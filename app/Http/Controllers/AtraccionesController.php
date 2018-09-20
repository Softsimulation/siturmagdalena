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
        $atraccion = Atracciones::with(['sitio' => function ($querySitio){
            $querySitio->with(['sitiosConIdiomas' => function ($querySitiosConIdiomas){
                $querySitiosConIdiomas->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }, 'multimediaSitios' => function($queryMultimediaSitios){
                $queryMultimediaSitios->select('sitios_id', 'ruta');
            }])->select('id');
        }, 'atraccionesConIdiomas' => function ($queryAtraccionesConIdiomas){
            $queryAtraccionesConIdiomas->select('atracciones_id', 'idiomas_id'  , 'como_llegar', 'horario', 'periodo', 'recomendaciones', 'reglas');
        }])->where('id', $id)->select('id', 'sitios_id', 'calificacion_legusto')->first();
        
        //return ['atraccion' => $atraccion];
        
        return view('atracciones.Ver', ['atraccion' => $atraccion]);
    }
    
}
