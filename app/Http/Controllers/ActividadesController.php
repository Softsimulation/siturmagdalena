<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Actividad;

class ActividadesController extends Controller
{
    //
    public function getVer($id){
        if ($id == null){
            return response('Bad request.', 400);
        }elseif(Actividad::find($id) == null){
            return response('Not found.', 404);
        }
        
        $actividad = Actividad::with(['actividadesConIdiomas' => function ($queryActividadesConIdiomas){
            $queryActividadesConIdiomas->orderBy('idiomas')->select('actividades_id', 'idiomas', 'nombre', 'descripcion');
        }, 'multimediasActividades' => function($queryMultimediasActividades){
            $queryMultimediasActividades->orderBy('portada', 'desc')->select('actividades_id', 'ruta');
        }, 'sitiosConActividades' => function ($querySitiosConActividades){
            $querySitiosConActividades->with(['sitiosConIdiomas' => function($querySitiosConIdiomas){
                $querySitiosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'sitios_id', 'nombre', 'descripcion');
            }])->select('sitios.id', 'sitios.latitud', 'sitios.longitud');
        }, 'perfilesUsuariosConActividades' => function ($queryPerfilesUsuariosConActividades){
            $queryPerfilesUsuariosConActividades->with(['perfilesUsuariosConIdiomas' => function($queryPerfilesUsuariosConIdiomas){
                $queryPerfilesUsuariosConIdiomas->orderBy('idiomas_id')->select('idiomas_id', 'perfiles_usuarios_id', 'nombre');
            }])->select('perfiles_usuarios.id');
        }, 'categoriaTurismoConActividades' => function($queryCategoriaTurismoConActividades){
            $queryCategoriaTurismoConActividades->with(['categoriaTurismoConIdiomas' => function ($queryCategoriaTurismoConIdiomas){
                $queryCategoriaTurismoConIdiomas->orderBy('idiomas_id')->select('categoria_turismo_id', 'idiomas_id', 'nombre');
            }])->select('categoria_turismo.id');
        }])->where('id', $id)->select('id', 'valor_min', 'valor_max', 'calificacion_legusto', 'calificacion_llegar', 'calificacion_recomendar', 'calificacion_volveria')->first();
        
        //return ['actividad' => $actividad];
        return view('actividades.Ver', ['actividad' => $actividad]);
    }
}
