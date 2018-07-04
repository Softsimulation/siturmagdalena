<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use CsvReader;

use App\Models\Departamento;
use App\Models\Pais;
use App\Models\Pais_Con_Idioma;

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
    
    public function postCreardepartamento(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'pais_id' => 'required|exists:paises,id|numeric'
        ],[
            'nombre.required' => 'El nombre del departamento es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'pais_id.required' => 'Se necesita un identificador para el país.',
            'pais_id.exists' => 'El país seleccionado no se encuentra registrado en la base de datos.',
            'pais_id.numeric' => 'El identificador del país debe ser un dato numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $departamento = Departamento::where('pais_id' ,$request->pais_id)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->get();
        if (count($departamento) > 0){
            $errores["existe"][0] = "Este departamento ya está registrado en este país.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $departamento = new Departamento();
        $departamento->nombre = $request->nombre;
        $departamento->pais_id = $request->pais_id;
        $departamento->estado = true;
        $departamento->user_update = "Situr";
        $departamento->user_create = "Situr";
        $departamento->created_at = Carbon::now();
        $departamento->updated_at = Carbon::now();
        $departamento->save();
        
        return ['success' => true, 'departamento' => $departamento];
    }
    
    public function postEditardepartamento(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'pais_id' => 'required|exists:paises,id|numeric',
            'id' => 'required|exists:departamentos|numeric'
        ],[
            'nombre.required' => 'El nombre del departamento es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'pais_id.required' => 'Se necesita un identificador para el país.',
            'pais_id.exists' => 'El país seleccionado no se encuentra registrado en la base de datos.',
            'pais_id.numeric' => 'El identificador del país debe ser un dato numérico.',
            
            'id.required' => 'Se necesita un identificador para el departamento.',
            'id.exists' => 'El identificador del departamento no está registrado en la base de datos.',
            'id.numeric' => 'El identificador del departamento debe ser un dato numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $departamento = Departamento::where('pais_id' ,$request->pais_id)->where('nombre', $request->nombre)->get();
        if (count($departamento) > 0){
            $errores["existe"][0] = "Este departamento ya está registrado en este país.";
        }
        unset($departamento);
        $departamento = Departamento::find($request->id)->where('nombre', $request->nombre)->where('pais_id', $request->pais_id)->get();
        if (count($departamento) > 0){
            $errores["existe"][0] = "No se ha modificado el nombre del departamento.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $departamento = Departamento::find($request->id);
        $departamento->nombre = $request->nombre;
        $departamento->pais_id = $request->pais_id;
        $departamento->user_update = "Situr";
        $departamento->updated_at = Carbon::now();
        $departamento->save();
        
        $departamentoReturn = Departamento::where('id', $departamento->id)
            ->select('pais_id', 'id', 'nombre', 'updated_at', 'user_update')->first();
        
        return ['success' => true, 'departamento' => $departamentoReturn];
    }
    
    public function postImportexcel (Request $request){
        $errores = [];
        if ($request->hasFile('import_file')){
            $reader = CsvReader::open($request->import_file, ';');
            $header = $reader->getHeader();
            if (count($header) > 3 || !in_array('nombreDepartamento', $header) || !in_array('nombrePais', $header)){
                $errores['file'][0] = "Error al cargar el archivo. El documento no tiene la estructura especificada. 
                    Debe incluir los encabezados 'nombreDepartamento' y 'nombrePais' al archivo.";
                return ['success' => false, 'errores' => $errores, 'header' => $header];
            }
            
            $errores['departamentos'] = array();
		    while(($line = $reader->readLine()) !== false){
	            if (!is_numeric($line['nombrePais']) && !is_numeric($line['nombreDepartamento'])){
	                $paisConIdioma = Pais_Con_Idioma::whereRaw("LOWER(nombre) = '".strtolower($line['nombrePais'])."'")->get()->first();
		            if ($paisConIdioma == null){
		                $paisConIdioma = new Pais_Con_Idioma();
                        $paisConIdioma->nombre = $line['nombrePais'];
                        $paisConIdioma->idioma_id = 1;
                        
                        $pais = new Pais();
                        $pais->created_at = Carbon::now();
                        $pais->updated_at = Carbon::now();
                        $pais->user_create = "Situr";
                        $pais->user_update = "Situr";
                        $pais->estado = true;
                        
                        $pais->save();
                        $paisConIdioma->pais_id = $pais->id;
                        $paisConIdioma->save();
		            }
		            $departamento = Departamento::where('pais_id', $paisConIdioma->pais_id)->whereRaw("LOWER(nombre) = '".strtolower($line['nombreDepartamento'])."'")->first();
    		        if ($departamento == null){
    		            $departamento = new Departamento();
    		            $departamento->nombre = $line['nombreDepartamento'];
    		            $departamento->estado = true;
    		            $departamento->created_at = Carbon::now();
    		            $departamento->updated_at = Carbon::now();
    		            $departamento->user_update = "Situr";
    		            $departamento->user_create = "Situr";
    		            $departamento->pais_id = $paisConIdioma->pais_id;
    		            $departamento->save();
    		        }
		        }
		    }
		    if (count($errores['departamentos']) != 0){
		        return ['success' => false, 'errores' => $errores];
		    }else{
		        ['success' => true];
		    }
		    return ['success' => true];
        }else{
            $errores['file'][0] = 'No se ha enviado ningún archivo.';
            return ['success' => false, 'errores' => $errores];
        }
    }
}
