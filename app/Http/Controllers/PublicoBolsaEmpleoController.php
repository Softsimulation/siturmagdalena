<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Oferta_Vacante;
use App\Models\Proveedores_rnt;
use App\Models\Nivel_Educacion;
use App\Models\Municipio;
use App\Models\Tipo_Cargo_Vacante;

class PublicoBolsaEmpleoController extends Controller
{
    
    public function __construct()
	{
	    $this->middleware('auth', ['only' => ['getMispostulaciones'] ]);
	}
    
    public function getVer($id){
        $vacante = Oferta_Vacante::find($id);
        if($vacante == null){
            return \Redirect::to('/promocionBolsaEmpleo/vacantes')->with('message', 'Verifique que la vacante se encuentre registrada en el sistema.')
                        ->withInput();
            // return "No existe vacante";
        }
        
        
        
        $otrasVacantes = Oferta_Vacante::where('estado',1)->where('id','<>',$id)->where('proveedores_rnt_id', $vacante->proveedores_rnt_id)->where(function($q){$q->where('fecha_vencimiento','>=',date('Y-m-d'))->orWhereNull('fecha_vencimiento');})->take(3)->get();
        
        return view('bolsaEmpleo.promocionVer', ['vacante' => $vacante, 'otrasVacantes' => $otrasVacantes]);
    }
    
    public function getVacantes(Request $request){
        
        $vacantes = Oferta_Vacante::where('estado',1)
                    ->search($request)
                    ->paginate(6);
        
        $proveedores = Proveedores_rnt::whereHas('vacantes',function($q){
            $q->where('estado',1)->where(function($q){$q->where('fecha_vencimiento','>=',date('Y-m-d'))->orWhereNull('fecha_vencimiento');});
        })->get();
        
        $nivelesEducacion = Nivel_Educacion::all();
        
        $tiposCargos = Tipo_Cargo_Vacante::all();
        
        $municipios = Municipio::where('departamento_id', 1411)->get();
        
        return view('bolsaEmpleo.promocionListado', ['vacantes' => $vacantes, 'tiposCargos' => $tiposCargos ,'proveedores' => $proveedores, 'nivelesEducacion' => $nivelesEducacion, 'municipios' => $municipios]);
    }
    
    public function getMispostulaciones(){
        $user = \Auth::user();
        
        return view('bolsaEmpleo.usuarioPostulaciones',['user' => $user]);
    }
    
}
