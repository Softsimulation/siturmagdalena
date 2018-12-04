<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Idioma;
use App\Models\User;
use App\Models\Destino_Con_Idioma;
use App\Models\Destino;
use App\Models\Atracciones;
use App\Models\Actividad_Con_Idioma;
use App\Models\Actividad;
use App\Models\Ruta_Con_Idioma;
use App\Models\Ruta;
use App\Models\Proveedores_rnt_idioma;
use App\Models\Evento_Con_Idioma;
use App\Models\Evento;
use App\Models\Slider_Idioma;


class SliderController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        /*$this->middleware('permissions:list-noticia',['only' => ['getListadonoticias','getNoticias'] ]);
        $this->middleware('permissions:create-noticia',['only' => ['getCrearnoticia','getDatoscrearnoticias','postGuardarnoticia',
        'postGuardarmultimedianoticia','postGuardartextoalternativo','postEliminarmultimedia'] ]);
        $this->middleware('permissions:read-noticia',['only' => ['getVernoticia','getDatosver'] ]);
        $this->middleware('permissions:edit-noticia',['only' => ['getNuevoidioma','postGuardarnoticia','postGuardarmultimedianoticia',
        'postGuardartextoalternativo','postEliminarmultimedia','getVistaeditar','getDatoseditar','postModificarnoticia' ] ]);
        $this->middleware('permissions:estado-noticia',['only' => ['postCambiarestado'] ]);*/
    }
     
    public function getListadosliders() {
        return view('sliders.ListadoSliders');
	}
	public function getSliders() {
	    /*Slider_Idioma::where('id','>',1)->delete();
	    Slider::where('id','>',0)->delete();*/
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados;
            $sliders[$i]["enlaceInterno"] = $sliders[$i]["enlaceInterno"] == true ? 1 : $sliders[$i]["enlaceAccesoSlider"] != null ? -1 : 2; 
        }
        $actividades = Actividad_Con_Idioma::where('idiomas',1)->with(['actividade'=>function($q){$q->where('estado',true);}])->get();
        $atracciones = Atracciones::
            join('sitios', 'sitios.id', '=', 'atracciones.sitios_id')
            ->join('sitios_con_idiomas', 'sitios_con_idiomas.sitios_id', '=', 'sitios.id')
            ->where('sitios_con_idiomas.idiomas_id',1)
            ->where('sitios.estado',true)
            ->where('atracciones.estado',true)
            ->select("atracciones.id as idAtraccion","sitios_con_idiomas.nombre as nombre")
            ->get();
        $rutas = Ruta_Con_Idioma::where('idioma_id',1)->with(['ruta'=>function($q){$q->where('estado',true);}])->get();
        $proveedores = Proveedores_rnt_idioma::where('idioma_id',1)->with(['proveedoresRnt'=>function($q){$q->where('estado',true);}])->get();
        $destinos = Destino_Con_Idioma::where('idiomas_id',1)->with(['destino'=>function($q){$q->where('estado',true);}])->get();
        $eventos = Evento_Con_Idioma::where('idiomas_id',1)->with(['idioma'=>function($q){$q->where('estado',true);}])->get();
        
        return ["sliders"=>$sliders,"actividades"=>$actividades,"atracciones"=>$atracciones,"destinos"=>$destinos,"rutas"=>$rutas,"proveedores"=>$proveedores,"eventos"=>$eventos];
	}
	public function postGuardarslider(Request $request){
	    //return $request->tituloSlider; 
	    //return $request->all();
	    
	    $validator = \Validator::make($request->all(), [
            'textoAlternativoSlider' => 'string|min:1|max:255|required',
            'enlaceInterno' => 'required|min:0|max:2',
            'imagenSlider.*' => 'mimes:jpg,jpeg,png',
            'imagenSlider' =>'required',
            
        ],[
            'textoAlternativoSlider.string' => 'El texto alternativo debe ser de tipo string.',
            'textoAlternativoSlider.min' => 'El texto alternativo debe ser mínimo de 1 caracter.',
            'textoAlternativoSlider.max' => 'El texto alternativo debe ser maximo de 255 caracteres.',
            'textoAlternativoSlider.required' => 'El texto alternativo es requerida.',
            'enlaceInterno.required' => 'Debe seleccionar a que tipo de enlace pertenece.',
            'enlaceInterno.min' => 'Tipo de enlace no válido, favor recargar la página.',
            'enlaceInterno.max' => 'Tipo de enlace no válido, favor recargar la página.',
            'imagenSlider.*.mimes' => 'subir solo archivos jpg,png o jgpe',
            'imagenSlider.required' => 'Debe cargar una imagen.',
            ]
        );
	    if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	    $errores = [];
	    if($request->enlaceInterno == 0){
	        if($request->enlaceExternoSlider == null){
	            $errores["EnlaceExterno"][0] = "El enlace externo es obligatorio.";
	        }
	    }else if($request->enlaceInterno == 1){
	        switch ($request->tipoEntidadIdSlider) {
                    case 1:
                        if(Actividad::find($request->actividadIdSlider) == null)
                        {
                            $errores["Actividad"][0] = "La actividad seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 2:
                        if(Atracciones::find($request->atraccionIdSlider) == null)
                        {
                            $errores["Atraccion"][0] = "La atracción seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 3:
                        if(Destino::find($request->destinoIdSlider) == null)
                        {
                            $errores["Destino"][0] = "El destino seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 4:
                        if(Evento::find($request->eventoIdSlider) == null)
                        {
                            $errores["Evento"][0] = "El evento seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 5:
                        if(Ruta::find($request->rutaIdSlider) == null)
                        {
                            $errores["Ruta"][0] = "La ruta seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 6:
                        if(Proveedores_rnt_idioma::where('proveedor_rnt_id',$request->proveedorIdSlider)->first() == null)
                        {
                            $errores["Proveedor"][0] = "El proveedor seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    default:
                        $errores["Default"][0] = "El tipo de entidad selecionado no es correcto, favor recargar la página.";
                        break;
                }
	    }
	    
	    if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
	    
	    
	    $slider = new Slider();
	    if ($request->enlaceInterno == 0)
        {
            $slider->es_interno = false;
            $slider->enlace_acceso = $request->enlaceExternoSlider;
        }else if ($request->enlaceInterno == 1){
            $slider->es_interno = true;
            switch ($request->tipoEntidadIdSlider)
            {
                
                case 1:
                    $slider->enlace_acceso = "/actividades/ver/".$request->actividadIdSlider;
                    break;
                case 2:
                    $slider->enlace_acceso = "/atracciones/ver/".$request->atraccionIdSlider;
                    break;
                case 3:
                    
                    $slider->enlace_acceso = "/destinos/ver/".$request->destinoIdSlider;
                    return $slider->enlace_acceso;
                    break;
                case 4:
                    $slider->enlace_acceso = "/eventos/ver/".$request->eventoIdSlider;
                    break;
                case 5:
                    $slider->enlace_acceso = "/rutas/ver/".$request->rutaIdSlider;
                    break;
                case 6:
                    $slider->enlace_acceso = "/proveedor/ver/".$request->proveedorIdSlider;
                    break;
                    
            }
        }else{
            $slider->enlace_acceso = null;
        }
	    $date = Carbon::now(); 
        $nombrex = "Slider"."-".date("Ymd-H:i:s").".".$request->imagenSlider->getClientOriginalExtension();
       \Storage::disk('Sliders')->put($nombrex,  \File::get($request->imagenSlider));
        $slider->ruta = "/Sliders/".$nombrex;
        
        $slidersPrioridad = Slider::Where('prioridad','<>',0)->get();
        foreach ($slidersPrioridad as $item)
        {
            if ($item->prioridad != 8) {
                $item->prioridad = $item->prioridad + 1;
                $item->save();
            }else
            {
                $item->prioridad = 0;
                $item->estado = false;
                $item->save();
            }
        }
        
        $slider->prioridad = 1;
        
        //$slider->fecha = $request->tituloSLider == null ? Carbon::now() : $request->fechaSlider;
        $slider->estado = true;
        $slider->es_visible = true;
        $slider->user_create = $this->user->username;
        $slider->user_update = $this->user->username;
        $slider->created_at = Carbon::now();
        $slider->updated_at = Carbon::now();
        $slider->save();
        
        $sliderIdioma = new Slider_Idioma();
        /*if($request->tituloSLider != null){
            $sliderIdioma->nombre = $request->tituloSLider; 
        }else{
            $sliderIdioma->nombre = "No tiene";
        }*/
        $sliderIdioma->nombre = $request->tituloSlider == null ? "No tiene" : $request->tituloSlider;
        $sliderIdioma->descripcion = $request->textoAlternativoSlider;
        $sliderIdioma->idioma_id = 1;
        $sliderIdioma->slider_id = $slider->id;
        $sliderIdioma->estado = true;
        $sliderIdioma->user_create = $this->user->username;
        $sliderIdioma->user_update = $this->user->username;
        $sliderIdioma->created_at = Carbon::now();
        $sliderIdioma->updated_at = Carbon::now();
        $sliderIdioma->save();
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados; 
        }
        
        return ["success"=>true,"sliders"=>$sliders];
	}
	
	public function postInfoeditar(Request $request){
	    //return $request->all();
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',$request->idiomaId)
            ->where('sliders.id',$request->slider)
            ->where('sliders_idiomas.idioma_id',$request->idiomaId)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")->first();
            
        $idiomas = Idioma::all();
            
            $sliders["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders["noIdiomas"] = $idiomasConsultados;
            //$sliders["enlaceInterno"] == true ? 1 : $sliders["enlaceAccesoSlider"] != null ? -1 : 2;
            if($sliders["enlaceInterno"]){
                $sliders["enlaceInterno"] = 1;
            }else{
                if($sliders["enlaceAccesoSlider"] == null){
                    $sliders["enlaceInterno"] = 2;
                }else{
                    $sliders["enlaceInterno"] = -1;
                }
            }
        
        return ["slider"=>$sliders];
	    
	}
	
	public function postEditarslider(Request $request){
	    //return $request->all();
	    $validator = \Validator::make($request->all(), [
            'textoAlternativoSlider' => 'string|min:1|max:255|required',
            'enlaceInterno' => 'required|min:0|max:2',
            'imagenSlider.*' => 'mimes:jpg,jpeg,png',
            'id' => 'required|exists:sliders,id',
            
        ],[
            'textoAlternativoSlider.string' => 'El texto alternativo debe ser de tipo string.',
            'textoAlternativoSlider.min' => 'El texto alternativo debe ser mínimo de 1 caracter.',
            'textoAlternativoSlider.max' => 'El texto alternativo debe ser maximo de 255 caracteres.',
            'textoAlternativoSlider.required' => 'El texto alternativo es requerida.',
            'enlaceInterno.required' => 'Debe seleccionar a que tipo de enlace pertenece.',
            'enlaceInterno.min' => 'Tipo de enlace no válido, favor recargar la página.',
            'enlaceInterno.max' => 'Tipo de enlace no válido, favor recargar la página.',
            'imagenSlider.*.mimes' => 'subir solo archivos jpg,png o jgpe',
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El registro que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            ]
        );
	    if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	    $errores = [];
	    $slider = Slider::find($request->id);
	    if($request->enlaceInterno == 0){
	        if($request->enlaceExternoSlider == null && $slider->enlace_acceso == null){
	            $errores["EnlaceExterno"][0] = "El enlace externo es obligatorio.";
	        }
	    }else if($request->enlaceInterno == 1 && $slider->enlace_acceso == null){
	        switch ($request->tipoEntidadIdSlider) {
                    case 1:
                        if(Actividad::find($request->actividadIdSlider) == null)
                        {
                            $errores["Actividad"][0] = "La actividad seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 2:
                        if(Atracciones::find($request->atraccionIdSlider) == null)
                        {
                            $errores["Atraccion"][0] = "La atracción seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 3:
                        if(Destino::find($request->destinoIdSlider) == null)
                        {
                            $errores["Destino"][0] = "El destino seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 4:
                        if(Evento::find($request->eventoIdSlider) == null)
                        {
                            $errores["Evento"][0] = "El evento seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 5:
                        if(Ruta::find($request->rutaIdSlider) == null)
                        {
                            $errores["Ruta"][0] = "La ruta seleccionada no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    case 6:
                        if(Proveedores_rnt_idioma::where('proveedor_rnt_id',$request->proveedorIdSlider)->first() == null)
                        {
                            $errores["Proveedor"][0] = "El proveedor seleccionado no se encuentra en la base de datos, favor recargar la página.";
                        }
                        break;
                    default:
                        $errores["Default"][0] = "El tipo de entidad selecionado no es correcto, favor recargar la página.";
                        break;
                }
	    }
	    
	    if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
	    
	    if ($request->enlaceInterno == -1)
        {
            if ($request->enlaceExternoSlider != null) {
                $slider->enlace_acceso = $request->enlaceExternoSlider;
            }
            
            $slider->es_interno = false;
        }else if ($request->enlaceInterno == 1 && $request->enlaceExternoSlider == null){
            //return "si";
            $slider->es_interno = 1;
            switch ($request->tipoEntidadIdSlider)
            {
                case 1:
                    $slider->enlace_acceso = "/actividades/ver/".$request->actividadIdSlider;
                    break;
                case 2:
                    $slider->enlace_acceso = "/atracciones/ver/".$request->atraccionIdSlider;
                    break;
                case 3:
                    $slider->enlace_acceso = "/destinos/ver/".$request->destinoIdSlider;
                    break;
                case 4:
                    $slider->enlace_acceso = "/eventos/ver/".$request->eventoIdSlider;
                    break;
                case 5:
                    
                    $slider->enlace_acceso = "/rutas/ver/".$request->rutaIdSlider;
                    //return $slider->enlace_acceso;
                    break;
                case 6:
                    $slider->enlace_acceso = "/proveedor/ver/".$request->proveedorIdSlider;
                    break;
                    
            }
        }else{
            $slider->es_interno = false;
            $slider->enlace_acceso = null;
        }
        if($request->imagenSlider != null){
            \File::delete(public_path() . $slider->ruta);
            $date = Carbon::now(); 
            $nombrex = "Slider"."-".date("Ymd-H:i:s").".".$request->imagenSlider->getClientOriginalExtension();
           \Storage::disk('Sliders')->put($nombrex,  \File::get($request->imagenSlider));
            $slider->ruta = "/Sliders/".$nombrex;
        }
        
        //$slider->fecha = $request->tituloSLider == null ? Carbon::now() : $request->fechaSlider;
        $slider->user_update = $this->user->username;
        $slider->updated_at = Carbon::now();
        $slider->save();
        
        $sliderIdioma = Slider_Idioma::where('slider_id',$slider->id)->first();
        $sliderIdioma->nombre = $request->tituloSlider == null ? "No tiene" : $request->tituloSlider;
        $sliderIdioma->descripcion = $request->textoAlternativoSlider;
        $sliderIdioma->user_update = $this->user->username;
        $sliderIdioma->updated_at = Carbon::now();
        $sliderIdioma->save();
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',$request->idiomaId)
            ->where('sliders.id',$slider->id)
            ->where('sliders_idiomas.idioma_id',$request->idiomaId)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")->first();
            
        $idiomas = Idioma::all();
            
            $sliders["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders["noIdiomas"] = $idiomasConsultados; 
        
        return ["success"=>true,"slider"=>$sliders];
	}
	
	public function postAgregaridiomaslider(Request $request){
	    $validator = \Validator::make($request->all(), [
            'textoAlternativoSlider' => 'string|min:1|max:255|required',
            'id' => 'required|exists:sliders,id',
            'idiomaIdSlider' => 'required|exists:idiomas,id',
            
        ],[
            'textoAlternativoSlider.string' => 'El texto alternativo debe ser de tipo string.',
            'textoAlternativoSlider.min' => 'El texto alternativo debe ser mínimo de 1 caracter.',
            'textoAlternativoSlider.max' => 'El texto alternativo debe ser maximo de 255 caracteres.',
            'textoAlternativoSlider.required' => 'El texto alternativo es requerida.',
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El registro que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            'idiomaIdSlider.required' => 'Debe seleccionar el idioma que desea agregar.',
            'idiomaIdSlider.exists' => 'El idioma seleccionado no se encuentra registrado en la base de datos, favor recargar la página.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $errores = [];
        if(Slider_Idioma::where('slider_id',$request->id)->where('idioma_id')->first() != null){
            $errores["Idioma"][0] = "El idioma que intenta agregar ya se encuentra relacionado con el slider seleccionado.";
        }
        
        if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
	    $sliderIdioma = new Slider_Idioma();
        $sliderIdioma->nombre = $request->tituloSlider == null ? "No tiene" : $request->tituloSlider;
        $sliderIdioma->descripcion = $request->textoAlternativoSlider;
        $sliderIdioma->idioma_id = $request->idiomaIdSlider;
        $sliderIdioma->slider_id = $request->id;
        $sliderIdioma->estado = true;
        $sliderIdioma->user_create = $this->user->username;
        $sliderIdioma->user_update = $this->user->username;
        $sliderIdioma->created_at = Carbon::now();
        $sliderIdioma->updated_at = Carbon::now();
        $sliderIdioma->save();
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->where('sliders.id',$request->id)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")->first();
            
        $idiomas = Idioma::all();
            
            $sliders["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders["idiomas"]);$j++){
                    if($idiomas[$k]["id"] != $sliders->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders["noIdiomas"] = $idiomasConsultados;
            
            return ["success"=>true,"slider"=>$sliders];
	}
	
	public function postSubirprioridad(Request $request){
	    $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:sliders,id',
            
        ],[
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El slider que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	    $slider = Slider::find($request->id);
	    if($slider->prioridad == 1){
	        $errores["Prioridad1"][0] = "El slider posee la máxima prioridad.";
	    }else if($slider->prioridad == 0){
	        $errores["Prioridad2"][0] = "El slider no posee prioridad asignada.";
	    }
	    
	    if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
	    
        $sliderAnterior = Slider::Where('prioridad',($slider->prioridad - 1))->where('prioridad','<>',0)->first();
        
        $slider->prioridad = $slider->prioridad - 1;
        $slider->save();
        if($sliderAnterior != null)
        {
            $sliderAnterior->prioridad = $slider->prioridad + 1;
            $sliderAnterior->save();
        }
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados; 
        }
        
        return ["success"=>true,"sliders"=>$sliders];
        
	}
	
	public function postBajarprioridad(Request $request){
	    $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:sliders,id',
            
        ],[
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El slider que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	    $slider = Slider::find($request->id);
	    if($slider->prioridad == 8){
	        $errores["Prioridad1"][0] = "El slider posee la mínima prioridad.";
	    }else if($slider->prioridad == 0){
	        $errores["Prioridad2"][0] = "El slider no posee prioridad asignada.";
	    }else if($slider->prioridad == Slider::where('estado',true)->count()){
	        $errores["Prioridad3"][0] = "El slider ya posee la prioridad más baja de los sliders activos.";
	    }
	    
	    if(sizeof($errores) > 0){
            return ['success'=>false, 'errores'=>$errores];
        }
        
        $sliderSiguiente = Slider::Where('prioridad',($slider->prioridad + 1))->where('prioridad','<>',0)->first();
        
        $slider->prioridad = $slider->prioridad + 1;
        $slider->save();
        if($sliderSiguiente != null)
        {
            $sliderSiguiente->prioridad = $slider->prioridad - 1;
            $sliderSiguiente->save();
        }
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados; 
        }
        
        return ["success"=>true,"sliders"=>$sliders];
        
	}
	
	public function postActivarslider(Request $request){
	    $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:sliders,id',
            
        ],[
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El registro que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        if (($request->prioridadSliderActivar < 1 || $request->prioridadSliderActivar > 8) && $request->bandera==1) {
            $errores["Prioridad"][0] = "La prioridad debe estar entre 1 y 8.";
        }
        $slider = Slider::find($request->id);
        
        if($slider->prioridad == 0){
            $activos = Slider::where('prioridad','<>',0)->where('estado',true)->count();
            $slidersActivos = Slider::where('prioridad','<>',0)->get();
            
            if ($activos <= 8){
                $slider->prioridad = 1;
                foreach ($slidersActivos as $item)
                {
                    if ($item->prioridad != 8)
                    {
                        $item->prioridad = $item->prioridad + 1;
                        $item->save();
                    }
                    else
                    {
                        $item->prioridad = 0;
                        $item->estado = false;
                        $item->save();
                    }
                }
            }
        }
        $slider->estado = true;
        $slider->save();
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados; 
        }
        
        return ["success"=>true,"sliders"=>$sliders];
	}
	
	public function postDesactivarslider(Request $request){
	    $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:sliders,id',
            
        ],[
            'id.required' => 'El slider es requerido.',
            'id.exists' => 'El registro que desea editar no se encuentra registrada en la base de datos, favor recargar la página.',
            ]
        );
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $slider = Slider::find($request->id);
        $slidersActivos = Slider::where('prioridad','<>',0)->get();
        if($slider->prioridad != 8){
            if ($slider->prioridad != 1 && sizeof($slidersActivos) != 1)
            {
                foreach ($slidersActivos as $item) {
                    if($item->prioridad > $slider->prioridad)
                    {
                        $item->prioridad = $item->prioridad - 1;
                        $item->save();
                    }
                }
            }
        }
        $slider->prioridad = 0;
        $slider->estado = false;
        $slider->save();
        
        $sliders = Slider::with('idiomas')->
            join('sliders_idiomas', 'sliders_idiomas.slider_id', '=', 'sliders.id')
            ->where('sliders_idiomas.idioma_id',1)
            ->select("sliders.prioridad as prioridadSlider","sliders.estado as estadoSlider","sliders.id","sliders.enlace_acceso as enlaceAccesoSlider","sliders_idiomas.descripcion as textoAlternativoSlider",
            "sliders.ruta as rutaSlider","sliders.es_interno as enlaceInterno","sliders_idiomas.nombre as tituloSlider")
            ->orderBy('sliders.estado','DESC')->orderBy('sliders.prioridad')
            ->get();
        $idiomas = Idioma::all();
        for($i=0;$i<sizeof($sliders);$i++){
            
            $sliders[$i]["noIdiomas"] = [];
            $idiomasConsultados = [];
            
            for($k=0;$k<sizeof($idiomas);$k++){
                for($j=0;$j<sizeof($sliders[$i]->idiomas);$j++){
                    if($idiomas[$k]["id"] != $sliders[$i]->idiomas[$j]->id){
                        array_push($idiomasConsultados, $idiomas[$k]);           
                    }
                }
            
            }
            $sliders[$i]["noIdiomas"] = $idiomasConsultados; 
        }
        
        return ["success"=>true,"sliders"=>$sliders];
	}
}