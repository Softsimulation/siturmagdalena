<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Storage;
use File;
use App\Models\Atracciones;
use App\Models\Idioma;
use App\Models\Tipo_Atraccion;
use App\Models\Destino;
use App\Models\Sector;
use App\Models\Perfil_Usuario;
use App\Models\Categoria_Turismo;
use App\Models\Actividades;
use App\Models\Sitio;
use App\Models\Sitio_Con_Idioma;
use App\Models\Atraccion_Con_Idioma;
use App\Models\Multimedia_Sitio;

class AdministradorAtraccionController extends Controller
{
    
    public function getIndex(){
        return view('administradoratracciones.Index');
    }
    
    public function getCrear(){
        return view('administradoratracciones.Crear');
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Atracciones::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradoratracciones.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getDatosatraccion($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Atracciones::find($id) == null){
            return response('Not found.', 404);
        }
        $atraccion = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion')->orderBy('idiomas_id');
            }, 'tipoSitio' => function ($queryTipoSitio){
                $queryTipoSitio->with(['tipoSitiosConIdiomas' => function ($queryTipoSitiosConIdiomas){
                    $queryTipoSitiosConIdiomas->select('idiomas_id', 'tipo_sitios_id', 'nombe', 'descripcion');
                }])->select('id');
            }])->select('tipo_sitios_id', 'latitud', 'longitud', 'id', 'sectores_id', 'direccion');
        }, 'atraccionesConIdiomas' => function($queryAtraccionesConIdiomas){
            $queryAtraccionesConIdiomas->select('atracciones_id', 'idiomas_id', 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }])->where('id', $id)->select('id' ,'sitios_id', 'telefono', 'sitio_web', 'valor_min', 'valor_max')->first();
        
        $perfiles_turista = Atracciones::find($id)->perfilesUsuariosConAtracciones()->pluck('perfiles_usuarios_id')->toArray();
        $tipo_atracciones = Atracciones::find($id)->atraccionesConTipos()->pluck('tipo_atracciones_id')->toArray();
        $categorias_turismo = Atracciones::find($id)->categoriaTurismoConAtracciones()->pluck('categoria_turismo_id')->toArray();
        $actividades = Sitio::find($atraccion->sitios_id)->sitiosConActividades()->pluck('actividades_id')->toArray();
        
        $portadaIMG = Multimedia_Sitio::where('portada', true)->where('sitios_id', $atraccion->sitios_id)->select('ruta', 'texto_alternativo')->first();
        $imagenes = Multimedia_Sitio::where('portada', false)->where('tipo', false)->where('sitios_id', $atraccion->sitios_id)->select('ruta', 'texto_alternativo')->get();
        $video = Multimedia_Sitio::where('portada', false)->where('tipo', true)->where('sitios_id', $atraccion->sitios_id)->pluck('ruta')->first();
        
        return ['atraccion' => $atraccion,
            'success' => true,
            'perfiles_turista' => $perfiles_turista,
            'tipo_atracciones' => $tipo_atracciones,
            'categorias_turismo' => $categorias_turismo,
            'actividades' => $actividades,
            'portadaIMG' => $portadaIMG,
            'imagenes' => $imagenes,
            'video_promocional' => $video];
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Atracciones::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradoratracciones.Editar', ['id' => $id]);
    }
    
    public function getDatoscrear(){
        $sectores = Sector::with(['destino' => function ($queryDestino){
            $queryDestino->with(['destinoConIdiomas' => function($queryDestinoConIdiomas){
                $queryDestinoConIdiomas->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
            }])->select('latitud', 'longitud', 'id');
        }])->with(['sectoresConIdiomas' => function ($querySectoresConIdiomas){
            $querySectoresConIdiomas->with(['idioma' => function($queryIdiomas){
                $queryIdiomas->select('id' ,'nombre', 'culture');
            }])->select('idiomas_id', 'sectores_id', 'nombre');
        }])->select('id', 'destino_id', 'es_urbano')->groupBy('destino_id', 'es_urbano', 'id')->where('estado', true)->get();
        
        $perfiles_turista = Perfil_Usuario::with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdioma){
           $queryPerfilesUsuariosConIdioma->with(['idioma' => function ($queryIdioma){
               $queryIdioma->select('id', 'nombre', 'culture');
           }])->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
        }])->select('id')->where('estado', true)->get();
        
        $tiposAtracciones = Tipo_Atraccion::with(['tipoAtraccionesConIdiomas' => function ($queryTipoAtraccionesConIdiomas){
            $queryTipoAtraccionesConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('idiomas_id', 'tipo_atracciones_id', 'nombre');
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
            
        $actividades = Actividades::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }])->where('estado', true)->select('id')->get();
            
        return ['success' => true, 
            'sectores' => $sectores, 
            'perfiles_turista' => $perfiles_turista, 
            'tipos_atracciones' => $tiposAtracciones,
            'categorias_turismo' => $categorias_turismo,
            'actividades' => $actividades];
    }
    
    public function getDatos (){
        $atracciones = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->with(['idioma' => function ($queryIdioma){
                    $queryIdioma->select('id', 'nombre', 'culture');
                }])->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion')->orderBy('idiomas_id');
            }, 'multimediaSitios' => function($queryMultimediaSitios) {
                $queryMultimediaSitios->where('portada', true)->select('sitios_id', 'ruta');
            }])->select('id');
        }])->select('sitios_id', 'id', 'estado', 'sugerido')->orderBy('id')->get();
        
        $idiomas = Idioma::select('id', 'nombre', 'culture')->get();
        
        return ['atracciones' => $atracciones, 'success' => true, 'idiomas' => $idiomas];
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $atraccion = Atracciones::with(['sitio' => function ($querySitio) use ($idIdioma, $id){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas) use ($idIdioma, $id) {
                $querySitiosConIdiomas->where('idiomas_id', $idIdioma)->select('sitios_id', 'nombre', 'descripcion');
            }])->select('sectores_id', 'id', 'direccion');
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas) use ($idIdioma, $id) {
            $queryAtraccionesConIdiomas->where('idiomas_id', $idIdioma)->select('atracciones_id', 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }])->select('telefono', 'sitio_web', 'sitios_id', 'id')->where('id', $id)->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['atraccion' => $atraccion, 'success' => Atraccion_Con_Idioma::where('atracciones_id', $id)->where('idiomas_id', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function postCrearatraccion(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|min:100',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric',
            'sector_id' => 'required|numeric|exists:sectores,id',
            'direccion' => 'max:150',
            'horario' => 'max:255',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255',
            'actividad' => 'max:1000',
            'recomendaciones' => 'max:1000',
            'reglas' => 'max:1000',
            'como_llegar' => 'max:1000',
            'pos' => 'required'
        ],[
            'nombre.required' => 'Se necesita un nombre para la atracción.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'descripcion.required' => 'Se necesita una descripción para la atracción.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para la atracción.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para la atracción.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            
            'sector_id.required' => 'Se necesita un identificador para el sector.',
            'sector_id.numeric' => 'El identificador del sector, debe ser numérico.',
            'sector_id.exists' => 'El identificador de sector no se encuentra registrado en la base de datos.',
            
            'direccion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Dirección".',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            
            'actividad.max' => 'Se ha excedido el número máximo de caracteres para el campo "Periodo de actividad e inactividad".',
            
            'recomendaciones.max' => 'Se ha excedido el número máximo de caracteres para el campo "Recomendaciones".',
            
            'reglas.max' => 'Se ha excedido el número máximo de caracteres para el campo "Reglas".',
            
            'como_llegar.max' => 'Se ha excedido el número máximo de caracteres para el campo "Como llegar".',
            
            'pos.required' => 'Agregue un marcador en el mapa de Google.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $sitio_nombre = Sitio_Con_Idioma::where('idiomas_id', 1)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($sitio_nombre != null){
            $errores["exists"][0] = "Esta atracción ya se encuentra registrada en el sistema.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $sitio = new Sitio();
        $sitio->sectores_id = $request->sector_id;
        $sitio->tipo_sitios_id = 1;
        $sitio->latitud = $request->pos['lat'];
        $sitio->longitud = $request->pos['lng'];
        $sitio->direccion = $request->direccion;
        $sitio->estado = true;
        $sitio->created_at = Carbon::now();
        $sitio->updated_at = Carbon::now();
        $sitio->user_create = "Situr";
        $sitio->user_update = "Situr";
        $sitio->save();
        
        $sitio_con_idioma = new Sitio_Con_Idioma();
        $sitio_con_idioma->idiomas_id = 1;
        $sitio_con_idioma->sitios_id = $sitio->id;
        $sitio_con_idioma->nombre = $request->nombre;
        $sitio_con_idioma->descripcion = $request->descripcion;
        $sitio_con_idioma->save();
        
        $atraccion = new Atracciones();
        $atraccion->sitios_id = $sitio->id;
        $atraccion->telefono = $request->telefono;
        $atraccion->sitio_web = $request->pagina_web;
        $atraccion->valor_min = $request->valor_minimo;
        $atraccion->valor_max = $request->valor_maximo;
        $atraccion->estado = true;
        $atraccion->user_create = "Situr";
        $atraccion->user_update = "Situr";
        $atraccion->created_at = Carbon::now();
        $atraccion->updated_at = Carbon::now();
        $atraccion->save();
        
        $atraccion_con_idioma = new Atraccion_Con_Idioma();
        $atraccion_con_idioma->atracciones_id = $atraccion->id;
        $atraccion_con_idioma->idiomas_id = 1;
        $atraccion_con_idioma->como_llegar = $request->como_llegar;
        $atraccion_con_idioma->horario = $request->horario;
        $atraccion_con_idioma->periodo = $request->actividad;
        $atraccion_con_idioma->recomendaciones = $request->recomendaciones;
        $atraccion_con_idioma->reglas = $request->reglas;
        $atraccion_con_idioma->save();
        
        return ['success' => true, 'id' => $atraccion->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'portadaIMGText' => 'required',
            'id' => 'required|exists:atracciones|numeric',
            'image' => 'array|max:20',
            'imageText' => 'array|max:20',
            'video_promocional' => 'url',
            'image.*' => 'max:2097152',
            'imageText.*' => 'required'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            'portadaIMG.max' => 'La imagen de portada no puede ser mayor a 2MB.',
            
            'portadaIMGText.required' => 'Se necesita el texto de la imagen de portada.',
            
            'id.required' => 'Se necesita un identificador para la atracción.',
            'id.exists' => 'El identificador de la atracción no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 20 imágenes para la atracción.',
            
            'imageText.array' => 'Error al enviar los datos. Recargue la página.',
            'imageText.max' => 'Máximo se pueden subir 20 imágenes para la atracción.',
            
            'video_promocional.url' => 'El video promocional no tiene la estructura de enlace.',
            
            'image.*.max' => 'El peso máximo por imagen es de 2MB. Por favor verifique si se cumple esta condición.',
            
            'imageText.*.required' => 'Una de las imágenes que se quiere subir no tiene texto alternativo.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        $atraccion->user_update = "Situr";
        $atraccion->updated_at = Carbon::now();
        
        Multimedia_Sitio::where('sitios_id', $atraccion->sitios_id)->where('portada', true)->delete();
        Storage::disk('multimedia-atraccion')->deleteDirectory('atraccion-'.$request->id);
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName(), PATHINFO_EXTENSION);
        //if (Storage::disk('multimedia-atraccion')->exists('atraccion-'.$request->id.'/portada.*')){
        //   Multimedia_Sitio::where('sitios_id', $atraccion->sitios_id)->where('portada', true)->delete();
        //   Storage::disk('multimedia-atraccion')->deleteDirectory('atraccion-'.$request->id);
        //}
        
        $multimedia_sitio = new Multimedia_Sitio();
        $multimedia_sitio->sitios_id = $atraccion->sitios_id;
        $multimedia_sitio->ruta = "/multimedia/atracciones/atraccion-".$request->id."/".$portadaNombre;
        $multimedia_sitio->texto_alternativo = $request->portadaIMGText;
        $multimedia_sitio->tipo = false;
        $multimedia_sitio->portada = true;
        $multimedia_sitio->estado = true;
        $multimedia_sitio->user_create = "Situr";
        $multimedia_sitio->user_update = "Situr";
        $multimedia_sitio->created_at = Carbon::now();
        $multimedia_sitio->updated_at = Carbon::now();
        $multimedia_sitio->save();
        
        Storage::disk('multimedia-atraccion')->put('atraccion-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        if ($request->has('video_promocional')){
            Multimedia_Sitio::where('sitios_id', $atraccion->sitios_id)->where('tipo', true)->delete();
            $multimedia_sitio = new Multimedia_Sitio();
            $multimedia_sitio->sitios_id = $atraccion->sitios_id;
            $multimedia_sitio->ruta = $request->video_promocional;
            $multimedia_sitio->tipo = true;
            $multimedia_sitio->portada = false;
            $multimedia_sitio->estado = true;
            $multimedia_sitio->user_create = "Situr";
            $multimedia_sitio->user_update = "Situr";
            $multimedia_sitio->created_at = Carbon::now();
            $multimedia_sitio->updated_at = Carbon::now();
            $multimedia_sitio->save();
        }
        
        Multimedia_Sitio::where('sitios_id', $atraccion->sitios_id)->where('tipo', false)->where('portada', false)->delete();
        // for ($i = 0; $i < 20; $i++){
        //     $nombre = "imagen-".$i.".*";
        //     if (Storage::disk('multimedia-atraccion')->exists('atraccion-'.$request->id.'/'.$nombre)){
        //         Storage::disk('multimedia-atraccion')->delete('atraccion-'.$request->id.'/'.$nombre);
        //     }
        // }
        
        //return ['success' => false, 'files' => $request->image[0]];
        
        if ($request->image != null){
            foreach($request->image as $key => $file){
                if (!is_string($file)){
                    $nombre = "imagen-".$key.".".pathinfo($file->getClientOriginalName())['extension'];
                    $multimedia_sitio = new Multimedia_Sitio();
                    $multimedia_sitio->sitios_id = $atraccion->sitios_id;
                    $multimedia_sitio->ruta = "/multimedia/atracciones/atraccion-".$request->id."/".$nombre;
                    $multimedia_sitio->texto_alternativo = $request->imageText[$key];
                    $multimedia_sitio->tipo = false;
                    $multimedia_sitio->portada = false;
                    $multimedia_sitio->estado = true;
                    $multimedia_sitio->user_create = "Situr";
                    $multimedia_sitio->user_update = "Situr";
                    $multimedia_sitio->created_at = Carbon::now();
                    $multimedia_sitio->updated_at = Carbon::now();
                    $multimedia_sitio->save();
                    
                    Storage::disk('multimedia-atraccion')->put('atraccion-'.$request->id.'/'.$nombre, File::get($file));
                }
            }
        }
        
        return ['success' => true];
    }
    
    public function postGuardaradicional (Request $request){
        $validator = \Validator::make($request->all(), [
            'perfiles' => 'required|array',
            'tipos' => 'required|array',
            'categorias' => 'required|array',
            'actividades' => 'array',
            'id' => 'required|exists:atracciones'
        ],[
            'perfiles.required' => 'Se necesitan los perfiles del turista para esta atracción.',
            'perfiles.array' => 'Error al enviar los datos. Recargue la página.',
            
            'tipos.required' => 'Se necesitan los tipos de atracciones.',
            'tipos.array' => 'Error al enviar los datos. Recargue la página.',
            
            'categorias.required' => 'Se necesitan las categorías de la atracción.',
            'categorias.max' => 'Error al enviar los datos. Recargue la página.',
            
            'actividades.max' => 'Error al enviar los datos. Recargue la página.',
            
            'id.required' => 'Se necesita el identificador de la atracción.',
            'id.exists' => 'El identificador de la atracción no se encuentra registrado en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        $atraccion->atraccionesConTipos()->detach();
        $atraccion->atraccionesConTipos()->attach($request->tipos);
        $atraccion->categoriaTurismoConAtracciones()->detach();
        $atraccion->categoriaTurismoConAtracciones()->attach($request->categorias);
        $atraccion->perfilesUsuariosConAtracciones()->detach();
        $atraccion->perfilesUsuariosConAtracciones()->attach($request->perfiles);
        
        if ($request->actividades != null){
            $sitio = Sitio::find($atraccion->sitios_id);
            $sitio->sitiosConActividades()->detach();
            $sitio->sitiosConActividades()->attach($request->actividades);
            $sitio->user_update = "Situr";
            $sitio->updated_at = Carbon::now();
            $sitio->save();
        }
        
        $atraccion->user_update = "Situr";
        $atraccion->updated_at = Carbon::now();
        $atraccion->save();
        
        return ["success" => true];
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:atracciones'
        ],[
            'id.required' => 'Se necesita el identificador de la atracción.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            'id.exists' => 'La atracción no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        $atraccion->estado = !$atraccion->estado;
        $atraccion->save();
        
        return ['success' => true];
    }
    
    public function postSugerir (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:atracciones'
        ],[
            'id.required' => 'Se necesita el identificador de la atracción.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            'id.exists' => 'La atracción no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        $atraccion->sugerido = !$atraccion->sugerido;
        $atraccion->save();
        
        return ['success' => true];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:atracciones|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|min:100',
            'horario' => 'max:255',
            'actividad' => 'max:1000',
            'recomendaciones' => 'max:1000',
            'reglas' => 'max:1000',
            'como_llegar' => 'max:1000'
        ],[
            'nombre.required' => 'Se necesita un nombre para la atracción.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador de la atracción.',
            'id.exists' => 'La atracción no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para la atracción.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'actividad.max' => 'Se ha excedido el número máximo de caracteres para el campo "Periodo de actividad e inactividad".',
            
            'recomendaciones.max' => 'Se ha excedido el número máximo de caracteres para el campo "Recomendaciones".',
            
            'reglas.max' => 'Se ha excedido el número máximo de caracteres para el campo "Reglas".',
            
            'como_llegar.max' => 'Se ha excedido el número máximo de caracteres para el campo "Como llegar".'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        
        if (Atraccion_Con_Idioma::where('atracciones_id', $request->id)->where('idiomas_id', $request->idIdioma)->first() != null){
            Sitio_Con_Idioma::where('sitios_id', $atraccion->sitios_id)->where('idiomas_id', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
            
            Atraccion_Con_Idioma::where('atracciones_id', $request->id)->where('idiomas_id', $request->idIdioma)
                ->update([
                'como_llegar' => $request->como_llegar,
                'horario' => $request->horario,
                'periodo' => $request->actividad,
                'recomendaciones' => $request->recomendaciones,
                'reglas' => $request->reglas]);
        }else{
            Sitio_Con_Idioma::create([
                'sitios_id' => $atraccion->sitios_id,
                'idiomas_id' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
            
            Atraccion_Con_Idioma::create([
                'atracciones_id' => $request->id,
                'idiomas_id' => $request->idIdioma,
                'como_llegar' => $request->como_llegar,
                'horario' => $request->horario,
                'periodo' => $request->actividad,
                'recomendaciones' => $request->recomendaciones,
                'reglas' => $request->reglas]);
        }
        
        $atraccion = Atracciones::with(['sitio' => function ($querySitio) use ($request){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas) use ($request) {
                $querySitiosConIdiomas->where('idiomas_id', $request->idIdioma)->select('sitios_id', 'nombre', 'descripcion');
            }])->select('sectores_id', 'id', 'direccion');
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas) use ($request) {
            $queryAtraccionesConIdiomas->where('idiomas_id', $request->idIdioma)->select('atracciones_id', 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }])->select('telefono', 'sitio_web', 'sitios_id', 'id')->where('id', $request->id)->first();
        
        return ['success' => true, 'atraccion' => $atraccion];
    }
    
    public function postEditaratraccion (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:atracciones|numeric',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric',
            'sector_id' => 'required|numeric|exists:sectores,id',
            'pos' => 'required'
        ],[
            'id.required' => 'Se necesita el identificador de la atracción.',
            'id.exists' => 'La atracción que planea modificar no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para la atracción.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para la atracción.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            
            'sector_id.required' => 'Se necesita saber el sector de la atracción.',
            'sector_id.numeric' => '"Sector" debe tener un valor numérico.',
            'sector_id.exists' => 'El sector que especificó no se encuentra registrado en el sistema.',
            
            'pos.required' => 'Por favor marque la ubicación de la atracción en el mapa de Google.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        $atraccion->valor_max = $request->valor_maximo;
        $atraccion->valor_min = $request->valor_minimo;
        $atraccion->telefono = $request->telefono;
        $atraccion->sitio_web = $request->sitio_web;
        $atraccion->user_update = "Situr";
        $atraccion->updated_at = Carbon::now();
        $atraccion->save();
        
        $sitio = Sitio::find($atraccion->sitios_id);
        $sitio->latitud = $request->pos['lat'];
        $sitio->longitud = $request->pos['lng'];
        $sitio->sectores_id = $request->sector_id;
        $sitio->direccion = $request->direccion;
        $sitio->user_update = "Situr";
        $sitio->updated_at = Carbon::now();
        $sitio->save();
        
        return ['success' => true];
    }
}
