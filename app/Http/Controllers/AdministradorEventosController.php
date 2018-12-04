<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Sector;
use App\Models\Perfil_Usuario;
use App\Models\Tipo_Evento;
use App\Models\Categoria_Turismo;
use App\Models\Sitio;
use App\Models\Evento;
use App\Models\Evento_Con_Idioma;
use App\Models\Multimedia_Evento;
use App\Models\Idioma;

use Carbon\Carbon;
use Storage;
use File;

class AdministradorEventosController extends Controller
{
    //
    public function getCrear(){
        return view('administradoreventos.Crear');
    }
    
    public function getIndex(){
        return view('administradoreventos.Index');
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Evento::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradoreventos.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Evento::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradoreventos.Editar', ['id' => $id]);
    }
    
    public function getDatos(){
        $eventos = Evento::with(['eventosConIdiomas' => function ($queryEventosConIdiomas){
            $queryEventosConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('eventos_id', 'idiomas_id', 'nombre', 'descripcion', 'edicion');
        }, 'multimediaEventos' => function ($queryMultimediaEventos){
            $queryMultimediaEventos->where('portada', true)->select('eventos_id', 'ruta');
        }])->select('id', 'estado', 'sugerido')->orderBy('id')->get();
        
        $idiomas = Idioma::select('id', 'nombre', 'culture')->get();
        
        return ['eventos' => $eventos, 'idiomas' => $idiomas, 'success' => true];
    }
    
