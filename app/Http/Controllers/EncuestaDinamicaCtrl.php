<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\EncuestaDinamica\Encuestas_dinamica;
use App\Models\EncuestaDinamica\Encuestas_idioma;
use App\Models\EncuestaDinamica\Encuestas_usuario;
use App\Models\EncuestaDinamica\Secciones_encuesta;
use App\Models\EncuestaDinamica\Tipo_campo;
use App\Models\EncuestaDinamica\Idiomas_pregunta;
use App\Models\EncuestaDinamica\Pregunta;
use App\Models\EncuestaDinamica\Idiomas_opciones_pregunta;
use App\Models\EncuestaDinamica\Opciones_preguntas_encuestado;
use App\Models\EncuestaDinamica\Opciones_pregunta;
use App\Models\EncuestaDinamica\Respuesta_pregunta;
use App\Models\EncuestaDinamica\Estados_encuesta;
use App\Models\EncuestaDinamica\Estados_encuestas_usuario;
use App\Models\EncuestaDinamica\Idioma;
use App\Models\EncuestaDinamica\Opciones_sub_pregunta;
use App\Models\EncuestaDinamica\Idiomas_opciones_sub_pregunta;
use App\Models\EncuestaDinamica\Sub_pregunta;
use App\Models\EncuestaDinamica\Idiomas_sub_pregunta;
use App\Models\EncuestaDinamica\Opciones_sub_preguntas_encuestado;
use App\Models\EncuestaDinamica\Opciones_sub_preguntas_has_sub_pregunta;
use App\Models\EncuestaDinamica\Tipos_encuestas_dinamica;

use Excel;

class EncuestaDinamicaCtrl extends Controller
{
    
    /// listado administrativo de encuestas
    public function __construct()
    {
        
        $this->middleware('auth')->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        //$this->middleware('role:Admin')->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        /*
        $this->middleware('permissions:list-encuestaADHOC|create-encuestaADHOC|read-encuestaADHOC|edit-encuestaADHOC|estado-encuestaADHOC|duplicar-encuestaADHOC|descargarDatos-encuestaADHOC',
        ['only' => ['getListado','getListadoencuestasdinamicas'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:create-encuestaADHOC',['only' => ['postAgregarencuesta'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:edit-encuestaADHOC|read-encuestaADHOC',['only' => ['getConfigurar','getDataconfiguracion',
        'getListar','getListadoencuestas'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:edit-encuestaADHOC',['only' => ['postGuardaridiomaencuesta',
        'postAgregarseccion','postAgregarpregunta','postActivardesactivarpregunta','postEliminarpregunta','postGuardarordenpreguntas','postGuardaridiomapregunta',
        'postAgregaropcionpregunta','postEliminaropcionpregunta',
        'postDuplicarpregunta','DuplicarPregunta'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:estado-encuestaADHOC',['only' => ['postCambiarestadoencuesta'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:duplicar-encuestaADHOC',['only' => ['postDuplicarencuesta'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        
        $this->middleware('permissions:descargarDatos-encuestaADHOC',['only' => ['getExcel'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        
        $this->middleware('permissions:estadisticas-encuestaADHOC',['only' => ['getEstadisticas','getEstadisticasencuesta'] ])
        ->except([ 'anonimos','getRegistrodeusuarios', 'postRegistrousuarioencuesta', 'encuesta', 'postGuardarencuestausuarios', 'postDataseccionencuestausuarios']);
        */
        
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
  
    public function getListado(){ 
        return View("/EncuestaDinamica/listado"); 
    }
    
    // configuracion de encuestas : creación o edición
    public function getConfigurar($id){ 
        
        $encuesta = Encuestas_dinamica::find($id);
        
        if(!$encuesta){
            return "Error 404";
        }
        
        $puedeEditar = ($encuesta->estados_encuestas_id==1 || $encuesta->estados_encuestas_id==4) ? true : false;
        
        return View("/EncuestaDinamica/configurar", [ "id"=>$id, "puedeEditar"=>$puedeEditar ] ); 
    }
    
    ////listado de encuestas relaizadas por usuarios
    public function getListar($id){ 
        
        $encuesta = Encuestas_dinamica::find($id);
        
        if(!$encuesta){
            return "Error 404";
        }
        
        return View("/EncuestaDinamica/ListadoEncuestas", [ "id"=>$id ] ); 
    }
    
    ///////// get listado de encuestas llenas por usuarios
    public function getListadoencuestas($id, Request $request){ 
        
        $encuesta = Encuestas_dinamica::where("id", $id)->with([
                                                      "idiomas"=>function($q){ $q->where("idiomas_id",1); },
                                                      "encuestas"=>function($q){ $q->where("estado",true)->with("estado"); }
                                                    ] )->orderBy("id")->first();
        
        if(!$encuesta){
            return [ "success"=>false ];
        }
        
        
        return [ "success"=>true, "encuesta"=>$encuesta, "host"=> $request->getSchemeAndHttpHost() ];
    }
    
   ///listado de encuestas dinamicas
    public function getListadoencuestasdinamicas(Request $request){
        return  [ 
                    "encuestas"=> Encuestas_dinamica::where("estado",true)->orderBy("id","DES")->with([ "estado", "tipo", "idiomas"=>function($q){ $q->with("idioma"); }])->get(),
                    "idiomas"=> Idioma::get(),
                    "estados"=> Estados_encuesta::where("id","!=",1)->get(),
                    "tipos"=> Tipos_encuestas_dinamica::get(),
                    "host"=> $request->getSchemeAndHttpHost()
                ];
    }
    
    public function postAgregarencuesta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                        "nombre" => "required",
                        "tipos_encuestas_dinamica_id" => "required|exists:tipos_encuestas_dinamicas,id",
                    ],
                    [ 
                        "nombre.required"=> "El nombre es  requerido",
                        "tipos_encuestas_dinamica_id.required"=> "El campo tipo de encuesta es  requerido",
                        "tipos_encuestas_dinamica_id.exists"=> "El campo tipo de encuesta no existe en el sistema."
                        
                    ]
                );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $encuesta = new Encuestas_dinamica();
        $encuesta->estados_encuestas_id = 1;
        $encuesta->tipos_encuestas_dinamica_id = $request->tipos_encuestas_dinamica_id;
        $encuesta->estado = true;
        $encuesta->save();
        
        $idioma = new Encuestas_idioma();
        $idioma->estado = true;
        $idioma->nombre = $request->nombre;
        $idioma->descripcion = $request->descripcion;
        $idioma->encuestas_id = $encuesta->id;
        $idioma->idiomas_id = 1;
        $idioma->save();
        
        return [
                 "success"=>true, 
                 "data"=> Encuestas_dinamica::where([ ["id",$encuesta->id] ])->with([ "estado", "tipo","idiomas"=>function($q){ $q->with("idioma"); }])->first() 
                ];
                
    }
    
    /*
    public function activarDesactivarEncuesta(Request $request){
        
        $encuesta = Encuesta::find($request->id);
        
        if($encuesta){
            
            $encuesta->es_visible = !$encuesta->es_visible;
            $encuesta->save();
            
            return [ "success"=>true, "estado"=> $encuesta->es_visible ];
        }
             
        return [ "success"=> false ]; 
    }
    
    public function eliminarEncuesta(Request $request){
        
        $encuesta = Encuesta::find($request->id);
        
        if($encuesta){
            
            $encuesta->estado = false;
            $encuesta->save();
            
            return [ "success"=>true ];
        }
             
        return [ "success"=> false ]; 
    }
    */
    
    public function postCambiarestadoencuesta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "id" => "required|exists:encuestas_dinamicas,id",
                      "estado" => "required|exists:estados_encuestas,id",
                    ],
                    [
                        "id.required"=> "Error en los datos,la encuesta no existe",
                        "id.exists"=> "Error en los datos, la encuesta no existe",
                        "estado.required"=> "Error en los datos, el estado no existe",
                        "estado.exists"=> "Error en los datos, el estado no existe",
                    ]);
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $encuesta = Encuestas_dinamica::find($request->id);
        $encuesta->estados_encuestas_id = $request->estado;
        $encuesta->save();
        return [ "success"=>true, "estado"=> Estados_encuesta::find($request->estado) ];
    }
    
    public function postGuardaridiomaencuesta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "idEncuesta" => "required|exists:encuestas_dinamicas,id",
                      "idiomas_id" => "required|exists:idiomas,id",
                      "nombre" => "required"
                    ],
                    [
                        "idEncuesta.required"=> "Error en los datos,la encuesta no existe",
                        "idEncuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "idiomas_id.required"=> "Error en los datos, el idioma no existe",
                        "idiomas_id.exists"=> "Error en los datos, el idioma no existe",
                        "nombre.required"=> "El nombre es  requerido",
                    ]
                );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $idioma = Encuestas_idioma::find($request->id);
        
        if(!$idioma){
            $idioma = new Encuestas_idioma();
            $idioma->estado = true;
            $idioma->encuestas_id = $request->idEncuesta;
            $idioma->idiomas_id = $request->idiomas_id;
        }
        
        $idioma->nombre = $request->nombre;
        $idioma->descripcion = $request->descripcion;
        $idioma->save();
        
        return [
                 "success"=>true, 
                 "data"=> Encuestas_dinamica::where([ ["id",$request->idEncuesta]])->with(["estado","idiomas"=>function($q){ $q->with("idioma"); }])->first() 
                ];
    }
    
    
    
    public function getDataconfiguracion($id){
 
        return [ 
                    "idiomas"=> Idioma::get(),
                    "tiposCamos"=> Tipo_campo::get(),
                    "encuesta"=> $this->getDataEncuesta($id)
               ];
        
        
    }
    
    public function postAgregarseccion(Request $request){
        
        if( !Encuestas_dinamica::find($request->id) ){
            return [ "success"=> false ];
        }
        
        $seccion = new Secciones_encuesta();
        $seccion->encuestas_id = $request->id;
        $seccion->save();
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->id) ];
    }
    
