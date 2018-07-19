<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Mes_Indicador;
use App\Models\Anio;
use App\Models\Estadisitica_Secundaria;
use App\Models\Valor_serie_tiempo;
use App\Models\Series_estadistica;
use App\Models\Rotulos_estadistica;
use App\Models\Series_estadistica_rotulo;

class EstadisticasSecundariasCtrl extends Controller
{
    
    
    public function getConfiguracion(){
        return View("EstadisticasSecundarias.configuracion");
    }
    
    
    public function getDataconfiguracion(){ 
        return
            [
                "meses"=> Mes_Indicador::get(),
                "anios"=> Anio::get(),
                "data"=> Estadisitica_Secundaria::with([ "series"=>function($q){ $q->with(["valores_tiempo","valores_rotulo"]); } , "rotulos" ])->get()
            ];
    }
    
    
    public function postGuardardata(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "series" => "required|array",
                      "series.*.id" => "required|exists:series_estadisticas,id",
                      "series.*.valores" => "required|array",
                      "series.*.valores.*.rotulo" => "exists:rotulos_estadisticas,id",
                      "series.*.valores.*.anio" => "exists:anios,id",
                      "series.*.valores.*.mes" => "exists:mes_indicador,id",
                    ],
                    [] );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        foreach($request->series as $serie){
            
            foreach($serie['valores'] as $dato){
                if( array_key_exists ( 'valor' , $dato ) ){
                    if( count( $request->rotulos ) == 0 ){
                        Valor_serie_tiempo::updateOrCreate( [ "series_estadistica_id"=> $serie['id'] , "anio_id"=> $dato['anio'] , "mes_indicador_id"=> $dato['mes'] ], 
                                                            [ "valor"=> $dato['valor'] ] );
                    }
                    else
                    if( count( $request->rotulos ) > 0 ){
                        Series_estadistica_rotulo::updateOrCreate( [ "series_estadistica_id"=> $serie['id'] ,"rotulo_estadistica_id"=> $dato['rotulo'] , "anio_id"=> $dato['anio'] ], 
                                                                   [ "valor"=> $dato['valor'] ] );
                    }
                }
            }
            
        }   
        
        return [ "success"=>true ];
    }
    
    
    public function postGuardarindicador(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "nombre" => "required"
                    ],
                    [] );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $indicador = Estadisitica_Secundaria::find($request->id);
        
        if(!$indicador){
            $indicador = new Estadisitica_Secundaria();
            $indicador->user_create = "admin";
            $indicador->estado = true;
        }
        
        $indicador->nombre = $request->nombre;
        $indicador->name   = $request->name;
        $indicador->user_update = "admin";
        $indicador->save();
        
        foreach($request->series as $serie){
            $serieN = Series_estadistica::where([ ["id", (array_key_exists('id', $serie) ? $serie['id'] : -1) ], ["estadisticas_secundaria_id",$indicador->id] ])->first();
            
            if(!$serieN){
                $serieN = new Series_estadistica();
                $serieN->estadisticas_secundaria_id = $indicador->id;
            }
            $serieN->nombre = $serie['nombre'];
            $serieN->name = array_key_exists('name', $serie) ? $serie['name'] : null;
            $serieN->save();
        }   
        
        foreach($request->rotulos as $rotulo){
            
            $rotuloN = Rotulos_estadistica::where([ ["id", (array_key_exists('id', $rotulo) ? $rotulo['id'] : -1) ], ["estadisticas_secundaria_id",$indicador->id] ])->first();
            
            if(!$rotuloN){
                $rotuloN = new Rotulos_estadistica();
                $rotuloN->estadisticas_secundaria_id = $indicador->id;
            }
            $rotuloN->nombre = $rotulo['nombre'];
            $rotuloN->name = array_key_exists('name', $rotulo) ? $rotulo['name'] : null;
            $rotuloN->save();
                                                 
        }  
        
        
        return [ "success"=>true ];
        
    }
    
    
    
    
}