    public function getDatoscrear (){
        $sitios = Sitio::with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
            $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre')->orderBy('idiomas_id');
        }])->select('id')->get();
        
        $perfiles_turista = Perfil_Usuario::with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdioma){
           $queryPerfilesUsuariosConIdioma->with(['idioma' => function ($queryIdioma){
               $queryIdioma->select('id', 'nombre', 'culture');
           }])->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
        }])->select('id')->where('estado', true)->get();
        
        $tipos_evento = Tipo_Evento::with(['tipoEventosConIdiomas' => function ($queryTipoEventosConIdiomas){
            $queryTipoEventosConIdiomas->select('idiomas_id', 'tipo_evento_id', 'nombre')->orderBy('idiomas_id');
        }])->select('id')->get();
        
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
            'categorias_turismo' => $categorias_turismo,
            'tipos_evento' => $tipos_evento];
    }
    
    public function postCrearevento(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|min:100',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric',
            'tipo_evento' => 'required|numeric|exists:tipo_eventos,id',
            'edicion' => 'max:50',
            'horario' => 'max:255',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255|url',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date'
        ],[
            'nombre.required' => 'Se necesita un nombre para el evento.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'descripcion.required' => 'Se necesita una descripción para el evento.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para el evento.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para el evento.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            
            'tipo_evento.required' => 'Se necesita un identificador para el tipo de evento.',
            'tipo_evento.numeric' => 'El identificador del tipo de evento, debe ser numérico.',
            'tipo_evento.exists' => 'El identificador del tipo de evento no se encuentra registrado en la base de datos.',
            
            'edicion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Edición".',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            'pagina_web.url' => 'La página web del evento debe tener la estructura de un enlace externo.',
            
            'fecha_inicio.required' => 'Se necesita una fecha de inicio para el evento.',
            'fecha_inicio.date' => 'No se ha pasado un formato de fecha válido para la fecha de inicio.',
            
            'fecha_final.required' => 'Se necesita una fecha de finalización para el evento.',
            'fecha_final.date' => 'No se ha pasado un formato de fecha válido para la fecha de finalización.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $evento_con_idioma = Evento_Con_Idioma::where('idiomas_id', 1)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($evento_con_idioma != null){
            $errores["exists"][0] = "Este evento ya se encuentra registrado en el sistema.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $evento = new Evento();
        $evento->tipo_eventos_id = $request->tipo_evento;
        $evento->telefono = $request->telefono;
        $evento->web = $request->pagina_web;
        $evento->fecha_in = $request->fecha_inicio;
        $evento->fecha_fin = $request->fecha_final;
        $evento->valor_min = $request->valor_minimo;
        $evento->valor_max = $request->valor_maximo;
        $evento->estado = true;
        $evento->created_at = Carbon::now();
        $evento->updated_at = Carbon::now();
        $evento->user_create = "Situr";
        $evento->user_update = "Situr";
        $evento->save();
        
        $evento_con_idioma = new Evento_Con_Idioma();
        $evento_con_idioma->idiomas_id = 1;
        $evento_con_idioma->eventos_id = $evento->id;
        $evento_con_idioma->nombre = $request->nombre;
        $evento_con_idioma->descripcion = $request->descripcion;
        $evento_con_idioma->horario = $request->horario;
        $evento_con_idioma->edicion = $request->edicion;
        $evento_con_idioma->save();
        
        return ['success' => true, 'id' => $evento->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'portadaIMGText' => 'required',
            'id' => 'required|exists:eventos|numeric',
            'image' => 'array|max:20',
            'imageText' => 'array|max:20',
            'video_promocional' => 'url',
            'image.*' => 'max:2097152',
            'imageText.*' => 'required'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            
            'portadaIMGText.required' => 'Se necesita el texto de la imagen de portada.',
            
            'id.required' => 'Se necesita un identificador para el evento.',
            'id.exists' => 'El identificador del evento no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador del evento debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 20 imágenes para el evento.',
            
            'imageText.array' => 'Error al enviar los datos. Recargue la página.',
            'imageText.max' => 'Máximo se pueden subir 20 imágenes para el evento.',
            
            'video_promocional.url' => 'El video promocional debe tener la estructura de enlace.',
            
            'image.*.max' => 'El peso máximo por imagen es de 2MB. Por favor verifique si se cumple esta condición.',
            
            'imageText.*.required' => 'Una de las imágenes que se quiere subir no tiene texto alternativo.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        Multimedia_Evento::where('eventos_id', $request->id)->where('portada', true)->delete();
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName(), PATHINFO_EXTENSION);
        if (Storage::disk('multimedia-evento')->exists('/evento-'.$request->id.'/'.$portadaNombre)){
            Storage::disk('multimedia-evento')->deleteDirectory('evento-'.$request->id);
        }
        
        $multimedia_evento = new Multimedia_Evento();
        $multimedia_evento->eventos_id = $request->id;
        $multimedia_evento->ruta = "/multimedia/eventos/evento-".$request->id."/".$portadaNombre;
        $multimedia_evento->texto_alternativo = $request->portadaIMGText;
        $multimedia_evento->tipo = false;
        $multimedia_evento->portada = true;
        $multimedia_evento->estado = true;
        $multimedia_evento->user_create = "Situr";
        $multimedia_evento->user_update = "Situr";
        $multimedia_evento->created_at = Carbon::now();
        $multimedia_evento->updated_at = Carbon::now();
        $multimedia_evento->save();
        
        Storage::disk('multimedia-evento')->put('evento-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        if ($request->video_promocional != null){
            Multimedia_Evento::where('eventos_id', $request->id)->where('tipo', true)->delete();
            $multimedia_evento = new Multimedia_Evento();
            $multimedia_evento->eventos_id = $request->id;
            $multimedia_evento->ruta = $request->video_promocional;
            $multimedia_evento->tipo = true;
            $multimedia_evento->portada = false;
            $multimedia_evento->estado = true;
            $multimedia_evento->user_create = "Situr";
            $multimedia_evento->user_update = "Situr";
            $multimedia_evento->created_at = Carbon::now();
            $multimedia_evento->updated_at = Carbon::now();
            $multimedia_evento->save();
        }
        
        Multimedia_Evento::where('eventos_id', $request->id)->where('tipo', false)->where('portada', false)->delete();
        for ($i = 0; $i < 5; $i++){
            $nombre = "imagen-".$i.".*";
            if (Storage::disk('multimedia-evento')->exists('evento-'.$request->id.'/'.$nombre)){
                Storage::disk('multimedia-evento')->delete('evento-'.$request->id.'/'.$nombre);
            }
        }
        
        if ($request->image != null){
            foreach($request->image as $key => $file){
                if (!is_string($file)){
                    $nombre = "imagen-".$key.".".pathinfo($file->getClientOriginalName())['extension'];
                    $multimedia_evento = new Multimedia_Evento();
                    $multimedia_evento->eventos_id = $request->id;
                    $multimedia_evento->ruta = "/multimedia/eventos/evento-".$request->id."/".$nombre;
                    $multimedia_evento->texto_alternativo = $request->imageText[$key];
                    $multimedia_evento->tipo = false;
                    $multimedia_evento->portada = false;
                    $multimedia_evento->estado = true;
                    $multimedia_evento->user_create = "Situr";
                    $multimedia_evento->user_update = "Situr";
                    $multimedia_evento->created_at = Carbon::now();
                    $multimedia_evento->updated_at = Carbon::now();
                    $multimedia_evento->save();
                    
                    Storage::disk('multimedia-evento')->put('evento-'.$request->id.'/'.$nombre, File::get($file));
                }
            }
        }
        
        return ['success' => true];
    }
    
    public function postGuardaradicional (Request $request){
        $validator = \Validator::make($request->all(), [
            'perfiles' => 'required|array',
            'sitios' => 'required|array',
            'categorias' => 'required|array',
            'id' => 'required|exists:eventos'
        ],[
            'perfiles.required' => 'Se necesitan los perfiles del turista para este evento.',
            'perfiles.array' => 'Error al enviar los datos. Recargue la página.',
            
            'sitios.required' => 'Se necesitan los sitios del evento.',
            'sitios.array' => 'Error al enviar los datos. Recargue la página.',
            
            'categorias.required' => 'Se necesitan las categorías de turismo para el evento.',
            'categorias.max' => 'Error al enviar los datos. Recargue la página.',
            
            'id.required' => 'Se necesita el identificador del evento.',
            'id.exists' => 'El identificador del evento no se encuentra registrado en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $evento = Evento::find($request->id);
        $evento->categoriaTurismoConEventos()->detach();
        $evento->categoriaTurismoConEventos()->attach($request->categorias);
        $evento->perfilesUsuariosConEventos()->detach();
        $evento->perfilesUsuariosConEventos()->attach($request->perfiles);
        $evento->sitiosConEventos()->detach();
        $evento->sitiosConEventos()->attach($request->sitios);
        
        $evento->user_update = "Situr";
        $evento->updated_at = Carbon::now();
        $evento->save();
        
        return ["success" => true];
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:eventos'
        ],[
            'id.required' => 'Se necesita el identificador del evento.',
            'id.numeric' => 'El identificador del evento debe ser un valor numérico.',
            'id.exists' => 'El evento no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $evento = Evento::find($request->id);
        $evento->estado = !$evento->estado;
        $evento->updated_at = Carbon::now();
        $evento->user_update = "Situr";
        $evento->save();
        
        return ['success' => true];
    }
    
    public function postSugerir (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:eventos'
        ],[
            'id.required' => 'Se necesita el identificador del evento.',
            'id.numeric' => 'El identificador del evento debe ser un valor numérico.',
            'id.exists' => 'El evento no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $evento = Evento::find($request->id);
        $evento->sugerido = !$evento->sugerido;
        $evento->updated_at = Carbon::now();
        $evento->user_update = "Situr";
        $evento->save();
        
        return ['success' => true];
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $evento = Evento::with(['eventosConIdiomas' => function ($queryEventosConIdiomas) use ($id, $idIdioma){
            $queryEventosConIdiomas->where('idiomas_id', $idIdioma)->select('nombre', 'descripcion', 'edicion', 'horario', 'eventos_id', 'idiomas_id');
        }])->where('id', $id)->select('id')->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['evento' => $evento, 'success' => Evento_Con_Idioma::where('eventos_id', $id)->where('idiomas_id', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:eventos|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|min:100',
            'horario' => 'max:255',
            'edicion' => 'max:50'
        ],[
            'nombre.required' => 'Se necesita un nombre para el evento.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador del evento.',
            'id.exists' => 'El evento no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador del evento debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para el evento.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'edicion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Edición".'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        
        if (Evento_Con_Idioma::where('eventos_id', $request->id)->where('idiomas_id', $request->idIdioma)->first() != null){
            Evento_Con_Idioma::where('eventos_id', $request->id)->where('idiomas_id', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'horario' => $request->horario,
                'edicion' => $request->edicion]);
                
        }else{
            Evento_Con_Idioma::create([
                'eventos_id' => $request->id,
                'idiomas_id' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'horario' => $request->horario,
                'edicion' => $request->edicion]);
        }
        
        return ['success' => true];
    }
    
    public function getDatosevento ($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Evento::find($id) == null){
            return response('Not found.', 404);
        }
        
        $evento = Evento::with(['eventosConIdiomas' => function ($queryEventosConIdiomas){
            $queryEventosConIdiomas->select('eventos_id', 'nombre');
        }])->where('id', $id)->select('telefono', 'web', 'fecha_in', 'fecha_fin', 'valor_min', 'valor_max', 'id', 'tipo_eventos_id')->first();
        
        $perfiles_turista = Evento::find($id)->perfilesUsuariosConEventos()->pluck('perfiles_usuarios_id')->toArray();
        $sitios = Evento::find($id)->sitiosConEventos()->pluck('sitios_id')->toArray();
        $categorias_turismo = Evento::find($id)->categoriaTurismoConEventos()->pluck('categoria_turismo_id')->toArray();
        
        $portadaIMG = Multimedia_Evento::where('portada', true)->where('eventos_id', $id)->select('ruta', 'texto_alternativo')->first();
        $imagenes = Multimedia_Evento::where('portada', false)->where('tipo', false)->where('eventos_id', $id)->select('ruta', 'texto_alternativo')->get();
        $video = Multimedia_Evento::where('portada', false)->where('tipo', true)->where('eventos_id', $id)->pluck('ruta')->first();
        
        return ['evento' => $evento,
            'success' => true,
            'perfiles_turista' => $perfiles_turista,
            'sitios' => $sitios,
            'categorias_turismo' => $categorias_turismo,
            'portadaIMG' => $portadaIMG,
            'imagenes' => $imagenes,
            'video_promocional' => $video];
    }
    
    public function postEditarevento (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:eventos|numeric',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric',
            'tipo_evento' => 'required|numeric|exists:sectores,id',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255|url',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date'
        ],[
            'id.required' => 'Se necesita el identificador del evento.',
            'id.exists' => 'El evento que planea modificar no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador del evento debe ser un valor numérico.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para el evento.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para el evento.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            
            'tipo_evento.required' => 'Se necesita un identificador para el tipo de evento.',
            'tipo_evento.numeric' => 'El identificador del tipo de evento, debe ser numérico.',
            'tipo_evento.exists' => 'El identificador del tipo de evento no se encuentra registrado en la base de datos.',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            'pagina_web.url' => 'La página web del evento debe tener la estructura de un enlace.',
            
            'fecha_inicio.required' => 'Se necesita una fecha de inicio para el evento.',
            'fecha_inicio.date' => 'No se ha pasado un formato de fecha válido para la fecha de inicio.',
            
            'fecha_final.required' => 'Se necesita una fecha de finalización para el evento.',
            'fecha_final.date' => 'No se ha pasado un formato de fecha válido para la fecha de finalización.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $evento = Evento::find($request->id);
        $evento->tipo_eventos_id = $request->tipo_evento;
        $evento->valor_max = $request->valor_maximo;
        $evento->valor_min = $request->valor_minimo;
        $evento->telefono = $request->telefono;
        $evento->web = $request->pagina_web;
        $evento->fecha_in = $request->fecha_inicio;
        $evento->fecha_fin = $request->fecha_final;
        $evento->user_update = "Situr";
        $evento->updated_at = Carbon::now();
        $evento->save();
        
        return ['success' => true, 'dato' => $evento];
    }
}
