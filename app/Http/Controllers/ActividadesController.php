<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Actividades;

class ActividadesController extends Controller
{
    //
    public function getVer($id){
        $actividad = Actividades::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->orderBy('idiomas')->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }, 'multimediasActividades' => function($queryMultimediasActividades){
            $queryMultimediasActividades->orderBy('portada', 'desc')->select('actividades_id', 'ruta');
        }])->where('id', $id)->select('id', 'valor_min', 'valor_max')->first();
        
        return view('actividades.Ver', ['actividad' => $actividad]);
    }
}
