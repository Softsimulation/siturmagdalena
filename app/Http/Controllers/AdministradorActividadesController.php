<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Storage;
use File;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

use App\Models\Sitio;
use App\Models\Perfil_Usuario;
use App\Models\Categoria_Turismo;
use App\Models\Actividad_Con_Idioma;
use App\Models\Actividad;
use App\Models\Multimedia_Actividad;
use App\Models\Idioma;

use Carbon\Carbon;

class AdministradorActividadesController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        //$this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }/*
        $this->middleware('permissions:list-actividad',['only' => ['getIndex','getDatos'] ]);
        $this->middleware('permissions:create-actividad',['only' => ['getCrear','getDatoscrear','getIdioma','getDatoscrearnoticias','postGuardarnoticia',
        'postGuardarmultimedianoticia','postGuardartextoalternativo','postEliminarmultimedia'] ]);
        $this->middleware('permissions:read-actividad',['only' => ['getVernoticia','getDatosver','getListadonoticias','getNoticias'] ]);
        $this->middleware('permissions:edit-actividad',['only' => ['getListadonoticias','getNoticias','getNuevoidioma','postGuardarnoticia','postGuardarmultimedianoticia',
        'postGuardartextoalternativo','postEliminarmultimedia','getVistaeditar','getDatoseditar','postModificarnoticia' ] ]);
        $this->middleware('permissions:estado-actividad',['only' => ['getListadonoticias','getNoticias','postCambiarestado'] ]);*/
    }
    public function getIndex(){
        return view('administradoractividades.Index');
    }
    
    public function getCrear(){
        return view('administradoractividades.Crear');
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradoractividades.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getDatosactividad($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        $actividad = Actividad::with(['actividadesConIdiomas' => function($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->select('actividades_id', 'idiomas', 'nombre', 'descripcion')->orderBy('idiomas');
        }])->where('id', $id)->select('id', 'valor_min', 'valor_max')->first();
        
        $perfiles_turista = Actividad::find($id)->perfilesUsuariosConActividades()->pluck('perfiles_usuarios_id')->toArray();
        $sitios = Actividad::find($id)->sitiosConActividades()->pluck('sitios_id')->toArray();
        $categorias_turismo = Actividad::find($id)->categoriaTurismoConActividades()->pluck('categoria_turismo_id')->toArray();
        
        $portadaIMG = Multimedia_Actividad::where('portada', true)->where('actividades_id', $id)->pluck('ruta')->first();
        $imagenes = Multimedia_Actividad::where('portada', false)->where('tipo', false)->where('actividades_id', $id)->pluck('ruta')->toArray();
        
        return ['actividad' => $actividad,
            'success' => true,
            'perfiles_turista' => $perfiles_turista,
            'sitios' => $sitios,
            'categorias_turismo' => $categorias_turismo,
            'portadaIMG' => $portadaIMG,
            'imagenes' => $imagenes];
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradoractividades.Editar', ['id' => $id]);
    }
    
    public function getDatoscrear(){
        $sitios = Sitio::with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
            $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre');
        }])->select('id')->get();
        
        $perfiles_turista = Perfil_Usuario::with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdioma){
           $queryPerfilesUsuariosConIdioma->with(['idioma' => function ($queryIdioma){
               $queryIdioma->select('id', 'nombre', 'culture');
           }])->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
        }])->select('id')->where('estado', true)->get();
        
        $categorias_turismo = Categoria_Turismo::with([
            'categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->with(['idioma' => function ($queryIdioma){
                    $queryIdioma->select('id', 'nombre', 'culture');
                }])->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }, 
            'tipoTurismo' => function($queryTipoTurismo){
                $queryTipoTurismo->with(['tipoTurismoConIdiomas' => function($queryTipoTurismoConIdiomas){
                    $queryTipoTurismoConIdiomas->with(['idioma' => function ($queryIdioma){
                        $queryIdioma->select('id', 'nombre', 'culture');
                    }])->select('idiomas_id', 'tipo_turismo_id', 'nombre');
                }])->select('id');
            }
            ])->select('tipo_turismo_id', 'id')->where('estado', true)->get();
            
        return ['success' => true, 
            'sitios' => $sitios, 
            'perfiles_turista' => $perfiles_turista, 
            'categorias_turismo' => $categorias_turismo];
    }
    
    public function getDatos (){
        $actividades = Actividad::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->orderBy('idiomas')->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }, 'multimediasActividades' => function ($queryMultimediasActividades){
            $queryMultimediasActividades->where('portada', true)->select('actividades_id', 'ruta');
        }])->orderBy('id')->select('id', 'estado', 'sugerido')->get();
        
        $idiomas = Idioma::select('id', 'nombre', 'culture')->get();
        
        return ['actividades' => $actividades, 'success' => true, 'idiomas' => $idiomas];
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $actividad = Actividad::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas) use ($id, $idIdioma){
            $queryActividadesConIdiomas->where('idiomas', $idIdioma)->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }])->where('id', $id)->select('id')->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['actividad' => $actividad, 'success' => Actividad_Con_Idioma::where('actividades_id', $id)->where('idiomas', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function postCrearactividad(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:1000|min:100',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric'
        ],[
            'nombre.required' => 'Se necesita un nombre para la actividad.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'descripcion.required' => 'Se necesita una descripción para la actividad.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para la actividad.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para la actividad.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $actividad_con_idioma = Actividad_Con_Idioma::where('idiomas', 1)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($actividad_con_idioma != null){
            $errores["exists"][0] = "Esta actividad ya se encuentra registrada en el sistema.";
        }
        if ($request->valor_maximo < $request->valor_minimo){
            $errores["gt"][0] = 'El campo "Valor máximo" debe ser mayor a "Valor mínimo".';
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $actividad = new Actividad();
        $actividad->valor_min = $request->valor_minimo;
        $actividad->valor_max = $request->valor_maximo;
        $actividad->estado = true;
        $actividad->user_create = "Situr";
        $actividad->user_update = "Situr";
        $actividad->created_at = Carbon::now();
        $actividad->updated_at = Carbon::now();
        $actividad->save();
        
        $actividad_con_idioma = new Actividad_Con_Idioma();
        $actividad_con_idioma->actividades_id = $actividad->id;
        $actividad_con_idioma->idiomas = 1;
        $actividad_con_idioma->nombre = $request->nombre;
        $actividad_con_idioma->descripcion = $request->descripcion;
        $actividad_con_idioma->save();
        
        return ['success' => true, 'id' => $actividad->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'id' => 'required|exists:actividades|numeric',
            'image' => 'array|max:5'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            'portadaIMG.max' => 'La imagen de portada debe pesar menos de 2MB',
            
            'id.required' => 'Se necesita un identificador para la actividad.',
            'id.exists' => 'El identificador de la actividad no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 5 imágenes para la actividad.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        Multimedia_Actividad::where('actividades_id', $actividad->id)->where('portada', true)->delete();
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName())['extension'];
        if (Storage::disk('multimedia-actividad')->exists('actividad-'.$request->id.'/'.$portadaNombre)){
            Storage::disk('multimedia-actividad')->deleteDirectory('actividad-'.$request->id);
        }
        
        $multimedia_actividad = new Multimedia_Actividad();
        $multimedia_actividad->actividades_id = $actividad->id;
        $multimedia_actividad->ruta = "/multimedia/actividades/actividad-".$request->id."/".$portadaNombre;
        $multimedia_actividad->tipo = false;
        $multimedia_actividad->portada = true;
        $multimedia_actividad->estado = true;
        $multimedia_actividad->user_create = "Situr";
        $multimedia_actividad->user_update = "Situr";
        $multimedia_actividad->created_at = Carbon::now();
        $multimedia_actividad->updated_at = Carbon::now();
        $multimedia_actividad->save();
        
        Storage::disk('multimedia-actividad')->put('actividad-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        Multimedia_Actividad::where('actividades_id', $actividad->id)->where('tipo', false)->where('portada', false)->delete();
        for ($i = 0; $i < 5; $i++){
            $nombre = "imagen-".$i.".*";
            if (Storage::disk('multimedia-actividad')->exists('actividad-'.$request->id.'/'.$nombre)){
                Storage::disk('multimedia-actividad')->delete('actividad-'.$request->id.'/'.$nombre);
            }
        }
        //return ['success' => $request->image];
        if ($request->image != null){
            foreach($request->image as $key => $file){
                $nombre = "imagen-".$key.".".pathinfo($file->getClientOriginalName())['extension'];
                $multimedia_actividad = new Multimedia_Actividad();
                $multimedia_actividad->actividades_id = $actividad->id;
                $multimedia_actividad->ruta = "/multimedia/actividades/actividad-".$request->id."/".$nombre;
                $multimedia_actividad->tipo = false;
                $multimedia_actividad->portada = false;
                $multimedia_actividad->estado = true;
                $multimedia_actividad->user_create = "Situr";
                $multimedia_actividad->user_update = "Situr";
                $multimedia_actividad->created_at = Carbon::now();
                $multimedia_actividad->updated_at = Carbon::now();
                $multimedia_actividad->save();
                
                Storage::disk('multimedia-actividad')->put('actividad-'.$request->id.'/'.$nombre, File::get($file));
            }
        }
        
        return ['success' => true];
    }
    
    public function postGuardaradicional (Request $request){
        $validator = \Validator::make($request->all(), [
            'perfiles' => 'required|array',
            'sitios' => 'required|array',
            'categorias' => 'required|array',
            'id' => 'required|exists:actividades'
        ],[
            'perfiles.required' => 'Se necesitan los perfiles del turista para esta actividad.',
            'perfiles.array' => 'Error al enviar los datos. Recargue la página.',
            
            'sitios.required' => 'Se necesitan los sitios adjuntos a esta actividad.',
            'sitios.array' => 'Error al enviar los datos. Recargue la página.',
            
            'categorias.required' => 'Se necesitan las categorías de turismo de esta actividad.',
            'categorias.max' => 'Error al enviar los datos. Recargue la página.',
            
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.exists' => 'El identificador de la actividad no se encuentra registrado en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        $actividad->sitiosConActividades()->detach();
        $actividad->sitiosConActividades()->attach($request->sitios);
        $actividad->categoriaTurismoConActividades()->detach();
        $actividad->categoriaTurismoConActividades()->attach($request->categorias);
        $actividad->perfilesUsuariosConActividades()->detach();
        $actividad->perfilesUsuariosConActividades()->attach($request->perfiles);
        
        return ["success" => true];
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:actividades'
        ],[
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            'id.exists' => 'La actividad no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        $actividad->estado = !$actividad->estado;
        $actividad->save();
        
        return ['success' => true];
    }
    
    public function postSugerir (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:actividades'
        ],[
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            'id.exists' => 'La actividad no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        $actividad->sugerido = !$actividad->sugerido;
        $actividad->save();
        
        return ['success' => true];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:actividades|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|max:1000|min:100'
        ],[
            'nombre.required' => 'Se necesita un nombre para la actividad.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.exists' => 'La actividad no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para la actividad.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        
        if (Actividad_Con_Idioma::where('actividades_id', $request->id)->where('idiomas', $request->idIdioma)->first() != null){
            
            Actividad_Con_Idioma::where('actividades_id', $request->id)->where('idiomas', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }else{
            Actividad_Con_Idioma::create([
                'actividades_id' => $request->id,
                'idiomas' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }
        
        $actividad = Actividad::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas) use ($request){
            $queryActividadesConIdiomas->where('idiomas', $request->idIdioma)->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }])->where('id', $request->id)->select('id')->first();
        
        return ['success' => true, 'actividad' => $actividad];
    }
    
    public function postEditardatosgenerales (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:actividades|numeric',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric'
        ],[
            'id.required' => 'Se necesita el identificador de la actividad.',
            'id.exists' => 'La actividad que planea modificar no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la actividad debe ser un valor numérico.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para la actividad.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para la actividad.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $actividad = Actividad::find($request->id);
        $actividad->valor_max = $request->valor_maximo;
        $actividad->valor_min = $request->valor_minimo;
        $actividad->save();
        
        return ['success' => true];
    }
}
