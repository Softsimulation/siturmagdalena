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
use App\Models\Encuesta;
use App\Models\Visitante_estado;
use App\Models\Tipo_Transporte;
use App\Models\Visitante_Transporte_Terrestre;
use App\Models\Tipo_Acompaniante_Visitante;
use App\Models\Otro_Turista;
use App\Models\Otro_Acompaniante_Viaje;
use App\Models\Fuente_Informacion_Antes_Viaje;
use App\Models\Fuente_Informacion_Durante_Viaje;
use App\Models\Redes_Sociales;
use App\Models\Otra_Fuente_Informacion_Antes_Viaje;
use App\Models\Otra_Fuente_Informacion_Durante_Viaje;
use App\Models\Visitante_Compartir_Redes;
use App\Models\Aspectos_Evaluado;
use App\Models\Elemento_Representativo;
use App\Models\Volveria_Visitar;
use App\Models\Calificacion;
use App\Models\Valoracion_General;
use App\Models\Otro_Elemento_Representativo;
use App\Models\Divisa_Con_Idioma;
use App\Models\Financiador_Viaje_Con_Idioma;
use App\Models\Opcion_Lugar_Con_Idioma;
use App\Models\Servicio_Paquete_Con_Idioma;
use App\Models\Tipo_Proveedor_Paquete_Con_Idioma;
use App\Models\Rubro;
use App\Models\Visitante_Paquete_Turistico;
use App\Models\Gasto_Visitante;
use App\Models\Sostenibilidad_Visitante;
use App\Models\Actividades_Sostenibilidad_Idiomas;
use App\Models\Opcion_Actividad_Realizada_Con_Idioma;
use App\Models\Opcion_Actividad_Realizada;

class TurismoReceptorController extends Controller
{
    public function getDatosencuestados(){
        return view('turismoReceptor.DatosEncuestados');
    }
    
    public function getInformaciondatoscrear(){
        
        $grupos = Grupo_Viaje::orderBy('id')->get()->pluck('id');
        
        $encuestadores = Digitador::with([ 'aspNetUser'=>function($q){$q->select('id','username');} ])->get();
        
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
        
        $result = [ 
            'grupos' => $grupos, 
            'encuestadores' => $encuestadores, 
            'lugar_nacimiento' => $lugar_nacimiento, 
            'paises' => $paises,
            'motivos' => $motivos,
            'medicos' => $medicos,
            'departamentos' => $departamentos,
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
        
        
        
		return ["success" => true, 'id' => $visitante->id];
    }
    
    public function getEditardatos($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        
        return view('turismoReceptor.EditarDatos',["id"=>$id]);
    }
    
    public function getCargareditardatos($id){
        
        $visitante = null;
        $visitanteCargar = Visitante::find($id);
        $departamentosr = null;
        $municipiosr = null;
        $municipiosd = null;
        if($visitanteCargar){
            $visitante = collect();
            
            $visitante['Id'] = $visitanteCargar->id;
            $visitante['Grupo'] = $visitanteCargar->grupo_viaje_id;
            $visitante['Encuestador'] = $visitanteCargar->encuestador_creada;
            $visitante['Encuestador_nombre'] = $visitanteCargar->digitadoreDigitada->aspNetUser->username;
            $visitante['Llegada'] = $visitanteCargar->fecha_llegada;
            $visitante['Salida'] = $visitanteCargar->fecha_salida;
            $visitante['Nombre'] = $visitanteCargar->nombre;
            $visitante['Edad'] = $visitanteCargar->edad;
            $visitante['Sexo'] = $visitanteCargar->sexo ? 1 : 0;
            $visitante['Email'] = $visitanteCargar->email;
            $visitante['Telefono'] = $visitanteCargar->telefono;
            $visitante['Celular'] = $visitanteCargar->celular;
            $visitante['Nacimiento'] = $visitanteCargar->opciones_lugares_id;
            $visitante['Pais_Nacimiento'] = $visitanteCargar->pais_nacimiento;
            $visitante['Municipio'] = $visitanteCargar->municipio_residencia;
            $visitante['Departamento'] = $visitanteCargar->municipioResidencia->departamento_id;
            $visitante['Pais'] = $visitanteCargar->municipioResidencia->departamento->pais_id;
            $visitante['Motivo'] = $visitanteCargar->motivo_viaje;
            $visitante['Destino'] = $visitanteCargar->destino_principal;
            $visitante['DepartamentoDestino'] = $visitanteCargar->municipioPrincipal!=null?$visitanteCargar->municipioPrincipal->departamento_id : null;
            $visitante['Salud'] = count($visitanteCargar->tiposAtencionSaluds) > 0 ? $visitanteCargar->tiposAtencionSaluds->take(1)->id : null;
            $visitante['Horas'] = $visitanteCargar->visitantesTransito != null ? $visitanteCargar->visitantesTransito->horas_transito : null ;
            $visitante['Otro'] = $visitanteCargar->otrosMotivo != null ? $visitanteCargar->otrosMotivo->otro_motivo : null ;
            
            $departamentosr = Departamento::where('pais_id', $visitanteCargar->municipioResidencia->departamento->pais_id)->orderBy('nombre')->get(["id","nombre"]);
            $municipiosr = Municipio::where('departamento_id',$visitanteCargar->municipioResidencia->departamento_id)->orderBy('nombre')->get(["id","nombre"]);
            
            if($visitante['Destino'] != null  && $visitanteCargar->municipioPrincipal != null){
                $municipiosd = Municipio::where('departamento_id',$visitanteCargar->municipioPrincipal->departamento_id)->orderBy('nombre')->get(["id","nombre"]);
            }
        }
        
        $result = [ 
            'datos' => $this->getInformaciondatoscrear(),
            'visitante' => $visitante,
            'departamentosr' => $departamentosr,
            'departamentosr' => $departamentosr,
            'municipiosr' => $municipiosr,
            'municipiosd' => $municipiosd,
        ];
        
        return $result;
    }
    
    public function postGuardareditardatos(Request $request){
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
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
    	],[
    	    'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
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
    	]);
    	
    	$municipio = Municipio::find($request->Municipio);
		if($municipio->departamento->pais_id != 47 && $request->Destino==null){
		    return ["success"=>false,"errores"=> [ ["El id del destino principal es inválido."] ] ];
		}
		
		$visitante = Visitante::find($request->Id);
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
		
