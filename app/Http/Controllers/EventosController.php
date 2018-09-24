<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Evento;

class EventosController extends Controller
{
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
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }])->select('sitios.id');
        }])->select('id', 'tipo_eventos_id', 'telefono', 'web', 'fecha_in', 'fecha_fin', 'valor_min', 'valor_max')->first();
        
        $video_promocional = Evento::where('id', $id)->with(['multimediaEventos' => function ($queryMultimediaEventos){
            $queryMultimediaEventos->where('tipo', true)->select('eventos_id', 'ruta');
        }])->first()->multimediaEventos[0]->ruta;
        
        //return ['evento' => $evento, 'video_promocional' => $video_promocional];
        return view('eventos.Ver', ['evento' => $evento, 'video_promocional' => $video_promocional]);
    }
}
