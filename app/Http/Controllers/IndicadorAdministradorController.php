<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anio;
use App\Models\Mes_Indicador;
use App\Models\Indicadores_medicion;
use App\Models\Tipo_Medicion_Indicador;
use App\Models\Tiempo_Indicador;
use App\Models\Indicador;
use App\Models\D_Tiempo;
use DB;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;

class IndicadorAdministradorController extends Controller
{
    //
    public function getIndex(){
        return view("indicadoresAdministrador.index");
    }
    
    public function getCargarinfo(){
        $anios = Anio::all();
        $meses = Mes_Indicador::all();
        $indicadores  = Indicadores_medicion::with([ "idiomas"=>function($q){ $q->where("idioma_id", 1); } ])
                                    ->orderBy('peso', 'asc')->get();
                                    
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        $tiposMedicion = Tipo_Medicion_Indicador::all();
        return ["anios"=>$anios,"meses"=>$meses,"indicadores"=>$indicadores,"tiposMedicion"=>$tiposMedicion];
    }
    
    public function postRecalcularindicador(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'indicador' => 'required|numeric|exists:indicadores,id'
        ],[
            'indicador_id.required' => 'Se necesita un indicador para calcular.',
            'indicador_id.exists' => 'El indicador debe existir.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $indicador = Indicador::find($request->indicador);
        $tiempo = Tiempo_Indicador::find($indicador->tiempo_indicador_id);
         
        $mes = Mes_Indicador::find($tiempo->mes_indicador_id);
        $anio = Anio::find($tiempo['años_id']);
        
        $d_tiempo = D_Tiempo::where("anios",$anio->anio)->where("meses",$mes->nombre)->first();
        
        $importar = DB::select("SELECT *from eliminar_datos_receptor (?,?)",array($indicador->indicador_medicion_id,$d_tiempo->id));
        $fecha_inicio = $anio->anio."-".$mes->id."-".$mes->dia_inicio;
        $fecha_final = $anio->anio."-".$mes->id."-".$mes->dia_final;
        $respuesta = $this->calcularReceptor($indicador->indicador_medicion_id,$d_tiempo->id,$fecha_inicio,$fecha_final,$indicador->id);
        
        if(!$respuesta["success"]){
            return $respuesta;
        }
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        return ["success"=>true,"indicadoresMedicion"=>$indicadoresMedicion];
    }
    
    public function postCalcularindicador(Request $request){
        $validator = \Validator::make($request->all(), [
            'indicador_id' => 'required|numeric|exists:indicadores_mediciones,id',
            'mes' => 'required|numeric|exists:mes_indicador,id',
            'anio' => 'required|numeric|exists:anios,id',
        ],[
            'indicador_id.required' => 'Se necesita un indicador para calcular.',
            'mes.required' => 'Se necesita un mes para calcular.',
            'anio.required' => 'Se necesita un año para calcular.',
            
            'indicador_id.exists' => 'El indicador debe existir.',
            'mes.exists' => 'El mes debe existir.',
            'anio.exists' => 'El año debe existir.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $tiempo = Tiempo_Indicador::where('años_id',$request->anio)->where("mes_indicador_id",$request->mes)->first();
        
        if($tiempo == null){
            $tiempo = new Tiempo_Indicador();
            $tiempo->mes_indicador_id = $request->mes;
            $tiempo['años_id']= $request->anio;
            $tiempo->save();
        }
        
        $mes = Mes_Indicador::find($request->mes);
        $anio = Anio::find($request->anio);
        
        $d_tiempo = D_Tiempo::where("anios",$anio->anio)->where("meses",$mes->nombre)->first();
        
        if($d_tiempo == null){
            $d_tiempo = new D_Tiempo;
            $d_tiempo->meses = $mes->nombre;
            $d_tiempo->month = $mes->name;
            $d_tiempo->anios = $anio->anio;
            $d_tiempo->month = $mes->name;
            $d_tiempo->user_create = "Admin";
            $d_tiempo->user_update = "Admin";
            $d_tiempo->estado = true;
            $d_tiempo->save();
            
        }
        
        $indicador = Indicador::where("indicador_medicion_id",$request->indicador_id)->where("tiempo_indicador_id",$tiempo->id)->first();
        
        if($indicador == null){
            $indicador = new Indicador;
            $indicador->tiempo_indicador_id = $tiempo->id;
            $indicador->fecha_carga=date('Y-m-d H:i:s');
            $indicador->estado_indicador_id = 1;
            $indicador->indicador_medicion_id = $request->indicador_id;
            $indicador->save();
            
        }else{
            if($indicador->estado_indicador_id != 3){
                 return ["success"=>false,"errores"=> [ ["El indicador ya se encuentra calculado."] ] ];
            }
        }
        
        
        $fecha_inicio = $anio->anio."-".$mes->id."-".$mes->dia_inicio;
        $fecha_final = $anio->anio."-".$mes->id."-".$mes->dia_final;
        
        $respuesta = $this->calcularReceptor($request->indicador_id,$d_tiempo->id,$fecha_inicio,$fecha_final,$indicador->id);
        
       
        if(!$respuesta["success"]){
            return $respuesta;
        }
        
        $indicadoresMedicion = new Collection(DB::select("SELECT *from indicadores_calculados "));
        return ["success"=>true,"indicadoresMedicion"=>$indicadoresMedicion];

    }
    
    public function calcularReceptor($indicadorMedicion, $dTiempo,$fecha_inicio,$fecha_final,$indicador){
        
        $importar = DB::select("SELECT *from importar_receptor()");
        

        try{
            switch($indicadorMedicion){
                case 1:
                        $importar = DB::select("SELECT *from etl_motivo_viaje_receptor(?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));            
                    
                    break;
                case 2:
                    $importar = DB::select("SELECT *from etl_tipo_alojamiento (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 3:
                    $importar = DB::select("SELECT *from etl_medio_transporte_receptor (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 4:
                    $importar = DB::select("SELECT *from etl_gasto_medio_receptor(?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 5:
                    $importar = DB::select("SELECT *from etl_gasto_medio_rubro_receptor (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 6:
                    $importar = DB::select("SELECT *from etl_duracion_media_receptor_1 (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
                case 7:
                    $importar = DB::select("SELECT *from etl_tamanio_grupo_viaje_receptor_1 (?,?,?)",array($fecha_inicio,$fecha_final,$dTiempo));
                    break;
            }
            
            $indicador = Indicador::find($indicador);
            $indicador->estado_indicador_id = 2;
            $indicador->fecha_finalizacion=date('Y-m-d H:i:s');
            $indicador->save();
            return ["success"=>true];
        }catch(Exception $ex){
        
            $indicador->estado_indicador_id = 3;
            $indicador->save();
             return ["success"=>false,"errores"=> [ [$ex->getMessage()] ] ];
        }
        
    }
}
