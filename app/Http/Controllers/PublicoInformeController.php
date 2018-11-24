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
use App\Models\Publicacione;
use App\Models\Idioma;
use App\Models\Tipo_Documento_Idioma;
use App\Models\Categoria_Documento_Idioma;

class PublicoInformeController extends Controller
{
	function getListado(Request $request){
        //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
        //Publicacione::where("estado",true)->delete();
        return view('informes.ListadoInformesPublico', array(
               "informes"=> Publicacione::
                   join('publicaciones_idioma', 'publicaciones_idioma.publicaciones_id', '=', 'publicaciones.id')
                   ->join('tipo_documento_idioma', 'tipo_documento_idioma.tipo_documento_id', '=', 'publicaciones.tipo_documento_id')
                   ->join('categoria_documento_idioma', 'categoria_documento_idioma.categoria_documento_id', '=', 'publicaciones.categoria_doucmento_id')
                   ->where('publicaciones_idioma.idioma_id',1)
                   ->where('tipo_documento_idioma.idioma_id',1)
                   ->where('categoria_documento_idioma.idioma_id',1)
                   ->where(function($q)use($request){ if( isset($request->tipoInforme) && $request->tipoInforme != null ){$q->where('publicaciones.tipo_documento_id',$request->tipoInforme);}})
                    ->where(function($q)use($request){ if( isset($request->categoriaInforme) && $request->categoriaInforme != null ){$q->where('publicaciones.categoria_doucmento_id',$request->categoriaInforme);}})
                    ->where(function($q)use($request){ if( isset($request->buscar) && $request->buscar != null ){$q->where(strtolower('noticias_has_idiomas.titulo'),'like','%',trim(strtolower($request->buscar)))
                                                                                                                   ->where(strtolower('noticias_has_idiomas.descripcion'),'like','%',trim(strtolower($request->buscar)))
                                                                                                                   ->where(strtolower('noticias_has_idiomas.autores'),'like','%',trim(strtolower($request->buscar)))
                    ;}}) 
                    ->select("publicaciones.id","publicaciones.autores", "publicaciones.volumen", "publicaciones.portada", "publicaciones.ruta", "publicaciones.fecha_creacion", 
                        "publicaciones.fecha_publicacion", "tipo_documento_idioma.nombre as tipoInforme", "categoria_documento_idioma.nombre as categoriaInforme",
                        "publicaciones_idioma.palabrasclaves as palabrasClaves", "publicaciones_idioma.nombre as tituloInforme", "publicaciones_idioma.descripcion")
                    ->orderBy('id')->paginate(10),
                   
                   /*with([ "idiomas"=>function($q){ $q->with(['idioma'=>function($s){$s->where('id',1);}]); }, 
                                                 "tipo"=>function($q){ $q->with([ "tipoDocumentoIdiomas"=>function($qq){ $qq->where("idioma_id",1); } ]); }, 
                                                 "categoria"=>function($q){ $q->with([ "categoriaDocumentoIdiomas"=>function($qq){ $qq->where("idioma_id",1); } ]); } 
                                                ])
                                                ->where(function($q)use($request){ if( isset($request->tipoInforme) && $request->tipoInforme != null ){$q->where('tipo_documento_id',$request->tipoInforme);}})
                                                ->where(function($q)use($request){ if( isset($request->categoriaInforme) && $request->categoriaInforme != null ){$q->where('categoria_doucmento_id',$request->categoriaInforme);}})
                                                ->orderBy('id')->paginate(10),*/
               "tipos"=> Tipo_Documento_Idioma::with(['tipoDocumento'=>function($s){$s->where('estado',true);}])->where('idioma_id',1)->get(),
               "categorias"=> Categoria_Documento_Idioma::with(['categoriaDocumento'=>function($s){$s->where("estado",true);}])->where('idioma_id',1)->get(),
            ));
       
    }
    function getVer($idInforme){
        //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
        //Publicacione::where("estado",true)->delete();
        return view('informes.VerInformePublico', array(
               "informe"=> Publicacione::
                   join('publicaciones_idioma', 'publicaciones_idioma.publicaciones_id', '=', 'publicaciones.id')
                   ->join('tipo_documento_idioma', 'tipo_documento_idioma.tipo_documento_id', '=', 'publicaciones.tipo_documento_id')
                   ->join('categoria_documento_idioma', 'categoria_documento_idioma.categoria_documento_id', '=', 'publicaciones.categoria_doucmento_id')
                   ->where('publicaciones_idioma.idioma_id',1)
                   ->where('tipo_documento_idioma.idioma_id',1)
                   ->where('categoria_documento_idioma.idioma_id',1)
                   ->where('publicaciones.id',$idInforme)
                   ->select("publicaciones.id","publicaciones.autores", "publicaciones.volumen", "publicaciones.portada", "publicaciones.ruta", "publicaciones.fecha_creacion", 
                        "publicaciones.fecha_publicacion", "tipo_documento_idioma.nombre as tipoInforme", "categoria_documento_idioma.nombre as categoriaInforme",
                        "publicaciones_idioma.palabrasclaves as palabrasClaves", "publicaciones_idioma.nombre as tituloInforme", "publicaciones_idioma.descripcion")
                    ->first()
                   
            ));
       
    }
}