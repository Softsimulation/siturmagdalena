<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Municipio;
use App\Models\Nivel_Educacion;
use App\Models\Motivo_No_Viaje;
use App\Models\Estrato;
use App\Models\Barrio;
use App\Models\EstadosCiviles;
use App\Models\Ocupacion;


use App\Models\Edificacion;
use App\Models\Hogar;
use App\Models\Persona;
use App\Models\No_Viajero;
use App\Models\Transporte;
use App\Models\Tipo_Transporte;
use App\Models\Tipo_Transporte_Con_Idioma;
use App\Models\Viaje;
use App\Models\Empresa_Terrestre_Interno;
use App\Models\Historial_Encuesta_Interno;

use App\Models\Rubro_Interno;
use App\Models\Financiador_Viaje;
use App\Models\Viaje_Financiadore;
use App\Models\Viaje_Gasto_Interno;
use App\Models\Viaje_Excursion;
use App\Models\Servicio_Paquete_Interno;
use App\Models\Opcion_Lugar;
use App\Models\Divisa;
use App\Models\Servicio_Excursion_Incluido_Interno;
use App\Models\Lugar_Agencia_Viaje;
use App\Models\Pago_Peso_Colombiano;

use App\Models\Pais_Con_Idioma;
use App\Models\Departamento;
use App\Models\Tipo_Alojamiento_Con_Idioma;
use App\Models\Acompaniante_Viaje;
use App\Models\Frecuencia_Viaje;
use App\Models\Motivo_Viaje_Con_Idioma;
use App\Models\Motivo_Viaje;
use App\Models\Actividad_Realizada;
use App\Models\Tipo_Atraccion;
use App\Models\Atracciones;
use App\Models\Atraccion_Por_Tipo_Actividad_Realizada;
use App\Models\Actividad_Realizada_Con_Actividad;
use App\Models\Municipio_Visitado_Magdalena;
use App\Models\Atraccion_Visitada_Interno;
use App\Models\Lugar_Visitado_Interno;
use App\Models\Actividad_Realizada_Interno;
use App\Models\Actividad_Realizada_Viajero;

use App\Models\Opcion_Actividad_Realizada;
use App\Models\Sub_Opcion_Actividad_Realizada_Interno;
use App\Models\Opcion_Actividad_Realizada_Interno;

use App\Models\Ciudad_Visitada;
use App\Models\Acompaniante_Viaje_Hogar;
use App\Models\Otros_Turistas_Interno;

use App\Models\Ubicacion_Agencia_Viaje;

use App\Models\Fuente_Informacion_Antes_Viaje_Con_Idioma;
use App\Models\Fuente_Informacion_Durante_Viaje_Con_Idioma;
use App\Models\Redes_Sociales;
use App\Models\Experiencia_Departamento;
use App\Models\Valor_Calificacion;
use App\Models\Otra_Fuente_Informacion_Antes_Viaje_Interno;
use App\Models\Viajero_Redes_Sociales;
use App\Models\Fuente_Informacion_Antes_Viaje_Interno;
use App\Models\Fuente_Informacion_Durante_Viaje_Interno;
use App\Models\Calificacion_Experiencia_Interno;
use App\Models\Redes_Sociales_Viajero;
use App\Models\Otra_Fuente_Informacion_Durante_Viaje_Interno;
use App\Models\Tipo_Transporte_Interno;
use App\Models\Alquila_Vehiculo_Interno;


