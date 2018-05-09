<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Grupo_Viaje;
use App\Models\Digitador;
use App\Models\Opcion_Lugar;
use App\Models\Actividades;
use App\Models\Pais;
use App\Models\Motivo_Viaje;
use App\Models\Tipo_Atencion_Salud;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Visitante;
use App\Models\Visitante_Transito;
use App\Models\Otro_Motivo;
use App\Models\Historial_Encuesta;
use App\Models\Tipo_Alojamiento;
use App\Models\Actividad_Realizada;
use App\Models\Tipo_Atraccion;
use App\Models\Atracciones;
use App\Models\Atraccion_Por_Tipo_Actividad_Realizada;
use App\Models\Actividad_Realizada_Con_Actividad;
use App\Models\Municipio_Visitado_Magdalena;
use App\Models\Atraccion_Visitada;
use App\Models\Lugar_Visitado;
use App\Models\Actividad_Hecha_Visitante;
use App\Models\Actividad_Realizada_Por_Visitante;

class TurismoReceptorController extends Controller
{
    public function getDatosencuestados(){
        return view('turismoReceptor.DatosEncuestados');
    }
    
    public function getInformaciondatoscrear(){
        
        $grupos = Grupo_Viaje::orderBy('id')->get()->pluck('id');
        
        $encuestadores = Digitador::where('id','<>',2)->with([ 'aspNetUser'=>function($q){$q->select('Id','UserName');} ])->get();
        
        $lugar_nacimiento = Opcion_Lugar::with(["opcionesLugaresConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('opciones_lugares_id','nombre');
        }])->get();
        
