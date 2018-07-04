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

class OfertaEmpleoController extends Controller
{
    //
    
    
    public function getCrearEncuesta(){
        return view('ofertaempleo.CrearEncuesta');
    }
    
    public function getEncuestaspendientes($id){
        
        $now = Carbon::now();
        
        return $now;

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
