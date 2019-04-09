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
use App\Models\D_aspectos_percepcion;

class IndicadoresCtrl extends Controller
{
    
    //////////////////////////////////////////////////////
    
    public function getReceptor(){
        $cultura = "es";
        $aspectos = [];
        
        if($cultura=="es"){
            $aspectos = D_aspectos_percepcion::where("estado",true)->select("aspecto_evaluacion","aspecto_evaluacion as nombre")->groupby("aspecto_evaluacion")->get();
        }
        else{
            $aspectos = D_aspectos_percepcion::where("estado",true)->select("aspecto_evaluacion","aspecto_evaluacion_name as nombre")->groupby("aspecto_evaluacion")->get();
        }
        
        return View("indicadores.index", ["indicadores"=> $this->getDataIndicadoresMedicion(1) , "aspectos"=>$aspectos] );
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
            case 1: $periodos = DB::select("SELECT *from tiempo_motivos(?) order by id DESC", array($cultura) );
                    $data = $this->getDataReceptor("motivo_viaje_receptor",$periodos[0],$cultura);  break;
                
            case 2: $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?) order by id DESC", array($cultura) );
                    $data = $this->getDataReceptor("tipo_alojamiento_receptor",$periodos[0],$cultura);  break;
            
            case 3: $periodos = DB::select("SELECT *from tiempo_tipo_alojamiento_receptor(?) order by id DESC", array($cultura) );
                    $data = $this->getDataReceptor("medio_transporte_receptor",$periodos[0],$cultura);  break;
                
            case 4: $periodos = DB::select("SELECT *from tiempo_gasto_medio_receptor(?) order by id DESC", array($cultura) );
                    $data = $this->GastoMedioReceptor($periodos[0],$cultura);  break;
                
            case 5: $periodos = DB::select("SELECT id, year from tiempo_gasto_medio_rubro_receptor(?) order by id DESC", array($cultura) );
                    $data = $this->GastoMedioBienesServiciosReceptor( $periodos[0] ,$cultura);  break;
                
            case 6: $periodos = DB::select("SELECT id, year from tiempo_duracion_media_receptor(?) order by id DESC", array($cultura) );
                    $data = $this->DuracionMediaEstanciaReceptor($periodos[0],$cultura); break;
                
