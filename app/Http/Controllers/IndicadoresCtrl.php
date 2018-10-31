<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;

use DB;


use App\Models\Indicadores_medicion;
use App\Models\Estadisitica_Secundaria;
use App\Models\Valor_serie_tiempo;
use App\Models\Series_estadistica;
use App\Models\Rotulos_estadistica;
use App\Models\Series_estadistica_rotulo;

class IndicadoresCtrl extends Controller
{
    
    //////////////////////////////////////////////////////
    
    public function getReceptor(){  
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(1) ] );
    }
    
    public function getInterno(){ 
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(2) ] );
    }
    
    public function getEmisor(){ 
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(3) ] );
    }
    
    public function getOferta(){ 
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(4) ] );
    }
    
    private function getDataIndicadoresMedicion($indicador){ 
        $idioma = 1;
        return  Indicadores_medicion::where("tipo_medicion_indicador_id",$indicador)
                                    ->with([ "idiomas"=>function($q) use($idioma){ $q->where("idioma_id", $idioma); } ])
                                    ->orderBy('peso', 'asc')->get();
    }
    
    
    public function getSecundarios(){
        $data = Estadisitica_Secundaria::where([ ["estado",true], ["es_visible",true] ])->get();
        return View("indicadores.estadisticasSecundarios", [ "indicadores"=> $data ] );
    }
    
    public function getDatasencundarios($id){
    
        $idioma = 1;
        
        $estadistica = null;
        if($idioma == 1){
            $estadistica = Estadisitica_Secundaria::where("id",$id)->with("graficas")->select("id","nombre" ,"label_x" ,"label_y" )->first();
        }
        else{
            $estadistica = Estadisitica_Secundaria::where("id",$id)->with("graficas")-select("id","name as nombre" ,"label_x_en as label_x" ,"label_y_en as label_y" )->first();
        }
        
        
        if($estadistica){
            $years = null;
            if( count( $estadistica->rotulos ) > 0 ){
                $years = Rotulos_estadistica::join("series_estadistica_rotulos","rotulos_estadisticas.id","=","rotulo_estadistica_id")
                                            ->join("anios","anios.id","=","anio_id")
                                            ->where("estadisticas_secundaria_id",$estadistica->id)
                                            ->distinct()->get([ "anios.id","anios.anio" ]);
            }
            else{
                $years = Series_estadistica::join("valor_series_tiempo","series_estadisticas.id","=","series_estadistica_id")
                                           ->join("anios","anios.id","=","anio_id")
                                           ->where("estadisticas_secundaria_id",$estadistica->id)
                                           ->distinct()->get([ "anios.id","anios.anio" ]);
            }
            
            return [ "periodos"=> $years, "indicador"=>$estadistica ,"data"=> count($years)>0 ? $this->getFiltrardatasecundaria($id,$years[0]->id) : []  ];
        }
        
    }
    
    public function getFiltrardatasecundaria($id,$year){
        
        
        $estadistica = Estadisitica_Secundaria::find($id);
        
        if($estadistica){
            
            $idioma = 1;
            $datos = [];
            $labels = [];
            
            if( count( $estadistica->rotulos ) > 0 ){
                
                foreach($estadistica->series as $serie){
                    $dt = [];
                    foreach($estadistica->rotulos as $rotulo){                         
                        $dato = Series_estadistica_rotulo::where([ ["series_estadistica_id",$serie->id] , ["rotulo_estadistica_id",$rotulo->id], ["anio_id",$year]  ])->pluck("valor")->first();
                        array_push( $dt, $dato );
                    }
                    array_push($datos,$dt); 
                }
                
                $labels = $idioma==1 ? $estadistica->rotulos->lists('nombre')->toArray() : $estadistica->rotulos->lists('name')->toArray();
            }
            else{
                
                foreach($estadistica->series as $serie){
                    
                    $meses = Valor_serie_tiempo::join("mes_indicador","mes_indicador.id","=","mes_indicador_id")
                                               ->where([ ["series_estadistica_id",$serie->id], ["anio_id",$year] ])->distinct()->get(["mes_indicador.*"]);
                
                    $dt = [];
                    foreach($meses as $mes){                         
                        $dato = Valor_serie_tiempo::where([ ["series_estadistica_id",$serie->id], ["mes_indicador_id",$mes->id], ["anio_id",$year]  ])->pluck("valor")->first();
                        array_push($dt,$dato); 
                    }
                    
                    array_push($datos,$dt); 
                    $labels = $strMes = $idioma==1? $meses->lists('nombre')->toArray() : $meses->lists('name')->toArray();
                }
                
            }
            
            return [
                "labels"=> $labels,
                "data"=>   $datos,
                "series"=> $idioma==1 ? $estadistica->series->lists('nombre')->toArray()  : $estadistica->series->lists('name')->toArray(),
            ];
        }
        
    }
    
    /////////////////////////////////////////////////////
    
    public function getDataindicador($id){
        $idioma = 1;
        $cultura = "es";
        $periodos = [];
        $data = [];
        
        switch($id){
            
            case 1:  /// indicador motivo principal del viaje de turismo recptor
                $periodos = DB::select("SELECT *from tiempo_motivos(?)", array($cultura) );
                $data = $this->MotivoPrincipalViajeReceptor($periodos[0],$cultura);
                break;
                
            case 2:  /// indicador tipo alojamiento utilizado de turismo recptor
                $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?)", array($cultura) );
                $data = $this->TipoAlojamientoUtilizadoReceptor($periodos[0],$cultura);
                break;
            
            case 3:  /// indicador  medios de transporte utilizado de turismo recptor
                $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?)", array($cultura) );
                $data = $this->MedioTransporteReceptor($periodos[0],$cultura);
                break;
                
            case 4:  /// indicador  gasto medio de turismo recptor
                $periodos = DB::select("SELECT *from tiempo_gasto_medio_receptor(?)", array($cultura) );
                $data = $this->GastoMedioReceptor($periodos[0],$cultura);
                break;
                
            case 5:  /// indicador  gasto medio por bienes o servicios utilizado de turismo recptor
                $periodos = DB::select("SELECT id, year from tiempo_gasto_medio_rubro_receptor(?)", array($cultura) );
                $data = $this->GastoMedioBienesServiciosReceptor( $periodos[0] ,$cultura);
                break;
                
            case 6:  /// indicador duración media de la estancia de turismo recptor
                $periodos = DB::select("SELECT id, year from tiempo_duracion_media_receptor(?)", array($cultura) );
                $data = $this->DuracionMediaEstanciaReceptor($periodos[0],$cultura);
                break;
                
            case 7:  /// indicador tamaño medio de grupos de viaje de turismo recptor
                $periodos = DB::select("SELECT id, year from tiempo_tamanio_grupo_viaje(?)", array($cultura) );
                $data = $this->TamanoMedioGrupoViajeReceptor($periodos[0],$cultura);
                break;
                
            default: break;
        }
        
        return  [
                "periodos"=> $periodos,
                "indicador"=> Indicadores_medicion::where([ ["tipo_medicion_indicador_id",1], ["id",$id] ])
                                                  ->with([ 
                                                            "idiomas"=>function($q) use($idioma){ $q->where("idioma_id", $idioma)->select("id","indicadores_medicion_id","nombre","eje_x","eje_y"); }, 
                                                            "graficas"=>function($q){ $q->select("id","nombre","icono","codigo"); }
                                                        ])->first(),
                "data"=> $data
            ];
            
    }
    
    
    public function postFiltrardataindicador(Request $request){
        
        $data = null;
        $idioma = "es";
        switch($request->indicador){
            
            case 1:  /// indicador motivo principal del viaje de turismo recptor
                $data = $this->MotivoPrincipalViajeReceptor($request,$idioma);
                break;
                
            case 2:  /// indicador tipo alojamiento utilizado de turismo recptor
                $data = $this->TipoAlojamientoUtilizadoReceptor($request,$idioma);
                break;
                
            case 3:  /// indicador tipo alojamiento utilizado de turismo recptor
                $data = $this->MedioTransporteReceptor($request,$idioma);
                break;
                
            case 4:  /// indicador gasto medio de turismo recptor
                $data = $this->GastoMedioReceptor($request,$idioma);
                break;
            
            case 5:  /// indicador gasto medio por bienes o servicios de turismo recptor
                $data = $this->GastoMedioBienesServiciosReceptor($request,$idioma);
                break;
             
            case 6:  /// indicador duración media de la estancia de turismo recptor
                $data = $this->DuracionMediaEstanciaReceptor($request,$idioma);
                break;
                
            case 7:  /// indicador tamaño medio de grupos de viaje de turismo recptor
                $data = $this->DuracionMediaEstanciaReceptor($request,$idioma);
                break;
                
            default: break;
        }
            
        return $data;
    }
    
    
    private function MotivoPrincipalViajeReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from motivo_viaje_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondear($data->lists('cantidad')->toArray())
        ];
    }
    
    private function TipoAlojamientoUtilizadoReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from tipo_alojamiento_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondear($data->lists('cantidad')->toArray())
        ];
    }
    
    private function MedioTransporteReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from medio_transporte_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondear($data->lists('cantidad')->toArray())
        ];
    }
    
    private function GastoMedioReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from gasto_medio_receptor(?,?)", array($request->year ,$idioma )) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   [ $this->redondear($data->lists('gastodia')->toArray()), $this->redondear($data->lists('gastototal')->toArray()) ],
            "series"=> [ "Gasto por día", "Gasto total" ]
        ];
    }
    
    private function GastoMedioBienesServiciosReceptor($request,$idioma){ 
        $data = new Collection( DB::select("SELECT *from gasto_medio_rubro_receptor(?,?)", array( $request->year ,$idioma )) );
        
        $meses = $data->unique("mes")->lists('mes')->toArray();
        $rubros = $data->unique("rubro")->lists('rubro')->toArray();
        
        $datos = [];
        
        $campoDatos = isset($request->tipoGasto)  ?  ($request->tipoGasto == "1" ? "gastototal" : "gastodia") : "gastototal";
        
        foreach($rubros as $rubro){
            $dt = [];
            $rbs = $data->where( "rubro",$rubro );
            
            foreach($meses as $mes){
                array_push($dt, $rbs->where( "mes", $mes )->pluck($campoDatos)->first() );
            }
            array_push($datos, $this->redondear($dt) );
        }
       
        return [
            "labels"=> $meses,
            "data"=>   $datos,
            "series"=> $rubros
        ];
        
    }
    
    private function DuracionMediaEstanciaReceptor($request, $idioma){
        $data = new Collection( DB::select("SELECT *from duracion_media_receptor(?,?)", array($request->year ,$idioma)) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   $this->redondear($data->lists('cantidad')->toArray()),
            "dataExtra"=> [
                            "media"=>  $this->redondear( $data->lists('media')->toArray() ), 
                            "mediana"=>$this->redondear( $data->lists('media')->toArray() ), 
                            "moda"=>   $this->redondear( $data->lists('media')->toArray() ), 
                          ]
        ];
    }
    
    private function TamanoMedioGrupoViajeReceptor($request, $idioma){
        $data = new Collection( DB::select("SELECT *from tamanio_grupo_receptor(?,?)", array($request->year ,$idioma)) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   $this->redondear($data->lists('cantidad')->toArray()),
            "dataExtra"=> [
                            "media"=>  $this->redondear( $data->lists('media')->toArray() ), 
                            "mediana"=>$this->redondear( $data->lists('media')->toArray() ), 
                            "moda"=>   $this->redondear( $data->lists('media')->toArray() ), 
                          ]
        ];
    }
    
    
    private function redondear($array){
       for($i=0; $i<count($array); $i++){ 
           $array[$i] = round( floatval( $array[$i] ) , 2);   
       }
       return $array;
    }
    
}
