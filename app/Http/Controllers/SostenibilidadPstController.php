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
use App\Models\Espacio_Alojamiento;
use App\Models\Riesgo_Encuesta_Pst_Sostenibilidad;

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
    	
    	$objeto = null;
    	if($encuesta->componenteSocialPst){
    		$objeto['trato_general'] = $encuesta->componenteSocialPst->trato_general;
    		$objeto['respetan_normas'] = $encuesta->componenteSocialPst->respetan_normas;
    		$objeto['criterios_calificacion_id'] = $encuesta->componenteSocialPst->criterios_calificacion_id;
    		$objeto['ofrece_informacion'] = $encuesta->componenteSocialPst->ofrece_informacion;
    		$objeto['accionesCulturales'] = $encuesta->accionesCulturalesPsts->pluck('id')->toArray();
    		$objeto['otroCultural'] = in_array(8,$objeto['accionesCulturales']) ? $encuesta->accionesCulturalesPsts->where('id',8)->first()->pivot->otro : null;
    		$objeto['nivel_importancia'] = $encuesta->componenteSocialPst->nivel_importancia;
    		$objeto['responsabilidad_social'] = $encuesta->componenteSocialPst->responsabilidad_social;
    		$objeto['motivosResponsabilidad'] = $encuesta->responsabilidadesSociale ? $encuesta->responsabilidadesSociale->motivosResponsabilidadesPsts->pluck('id')->toArray() : array();
    		$objeto['otroMotivoResp'] = in_array(9,$objeto['motivosResponsabilidad']) ? $encuesta->responsabilidadesSociale->motivosResponsabilidadesPsts->where('id',9)->first()->pivot->otro : null;
    		$objeto['anio_compromiso'] = $encuesta->responsabilidadesSociale ? $encuesta->responsabilidadesSociale->anio_compromiso : null;
    		$objeto['anio_normas'] = $encuesta->responsabilidadesSociale ? $encuesta->responsabilidadesSociale->anio_normas : null;
    		$objeto['espacios_accesibles'] = $encuesta->componenteSocialPst->espacios_accesibles;
    		$objeto['numero_habitaciones'] = $encuesta->espaciosAlojamiento ? $encuesta->espaciosAlojamiento->numero_habitaciones : null;
    		$objeto['tiposDiscapacidad'] =  $encuesta->espaciosAlojamiento ? $encuesta->espaciosAlojamiento->tiposDiscapacidades : array();
    		$objeto['esquemasAccesibles'] = $encuesta->esquemasAccesibles->pluck('id')->toArray();
    		$objeto['otroEsquemaAcc'] = in_array(8,$objeto['esquemasAccesibles']) ? $encuesta->esquemasAccesibles->where('id',8)->first()->pivot->otro : null;
    		$objeto['beneficiosEsquema'] = $encuesta->beneficiosEsquemas->pluck('id')->toArray();
    		$objeto['otroBeneficio'] = in_array(7,$objeto['beneficiosEsquema']) ? $encuesta->beneficiosEsquemas->where('id',7)->first()->pivot->otro : null;
    		$objeto['conoce_herramienta_tic'] =$encuesta->componenteSocialPst->conoce_herramienta_tic;
    		$objeto['implementa_herramienta_tic'] =$encuesta->componenteSocialPst->implementa_herramienta_tic;
    		$objeto['contribucion_turismo'] = $encuesta->componenteSocialPst->contribucion_turismo;
    		
    		if(count($objeto['tiposDiscapacidad']) > 0){
    			foreach($objeto['tiposDiscapacidad'] as $item){
    				$item['numero_habitacion'] = $item['pivot']['numero_habitacion'];
    			}
    			$tiposDiscapacidad = $objeto['tiposDiscapacidad'];
    		}
    		
    		foreach($tiposRiesgos as $item){
    			$riesgo = Riesgo_Encuesta_Pst_Sostenibilidad::where('encuesta_pst_sostenibilidad_id',$encuesta->id)->where('tipo_riesgo_id', $item['id'])->first();
    			$item['califcacion'] = $riesgo->criterios_calificacion_id;
    		}
    		$objeto['tiposRiesgos'] = $tiposRiesgos;
    		
    	}
    	
    	$retornado = [
    		'proveedor' => $proveedor, 
    		'criteriosCalificacion' => $criteriosCalificacion, 
    		'accionesCulturales' => $accionesCulturales, 
    		'motivosResponsabilidad' => $motivosResponsabilidad,
    		'tiposDiscapacidad' =>  $tiposDiscapacidad,
    		'esquemasAccesibles' => $esquemasAccesibles,
    		'beneficiosEsquema' => $beneficiosEsquema,
    		'tiposRiesgos' => $tiposRiesgos,
    		'objeto' => $objeto
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
			$encuesta->componenteSocialPst->delete();
			
			$espaciosAlo = Espacio_Alojamiento::where('encuestas_pst_sostenibilidad_id',$encuesta->id)->first();
			$espaciosAlo->tiposDiscapacidades()->detach();
			$encuesta->espaciosAlojamiento->delete();
			
			$res = Responsabilidad_Social::where('encuestas_pst_sostenibilidad_id',$encuesta->id)->first();
			$res->motivosResponsabilidadesPsts()->detach();
			$encuesta->responsabilidadesSociale->delete();
			
			$encuesta->accionesCulturalesPsts()->detach();
			$encuesta->esquemasAccesibles()->detach();
			$encuesta->beneficiosEsquemas()->detach();
			
			Riesgo_Encuesta_Pst_Sostenibilidad::where('encuesta_pst_sostenibilidad_id',$encuesta->id)->delete();
		}
		
		$componenteSocial = new Componente_Social_Pst();
		$componenteSocial->encuesta_pst_sostenibilidad_id = $encuesta->id;
		$componenteSocial->trato_general = $request->trato_general;
		$componenteSocial->respetan_normas = $request->respetan_normas == 1 ? 1 : 0;
		$componenteSocial->criterios_calificacion_id = $request->criterios_calificacion_id;
		$componenteSocial->ofrece_informacion = $request->criterios_calificacion_id != 4 ? ($request->ofrece_informacion==1?1:0) : null;
		$componenteSocial->nivel_importancia = $request->nivel_importancia;
		$componenteSocial->responsabilidad_social = $request->responsabilidad_social == 1 ? 1 : 0;
		$componenteSocial->espacios_accesibles = $request->espacios_accesibles == 1 ? 1 : 0;
		$componenteSocial->conoce_herramienta_tic = !in_array(7,$request->esquemasAccesibles) ? ($request->conoce_herramienta_tic == 1 ? 1 : 0) : null;
		$componenteSocial->implementa_herramienta_tic = !in_array(7,$request->esquemasAccesibles) && $request->conoce_herramienta_tic == 1 ? ($request->implementa_herramienta_tic == 1 ? 1 : 0) : null;
		$componenteSocial->contribucion_turismo = $request->contribucion_turismo;
		$componenteSocial->user_create = "admin";
		$componenteSocial->user_update = "admin";
		$componenteSocial->estado = 1;
		$componenteSocial->save();
		
		if($request->espacios_accesibles == 1){
			$espacioAlojamiento = Espacio_Alojamiento::create([
				'encuestas_pst_sostenibilidad_id' => $encuesta->id,
				'numero_habitaciones' => $request->numero_habitaciones
			]);
			
			foreach($request->tiposDiscapacidad as $item){
				$espacioAlojamiento->tiposDiscapacidades()->attach($item['id'],[
					'numero_habitacion' => $item['numero_habitacion'],
					'user_create' => 'admin',
					'user_update' => 'admin'
				]);
			}
			
		}
		
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
		
		foreach($request->esquemasAccesibles as $item){
			if($item != 8){
				$encuesta->esquemasAccesibles()->attach($item);	
			}else{
				$encuesta->esquemasAccesibles()->attach($item,['otro' => $request->otroEsquemaAcc]);
			}
		}
		
		if(!in_array(7,$request->esquemasAccesibles)){
			foreach($request->beneficiosEsquema as $item){
				if($item != 7){
					$encuesta->beneficiosEsquemas()->attach($item);	
				}else{
					$encuesta->beneficiosEsquemas()->attach($item,['otro' => $request->otroBeneficio]);
				}
			}
		}
		
		foreach($request->tiposRiesgos as $item){
			$riesgo = Riesgo_Encuesta_Pst_Sostenibilidad::where('encuesta_pst_sostenibilidad_id',$encuesta->id)->where('tipo_riesgo_id', $item['id'])->first();
			if($riesgo){
				$riesgo->criterios_calificacion_id = $item['califcacion'];
				$riesgo->save();
			}else{
				Riesgo_Encuesta_Pst_Sostenibilidad::create([
					'criterios_calificacion_id' => $item['califcacion'],
					'encuesta_pst_sostenibilidad_id' => $encuesta->id,
					'tipo_riesgo_id' => $item['id'],
					'otro' => $item['id'] == 8 && isset($item['otroRiesgo']) ? $item['otroRiesgo'] : null 
				]);	
			}
		}
		
		return ["success" => true];
    }
    
}
