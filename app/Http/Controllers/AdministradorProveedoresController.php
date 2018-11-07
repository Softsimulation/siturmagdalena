<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use File;
use DB;

use App\Models\Sector;
use App\Models\Perfil_Usuario;
use App\Models\Categoria_Turismo;
use App\Models\Actividades;
use App\Models\Categoria_Proveedor;
use App\Models\Proveedor;
use App\Models\Proveedor_Con_Idioma;
use App\Models\Proveedores_rnt;
use App\Models\Proveedores_rnt_idioma;
use App\Models\Multimedia_Proveedor;
use App\Models\Idioma;

class AdministradorProveedoresController extends Controller
{
    //
    
    public function getCrear(){
        return view('administradorproveedores.Crear');
    }
    
    public function getIndex (){
        return view('administradorproveedores.Index');
    }
    
    public function getEditar($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Proveedor::find($id) == null){
            return response('Not found.', 404);
        }
        return view('administradorproveedores.Editar', ['id' => $id]);
    }
    
    public function getIdioma($id, $idIdioma){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Proveedor::find($id) == null){
            return response('Not found.', 404);
        }
        if ($idIdioma == null){
            return response('Bad request.', 400);
        }elseif(Idioma::find($idIdioma) == null){
            return response('Not found.', 404);
        }
        return view('administradorproveedores.Idioma', ['id' => $id, 'idIdioma' => $idIdioma]);
    }
    
    public function getDatosIdioma ($id, $idIdioma){
        $proveedor = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt) use ($idIdioma){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma) use ($idIdioma){
                $queyProveedor_rnt_idioma->select('proveedor_rnt_id', 'idioma_id','nombre' , 'descripcion')->where('idioma_id', $idIdioma);
            }])->select('id', 'razon_social');
        }, 'proveedoresConIdiomas' => function ($queryProveedoresConIdiomas){
            $queryProveedoresConIdiomas->select('idiomas_id', 'proveedores_id', 'horario');
        }])->select('id', 'proveedor_rnt_id')->where('id', $id)->first();
        
        $idioma = Idioma::find($idIdioma);
        
        return ['proveedor' => $proveedor, 'success' => Proveedores_rnt_idioma::where('proveedor_rnt_id', $proveedor->proveedor_rnt_id)->where('idioma_id', $idIdioma)->first() != null, 'idioma' => $idioma];
    }
    
    public function getDatos (){
        $proveedores = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma){
                $queyProveedor_rnt_idioma->with(['idioma' => function ($queryIdioma){
                    $queryIdioma->select('id', 'nombre', 'culture');
                }])->select('proveedor_rnt_id', 'idioma_id', 'nombre', 'descripcion')->orderBy('idioma_id');
            }])->select('id', 'razon_social');
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('portada', true)->select('proveedor_id', 'ruta');
        }])->select('id', 'estado', 'proveedor_rnt_id')->orderBy('id')->get();
        
        $idiomas = Idioma::select('id', 'culture', 'nombre')->where('estado', true)->get();
        
        return ['proveedores' => $proveedores, 'idiomas' => $idiomas, 'success' => true];
    }
    
    public function getProveedoresrnt(){
        $proveedores = Proveedores_rnt::all();
        
        return [$proveedores];
    }
    
    public function getDatosproveedor ($id){
        $proveedor = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt){
            $queryProveedorRnt->select('id', 'razon_social');
        }])->select('id', 'proveedor_rnt_id', 'telefono', 'sitio_web', 'valor_min', 'valor_max')->where('id', $id)->first();
        
        $portadaIMG = Multimedia_Proveedor::where('portada', true)->where('proveedor_id', $id)->pluck('ruta')->first();
        $imagenes = Multimedia_Proveedor::where('portada', false)->where('tipo', false)->where('proveedor_id', $id)->pluck('ruta')->toArray();
        $video = Multimedia_Proveedor::where('portada', false)->where('tipo', true)->where('proveedor_id', $id)->pluck('ruta')->first();
        
        $perfiles_usuarios = Proveedor::find($id)->perfilesUsuariosConProveedores()->pluck('perfiles_usuarios_id')->toArray();
        $categorias_turismo = Proveedor::find($id)->categoriaTurismoConProveedores()->pluck('categoria_turismo_id')->toArray();
        $actividades = Proveedor::find($id)->actividadesProveedores()->pluck('actividad_id')->toArray();
        
        return [
            'proveedor' => $proveedor,
            'portadaIMG' => $portadaIMG,
            'imagenes' => $imagenes,
            'video_promocional' => $video,
            'perfiles_usuarios' => $perfiles_usuarios,
            'categorias_turismo' => $categorias_turismo,
            'actividades' => $actividades,
            'success' => true
        ];
    }
    
    public function getDatoscrear(){
        $perfiles_turista = Perfil_Usuario::with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdioma){
           $queryPerfilesUsuariosConIdioma->with(['idioma' => function ($queryIdioma){
               $queryIdioma->select('id', 'nombre', 'culture');
           }])->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
        }])->select('id')->where('estado', true)->get();
        
        $categoria_proveedor = Categoria_Proveedor::with(['categoriaProveedoresConIdiomas' => function ($queryCategoriaProveedoresConIdiomas){
            $queryCategoriaProveedoresConIdiomas->select('idiomas_id', 'categoria_proveedores_id', 'nombre')->orderBy('idiomas_id');
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
            
        $actividades = Actividades::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->with(['idioma' => function ($queryIdioma){
                $queryIdioma->select('id', 'nombre', 'culture');
            }])->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }])->where('estado', true)->select('id')->get();
        
        $proveedores_rnt = Proveedores_rnt::select('id', 'razon_social')->orderBy('id')->doesntHave('proveedor')->get();
        //$proveedores_rnt = DB::select("SELECT proveedores_rnt.id AS id, proveedores_rnt.razon_social AS razon_social FROM
        //proveedores_rnt INNER JOIN proveedores ON proveedores.proveedor_rnt_id = proveedores_rnt.id");
            
        return ['success' => true,
            'perfiles_turista' => $perfiles_turista, 
            'categoria_proveedor' => $categoria_proveedor,
            'categorias_turismo' => $categorias_turismo,
            'actividades' => $actividades,
            'proveedores_rnt' => $proveedores_rnt];
    }
    
    public function postCrearproveedor(Request $request){
        $validator = \Validator::make($request->all(), [
            'proveedor_rnt_id' => 'required|numeric|exists:proveedores_rnt,id',
            'descripcion' => 'required|max:1000|min:100',
            'nombre' => 'max:255|required',
            'valor_minimo' => 'required|numeric|min:0',
            'valor_maximo' => 'required|numeric|min:0',
            'horario' => 'max:255',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255|url'
        ],[
            'proveedor_rnt_id.required' => 'Se necesita el identificador del proveedor.',
            'proveedor_rnt_id.numeric' => 'El identificador del proveedor debe ser un valor numérico.',
            'proveedor_rnt_id.exists' => 'El proveedor no se encuentra registrado en la base de datos.',
            
            'descripcion.required' => 'Se necesita una descripción para el proveedor.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            'nombre.required' => 'El nombre público del proveedor es requerido.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para el proveedor.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            'valor_minimo.min' => '"Valor mínimo" no puede ser menor que 0',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para el proveedor.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            'valor_maximo.min' => '"Valor máximo" no puede ser menor que 0',
            
            'categoria_proveedor.required' => 'Se necesita una categoría para el proveedor.',
            'categoria_proveedor.numeric' => 'La categoría del proveedor debe ser un valor numérico.',
            'categoria_proveedor.exists' => 'La categoría del proveedor no se encuentra registrada en la base de datos.',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            'pagina_web.url' => 'El campo "Página web" debe tener la estructura http://example.com'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $proveedor_rnt_con_idioma = Proveedor::where('proveedor_rnt_id', $request->proveedor_rnt_id)->first();
        //return ['proveedores' => Proveedores_rnt_idioma::all()];
        if ($proveedor_rnt_con_idioma != null){
            $errores["exists"][0] = "Este proveedor ya se encuentra registrado en el sistema.";
        }
        if ($request->valor_maximo < $request->valor_minimo){
            $errores["gt"][0] = 'El campo "Valor máximo" debe ser mayor a "Valor mínimo".';
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $proveedor = new Proveedor();
        $proveedor->valor_min = $request->valor_minimo;
        $proveedor->valor_max = $request->valor_maximo;
        $proveedor->telefono = $request->telefono;
        $proveedor->sitio_web = $request->pagina_web;
        $proveedor->proveedor_rnt_id = $request->proveedor_rnt_id;
        $proveedor->estado = true;
        $proveedor->created_at = Carbon::now();
        $proveedor->updated_at = Carbon::now();
        $proveedor->user_create = "Situr";
        $proveedor->user_update = "Situr";
        $proveedor->save();
        
        $proveedor_con_idioma = new Proveedor_Con_Idioma();
        $proveedor_con_idioma->idiomas_id = 2;
        $proveedor_con_idioma->proveedores_id = $proveedor->id;
        $proveedor_con_idioma->horario = $request->horario;
        $proveedor_con_idioma->save();
        
        $proveedor_rnt_con_idioma = Proveedores_rnt_idioma::where('idioma_id', 1)->where('proveedor_rnt_id', $request->proveedor_rnt_id)->first();
        if ($proveedor_rnt_con_idioma != null){
            $proveedor_rnt_con_idioma->nombre = $request->nombre;
            $proveedor_rnt_con_idioma->descripcion = $request->descripcion;
        }else {
            $proveedor_rnt_con_idioma = new Proveedores_rnt_idioma();
            $proveedor_rnt_con_idioma->proveedor_rnt_id = $request->proveedor_rnt_id;
            $proveedor_rnt_con_idioma->idioma_id = 1;
            $proveedor_rnt_con_idioma->nombre = $request->nombre;
            $proveedor_rnt_con_idioma->descripcion = $request->descripcion;
        }
        $proveedor_rnt_con_idioma->save();
        
        return ['success' => true, 'id' => $proveedor->id];
    }
    
    public function postGuardarmultimedia (Request $request){
        $validator = \Validator::make($request->all(), [
            'portadaIMG' => 'required|max:2097152',
            'id' => 'required|exists:proveedores|numeric',
            'image' => 'array|max:5',
            'video_promocional' => 'url'
        ],[
            'portadaIMG.required' => 'Se necesita una imagen de portada.',
            'portadaIMG.max' => 'La imagen de portada no puede ser mayor a 2MB.',
            
            'id.required' => 'Se necesita un identificador para el proveedor.',
            'id.exists' => 'El identificador del proveedor no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador del proveedor debe ser un valor numérico.',
            
            'image.array' => 'Error al enviar los datos. Recargue la página.',
            'image.max' => 'Máximo se pueden subir 5 imágenes para la atracción.',
            
            'video_promocional.url' => 'La estructura del video promocional debe ser un enlace.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        Multimedia_Proveedor::where('proveedor_id', $request->id)->delete();
        
        $portadaNombre = "portada.".pathinfo($request->portadaIMG->getClientOriginalName(), PATHINFO_EXTENSION);
        if (Storage::disk('multimedia-proveedor')->exists('proveedor-'.$request->id.'/'.$portadaNombre)){
            Storage::disk('multimedia-proveedor')->deleteDirectory('proveedor-'.$request->id);
        }
        
        $multimedia_proveedor = new Multimedia_Proveedor();
        $multimedia_proveedor->proveedor_id = $request->id;
        $multimedia_proveedor->ruta = "/multimedia/proveedores/proveedor-".$request->id."/".$portadaNombre;
        $multimedia_proveedor->tipo = false;
        $multimedia_proveedor->portada = true;
        $multimedia_proveedor->estado = true;
        $multimedia_proveedor->user_create = "Situr";
        $multimedia_proveedor->user_update = "Situr";
        $multimedia_proveedor->created_at = Carbon::now();
        $multimedia_proveedor->updated_at = Carbon::now();
        $multimedia_proveedor->save();
        
        Storage::disk('multimedia-proveedor')->put('proveedor-'.$request->id.'/'.$portadaNombre, File::get($request->portadaIMG));
        
        if ($request->has('video_promocional') && count($request->video_promocional) != 0){
            $multimedia_proveedor = new Multimedia_Proveedor();
            $multimedia_proveedor->proveedor_id = $request->id;
            $multimedia_proveedor->ruta = $request->video_promocional;
            $multimedia_proveedor->tipo = true;
            $multimedia_proveedor->portada = false;
            $multimedia_proveedor->estado = true;
            $multimedia_proveedor->user_create = "Situr";
            $multimedia_proveedor->user_update = "Situr";
            $multimedia_proveedor->created_at = Carbon::now();
            $multimedia_proveedor->updated_at = Carbon::now();
            $multimedia_proveedor->save();
        }
        
        for ($i = 0; $i < 5; $i++){
            $nombre = "imagen-".$i.".*";
            if (Storage::disk('multimedia-proveedor')->exists('proveedor-'.$request->id.'/'.$nombre)){
                Storage::disk('multimedia-proveedor')->delete('proveedor-'.$request->id.'/'.$nombre);
            }
        }
        
        if ($request->image != null){
            foreach($request->image as $key => $file){
                if (!is_string($file)){
                    $nombre = "imagen-".$key.".".pathinfo($file->getClientOriginalName())['extension'];
                    $multimedia_proveedor = new Multimedia_Proveedor();
                    $multimedia_proveedor->proveedor_id = $request->id;
                    $multimedia_proveedor->ruta = "/multimedia/proveedores/proveedor-".$request->id."/".$nombre;
                    $multimedia_proveedor->tipo = false;
                    $multimedia_proveedor->portada = false;
                    $multimedia_proveedor->estado = true;
                    $multimedia_proveedor->user_create = "Situr";
                    $multimedia_proveedor->user_update = "Situr";
                    $multimedia_proveedor->created_at = Carbon::now();
                    $multimedia_proveedor->updated_at = Carbon::now();
                    $multimedia_proveedor->save();
                    
                    Storage::disk('multimedia-proveedor')->put('proveedor-'.$request->id.'/'.$nombre, File::get($file));
                }
            }
        }
        
        return ['success' => true];
    }
    
    public function postGuardaradicional (Request $request){
        $validator = \Validator::make($request->all(), [
            'perfiles' => 'required|array',
            'actividades' => 'array',
            'categorias' => 'required|array',
            'id' => 'required|exists:proveedores'
        ],[
            'perfiles.required' => 'Se necesitan los perfiles del turista para este proveedor.',
            'perfiles.array' => 'Error al enviar los datos. Recargue la página.',
            
            'actividades.array' => 'Error al enviar los datos. Recargue la página.',
            
            'categorias.required' => 'Se necesitan las categorías de turismo para el proveedor.',
            'categorias.max' => 'Error al enviar los datos. Recargue la página.',
            
            'id.required' => 'Se necesita el identificador del proveedor.',
            'id.exists' => 'El identificador del evento no se encuentra registrado en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $proveedor = Proveedor::find($request->id);
        $proveedor->categoriaTurismoConProveedores()->detach();
        $proveedor->categoriaTurismoConProveedores()->attach($request->categorias);
        $proveedor->perfilesUsuariosConProveedores()->detach();
        $proveedor->perfilesUsuariosConProveedores()->attach($request->perfiles);
        $proveedor->actividadesProveedores()->detach();
        $proveedor->actividadesProveedores()->attach($request->actividades);
        
        $proveedor->save();
        
        return ["success" => true];
    }
    
    public function postDesactivarActivar (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|numeric|exists:proveedores'
        ],[
            'id.required' => 'Se necesita el identificador del proveedor.',
            'id.numeric' => 'El identificador del proveedor debe ser un valor numérico.',
            'id.exists' => 'El proveedor no se encuentra registrada en la base de datos.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $proveedor = Proveedor::find($request->id);
        $proveedor->estado = !$proveedor->estado;
        $proveedor->save();
        
        return ['success' => true];
    }
    
    public function postEditarproveedor (Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:proveedores|numeric',
            'proveedor_rnt_id' => 'required|numeric|exists:proveedores_rnt,id',
            // 'descripcion' => 'required|max:1000|min:100',
            'valor_minimo' => 'required|numeric|min:0',
            'valor_maximo' => 'required|numeric|min:0',
            // 'horario' => 'max:255',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255|url'
        ],[
            'id.required' => 'Se necesita el indentificador del proveedor.',
            'id.exists' => 'El identificador del proveedor no se encuentra registrado en el sistema.',
            'id.numeric' => 'El identificador del proveedor debe ser un dato numérico.',
            
            'proveedor_rnt_id.required' => 'Se necesita el identificador del proveedor.',
            'proveedor_rnt_id.numeric' => 'El identificador del proveedor debe ser un valor numérico.',
            'proveedor_rnt_id.exists' => 'El proveedor no se encuentra registrado en la base de datos.',
            
            // 'descripcion.required' => 'Se necesita una descripción para el proveedor.',
            // 'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            // 'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'valor_minimo.required' => 'Se requiere ingresar un valor mínimo para el proveedor.',
            'valor_minimo.numeric' => '"Valor mínimo" debe tener un valor numérico.',
            'valor_minimo.min' => '"Valor mínimo" no puede ser menor que 0',
            
            'valor_maximo.required' => 'Se requiere ingresar un valor máximo para el proveedor.',
            'valor_maximo.numeric' => '"Valor máximo" debe tener un valor numérico.',
            'valor_maximo.min' => '"Valor máximo" no puede ser menor que 0',
            
            'categoria_proveedor.required' => 'Se necesita una categoría para el proveedor.',
            'categoria_proveedor.numeric' => 'La categoría del proveedor debe ser un valor numérico.',
            'categoria_proveedor.exists' => 'La categoría del proveedor no se encuentra registrada en la base de datos.',
            
            // 'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            'pagina_web.url' => 'El campo "Página web" debe tener la estructura http://example.com'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        // $proveedor_rnt_con_idioma = Proveedores_rnt_idioma::where('idioma_id', 2)->where('proveedor_rnt_id', $request->proveedor_rnt_id)->first();
        // if ($proveedor_rnt_con_idioma != null){
        //     if ($proveedor_rnt_con_idioma->proveedor_rnt_id != Proveedor::find($request->id)->proveedor_rnt_id){
        //         $errores["exists"][0] = "Este proveedor ya se encuentra registrado en el sistema.";
        //     }
        // }
        if ($request->valor_maximo < $request->valor_minimo){
            $errores["gt"][0] = 'El campo "Valor máximo" debe ser mayor a "Valor mínimo".';
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false, "errores"=>$errores];
        }
        
        $proveedor = Proveedor::find($request->id);
        // Proveedores_rnt_idioma::where('proveedor_rnt_id', $proveedor->proveedor_rnt_id)->where('idioma_id', 2)->delete();
        $proveedor->valor_min = $request->valor_minimo;
        $proveedor->valor_max = $request->valor_maximo;
        $proveedor->telefono = $request->telefono;
        $proveedor->sitio_web = $request->pagina_web;
        // $proveedor->proveedor_rnt_id = $request->proveedor_rnt_id;
        $proveedor->estado = true;
        $proveedor->created_at = Carbon::now();
        $proveedor->updated_at = Carbon::now();
        $proveedor->user_create = "Situr";
        $proveedor->user_update = "Situr";
        $proveedor->save();
        
        // $proveedor_con_idioma = Proveedor_Con_Idioma::where('proveedores_id', $request->id)->where('idiomas_id', 2)->first();
        // $proveedor_con_idioma->horario = $request->horario;
        // $proveedor_con_idioma->save();
        
        // $proveedor_rnt_con_idioma = new Proveedores_rnt_idioma();
        // $proveedor_rnt_con_idioma->proveedor_rnt_id = $request->proveedor_rnt_id;
        // $proveedor_rnt_con_idioma->idioma_id = 2;
        // $proveedor_rnt_con_idioma->nombre = Proveedores_rnt::find($request->proveedor_rnt_id)->razon_social;
        // $proveedor_rnt_con_idioma->descripcion = $request->descripcion;
        // $proveedor_rnt_con_idioma->save();
        
        return ['success' => true];
    }
    
    public function postEditaridioma (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'id' => 'required|exists:proveedores|numeric',
            'idIdioma' => 'required|exists:idiomas,id|numeric',
            'descripcion' => 'required|max:1000|min:100',
            'horario' => 'max:255'
        ],[
            'nombre.required' => 'Se necesita un nombre para el proveedor.',
            'nombre.max' => 'Se ha excedido el número máximo de caracteres para el campo "Nombre".',
            
            'id.required' => 'Se necesita el identificador del proveedor.',
            'id.exists' => 'El proveedor no se encuentra registrada en la base de datos.',
            'id.numeric' => 'El identificador del proveedor debe ser un valor numérico.',
            
            'idIdioma.required' => 'Se necesita el identificador del idioma.',
            'idIdioma.numeric' => 'El identificador del idioma debe ser un valor numérico.',
            'idIdioma.exists' => 'El idioma especificado no se encuentra registrado en la base de datos.',
            
            
            'descripcion.required' => 'Se necesita una descripción para el proveedor.',
            'descripcion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Descripción".',
            'descripcion.min' => 'Se deben ingresar mínimo 100 caracteres para la descripción.',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario"'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $proveedor_rnt_id = Proveedor::find($request->id)->proveedor_rnt_id;
        
        
        if (Proveedores_rnt_idioma::where('proveedor_rnt_id', $proveedor_rnt_id)->where('idioma_id', $request->idIdioma)->first() != null){
            
            Proveedores_rnt_idioma::where('proveedor_rnt_id', $proveedor_rnt_id)->where('idioma_id', $request->idIdioma)
                ->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }else{
            Proveedores_rnt_idioma::create([
                'proveedor_rnt_id' => $proveedor_rnt_id,
                'idioma_id' => $request->idIdioma,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion]);
        }
        
        if (Proveedor_Con_Idioma::where('proveedores_id', $request->id)->where('idiomas_id', $request->idIdioma)->first() != null){
            
            Proveedor_Con_Idioma::where('proveedores_id', $request->id)->where('idiomas_id', $request->idIdioma)
                ->update([
                'horario' => $request->horario]);
        }else{
            Proveedor_Con_Idioma::create([
                'proveedores_id' => $request->id,
                'idiomas_id' => $request->idIdioma,
                'horario' => $request->horario]);
        }
        
        $proveedor = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt) use ($request){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma) use ($request){
                $queyProveedor_rnt_idioma->select('proveedor_rnt_id', 'idioma_id','nombre' , 'descripcion')->where('idioma_id', $request->idIdioma);
            }])->select('id', 'razon_social');
        }, 'proveedoresConIdiomas' => function ($queryProveedoresConIdiomas){
            $queryProveedoresConIdiomas->select('idiomas_id', 'proveedores_id', 'horario');
        }])->select('id', 'proveedor_rnt_id')->where('id', $request->id)->first();
        
        return ['success' => true, 'proveedor' => $proveedor];
    }
}
