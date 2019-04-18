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
                'mes'=>'required|exists:meses,id'
            ]);
            
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $mes=Mes::find($request->mes);
        $datos=array();
        $datos['origeninternacional']=\DB::select("SELECT tipo as nombre,cantidad as numero,id_tipo as id from extranjeros_visitantes_receptor(?,?,?) limit 4", array($request->anio,"es",$mes->nombre));
        $datos['origennacional']=\DB::select("SELECT * from origennacional(?,?) limit 4", array($request->anio,$mes->nombre));
        $datos['tipoalojamiento']=\DB::select("SELECT tipo as nombre,cantidad as numero,id_tipo as id from tipo_alojamiento_receptor(?,?,?)limit 3", array($request->anio,"es",$mes->nombre));
        $datos['tipotransporte']=\DB::select("SELECT tipo as nombre,cantidad as numero,id_tipo as id from medio_transporte_receptor(?,?,?) limit 3", array($request->anio,"es",$mes->nombre));
        $datos['sexo']=\DB::select("SELECT *from sexos(?,?)", array($request->anio,$mes->id));
        $datos['rangoedad']=\DB::select("SELECT *from rangoedad(?,?)", array($request->anio,$mes->id));
        $datos['duracionpromedio']=\DB::select("SELECT *from duracionpromedioviaje(?,?)", array($request->anio,$mes->id));
        $datos['destinoprincipalviaje']=\DB::select("SELECT tipo as nombre, cantidad as numero from municipios_interno_receptor(?,?,?) limit 4", array($request->anio,"es",$mes->nombre));
        $datos['tamaniogrupo']=\DB::select("SELECT cantidad::integer as nombre,cantidad::integer as numero from tamanio_grupo_receptor(?,?) where mes='".$mes->nombre."' limit 1", array($request->anio,"es"));
        $datos['promediotiporubro']=\DB::select("select rubro as nombre,Round(gastototal::numeric,0) as numero, id_tipo as id from gasto_medio_rubro_receptor(?,?) where mes='".$mes->nombre."' order by gastototal  limit 4", array($request->anio,"es"));
        $datos['motivoviaje']=\DB::select("SELECT *from motivoviaje(?,?)limit 2", array($request->anio,$mes->nombre));
        /*
        $datos['motivopersonalviaje']=\DB::select("SELECT *from motivoviajepersonal(?,?,?) limit 2",array($request->anio,"es",$request->mes));
        $datos['motivoviajeprofesional']=\DB::select("SELECT *from motivoviajeprofesional(?,?,?) limit 2", array($request->anio,"es",$request->mes));
        */
        return ["success"=>true,'datos'=>$datos];
    }
}
