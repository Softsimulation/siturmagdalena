<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Anio;
use App\Models\Mes;

class InfografiasController extends Controller
{
    
    public function __construct(){
        
        return $this->middleware('auth');
        
    }
    
    public function getDatos(){
        
        $anios=Anio::get();
        $meses=Mes::get();
        
        return["anios"=>$anios,'meses'=>$meses];
        
    }
    
    public function getIndex(){
        return view('infografias.index');
    }
    
    public function postGenerar(Request $request){
        
        $validator=\Validator::make($request->all(),[
                'anio'=>'required|exists:anios,anio',
                'mes'=>'required|exists:meses,nombre'
            ]);
            
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        $datos=array();
        $datos['origeninternacional']=\DB::select("SELECT *from extranjeros_visitantes_receptor(?,?,?) limit 4", array($request->anio,"es",$request->mes));
        $datos['origennacional']=\DB::select("SELECT *from municipio_colombia_visitantes_receptor(?,?,?) limit 4", array($request->anio,"es",$request->mes));
        $datos['tipoalojamiento']=\DB::select("SELECT *from tipo_alojamiento_receptor(?,?,?)limit 3", array($request->anio,"es",$request->mes));
        $datos['tipotransporte']=\DB::select("SELECT *from medio_transporte_receptor(?,?,?) limit 3", array($request->anio,"es",$request->mes));
        $datos['sexo']=\DB::select("SELECT *from sexos(?,?)", array($request->anio,$request->mes));
        $datos['rangoedad']=\DB::select("SELECT *from rangoedad(?,?)", array($request->anio,$request->mes));
        $datos['duracionpromedio']=\DB::select("SELECT *from duracion_media_receptor(?,?,?)", array($request->anio,"es",$request->mes));
        $datos['destinoprincipalviaje']=\DB::select("SELECT *from municipios_interno_receptor(?,?,?) limit 4", array($request->anio,"es",$request->mes));
        $datos['tamaniogrupo']=\DB::select("SELECT *from tamanio_grupo_receptor(?,?,?) limit 1", array($request->anio,"es",$request->mes));
        $datos['promediotiporubro']=\DB::select("SELECT *from gasto_medio_rubro_receptor(?,?,?) limit 4", array($request->anio,"es",$request->mes));
        /*
        $datos['motivoviaje']=\DB::select("SELECT *from motivoviaje(?,?,?)limit 2", array($request->anio,"es",$request->mes));
        $datos['motivopersonalviaje']=\DB::select("SELECT *from motivoviajepersonal(?,?,?) limit 2",array($request->anio,"es",$request->mes));
        $datos['motivoviajeprofesional']=\DB::select("SELECT *from motivoviajeprofesional(?,?,?) limit 2", array($request->anio,"es",$request->mes));
        */
        return ["success"=>true,'datos'=>$datos];
    }
}
