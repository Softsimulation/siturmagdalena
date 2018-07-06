<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Atracciones;
use App\Models\Idioma;
use App\Models\Tipo_Atraccion;
use App\Models\Destino;
use App\Models\Sector;

class AdministradorAtraccionController extends Controller
{
    //
    
    public function getIndex(){
        return view('administradoratracciones.Index');
    }
    
    public function getCrear(){
        return view('administradoratracciones.Crear');
    }
    
    public function getDatoscrear(){
        // $destinos = Destino::with(['sectores' => function ($querySectores){
        //     $querySectores->with(['sectoresConIdiomas' => function ($querySectoresConIdiomas){
        //         $querySectoresConIdiomas->with(['idioma' => function($queryIdiomas){
        //             $queryIdiomas->select('id' ,'nombre', 'culture');
        //         }])->select('idiomas_id', 'sectores_id', 'nombre');
        //     }])->select('id', 'destino_id', 'es_urbano');
        // }])->with(['destinoConIdiomas' => function ($queryDestinoConIdiomas){
        //     $queryDestinoConIdiomas->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
        // }])->select('latitud', 'longitud', 'id')->get();
        
        $sectores = Sector::with(['destino' => function ($queryDestino){
            $queryDestino->with(['destinoConIdiomas' => function($queryDestinoConIdiomas){
                $queryDestinoConIdiomas->select('destino_id', 'idiomas_id', 'nombre', 'descripcion');
            }])->select('latitud', 'longitud', 'id');
        }])->with(['sectoresConIdiomas' => function ($querySectoresConIdiomas){
            $querySectoresConIdiomas->with(['idioma' => function($queryIdiomas){
                $queryIdiomas->select('id' ,'nombre', 'culture');
            }])->select('idiomas_id', 'sectores_id', 'nombre');
        }])->select('id', 'destino_id', 'es_urbano')->groupBy('destino_id', 'es_urbano', 'id')->get();
        return ['success' => true, 'sectores' => $sectores];
    }
    
    public function getDatos (){
        $idiomas = Idioma::select('id', 'nombre', 'culture')->where('estado', true)->get();
        
        $atracciones = Atracciones::with(['sitio' => function ($q){
            $q->with(['sitiosConIdiomas' => function($x){
                $x->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }])->select('id', 'idioma_id', 'nombre', 'descripcion')->get();
            }])->get();
        }, 'atraccionesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }])->select('como_llegar', 'idioma_id')->get();
        }, 'atraccionesConTipos' => function($q){
            $q->with(['tipoAtraccione' => function($a){
                $a->with(['tipoAtraccionesConIdiomas' => function($ta){
                        $ta->with(['idioma' => function($i){
                            $i->select('id', 'nombre', 'culture');
                    }])->select('nombre', 'idioma_id')->get();
                }])->select('tipo_atracciones_id', 'idioma_id', 'id', 'nombre')->get();
            }])->get();
        }])->select('id', 'sitios_id', 'estado', 'telefono', 'sitio_web', 'valor_min', 'valor_max')->get();
        
        $tiposAtracciones = Tipo_Atraccion::with(['tipoAtraccionesConIdiomas' => function ($query){
            $query->with(['idioma' => function ($idioma){
                $idioma->select('id', 'nombre', 'culture');
            }])->select('id', 'nombre', 'idiomas_id', 'tipo_atracciones_id');
        }])->select('id')->get();
        return ['atracciones' => $atracciones, 'idiomas' => $idiomas, 'tiposAtracciones' => $tiposAtracciones];
    }
}
