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
use App\Models\Tipo_Cargo_Vacante;

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
        $tiposCargos = Tipo_Cargo_Vacante::all();
        $municipio = Municipio::where('departamento_id', 1411)->get();
        
        return ["proveedores" => $proveedores, 'nivelesEducacion' => $nivelesEducacion, 'municipios' => $municipio, 'tiposCargos' => $tiposCargos];
    }
    
    public function postCrearvacante(Request $request){
        $validator = \Validator::make($request->all(), [
			'proveedor_id' => 'required|exists:proveedores_rnt,id',
			'nombre_vacante' => 'required|max:250',
			'numero_vacantes' => 'required|min:1',
			'descripcion' => 'required|max:1000',
			'anios_experiencia' => 'required|min:0',
			'municipio_id' => 'required|exists:municipios,id',
			'nivelEducacion' => 'required|exists:nivel_educacion,id',
			'tipo_cargo_vacante_id' => 'required|exists:tipos_cargos_vacantes,id',
			'salario_minimo' => 'min:0',
			'banderPublicar' => 'required|between:0,1',
			'requisitos' => 'required|max:3000',
			'numero_maximo_postulaciones' => 'min:1'
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(isset($request->fecha_vencimiento)){
		    if($request->fecha_vencimiento < date('d-m-Y') ){
    		    return ["success"=>false,"errores"=> [ ["La fecha de vencimiento no puede ser menor a la fecha actual."] ] ];
    		}
		}
		
		if(isset($request->salario_minimo) && isset($request->salario_maximo)){
			if($request->salario_minimo > $request->salario_maximo){
				return ["success"=>false,"errores"=> [ ["El salario mínimo no puede ser mayor al salario máximo."] ] ];
			}
		}
		
		
		$vacante = Oferta_Vacante::create([
	        'proveedores_rnt_id' => $request->proveedor_id,
	        'municipio_id' => $request->municipio_id,
	        'nivel_educacion_id' => $request->nivelEducacion,
	        'tipo_cargo_vacante_id' => $request->tipo_cargo_vacante_id,
	        'nombre' => $request->nombre_vacante,
	        'descripcion' => $request->descripcion,
	        'anios_experiencia' => $request->anios_experiencia,
	        'numero_maximo_postulaciones' => isset($request->numero_maximo_postulaciones) ? $request->numero_maximo_postulaciones : null,
	        'fecha_vencimiento' => isset($request->fecha_vencimiento) ? $request->fecha_vencimiento : null,
	        'salario_minimo' => isset($request->salario_minimo) ? $request->salario_minimo : null,
	        'salario_maximo' => isset($request->salario_maximo) ? $request->salario_maximo : null,
	        'numero_vacantes' => $request->numero_vacantes,
	        'requisitos' => $request->requisitos,
	        'fecha_publicacion' => $request->banderPublicar == 1 ? date('Y-m-d') : null,
	        'estado' => 1,
	        'es_publico' => $request->banderPublicar,
	        'user_create' => $this->user->username,
    		'user_update' => $this->user->username
	    ]);
		
		return ["success" => true];
    }
    
    public function getEditarvacante($id){
        if(Oferta_Vacante::find($id) == null){
            return \Redirect::to('/bolsaEmpleo/vacantes')->with('message', 'Verifique que el visitante este en la sección adecuada.')
                        ->withInput();
        }
        
        return view('bolsaEmpleo.editar', ['id' => $id]);
    }
    
    public function getCargareditarvacante($id){
        $vacante = Oferta_Vacante::where('id',$id)->with(['proveedoresRnt','municipio','nivelEducacion','tiposCargosVacante'])->first();
        $vacante['salario'] = floatval($vacante->salario);
    
        $proveedores = Proveedores_rnt::all();
        $nivelesEducacion = Nivel_Educacion::all();
        $municipio = Municipio::where('departamento_id', 1411)->get();
        $tiposCargos = Tipo_Cargo_Vacante::all();
        
        return ['vacante' => $vacante,"proveedores" => $proveedores, 'tiposCargos' => $tiposCargos ,'nivelesEducacion' => $nivelesEducacion, 'municipios' => $municipio];
        
    }
    
    public function postEditarvacante(Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:ofertas_vacantes,id',
			'proveedores_rnt_id' => 'required|exists:proveedores_rnt,id',
			'nombre' => 'required|max:250',
			'numero_vacantes' => 'required|min:1',
			'descripcion' => 'required|max:1000',
			'anios_experiencia' => 'required|min:0',
			'municipio_id' => 'required|exists:municipios,id',
			'nivel_educacion_id' => 'required|exists:nivel_educacion,id',
			'tipo_cargo_vacante_id' => 'required|exists:tipos_cargos_vacantes,id',
			'salario_minimo' => 'min:0',
			'requisitos' => 'required|max:3000',
			'numero_maximo_postulaciones' => 'min:1'
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if(isset($request->fecha_vencimiento)){
		    if($request->fecha_vencimiento < date('d-m-Y') ){
    		    return ["success"=>false,"errores"=> [ ["La fecha de vencimiento no puede ser menor a la fecha actual."] ] ];
    		}
		}
		
		if(isset($request->salario_minimo) && isset($request->salario_maximo)){
			if($request->salario_minimo > $request->salario_maximo){
				return ["success"=>false,"errores"=> [ ["El salario mínimo no puede ser mayor al salario máximo."] ] ];
			}
		}
		
		$vacante = Oferta_Vacante::find($request->id);
		$vacante->proveedores_rnt_id = $request->proveedores_rnt_id;
		$vacante->nombre = $request->nombre;
		$vacante->numero_vacantes = $request->numero_vacantes;
		$vacante->descripcion = $request->descripcion;
		$vacante->numero_maximo_postulaciones = isset($request->numero_maximo_postulaciones) ? $request->numero_maximo_postulaciones : null;
		$vacante->fecha_vencimiento = isset($request->fecha_vencimiento) ? $request->fecha_vencimiento : null;
		$vacante->anios_experiencia = $request->anios_experiencia;
		$vacante->municipio_id = $request->municipio_id;
		$vacante->nivel_educacion_id = $request->nivel_educacion_id;
		$vacante->tipo_cargo_vacante_id = $request->tipo_cargo_vacante_id;
		$vacante->salario_minimo = isset($request->salario_minimo) ? $request->salario_minimo : null;
		$vacante->salario_maximo = isset($request->salario_maximo) ? $request->salario_maximo : null;
		$vacante->requisitos = $request->requisitos;
		$vacante->save();
		
		return ['success' => true];
    }
    
    public function getVacantes(){
        return view('bolsaEmpleo.index');
    }
    
    public function getCargarvacantes(){
        $vacantes = Oferta_Vacante::with(['proveedoresRnt','municipio','nivelEducacion','tiposCargosVacante'])->get();
        return ['vacantes' => $vacantes];
    }
    
    public function postCambiarestadovacante(Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:ofertas_vacantes,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		
		$vacante = Oferta_Vacante::find($request->id);
		$vacante->estado = !$vacante->estado;
		$vacante->save();
		
		return ["success" => true];
    }
    
    public function postCambiarestadopublicovacante(Request $request){
    	$validator = \Validator::make($request->all(), [
            'id' => 'required|exists:ofertas_vacantes,id',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$vacante = Oferta_Vacante::find($request->id);
		
		if(isset($vacante->fecha_vencimiento)){
		    if($vacante->fecha_vencimiento < date('d-m-Y') ){
    		    return ["success"=>false,"errores"=> [ ["No se puede publicar una vacante cuya fecha de vencimiento es menor a la actual."] ] ];
    		}
		}
		
		$vacante->es_publico = !$vacante->es_publico;
		$vacante->save();
		
		return ["success" => true];
    }
    
}
