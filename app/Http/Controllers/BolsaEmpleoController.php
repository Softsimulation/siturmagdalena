<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Proveedores_rnt;
use App\Models\Nivel_Educacion;
use App\Models\Municipio;
use App\Models\Oferta_Vacante;

class BolsaEmpleoController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    
    public function getCrear(){
        return view('bolsaEmpleo.crear');
    }
    
    public function getEmpresas(){
        $proveedores = Proveedores_rnt::all();
        $nivelesEducacion = Nivel_Educacion::all();
        $municipio = Municipio::where('departamento_id', 1411)->get();
        
        return ["proveedores" => $proveedores, 'nivelesEducacion' => $nivelesEducacion, 'municipios' => $municipio];
    }
    
    public function postCrearvacante(Request $request){
        $validator = \Validator::make($request->all(), [
			'proveedor_id' => 'required|exists:proveedores_rnt,id',
			'nombre_vacante' => 'required|max:250',
			'numero_vacantes' => 'required|min:1',
			'perfil' => 'required',
			'fecha_inicio' => 'required',
			'anios_experiencia' => 'required|min:0',
			'municipio_id' => 'required|exists:municipios,id',
			'nivelEducacion' => 'required|exists:nivel_educacion,id',
			'salario' => 'min:0'
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(isset($request->fecha_fin)){
		    if($request->fecha_inicio > $request->fecha_fin){
    		    return ["success"=>false,"errores"=> [ ["La fecha de inicio no debe ser mayor a la de fin."] ] ];
    		}
		}
		
		
		$vacante = Oferta_Vacante::create([
	        'proveedores_rnt_id' => $request->proveedor_id,
	        'municipio_id' => $request->municipio_id,
	        'nivel_educacion_id' => $request->nivelEducacion,
	        'nombre' => $request->nombre_vacante,
	        'perfil' => $request->perfil,
	        'anios_experiencia' => $request->anios_experiencia,
	        'fecha_inicio' => $request->fecha_inicio,
	        'fecha_fin' => isset($request->fecha_fin) ? $request->fecha_fin : null,
	        'salario' => isset($request->salario) ? $request->salario : null,
	        'numero_vacantes' => $request->numero_vacantes,
	        'requisitos' => $request->requisitos,
	        'estado' => 1,
	        'user_create' => $this->user->username,
    		'user_update' => $this->user->username
	    ]);
		
		return ["success" => true];
    }
    
}
