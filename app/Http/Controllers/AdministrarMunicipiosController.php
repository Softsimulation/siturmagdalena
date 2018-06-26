<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use CsvReader;

use App\Models\Municipio;
use App\Models\Departamento;
use App\Models\Pais;
use App\Models\Pais_Con_Idioma;

use App\Http\Requests;

class AdministrarMunicipiosController extends Controller
{
    //
    public function getIndex(){
        return view('administrarmunicipios.Index');
    }
    
    public function getDatos(){
        $municipios = Municipio::select('id', 'departamento_id', 'nombre', 'updated_at', 'user_update')->orderBy('departamento_id')->get();
        $departamentos = Departamento::with(['paise' => function ($q){
            $q->with(['paisesConIdiomas' => function ($query){
                $query->where('idioma_id',1)->select('id','idioma_id', 'nombre','pais_id');
            }])->select('id');
        }])->select('nombre', 'updated_at', 'user_update', 'id','pais_id')->get();

        return ['municipios' => $municipios, 'departamentos' => $departamentos, 'success' => true];
    }
    
    public function postCrearmunicipio(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'departamento_id' => 'required|exists:departamentos,id|numeric'
        ],[
            'nombre.required' => 'El nombre del municipio es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'departamento_id.required' => 'Se necesita un identificador para el departamento.',
            'departamento_id.exists' => 'El departamento seleccionado no se encuentra registrado en la base de datos.',
            'departamento_id.numeric' => 'El identificador del departamento debe ser un dato numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $municipio_ = Municipio::where('departamento_id' ,$request->departamento_id)->whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($municipio_ != null){
            $errores["existe"][0] = "Este municipio ya está registrado en este departamento.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $municipio = new Municipio();
        $municipio->nombre = $request->nombre;
        $municipio->departamento_id = $request->departamento_id;
        $municipio->estado = true;
        $municipio->updated_at = Carbon::now();
        $municipio->created_at = Carbon::now();
        $municipio->user_update = "Situr";
        $municipio->user_create = "Situr";
        $prueba = $municipio->save();
        
        $municipioReturn = Municipio::where('id', $municipio->id)->select('id', 'departamento_id', 'nombre', 'updated_at', 'user_update')->first();
        
        return ['success' => true, 'municipio' => $municipioReturn ];
    }
    
    public function postEditarmunicipio(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'departamento_id' => 'required|exists:departamentos,id|numeric',
            'id' => 'required|exists:municipios|numeric'
        ],[
            'nombre.required' => 'El nombre del municipio es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'departamento_id.required' => 'Se necesita un identificador para el departamento.',
            'departamento_id.exists' => 'El departamento seleccionado no se encuentra registrado en la base de datos.',
            'departamento_id.numeric' => 'El identificador del departamento debe ser un dato numérico.',
            
            'id.required' => 'El identificador del municipio es necesario.',
            'id.exists' => 'El identificador del municipio ingresado no existe en la base de datos.',
            'id.numeric' => 'El identificador del municipio debe ser un dato numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $departamento = Municipio::where('id' ,$request->id)->where('nombre', $request->nombre)->get();
        if (count($departamento) > 0){
            $errores["existe"][0] = "Este municipio ya está registrado con este nombre.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $municipio = Municipio::find($request->id);
        $municipio->nombre = $request->nombre;
        $municipio->departamento_id = $request->departamento_id;
        $municipio->updated_at = Carbon::now();
        $municipio->user_update = "Situr";
        $municipio->save();
        
        return ['success' => true, 'municipio' => $municipio];
    }
    
    public function postImportexcel (Request $request){
        $errores = [];
        if ($request->hasFile('import_file')){
            $reader = CsvReader::open($request->import_file, ';');
            $header = $reader->getHeader();
            if (count($header) > 3 || !in_array('nombreMunicipio', $header) || !in_array('nombreDepartamento', $header) || !in_array('nombrePais', $header)){
                $errores['file'][0] = "Error al cargar el archivo. El documento no tiene la estructura especificada. 
                    Debe incluir los encabezados 'nombreMunicipio', 'nombreDepartamento' y 'nombrePais' al archivo.";
                return ['success' => false, 'errores' => $errores, 'header' => $header];
            }
            
            $errores = array();
		    while(($line = $reader->readLine()) !== false){
	            if (!empty($line['nombreMunicipio']) && !empty($line['nombreDepartamento']) && !empty($line['nombrePais'])){
	                $paisConIdioma = Pais_Con_Idioma::where('nombre', $line['nombrePais'])->get()->first();
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
    	            $departamento = Departamento::where('nombre', $line['nombreDepartamento'])->where('pais_id', $paisConIdioma->pais_id)->get()->first();
    	            if ($departamento == null){
    	                $departamento = new Departamento();
                        $departamento->nombre = $line['nombreDepartamento'];
                        $departamento->pais_id = $paisConIdioma->pais_id;
                        $departamento->created_at = Carbon::now();
                        $departamento->updated_at = Carbon::now();
                        $departamento->user_create = "Situr";
                        $departamento->user_update = "Situr";
                        $departamento->estado = true;
                        
                        $departamento->save();
    	            }
    	            $municipio = Municipio::where('departamento_id', $departamento->id)->where('nombre', $line['nombreMunicipio'])->first();
    		        if ($municipio == null){
    		            $municipio = new Municipio();
    		            $municipio->nombre = $line['nombreMunicipio'];
    		            $municipio->estado = true;
    		            $municipio->created_at = Carbon::now();
    		            $municipio->updated_at = Carbon::now();
    		            $municipio->user_update = "Situr";
    		            $municipio->user_create = "Situr";
    		            $municipio->departamento_id = $departamento->id;
    		            $municipio->save();
    		        }
	            }
		    }
		    if (count($errores) != 0){
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
