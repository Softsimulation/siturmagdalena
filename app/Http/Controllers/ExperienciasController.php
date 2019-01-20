<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

use App\Models\Idioma;

class ExperienciasController extends Controller
{
    public function getIndex(Request $request){
        return view('experiencias.index', ['destinos' => $this->getDestinos()]);
    }
    
    public function getDestinos(){
        // $arr = '{[
        //     {
        //         "id": 1,
        //         "nombre": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tristique dui maximus libero cursus pulvinar. Aenean sagittis, ex et volutpat posuere.",
        //         "tipoEntidad": 1,
        //         "tipoExperiencia": 1,
        //         "imagen": "http://lorempixel.com/output/sports-q-c-1366-768-8.jpg",
        //         "calificacion_legusto": 3.5
        //     },
        //     {
        //         "id": 2,
        //         "nombre": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean tristique dui maximus libero cursus pulvinar. Aenean sagittis, ex et volutpat posuere.",
        //         "tipoEntidad": 1,
        //         "tipoExperiencia": 1,
        //         "imagen": "http://lorempixel.com/output/sports-q-c-1366-768-8.jpg",
        //         "calificacion_legusto": 4.5
        //     }
        // ]}'; 
        $arr = "hola";
        return json_decode($arr);
    }
}