<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
    //
    
    public function getIndex(){
        return view('administradoratracciones.Index');
    }
    
    public function getCrear(){
        return view('administradoratracciones.Crear');
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
        $idiomas = Idioma::select('id', 'nombre', 'culture')->where('estado', true)->get();
        
        $atracciones = Atracciones::with(['sitio' => function ($q){
            $q->with(['sitiosConIdiomas' => function($x){
                $x->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }])->select('id', 'idioma_id', 'nombre', 'descripcion')->get();
            }])->get();
        }, 'atraccionesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }])->select('como_llegar', 'idioma_id')->get();
        }, 'atraccionesConTipos' => function($q){
            $q->with(['tipoAtraccione' => function($a){
                $a->with(['tipoAtraccionesConIdiomas' => function($ta){
                        $ta->with(['idioma' => function($i){
                            $i->select('id', 'nombre', 'culture');
                    }])->select('nombre', 'idioma_id')->get();
                }])->select('tipo_atracciones_id', 'idioma_id', 'id', 'nombre')->get();
            }])->get();
        }])->select('id', 'sitios_id', 'estado', 'telefono', 'sitio_web', 'valor_min', 'valor_max')->get();
        
        $tiposAtracciones = Tipo_Atraccion::with(['tipoAtraccionesConIdiomas' => function ($query){
            $query->with(['idioma' => function ($idioma){
                $idioma->select('id', 'nombre', 'culture');
            }])->select('id', 'nombre', 'idiomas_id', 'tipo_atracciones_id');
        }])->select('id')->get();
        return ['atracciones' => $atracciones, 'idiomas' => $idiomas, 'tiposAtracciones' => $tiposAtracciones];
    }
    
    public function postCrearatraccion(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:1000|min:100',
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
            'como_llegar' => 'max:1000'
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
            
            'como_llegar.max' => 'Se ha excedido el número máximo de caracteres para el campo "Como llegar".'
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
            'portadaIMG' => 'required',
            'id' => 'required|exists:atracciones|numeric',
            'image' => 'array|max:5'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            
            'id.required' => 'Se necesita un identificador para la atracción.',
            'id.exists' => 'El identificador de la atracción no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador de la atracción debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 5 imágenes para la atracción.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $atraccion = Atracciones::find($request->id);
        
        $portadaNombre = "portada-".$request->id.".".pathinfo($request->portadaIMG->getClientOriginalName(), PATHINFO_EXTENSION);
        if (Storage::disk('multimedia-atraccion')->exists($portadaNombre)){
            Multimedia_Sitio::where('sitios_id', $atraccion->sitios_id)->where('portada', true)->delete();
            Storage::disk('multimedia-atraccion')->delete($portadaNombre);
        }
        
        $multimedia_sitio = new Multimedia_Sitio();
        $multimedia_sitio->sitios_id = $atraccion->sitios_id;
        $multimedia_sitio->ruta = "/multimedia/atracciones/".$portadaNombre;
        $multimedia_sitio->tipo = false;
        $multimedia_sitio->portada = true;
        $multimedia_sitio->estado = true;
        $multimedia_sitio->user_create = "Situr";
        $multimedia_sitio->user_update = "Situr";
        $multimedia_sitio->created_at = Carbon::now();
        $multimedia_sitio->updated_at = Carbon::now();
        $multimedia_sitio->save();
        
        if ($request->video_promocional != null){
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
        
        Storage::disk('multimedia-atraccion')->put($portadaNombre, File::get($request->portadaIMG));
        
        $cont = "";
        foreach($request->image as $key => $file){
            $nombre = "atraccion".$atraccion->id."-imagen".$key.".".pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);;
            if (Storage::disk('multimedia-atraccion')->exists($nombre)){
                Storage::disk('multimedia-atraccion')->delete($nombre);
            }
            $multimedia_sitio = new Multimedia_Sitio();
            $multimedia_sitio->sitios_id = $atraccion->sitios_id;
            $multimedia_sitio->ruta = "/multimedia/atracciones/".$nombre;
            $multimedia_sitio->tipo = false;
            $multimedia_sitio->portada = false;
            $multimedia_sitio->estado = true;
            $multimedia_sitio->user_create = "Situr";
            $multimedia_sitio->user_update = "Situr";
            $multimedia_sitio->created_at = Carbon::now();
            $multimedia_sitio->updated_at = Carbon::now();
            $multimedia_sitio->save();
            
            Storage::disk('multimedia-atraccion')->put($nombre, File::get($file));
            $cont = $nombre;
        }
        
        return ['success' => true, 'cont' => $cont];
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
        }
        
        return ["success" => true];
    }
}
