<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Control_Sostenibilidad_Receptor;

class ControlSostenibilidadController extends Controller
{
    public function __construct()
	{
	    $this->middleware('auth');
	    $this->middleware('role:Admin');
	    $this->user = \Auth::user();
	}
	
	public function getRegistros(){
	    return view('controlSostenibilidadReceptor.index');
	}
	
	public function getListado(){
	    $registros = Control_Sostenibilidad_Receptor::all();
	    return ["registros" => $registros];
	}
	
	public function postGuardarregistro(Request $request){
	    $validator = \Validator::make($request->all(), [
			'fecha_inicial' => 'required',
			'fecha_final' => 'required',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->fecha_inicial > $request->fecha_final){
		    return ["success"=>false,"errores"=>[["La fecha inicial no puede ser mayor que la final."]]];
		}
		
		$consulta = Control_Sostenibilidad_Receptor::where(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_inicial)->where('fecha_final', '>=', $request->fecha_inicial)->where('estado',true);
            		})->orWhere(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_final)->where('fecha_final', '>=', $request->fecha_final)->where('estado',true);
            		})->first();
		if( $consulta ){
		    return ["success"=>false,"errores"=>[["Verifique que las fechas de activación no se superpongan."]]];
		}
		
		$registro = Control_Sostenibilidad_Receptor::create([
	        'activado' => true,
	        'fecha_inicial' => date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_inicial))),
	        'fecha_final' => date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_final))),
	        'user_create' => $this->user->username,
    		'user_update' => $this->user->username,
    		'estado' => 1
	    ]);
		
		return ["success" => true, 'registro' => $registro];
	}
	
	public function postEditarregistro(Request $request){
	    $validator = \Validator::make($request->all(), [
	        'id' => 'required|exists:control_sostenibilidad_receptor,id',
			'fecha_inicial' => 'required',
			'fecha_final' => 'required',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->fecha_inicial > $request->fecha_final){
		    return ["success"=>false,"errores"=>[["La fecha inicial no puede ser mayor que la final."]]];
		}
		
		$consulta = Control_Sostenibilidad_Receptor::where(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_inicial)->where('fecha_final', '>=', $request->fecha_inicial)->where('estado',true)->where('id', '<>', $request->id);
            		})->orWhere(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_final)->where('fecha_final', '>=', $request->fecha_final)->where('estado',true)->where('id', '<>', $request->id);
            		})->first();
		if( $consulta ){
		    return ["success"=>false,"errores"=>[["Verifique que las fechas de activación no se superpongan."]]];
		}
		
		$registro = Control_Sostenibilidad_Receptor::find($request->id);
		$registro->fecha_inicial = date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_inicial)));
		$registro->fecha_final = date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_final)));
		$registro->user_update = $this->user->username;
		$registro->save();
		
		return ["success" => true, 'registro' => $registro];
	}
	
	public function postCambiarestado(Request $request){
	    $validator = \Validator::make($request->all(), [
	        'id' => 'required|exists:control_sostenibilidad_receptor,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		//validacion encuestas hecas ese mes
		// if( $consulta ){
		//     return ["success"=>false,"errores"=>[["Verifique que las fechas de activación no se superpongan."]]];
		// }
		
		$registro = Control_Sostenibilidad_Receptor::find($request->id);
		$registro->estado = !$registro->estado;
		$registro->save();
		
		return ["success" => true, 'registro' => $registro];
	}
	
}
