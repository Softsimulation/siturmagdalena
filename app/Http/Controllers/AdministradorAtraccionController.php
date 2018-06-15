<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atracciones;
use App\Models\Idioma;
use App\Http\Requests;

class AdministradorAtraccionController extends Controller
{
    //
    
    public function getListado (){
        $idiomas = Idioma::select('id', 'nombre', 'culture')->where('estado', true)->get();
        
        $atracciones = Atracciones::with(['id', 'sitio' => function ($q){
            $q->with(['sitiosConIdiomas' => function($x){
                $x->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }, 'nombre', 'descripcion'])->get();
            }])->get();
        }, 'atraccionesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                    $i->select('id', 'nombre', 'culture');
                }, 'como_llegar'])->get();
        }, 'atraccionesConTipos' => function($q){
            $q->with(['tipoAtraccione' => function($a){
                $a->with(['tipoAtraccionesConIdiomas' => function($ta){
                        $ta->with(['idioma' => function($i){
                        $i->select('id', 'nombre', 'culture');
                    }, 'nombre'])->get();
                }])->get();
            }])->get();
        }, 'estado', 'telefono', 'sitio_web', 'valor_min', 'valor_max'])->get();
        return view('administradoratracciones.Listado', ['atracciones' => $atracciones, 'idiomas' => $idiomas]);
    }
}
