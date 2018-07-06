<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use CsvReader;

use App\Models\Pais;
use App\Models\Idioma;
use App\Models\Pais_Con_Idioma;

use App\Http\Requests;

class AdministrarPaisesController extends Controller
{
    //
    public function getIndex(){
        return view('administrarpaises.Index');
    }
    
    public function getDatos(){
        $paises = Pais::with(['paisesConIdiomas' => function ($q){
            $q->with(['idioma' => function($i){
                $i->select('id', 'culture', 'nombre');
            }])->select('pais_id', 'nombre', 'idioma_id');
        }])->select('id', 'user_update', 'updated_at')->get();
        
        $idiomas = Idioma::select('id', 'culture', 'nombre')->get();
        return ['paises' => $paises, 'success' => true, 'idiomas' => $idiomas];
    }
    
    public function postCrearpais(Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|unique:paises_con_idiomas|max:255',
            'idioma' => 'required|exists:idiomas,id|numeric'
        ],[
            'nombre.required' => 'El nombre del país es requerido.',
            'nombre.unique' => 'Ya existe en la base de datos un país con este nombre.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'idioma.required' => 'Se necesita un identificador para el idioma.',
            'idioma.exists' => 'El idioma seleccionado no se encuentra registrado en la base de datos.',
            'idioma.numeric' => 'El identificador del idioma debe ser un dato numérico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        $errores = [];
        $pais_ = Pais_Con_Idioma::whereRaw("LOWER(nombre) = '".strtolower($request->nombre)."'")->first();
        if ($pais_ != null){
            $errores["existe"][0] = "Este país ya está registrado en el sistema.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $pais_con_idioma = new Pais_Con_Idioma();
        $pais_con_idioma->nombre = $request->nombre;
        $pais_con_idioma->idioma_id = $request->idioma;
        
        $pais = new Pais();
        $pais->created_at = Carbon::now();
        $pais->updated_at = Carbon::now();
        $pais->user_create = "Situr";
        $pais->user_update = "Situr";
        $pais->estado = true;
        
        $pais->save();
        $pais_con_idioma->pais_id = $pais->id;
        $pais_con_idioma->save();
        $idioma = Idioma::find($pais_con_idioma->idioma_id)->select('id', 'nombre', 'culture');
        
        $paisReturn = Pais::where('id', $pais->id)->with(['paisesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                $i->select('id', 'culture', 'nombre');
            }])->select('pais_id', 'nombre', 'idioma_id');
        }])->select('id', 'user_update', 'updated_at')->first();
        
        return ['success' => true, 'pais' => $paisReturn, 'prueba' => $pais_];
    }
    
    public function postAgregarnombre (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'idioma' => 'required|exists:idiomas,id|numeric',
            'id' => 'required|exists:paises|numeric'
        ],[
            'nombre.required' => 'El nombre del país es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'idioma.required' => 'Se necesita un identificador para el idioma.',
            'idioma.exists' => 'El idioma seleccionado no se encuentra registrado en la base de datos.',
            'idioma.numeric' => 'El idioma debe ser un dato numérico.',
            
            'id.required' => 'Se necesita un identificador para el país.',
            'id.exists' => 'El identificador del país no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador debe ser númerico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $pais = Pais_Con_Idioma::where('idioma_id', $request->idioma)->where('pais_id', $request->id)->get();
        if (count($pais) > 0){
            $errores["existe"][0] = "Este país ya cuenta con un nombre en este idioma.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        
        $pais_con_idioma = new Pais_Con_Idioma();
        $pais_con_idioma->idioma_id = $request->idioma;
        $pais_con_idioma->pais_id = $request->id;
        $pais_con_idioma->nombre = $request->nombre;
        $pais_con_idioma->save();
        
        $paisReturn = Pais::where('id', $pais_con_idioma->pais_id)->with(['paisesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                $i->select('id', 'culture', 'nombre');
            }])->select('pais_id', 'nombre', 'idioma_id');
        }])->select('id', 'user_update', 'updated_at')->first();
        
        return ['success' => true, 'pais' => $paisReturn];
    }
    
    public function postEditarpais (Request $request){
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'idioma' => 'required|exists:idiomas,id|numeric',
            'id' => 'required|exists:paises|numeric'
        ],[
            'nombre.required' => 'El nombre del país es requerido.',
            'nombre.max' => 'Máximo se admiten 255 carácteres para el nombre.',
            
            'idioma.required' => 'Se necesita un identificador para el idioma.',
            'idioma.exists' => 'El idioma seleccionado no se encuentra registrado en la base de datos.',
            'idioma.numeric' => 'El idioma debe ser un dato numérico.',
            
            'id.required' => 'Se necesita un identificador para el país.',
            'id.exists' => 'El identificador del país no se encuentra registrado en la base de datos.',
            'id.numeric' => 'El identificador debe ser númerico.'
        ]);
        
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $errores = [];
        $pais_con_idioma = Pais_Con_Idioma::where('idioma_id', $request->idioma)->where('pais_id', $request->id)->first();
        if ($pais_con_idioma == null){
            $errores["existe"][0] = "Este país no tiene una traducción en este idioma.";
        }
        if($errores != null || sizeof($errores) > 0){
            return  ["success"=>false,"errores"=>$errores];
        }
        $pais_con_idioma->nombre = $request->nombre;
        $pais_con_idioma->save();
        
        $paisReturn = Pais::where('id', $pais_con_idioma->pais_id)->with(['paisesConIdiomas' => function($q){
            $q->with(['idioma' => function($i){
                $i->select('id', 'culture', 'nombre');
            }])->select('pais_id', 'nombre', 'idioma_id');
        }])->select('id', 'user_update', 'updated_at')->first();
        
        return ['success' => true, 'pais' => $paisReturn];
    }
    
    public function postImportexcel(Request $request){
        $errores = [];
        if ($request->hasFile('import_file')){
            $reader = CsvReader::open($request->import_file, ';');
            $header = $reader->getHeader();
            if (count($header) > 2 || !in_array('nombrePais', $header)){
                $errores['file'][0] = "Error al cargar el archivo. El documento no tiene la estructura especificada. 
                    Debe incluir los encabezados 'nombreMunicipio', 'nombreDepartamento' y 'nombrePais' al archivo.";
                return ['success' => false, 'errores' => $errores, 'header' => $header];
            }
            
            $errores = array();
		    while(($line = $reader->readLine()) !== false){
	            if (!empty($line['nombreMunicipio']) && !empty($line['nombreDepartamento']) && !empty($line['nombrePais'])){
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
    
    // public function getDeletepais ($id){
    //     $pais = Pais::find($id);
    //     $pais->departamentos()->delete();
    //     $pais->paisesConIdiomas()->delete();
    //     $pais->visitantes()->delete();
    //     $pais->delete();
    //     return ['success' => true];
    // }
}
