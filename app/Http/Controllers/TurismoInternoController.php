<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Municipio;
use App\Models\Nivel_Educacion;
use App\Models\Motivo_No_Viaje;
use App\Models\Estrato;
use App\Models\Barrio;

use App\Models\Edificacion;
use App\Models\Hogar;
use App\Models\Persona;
use App\Models\No_Viajero;

use App\Models\Pais_Con_Idioma;
use App\Models\Departamento;
use App\Models\Tipo_Alojamiento_Con_Idioma;
use App\Models\Acompaniante_Viaje;
use App\Models\Frecuencia_Viaje;
use App\Models\Motivo_Viaje_Con_Idioma;
use App\Models\Motivo_Viaje;
use App\Models\Viaje;
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

class TurismoInternoController extends Controller
{
    
    public function getDatoshogar(){
        
        $municipios=Municipio::where('departamento_id',1411)->get();
        $niveles=Nivel_Educacion::get();
        $motivos=Motivo_No_Viaje::get();
        $estratos=Estrato::get();
        return ["municipios"=>$municipios,'niveles'=>$niveles,'motivos'=>$motivos,'estratos'=>$estratos];
        
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
                
                'Fecha_aplicacion'=>'required|date',
                'Hora_aplicacion'=>'required',
                'Barrio'=>'required|exists:barrios,id',
                'Estrato'=>'required|exists:estratos,id',
                'Direccion'=>'required',
                'Telefono'=>'required',
                'Nombre_Entrevistado'=>'required',
                'Celular_Entrevistado'=>'numeric',
                'Email_Entrevistado'=>'email'
            ]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $edificacion=new Edificacion();
        $edificacion->direccion=$request->Direccion;
        $edificacion->barrio_id=$request->Barrio;
        $edificacion->estrato_id=$request->Estrato;
        $edificacion->temporada_id=$request->Temporada_id;
        $edificacion->nombre_entrevistado=$request->Nombre_Entrevistado;
        $edificacion->telefono_entrevistado=$request->Celular_Entrevistado;
        $edificacion->email_entrevistado=$request->Email_Entrevistado;
        $edificacion->user_create="Pater";
        $edificacion->user_update="Pater";
        $edificacion->save();
        
