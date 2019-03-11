<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Indicadores_medicion;

class IndicadoresMedicionController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    public function getListado(){
        //return $this->user;
        return view('IndicadoresMedicion.ListadoIndicadoresMedicion');
    }
    public function getIndicadoresmedicion(){
        
        $indicadores = Indicadores_medicion::
                                    with([ "graficas","idiomas"=>function($q) { $q->where("idioma_id", 1); } ])
                                    ->orderBy('peso', 'asc')->get();
                                    
        return ["indicadores"=>$indicadores];
    }
}
