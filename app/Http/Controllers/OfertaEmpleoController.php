<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Servicio_Agencia;
use App\Models\Encuesta;
use App\Models\Viaje_Turismo;
use App\Models\Viaje_Turismo_Otro;
use App\Models\Opcion_Persona_Destino;
use App\Models\Persona_Destino_Con_Viaje_Turismo;
use App\Models\Plan_Santamarta;
use App\Models\Actividad_Servicio;
use App\Models\Provision_Alimento;
use App\Models\Especialidad;
use App\Models\Capacidad_Alimento;
use App\Models\Historial_Encuesta_Oferta;
use App\Models\Actividad_Deportiva;
use App\Models\Tour;

use App\Models\Agencia_Operadora;
use App\Models\Otra_Actividad;
use App\Models\Otro_Tour;

use App\Models\Prestamo_Servicio;
use App\Models\Alquiler_Vehiculo;


use App\Models\alojamiento;
use App\Models\Casa;
use App\Models\Camping;
use App\Models\Habitacion;
use App\Models\Apartamento;
use App\Models\Cabana;


class OfertaEmpleoController extends Controller
{
    //
    
    
    public function getCrearEncuesta(){
        return view('ofertaempleo.CrearEncuesta');
    }
    
    public function getEncuestaspendientes($id){
        
       
        $meses = array();
        $pendientes = array();
        for($i = 1;$i<=11;$i++){
            $now = Carbon::now();
            $copy  = $now->addMonth(-$i);
            array_push($meses,$copy);
        }
        
        foreach($meses as $me){
            $nombreMes = Mes::find($me->month);
            $anio = Anio::where('anio',$me->year)->get();
            if($anio == null){
                 array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
            }else{
                $meses_anio = Mes_Anio::where('mes_id',$me->month)->whereHas('anio',function($q) use ($me){
                    $q->where('anio',$me->year);
                })->first();
                 
                if($meses_anio == null){
                      array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                }else{
                    
                    $encuesta = Encuesta::where('sitios_para_encuestas_id',$id)->get();
                    if($encuesta==null){
                        array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                    }
                }
                
            }
            
            
        }
        
        return ["mes"=>$pendientes];

    }
    //Lucho
    public function getAgenciaviajes($id){
        return view('ofertaEmpleo.AgenciaViajes',array('id' => $id));
    }
    
    public function getOfertaagenciaviajes($id){
        return view('ofertaEmpleo.OfertaAgenciaViaje',array('id' => $id));
    }
    
    public function getCaracterizacionalimentos($id){
        return view('ofertaEmpleo.CaracterizacionAlimentos',array('id' => $id));
    }
    public function getCapacidadalimentos($id){
        return view('ofertaEmpleo.CapacidadAlimentos',array('id' => $id));
    }
    public function getDatosagencia(){
        $servicios = Servicio_Agencia::all();
        //$servicios = (from servicio in conexion.servicios_agencias select new { id = servicio.id, nombre = servicio.nombre }).ToList();
        //return json.Serialize(servicios);
        return $servicios;
    }
    public function getAgencia($id){
        $agencia = Encuesta::with(['viajesTurismos'=>function($q){
            $q->with(['viajesTurismosOtro','serviciosAgencias'=>function($r){
                $r->select('id');
            }]);
        }])->where('id',$id)->firstOrFail();
        
        //return $agencia;
        
        $agenciaRetornar = [];
        $agenciaRetornar["Id"] = $agencia->id;
        if(sizeof($agencia["viajesTurismos"]) != 0){
            $agenciaRetornar["TipoServicios"] = sizeof($agencia["viajesTurismos"][0]) == 0 ? null : $agencia["viajesTurismos"][0];
            $agenciaRetornar["Planes"] = sizeof($agencia["viajesTurismos"][0]->ofreceplanes) == 0 ? null : $agencia["viajesTurismos"][0]->ofreceplanes;
            $agenciaRetornar["Otro"] = sizeof($agencia["viajesTurismos"][0]->viajesTurismosOtro["otro"]) == 0 ? null : $agencia["viajesTurismos"][0]->viajesTurismosOtro["otro"];
        }else{
            $agenciaRetornar["TipoServicios"] = [];
            $agenciaRetornar["Planes"] = "";
            $agenciaRetornar["Otro"] = "";
        }
        
        /*
        CaracterizacionAgenciasViewModel enviar = new CaracterizacionAgenciasViewModel();
            var agencia = (from encuesta in conexion.encuestas
                           join viajes in conexion.viajes_turismos on encuesta.id equals viajes.encuestas_id
                           join otro in conexion.viajes_turismos_otro on viajes.id equals otro.viajes_turismo_id into joined
                           from otro in joined.DefaultIfEmpty()
                           where encuesta.id == id
                           select new CaracterizacionAgenciasViewModel
                           {
                               Id = encuesta.id,
                               TipoServicios = viajes.servicios_agencias.Select(x => x.id).ToList(),
                               Planes = viajes.ofreceplanes,
                               Otro = otro.otro
                           }).ToList();
        return $servicios;*/
        return $agenciaRetornar;
    }
    /*
        [HttpPost]
        public string GetAgencia(int id)
        {

            CaracterizacionAgenciasViewModel enviar = new CaracterizacionAgenciasViewModel();
            var agencia = (from encuesta in conexion.encuestas
                           join viajes in conexion.viajes_turismos on encuesta.id equals viajes.encuestas_id
                           join otro in conexion.viajes_turismos_otro on viajes.id equals otro.viajes_turismo_id into joined
                           from otro in joined.DefaultIfEmpty()
                           where encuesta.id == id
                           select new CaracterizacionAgenciasViewModel
                           {
                               Id = encuesta.id,
                               TipoServicios = viajes.servicios_agencias.Select(x => x.id).ToList(),
                               Planes = viajes.ofreceplanes,
                               Otro = otro.otro
                           }).ToList();
            if (agencia.Count == 0)
            {
                var usuario = (from e in conexion.encuestas
                              join s in conexion.sitios_para_encuestas on e.sitios_para_encuestas_id equals s.id
                              where e.id == id
                              select s.AspNetUser.Id).FirstOrDefault();
                var agenciaanterior = (from encuesta in conexion.encuestas
                                       join viajes in conexion.viajes_turismos on encuesta.id equals viajes.encuestas_id
                                       join otro in conexion.viajes_turismos_otro on viajes.id equals otro.viajes_turismo_id into joined
                                       from otro in joined.DefaultIfEmpty()
                                       where encuesta.id != id && encuesta.sitios_para_encuestas.user_id == usuario
                                       orderby encuesta.id ascending
                                       select new CaracterizacionAgenciasViewModel
                                       {
                                           Id = encuesta.id,
                                           TipoServicios = viajes.servicios_agencias.Select(x => x.id).ToList(),
                                           Planes = viajes.ofreceplanes,
                                           Otro = otro.otro

                                       }).ToList();

                if (agenciaanterior.Count > 0)
                {
                    enviar = agenciaanterior.Last();
                }

            }
            else
            {

                enviar = agencia.First();

            }

            return json.Serialize(enviar);
        }*/
    