            case 7: $periodos = DB::select("SELECT id, year from tiempo_tamanio_grupo_viaje(?) order by id DESC", array($cultura) );
                    $data = $this->TamanoMedioGrupoViajeReceptor($periodos[0],$cultura);  break;
            case 34: 
                     $periodos = DB::select("SELECT * from tiempo_rango_edades_visitantes_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("extranjeros_visitantes_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 35: 
                     $periodos = DB::select("SELECT * from tiempo_rango_edades_visitantes_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("municipio_colombia_visitantes_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 36: 
                     $periodos = DB::select("SELECT * from tiempo_rango_edades_visitantes_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("rango_edades_visitantes_receptor",$periodos[0],$cultura);  break;
                     break;
            case 37: 
                     $periodos = DB::select("SELECT * from tiempo_distribucion_grupo_viaje_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("distribucion_grupo_viaje_receptor",$periodos[0],$cultura);  break;
                     break;
            case 38: 
                     $periodos = DB::select("SELECT * from tiempo_medios_reserva_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("medios_reserva_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 39: 
                     $periodos = DB::select("SELECT * from tiempo_opciones_nacimiento_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("opciones_nacimiento_receptor",$periodos[0],$cultura);  break;
                     break;
            case 40: 
                     $periodos = DB::select("SELECT * from tiempo_redes_sociales_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("redes_sociales_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 41: 
                     $periodos = DB::select("SELECT * from tiempo_fuente_despues_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("fuente_despues_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 42: 
                     $periodos = DB::select("SELECT * from tiempo_fuente_antes_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("fuente_antes_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 43: 
                     $periodos = DB::select("SELECT * from tiempo_actividades_realizadas_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("actividades_realizadas_receptor",$periodos[0],$cultura);  break;
                     break; 
            case 44: 
                     $periodos = DB::select("SELECT * from tiempo_percepcion_viaje_receptor(?) order by id DESC", array($cultura) );
                     
                     $object = new \stdClass();
                     $object->year = $periodos[0]->year;
                     $object->mes = $periodos[0]->mes;
                     $object->aspecto = null;
                     
                     $data = $this->getDataReceptorPercepcion($object,$cultura);  break;
                     break; 
            case 45: 
                     $periodos = DB::select("SELECT * from tiempo_transporte_interno_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("transporte_interno_receptor",$periodos[0],$cultura);  break;
                     break;
            case 46: 
                     $periodos = DB::select("SELECT * from tiempo_municipios_interno_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("municipios_interno_receptor",$periodos[0],$cultura);  break;
                     break;
            case 47: 
                     $periodos = DB::select("SELECT * from tiempo_porcentaje_paquete_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("porcentaje_paquete_receptor",$periodos[0],$cultura);  break;
                     break;
            case 48: 
                     $periodos = DB::select("SELECT id,year from tiempo_costo_paquete_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptorCostoPromedioTuristico($periodos[0],$cultura);  break;
                     break;
            case 49: 
                     $periodos = DB::select("SELECT * from tiempo_financiadore_viajes_receptor(?) order by id DESC", array($cultura) );
                     $data = $this->getDataReceptor("financiadore_viajes_receptor",$periodos[0],$cultura);  break;
                     break;
            
                
            ////////////////////////////////INTERNO/////////////////////////////////////////
            case 8: 
                    $periodos = DB::select("SELECT * from tiempo_motivo_viaje_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                    $data = $this->getDataIndicadorInternoEmisor("motivo_viaje_interno_emisor", $periodos[0], $cultura, true);
                    break;  
            case 9: 
                    $periodos = DB::select("SELECT * from tiempo_tipo_alojamiento_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                    $data = $this->getDataIndicadorInternoEmisor("tipo_alojamiento_interno_emisor", $periodos[0], $cultura, true);
                    break;
            case 10: 
                     $periodos = DB::select("SELECT * from tiempo_tamanio_grupo_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                     $data = $this->getDataIndicadorInternoEmisor("tamanio_grupo_interno_emisor", $periodos[0], $cultura, true);
                     break;
            case 11: 
                     $periodos = DB::select("SELECT * from tiempo_medio_transporte_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                     $data = $this->getDataIndicadorInternoEmisor("medio_transporte_interno_emisor", $periodos[0], $cultura, true);
                     break;
            case 12: 
                     $periodos = DB::select("SELECT * from tiempo_duracion_media_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                     $data = $this->getDataIndicadorInternoEmisor("duracion_media_interno_emisor", $periodos[0], $cultura, true);
                     break;
            case 13: 
                      $periodos = DB::select("SELECT * from tiempo_gasto_medio_interno_emisor(?,?) order by id DESC", array($cultura,true) );
                      $data = $this->GastoMedioInternoEmisor($periodos[0], $cultura, true);
                      break;
                      
            ////////////////////////////////EMISOR/////////////////////////////////////////
            case 14: 
                     $periodos = DB::select("SELECT * from tiempo_motivo_viaje_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->getDataIndicadorInternoEmisor("motivo_viaje_interno_emisor", $periodos[0], $cultura, false);
                     break;
            case 15: 
                     $periodos = DB::select("SELECT * from tiempo_tipo_alojamiento_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->getDataIndicadorInternoEmisor("tipo_alojamiento_interno_emisor", $periodos[0], $cultura, false);
                     break;
            case 16: 
                     $periodos = DB::select("SELECT * from tiempo_tamanio_grupo_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->getDataIndicadorInternoEmisor("tamanio_grupo_interno_emisor", $periodos[0], $cultura, false);
                     break;
            case 17: 
                     $periodos = DB::select("SELECT * from tiempo_medio_transporte_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->getDataIndicadorInternoEmisor("medio_transporte_interno_emisor", $periodos[0], $cultura, false);
                     break;
            case 18: 
                     $periodos = DB::select("SELECT * from tiempo_duracion_media_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->getDataIndicadorInternoEmisor("duracion_media_interno_emisor", $periodos[0], $cultura, false);
                     break;
            case 19:  
                     $periodos = DB::select("SELECT * from tiempo_gasto_medio_interno_emisor(?,?) order by id DESC", array($cultura,false) );
                     $data = $this->GastoMedioInternoEmisor($periodos[0], $cultura, false);
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
            
            
            
            
                
            default: break;
        }
        
        return  json_encode([
                            "periodos"=> $periodos,
                            "indicador"=> Indicadores_medicion::where( "id",$id )
                                                              ->with([ 
                                                                        "idiomas"=>function($q) use($idioma){ $q->where("idioma_id", $idioma)->select("id","indicadores_medicion_id","nombre", "descripcion","eje_x","eje_y"); }, 
                                                                        "graficas"=>function($q){ $q->select("id","nombre","icono","codigo"); }
                                                                    ])->first(),
                            "data"=> $data
                        ]);
            
    }
    
    public function postFiltrardataindicador(Request $request){
        
        $data = null;
        $idioma = "es";
        switch($request->indicador){
            
            ////////////////////////////RECEPTOR/////////////////////////////
            case 1: $data = $this->getDataReceptor("motivo_viaje_receptor",$request,$idioma);  break;
            case 2: $data = $this->getDataReceptor("tipo_alojamiento_receptor",$request,$idioma);  break;
            case 3: $data = $this->getDataReceptor("medio_transporte_receptor",$request,$idioma);  break;
            case 4: $data = $this->GastoMedioReceptor($request,$idioma); break;
            case 5: $data = $this->GastoMedioBienesServiciosReceptor($request,$idioma); break;
            case 6: $data = $this->DuracionMediaEstanciaReceptor($request,$idioma); break;
            case 7: $data = $this->TamanoMedioGrupoViajeReceptor($request,$idioma); break;
            
            case 34: $data = $this->getDataReceptor("extranjeros_visitantes_receptor",$request,$idioma);  break;
            case 35: $data = $this->getDataReceptor("municipio_colombia_visitantes_receptor",$request,$idioma);  break;
            case 36: $data = $this->getDataReceptor("rango_edades_visitantes_receptor",$request,$idioma);  break;
            case 37: $data = $this->getDataReceptor("distribucion_grupo_viaje_receptor",$request,$idioma);  break;
            case 38: $data = $this->getDataReceptor("medios_reserva_receptor",$request,$idioma);  break;
            case 39: $data = $this->getDataReceptor("opciones_nacimiento_receptor",$request,$idioma);  break;
            case 40: $data = $this->getDataReceptor("redes_sociales_receptor",$request,$idioma);  break;
            case 41: $data = $this->getDataReceptor("fuente_despues_receptor",$request,$idioma);  break;
            case 42: $data = $this->getDataReceptor("fuente_antes_receptor",$request,$idioma);  break;
            case 43: $data = $this->getDataReceptor("actividades_realizadas_receptor",$request,$idioma);  break;
            case 44: $data = $this->getDataReceptorPercepcion($request,$idioma);  break;
            case 45: $data = $this->getDataReceptor("transporte_interno_receptor",$request,$idioma);  break;
            case 46: $data = $this->getDataReceptor("municipios_interno_receptor",$request,$idioma);  break;
            case 47: $data = $this->getDataReceptor("porcentaje_paquete_receptor",$request,$idioma);  break;
            case 48: $data = $this->getDataReceptorCostoPromedioTuristico($request,$idioma);  break;
            case 49: $data = $this->getDataReceptor("financiadore_viajes_receptor",$request,$idioma);  break;
            
            ////////////////////////////////INTERNO/////////////////////////////////////////
            case 8:  $data = $this->getDataIndicadorInternoEmisor("motivo_viaje_interno_emisor", $request, $idioma, true); break;  
            case 9:  $data = $this->getDataIndicadorInternoEmisor("tipo_alojamiento_interno_emisor", $request, $idioma, true); break;
            case 10: $data = $this->getDataIndicadorInternoEmisor("tamanio_grupo_interno_emisor", $request, $idioma, true); break;
            case 11: $data = $this->getDataIndicadorInternoEmisor("medio_transporte_interno_emisor", $request, $idioma, true); break;
            case 12: $data = $this->getDataIndicadorInternoEmisor("duracion_media_interno_emisor", $request, $idioma, true); break;
            case 13: $data = $this->GastoMedioInternoEmisor($request, $idioma, true); break;
            
            ////////////////////////////////EMISOR/////////////////////////////////////////
            case 8:  $data = $this->getDataIndicadorInternoEmisor("motivo_viaje_interno_emisor", $request, $idioma, false); break;  
            case 9:  $data = $this->getDataIndicadorInternoEmisor("tipo_alojamiento_interno_emisor", $request, $idioma, false); break;
            case 10: $data = $this->getDataIndicadorInternoEmisor("tamanio_grupo_interno_emisor", $request, $idioma, false); break;
            case 11: $data = $this->getDataIndicadorInternoEmisor("medio_transporte_interno_emisor", $request, $idioma, false); break;
            case 12: $data = $this->getDataIndicadorInternoEmisor("duracion_media_interno_emisor", $request, $idioma, false); break;
            case 13: $data = $this->GastoMedioInternoEmisor($request, $idioma, false); break;
            
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
       
        $idioma = "es";
        $select = "*";
        $metodo = null;
        
       
        switch($id){
            
            case 1: 
                    $metodo = 'motivo_viaje_receptor';
                    $select = $idioma=="es" ?  'sexo,anio,mes,opcionesnacimiento as "opciones nacimiento",municipioresidencia as "municipio residencia",departamentoresidencia as "departamento residencia",país,edad,motivoviaje, cantidad' : 
                                               'birthoptions,country,month,tripreason,sex,municipioresidencia,opcionesnacimiento, cantidad';
                break;
            case 2: 
                    $metodo = 'alojamiento_receptor';
                    $select = $idioma=="es" ?  'anio,departamentoresidencia as "departamento residencia",edad,mes,motivoviaje as "motivo viaje",municipioresidencia as "municipio residencia",país,sexo,tipoalojamiento as "tipo alojamiento", cantidad' : 
                                               'anio as "year",departamentoresidencia as "departamento residencia",edad as "age" "",month,tripreason,municipioresidencia as "municipio residencia",country,sex,accommodationtype as "accommodation type", cantidad';
                break;
            case 3: 
                    $metodo = 'medio_transporte_receptor';
                    $select = $idioma=="es" ?  'anio,departamentoresidencia as "departamento residencia",edad,mes,motivoviaje as "motivo viaje",municipioresidencia as "municipio residencia",país,sexo,tipotransporte as "tipo transporte", cantidad' : 
                                               'anio as "year",departamentoresidencia as "departamento residencia",edad as "age" "",month,tripreason,municipioresidencia as "municipio residencia",country,sex,transporttype as "transport type", cantidad';
                break;
            case 4: 
                    $metodo = 'gasto_medio_receptor';
                    $select = $idioma=="es" ?  'anio,departamento,edad,mes,motivoviaje as "motivo viaje",municipio,opcionesnacimiento as "opciones nacimiento",pais,rubro,sexo, cantidad' : 
                                               'anio as "year",departamento,edad as "age",month,tripreason,municipio,birthoptions as "birth options",country,category,sex, cantidad';
                    break;
            case 5:
                    $metodo = 'gasto_medio_total_receptor';
                    $select = $idioma=="es" ?  'anio,departamento,edad,mes,motivoviaje as "motivo viaje",municipio,opcionesnacimiento as "opciones nacimiento",pais,rubro,sexo, cantidad' : 
                                               'anio as "year",departamento,edad as "age",month,tripreason,municipio,birthoptions as "birth options",country,category,sex, cantidad';
                    break;
            
            case 34:
                    $metodo = 'caracteristica_visitante_receptor_vista';
                    break;
            case 35:
                    $metodo = 'caracteristica_visitante_receptor_vista';
                    break;        
            case 36:
                    $metodo = 'caracteristica_visitante_receptor_vista';
                    break;
                    
            case 37:
                    $metodo = 'distribucion_viaje_receptor_vista';
                    break;
            case 38:
                    $metodo = 'medio_reserva_receptor_vista';
                    break;
            case 39:
                    $metodo = 'opciones_nacimiento_receptor_vista';
                    break;
            
            case 40:
                    $metodo = 'redes_sociales_receptor_vista';
                    break;
            case 41:
                    $metodo = 'fuente_despues_receptor_vista';
                    break;
            case 42:
                    $metodo = 'fuente_antes_receptor_vista';
                    break;
            case 43:
                    $metodo = 'actividades_realizadas_receptor_vista';
                    break;
            case 44:
                    $metodo = 'percepcion_viaje_receptor_vista';
                    break;
            case 45:
                    $metodo = 'transporte_interno_receptor_vista';
                    break;
            case 46:
                    $metodo = 'municipio_interno_receptor_vista';
                    break;
            case 47:
                    $metodo = 'porcentaje_paquete_receptor_vista';
                    break;
            case 48:
                    $metodo = 'costo_paquete_receptor_vista';
                    break;
            case 49:
                    $metodo = 'financiadores_viajes_receptor_vista';
                    break;
            
            ////////////////////INTERNO//////////////////////
            case 8:
                    $metodo = 'vista_motivo_viaje_interno_datos';
                    break;
            case 9:
                    $metodo = 'vista_alojamiento_interno_datos';
                    break;
            case 10:
                    //$metodo = 'Tamaño medio de grupo de viaje'; //No tiene
                    break;
            case 11:
                    $metodo = 'vista_medio_transporte_interno_datos';
                    break;
            case 12:
                     //$metodo = 'duracion media'; //No tiene
                    break;
            case 13:
                    $metodo = 'vista_gasto_medio_total_interno_datos';
                    break;
                    
            ////////////////////EMISOR//////////////////////
            case 14:
                    $metodo = 'vista_motivo_viaje_emisor_datos';
                    break;
            case 15:
                    $metodo = 'vista_alojamiento_emisor_datos';
                    break;
            case 16:
                    //$metodo = 'Tamaño medio de grupo de viaje'; //No tiene
                    break;
            case 17:
                    $metodo = 'vista_medio_transporte_emisor_datos';
                    break;
            case 18:
                     //$metodo = 'duracion media'; //No tiene
                    break;
            case 19:
                    $metodo = 'vista_gasto_medio_total_emisor_datos';
                    break;
            
            default: break;
        }
        
        return json_encode( $metodo ? DB::select("SELECT ".$select." from ".$metodo) : [] );
            
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
    
 
    
    ////////////////////////////RECEPTOR/////////////////////////////
    private function getDataReceptor($procedimiento,$request,$idioma){
        $data = new Collection( DB::select("SELECT *from ".$procedimiento."(?,?,?)", array($request->year ,$idioma, $request->mes)) );
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
  
    private function getDataReceptorPercepcion($request,$idioma){
        $data = new Collection( DB::select("SELECT *from percepcion_viaje_receptor(?,?,?,?)", array($request->year ,$idioma, $request->mes, (!$request->aspecto || $request->aspecto=="" ? null :$request->aspecto) )) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function getDataReceptorCostoPromedioTuristico($request,$idioma){
        $data = new Collection( DB::select("SELECT *from costo_paquete_receptor(?,?)", array($request->year ,$idioma)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    /////////////////////////// INTERNO Y EMISOR //////////////
    
    private function getDataIndicadorInternoEmisor($procedimiento, $request, $idioma, $es_interno){
        $data = new Collection( DB::select("SELECT *from ".$procedimiento."(?,?,?)", array($request->id,$idioma,$es_interno)) );
        return [
            "labels"=> $data->lists('tipo')->toArray(),
            "data"=>   $this->redondearArray($data->lists('cantidad')->toArray())
        ];
    }
    
    private function GastoMedioInternoEmisor($request,$idioma,$es_interno){
        $data = new Collection( DB::select("SELECT *from gasto_medio_interno_emisor(?,?,?)", array($request->id ,$idioma,$es_interno )) );
        return [
            "labels"=> $data->lists('mes')->toArray(),
            "data"=>   [ $this->redondearArray($data->lists('gastodia')->toArray()), $this->redondearArray($data->lists('gastototal')->toArray()) ],
            "series"=> [ "Gasto por día", "Gasto total" ]
        ];
    }
    
    
    /////////////////////////////////////////////////////////////////////////
    
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
