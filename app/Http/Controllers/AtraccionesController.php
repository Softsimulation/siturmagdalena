<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Models\Atracciones;

class AtraccionesController extends Controller
{
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
            }])->select('id', 'longitud', 'latitud');
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas){
            $queryAtraccionesConIdiomas->orderBy('idiomas_id')->select('atracciones_id', 'idiomas_id'  , 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }])->where('id', $id)->select('id', 'sitios_id', 'calificacion_legusto')->first();
        
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
    
}
