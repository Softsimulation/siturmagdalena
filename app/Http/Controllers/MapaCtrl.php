<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Tipo_Proveedor;
use App\Models\Tipo_Atraccion;
use App\Models\Destino;
use App\Models\Atracciones;
use App\Models\Proveedores_rnt;


class MapaCtrl extends Controller
{
    
    
    public function getIndex(){
        return View("mapa.index");
    }
    
    public function getData(){
        
        $idioma = 1;
        
        return json_encode([
                 "tipoProveedores" => Tipo_Proveedor::where("estado",true)->with(['tipoProveedoresConIdiomas'=>function($q) use($idioma){ $q->where("idiomas_id",$idioma); } ])->get(["id","icono_cerca","icono_lejos"]),
                 "tipoAtracciones" => Tipo_Atraccion::where("estado",true)->with(['tipoAtraccionesConIdiomas'=>function($q) use($idioma){ $q->where("idiomas_id",$idioma); } ])->get(["id"]),
                 "destinos" => Destino::where("estado",true)->with([ "multimediaDestinos"=>function($qq){ $qq->where("portada",true);} ,'destinoConIdiomas'=>function($q) use($idioma){ $q->where("idiomas_id",$idioma); } ])->get(),
                 "atracciones" => Atracciones::where("estado",true)->with([ 'atraccionesConTipos','sitio'=>function($q) use($idioma){ $q->with([ "multimediaSitios"=>function($qq){ $qq->where("portada",true);}, "sitiosConIdiomas"=>function ($qq)use($idioma){ $qq->where("idiomas_id",$idioma); }  ]);}])->get(),
                 "proveedores" => Proveedores_rnt::where("estado",true)->with([ "categoria", "proveedor"=>function($q){ $q->with([ "multimediaProveedores"=>function($qq){ $qq->where("portada",true)->select("id","proveedor_id","ruta"); }])->select("id","proveedor_rnt_id");  }])->get(["id","categoria_proveedores_id","razon_social","latitud","longitud", "direccion"])
               ]);
    }
    
    
    
    
}
