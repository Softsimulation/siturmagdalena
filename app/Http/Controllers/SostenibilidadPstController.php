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
use App\Models\Actividad_Medio_Ambiente;
use App\Models\Programa_Conservacion;
use App\Models\Plan_Mitigacion;
use App\Models\Periodo_Informe;
use App\Models\Actividad_Residuo;
use App\Models\Accion_Reducir_Energia;
use App\Models\Tipo_Energia_Renovable;
use App\Models\Componente_Ambiental_Pst;
use App\Models\Informe_Gestion_Pst;
use App\Models\Agua_Reciclada;
use App\Models\Clasificacion_Proveedor;
use App\Models\Aspecto_Seleccion_Proveedor;
use App\Models\Beneficio;
use App\Models\Calificacion_Factor;
use App\Models\Beneficio_Economico;
use App\Models\Componente_Economico_Pst;
use App\Models\Beneficio_Economico_Temporada_Pst;

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
    			$item['otroRiesgo'] = $riesgo->otro;
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
			'tiposDiscapacidad.*.numero_habitacion' => 'required_if:espacios_accesibles,1|min:0',
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
			
			//Riesgo_Encuesta_Pst_Sostenibilidad::where('encuesta_pst_sostenibilidad_id',$encuesta->id)->delete();
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
    
    public function getAmbiental($id){
    	if(Encuesta_Pst_Sostenibilidad::find($id) == null){
    		return "no";
    	}else{
    		return view('sostenibilidadPst.ambiental',["id" => $id]);
    	}
    }
    
    public function getCargardatosambiental($id){
    	$encuesta = Encuesta_Pst_Sostenibilidad::find($id);
    	$proveedor = $encuesta->proveedoresRnt;
    	$criteriosCalificacion = Criterio_Calificacion::all();
    	$actividadesAmbiente = Actividad_Medio_Ambiente::all();
    	$programasConservacion = Programa_Conservacion::all();
    	$tiposRiesgos = Tipo_Riesgo::where('categorias_riesgo_id',2)->get();
    	$planesMitigacion = Plan_Mitigacion::all();
    	$periodosInformes = Periodo_Informe::all();
    	$actividadesResiduos = Actividad_Residuo::all();
    	$accionesAgua = Accion_Reducir_Energia::where('tipo_accion',0)->get();
    	$accionesEnergia = Accion_Reducir_Energia::where('tipo_accion',1)->get();
    	$tiposEnergia = Tipo_Energia_Renovable::all();
    
    	$objeto = null;
    	if($encuesta->componenteAmbientalPst){
    		$objeto['areas_promociona'] = $encuesta->componenteAmbientalPst->areas_promociona;
    		$objeto['criterios_calificacion_id'] = $encuesta->componenteAmbientalPst->criterios_calificacion_id;
    		$objeto['tiene_guia'] = $encuesta->componenteAmbientalPst->tiene_guia;
    		$objeto['actividadesAmbiente'] = $encuesta->actividadesAmbientalesPsts->pluck('id')->toArray();
    		$objeto['otroActividad'] = in_array(7,$objeto['actividadesAmbiente']) ? $encuesta->actividadesAmbientalesPsts->where('id',7)->first()->pivot->otro : null;
    		$objeto['programasConservacion'] = $encuesta->programasConservacionPsts->pluck('id')->toArray();
    		$objeto['otroPrograma'] = in_array(8,$objeto['programasConservacion']) ? $encuesta->programasConservacionPsts->where('id',8)->first()->pivot->otro : null;
    		$objeto['planesMitigacion'] = $encuesta->planesMitigacionPsts->pluck('id')->toArray();
    		$objeto['otroMitigacion'] = in_array(9,$objeto['planesMitigacion']) ? $encuesta->planesMitigacionPsts->where('id',9)->first()->pivot->otro : null;
    		$objeto['tiene_informe_gestion'] = $encuesta->componenteAmbientalPst->tiene_informe_gestion;
    		$objeto['periodos_informe_id'] = $objeto['tiene_informe_gestion'] == 1 ? $encuesta->informesGestionPst->periodos_informe_id : null;
    		$objeto['mide_residuos'] = $objeto['tiene_informe_gestion'] == 1 ? $encuesta->informesGestionPst->mide_residuos : null;
    		$objeto['actividadesResiduos'] = $encuesta->actividadesResiduosPsts->pluck('id')->toArray();
    		$objeto['otroActividadRes'] = in_array(8,$objeto['actividadesResiduos']) ? $encuesta->actividadesResiduosPsts->where('id',8)->first()->pivot->otro : null;
    		$objeto['accionesAgua'] = $encuesta->accionesReducirEnergiaPsts->where('tipo_accion',false)->pluck('id')->toArray();
    		$objeto['otroAgua'] = in_array(7,$objeto['accionesAgua']) ? $encuesta->accionesReducirEnergiaPsts->where('tipo_accion',false)->where('id',7)->first()->pivot->otro : null;
    		$objeto['agua_reciclabe'] = !isset($encuesta->componenteAmbientalPst->agua_reciclabe) ? -1 : $encuesta->componenteAmbientalPst->agua_reciclabe;
    		$objeto['tipo_agua'] = $encuesta->componenteAmbientalPst->agua_reciclabe == 1 ? $encuesta->aguaReciclada->tipo_agua : null;
    		$objeto['uso_agua'] = $encuesta->componenteAmbientalPst->agua_reciclabe == 1 ? $encuesta->aguaReciclada->uso_agua : null;
    		$objeto['accionesEnergia'] = $encuesta->accionesReducirEnergiaPsts->where('tipo_accion',true)->pluck('id')->toArray();
    		$objeto['otroEnergia'] = in_array(17,$objeto['accionesEnergia']) ? $encuesta->accionesReducirEnergiaPsts->where('tipo_accion',true)->where('id',17)->first()->pivot->otro : null;
    		$objeto['energias_renovables'] = !isset($encuesta->componenteAmbientalPst->energias_renovables) ? -1 : $encuesta->componenteAmbientalPst->energias_renovables;
    		$objeto['tiene_manual'] = $objeto['energias_renovables']==1 ? ( !isset($encuesta->componenteAmbientalPst->tiene_manual) ? -1 : $encuesta->componenteAmbientalPst->tiene_manual) : null;
    		$objeto['tiposEnergia'] = $objeto['energias_renovables']==1 ? $encuesta->energiasRenovablesPst->pluck('id')->toArray() : array();
    		$objeto['otroRenovable'] = in_array(4,$objeto['tiposEnergia']) ? $encuesta->energiasRenovablesPst->where('id',4)->first()->pivot->otro : null;
    		
    		
    		foreach($tiposRiesgos as $item){
    			$riesgo = Riesgo_Encuesta_Pst_Sostenibilidad::where('encuesta_pst_sostenibilidad_id',$encuesta->id)->where('tipo_riesgo_id', $item['id'])->first();
    			$item['califcacion'] = $riesgo->criterios_calificacion_id;
    			$item['otroRiesgo'] = $riesgo->otro;
    		}
    		$objeto['tiposRiesgos'] = $tiposRiesgos;
    	}
    	
    	$retornado = [
    		'proveedor' => $proveedor, 
    		'criteriosCalificacion' => $criteriosCalificacion, 
    		'actividadesAmbiente' => $actividadesAmbiente,
    		'programasConservacion' => $programasConservacion,
    		'tiposRiesgos' => $tiposRiesgos,
    		'planesMitigacion' => $planesMitigacion,
    		'periodosInformes' => $periodosInformes,
    		'actividadesResiduos' => $actividadesResiduos,
    		'accionesEnergia' => $accionesEnergia,
    		'accionesAgua' => $accionesAgua,
    		'tiposEnergia' => $tiposEnergia,
    		'objeto' => $objeto
    	];
    	
    	return $retornado;
    }
    
    public function postGuardarambiental(Request $request){
    	$validator = \Validator::make($request->all(), [
			'pst_id' => 'required|exists:encuestas_pst_sostenibilidad,id',
			'areas_promociona' => 'required|max:2000',
			'criterios_calificacion_id' => 'required|exists:criterios_calificaciones,id',
			'tiene_guia' => 'required',
			'actividadesAmbiente' => 'required',
			'actividadesAmbiente.*' => 'exists:actividades_medio_ambientes,id',
			'programasConservacion' => 'required',
			'programasConservacion.*' => 'exists:programas_conservacion,id',
			'tiposRiesgos' => 'required',
			'tiposRiesgos.*.id' => 'exists:tipos_riesgos,id',
			'tiposRiesgos.*.califcacion' => 'exists:criterios_calificaciones,id',
			'planesMitigacion' => 'required',
			'planesMitigacion.*' => 'exists:planes_mitigacion,id',
			'tiene_informe_gestion' => 'required',
			'periodos_informe_id' => 'required_if:tiene_informe_gestion,1',
			'mide_residuos' => 'required_if:tiene_informe_gestion,1',
			'actividadesResiduos' => 'required',
			'actividadesResiduos.*' => 'exists:actividades_residuos,id',
			'accionesAgua' => 'required',
			'accionesAgua.*' => 'exists:acciones_reduccir_energia,id',
			'agua_reciclabe' => 'required',
			'tipo_agua' => 'required_if:agua_reciclabe,1',
			'uso_agua' => 'required_if:agua_reciclabe,1',
			'accionesEnergia' => 'required',
			'accionesEnergia.*' => 'exists:acciones_reduccir_energia,id',
			'energias_renovables' => 'required',
			'tiene_manual' => 'required_if:energias_renovables,1',
			'tiposEnergia' => 'required_if:energias_renovables,1',
			'tiposEnergia.*' => 'exists:tipos_energias_renovables,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(in_array(7,$request->actividadesAmbiente) && !isset($request->otroActividad) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 13 es requerido."]] ];
		}
		if(in_array(8,$request->programasConservacion) && !isset($request->otroPrograma) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 14 es requerido."]] ];
		}
		if(in_array(8,$request->actividadesResiduos) && !isset($request->otroActividadRes) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 18 es requerido."]] ];
		}
		if(in_array(7,$request->accionesAgua) && !isset($request->otroAgua) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 19 es requerido."]] ];
		}
		if(in_array(17,$request->accionesEnergia) && !isset($request->otroEnergia) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 21 es requerido."]] ];
		}
		if(in_array(4,$request->tiposEnergia) && $request->energias_renovables == 1 && !isset($request->otroRenovable) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 22.2 es requerido."]] ];
		}
		if(in_array(9,$request->planesMitigacion) && !isset($request->otroMitigacion) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 16 es requerido."]] ];
		}
		
		$encuesta = Encuesta_Pst_Sostenibilidad::find($request->pst_id);
		
		if($encuesta->componenteAmbientalPst){
			$encuesta->componenteAmbientalPst->delete();
			$encuesta->actividadesAmbientalesPsts()->detach();
			$encuesta->programasConservacionPsts()->detach();
			$encuesta->planesMitigacionPsts()->detach();
			Informe_Gestion_Pst::where('encuestas_pst_sosteniblidad_id',$encuesta->id)->delete();
			$encuesta->actividadesResiduosPsts()->detach();
			$encuesta->accionesReducirEnergiaPsts()->detach();
			Agua_Reciclada::where('encuesta_pst_sosteniblidad_id',$encuesta->id)->delete();
			$encuesta->energiasRenovablesPst()->detach();
		}
		
		$ambiental = new Componente_Ambiental_Pst();
		$ambiental->encuesta_pst_sostenibilidad_id = $encuesta->id;
		$ambiental->areas_promociona = $request->areas_promociona;
		$ambiental->criterios_calificacion_id = $request->criterios_calificacion_id;
		$ambiental->tiene_guia = $request->tiene_guia == 1 ? 1 : 0;
		$ambiental->tiene_informe_gestion = $request->tiene_informe_gestion == 1 ? 1 : 0;
		$ambiental->agua_reciclabe = $request->agua_reciclabe == -1 ? null : $request->agua_reciclabe;
		$ambiental->energias_renovables = $request->energias_renovables == -1 ? null : $request->energias_renovables;
		$ambiental->tiene_manual = $request->energias_renovables == 1 ? ($request->tiene_manual == -1 ? null : $request->tiene_manual) : null;
		$ambiental->save();
		
		foreach($request->actividadesAmbiente as $item){
			if($item != 7){
				$encuesta->actividadesAmbientalesPsts()->attach($item);	
			}else{
				$encuesta->actividadesAmbientalesPsts()->attach($item,['otro' => $request->otroActividad]);
			}
		}
		
		foreach($request->programasConservacion as $item){
			if($item != 8){
				$encuesta->programasConservacionPsts()->attach($item);	
			}else{
				$encuesta->programasConservacionPsts()->attach($item,['otro' => $request->otroPrograma]);
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
					'otro' => $item['id'] == 21 && isset($item['otroRiesgo']) ? $item['otroRiesgo'] : null 
				]);	
			}
		}
		
		foreach($request->planesMitigacion as $item){
			if($item != 9){
				$encuesta->planesMitigacionPsts()->attach($item);	
			}else{
				$encuesta->planesMitigacionPsts()->attach($item,['otro' => $request->otroMitigacion]);
			}
		}
		
		if($request->tiene_informe_gestion == 1){
			Informe_Gestion_Pst::create([
				'encuestas_pst_sosteniblidad_id' => $encuesta->id,
				'periodos_informe_id' => $request->periodos_informe_id,
				'mide_residuos' => $request->mide_residuos == 1 ? 1 : 0
			]);
		}
		
		foreach($request->actividadesResiduos as $item){
			if($item != 8){
				$encuesta->actividadesResiduosPsts()->attach($item);	
			}else{
				$encuesta->actividadesResiduosPsts()->attach($item,['otro' => $request->otroActividadRes]);
			}
		}
		
		foreach($request->accionesAgua as $item){
			if($item != 7){
				$encuesta->accionesReducirEnergiaPsts()->attach($item);	
			}else{
				$encuesta->accionesReducirEnergiaPsts()->attach($item,['otro' => $request->otroAgua]);
			}
		}
		
		foreach($request->accionesEnergia as $item){
			if($item != 17){
				$encuesta->accionesReducirEnergiaPsts()->attach($item);	
			}else{
				$encuesta->accionesReducirEnergiaPsts()->attach($item,['otro' => $request->otroEnergia]);
			}
		}
		
		if($request->agua_reciclabe == 1){
			Agua_Reciclada::create([
				'encuesta_pst_sosteniblidad_id' => $encuesta->id,
				'tipo_agua' => $request->tipo_agua,
				'uso_agua' => $request->uso_agua,
			]);
		}
		
		if($request->energias_renovables == 1){
			foreach($request->tiposEnergia as $item){
				if($item != 4){
					$encuesta->energiasRenovablesPst()->attach($item);	
				}else{
					$encuesta->energiasRenovablesPst()->attach($item,['otro' => $request->otroRenovable]);
				}
			}
		}
		
		return ["success" => true];
    }
    
    public function getEconomico($id){
    	if(Encuesta_Pst_Sostenibilidad::find($id) == null){
    		return "no";
    	}else{
    		return view('sostenibilidadPst.economico',["id" => $id]);
    	}
    }
    
    public function getCargardatoseconomico($id){
    	$encuesta = Encuesta_Pst_Sostenibilidad::find($id);
    	$proveedor = $encuesta->proveedoresRnt;
    	$clasificacionesProveedor = Clasificacion_Proveedor::orderBy('id')->get();
    	$aspectosSeleccion = Aspecto_Seleccion_Proveedor::orderBy('id')->get();
    	$beneficios = Beneficio::where('tipo_beneficio',true)->orderBy('id')->get();
    	$calificacionesFactor = Calificacion_Factor::all();
    	$beneficiosEconomicos = Beneficio_Economico::all();
    	
    	$objeto = null;
    	if($encuesta->componenteEconomicoPst){
    		$objeto['es_positivo'] = $encuesta->componenteEconomicoPst->es_positivo;
    		$objeto['porcentaje'] = floatval($encuesta->componenteEconomicoPst->porcentaje);
    		$objeto['clasificacionesProveedor'] = $encuesta->clasificacionesProveedoresPsts->pluck('id')->toArray();
    		$objeto['otroClasificacion'] = in_array(14,$objeto['clasificacionesProveedor']) ? $encuesta->clasificacionesProveedoresPsts->where('id',14)->first()->pivot->otro : null;
    		$objeto['aspectosSeleccion'] = $encuesta->aspectosSeleccionPsts->pluck('id')->toArray();
    		$objeto['otroSeleccion'] = in_array(9,$objeto['aspectosSeleccion']) ? $encuesta->aspectosSeleccionPsts->where('id',9)->first()->pivot->otro : null;
    		$objeto['dificultades'] = $encuesta->componenteEconomicoPst->dificultades;
    		$objeto['beneficiosEconomicos'] = $encuesta->beneficiosEconomicosPsts->pluck('id')->toArray();
    		$objeto['otroEconomico'] = in_array(12,$objeto['beneficiosEconomicos']) ? $encuesta->beneficiosEconomicosPsts->where('id',12)->first()->pivot->otro : null;
    		$objeto['conoce_marca'] = $encuesta->conoce_marca;
    		$objeto['autoriza_tratamiento'] = $encuesta->autoriza_tratamiento;
    		$objeto['autorizacion'] = $encuesta->autorizacion;
    		
    		foreach($beneficios as $item){
    			$beneficio = Beneficio_Economico_Temporada_Pst::where('encuestas_pst_sostenibilidad_id',$encuesta->id)->where('beneficio_id',$item['id'])->first();
				$item['califcacion'] = $beneficio->calificacion_factores_id;
    			$item['otroBeneficio'] = $beneficio->otro;
    		}
    		$objeto['beneficios'] = $beneficios;
    		
    	}
    	
    	$retornado = [
    		'proveedor' => $proveedor,
    		'clasificacionesProveedor' => $clasificacionesProveedor,
    		'aspectosSeleccion' => $aspectosSeleccion,
    		'beneficios' => $beneficios,
    		'calificacionesFactor' => $calificacionesFactor,
    		'beneficiosEconomicos' => $beneficiosEconomicos,
    		'objeto' => $objeto
    	];
    	
    	return $retornado;
    }
	
	public function postGuardareconomico(Request $request){
		$validator = \Validator::make($request->all(), [
			'pst_id' => 'required|exists:encuestas_pst_sostenibilidad,id',
			'es_positivo' => 'required',
			'porcentaje' => 'required|numeric',
			'clasificacionesProveedor' => 'required',
			'clasificacionesProveedor.*' => 'exists:clasificaciones_proveedores,id',
			'aspectosSeleccion' => 'required',
			'aspectosSeleccion.*' => 'exists:aspectos_seleccion_proveedores,id',
			'dificultades' => 'required|max:2000',
			'beneficios' => 'required',
			'beneficios.*.id' => 'exists:beneficios,id',
			'beneficios.*.califcacion' => 'exists:calificaciones_factores,id',
			'beneficiosEconomicos' => 'required',
			'beneficiosEconomicos.*' => 'exists:beneficios_economicos,id',
			'conoce_marca' => 'required',
			'autoriza_tratamiento' => 'required',
			'autorizacion' => 'required'
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(in_array(14,$request->clasificacionesProveedor) && !isset($request->otroClasificacion) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 24.1 es requerido."]] ];
		}
		if(in_array(9,$request->aspectosSeleccion) && !isset($request->otroSeleccion) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 24.2 es requerido."]] ];
		}
		if(in_array(12,$request->beneficiosEconomicos) && !isset($request->otroEconomico) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 27 es requerido."]] ];
		}
		
		$encuesta = Encuesta_Pst_Sostenibilidad::find($request->pst_id);
		
		if($encuesta->componenteEconomicoPst){
			$encuesta->componenteEconomicoPst->delete();
			$encuesta->clasificacionesProveedoresPsts()->detach();
			$encuesta->aspectosSeleccionPsts()->detach();
			$encuesta->beneficiosEconomicosPsts()->detach();
		}
		
		$economico = new Componente_Economico_Pst();
		$economico->encuestas_pst_sostenibilidad_id = $encuesta->id;
		$economico->es_positivo = $request->es_positivo;
		$economico->porcentaje = $request->porcentaje;
		$economico->dificultades = $request->dificultades;
		$economico->save();
		
		foreach($request->clasificacionesProveedor as $item){
			if($item != 14){
				$encuesta->clasificacionesProveedoresPsts()->attach($item);	
			}else{
				$encuesta->clasificacionesProveedoresPsts()->attach($item,['otro' => $request->otroClasificacion]);
			}
		}
		
		foreach($request->aspectosSeleccion as $item){
			if($item != 9){
				$encuesta->aspectosSeleccionPsts()->attach($item);	
			}else{
				$encuesta->aspectosSeleccionPsts()->attach($item,['otro' => $request->otroSeleccion]);
			}
		}
		
		foreach($request->beneficios as $item){
			$beneficio = Beneficio_Economico_Temporada_Pst::where('encuestas_pst_sostenibilidad_id',$encuesta->id)->where('beneficio_id',$item['id'])->first();
			if($beneficio){
				$beneficio->calificacion_factores_id = $item['califcacion'];
				$beneficio->save();
			}else{
				Beneficio_Economico_Temporada_Pst::create([
					'calificacion_factores_id' => $item['califcacion'],
					'encuestas_pst_sostenibilidad_id' => $encuesta->id,
					'beneficio_id' => $item['id'],
					'otro' => ($item['id'] == 18 && isset($item['otroBeneficio'])) || ($item['id'] == 24 && isset($item['otroBeneficio'])) ? $item['otroBeneficio'] : null 
				]);	
			}
		}
		
		foreach($request->beneficiosEconomicos as $item){
			if($item != 12){
				$encuesta->beneficiosEconomicosPsts()->attach($item);	
			}else{
				$encuesta->beneficiosEconomicosPsts()->attach($item,['otro' => $request->otroEconomico]);
			}
		}
		
		$encuesta->conoce_marca = $request->conoce_marca;
		$encuesta->autoriza_tratamiento = $request->autoriza_tratamiento;
		$encuesta->autorizacion = $request->autorizacion;
		$encuesta->save();
		
		return ["success" => true];
	}
	    
}
