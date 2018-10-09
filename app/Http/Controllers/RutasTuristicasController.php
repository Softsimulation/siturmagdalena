<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Ruta;

class RutasTuristicasController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Ruta::find($id) == null){
            return response('Not found.', 404);
        }
        
        $ruta = Ruta::where('id', $id)->with(['rutasConIdiomas' => function ($queryRutasConIdiomas){
            $queryRutasConIdiomas->orderBy('idioma_id')->select('idioma_id', 'ruta_id', 'nombre', 'descripcion', 'recomendacion');
        }, 'rutasConAtracciones' => function ($queryRutasConAtracciones){
            $queryRutasConAtracciones->with(['sitio' => function($querySitio){
                $querySitio->with(['sitiosConIdiomas' => function($querySitiosConIdiomas){
                    $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre');
                }, 'multimediaSitios' => function($queryMultimediaSitios){
                    $queryMultimediaSitios->select('sitios_id', 'ruta')->orderBy('portada', 'desc')->where('tipo', false);
                }])->select('id');
            }])->select('atracciones.id', 'atracciones.sitios_id');
        }])->select('id', 'portada')->first();
        
        //return ['ruta' => $ruta];
        return view('rutas.Ver', ['ruta' => $ruta]);
    }
}
