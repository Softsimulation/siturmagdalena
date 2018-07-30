<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Empleo;
use App\Models\Encuesta;
use App\Models\Vacante;
use App\Models\Empleado_Vinculacion;
use App\Models\Edad_Empleado;
use App\Models\Sexo_Empleado;
use App\Models\Tipo_Cargo;
use App\Models\Asignacion_Salarial;
use App\Models\Capacitacion_Empleado;
use App\Models\Dominiosingles;
use App\Models\Educacion_Empleado;
use App\Models\Historial_Encuesta_Oferta;
use App\Models\Remuneracion_Promedio;
use App\Models\Razon_Vacante;
use App\Models\Capacitacion_Empleo;
use App\Models\Tematica_Capacitacion;
use App\Models\Linea_Tematica;
use App\Models\Tipo_Programa_Capacitacion;
use App\Models\Medio_Capacitacion;
use App\Models\Servicio_Agencia;
use App\Models\Viaje_Turismo;
use App\Models\Viaje_Turismo_Otro;
use App\Models\Opcion_Persona_Destino;
use App\Models\Persona_Destino_Con_Viaje_Turismo;
use App\Models\Plan_Santamarta;
use App\Models\Actividad_Servicio;
use App\Models\Provision_Alimento;
use App\Models\Especialidad;
use App\Models\Capacidad_Alimento;
use App\Models\Actividad_Deportiva;
use App\Models\Tour;
use DB;
use App\Models\Agencia_Operadora;
use App\Models\Otra_Actividad;
use App\Models\Otro_Tour;

use App\Models\Prestamo_Servicio;
use App\Models\Alquiler_Vehiculo;
use App\Models\Transporte;
use App\Models\Oferta_Transporte;
use App\Models\alojamiento;
use App\Models\Casa;
use App\Models\Camping;
use App\Models\Habitacion;
use App\Models\Apartamento;
use App\Models\Cabana;
use App\Models\Mes;
use App\Models\Anio;
use App\Models\Mes_Anio;
use App\Models\Sitio_Para_Encuesta;
use App\Models\Medio_Actualizacion;


class OfertaEmpleoController extends Controller
{
    //
    
        public function __construct()
    {
        
        $this->middleware('oferta', ['only' => ['getEncuesta','getActividadcomercial','getAgenciaviajes','getOfertaagenciaviajes','getCaracterizacionalimentos',
                                    'getCapacidadalimentos','getOfertatransporte','getCaracterizaciontransporte','getCaracterizacion','getOferta',
                                    'getCaracterizacionagenciasoperadoras','getOcupacionagenciasoperadoras','getCaracterizacionalquilervehiculo','getCaracterizacion','getCaracterizacion','getEmpleomensual','getNumeroempleados']]);
    }
    
    
    public function getCrearencuesta(){
        return view('ofertaEmpleo.Crearencuesta');
    }
    
    public function getListadoproveedores(){
        return view('ofertaEmpleo.ListadoProveedores');
    }
    
    public function getListado(){
      
      $provedores = Sitio_Para_Encuesta::with(["proveedor"=> function($q1){ $q1->with([ "estadop", "categoria", "idiomas"=>function($q){ $q->where("idioma_id",1); } ])->get(); }])->get();
      
      return ["success" => true, "proveedores"=> $provedores];
    }
    
    public function getEncuestas($one){
        
        return view('ofertaEmpleo.ListadoEncuestas',['id'=>$one]);
    }
    
    public function getEncuestasrealizadas($id){
 
          $data =  new Collection(DB::select("SELECT *from listado_encuesta_oferta where sitio_para_encuesta =".$id));
        
          $ruta = null;
          $tipo = Sitio_Para_Encuesta::where("id",$id)->first();
         
          if($tipo->proveedor->categoria->tipoProveedore->id == 1){
              $ruta = "/ofertaempleo/caracterizacion";
              }else{
                  
                    if($tipo->proveedor->categoria->id == 15){
                         $ruta = "/ofertaempleo/agenciaviajes";
                    }
                     if($tipo->proveedor->categoria->id == 14){
                         $ruta = "/ofertaempleo/caracterizacionagenciasoperadoras";
                    }
                     if($tipo->proveedor->categoria->id == 21){
                         $ruta = "/ofertaempleo/caracterizacionalquilervehiculo";
                    }
                     if($tipo->proveedor->categoria->id == 22){
                         $ruta = "/ofertaempleo/caracterizaciontransporte";
                    }
                     if($tipo->proveedor->categoria->id == 12){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
                   if($tipo->proveedor->categoria->id == 11){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
              }
         
          
 
        
        
        return ["success"=>true, "encuestas"=>$data, 'ruta'=>$ruta];

    }
    
    public function getEncuesta($one){
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
                    
                    $encuesta = Encuesta::where('sitios_para_encuestas_id',$one)->where('meses_anio_id',$meses_anio->id)->first();

                    
                    if($encuesta ==null ){
                        array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                    }
                }
                
            }
            
            
        }
        
