<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
     public function getData($one){
       
        return Encuesta::get();
    }
    
    public function getEmpleadoscaracterizacion($one){
        $id = $one;
        return view('ofertaEmpleo.EmpleadosCaracterizacion',compact('id'));
    }
    
      public function getEmpleomensual($one){
        $id = $one;
        return view('ofertaEmpleo.EmpleoMensual',compact('id'));
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
            
            $data = collect();
            $data["lineas"] = Linea_Tematica::select("id","nombre","tipo_nivel")->get();
            $data["tipos"] = Tipo_Programa_Capacitacion::select("id","nombre")->get();
            $data["medios"] = Medio_Capacitacion::select("id","nombre")->get();
          
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
        $vacBuscado->remplazo = $request->VacanteOperativo;
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
  	         'capacitacion' => 'required|min:0',
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
		
    		$encuesta = Empleo::find($request->Encuesta);
    
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
		
		

        return ["success" => true];
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

    
}