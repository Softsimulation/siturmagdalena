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
    }
    
}