        return view('ofertaEmpleo.Encuesta',array("meses"=>collect($pendientes),"id"=>$one));
    }
    
    public function getActividadcomercial($mes,$anio,$id){
        
             return view('ofertaEmpleo.ActividadComercial',array("Id"=>$mes,"Anio"=>$anio,'Sitio'=>$id));
    }
    
    public function postGuardaractividadcomercial(Request $request)
    {
        $validator = \Validator::make($request->all(),[
        
            'Sitio' => 'required|exists:sitios_para_encuestas,id',
            'Anio' => 'numeric',
            'Mes' => 'required|exists:meses,id',
            'NumeroDias' => 'numeric|min:1|max:31',
            'Comercial' => 'required|numeric|min:0|max:1',
            
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
        
        if ($request->Mes == 4 || $request->Mes == 6 || $request->Mes == 9 ||$request-> Mes == 11)
        {
            if ($request->NumeroDias > 30)
            {
                 return ["success" => false, "errores" => [["El número de días no puede exceder a 30 días."]] ];
               
            }
        }

        if ($request->Mes == 1 ||$request->Mes == 3 || $request->Mes == 5 || $request->Mes == 7 || $request->Mes == 8 || $request->Mes == 10 || $request->Mes == 12)
        {
            if ($request->NumeroDias > 31)
            {
                 return ["success" => false, "errores" => [["El número de días no puede exceder a 31 días."]] ];

            }
        }
        if ($request->Mes == 2)
        {
            if ($request->NumeroDias > 29)
            {
                 return ["success" => false, "errores" => [["El número de días no puede exceder a 29 días."]] ];

            }
        }
        
        $encuesta = Encuesta::join("meses_de_anio","encuestas.meses_anio_id","=","meses_de_anio.id")
        ->join("anios","meses_de_anio.anio_id","=","anios.id")
        ->where("encuestas.sitios_para_encuestas_id", $request->Sitio)
        ->where("meses_de_anio.mes_id", $request->Mes)
        ->where("anios.anio", $request->Anio)
        ->first();
     
        if($encuesta != null){
            return ["success" => false, "errores" => [["Ya existe una encuesta creada."]] ];
        }
  
  
        
       $mesid = Mes_Anio::join("anios","meses_de_anio.anio_id","=","anios.id")
        ->where("meses_de_anio.mes_id", $request->Mes)
        ->where("anios.anio", $request->Anio)
        ->select("meses_de_anio.id")->first();
        
     
        if($mesid == null){
            $mesid = new Mes_Anio();
            $anio = Anio::where("anio",$request->Anio)->first();
            if($anio == null){
                $anio = new Anio();
                $anio = $request->Anio;
                $anio->save();
            }
            $mesid->mes_id = $request->Mes;
            $mesid->anio_id = $anio->id;
            $mesid->save();
            
        }
        
        
       $ruta = null;
      $encuesta = new Encuesta();
      if ($request->Comercial == 0)
        {
            $encuesta->actividad_comercial = 0;
            $encuesta->numero_dias = 0;
            $ruta = "ofertaempleo/encuesta/".$request->Sitio;
            $encuesta->meses_anio_id = $mesid->id;
            $encuesta->sitios_para_encuestas_id = $request->Sitio;
            $encuesta->save();
    	   Historial_Encuesta_Oferta::create([
               'encuesta_id' => $encuesta->id,
               'user_id' => 1,
               'estado_encuesta_id' => 3,
               'fecha_cambio' => Carbon::now()
           ]);
        }
        else
        {
            $encuesta->actividad_comercial = 1;
            $encuesta->numero_dias = $request->NumeroDias;
            $encuesta->meses_anio_id = $mesid->id;
            $encuesta->sitios_para_encuestas_id = $request->Sitio;
            $encuesta->save();
           Historial_Encuesta_Oferta::create([
               'encuesta_id' => $encuesta->id,
               'user_id' => 1,
               'estado_encuesta_id' => 1,
               'fecha_cambio' => Carbon::now()
           ]);
        }


        
       
        
     
       $tipo = Sitio_Para_Encuesta::where("id",$encuesta->sitios_para_encuestas_id)->first();
         
          if($tipo->proveedor->categoria->tipoProveedore->id == 1){
              $ruta = "/ofertaempleo/caracterizacion";
              }else{
                  
                    if($tipo->proveedor->categoria->id == 15){
                         $ruta = "/ofertaempleo/agenciaviajes";
                    }
                     if($tipo->proveedor->categoria->id == 14){
                         $ruta = "/ofertaempleo/caracterizacionagenciasoperadoras";
                    }
                     if($tipo->proveedor->categoria->id == 21){
                         $ruta = "/ofertaempleo/caracterizacionalquilervehiculo";
                    }
                     if($tipo->proveedor->categoria->id == 22){
                         $ruta = "/ofertaempleo/caracterizaciontransporte";
                    }
                     if($tipo->proveedor->categoria->id == 12){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
                   if($tipo->proveedor->categoria->id == 11){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
              }
         
           if($ruta != null){
              $ruta = $ruta.'/'.$encuesta->id;
          }else{
              $ruta = 'proveedor';
          }
        
        
       
       
       return ["success"=>true,"ruta"=>$ruta];
            
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
                    
                    $encuesta = Encuesta::where('sitios_para_encuestas_id',$id)->first();
                    if($encuesta==null){
                        array_push($pendientes,["mesId"=>$me->month,"mes"=>$nombreMes->nombre,"anio"=>$me->year]);
                    }
                }
                
            }
            
            
        }
        
        return [];

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
    public function getCaracterizaciontransporte($id){
        return view('ofertaEmpleo.CaracterizacionTransporte',array('id' => $id));
    }
    public function getOfertatransporte($id){
        return view('ofertaEmpleo.OfertaTransporte',array('id' => $id));
    }
   
    public function getDatosagencia(){
        $servicios = Servicio_Agencia::all();
        //$servicios = (from servicio in conexion.servicios_agencias select new { id = servicio.id, nombre = servicio.nombre }).ToList();
        //return json.Serialize(servicios);
        return $servicios;
    }
    
    public function getData($one){
       
        return Encuesta::get();
    }
    
    public function getEmpleadoscaracterizacion($one){
        $id = $one;
        return view('ofertaEmpleo.EmpleadosCaracterizacion',array('id'=>$id));
    }
    
    public function getEmpleomensual($one){
        $id = $one;
        $encuesta = Encuesta::find($one);
        $tipo = Sitio_Para_Encuesta::where("id",$encuesta->sitios_para_encuestas_id)->first();
         
          if($tipo->proveedor->categoria->tipoProveedore->id == 1){
              $ruta = "/ofertaempleo/caracterizacion";
              }else{
                  
                    if($tipo->proveedor->categoria->id == 15){
                         $ruta = "/ofertaempleo/agenciaviajes";
                    }
                     if($tipo->proveedor->categoria->id == 14){
                         $ruta = "/ofertaempleo/caracterizacionagenciasoperadoras";
                    }
                     if($tipo->proveedor->categoria->id == 21){
                         $ruta = "/ofertaempleo/caracterizacionalquilervehiculo";
                    }
                     if($tipo->proveedor->categoria->id == 22){
                         $ruta = "/ofertaempleo/caracterizaciontransporte";
                    }
                     if($tipo->proveedor->categoria->id == 12){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
                   if($tipo->proveedor->categoria->id == 11){
                         $ruta = "/ofertaempleo/caracterizacionalimentos";
                    }
              }
        
        return view('ofertaEmpleo.EmpleoMensual',array('id'=>$id,'ruta'=>$ruta));
    }
    
    public function getNumeroempleados($one){
        $id = $one;
        return view('ofertaEmpleo.NumeroEmpleados',compact('id'));
    }
    
    public function getCargardatosdmplmensual($id = null)  
    {
        $empleo = collect();
  
        $empleo = collect();
        $empleo["Empleo"] = Empleo::where("encuestas_id",$id)->get(); 
        $vac = Vacante::where("encuestas_id",$id)->first(); 
        if($vac != null){
            $empleo["VacanteOperativo"] = $vac->operativo;
            $empleo["VacanteAdministrativo"] = $vac->administrativo;
            $empleo["VacanteGerencial"]  = $vac->gerencial;
        }
        $empleo["Razon"] = Razon_Vacante::where("encuesta_id",$id)->first();
        $empleo["ingles"] = Dominiosingles::where("encuestas_id",$id)->get();
        $empleo["Vinculacion"] = Empleado_Vinculacion::where("encuestas_id",$id)->get();
        $empleo["Edad"] = Edad_Empleado::where("encuestas_id",$id)->get();
        $empleo["Educacion"] = Educacion_Empleado::where("encuestas_id",$id)->get();
        $empleo["Sexo"]  =  Sexo_Empleado::where("encuestas_id",$id)->get();
        $empleo["Remuneracion"]  =  Remuneracion_Promedio::where("encuesta_id",$id)->get();
        
        $tipo_cargo = Tipo_Cargo::select("id as Id","nombre as Nombre")->get();
            
          $retorno = [
                'empleo' => $empleo,
                'tipo_cargo' => $tipo_cargo,
                  'url' => ""
            ];
        

            return $retorno;


        
         $retorno = [
                'empleo' => $empleo,
                'url' => ""
            ];
            
            return $retorno;
    }
    
    public function getCargardatosemplcaract($id = null)
    {
            $empleo = collect();
    
        
            $empleo["capacitacion"] = Capacitacion_Empleo::where("encuesta_id",$id)->pluck("realiza_proceso")->first();
            $empleo["tematicas"] = Tematica_Capacitacion::where("encuesta_id",$id)->get();
            $empleo["lineasadmin"] = Capacitacion_Empleo::join("tematicas_aplicadas_encuestas",'capacitaciones_empleo.encuesta_id','=','tematicas_aplicadas_encuestas.encuesta_id')->join("lineas_tematicas","id","=","linea_tematica_id")->where("capacitaciones_empleo.encuesta_id",$id)->where("tipo_nivel",true)->pluck("linea_tematica_id as id")->toArray();
            $empleo["lineasopvt"] = Capacitacion_Empleo::join("tematicas_aplicadas_encuestas",'capacitaciones_empleo.encuesta_id','=','tematicas_aplicadas_encuestas.encuesta_id')->join("lineas_tematicas","id","=","linea_tematica_id")->where("capacitaciones_empleo.encuesta_id",$id)->where("tipo_nivel",false)->pluck("linea_tematica_id as id")->toArray();
            $empleo["tipos"] = Capacitacion_Empleo::join("programas_capaciaciones",'capacitaciones_empleo.encuesta_id','=','programas_capaciaciones.encuesta_id')->where("capacitaciones_empleo.encuesta_id",$id)->pluck("tipo_programa_capacitacion_id")->toArray();
            $empleo["medios"] = Capacitacion_Empleo::join("medios_capacitaciones_encuestas",'capacitaciones_empleo.encuesta_id','=','medios_capacitaciones_encuestas.encuesta_id')->where("capacitaciones_empleo.encuesta_id",$id)->pluck("medio_capacitacion_id")->toArray();
            $empleo["autorizacion"] = Encuesta::where("id",$id)->pluck("autorizacion")->first();
            $empleo["esta_acuerdo"] = Encuesta::where("id",$id)->pluck("esta_acuerdo")->first();
            $empleo["medios_actualizacion_id"] = Encuesta::where("id",$id)->pluck("medios_actualizacion_id")->first();
            
            
            $data = collect();
            $data["lineas"] = Linea_Tematica::select("id","nombre","tipo_nivel")->get();
            $data["tipos"] = Tipo_Programa_Capacitacion::select("id","nombre")->get();
            $data["medios"] = Medio_Capacitacion::select("id","nombre")->get();
            $data["actualizaciones"] = Medio_Actualizacion::select("id","nombre")->get(); 
          
            $empleo["otrotipo"] = Capacitacion_Empleo::join("programas_capaciaciones",'capacitaciones_empleo.encuesta_id','=','programas_capaciaciones.encuesta_id')->where("capacitaciones_empleo.encuesta_id",$id)->where("tipo_programa_capacitacion_id",10)->pluck("otro")->first();
            $empleo["otromedio"] = Capacitacion_Empleo::join("medios_capacitaciones_encuestas",'capacitaciones_empleo.encuesta_id','=','medios_capacitaciones_encuestas.encuesta_id')->where("capacitaciones_empleo.encuesta_id",$id)->where("medio_capacitacion_id",6)->pluck("otro")->first();
            
           
       
          $retorno = [
                'empleo' => $empleo,
                'data'=> $data
                
            ];
            
            return $retorno;
    
        }
    
    public function postGuardarempleomensual (Request $request){
       
        $validator = \Validator::make($request->all(), [
			'Encuesta' => 'required|exists:encuestas,id',
			'Edad' => 'required',
			'VacanteOperativo' => 'required|min:0',
			'VacanteAdministrativo' => 'required|min:0',
			'VacanteGerencial' => 'required|min:0',
			'Razon' => 'required',
			'Razon.apertura' => 'required|min:0',
			'Razon.crecimiento' => 'required|min:0',
			'Razon.remplazo' => 'required|min:0',
			'Edad.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Edad.*.docea18' => 'required|min:0',
			'Edad.*.diecinuevea25' => 'required|min:0',
			'Edad.*.ventiseisa40' => 'required|min:0',
			'Edad.*.cuarentayunoa64' => 'required|min:0',
			'Edad.*.mas65' => 'required|min:0',
			'Empleo' => 'required',
			'Empleo.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Empleo.*.tiempo_completo' => 'required|min:0',
			'Empleo.*.medio_tiempo' => 'required|min:0',
			'ingles' => 'required',
			'ingles.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'ingles.*.sabeningles' => 'required|min:0',
			'Vinculacion' => 'required',
			'Vinculacion.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Vinculacion.*.contrato_direto' => 'required|min:0',
			'Vinculacion.*.personal_permanente' => 'required|min:0',
			'Vinculacion.*.personal_agencia' => 'required|min:0',
			'Vinculacion.*.trabajador_familiar' => 'required|min:0',
			'Vinculacion.*.propietario' => 'required|min:0',
			'Vinculacion.*.aprendiz' => 'required|min:0',
			'Vinculacion.*.cuenta_propia' => 'required|min:0',
			'Educacion' => 'required',
			'Educacion.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Educacion.*.ninguno' => 'required|min:0',
			'Educacion.*.posgrado' => 'required|min:0',
			'Educacion.*.bachiller' => 'required|min:0',
			'Educacion.*.universitario' => 'required|min:0',
			'Educacion.*.tecnico' => 'required|min:0',
			'Educacion.*.tecnologo' => 'required|min:0',
			'Sexo' => 'required',
			'Sexo.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Sexo.*.hombres' => 'required|min:0',
			'Sexo.*.mujeres' => 'required|min:0',
			'Remuneracion' => 'required',
			'Remuneracion.*.tipo_cargo_id' => 'required|exists:tipos_cargos,id',
			'Remuneracion.*.valor' => 'required|min:0',
		    
    	],[
       		'Encuesta.required' => 'Error no se encontro la encuesta.',
       		'Encuesta.exists' => 'La encuesta eleccionado no se encuentra seleccionado en el sistema.',
 
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		
	if(($request->VacanteGerencial+$request->VacanteAdministrativo+$request->VacanteOperativo) != ($request->Razon["apertura"]+$request->Razon["crecimiento"]+$request->Razon["remplazo"])){
	    
	    return ["success" => false, "errores" => [["El valor de los vacantes no coinciden con la razón de los vacantes"]] ]; 
	}
        
     for ($i =0; $i < collect($request->Sexo)->Count(); $i++)
    {
        $cargo = Tipo_Cargo::where("id",$request->Sexo[$i]["tipo_cargo_id"])->first();
        $edad = collect($request->Edad)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",1)->first();
       
        if($edad){
            
            if(($edad["diecinuevea25"] + $edad["ventiseisa40"] + $edad["cuarentayunoa64"] + $edad["mas65"] + $edad["docea18"] ) !=  $request->Sexo[$i]["hombres"] ){
            
                 return ["success" => false, "errores" => [["error en el numero de hombres por edad en el cargo ".$cargo->nombre]] ];    
            }
        }
            
         $edad = collect($request->Edad)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",0)->first();
         if($edad){
            if(($edad["diecinuevea25"] + $edad["ventiseisa40"] + $edad["cuarentayunoa64"] + $edad["mas65"] + $edad["docea18"] )  !=  $request->Sexo[$i]["mujeres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de mujeres por edad en el cargo ".$cargo->nombre]] ];    
            }
         }
            
        $educacion = collect($request->Educacion)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",1)->first();
        if($educacion){
            if(($educacion["ninguno"] + $educacion["bachiller"] + $educacion["posgrado"] + $educacion["tecnico"] + $educacion["tecnologo"] + $educacion["universitario"] ) !=  $request->Sexo[$i]["hombres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de hombres por eduacion en el cargo ".$cargo->nombre]] ];    
            }
        }
        
        $educacion = collect($request->Educacion)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",0)->first();
        if($educacion){
            if(($educacion["ninguno"] + $educacion["bachiller"] + $educacion["posgrado"] + $educacion["tecnico"] + $educacion["tecnologo"] + $educacion["universitario"] ) !=  $request->Sexo[$i]["mujeres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de mujeres por eduacion en el cargo ".$cargo->nombre]] ];    
            }
        }
        
        $ingl = collect($request->ingles)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",1)->first();
        if($ingl){
            if($ingl["sabeningles"]   > $request->Sexo[$i]["hombres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de hombres que saben ingles es mayor en el cargo ".$cargo->nombre]] ];    
            }   
        }
        
        
           $ingl = collect($request->ingles)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",0)->first();
        if($ingl){
            if($ingl["sabeningles"]  > $request->Sexo[$i]["mujeres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de hombres por edad en el cargo ".$cargo->nombre]] ];    
            }   
            
        }

        $vinculacion = collect($request->Vinculacion)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",1)->first();
        if($vinculacion){
            if(($vinculacion["personal_permanente"] + $vinculacion["personal_agencia"] + $vinculacion["propietario"] + $vinculacion["contrato_direto"] + $vinculacion["trabajador_familiar"] + $vinculacion["cuenta_propia"] + $vinculacion["aprendiz"] ) !=  $request->Sexo[$i]["hombres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de hombres por vinculación en el cargo ".$cargo->nombre]] ];    
            }
            
        }
        
        $vinculacion = collect($request->Vinculacion)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",0)->first();
        if($vinculacion){
            if(($vinculacion["personal_permanente"] + $vinculacion["personal_agencia"] + $vinculacion["propietario"] + $vinculacion["contrato_direto"] + $vinculacion["trabajador_familiar"] + $vinculacion["cuenta_propia"] + $vinculacion["aprendiz"] ) !=  $request->Sexo[$i]["mujeres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de mujeres por vinculación en el cargo ".$cargo->nombre]] ];    
            }  
        }

       $empleo = collect($request->Empleo)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",1)->first();
        if($vinculacion){
            if(($empleo["tiempo_completo"]  + $empleo["medio_tiempo"] ) !=  $request->Sexo[$i]["hombres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de hombres por jornada laboral el cargo ".$cargo->nombre]] ];    
            }
        }

        $empleo = collect($request->Empleo)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->where("sexo",0)->first();
        if($vinculacion){
            if(($empleo["tiempo_completo"]  + $empleo["medio_tiempo"]) !=  $request->Sexo[$i]["mujeres"] ){
                 
                 return ["success" => false, "errores" => [["error en el numero de mujeres por jornada laboral en el cargo ".$cargo->nombre]] ];    
            }

        
        }
        
    }

    for ($i =0; $i < collect($request->Sexo)->Count(); $i++)
    {
        
        $sexoBuscado = Sexo_Empleado::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->Sexo[$i]["tipo_cargo_id"])->first();
        if ($sexoBuscado == null)
        {
        
            $sexoBuscado = new Sexo_Empleado();
            $sexoBuscado->encuestas_id = $request->Encuesta;
            $sexoBuscado->mujeres = $request->Sexo[$i]["mujeres"];
            $sexoBuscado->hombres = $request->Sexo[$i]["hombres"];
            $sexoBuscado->tipo_cargo_id = $request->Sexo[$i]["tipo_cargo_id"];
            $sexoBuscado->save();
        }
        else
        {
            $sexoBuscado->mujeres = $request->Sexo[$i]["mujeres"];
            $sexoBuscado->hombres = $request->Sexo[$i]["hombres"];
            $sexoBuscado->save();
        }
    }

    
    for ($i =0; $i < collect($request->Edad)->Count(); $i++)
    {
        
    $edadempleo = Edad_Empleado::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->Edad[$i]["tipo_cargo_id"])->where("sexo",$request->Edad[$i]["sexo"])->first();;
        if ($edadempleo == null)
        {
            $edadempleo = new Edad_Empleado(); 
            $edadempleo->encuestas_id = $request->Encuesta;
            $edadempleo->diecinuevea25 = $request->Edad[$i]["diecinuevea25"]; 
            $edadempleo->ventiseisa40 = $request->Edad[$i]["ventiseisa40"]; 
            $edadempleo->cuarentayunoa64 = $request->Edad[$i]["cuarentayunoa64"];
            $edadempleo->mas65 = $request->Edad[$i]["mas65"];
            $edadempleo->docea18 = $request->Edad[$i]["docea18"]; 
            $edadempleo->sexo = $request->Edad[$i]["sexo"];  
            $edadempleo->tipo_cargo_id = $request->Edad[$i]["tipo_cargo_id"];  
            $edadempleo->save();
        }
        else
        {               
            $edadempleo->diecinuevea25 = $request->Edad[$i]["diecinuevea25"]; 
            $edadempleo->ventiseisa40 = $request->Edad[$i]["ventiseisa40"]; 
            $edadempleo->cuarentayunoa64 = $request->Edad[$i]["cuarentayunoa64"];
            $edadempleo->mas65 = $request->Edad[$i]["mas65"];
            $edadempleo->docea18 = $request->Edad[$i]["docea18"]; 
  
            $edadempleo->save();
        }
    }
    

    for ($i =0; $i < collect($request->Educacion)->Count(); $i++)
    {
        
        $educacionempleo = Educacion_Empleado::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->Educacion[$i]["tipo_cargo_id"])->where("sexo",$request->Educacion[$i]["sexo"])->first();;
        if ($educacionempleo == null)
        {
            
            $educacionempleo = new Educacion_Empleado();
            $educacionempleo->encuestas_id = $request->Encuesta;
            $educacionempleo->ninguno = $request->Educacion[$i]["ninguno"];
            $educacionempleo->bachiller = $request->Educacion[$i]["bachiller"];
            $educacionempleo->posgrado = $request->Educacion[$i]["posgrado"]; 
            $educacionempleo->tecnico = $request->Educacion[$i]["tecnico"];
            $educacionempleo->tecnologo = $request->Educacion[$i]["tecnologo"];
            $educacionempleo->universitario = $request->Educacion[$i]["universitario"];
            $educacionempleo->sexo = $request->Educacion[$i]["sexo"];  
            $educacionempleo->tipo_cargo_id = $request->Educacion[$i]["tipo_cargo_id"];  
            $educacionempleo->save();
        }
        else
        {               
            $educacionempleo->ninguno = $request->Educacion[$i]["ninguno"];
            $educacionempleo->bachiller = $request->Educacion[$i]["bachiller"];
            $educacionempleo->posgrado = $request->Educacion[$i]["posgrado"]; 
            $educacionempleo->tecnico = $request->Educacion[$i]["tecnico"];
            $educacionempleo->tecnologo = $request->Educacion[$i]["tecnologo"];
            $educacionempleo->universitario = $request->Educacion[$i]["universitario"];
            $educacionempleo->save();
        }
    }

    for ($i =0; $i < collect($request->Vinculacion)->Count(); $i++)
    {
        
        $vinculacionempleo = Empleado_Vinculacion::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->Vinculacion[$i]["tipo_cargo_id"])->where("sexo",$request->Vinculacion[$i]["sexo"])->first();;
        if ($vinculacionempleo == null)
        {
            $vinculacionempleo = new Empleado_Vinculacion(); 
            $vinculacionempleo->encuestas_id = $request->Encuesta;
            $vinculacionempleo->personal_permanente = $request->Vinculacion[$i]["personal_permanente"];  
            $vinculacionempleo->personal_agencia = $request->Vinculacion[$i]["personal_agencia"];   
            $vinculacionempleo->propietario = $request->Vinculacion[$i]["propietario"];   
            $vinculacionempleo->contrato_direto = $request->Vinculacion[$i]["contrato_direto"];  
            $vinculacionempleo->trabajador_familiar = $request->Vinculacion[$i]["trabajador_familiar"];   
            $vinculacionempleo->cuenta_propia = $request->Vinculacion[$i]["cuenta_propia"];   
            $vinculacionempleo->aprendiz = $request->Vinculacion[$i]["aprendiz"];  
            $vinculacionempleo->sexo = $request->Vinculacion[$i]["sexo"];  
            $vinculacionempleo->tipo_cargo_id = $request->Vinculacion[$i]["tipo_cargo_id"];  
            $vinculacionempleo->save();
        }
        else
        {               
            $vinculacionempleo->personal_permanente = $request->Vinculacion[$i]["personal_permanente"];  
            $vinculacionempleo->personal_agencia = $request->Vinculacion[$i]["personal_agencia"];   
            $vinculacionempleo->propietario = $request->Vinculacion[$i]["propietario"];   
            $vinculacionempleo->contrato_direto = $request->Vinculacion[$i]["contrato_direto"];  
            $vinculacionempleo->trabajador_familiar = $request->Vinculacion[$i]["trabajador_familiar"];   
            $vinculacionempleo->cuenta_propia = $request->Vinculacion[$i]["cuenta_propia"];   
            $vinculacionempleo->aprendiz = $request->Vinculacion[$i]["aprendiz"];  
            $vinculacionempleo->save();

         }
    }

    for ($i =0; $i < collect($request->ingles)->Count(); $i++)
    {
            
            $inglesempleo = Dominiosingles::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->ingles[$i]["tipo_cargo_id"])->where("sexo",$request->ingles[$i]["sexo"])->first();;
            if ($inglesempleo == null)
            {
                $inglesempleo = new Dominiosingles(); 
                $inglesempleo->encuestas_id = $request->Encuesta;
                $inglesempleo->sabeningles = $request->ingles[$i]["sabeningles"];  
                $inglesempleo->nosabeningles = 0;  
                $inglesempleo->sexo = $request->ingles[$i]["sexo"];  
                $inglesempleo->tipo_cargo_id = $request->ingles[$i]["tipo_cargo_id"];  
                $inglesempleo->save();
            }
            else
            {               
                $inglesempleo->sabeningles = $request->ingles[$i]["sabeningles"];
                $inglesempleo->nosabeningles = 0;  
                $inglesempleo->save();
 
             }
        }
        
    for ($i =0; $i < collect($request->Empleo)->Count(); $i++)
    {
        
          $empBuscado = Empleo::where("encuestas_id", $request->Encuesta)->where("tipo_cargo_id",$request->Empleo[$i]["tipo_cargo_id"])->where("sexo",$request->Empleo[$i]["sexo"])->first();;
             if ($empBuscado == null)
            {
                $empBuscado= new empleo();
                $empBuscado->encuestas_id = $request->Encuesta;  
                $empBuscado->tiempo_completo = $request->Empleo[$i]["tiempo_completo"];  
                $empBuscado->medio_tiempo = $request->Empleo[$i]["medio_tiempo"];  
                $empBuscado->sexo = $request->Empleo[$i]["sexo"];  
                $empBuscado->tipo_cargo_id = $request->Empleo[$i]["tipo_cargo_id"];  
                $empBuscado->save();
            }
            else
            {
                $empBuscado->tiempo_completo = $request->Empleo[$i]["tiempo_completo"];  
                $empBuscado->medio_tiempo = $request->Empleo[$i]["medio_tiempo"];  
                $empBuscado->save();
            }

        
    }

    for ($i =0; $i < collect($request->Remuneracion)->Count(); $i++)
    {
                
                  $remuneracion = Remuneracion_Promedio::where("encuesta_id", $request->Encuesta)->where("tipo_cargo_id",$request->Remuneracion[$i]["tipo_cargo_id"])->where("sexo",$request->Remuneracion[$i]["sexo"])->first();;
                     if ($remuneracion == null)
                    {
                        $remuneracion= new Remuneracion_Promedio();
                        $remuneracion->encuesta_id = $request->Encuesta;  
                        $remuneracion->valor = $request->Remuneracion[$i]["valor"];  
                        $remuneracion->sexo = $request->Remuneracion[$i]["sexo"];  
                        $remuneracion->tipo_cargo_id = $request->Remuneracion[$i]["tipo_cargo_id"];  
                        $remuneracion->save();
                    }
                    else
                    {
                       
                        $remuneracion->valor = $request->Remuneracion[$i]["valor"];  
                        
                        $remuneracion->save();
                    }
    
                
            }


