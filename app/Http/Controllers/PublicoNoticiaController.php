<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

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

class PublicoNoticiaController extends Controller
{
	public function getListado(Request $request) {
	    //return $request->all();
	    //return strtolower($request->buscar);
	    $noticiasRetornar = [];
	    //$request->buscar = trim(strtoupper($request->buscar));
	    //return $request->buscar;
	    $noticias = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->leftjoin('multimedias_noticias', function($join)
        {
            $join->on('noticias.id', '=', 'multimedias_noticias.noticia_id')
                 ->where('multimedias_noticias.es_portada', '=', 1);
        })
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        ->where('noticias_has_idiomas.idiomas_id',1)->where('tipos_noticias_has_idiomas.idiomas_id',1)
        ->where('tipos_noticias.estado',1)
        ->where('noticias_has_idiomas.titulo','like','%'.$request->buscar.'%')
        
        //->where(function($q)use($request){ if( isset($request->tipoNoticia) && $request->tipoNoticia != null ){$q->where('tipos_noticias.id',$request->tipoNoticia);}})
        //->where(function($q)use($request){ if( isset($request->buscar) && $request->buscar != null ){$q->where(strtolower('noticias_has_idiomas.titulo'),'like','%'.strtolower($request->buscar).'%');}})             
        ->select("noticias.id as idNoticia","noticias.enlace_fuente","noticias.es_interno","noticias.estado",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen","noticias_has_idiomas.texto",
        "tipos_noticias.id as idTipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia","multimedias_noticias.ruta as portada", "multimedias_noticias.es_portada")->paginate(10);
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        //return $noticias;
        return view('noticias.ListadoNoticiasPublico',array('noticias' => $noticias,"tiposNoticias"=>$tiposNoticias));
	}
	public function getTop(Request $request) {
	    $noticias = Noticia::
        join('noticias_has_idiomas', 'noticias_has_idiomas.noticias_id', '=', 'noticias.id')
        ->join('tipos_noticias', 'tipos_noticias.id', '=', 'noticias.tipos_noticias_id')
        ->join('tipos_noticias_has_idiomas', 'tipos_noticias_has_idiomas.tipos_noticias_id', '=', 'tipos_noticias.id')
        ->leftjoin('multimedias_noticias', function($join)
        {
            $join->on('noticias.id', '=', 'multimedias_noticias.noticia_id')
                 ->where('multimedias_noticias.es_portada', '=', 1);
        })
        ->where('noticias_has_idiomas.idiomas_id',1)->where('tipos_noticias_has_idiomas.idiomas_id',1)
        ->where('tipos_noticias.estado',1)
        ->select("noticias.id as idNoticia","noticias.enlace_fuente","noticias.es_interno","noticias.estado", "noticias.created_at as fecha",
        "noticias_has_idiomas.titulo as tituloNoticia","noticias_has_idiomas.resumen","noticias_has_idiomas.texto",
        "tipos_noticias.id as idTipoNoticia","tipos_noticias_has_idiomas.nombre as nombreTipoNoticia","multimedias_noticias.ruta as portada", "multimedias_noticias.es_portada")->
        orderBy('fecha','DESC')->take(4)->get();
        
        $tiposNoticias = Tipo_noticia_Idioma::where('idiomas_id',1)->get();
        return $noticias;
        //return view('noticias.ListadoNoticiasPublico',array('noticias' => $noticias,"tiposNoticias"=>$tiposNoticias));
	}
	public function getVer($idNoticia){
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
        
        return view('noticias.Ver',array('noticia' => $noticia,"multimedias"=>$multimediaNoticia,"portada"=>$portada ));
	}
}