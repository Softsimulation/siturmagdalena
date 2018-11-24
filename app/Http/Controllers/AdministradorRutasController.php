<?php

namespace App\Http\Controllers;

use App\Models\Atracciones;
use App\Models\Ruta;
use App\Models\Ruta_Con_Idioma;
use App\Models\Ruta_Con_Atraccion;
use App\Models\Idioma;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use File;

class AdministradorRutasController extends Controller
{
    //
    public function getCrear() {
        return view('administradorrutas.Crear');
    }
    
    public function getIndex(){
        return view('administradorrutas.Index');
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Ruta::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradorrutas.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Ruta::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradorrutas.Editar', ['id' => $id]);
    }
    
    public function getDatos(){
        $rutas = Ruta::with(['rutasConIdiomas' => function ($queryRutasConIdiomas){
            $queryRutasConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('idioma_id', 'ruta_id', 'nombre', 'descripcion')->orderBy('idioma_id');
        }])->select('id', 'estado', 'portada', 'sugerido')->orderBy('id')->get();
        
        $idiomas = Idioma::select('id', 'nombre', 'culture')->get();
        
        return ['rutas' => $rutas, 'idiomas' => $idiomas, 'success' => true];
    }
    
    public function getDatoscrear() {
        $atracciones = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre')->orderBy('idiomas_id');
            }])->select('id');
        }])->select('sitios_id', 'id')->get();
        
        return ['atracciones' => $atracciones, 'success' => true];
    }
    
    public function postCrearruta (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|min:100'
        ],[
            'nombre.required' => 'Se necesita un nombre para la ruta turística.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'descripcion.required' => 'Se necesita una descripción para la ruta turística.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $evento_con_idioma = Ruta_Con_Idioma::where('idioma_id', 1)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($evento_con_idioma != null){
            $errores["exists"][0] = "Esta ruta turística ya se encuentra registrada en el sistema.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $ruta = new Ruta();
        $ruta->estado = true;
        $ruta->user_create = "Situr";
        $ruta->user_update = "Situr";
        $ruta->created_at = Carbon::now();
        $ruta->updated_at = Carbon::now();
        $ruta->save();
        
        $ruta_con_idioma = new Ruta_Con_Idioma();
        $ruta_con_idioma->ruta_id = $ruta->id;
        $ruta_con_idioma->idioma_id = 1;
        $ruta_con_idioma->nombre = $request->nombre;
        $ruta_con_idioma->descripcion = $request->descripcion;
        $ruta_con_idioma->recomendacion = $request->recomendacion;
        $ruta_con_idioma->save();
        
        return ['success' => true, 'id' => $ruta->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'id' => 'required|exists:rutas|numeric'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            'portadaIMG.max' => 'La imagen de portada no puede superar los 2MB de peso.',
            
            'id.required' => 'Se necesita un identificador para la ruta turística.',
            'id.exists' => 'El identificador de la ruta no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la ruta debe ser un valor numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $ruta = Ruta::find($request->id);
        
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName(), PATHINFO_EXTENSION);
        
        Storage::disk('multimedia-ruta')->deleteDirectory('ruta-'.$request->id);
        Storage::disk('multimedia-ruta')->put('ruta-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        $ruta->portada = "/multimedia/rutas/ruta-".$request->id."/".$portadaNombre;
        $ruta->save();
        
        return ['success' => true];
    }
    
    public function postGuardaradicional (Request $request){
        $validator = \Validator::make($request->all(), [
            'atracciones' => 'array|required',
            'id' => 'required|exists:rutas|numeric'
        ],[
            'atracciones.required' => 'Debe especificar por lo menos una atracción para esta ruta turística.',
            'atracciones.array' => 'Error al ingresar los datos. Recargue la página.',
            
            'id.required' => 'Se necesita un identificador para la ruta turística.',
            'id.exists' => 'El identificador de la ruta no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la ruta debe ser un valor numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        Ruta_Con_Atraccion::where('ruta_id', $request->id)->delete();
        
        for ($i = 0; $i < count($request->atracciones); $i++){
            Ruta_Con_Atraccion::create([
                'atraccion_id' => $request->atracciones[$i], 
                'ruta_id' => $request->id, 
                'orden' => $i + 1]);
        }
        
        return ['success' => true];
        
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:rutas'
        ],[
            'id.required' => 'Se necesita el identificador de la ruta turística.',
            'id.numeric' => 'El identificador de la ruta debe ser un valor numérico.',
            'id.exists' => 'La ruta no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $ruta = Ruta::find($request->id);
        $ruta->estado = !$ruta->estado;
        $ruta->updated_at = Carbon::now();
        $ruta->user_update = "Situr";
        $ruta->save();
        
        return ['success' => true];
    }
    
    public function postSugerir (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:rutas'
        ],[
            'id.required' => 'Se necesita el identificador de la ruta turística.',
            'id.numeric' => 'El identificador de la ruta debe ser un valor numérico.',
            'id.exists' => 'La ruta no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $ruta = Ruta::find($request->id);
        $ruta->sugerido = !$ruta->sugerido;
        $ruta->updated_at = Carbon::now();
        $ruta->user_update = "Situr";
        $ruta->save();
        
        return ['success' => true];
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $ruta = Ruta::with(['rutasConIdiomas' => function ($queryRutasConIdiomas) use ($id, $idIdioma){
            $queryRutasConIdiomas->where('idioma_id', $idIdioma)->select('nombre', 'descripcion', 'recomendacion', 'idioma_id', 'ruta_id');
        }])->where('id', $id)->select('id')->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['ruta' => $ruta, 'success' => Ruta_Con_Idioma::where('ruta_id', $id)->where('idioma_id', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:rutas|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|min:100',
            'recomendacion' => 'max:1000|min:100'
        ],[
            'nombre.required' => 'Se necesita un nombre para la ruta turística.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador de la ruta turística.',
            'id.exists' => 'La ruta turística no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la ruta turística debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para la ruta turística.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'recomendacion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Recomendaciones".',
            'recomendacion.min' => 'Se debe ingresar mínimo 100 caracteres para las recomendaciones.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        
        if (Ruta_Con_Idioma::where('ruta_id', $request->id)->where('idioma_id', $request->idIdioma)->first() != null){
            Ruta_Con_Idioma::where('ruta_id', $request->id)->where('idioma_id', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'recomendacion' => $request->recomendacion]);
                
        }else{
            Ruta_Con_Idioma::create([
                'ruta_id' => $request->id,
                'idioma_id' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'recomendacion' => $request->recomendacion]);
        }
        
        return ['success' => true];
    }
    
    public function getDatosruta ($id){
        $ruta = Ruta::with(['rutasConIdiomas' => function ($queryRutasConIdiomas){
            $queryRutasConIdiomas->orderBy('idioma_id')->select('ruta_id', 'nombre');
        }])->select('id', 'portada')->where('id', $id)->first();
        
        $rutas_con_atracciones = Ruta_Con_Atraccion::where('ruta_id', $id)->pluck('atraccion_id');
        
        return ['ruta' => $ruta, 'rutas_con_atracciones' => $rutas_con_atracciones, 'success' => true];
    }
}
