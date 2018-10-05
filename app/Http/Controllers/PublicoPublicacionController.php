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
use App\Models\Publicacion;
use App\Models\TipoPublicacion;

class PublicoPublicacionController extends Controller
{
	function getListado(Request $request){
	 //return $request->all();
        //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
        //Publicacione::where("estado",true)->delete();
        return view('publicaciones.ListadoPublicoPublicacion', array(
               "publicaciones"=> Publicacion::
                where(function($s){ if( isset($request->tipoPublicacion) && $request->tipoPublicacion != null ){$s->where('publicaciones_obras.tipos_publicaciones_obras_id',intval($request->tipoPublicacion));}})
                ->with( ["tipopublicacion"=>function($qrr) use($request){
                   
                   $qrr->with(["idiomas" => function($qrrr) use($request){ $qrrr->where("idiomas_id",1)
                   ; } ])
                   ;
                
               }, "estadoPublicacion" ])
               
                   ->orderBy('id')->paginate(10),
                   
               "tipos"=> TipoPublicacion::join("idiomas_has_tipos_publicaciones_obras","idiomas_has_tipos_publicaciones_obras.tipos_publicaciones_obras_id","=","tipos_publicaciones_obras.id")->where("idiomas_has_tipos_publicaciones_obras.idiomas_id","=",1)->select("idiomas_has_tipos_publicaciones_obras.nombre as nombre ","tipos_publicaciones_obras.id as id")->get()    
                ));
       
    }
}