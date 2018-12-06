<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Actividad;
use App\Models\Actividad_Favorita;
use App\Models\Comentario_Actividad;
use Carbon\Carbon;

class ActividadesController extends Controller
{
    
    public function __construct()
    {
        
        $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
        $this->user = \Auth::user();
    }
    
    //
    public function getVer($id){
        
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        
        $idioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $actividad = Actividad::with(['comentariosActividads'=> function ($queryComentario){
            $queryComentario->orderBy('fecha', 'DESC')->with(['user']);
        },
            'actividadesConIdiomas' => function ($queryActividadesConIdiomas) use ($idioma){
            $queryActividadesConIdiomas->where('idiomas', $idioma)->select('actividades_id', 'idiomas', 'nombre', 'descripcion')->get();
        }, 'multimediasActividades' => function($queryMultimediasActividades){
            $queryMultimediasActividades->orderBy('portada', 'desc')->select('actividades_id', 'ruta');
        }, 'sitiosConActividades' => function ($querySitiosConActividades) use ($idioma){
            $querySitiosConActividades->with(['sitiosConIdiomas' => function($querySitiosConIdiomas) use ($idioma){
                $querySitiosConIdiomas->where('idiomas_id', $idioma)->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }])->select('sitios.id', 'sitios.latitud', 'sitios.longitud');
        }, 'perfilesUsuariosConActividades' => function ($queryPerfilesUsuariosConActividades) use ($idioma){
            $queryPerfilesUsuariosConActividades->with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdiomas) use ($idioma){
                $queryPerfilesUsuariosConIdiomas->where('idiomas_id', $idioma)->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }, 'categoriaTurismoConActividades' => function($queryCategoriaTurismoConActividades) use ($idioma){
            $queryCategoriaTurismoConActividades->with(['categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas) use ($idioma){
                $queryCategoriaTurismoConIdiomas->where('idiomas_id', $idioma)->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }])->where('id', $id)->select('id', 'valor_min', 'valor_max', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria')->first();
        
       
        //return ['actividad' => $actividad];
        return view('actividades.Ver', ['actividad' => $actividad]);
    }
    
    public function postFavorito(Request $request){
        $this->user = \Auth::user();
        $actividad = Actividad::find($request->actividad_id);
        if(!$actividad){
            return response('Not found.', 404);
        }else{
            if(Actividad_Favorita::where('usuario_id',$this->user->id)->where('actividades_id',$actividad->id)->first() == null){
                Actividad_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'actividades_id' => $actividad->id
                ]);
                return \Redirect::to('/actividades/ver/'.$actividad->id)
                        ->with('message', 'Se ha añadido la actividad a tus favoritos.')
                        ->withInput(); 
            }else{
                Actividad_Favorita::where('usuario_id',$this->user->id)->where('actividades_id',$actividad->id)->delete();
                return \Redirect::to('/actividades/ver/'.$actividad->id)
                        ->with('message', 'Se ha quitado la actividad de tus favoritos.')
                        ->withInput(); 
            }
        }
    }
    
    public function postFavoritoclient(Request $request){
        $this->user = \Auth::user();
        $actividad = Actividad::find($request->actividad_id);
        if(!$actividad){
            return ["success" => false, "errores" => [["La actividad seleccionada no se encuentra en el sistema."]] ];
        }else{
            if(Actividad_Favorita::where('usuario_id',$this->user->id)->where('actividades_id',$actividad->id)->first() == null){
                Actividad_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'actividades_id' => $actividad->id
                ]);
                return ["success" => true];
            }else{
                Actividad_Favorita::where('usuario_id',$this->user->id)->where('actividades_id',$actividad->id)->delete();
                return ["success" => true];
            }
        }
    }
    
     public function postGuardarcomentario(Request $request){
	   
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:actividades,id',
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
           return redirect('actividades/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
          if($this->user == null){
            return redirect('actividades/ver/'.$request->id)->with('error','No se pudo guardar el comentario');
            
        }
        
        $comentario = new Comentario_Actividad();
        $comentario->actividad_id = $request->id;
        $comentario->user_id = $this->user->id;
        $comentario->comentario = $request->comentario;
        $comentario->llegar = $request->calificacionFueFacilLlegar;
        $comentario->recomendar = $request->calificacionRecomendaria;
        $comentario->volveria = $request->calificacionRegresaria;
        $comentario->le_gusto = $request->calificacionLeGusto;
        $comentario->fecha = Carbon::now();
        $comentario->save();
        
        $actividad = Actividad::where('id',$request->id)->first();
        $actividad->calificacion_legusto = Comentario_Actividad::where('actividad_id',$request->id)->avg('le_gusto');
        $actividad->calificacion_llegar = Comentario_Actividad::where('actividad_id',$request->id)->avg('llegar'); 
        $actividad->calificacion_recomendar = Comentario_Actividad::where('actividad_id',$request->id)->avg('recomendar'); 
        $actividad->calificacion_volveria = Comentario_Actividad::where('actividad_id',$request->id)->avg('volveria'); 
        $actividad->save();
        
        return redirect('actividades/ver/'.$request->id)->with('success','Comentario guardado correctamente');
    }

    
}