    public function postAgregarpregunta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "idEncuesta" => "required|exists:encuestas_dinamicas,id",
                      "idSeccion" => "required|exists:secciones_encuestas,id",
                      "tipoCampo" => "required|exists:tipo_campos,id",
                      "esRequerido" => "required",
                      "pregunta" => "required",
                    ],
                    [
                        "idEncuesta.required"=> "Error en los datos,la encuesta no existe",
                        "idEncuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "idSeccion.required"=> "Error en los datos,la sección no existe",
                        "idSeccion.exists"=> "Error en los datos, la sección no existe",
                        "tipoCampo.required"=> "Error en los datos, el tipo de campo no existe",
                        "tipoCampo.exists"=> "Error en los datos, el tipo de campo no existe",
                        "esRequerido.required"=> "El campo esRequerido es requerido",
                        "pregunta.required"=> "La pregunta es requerida",
                    ]
                );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $pregunta = new Pregunta();
        $pregunta->secciones_encuestas_id = $request->idSeccion;
        $pregunta->tipo_campos_id = $request->tipoCampo;
        $pregunta->es_requerido = $request->esRequerido;
        $pregunta->max_length = $request->caracteres;
        $pregunta->valor_max = $request->maxNumero;
        $pregunta->valor_min = $request->minNumero;
        $pregunta->orden = 1000000;
        $pregunta->es_visible = true;
        $pregunta->estado = true;
        $pregunta->save();
        
        $pregunta_idioma = new Idiomas_pregunta();
        $pregunta_idioma->idiomas_id = 1;
        $pregunta_idioma->preguntas_id = $pregunta->id;
        $pregunta_idioma->pregunta = $request->pregunta;
        $pregunta_idioma->save();
        
        if($request->tipoCampo==3 || $request->tipoCampo==5 || $request->tipoCampo==6 || $request->tipoCampo==7 ){
               
            foreach($request->opciones as $item){   
                $opcion = new Opciones_pregunta();
                $opcion->preguntas_id = $pregunta->id;
                if( ($request->tipoCampo==3||$request->tipoCampo==7) && array_key_exists("otro", $item) ){ $opcion->es_otro = true; }
                $opcion->estado = true;
                $opcion->save();
                
                $opcion_idioma = new Idiomas_opciones_pregunta();
                $opcion_idioma->idiomas_id =1;
                $opcion_idioma->opciones_preguntas_id = $opcion->id;
                $opcion_idioma->nombre = $item["text"];
                $opcion_idioma->save();
            }
            
        }
        else if($request->tipoCampo==8 || $request->tipoCampo==9 || $request->tipoCampo==10 || $request->tipoCampo==11){
            
            $idsOpcions = [];
            
            foreach($request->opciones as $item){
                $opcion = new Opciones_sub_pregunta();
                $opcion->preguntas_id = $pregunta->id;
                $opcion->estado = true;
                $opcion->save();
                
                $opcion_idioma = new Idiomas_opciones_sub_pregunta();
                $opcion_idioma->idiomas_id =1;
                $opcion_idioma->opciones_sub_preguntas_id = $opcion->id;
                $opcion_idioma->nombre = $item["text"];
                $opcion_idioma->save();
                
                array_push($idsOpcions, $opcion->id);
            }
            
            foreach($request->subPreguntas as $item){
            
                $subPregunta = new Sub_pregunta();
                $subPregunta->preguntas_id = $pregunta->id;
                $subPregunta->estado = true;
                $subPregunta->save();
                
                $opcion_idioma = new Idiomas_sub_pregunta();
                $opcion_idioma->idiomas_id =1;
                $opcion_idioma->sub_preguntas_id = $subPregunta->id;
                $opcion_idioma->nombre = $item;
                $opcion_idioma->save();
                
                foreach($idsOpcions as $id){
                   $Opcion_Pregunta = new Opciones_sub_preguntas_has_sub_pregunta();
                   $Opcion_Pregunta->opciones_sub_preguntas_id = $id;
                   $Opcion_Pregunta->sub_preguntas_id = $subPregunta->id;
                   $Opcion_Pregunta->save();
                }
            }
            
        }
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->idEncuesta) ];
    }
    
    public function postActivardesactivarpregunta(Request $request){
        
        $pregunta = Pregunta::find($request->id);
        
        if($pregunta){
            
            $pregunta->es_visible = !$pregunta->es_visible;
            $pregunta->save();
            
            return [ "success"=>true, "estado"=> $pregunta->es_visible ];
        }
             
        return [ "success"=> false ]; 
    }
    
    public function postEliminarpregunta(Request $request){
        
        $pregunta = Pregunta::find($request->id);
        
        if($pregunta){
            
            $pregunta->estado = false;
            $pregunta->save();
            
            return [ "success"=>true ];
        }
             
        return [ "success"=> false ]; 
    }
    
    public function postGuardarordenpreguntas(Request $request){
        
        $validate = \ Validator::make($request->all(),
                                [ "preguntas.*" => "required|exists:preguntas,id" ],
                                [ "preguntas.required"=> "Las preguntas son requeridas",
                                  "preguntas.*.exists"=> "La pregunta no existe" ] );
            
        if ($validate->fails()){
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $index = 1;
        foreach($request->preguntas as $id){
            $pregunta = Pregunta::where([ ["id",$id],["estado",true], ["secciones_encuestas_id",$request->idSeccion] ])->update(['orden' => $index]);
            $index++;
        }
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->idEncuesta) ];
    }
    
    public function postGuardaridiomapregunta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "idEncuesta" => "required|exists:encuestas_dinamicas,id",
                      "idioma" => "required|exists:idiomas,id"
                    ],
                    [
                        "idEncuesta.required"=> "Error en los datos,la encuesta no existe",
                        "idEncuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "idioma.required"=> "Error en los datos, el idioma no existe",
                        "idioma.exists"=> "Error en los datos, el idioma no existe",
                    ]
                );
            
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $pregunta_idioma = Idiomas_pregunta::find($request->idIdiomaPregunta);
        
        if(!$pregunta_idioma){
            $pregunta_idioma = new Idiomas_pregunta();
            $pregunta_idioma->idiomas_id = $request->idioma;
            $pregunta_idioma->preguntas_id = $request->idPregunta;
        }
        
        $pregunta_idioma->pregunta = $request->pregunta;
        $pregunta_idioma->save();
        
        if($request->tipoCampo==3 || $request->tipoCampo==5 || $request->tipoCampo==6 || $request->tipoCampo==7){
            
            foreach($request->opciones as $item){   
                
                $opcion_idioma = null;
                
                if( array_key_exists( "id", $item) ){
                    $opcion_idioma = Idiomas_opciones_pregunta::find($item["id"]);
                }
                
                if(!$opcion_idioma){
                    $opcion_idioma = new Idiomas_opciones_pregunta();
                    $opcion_idioma->idiomas_id = $request->idioma;
                    $opcion_idioma->opciones_preguntas_id = $item["idOpcion"];
                }
                
                $opcion_idioma->nombre = $item["texto"];
                $opcion_idioma->save();
            }
        }
        else if($request->tipoCampo==8 || $request->tipoCampo==9){
            
            foreach($request->opcionesSubPreguntas as $item){
                $opc_sub_pregunta_idioma = null;
                
                if( array_key_exists( "id", $item) ){
                    $opc_sub_pregunta_idioma = Idiomas_opciones_sub_pregunta::find($item["id"]);
                }
                
                if(!$opc_sub_pregunta_idioma){
                    $opc_sub_pregunta_idioma = new Idiomas_opciones_sub_pregunta();
                    $opc_sub_pregunta_idioma->idiomas_id = $request->idioma;
                    $opc_sub_pregunta_idioma->opciones_sub_preguntas_id = $item["idOpcionSubPregunta"];
                }
                
                $opc_sub_pregunta_idioma->nombre = $item["texto"];
                $opc_sub_pregunta_idioma->save();
            }
            
            foreach($request->subPreguntas as $item){
            
                $sub_pregunta_idioma = null;
                
                if( array_key_exists( "id", $item) ){
                    $sub_pregunta_idioma = Idiomas_sub_pregunta::find($item["id"]);
                }
                
                if(!$sub_pregunta_idioma){
                    $sub_pregunta_idioma = new Idiomas_sub_pregunta();
                    $sub_pregunta_idioma->idiomas_id = $request->idioma;
                    $sub_pregunta_idioma->sub_preguntas_id = $item["idSubPregunta"];
                }
                
                $sub_pregunta_idioma->nombre = $item["texto"];
                $sub_pregunta_idioma->save();
            }
            
        }
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->idEncuesta) ];
    }
    
    public function postAgregaropcionpregunta(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "idEncuesta" => "required|exists:encuestas_dinamicas,id",
                      "idPregunta" => "required|exists:preguntas,id"
                    ],
                    [
                        "idEncuesta.required"=> "Error en los datos,la encuesta no existe",
                        "idEncuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "idPregunta.required"=> "Error en los datos, la pregunta no existe",
                        "idPregunta.exists"=> "Error en los datos, la pregunta no existe",
                    ]
                );
        
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $opcion = new Opciones_pregunta();
        $opcion->preguntas_id = $request->idPregunta;
        $opcion->estado = true;
        $opcion->save();
        
        foreach($request->idiomas as $item){   
            $opcion_idioma = new Idiomas_opciones_pregunta();
            $opcion_idioma->idiomas_id = $item["id"];
            $opcion_idioma->opciones_preguntas_id = $opcion->id;
            $opcion_idioma->nombre = $item["opcion"];
            $opcion_idioma->save();
        }
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->idEncuesta) ];
    }
    
    public function postEliminaropcionpregunta(Request $request){
        
        $opcion = Opciones_pregunta::find($request->id);
        
        if($opcion){
            
            $opcion->estado = false;
            $opcion->save();
            
            return [ "success"=>true ];
        }
             
        return [ "success"=> false ]; 
        
    }
    
    private function getDataencuesta($id){
        
        return Encuestas_dinamica::where([ ["id",$id], ["estado",true] ])
                       ->with( [ "secciones"=>function($q){ 
                                            $q->with([ "preguntas"=>function($qr){
                                                    $qr->with( [  "tipoCampo", "idiomas"=>function($qrr){  $qrr->with("idioma"); } ,
                                                                  "opciones"=>function($qrr){ $qrr->with("idiomas")->where("estado",true); },
                                                                  "subPreguntas"=>function($qrr){ $qrr->with("idiomas")->where("estado",true); },
                                                                  "OpcionesSubPreguntas"=>function($qrr){ $qrr->with("idiomas")->where("estado",true); },
                                                             ] )->where("estado",true)->orderBy('orden'); },
                                                                  
                                                 ] ); 
                                            },
                                            "idiomas"=>function($q){ $q->where("idiomas_id",1); }
                            ] )->first();
        
    }
    
    
    ///////////// generación de estadisticas de las encuestas ////////////
    
    public function getEstadisticas($id){
        
        $data = [
           "encuesta"=> Encuestas_dinamica::where([ ["id",$id], ["estado",true] ])
                                           ->with( [ "secciones"=>function($q){ 
                                                          $q->with([ "preguntas"=>function($qr){ 
                                                                    $qr->where([["es_visible",true],["estado",true]])->whereNotIn( "tipo_campos_id",[1,2,4])
                                                                       ->with( [ 
                                                                            "idiomas"=> function($qrr){ $qrr->where("idiomas_id",1)->select("id","preguntas_id","idiomas_id","pregunta"); }
                                                                        ] )->select("id","secciones_encuestas_id", "tipo_campos_id")->orderBy('orden'); 
                                                          }])->select("id","encuestas_id");
                                                     },
                                                     "idiomas"=> function($qr){ $qr->where("idiomas_id",1)->select("id","encuestas_id","idiomas_id","nombre","descripcion"); }
                                              ] )->first(),
            "terminadas"=>   Encuestas_usuario::where([ ["estado",true], ["encuestas_id",$id], ["estados_encuestas_usuarios_id",3], ["estado",true] ])->count(),
            "noTerminadas"=> Encuestas_usuario::where([ ["estado",true], ["encuestas_id",$id], ["estados_encuestas_usuarios_id","!=",3], ["estado",true] ])->count(),
        ];
        
        return View("/EncuestaDinamica/estadisticas", $data );
    }
    
    public function getEstadisticasencuesta($id){
        
        $pregunta = Pregunta::find($id);
        $titulo = $pregunta->idiomas()->where("idiomas_id",1)->pluck("pregunta")->first(); 
        $labels = [];
        $series = [];
        $data = [];
        
        if($pregunta->tipo_campos_id==8 || $pregunta->tipo_campos_id==9){
            $series = Sub_pregunta::where("preguntas_id",$id)->join("idiomas_sub_preguntas", "sub_preguntas.id","=","sub_preguntas_id")->select("sub_preguntas.id","nombre")->get();
            $labels = Opciones_sub_pregunta::where("preguntas_id",$id)->join("idiomas_opciones_sub_preguntas", "opciones_sub_preguntas.id","=","opciones_sub_preguntas_id")->select("opciones_sub_preguntas.id","nombre")->get();
           
            foreach($series as $subP){
                $res = [];
                foreach($labels as $opcion){
                    $nun = Opciones_sub_preguntas_has_sub_pregunta::where([ ["sub_preguntas_id",$subP->id],["opciones_sub_preguntas_id",$opcion->id],["estados_encuestas_usuarios_id",3] ])->
                                join("opciones_sub_preguntas_encuestados","opciones_sub_preguntas_has_sub_preguntas.id","=","opciones_sub_preguntas_has_sub_preguntas_id")->
                                join("encuestas_usuarios", function($q){$q->on("encuestas_usuarios.id","=","encuestas_usuarios_id")->where('encuestas_usuarios.estado','=',true);} )
                                ->groupBy('encuestas_usuarios_id')->count();
                    
                    array_push( $res,$nun); 
                }
                array_push($data, $res );
            }
            $labels = $labels->lists('nombre')->toArray();
            $series = $series->lists('nombre')->toArray();
            
        }
        else{
            
            $ids = Opciones_pregunta::where([ ["preguntas_id",$id],["estado",true] ])->lists('id')->toArray();
            
            foreach($ids as $id){
                array_push($labels, Idiomas_opciones_pregunta::where([ ["opciones_preguntas_id",$id],["idiomas_id",1] ])->pluck("nombre")->first() ); 
                $nun =  Opciones_preguntas_encuestado::where([ ["opciones_preguntas_id",$id],["estados_encuestas_usuarios_id",3] ])
                                                     ->join("encuestas_usuarios", function($q){$q->on("encuestas_usuarios.id","=","encuestado_id")->where('encuestas_usuarios.estado','=',true);} )
                          ->count();
                array_push($data,  $nun ); 
            }
            
        }
        
         
        return [ "labels"=>$labels, "data"=>$data, "series"=>$series, "titulo"=>$titulo ];
    }
    
    
    //////////// Encuesta dinamica para usuarios ///////////////////////7
    
    public function encuesta($codigo, Request $request){
        //, ["estados_encuestas_usuarios_id","!=",3]
        $encuesta = Encuestas_usuario::where([ ["codigo", $codigo ] ])->first();
        //return $encuesta;
        if($encuesta){
           
            $secciones = Secciones_encuesta::where("encuestas_id", $encuesta->encuestas_id )->orderby("id")->lists('id')->toArray();
            $seccion =   $secciones[0];
            $atras = null;
            $index = 0;
            
            if($request->seccion){
                $index = array_search($request->seccion,$secciones);
                if($index>0){
                   $seccion = $request->seccion;
                   $atras =   $secciones[$index-1];
                }
            }
            else if($encuesta->ultima_seccion!=0){
                $index = array_search($encuesta->ultima_seccion,$secciones);
                if($index>0){
                   $seccion = $encuesta->ultima_seccion;
                   $atras =   $secciones[$index-1];
                }
            }
        
            $data = [ 
                  "codigo"=>$encuesta->codigo,
                  "idEncuesta"=>$encuesta->id,
                  "idSeccion"=>$seccion, 
                  "atras"=>$atras, 
                  "porcentaje"=>(round( 100/count($secciones) )*$index),
                  "nunSeccion"=> $index+1
                ];

            return View("/EncuestaDinamica/encuesta", $data ); 
            
                 
        }
        
        return "Error la encuesta no existe";
    }
    
    public function postGuardarencuestausuarios(Request $request){
        
        $validar = $this->vailidarGuardado($request);
        if(!$validar["success"]){
            return $validar;
        }
        
        $encuesta = Encuestas_usuario::where([ ["id",$request->idEncuesta] ])->first();
        
        if($encuesta){
            foreach($request->preguntas as $pregunta){
                
                if($pregunta["respuesta"]){
                
                    if( $pregunta["tipo_campos_id"]==1 || $pregunta["tipo_campos_id"]==2 || $pregunta["tipo_campos_id"]==4 || $pregunta["tipo_campos_id"]==12){
                        Respuesta_pregunta::updateOrCreate(
                                                            [ "encuestado_id"=> $encuesta->id , "preguntas_id"=> $pregunta["id"] ], 
                                                            [ "estado"=>true, "respuesta"=>$pregunta["respuesta"] ]
                                                          );
                    }
                    
                    else if( $pregunta["tipo_campos_id"]==8 || $pregunta["tipo_campos_id"]==9 ){
                        foreach($pregunta["sub_preguntas"] as $subPregunta){
                            //$encuesta->opcionesRespuestasSubPreguntas()->where("sub_preguntas_id", $subPregunta["id"])->detach();
                            
                            foreach(Opciones_sub_preguntas_has_sub_pregunta::where("sub_preguntas_id",$subPregunta["id"])->get() as $item){
                                $item->opcionesRespuestas()->wherePivot('encuestas_usuarios_id', $encuesta->id)->detach();
                            }
                            
                            $encuesta->opcionesRespuestasSubPreguntas()->attach( $subPregunta["respuesta"] );
                        }
                    }
                    
                    else if( $pregunta["tipo_campos_id"]==10 || $pregunta["tipo_campos_id"]==11 ){
                        
                        foreach($pregunta["sub_preguntas"] as $subPregunta){
                            
                            foreach(Opciones_sub_preguntas_has_sub_pregunta::where("sub_preguntas_id",$subPregunta["id"])->get() as $item){
                                $item->opcionesRespuestas()->wherePivot('encuestas_usuarios_id', $encuesta->id)->detach();
                            }
                           
                            foreach($subPregunta["opciones"] as $item){  
                                $encuesta->opcionesRespuestasSubPreguntas()->attach( $item["id"], [ "respuesta"=> $item["respuesta"] ] );
                            }
                            
                        }
                    }
                    
                    else{
                        //$encuesta->opcionesRespuestas()->where("preguntas_id", $pregunta["id"])->detach();
                        
                        $idOtro = null;
                        
                        foreach(Opciones_pregunta::where("preguntas_id",$pregunta["id"])->get() as $item){
                            $item->opcionesRespuestas()->wherePivot('encuestado_id', $encuesta->id)->detach();
                            $idOtro = $item->es_otro==true ? $item->id : -1;
                        }
                        
                        $encuesta->opcionesRespuestas()->attach( $pregunta["respuesta"] );
                        
                        if( ($pregunta["tipo_campos_id"]==3 || $pregunta["tipo_campos_id"]==7) && $idOtro!=-1 ){
                            $opcionOtro = Opciones_preguntas_encuestado::where([ ['encuestado_id', $encuesta->id],['opciones_preguntas_id',$idOtro] ])->update(['otro'=> $pregunta["otro"]]);
                        }
                        
                    }
                }
            }
            
            $secciones = Secciones_encuesta::where("encuestas_id", $encuesta->encuestas_id )->lists('id')->toArray();
            
            $index = array_search( $request->id, $secciones );
            $seccion = ($index+1) < count($secciones) ? $secciones[$index+1] : null;
            
            $ruta = $seccion==null ?  "/" :  "/encuestaAdHoc/" . $encuesta->codigo . "?seccion=".$seccion;
            $termino = $seccion==null ? true: false;
            
            if($seccion!=null){
                $encuesta->ultima_seccion = $secciones[ $index==0 ? 0 : $index-1 ];
                $encuesta->estados_encuestas_usuarios_id = 2;
                $encuesta->save();
            }
            else{
                $encuesta->ultima_seccion = $secciones[count($secciones)-1];
                $encuesta->estados_encuestas_usuarios_id = 3;
                $encuesta->save();
            }
        
            return [ "success"=>true, "ruta"=>$ruta, "termino"=>$termino ];
        }
        return ["success"=>false];
    }
    
    public function postDataseccionencuestausuarios(Request $request){
        
        $encuesta = Encuestas_usuario::with("encuesta")->where([ ["id",$request->idEncuesta] ])->first();
        
        if($encuesta){
            $idIdioma = 1;
            $idEncuestado = $encuesta->id;
            $idEncuesta = $encuesta->encuestas_id;
            $idSeccion = $request->idSeccion;
            
            $seccion = Secciones_encuesta::where("id",$idSeccion)
                                         ->with([ "preguntas"=>function($qr) use ($idIdioma){
                                                   $qr->where([ ["es_visible",true], ["estado",true] ])
                                                      ->with( [ 
                                                               "idiomas"=> function($qrr) use ($idIdioma) { $qrr->where("idiomas_id",$idIdioma)->select("id","preguntas_id","idiomas_id","pregunta"); }, 
                                                               "opciones"=>function($qrr) use ($idIdioma) { 
                                                                                $qrr->with([ 
                                                                                           "idiomas"=> function($qrrr) use ($idIdioma) { 
                                                                                                            $qrrr->where("idiomas_id",$idIdioma)->select("id","opciones_preguntas_id","nombre"); 
                                                                                                        }
                                                                                        ])->select("id","preguntas_id","es_otro");
                                                                            },
                                                                "subPreguntas"=>function($qrr) use ($idIdioma) { 
                                                                                $qrr->with(["opciones", 
                                                                                            "idiomas"=> function($qrrr) use ($idIdioma) { 
                                                                                                            $qrrr->where("idiomas_id",$idIdioma)->select("id","sub_preguntas_id","nombre");
                                                                                                        }
                                                                                        ])->select("id","preguntas_id");
                                                                            },
                                                                "OpcionesSubPreguntas"=>function($qrr) use ($idIdioma) { 
                                                                                $qrr->with([ 
                                                                                           "idiomas"=> function($qrrr) use ($idIdioma) { 
                                                                                                            $qrrr->where("idiomas_id",$idIdioma)->select("id","opciones_sub_preguntas_id","nombre"); 
                                                                                                        }
                                                                                        ])->select("id","preguntas_id");
                                                                            },
                                                            
                                                            ])->select("id","secciones_encuestas_id","tipo_campos_id","es_requerido","valor_max","valor_min","max_length")
                                                               ->orderBy('orden');   
                                               }])->select("id","encuestas_id")->first(); 
                                               
            foreach($seccion->preguntas as $pregunta){
                
                if( $pregunta->tipo_campos_id==1 || $pregunta->tipo_campos_id==2 || $pregunta->tipo_campos_id==4 || $pregunta->tipo_campos_id==12 ){
                    $pregunta["respuesta"] =  Respuesta_pregunta::where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado] ])->pluck("respuesta")->first();
                    
                    $pregunta["respuesta"] = ( $pregunta->tipo_campos_id==2 && $pregunta["respuesta"] ) ? intval($pregunta["respuesta"]) : $pregunta["respuesta"];
                }
                else if($pregunta->tipo_campos_id==3 || $pregunta->tipo_campos_id==5){
                    $pregunta["respuesta"] =  Opciones_preguntas_encuestado::join("opciones_preguntas","opciones_preguntas_id", "=" ,"opciones_preguntas.id")
                                                                           ->where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado]  ])->pluck("id")->first();
                }
                else if($pregunta->tipo_campos_id==6 || $pregunta->tipo_campos_id==7){
                    $pregunta["respuesta"] =  Opciones_preguntas_encuestado::join("opciones_preguntas","opciones_preguntas_id", "=", "opciones_preguntas.id")
                                                                           ->where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado]  ])->lists('id')->toArray();
                }
                
                else if($pregunta->tipo_campos_id==8){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        $subPregunta["respuesta"] = Opciones_sub_preguntas_encuestado::join("opciones_sub_preguntas_has_sub_preguntas","opciones_sub_preguntas_has_sub_preguntas_id", "=" ,"opciones_sub_preguntas_has_sub_preguntas.id")
                                                                           ->where([ ["sub_preguntas_id",$subPregunta->id], ["encuestas_usuarios_id",$idEncuestado]  ])->pluck("id")->first();
                    }
                }
                else if($pregunta->tipo_campos_id==9){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        $subPregunta["respuesta"] = Opciones_sub_preguntas_encuestado::join("opciones_sub_preguntas_has_sub_preguntas","opciones_sub_preguntas_has_sub_preguntas_id", "=" ,"opciones_sub_preguntas_has_sub_preguntas.id")
                                                                           ->where([ ["sub_preguntas_id",$subPregunta->id], ["encuestas_usuarios_id",$idEncuestado]  ])->lists('id')->toArray();
                    }
                }
                else if($pregunta->tipo_campos_id==10){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        foreach($subPregunta->opciones as $opcion){
                        
                            $opcion["respuesta"] = Opciones_sub_preguntas_encuestado::
                                                        where([ ["opciones_sub_preguntas_has_sub_preguntas_id",$opcion->id], ["encuestas_usuarios_id",$idEncuestado] ])->pluck("respuesta")->first();
                            $opcion["respuesta"] = $opcion["respuesta"] ? intval( $opcion["respuesta"] ) : null;
                            
                        }
                    }
                }
                else if($pregunta->tipo_campos_id==11){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        foreach($subPregunta->opciones as $opcion){
                        
                            $opcion["respuesta"] = Opciones_sub_preguntas_encuestado::
                                                        where([ ["opciones_sub_preguntas_has_sub_preguntas_id",$opcion->id], ["encuestas_usuarios_id",$idEncuestado] ])->pluck("respuesta")->first();
                        }
                    }
                }
                
                
                
                if($pregunta->tipo_campos_id==3 || $pregunta->tipo_campos_id==7){
                    $pregunta["otro"] =  Opciones_preguntas_encuestado::join("opciones_preguntas","opciones_preguntas_id", "=" ,"opciones_preguntas.id")
                                                                      ->where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado], ["es_otro",true] ])
                                                                      ->pluck("otro")->first();
                }
                
                
            }                              
            
            
            
            $seccion["encuesta"] = Encuestas_dinamica::where("id", $encuesta->encuestas_id)
                                           ->with([ "idiomas"=>function($q) use($idIdioma) { $q->where("idiomas_id",$idIdioma); }])->first();
                                                   
            return $seccion;
        }
        
    }
    
    private function vailidarGuardado(Request $request){
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "idEncuesta" => "required|exists:encuestas_usuarios,id",
                      "encuestas_id" => "required|exists:encuestas_dinamicas,id",
                      "id" => "required|exists:secciones_encuestas,id",
                      "preguntas" => "required|array",
                      "preguntas.*.id" => "required|exists:preguntas,id",
                      "preguntas.*.tipo_campos_id" => "required|exists:tipo_campos,id",
                    ],
                    [
                        "idEncuesta.required"=> "Error en los datos, los datos an sido alterados",
                        "idEncuesta.required"=> "Error en los datos, los datos an sido alterados",
                        "encuestas_id.required"=> "Error en los datos, la encuesta no existe no existe",
                        "encuestas_id.exists"=> "Error en los datos, la encuesta existe",
                        "preguntas.required"=> "Error en los datos, no existen preguntas",
                        "preguntas.array"=> "Error en los datos, no existen preguntas",
                        "preguntas.*.id.required"=> "Error en los datos, la pregunta no existe",
                        "preguntas.*.id.exists"=> "Error en los datos, la pregunta no existe",
                        "preguntas.*.tipo_campos_id.required"=> "Error en los datos, el tipo de campo no existe",
                        "preguntas.*.tipo_campos_id.exists"=> "Error en los datos, el tipo de campoa no existe",
                    ]
                );
        
        $errores = [];
        $estadoValidacion = true;
        
        if ($validate->fails())
        {
            $error = json_decode($validate->errors(),true);
            $errores = array_merge($errores, $error);
            $estadoValidacion = false;
        }
        
        
        foreach($request->preguntas as $pregunta){
          
            $validaciones = $this->getValidaciones( $pregunta["id"], $pregunta["idiomas"][0]["pregunta"] );
            
            $validate = \ Validator::make( $pregunta , $validaciones[0], $validaciones[1]);
            if ($validate->fails())
            {
                $error = json_decode($validate->errors(),true);
                $errores = array_merge($errores, $error);
                $estadoValidacion = false;
            }
            
        }
        
        if(!$estadoValidacion){
            return [ "success"=>false, "errores"=>$errores ];
        }
        
    
        return [ "success"=>true ];
        
    }
    
    
    private function getValidaciones( $id, $pregunta ){
        
        $preg = Pregunta::find($id);
        
        $validaciones =  $preg->es_requerido ? [  
                                                 ["respuesta"=>"required|"],
                                                 ["respuesta.required"=> "$pregunta: es requerida."]  
                                                ] 
                                                : [ ["respuesta"=>""], []  ];
        
        switch ($preg->tipo_campos_id){
            
            case 1:   
                    $validaciones[0]["respuesta"] .=  "max:" . $preg->max_length;
                    $validaciones[1]["respuesta.max"] =  "$pregunta, en número maximo de caracteres es " . $preg->max_length . ".";
                    break;
                    
            case 2:   
                    $validaciones[0]["respuesta"] .=  "min:" .$preg->valor_min. "|max:" . $preg->valor_max . "|numeric";
                    $validaciones[1]["respuesta.min"] =  "$pregunta, el número minimo es " . $preg->valor_min . ".";
                    $validaciones[1]["respuesta.max"] =  "$pregunta, el número maximo es " . $preg->valor_max . ".";
                    break;
            
            case 3:        
            case 5:   
                    $validaciones[0]["respuesta"] .=  "exists:opciones_preguntas,id";
                    $validaciones[1]["respuesta.exists"] =  "$pregunta, la respuesta que intentas guardar no existe en el sistema.";
                    break;
            
            case  4:  
                    $validaciones[0]["respuesta"] .=  "date";
                    $validaciones[1]["respuesta.date"] =  "$pregunta, formato de fecha invalida.";
                    break;        
            case 6:            
            case 7: 
                    $validaciones[0]["respuesta"] .=  "array|min:1";
                    $validaciones[1]["respuesta.array"] = "$pregunta, formato de respuesta invalido.";
                    $validaciones[1]["respuesta.min"] = "$pregunta, es requerido.";
                    
                    $validaciones[0]["respuesta.*"] = "exists:opciones_preguntas,id";
                    $validaciones[1]["respuesta.*.exists"] = "$pregunta, la opción ingresada no existe.";
                    break;    
            
            case 8:   
                    $validaciones[0]["respuesta"] = "";
                    $validaciones[0]["sub_preguntas.*.respuesta"] = ( $preg->es_requerido ? "required|" : "" ) . "exists:opciones_sub_preguntas_has_sub_preguntas,id";
                    $validaciones[1]["sub_preguntas.*.respuesta.required"] = "$pregunta, es requerida.";
                    $validaciones[1]["sub_preguntas.*.respuesta.exists"] = "$pregunta, la opción no existe en el sistema.";
                    break;
            case 9:  
                    $validaciones[0]["respuesta"] = "";
                    $validaciones[0]["sub_preguntas.*.respuesta.*"] = ( $preg->es_requerido ? "required|" : "" ) . "exists:opciones_sub_preguntas_has_sub_preguntas,id";
                    $validaciones[1]["sub_preguntas.*.respuesta.*.required"] = "$pregunta, es requerida.";
                    $validaciones[1]["sub_preguntas.*.respuesta.*.exists"] = "$pregunta, la opción no existe en el sistema.";
                    break;
             
            case 10:
                    $validaciones[0]["respuesta"] = "";
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*"] = ($preg->es_requerido ? "required|" : "") . "integer|min:" .$preg->valor_min. "|max:" . $preg->valor_max;
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*.required"] = "$pregunta, todos los campos son requeridos.";
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*.min"] =  "$pregunta, en número minimo es " . $preg->valor_min . ".";
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*.max"] =  "$pregunta, en número maximo es " . $preg->valor_max . ".";
                break;
            
            case 11:
                    $validaciones[0]["respuesta"] = "";
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*"] = $preg->es_requerido ? "required" : "";
                    $validaciones[0]["sub_preguntas.*.opciones.*.respuesta.*.required"] = "$pregunta, todos los campos son requeridos.";
                break;
                
                
                    
            case 12:   
                    $validaciones[0]["respuesta"] .=  "email";
                    $validaciones[1]["respuesta.date"] =  "$pregunta, formato de email invalido.";
                    break;  
            
        }
        
        return $validaciones;
    }
    
    
    
    //////////////////////////////  anonimos /////////////////////////////////////////////
    
    public function anonimos($idEncuesta){
        
        $encuesta = Encuestas_dinamica::where([ ["id",$idEncuesta ], ["estados_encuestas_id",4 ], ["estado",true] ])->first();
        $estado = true;
        
        if(!$encuesta){
            $encuesta = Encuestas_dinamica::where([ ["id",$idEncuesta ], ["tipos_encuestas_dinamica_id",1], ["estados_encuestas_id",2 ], ["estado",true] ])->first();
            $estado = false;
        }
        
        if($encuesta){
            $usuario = new Encuestas_usuario();
            $usuario->encuestas_id = $encuesta->id;
            $usuario->estados_encuestas_usuarios_id = 1;
            $usuario->nombres = "ANONIMO";
            $usuario->apellidos = "";
            $usuario->ultima_seccion = 0;
            $usuario->codigo = $this->generarCodigo();
            $usuario->estado = !$estado;
            $usuario->save();
            
            $ruta = "/encuestaAdHoc/" . $usuario->codigo;
            
            return redirect($ruta);
        }
        
        return "La encuesta no existe";
    }
    
    ////////////////////////////  Registro de usuarios a encuestas ///////////////////////////
    
    
    public function getRegistrodeusuarios($encuesta){ 
        
        $idIdioma = 1;
        
        $encuesta = Encuestas_dinamica::where([ ["id",$encuesta], ["tipos_encuestas_dinamica_id",2], ["estado",true] ])
                            ->with(["idiomas"=>function($q) use($idIdioma) { $q->where("idiomas_id",$idIdioma); } ])
                            ->first();
        
        if(!$encuesta){ return "Error encuesta no encontrada"; }
        
        return View("/EncuestaDinamica/registroDeUSuarios", [ "encuesta"=>$encuesta ]); 
    }
    
    public function postRegistrousuarioencuesta(Request $request){
        
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "encuesta" => "required|exists:encuestas_dinamicas,id",
                      "nombres" => "required|max:120",
                      "apellidos" => "required|max:120",
                      "email" => "email|max:120",
                      "telefono" => "max:120",
                    ],
                    [
                        "encuesta.required"=> "Error en los datos,la encuesta no existe",
                        "encuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "nombres.required"=> "El campo nombre es requerido",
                        "nombres.max"=> "El campo nombre supera los 120 caracteres",
                        "apellidos.required"=> "El campo apellidos es requerido",
                        "apellidos.max"=> "El campo apellidos supera los 120 caracteres",
                        "email.required"=> "El campo nombre es requerido",
                        "email.email"=> "El formato para el campo correo electronico, no es valido",
                        "email.max"=> "El campo email supera los 120 caracteres",
                        "telefono.max"=> "El campo apellidos supera los 120 caracteres",
                    ]
                );
        
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $encuesta = Encuestas_dinamica::where([ ["id",$request->encuesta ],["estado",true] ])->first();
        
        $usuario = new Encuestas_usuario();
        $usuario->encuestas_id = $encuesta->id;
        $usuario->estados_encuestas_usuarios_id = 1;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->ultima_seccion = 0;
        $usuario->codigo = $this->generarCodigo();
        $usuario->estado = true;
        $usuario->save();
        
        $ruta = "/encuestaAdHoc/" . $usuario->codigo;
        
        return [ "success"=>true , "ruta"=>$ruta ];
    }
    
    public function postAgregarencuestausuario(Request $request){
        
        
        $validate = \ Validator::make($request->all(),
                    [ 
                      "encuesta" => "required|exists:encuestas_dinamicas,id",
                      "nombres" => "required|max:120",
                      "apellidos" => "required|max:120",
                      "email" => "email|max:120",
                      "telefono" => "max:120",
                    ],
                    [
                        "encuesta.required"=> "Error en los datos,la encuesta no existe",
                        "encuesta.exists"=> "Error en los datos, la encuesta no existe",
                        "nombres.required"=> "El campo nombre es requerido",
                        "nombres.max"=> "El campo nombre supera los 120 caracteres",
                        "apellidos.required"=> "El campo apellidos es requerido",
                        "apellidos.max"=> "El campo apellidos supera los 120 caracteres",
                        "email.required"=> "El campo nombre es requerido",
                        "email.email"=> "El formato para el campo correo electronico, no es valido",
                        "email.max"=> "El campo email supera los 120 caracteres",
                        "telefono.max"=> "El campo apellidos supera los 120 caracteres",
                    ]
                );
        
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $usuario = new Encuestas_usuario();
        $usuario->encuestas_id = $request->encuesta;
        $usuario->estados_encuestas_usuarios_id = 1;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->telefono = $request->telefono;
        $usuario->ultima_seccion = 0;
        $usuario->codigo = encrypt( $usuario->id ."%%%". $usuario->email );
        $usuario->estado = true;
        $usuario->save();
        
        return [ "success"=>true , "encuesta"=>Encuestas_usuario::where("id",$usuario->id)->with("estado")->first() ];
    }
    
    
    /////// EXPORTAR DATOS DE LAS ENCUESTAS DINAMICA //////////////////////////
    public function getExcel($id){
        
        
        $dataEncuestas = $this->DataEncuestas($id);
        
        //return View( "EncuestaDinamica.formatoDescarga", $dataEncuestas);
        
        Excel::create('Data', function($excel) use($dataEncuestas) {
    
                    $excel->sheet('data', function($sheet) use($dataEncuestas) {
                        $sheet->loadView('EncuestaDinamica.formatoDescarga', $dataEncuestas );
                    });
    
            })->export('xls');
        
    }
    
    private function DataEncuestas($id){
        
        $preguntas = Pregunta::whereHas( 'seccion',function($q) use($id){ $q->where("encuestas_id",$id); })
                             ->where("estado",true)
                             ->with([ 
                                      "subPreguntas"=> function($q){ $q->with([ "idiomas"=> function($qq){ $qq->where("idiomas_id",1); } ]); }, 
                                      "idiomas"=> function($q){ $q->where("idiomas_id",1); }
                                    ])->orderBy('secciones_encuestas_id')->orderBy('orden')->get();
                            
        $encuestasIDS = Encuestas_usuario::where([["encuestas_id",$id],["estado",true]])->lists('id')->toArray();
        
        $encuestas = [];
        
        foreach($encuestasIDS as $idEncuestado){
            
            $ronda = [];
                                        
            foreach($preguntas as $pregunta){
                
                if( $pregunta->tipo_campos_id==1 || $pregunta->tipo_campos_id==2 || $pregunta->tipo_campos_id==4 || $pregunta->tipo_campos_id==12 ){
                    $res =  Respuesta_pregunta::where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado] ])->pluck("respuesta")->first();
                    array_push($ronda,$res);
                }
                
                else if($pregunta->tipo_campos_id==3 || $pregunta->tipo_campos_id==5 || $pregunta->tipo_campos_id==6 || $pregunta->tipo_campos_id==7){
                    $res =  Opciones_preguntas_encuestado::join("opciones_preguntas","opciones_preguntas_encuestados.opciones_preguntas_id", "=" ,"opciones_preguntas.id")
                                                         ->join("idiomas_opciones_preguntas","idiomas_opciones_preguntas.opciones_preguntas_id", "=" ,"opciones_preguntas.id")
                                                         ->where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado], ["idiomas_id",1]  ])
                                                         ->lists('nombre')->toArray();
                                                         
                    if($pregunta->tipo_campos_id==3 || $pregunta->tipo_campos_id==7){
                        
                        $otro =  Opciones_preguntas_encuestado::join("opciones_preguntas","opciones_preguntas_id", "=" ,"opciones_preguntas.id")
                                                                  ->where([ ["preguntas_id",$pregunta->id], ["encuestado_id",$idEncuestado], ["es_otro",true] ])
                                                                  ->pluck("otro")->first();
                        if($otro){  array_push($res, "[otro=$otro]" );  }
                    }
                    array_push($ronda, implode(";", $res) );
                }
                
                else if($pregunta->tipo_campos_id==8 || $pregunta->tipo_campos_id==9){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        $res = Opciones_sub_preguntas_encuestado::join("opciones_sub_preguntas_has_sub_preguntas","opciones_sub_preguntas_has_sub_preguntas_id", "=" ,"opciones_sub_preguntas_has_sub_preguntas.id")
                                                                ->join("idiomas_opciones_sub_preguntas","idiomas_opciones_sub_preguntas.opciones_sub_preguntas_id", "=" ,"opciones_sub_preguntas_has_sub_preguntas.opciones_sub_preguntas_id")
                                                                ->where([ ["sub_preguntas_id",$subPregunta->id], ["encuestas_usuarios_id",$idEncuestado]  ])->lists('nombre')->toArray();
                        array_push($ronda, implode(";", $res) );                                        
                    }
                }
               
                else if($pregunta->tipo_campos_id==10 || $pregunta->tipo_campos_id==11){
                    foreach($pregunta->subPreguntas as $subPregunta){
                        $res = Opciones_sub_preguntas_encuestado::join("opciones_sub_preguntas_has_sub_preguntas","opciones_sub_preguntas_has_sub_preguntas_id", "=" ,"opciones_sub_preguntas_has_sub_preguntas.id")
                                                                ->where([ ["sub_preguntas_id",$subPregunta->id], ["encuestas_usuarios_id",$idEncuestado]  ])->lists('respuesta')->toArray();
                        array_push($ronda, implode(";", $res) );  
                    }
                }
                
            }                              
            
            array_push($encuestas,$ronda);
            
        }
        
        return [ "preguntas"=>$preguntas, "encuestas"=>$encuestas ];
        
    }
    
    
    //////////////// DUPLICAR ENCUESTA //////////////////////////
    public function postDuplicarencuesta(Request $request){
        
        
         $validate = \ Validator::make($request->all(),
                    [ 
                      "id" => "required|exists:encuestas_dinamicas,id",
                      "tipo" => "required|exists:tipos_encuestas_dinamicas,id"
                    ]
                );
        
        if ($validate->fails())
        {
            return [ "success"=>false, "errores"=>$validate->errors() ];
        }
        
        $encuesta = Encuestas_dinamica::find($request->id);
        
        $encuestaNueva = new Encuestas_dinamica();
        $encuestaNueva->estados_encuestas_id = 1;
        $encuestaNueva->tipos_encuestas_dinamica_id = $request->tipo;
        $encuestaNueva->estado = true;
        $encuestaNueva->save();
        
        foreach($encuesta->idiomas()->get() as $item){
            $idioma = new Encuestas_idioma();
            $idioma->estado = $item->estado;
            $idioma->nombre = $item->nombre;
            $idioma->descripcion = $item->descripcion;
            $idioma->encuestas_id = $encuestaNueva->id;
            $idioma->idiomas_id = $item->idiomas_id;
            $idioma->save();
        }
        
        foreach($encuesta->secciones()->get() as $seccion){
            
            $seccionNueva = new Secciones_encuesta();
            $seccionNueva->encuestas_id = $encuestaNueva->id;
            $seccionNueva->save();
            
            foreach($seccion->preguntas()->get() as $pregunta){
                
                $this->DuplicarPregunta($pregunta,$seccionNueva->id);

            }
            
        }
            
        return [
                 "success"=>true, 
                 "data"=> Encuestas_dinamica::where([ ["id",$encuestaNueva->id] ])->with([ "estado","tipo","idiomas"=>function($q){ $q->with("idioma"); }])->first() 
                ];
        
    }
    
    public function postDuplicarpregunta(Request $request){
        
        
        $this->DuplicarPregunta( Pregunta::find($request->idPregunta) , $request->idSeccion );
        
        return [ "success"=>true, "data"=> $this->getDataEncuesta($request->idEncuesta) ];
    }
    
    private function DuplicarPregunta($pregunta,$idSeccion){
        
        $preguntaNueva = new Pregunta();
        $preguntaNueva->secciones_encuestas_id = $idSeccion;
        $preguntaNueva->tipo_campos_id = $pregunta->tipo_campos_id;
        $preguntaNueva->es_requerido = $pregunta->es_requerido;
        $preguntaNueva->max_length = $pregunta->max_length;
        $preguntaNueva->valor_max = $pregunta->valor_max;
        $preguntaNueva->valor_min = $pregunta->valor_min;
        $preguntaNueva->orden = $pregunta->orden;
        $preguntaNueva->es_visible = $pregunta->es_visible;
        $preguntaNueva->estado = $pregunta->estado;
        $preguntaNueva->save();
        
        foreach($pregunta->idiomas()->get() as $item){
            $idioma = new Idiomas_pregunta();
            $idioma->idiomas_id = $item->idiomas_id;
            $idioma->preguntas_id = $preguntaNueva->id;
            $idioma->pregunta = $item->pregunta;
            $idioma->save();
        }

        foreach($pregunta->opciones()->get() as $opcion){   
            
            $opcionNueva = new Opciones_pregunta();
            $opcionNueva->preguntas_id = $preguntaNueva->id;
            $opcionNueva->es_otro = $opcion->es_otro;
            $opcionNueva->estado = $opcion->estado;
            $opcionNueva->save();
            
            foreach($opcion->idiomas()->get() as $item){
                $idioma = new Idiomas_opciones_pregunta();
                $idioma->idiomas_id = $item->idiomas_id;
                $idioma->opciones_preguntas_id = $opcionNueva->id;
                $idioma->nombre = $item->nombre;
                $idioma->save();
            }
        }
        
        
        $idsSubpreguntas = [];
        foreach($pregunta->subPreguntas()->get() as $subPregunta){
            
            $subPreguntaNueva = new Sub_pregunta();
            $subPreguntaNueva->preguntas_id = $preguntaNueva->id;
            $subPreguntaNueva->estado = $subPregunta->estado;
            $subPreguntaNueva->save();
            array_push($idsSubpreguntas, $subPreguntaNueva->id);
            
            foreach($subPregunta->idiomas()->get() as $item){
                $opcion_idioma = new Idiomas_sub_pregunta();
                $opcion_idioma->idiomas_id = $item->idiomas_id;
                $opcion_idioma->sub_preguntas_id = $subPreguntaNueva->id;
                $opcion_idioma->nombre = $item->nombre;
                $opcion_idioma->save();
            }
        }
        
        foreach($pregunta->OpcionesSubPreguntas()->get() as $opcion){ 
            
            $opcionNueva = new Opciones_sub_pregunta();
            $opcionNueva->preguntas_id = $preguntaNueva->id;
            $opcionNueva->estado = $opcion->estado;
            $opcionNueva->save();
            
            foreach($opcion->idiomas()->get() as $item){
                $idioma = new Idiomas_opciones_sub_pregunta();
                $idioma->idiomas_id = $item->idiomas_id;
                $idioma->opciones_sub_preguntas_id = $opcionNueva->id;
                $idioma->nombre = $item->nombre;
                $idioma->save();
            }
            
            foreach($idsSubpreguntas as $id){
               $Opcion_Pregunta = new Opciones_sub_preguntas_has_sub_pregunta();
               $Opcion_Pregunta->opciones_sub_preguntas_id = $opcionNueva->id;
               $Opcion_Pregunta->sub_preguntas_id = $id;
               $Opcion_Pregunta->save();
            }
            
        }
        
        
    }
    
    
    
    /////////////Generar Codigo Unico/////////////////
    
    private function generarCodigo(){
        $fecha = \Carbon\Carbon::createFromTimestamp(-1)->toDateTimeString();
        return encrypt( $fecha );
    }
    
}
