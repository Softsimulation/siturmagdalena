<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Encuesta;
use App\Models\Mes_Anio;
use App\Models\Anio;
use App\Models\Mes;

class OfertaEmpleoController extends Controller
{
    //
    
    
    public function getCrearEncuesta(){
        return view('ofertaempleo.CrearEncuesta');
    }
    
    public function getEncuestaspendientes($id){
        
       
        $meses = array();
        $pendientes = array();
        for($i = 1;$i<=11;$i++){
            $now = Carbon::now();
            $copy  = $now->addMonth(-$i);
            array_push($meses,$copy);
        }
        
        foreach($meses as $me){
            $nombreMes = Mes::find($me->month);
            $anio = Anio::where('anio',$me->year)->get();
            if($anio == null){
                 array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
            }else{
                $meses_anio = Mes_Anio::where('mes_id',$me->month)->whereHas('anio',function($q) use ($me){
                    $q->where('anio',$me->year);
                })->first();
                 
                if($meses_anio == null){
                      array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                }else{
                    
                    $encuesta = Encuesta::where('sitios_para_encuestas_id',$id)->get();
                    if($encuesta==null){
                        array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                    }
                }
                
            }
            
            
        }
        
        return ["mes"=>$pendientes];

    }
    
    
}
