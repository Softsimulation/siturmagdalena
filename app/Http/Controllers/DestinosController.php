<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Models\Destino;
use App\Models\Municipio;
use App\Models\Proveedores_rnt;
use App\Models\Atracciones;
use App\Models\Actividades;

class DestinosController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Destino::find($id) == null){
            return response('Not found.', 404);
        }
        
        $idioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $destino = Destino::where('id', $id)->with(['tipoDestino' => function ($queryTipoDestino){
            $queryTipoDestino->with(['tipoDestinoConIdiomas' => function($queryTipoDestinoConIdiomas){
                $queryTipoDestinoConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'tipo_destino_id', 'nombre');
            }])->select('id');
        }, 'destinoConIdiomas' => function($queryDestinoConIdiomas){
            $queryDestinoConIdiomas->orderBy('idiomas_id')->select('destino_id', 'idiomas_id', 'nombre', 'descripcion','informacion_practica', 'reglas', 'como_llegar');
        }, 'multimediaDestinos' => function ($queryMultimediaDestinos){
            $queryMultimediaDestinos->where('tipo', false)->orderBy('portada', 'desc')->select('destino_id', 'ruta');
        }, 'sectores' => function($querySectores){
            $querySectores->with(['sectoresConIdiomas' => function($querySectoresConIdiomas){
                $querySectoresConIdiomas->select('idiomas_id', 'sectores_id', 'nombre');
            },'sitios' => function($sitios){
                $sitios->with(['atracciones' => function($actividades){
                    $actividades->with(['multimedia' => function($multimedia){
                        $multimedia->where('portada',true);
                    },'langContent']);
                },'actividades' => function($actividades){
                    $actividades->with(['multimedia' => function($multimedia){
                        $multimedia->where('portada',true);
                    },'langContent']);
                }]);
            }])->select('id', 'destino_id', 'es_urbano');
        }])->select('id', 'tipo_destino_id', 'latitud', 'longitud', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria')->first();
        
        $atracciones = Atracciones::with(['sitio' => function($sitio) {
            $sitio->with(['sector' => function($sector){
                $sector->with('destino');
            }]);
        },'multimedia' => function($multimedia){
            $multimedia->where('portada', true);
        },'langContent' => function($langContent) use ($idioma){
            $langContent->where('idiomas_id', $idioma);
        }])->wherehas('sitio.sector.destino', function($q) use ($destino){
            $q->where('id', $destino->id);
        })->take(6)->get();
        
        
        $actividades = Actividades::with(['sitiosConActividades' => function($sitiosConActividades) {
            $sitiosConActividades->with(['sector' => function($sector){
                    $sector->with('destino');
                }]);
        },'multimedia' => function($multimedia){
            $multimedia->where('portada', true);
        }, 'langContent' => function($langContent) use ($idioma){
            $langContent->where('idiomas', $idioma);
        }])->wherehas('sitiosConActividades.sector.destino', function($q) use ($destino){
            $q->where('id', $destino->id);
        })->take(6)->get();
        
        
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
        return view('destinos.Ver', ['destino' => $destino, 'video_promocional' => $video_promocional, 'pst' => $pst, 'proveedores' => $proveedores, 'atracciones' => $atracciones, 'actividades' => $actividades]);
    }
}
