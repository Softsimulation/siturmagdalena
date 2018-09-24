<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedor;

class ProveedoresController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Proveedor::find($id) == null){
            return response('Not found.', 404);
        }
        
        $proveedor = Proveedor::with(['proveedorRnt' => function ($queryProveedorRnt){
            $queryProveedorRnt->with(['idiomas' => function ($queyProveedor_rnt_idioma){
                $queyProveedor_rnt_idioma->select('proveedor_rnt_id', 'idioma_id', 'descripcion')->orderBy('idioma_id');
            }])->select('id', 'razon_social');
        }, 'proveedoresConIdiomas' => function ($queryProveedoresConIdiomas){
            $queryProveedoresConIdiomas->select('idiomas_id', 'proveedores_id', 'horario')->where('idiomas_id', 2);
        }, 'multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', false)->orderBy('portada', 'desc')->select('proveedor_id', 'ruta');
        }, 'actividadesProveedores' => function ($queryActividadesProveedores){
            $queryActividadesProveedores->with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
                $queryActividadesConIdiomas->select('actividades_id', 'idiomas', 'nombre');
            }])->select('actividades.id');
        }])->select('id', 'proveedor_rnt_id', 'telefono', 'sitio_web', 'valor_min', 'valor_max')->where('id', $id)->first();
        
        $video_promocional = Proveedor::with(['multimediaProveedores' => function ($queryMultimediaProveedores){
            $queryMultimediaProveedores->where('tipo', true)->select('proveedor_id', 'ruta');
        }])->first()->multimediaProveedores[0]->ruta;
        
        //return ['proveedor' => $proveedor, 'video_promocional' => $video_promocional];
        return view('proveedor.Ver', ['proveedor' => $proveedor, 'video_promocional' => $video_promocional]);
    }
}
