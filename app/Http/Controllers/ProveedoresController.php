<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests;
use App\Models\Proveedor;
use App\Models\Comentario_Proveedor;
use Carbon\Carbon;
use App\Models\Proveedor_Favorito;
class ProveedoresController extends Controller
{
  
    public function __construct()
	{
	    $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
	}
	
	public function getIndex(){
	    $idioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        $proveedores = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt) use ($idioma){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma) use ($idioma){
                $queyProveedor_rnt_idioma->where('idioma_id', $idioma)->select('proveedor_rnt_id', 'idioma_id', 'descripcion', 'nombre')->orderBy('idioma_id');
            }])->select('id', 'razon_social');
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', false)->orderBy('portada', 'desc')->select('proveedor_id', 'ruta');
        }])->select('id', 'valor_min', 'valor_max', 'calificacion_legusto', 'proveedor_rnt_id')->where('estado', true)->get();
        
        return view('proveedor.Index', ['proveedores' => $proveedores]);
	}
	
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Proveedor::find($id) == null){
            return response('Not found.', 404);
        }
        
        $idioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $proveedor = Proveedor::with(['comentariosProveedores'=> function ($queryComentario){
            $queryComentario->orderBy('fecha', 'DESC')->with(['user']);
        },'proveedorRnt' => function ($queryProveedorRnt) use ($idioma){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma) use ($idioma){
                $queyProveedor_rnt_idioma->where('idioma_id', $idioma)->select('proveedor_rnt_id', 'idioma_id', 'descripcion')->orderBy('idioma_id');
            }])->select('id', 'razon_social');
        }, 'proveedoresConIdiomas' => function ($queryProveedoresConIdiomas) use ($idioma){
            $queryProveedoresConIdiomas->select('idiomas_id', 'proveedores_id', 'horario')->where('idiomas_id', $idioma);
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', false)->orderBy('portada', 'desc')->select('proveedor_id', 'ruta');
        }, 'actividadesProveedores' => function ($queryActividadesProveedores) use ($idioma){
            $queryActividadesProveedores->with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas) use ($idioma){
                $queryActividadesConIdiomas->where('idiomas', $idioma)->select('actividades_id', 'idiomas', 'nombre');
            }])->select('actividades.id');
        }, 'perfilesUsuariosConProveedores' => function($queryPerfilesUsuariosConProveedores) use ($idioma){
            $queryPerfilesUsuariosConProveedores->with(['perfilesUsuariosConIdiomas' => function ($queryPerfilesUsuariosConIdiomas) use ($idioma){
                $queryPerfilesUsuariosConIdiomas->where('idiomas_id', $idioma)->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }, 'categoriaTurismoConProveedores' => function($queryCategoriaTurismoConProveedores) use ($idioma){
            $queryCategoriaTurismoConProveedores->with(['categoriaTurismoConIdiomas' => function($queryCategoriaTurismoConIdiomas) use ($idioma){
                $queryCategoriaTurismoConIdiomas->where('idiomas_id')->select('categoria_turismo_id', 'idiomas_id', 'nombre');
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
    
    public function postGuardarcomentario(Request $request){
	   
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:proveedores,id',

            'calificacionLeGusto' => 'required|numeric|min:1|max:5',

            'comentario' => 'required|string',
        ],[
            'comentario.string' => 'El comentario  debe ser de tipo string.',
            'id.exists' => 'No se encontro la actividad',
        
            ]
        );
        
        if($validator->fails()){
           return redirect('proveedor/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        
        if($this->user == null){
            return redirect('proveedor/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        $comentario = new Comentario_Proveedor();
        $comentario->proveedores_id = $request->id;
        $comentario->user_id = $this->user->id;
        $comentario->comentario = $request->comentario;
        $comentario->le_gusto = $request->calificacionLeGusto;
        $comentario->fecha = Carbon::now();
        $comentario->save();
        $proveedor = Proveedor::where('id',$request->id)->first();
        $proveedor->calificacion_legusto = Comentario_Proveedor::where('proveedores_id',$request->id)->avg('le_gusto');
        $proveedor->save();
        
        return redirect('proveedor/ver/'.$request->id)->with('success','Comentario guardado correctamente');
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
