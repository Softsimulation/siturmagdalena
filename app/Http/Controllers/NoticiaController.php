<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Noticia;
use App\Models\Idioma;
use App\Models\Noticia_Idioma;
use App\Models\Multimedia_noticia;
use App\Models\Multimedia_noticia_Idioma;
use App\Models\Tipo_noticia;
use App\Models\Tipo_noticia_Idioma;
use App\Models\User;

class NoticiaController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
     
    public function getListadonoticias() {
        return view('noticias.ListadoNoticias');
	}
	public function getCrearnoticia() {
        return view('noticias.CrearNoticia');
	}
	public function getNuevoidioma($id) {
        //return view('noticias.CrearIdioma');
        $noticia = Noticia::where('id',$id)->first();
        
        if($noticia == null){
            $error = [];
            $error["NuevoIdioma"][0] = "Vuelva a intentar, noticia o idioma seleccionado no se encuentra registrado.";
            return ["success"=>false,"errores"=>$error];
        }
        
        return view('noticias.CrearIdioma', array('idNoticia' => $id));
	}
    public function getNoticias(){
        $noticias = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        ->where('noticias_has_idiomas.idiomas_id',1)->where('tipos_noticias_has_idiomas.idiomas_id',1)
        ->select("noticias.id as idNoticia","noticias.enlace_fuente","noticias.es_interno","noticias.estado",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen","noticias_has_idiomas.texto",
        "tipos_noticias.id as idTipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia")->get();
        
        foreach($noticias as $not){
            $not["idiomas"] = Noticia::with(['idiomas'])->where('id',$not->idNoticia)->get(); 
        }
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        $idiomasNoticia = Noticia::with(['idiomas'])->get();
        $cantIdiomas = Idioma::count();
        return  ["success"=>true,"noticias"=>$noticias,"tiposNoticias"=>$tiposNoticias,"idiomasNoticia"=>$idiomasNoticia,"cantIdiomas"=>$cantIdiomas];
    }
    public function getDatoscrearnoticias(){
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        return  ["success"=>true,"tiposNoticias"=>$tiposNoticias];
    }
    
    public function postGuardarnoticia(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'tituloNoticia' => 'string|min:1|max:255|required',
            'resumenNoticia' => 'required',
            'texto' => 'required',
            'tipoNoticia' => 'required|exists:tipos_noticias,id',
            
        ],[
            'tituloNoticia.string' => 'El titulo debe ser de tipo string.',
            'tituloNoticia.min' => 'El titulo debe ser mínimo de 1 caracter.',
            'tituloNoticia.max' => 'El asunto debe ser maximo de 255 caracteres.',
            'tituloNoticia.required' => 'El título es requerida.',
            'resumenNoticia.required' => 'EL antetítulo es requerido.',
            'texto.required' => 'La noticia debe tener un cuerpo.',
            'Dependencia.exists' => 'La dependencia debe existir.',
            'tipoNoticia.required' => 'El tipo de noticia es requerido.',
            'tipoNoticia.exists' => 'El tipo de noticia debe existir.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if($request->id > 0){
            $consultaNoticia = Noticia::where('id',$request->id)->first();
            if( $consultaNoticia == null){
                $error = [];
                $error["Noticia"][0] = "La noticia no se encuentra en la base de datos";
                return ["success"=>false,"errores"=>$error];
            }else{
                $consultaNoticia->enlace_fuente = $request->fuenteNoticia;
                $consultaNoticia->es_interno = 1;
                $consultaNoticia->tipos_noticias_id = intval($request->tipoNoticia);
                $consultaNoticia->user_update = $this->user->username;
                $consultaNoticia->updated_at = Carbon::now();
                $consultaNoticia->save();
                
                $consultaNoticia_Idioma = Noticia_Idioma::where('noticias_id',$consultaNoticia->id)->first();
                
                $consultaNoticia_Idioma->idiomas_id = 1;
                $consultaNoticia_Idioma->titulo = $request->tituloNoticia;
                $consultaNoticia_Idioma->resumen = $request->resumenNoticia;
                $consultaNoticia_Idioma->texto = $request->texto;
                $consultaNoticia_Idioma->user_update = $this->user->username;
                $consultaNoticia_Idioma->updated_at = Carbon::now();
                $consultaNoticia_Idioma->save();
                
                return  ["success"=>true,"idNoticia"=>$consultaNoticia->id];
            }
        }else{
            $noticia = new Noticia();
            
            $noticia->enlace_fuente = $request->fuenteNoticia;
            $noticia->es_interno = 1;
            $noticia->tipos_noticias_id = intval($request->tipoNoticia);
            $noticia->user_create = $this->user->username;
            $noticia->user_update = $this->user->username;
            $noticia->created_at = Carbon::now();
            $noticia->updated_at = Carbon::now();
            $noticia->estado = 1;
            $noticia->save();
            
            $noticia_idioma = new Noticia_Idioma();
                
            $noticia_idioma->noticias_id = $noticia->id;
            $noticia_idioma->idiomas_id = 1;
            $noticia_idioma->titulo = $request->tituloNoticia;
            $noticia_idioma->resumen = $request->resumenNoticia;
            $noticia_idioma->texto = $request->texto;
            $noticia_idioma->user_create = $this->user->username;
            $noticia_idioma->user_update = $this->user->username;
            $noticia_idioma->created_at = Carbon::now();
            $noticia_idioma->updated_at = Carbon::now();
            $noticia_idioma->estado = 1;
            $noticia_idioma->save();
            
            return  ["success"=>true,"idNoticia"=>$noticia->id];
        }
        
        
        /*$noticiaRetornar = [];
        $noticiaRetornar->id = $noticia->id;
        $noticiaRetornar->enlaceFuente = $noticia->enlace_fuente;
        $noticiaRetornar->es_interno = $noticia->es_interno;
        $noticiaRetornar->tipoNoticia = $noticia->tipos_noticias_id;
        $noticiaRetornar->estado = $noticia->estado;
        $noticiaRetornar->idIdioma = $noticia->idiomas_id;
        $noticiaRetornar->tituloNoticia = $noticia->titulo;
        $noticiaRetornar->resumenNoticia = $noticia->resumen;
        $noticiaRetornar->texto = $noticia->texto;
        $noticiaRetornar->user_create = $noticia->user_create;
        $noticiaRetornar->user_update = $noticia->user_update;
        $noticiaRetornar->created_at = $noticia->created_at;
        $noticiaRetornar->updated_at = $noticia->updated_at;*/
        
    }
    
    public function postGuardarmultimedianoticia(Request $request){
        $request->portadaNoticia = intval($request->portadaNoticia);
        $request->videoNoticia = intval($request->videoNoticia);
        //return $request->all();
        
        $validator = \Validator::make($request->all(), [
            'texto_alternativo' => 'string|min:1|max:255|required',
            'idNoticia' => 'required|exists:noticias,id',
            'portadaNoticia' => 'required|boolean',
            'Galeria.*' => 'mimes:jpg,jpeg,png',
            'Galeria' =>'required',
            
        ],[
            'texto_alternativo.string' => 'El texto alternativo debe ser de tipo string.',
            'texto_alternativo.min' => 'El texto alternativo debe ser mínimo de 1 caracter.',
            'texto_alternativo.max' => 'El texto alternativo debe ser maximo de 255 caracteres.',
            'texto_alternativo.required' => 'El texto alternativo es requerida.',
            'idNoticia.required' => 'Es necesario haber creado primero la noticia.',
            'idNoticia.exists' => 'Es necesario haber creado primero la noticia.',
            'portadaNoticia.required' => 'Debe seleccionar si la imagen es portada.',
            'portadaNoticia.Boolean' => 'Favor recargar la página.',
            'Galeria.*.mimes' => 'subir solo archivos jpg,png o jgpe',
            'Galeria.required' => 'Debe cargar una imagen.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if($request->Galeria != null){
            $tamaño = filesize($request->Galeria);
            if($tamaño/1024 > 2000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        if($request->idIdioma != null && Noticia_Idioma::where('noticias_id',$request->idNoticia)->where('idiomas_id',$request->idIdioma)->first() == null){
            $error = [];
            $error["Noticia"][0] = "Solo es posible agregar multimedia en el idioma de español";
            return ["success"=>false,"errores"=>$error];
        }
        $multimedia = new Multimedia_noticia();
        $multimedia->noticia_id = $request->idNoticia;
        $multimedia->es_portada = intval($request->portadaNoticia);
        if(intval($request->portadaNoticia) == 1){
            $consultaMultimedia = Multimedia_noticia::where('noticia_id',$request->idNoticia)->where('es_portada',1)->first();
            if($consultaMultimedia != null){
                $consultaMultimedia->es_portada = 0;
                $consultaMultimedia->save();
            }
        }
        $date = Carbon::now(); 
        $nombrex = $request->idNoticia."-".date("Ymd-H:i:s").".".$request->Galeria->getClientOriginalExtension();
       \Storage::disk('Noticias')->put($nombrex,  \File::get($request->Galeria));
        $multimedia->ruta = "/Noticias/".$nombrex;
        $multimedia->user_create = $this->user->username;
        $multimedia->user_update = $this->user->username;
        $multimedia->updated_at = Carbon::now();
        $multimedia->created_at = Carbon::now();
        $multimedia->save();
        
        $multimedia_idioma = new Multimedia_noticia_Idioma();
        
        $multimedia_idioma->multimedias_noticias_id = $multimedia->id;
        $multimedia_idioma->idiomas_id = 1;
        $multimedia_idioma->texto_alternativo = $request->texto_alternativo;
        $multimedia_idioma->save();
        
        //$multimediaNoticia = Multimedia_noticia_Idioma::with(['multimedias_noticia'=>function ($q) use($request){$q->where('noticias_id',$request->idNoticia);}])->where('idiomas_id',1)->get();
        
        $multimediaNoticia = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias_has_idiomas.idiomas_id',1)->where('multimedias_noticias.noticia_id',$request->idNoticia)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->get();
        return  ["success"=>true,"multimedia"=>$multimediaNoticia,"multimediaIdioma"=>$multimedia_idioma];
    }
    
    public function getVistaeditar($id,$idIdioma){
        $noticia = Noticia::where('id',$id)->first();
        $idioma = Idioma::where('id',$idIdioma)->first();
        
        if($noticia == null || $idioma == null){
            $error = [];
            $error["Editar"][0] = "Vuelva a intentar, noticia o idioma seleccionado no se encuentra registrado.";
            return ["success"=>false,"errores"=>$error];
        }
        
        return view('noticias.EditarNoticia2', array('idNoticia' => $id,'idIdioma'=>$idIdioma));
    }
    
    public function getVernoticia($id){
        $noticia = Noticia::where('id',$id)->first();
        
        if($noticia == null){
            $error = [];
            $error["Editar"][0] = "Vuelva a intentar, noticia no se encuentra registrado.";
            return ["success"=>false,"errores"=>$error];
        }
        
        $portada = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias.noticia_id',$id)->where('multimedias_noticias.es_portada',1)->where('multimedias_noticias_has_idiomas.idiomas_id',1)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portadaNoticia",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->first();
        
        
        return view('noticias.VerNoticia', array('idNoticia' => $id,'portada'=> $portada));
    }
    
    public function getDatosver($idNoticia){
        $noticia = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        
        ->where('noticias.id',$idNoticia)
        ->select("noticias.id as id","noticias.enlace_fuente as enlaceFuente","noticias.es_interno as interno","noticias.estado",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen as resumenNoticia","noticias_has_idiomas.texto",
        "tipos_noticias.id as tipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia")->first();
        
        
        if($noticia == null){
            $error = [];
            $error["Ver"][0] = "Vuelva a intentar, noticia seleccionado no se encuentra registrado.";
            return ["success"=>false,"errores"=>$error];
        }
        
        $portada = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias.noticia_id',$idNoticia)->where('multimedias_noticias.es_portada',1)->where('multimedias_noticias_has_idiomas.idiomas_id',1)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->first();
        
        $multimediaNoticia = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias.noticia_id',$idNoticia)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->get();
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        
        return ["noticia"=>$noticia,"multimedia"=>$multimediaNoticia,"tiposNoticias"=>$tiposNoticias,"portada"=>$portada];
    }
    
    public function getDatoseditar($idNoticia,$idIdioma){
        //return [$idNoticia,$idIdioma];
        $noticia = Noticia::where('id',$idNoticia)->first();
        $idioma = Idioma::where('id',$idIdioma)->first();
        
        if($noticia == null || $idioma == null){
            $error = [];
            $error["Editar"][0] = "Vuelva a intentar, noticia o idioma seleccionado no se encuentra registrado.";
            return ["success"=>false,"errores"=>$error];
        }
        $noticia = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        
        ->where('noticias.id',$idNoticia)->where('noticias_has_idiomas.idiomas_id',$idIdioma)
        ->select("noticias.id as id","noticias.enlace_fuente as fuenteNoticia","noticias.es_interno as interno","noticias.estado",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen as resumenNoticia","noticias_has_idiomas.texto","noticias_has_idiomas.idiomas_id as idIdioma",
        "tipos_noticias.id as tipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia")->first();
        
        $multimediaNoticia = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias_has_idiomas.idiomas_id',$idIdioma)->where('multimedias_noticias.noticia_id',$idNoticia)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->get();
        
        $multimediaEspañol = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias_has_idiomas.idiomas_id',1)->where('multimedias_noticias.noticia_id',$idNoticia)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->get();
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',$idIdioma)->get();
        return ["noticia"=>$noticia,"multimedia"=>$multimediaNoticia,"tiposNoticias"=>$tiposNoticias,"multimediaEspañol"=>$multimediaEspañol];
    }
    
    public function postModificarnoticia(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'tituloNoticia' => 'string|min:1|max:255|required',
            'resumenNoticia' => 'required',
            'texto' => 'required',
            'tipoNoticia' => 'required|exists:tipos_noticias,id',
            'idIdioma' => 'required|exists:idiomas,id',
            'id' => 'required|exists:noticias,id',
            
        ],[
            'tituloNoticia.string' => 'El titulo debe ser de tipo string.',
            'tituloNoticia.min' => 'El titulo debe ser mínimo de 1 caracter.',
            'tituloNoticia.max' => 'El asunto debe ser maximo de 255 caracteres.',
            'tituloNoticia.required' => 'El título es requerida.',
            'resumenNoticia.required' => 'EL antetítulo es requerido.',
            'texto.required' => 'La noticia debe tener un cuerpo.',
            'tipoNoticia.required' => 'El tipo de noticia es requerido.',
            'tipoNoticia.exists' => 'El tipo de noticia debe existir.',
            'idIdioma.required' => 'Favor recargar la página.',
            'idIdioma.exists' => 'El idioma seleccionado no sse encuentra registrado en el sistema.',
            'id.required' => 'Favor recargar la página.',
            'id.exists' => 'El idioma seleccionado no sse encuentra registrado en el sistema.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        //if($request->id == null)
        /*
        $busquedaNoticia = Noticia_Idioma::where('noticias_id',$request->id)->where('idiomas_id',$request->idIdioma)->first();
        if( $busquedaNoticia == null){
            $error = [];
            $error["Noticia"][0] = "La noticia no posee registro con el idioma seleccionado";
            return ["success"=>false,"errores"=>$error];
        }*/
        
        $consultaNoticia = Noticia::where('id',$request->id)->first();
        
        $consultaNoticia->enlace_fuente = $request->fuenteNoticia;
        $consultaNoticia->es_interno = 1;
        $consultaNoticia->tipos_noticias_id = intval($request->tipoNoticia);
        $consultaNoticia->user_update = $this->user->username;
        $consultaNoticia->updated_at = Carbon::now();
        $consultaNoticia->save();
        
        $busquedaNoticia = Noticia_Idioma::where('noticias_id',$request->id)->where('idiomas_id',$request->idIdioma)->first();
        //return $consultaNoticia_Idioma;
        if($busquedaNoticia != null){
            $busquedaNoticia->idiomas_id = $request->idIdioma;
            $busquedaNoticia->titulo = $request->tituloNoticia;
            $busquedaNoticia->resumen = $request->resumenNoticia;
            $busquedaNoticia->texto = $request->texto;
            $busquedaNoticia->user_update = $this->user->username;
            $busquedaNoticia->updated_at = Carbon::now();
            
        }else{
            $busquedaNoticia = new Noticia_Idioma();
            $busquedaNoticia->noticias_id = $consultaNoticia->id;
            $busquedaNoticia->idiomas_id = $request->idIdioma;
            $busquedaNoticia->titulo = $request->tituloNoticia;
            $busquedaNoticia->resumen = $request->resumenNoticia;
            $busquedaNoticia->texto = $request->texto;
            $busquedaNoticia->user_create = $this->user->username;
            $busquedaNoticia->user_update = $this->user->username;
            $busquedaNoticia->created_at = Carbon::now();
            $busquedaNoticia->updated_at = Carbon::now();
            $busquedaNoticia->estado = 1;
        }
        $busquedaNoticia->save();
        
        return  ["success"=>true];
    }
    public function postCambiarestado(Request $request)
    {
        $noticia = Noticia::where('id',$request[0])->first();
        if($noticia == null){
            return ["success"=> false];
        }  
        $noticia->estado = !$noticia->estado;
        $noticia->user_update = $this->user->username;
        $noticia->updated_at = Carbon::now();
        $noticia->save();
        return ["success"=> true,"estado"=>$noticia->estado];
    }
    public function postEliminarnoticia(Request $request)
    {
        //return $request->all();
        $noticia = Noticia::where('id',$request[0])->first();
        if($noticia == null){
            return ["success"=> false];
        }
        $multimedia_noticia = Multimedia_noticia::where('noticia_id',$noticia->id)->get();
        for($i=0;$i<sizeof($multimedia_noticia);$i++){
            \File::delete(public_path() . $multimedia_noticia[$i]->ruta);
        }
        $noticia->delete('cascade');
        return ["success"=> true];
    }
    public function postComentarionoticia(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'idNoticia' => 'required|exists:noticias,id',
            
        ],[
            'idNoticia.required' => 'Favor recargar la página.',
            'idNoticia.exists' => 'La noticia no se encuentra registrada en el sistema.',
            ]
        );
        if($request->textoComentario == null && $request->calificacionNoticia == null){
            $error = [];
            $error["Comentario"][0] = "Debe realizar un comentario o calificación.";
            return ["success"=>false,"errores"=>$error];
        }
        $comentario = new Comentario_noticia();
        $comentario->texto = $request->textoComentario;
        $comentario->calificacion = $request->calificacionNoticia;
        $comentario->noticias_id = $request->idNoticia;
        $comentario->user_create = $this->user->username;
        $comentario->created_at = Carbon::now();
        $comentario->user_update = $this->user->username;
        $comentario->updated_at = Carbon::now();
        $comentario->save();
        
        $listaComentarios = Comentario_noticia::where('noticias_id',$request->idNoticia)->get();
        
        return ["success"=> true,"comentarios"=>$listaComentarios];
    }
    public function postGuardartextoalternativo(Request $request)
    {
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'textoAlternativo' => 'required',
            'idMultimedia' => 'required|exists:multimedias_noticias,id',
            'idIdioma' => 'required|exists:idiomas,id',
            
        ],[
            'textoAlternativo.required' => 'El texto alternativo es requerido.',
            'idMultimedia.required' => 'Favor recargar la página.',
            'idMultimedia.exists' => 'La multimedia no se encuentra registrada en el sistema.',
            'idIdioma.required' => 'Es necesario conocer el idioma a quien se le va a registrar, favor recargar la página.',
            'idIdioma.exists' => 'EL idioma no se encuentra registrado en el sistema.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        
        $multimedia = Multimedia_noticia::where('id',$request->idMultimedia)->first();
        $multimedia_idioma = Multimedia_noticia_Idioma::where('multimedias_noticias_id',$multimedia->id)->where('idiomas_id',$request->idIdioma)->first();
        
        
        $busquedaNoticia = Noticia_Idioma::where('noticias_id',$multimedia->noticia_id)->where('idiomas_id',$request->idIdioma)->first();
        if( $busquedaNoticia == null){
            $error = [];
            $error["Noticia"][0] = "La noticia no posee registro con el idioma seleccionado";
            return ["success"=>false,"errores"=>$error];
        }
        if($multimedia_idioma!=null){
            $multimedia_idioma->texto_alternativo = $request->textoAlternativo;
        }else{
            $multimedia_idioma = new Multimedia_noticia_Idioma();
            
            $multimedia_idioma->multimedias_noticias_id = $multimedia->id;
            $multimedia_idioma->texto_alternativo = $request->textoAlternativo;
            $multimedia_idioma->idiomas_id = $request->idIdioma;
            
        }
        $multimedia_idioma->save();
        return ["success"=> true,"texto"=>$multimedia_idioma->texto_alternativo,"idMultimedia"=>$multimedia_idioma->multimedias_noticias_id];
    }
    public function getDatosnuevoidioma($id){
        $idiomas = Idioma::all();
        $idiomasNoticia = Noticia::where('id',$id)->with('idiomas')->first();
        //return $idiomasNoticia;
        $arrayIdiomaNoticia = [];
        foreach($idiomasNoticia->idiomas as $idio){
            array_push($arrayIdiomaNoticia,$idio->id);
        }
        $arrayAux = [];
        foreach($idiomas as $idio){
            if(!in_array($idio->id, $arrayIdiomaNoticia)){
                array_push($arrayAux,$idio);
            }
        }
        $multimediaEspañol = Multimedia_noticia::
        join('multimedias_noticias_has_idiomas', 'multimedias_noticias_has_idiomas.multimedias_noticias_id', '=', 'multimedias_noticias.id')
        ->where('multimedias_noticias_has_idiomas.idiomas_id',1)->where('multimedias_noticias.noticia_id',$id)
        ->select("multimedias_noticias.id as idMultimedia","multimedias_noticias.id as idMultimedia","multimedias_noticias.ruta as ruta","multimedias_noticias.es_portada as portada",
        "multimedias_noticias_has_idiomas.idiomas_id as idiomas_id", "multimedias_noticias_has_idiomas.texto_alternativo as texto")->get();
        
        
        return ["idiomas"=>$arrayAux,"multimedia"=>$multimediaEspañol];
    }
    public function postGuardarnuevoidioma(Request $request){
        //return $request->all();
        $validator = \Validator::make($request->all(), [
            'idNoticia' => 'required|exists:noticias,id',
            'tituloNoticia' => 'string|min:1|max:255|required',
            'resumenNoticia' => 'required',
            'texto' => 'required',
            'idioma' => 'required|exists:idiomas,id',
            
        ],[
            'idNoticia.required' => 'Primero ha tenido que creear una noticia con el idioma de español.',
            'idNoticia.exists' => 'Primero ha tenido que creear una noticia con el idioma de español.',
            'tituloNoticia.string' => 'El titulo debe ser de tipo string.',
            'tituloNoticia.min' => 'El titulo debe ser mínimo de 1 caracter.',
            'tituloNoticia.max' => 'El asunto debe ser maximo de 255 caracteres.',
            'tituloNoticia.required' => 'El título es requerida.',
            'resumenNoticia.required' => 'EL antetítulo es requerido.',
            'texto.required' => 'La noticia debe tener un cuerpo.',
            'idioma.required' => 'Es necesario conocer el idioma a quien se le va a registrar, favor recargar la página.',
            'idioma.exists' => 'EL idioma no se encuentra registrado en el sistema.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $consultaNoticia_Idioma = Noticia_Idioma::where('noticias_id',$request->idNoticia)->where('idiomas_id',$request->idioma)->first();
        if( $consultaNoticia_Idioma == null){
            $noticia_idioma = new Noticia_Idioma();
                
            $noticia_idioma->noticias_id = $request->idNoticia;
            $noticia_idioma->idiomas_id = $request->idioma;
            $noticia_idioma->titulo = $request->tituloNoticia;
            $noticia_idioma->resumen = $request->resumenNoticia;
            $noticia_idioma->texto = $request->texto;
            $noticia_idioma->user_create = $this->user->username;
            $noticia_idioma->user_update = $this->user->username;
            $noticia_idioma->created_at = Carbon::now();
            $noticia_idioma->updated_at = Carbon::now();
            $noticia_idioma->estado = 1;
            $noticia_idioma->save();
        }else{
            
            $consultaNoticia_Idioma->idiomas_id = $request->idioma;
            $consultaNoticia_Idioma->titulo = $request->tituloNoticia;
            $consultaNoticia_Idioma->resumen = $request->resumenNoticia;
            $consultaNoticia_Idioma->texto = $request->texto;
            $consultaNoticia_Idioma->user_update = $this->user->username;
            $consultaNoticia_Idioma->updated_at = Carbon::now();
            $consultaNoticia_Idioma->save();
        }
            
            
            return  ["success"=>true];
        
        
    }
    public function postEliminarmultimedia(Request $request)
    {
        //return $request->all();
        
        $multimedia_noticia = Multimedia_noticia::where('id',$request[0])->first();
        if($multimedia_noticia == null){
            return ["success"=> false];
        }
        $multimedia_idioma = Multimedia_noticia_Idioma::where('multimedias_noticias_id',$multimedia_noticia->id)->delete();
        \File::delete(public_path() . $multimedia_noticia->ruta);
        return ["success"=> true];
    }
    public function postEditarmultimedia(Request $request)
    {
        //return $request->all();
        
        $validator = \Validator::make($request->all(), [
            'texto_alternativo' => 'string|min:1|max:255|required',
            'idMultimedia' => 'required|exists:multimedias_noticias,id',
            'portadaNoticia' => 'required|numeric|min:1|max:2',
            'Galeria.*' => 'mimes:jpg,jpeg,png',
            
        ],[
            'texto_alternativo.string' => 'El texto alternativo debe ser de tipo string.',
            'texto_alternativo.min' => 'El texto alternativo debe ser mínimo de 1 caracter.',
            'texto_alternativo.max' => 'El texto alternativo debe ser maximo de 255 caracteres.',
            'texto_alternativo.required' => 'El texto alternativo es requerida.',
            'idMultimedia.required' => 'No se encuentra registrada en el sistema la multimedia seleccionada.',
            'idMultimedia.exists' => 'No se encuentra registrada en el sistema la multimedia seleccionada.',
            'portadaNoticia.required' => 'Debe seleccionar si la imagen es portada.',
            'portadaNoticia.numeric' => 'Favor recargar la página.',
            'portadaNoticia.min' => 'Favor recargar la página.',
            'portadaNoticia.max' => 'Favor recargar la página.',
            'Galeria.*.mimes' => 'subir solo archivos jpg,png o jgpe',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if($request->Galeria != null){
            $tamaño = filesize($request->Galeria);
            if($tamaño/1024 > 2000){
                $error = [];
                $error["Galeria"][0] = "Tamaño total de los adjuntos exceden los 10MB";
                return ["success"=>false,"errores"=>$error];
            } 
        }
        
        $multimedia_noticia = Multimedia_noticia::where('id',$request->idMultimedia)->first();
        $multimedia_noticia->es_portada = intval($request->portadaNoticia) == 1 ? true : false;
        if(intval($request->portadaNoticia) == 1){
            $consultaMultimedia = Multimedia_noticia::where('noticia_id',$multimedia_noticia->noticia_id)->where('es_portada',1)->first();
            if($consultaMultimedia != null){
                $consultaMultimedia->es_portada = 0;
                $consultaMultimedia->save();
            }
        }
        if($request->Galeria != null){
            \File::delete(public_path() . $multimedia_noticia->ruta);
            $date = Carbon::now(); 
            $nombrex = $multimedia_noticia->noticia_id."-".date("Ymd-H:i:s").".".$request->Galeria->getClientOriginalExtension();
           \Storage::disk('Noticias')->put($nombrex,  \File::get($request->Galeria));
            $multimedia_noticia->ruta = "/Noticias/".$nombrex;
            $multimedia_noticia->user_update = $this->user->username;
            $multimedia_noticia->updated_at = Carbon::now();
            
            
        }
        $multimedia_noticia->save();
        $multimedia_idioma = Multimedia_noticia_Idioma::where('multimedias_noticias_id',$multimedia_noticia->id)->where('idiomas_id',1)->first();
        $multimedia_idioma->texto_alternativo = $request->texto_alternativo;
        $multimedia_idioma->save();
        
        $multimediaRetornar = [];
        $multimediaRetornar["ruta"] = $multimedia_noticia->ruta;
        $multimediaRetornar["portada"] = $multimedia_noticia->es_portada;
        $multimediaRetornar["texto"] = $multimedia_idioma->texto_alternativo;
        
        return ["success"=> true, "multimedia"=>$multimediaRetornar];
    }
}