$vacRazon = Razon_Vacante::where("encuesta_id",$request->Encuesta)->first(); 

    if ($vacRazon == null)
    {
        $vacRazon = new Razon_Vacante();
        $vacRazon->encuesta_id = $request->Encuesta;
        $vacRazon->apertura = $request->Razon["apertura"];
        $vacRazon->crecimiento =  $request->Razon["crecimiento"];
        $vacRazon->remplazo =  $request->Razon["remplazo"];
        $vacRazon->save();
    }
    else
    {
        $vacRazon->apertura = $request->Razon["apertura"];
        $vacRazon->crecimiento =  $request->Razon["crecimiento"];
        $vacRazon->remplazo =  $request->Razon["remplazo"];
        $vacRazon->save();
    }

    $vacBuscado = Vacante::where("encuestas_id",$request->Encuesta)->first(); 

    if ($vacBuscado == null)
    {
        $vacBuscado = new vacante();
        $vacBuscado->encuestas_id = $request->Encuesta;
        $vacBuscado->administrativo = $request->VacanteAdministrativo;
        $vacBuscado->gerencial = $request->VacanteGerencial;
        $vacBuscado->operativo = $request->VacanteOperativo;
        $vacBuscado->save();
    }
    else
    {
        $vacBuscado->administrativo = $request->VacanteAdministrativo;
        $vacBuscado->gerencial = $request->VacanteGerencial;
        $vacBuscado->operativo = $request->VacanteOperativo;
        $vacBuscado->save();
    }
    Historial_Encuesta_Oferta::create([
           'encuesta_id' => $request->Encuesta,
           'user_id' => 1,
           'estado_encuesta_id' => 2,
           'fecha_cambio' => Carbon::now()
       ]);
	

        return ["success" => true];
    }
    
    public function postGuardarempcaracterizacion(Request $request){
        $validator = \Validator::make($request->all(), [
  	         'Encuesta' => 'required|exists:encuestas,id',
  	         'capacitacion' => 'required|min:0|max:1',
  	         'autorizacion' => 'required|min:0|max:1',
  	         'esta_acuerdo' => 'required|min:0|max:1',
  	         'medios_actualizacion_id'=> 'required|exists:medios_actualizaciones,id',
			 'medios.*' => 'required|exists:medios_capacitaciones,id',
		     'tipos.*' => 'required|exists:tipos_programas_capacitaciones,id',
		     'lineasadmin.*' => 'required|exists:lineas_tematicas,id',
			 'lineasopvt.*' => 'required|exists:lineas_tematicas,id',
		
		
    	],[
       		'Encuesta.required' => 'Error no se encontro la encuesta.',
       		'Encuesta.exists' => 'La encuesta eleccionado no se encuentra seleccionado en el sistema.',
 
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
    		$encuesta = Encuesta::find($request->Encuesta);

    		 if($request->capacitacion == 1 ){
    		     if($request->tematicas == null || count($request->tematicas) == 0){
    	                return ["success" => false, "errores" => [["Es requerido las tematicas."]] ];    
    	    
    		     }
    	     }
	
	         
	         if(in_array(10,$request->medios )&& $request->otromedio == null){
	             return ["success" => false, "errores" => [["No se encontro el valor del otro en medios."]] ];    
	             
	         }
	    
              if(in_array(6,$request->tipos) && $request->otrotipo == null){
	             return ["success" => false, "errores" => [["No se encontro el valor del otro tipos."]] ];    
	             
	         }
	 
              $capacitacion = Capacitacion_Empleo::where("encuesta_id", $request->Encuesta)->first();

                if ($capacitacion == null)
                {
                   $capacitacion = new Capacitacion_Empleo();
                    $capacitacion->encuesta_id = $request->Encuesta;
                    $capacitacion->realiza_proceso = $request->capacitacion;
                
                    $capacitacion->save();
                }
                else
                {
                    $capacitacion->realiza_proceso = $request->capacitacion;
        
                    $capacitacion->save();
                }

            
            $encuesta->autorizacion = $request->autorizacion;
            $encuesta->esta_acuerdo = $request->esta_acuerdo;
            $encuesta->medios_actualizacion_id = $request->medios_actualizacion_id;
            $encuesta->save();    
                
            $capacitacion->lineasTematicas()->detach();
            $capacitacion->mediosCapacitacion()->detach();
            $capacitacion->programasCapaciacion()->detach();      
            $capacitacion->lineasTematicas()->attach($request->lineasadmin);   
            $capacitacion->lineasTematicas()->attach($request->lineasopvt);   
            
            for($i = 0; $i < count($request->medios);$i++){
                
                if($request->medios[$i] == 6){
                      $capacitacion->mediosCapacitacion()->attach($request->medios[$i],['otro' => $request->otromedio]);
                    
                }else{
                    $capacitacion->mediosCapacitacion()->attach($request->medios[$i]);
                }  
                
            }
            
            for($i = 0; $i < count($request->tipos);$i++){
                
                if($request->tipos[$i] == 10){
                      $capacitacion->programasCapaciacion()->attach($request->tipos[$i],['otro' => $request->otrotipo]);
                    
                }else{
                     $capacitacion->programasCapaciacion()->attach($request->tipos[$i]);
                } 
                
            }
            
    		foreach($request->tematicas as $tematica){
		  
	           
	                 if(collect($tematica)->has("id")){
	                        $temb = Tematica_Capacitacion::where("id",$tematica["id"])->first();
                    if ($temb == null)
                    {
                        $temb = new Tematica_Capacitacion(); 
                        $temb->encuesta_id = $request->Encuesta;
                        $temb->nombre =  $tematica["nombre"]; 
                        $temb->realizada_empresa =  $tematica["realizada_empresa"]; 
                        $temb->save();
                    }
                    else
                    {               
                        $temb->nombre =  $tematica["nombre"]; 
                        $temb->realizada_empresa =  $tematica["realizada_empresa"]; 
                        $temb->save();
                    }
	                 
	                     
	                 }else{
                        $temb = new Tematica_Capacitacion(); 
                        $temb->encuesta_id = $request->Encuesta;
                        $temb->nombre =  $tematica["nombre"]; 
                        $temb->realizada_empresa =  $tematica["realizada_empresa"]; 
                        $temb->save();
	                 }
	      
		    
		}
		
	  Historial_Encuesta_Oferta::create([
           'encuesta_id' => $request->Encuesta,
           'user_id' => 1,
           'estado_encuesta_id' => 3,
           'fecha_cambio' => Carbon::now()
       ]);
		
		
        
        
        return ["success" => true, "idsitio"=> $encuesta->sitios_para_encuestas_id ];
    }
    
    public function postGuardarnumeroemp(Request $request){
        $validator = \Validator::make($request->all(), [
			'Encuesta' => 'required|exists:empleos,id',
			'TemporalDirecto' => 'required|min:0',
			'TemporalAgencia' => 'required|min:0',
			'Permanente' => 'required|min:0',
			'Aprendiz' => 'required|min:0',
			'Rango12' => 'required|min:0',
			'Rango19' => 'required|min:0',
			'Rango26' => 'required|min:0',
			'Rango41' => 'required|min:0',
			'Rango65' => 'required|min:0',
			'Hombre' => 'required|min:0',
		    'Mujer' => 'required|min:0',
		
		
    	],[
       		'Encuesta.required' => 'Error no se encontro la encuesta.',
       		'Encuesta.exists' => 'La encuesta eleccionado no se encuentra seleccionado en el sistema.',
      		'TemporalDirecto.required' => 'Debe agregar temporal directo.',
       		'TemporalDirecto.min' => 'El número temporal directo debe ser mayor o igual que cero.',
     		'TemporalAgencia.required' => 'Debe agregar temporal agencia.',
       		'TemporalAgencia.min' => 'El número temporal agencia debe ser mayor o igual que cero.',
     		'Permanente.required' => 'Debe agregar permanenteo.',
       		'Permanente.min' => 'El número permanente debe ser mayor o igual que cero.',
     		'Aprendiz.required' => 'Debe agregar temporal directo.',
       		'Aprendiz.min' => 'El número temporal directo debe ser mayor o igual que cero.',
     		'Rango12.required' => 'Debe agregar temporal directo.',
       		'Rango12.min' => 'El número temporal directo debe ser mayor o igual que cero.',
       		'Rango19.required' => 'Debe agregar temporal directo.',
       		'Rango19.min' => 'El número temporal directo debe ser mayor o igual que cero.',
      		'Rango26.required' => 'Debe agregar temporal directo.',
       		'Rango26.min' => 'El número temporal directo debe ser mayor o igual que cero.',
      		'Rango41.required' => 'Debe agregar temporal directo.',
       		'Rango41.min' => 'El número temporal directo debe ser mayor o igual que cero.',
     		'Rango65.required' => 'Debe agregar temporal directo.',
       		'Rango65.min' => 'El número temporal directo debe ser mayor o igual que cero.',
     		'Hombre.required' => 'Debe agregar temporal directo.',
       		'Hombre.min' => 'El número temporal directo debe ser mayor o igual que cero.',
     		'Mujer.required' => 'Debe agregar temporal directo.',
       		'Mujer.min' => 'El número temporal directo debe ser mayor o igual que cero.',
 
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$encuesta = Empleo::find($request->Encuesta);

		
	
	    if( ($request->TemporalDirecto+ $request->TemporalAgencia + $request->Permanente + $request->Aprendiz) != ($encuesta->tiempo_completo + $encuesta->medio_tiempo) ){
	        return ["success" => false, "errores" => [["El total de empleados según el tipo de vinculación no coincieden con el total de empleados del establecimiento."]] ];    
	    }
		
	   if( ($request->Rango12+$request->Rango19+$request->Rango26+$request->Rango41+$request->Rango65) != ($encuesta->tiempo_completo + $encuesta->medio_tiempo) ){
	        return ["success" => false, "errores" => [["El total de empleados según el rango no coincieden con el total de empleados del establecimiento."]] ];    
	    }
	    
	   if( ($request->Mujer+$request->Hombre) != ($encuesta->tiempo_completo + $encuesta->medio_tiempo) ){
	        return ["success" => false, "errores" => [["El total de empleados según el sexo no coincieden con el total de empleados del establecimiento."]] ];    
	    }

	    $vincBuscado = Empleado_Vinculacion::where("encuestas_id", $request->Encuesta)->first();
        $edadBuscado = Edad_Empleado::where("encuestas_id", $request->Encuesta)->first();
        $sexoBuscado = Sexo_Empleado::where("encuestas_id", $request->Encuesta)->first();

        if ($vincBuscado == null)
        {
            $vincBuscado = new Empleado_Vinculacion();
            $vincBuscado->encuestas_id = $request->Encuesta;
            $vincBuscado->contrato_direto = $request->TemporalDirecto;
            $vincBuscado->personal_agencia = $request->TemporalAgencia;
            $vincBuscado->personal_permanente = $request->Permanente;
            $vincBuscado->aprendiz = $request->Aprendiz;
            $vincBuscado->save();
        }
        else
        {
            $vincBuscado->contrato_direto = $request->TemporalDirecto;
            $vincBuscado->personal_agencia = $request->TemporalAgencia;
            $vincBuscado->personal_permanente = $request->Permanente;
            $vincBuscado->aprendiz = $request->Aprendiz;
            $vincBuscado->save();
        }

        if ($edadBuscado == null)
        {
            $edadBuscado = new Edad_Empleado();
            $edadBuscado->encuestas_id = $request->Encuesta;
            $edadBuscado->docea18 = $request->Rango12;
            $edadBuscado->diecinuevea25 = $request->Rango19;
            $edadBuscado->ventiseisa40 = $request->Rango26;
            $edadBuscado->cuarentayunoa64 = $request->Rango41;
            $edadBuscado->mas65 = $request->Rango65;
            $edadBuscado->save();
        }
        else
        {
            $edadBuscado->docea18 = $request->Rango12;
            $edadBuscado->diecinuevea25 = $request->Rango19;
            $edadBuscado->ventiseisa40 = $request->Rango26;
            $edadBuscado->cuarentayunoa64 = $request->Rango41;
            $edadBuscado->mas65 = $request->Rango65;
            $edadBuscado->save();
        }
   
        if ($sexoBuscado == null)
        {
            $sexoBuscado = new Sexo_Empleado();
            $sexoBuscado->encuestas_id = $request->Encuesta;
            $sexoBuscado->mujeres = $request->Mujer;
            $sexoBuscado->hombres = $request->Hombre;
            $sexoBuscado->save();
        }
        else
        {
            $sexoBuscado->mujeres = $request->Mujer;
            $sexoBuscado->hombres = $request->Hombre;
            $sexoBuscado->save();
        }

		
		        Historial_Encuesta_Oferta::create([
               'encuesta_id' => $encuesta->id,
               'user_id' => 1,
               'estado_encuesta_id' => 2,
               'fecha_cambio' => Carbon::now()
           ]);
		

        return ["success" => true];
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
            $agenciaRetornar["TipoServicios"] = sizeof($agencia["viajesTurismos"]) == 0 ? null : $agencia["viajesTurismos"][0];
            $agenciaRetornar["Planes"] = sizeof($agencia["viajesTurismos"][0]->ofreceplanes) == 0 ? null : $agencia["viajesTurismos"][0]->ofreceplanes;
            $agenciaRetornar["Otro"] = sizeof($agencia["viajesTurismos"][0]->viajesTurismosOtro["otro"]) == 0 ? null : $agencia["viajesTurismos"][0]->viajesTurismosOtro["otro"];
        }else{
            $agenciaRetornar["TipoServicios"] = null;
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
            'Planes' => 'boolean|required',
            'TipoServicios' => 'required',
            
        ],[
            'id.required' => 'Tuvo primero que haber creado una encuesta.',
            'id.exists' => 'Tuvo primero que haber creado una encuesta.',
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
            $viajes_turismos = Viaje_Turismo::create([
                'encuestas_id'=>$request->id,  
                'ofreceplanes'=>$request->Planes  
            ]);
            
            foreach ($request->TipoServicios as $servi)
            {
                $viajes_turismos->serviciosAgencias()->attach($servi);
                //$viajes_turismos->save();
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
                    if($viajes_turismos_otro == null){
                        $viajes_turismos_otro = new Viaje_Turismo_Otro();
                        $viajes_turismos_otro->viajes_turismo_id = $viajes_turismos->id;
                    }
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
       /* $agencia = Persona_Destino_Con_Viaje_Turismo::with(['viajesTurismo'=>function($q) use($id){
           $q->where('encuestas_id',$id);
       }])->get();*/
       //return $agencia;
        $agencia = Viaje_Turismo::with(['planesSantamarta','personasDestinoConViajesTurismos'=>function($q){
            $q->with('opcionesPersonasDestino')->get();
        }])->where('encuestas_id',$id)->first();
        

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
                'id.required' => 'Tuvo primero que haber creado una encuesta.',
                'id.exists' => 'Tuvo primero que haber creado una encuesta.',
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
            //return $request->personas;
            foreach ($request->personas as $fila)
            {
                if(intval($fila["internacional"]) + intval($fila["nacional"]) != 100){
                    $errores["Porcentajes"][0] = "Todo los porcentajes en la seccion personas que viajaron segun destinos deben sumar 100.";
                }
                //return $fila;
                if(Opcion_Persona_Destino::where('id',intval($fila["opciones_personas_destino_id"]))->first() == null){
                    $errores["Opciones"][0] = "Una de las opciones cargadas no esta disponible.";
                }
            }
            if($request->magdalena + $request->nacional + $request->internacional != 100){
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
            return ["success"=>true];
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
                if($prestamo){
                    $prestamoCargar["totalP"] = floatval($prestamo->numero_personas);
                    $prestamoCargar["porcentajeC"] = floatval($prestamo->personas_colombianas);
                    $prestamoCargar["porcentajeE"] = floatval($prestamo->personas_extranjeras);
                    $prestamoCargar["porcentajeM"] = floatval($prestamo->personas_magdalena);    
                }
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
       
    
        $alojamiento = alojamiento::where("encuestas_id",$request->encuesta)->first();
    
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
           'encuesta_id' => $request->encuesta,
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
    
    public function getInfocaracterizaciontransporte($id)
    {
        
        $transporte = Transporte::with('tipoTransporteOferta')->where('encuestas_id',$id)->get();
        
        return ["transporte"=>$transporte];
    }
    
    public function postGuardarcaracterizaciontransporte(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:encuestas,id',
            
        ],[
            'id.required' => 'Tuvo primero que haber creado una encuesta.',
            'id.exists' => 'Tuvo primero que haber creado una encuesta.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        //return $request->all();
        $errores = [];
        if($request->Terrestre == null && $request->Aereo == null && $request->Maritimo == null){
            $errores["VehiculosTerrestre"][0] = "No se ha diligenciado el formulario correctamente.";    
        }
        if($request->Terrestre != 1 && $request->Aereo != 2 && $request->Maritimo != 3){
            $errores["VehiculosTerrestre"][0] = "Se ha manipulado la información, favor recargar la página.";    
        }else{
            if($request->Terrestre != null && $request->Terrestre == 1){
                if($request->VehiculosTerrestre == null || $request->PersonasVehiculosTerrestre == null){
                    $errores["VehiculosTerrestre"][0] = "Por favor complete la sección de transporte terrestre.";    
                }
            }
            if($request->Aereo != null && $request->Aereo == 2){
                if($request->VehiculosAereo == null || $request->PersonasVehiculosAereo == null){
                    $errores["VehiculosAereo"][0] = "Por favor complete la sección de transporte aéreo.";    
                }
            }
            if($request->Maritimo != null && $request->Maritimo == 3){
                if($request->VehiculosMaritimo == null || $request->PersonasVehiculosMaritimo == null){
                    $errores["VehiculosMaritimo"][0] = "Por favor complete la sección de transporte marítimo.";    
                }
            }    
        }
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        //return $request->all();
        /*if(Transporte::where('encuestas_id',$request->id)->count() > 0){
            
            $busquedaTransporte = Transporte::where('encuestas_id',$request->id)->delete();
        }*/
        $busquedaTransporte = Transporte::where('encuestas_id',$request->id)->get();
        if($busquedaTransporte != null){
            //return $busquedaTransporte;
            foreach($busquedaTransporte as $busqueda){
                if($busqueda->tipos_transporte_oferta_id == 1){
                    if($request->Terrestre == null || $request->Terrestre == false){
                        $busquedaOferta = Oferta_transporte::where('transporte_id',$busqueda->id)->first();
                        if($busquedaOferta != null){
                            $busquedaOferta->delete();
                            
                        }
                        $busqueda->delete();
                    }else{
                        $busqueda->numero_vehiculos = intval($request->VehiculosTerrestre);
                        $busqueda->personas = intval($request->PersonasVehiculosTerrestre);
                        $busqueda->encuestas_id = intval($request->id);
                        $busqueda->save();
                    }
                }
                if($busqueda->tipos_transporte_oferta_id == 2){
                    //return $busqueda;
                    if($request->Aereo == null || $request->Aereo == false){
                        $busquedaOferta = Oferta_transporte::where('transporte_id',$busqueda->id)->first();
                        if($busquedaOferta != null){
                            //return $busquedaOferta;
                            $busquedaOferta->delete();
                            
                        }
                        $busqueda->delete();
                    }else{
                        $busqueda->numero_vehiculos = intval($request->VehiculosAereo);
                        $busqueda->personas = intval($request->PersonasVehiculosAereo);
                        $busqueda->encuestas_id = $request->id;
                        $busqueda->save();
                    }
                }
                if($busqueda->tipos_transporte_oferta_id == 3){
                    if($request->Maritimo == null || $request->Maritimo == false){
                        $busquedaOferta = Oferta_transporte::where('transporte_id',$busqueda->id)->first();
                        if($busquedaOferta != null){
                            $busquedaOferta->delete();
                            
                        }
                        $busqueda->delete();
                    }else{
                        $busqueda->numero_vehiculos = intval($request->VehiculosMaritimo);
                        $busqueda->personas = intval($request->PersonasVehiculosMaritimo);
                        $busqueda->encuestas_id = $request->id;
                        $busqueda->save();
                    }
                }
            }
            
        }
        if ($request->Terrestre != null ) {
            $transporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',1)->first();
            if($transporte == null){
                $transporte = new Transporte();
                $transporte->tipos_transporte_oferta_id = intval($request->Terrestre);
                $transporte->numero_vehiculos = intval($request->VehiculosTerrestre);
                $transporte->personas = intval($request->PersonasVehiculosTerrestre);
                $transporte->encuestas_id = intval($request->id);
                $transporte->save();
            }
            
        }
        if ($request->Aereo != null )
        {
            $transporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',2)->first();
            if($transporte == null){
                $transporte = new Transporte();
                $transporte->tipos_transporte_oferta_id = intval($request->Aereo);
                $transporte->numero_vehiculos = intval($request->VehiculosAereo);
                $transporte->personas = intval($request->PersonasVehiculosAereo);
                $transporte->encuestas_id = $request->id;
                $transporte->save();
            }
        }
        if ($request->Maritimo != null )
        {
            $transporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',3)->first();
            if($transporte == null){
                $transporte = new Transporte();
                $transporte->tipos_transporte_oferta_id = intval($request->Maritimo);
                $transporte->numero_vehiculos = intval($request->VehiculosMaritimo);
                $transporte->personas = intval($request->PersonasVehiculosMaritimo);
                $transporte->encuestas_id = $request->id;
                $transporte->save();
            }
        }
            
        $historial = new Historial_Encuesta_Oferta();
        $historial->encuesta_id = $request->id;
        $historial->estado_encuesta_id = 2;
        $historial->fecha_cambio = Carbon::now();
        $historial->user_id = 1;
        $historial->save();
        
        return ["success"=>true];
            
    }
    
    public function getInfoofertatransporte($id) {
        
        $transporte = Transporte::select('tipos_transporte_oferta_id')->with('tipoTransporteOferta')->where('encuestas_id',$id)->get();
       // return $transporte;
        $ids = [];
        if($transporte != null){
            foreach($transporte as $trans)
            array_push($ids,$trans->tipos_transporte_oferta_id);
        }
        $oferta = Oferta_Transporte::with(['transporte'=>function($q) use ($id){
            $q->where('encuestas_id',$id);
        }])->get();
        
        return ["oferta"=>$oferta, "ides"=>$ids];
    }
    
    public function postGuardarofertatransporte(Request $request) {
        //return $request->all();
        $validator = \Validator::make($request->all(),[
        
            'id' => 'required|exists:encuestas,id',
            
            'Terrestre' => 'exists:tipo_transporte_oferta,id',
            'Aereo' => 'exists:tipo_transporte_oferta,id',
            'Maritimo' => 'exists:tipo_transporte_oferta,id',
            
            'TotalTerrestre' => 'numeric|min:1',
            'TarifaTerrestre' => 'numeric|min:1000',
            'TotalAereo' => 'numeric|min:1',
            
            'TarifaAereo' => 'numeric|min:1000',
            'TotalMaritimo' => 'numeric|min:1',
            'TarifaMaritimo' => 'numeric|min:1000',
            
        ],[
            'id.required' => 'Verifique la información y vuelva a intentarlo.',
            'id.exists' => 'Verifique la información y vuelva a intentarlo.',
            
            'Terrestre.exists' => 'Verifique la información y vuelva a intentarlo, la opción de tipo transporte terrestre no se encuentra en la base de datos.',
            'Aereo.exists' => 'Verifique la información y vuelva a intentarlo, la opción de tipo transporte aéreo no se encuentra en la base de datos.',
            'Maritimo.exists' => 'Verifique la información y vuelva a intentarlo, la opción de tipo transporte marítimo no se encuentra en la base de datos.',

            'TotalTerrestre.numeric' => 'Por favor ingrese un valor mayor que cero en el campo de transporte terrestre.',
            'TotalTerrestre.min' => 'Por favor ingrese un valor mayor que cero en el campo de transporte terrestre.',
            
            'TarifaTerrestre.numeric' => 'Por favor ingrese un valor válido para tarifa de transporte terrestre.',
            'TarifaTerrestre.min' => 'El valor para tarifa de transporte terrestre debe ser mayor o igual a 1000.',
            
            'TotalAereo.numeric' => 'Por favor ingrese un valor mayor que cero en el campo de transporte aéreo.',
            'TotalAereo.min' => 'Por favor ingrese un valor mayor que cero en el campo de transporte aéreo.',
            
            'TarifaAereo.numeric' => 'Por favor ingrese un valor válido para tarifa de transporte aéreo.',
            'TarifaAereo.min' => 'El valor para tarifa de transporte aéreo debe ser mayor o igual a 1000.',
            
            'TotalMaritimo.numeric' => 'Por favor ingrese un valor mayor que cero en el campo de transporte marítimo.',
            'TotalMaritimo.min' => 'Por favor ingrese un valor mayor que cero en el campo de transporte marítimo.',
            
            'TarifaMaritimo.numeric' => 'Por favor ingrese un valor válido para tarifa de transporte marítimo.',
            'TarifaMaritimo.min' => 'El valor para tarifa de transporte marítimo debe ser mayor o igual a 1000.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //return $request->all();
        $errores = [];
        if($request->Terrestre == null && $request->Aereo == null && $request->Maritimo == null){
            $errores["VehiculosTerrestre"][0] = "No se ha diligenciado el formulario correctamente.";    
        }
        if($request->Terrestre != 1 && $request->Aereo != 2 && $request->Maritimo != 3){
            $errores["VehiculosTerrestre"][0] = "Se ha manipulado la información, favor recargar la página.";    
        }else{
            if($request->Terrestre != null && $request->Terrestre == 1){
                 $capacidadTotal = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Terrestre))->first();
                //return $capacidadTotal;
                if ($request->TotalTerrestre > $capacidadTotal->personas) {
                    $errores["TotalTerrestre"][0] ="Por favor el campo total de personas transportadas el mes anterior no puede superar la capacidad total de transporte";
                }
            }
            if($request->Aereo != null && $request->Aereo == 2){
                $capacidadTotal = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Aereo))->first();
                
                if ($request->TotalAereo > $capacidadTotal->personas) {
                    $errores["TotalAereo"][0] ="Por favor el campo total de personas transportadas el mes anterior no puede superar la capacidad total de transporte";
                }
            }
            if($request->Maritimo != null && $request->Maritimo == 3){
                $capacidadTotal = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Maritimo))->first();
                
                if ($request->TotalMaritimo > $capacidadTotal->personas) {
                    $errores["TotalTerrestre"][0] ="Por favor el campo total de personas transportadas el mes anterior no puede superar la capacidad total de transporte";
                }
            }    
        }
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        //return $request->all();
        
        if ($request->Terrestre != null ) {
                $busquedaTransporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Terrestre))->first();
                $ofertaTransporte = new Oferta_Transporte();
                $ofertaTransporte->transporte_id = $busquedaTransporte->id;
                $ofertaTransporte->tarifa_promedio = $request->TarifaTerrestre;
                $ofertaTransporte->personas_total = $request->TotalTerrestre;
                $ofertaTransporte->save();
        }
        if ($request->Aereo != null )
        {
                $busquedaTransporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Aereo))->first();
                $ofertaTransporte = new Oferta_Transporte();
                $ofertaTransporte->transporte_id = $busquedaTransporte->id;
                $ofertaTransporte->tarifa_promedio = $request->TarifaAereo;
                $ofertaTransporte->personas_total = $request->TotalAereo;
                $ofertaTransporte->save();
        }
        if ($request->Maritimo != null )
        {
                $busquedaTransporte = Transporte::where('encuestas_id',$request->id)->where('tipos_transporte_oferta_id',intval($request->Maritimo))->first();
                $ofertaTransporte = new Oferta_Transporte();
                $ofertaTransporte->transporte_id = $busquedaTransporte->id;
                $ofertaTransporte->tarifa_promedio = $request->TarifaMaritimo;
                $ofertaTransporte->personas_total = $request->TotalMaritimo;
                $ofertaTransporte->save();
        }
            
        $historial = new Historial_Encuesta_Oferta();
        $historial->encuesta_id = $request->id;
        $historial->estado_encuesta_id = 2;
        $historial->fecha_cambio = Carbon::now();
        $historial->user_id = 1;
        $historial->save();
        
        return ["success"=>true];
        
    }
    
    public function getProveedoresactivos()
    {
        $proveedores = Proveedor::with(['proveedoresConIdiomas'=>function($q){
            $q->where('idiomas_id',1);
        },'sitio'=>function($r){
            $r->with(['sitiosConIdiomas','sitiosParaEncuestas']);
        }])->get();
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
                    
                    //$mes = encuesta.meses_de_anio.mes.nombre;
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