        $hogar=new Hogar();
        $hogar->fecha_realizacion=$request->Fecha_aplicacion;
        $hogar->digitadores_id=1;
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
             $persona->celular=$personaux["Celular"];
             $persona->email=$personaux["Email"];
             $persona->es_viajero=$personaux["Viaje"];
             $persona->nivel_educacion=$personaux["Nivel_Educacion"];
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
        $encuesta->personas=Persona::where('hogar_id',$encuesta->id)->with('motivoNoViajes')->get();
        $barrios=Barrio::where('municipio_id',$encuesta->edificacione->barrio->municipio_id)->get();
        return ["datos"=>$datos,"encuesta"=>$encuesta,"barrios"=>$barrios];
        
    }
    
    public function getActividadesrealizadas($one){
        $id = $one;
        return view('turismointerno.ActividadesRealizadas',compact('id'));
    }
    
    public function getActividades($id = null){

        
        $actividadesrealizadas = Actividad_Realizada::where('estado',1)->with(["actividadesRealizadasConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('actividad_realizada_id','nombre');
        }])->get();
        
        $tipoatracciones = Tipo_Atraccion::has('actividadesRealizadas')->where('estado',1)->with(["tipoAtraccionesConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipo_atracciones_id','nombre');
        }, "actividadesRealizadas"])->get();
        
        $atracciones = Atraccion_Por_Tipo_Actividad_Realizada::has('atraccione')->with([
            'atraccione' => function($p){
                $p->where('estado',1)->with(['sitio'=> function($w){
                    $w->with(['sitiosConIdiomas' => function($q){
                        $q->whereHas('idioma', function($x){
                            $x->where('culture','es');
                        })->select('sitios_id','nombre');
                    }]);
                }]);
            }
        ])->get();
        
        $atraccionesportal = Atracciones::where('estado',1)->with(['sitio' => function($q){
            $q->with(['sitiosConIdiomas' => function($p){
                $p->whereHas('idioma', function($x){
                    $x->where('culture','es');
                })->select('sitios_id','nombre');
            }]);
        }])->get();
        
        $actividades = Actividad_Realizada_Con_Actividad::with([
            'actividade' => function($p){
                $p->where('estado',1)->with(["actividadesConIdiomas"=>function($q){
                    $q->whereHas('idioma', function($x){
                        $x->where('culture','es');
                    })->select('actividades_id','nombre');
                }]);
            }
        ])->get();
        
        $viaje = Viaje::where("id","=",$id)->first();
        $encuesta = collect();
        if($viaje->ultima_sesion >= 2){
            $atraccionesP = collect(Atraccion_Visitada_Interno::where('viajes_id', $viaje->id)->where('tipo_atraccion_id',77)->get())->pluck('atraccion_id')->toArray();
            $atraccionesM = collect(Atraccion_Visitada_Interno::where('viajes_id', $viaje->id)->where('tipo_atraccion_id',117)->get())->pluck('atraccion_id')->toArray();
            $atraccionesN = collect(Atraccion_Visitada_Interno::where('viajes_id', $viaje->id)->where('tipo_atraccion_id',94)->get())->pluck('atraccion_id')->toArray();
           
            $tipoAtraccionesN = collect(Lugar_Visitado_Interno::where('viajes_id',$viaje->id)->where('actividad_realizadas_id',2)->get())->pluck('tipo_atraccion_id')->toArray();
            $tipoAtraccionesM = collect(Lugar_Visitado_Interno::where('viajes_id',$viaje->id)->where('actividad_realizadas_id',3)->get())->pluck('tipo_atraccion_id')->toArray();
  
            $actividadesH = collect(Actividad_Realizada_Viajero::where('viajes_id',$viaje->id)->where('actividades_realizadas_id',8)->get())->pluck('actividad_id')->toArray();
            $actividadesD = collect(Actividad_Realizada_Viajero::where('viajes_id',$viaje->id)->where('actividades_realizadas_id',10)->get())->pluck('actividad_id')->toArray();
            $actividadesRelizadas = collect(Actividad_Realizada_Interno::where('viajes_id',$viaje->id)->get())->pluck('actividades_realizadas_id')->toArray();
            
            $encuesta = collect();
            
            if(count($atraccionesP) > 0){
                array_push($actividadesRelizadas,1);
            }
            
            if(count($atraccionesN) > 0){
                array_push($actividadesRelizadas,2);
                array_push($tipoAtraccionesN,94);
            }
            
            if(count($atraccionesM) > 0){
                array_push($actividadesRelizadas,3);
                array_push($tipoAtraccionesM,117);
            }
            
            if(count($actividadesD) > 0){
                array_push($actividadesRelizadas,10);
            }
            
            if(count($actividadesH) > 0){
                array_push($actividadesRelizadas,8);
            }
            

            $encuesta['ActividadesRelizadas'] = $actividadesRelizadas;
            $encuesta['Favorito'] = count($viaje->atraccionesVisitadasInternos) == 0 ? null : $viaje->atraccionesVisitadasInternos->first()->id;
            $encuesta['AtraccionesP'] = $atraccionesP;
            $encuesta['AtraccionesN'] = $atraccionesN;
            $encuesta['AtraccionesM'] = $atraccionesM;
            $encuesta['ActividadesD'] = $actividadesD;
            $encuesta['ActividadesH'] = $actividadesH;
            $encuesta['TipoAtraccionesN'] = $tipoAtraccionesN;
            $encuesta['TipoAtraccionesM'] = $tipoAtraccionesM;
            
            
        }
        
        $enlaces = collect();

        $enlaces['Actividadesrelizadas'] = $actividadesrealizadas;
        $enlaces['TipoAtracciones'] = $tipoatracciones;
        $enlaces['Atracciones'] = $atracciones;
        $enlaces['AtraccionesPortal'] = $atraccionesportal;
        $enlaces['Actividades'] = $actividades;
        
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
			'ActividadesRelizadas.*' => 'exists:actividades_realizadas,id',
			'AtraccionesP.*' => 'exists:atracciones_por_tipo_actividades_realizadas,atraccion_id',
			'TipoAtraccionesN.*' => 'exists:actividades_realizadas_atraccion,tipo_atraccion_id',
			'AtraccionesN.*' => 'exists:atracciones_por_tipo_actividades_realizadas,atraccion_id',
			'TipoAtraccionesM.*' => 'exists:actividades_realizadas_atraccion,tipo_atraccion_id',
			'AtraccionesM.*' => 'exists:atracciones_por_tipo_actividades_realizadas,atraccion_id',
			'ActividadesH.*' => 'exists:actividades_realizadas_con_actividades,actividad_id',
			'ActividadesD.*' => 'exists:actividades_realizadas_con_actividades,actividad_id',
    	],[
       		'Id.required' => 'Debe seleccionar el viaje  a realizar no se encuentra.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
       		'ActividadesRelizadas.required' => 'Debe seleccionar por lo menos una actividad realizada.',
       		'ActividadesRelizadas.*.exists' => 'Alguna de las actividades realizadas no se encuentra registrada en el sistema.',
       		'AtraccionesP.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'TipoAtraccionesN.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'TipoAtraccionesM.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'AtraccionesN.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'AtraccionesM.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'ActividadesH.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
       		'ActividadesD.*.exists' => 'Alguna de los elementos seleccionados no se encuentra registrado en el sistema.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$viaje = Viaje::find($request->Id);

		
		if(in_array(23,$request->ActividadesRelizadas)){
		    if( count($request->ActividadesRelizadas) > 1 ){
		        return ["success" => false, "errores" => [["Si selecciona la opción ninguna no puede seleccionar otras actividades."]] ];    
		    }
		}
		
		if(in_array(1,$request->ActividadesRelizadas)){
		    if(!isset($request->AtraccionesP) || count($request->AtraccionesP)==0 ){
		        return ["success" => false, "errores" => [["Debe seleccionar por lo menos una playa."]] ];    
		    }
		}
		
		if(in_array(2,$request->ActividadesRelizadas)){
		    if(!isset($request->TipoAtraccionesN) || count($request->TipoAtraccionesN)==0 ){
		        return ["success" => false, "errores" => [["Debe seleccionar por lo menos uno de los parques,rios."]] ];    
		    }else if(in_array(94,$request->TipoAtraccionesN)){
		        if(!isset($request->AtraccionesN) || count($request->AtraccionesN)==0 ){
		            return ["success" => false, "errores" => [["Debe seleccionar por lo menos un parque."]] ];
		        }
		    }
		}
		
		if(in_array(3,$request->ActividadesRelizadas)){
		    if(!isset($request->TipoAtraccionesM) || count($request->TipoAtraccionesM)==0 ){
		        return ["success" => false, "errores" => [["Debe seleccionar por lo menos una visitas a museos, santuarios, ect."]] ];    
		    }else if(in_array(117,$request->TipoAtraccionesM)){
		        if(!isset($request->AtraccionesM) || count($request->AtraccionesM)==0 ){
		            return ["success" => false, "errores" => [["Debe seleccionar por lo menos un museo."]] ];
		        }
		    }
		}
		
		if(in_array(8,$request->ActividadesRelizadas)){
		    if(!isset($request->ActividadesH) || count($request->ActividadesH)==0 ){
		        return ["success" => false, "errores" => [["Debe seleccionar por lo menos una hacienda."]] ];    
		    }
		}
		
		if(in_array(10,$request->ActividadesRelizadas)){
		    if(!isset($request->ActividadesD) || count($request->ActividadesD)==0 ){
		        return ["success" => false, "errores" => [["Debe seleccionar por lo menos un deporte."]] ];    
		    }
		}
		
		
		$sw = 0;
		if($viaje->ultima_sesion >= 2){
		    $sw =1;
		  
		    Atraccion_Visitada_Interno::where('viajes_id', $viaje->id)->delete();
		    Lugar_Visitado_Interno::where('viajes_id', $viaje->id)->delete();
		    Actividad_Realizada_Viajero::where('viajes_id', $viaje->id)->delete();
		    Actividad_Realizada_Interno::where('viajes_id', $viaje->id)->delete();
		}else{
		    $viaje->ultima_sesion = 2;
		}
		
		if(isset($request->Favorito)){
		    $viaje->atracciones()->detach();
		    $viaje->atracciones()->attach($request->Favorito);
		}
		
		
		foreach($request->ActividadesRelizadas as $actividad){
		    switch($actividad){
		        case 1:
		            foreach ($request->AtraccionesP as $value) {
		                Atraccion_Visitada_Interno::create([
	                        'atraccion_id' => $value,
	                        'viajes_id' => $viaje->id,
	                        'actividades_realizadas_id' => $actividad,
	                        'tipo_atraccion_id' => 77
	                    ]);
		            }
		            break;
	            case 2:
	                foreach($request->TipoAtraccionesN as $tipoAtrac){
	                    if($tipoAtrac == 94){
	                        foreach($request->AtraccionesN as $value){
	                            Atraccion_Visitada_Interno::create([
        	                        'atraccion_id' => $value,
        	                        'viajes_id' => $viaje->id,
        	                        'actividades_realizadas_id' => $actividad,
        	                        'tipo_atraccion_id' => $tipoAtrac
        	                    ]);
	                        }
	                    }else{
	                       
	                        Lugar_Visitado_Interno::create([
                                'actividad_realizadas_id' => $actividad,
                                'tipo_atraccion_id' => $tipoAtrac,
                                'viajes_id' => $viaje->id,
                                'estado' => 1
                            ]);
	                    }
	                }
	                break;
                case 3:
                    foreach($request->TipoAtraccionesM as $tipoAtrac){
                        if($tipoAtrac == 117){
                            foreach($request->AtraccionesM as $value){
                                Atraccion_Visitada_Interno::create([
        	                        'atraccion_id' => $value,
        	                        'viajes_id' => $viaje->id,
        	                        'actividades_realizadas_id' => $actividad,
        	                        'tipo_atraccion_id' => $tipoAtrac
        	                    ]);
                            }
                        }else{
                           
                            Lugar_Visitado_Interno::create([
                                'actividad_realizadas_id' => $actividad,
                                'tipo_atraccion_id' => $tipoAtrac,
                                'viajes_id' => $viaje->id,
                                'estado' => 1
                            ]);
                        }
                    }
                    break;
                case 8:
                    foreach($request->ActividadesH as $tipoActi){
                        Actividad_Realizada_Viajero::create([
                            'actividades_realizadas_id' => $actividad,
                            'actividad_id' => $tipoActi,
                            'viajes_id' => $viaje->id
                        ]);
                    }
                    
                    break;
                case 10:
                    foreach($request->ActividadesD as $tipoActi){
                        Actividad_Realizada_Viajero::create([
                            'actividades_realizadas_id' => $actividad,
                            'actividad_id' => $tipoActi,
                            'viajes_id' => $viaje->id
                        ]);
                    }
                    break;
                default:
                    Actividad_Realizada_Interno::create([
                        'actividades_realizadas_id' => $actividad,
                        'viajes_id' => $viaje->id,
                        'estado' => 1
                    ]);
                    break;
		    }
		}
		$viaje->save();
		return $viaje;
        return ["success" => true];
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
    
    
    public function postCreateViaje(Request $request){
            $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
			'Estancias' => 'required|min:1',
			'Estancias.*.Municipio' => 'required|exists:municipios,id',
			'Estancias.*.Alojamiento' => 'required|exists:tipos_alojamiento,id',
			'Estancias.*.Noches' => 'required|min:0',
			'Principal' => 'required|exists:municipios,id',
	
		
    	],[
       		'Id.required' => 'Debe seleccionar el visitante a realizar la $request->',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
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
		
		/*$visitante = Visitante::find($request->Id);
		$diferencia = (  strtotime($visitante->fecha_salida) - strtotime($visitante->fecha_llegada) ) / 86400;
		$numeroDias = $diferencia;
		$noches = 0;
		*/
		
		foreach($request->Estancias as $estancia){
		    $noches+=$estancia['Noches'];
		    
		    if($estancia['Noches'] == 0 && $estancoa['Alojamiento'] != 15 ){
		        return ["success" => false, "errores" => [["Si el número de noches es igual a 0 debe seleccionar la opcion Ningún tipo de alojamiento."]] ];
		    }
		    
		    if( collect($request->Estancias)->where('Municipio', $estancia['Municipio'] )->count() > 1 ){
		        return ["success" => false, "errores" => [["No debe repetir un municipio en las estancias."]] ];
		    }
		    
		}
		/*
		if($noches > $numeroDias){
		    return ["success" => false, "errores" => [["La suma del número de noches no debe ser mayor al número de días del viaje."]] ];
		}
		*/
		
		$persona = Persona::where("id","=",$request->Id)->first();
		
		if($request->Crear){
		    $viaje = Viaje::where("","",$request->Idv)->first();
		}else{
		    
		    $viaje = new Viaje();
		}
    
        $viaje->motivo_viaje_id = $request->Motivo;
        $viaje->frecuencia_id = $request->Frecuencia;
        $viaje->fecha_inicio = $request->Inicio;
        $viaje->fecha_final = $request->Fin;
        $viaje->personas_id =	$persona->id;
        $viaje->tamaño_grupo = $request->Numero;
        $viaje->ciudades_visitadas()->detach();
        $viaje->acompanantesViajes()->detach();
        
        $viaje->acompanantesViajes()->attach();
        
    	foreach($request->Estancias as $estancia){
		    Ciudad_Visitada::create([
	            'viaje' => $viaje->id,
	            'municipios_id' => $estancia['Municipio'],
	            'tipo_alojamiento_id' => $estancia['Alojamiento'],
	            'numero_noches' => $estancia['Noches'],
	            'destino_principal' => $estancia['Municipio'] == $request->Principal ? 1 : 0
	        ]);
		}
        
        
    }
    
    public function getFuentesinformacion(){
        return view('turismointerno.FuentesInformacion');
    }
    public function getGastos(){
        return view('turismointerno.Gastos');
    }
   
    public function getTransporte(){
        return view('turismointerno.Transporte');
    }
    public function getViajesrealizados($one){
         $id = $one;
        return view('turismointerno.ViajesRealizados',compact('id'));
    }
    
    
    
   
}
