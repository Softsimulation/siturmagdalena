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
use App\Models\Temporada;
use App\Models\Mes_Indicador;
use App\Models\Mes_Anio;

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
    
    public function getEmpleo(){ 
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(5) ] );
    }
    
    
    
    ///////////////////////ESTADISTICAS SECUNDARIAS//////////////////////////////////
    public function getSecundarios(){
        $data = Estadisitica_Secundaria::where([ ["estado",true], ["es_visible",true] ])->get();
        return View("indicadores.estadisticasSecundarios", [ "indicadores"=> $data ] );
    }
    
    public function getDatasencundarios($id){
    
        $idioma = 1;
        
        $estadistica = null;
        if($idioma == 1){
            $estadistica = Estadisitica_Secundaria::where("id",$id)->with("graficas")->select("id","nombre" ,"label_x" ,"label_y", "descripcion_es as descripcion" )->first();
        }
        else{
            $estadistica = Estadisitica_Secundaria::where("id",$id)->with("graficas")-select("id","name as nombre" ,"label_x_en as label_x" ,"label_y_en as label_y", "descripcion_en as descripcion" )->first();
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
                                               ->where([ ["series_estadistica_id",$serie->id], ["anio_id",$year] ])->distinct()->orderBy("mes_indicador.id")->get(["mes_indicador.*"]);
                
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
    
    ///////////////////////INDICADORES////////////////////////////////
    private function getDataIndicadoresMedicion($indicador){ 
        $idioma = 1;
        return  Indicadores_medicion::where("tipo_medicion_indicador_id",$indicador)
                                    ->with([ "idiomas"=>function($q) use($idioma){ $q->where("idioma_id", $idioma); } ])
                                    ->orderBy('peso', 'asc')->get();
    }
    
    public function getDataindicador($id){ 
        $idioma = 1;
        $cultura = "es";
        $periodos = [];
        $data = [];
        
        switch($id){
            
            ////////////////////////////RECEPTOR/////////////////////////////
            case 1: $periodos = DB::select("SELECT *from tiempo_motivos(?)", array($cultura) );
                    $data = $this->MotivoPrincipalViajeReceptor($periodos[0],$cultura); break;
                
            case 2: $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?)", array($cultura) );
                    $data = $this->TipoAlojamientoUtilizadoReceptor($periodos[0],$cultura); break;
            
            case 3: $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?)", array($cultura) );
                    $data = $this->MedioTransporteReceptor($periodos[0],$cultura);  break;
                
            case 4: $periodos = DB::select("SELECT *from tiempo_gasto_medio_receptor(?)", array($cultura) );
                    $data = $this->GastoMedioReceptor($periodos[0],$cultura);  break;
                
            case 5: $periodos = DB::select("SELECT id, year from tiempo_gasto_medio_rubro_receptor(?)", array($cultura) );
                    $data = $this->GastoMedioBienesServiciosReceptor( $periodos[0] ,$cultura);  break;
                
            case 6: $periodos = DB::select("SELECT id, year from tiempo_duracion_media_receptor(?)", array($cultura) );
                    $data = $this->DuracionMediaEstanciaReceptor($periodos[0],$cultura); break;
                
            case 7: $periodos = DB::select("SELECT id, year from tiempo_tamanio_grupo_viaje(?)", array($cultura) );
                    $data = $this->TamanoMedioGrupoViajeReceptor($periodos[0],$cultura);  break;
                
            ////////////////////////////////INTERNO/////////////////////////////////////////
            case 8: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                    $object = new \stdClass();
                    $object->temporada = $periodos[0]["temporadas"][0]->id ;
                    $data = $this->getDataIndicadorDB_Temporada("estadistica_motivo_viaje_interno", $object, $cultura);
                    break;   
                
            case 9: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                    $object = new \stdClass();
                    $object->temporada = $periodos[0]["temporadas"][0]->id ;
                    $data = $this->getDataIndicadorDB_Temporada("estadistica_tipos_alojamiento_interno", $object, $cultura);
                    break;
                    
            case 10: $periodos = [ [ "id"=>1, "year"=>2018 ] ]; 
                     $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_tamanio_grupo_viaje_interno", null, $cultura);
                     break;
                     
            case 11: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                     $object = new \stdClass();
                     $object->temporada = $periodos[0]["temporadas"][0]->id ;
                     $data = $this->getDataIndicadorDB_Temporada("estadistica_medio_transporte_interno", $object, $cultura); 
                     break;
                     
            case 12: 
                     $periodos = [ [ "id"=>1, "year"=>2018 ] ]; 
                     $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_duracion_media_interno", null, $cultura);
                     break;
                     
            case 13:  $periodos = [ [ "id"=>1, "year"=>2018 ] ];
                      $object = new \stdClass();
                      $object->tipoGasto = 1;
                      $data = $this->getDataIndicadorGastos_temporada("estadistica_gastos_interno", $object, $cultura); 
                      break;
                      
            ////////////////////////////////EMISOR/////////////////////////////////////////
            case 14: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                     $object = new \stdClass();
                     $object->temporada = $periodos[0]["temporadas"][0]->id;
                     $data = $this->getDataIndicadorDB_Temporada("estadistica_motivo_viaje_emisor", $object, $cultura);
                     break;   
                
            case 15: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                     $object = new \stdClass();
                     $object->temporada = $periodos[0]["temporadas"][0]->id ;
                     $data = $this->getDataIndicadorDB_Temporada("estadistica_tipos_alojamiento_emisor", $object, $cultura);
                     break;
                     
            case 16: $periodos = [ [ "id"=>1, "year"=>2018 ] ]; 
                     $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_tamanio_grupo_viaje_emisor", null, $cultura);
                     break;
                     
            case 17: $periodos = [ [ "id"=>1, "year"=>2018, "temporadas"=> $this->getTemporadas() ] ]; 
                     $object = new \stdClass();
                     $object->temporada = $periodos[0]["temporadas"][0]->id ;
                     $data = $this->getDataIndicadorDB_Temporada("estadistica_medio_transporte_emisor", $object, $cultura); 
                     break;
                     
            case 18: 
                     $periodos = [ [ "id"=>1, "year"=>2018 ] ]; 
                     $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_duracion_media_emisor", null, $cultura);
                     break;
                     
            case 19:  $periodos = [ [ "id"=>1, "year"=>2018 ] ];
                      $object = new \stdClass();
                      $object->tipoGasto = 1;
                      $data = $this->getDataIndicadorGastos_temporada("estadistica_gastos_emisor", $object, $cultura);     
                      break;
       
        
            ////////////////////////////////OFERTA/////////////////////////////////////////          
            case 20: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_numero_establecimiento", $periodos[0], $cultura);
                     break; 
                     
            case 21: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_agencia_viaje_operadoras", $periodos[0], $cultura);  
                     break;
                     
            case 22: 
                     $periodos = DB::select("SELECT id, year from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB_Meses("estadistica_tasa_ocupacion_oferta", $periodos[0], $cultura);  
                     break;
            
            case 23: 
                     $periodos = DB::select("SELECT id, year from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB_Meses("estadistica_platos_comida", $periodos[0], $cultura);  
                     break;
            
            case 24: 
                     $periodos = DB::select("SELECT id, year from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB_Meses("estadistica_unidades_comida", $periodos[0], $cultura);  
                     break;
            
            case 25: 
                     $periodos = DB::select("SELECT id, year from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB_Meses("estadistica_agencia_viaje_emisor", $periodos[0], $cultura);  
                     break;
            
            case 26: 
                     $periodos = DB::select("SELECT id, year from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB_Meses("estadistica_agencia_viaje_interno", $periodos[0], $cultura);  
                     break;
            
            ////////////////////////////////EMPLEO/////////////////////////////////////////          
            case 27: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_vinculacion_laboral", $periodos[0], $cultura);
                     break; 
                     
           case 28: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_total_personas", $periodos[0], $cultura);
                     break; 
                     
            case 29: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_dominio_ingles", $periodos[0], $cultura);
                     break; 
            
            case 30: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC");  
                     $data = $this->getDataIndicadorDB("estadistica_numero_empleados", $periodos[0], $cultura);
                     break; 
                     
            case 31: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_numero_empleados_tc", $periodos[0], $cultura);
                     break; 
            case 32: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores where mes_id%3=0 order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_remuneracion_promedio", $periodos[0], $cultura);
                     break; 
            
            case 33: 
                     $periodos = DB::select("SELECT *from tiempo_indicadores order by year DESC, mes_id DESC"); 
                     $data = $this->getDataIndicadorDB("estadistica_vacantes", $periodos[0], $cultura);
                     break; 
                
            default: break;
        }
        
        return  [
                "periodos"=> $periodos,
                "indicador"=> Indicadores_medicion::where( "id",$id )
                                                  ->with([ 
                                                            "idiomas"=>function($q) use($idioma){ $q->where("idioma_id", $idioma)->select("id","indicadores_medicion_id","nombre", "descripcion","eje_x","eje_y"); }, 
                                                            "graficas"=>function($q){ $q->select("id","nombre","icono","codigo"); }
                                                        ])->first(),
                "data"=> $data
            ];
            
    }
    
    public function postFiltrardataindicador(Request $request){
        
        $data = null;
        $idioma = "es";
        switch($request->indicador){
            
            ////////////////////////////RECEPTOR/////////////////////////////
            case 1: $data = $this->MotivoPrincipalViajeReceptor($request,$idioma); break;
            case 2: $data = $this->TipoAlojamientoUtilizadoReceptor($request,$idioma); break;
            case 3: $data = $this->MedioTransporteReceptor($request,$idioma); break;
            case 4: $data = $this->GastoMedioReceptor($request,$idioma); break;
            case 5: $data = $this->GastoMedioBienesServiciosReceptor($request,$idioma); break;
            case 6: $data = $this->DuracionMediaEstanciaReceptor($request,$idioma); break;
            case 7: $data = $this->DuracionMediaEstanciaReceptor($request,$idioma); break;
                
            ////////////////////////////////INTERNO/////////////////////////////////////////
            case 8:  $data = $this->getDataIndicadorDB_Temporada("estadistica_motivo_viaje_interno", $request, $idioma); break;
            case 9:  $data = $this->getDataIndicadorDB_Temporada("estadistica_tipos_alojamiento_interno", $request, $idioma); break;
            case 10: $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_tamanio_grupo_viaje_interno", $request, $idioma); break;
            case 11: $data = $this->getDataIndicadorDB_Temporada("estadistica_medio_transporte_interno", $request, $idioma); break;
            case 12: $data = $this->DuracionMediaEstanciaInterno($request,$idioma); break;
            case 13: $data = $this->getDataIndicadorDB_Temporada("estadistica_gastos_interno", $request, $idioma); break;
            
            ////////////////////////////////EMISOR/////////////////////////////////////////
            case 14: $data = $this->getDataIndicadorDB_Temporada("estadistica_motivo_viaje_emisor", $request, $idioma); break;
            case 15: $data = $this->getDataIndicadorDB_Temporada("estadistica_tipos_alojamiento_emisor", $request, $idioma); break;
            case 16: $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_tamanio_grupo_viaje_emisor", $request, $idioma); break;
            case 17: $data = $this->getDataIndicadorDB_Temporada("estadistica_medio_transporte_emisor", $request, $idioma); break;
            case 18: $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_duracion_media_interno", $request, $idioma); break;
            case 19: $data = $this->getDataIndicadorDB_Temporada("estadistica_gastos_emisor", $request, $idioma); break;
            
            ////////////////////////////////OFERTA/////////////////////////////////////////
            case 20: $data = $this->getDataIndicadorDB("estadistica_numero_establecimiento", $request, $idioma); break;
            case 21: $data = $this->getDataIndicadorDB("estadistica_agencia_viaje_operadoras", $request, $idioma); break;
            case 22: $data = $this->getDataIndicadorDB_Meses("estadistica_tasa_ocupacion_oferta", $request, $idioma); break;
            case 23: $data = $this->getDataIndicadorDB_Meses("estadistica_platos_comida", $request, $idioma); break;
            case 24: $data = $this->getDataIndicadorDB_Temporada("estadistica_medio_transporte_emisor", $object, $idioma); break;
            case 25: $data = $this->getDataIndicadorDB_Por_Temporada("estadistica_duracion_media_emisor", null, $idioma); break;
            case 26: $data = $this->getDataIndicadorDB_Meses("estadistica_agencia_viaje_interno", $request, $idioma); break;
            
            ////////////////////////////////EMPLEO/////////////////////////////////////////
            case 27: $data = $this->getDataIndicadorDB("estadistica_vinculacion_laboral", $request, $idioma); break;
            case 28: $data = $this->getDataIndicadorDB("estadistica_total_personas", $request, $idioma); break;
            case 29: $data = $this->getDataIndicadorDB("estadistica_dominio_ingles", $request, $idioma); break;
            case 30: $data = $this->getDataIndicadorDB("estadistica_numero_empleados", $request, $idioma); break;
            case 31: $data = $this->getDataIndicadorDB("estadistica_numero_empleados_tc", $request, $idioma); break;
            case 32: $data = $this->getDataIndicadorDB("estadistica_remuneracion_promedio", $request, $idioma); break;
            case 33: $data = $this->getDataIndicadorDB("estadistica_vacantes", $request, $idioma); break;
            
            default: break;
        }
            
        return $data;
    }
    
    
    public function getDatapivotable($id){
       
        switch($id){
            
            case 1: return  DB::select("SELECT *from motivo_viaje_receptor"); break;
            case 2: return  DB::select("SELECT *from alojamiento_receptor"); break;
            case 3: return  DB::select("SELECT *from medio_transporte_receptor"); break;
            case 4: return  DB::select("SELECT *from gasto_medio_receptor"); break;
            case 5: return  DB::select("SELECT *from gasto_medio_total_receptor"); break;
            
            default: break;
        }
        
        
            
    }
    
    /////////////////////////////////////////////////////
    
    private function getDataIndicadorDB($procedimiento, $request, $idioma){ 
        $data = new Collection( DB::select("SELECT *from ".$procedimiento."(?,?)", array($request->id,$idioma)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function getDataIndicadorDB_Meses($procedimiento, $request, $idioma){
       
        $labels = [];
        $data = [];
        
        $meses = DB::select("SELECT *from tiempo_indicadores where year =". $request->year); 
        
        foreach($meses as $mes){
            
            $d =  DB::select("SELECT *from ".$procedimiento."(?,?)", array($mes->id ,$idioma)); 
            if($d!=null){
                $d = (new Collection($d))->pluck('cantidad')->first();
                array_push($data, $this->redondearNumero($d) );
                array_push($labels, $mes->mes);
            }
        }
    
        return [ "labels"=> $labels, "data"=> $data ];
    }
    
    private function getDataIndicadorDB_Temporada($procedimiento, $request, $idioma){
        $data = new Collection( DB::select("SELECT *from ".$procedimiento."(?,?)", array($request->temporada,$idioma)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function getDataIndicadorDB_Por_Temporada($procedimiento, $request, $idioma){
       
        $labels = [];
        $data = [];
        foreach(Temporada::get() as $temporada){
            $d =  DB::select("SELECT *from ".$procedimiento."(?,?)", array($temporada->id ,$idioma)); 
            if($d!=null){
                $d = (new Collection($d))->pluck('cantidad')->first();
                array_push($data, $this->redondearNumero($d) );
                array_push($labels, $temporada->nombre);
            }
        }
    
        return [ "labels"=> $labels, "data"=> $data ];
    }
    
    private function getDataIndicadorGastos_temporada($procedimiento, $request, $idioma){
        
        $labels = [];
        $data = [];
        
        if($request->tipoGasto==1){
            foreach(Temporada::where("estado",true)->get() as $temporada){
                $d =  DB::select("SELECT *from ".$procedimiento."(?,?)", array($temporada->id ,$idioma)); 
                if($d!=null){
                    $d = (new Collection($d))->pluck('gasto_total')->first();
                    array_push($data, $this->redondearNumero($d) );
                    array_push($labels, $temporada->nombre);
                }
            }
        }
        else{
            foreach(Temporada::where("estado",true)->get() as $temporada){
                $d =  DB::select("SELECT *from ".$procedimiento."(?,?)", array($temporada->id ,$idioma)); 
                if($d!=null){
                    $d = (new Collection($d))->pluck('gasto_dia')->first();
                    array_push($data, $this->redondearNumero($d) );
                    array_push($labels, $temporada->nombre);
                }
            }
        }
        
        return [ "labels"=> $labels, "data"=> $data ];
    }
    
    
    ////////////////////////////RECEPTOR/////////////////////////////
    
    private function MotivoPrincipalViajeReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from motivo_viaje_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function TipoAlojamientoUtilizadoReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from tipo_alojamiento_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function MedioTransporteReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from medio_transporte_receptor(?,?,?)", array($request->year ,$idioma, $request->mes)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function GastoMedioReceptor($request,$idioma){
        $data = new Collection( DB::select("SELECT *from gasto_medio_receptor(?,?)", array($request->year ,$idioma )) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   [ $this->redondearArray($data->lists('gastodia')->toArray()), $this->redondearArray($data->lists('gastototal')->toArray()) ],
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
            array_push($datos, $this->redondearArray($dt) );
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
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray()),
            "dataExtra"=> [
                            "media"=>  $this->redondearArray( $data->lists('media')->toArray() ), 
                            "mediana"=>$this->redondearArray( $data->lists('media')->toArray() ), 
                            "moda"=>   $this->redondearArray( $data->lists('media')->toArray() ), 
                          ]
        ];
    }
    
    private function TamanoMedioGrupoViajeReceptor($request, $idioma){
        $data = new Collection( DB::select("SELECT *from tamanio_grupo_receptor(?,?)", array($request->year ,$idioma)) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray()),
            "dataExtra"=> [
                            "media"=>  $this->redondearArray( $data->lists('media')->toArray() ), 
                            "mediana"=>$this->redondearArray( $data->lists('media')->toArray() ), 
                            "moda"=>   $this->redondearArray( $data->lists('media')->toArray() ), 
                          ]
        ];
    }
  
  
  
  
    public function getTemporadas(){ 
        return Temporada::where('estado',true)->get([ "id", "nombre" ]);
    }
    
    private function redondearArray($array){
       for($i=0; $i<count($array); $i++){ 
           $array[$i] = round( floatval( $array[$i] ) , 2);   
       }
       return $array;
    }
    
    private function redondearNumero($val){
       return round( floatval( $val ) , 2);   ;
    }
    
}
