<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Actividad_Deportiva;
use App\Models\Tour;
use App\Models\Encuesta;
use App\Models\Agencia_Operadora;
use App\Models\Otra_Actividad;
use App\Models\Otro_Tour;
use App\Models\Historial_Encuesta_Oferta;
use App\Models\Prestamo_Servicio;
use App\Models\Alquiler_Vehiculo;

use App\Models\Encuesta;
use App\Models\alojamiento;
use App\Models\Casa;
use App\Models\Camping;
use App\Models\Habitacion;
use App\Models\Apartamento;
use App\Models\Cabana;
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
    
}
