<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Evento;
use App\Models\Evento_Favorita;

class EventosController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth',["only"=>["postFavorito","postFavoritoclient"]]);
        // $this->user = \Auth::user();
    }
    
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Evento::find($id) == null){
            return response('Not found.', 404);
        }
        
        $evento = Evento::where('id', $id)->with(['eventosConIdiomas' => function ($queryEventosConIdiomas){
            $queryEventosConIdiomas->orderBy('idiomas_id')->select('eventos_id', 'idiomas_id', 'nombre', 'descripcion', 'horario', 'edicion');
        }, 'tipoEvento' => function ($queryTipoEvento){
            $queryTipoEvento->with(['tipoEventosConIdiomas' => function ($queryTipoEventosConIdiomas){
                $queryTipoEventosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'tipo_evento_id', 'nombre');
            }])->select('id');
        }, 'multimediaEventos' => function ($queryMultimediaEventos){
            $queryMultimediaEventos->where('tipo', false)->orderBy('portada', 'desc')->select('eventos_id', 'ruta');
        }, 'sitiosConEventos' =>function ($querySitiosConEventos){
            $querySitiosConEventos->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'sitios_id', 'nombre');
            }, 'multimediaSitios' => function($queryMultimediaSitios){
                $queryMultimediaSitios->select('sitios_id', 'ruta')->orderBy('portada', 'desc')->where('tipo', false);
            }])->select('sitios.id');
        }, 'perfilesUsuariosConEventos' => function ($queryPerfilesUsuariosConEventos){
            $queryPerfilesUsuariosConEventos->with(['perfilesUsuariosConIdiomas' => function ($queryPerfilesUsuariosConIdiomas){
                $queryPerfilesUsuariosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }, 'categoriaTurismoConEventos' => function ($queryCategoriaTurismoConEventos){
            $queryCategoriaTurismoConEventos->with(['categoriaTurismoConIdiomas' => function($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->orderBy('idiomas_id')->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }])->select('id', 'tipo_eventos_id', 'telefono', 'web', 'fecha_in', 'fecha_fin', 'valor_min', 'valor_max')->first();
        
        $video_promocional = Evento::where('id', $id)->with(['multimediaEventos' => function ($queryMultimediaEventos){
            $queryMultimediaEventos->where('tipo', true)->select('eventos_id', 'ruta');
        }])->first()->multimediaEventos;
        
        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        
        //return ['evento' => $evento, 'video_promocional' => $video_promocional];
        return view('eventos.Ver', ['evento' => $evento, 'video_promocional' => $video_promocional]);
    }
    
    public function postFavorito(Request $request){
        $this->user = \Auth::user();
        $evento = Evento::find($request->evento_id);
        if(!$evento){
            return response('Not found.', 404);
        }else{
            if(Evento_Favorita::where('usuario_id',$this->user->id)->where('eventos_id',$evento->id)->first() == null){
                Evento_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'eventos_id' => $evento->id
                ]);
                return \Redirect::to('/eventos/ver/'.$evento->id)
                        ->with('message', 'Se ha añadido el evento a tus favoritos.')
                        ->withInput(); 
            }else{
                Evento_Favorita::where('usuario_id',$this->user->id)->where('eventos_id',$evento->id)->delete();
                return \Redirect::to('/eventos/ver/'.$evento->id)
                        ->with('message', 'Se ha quitado el evento de tus favoritos.')
                        ->withInput(); 
            }
        }
    }
    
    public function postFavoritoclient(Request $request){
        $this->user = \Auth::user();
        $evento = Evento::find($request->evento_id);
        if(!$evento){
            return ["success" => false, "errores" => [["El evento seleccionado no se encuentra en el sistema."]] ];
        }else{
            if(Evento_Favorita::where('usuario_id',$this->user->id)->where('eventos_id',$evento->id)->first() == null){
                Evento_Favorita::create([
                    'usuario_id' => $this->user->id,
                    'eventos_id' => $evento->id
                ]);
                return ["success" => true];
            }else{
                Evento_Favorita::where('usuario_id',$this->user->id)->where('eventos_id',$evento->id)->delete();
                return ["success" => true];
            }
        }
    }
    
}