class TurismoInternoController extends Controller
{
    public function __construct()
    {
        $this->middleware('interno', ['only' => ['getViajesrealizados','getActividadesrealizadas']]);
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
    public function getDatoshogar(){
        
        $municipios=Municipio::where('departamento_id',1411)->get();
        $niveles=Nivel_Educacion::get();
        $motivos=Motivo_No_Viaje::get();
        $estratos=Estrato::get();
        $estados=EstadosCiviles::get();
        $ocupaciones=Ocupacion::get();
        return ["municipios"=>$municipios,'niveles'=>$niveles,'motivos'=>$motivos,'estratos'=>$estratos,'estados'=>$estados,'ocupaciones'=>$ocupaciones];
        
    }
    
    public function postBarrios(Request $request){
        
        $barrios=Barrio::where('municipio_id',$request->id)->get();
        return ['barrios'=>$barrios];
        
    }
    
    public function getHogar($one){
        $id=$one;
        return view('turismointerno.Hogar',compact('id'));
    }
    
    public function postGuardarhogar(Request $request){
        
         $validator=\Validator::make($request->all(),[
                
                'Fecha_aplicacion'=>'required|date|before:tomorrow',
                'Barrio'=>'required|exists:barrios,id',
                'Estrato'=>'required|exists:estratos,id',
                'Direccion'=>'required',
                'Telefono'=>'regex:^([0-9]){7}^',
                'Nombre_Entrevistado'=>'required',
                'Celular_Entrevistado'=>'numeric',
                'Email_Entrevistado'=>'email'
            ],["Telefono.regex"=>"El telefono debe tener minimos 7 digitos","Fecha_aplicacion.tomorrow"=>"La fecha de aplicacion debe ser menor a la fecha de hoy"]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
             
         if($request->integrantes[$request->jefe_hogar]["Edad"]<16){
             
                 return ["success"=>false,'errores'=>[["El jefe de hogar debe ser mayor a 15 años"]]];
             
         }
             
         
        
        
        $edificacion=new Edificacion();
        $edificacion->direccion=$request->Direccion;
        $edificacion->barrio_id=$request->Barrio;
        $edificacion->estrato_id=$request->Estrato;
        $edificacion->temporada_id=$request->Temporada_id;
        $edificacion->nombre_entrevistado=$request->Nombre_Entrevistado;
        $edificacion->telefono_entrevistado=$request->Celular_Entrevistado;
        $edificacion->email_entrevistado=$request->Email_Entrevistado;
        $edificacion->user_create= $this->user->username;
        $edificacion->user_update= $this->user->username;
        $edificacion->save();
        
        $hogar=new Hogar();
        $hogar->fecha_realizacion=$request->Fecha_aplicacion;
        $hogar->digitadores_id= $this->user->digitador->id;
        $hogar->telefono=$request->Telefono;
        $hogar->edificaciones_id=$edificacion->id;
        $hogar->save();
        
        $i=0;
        foreach($request->integrantes as $personaux){
            
             $persona=new Persona();
             $persona->nombre=$personaux["Nombre"];
             $persona->jefe_hogar=($i==$request->jefe_hogar)?true:false;
             $persona->sexo=$personaux["Sexo"];
             $persona->edad=$personaux["Edad"];
             $persona->es_viajero=$personaux["Viaje"];
             $persona->nivel_educacion=$personaux["Nivel_Educacion"];
             $persona->estado_civil_id=$personaux["Civil"];
             $persona->es_residente=$personaux["Vive"];
             $persona->ocupacion_id=$personaux["Ocupacion"];
             $persona->hogar_id=$hogar->id;
             $persona->save();
             
             if($persona->es_viajero=="0"){
             
                 $noviajo=new No_Viajero();
                 $noviajo->motivo_no_viaje_id=$personaux["Motivo"];
                 $noviajo->persona_id=$persona->id;
                 $noviajo->save();
             
             }
             
             
         $i++;    
        }
        return ["success"=>true,"id"=>$hogar->id];
    }
    
    public function getEditarhogar($one){
        $id=$one;
        
        return view('turismointerno.EditarHogar',compact('id'));
    }
    
    public function postDatoseditar(Request $request){
        
        $datos=$this->getDatoshogar();
        $encuesta=Hogar::where('id',$request->id)
                  ->with('edificacione')
                  ->with('edificacione.barrio')
                  ->first();
        $encuesta->fecha_realizacion=new \Carbon\Carbon($encuesta->fecha_realizacion);
        $encuesta->fecha_realizacion=$encuesta->fecha_realizacion->format('Y-m-d h:i');
        $encuesta->personas=Persona::where('hogar_id',$encuesta->id)->with('motivoNoViajes')->get();
        $barrios=Barrio::where('municipio_id',$encuesta->edificacione->barrio->municipio_id)->get();
        return ["datos"=>$datos,"encuesta"=>$encuesta,"barrios"=>$barrios];
        
    }
    
    public function postEliminarpersona(Request $request){
        
        $persona=Persona::find($request->id);
        if($persona==null){
            return ['success'=>false, "error"=>"La persona seleccionada no existe"];
        }
        if($persona->viajes->count()>0){
            return ["success"=>false,"error"=>"La persona tiene viajes registrados no puede ser eliminado"];
        }
        if($persona->motivoNoViajes->count()>0){
            
            $aux=No_Viajero::where('persona_id',$request->id)->delete();
        }
        $persona->delete();
        
        return ["success"=>true];
        
    }
    
    public function postGuardareditarhogar(Request $request){
        
         $validator=\Validator::make($request->all(),[
                
                'Fecha_aplicacion'=>'required|date|before:tomorrow',
                'Barrio'=>'required|exists:barrios,id',
                'Estrato'=>'required|exists:estratos,id',
                'Direccion'=>'required',
                'Telefono'=>'regex:^([0-9]){7}^',
                'Nombre_Entrevistado'=>'required',
                'Celular_Entrevistado'=>'numeric',
                'Email_Entrevistado'=>'email'
            ],["Telefono.regex"=>"El telefono debe tener minimos 7 digitos","Fecha_aplicacion.tomorrow"=>"La fecha de aplicacion debe ser menor a la fecha de hoy"]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        foreach($request->integrantes as $personaux){
             
             if($personaux["jefe_hogar"]=="true"){
                 if($personaux["Edad"]<16){
                     return ["success"=>false,'errores'=>[["El jefe de hogar debe ser mayor a 15 años"]]];
                 }
             }
             
         }
        
        $hogar=Hogar::find($request->id);
        $hogar->fecha_realizacion=$request->Fecha_aplicacion;
        $hogar->digitadores_id=$this->user->digitador->id;
        $hogar->telefono=$request->Telefono;
        $hogar->save();
        
        $edificacion=Edificacion::find($hogar->edificaciones_id);
        $edificacion->direccion=$request->Direccion;
        $edificacion->barrio_id=$request->Barrio;
        $edificacion->estrato_id=$request->Estrato;
        $edificacion->nombre_entrevistado=$request->Nombre_Entrevistado;
        $edificacion->telefono_entrevistado=$request->Celular_Entrevistado;
        $edificacion->email_entrevistado=$request->Email_Entrevistado;
        $edificacion->user_update=$this->user->username;
        $edificacion->save();
        
      
        foreach($request->integrantes as $personaux){
            
            if(array_key_exists("id",$personaux)){
                
                $persona=Persona::find($personaux["id"]);
                if($persona->es_viajero=="0"){
                    $aux=No_Viajero::where('persona_id',$persona->id)->delete();
                }
                
            }else{
                
                $persona=new Persona();
            }
            
            
             
             $persona->nombre=$personaux["Nombre"];
             $persona->jefe_hogar=(array_key_exists("jefe_hogar",$personaux))?$personaux["jefe_hogar"]:false;
             $persona->sexo=$personaux["Sexo"];
             $persona->edad=$personaux["Edad"];
             $persona->es_viajero=$personaux["Viaje"];
             $persona->nivel_educacion=$personaux["Nivel_Educacion"];
             $persona->estado_civil_id=$personaux["Civil"];
             $persona->es_residente=$personaux["Vive"];
             $persona->ocupacion_id=$personaux["Ocupacion"];
             $persona->hogar_id=$hogar->id;
             $persona->save();
             
             
             if($persona->es_viajero=="0"){
                 
                
                 $noviajo=new No_Viajero();
                 $noviajo->motivo_no_viaje_id=$personaux["Motivo"];
                 $noviajo->persona_id=$persona->id;
                 $noviajo->save();
             
             }
        }
        
        return ["success"=>true,"id"=>$hogar->id];
    }
    
    
    public function getActividadesrealizadas($one){
        $id = $one;
        $idpersona=Viaje::find($one)->personas_id;
        return view('turismointerno.ActividadesRealizadas',compact('id','idpersona'));
    }
    
    public function getActividades($id = null){
        
        $actividadesrealizadas = Actividad_Realizada::where('estado',1)->with(["actividadesRealizadasConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('actividad_realizada_id','nombre');
        },"opcionesActividadesRealizadasInternos" =>  function($q){ $q->with(["subOpcionesActividadesRealizadasInternos"]); }])->get();
        
    
        
        $viaje = Viaje::where("id","=",$id)->first();
        $encuesta = collect();
        $datosactividad = [];
        $datosopciones =  [];
        $datossub = [];
        if($viaje->ultima_sesion >= 2){

         $sw = 0;
         foreach($actividadesrealizadas as $data){
      
             if(sizeof($viaje->actividadesRealizadasInternos()->where('id',$data->id)->get()) > 0){
                     $objeto = $viaje->actividadesRealizadasInternos->where('id',$data->id)->first();
                      $data["otro"] = $objeto->pivot->otro;
                 array_push($datosactividad,$data);
             }
                
           if(count($data->opcionesActividadesRealizadasInternos)>0){
              
                 $sw = 0;
                  foreach($data->opcionesActividadesRealizadasInternos as $data2){
                  
                       if(sizeof($viaje->opcionesActividadesRealizadasInternos()->where('id',$data2->id)->get())){
                           $sw = 1;
                         $objeto = $viaje->opcionesActividadesRealizadasInternos->where('id',$data2->id)->first();
                         $data2["otro"] = $objeto->pivot->otro;
                         array_push($datosopciones,$data2);
                     }
                      
                  }
                 
                 if($sw == 1){

                      array_push($datosactividad,$data);
                     
                 }
             }
                   
             
         }
         
         
            
      
        }
        
        $enlaces = collect();
        $enlaces['Actividadesrelizadas'] = $actividadesrealizadas;
        $encuesta["ActividadesRelizadas"] = $datosactividad;
         $encuesta["OpcionesActividades"] = $datosopciones;  
         $encuesta["SubOpcionesActividades"] = $datossub;  
        $retorno = [
            'Enlaces' => $enlaces,
            'encuesta' => $encuesta
        ];
        
        return $retorno;
    }
    
    public function postCrearestancia(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:viajes,id',
			'ActividadesRelizadas' => 'required',
			'ActividadesRelizadas.id*' => 'exists:actividades_realizadas,id',
			'OpcionesActividades.id*' => 'exists:opciones_actividades_realizadas_interno,id',
			'SubOpcionesActividades.id*' => 'exists:sub_opciones_actividades_realizadas_interno,id',
		
    	],[
       		'Id.required' => 'Debe seleccionar el viaje  a realizar no se encuentra.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
       		'ActividadesRelizadas.required' => 'Debe seleccionar por lo menos una actividad realizada.',
       		'ActividadesRelizadas.*.exists' => 'Alguna de las actividades realizadas no se encuentra registrada en el sistema.',
       		'OpcionesActividades.*.exists' => 'Alguna de las opciones actividades realizadas no se encuentra registrada en el sistema.',
       		'SubOpcionesActividades.*.exists' => 'Alguna de las subopciones actividades realizadas no se encuentra registrada en el sistema.',
       	
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		
		
		$viaje = Viaje::find($request->Id);
		

		if(collect($request->ActividadesRelizadas)->where("id",23)->count() > 0){
		    if( count($request->ActividadesRelizadas) > 1 ){
		        return ["success" => false, "errores" => [["Si selecciona la opción ninguna no puede seleccionar otras actividades."]] ];    
		    }
		}
		
		foreach($request->ActividadesRelizadas as $actividad){
		    $opciones = Opcion_Actividad_Realizada::where("actividad_realizada_id",$actividad["id"])->get();
		    
	            if(sizeof($opciones) > 0 ){
	                  if(collect($request->OpcionesActividades)->where("actividad_realizada_id",$actividad["id"])->count() == 0){
    		           
    		             return ["success" => false, "errores" => [["Si selecciona la opción ".$actividad["actividades_realizadas_con_idiomas"][0]["nombre"]." debe elegir alguna opcíon de segundo nivel"]],"opcion"=>$request->OpcionesActividades,"sd"=> $actividad]; 
	                }
	            }
		    
		}
		
		$sw = 0;
	    $viaje->actividadesRealizadasInternos()->detach();
	    $viaje->opcionesActividadesRealizadasInternos()->detach();
	    $viaje->subOpcionesActividadesRealizadasInternos()->detach();

		if($viaje->ultima_sesion >= 2){
		    $sw =1;
	
	         
		}else{
		    $viaje->ultima_sesion = 2;
		}
		
		foreach($request->ActividadesRelizadas as $actividad){
		  
	            if(sizeof(Opcion_Actividad_Realizada::where("actividad_realizada_id",$actividad["id"])->get()) == 0 ){
	                 if(collect($actividad)->has("otro")){
	                        $viaje->actividadesRealizadasInternos()->attach($actividad["id"],['otro' => $actividad['otro']]);
	                 }else{
	                      $viaje->actividadesRealizadasInternos()->attach($actividad["id"]);
	                 }
	            }
		    
		}
			if($request->OpcionesActividades != null){
            		foreach($request->OpcionesActividades as $actividad){
            	            if(sizeof(Sub_Opcion_Actividad_Realizada_Interno::where("opciones_actividades_realizada_interno_id",$actividad["id"])->get()) == 0 ){
            	                if(collect($actividad)->has("otro")){
            	                $viaje->opcionesActividadesRealizadasInternos()->attach($actividad["id"],['otro' => $actividad['otro']]);
            	            
            	                }else{
            	                    
            	                    $viaje->opcionesActividadesRealizadasInternos()->attach($actividad["id"]);
            	                        }
            	                }
            		    
            		}
			}
		if($request->SubOpcionesActividades != null){
		
        foreach($request->SubOpcionesActividades as $actividad){
	       
	        $viaje->subOpcionesActividadesRealizadasInternos()->attach($actividad["id"]);

		    
		}
		}
		
		$viaje->save();
		
		$historial=new Historial_Encuesta_Interno();
        $historial->viajes_id=$viaje->id;
        $historial->estado_id=($viaje->ultima_sesion != 7)?2:3;
        $historial->digitador_id=$this->user->digitador->id;
        $historial->fecha_cambio=\Carbon\Carbon::now();
        $historial->mensaje=($sw==0)?"Se completó la sección de actividades realizadas":"Se editó la sección de actividades realizadas";
        $historial->save();
        return ["success" => true];
    }
    
    public function getFuentesinformacion($one){
        $id=$one;
        return view('turismointerno.FuentesInformacion',compact('id'));
    }
    
    public function getCargardatosfuentes($one){
        
        $viaje=Viaje::find($one);
        
        $fuentesAntes=Fuente_Informacion_Antes_Viaje_Con_Idioma::
            whereHas('idioma',function($q){
                $q->where('culture','es');
            })->whereHas('fuentesInformacionAntesViaje',function($q){
                $q->where('estado',true);
             })->get(['fuentes_informacion_antes_viaje_id as id','nombre']);
             
        $fuentesDurante=Fuente_Informacion_Durante_Viaje_Con_Idioma::
            whereHas('idioma',function($q){
                $q->where('culture','es');
            })->whereHas('fuentesInformacionDuranteViaje',function($q){
                $q->where('estado',true);
             })->get(['fuente_informacion_durante_viaje_id as id','nombre']);
             
        $redes=Redes_Sociales::where('estado',true)->get();
        
        $experiencias=Experiencia_Departamento::where('estado',true)->get(["id","items as nombre","experiencias as tipo"]);
        foreach($experiencias as $exp){
            $experiencias->valor=-1;
        }
        $calificaciones=Valor_Calificacion::where('estado',true)->get(['id','valor as nombre']);
        $fuentes_antes=[];
        $fuentes_durante=[];
        $compar_redes=[];
        $OtroFuenteAntes="";
        $OtroFuenteDurante="";
        $facebook="";
        $twitter="";
        $invitacion=0;
        $invitacion_correo=0;
        
        if($viaje->ultima_sesion>=4){
            
            $fuentes_antes=$viaje->fuentesInformacionAntesViajes()->get(['fuentes_informacion_antes_id'])->pluck('fuentes_informacion_antes_id')->toArray();
            $fuentes_durante=$viaje->fuentesInformacionDuranteViajes()->get(['fuente_informacion_durante_id'])->pluck('fuente_informacion_durante_id')->toArray();
            $compar_redes=$viaje->redesSociales()->get(['redes_sociales_id'])->pluck('redes_sociales_id')->toArray();
           
            
            if(in_array(14,$fuentes_antes)){
                
                $OtroFuenteAntes=$viaje->otrasFuentesInformacionAntesViajeInterno->nombre;
                
            }
            
            if(in_array(14,$fuentes_durante)){
                
                $OtroFuenteDurante=$viaje->otrasFuentesInformacionDuranteViajeInterno->nombre;
                
            }
            $otro=$viaje->viajeroRedesSociale()->first();
            
            if($otro != null){
                $facebook=$otro->nombre_facebook;
                $twitter=$otro->nombre_twitter;
            }
            if($facebook != "" && $twitter!=""){
                
                $invitacion=1;
                
            }
            
            $invitacion_correo=$viaje->invitacion_correo;
            
            foreach($experiencias as $expe){
                $expe->valor=($viaje->calificacionExperienciaInternos()->where('experiencias_departamento_id',$expe->id)->first() != null)?$viaje->calificacionExperienciaInternos()->where('experiencias_departamento_id',$expe->id)->first()->valor_calificacion_id:-1;
            }
            
        }
        
        return ['fuentesAntes'=>$fuentesAntes,
                'fuentesDurante'=>$fuentesDurante,
                'redes'=>$redes,
                'experiencias'=>$experiencias,
                'calificaciones'=>$calificaciones,
                'fuentes_antes'=>$fuentes_antes,
                'fuentes_durante'=>$fuentes_durante,
                'compar_redes'=>$compar_redes,
                'OtroFuenteAntes'=>$OtroFuenteAntes,
                'OtroFuenteDurante'=>$OtroFuenteDurante,
                'facebook'=>$facebook,
                'twitter'=>$twitter,
                'invitacion'=>$invitacion,
                'invitacion_correo'=>$invitacion_correo
                ];
    }
    
    public function postGuardarfuentesinformacion(Request $request){
        
         $validator=\Validator::make($request->all(),[
                
                'id'=>'required|exists:viajes,id',
                'FuentesAntes'=>'required|min:1',
                'FuentesDurante'=>'required|min:1',
                'Redes'=>'required|min:1',
                'Correo'=>'required',
                'Invitacion'=>'required',
                'Experiencias'=>'required'
            ]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $sw=0;
        
        $viaje=Viaje::find($request->id);
        
        if($viaje->ultima_sesion>=5){
            $sw=1;
        }
      
            
            
            if(in_array(14,$viaje->fuentesInformacionAntesViajes()->get(['fuentes_informacion_antes_id'])->pluck('fuentes_informacion_antes_id')->toArray())){
                
                Otra_Fuente_Informacion_Antes_Viaje_Interno::where('viajes_id',$viaje->id)->delete();
                
            }
            
            if(in_array(14,$viaje->fuentesInformacionDuranteViajes()->get(['fuente_informacion_durante_id'])->pluck('fuente_informacion_durante_id')->toArray())){
                
                Otra_Fuente_Informacion_Durante_Viaje_Interno::where('viajes_id',$viaje->id)->delete();
                
            }
            
            if($viaje->viajeroRedesSociale()->first() != null){
                
                Viajero_Redes_Sociales::where('viajes_id',$viaje->id)->delete();
            }
            
            Fuente_Informacion_Antes_Viaje_Interno::where('viajes_id',$viaje->id)->delete();
            Fuente_Informacion_Durante_Viaje_Interno::where('viajes_id',$viaje->id)->delete();
            Redes_Sociales_Viajero::where('viajero_id',$viaje->id)->delete();
            Calificacion_Experiencia_Interno::where('viajes_id',$viaje->id)->delete();
            
            
       
        
        foreach($request->FuentesAntes as $idantes){
            
            $antes=new Fuente_Informacion_Antes_Viaje_Interno();
            $antes->fuentes_informacion_antes_id=$idantes;
            $antes->viajes_id=$viaje->id;
            $antes->save();
           
            
        }
        
        if(in_array(14,$request->FuentesAntes)){
            
            $otra=new Otra_Fuente_Informacion_Antes_Viaje_Interno();
            $otra->nombre=$request->OtroFuenteAntes;
            $otra->viajes_id=$viaje->id;
            $otra->save();
            
            
        }
        
        foreach($request->FuentesDurante as $iddurantes){
            
            $antes=new Fuente_Informacion_Durante_Viaje_Interno();
            $antes->fuente_informacion_durante_id=$iddurantes;
            $antes->viajes_id=$viaje->id;
            $antes->save();
            
            
        }
        
        if(in_array(14,$request->FuentesDurante)){
            
            $otra=new Otra_Fuente_Informacion_Durante_Viaje_Interno();
            $otra->nombre=$request->OtroFuenteDurante;
            $otra->viajes_id=$viaje->id;
            $otra->save();
            
        }
        
        foreach($request->Redes as $idred){
            
            $red=new Redes_Sociales_Viajero();
            $red->redes_sociales_id=$idred;
            $red->viajero_id=$viaje->id;
            $red->save();
            
        }
        
        if($request->Invitacion==1){
            
            $redes=new Viajero_Redes_Sociales();
            $redes->nombre_facebook=$request->NombreFacebook;
            $redes->nombre_twitter=$request->NombreTwitter;
            $redes->viajes_id=$viaje->id;
            $redes->save();
        }
        
        if(count($request->Experiencias)>0){
            
            foreach($request->Experiencias as $expe){
                
                if($expe["valor"]>0){
                    
                    $cali=new Calificacion_Experiencia_Interno();
                    $cali->valor_calificacion_id=$expe["valor"];
                    $cali->experiencias_departamento_id =$expe["id"];
                    $cali->viajes_id=$viaje->id;
                    $cali->save();
                    
                }
                
            }
            
        }
        $viaje->invitacion_correo=($request->Correo==0)?false:true;
        $viaje->ultima_sesion=($sw==0)?7:$viaje->ultima_sesion;
        $viaje->save();
        
        $historial=new Historial_Encuesta_Interno();
        $historial->viajes_id=$viaje->id;
        $historial->estado_id=($viaje->ultima_sesion!=7)?2:3;
        $historial->digitador_id=$this->user->digitador->id;
        $historial->fecha_cambio=\Carbon\Carbon::now();
        $historial->mensaje=($sw==0)?"Se completó la sección de fuentes de información del viajero":"Se editó la sección de fuentes de información del viajero";
        $historial->save();
        
        return ["success"=>true,'sw'=>$sw];
        
        
    }
    
    public function getGastos($id){
        return view('turismointerno.Gastos', ["id"=>$id]);
    }
     public function postDatagastos(Request $request){
        
        $idioma = 1;
        $idViaje = $request->id;
        
        $encuesta = [
                "rubros"=> Rubro_Interno::with([ "viajesGastosInternos"=>function($q) use($idViaje){ $q->where("viajes_id",$idViaje); } ])->get(),
                "financiadores"=> Viaje_Financiadore::where("viaje_id",$idViaje)->pluck('financiadores_id')->toArray(),
                "viajeExcursion"=> Viaje_Excursion::where("viajes_id",$idViaje)->first(),
                "serviciosPaquetes"=> Servicio_Excursion_Incluido_Interno::where("viajes_id",$idViaje)->pluck('servicios_paquete_id')->toArray(),
                "lugarAgencia"=> Lugar_Agencia_Viaje::where("viaje_excursion_id",$idViaje)->pluck('ubicacion_agencia_viajes_id')->first(),
                "modalidadPago"=> Pago_Peso_Colombiano::where("viajes_id",$idViaje)->pluck('es_efectivo')->first()
        ];
        
        $encuesta["realizoGasto"] = Viaje_Gasto_Interno::where("viajes_id",$idViaje)->count() > 0 ? 1 : ( $encuesta["viajeExcursion"] != null > 0 ? 1 : 0 );
        $encuesta["viajePaquete"] = $encuesta["viajeExcursion"] != null > 0 ? 1 : 0;
        $encuesta["gastosAparte"] = Viaje_Gasto_Interno::where("viajes_id",$idViaje)->count() > 0 ? 1 :0;
        $encuesta["comproEnAgencia"] = $encuesta["lugarAgencia"] != null > 0 ? 1 : 0;
        
        return [ 
                "financiadores"=> Financiador_Viaje::with([ "financiadoresViajesConIdiomas"=>function($q) use($idioma){ $q->where("idiomas_id",$idioma); }])->get(),
                "serviciosPaquetes"=> Servicio_Paquete_Interno::get(),
                "opcionesLugares"=> Ubicacion_Agencia_Viaje::get(),
                "divisas"=> Divisa::with([ "divisasConIdiomas"=>function($q) use($idioma){ $q->where("idiomas_id",$idioma); }])->get(),
                "encuesta"=>$encuesta,
            ];
        
    }
   
    public function postGuardargastos(Request $request){
      
        $validator=\Validator::make($request->all(),[
                'id'=>'required|exists:viajes,id',
                'financiadores'=>'required|array|min:1',
                'financiadores.*'=>'required|numeric|exists:financiadores_viajes,id',
                'realizoGasto'=>'required',
                'viajePaquete'=>'required_if:realizoGasto,1',
                'gastosAparte'=>'required_if:realizoGasto,1',
                
                'rubros'=>'required_if:gastosAparte,1|array|min:1',
                'rubros.*.rubros_id'=>'required|exists:rubro_interno,id',
                
                'viajeExcursion'=>'required_if:viajePaquete,1',
                'viajeExcursion.divisas_id'=>'required_if:viajePaquete,1|exists:divisas,id',
                'viajeExcursion.valor_paquete'=>'required_if:viajePaquete,1',
                
                'serviciosPaquetes'=>'required_if:viajePaquete,1|array|min:1',
                'serviciosPaquetes.*'=>'required|numeric|exists:servicios_paquete_interno,id',
                'lugarAgencia'=>'required_if:viajePaquete,1|exists:opciones_lugares,id',
                'modalidadPago'=>'required_if:viajeExcursion.divisas_id,39',
            ], [ "id.required"=>"Error 1", "id.exists"=> "Error 2" ]);
            
        if($validator->fails()){
            return [ "success"=>false,'errores'=>$validator->errors() ];
        }
      
        $idViaje = $request->id;
        $viaje = Viaje::find($idViaje);
        
        if(Viaje_Financiadore::where("viaje_id",$idViaje)->count()==0){
            $viaje->ultima_sesion=4;
            $viaje->save();
        }
        
        Pago_Peso_Colombiano::where("viajes_id",$idViaje)->delete();
        Lugar_Agencia_Viaje::where("viaje_excursion_id",$idViaje)->delete();
        Servicio_Excursion_Incluido_Interno::where("viajes_id",$idViaje)->delete();
        Viaje_Excursion::where("viajes_id",$idViaje)->delete();
        Viaje_Financiadore::where("viaje_id",$idViaje)->delete();
        Viaje_Gasto_Interno::where("viajes_id",$idViaje)->delete();
        
        
        
        if($request->realizoGasto==1){
            
            if($request->viajePaquete==1){
                $viajeExcursion = new Viaje_Excursion();
                $viajeExcursion->viajes_id = $idViaje;
                $viajeExcursion->valor_paquete = $request->viajeExcursion["valor_paquete"];
                if(array_key_exists('personas_cubrio',$request->viajeExcursion)){ $viajeExcursion->personas_cubrio = $request->viajeExcursion["personas_cubrio"]; }
                $viajeExcursion->divisas_id = $request->viajeExcursion["divisas_id"];
                $viajeExcursion->save();
                
                $viajeExcursion->serviciosPaqueteInternos()->attach($request->serviciosPaquetes);
                $viajeExcursion->ubicacionAgenciaViajes()->attach($request->lugarAgencia);
                
                if($request->viajeExcursion["divisas_id"] == 39){
                    $pago = new Pago_Peso_Colombiano();
                    $pago->es_efectivo = $request->modalidadPago;
                    $viajeExcursion->pagoPesosColombiano()->save($pago);
                }
                
            }
            
            if($request->gastosAparte==1){
               foreach($request->rubros as $rubroGasto){
                   $viaje->viajesGastosInternos()->save( new Viaje_Gasto_Interno($rubroGasto) );
               } 
            }
        }
        
        $viaje->financiadoresViajes()->attach($request->financiadores);
       
        $historial = new Historial_Encuesta_Interno([ 
                                                      'digitador_id'=>$this->user->digitador->id,
                                                      'estado_id'=> ( $viaje->ultima_sesion!=5 ? 2 : 3 ), 
                                                      'viajes_id'=> $viaje->id, 
                                                      'fecha_cambio'=> date("Y-m-d H:i:s"), 
                                                      'mensaje'=> "Guardado sección de gastos",
                                                    ]);
        $historial->save();
       
        return [ "success"=>true ];
        
    }
   
    public function getTransporte($one){
        $id=$one;
        return view('turismointerno.Transporte',compact('id'));
    }
    public function getCargartransporte($one){
        
        $transportes=Tipo_Transporte_Con_Idioma::whereHas('idioma',function($q){
            $q->where('culture','es');
        })->whereHas('tiposTransporte',function($p){
            $p->where('estado',true);
        })->get(['tipos_transporte_id as id','nombre']);
        
        $transporteinterno=Tipo_Transporte_Interno::where('estado',true)->get();
        
        $viajero=Viaje::find($one);
        $aux=Empresa_Terrestre_Interno::where('viajes_id',$viajero->id)->first();
        $aux2=Alquila_Vehiculo_Interno::where('viaje_id',$viajero->id)->first();
        $empresa=($aux != null)?$aux->nombre:"";
        $alquilado=($aux2 != null)?$aux2->alquilado_magdalena:null;
        
        return ["transportes"=>$transportes,
                "tipo_transporte"=>$viajero->tipo_transporte_id,
                'tipo_transporte_interno'=>$viajero->tipo_transporte_interno_id,
                'salir'=>$viajero->salir,
                "empresa"=>$empresa,
                "transporte_interno"=>$transporteinterno,
                "alquilado"=>$alquilado
                ];
        
    }
    
    public function postGuardartransporte(Request $request){
        
          $validator=\Validator::make($request->all(),[
               
                'Mover'=>'required|exists:tipos_transporte_interno,id',
                'Desplazarse'=>'required|exists:tipos_transporte_interno,id',
                'Salir'=>'required|exists:tipos_transporte_interno,id',
                'Empresa'=>"required_if:Mover,6",
                'alquilado'=>'required_if:Mover,5'
            ]);
            
            if($validator->fails()){
             return ["success"=>false,'errores'=>$validator->errors()];
            }
            
            
            
          $viajero=Viaje::find($request->id);
          
          $sw=($viajero->tipos_transporte_id == null)?0:1;
          
          $viajero->ultima_sesion=($viajero->ultima_sesion<3)?3:$viajero->ultima_sesion;
          
          
          if($viajero->tipo_transporte_id == 6){
              
              Empresa_Terrestre_Interno::where('viajes_id',$viajero->id)->delete();
              
          }
          if($viajero->tipo_transporte_id == 5){
              
              Alquila_Vehiculo_Interno::where('viaje_id',$viajero->id)->delete();
              
          }
          $viajero->tipo_transporte_id=$request->Mover;
          $viajero->tipo_transporte_interno_id=$request->Desplazarse;
          $viajero->salir=$request->Salir;
          
          if($request->Mover == 6){
              
              $nuevo=new Empresa_Terrestre_Interno();
              $nuevo->viajes_id=$viajero->id;
              $nuevo->nombre=$request->Empresa;
              $nuevo->save();
          }
          
           if($request->Mover == 5){
              
              $nuevo=new Alquila_Vehiculo_Interno();
              $nuevo->viaje_id=$viajero->id;
              $nuevo->alquilado_magdalena=$request->alquilado;
              $nuevo->save();
          }
          
          $viajero->save();
          
          $historial=new Historial_Encuesta_Interno();
          $historial->viajes_id=$viajero->id;
          $historial->estado_id=($viajero->ultima_sesion != 7)?2:3;
          $historial->digitador_id=$this->user->digitador->id;
          $historial->fecha_cambio=\Carbon\Carbon::now();
          $historial->mensaje=($sw==0)?"Se completó la sección de transporte":"Se editó la sección de transporte";
          $historial->save();
          
          return ["success"=>true,"sw"=>$sw];
        
    }
    
    
    public function getViajesrealizados($one){
         $id = $one;
         $hogar=Persona::find($id)->hogar_id;
        return view('turismointerno.ViajesRealizados',compact('id','hogar'));
    }
    
    public function getViajes($id = null){

     
        $paises = Pais_Con_Idioma::where("idioma_id",1)->select("nombre","pais_id as id")->get();
      
        $depertamentos = Departamento::select("nombre","id","pais_id as idP")->get();
        $municipios = Municipio::select("nombre","id","departamento_id as idD")->get();
        $alojamientos =  Tipo_Alojamiento_Con_Idioma::where("idiomas_id",1)->select("nombre","tipos_alojamientos_id as id")->get();
        $motivos =  Motivo_Viaje_Con_Idioma::where("idiomas_id",1)->select("nombre","motivo_viaje_id as id")->get();
        $frecuencias = Frecuencia_Viaje::where("estado","=",true)->select("frecuencia","id")->get();
        $acomponiantes = Acompaniante_Viaje::where("estado","=",true)->select("nombre","id")->get();
        $viajes = Viaje::where("personas_id","=",$id)->get();
        $principal = Viaje::where("personas_id","=",$id)->where("es_principal","=",true)->pluck('id');               
       
        $enlaces = collect();

        $enlaces['Paises'] = $paises;
        $enlaces['Depertamentos'] = $depertamentos;
        $enlaces['Municipios'] = $municipios;
        $enlaces['Alojamientos'] = $alojamientos;
        $enlaces['Motivos'] = $motivos;
        $enlaces['Frecuencias'] = $frecuencias;
        $enlaces['Acompaniantes'] = $acomponiantes;

       
        
        return ["Enlaces" => $enlaces,"Viajes"=>$viajes,"Principal"=>$principal];
    }
    
    public function getViaje($id = null){
       
        $viaje = Viaje::where("id","=",$id)->select("frecuencia_id as Frecuencia","motivo_viaje_id as Motivo","fecha_inicio as Inicio","fecha_final as Fin","tamaño_grupo as Numero")->first();
     
        $estancias = Ciudad_Visitada::join("municipios","municipios.id","=","municipio_id")->join("departamentos","departamentos.id","=","municipios.departamento_id")->where('viajes_id', $id)->get(['municipio_id AS Municipio','tipo_alojamientos_id AS Alojamiento','numero_noches AS Noches',"departamento_id AS Departamento","departamentos.pais_id AS Pais"]);
        $principal = 0;
        if(count($estancias)>0){
            $principal = Ciudad_Visitada::where('viajes_id', $id)->where('destino_principal',1)->first()->municipio_id;
          }
        $encuesta = collect($viaje);    
        $encuesta["Personas"] =  $viaje = Viaje::join("viajes_acompañantes_viajes","viajes_id","=","viajes.id")->where("viajes.id","=",$id)->pluck("acompañantes_viajes_id");
        $encuesta["Principal"] = $principal;
        $encuesta["Estancias"] = $estancias;
        
        if ( $encuesta["Personas"]->contains(2) ||  $encuesta["Personas"]->contains(3))
        {

            $encuesta["Numerohogar"] =  Acompaniante_Viaje_Hogar::where("viajes_id","=",$id)->first()->numero;
        }

      
        if ($encuesta["Personas"]->contains(4) || $encuesta["Personas"]->contains(5))
        {

            $encuesta["Numerotros"] = Otros_Turistas_Interno::where("viaje_id","=",$id)->first()->numero;
        }
        
        
        
        return ["encuesta"=>$encuesta];
    }
    
    public function postCreateviaje(Request $request){
            $validator = \Validator::make($request->all(), [
      'Id' => 'required|exists:personas,id',
	  'Inicio' => 'required|date|before:tomorrow',
	  'Fin' => 'required|date|after:Inicio',
      'Idv' => 'exists:viajes,id',
      'Estancias' => 'required|min:1',
      'Estancias.*.Municipio' => 'required|exists:municipios,id',
      'Estancias.*.Alojamiento' => 'required|exists:tipos_alojamiento,id',
      'Estancias.*.Noches' => 'required|min:0',
      'Principal' => 'required|exists:municipios,id',
      'Personas.*'=>'required|exists:acompañantes_viajes,id',
      'Motivo'=>'required|exists:motivos_viaje,id',
      'Frecuencia'=>'required|exists:frecuencia_viaje,id'
      ],[
          'Id.required' => 'Debe seleccionar el visitante a realizar la $request->',
          'Personas.exists' => 'las personas de compañia seleccionado no se encuentra seleccionado en el sistema.',
          'Motivo.exists' => 'El motivo seleccionado no se encuentra seleccionado en el sistema.',
          'Inicio.required' => 'El campo fecha de llegada es requerido.',
          'Inicio.date' => 'El formato del campo fecha de inicio es inválido.',
          'Inicio.before_or_equal' => 'La fecha de incio de viaje debe ser menor al día de hoy.',
          'Fin.required' => 'El campo fecha de salida es requerido.',
          'Fin.date' => 'El formato del campo fecha de salida es inválido.',
          'Fin.after' => 'La fecha de fin del viaje debe ser mayor o igual a la de llegada.',
          'Frecuencia.exists' => 'la frecuencia seleccionado no se encuentra seleccionado en el sistema.',
          'Estancias.required' => 'Debe ingresar por lo menos una estancia.',
          'Estancias.min' => 'Debe ingresar por lo menos una estancia.',
          'Estancias.*Municipio.required' => 'Debe seleccionar el municipio en las estancias.',
          'Estancias.*Municipio.exists' => 'Uno de los municipios selecionados en las estancias no se encuentra registrado en el sistema.',
          'Estancias.*Alojamiento.required' => 'Debe seleccionar el alojamiento en las estancias.',
          'Estancias.*Alojamiento.exists' => 'Uno de los alojamientos selecionados en las estancias no se encuentra registrado en el sistema.',
          'Estancias.*Noches.required' => 'Debe el número de noches en las estancias.',
          'Estancias.*Noches.min' => 'El número de noches en las estancias debe ser mayor o igual que cero.',
          'Principal.required' => 'Debe seleccionar el municipio principal de la estancia.',
          'Principal.exists' => 'El municipio principal no se encuentra registrado en el sistema.',
      ]);
       
      if($validator->fails()){
        return ["success"=>false,"errores"=>$validator->errors()];
    }
    
    $diferencia = (  strtotime($request->Fin) - strtotime($request->Inicio) ) / 86400;
    $numeroDias = $diferencia;
    $noches = 0;
    
    
    foreach($request->Estancias as $estancia){
        $noches+=$estancia['Noches'];
        
        if($estancia['Noches'] == 0 && $estancia['Alojamiento'] != 15 ){
            return ["success" => false, "errores" => [["Si el número de noches es igual a 0 debe seleccionar la opcion Ningún tipo de alojamiento."]] ];
        }
        
        if( collect($request->Estancias)->where('Municipio', $estancia['Municipio'] )->count() > 1 ){
            return ["success" => false, "errores" => [["No debe repetir un municipio en las estancias."]] ];
        }
        
    }
    
    if($noches > $numeroDias){
        return ["noches"=> $noches,"dias"=> $numeroDias];
        return ["success" => false, "errores" => [["La suma del número de noches no debe ser mayor al número de días del viaje."]] ];
    }
    
    
    $persona = Persona::where("id","=",$request->Id)->first();
    
     if(!$request->Crear){

        if(Viaje::where("personas_id",$request->Id)->where("id","!=",$request->Idv)->where("fecha_inicio","<=",$request->Inicio)->where("fecha_final",">=",$request->Inicio)->first() != null){
            return ["success" => false, "errores" => [["Ya existe un viaje creado en esas fechas."]] ];
            
        }
         if(Viaje::where("personas_id",$request->Id)->where("id","!=",$request->Idv)->where("fecha_inicio","<=",$request->Fin)->where("fecha_final",">=",$request->Fin)->first() != null){
            return ["success" => false, "errores" => [["Ya existe un viaje creado en esas fechas."]] ];
            
        }
        
     }
     
     if($request->Crear){

        if(Viaje::where("personas_id",$request->Id)->where("fecha_inicio","<=",$request->Inicio)->where("fecha_final",">=",$request->Inicio)->first() != null){
            return ["success" => false, "errores" => [["Ya existe un viaje creado en esas fechas."]] ];
            
        }
         if(Viaje::where("personas_id",$request->Id)->where("fecha_inicio","<=",$request->Fin)->where("fecha_final",">=",$request->Fin)->first() != null){
            return ["success" => false, "errores" => [["Ya existe un viaje creado en esas fechas."]] ];
            
        }
        
     }
    
    $temporada = $persona->hogare->edificacione->temporada;
    if($temporada->fecha_ini > $request->Fin || $request->Fin > $temporada->fecha_fin ){
         return ["success" => false, "errores" => [["Las fechas de viajes no coinciden con la temporada de estar entre.".$temporada->fecha_ini."-".$temporada->fecha_fin]] ];
        
    }
    if($request->Crear){
        $viaje = new Viaje();
        $viaje->creada_por = $this->user->digitador->id;
        $viaje->digitada_por = $this->user->digitador->id;
        $viaje->ultima_sesion = 1;
        $mensaje="Creada seccion de viaje";
    }else{
          $viaje = Viaje::where("id","=",$request->Idv)->first();
          $mensaje="Editada seccion de viaje";
           
    }
    
        $viaje->motivo_viaje_id = $request->Motivo;
        $viaje->frecuencia_id = $request->Frecuencia;
        $viaje->fecha_inicio = $request->Inicio;
        $viaje->fecha_final = $request->Fin;
        $viaje->personas_id = $persona->id;
        $viaje->tamaño_grupo = $request->Numero;

        $viaje->save();
     
        $viaje->acompanantesViajes()->detach();
        Ciudad_Visitada::where('viajes_id', $viaje->id)->delete();
        $viaje->acompanantesViajes()->attach($request->Personas);
      foreach($request->Estancias as $estancia){
         
        Ciudad_Visitada::create([
             
              'viajes_id' => $viaje->id,
              'municipio_id' => $estancia['Municipio'],
              'tipo_alojamientos_id' => $estancia['Alojamiento'],
              'numero_noches' => $estancia['Noches'],
              'destino_principal' => $estancia['Municipio'] == $request->Principal ? 1 : 0
          ]);
    }
    
    
            $acompaniante = Acompaniante_Viaje_Hogar::where("viajes_id","=",$viaje->id)->first();
            if ($request->Numerohogar > 0)
            {
               if ($acompaniante != null)
                {
                    $acompaniante->numero = $request->Numerohogar;
                     $acompaniante->save();
                }
                else
                {

                    $acompaniante = new Acompaniante_Viaje_Hogar();

                    $acompaniante->viajes_id = $viaje->id;
                    $acompaniante->numero = $request->Numerohogar;
                    $acompaniante->save();

                }

            }
            else
            {
                if ($acompaniante != null)
                {
                    $acompaniante->delete();

                }



            }


           $otroTrurista = Otros_Turistas_Interno::where("viaje_id","=",$viaje->id)->first();

            if ($request->Numerotros > 0)
            {


                if ($otroTrurista != null)
                {
                    $otroTrurista->numero = $request->Numerotros;
                    $otroTrurista->save();
                }
                else
                {
                    $otroTrurista = new Otros_Turistas_Interno();
                    $otroTrurista->viaje_id = $viaje->id;
                    $otroTrurista->numero = $request->Numerotros;
                    $otroTrurista->save();

                }

            }
            else
            {
                if ($otroTrurista != null)
                {
                    $otroTrurista->delete();

                }



            }
    
         $principal = Ciudad_Visitada::join("municipios","municipios.id","=","municipio_id")
            ->join("departamentos","departamentos.id","=","municipios.departamento_id")
            ->where('viajes_id', $viaje->id)->where("destino_principal",true)
            ->where("departamentos.id",1411)->first();
            if($principal == null){
                
                 $viaje->actividadesRealizadasInternos()->detach();
        	     $viaje->opcionesActividadesRealizadasInternos()->detach();
        	     $viaje->subOpcionesActividadesRealizadasInternos()->detach();
                
            }
            
          $historial=new Historial_Encuesta_Interno();
          $historial->viajes_id=$viaje->id;
          $historial->estado_id=($viaje->ultima_sesion != 7)?2:3;
          $historial->digitador_id=$this->user->digitador->id;
          $historial->fecha_cambio=\Carbon\Carbon::now();
          $historial->mensaje=$mensaje;
          $historial->save();
    
            return ["success" => true, "viaje"=>$viaje];
    }
    
    public function postEliminarviaje (Request $request){
     
            $validator = \Validator::make($request->all(), [
      'id' => 'required|exists:viajes,id',
      ],[
          'id.required' => 'Debe seleccionar el viaje a realizar la $request->',
          'id.exists' => 'El viaje seleccionado no se encuentra seleccionado en el sistema.',
      ]);
       
      if($validator->fails()){
        return ["success"=>false,"errores"=>$validator->errors()];
    }
        $viaje = Viaje::where("id",$request->id)->first();
        $viaje->delete();
        
        return ["success" => true];
        
    }
    
     public function postSiguienteviaje (Request $request){
     
            $validator = \Validator::make($request->all(), [
      'id' => 'required|exists:personas,id',
      'principal' => 'required|exists:viajes,id',
      ],[
          'id.required' => 'Debe seleccionarla persona a realizar la $request->',
          'id.exists' => 'El persona seleccionado no se encuentra seleccionado en el sistema.',
          'principal.required' => 'Debe seleccionar el viaje a realizar la $request->',
          'principal.exists' => 'El viaje seleccionado no se encuentra seleccionado en el sistema.',
      ]);
       
      if($validator->fails()){
        return ["success"=>false,"errores"=>$validator->errors()];
    }
        Viaje::where("personas_id",$request->id)->update(['es_principal' => false]);
        Viaje::where("personas_id",$request->id)->where("id",$request->principal)->update(['es_principal' => true]);
        $sw = 0;
        $principal = Ciudad_Visitada::join("municipios","municipios.id","=","municipio_id")
        ->join("departamentos","departamentos.id","=","municipios.departamento_id")
        ->where('viajes_id', $request->principal)->where("destino_principal",true)
        ->where("departamentos.id",1411)->first();
       
        if($principal != null ){
            $sw = 1;
            
        }
        
        return ["success" => true,"Sw"=>$sw];
        
    }
    
    
   
    
   
}
