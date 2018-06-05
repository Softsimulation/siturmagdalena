<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Departamento;
use App\Models\Pais;

use App\Http\Requests;

class AdministrarDepartamentosController extends Controller
{
    //
    public function getIndex(){
        return view('administrardepartamentos.Index');
    }
    
    public function getDatos(){
        $departamentos = Departamento::select('pais_id', 'id', 'nombre', 'updated_at', 'user_update')->orderBy('pais_id')->get();
        $paises = Pais::with(['paisesConIdiomas' => function ($q){
            $q->with(['idioma' => function($i){
                $i->select('id', 'culture', 'nombre');
            }], 'nombre');
        }], 'id')->select('id', 'user_update', 'updated_at')->get();
        return ['departamentos' => $departamentos, 'paises' => $paises, 'success' => true];
    }
}