        $paises = Pais::with(['paisesConIdiomas' => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('pais_id','nombre');
        }])->get();
        
        $motivos = Motivo_Viaje::with(["motivosViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('motivo_viaje_id','nombre');
        }])->get();
        
        $medicos = Tipo_Atencion_Salud::with(["tiposAtencionSaludConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipos_atencion_salud_id','nombre');
        }])->get();
        
        $departamentos = Departamento::where('pais_id',47)->select('id','nombre')->get();
        
        $result = [ 'grupos' => $grupos, 
                    'encuestadores' => $encuestadores, 
                    'lugar_nacimiento' => $lugar_nacimiento, 
                    'paises' => $paises,
                    'motivos' => $motivos,
                    'medicos' => $medicos,
                    'departamentos' => $departamentos
        ];
        
        return $result;
    }
    
    public function postGuardardatos(Request $request){
        $validator = \Validator::make($request->all(), [
			'Grupo' => 'required|exists:grupos_viaje,id',
			'Encuestador' => 'required|exists:digitadores,id',
			'Llegada' => 'required|date|before:tomorrow',
			'Salida' => 'required|date|after:Llegada',
			'Nombre' => 'required|max:150',
			'Edad' => 'required|numeric|between:15,150',
			'Sexo' => 'required',
			'Email' => 'required|email',
			'Telefono' => 'max:50',
			'Celular' => 'max:50',
			'Nacimiento' => 'required|exists:opciones_lugares,id',
			'Pais_Nacimiento' => 'required_if:Nacimiento,3',
			'Municipio' => 'required|exists:municipios,id',
			'Motivo' => 'required|exists:motivos_viaje,id',
			'Destino' => 'exists:municipios,id',
			'Salud' => 'exists:tipos_atencion_salud,id|required_if:Motivo,5',
			'Horas' => 'required_if:Motivo,3',
			'Otro' => 'required_if:Motivo,18|max:150',
			'Actor' => 'required',
    	],[
       		'Grupo.required' => 'Debe seleccionar el grupo de viaje.',
       		'Grupo.exists' => 'El grupo de viaje seleccionado no se encuentra registrado en el sistema.',
       		'Encuestador.required' => 'Debe seleccionar el encuenstador.',
       		'Encuestador.exists' => 'El encuenstador seleccionado no se encuentra registrado en el sistema.',
       		'Llegada.required' => 'El campo fecha de llegada es requerido.',
       		'Llegada.date' => 'El formato del campo fecha de llegada es inválido.',
       		'Llegada.before_or_equal' => 'La fecha de llegada debe ser menor al día de hoy.',
       		'Salida.required' => 'El campo fecha de salida es requerido.',
       		'Salida.date' => 'El formato del campo fecha de salida es inválido.',
       		'Salida.after' => 'La fecha de salida debe ser mayor o igual a la de llegada.',
       		'Nombre.required' => 'El campo nombre es requerido.',
       		'Nombre.max' => 'El campo nombre no debe exceder los 150 caracteres.',
       		'Edad.required' => 'EL campo edad es requerido.',
       		'Edad.between' => 'El campo edad debe estar entre 16 y 150.',
       		'Sexo.required' => 'El campo sexo es requerido.',
       		'Email.required' => 'El campo email es requerido.',
       		'Email.email' => 'El formato del email es inválido.',
       		'Telefono.max' => 'El campo télefono no debe superar los 50 caracteres.',
       		'Celular.max' => 'El campo celular no debe superar los 50 caracteres.',
       		'Nacimiento.required' => 'Debe selecionar el lugar de nacimiento.',
       		'Nacimiento.exists' => 'El lugar de nacimiento seleccionado no se encuentra registrado en el sistema.',
       		'Municipio.required' => 'La ciudad de residencia es requerida.',
       		'Municipio.exists' => 'El municipio de residencia seleccionado no se encuentra registrado en el sistema.',
       		'Motivo.required' => 'El motivo de viaje es requerido.',
       		'Motivo.exists' => 'El motivo de viaje selecionado no se encuentra registrado en el sistema.',
       		'Destino.exists' => 'El municipio del destino principal no se encuentra registrado en el sistema',
       		'Salud.exists' => 'El tipo de opción seleccionado para el motivo de salud no se encuentra registrado en el sistema.',
       		'Salud.required_if' => 'Debe seleccionar el motivo por salud de viaje.',
       		'Horas.required_if' => 'Debe ingresar el número de horas de viaje.',
       		'Otro.required_if' => 'Debe ingresar datos en el campo otro.',
       		'Otro.max' => 'El campo otro no debe superar los 150 caracteres.',
       		'Actor.required' => 'Debe seleccionar el actor.'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$municipio = Municipio::find($request->Municipio);
		if($municipio->departamento->pais_id != 47 && $request->Destino==null){
		    return ["success"=>false,"errores"=> [ ["El id del destino principal es inválido."] ] ];
		}
		
		$grupo = Grupo_Viaje::find($request->Grupo);
		//return count($grupo->visitantes).'-'.$grupo->personas_encuestadas;
		if( count($grupo->visitantes) >= $grupo->personas_encuestadas ){
		    return ["success"=>false,"errores"=> [ ["El grupo seleccionado ya tiene el número de encuestas completas."] ] ];
		}
		
		$visitante = new Visitante();
		$visitante->telefono = isset($request->Telefono) ? $request->Telefono : null;
		$visitante->celular = isset($request->Celular) ? $request->Celular : null;
		$visitante->destino_principal = isset($request->Destino) ? $request->Destino : null;
		$visitante->digitada = 1;
		$visitante->edad = $request->Edad;
		$visitante->email = $request->Email;
		$visitante->encuestador_creada = $request->Encuestador;
		$visitante->fecha_llegada = $request->Llegada;
		$visitante->fecha_salida = $request->Salida;
		$visitante->grupo_viaje_id = $request->Grupo;
		$visitante->motivo_viaje = $request->Motivo;
		$visitante->municipio_residencia = $request->Municipio;
		$visitante->nombre = $request->Nombre;
		$visitante->opciones_lugares_id = $request->Nacimiento;
		$visitante->pais_nacimiento = $request->Nacimiento != 3 ? 47 : $request->Pais_Nacimiento;
		$visitante->sexo = $request->Sexo;
		$visitante->ultima_sesion = 1;
		$visitante->save();
		
		switch ($visitante->motivo_viaje)
        {

            case 3:
                $visitante->visitantesTransito()->save( new Visitante_Transito(['horas_transito' => $request->Horas]) );
                break;
            case 5:
                $visitante->tiposAtencionSaluds()->attach($request->Salud);
                break;
            case 18:
                $visitante->otrosMotivo()->save( new Otro_Motivo([ 'otro_motivo' => $request->Otro ]) );
                break;
        }
        
        
        $visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => 1,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => 'La encuesta ha sido creada',
            'usuario_id' => 1
        ]));
        
        
        
		return ["success" => true];
    }
    
    public function getDepartamento($id){
        $departamentos = Departamento::where('pais_id',$id)->select('id','nombre')->get();
        return $departamentos;
    }
    
    public function getMunicipio($id){
        $municipios = Municipio::where('departamento_id',$id)->select('id','nombre')->get();
        return $municipios;
    }
    
    public function getSeccionestancia($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        
        return view('turismoReceptor.SeccionEstanciayvisitados',["id"=>$id]);
    }
    
    public function getCargardatosseccionestancia($id = null){
        $municipios = Municipio::where('departamento_id', 1411)->select('id','nombre')->get();
        
        $alojamientos = Tipo_Alojamiento::with(["tiposAlojamientoConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipos_alojamientos_id','nombre');
        }])->get();
        
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
        
        $visitante = Visitante::find($id);
        $encuesta = null;
        if($visitante->ultima_sesion >= 2){
            $estancias = Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->get(['municipios_id AS Municipio','tipo_alojamiento_id AS Alojamiento','numero_noches AS Noches']);
            $principal = Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->where('destino_principal',1)->first()->municipios_id;
            $atraccionesP = collect(Atraccion_Visitada::where('visitante_id', $visitante->id)->where('tipo_atraccion_id',77)->get())->pluck('atraccion_id')->toArray();
            $atraccionesM = collect(Atraccion_Visitada::where('visitante_id', $visitante->id)->where('tipo_atraccion_id',117)->get())->pluck('atraccion_id')->toArray();
            $atraccionesN = collect(Atraccion_Visitada::where('visitante_id', $visitante->id)->where('tipo_atraccion_id',94)->get())->pluck('atraccion_id')->toArray();
            $tipoAtraccionesN = collect(Lugar_Visitado::where('visitante_id',$visitante->id)->where('actividad_realizada_id',2)->get())->pluck('tipo_atraccion_id')->toArray();
            $tipoAtraccionesM = collect(Lugar_Visitado::where('visitante_id',$visitante->id)->where('actividad_realizada_id',3)->get())->pluck('tipo_atraccion_id')->toArray();
            $actividadesH = collect(Actividad_Hecha_Visitante::where('visitante_id',$visitante->id)->where('acitvidades_realizadas_id',8)->get())->pluck('actividad_id')->toArray();
            $actividadesD = collect(Actividad_Hecha_Visitante::where('visitante_id',$visitante->id)->where('acitvidades_realizadas_id',10)->get())->pluck('actividad_id')->toArray();
            $actividadesRelizadas = collect(Actividad_Realizada_Por_Visitante::where('visitante_id',$visitante->id)->get())->pluck('actividades_realizadas_id')->toArray();
            
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
                array_push($tipoAtraccionesN,117);
            }
            
            if(count($actividadesD) > 0){
                array_push($actividadesRelizadas,10);
            }
            
            if(count($actividadesH) > 0){
                array_push($actividadesRelizadas,8);
            }
            
            $encuesta['Favorito'] = count($visitante->atracciones) == 0 ? null : $visitante->atracciones->first()->id;
            $encuesta['Estancias'] = $estancias;
            $encuesta['ActividadesRelizadas'] = $actividadesRelizadas;
            $encuesta['Principal'] = $principal;
            $encuesta['AtraccionesP'] = $atraccionesP;
            $encuesta['AtraccionesN'] = $atraccionesN;
            $encuesta['AtraccionesM'] = $atraccionesM;
            $encuesta['ActividadesD'] = $actividadesD;
            $encuesta['ActividadesH'] = $actividadesH;
            $encuesta['TipoAtraccionesN'] = $tipoAtraccionesN;
            $encuesta['TipoAtraccionesM'] = $tipoAtraccionesM;
            
            
        }
        
        $enlaces = collect();
        $enlaces['Municipios'] = $municipios;
        $enlaces['Alojamientos'] = $alojamientos;
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
			'Id' => 'required|exists:visitantes,id',
			'Estancias' => 'required|min:1',
			'Estancias.*.Municipio' => 'required|exists:municipios,id',
			'Estancias.*.Alojamiento' => 'required|exists:tipos_alojamiento,id',
			'Estancias.*.Noches' => 'required|min:0',
			'Principal' => 'required|exists:municipios,id',
			'Favorito' => 'exists:atracciones,id',
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
       		'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
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
       		'Favorito.exists' => 'La atracción favorita no se encuentra registrada en el sistema.',
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
		
		$visitante = Visitante::find($request->Id);
		$diferencia = (  strtotime($visitante->fecha_salida) - strtotime($visitante->fecha_llegada) ) / 86400;
		$numeroDias = $diferencia;
		$noches = 0;
		
		foreach($request->Estancias as $estancia){
		    $noches+=$estancia['Noches'];
		    
		    if($estancia['Noches'] == 0 && $estancoa['Alojamiento'] != 15 ){
		        return ["success" => false, "errores" => [["Si el número de noches es igual a 0 debe seleccionar la opcion Ningún tipo de alojamiento."]] ];
		    }
		    
		    if( collect($request->Estancias)->where('Municipio', $estancia['Municipio'] )->count() > 1 ){
		        return ["success" => false, "errores" => [["No debe repetir un municipio en las estancias."]] ];
		    }
		    
		}
		
		if($noches > $numeroDias){
		    return ["success" => false, "errores" => [["La suma del número de noches no debe ser mayor al número de días del viaje."]] ];
		}
		
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
		if($visitante->ultima_sesion >= 2){
		    $sw =1;
		    Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->delete();
		    Atraccion_Visitada::where('visitante_id', $visitante->id)->delete();
		    Lugar_Visitado::where('visitante_id', $visitante->id)->delete();
		    Actividad_Hecha_Visitante::where('visitante_id', $visitante->id)->delete();
		    Actividad_Realizada_Por_Visitante::where('visitante_id', $visitante->id)->delete();
		}else{
		    $visitante->ultima_sesion = 2;
		}
		
		if(isset($request->Favorito)){
		    $visitante->atracciones()->detach();
		    $visitante->atracciones()->attach($request->Favorito);
		}
		
		foreach($request->Estancias as $estancia){
		    Municipio_Visitado_Magdalena::create([
	            'visitante_id' => $visitante->id,
	            'municipios_id' => $estancia['Municipio'],
	            'tipo_alojamiento_id' => $estancia['Alojamiento'],
	            'numero_noches' => $estancia['Noches'],
	            'destino_principal' => $estancia['Municipio'] == $request->Principal ? 1 : 0
	        ]);
		}
		
		foreach($request->ActividadesRelizadas as $actividad){
		    switch($actividad){
		        case 1:
		            foreach ($request->AtraccionesP as $value) {
		                Atraccion_Visitada::create([
	                        'atraccion_id' => $value,
	                        'visitante_id' => $visitante->id,
	                        'actividades_realizadas_id' => $actividad,
	                        'tipo_atraccion_id' => 77
	                    ]);
		            }
		            break;
	            case 2:
	                foreach($request->TipoAtraccionesN as $tipoAtrac){
	                    if($tipoAtrac == 94){
	                        foreach($request->AtraccionesN as $value){
	                            Atraccion_Visitada::create([
        	                        'atraccion_id' => $value,
        	                        'visitante_id' => $visitante->id,
        	                        'actividades_realizadas_id' => $actividad,
        	                        'tipo_atraccion_id' => $tipoAtrac
        	                    ]);
	                        }
	                    }else{
	                        Lugar_Visitado::create([
                                'actividad_realizada_id' => $actividad,
                                'tipo_atraccion_id' => $tipoAtrac,
                                'visitante_id' => $visitante->id,
                                'estado' => 1
                            ]);
	                    }
	                }
	                break;
                case 3:
                    foreach($request->TipoAtraccionesM as $tipoAtrac){
                        if($tipoAtrac == 117){
                            foreach($request->AtraccionesM as $value){
                                Atraccion_Visitada::create([
        	                        'atraccion_id' => $value,
        	                        'visitante_id' => $visitante->id,
        	                        'actividades_realizadas_id' => $actividad,
        	                        'tipo_atraccion_id' => $tipoAtrac
        	                    ]);
                            }
                        }else{
                            Lugar_Visitado::create([
                                'actividad_realizada_id' => $actividad,
                                'tipo_atraccion_id' => $tipoAtrac,
                                'visitante_id' => $visitante->id,
                                'estado' => 1
                            ]);
                        }
                    }
                    break;
                case 8:
                    foreach($request->ActividadesH as $tipoActi){
                        Actividad_Hecha_Visitante::create([
                            'acitvidades_realizadas_id' => $actividad,
                            'actividad_id' => $tipoActi,
                            'visitante_id' => $visitante->id
                        ]);
                    }
                    break;
                case 10:
                    foreach($request->ActividadesD as $tipoActi){
                        Actividad_Hecha_Visitante::create([
                            'acitvidades_realizadas_id' => $actividad,
                            'actividad_id' => $tipoActi,
                            'visitante_id' => $visitante->id
                        ]);
                    }
                    break;
                default:
                    Actividad_Realizada_Por_Visitante::create([
                        'actividades_realizadas_id' => $actividad,
                        'visitante_id' => $visitante->id
                    ]);
                    break;
		    }
		}
		$visitante->save();
        return ["success" => true];
    }
    
    public function getSecciontransporte(){
        return view('turismoReceptor.SeccionTransporte');
    }
    
    public function getSecciongrupoviaje(){
        return view('turismoReceptor.SeccionViajeGrupo');
    }
    
    public function getSecciongastos(){
        return view('turismoReceptor.Gastos');
    }
    
    public function getSeccionpercepcionviaje(){
        return view('turismoReceptor.PercepcionViaje');
    }
    
    public function getSeccionfuentesinformacion(){
        return view('turismoReceptor.FuentesInformacionVisitante');
    }
    public function actividades(){
        return Actividades::all();
    }
}
