<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Sector;
use App\Models\Perfil_Usuario;
use App\Models\Categoria_Turismo;
use App\Models\Actividades;
use App\Models\Categoria_Proveedor;
use App\Models\Proveedor_Con_Idioma;

class AdministradorProveedoresController extends Controller
{
    //
    
    public function getCrear(){
        return view('administradorproveedores.Crear');
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
            
        return ['success' => true, 
            'sectores' => $sectores, 
            'perfiles_turista' => $perfiles_turista, 
            'categoria_proveedor' => $categoria_proveedor,
            'categorias_turismo' => $categorias_turismo,
            'actividades' => $actividades];
    }
    
    public function postCrearproveedor(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:1000|min:100',
            'valor_minimo' => 'required|numeric',
            'valor_maximo' => 'required|numeric',
            'sector_id' => 'required|numeric|exists:sectores,id',
            'categoria_proveedor' => 'required|numeric|exists:categoria_proveedores,id',
            'direccion' => 'max:150',
            'horario' => 'max:255',
            'telefono' => 'max:100',
            'pagina_web' => 'max:255',
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
            
            'categoria_proveedor.required' => 'Se necesita una categoría para el proveedor.',
            'categoria_proveedor.numeric' => 'La categoría del proveedor debe ser un valor numérico.',
            'categoria_proveedor.exists' => 'La categoría del proveedor no se encuentra registrada en la base de datos.',
            
            'direccion.max' => 'Se ha excedido el número máximo de caracteres para el campo "Dirección".',
            
            'horario.max' => 'Se ha excedido el número máximo de caracteres para el campo "Horario".',
            
            'telefono.max' => 'Se ha excedido el número máximo de caracteres para el campo "Teléfono".',
            
            'pagina_web.max' => 'Se ha excedido el número máximo de caracteres para el campo "Página web".',
            
            'po.requireds' => 'Agregue un marcador en el mapa de Google.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $sitio_nombre = Proveedor_Con_Idioma::where('idiomas_id', 1)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
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
}