		$visitante->visitantesTransito()->delete();
		$visitante->tiposAtencionSaluds()->detach();
        $visitante->otrosMotivo()->delete();
    	
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
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => 'Se ha modificado la sección de información general.',
            'usuario_id' => 1
        ]));
    	
    	$visitante->save();
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
        $municipios = Municipio::where('departamento_id', 1396)->select('id','nombre')->get();
        
        $alojamientos = Tipo_Alojamiento::with(["tiposAlojamientoConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipos_alojamientos_id','nombre');
        }])->get();
        
        $actividadesrealizadas = Actividad_Realizada::where('estado',1)->with(["actividadesRealizadasConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('actividad_realizada_id','nombre');
        },"opciones" => function($q){
            $q->orderBy('id')->with(["opcionesActividadesRealizadasIdiomas" => function($w){
                $w->whereHas('idioma',function($p){
                    $p->where('culture','es');
                })->select('opciones_actividad_realizada_id','nombre');
            }]);
        }])->get();
        
        
        $atraccionesportal = Atracciones::where('estado',1)->with(['sitio' => function($q){
            $q->with(['sitiosConIdiomas' => function($p){
                $p->whereHas('idioma', function($x){
                    $x->where('culture','es');
                })->select('sitios_id','nombre');
            }]);
        }])->get();
        
        $visitante = Visitante::find($id);
        $encuesta = null;
        if($visitante->ultima_sesion >= 2){
            $estancias = Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->get(['municipios_id AS Municipio','tipo_alojamiento_id AS Alojamiento','numero_noches AS Noches']);
            $principal = Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->where('destino_principal',1)->first() != null ? Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->where('destino_principal',1)->first()->municipios_id : null;
            
            $encuesta = collect();
            $arreglo = array();
            
            foreach ($actividadesrealizadas as $actividad) {
                
                $respuestasIds = $visitante->opcionesActividadesRealizadas->where('actividad_realizada_id',$actividad->id)->pluck('id')->toArray();
                
                if(count($respuestasIds) > 0){
                    $actividad->Respuestas = $respuestasIds;
                    if(in_array(22,$respuestasIds)){
                        $actividad->otro = $visitante->opcionesActividadesRealizadas->where('id',22)->first()->pivot->otro;
                    }
                    if(in_array(26,$respuestasIds)){
                        $actividad->otro = $visitante->opcionesActividadesRealizadas->where('id',26)->first()->pivot->otro;
                    }
                    if(in_array(34,$respuestasIds)){
                        $actividad->otro = $visitante->opcionesActividadesRealizadas->where('id',34)->first()->pivot->otro;
                    }
                    array_push($arreglo,$actividad);
                }else{
                    if(Actividad_Realizada_Por_Visitante::where('actividades_realizadas_id',$actividad->id)->where('visitante_id',$visitante->id)->first() != null){
                        if($actividad->id == 19){
                            $actividad->otroActividad = Actividad_Realizada_Por_Visitante::where('actividades_realizadas_id',$actividad->id)->where('visitante_id',$visitante->id)->first()->otro;
                        }
                        array_push($arreglo,$actividad);    
                    }
                }
                
            }
            
            $encuesta['ActividadesRelizadas'] = $arreglo;
            $encuesta['Estancias'] = $estancias;
            $encuesta['Principal'] = $principal;
        }
        
        $enlaces = collect();
        $enlaces['Municipios'] = $municipios;
        $enlaces['Alojamientos'] = $alojamientos;
        $enlaces['Actividadesrelizadas'] = $actividadesrealizadas;
        
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
			'ActividadesRelizadas' => 'required',
			'ActividadesRelizadas.*.id' => 'exists:actividades_realizadas,id',
			'ActividadesRelizadas.*.Respuestas.*' => 'exists:opciones_actividades_realizadas,id',
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
       		'ActividadesRelizadas.*.id.exists' => 'Alguna de las actividades realizadas no se encuentra registrada en el sistema.',
       		'ActividadesRelizadas.*.Respuestas.*.exists' => 'Verifique que alguna de las opciones del segundo nivel se encuentre registrada en el sistema.',
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
		    
		    if($estancia['Noches'] == 0 && $estancia['Alojamiento'] != 15 ){
		        return ["success" => false, "errores" => [["Si el número de noches es igual a 0 debe seleccionar la opcion Ningún tipo de alojamiento."]] ];
		    }
		    
		    if( collect($request->Estancias)->where('Municipio', $estancia['Municipio'] )->count() > 1 ){
		        return ["success" => false, "errores" => [["No debe repetir un municipio en las estancias."]] ];
		    }
		    
		}
		
		if($noches > $numeroDias){
		    return ["success" => false, "errores" => [["La suma del número de noches no debe ser mayor al número de días del viaje."]] ];
		}
		
		foreach($request->ActividadesRelizadas as $actividad){
		    if($actividad['id'] == 19 && !isset($actividad['otroActividad']) ){
		        return ["success" => false, "errores" => [["Si en las actividades realizadas seleccionó el valor 'Otro' debe ingresar el texto de este."]] ];
		    }
		    
		    if(count($actividad['opciones']) > 0 && count($actividad['Respuestas']) == 0 ){
		        return ["success" => false, "errores" => [["Verifique que en las actividades que tengan segundo nivel haya seleccionado alguna opción."]] ];    
		    }
		    
		    switch($actividad['id']){
		        case 6:
		            if(in_array(22,$actividad['Respuestas']) && !isset($actividad['otro'])  ){
	                    return ["success" => false, "errores" => [["Verifique que ingresoó el campo otro en las opciones del segundo nivel."]] ];  
		            }
		            break;
	            case 8:
		            if(in_array(26,$actividad['Respuestas']) && !isset($actividad['otro'])  ){
	                    return ["success" => false, "errores" => [["Verifique que ingresoó el campo otro en las opciones del segundo nivel."]] ];  
		            }
		            break;
	            case 10:
		            if(in_array(34,$actividad['Respuestas']) && !isset($actividad['otro'])  ){
	                    return ["success" => false, "errores" => [["Verifique que ingresoó el campo otro en las opciones del segundo nivel."]] ];  
		            }
		            break;
		    }
		}
		
		
		$sw = 0;
		if($visitante->ultima_sesion >= 2){
		    $sw =1;
		    Municipio_Visitado_Magdalena::where('visitante_id', $visitante->id)->delete();
		    Actividad_Realizada_Por_Visitante::where('visitante_id', $visitante->id)->delete();
		    $visitante->opcionesActividadesRealizadas()->detach();
		}else{
		    $visitante->ultima_sesion = 2;
		}
		
		
		foreach($request->Estancias as $estancia){
		    $visitante->municipiosVisitadosMagdalenas()->save(new Municipio_Visitado_Magdalena([
	            'municipios_id' => $estancia['Municipio'],
	            'tipo_alojamiento_id' => $estancia['Alojamiento'],
	            'numero_noches' => $estancia['Noches'],
	            'destino_principal' => $estancia['Municipio'] == $request->Principal ? 1 : 0
	        ]));
		}
		
		foreach($request->ActividadesRelizadas as $actividad){
		    if(count($actividad['opciones']) > 0){
		        foreach ($actividad['Respuestas'] as $respuesta) {
		            if( ($actividad['id']==6 && $respuesta == 22) || ($actividad['id']==8 && $respuesta == 26) || ($actividad['id']==10 && $respuesta == 34) ){
		                $visitante->opcionesActividadesRealizadas()->attach($respuesta,['otro' => $actividad['otro']]);
		            }else{
		                $visitante->opcionesActividadesRealizadas()->attach($respuesta);
		            }
		        }
		    }else{
		        $visitante->actividadesRealizadasPorVisitantes()->save(new Actividad_Realizada_Por_Visitante([
                    'actividades_realizadas_id' => $actividad['id'],
                    'estado' => 1,
                    'otro' => $actividad['id'] == 19 ? $actividad['otroActividad'] : null
                ]));
		    }
		}
		
		$visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $sw == 0 ? 'Se ha creado en la sección estancia y visitados' : 'Se ha editado la sección estancia y visitados',
            'usuario_id' => 1
        ]));
		
		$visitante->save();
        return ["success" => true];
    }
    
    public function getEncuestas(){
        
        $encuestas = Visitante_estado::all();
        
        return $encuestas;
    }
    
    public function getListadoencuestas(){
        return view('turismoReceptor.Encuestas');
    }
    
    public function getSecciontransporte($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        return view('turismoReceptor.SeccionTransporte',["id" => $id]);
    }
    
    public function getCargardatostransporte($id = null){
        
        $visitante = Visitante::find($id);
        if($visitante == null){
            return ["success" => false];
        }
        
        $transporte_llegar = Tipo_Transporte::with(["tiposTransporteConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipos_transporte_id','nombre');
        }])->get();
        
        $lugares = Opcion_Lugar::with(["opcionesLugaresConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('opciones_lugares_id','nombre');
        }])->get();
        
        $sostenibilidad = Sostenibilidad_Visitante::find($id);
        
        $retorno = [
            'success' => true,
            'transporte_llegar' => $transporte_llegar,
            'lugares' => $lugares,
            'calificacion'=>$sostenibilidad == null?null:$sostenibilidad->facil_llegar,
            'mover' => $visitante->transporte_interno,
            'llegar' => $visitante->transporte_llegada,
        ];
        
        return $retorno;
    }
    
    public function postGuardarsecciontransporte(Request $request){
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
			'Llegar' => 'required|exists:tipos_transporte,id',
			'Mover' => 'required|exists:tipos_transporte,id',
			'Calificacion'=>'integer'
    	],[
       		'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
       		'Llegar.required' => 'Debe seleccionar el transporte de llegada.',
       		'Llegar.exists' => 'El transporte de llegada seleccionado no se encuentra registrado en el sistema.',
       		'Mover.required' => 'Debe seleccionar el transporte para moverse dentro del departamento.',
       		'Mover.exists' => 'El campo de transporte dentro del departamento no se encuentra registrado en el sistema.',
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$visitante = Visitante::find($request->Id);
		
		$sw = 0;
		if($visitante->ultima_sesion >= 3){
		    $sw =1;
		   
		}else{
		    $visitante->ultima_sesion = 3;
		}
		
		$visitante->transporte_llegada = $request->Llegar;
		$visitante->transporte_interno = $request->Mover;
		
	
		
		if(isset($request->Calificacion)){
		    $sostenibilidad = Sostenibilidad_Visitante::find($request->Id);
		    if($sostenibilidad == null){
		        $sostenibilidad = new Sostenibilidad_Visitante;
		        $sostenibilidad->visitante_id = $request->Id;
		        $sostenibilidad->estado = true;
		        $sostenibilidad->user_update = "Jhon";
		        $sostenibilidad->user_create = "Jhon";
		    }
		    $sostenibilidad->facil_llegar = $request->Calificacion;
		    $sostenibilidad->save();
		}
		
		$visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $sw == 0 ? 'Se completó la sección de transporte' : 'Se editó la sección de transporte',
            'usuario_id' => 1
        ]));
		
		$visitante->save();
        return ["success" => true, 'sw' => $sw];
    }
    
    public function getSecciongrupoviaje($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        return view('turismoReceptor.SeccionViajeGrupo',["id" => $id]);
    }
    
    public function getCargardatosseccionviaje($id = null){
        $visitante = Visitante::find($id);
        if($visitante == null){
            return ["success" => false];
        }
        
        $viaje_grupos = Tipo_Acompaniante_Visitante::with(["tiposAcompanianteConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            });
        }])->get();
        
        $personas = $visitante->tiposAcompañantesVisitantes()->pluck('id')->toArray();
        
        $retorno = [
            'success' => true,
            'viaje_grupos' => $viaje_grupos,
            'tam_grupo' => $visitante->tamaño_grupo_visitante,
            'personas' => $personas,
            'acompaniantes' => in_array(9,$personas) ? $visitante->otrosTurista->numero_otros : null,
            'otro' => in_array(12,$personas) ? $visitante->otrosAcompañantesViaje->nombre : null
        ];
        
        return $retorno;
    }
    
    public function postGuardarseccionviajegrupo(Request $request){
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
			'Personas' => 'required|min:1|exists:tipos_acompañantes_visitantes,id',
			'Numero' => 'required|min:1',
			'Otro' => 'max:100',
			'Numero_otros' => 'min:1'
    	],[
       		'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
       		'Personas.required' => 'Debe elegir una opción en los acompañantes.',
       		'Personas.min' => 'Debe elegir una opción en los acompañantes.',
       		'Personas.exists' => 'Alguno de los elementos seleccionados en las opciones de los acompañantes no se encuentra registrado en el sistema.',
       		'Numero.required' => 'Debe ingresar el número de personas del viaje.',
       		'Numero.min' => 'El número de personas del viaje debe ser mayor o igual que 1.',
       		'Otro.max' => 'El campo otro no debe superar los 100 caracteres.',
       		'Numero_otros.min' => 'El número de los otros viajeros debe ser mayor o igual que 1.'
    	]);
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->Numero == 1 && count($request->Personas) > 1 ){
		    return ["success" => false, "errores" => [["Si el número de personas es igual a 1 solo debe seleccionar la opción 'Viajé solo'"]] ];
		}
		if($request->Numero > 1 && in_array(1,$request->Personas) ){
		    return ["success" => false, "errores" => [["Si el número de personas es mayor que 1 no debe seleccionar la opción 'Viajé solo'"]] ];
		}
		if( !isset($request->Numero_otros) && in_array(9,$request->Personas) ){
		    return ["success" => false, "errores" => [["El número de los otros turistas es requerido."]] ];
		}
		if( !isset($request->Otro) && in_array(12,$request->Personas) ){
		    return ["success" => false, "errores" => [["Debe ingresar quien era el otro turista."]] ];
		}
		
		$visitante = Visitante::find($request->Id);
		$visitante->tamaño_grupo_visitante = $request->Numero;
		
		$sw = 0;
		if($visitante->ultima_sesion >= 4){
		    $sw =1;
		    $acompaniantes = $visitante->tiposAcompañantesVisitantes()->pluck('id')->toArray();
		    if(in_array(9,$acompaniantes)){
		        $visitante->otrosTurista()->delete();
		    }
		    if(in_array(12,$acompaniantes)){
		        $visitante->otrosAcompañantesViaje()->delete();
		    }
		    $visitante->tiposAcompañantesVisitantes()->detach();
		}else{
		    $visitante->ultima_sesion = 4;
		}
		
		if(in_array(9,$request->Personas)){
	        $visitante->otrosTurista()->save(new Otro_Turista(['numero_otros'=>$request->Numero_otros]));
	    }
	    if(in_array(12,$request->Personas)){
	        $visitante->otrosAcompañantesViaje()->save(new Otro_Acompaniante_Viaje(['nombre' => $request->Otro]));
	    }
		
		$visitante->tiposAcompañantesVisitantes()->attach($request->Personas);
		
		$visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $sw == 0 ? 'Se completó la sección de viaje en grupo' : 'Se editó la sección de viaje en grupo',
            'usuario_id' => 1
        ]));
		
		$visitante->save();
		return ["success" => true, 'sw' => $sw];
    }
    
    public function getSecciongastos($id){
       if(Visitante::find($id) == null){
            return \Redirect::to('/turismoreceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        $data = ["id"=>$id];
        return view('turismoReceptor.Gastos',$data);
    }
    
    public function getInfogasto($id){
        
        
        $divisas = Divisa_Con_Idioma::whereHas('idioma',function($q){
            $q->where('culture','es');
        })->select('divisas_id as id','nombre')->get();
        
        $financiadores = Financiador_Viaje_Con_Idioma::whereHas('idioma',function($q){
            $q->where('culture','es');
        })->select('financiadores_viaje_id as id','nombre')->get();
        
        $municipios = Municipio::select('id','nombre')->get();
        
        $opciones = Opcion_Lugar_Con_Idioma::whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('opciones_lugares_id as id','nombre')->get();
        
        $servicios =  Servicio_Paquete_Con_Idioma::whereHas('idioma',function($q){
             $q->where('culture','es');
        })->select('servicios_paquete_id as id','nombre')->get();
        
        $tipos = Tipo_Proveedor_Paquete_Con_Idioma ::whereHas('idioma',function($q){
            $q->where('culture','es');
        })->select('tipo_proveedor_paquete_id as id','nombre')->get();
        
        $rubros =  Rubro::with(["rubrosConIdiomas"=>function($q){
            $q->where('idiomas_id',1);
        },"gastosVisitantes"=>function($r) use($id){
            $r->where('visitante_id',$id);
        }])->get();
        
        $paquete = Visitante_Paquete_Turistico::find($id);
        
        $visitante = Visitante::find($id);
        
        $encuesta["id"]= $id;
        if($visitante->ultima_sesion>=5){
            
            $encuesta["RealizoGasto"] = Gasto_Visitante::where('visitante_id',$id)->count()>0 || $paquete != null ? 1:0;
            
            $encuesta["ViajoDepartamento"] = $paquete != null ? 1 :0;
            
            if( $encuesta["ViajoDepartamento"] == 1){
                $encuesta["CostoPaquete"] = $paquete->costo_paquete;
                $encuesta["DivisaPaquete"] = $paquete->divisas_id;
                $encuesta["PersonasCubrio"] = $paquete->personas_cubrio;
                $encuesta["IncluyoOtros"] = $paquete->municipios()->count()>0?1:0;
                $encuesta["Municipios"] = $paquete->municipios()->pluck('id');
                $encuesta["Proveedor"] = $paquete->tipo_proveedor_paquete_id;
                if($paquete->opcionesLugares()->first() != null){
                    
                    $encuesta["LugarAgencia"]= $paquete->opcionesLugares()->first()->id;
                }
                $encuesta["ServiciosIncluidos"] = $paquete->serviciosPaquetes()->pluck('id');
            }
            
          
            
            if($visitante->visitanteTransporteTerrestre!= null){
                $encuesta["Empresa"] = $visitante->visitanteTransporteTerrestre->nombre_empresa;
            }
            if(count($visitante->opcionesLugares) > 0){
                $encuesta["Alquiler"] = $visitante->opcionesLugares()->first()->id;
            }
            
            if(count($visitante->opcionesLugaresG) > 0){
                $encuesta["Ropa"] = $visitante->opcionesLugaresG()->first()->id;
            }
            
            $encuesta["GastosAparte"] = Gasto_Visitante::where('visitante_id',$id)->count()>0 ? 1 :0;
        }
        $encuesta["Financiadores"] = Visitante::find($id)->financiadoresViajes()->pluck('id');
         

        return ["divisas"=>$divisas ,"financiadores"=>$financiadores ,"municipios"=>$municipios,"opciones"=>$opciones,"servicios"=>$servicios,"rubros"=>$rubros,"tipos"=>$tipos,"encuesta"=>$encuesta];
        
    }
    
    public function postGuardargastos(Request $request){
        
         $validator = \Validator::make($request->all(), [
             
			'id' => 'required|exists:visitantes,id',
			'RealizoGasto' => 'required|between:0,1',
			'ViajoDepartamento' => 'required_if:RealizoGasto,1|between:0,1',
			'CostoPaquete' => 'required_if:ViajoDepartamento,1',
			'DivisaPaquete' => 'required_if:ViajeDepartamento,1|exists:divisas,id',
			'PersonasCubrio' => 'required_if:ViajeDepartamento,1|integer|min:1',
			'IncluyoOtros' => 'required_if:ViajoDepartamento,1|between:0,1',
			'Municipios' => 'required_if:IncluyoOtros,1|array',
			'Municipios.*' => 'required|exists:municipios,id',
			'Proveedor' => 'required_if:ViajoDepartamento,1|exists:tipo_proveedor_paquete,id',
			'LugarAgencia' => 'required_if:Proveedor,1|exists:opciones_lugares,id',
			'ServiciosIncluidos' => 'required_if:ViajoDepartamento,1|array',
			'ServiciosIncluidos.*' => 'required|exists:servicios_paquete,id',
			'GastosAparte' => 'required_if:RealizoGasto,1|between:0,1',
			'Financiadores' => 'required|array',
			'Financiadores.*' => 'required|exists:financiadores_viajes,id',
			'Rubros'=>'required_if:GastosAparte,1|array',
			
    	],[
       		'RealizoGasto.required' => 'Debe seleccionar la opción de realizar los gastos.',
       		'RealizoGasto.between' => 'No es un valor válido para el campo.',
       		'CostoPaquete.required_if' => 'Debe seleccionar el costo del paquete.',
       		'DivisaPaquete.required_if' => 'Debe seleccionar la divisa del paquete.',
       		'DivisaPaquete.exists' => 'Esta divisa no se encuentra almacenada en el sistema.',
       		'PersonasCubrio.required_if' => 'Debe ingresar el número de personas que cubre el paquete.',
       		'PersonasCubrio.min' => 'El número de personas debe ser mayor o igual a 1.',
       		'IncluyoOtros.required' => 'Debe seleccionar la opción de realizar los gastos.',
       		'IncluyoOtros.between' => 'No es un valor válido para el campo.',
       		'Municipios.required_if' => 'El campo municipio es requerido.',
       		'Municipios.*.exists' => 'El municipio no está registrado en el sistema.',
       		'Proveedor.required_if' => 'El campo proveedor del paquete es requerido.',
       		'Proveedor.exists' => 'El proveedor no existe en el sistema.',
       		'LugarAgencia.required_if' => 'El lugar de la agencia es requerido.',
       		'LugarAgencia.exists' => 'El lugar de la ubicación de la agencia no está registrada en el sistema.',
       		'ServiciosIncluidos.required_if' => 'Los servicios incluidos son requeridos.',
       		'ServiciosIncluidos.*.exists' => 'El servicio incluido no existe en el sistema.',
       		'GastosAparte.required' => 'El campo de proporcionar gastos adicionales es requerido.',
       		'Financiadores.required' => 'El campo de financiadores de viaje es requerido.',
       		'Financiadores.*.exists' => 'El financiador de viaje no existe.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
    	
    	foreach($request->Rubros as $rub){
    	    
    	    
    	    if(isset($rub["gastos_visitantes"][0]["cantidad_pagada_magdalena"]) && isset($rub["gastos_visitantes"][0]["divisas_magdalena"]) && isset($rub["gastos_visitantes"][0]["personas_cubiertas"])){
    	        if($rub["gastos_visitantes"][0]["cantidad_pagada_magdalena"] != null && ($rub["gastos_visitantes"][0]["divisas_magdalena"] == null || $rub["gastos_visitantes"][0]["personas_cubiertas"] == null ) ){
    	            
    	            if($rub["gastos_visitantes"][0]["divisas_magdalena"] == null){
    	                return ["success"=>false,"errores"=> [ ["La divisa es requerida en el rubro dentro del magdalena."] ] ];
    	            }
    	             if($rub["gastos_visitantes"][0]["personas_cubiertas"] == null){
    	                return ["success"=>false,"errores"=> [ ["Las personas cubiertas son requeridas."] ] ];
    	            }
        	        
        	     }
    	    }
        	
        	switch($rub["id"]){
        	    case 3:
        	        if(!isset($request->Empresa)){
        	            return ["success"=>false,"errores"=> [ ["El campo empresa es requerido."] ] ];
        	        }
        	        break;
        	    case 5:
        	        if(!isset($request->Alquiler)){
        	            return ["success"=>false,"errores"=> [ ["El campo localizacion de empresa de alquiler  es requerido."] ] ];
        	        }
        	        break;
        	    case 10:
        	        if(!isset($request->Ropa)){
        	            return ["success"=>false,"errores"=> [ ["El campo don es requerido."] ] ];
        	        }
        	        break;
        	    default:
        	        break;
        	}    
    	  
    	}
    	
    	$visitante = Visitante::find($request->id);
    	if($request["RealizoGasto"] == 1){
    	    // Paquete
    	    $paquete = Visitante_Paquete_Turistico::find($request->id);
    	    if($request["ViajoDepartamento"] == 1){
    	        if($paquete == null){
    	            $paquete = new Visitante_Paquete_Turistico;
    	            $paquete->visitante_id = $request->id;
    	            $paquete->costo_paquete = $request->CostoPaquete;
    	            $paquete->personas_cubrio = $request->PersonasCubrio;
    	            $paquete->divisas_id = $request->DivisaPaquete;
    	            $paquete->tipo_proveedor_paquete_id = $request->Proveedor;
    	            $paquete->save();
    	        }else{
    	            $paquete->personas_cubrio = $request->PersonasCubrio;
    	            $paquete->divisas_id = $request->DivisaPaquete;
    	            $paquete->tipo_proveedor_paquete_id = $request->Proveedor;
    	        }
    	        $paquete->municipios()->detach();
    	        if($request["IncluyoOtros"]==1){
    	            $paquete->municipios()->attach($request->Municipios);
    	        }
    	        $paquete->opcionesLugares()->detach();
    	        if($paquete->tipo_proveedor_paquete_id == 1){
    	            $paquete->opcionesLugares()->attach($request->LugarAgencia);
    	        }
    	        $paquete->serviciosPaquetes()->detach();
    	        $paquete->serviciosPaquetes()->attach($request->ServiciosIncluidos);
    	        $paquete->save();
    	    }else{
    	        if($paquete != null){
    	            $paquete->municipios()->detach();
    	            $paquete->opcionesLugares()->detach();
    	            $paquete->serviciosPaquetes()->detach();
    	            $paquete->delete();
    	        }
    	    }
    	    
    	    // Rubros
    	    $rubros = Gasto_Visitante::where('visitante_id',$request->id)->delete();
    	    if($request["GastosAparte"] == 1){
    	        foreach($request["Rubros"] as $rub){
    	            
    	            $gasto = new Gasto_Visitante;
    	            $gasto->visitante_id = $request->id;
    	            $gasto->rubros_id = $rub["id"];
    	            
    	            if(isset($rub["gastos_visitantes"][0]["divisas_fuera"]) && isset($rub["gastos_visitantes"][0]["cantidad_pagada_fuera"])){
    	                
    	                if($rub["gastos_visitantes"][0]["divisas_fuera"] != null && $rub["gastos_visitantes"][0]["cantidad_pagada_fuera"] != null){
        	                $gasto->divisas_fuera = $rub["gastos_visitantes"][0]["divisas_fuera"];
        	                $gasto->cantidad_pagada_fuera = $rub["gastos_visitantes"][0]["cantidad_pagada_fuera"];
    	                }
    	            }
    	            
    	            if(isset($rub["gastos_visitantes"][0]["divisas_magdalena"]) && isset($rub["gastos_visitantes"][0]["cantidad_pagada_magdalena"])){
    	                if($rub["gastos_visitantes"][0]["divisas_magdalena"] != null && $rub["gastos_visitantes"][0]["cantidad_pagada_magdalena"] != null){
        	                $gasto->divisas_magdalena = $rub["gastos_visitantes"][0]["divisas_magdalena"];
        	                $gasto->cantidad_pagada_magdalena = $rub["gastos_visitantes"][0]["cantidad_pagada_magdalena"];
    	                }
    	            }
    	            
    	            
    	            if($rub["gastos_visitantes"][0]["personas_cubiertas"] != null){
    	                $gasto->personas_cubiertas = $rub["gastos_visitantes"][0]["personas_cubiertas"];
    	            }
    	            
    	            if(isset($rub["gastos_visitantes"][0]["gastos_asumidos_otros"])){
    	                $gasto->gastos_asumidos_otros = $rub["gastos_visitantes"][0]["gastos_asumidos_otros"];
    	            }
    	            $gasto->save();
    	            
    	            switch($rub["id"]){
                	    case 3:
                	        if(isset($visitante->visitanteTransporteTerrestre)){
                		        $visitante->visitanteTransporteTerrestre()->delete();
                		    }
                		    if(isset($request->Empresa)){
                		        $visitante->visitanteTransporteTerrestre()->save(new Visitante_Transporte_Terrestre([
                	                'nombre_empresa' =>  $request->Empresa
                	            ]));   
                		    }
                		     
                	        break;
                	    case 5:
                	        if(count($visitante->opcionesLugares) > 0){
                		        $visitante->opcionesLugares()->detach();
                		    }
                		    if(isset($request->Alquiler)){
                		        $visitante->opcionesLugares()->attach($request->Alquiler);   
                		    }
                		     
                	        break;
                	    case 10:
                	        if(count($visitante->opcionesLugaresG) > 0){
                		        $visitante->opcionesLugaresG()->detach();
                		    }
                		    if(isset($request->Ropa)){
                		        $visitante->opcionesLugaresG()->attach($request->Ropa);   
                		    }
                	        break;
                	    default:
                	        break;
                	}
    	        }
    	        
    	        
    	        
    	    }
    	    
    	}else{
    	   $paquete = Visitante_Paquete_Turistico::find($request->id);
    	   if($paquete != null){
    	            $paquete->municipios()->detach();
    	            $paquete->opcionesLugares()->detach();
    	            $paquete->serviciosPaquetes()->detach();
    	            $paquete->delete();
    	   }
    	   $rubros = Gasto_Visitante::where('visitante_id',$request->id)->delete();
    	        
    	}
        $visitante->financiadoresViajes()->detach();
        $visitante->financiadoresViajes()->attach($request["Financiadores"]);
        if($visitante->ultima_sesion<5){
            $visitante->ultima_sesion =5;
        }
        
        $visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => 1,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $visitante->ultima_sesion ==5?"Se ha creado la sección de gastos":"Se ha editado la sección de gastos",
            'usuario_id' => 1
        ]));
        $visitante->save();
        return ["success"=>true];
    }
    
    public function getSeccionpercepcionviaje($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        return view('turismoReceptor.PercepcionViaje',["id" => $id]);
    }
    
    public function getCargardatospercepcion($id){
        $visitante = Visitante::find($id);
        if($visitante == null){
            return ["success" => false];
        }
        
        $percepcion = Aspectos_Evaluado::where('estado',1)->with(["aspectosEvaluadosConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('aspectos_evaluados_id','nombre');
        },"itemsEvaluars"=>function($q)use($visitante){
            $q->with(['itemsEvaluarConIdiomas' => function($p){
                $p->whereHas('idioma',function($z){$z->where('culture','es');});
            },"calificacions" => function($p)use($visitante){
                $p->where('visitante_id',$visitante->id);
            }]);
        }])->get();
        
        $elementos = Elemento_Representativo::where('estado',1)->with(["elementosRepresentativosConIdiomas"=>function($q){
            $q->whereHas('idioma',function($p){
                $p->where('culture','es');
            });
        }])->get();
        
        $veces = Volveria_Visitar::where('estado',1)->with(["volveriaVisitarConIdiomas"=>function($q){
            $q->whereHas('idioma',function($p){
                $p->where('culture','es');
            });
        }])->get();
        
        $calificaciones = Calificacion::where("visitante_id",$visitante->id)->with("itemsEvaluar")->get(["item_evaluar_id as Id","calificacion as Valor"]);
        
        $alojamiento = collect($calificaciones)->where("Id",1)->first() != null ? 1 : 0;
        $restaurante = collect($calificaciones)->where("Id",8)->first() != null ? 1 : 0;
        $factores = count(Calificacion::where("visitante_id",$visitante->id)->whereIn('item_evaluar_id',[13,15])->get()) >0 ?1:0;
        
        $ocio = count(Calificacion::where("visitante_id",$visitante->id)->whereIn('item_evaluar_id',[17,20])->get())> 0 ?1:0;
        
        $infraestructura = count(Calificacion::where("visitante_id",$visitante->id)->whereIn('item_evaluar_id',[21,23])->get()) >0 ?1:0;
        
        $sostenibilidad = Sostenibilidad_Visitante::find($id);
        if($sostenibilidad != null){
            $respuestaElementos = $sostenibilidad->actividadesSostenibilidad()->pluck('id')->toArray();
            $flora = $sostenibilidad->es_informado?1:0;
            $sost = $sostenibilidad->trato_turista;
        }
        
        
        $otroElemento = null;
        if(in_array(12,$respuestaElementos)){
           $otroElemento= $sostenibilidad->actividadesSostenibilidad()->wherePivot('nombre','<>',null)->first()->pivot->nombre;
        }
        
        $valo = Valoracion_General::where('visitante_id',$visitante->id)->select(["recomendaciones as Recomendacion","calificacion as Calificacion", "volveria as Volveria","recomendaria as Recomienda","veces_visitadas as Veces"])->first();
        
        
        
        $actividades = Actividades_Sostenibilidad_Idiomas::whereHas('idioma',function($q){
            $q->where('culture','es');
        })->select('actividades_sostenibilidad_id as id','nombre')->get();;
        
        $retorno = [
            'success' => true,
            'percepcion' => $percepcion,
            'elementos' => $elementos,
            'veces' => $veces,
            'calificar' => $calificaciones,
            'alojamiento' => $alojamiento,
            'restaurante' => $restaurante,
            'factores'=>$factores,
            'ocio'=>$ocio,
            'infraestructura'=>$infraestructura,
            'respuestaElementos' => $respuestaElementos,
            'valoracion' => $valo,
            'otroElemento' => $otroElemento,
            'actividades'=>$actividades,
            'flora'=>$flora,
            'sost'=>$sost,
        ];
        
        return $retorno;
        
    }
    
    public function postGuardarseccionpercepcion(Request $request){
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
			'Alojamiento' => 'required',
			'Restaurante' => 'required',
			'Factores'=>'required',
			'Ocio'=>'required',
			'Infra'=>'required',
			'Elementos' => 'exists:actividades_sostenibilidad,id',
			'Recomendaciones'=> 'max:250',
			'Calificacion' => 'required|between:1,10',
			'Volveria' => 'required|exists:volveria_visitar,id',
			'Recomienda' => 'required|exists:volveria_visitar,id',
			'VecesVisitadas' => 'required',
			'OtroElementos' => 'max:100',
			'Evaluacion' => 'required',
    	],[
       		'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
    	]);
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$aux = collect($request->Evaluacion)->pluck('Id')->toArray();
		if($request->Alojamiento == 1){
		    for($i=1;$i<=7;$i++){
		        if(!in_array($i,$aux)){
		            return ["success"=>false,"errores"=>[["Por favor califique todos los items del aspecto de alojamiento."]]];
		        }
		    }
		}
		if($request->Restaurante == 1){
		    for($i=8;$i<=12;$i++){
		        if(!in_array($i,$aux)){
		            return ["success"=>false,"errores"=>[["Por favor califique todos los items del aspecto de restaurante."]]];
		        }
		    }
		}
		if( (!isset($request->OtroElementos)) && in_array(11,$request->Elementos) ){
		    return ["success"=>false,"errores"=>[["Por favor ingrese el campo de valor otro."]]];
		}
		
		$visitante = Visitante::find($request->Id);
		$sw = 0;
		if($visitante->ultima_sesion >= 6){
		    $sw =1;
		    $visitante->elementosRepresentativos()->detach();
	        $visitante->calificacions()->delete();
	        $visitante->valoracionGeneral()->delete();
	        if($visitante->otrosElementosRepresentativo!=null){$visitante->otrosElementosRepresentativo()->delete();}
		}else{
		    $visitante->ultima_sesion = 6;
		}
		
		foreach($request->Evaluacion as $evaluacion){
		        $visitante->calificacions()->save(new Calificacion([
	                'item_evaluar_id' => $evaluacion['Id'],
	                'calificacion' => $evaluacion['Valor']
	            ]));
		    }
		
		$sostenibilidad = Sostenibilidad_Visitante::find($request->Id);
		    if($sostenibilidad == null){
		        $sostenibilidad = new Sostenibilidad_Visitante;
		        $sostenibilidad->visitante_id = $request->Id;
		        $sostenibilidad->estado = true;
		        $sostenibilidad->user_update = "Jhon";
		        $sostenibilidad->user_create = "Jhon";
		    }else{
		        $sostenibilidad->actividadesSostenibilidad()->detach();
		    }
		    
		    if(isset($request->Elementos)){
		        foreach($request->Elementos as $el){
		            
		            if($el == 12){
		                
		                $sostenibilidad->actividadesSostenibilidad()->attach($el,['nombre'=>$request->OtroElementos]);
		            }else{
		                 $sostenibilidad->actividadesSostenibilidad()->attach($el);
		            }
		            
		        }
		        
		    }
		    
		    if(isset($request->Flora)){
		        $sostenibilidad->es_informado = $request->Flora != 0? true:false;
		    }
		    
		    if(isset($request->Sostenibilidad)){
		        $sostenibilidad->trato_turista = $request->Sostenibilidad;
		    }
		
		    $sostenibilidad->save();
		
	    /*$visitante->elementosRepresentativos()->attach($request->Elementos);
	    if(in_array(11,$request->Elementos)){
	        $visitante->otrosElementosRepresentativo()->save(new Otro_Elemento_Representativo(['nombre'=>$request->OtroElementos]));
	    }*/
	    
	    $visitante->valoracionGeneral()->save(new Valoracion_General([
            'volveria' => $request->Volveria,
            'veces_visitadas' => $request->VecesVisitadas,
            'recomendaciones' => $request->Recomendaciones,
            'calificacion' => $request->Calificacion,
            'recomendaria' => $request->Recomienda
        ]));
		
		$visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $sw == 0 ? 'Se completó la sección de fuente de percepción del visitante' : 'Se editó la sección de fuente de percepción del visitante',
            'usuario_id' => 1
        ]));
		
		$visitante->save();
		return ["success" => true, 'sw' => $sw];
    }
    
    public function getSeccionfuentesinformacion($id){
        if(Visitante::find($id) == null){
            return \Redirect::to('/turismoReceptor/encuestas')
                    ->with('message', 'El visitante seleccionado no se encuentra registrado.')
                    ->withInput();
        }
        return view('turismoReceptor.FuentesInformacionVisitante',["id" => $id]);
    }
    
    public function getCargardatosseccioninformacion($id){
        $visitante = Visitante::find($id);
        if($visitante == null){
            return ["success" => false];
        }
        
        $fuentesAntes = Fuente_Informacion_Antes_Viaje::with(["fuenteInformacionAntesViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('fuentes_informacion_antes_viaje_id','nombre');
        }])->get();
        
        $fuentesDurante = Fuente_Informacion_Durante_Viaje::with(["fuentesInformacionDuranteViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('fuente_informacion_durante_viaje_id','nombre');
        }])->get();
        
        $redes = Redes_Sociales::where('estado',1)->get(['id as Id','nombre as Nombre']);
        
        $fuentes_antes = $visitante->fuentesInformacionAntesViajes()->pluck('id')->toArray();
        $fuentes_durante = $visitante->fuentesInformacionDuranteViajes()->pluck('id')->toArray();
        $compar_redes = $visitante->redesSociales()->pluck('id')->toArray();
        
        if(in_array(14,$fuentes_antes)){
            $OtroFuenteAntes = $visitante->otrasFuenteInformacionAntesViaje->nombre;
        }
        if(in_array(14,$fuentes_durante)){
            $OtroFuenteDurante = $visitante->otrasFuenteInformacionDuranteViaje->nombre;
        }
        
        $retorno = [
            'success' => true,
            'fuentesAntes' => $fuentesAntes,
            'fuentesDurante' => $fuentesDurante,
            'redes' => $redes,
            'fuentes_antes' => $fuentes_antes,
            'fuentes_durante' => $fuentes_durante,
            'compar_redes' => $compar_redes,
            'otroRed' => in_array(12,$compar_redes) ? $visitante->redesSociales()->wherePivot('otro','<>',null)->first()->pivot->otro : null,
            'OtroFuenteAntes' => isset($OtroFuenteAntes) ? $OtroFuenteAntes : null,
            'OtroFuenteDurante' => isset($OtroFuenteDurante) ? $OtroFuenteDurante : null,
            'facebook' => $visitante->visitanteCompartirRede != null ? $visitante->visitanteCompartirRede->nombre_facebook : null,
            'twitter' => $visitante->visitanteCompartirRede != null ? $visitante->visitanteCompartirRede->nombre_twitter : null,
            'invitacion_correo' => $visitante->invitacion_correo == 1 ? 1 : -1,
            'invitacion' => $visitante->visitanteCompartirRede != null ? 1 : -1,
            'facilidad' => $visitante->facilidad == 1 ? 1 : -1,
            'conoce_marca' => $visitante->conoce_marca == 1 ? 1 : -1,
            'acepta_autorizacion' => $visitante->acepta_autorizacion == 1 ? 1 : -1,
            'acepta_tratamiento' => $visitante->acepta_tratamiento == 1 ? 1 : -1,
        ];
        
        return $retorno;
    }
    
    public function postGuardarseccioninformacion(Request $request){
        $validator = \Validator::make($request->all(), [
			'Id' => 'required|exists:visitantes,id',
			'FuentesAntes' => 'required|min:1|exists:fuentes_informacion_antes_viaje,id',
			'FuentesDurante' => 'required|min:1|exists:fuentes_informacion_durante_viaje,id',
			'Redes' => 'required|min:1|exists:redes_sociales,id',
			'Correo' => 'required',
			'Invitacion' => 'required',
			'NombreFacebook' => 'max:100',
			'NombreTwitter' => 'max:100',
			'OtroFuenteAntes' => 'max:100',
			'OtroFuenteDurante' => 'max:100',
			'otroRed' => 'max:100',
			'facilidad' => 'required',
			'conoce_marca' => 'required',
			'acepta_autorizacion' => 'required',
			'acepta_tratamiento' => 'required',
    	],[
       		'Id.required' => 'Debe seleccionar el visitante a realizar la encuesta.',
       		'Id.exists' => 'El visitante seleccionado no se encuentra seleccionado en el sistema.',
       		'FuentesAntes.required' => 'Debe seleccionar alguna de las fuentes de información antes del viaje.',
       		'FuentesAntes.min' => 'Debe seleccionar alguna de las fuentes de información antes del viaje.',
       		'FuentesAntes.exists' => 'Alguna de las fuentes de información antes del viaje no se encuentra registrada en el sistema.',
       		'FuentesDurante.required' => 'Debe seleccionar alguna de las fuentes de información durante el viaje.',
       		'FuentesDurante.min' => 'Debe seleccionar alguna de las fuentes de información durante el viaje.',
       		'FuentesDurante.exists' => 'Alguna de las fuentes de información durante el viaje no se encuentra registrada en el sistema.',
       		'Redes.required' => 'Debe selecionar alguna de las opciones en las redes sociales.',
       		'Redes.min' => 'Debe selecionar alguna de las opciones en las redes sociales.',
       		'Redes.exists' => 'Alguna de las redes sociales seleccionadas no se encuentra ingresada en el sistema.',
       		'Correo' => 'Debe seleccionar alguna opción para confirmar la invitación por correo.',
       		'Correo.beetwen' => 'Verifique la información y vuelva a intentarlo.',
       		'Invitacion' => 'Debe seleccionar alguna opción para confirmar la invitación por redes sociales.',
       		'Invitacion.beetwen' => 'Verifique la información y vuelva a intentarlo.',
       		'NombreFacebook.max' => 'EL campo nombre de usuario de Facebook no debe superar los 100 caracteres.',
       		'NombreTwitter.max' => 'EL campo nombre de usuario de Twitter no debe superar los 100 caracteres.',
       		'OtroFuenteAntes.max' => 'EL campo nombre de otro en fuentes de información antes del viaje no debe superar los 100 caracteres.',
       		'OtroFuenteDurante.max' => 'EL campo nombre de otro en fuentes de información durante el viaje no debe superar los 100 caracteres.',
       		'otroRed.max' => 'EL campo nombre de otro en redes después del viaje no debe superar los 100 caracteres.',
       		'facilidad.required' => 'Debe seleccionar alguna de las opciones en la pregunta de sostenibilidad.',
       		'conoce_marca.required' => 'Debe seleccionar alguna de las opciones en la pregunta de conocimiento de marca.',
       		'acepta_autorizacion.required' => 'Debe seleccionar alguna de las opciones en la pregunta de autorización de contacto nuevamente.',
       		'acepta_tratamiento.required' => 'Debe seleccionar alguna de las opciones en la pregunta de autorización de tratamiento de datos.',
    	]);
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->Invitacion == 1 && !(isset($request->NombreFacebook)) && !(isset($request->NombreTwitter)) ){
		    return ["success" => false, "errores" => [["Por favor ingrese alguna de sus redes sociales."]] ];
		}
		if( !(isset($request->OtroFuenteAntes)) && in_array(14,$request->FuentesAntes) ){
		    return ["success" => false, "errores" => [["Por favor ingrese la otra fuente de información antes de llegar al departamento."]] ];
		}
		if( !(isset($request->OtroFuenteDurante)) && in_array(14,$request->FuentesDurante) ){
		    return ["success" => false, "errores" => [["Por favor ingrese la otra fuente de información durante la estadia."]] ];
		}
		if( !(isset($request->otroRed)) && in_array(12,$request->Redes) ){
		    return ["success" => false, "errores" => [["Por favor ingrese la otra red de información después la estadia."]] ];
		}
		
		$visitante = Visitante::find($request->Id);
		
		$sw = 0;
		if($visitante->ultima_sesion >= 7){
		    $sw =1;
		    $fuentesAntes = $visitante->fuentesInformacionAntesViajes()->pluck('id')->toArray();
		    $fuentesDurante = $visitante->fuentesInformacionDuranteViajes()->pluck('id')->toArray();
		    
		    if(in_array(14,$fuentesAntes)){
		        $visitante->otrasFuenteInformacionAntesViaje()->delete();
		    }
		    if(in_array(14,$fuentesDurante)){
		        $visitante->otrasFuenteInformacionDuranteViaje()->delete();
		    }
		    
		    if($visitante->visitanteCompartirRede != null){
		       $visitante->visitanteCompartirRede()->delete(); 
		    }
		    
		    $visitante->fuentesInformacionAntesViajes()->detach();
		    $visitante->fuentesInformacionDuranteViajes()->detach();
		    $visitante->redesSociales()->detach();
		}else{
		    $visitante->ultima_sesion = 7;
		}
		
		$visitante->fuentesInformacionAntesViajes()->attach($request->FuentesAntes);
		$visitante->fuentesInformacionDuranteViajes()->attach($request->FuentesDurante);
		
		foreach($request->Redes as $red){
		    if($red == 12){
		        $visitante->redesSociales()->attach($red, ['otro' => $request->otroRed]);
		    }else{
		        $visitante->redesSociales()->attach($red);
		    }    
		}
		
		if(in_array(14,$request->FuentesAntes)){
		    $visitante->otrasFuenteInformacionAntesViaje()->save(new Otra_Fuente_Informacion_Antes_Viaje(['nombre'=>$request->OtroFuenteAntes]));
		}
		if(in_array(14,$request->FuentesDurante)){
		    $visitante->otrasFuenteInformacionDuranteViaje()->save(new Otra_Fuente_Informacion_Durante_Viaje(['nombre'=>$request->OtroFuenteDurante]));
		}
		if($request->Invitacion == 1){
		    $visitante->visitanteCompartirRede()->save(new Visitante_Compartir_Redes(["nombre_facebook"=>$request->NombreFacebook,"nombre_twitter"=>$request->NombreTwitter]));
		}
		
		$visitante->invitacion_correo = $request->Correo == 1 ? 1 : 0;
		$visitante->facilidad = $request->facilidad == 1 ? 1 : 0;
		$visitante->conoce_marca = $request->conoce_marca == 1 ? 1 : 0;
		$visitante->acepta_autorizacion = $request->acepta_autorizacion == 1 ? 1 : 0;
		$visitante->acepta_tratamiento = $request->acepta_tratamiento == 1 ? 1 : 0;
		
		$visitante->historialEncuestas()->save(new Historial_Encuesta([
            'estado_id' => $visitante->ultima_sesion != 7 ? 2 : 3,
            'fecha_cambio' => date('Y-m-d H:i:s'), 
            'mensaje' => $sw == 0 ? 'Se completó la sección de fuente de información del visitante' : 'Se editó la sección de fuente de información del visitante',
            'usuario_id' => 1
        ]));
		
        $visitante->save();
        return ["success" => true, 'sw' => $sw];
    }
    
}
