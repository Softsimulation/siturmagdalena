<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Models\Destino;
use App\Models\Municipio;
use App\Models\Proveedores_rnt;

class DestinosController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        
        $destino = Destino::where('id', $id)->with(['tipoDestino' => function ($queryTipoDestino){
            $queryTipoDestino->with(['tipoDestinoConIdiomas' => function($queryTipoDestinoConIdiomas){
                $queryTipoDestinoConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'tipo_destino_id', 'nombre');
            }])->select('id');
        }, 'destinoConIdiomas' => function($queryDestinoConIdiomas){
            $queryDestinoConIdiomas->orderBy('idiomas_id')->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
        }, 'multimediaDestinos' => function ($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('tipo', false)->orderBy('portada', 'desc')->select('destino_id', 'ruta');
        }, 'sectores' => function($querySectores){
            $querySectores->with(['sectoresConIdiomas' => function($querySectoresConIdiomas){
                $querySectoresConIdiomas->select('idiomas_id', 'sectores_id', 'nombre');
            }])->select('id', 'destino_id', 'es_urbano');
        }])->select('id', 'tipo_destino_id', 'latitud', 'longitud', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria')->first();
        
        $idMunicipio = Municipio::where('nombre', $destino->destinoConIdiomas[0]->nombre)->pluck('id')->first();
        
        $pst = Proveedores_rnt::where('municipio_id', $idMunicipio)->select('id', 'razon_social', 'latitud', 'longitud')->get();
        
        //return ['detinos' => $pst];
        
        $proveedores = Proveedores_rnt::select(DB::raw('proveedores_rnt.id AS id, proveedores_rnt.razon_social AS razon_social, proveedores_rnt.latitud AS latitud
        , proveedores_rnt.longitud AS longitud, proveedores_rnt.telefono AS telefono, proveedores_rnt.celular AS celular, proveedores_rnt.email AS email'))
        ->join('municipios', 'municipios.id', '=', 'proveedores_rnt.municipio_id')
        ->where('municipios.nombre', $destino->destinoConIdiomas[0]->nombre)->get();
        
        
        $video_promocional = Destino::where('id', $id)->with(['multimediaDestinos' => function($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('tipo', true);
        }])->first()->multimediaDestinos;
        
        if (count($video_promocional) > 0){
            $video_promocional = $video_promocional[0]->ruta;
        }else {
            $video_promocional = null;
        }
        
        //return ['proveedores' => $proveedores];
        //return ['destino' => $destino, 'video_promocional' => $video_promocional];
        return view('destinos.Ver', ['destino' => $destino, 'video_promocional' => $video_promocional, 'pst' => $pst, 'proveedores' => $proveedores]);
    }
}
