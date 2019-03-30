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
        
        $datos=array();
        $datos['origeninternacional']=\DB::select("SELECT *from origeninternacional(?,?) limit 4", array($request->anio,$request->mes));
        $datos['origennacional']=\DB::select("SELECT *from origennacional(?,?) limit 4", array($request->anio,$request->mes));
        $datos['tipoalojamiento']=\DB::select("SELECT *from tipoalojamientoutilizado(?,?) limit 3", array($request->anio,$request->mes));
        $datos['tipotransporte']=\DB::select("SELECT *from tipotransporteutilizado(?,?) limit 3", array($request->anio,$request->mes));
        $datos['sexo']=\DB::select("SELECT *from sexos(?,?)", array($request->anio,$request->mes));
        $datos['rangoedad']=\DB::select("SELECT *from rangoedad(?,?)", array($request->anio,$request->mes));
        $datos['duracionpromedio']=\DB::select("SELECT *from duracionpromedioviaje(?,?)", array($request->anio,$request->mes));
        $datos['destinoprincipalviaje']=\DB::select("SELECT *from destinoprincipal(?,?) limit 4", array($request->anio,$request->mes));
        $datos['tamaniogrupo']=\DB::select("SELECT *from tamaniogrupo(?,?) limit 1", array($request->anio,$request->mes));
    
        return ["success"=>true,'datos'=>$datos];
    }
}
