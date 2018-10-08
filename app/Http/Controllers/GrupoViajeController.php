<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests;
use App\Models\Lugar_Aplicacion_Encuesta;
use App\Models\Tipo_Viaje;
use App\Models\Grupo_Viaje;
use App\Models\Visitante;

class GrupoViajeController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
    public function getGrupoviaje(){
        return view('grupoViaje.CrearGrupoViaje');
    }
    public function getListadogrupos(){
        //$grupos = Grupo_Viaje::where('digitador_id',6)->get();
        return view('grupoViaje.ListadoGrupos');
    }
    public function getGrupos(){
        


            $grupos = Grupo_Viaje::with(['lugaresAplicacionEncuestum','digitadore'=>function($q){
                $q->with('user');
            },'visitantes'=>function($q){
                $q->select("grupo_viaje_id","nombre");
            }])->where('digitador_id',$this->user->digitador->id)->get();
            
        return $grupos;    
    }
    
    public function getInformaciondatoscrear(){
        
        $lugares_aplicacion = Lugar_Aplicacion_Encuesta::all();
        
        $tipos_viajes = Tipo_Viaje::with(["tiposViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipo_viaje_id','nombre');
        }])->get();
        
        $result = [ 'lugares_aplicacion' => $lugares_aplicacion, 
                    'tipos_viajes' => $tipos_viajes
        ];
        
        return $result;
    }
    public function postGuardargrupo(Request $request) {
        //return $request->all();
        $validator=\Validator::make($request->all(),[
            
            'Fecha'=>'required|date',
            'Sitio'=>'required|numeric|exists:lugares_aplicacion_encuesta,id',
            'Mayores15'=>'required|numeric|between:0,999999999',
            'Menores15'=>'required|numeric|between:0,999999999',
            'Mayores15No'=>'required|numeric|between:0,999999999',
            'Menores15No'=>'required|numeric|between:0,999999999',
            'PersonasMag'=>'required|numeric|between:0,999999999',
            'PersonasEncuestadas'=>'required|numeric|between:0,999999999',
            'Tipo'=>'required|numeric|exists:tipos_viaje,id',
        ],
        [
       		'Fecha.required' => 'La fecha de aplicación es requerida.',
       		'Fecha.date' => 'El campo fecha debe ser formato fecha.',
       		'Sitio.required' => 'El sitio es requerido.',
       		'Sitio.exists' => 'El sitio seleccionado no se encuentra en la DB.',
       		'Sitio.numeric' => 'Debes selecionar un sitio válido.',
       		'Mayores15.required' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.numeric' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.between' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Menores15.required' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15.numeric' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15.between' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Mayores15.required' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.numeric' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.between' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Menores15No.required' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15No.numeric' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15No.between' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'PersonasMag.required' => 'El número de las personas del Magdalena debe ser un valor numérico.',
       		'PersonasMag.numeric' => 'El número de las personas del Magdalena debe ser un valor numérico.',
       		'PersonasMag.between' => 'El número de las personas del Magdalena debe ser un valor numérico mayor o igual a 0.',
       		
       		'Tipo.required' => 'El tipo de viaje es requerido.',
       		'Tipo.exists' => 'El tipo de viaje seleccionado no se encuentra en la DB.',
       		'Tipo.numeric' => 'Debes selecionar un tipo de viaje válido.',
       		
       		'PersonasEncuestadas.required' => 'El número de personas encuestadas debe ser un valor numérico.',
       		'PersonasEncuestadas.numeric' => 'El número de personas encuestadas debe ser un valor numérico.',
       		'PersonasEncuestadas.between' => 'El número de personas encuestadas debe ser un valor numérico mayor o igual a 0.',
    	]);
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        
        $total =  $request->Mayores15 + $request->Mayores15No + $request->Menores15 + $request->Menores15No;
        if ($total == 0) {
            $errores["Total"][0] = "Debe ingresar por lo menos algun valor en el tamaño del grupo de viaje.";
        }

        if ($request->PersonasEncuestadas > $request->Mayores15)
        {
            $errores["Total"][1] ="La cantidad de personas encuestadas no puede ser mayor a las personas mayores de 15 años presentes.";
        }

        if ($total < $request->PersonasEncuestadas) {
            $errores["Total"][2] = "La cantidad de personas encuestadas no puede ser mayor al tamaño total del grupo.";
        }
        $date = Carbon::now();
        if(strtotime($request->Fecha) >  strtotime($date)){
            $errores["Fecha"][0] = "La fecha de aplicación no puede superar la fecha actual.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        //return $request->all();

        $grupo = new Grupo_Viaje();
        $grupo->digitador_id = $this->user->digitador->id;
        $grupo->fecha_aplicacion = $request->Fecha;
        $grupo->lugar_aplicacion_id = $request->Sitio;
        $grupo->tipo_viaje_id = $request->Tipo;
        $grupo->mayores_quince = $request->Mayores15;
        $grupo->menores_quince = $request->Menores15;
        $grupo->menores_quince_no_presentes = $request->Menores15No;
        $grupo->mayores_quince_no_presentes = $request->Mayores15No;
        $grupo->personas_magdalena = $request->PersonasMag;
        $grupo->personas_encuestadas = $request->PersonasEncuestadas;
        $grupo->created_at = Carbon::now();
        $grupo->updated_at = Carbon::now();
        $grupo->user_create = $this->user->username;
        $grupo->user_update = $this->user->username;
        $grupo->estado = true;
        
        //return $request->all();
        
        $grupo->save();

        return  ["success"=>true,"id"=>$grupo->id];
    }
    
    public function getVergrupo($id) {
            if ($id == null)
            {
                return response('Bad request.', 400);
            }
            else
            {
                $grupo = Grupo_Viaje::where('id',$id)->first();
                if ($grupo == null || $grupo->estado == false)
                {
                    return response('Bad request.', 400);
                }

            }
            $grupo = Grupo_Viaje::where('id',$id)->first();
            return view('grupoViaje.VerGrupo',array('id' => $id,'grupo'=>$grupo));
        }

    public function getDetallegrupo($id)
    {
        //return $id;
        //return $id;
        
        //string idioma = (string)Session["idioma"];

        //$sitios = Lugar_Aplicacion_Encuesta::
            
        $lugares_aplicacion = Lugar_Aplicacion_Encuesta::all();
    
        $tipos_viajes = Tipo_Viaje::with(["tiposViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipo_viaje_id','nombre');
        }])->get();

        $grupo = Grupo_Viaje::where('id',$id)->with(['lugaresAplicacionEncuestum','tiposViaje'=>function($q){
            $q->with(['tiposViajeConIdiomas'=>function($r){
                $r->whereHas('idioma', function($p){
                    $p->where('culture','es');
                });
            }]);
        },'visitantes'=>function($q){
            $q->with(['historialEncuestas'=>function($r){
                $r->with(['estadosEncuesta'=>function($s){
                    $s->select("id","nombre");
                }])->orderby('fecha_cambio','desc');
            }]);
        }])->first();
        
        return $grupo;                        
    }
    
    public function getInformacioneditar($id) {
            
        $lugares_aplicacion = Lugar_Aplicacion_Encuesta::all();
    
        $tipos_viajes = Tipo_Viaje::with(["tiposViajeConIdiomas" => function($q){
            $q->whereHas('idioma', function($p){
                $p->where('culture','es');
            })->select('tipo_viaje_id','nombre');
        }])->get();

        $grupo = Grupo_Viaje::where('id',$id)->with(['tiposViaje'=>function($q){
            $q->with(['tiposViajeConIdiomas'=>function($r){
                $r->whereHas('idioma', function($p){
                    $p->where('culture','es');
                });
            }]);
        },'visitantes'=>function($q){
            $q->with(['historialEncuestas'=>function($r){
                $r->where('fecha_cambio',$r->max('fecha_cambio'))->with(['estadosEncuesta'=>function($s){
                    $s->select("id","nombre");
                }]);
            }]);
        }])->first();
        //return $grupo;
        $grupoRetornar = [];
        
        $grupoRetornar["id"] = $grupo->id;
        $grupoRetornar["Mayores15"] = $grupo->mayores_quince;
        $grupoRetornar["Mayores15No"] = $grupo->mayores_quince_no_presentes;
        $grupoRetornar["PersonasMag"] = $grupo->personas_magdalena;
        $grupoRetornar["Menores15"] = $grupo->menores_quince;
        $grupoRetornar["Menores15No"] = $grupo->menores_quince_no_presentes;
        $grupoRetornar["Fecha"] = date('Y-m-d',strtotime($grupo->fecha_aplicacion));;
        $grupoRetornar["Sitio"] = $grupo->lugar_aplicacion_id;
        $grupoRetornar["Tipo"] = $grupo->tipo_viaje_id;
        $grupoRetornar["PersonasEncuestadas"] = $grupo->personas_encuestadas;
        $grupoRetornar["Encuestas"] = [];
        
        for($i=0;$i<sizeof($grupo->visitantes);$i++){
            //return $grupo->visitantes;
            $visitante = [];
            //$estados_encuesta = $grupo->visitantes[$i]->historialEncuestas[0];
            $visitante["Id"] = $grupo->visitantes[$i]["id"];
            $visitante["Nombre"] = $grupo->visitantes[$i]["nombre"];
            $visitante["Sexo"] = $grupo->visitantes[$i]["sexo"];
            $visitante["Email"] = $grupo->visitantes[$i]["email"];
            if(sizeof($grupo->visitantes[$i]->historialEncuestas) > 0){
                $visitante["Estado"] = $grupo->visitantes[$i]->historialEncuestas[0];
            }
            
            array_push($grupoRetornar["Encuestas"],$visitante);
        }
        
        return ["grupo"=>$grupoRetornar, "lugares_aplicacion"=>$lugares_aplicacion, "tipos_viajes"=>$tipos_viajes];                      
    }
    
    public function getEditar($id) {
        if ($id == null)
        {
            return response('Bad request.', 400);
        }
        else
        {
            $grupo = Grupo_Viaje::where('id',$id)->first();
            if ($grupo == null || $grupo->estado == false)
            {
                return response('Bad request.', 400);
            }

        }
        return view('grupoViaje.EditarGrupo',array('id' => $id));
    }

    public function postEditargrupo(Request $request) {
        //return $request->all();
        $validator=\Validator::make($request->all(),[
            'id'=>'required|exists:grupos_viaje,id',
            'Fecha'=>'required|date',
            'Sitio'=>'required|numeric|exists:lugares_aplicacion_encuesta,id',
            'Mayores15'=>'required|numeric|between:0,999999999',
            'Menores15'=>'required|numeric|between:0,999999999',
            'Mayores15No'=>'required|numeric|between:0,999999999',
            'Menores15No'=>'required|numeric|between:0,999999999',
            'PersonasMag'=>'required|numeric|between:0,999999999',
            'PersonasEncuestadas'=>'required|numeric|between:0,999999999',
            'Tipo'=>'required|numeric|exists:tipos_viaje,id',
        ],
        [
            'Id.required' => 'Favor recargar la página.',
       		'Id.exists' => 'El grupo seleccionado no se encuentra en la DB.',
       		'Fecha.required' => 'La fecha de aplicación es requerida.',
       		'Fecha.date' => 'El campo fecha debe ser formato fecha.',
       		'Sitio.required' => 'El sitio es requerido.',
       		'Sitio.exists' => 'El sitio seleccionado no se encuentra en la DB.',
       		'Sitio.numeric' => 'Debes selecionar un sitio válido.',
       		'Mayores15.required' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.numeric' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.between' => 'El número de las personas presentes mayores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Menores15.required' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15.numeric' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15.between' => 'El número de las personas presentes menores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Mayores15.required' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.numeric' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico.',
       		'Mayores15.between' => 'El número de las personas no presentes mayores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'Menores15No.required' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15No.numeric' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico.',
       		'Menores15No.between' => 'El número de las personas no presentes menores de 15 años debe ser un valor numérico mayor o igual a 0.',
       		
       		'PersonasMag.required' => 'El número de las personas del Magdalena debe ser un valor numérico.',
       		'PersonasMag.numeric' => 'El número de las personas del Magdalena debe ser un valor numérico.',
       		'PersonasMag.between' => 'El número de las personas del Magdalena debe ser un valor numérico mayor o igual a 0.',
       		
       		'Tipo.required' => 'El tipo de viaje es requerido.',
       		'Tipo.exists' => 'El tipo de viaje seleccionado no se encuentra en la DB.',
       		'Tipo.numeric' => 'Debes selecionar un tipo de viaje válido.',
       		
       		'PersonasEncuestadas.required' => 'El número de personas encuestadas debe ser un valor numérico.',
       		'PersonasEncuestadas.numeric' => 'El número de personas encuestadas debe ser un valor numérico.',
       		'PersonasEncuestadas.between' => 'El número de personas encuestadas debe ser un valor numérico mayor o igual a 0.',
    	]);
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        $errores = [];
        $errores["Total"] = [];
        $errores["Fecha"] = [];
        
        $total =  $request->Mayores15 + $request->Mayores15No + $request->Menores15 + $request->Menores15No;
        if ($total == 0) {
            array_push($errores["Total"],"Debe ingresar por lo menos algun valor en el tamaño del grupo de viaje.");
        }
    
        if ($request->PersonasEncuestadas > $request->Mayores15)
        {
            array_push($errores["Total"],"La cantidad de personas encuestadas no puede ser mayor a las personas mayores de 15 años presentes.");
        }
    
        if ($total < $request->PersonasEncuestadas) {
            array_push($errores["Total"],"La cantidad de personas encuestadas no puede ser mayor al tamaño total del grupo.");
        }
        
        $encuestas = Visitante::where('grupo_viaje_id',$request->Id)->count();
        
        if ($encuestas > $request->PersonasEncuestadas) {
            array_push($errores["Total"],"La cantidad de personas encuestadas no debe ser menor que el número de encuestas ya realizadas.");
        }
    
        if ($encuestas > $request->Mayores15)
        {
            array_push($errores["Total"],"La cantidad de personas mayores de 15 años no debe ser menor que el número de encuestas ya realizadas.");
        }
        $date = Carbon::now();
        if(strtotime($request->Fecha) >  strtotime($date)){
            $errores["Fecha"][0] = "La fecha de aplicación no puede superar la fecha actual.";
        }
        
        if($errores["Total"] != null || sizeof($errores["Total"]) > 0 || $errores["Fecha"] != null || sizeof($errores["Fecha"]) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        $grupo = Grupo_Viaje::where('id',$request->id)->first();

        $grupo->fecha_aplicacion = $request->Fecha;
        $grupo->lugar_aplicacion_id = $request->Sitio;
        $grupo->tipo_viaje_id = $request->Tipo;
        $grupo->mayores_quince = $request->Mayores15;
        $grupo->menores_quince = $request->Menores15;
        $grupo->menores_quince_no_presentes = $request->Menores15No;
        $grupo->mayores_quince_no_presentes = $request->Mayores15No;
        $grupo->personas_magdalena = $request->PersonasMag;
        $grupo->personas_encuestadas = $request->PersonasEncuestadas;
        $grupo->user_update = $this->user->username;
        
        //return $request->all();
        
        $grupo->save();

        return ["success"=>true];
        }
}
