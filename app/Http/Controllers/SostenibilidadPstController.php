<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedores_rnt;
use App\Models\Proveedores_rnt_idioma;
use App\Models\Encuesta_Pst_Sostenibilidad;
use App\Models\Criterio_Calificacion;
use App\Models\Accion_Cultural;
use App\Models\Motivo_Responsabilidad;
use App\Models\Tipo_Discapacidad;
use App\Models\Esquema_Accesible;
use App\Models\Beneficio_Esquema;
use App\Models\Tipo_Riesgo;
use App\Models\Componente_Social_Pst;
use App\Models\Responsabilidad_Social;

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
    
    public function getSociocultural($id){
    	if(Encuesta_Pst_Sostenibilidad::find($id) == null){
    		return "no";
    	}else{
    		return view('sostenibilidadPst.socioCultural',["id" => $id]);
    	}
    }
    
    public function getCargardatossociocultural($id){
    	$encuesta = Encuesta_Pst_Sostenibilidad::find($id);
    	$proveedor = $encuesta->proveedoresRnt;
    	$criteriosCalificacion = Criterio_Calificacion::all();
    	$accionesCulturales = Accion_Cultural::all();
    	$motivosResponsabilidad = Motivo_Responsabilidad::all();
    	$tiposDiscapacidad = Tipo_Discapacidad::all();
    	$esquemasAccesibles = Esquema_Accesible::all();
    	$beneficiosEsquema = Beneficio_Esquema::all();
    	$tiposRiesgos = Tipo_Riesgo::where('categorias_riesgo_id',1)->get();
    	
    	$retornado = [
    		'proveedor' => $proveedor, 
    		'criteriosCalificacion' => $criteriosCalificacion, 
    		'accionesCulturales' => $accionesCulturales, 
    		'motivosResponsabilidad' => $motivosResponsabilidad,
    		'tiposDiscapacidad' => $tiposDiscapacidad,
    		'esquemasAccesibles' => $esquemasAccesibles,
    		'beneficiosEsquema' => $beneficiosEsquema,
    		'tiposRiesgos' => $tiposRiesgos
    	];
    	
    	return $retornado;
    }
    
    public function postGuardarseccioncultural(Request $request){
    	$validator = \Validator::make($request->all(), [
			'pst_id' => 'required|exists:encuestas_pst_sostenibilidad,id',
			'trato_general' => 'required|integer',
			'respetan_normas' => 'required',
			'criterios_calificacion_id' => 'required|exists:criterios_calificaciones,id',
			'ofrece_informacion' => 'required_if:criterios_calificacion_id,!=,4',
			'accionesCulturales' => 'required',
			'accionesCulturales.*' => 'exists:acciones_culturales,id',
			'nivel_importancia' => 'required|integer',
			'responsabilidad_social' => 'required',
			'motivosResponsabilidad' => 'required_if:responsabilidad_social,1',
			'motivosResponsabilidad.*' => 'exists:motivos_responsabilidades,id',
			'espacios_accesibles' => 'required',
			'numero_habitaciones' => 'required_if:espacios_accesibles,1|min:0',
			'tiposDiscapacidad.*.id' => 'exists:tipos_discapacidades,id',
			'tiposDiscapacidad.*.numero_habitacion' => 'required|min:0',
			'esquemasAccesibles' => 'required',
			'esquemasAccesibles' => 'exists:esquemas_accesibles,id',
			'beneficiosEsquema' => 'exists:beneficios_esquemas,id',
			'tiposRiesgos.*.id' => 'required|exists:tipos_riesgos,id',
			'tiposRiesgos.*.califcacion' => 'exists:criterios_calificaciones,id',
			'contribucion_turismo' => 'required'
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(in_array(8,$request->accionesCulturales) && !isset($request->otroCultural) ){
			return ["success" => false, "errores" => [["El campo otro en las acciones culturales es requerido."]] ];
		}
		
		if(in_array(9,$request->motivosResponsabilidad) && !isset($request->otroMotivoResp) && $request->responsabilidad_social == 1 ){
			return ["success" => false, "errores" => [["El campo otro en los motivos de responsabilidad social es requerido."]] ];
		}
		
		if(in_array(8,$request->esquemasAccesibles) && !isset($request->otroEsquemaAcc) ){
			return ["success" => false, "errores" => [["El campo otro en los esquenas accesibles es requerido."]] ];
		}
		
		if( !in_array(7,$request->esquemasAccesibles) && !isset($request->beneficiosEsquema) ){
			return ["success" => false, "errores" => [["Debe seleccionar alguna opción en la pregunta 8.1."]] ];
		}
		
		if(in_array(7,$request->beneficiosEsquema) && !isset($request->otroBeneficio) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 8.1 es requerido."]] ];
		}
		
		if( !in_array(7,$request->esquemasAccesibles) && !isset($request->conoce_herramienta_tic) ){
			return ["success" => false, "errores" => [["Debe seleccionar alguna opción en la pregunta 8.2."]] ];
		}
		
		if( !in_array(7,$request->esquemasAccesibles) && $request->conoce_herramienta_tic == 1 && !isset($request->implementa_herramienta_tic) ){
			return ["success" => false, "errores" => [["Debe seleccionar alguna opción en la pregunta 8.2.1."]] ];
		}
		
		$encuesta = Encuesta_Pst_Sostenibilidad::find($request->pst_id);
		
		if($encuesta->componenteSocialPst){
			
		}else{
			$componenteSocial = new Componente_Social_Pst();
			$componenteSocial->encuesta_pst_sostenibilidad_id = $encuesta->id;
		}
		
		$componenteSocial->trato_general = $request->trato_general;
		$componenteSocial->respetan_normas = $request->respetan_normas == 1 ? 1 : 0;
		$componenteSocial->criterios_calificacion_id = $request->criterios_calificacion_id;
		$componenteSocial->ofrece_informacion = $request->criterios_calificacion_id != 4 ? ($request->ofrece_informacion==1?1:0) : null;
		$componenteSocial->nivel_importancia = $request->nivel_importancia;
		$componenteSocial->responsabilidad_social = $request->responsabilidad_social == 1 ? 1 : 0;
		$componenteSocial->save();
		
		if($request->responsabilidad_social == 1){
			$responsabilidad = Responsabilidad_Social::create([
				'encuestas_pst_sostenibilidad_id' => $encuesta->id,
				'anio_compromiso' => isset($request->anio_compromiso) ? $request->anio_compromiso : null,
				'anio_normas' => isset($request->anio_normas) ? $request->anio_normas : null,
				'user_update' => 'admin',
				'user_create' => 'admin',
				'estado' => 1
			]);
			
			foreach($request->motivosResponsabilidad as $item){
				if($item != 9){
					$responsabilidad->motivosResponsabilidadesPsts()->attach($item);	
				}else{
					$responsabilidad->motivosResponsabilidadesPsts()->attach($item,['otro' => $request->otroMotivoResp]);
				}
			}
			
		}
		
		foreach($request->accionesCulturales as $item){
			if($item != 8){
				$encuesta->accionesCulturalesPsts()->attach($item);	
			}else{
				$encuesta->accionesCulturalesPsts()->attach($item,['otro' => $request->otroCultural]);
			}
		}
		
		return ["success" => true];
    }
    
}
