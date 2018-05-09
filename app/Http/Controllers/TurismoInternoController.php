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
    
    public function getActividadesrealizadas(){
        return view('turismointerno.ActividadesRealizadas');
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
    public function getViajesrealizados(){
        return view('turismointerno.ViajesRealizados');
    }
    
   
}
