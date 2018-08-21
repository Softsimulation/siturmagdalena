<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use File;

use App\Models\Tipo_Destino;
use App\Models\Destino;
use App\Models\Destino_Con_Idioma;
use App\Models\Multimedia_Destino;
use App\Models\Idioma;

class AdministradorDestinosController extends Controller
{
    //
    public function getIndex (){
        return view('administradordestinos.Index');
    }
    
    public function getCrear (){
        return view('administradordestinos.Crear');
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradordestinos.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradordestinos.Editar', ['id' => $id]);
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $destino = Destino::with(['destinoConIdiomas' => function ($queryDestinoConIdiomass) use ($id, $idIdioma){
            $queryDestinoConIdiomass->where('idiomas_id', $idIdioma)->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
        }])->where('id', $id)->select('id')->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['destino' => $destino, 'success' => Destino_Con_Idioma::where('destino_id', $id)->where('idiomas_id', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function getDatos (){
        $destinos = Destino::with(['destinoConIdiomas' => function ($queryDestinoConIdiomas){
            $queryDestinoConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('destino_id', 'idiomas_id', 'nombre', 'descripcion')->orderBy('idiomas_id');
        }, 'multimediaDestinos' => function ($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('portada', true)->select('destino_id', 'ruta');
        }])->select('id', 'estado')->orderBy('id')->get();
        
        $idiomas = Idioma::select('id', 'nombre', 'culture')->where('estado', true)->get();
        
        return ['success' => true, 'destinos' => $destinos, 'idiomas' => $idiomas];
    }
    
    public function getDatoscrear() {
        $tipos_sitio = Tipo_Destino::with(['tipoDestinoConIdiomas' => function ($queryTipoDestinoConIdiomas){
            $queryTipoDestinoConIdiomas->select('idiomas_id', 'tipo_destino_id', 'nombre');
        }])->select('id')->get();
        
        return ['success' => true, 'tipos_sitio' => $tipos_sitio];
    }
    
    public function getDatosdestino($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        $destino = Destino::with(['destinoConIdiomas' => function($queryDestinoConIdiomas){
            $queryDestinoConIdiomas->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
        }])->where('id', $id)->select('id', 'tipo_destino_id', 'latitud', 'longitud')->first();
        
        $portadaIMG = Multimedia_Destino::where('portada', true)->where('destino_id', $id)->pluck('ruta')->first();
        $imagenes = Multimedia_Destino::where('portada', false)->where('tipo', false)->where('destino_id', $id)->pluck('ruta')->toArray();
        $video = Multimedia_Destino::where('tipo', true)->where('destino_id', $id)->pluck('ruta')->first();
        
        return ['destino' => $destino,
            'success' => true,
            'portadaIMG' => $portadaIMG,
            'imagenes' => $imagenes,
            'video' => $video];
    }
    
    public function postCreardestino(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:1000|min:100',
            'tipo' => 'required|numeric|exists:tipo_destino,id',
            'pos' => 'required'
        ],[
            'nombre.required' => 'Se necesita un nombre para el destino.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'descripcion.required' => 'Se necesita una descripción para el destino.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'tipo.required' => 'Se requiere ingresar un tipo de destino.',
            'tipo.numeric' => '"Tipo de destino" debe tener un valor numérico.',
            'tipo.exists' => 'El tipo de destino no se encuentra registrado en la base de datos del sistema.',
            
            'pos.required' => 'Agregue un marcador en el mapa de Google.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $destino = new Destino();
        $destino->tipo_destino_id = $request->tipo;
        $destino->estado = true;
        $destino->user_create = "Situr";
        $destino->user_update = "Situr";
        $destino->latitud = $request->pos['lat'];
        $destino->longitud = $request->pos['lng'];
        $destino->created_at = Carbon::now();
        $destino->updated_at = Carbon::now();
        $destino->save();
        
        $destino_con_idioma = new Destino_Con_Idioma();
        $destino_con_idioma->destino_id = $destino->id;
        $destino_con_idioma->idiomas_id = 1;
        $destino_con_idioma->nombre = $request->nombre;
        $destino_con_idioma->descripcion = $request->descripcion;
        $destino_con_idioma->save();
        
        return ['success' => true, 'id' => $destino->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'id' => 'required|exists:destino|numeric',
            'image' => 'array|max:5',
            'video' => 'url'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            'portadaIMG.max' => 'La portada debe tener máximo 2MB',
            
            'id.required' => 'Se necesita un identificador para el destino.',
            'id.exists' => 'El identificador del destino no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador del destino debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 5 imágenes para el destino.',
            
            'video.url' => 'El video debe tener la estructura de un enlace.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName())['extension'];
        if (Storage::disk('multimedia-destino')->exists('destino-'.$request->id.'/'.$portadaNombre)){
            Multimedia_Destino::where('destino_id', $request->id)->where('portada', true)->delete();
            Storage::disk('multimedia-destino')->deleteDirectory('destino-'.$request->id);
        }
        
        $multimedia_destino = new Multimedia_Destino();
        $multimedia_destino->destino_id = $request->id;
        $multimedia_destino->ruta = "/multimedia/destinos/destino-".$request->id."/".$portadaNombre;
        $multimedia_destino->tipo = false;
        $multimedia_destino->portada = true;
        $multimedia_destino->estado = true;
        $multimedia_destino->user_create = "Situr";
        $multimedia_destino->user_update = "Situr";
        $multimedia_destino->created_at = Carbon::now();
        $multimedia_destino->updated_at = Carbon::now();
        $multimedia_destino->save();
        
        Storage::disk('multimedia-destino')->put('destino-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        Multimedia_Destino::where('destino_id', $request->id)->where('tipo', false)->where('portada', false)->delete();
        
        if ($request->video != null){
            Multimedia_Destino::where('destino_id', $request->id)->where('tipo', true)->delete();
            $multimedia_sitio = new Multimedia_Destino();
            $multimedia_sitio->destino_id = $request->id;
            $multimedia_sitio->ruta = $request->video;
            $multimedia_sitio->tipo = true;
            $multimedia_sitio->portada = false;
            $multimedia_sitio->estado = true;
            $multimedia_sitio->user_create = "Situr";
            $multimedia_sitio->user_update = "Situr";
            $multimedia_sitio->created_at = Carbon::now();
            $multimedia_sitio->updated_at = Carbon::now();
            $multimedia_sitio->save();
        }
        
        for ($i = 0; $i < 5; $i++){
            $nombre = "imagen-".$i.".*";
            if (Storage::disk('multimedia-destino')->exists('destino-'.$request->id.'/'.$nombre)){
                Storage::disk('multimedia-destino')->delete('destino-'.$request->id.'/'.$nombre);
            }
        }
        
        if ($request->image != null){
            foreach($request->image as $key => $file){
                $nombre = "imagen-".$key.".".pathinfo($file->getClientOriginalName())['extension'];
                $multimedia_sitio = new Multimedia_Destino();
                $multimedia_sitio->destino_id = $request->id;
                $multimedia_sitio->ruta = "/multimedia/destinos/destino-".$request->id."/".$nombre;
                $multimedia_sitio->tipo = false;
                $multimedia_sitio->portada = false;
                $multimedia_sitio->estado = true;
                $multimedia_sitio->user_create = "Situr";
                $multimedia_sitio->user_update = "Situr";
                $multimedia_sitio->created_at = Carbon::now();
                $multimedia_sitio->updated_at = Carbon::now();
                $multimedia_sitio->save();
                
                Storage::disk('multimedia-destino')->put('destino-'.$request->id.'/'.$nombre, File::get($file));
            }
        }
        
        return ['success' => true];
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:destino'
        ],[
            'id.required' => 'Se necesita el identificador del destino.',
            'id.numeric' => 'El identificador del destino debe ser un valor numérico.',
            'id.exists' => 'El destino no se encuentra registrado en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $destino = Destino::find($request->id);
        $destino->estado = !$destino->estado;
        $destino->save();
        
        return ['success' => true];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:destino|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|max:1000|min:100'
        ],[
            'nombre.required' => 'Se necesita un nombre para el destino.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador del destino.',
            'id.exists' => 'El destino no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para el destino.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        
        if (Destino_Con_Idioma::where('destino_id', $request->id)->where('idiomas_id', $request->idIdioma)->first() != null){
            
            Destino_Con_Idioma::where('destino_id', $request->id)->where('idiomas_id', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }else{
            Destino_Con_Idioma::create([
                'destino_id' => $request->id,
                'idiomas_id' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }
        
        $destino = Destino::with(['destinoConIdiomas' => function ($queryDestinoConIdiomas) use ($request){
            $queryDestinoConIdiomas->where('idiomas_id', $request->idIdioma)->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
        }])->where('id', $request->id)->select('id')->first();
        
        return ['success' => true, 'destino' => $destino];
    }
    
    public function postEditardatosgenerales (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:actividades|numeric',
            'tipo' => 'required|numeric|exists:tipo_destino,id',
            'pos' => 'required'
        ],[
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.exists' => 'La actividad que planea modificar no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            
            'tipo.required' => 'Se necesita un tipo de destino.',
            'tipo.numeric' => '"Tipo de destino" debe tener un valor numérico.',
            'tipo.exists' => 'El tipo de destino no se encuentra registrado en la base de datos.',
            
            'pos.required' => 'Se requiere la posición del destino.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $destino = Destino::find($request->id);
        $destino->tipo_destino_id = $request->tipo;
        $destino->latitud = $request->pos['lat'];
        $destino->longitud = $request->pos['lng'];
        $destino->save();
        
        return ['success' => true];
    }
}
