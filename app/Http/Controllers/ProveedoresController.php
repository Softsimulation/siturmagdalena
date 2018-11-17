<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedor;

class ProveedoresController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
	}
	
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Proveedor::find($id) == null){
            return response('Not found.', 404);
        }
        
        $proveedor = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma){
                $queyProveedor_rnt_idioma->select('proveedor_rnt_id', 'idioma_id', 'descripcion')->orderBy('idioma_id');
            }])->select('id', 'razon_social');
        }, 'proveedoresConIdiomas' => function ($queryProveedoresConIdiomas){
            $queryProveedoresConIdiomas->select('idiomas_id', 'proveedores_id', 'horario')->where('idiomas_id', 2);
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', false)->orderBy('portada', 'desc')->select('proveedor_id', 'ruta');
        }, 'actividadesProveedores' => function ($queryActividadesProveedores){
            $queryActividadesProveedores->with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
                $queryActividadesConIdiomas->select('actividades_id', 'idiomas', 'nombre');
            }])->select('actividades.id');
        }, 'perfilesUsuariosConProveedores' => function($queryPerfilesUsuariosConProveedores){
            $queryPerfilesUsuariosConProveedores->with(['perfilesUsuariosConIdiomas' => function ($queryPerfilesUsuariosConIdiomas){
                $queryPerfilesUsuariosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }, 'categoriaTurismoConProveedores' => function($queryCategoriaTurismoConProveedores){
            $queryCategoriaTurismoConProveedores->with(['categoriaTurismoConIdiomas' => function($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->orderBy('idiomas_id')->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }])->select('id', 'proveedor_rnt_id',  'telefono', 'sitio_web', 'valor_min', 'valor_max', 'calificacion_legusto')->where('id', $id)->first();
        
        $video_promocional = Proveedor::with(['multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', true)->select('proveedor_id', 'ruta');
        }])->first()->multimediaProveedores;

        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        
        //return ['proveedor' => $proveedor, 'video_promocional' => $video_promocional];
        return view('proveedor.Ver', ['proveedor' => $proveedor, 'video_promocional' => $video_promocional]);
    }
    
    public function postFavorito(Request $request){
        $this->user = \Auth::user();
        $proveedor = Proveedor::find($request->proveedor_id);
        if(!$proveedor){
           return response('Not found.', 404);
        }else{
            if(Proveedor_Favorito::where('usuario_id',$this->user->id)->where('proveedores_id',$proveedor->id)->first() == null){
                Proveedor_Favorito::create([
                    'usuario_id' => $this->user->id,
                    'proveedores_id' => $proveedor->id
                ]);
                return \Redirect::to('/proveedor/ver/'.$proveedor->id)
                        ->with('message', 'Se ha añadido el proveedor a tus favoritos.')
                        ->withInput(); 
            }else{
                Proveedor_Favorito::where('usuario_id',$this->user->id)->where('proveedores_id',$proveedor->id)->delete();
                return \Redirect::to('/proveedor/ver/'.$proveedor->id)
                        ->with('message', 'Se ha quitado el proveedor de tus favoritos.')
                        ->withInput(); 
            }
        }
    }
    
    public function postFavoritoclient(Request $request){
        $this->user = \Auth::user();
        $proveedor = Proveedor::find($request->proveedor_id);
        if(!$proveedor){
           return ["success" => false, "errores" => [["El proveedor seleccionado no se encuentra en el sistema."]] ];
        }else{
            if(Proveedor_Favorito::where('usuario_id',$this->user->id)->where('proveedores_id',$proveedor->id)->first() == null){
                Proveedor_Favorito::create([
                    'usuario_id' => $this->user->id,
                    'proveedores_id' => $proveedor->id
                ]);
                return ["success" => true];
            }else{
                Proveedor_Favorito::where('usuario_id',$this->user->id)->where('proveedores_id',$proveedor->id)->delete();
                return ["success" => true]; 
            }
        }

    }
    
}
