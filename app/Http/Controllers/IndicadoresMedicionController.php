<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Indicadores_medicion;
use App\Models\Tipos_grafica;
use App\Models\Idioma;
use App\Models\Indicadores_mediciones_idioma;
use App\Models\Tipo_Medicion_Indicador;
use Carbon\Carbon;



class IndicadoresMedicionController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        //$this->middleware('role:Admin');
        $this->middleware('permissions:list-indicadorMedicion|create-indicadorMedicion|edit-indicadorMedicion',['only' => ['getListado','getIndicadoresmedicion'] ]);
        $this->middleware('permissions:create-indicadorMedicion',['only' => ['postCrearindicador'] ]);
        $this->middleware('permissions:edit-indicadorMedicion',['only' => ['getInformacioneditar','postGuardarindicador'] ]);
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    public function getListado(){
        //return $this->user;
        return view('IndicadoresMedicion.ListadoIndicadoresMedicion');
    }
    public function getIndicadoresmedicion(){
        //return "si";
        $tiposGraficas = Tipos_grafica::get();
        $tiposMedicion = Tipo_Medicion_Indicador::where('estado',1)->get();
        //$idiomas = Idioma::where('estado',1)->get();
        
        $indicadores = Indicadores_medicion::
                                    with([ "tipoIndicador","graficas","idiomas"])
                                    ->orderBy('peso', 'asc')->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($indicadores);$i++){
            
            $indicadores[$i]["noIdiomas"] = [];
            $indicadores[$i]["tieneIdiomas"] = [];
            $idiomasConsultados = [];
            $tieneIdiomas = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($indicadores[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $indicadores[$i]->idiomas[$j]->idioma_id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }else{
                        array_push($tieneIdiomas, $idiomas[$k]);  
                    }
                }
            
            }
            $indicadores[$i]["noIdiomas"] = $idiomasConsultados;
            $indicadores[$i]["tieneIdiomas"] = $tieneIdiomas; 
        }                         
        return ["indicadores"=>$indicadores,"tiposGraficas"=>$tiposGraficas,"idiomas"=>$idiomas,"tiposMediciones"=>$tiposMedicion];
    }
    public function getInformacioneditar($id,$idioma_id){
        //return $idioma_id;
        $indicador = Indicadores_medicion::where('id',$id)
                                    ->with(["idiomas"=>function($q)use($idioma_id) { $q->where("idioma_id", $idioma_id)->orderBy('idioma_id', 'asc')->get(); } ])->first();
                                    
                                    
                               
        return ["indicador"=>$indicador];
    }
    public function postGuardarindicador(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'descripcion' => 'required',
            'id' => 'required|exists:indicadores_mediciones,id',
            'graficaPrincipal' => 'required|exists:tipos_graficas,id',
            'eje_x' => 'required',
            'eje_y' => 'required',
            'nombre' =>'required',
            'idioma_id'=> 'required|exists:idiomas,id',
            
        ],[
            'descripcion.required' => 'La descripción es requerida.',
            'nombre.required' => 'El nombre es requerido.',
            'idsGraficas.required' => 'Se debe seleccionar por lo menos un tipo de gráfica.',
            'graficaPrincipal.required' => 'Se debe seleccionar una gráfica principal.',
            'graficaPrincipal.exists' => 'El tipo de gráfica principal, no se encuentra registrada en el sistema.',
            'id.exists' => 'El indicador no se encuentra en la base de datos, favor recargar la página.',
            'idioma_id.required' => 'Es necesario seleccionar el idioma que desea editar.',
            'idioma_id.exists' => 'El idioma seleccionado no se encuentra en la base de datos, favor recargar la página.',
            'eje_x.required' => 'El valor para el eje x es requerido.',
            'eje_y.required' => 'El valor para el eje y es requerido.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if (!in_array($request->graficaPrincipal, $request->idsGraficas)) {
            return ["success"=>false,"errores"=>[["Se debe seleccionar en el listado, la gráfica principal."]]];
        }
        $indicadorIdioma = Indicadores_mediciones_idioma::where('indicadores_medicion_id',$request->id)->where('idioma_id',$request->idioma_id)->first();
        if($request->idioma_id == 1){
            if(sizeof($request->idsGraficas) == 0){
                return ["success"=>false,"errores"=>[["Se debe seleccionar por lo menos un tipo de gráfica."]]];
            }
            for($i=0;$i<sizeof($request->idsGraficas);$i++){
                if(Tipos_grafica::where('id',$request->idsGraficas[$i])->first() == null){
                    return ["success"=>false,"errores"=>[["Uno de los tipos de gráficas seleccionados no se encuentra en la base de datos."]]];
                }
            }
        }else if($indicadorIdioma == null){
            $indicadorIdioma = new Indicadores_mediciones_idioma();
            $indicadorIdioma->indicadores_medicion_id = $request->id;
            $indicadorIdioma->idioma_id = $request->idioma_id;
        }
        
        //$indicadorIdioma = Indicadores_mediciones_idioma::where('indicadores_medicion_id',$request->id)->where('idioma_id',$request->idioma_id)->first();
        $indicadorIdioma->descripcion = $request->descripcion;
        $indicadorIdioma->nombre = $request->nombre;
        $indicadorIdioma->eje_x = $request->eje_x;
        $indicadorIdioma->eje_y = $request->eje_y;
        $indicadorIdioma->save();
        
        if($request->idioma_id == 1){
            //return "si";
            $indicador = Indicadores_medicion::where('id',$request->id)->first();
            //return $request->formato;
            $indicador->formato = $request->formato;
            $indicador->save();
            $indicador->graficas()->detach();
            for($i=0;$i<sizeof($request->idsGraficas);$i++){
                if($request->idsGraficas[$i] == $request->graficaPrincipal){
                    $indicador->graficas()->attach($request->idsGraficas[$i],["es_principal"=>1]);
                }else{
                    $indicador->graficas()->attach($request->idsGraficas[$i]);
                }
            }
            
        }
        
        
        return ["success"=>true];
    }
    public function postCrearindicador(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'descripcion' => 'required',
            'idsGraficas' => 'required',
            'graficaPrincipal' => 'required|exists:tipos_graficas,id',
            'eje_x' => 'required',
            'eje_y' => 'required',
            'nombre' =>'required',
            
        ],[
            'descripcion.required' => 'La descripción es requerida.',
            'nombre.required' => 'El nombre es requerido.',
            'idsGraficas.required' => 'Se debe seleccionar por lo menos un tipo de gráfica.',
            'graficaPrincipal.required' => 'Se debe seleccionar una gráfica principal.',
            'graficaPrincipal.exists' => 'El tipo de gráfica principal, no se encuentra registrada en el sistema.',
            'eje_x.required' => 'El valor para el eje x es requerido.',
            'eje_y.required' => 'El valor para el eje y es requerido.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if (!in_array($request->graficaPrincipal, $request->idsGraficas)) {
            return ["success"=>false,"errores"=>[["Se debe seleccionar en el listado, la gráfica principal."]]];
        }
        for($i=0;$i<sizeof($request->idsGraficas);$i++){
            if(Tipos_grafica::where('id',$request->idsGraficas[$i])->first() == null){
                return ["success"=>false,"errores"=>[["Uno de los tipos de gráficas seleccionados no se encuentra en la base de datos."]]];
            }
        }
        
        $indicador = new Indicadores_medicion();
        $indicador->formato = $request->formato;
        $indicador->peso = 1;
        $indicador->tipo_medicion_indicador_id = $request->tipo_medicion_indicador_id;
        $indicador->estado = 1;
        $indicador->user_create = $this->user->username;
        $indicador->user_update = $this->user->username;
        $indicador->updated_at = Carbon::now();
        $indicador->created_at = Carbon::now();
        $indicador->save();
        for($i=0;$i<sizeof($request->idsGraficas);$i++){
            if($request->idsGraficas[$i] == $request->graficaPrincipal){
                $indicador->graficas()->attach($request->idsGraficas[$i],["es_principal"=>1]);
            }else{
                $indicador->graficas()->attach($request->idsGraficas[$i]);
            }
        }
        //$indicador->save();
            
        $indicadorIdioma = new Indicadores_mediciones_idioma();
        $indicadorIdioma->indicadores_medicion_id = $indicador->id;
        $indicadorIdioma->idioma_id = 1;
        $indicadorIdioma->descripcion = $request->descripcion;
        $indicadorIdioma->nombre = $request->nombre;
        $indicadorIdioma->eje_x = $request->eje_x;
        $indicadorIdioma->eje_y = $request->eje_y;
        $indicadorIdioma->save();
        
        return ["success"=>true];
    }
}
