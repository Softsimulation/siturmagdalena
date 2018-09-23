<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests;
use App\Models\Estrato;
use App\Models\Barrio;
use App\Models\Criterio_Calificacion;
use App\Models\Accion_Cultural;
use App\Models\Tipo_Riesgo;
use App\Models\Factor_Calidad;
use App\Models\Calificacion_Factor;
use App\Models\Beneficio;
use App\Models\Componente_Social;
use App\Models\Factor_Calidad_Turismo;
use App\Models\Riesgo_Turismo;
use App\Models\Factor_Positivo;
use App\Models\Beneficio_Sociocultural;
use App\Models\Casa_Sostenibilidad;
use App\Models\Vivienda_Turistica_Sostenible;
use App\Models\Actividad_Medio_Ambiente;
use App\Models\Accion_Ambiental;
use App\Models\Componente_Ambiental;
use App\Models\Digitador;
use App\Models\Sectores_Turismo;
use App\Models\Sectores_Economia;
use App\Models\Componente_Tecnico;
use App\Models\Estados_Encuesta;
use App\Models\Historial_Encuesta_Hogar_Sostenibilidad;
use App\Models\ListadoEncuestasHogarSostenibilidad;


class SostenibilidadHogaresController extends Controller
{
    //
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        $this->user = Auth::user();
    }
    
    public function getCrear(){
    	 return view('sostenibilidadHogar.crear');
    }
    
    public function getInfocrear(){
    	$estratos = Estrato::all();
        $barrios = Barrio::all();
    	$encuestadores = Digitador::with([ 'user'=>function($q){$q->select('id','username');} ])->get();
    	
    	return ["estratos"=>$estratos,"barrios"=>$barrios,"encuestadores"=>$encuestadores];
    }
    
    public function getInfoeditar($id){
    	$estratos = Estrato::all();
        $barrios = Barrio::all();
    	$encuestadores = Digitador::with([ 'user'=>function($q){$q->select('id','username');} ])->get();
    	$casa = Casa_Sostenibilidad::find($id);
    	return ["estratos"=>$estratos,"barrios"=>$barrios,"encuestadores"=>$encuestadores,"casa"=>$casa];
    }
    
    public function getEditar($id){
    	 $data=["id"=>$id];
    	 return view('sostenibilidadHogar.editar',$data);
    }
    
    public function postGuardarencuesta(Request $request){
    	
    	$validator = \Validator::make($request->all(), [
			'fecha_aplicacion' => 'required',
			'nombre_encuestado' => 'required|string|max:250',
			'sexo' => 'required|boolean',
			'barrio_id' => 'required|exists:barrios,id',
			'digitador_id' => 'required|exists:digitadores,id',
			'estrato_id' => 'required|exists:estratos,id',
			'direccion' => 'required|string|max:150',
			'celular' => 'required|string|max:150',
			'email' => 'required|email|string|max:150',
    	],[
       		
    	]);
    	
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$casa = new Casa_Sostenibilidad;
		$casa->fecha_aplicacion = date('Y-m-d H:i:s',strtotime($request->fecha_aplicacion));
		$casa->nombre_encuestado = $request->nombre_encuestado;
		$casa->sexo = $request->sexo;
		$casa->barrio_id = $request->barrio_id;
		$casa->estrato_id = $request->estrato_id;
		$casa->digitador_id = $request->digitador_id;
		$casa->direccion = $request->direccion;
		$casa->celular = $request->celular;
		$casa->email = $request->email;
		$casa->estado_encuesta_id = 1;
		$casa->numero_sesion = 1;
		$casa->save();
		
		Historial_Encuesta_Hogar_Sostenibilidad::create([
    		'estado_encuesta_id' => 1,
    		'casas_sostenibilidad_id' => $casa->id,
    		'observacion' => 'Se ha creado la encuesta.',
    		'fecha_cambio' => date('Y-m-d H:i'),
    		'estado' => 1,
    		'user_create' => $this->user->username,
    		'user_update' => $this->user->username
    	]);
			
		return ["success"=>true,"id"=>$casa->id];
		
    }
    
    public function postEditarencuesta(Request $request){
    	
    	$validator = \Validator::make($request->all(), [
    		'id'=>'required|exists:casas_sostenibilidad,id',
			'fecha_aplicacion' => 'required',
			'nombre_encuestado' => 'required|string|max:250',
			'sexo' => 'required|boolean',
			'barrio_id' => 'required|exists:barrios,id',
			'digitador_id' => 'required|exists:digitadores,id',
			'estrato_id' => 'required|exists:estratos,id',
			'direccion' => 'required|string|max:150',
			'celular' => 'required|string|max:150',
			'email' => 'required|email|string|max:150',
    	],[
       		
    	]);
    	
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$casa = Casa_Sostenibilidad::find($request->id);
		$casa->fecha_aplicacion = date('Y-m-d H:i:s',strtotime($request->fecha_aplicacion));
		$casa->nombre_encuestado = $request->nombre_encuestado;
		$casa->sexo = $request->sexo;
		$casa->barrio_id = $request->barrio_id;
		$casa->estrato_id = $request->estrato_id;
		$casa->digitador_id = $request->digitador_id;
		$casa->direccion = $request->direccion;
		$casa->celular = $request->celular;
		$casa->email = $request->email;
		$casa->save();
		
		Historial_Encuesta_Hogar_Sostenibilidad::create([
    		'estado_encuesta_id' => 1,
    		'casas_sostenibilidad_id' => $casa->id,
    		'observacion' => 'Se ha editado la encuesta.',
    		'fecha_cambio' => date('Y-m-d H:i'),
    		'estado' => 1,
    		'user_create' => $this->user->username,
    		'user_update' => $this->user->username
    	]);
			
		return ["success"=>true,"id"=>$casa->id];
		
    }
    
    public function getComponentesocial($id){
        $data = ["id"=>$id];
        return view('sostenibilidadHogar.social',$data);
    }
    
    public function getInfocomponentesocial($id){
        $estratos = Estrato::all();
        $barrios = Barrio::all();
        $criterios = Criterio_Calificacion::all();
        $culturales = Accion_Cultural::where('estado',true)->where('es_hogar', true)->get();
        $social = Componente_Social::find($id);
        $casa = Casa_Sostenibilidad::find($id);
        $factores = Factor_Calidad::where('estado',true)->where('tipo_factor_id','!=',3)->get();
        $riesgos = Tipo_Riesgo::where('categorias_riesgo_id',1)->get();
        $factoresPositivos = Factor_Calidad::where('estado',true)->where('tipo_factor_id',3)->get();
        $calificacionFactor = Calificacion_Factor::where('estado',true)->get();
        $beneficios = Beneficio::where('tipo_beneficio',false)->where('id', '<>',25)->where('id', '<>',27)->orderBy('peso')->get();
        
        
        
        if($social != null){
        	$social["culturales"]= $casa->accionesCulturales()->pluck('id')->toArray();
	        $social["otroCultura"]=null;
	        if(in_array(9,$social["culturales"])){
	           $social["otroCultura"]= $casa->accionesCulturales()->wherePivot('otro','!=',null)->first() != null ? $casa->accionesCulturales()->wherePivot('otro','!=',null)->first()->pivot->otro : null;
	        }
	        
	        foreach($riesgos as $ite){
	        	$valor = Riesgo_Turismo::where('tipos_riesgo_id',$ite["id"])->where('casas_sostenibilidad_id',$casa->id)->first();
	        	$ite["calificacion"]= $valor != null ? $valor->	criterios_calificacion_id:null;
	        	if($ite["id"]==8 && $valor != null){
	        		$ite["otroRiesgo"]= $valor->otro;
	        	}
	        }
	        foreach($factores as $ite){
	        	$valor = Factor_Calidad_Turismo::where('factores_calidad_id',$ite["id"])->where('casas_sostenibilidad_id',$casa->id)->first();
	        	$ite["calificacion"]=$valor !=null ? $valor->calificaciones_factor_id:null;
	        	if($ite["id"]==11 && $valor != null){
	        		$ite["otroFactor1"]= $valor->otro;
	        	}
	        	if($ite["id"]==29 && $valor != null){
	        		$ite["otroFactor2"]= $valor->otro;
	        	}
	        }
        
	        foreach($factoresPositivos as $ite){
	        	$valor = Factor_Positivo::where('factores_calidad_id',$ite["id"])->where('casas_sostenibilidad_id',$casa->id)->first();
	        	$ite["calificacion"]= $valor != null ? $valor->	calificacion:null;
	        	if($ite["id"]==36 && $valor != null){
	        		$ite["otroFactor3"]= $valor->otro;
	        	}
	        }
	        
	
	        foreach($beneficios as $ite){
	        	$valor = Beneficio_Sociocultural::where('beneficio_id',$ite["id"])->where('casas_sostenibilidad_id',$casa->id)->first();
	        	$ite["calificacion"]= $valor != null ? $valor->	calificacion_factores_id:null;
	        	if($ite["id"]==6 && $valor != null){
	        		$ite["beneficioBajo"]= $valor->otro;
	        	}
	        	if($ite["id"]==12 && $valor != null){
	        		$ite["beneficioAlto"]= $valor->otro;
	        	}
	        }
	        
	        if($social["viviendas_turisticas"]){
	        	$vivienda = Vivienda_Turistica_Sostenible::find($id);
	        	$social["cantidad"]=$vivienda->cantidad;
	        	$social["razon_cambio"]=$vivienda->razon_cambio;
	        	$social["numero_meses"] = $vivienda->numero_meses;
	        	$social["cuantas_rnt"] = $vivienda->cuantas_rnt;
	        }

        }
        

        
        return ["estratos"=>$estratos,"barrios"=>$barrios,"criterios"=>$criterios,
                "culturales"=>$culturales,"riesgos"=>$riesgos,"factores"=>$factores,"factoresPositivos"=>$factoresPositivos,
                "calificacionFactor"=>$calificacionFactor,"beneficios"=>$beneficios,"social"=>$social];
    }
    
    public function postGuardarcomponentesocial(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:casas_sostenibilidad,id',
			'es_agradable' => 'boolean',
			'calificacion' => 'required|integer',
			'criterios_calificacion_id' => 'required|exists:criterios_calificaciones,id',
			'ofrece_informacion' => 'required_if:criterios_calificacion_id,1,2,3',
			'pertenece_gremio' => 'required|boolean',
			'culturales' => 'required',
			'culturales.*' => 'exists:acciones_culturales,id',
			'riesgos' => 'array',
			'riesgos.*.id' => 'exists:tipos_riesgos,id',
			'riesgos.*.calificacion' => 'exists:criterios_calificaciones,id',
			'nivel_sastifacion' => 'required|integer',
			'cambian_turistas' => 'boolean',
			'factores' => 'array',
			'factores.*.id' => 'exists:factores_calidad,id',
			'factores.*.calificacion' => 'exists:calificaciones_factores,id',
			'conservacion_patrimonio_id' => 'boolean',
			'viviendas_turisticas' => 'required|boolean',
			'cantidad' => 'required_if:viviendas_turisticas,true|integer',
			'razon_cambio' => 'required_if:viviendas_turisticas,true|string|max:1000',
			'numero_meses' => 'required_if:viviendas_turisticas,true|integer',
			'cuantas_rnt' => 'required_if:viviendas_turisticas,true|integer',
			'factoresPositivos' => 'array',
			'factoresPositivos.*.calificacion' => 'boolean',
			'efecto_turismo' => 'boolean',
			'beneficios' => 'required|array',
			'beneficios.*.id' => 'exists:tipos_riesgos,id',
			'beneficios.*.calificacion' => 'exists:criterios_calificaciones,id',
			'positivo' => 'string|max:2000',
			'negativo' => 'string|max:2000',
    	],[
       		
    	]);
    	
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(in_array(9,$request->culturales) && !isset($request->otroCultura) ){
			return ["success" => false, "errores" => [["El campo otro en las acciones culturales es requerido."]] ];
		}
		
		if(isset($request->riesgos)){
		    foreach($request->riesgos as $ite){
		        if($ite["id"] == 8 ){
		            if(!isset($ite["otroRiesgo"])){
		                return ["success" => false, "errores" => [["El campo otro en los riesgos."]] ];
		            }
		        }
		    }
		}
		
		if(isset($request->factores)){
		    foreach($request->factores as $ite){
		        if($ite["id"] == 11 ){
		            if(!isset($ite["otroFactor1"])){
		                return ["success" => false, "errores" => [["El campo otro en los factores de calidad de vida."]] ];
		            }
		        }
		        if($ite["id"] == 29 ){
		            if(!isset($ite["otroFactor2"])){
		                return ["success" => false, "errores" => [["El campo otro en los factores de patrimonio cultural."]] ];
		            }
		        }
		    }
		}
		
		if(isset($request->factoresPositivos)){
		    foreach($request->factoresPositivos as $ite){
		        if($ite["id"] == 36 ){
		            if(!isset($ite["otroFactor3"])){
		                return ["success" => false, "errores" => [["El campo otro en los factores de identidad cultural."]] ];
		            }
		        }
		    }
		}
		
		if(isset($request->beneficios)){
		    foreach($request->beneficios as $ite){
		        if($ite["id"] == 6 ){
		            if(!isset($ite["beneficioBajo"])){
		                return ["success" => false, "errores" => [["El campo otro en los beneficios de temporada baja."]] ];
		            }
		        }
		        if($ite["id"] == 12 ){
		            if(!isset($ite["beneficioAlto"])){
		                return ["success" => false, "errores" => [["El campo otro en los beneficios de temporada alta."]] ];
		            }
		        }
		    }
		}
	
		$componente = Componente_Social::find($request->id);
		$casa = Casa_Sostenibilidad::find($request->id);
		if($componente == null){
			$componente = new Componente_Social;
			$componente->casas_sostenibilidad_id = $request->id;
		}
		
		if(isset($request["es_agradable"])){
			$componente->es_agradable = $request["es_agradable"];
		}
		$componente->calificacion = $request["calificacion"];
		$componente->criterios_calificacion_id = $request["criterios_calificacion_id"];
		if($componente->criterios_calificacion_id != 4){
			$componente->ofrece_informacion = $request->ofrece_informacion;
		}
		$componente->pertenece_gremio= $request->pertenece_gremio;
		$componente->nivel_sastifacion = $request->nivel_sastifacion;
		
		if(isset($request->cambian_turistas)){
			$componente->cambian_turistas = $request->cambian_turistas;
		}
		
		if(isset($request->conservacion_patrimonio_id)){
			$componente->conservacion_patrimonio_id = $request->conservacion_patrimonio_id;
		}
		$componente->viviendas_turisticas = $request->viviendas_turisticas;
		if(isset($request->efecto_turismo)){
			$componente->efecto_turismo = $request->efecto_turismo;
		}
		if(isset($request->positivo)){
			$componente->positivo = $request->positivo;
		}
		if(isset($request->negativo)){
			$componente->negativo = $request->negativo;
		}
		$componente->user_update = $this->user->username;
		$componente->estado = true;
		if(Componente_Social::find($request->id)==null){
			
			$componente->user_create = $this->user->username;
			$componente->save();
		}
		
		$casa->accionesCulturales()->detach();
		
		foreach($request->culturales as $it){
			if($it==9){
				$casa->accionesCulturales()->attach($it,['otro'=>$request->otroCultura]);
			}else{
				$casa->accionesCulturales()->attach($it);
			}
		}
		
		$eliminarF = Factor_Calidad_Turismo::where('casas_sostenibilidad_id',$request->id);
			
			foreach($eliminarF as $el){
				$el->delete();
			}
		
		if(isset($request->factores)){
		
			foreach($request->factores as $fac){
			
				$factor = new Factor_Calidad_Turismo;
				$factor->factores_calidad_id = $fac["id"];
				$factor->calificaciones_factor_id = $fac["calificacion"];
				$factor->casas_sostenibilidad_id = $request->id;
				if($fac["id"]==11){
					$factor->otro = $fac["otroFactor1"];
				}
				
				if($fac["id"]==29){
					$factor->otro = $fac["otroFactor2"];
				}
				
				$factor->save();
				
			}
		}
		
		$eliminarF = Factor_Positivo::where('casas_sostenibilidad_id',$request->id);
			
			foreach($eliminarF as $el){
				$el->delete();
			}
		
		if(isset($request->factoresPositivos)){
		
			foreach($request->factoresPositivos as $fac){
			
				$factor = new Factor_Positivo;
				$factor->factores_calidad_id = $fac["id"];
				$factor->calificacion = $fac["calificacion"];
				$factor->casas_sostenibilidad_id = $request->id;
				if($fac["id"]==36){
					$factor->otro = $fac["otroFactor3"];
				}
			
				$factor->save();
				
			}
		}
		
		
		$eliminarR = Riesgo_Turismo::where('casas_sostenibilidad_id',$request->id)->where('categorias_riesgo_id',1);
			
		foreach($eliminarR as $el){
			$el->delete();
		}
		if(isset($request->riesgos)){
			foreach($request->riesgos as $ris){
			
				$riesgo = new Riesgo_Turismo;
				$riesgo->tipos_riesgo_id = $ris["id"];
				$riesgo->criterios_calificacion_id = $ris["calificacion"];
				$riesgo->casas_sostenibilidad_id = $request->id;
				if($ris["id"]==8){
					$riesgo->otro = $ris["otroRiesgo"];
				}
				
				$riesgo->save();
			}
			
		}
		
		$eliminarB = Beneficio_Sociocultural::where('casas_sostenibilidad_id',$request->id);
		
		foreach($eliminarB as $el){
			$el->delete();
		}
		
		if(isset($request->beneficios)){
			foreach($request->beneficios as $ben){
			
				$beneficio = new Beneficio_Sociocultural;
				$beneficio->beneficio_id = $ben["id"];
				$beneficio->calificacion_factores_id = $ben["calificacion"];
				$beneficio->casas_sostenibilidad_id = $request->id;
				if($ben["id"]==6){
					$beneficio->otro = $ben["beneficioBajo"];
				}
				if($ben["id"]==12){
					$beneficio->otro = $ben["beneficioAlto"];
				}
				
				$beneficio->save();
			}
		
		}
		
		if($componente->viviendas_turisticas){
			$vivienda = Vivienda_Turistica_Sostenible::find($request->id);
			if($vivienda==null){
				$vivienda = new Vivienda_Turistica_Sostenible;
				$vivienda->casas_sostenibilidad_id = $componente->casas_sostenibilidad_id;
			
			}
			$vivienda->cantidad = $request->cantidad;
			$vivienda->razon_cambio = $request->razon_cambio;
			$vivienda->numero_meses = $request->numero_meses;
			$vivienda->cuantas_rnt = $request->cuantas_rnt;
			$vivienda->save();
		}
		
		$componente->save();
		
		if($casa->numero_sesion == 1){
			$casa->numero_sesion = 2;
			$casa->estado_encuesta_id = 2;
			$casa->save();
			
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 2,
	    		'casas_sostenibilidad_id' => $casa->id,
	    		'observacion' => 'Se ha creado la encuesta en la sección socio-cultural.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
			
		}else{
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 2,
	    		'casas_sostenibilidad_id' => $casa->id,
	    		'observacion' => 'Se ha editado la encuesta en la sección socio-cultural.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
		}
		
		return ["success"=>true];
    }
    
    public function getComponenteambiental($id){
    	$data = ["id"=>$id];
        return view('sostenibilidadHogar.ambiental',$data);
    }
    
    public function getInfocomponenteambiental($id){
    	
    	 $criterios = Criterio_Calificacion::all();
    	 $actividades = Actividad_Medio_Ambiente::where('es_hogar', true)->get();
    	 $acciones = Accion_Ambiental::where('estado',true)->get();
    	 $riesgos = Tipo_Riesgo::where('categorias_riesgo_id',2)->get();
    	 $casa = Casa_Sostenibilidad::find($id);
    	 $ambiente = Componente_Ambiental::find($id);
    	 
    	 if($ambiente != null){
    	 	
    	 	$ambiente["actividades"]= $casa->actividadesAmbientales()->pluck('id')->toArray();
	        $ambiente["otroActividad"]=null;
	        if(in_array(6,$ambiente["actividades"])){
	           $ambiente["otroActividad"]= $casa->actividadesAmbientales()->wherePivot('otro','!=',null)->first() != null ? $casa->actividadesAmbientales()->wherePivot('otro','!=',null)->first()->pivot->otro : null;
	        }
	        
	        $ambiente["residuos"]= $casa->accionesAmbientales()->where('tipo_accion_id',1)->pluck('id')->toArray();
	        $ambiente["otroAccion1"]=null;
	        if(in_array(15,$ambiente["residuos"])){
	           $ambiente["otroAccion1"]= $casa->accionesAmbientales()->where('tipo_accion_id',1)->wherePivot('otro','!=',null)->first() != null ? $casa->accionesAmbientales()->where('tipo_accion_id',1)->wherePivot('otro','!=',null)->first()->pivot->otro : null;
	        }
	        
	        $ambiente["aguas"]= $casa->accionesAmbientales()->where('tipo_accion_id',2)->pluck('id')->toArray();
	        $ambiente["otroAccion2"]=null;
	        if(in_array(8,$ambiente["aguas"])){
	           $ambiente["otroAccion2"]= $casa->accionesAmbientales()->where('tipo_accion_id',2)->wherePivot('otro','!=',null)->first() != null ? $casa->accionesAmbientales()->where('tipo_accion_id',2)->wherePivot('otro','!=',null)->first()->pivot->otro : null;
	        }
	        
	        foreach($riesgos as $ite){
	        	$valor = Riesgo_Turismo::where('tipos_riesgo_id',$ite["id"])->where('casas_sostenibilidad_id',$casa->id)->first();
	        	$ite["calificacion"]= $valor != null ? $valor->	criterios_calificacion_id:null;
	        	if($ite["id"]==21 && $valor != null){
	        		$ite["otroRiesgo"]= $valor->otro;
	        	}
	        }
    	 }
    	 
    	 return ["criterios"=>$criterios,"actividades"=>$actividades,"acciones"=>$acciones,"riesgos"=>$riesgos,"ambiental"=>$ambiente];
    }
    
    public function postGuardarcomponenteambiental(Request $request){
    	
    	$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:casas_sostenibilidad,id',
			'areas_protegidas' => 'required|string|max:2000',
			'criterios_calificacion_id' => 'required|exists:criterios_calificaciones,id',
			'existe_guia' => 'required_if:criterios_calificacion_id,1,2,3',
			'actividades' => 'required',
			'actividades.*' => 'exists:actividades_medio_ambientes,id',
			'residuos' => 'required',
			'residuos.*' => 'exists:acciones_ambientales,id',
			'aguas' => 'required',
			'aguas.*' => 'exists:acciones_ambientales,id',
			'riesgos' => 'array',
			'riesgos.*.id' => 'exists:tipos_riesgos,id',
			'riesgos.*.calificacion' => 'exists:criterios_calificaciones,id',
			'efecto_turismo' => 'required|boolean',
    	],[
       		
    	]);
    	
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(in_array(6,$request->actividades) && !isset($request->otroActividad) ){
			return ["success" => false, "errores" => [["El campo otro en las actividades de medio ambiente es requerido."]] ];
		}
		if(in_array(15,$request->residuos) && !isset($request->otroAccion1) ){
			return ["success" => false, "errores" => [["El campo otro en las acciones de manejo de residuos es requerido."]] ];
		}
		if(in_array(8,$request->aguas) && !isset($request->otroAccion2) ){
			return ["success" => false, "errores" => [["El campo otro en las acciones de reducción de agua es requerido."]] ];
		}
		
		if(isset($request->riesgos)){
		    foreach($request->riesgos as $ite){
		        if($ite["id"] == 21 ){
		            if(!isset($ite["otroRiesgo"])){
		                return ["success" => false, "errores" => [["El campo otro en los riesgos."]] ];
		            }
		        }
		    }
		}
		
		$casa = Casa_Sostenibilidad::find($request->id);
		$componente = Componente_Ambiental::find($request->id);
		if($componente == null){
			$componente = new Componente_Ambiental;
			$componente->casas_sostenibilidad_id = $request->id;
		}
		if(isset($request->existe_guia)){
			$componente->existe_guia = $request->existe_guia;
		}
		$componente->criterios_calificacion_id = $request["criterios_calificacion_id"];
		$componente->areas_protegidas = $request->areas_protegidas;
		$componente->efecto_turismo = $request->efecto_turismo;
		
		$componente->user_update = $this->user->username;
		$componente->estado = true;
		if(Componente_Ambiental::find($request->id)==null){
			
			$componente->user_create = $this->user->username;
			$componente->save();
		}
		
		$casa->actividadesAmbientales()->detach();
		
		foreach($request->actividades as $it){
			if($it==6){
				$casa->actividadesAmbientales()->attach($it,['otro'=>$request->otroActividad]);
			}else{
				$casa->actividadesAmbientales()->attach($it);
			}
		}
		
		$casa->accionesAmbientales()->detach();
		
		foreach($request->residuos as $it){
			if($it==15){
				$casa->accionesAmbientales()->attach($it,['otro'=>$request->otroAccion1]);
			}else{
				$casa->accionesAmbientales()->attach($it);
			}
		}
		
		foreach($request->aguas as $it){
			if($it==8){
				$casa->accionesAmbientales()->attach($it,['otro'=>$request->otroAccion2]);
			}else{
				$casa->accionesAmbientales()->attach($it);
			}
		}
		
		
		$eliminarR = Riesgo_Turismo::where('casas_sostenibilidad_id',$request->id)->where('categorias_riesgo_id',2);
			
		foreach($eliminarR as $el){
			$el->delete();
		}
		if(isset($request->riesgos)){
			foreach($request->riesgos as $ris){
			
				$riesgo = new Riesgo_Turismo;
				$riesgo->tipos_riesgo_id = $ris["id"];
				$riesgo->criterios_calificacion_id = $ris["calificacion"];
				$riesgo->casas_sostenibilidad_id = $request->id;
				if($ris["id"]==21){
					$riesgo->otro = $ris["otroRiesgo"];
				}
				
				$riesgo->save();
			}
			
			
		}
		$casa->save();
		$componente->save();
		
		if($casa->numero_sesion == 2){
			$casa->numero_sesion = 3;
			$casa->estado_encuesta_id = 2;
			$casa->save();
			
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 2,
	    		'casas_sostenibilidad_id' => $casa->id,
	    		'observacion' => 'Se ha creado la encuesta en la sección ambiental.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
			
		}else{
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 2,
	    		'casas_sostenibilidad_id' => $casa->id,
	    		'observacion' => 'Se ha editado la encuesta en la sección ambiental.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
		}
			
		return ["success"=>true];
		
    }
    
    public function getEconomico($id){
    	if(Casa_Sostenibilidad::find($id) == null){
    		return "no";
    	}else{
    		return view('sostenibilidadHogar.economico',["id" => $id]);
    	}
    }
    
    public function getCargardatoseconomico($id){
    	$sectoresTurismo = Sectores_Turismo::all();
    	$sectoresEconomia = Sectores_Economia::all();
    	$beneficios = Beneficio::where('tipo_beneficio',true)->where('id', '<>',26)->where('id', '<>',28)->orderBy('peso')->get();
    	$calificacionesFactor = Calificacion_Factor::all();
    	$tiposRiesgos = Tipo_Riesgo::where('categorias_riesgo_id',3)->get();
    	$criteriosCalificacion = Criterio_Calificacion::all();
    	
    	$encuesta = Casa_Sostenibilidad::find($id);
    	$objeto = null;
    	if($encuesta->componenteTecnico){
			$objeto['contribuira'] = !isset($encuesta->componenteTecnico->contribuira) ? -1 : $encuesta->componenteTecnico->contribuira;
			$objeto['aspectos_mejorar'] = $encuesta->componenteTecnico->aspectos_mejorar;
    		$objeto['sectoresTurismo'] = $encuesta->sectoresTurismosSostenibilidads->pluck('id')->toArray();
    		$objeto['otroSectorTurismo'] = in_array(7,$objeto['sectoresTurismo']) ? $encuesta->sectoresTurismosSostenibilidads->where('id',7)->first()->pivot->otro : null;
    		$objeto['es_fuente'] = !in_array(6,$objeto['sectoresTurismo']) ? $encuesta->componenteTecnico->es_fuente : null;
    		$objeto['sectoresEconomia'] = !in_array(6,$objeto['sectoresTurismo']) ? $encuesta->sectoresEconomiaSostenibilidads->pluck('id')->toArray() : array();
    		$objeto['otroSectorEconomia'] = in_array(12,$objeto['sectoresEconomia']) ? $encuesta->sectoresEconomiaSostenibilidads->where('id',12)->first()->pivot->otro : null;
    		$objeto['impacto_economico'] = $encuesta->componenteTecnico->impacto_economico;
    		$objeto['conoce_marca'] = $encuesta->conoce_marca;
    		$objeto['autoriza_tratamiento'] = $encuesta->autoriza_tratamiento;
    		$objeto['autorizacion'] = $encuesta->autorizacion;
    		
    		foreach($beneficios as $item){
    			$beneficio = Beneficio_Sociocultural::where('casas_sostenibilidad_id',$encuesta->id)->where('beneficio_id',$item['id'])->first();
				if($beneficio){
					$item['califcacion'] = $beneficio->calificacion_factores_id;
    				$item['otroBeneficio'] = $beneficio->otro;	
				}
    		}
    		$objeto['beneficios'] = $beneficios;
    		
    		foreach($tiposRiesgos as $item){
    			$riesgo = Riesgo_Turismo::where('casas_sostenibilidad_id',$encuesta->id)->where('tipos_riesgo_id', $item['id'])->first();
				if($riesgo){
					$item['califcacion'] = $riesgo->criterios_calificacion_id;
    				$item['otroRiesgo'] = $riesgo->otro;	
				}
    		}
    		$objeto['tiposRiesgos'] = $tiposRiesgos;
    			
    	}
    	
    	$retornado = [
    		'sectoresTurismo' => $sectoresTurismo,
    		'sectoresEconomia' => $sectoresEconomia,
    		'beneficios' => $beneficios,
    		'calificacionesFactor' => $calificacionesFactor,
    		'tiposRiesgos' => $tiposRiesgos,
    		'criteriosCalificacion' => $criteriosCalificacion,
    		'objeto' => $objeto
    	];
    	
    	return $retornado;
    }
    
    public function postGuardareconomico(Request $request){
    	$validator = \Validator::make($request->all(), [
			'hogar_id' => 'required|exists:casas_sostenibilidad,id',
			'contribuira' => 'required',
			'aspectos_mejorar' => 'required_if:contribuira,1',
			'sectoresTurismo' => 'required',
			'sectoresTurismo.*' => 'exists:sectores_turismos,id',
			'sectoresEconomia' => 'exists:sectores_economia,id',
			'beneficios' => 'required',
			'beneficios.*.id' => 'exists:beneficios,id',
			'beneficios.*.califcacion' => 'exists:calificaciones_factores,id',
			'impacto_economico' => 'required',
			'tiposRiesgos' => 'required',
			'tiposRiesgos.*.id' => 'exists:tipos_riesgos,id',
			'tiposRiesgos.*.califcacion' => 'exists:criterios_calificaciones,id',
			'conoce_marca' => 'required',
			'autoriza_tratamiento' => 'required',
			'autorizacion' => 'required'
    	],[
       		
    	]);
    	
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if( !in_array(6,$request->sectoresTurismo) && !isset($request->es_fuente) ){
			return ["success" => false, "errores" => [["El campo fuente de generación de ingreso es reuqerido si en los secotres no marco ninguno."]] ];
		}
		
		if(!in_array(6,$request->sectoresTurismo) && count($request->sectoresEconomia) == 0 ){
			return ["success" => false, "errores" => [["Debe seleccionar alguna de las actividades económicas si en los secotres no marco ninguno."]] ];
		}
		
		if(in_array(7,$request->sectoresTurismo) && !isset($request->otroSectorTurismo) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 22 es requerido."]] ];
		}
		
		if(in_array(12,$request->sectoresEconomia) && !isset($request->otroSectorEconomia) ){
			return ["success" => false, "errores" => [["El campo otro en la pregunta 22.2 es requerido."]] ];
		}
		
		$encuesta = Casa_Sostenibilidad::find($request->hogar_id);
		
		//----------------------------------------------------------------
		if($encuesta->componenteTecnico){
			$encuesta->componenteTecnico->delete();
		}
		$encuesta->sectoresTurismosSostenibilidads()->detach();
		$encuesta->sectoresEconomiaSostenibilidads()->detach();
		//----------------------------------------------------------------
		
		$tecnico = new Componente_Tecnico();
		$tecnico->casas_sostenibilidad_id = $encuesta->id;
		$tecnico->contribuira =$request->contribuira == -1 ? null : $request->contribuira;
		$tecnico->aspectos_mejorar = $request->contribuira == 1 ? $request->aspectos_mejorar : null;
		$tecnico->es_fuente = !in_array(6,$request->sectoresTurismo) ? $request->es_fuente : null;
		$tecnico->impacto_economico = $request->impacto_economico;
		$tecnico->save();
		
		foreach($request->sectoresTurismo as $item){
			if($item != 7){
				$encuesta->sectoresTurismosSostenibilidads()->attach($item);	
			}else{
				$encuesta->sectoresTurismosSostenibilidads()->attach($item,['otro' => $request->otroSectorTurismo]);
			}
		}
		
		if( !in_array(6,$request->sectoresTurismo) ){
			foreach($request->sectoresEconomia as $item){
				if($item != 12){
					$encuesta->sectoresEconomiaSostenibilidads()->attach($item);	
				}else{
					$encuesta->sectoresEconomiaSostenibilidads()->attach($item,['otro' => $request->otroSectorEconomia]);
				}
			}
		}
		
		foreach($request->beneficios as $item){
			if( isset($item['califcacion']) ){
				$beneficio = Beneficio_Sociocultural::where('casas_sostenibilidad_id',$encuesta->id)->where('beneficio_id',$item['id'])->first();
				if($beneficio){
					$beneficio->calificacion_factores_id = $item['califcacion'];
					$beneficio->otro = ($item['id'] == 18 && isset($item['otroBeneficio'])) || ($item['id'] == 24 && isset($item['otroBeneficio'])) ? $item['otroBeneficio'] : null ;
					$beneficio->save();
				}else{
					Beneficio_Sociocultural::create([
						'calificacion_factores_id' => $item['califcacion'],
						'casas_sostenibilidad_id' => $encuesta->id,
						'beneficio_id' => $item['id'],
						'otro' => ($item['id'] == 18 && isset($item['otroBeneficio'])) || ($item['id'] == 24 && isset($item['otroBeneficio'])) ? $item['otroBeneficio'] : null 
					]);	
				}	
			}
		}
		
		foreach($request->tiposRiesgos as $item){
			$riesgo = Riesgo_Turismo::where('casas_sostenibilidad_id',$encuesta->id)->where('tipos_riesgo_id', $item['id'])->first();
			if($riesgo){
				$riesgo->criterios_calificacion_id = $item['califcacion'];
				$riesgo->otro = $item['id'] == 28 && isset($item['otroRiesgo']) ? $item['otroRiesgo'] : null;
				$riesgo->save();
			}else{
				Riesgo_Turismo::create([
					'criterios_calificacion_id' => $item['califcacion'],
					'casas_sostenibilidad_id' => $encuesta->id,
					'tipos_riesgo_id' => $item['id'],
					'otro' => $item['id'] == 28 && isset($item['otroRiesgo']) ? $item['otroRiesgo'] : null 
				]);	
			}
		}
		
		$encuesta->conoce_marca = $request->conoce_marca;
		$encuesta->autoriza_tratamiento = $request->autoriza_tratamiento;
		$encuesta->autorizacion = $request->autorizacion;
		$encuesta->save();
		
		if($encuesta->numero_sesion == 3){
			$encuesta->numero_sesion = 4;
			$encuesta->estado_encuesta_id = 3;
			$encuesta->save();
			
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 3,
	    		'casas_sostenibilidad_id' => $encuesta->id,
	    		'observacion' => 'Se ha creado la encuesta en la sección económico.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
			
		}else{
			Historial_Encuesta_Hogar_Sostenibilidad::create([
	    		'estado_encuesta_id' => 3,
	    		'casas_sostenibilidad_id' => $encuesta->id,
	    		'observacion' => 'Se ha editado la encuesta en la sección económico.',
	    		'fecha_cambio' => date('Y-m-d H:i'),
	    		'estado' => 1,
	    		'user_create' => $this->user->username,
	    		'user_update' => $this->user->username
	    	]);
		}
		
		return ["success" => true];
    }
    
    public function getEncuestas(){
		return view('sostenibilidadHogar.listadoEncuestas');
	}
    
    public function getListarencuestas(){
		$encuestas = ListadoEncuestasHogarSostenibilidad::all();
		return ['encuestas' => $encuestas];
	}
    
}
