<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Oferta_Vacante;
use App\Models\Proveedores_rnt;
use App\Models\Nivel_Educacion;
use App\Models\Municipio;

class PublicoBolsaEmpleoController extends Controller
{
    public function getVer($id){
        $vacante = Oferta_Vacante::find($id);
        if($vacante == null){
            // return \Redirect::to('/bolsaEmpleo/vacantes')->with('message', 'Verifique que el visitante este en la sección adecuada.')
            //             ->withInput();
            return "No existe vacante";
        }
        
        
        
        $otrasVacantes = Oferta_Vacante::where('estado',1)->where('id','<>',$id)->where('proveedores_rnt_id', $vacante->proveedores_rnt_id)->where(function($q){$q->where('fecha_fin','>=',date('Y-m-d'))->orWhereNull('fecha_fin');})->take(3)->get();
        
        return view('bolsaEmpleo.promocionVer', ['vacante' => $vacante, 'otrasVacantes' => $otrasVacantes]);
    }
    
    public function getVacantes(){
        $vacantes = Oferta_Vacante::where('estado',1)->where(function($q){$q->where('fecha_fin','>=',date('Y-m-d'))->orWhereNull('fecha_fin');})->get();
        
        $proveedores = Proveedores_rnt::whereHas('vacantes',function($q){
            $q->where('estado',1)->where(function($q){$q->where('fecha_fin','>=',date('Y-m-d'))->orWhereNull('fecha_fin');});
        })->get();
        
        $nivelesEducacion = Nivel_Educacion::all();
        
        $municipios = Municipio::where('departamento_id', 1411)->get();
        
        return view('bolsaEmpleo.promocionListado', ['vacantes' => $vacantes, 'proveedores' => $proveedores, 'nivelesEducacion' => $nivelesEducacion, 'municipios' => $municipios]);
    }
    
}
