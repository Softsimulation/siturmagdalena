<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Models\Atracciones;
use App\Models\Atraccion_Favorita;

class AtraccionesController extends Controller
{
    
    public function __construct()
    {
        
        $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
        $this->user = \Auth::user();
    }
    
    //
    
    public function getIndex (){
        $atracciones = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }, 'multimediaSitios' => function ($queryMultimediaSitios){
                $queryMultimediaSitios->where('portada', true)->select('sitios_id', 'ruta');
            }])->select('id', 'latitud', 'longitud', 'direccion');
        }])->select('id', 'sitios_id', 'calificacion_legusto')->get();
        
        $destinos = DB::table('destino_con_idiomas')
                        ->join('')->select()->get();
        
        
        
        return view('atracciones.Index', ['atracciones' => $atracciones, 'destinos' => $destinos]);
    }
    
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Atracciones::find($id) == null){
            return response('Not found.', 404);
        }
        
        $atraccion = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }, 'multimediaSitios' => function($queryMultimediaSitios){
                $queryMultimediaSitios->select('sitios_id', 'ruta')->orderBy('portada', 'desc')->where('tipo', false);
            }, 'sitiosConActividades' => function ($querySitiosConActividades){
                $querySitiosConActividades->with(['actividadesConIdiomas' => function($queryActividadesConIdiomas){
                    $queryActividadesConIdiomas->select('actividades_id', 'idiomas', 'nombre');
                }, 'multimediasActividades' => function($queryMultimediasActividades){
                    $queryMultimediasActividades->where('portada', true)->select('actividades_id', 'ruta');
                }])->select('actividades.id');
            }])->select('id', 'longitud', 'latitud', 'direccion');
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas){
            $queryAtraccionesConIdiomas->orderBy('idiomas_id')->select('atracciones_id', 'idiomas_id'  , 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }, 'atraccionesConTipos' => function ($queryAtraccionesConTipos){
            $queryAtraccionesConTipos->with(['tipoAtraccionesConIdiomas' => function ($queryTipoAtraccionesConIdiomas){
                $queryTipoAtraccionesConIdiomas->select('idiomas_id', 'tipo_atracciones_id', 'nombre');
            }])->select('tipo_atracciones.id');
        }, 'categoriaTurismoConAtracciones' => function($queryCategoriaTurismoConAtracciones){
            $queryCategoriaTurismoConAtracciones->with(['categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }, 'perfilesUsuariosConAtracciones' => function ($queryPerfilesUsuariosConAtracciones){
            $queryPerfilesUsuariosConAtracciones->with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdiomas){
                $queryPerfilesUsuariosConIdiomas->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }])->where('id', $id)->select('id', 'sitios_id', 'calificacion_legusto', 'calificacion_recomendar', 'calificacion_volveria', 'sitio_web')->first();
        
        $video_promocional = Atracciones::where('id', $id)->with(['sitio' => function($querySitio){
            $querySitio->with(['multimediaSitios' => function ($queryMultimediaSitios){
                $queryMultimediaSitios->where('tipo', true);
            }]);
        }])->first()->sitio->multimediaSitios;
        
        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        
        //return ['atraccion' => $atraccion, 'video_promocional' => $video_promocional];
        
        return view('atracciones.Ver', ['atraccion' => $atraccion, 'video_promocional' => $video_promocional]);
    }
    
    
    public function postFavorito(Request $request){
        $this->user = \Auth::user();
        $atraccion = Atracciones::find($request->atraccion_id);
        if(!$atraccion){
            return response('Not found.', 404);
        }else{
            if(Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->first() == null){
                Atraccion_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'atracciones_id' => $atraccion->id
                ]);
                return \Redirect::to('/atracciones/ver/'.$atraccion->id)
                        ->with('message', 'Se ha añadido la atracción a tus favoritos.')
                        ->withInput(); 
            }else{
                Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->delete();
                return \Redirect::to('/atracciones/ver/'.$atraccion->id)
                        ->with('message', 'Se ha quitado la atracción a tus favoritos.')
                        ->withInput(); 
            }
        }
    }
    
    public function postFavoritoclient(Request $request){
        $this->user = \Auth::user();
        $atraccion = Atracciones::find($request->atraccion_id);
        if(!$atraccion){
            return ["success" => false, "errores" => [["La atracción seleccionada no se encuentra en el sistema."]] ];
        }else{
            if(Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->first() == null){
                Atraccion_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'atracciones_id' => $atraccion->id
                ]);
                return ["success" => true]; 
            }else{
                Atraccion_Favorita::where('usuario_id',$this->user->id)->where('atracciones_id',$atraccion->id)->delete();
                return ["success" => true]; 
            }
        }
    }
    
    
   public function postGuardarcomentario(Request $request){
	   
	   return $request;
	   
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:atracciones,id',
            'calificacionFueFacilLlegar' => 'required|numeric|min:1|max:5',
            'calificacionLeGusto' => 'required|numeric|min:1|max:5',
            'calificacionRegresaria' => 'required|numeric|min:1|max:5',
            'calificacionRecomendaria' => 'required|numeric|min:1|max:5',
            'comentario' => 'required|string',
        ],[
            'comentario.string' => 'El comentario  debe ser de tipo string.',
            'id.exists' => 'No se encontro la actividad',
            'calificacionFueFacilLlegar.min' => 'la calificacion fue facil llegar debe ser mínimo de 1.',
            'calificacionFueFacilLlegar.max' => 'la calificacion fue facil llegar debe ser maximo de 5.',
            'calificacionRegresaria.min' => 'la calificacion regresaria debe ser mínimo de 1.',
            'calificacionRegresaria.max' => 'la calificacion regresaria debe ser maximo de 5.',
            'calificacionRecomendaria.min' => 'la calificacion recomendaria debe ser mínimo de 1.',
            'calificacionRecomendaria.max' => 'la calificacion recomendaria debe ser maximo de 5.',
            ]
        );
        
        if($validator->fails()){
           return redirect('atracciones/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        
        if($this->user == null){
            return redirect('atracciones/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        
        $comentario = new Comentario_Atraccion();
        $comentario->atraccion_id = $request->id;
        $comentario->user_id = $this->user->id;
        $comentario->comentario = $request->comentario;
        $comentario->llegar = $request->calificacionFueFacilLlegar;
        $comentario->recomendar = $request->calificacionRecomendaria;
        $comentario->volveria = $request->calificacionRegresaria;
        $comentario->le_gusto = $request->calificacionLeGusto;
        $comentario->fecha = date("Y/m/d-H:i:s");
        
        
        $atraccion = Atracciones::where('id',$request->id)->first();
        $atraccion->calificacion_legusto = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('le_gusto');
        $atraccion->calificacion_llegar = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('llegar'); 
        $atraccion->calificacion_recomendar = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('recomendar'); 
        $atraccion->calificacion_volveria = Comentario_Atraccion::where('atraccion_id',$request->id)->avg('volveria'); 
        $atraccion->save();
        $comentario->save();
        return redirect('atracciones/ver/'.$request->id)->with('success','Comentario guardado correctamente');
    }
}
