<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Periodo_Sostenibilidad_Hogar;

class PeriodoSostenibilidadHogarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin|Estadistico');
        $this->user = \Auth::user();
    }
    
    public function getListado(){
        return view('periodoSostenibilidadHogares.index');
    }
    
    public function getListarperiodos(){
        $periodos = Periodo_Sostenibilidad_Hogar::withCount('encuestas')->get();
        return ['registros' => $periodos];
    }
    
    public function postGuardarregistro(Request $request){
	    $validator = \Validator::make($request->all(), [
	        'nombre' => 'required|max:250',
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
		
		$consulta = Periodo_Sostenibilidad_Hogar::where(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_inicial)->where('fecha_final', '>=', $request->fecha_inicial)->where('estado',true);
            		})->orWhere(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_final)->where('fecha_final', '>=', $request->fecha_final)->where('estado',true);
            		})->first();
		if( $consulta ){
		    return ["success"=>false,"errores"=>[["Verifique que las fechas no se superpongan."]]];
		}
		
		$registro = Periodo_Sostenibilidad_Hogar::create([
	        'nombre' => $request->nombre,
	        'fecha_inicial' => date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_inicial))),
	        'fecha_final' => date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_final))),
	        'user_create' => $this->user->username,
    		'user_update' => $this->user->username,
    		'estado' => 1
	    ]);
	    
	    $registro['encuestas_count'] = 0;
		
		return ["success" => true, 'registro' => $registro];
	}
	
	public function postEditarregistro(Request $request){
	    $validator = \Validator::make($request->all(), [
	        'id' => 'required|exists:periodos_sostenibilidad_hogares,id',
	        'nombre' => 'required|max:250',
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
		
		$consulta = Periodo_Sostenibilidad_Hogar::where(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_inicial)->where('fecha_final', '>=', $request->fecha_inicial)->where('estado',true)->where('id', '<>', $request->id);
            		})->orWhere(function($q)use($request){
            		    $q->where('fecha_inicial', '<=', $request->fecha_final)->where('fecha_final', '>=', $request->fecha_final)->where('estado',true)->where('id', '<>', $request->id);
            		})->first();
		if( $consulta ){
		    return ["success"=>false,"errores"=>[["Verifique que las fechas no se superpongan."]]];
		}
		
		$registro = Periodo_Sostenibilidad_Hogar::find($request->id);
		$registro->nombre = $request->nombre;
		$registro->fecha_inicial = date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_inicial)));
		$registro->fecha_final = date('Y-m-d',strtotime(str_replace("/","-",$request->fecha_final)));
		$registro->user_update = $this->user->username;
		$registro->save();
		
		return ["success" => true, 'registro' => $registro];
	}
	
	public function postCambiarestado(Request $request){
	    $validator = \Validator::make($request->all(), [
	        'id' => 'required|exists:periodos_sostenibilidad_pst,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		//validacion encuestas hecas ese mes
		// if( $consulta ){
		//     return ["success"=>false,"errores"=>[["Verifique que las fechas de activación no se superpongan."]]];
		// }
		
		$registro = Periodo_Sostenibilidad_Hogar::find($request->id);
		$registro->estado = !$registro->estado;
		$registro->save();
		
		return ["success" => true, 'registro' => $registro];
	}
	
	public function getDetalle($id){
		if(!Periodo_Sostenibilidad_Hogar::find($id)){
    		return \Redirect::to('/periodoSostenibilidadHogares/listado')->with('message', 'Verifique que el periodo este ingresado en el sistema.')
                        ->withInput();
    	}
    	return view('periodoSostenibilidadHogares.detalle',['id' => $id]);
	}
	
	public function getCargardetalle($id){
		$periodo = Periodo_Sostenibilidad_Hogar::where('id',$id)->with(['encuestas'=>function($q){$q->with(['barrio','estado','digitador'=>function($p){$p->with('user');}]);}])->first();
		
		return ["periodo" => $periodo];
	}
}
