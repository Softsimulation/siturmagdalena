<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedores_rnt;
use App\Models\Proveedores_rnt_idioma;
use App\Models\Encuesta_Pst_Sostenibilidad;

class SostenibilidadPstController extends Controller
{
    public function getConfiguracionencuesta(){
        return view('sostenibilidadPst.configurarcionEncuesta');
    }
    
    public function getCargarproveedoresrnt(){
        $proveedores = Proveedores_rnt_idioma::where('proveedor_rnt_id',1)->with('proveedoresRnt')->get();
        return ['proveedores' => $proveedores];
    }
    
    public function postGuardarconfiguracion(Request $request){
        $validator = \Validator::make($request->all(), [
			'fechaAplicacion' => 'required|date',
			'lugar_encuesta' => 'required|max:255',
			'nombre_contacto' => 'required|max:255',
			'cargo' => 'required|max:255',
			'establecimiento' => 'required',
			'establecimiento.proveedor_rnt_id' => 'exists:proveedores_rnt,id'
    	],[
       		'fechaAplicacion.required' => 'La fecha de apliación es requerida.',
       		'fechaAplicacion.date' => 'La fecha de apliación debe ser tipo fecha.',
       		'lugar_encuesta.required' => 'El lugar de la encuesta es requerido.',
       		'lugar_encuesta.max' => 'El lugar de la encuesta no debe superar los 255 caracteres.',
       		'nombre_contacto.required' => 'El nombre del contacto es requerido.',
       		'nombre_contacto.max' => 'El nombre del contacto no debe superar los 255 caracteres.',
       		'cargo.required' => 'El cargo del contacto es requerido.',
       		'cargo.max' => 'El cargo del contacto no debe superar los 255 caracteres.',
       		'establecimiento.required' => 'Debe seleccionar el establecimiento.',
       		'establecimiento.proveedor_rnt_id' => 'El establecimiento seleccionado no se encuentra ingresado en el sistema.'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if( date('Y-m-d',strtotime(str_replace("/","-",$request->fechaAplicacion))) > date('Y-m-d') ){
		    return ["success"=>false,"errores"=> [ ["La fecha de aplicación no debe ser mayor a la actual."] ] ];
		}
		
		$encuesta = Encuesta_Pst_Sostenibilidad::create([
		    'proveedores_rnt_id' => $request->establecimiento['proveedor_rnt_id'],
		    'nombre_contacto' => $request->nombre_contacto,
		    'lugar_encuesta' => $request->lugar_encuesta,
		    'cargo' => $request->cargo,
		    'fecha_aplicacion' => date('Y-m-d H:i',strtotime(str_replace("/","-",$request->fechaAplicacion)))
	    ]);
		
		return ["success" => true, 'encuesta' => $encuesta];
    }
    
}
