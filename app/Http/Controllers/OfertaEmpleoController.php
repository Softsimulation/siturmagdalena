<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

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