    public function postGuardarcaracterizacion(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:encuestas,id',
            'Planes' => 'bit|required',
            'TipoServicios' => 'required',
            
        ],[
            'Id.required' => 'Tuvo primero que haber creado una encuesta.',
            'Id.exists' => 'Tuvo primero que haber creado una encuesta.',
            'Planes.required' => 'El campo planes es requerido.',
            'TipoServicios.required' => 'Debe seleccionar por lo menos un tipo de servicio.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $agencia = Encuesta::with(['viajesTurismos'=>function($q){
            $q->with('viajesTurismosOtro');
        }])->where('id',$request->id)->first();
        
        if(sizeof($agencia["viajesTurismos"]) == 0){
            $viajes_turismos = new Viaje_Turismo();
            $viajes_turismos->encuestas_id = $request->id;
            $viajes_turismos->ofreceplanes = $request->Planes;
            $viajes_turismos->save();
            foreach ($request->TipoServicios as $servi)
            {
                $viajes_turismos->serviciosAgencias()->attach($servi);
                $viajes_turismos->save();
                if ($servi == 5)
                {
                    $viajes_turismos_otro = new Viaje_Turismo_Otro();
                    $viajes_turismos_otro->viajes_turismo_id = $viajes_turismos->id;
                    $viajes_turismos_otro->otro = $request->Otro;
                    $viajes_turismos_otro->save();
                }
            }
        }else{
            $viajes_turismos = Viaje_Turismo::where('encuestas_id',$request->id)->first();
            $viajes_turismos->ofreceplanes = $request->Planes;
            
            $viajes_turismos->serviciosAgencias()->detach();
            foreach ($request->TipoServicios as $servi)
            {
                $viajes_turismos->serviciosAgencias()->attach($servi);
                $viajes_turismos->save();
                if ($servi == 5)
                {
                    //$viajes_turismos_otro = new Viaje_Turismo_Otro();
                    $viajes_turismos_otro =  Viaje_Turismo_Otro::where('viajes_turismo_id',$viajes_turismos->id)->first();
                    $viajes_turismos_otro->otro = $request->Otro;
                    $viajes_turismos_otro->save();
                }
                
            }
        }
        return ["success"=>true];
    }
    public function getDatosofertaagencia(){
        //var destinos = (from destino in conexion.opciones_personas_destinos select new { id = destino.id, nombre = destino.nombre }).ToList();
        $destinos = Opcion_Persona_Destino::all();
        //$servicios = (from servicio in conexion.servicios_agencias select new { id = servicio.id, nombre = servicio.nombre }).ToList();
        //return json.Serialize(servicios);
        return $destinos;
    }
    public function getOfertaagencia($id)
    {

        $agencia = Viaje_Turismo::with(['planesSantamarta','personasDestinoConViajesTurismos'=>function($q){
            $q->with('opcionesPersonasDestino');
        }])->where('encuestas_id',$id)->first();
        
        
        
        /*from encuesta in conexion.encuestas
                      join viaje in conexion.viajes_turismos on encuesta.id equals viaje.encuestas_id
                      join planes in conexion.planes_santamarta on viaje.id equals planes.viajes_turismos_id
                      where encuesta.id == id
                      select new OfertaAgenciaViajesViewModel
                      {
                          Personas = viaje.personas_destino_con_viajes_turismos.OrderBy(x => x.opciones_personas_destino_id).ToList().Select(x => new ViajesDestinoViewModel
                          {
                              opciones_personas_destino_id = x.opciones_personas_destino_id,
                              numerototal = x.numerototal,
                              internacional = x.internacional,
                              nacional = x.nacional,
                          }).ToList(),
                          numero = planes.numero,
                          internacional = planes.extrajeros,
                          nacional = planes.noresidentes,
                          magdalena = planes.residentes,
                          Id = viaje.id
                      };
        if (agencia.Count() > 0)
        {
            return json.Serialize(agencia.First());
        }
        else
        {

            return json.Serialize(new { Id = 0 });
        }*/

        return $agencia;
    }
    public function postGuardarofertaagenciaviajes(Request $request)
        {
            //return $request->all();
            $validator = \Validator::make($request->all(),[
        
                'id' => 'required|exists:encuestas,id',
                'numero' => 'double|required',
                'magdalena' => 'double|required|between:0,100',
                'nacional' => 'double|required|between:0,100',
                'internacional' => 'double|required|between:0,100',
                
            ],[
                'Id.required' => 'Tuvo primero que haber creado una encuesta.',
                'Id.exists' => 'Tuvo primero que haber creado una encuesta.',
                'numero.required' => 'El número total de personas que viajaron con planes a Santa Marta es requerido.',
                'numero.double' => 'El número total de personas que viajaron con planes a Santa Marta debe ser de valor numérico.',
                'magdalena.required' => 'El porcentaje comprado por residentes en el magdalena es requerido.',
                'magdalena.double' => 'El porcentaje comprado por residentes en el magdalena debe ser de valor numérico.',
                'magdalena.between' => 'El porcentaje comprado por residentes en el magdalena debe ser menor o igual a 100.',
                'nacional.required' => 'El porcentaje comprado por residentes fuera del magdalena es requerido.',
                'nacional.double' => 'El porcentaje comprado por residentes fuera del magdalena debe ser de valor numérico.',
                'nacional.between' => 'El porcentaje comprado por residentes fuera del magdalena debe ser menor o igual a 100.',
                'internacional.required' => 'El porcentaje comprado por residentes en el extranjero es requerido.',
                'internacional.double' => 'El porcentaje comprado por residentes en el extranjero debe ser de valor numérico.',
                'internacional.between' => 'El porcentaje comprado por residentes en el extramjero debe ser menor o igual a 100.',
                ]
            ); 
            $errores = [];
            foreach ($request->personas as $fila)
            {
                if(intval($fila["internacional"]) + intval($fila["nacional"]) != 100){
                    $errores["Porcentajes"][0] = "Todo los porcentajes en la seccion personas que viajaron segun destinos deben sumar 100.";
                }
                if(Opcion_Persona_Destino::find(intval($fila["opciones_personas_destino_id"])) == null){
                    $errores["Opciones"][0] = "Una de las opciones cargadas no esta disponible.";
                }
            }
            if($request->magdalena + $request->nacional + $request->internacional){
                $errores["PorcentajeMagdalena"][0] = "Los porcentajes en los viajes en el magdalena deben sumar 100.";
            }
            if(sizeof($errores) > 0){
                return ['success'=>false, 'errores'=>$errores];
            }
            $agencia = Viaje_Turismo::with(['personasDestinoConViajesTurismos','planesSantamarta'])->where('encuestas_id',$request->id)->first();
            //return $agencia;
            if (sizeof($agencia->personasDestinoConViajesTurismos) > 0)
            {
                //$agencia->personasDestinoConViajesTurismos()->detach();
                $personas = Persona_Destino_Con_Viaje_Turismo::where('viajes_turismos_id',$agencia->id)->delete();
                foreach ($request->personas as $fila)
                {
                    //return $fila;
                    //return $agencia;
                    //return $agencia->opcionesPersonasDestino;
                    
                    $personaDestino = new Persona_Destino_Con_Viaje_Turismo();
                    $personaDestino->viajes_turismos_id = $agencia->id;
                    $personaDestino->opciones_personas_destino_id = $fila["opciones_personas_destino_id"];
                    $personaDestino->internacional = $fila["internacional"];
                    $personaDestino->nacional = $fila["nacional"];
                    $personaDestino->numerototal = $fila["numerototal"];
                    $personaDestino->save();
                }
                $planSantaMarta = Plan_Santamarta::where('viajes_turismos_id',$agencia->id)->first();
                $planSantaMarta->numero = $request->numero;
                $planSantaMarta->residentes = $request->magdalena;
                $planSantaMarta->noresidentes = $request->nacional;
                $planSantaMarta->extrajeros = $request->internacional;
                $planSantaMarta->save();
            }
            else
            {
                foreach ($request->personas as $fila)
                {
                    //return $fila;
                    //return $agencia;
                    //return $agencia->opcionesPersonasDestino;
                    
                    $personaDestino = new Persona_Destino_Con_Viaje_Turismo();
                    $personaDestino->viajes_turismos_id = $agencia->id;
                    $personaDestino->opciones_personas_destino_id = $fila["opciones_personas_destino_id"];
                    $personaDestino->internacional = $fila["internacional"];
                    $personaDestino->nacional = $fila["nacional"];
                    $personaDestino->numerototal = $fila["numerototal"];
                    $personaDestino->save();
                }
                $planSantaMarta = new Plan_Santamarta();
                $planSantaMarta->viajes_turismos_id = $agencia->id;
                $planSantaMarta->numero = $request->numero;
                $planSantaMarta->residentes = $request->magdalena;
                $planSantaMarta->noresidentes = $request->nacional;
                $planSantaMarta->extrajeros = $request->internacional;
                $planSantaMarta->save();

            }
    }
        
        
    public function getInfocaracterizacionalimentos($id)
    {
        $actividades_servicios = Actividad_Servicio::all();
        $especialidades = Especialidad::all();
        
        $encuesta = Encuesta::with('sitiosParaEncuesta')->where('id',$id)->firstOrFail();
        $especialidad = null;
        $sirvePlatos = null;
        $mesas = null;
        $asientos = null;
        
        if($encuesta != null){
            $provisionesAlimentos = Provision_Alimento::where('encuestas_id',$encuesta->id)->first();
            if($provisionesAlimentos != null){
                $especialidad = $provisionesAlimentos->especialidades_id;
                $sirvePlatos = $provisionesAlimentos->actividades_servicio_id;
                $mesas = $provisionesAlimentos->numero_mesas;
                $asientos = $provisionesAlimentos->numero_asientos;
            }else{
                //$user = Sitio_Para_Encuesta::where('user_id',1)->firstOrFail();
            }
        }
        $provision = [];
        $provision["especialidad"] = $especialidad;
        $provision["sirvePlatos"] = $sirvePlatos;
        $provision["mesas"] = $mesas;
        $provision["asientos"] = $asientos;
        return ["actividades_servicios"=>$actividades_servicios, "especialidades"=>$especialidades, "provision"=>$provision];
    }
    public function postGuardarcaralimentos(Request $request)
    {
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:encuestas,id',
            'sirvePlatos' => 'required|exists:actividades_servicios,id',
            'especialidad' => 'required|exists:especialidades,id',
            'mesas' => 'required|numeric|min:1',
            'asientos' => 'required|numeric|min:1',
            
        ],[
            'id.required' => 'Tuvo primero que haber creado una encuesta.',
            'id.exists' => 'Tuvo primero que haber creado una encuesta.',
            'sirvePlatos.required' => 'Debe seleccionar la actividad de servicio del proveedor.',
            'sirvePlatos.exists' => 'La actividad de servicio seleccionada no se encuentra en la base de datos.',
            'especialidad.required' => 'Debe seleccionar la especialidad del proveedor.',
            'especialidad.exists' => 'La especialidad seleccionada no se encuentra en la base de datos.',
            'mesas.required' => 'El número de mesas es requerido.',
            'mesas.numeric' => 'El número de mesas solo puede ser numérico.',
            'mesas.min' => 'El número de mesas debe ser mayor a cero.',
            'asientos.required' => 'El número de asientos es requerido.',
            'asientos.numeric' => 'El número de asientos solo puede ser numérico.',
            'asientos.min' => 'El número de asientos debe ser mayor a cero.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //return $request->all();
            $encuesta = Encuesta::where('id',$request->id)->first();
            $provision = Provision_Alimento::where('encuestas_id',$encuesta->id)->first();
            if ($provision == null)
            {
                $provision = new Provision_Alimento();
                $provision->encuestas_id = $encuesta->id;
                $provision->especialidades_id = $request->especialidad;
                $provision->actividades_servicio_id = $request->sirvePlatos;
                $provision->numero_mesas = $request->mesas;
                $provision->numero_asientos = $request->asientos;
                
            }
            else
            {
                $provision->especialidades_id = $request->especialidad;
                $provision->actividades_servicio_id = $request->sirvePlatos;
                $provision->numero_mesas = $request->mesas;
                $provision->numero_asientos = $request->asientos;
            }
            $provision->save();

            $historial = new Historial_Encuesta_Oferta();
            $historial->encuesta_id = $encuesta->id;
            $historial->estado_encuesta_id = 2;
            $historial->fecha_cambio = Carbon::now();
            $historial->user_id = 1;
            
            $historial->save();
            
            return ["success"=>true];
            
    }
    
    public function getInfocapalimentos($id)
    {
        $provision = Provision_Alimento::with('capacidadAlimento')->where('encuestas_id',$id)->first();
        //return $provision;
        $capacidad = [];
        $capacidad["platosMaximo"] = null;
        $capacidad["platoServido"] = null;
        $capacidad["precioPlato"] = null;
        $capacidad["platosPromedio"] = null;
        $capacidad["unidadServida"] = null;
        $capacidad["bebidasMaximo"] = null;
        $capacidad["tipo"] = null;
        $capacidad["valor_unidad"] = null;
        $capacidad["bebidasServidas"] = null;
        $capacidad["bebidaValor"] = null;
        $capacidad["precioUnidad"] = null;
        
        $capacidad["tipo"] = $provision->actividades_servicio_id;
        if($provision["capacidadAlimento"] != null || sizeof($provision["capacidadAlimento"]) > 0){
            $capacidad["platosMaximo"] = $provision["capacidadAlimento"]->max_platos;
            $capacidad["platoServido"] = $provision["capacidadAlimento"]->platos_servidos;
            $capacidad["precioPlato"] = intval($provision["capacidadAlimento"]->valor_plato);
            $capacidad["platosPromedio"] = $provision["capacidadAlimento"]->promedio_unidades;
            $capacidad["unidadServida"] = $provision["capacidadAlimento"]->unidades_vendidas;
            
            $capacidad["precioUnidad"] = $provision["capacidadAlimento"]->valor_unidad;
            $capacidad["bebidasMaximo"] = $provision["capacidadAlimento"]->bebidas_promedio;
            $capacidad["bebidasServidas"] = $provision["capacidadAlimento"]->bebidas_servidas;
            $capacidad["bebidaValor"] = intval($provision["capacidadAlimento"]->valor_bebida);
            $capacidad["valor_unidad"] = $provision["capacidadAlimento"]->valor_unidad;
        }
        return ["capacidad"=>$capacidad];
    }
    
    public function getCaracterizacionagenciasoperadoras($id){
        return view('ofertaEmpleo.caracterizacionAgenciasOperadora',['id'=>$id]);
    }
    
    public function getInfocaracterizacionoperadora($id){
        $actividadesDeportivas = Actividad_Deportiva::all();
        $toures = Tour::all();
        
        $encuesta = Encuesta::find($id);
        $agencia = $encuesta->agenciasOperadoras->first();
        $retornado = null;
        if($agencia){
            $retornado["planes"] = $agencia->numero_planes;
            $retornado["actividades"] = $agencia->actividadesDeportivas->pluck('id');
            $retornado["toures"] = $agencia->tours->pluck('id');
            $retornado["otraC"] = $agencia->otras_actividades;
            $retornado["otraD"] = count($agencia->otraActividads) > 0 ? $agencia->otraActividads->first()->nombre : null;
            $retornado["otroT"] = count($agencia->otroTours) > 0 ? $agencia->otroTours->first()->nombre : null;
        }
        
        return ['toures' => $toures, 'actividades' => $actividadesDeportivas, 'retornado' => $retornado];
    }
    
    public function postCrearcaracterizacionoperadora(Request $request){
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:encuestas,id',
			'planes' => 'required|min:1',
			'actividades' => 'required',
			'actividades.*.' => 'exists:actividades_deportivas,id',
			'toures' => 'required',
			'toures.*.id' => 'exists:tours,id',
			'otraD' => 'max:255',
			'otraC' => 'max:255',
			'otroT' => 'max:255'
    	],[
       		'id.required' => 'Verifique la información y vuelva a intentarlo.',
       		'id.exists' => 'La encuesta seleccionada no se encuentra registrada en el sistema.',
       		'planes.required' => 'Debe ingresar un valor en la cantidad de planes.',
       		'planes.min' => 'El campo cantidad de planes debe ser mayor o igual que 1.',
       		'actividades.required' => 'Debe seleccionar alguna de las actividades deportivas.',
       		'actividades.exists' => 'Alguna de las actividades seleccionadas no se encuentra registrada en el sistema.',
       		'toures.required' => 'Debe seleccionar alguno de los toures.',
       		'toures.exists' => 'Alguno de los toures seleccionados no se encuentra registrado en el sistema.',
       		'otraD.max' => 'La otra actividad deportiva no debe superar los 255 caracteres.',
       		'otraC.max' => 'La otra actividad recreativa no debe superar los 255 caracteres.',
       		'otroT.max' => 'El otro tour no debe superar los 255 caracteres.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if( (!isset($request->otraD)) && in_array(15,$request->actividades) ){
		    return ["success" => false, "errores" => [["El campo otra actividad deportiva es requerido."]] ];
		}
		if( (!isset($request->otroT)) && in_array(14,$request->toures) ){
		    return ["success" => false, "errores" => [["El campo otro tour es requerido."]] ];
		}
		
		$encuesta = Encuesta::find($request->id);
		$agencia = $encuesta->agenciasOperadoras->first();
		if($agencia){
		    if(!in_array(15,$request->actividades)){
		        $agencia->otraActividads()->delete();
		    }
		    if(!in_array(14,$request->toures)){
		        $agencia->otroTours()->delete();
		    }
		    $agencia->actividadesDeportivas()->detach();
		    $agencia->tours()->detach();
		}else{
		    $agencia = new Agencia_Operadora();
		    $agencia->encuestas_id = $encuesta->id;
		}
		
		$agencia->numero_planes = $request->planes;
		$agencia->otras_actividades = $request->otraC;
		$agencia->save();
		
		if(in_array(15,$request->actividades)){
		    $otraActividad = $agencia->otraActividads->first();
		    if($otraActividad){
		        $otraActividad->nombre = $request->otraD;
		        $otraActividad->save();
		    }else{
		        Otra_Actividad::create([
	                'nombre' => $request->otraD,
	                'agencia_operadora_id' => $agencia->id
	            ]);
		    }
		}
		
		if(in_array(14,$request->toures)){
		    $otrTour = $agencia->otroTours->first();
		    if($otrTour){
		        $otrTour->nombre = $request->otroT;
		        $otrTour->save();
		    }else{
		        Otro_Tour::create([
	                'nombre' => $request->otroT,
	                'agencias_operadoras_id' => $agencia->id
	            ]);
		    }
		}
		
		$agencia->actividadesDeportivas()->attach($request->actividades);
		$agencia->tours()->attach($request->toures);
		
		Historial_Encuesta_Oferta::create([
	        'encuesta_id' => $encuesta->id,
	        'user_id' => 1,
	        'estado_encuesta_id' => 2,
	        'fecha_cambio' => Carbon::now()
	    ]);
		
        return ["success" => true];
    }
    
    public function getOcupacionagenciasoperadoras($id){
        return view('ofertaEmpleo.ofertaAgenciasOperadoras',["id" => $id]);
    }
    
    public function getCargardatosocupacionoperadoras($id){
        $encuesta = Encuesta::find($id);
        $prestamoCargar = null;
        if($encuesta){
            $agencia = $encuesta->agenciasOperadoras->first();
            if($agencia){
                $prestamo = $agencia->prestamosServicios->first();  
                $prestamoCargar["totalP"] = floatval($prestamo->numero_personas);
                $prestamoCargar["porcentajeC"] = floatval($prestamo->personas_colombianas);
                $prestamoCargar["porcentajeE"] = floatval($prestamo->personas_extranjeras);
                $prestamoCargar["porcentajeM"] = floatval($prestamo->personas_magdalena);
            }
        }
		return ["prestamo" => $prestamoCargar];
    }
    
    public function postGuardarocupacionoperadora(Request $request){
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:encuestas,id',
			'totalP' => 'required|min:0',
			'porcentajeC' => 'required|min:0',
			'porcentajeE' => 'required|min:0',
			'porcentajeM' => 'required|min:0',
    	],[
       		'id.required' => 'Verifique la información y vuelva a intentarlo.',
       		'id.exists' => 'La encuesta seleccionada no se encuentra registrada en el sistema.',
       		'totalP.required' => 'El número total es requerido.',
       		'totalP.min' => 'El número de total debe ser mayor que 0.',
       		'porcentajeC.required' => 'El porcentaje de residentes en Colombia excepto magdalenenses es requerido.',
       		'porcentajeC.min' => 'El porcentaje de residentes en Colombia excepto magdalenenses debe ser mayor que 0.',
       		'porcentajeE.required' => 'El porcentaje de extranjeros es requerido.',
       		'porcentajeE.min' => 'El porcentaje de extranjeros debe ser mayor que 0.',
       		'porcentajeM.required' => 'El porcentaje de residentes en el Magdalena es requerido.',
       		'porcentajeM.min' => 'El residentes en el Magdalena debe ser mayor que 0.',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$suma = $request->porcentajeC + $request->porcentajeE + $request->porcentajeM;
		if($suma != 100){
		    return ["success"=>false,"errores"=>[['La suma de los valores porcentuales debe ser igual que 100.']]];
		}
		
		$encuesta = Encuesta::find($request->id);
		$agencia = $encuesta->agenciasOperadoras->first();
		$prestamo = $agencia->prestamosServicios->first();
		if(!$prestamo){
		    $prestamo = new Prestamo_Servicio();
		    $prestamo->agencia_operadora_id = $agencia->id;
		}
		$prestamo->numero_personas = $request->totalP;
		$prestamo->personas_colombianas = $request->porcentajeC;
		$prestamo->personas_extranjeras = $request->porcentajeE;
		$prestamo->personas_magdalena = $request->porcentajeM;
		$prestamo->save();
		
		Historial_Encuesta_Oferta::create([
	        'encuesta_id' => $encuesta->id,
	        'user_id' => 1,
	        'estado_encuesta_id' => 2,
	        'fecha_cambio' => Carbon::now()
	    ]);
		
		return ["success" => true];
    }
    
    public function getCaracterizacionalquilervehiculo($id){
        return view('ofertaEmpleo.caracterizacionAlquilerVehiculo',['id'=>$id]);
    }
    
    public function getCargarcaracterizacionalquilervehiculos($id){
        $encuesta = Encuesta::find($id);
        $alquilerCargar = null;
        
        $alquiler = $encuesta->alquilerVehiculos->first();
        if($alquiler){
            $alquilerCargar["id"] = $encuesta->id;
            $alquilerCargar["VehiculosAlquiler"] = $alquiler->numero_vehiculos;
            $alquilerCargar["PromedioDia"] = $alquiler->vehiculos_alquilados_dia;
            $alquilerCargar["TotalTrimestre"] = $alquiler->vehiculos_alquilados_total;
            $alquilerCargar["Tarifa"] = floatval($alquiler->tarifa_promedio);
        }
        
        
        return ["alquiler" => $alquilerCargar];
    }
    
    public function postGuardarcaracterizacionalquilervehiculo(Request $request){
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:encuestas,id',
			'VehiculosAlquiler' => 'required|min:0',
			'PromedioDia' => 'required|min:0',
			'TotalTrimestre' => 'required|min:0',
			'Tarifa' => 'required|numeric|min:1000',
    	],[
       		'id.required' => 'Verifique la información y vuelva a intentarlo.',
       		'id.exists' => 'La encuesta seleccionada no se encuentra registrada en el sistema.',
       		'VehiculosAlquiler.required' => 'El campo número de vehículos cuenta el establecimiento para alquiler es requerido.',
       		'VehiculosAlquiler.min' => 'El valor mínimo del campo número de vehículos cuenta el establecimiento para alquiler debe ser mayor uno.',
       		'PromedioDia.required' => 'El campo número de vehículos alquilados en promedio al día es requerido.',
       		'PromedioDia.min' => 'El valor mínimo del campo número de vehículos alquilados en promedio al día debe ser mayor a uno.',
       		'TotalTrimestre.required' => 'El campo número de vehículos alquilados en total del trimestre anterior es requerido.',
       		'TotalTrimestre.min' => 'El valor mínimo del campo número de vehículos alquilados en total del trimestre anterior debe ser mayor a uno.',
       		'Tarifa.required' => 'El campo la tarifa promedio para el alquiler de vehículo es requerido.',
       		'Tarifa.min' => 'El valor mínimo del campo la tarifa promedio para el alquiler de vehículo debe ser mayor a 1.000.',
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->VehiculosAlquiler < $request->PromedioDia){
		    return ["success"=>false,"errores"=> [['El campo promedio de vehículos alquilado por día no puede ser mayor que el número de vehículos que cuenta el establecimiento.']] ];
		}
		
		$encuesta = Encuesta::find($request->id);
		$numeroDias = $encuesta->numero_dias;
		if($request->TotalTrimestre > ($request->VehiculosAlquiler*$numeroDias) ){
		    return ["success"=>false,"errores"=> [['El número de vehículos mensuales no puede ser mayor al producto de vehiculos para alquiler x los días de actividad comercial.']] ];
		}
		
		if($request->TotalTrimestre < ($request->PromedioDia*$numeroDias) ){
		    return ["success"=>false,"errores"=> [['El número de vehículos mensuales no puede ser menor al producto de promedio de vehículos diarios x los días de actividad comercial.']] ];
		}
		
		$alquiler = $encuesta->alquilerVehiculos->first();
		if(!$alquiler){
		    $alquiler = new Alquiler_Vehiculo();
		    $alquiler->encuestas_id  = $encuesta->id;
		}
		
		$alquiler->numero_vehiculos = $request->VehiculosAlquiler;
		$alquiler->vehiculos_alquilados_total = $request->TotalTrimestre;
		$alquiler->vehiculos_alquilados_dia = $request->PromedioDia;
		$alquiler->tarifa_promedio = $request->Tarifa;
		$alquiler->save();
		
		Historial_Encuesta_Oferta::create([
	        'encuesta_id' => $encuesta->id,
	        'user_id' => 1,
	        'estado_encuesta_id' => 2,
	        'fecha_cambio' => Carbon::now()
	    ]);
		
		return ["success" => true];
    }
    
    public function getCaracterizacion($id){
        return View('ofertaEmpleo.caracterizacionAlojamientos', ["id"=>$id] );
    }
    
    public function getOferta($id){
        return View('ofertaEmpleo.ofertaAlojamientos', ["id"=>$id] );
    }
    
    
    public function getDataalojamiento($id){ 
       
        $idEncuesta = $id;
      /*
        if( !alojamiento::where("encuestas_id",$id)->first() ){
            $encuesta = Encuesta::find($id);
            $anterior = Encuesta::where([ ["sitios_para_encuestas_id",$encuesta->sitios_para_encuestas_id], ["id","!=",$id] ])
                                  ->latest("id")->first();
            if($anterior){ $idEncuesta = $anterior->id;  }
        }
        */
        $alojamiento = alojamiento::where("encuestas_id",$idEncuesta)->with(["casas","campings","habitaciones","apartamentos","cabanas"])->first();
        
        $servicios = [ "habitacion"=>false, "apartamento"=>false, "casa"=>false, "cabana"=>false, "camping"=>false ];
        
        if($alojamiento){
            $servicios["habitacion"] = count($alojamiento->habitaciones)>0 ? true : false;
            $servicios["apartamento"] = count($alojamiento->apartamentos)>0 ? true : false;
            $servicios["casa"] = count($alojamiento->casas)>0 ? true : false;
            $servicios["camping"] = count($alojamiento->campings)>0 ? true : false;
            $servicios["cabana"] = count($alojamiento->cabanas)>0 ? true : false;
        }
        
        if( $id!=$idEncuesta ){
            $alojamiento["id"] = null;
        }
        
        return [ "alojamiento"=>$alojamiento, "servicios"=>$servicios ];
    } 
    
    public function postGuardarcaracterizacionalojamientos(Request $request){ 
    
        $validate = \ Validator::make($request->all(),
                    [ 
                      "encuesta" => "required|exists:encuestas,id",
                      
                      "habitaciones"=>"array|max:1",
                      "habitaciones.*.total_camas" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.capacidad" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.total" => "required_if:servicios.habitacion,true",
                      
                      "apartamentos"=>"array|max:1",
                      "apartamentos.*.total" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.capacidad" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.habitaciones" => "required_if:servicios.apartamento,true",
                      
                      "casas"=>"array|max:1",
                      "casas.*.total" => "required_if:servicios.casa,true",
                      "casas.*.capacidad" => "required_if:servicios.casa,true",
                      "casas.*.promedio" => "required_if:servicios.casa,true",
                      "casas.*.habitaciones" => "required_if:servicios.casa,true",
                      
                      "campings"=>"array|max:1",
                      "campings.*.area" => "required_if:servicios.camping,true",
                      "campings.*.total_parcelas" => "required_if:servicios.camping,true",
                      "campings.*.capacidad" => "required_if:servicios.camping,true",
                      
                      "cabanas"=>"array|max:1",
                      "cabanas.*.total" => "required_if:servicios.cabana,true",
                      "cabanas.*.capacidad" => "required_if:servicios.cabana,true",
                      "cabanas.*.promedio" => "required_if:servicios.cabana,true",
                      "cabanas.*.habitaciones" => "required_if:servicios.cabana,true",
                      
                    ]);
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
       
    
        $alojamiento = alojamiento::where("encuestas_id",$request->encuesta)->first();
    
        if(!$alojamiento){
           $alojamiento = new alojamiento();
           $alojamiento->encuestas_id = $request->encuesta;
           $alojamiento->save();
        }
      
        /////////////////////////////////////////////////////////////////////////
        $habitacion = Habitacion::where("alojamientos_id", $alojamiento->id)->first();
        if( $request->servicios["habitacion"] ){
            if(!$habitacion){
                $habitacion = new Habitacion();
                $habitacion->alojamientos_id = $alojamiento->id;
            }
            $habitacion->total_camas = $request->habitaciones[0]["total_camas"];
            $habitacion->capacidad = $request->habitaciones[0]["capacidad"];
            $habitacion->total = $request->habitaciones[0]["total"];
            $habitacion->save();
        }
        else{
            if($habitacion){ $habitacion->delete(); }
        }
        
        /////////////////////////////////////////////////////////////////////////
        $apartamento = Apartamento::where("alojamientos_id", $alojamiento->id)->first();
        if( $request->servicios["apartamento"] ){
            if(!$apartamento){
                $apartamento = new Apartamento();
                $apartamento->alojamientos_id = $alojamiento->id;
            }
            $apartamento->total = $request->apartamentos[0]["total"];
            $apartamento->capacidad = $request->apartamentos[0]["capacidad"];
            $apartamento->habitaciones = $request->apartamentos[0]["habitaciones"];
            $apartamento->save();
        }
        else{
            if($apartamento){ $apartamento->delete(); }
        }
        
        /////////////////////////////////////////////////////////////////////////
        $casa = Casa::where("alojamientos_id", $alojamiento->id)->first();
        if( $request->servicios["casa"] ){
            if(!$casa){
                $casa = new Casa();
                $casa->alojamientos_id = $alojamiento->id;
            }
            $casa->total = $request->casas[0]["total"];
            $casa->capacidad = $request->casas[0]["capacidad"];
            $casa->promedio = $request->casas[0]["promedio"];
            $casa->habitaciones = $request->casas[0]["habitaciones"];
            $casa->save();
        }
        else{
            if($casa){ $casa->delete(); }
        }
        
        /////////////////////////////////////////////////////////////////////////
        $camping = Camping::where("alojamientos_id", $alojamiento->id)->first();
        if( $request->servicios["camping"] ){
            if(!$camping){
                $camping = new Camping();
                $camping->alojamientos_id = $alojamiento->id;
            }
            $camping->area = $request->campings[0]["area"];
            $camping->total_parcelas = $request->campings[0]["total_parcelas"];
            $camping->capacidad = $request->campings[0]["capacidad"];
            $camping->save();
        }
        else{
            if($camping){ $camping->delete(); }
        }
        
        /////////////////////////////////////////////////////////////////////////
        $cabana = Cabana::where("alojamientos_id", $alojamiento->id)->first();
        if( $request->servicios["cabana"] ){
            if(!$cabana){
                $cabana = new Cabana();
                $cabana->alojamientos_id = $alojamiento->id;
            }
            $cabana->total = $request->cabanas[0]["total"];
            $cabana->capacidad = $request->cabanas[0]["capacidad"];
            $cabana->promedio = $request->cabanas[0]["promedio"];
            $cabana->habitaciones = $request->cabanas[0]["habitaciones"];
            $cabana->save();
        }
        else{
            if($cabana){ $cabana->delete(); }
        }
        
        Historial_Encuesta_Oferta::create([
           'encuesta_id' => $request->encuesta,
           'user_id' => 1,
           'estado_encuesta_id' => 2,
           'fecha_cambio' => Carbon::now()
        ]);
        
        return [ "success"=>true ];
    }
    
    public function postGuardarofertaalojamientos(Request $request){
    
        $validate = \ Validator::make($request->all(),
                    [ 
                      "encuesta" => "required|exists:encuestas,id",
                      
                      "habitaciones"=>"array|max:1",
                      "habitaciones.*.tarifa" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.numero_personas" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.viajeros_locales" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.viajeros_extranjeros" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.habitaciones_ocupadas" => "required_if:servicios.habitacion,true",
                      "habitaciones.*.total_huespedes" => "required_if:servicios.habitacion,true",
                      
                      "apartamentos"=>"array|max:1",
                      "apartamentos.*.tarifa" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.capacidad_ocupada" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.viajeros" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.viajeros_colombianos" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.viajeros_extranjeros" => "required_if:servicios.apartamento,true",
                      "apartamentos.*.total_huespedes" => "required_if:servicios.apartamento,true",
                      
                      "casas"=>"array|max:1",
                      "casas.*.tarifa" => "required_if:servicios.casa,true",
                      "casas.*.viajeros" => "required_if:servicios.casa,true",
                      "casas.*.viajeros_colombia" => "required_if:servicios.casa,true",
                      "casas.*.capacidad_ocupadas" => "required_if:servicios.casa,true",
                      "casas.*.viajeros_extranjeros" => "required_if:servicios.casa,true",
                      "casas.*.total_huespedes" => "required_if:servicios.casa,true",
                      
                      "campings"=>"array|max:1",
                      "campings.*.tarifa" => "required_if:servicios.camping,true",
                      "campings.*.viajeros" => "required_if:servicios.camping,true",
                      "campings.*.capacidad_ocupada" => "required_if:servicios.camping,true",
                      "campings.*.viajeros_extranjeros" => "required_if:servicios.camping,true",
                      "campings.*.total_huespedes" => "required_if:servicios.camping,true",
                      
                      "cabanas"=>"array|max:1",
                      "cabanas.*.tarifa" => "required_if:servicios.cabana,true",
                      "cabanas.*.viajeros" => "required_if:servicios.cabana,true",
                      "cabanas.*.capacidad_ocupada" => "required_if:servicios.cabana,true",
                      "cabanas.*.viajeros_colombia" => "required_if:servicios.cabana,true",
                      "cabanas.*.viajeros_extranjeros" => "required_if:servicios.cabana,true",
                      "cabanas.*.total_huespedes" => "required_if:servicios.cabana,true",
                      
                    ]);
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
       
    
        $alojamiento = alojamiento::where("encuestas_id",$request->id)->first();
    
        /////////////////////////////////////////////////////////////////////////
        if($request->habitaciones){
            $habitacion = Habitacion::where("alojamientos_id", $alojamiento->id)->first();
            $habitacion->tarifa = $request->habitaciones[0]["tarifa"];
            $habitacion->numero_personas = $request->habitaciones[0]["numero_personas"];
            $habitacion->viajeros_locales = $request->habitaciones[0]["viajeros_locales"];
            $habitacion->viajeros_extranjeros = $request->habitaciones[0]["viajeros_extranjeros"];
            $habitacion->habitaciones_ocupadas = $request->habitaciones[0]["habitaciones_ocupadas"];
            $habitacion->total_huespedes = $request->habitaciones[0]["total_huespedes"];
            $habitacion->save();
        }
        
        /////////////////////////////////////////////////////////////////////////
        if($request->apartamentos){
            $apartamento = Apartamento::where("alojamientos_id", $alojamiento->id)->first();
            $apartamento->tarifa = $request->apartamentos[0]["tarifa"];
            $apartamento->capacidad_ocupada = $request->apartamentos[0]["capacidad_ocupada"];
            $apartamento->viajeros = $request->apartamentos[0]["viajeros"];
            $apartamento->viajeros_colombianos = $request->apartamentos[0]["viajeros_colombianos"];
            $apartamento->viajeros_extranjeros = $request->apartamentos[0]["viajeros_extranjeros"];
            $apartamento->total_huespedes = $request->apartamentos[0]["total_huespedes"];
            $apartamento->save();
        }
        
        /////////////////////////////////////////////////////////////////////////
        if($request->casas){
            $casa = Casa::where("alojamientos_id", $alojamiento->id)->first();
            $casa->tarifa = $request->casas[0]["tarifa"];
            $casa->viajeros = $request->casas[0]["viajeros"];
            $casa->viajeros_colombia = $request->casas[0]["viajeros_colombia"];
            $casa->capacidad_ocupadas = $request->casas[0]["capacidad_ocupadas"];
            $casa->viajeros_extranjeros = $request->casas[0]["viajeros_extranjeros"];
            $casa->total_huespedes = $request->casas[0]["capacidad_ocupadas"];
            $casa->save();
        }
        /////////////////////////////////////////////////////////////////////////
        if($request->campings){
            $camping = Camping::where("alojamientos_id", $alojamiento->id)->first();
            $camping->tarifa = $request->campings[0]["tarifa"];
            $camping->viajeros = $request->campings[0]["viajeros"];
            $camping->capacidad_ocupada = $request->campings[0]["capacidad_ocupada"];
            $camping->viajeros_extranjeros = $request->campings[0]["viajeros_extranjeros"];
            $camping->total_huespedes = $request->campings[0]["total_huespedes"];
            $camping->save();
        }
        
        /////////////////////////////////////////////////////////////////////////
        if($request->cabanas){
            $cabana = Cabana::where("alojamientos_id", $alojamiento->id)->first();
            $cabana->tarifa = $request->cabanas[0]["tarifa"];
            $cabana->viajeros = $request->cabanas[0]["viajeros"];
            $cabana->capacidad_ocupada = $request->cabanas[0]["capacidad_ocupada"];
            $cabana->viajeros_colombia = $request->cabanas[0]["viajeros_colombia"];
            $cabana->viajeros_extranjeros = $request->cabanas[0]["viajeros_extranjeros"];
            $cabana->total_huespedes = $request->cabanas[0]["total_huespedes"];
            $cabana->save();
        }
        
        
        Historial_Encuesta_Oferta::create([
           'encuesta_id' => $request->id,
           'user_id' => 1,
           'estado_encuesta_id' => 2,
           'fecha_cambio' => Carbon::now()
        ]);
        
        return [ "success"=>true ];
    }
    

    public function postGuardarofertaalimentos(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:encuestas,id',
            'tipo' => 'required|numeric',
            
            'platosMaximo' => 'numeric|min:1',
            'platoServido' => 'numeric|min:1',
            'precioPlato' => 'numeric|min:1',
            
            'platosPromedio' => 'numeric|min:1',
            'unidadServida' => 'numeric|min:1',
            'precioUnidad' => 'numeric|min:1',
            
            'bebidasMaximo' => 'required|numeric|min:1',
            'bebidasServidas' => 'required|numeric|min:1',
            'bebidaValor' => 'numeric|min:1',
            
        ],[
            'id.required' => 'Verifique la información y vuelva a intentarlo.',
            'id.exists' => 'Verifique la información y vuelva a intentarlo.',
            'tipo.required' => 'El número de mesas es requerido.',
            'tipo.numeric' => 'El número de mesas solo puede ser numérico.',

            'platosMaximo.numeric' => 'El número de platos máximo solo puede ser numérico.',
            'platosMaximo.min' => 'El número de platos máximo debe ser mayor a cero.',
            
            'platoServido.numeric' => 'El número de platos servidos solo puede ser numérico.',
            'platoServido.min' => 'El número de platos servidos debe ser mayor a cero.',
            
            'precioPlato.numeric' => 'El precio del plato solo puede ser numérico.',
            'precioPlato.min' => 'El precio del plato debe ser mayor a cero.',
            
            'platosPromedio.numeric' => 'El número de unidades promedio solo puede ser numérico.',
            'platosPromedio.min' => 'El número de unidades promedio debe ser mayor que cero.',
            
            'unidadServida.numeric' => 'El número de unidades servidas solo puede ser numérico.',
            'unidadServida.min' => 'El número de unidades servidas debe ser mayor que cero.',
            
            'precioUnidad.numeric' => 'El precio de la unidad  más servida solo puede ser numérico.',
            'precioUnidad.min' => 'El precio de la unidad  más servida debe ser mayor que cero.',
            
            'bebidasMaximo.required' => 'El número de bebidas máximo es requerido.',
            'bebidasMaximo.numeric' => 'El número de bebidas máximo solo puede ser numérico.',
            'bebidasMaximo.min' => 'El número de bebidas máximo debe ser mayor que cero.',
            
            'bebidasServidas.required' => 'El número de bebidas servidas es requerido.',
            'bebidasServidas.numeric' => 'El número de bebidas servidas solo puede ser numérico.',
            'bebidasServidas.min' => 'El número de bebidas servidas debe ser mayor que cero.',
            
            'bebidaValor.required' => 'El valor de la bebida es requerido.',
            'bebidaValor.numeric' => 'El valor de la bebida solo puede ser numérico.',
            'bebidaValor.min' => 'El valor de la bebida debe ser mayor que cero.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //return $request->all();
        $errores = [];
        if($request->tipo == 1){
            if($request->platosMaximo == 0 || $request->platoServido == 0  || $request->precioPlato == 0){
                $errores["InformacionCompleta"][0] = "Complete la información.";
            }
        }else{
            if($request->unidadServida == 0 || $request->precioUnidad == 0 || $request->platosPromedio == 0){
                $errores["InformacionCompleta"][0] = "Complete la información.";
            }
        }
        
        $encuesta = Encuesta::where('id',$request->id)->first();
        $provision = Provision_Alimento::with('capacidadAlimento')->where('encuestas_id',$request->id)->first();
        
        if($provision->actividades_servicio_id == 1){
            if(($request->platosMaximo * $encuesta->numero_dias) < $request->platoServido){
                $errores["PromedioPlatos"][0] = "El promedio de platos servido multiplicado por los días de actividad comercial no puede ser mayor que el número de platos servidos efectivamente. El número de días de actividad comercial es ".$encuesta->numero_dias.".";
            }
        }else{
            if(($request->platosPromedio * $encuesta->numero_dias) < $request->unidadServida){
                $errores["PromedioPlatos"][0] = "El promedio de platos servido multiplicado por los días de actividad comercial no puede ser mayor que el número de platos servidos efectivamente. El número de días de actividad comercial es ".$encuesta->numero_dias.".";
            }
        }
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        //return $request->all();
        
        $capacidad = Capacidad_Alimento::where('id_alimento',$provision->id)->first();
        if($provision == null){
            return ["success"=>false];
        }else{
            if($provision["capacidadAlimento"] == null || sizeof($provision["capacidadAlimento"]) == 0 || $capacidad == null){
                $capacidad_alimento = new Capacidad_Alimento();
                $capacidad_alimento->id_alimento = $provision->id;
                $capacidad_alimento->max_platos = $request->platosMaximo;
                $capacidad_alimento->platos_servidos = $request->platoServido;
                $capacidad_alimento->valor_plato = $request->precioPlato;
                $capacidad_alimento->promedio_unidades = $request->platosPromedio;
                $capacidad_alimento->unidades_vendidas = $request->unidadServida;
                $capacidad_alimento->valor_unidad = $request->precioUnidad;
                $capacidad_alimento->bebidas_promedio = $request->bebidasMaximo;
                $capacidad_alimento->bebidas_servidas = $request->bebidasServidas;
                $capacidad_alimento->valor_bebida = $request->bebidaValor;
                $capacidad_alimento->save();
            }else{
                $capacidad->max_platos = $request->platosMaximo;
                $capacidad->platos_servidos = $request->platoServido;
                $capacidad->valor_plato = $request->precioPlato;
                $capacidad->promedio_unidades = $request->platosPromedio;
                $capacidad->unidades_vendidas = $request->unidadServida;
                $capacidad->valor_unidad = $request->precioUnidad;
                $capacidad->bebidas_promedio = $request->bebidasMaximo;
                $capacidad->bebidas_servidas = $request->bebidasServidas;
                $capacidad->valor_bebida = $request->bebidaValor;
                $capacidad->save();
            }
            $historial = new Historial_Encuesta_Oferta();
            $historial->encuesta_id = $request->id;
            $historial->estado_encuesta_id = 2;
            $historial->fecha_cambio = Carbon::now();
            $historial->user_id = 1;
            $historial->save();
            
            return ["success"=>true];
        }

    }
    
    public function getInfoProveedor($id, $bandera)
        {
            $mes = "";
            $proveedor = "";

            if ($bandera == 0)
            {
                $encuesta = Encuesta::find($id);
                if ($encuesta != null)
                {
                    $proveedor = Sitio_Con_Idioma::select('nombre')->where('sitios_id',$encuesta->sitios_para_encuestas_id)->where('idiomas_id',1)->first();
                    
                    //$mes = encuesta.meses_de_año.mes.nombre;
                }
            }
            else {
                /*sitios_para_encuestas sitioEncuesta = conexion.sitios_para_encuestas.Find(id);
                proveedor = sitioEncuesta.sitio.sitios_con_idiomas.Where(x => x.idiomas_id == 1).FirstOrDefault().nombre;*/
                $proveedor = Sitio_Con_Idioma::select('nombre')->where('sitios_id',$encuesta->sitios_para_encuestas_id)->where('idiomas_id',1)->first();
            }
            
            

            return ["mes"=>$mes, "proveedor"=>$proveedor];

        }
}
