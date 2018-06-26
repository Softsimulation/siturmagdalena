<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class IndicadoresCtrl extends Controller
{
    
    //////////////////////////////////////////////////////
    
    public function getReceptor(){
        return View("indicadores.receptor");
    }
    
    public function getDatareceptor(){
        $data = [
               "periodos"=> [2001,2002,2003,2004,2005],
               "graficas"=> [ ["id"=>1, "tipo"=>"line", "nombre"=>"Líneas", "icono"=>"show_chart" ], ["id"=>1, "tipo"=>"bar", "nombre"=>"Columnas", "icono"=>"bar_chart" ] ]
            ];
            
        return $data;
    }
    
   ///////////////////////////////////////////////////// 
}
