<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Proveedores_rnt;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Estado_proveedor;
use App\Models\Categoria_Proveedor;
use App\Models\Tipo_Proveedor;
use App\Models\ProveedoresRntVista;
use App\Models\Categoria_Proveedor_Con_Idioma;
use App\Models\Proveedores_rnt_idioma;

class ImportacionRntController extends Controller
{
    public function getIndex(){
        return view('proveedoresRnt.importarExcel');
    }
    
    public function postCargarsoporte(Request $request){
        $validator = \Validator::make($request->all(), [
			'soporte' => 'required|max:20480'
    	],[
       		'soporte.required' => 'Debe seleccionar un soporte.',
       		'soporte.max' => 'El soporte no debe superar los 20 MB.'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}

        $reader = \CsvReader::open($request->soporte, ';');
        $header = $reader->getHeader();
		
		$cabeceras = ["Numero del RNT","Estado","Municipio","Departamento","Nombre Comercial RNT","Nombre Comercial Plataforma","Categoria","Subcategoria","Direccion Comercial","Telefono","Celular","Correo Electronico"];
		
		if($cabeceras != $header){
		    return ["success" => false, "errores" => [["Verifique que las cabeceras cumplen con los requisitos del archivo."]] ];
		}
		
		$arreglo = $reader->readAll();
		$arreglo = collect($arreglo);
		//dd($arreglo[0]);
		
		$proveedoresIngresados = ProveedoresRntVista::all();
		$rntproveedores = $proveedoresIngresados->pluck('numero_rnt')->toArray();
		$antiguos = $arreglo->whereIn('Numero del RNT',$rntproveedores)->toArray();
		$nuevos = $this->compare($arreglo->toArray(),$antiguos);
		
		$estadosProveedor = Estado_proveedor::select(\DB::raw('upper(nombre) as nombre, id'))->get();
		$subCategorias = Categoria_Proveedor_Con_Idioma::where('idiomas_id',1)->select(\DB::raw('upper(nombre) as nombre, categoria_proveedores_id as id'))->get();
		$municipios = Municipio::where('departamento_id',1411)->select(\DB::raw('upper(nombre) as nombre, id'))->get();
		
 		$nuevos_retornar = array();
		foreach($nuevos as $registro){
			$registro = $this->MutarRegistro($registro);
		    $validar = $this->validarRegistro($registro,$estadosProveedor,$subCategorias,$municipios);
		    if($validar['success']){
		    	$registro = $validar["registro"];
		        $proveedorCrear = Proveedores_rnt::create([
	        		"categoria_proveedores_id" => $registro["categoria_proveedores_id"],
	        		"estados_proveedor_id" => $registro["estados_proveedor_id"],
	        		"municipio_id" => $registro["municipio_id"],
	        		"razon_social" => $registro["nombre_comercial"],
	        		"direccion" => $registro["direccion_comercial"],
	        		"numero_rnt" => $registro["numero_rnt"],
	        		"telefono" => $registro["telefono"],
	        		"celular" => $registro["celular"],
	        		"email" => $registro["correo"],
	        		"estado" => 1,
	        		"user_create" => "MM",
	        		"user_update" => "MM",
	        	]);
	        	
	        	if($registro["nombre_comercial_plataforma"] != null){
	        		$proveedorIdioma = $proveedorCrear->proveedor_rnt_idioma->where('idiomas_id',1)->first();
					if($proveedorIdioma){
						$proveedorIdioma->nombre = $request->nombre_comercial_plataforma;
						$proveedorIdioma->save();
					}else{
						Proveedores_rnt_idioma::create([
			    			'idioma_id' => 1,
			    			'proveedor_rnt_id' => $proveedorCrear->id,
			    			'nombre' => $registro["nombre_comercial_plataforma"]
			    		]);
					}	
	        	}
	        	
		        $registro['id'] = $proveedorCrear->id;
		        $registro['es_correcto'] = 1;
		    }else{
		        $registro['es_correcto'] = 0;
		        $registro['campos'] = $validar['campos'];
		    }
		    array_push($nuevos_retornar, $registro);
		}
        
        $antiguos_retornar = array();		
		foreach($antiguos as $registro){
		    $registro = $this->MutarRegistro($registro);
		    $proveedorIng = $proveedoresIngresados->where('numero_rnt',$registro["numero_rnt"])->first();
		    
		    $registro["id"] = $proveedorIng->id;
		    $registro = $this->MutarEditarRegistro($registro,$proveedorIng);
            array_push($antiguos_retornar,$registro);
		}
		
		
		$reader->close();
		
		//return ['success' => true, 'nuevos' => json_encode($nuevos_retornar), 'antiguos' => json_encode($antiguos_retornar) ];
		return response()->json(['success' => true, 'nuevos' => $nuevos_retornar, 'antiguos' => $antiguos_retornar]);
    }
    
    public function postEditarproveedor(Request $request){
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:proveedores_rnt,id',
			'numero_rnt' => 'required|max:50|unique:proveedores_rnt,numero_rnt,'.$request->id,
			'estado' => 'required|max:255',
			'municipio' => 'required|max:255',
			'departamento' => 'required|max:255',
			'nombre_comercial' => 'required|max:455',
			'nombre_comercial_plataforma' => 'required|max:455',
			'categoria' => 'required|max:255',
			'sub_categoria' => 'required|max:255',
			'direccion_comercial' => 'required|max:455',
			'telefono' => 'required|max:255',
			'celular' => 'required|max:255',
			'correo' => 'required|max:455',
    	],[
       		'id.required' => 'Debe seleccionar el registro a editar.',
       		'id.exists' => 'El registro seleccionado no se encuentra ingresado en el sistema.',
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$categoriaProveedor = Categoria_Proveedor_Con_Idioma::whereRaw('upper(nombre) = ? and idiomas_id = 1',[ $this->MayusculaTilde(utf8_encode(strtoupper($request["sub_categoria"]))) ])->first();
		if($categoriaProveedor == null){
			return ["success"=>false,"errores"=> [["La SubCategoría ingresada no se encuentra ingresada en el sistema."]] ];
		}
		
		$municipio = Municipio::whereRaw('upper(nombre) = ?',[$this->MayusculaTilde(utf8_encode(strtoupper($request["municipio"])))])->first();
		if($municipio == null){
			return ["success"=>false,"errores"=> [["El municipio ingresado no se encuentra ingresado en el sistema."]] ];
		}
		
		$estado = Estado_proveedor::whereRaw('upper(nombre) = ?',[$this->MayusculaTilde(utf8_encode(strtoupper($request["estado"])))])->first();
		if($estado == null){
			return ["success"=>false,"errores"=> [["El estado ingresado no se encuentra ingresado en el sistema."]] ];
		}
		
		$proveedor = Proveedores_rnt::find($request->id);
		$proveedor->numero_rnt = $request->numero_rnt;
		$proveedor->estados_proveedor_id = $estado->id;
		$proveedor->municipio_id = $municipio->id;
		$proveedor->razon_social = $request->nombre_comercial;
		$proveedor->categoria_proveedores_id = $categoriaProveedor->categoria_proveedores_id;
		$proveedor->direccion = $request->direccion_comercial;
		$proveedor->telefono = $request->telefono;
		$proveedor->celular = $request->celular;
		$proveedor->email = $request->correo;
		$proveedor->user_update = "MM";
		$proveedor->save();
		
		$proveedorIdioma = $proveedor->proveedor_rnt_idioma->where('idiomas_id',1)->first();
		if($proveedorIdioma){
			$proveedorIdioma->nombre = $request->nombre_comercial_plataforma;
			$proveedorIdioma->save();
		}else{
			Proveedores_rnt_idioma::create([
    			'idioma_id' => 1,
    			'proveedor_rnt_id' => $proveedor->id,
    			'nombre' => $request->nombre_comercial_plataforma
    		]);
		}
		
		
		$objeto["numero_rnt"] = $request->numero_rnt;
		$objeto["numero_rnt2"] = $request->numero_rnt;
		$objeto["estado"] = $request->estado;
		$objeto["estado2"] = $request->estado;
		$objeto["municipio"] = $request->municipio;
		$objeto["municipio2"] = $request->municipio;
		$objeto["departamento"] = $request->departamento;
		$objeto["departamento2"] = $request->departamento;
		$objeto["nombre_comercial"] = $request->nombre_comercial;
		$objeto["nombre_comercial2"] = $request->nombre_comercial;
		$objeto["nombre_comercial_plataforma"] = $request->nombre_comercial_plataforma;
		$objeto["nombre_comercial_plataforma2"] = $request->nombre_comercial_plataforma;
		$objeto["categoria"] = $request->categoria;
		$objeto["categoria2"] = $request->categoria;
		$objeto["sub_categoria"] = $request->sub_categoria;
		$objeto["sub_categoria2"] = $request->sub_categoria;
		$objeto["direccion_comercial"] = $request->direccion_comercial;
		$objeto["direccion_comercial2"] = $request->direccion_comercial;
		$objeto["telefono"] = $request->telefono;
		$objeto["telefono2"] = $request->telefono;
		$objeto["celular"] = $request->celular;
		$objeto["celular2"] = $request->celular;
		$objeto["correo"] = $request->correo;
		$objeto["correo2"] = $request->correo;
		
        return ["success" => true, 'proveedor' => $objeto];
    }
    
    public function postCrearproveedor(Request $request){
        $validator = \Validator::make($request->all(), [
			'numero_rnt' => 'required|max:50|unique:proveedores_rnt,numero_rnt',
			'estado' => 'required|max:255',
			'municipio' => 'required|max:255',
			'departamento' => 'required|max:255',
			'nombre_comercial' => 'required|max:455',
			'nombre_comercial_plataforma' => 'required|max:455',
			'categoria' => 'required|max:255',
			'sub_categoria' => 'required|max:255',
			'direccion_comercial' => 'required|max:455',
			'telefono' => 'required|max:255',
			'celular' => 'required|max:255',
			'correo' => 'required|max:455',
    	],[
       		'id.required' => 'Debe seleccionar el registro a editar.',
       		'id.exists' => 'El registro seleccionado no se encuentra ingresado en el sistema.',
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		$categoriaProveedor = Categoria_Proveedor_Con_Idioma::whereRaw('upper(nombre) = ? and idiomas_id = 1',[ $this->MayusculaTilde(utf8_encode(strtoupper($request["sub_categoria"]))) ])->first();
		if($categoriaProveedor == null){
			return ["success"=>false,"errores"=> [["La SubCategoría ingresada no se encuentra ingresada en el sistema."]] ];
		}
		
		$municipio = Municipio::whereRaw('upper(nombre) = ?',[$this->MayusculaTilde(utf8_encode(strtoupper($request["municipio"])))])->first();
		if($municipio == null){
			return ["success"=>false,"errores"=> [["El municipio ingresado no se encuentra ingresado en el sistema."]] ];
		}
		
		$estado = Estado_proveedor::whereRaw('upper(nombre) = ?',[$this->MayusculaTilde(utf8_encode(strtoupper($request["estado"])))])->first();
		if($estado == null){
			return ["success"=>false,"errores"=> [["El estado ingresado no se encuentra ingresado en el sistema."]] ];
		}
		
		$proveedorCrear = Proveedores_rnt::create([
			"categoria_proveedores_id" => $categoriaProveedor->categoria_proveedores_id,
			"estados_proveedor_id" => $estado->id,
			"municipio_id" => $municipio->id,
			"razon_social" => $request["nombre_comercial"],
			"direccion" => $request["direccion_comercial"],
			"numero_rnt" => $request["numero_rnt"],
			"telefono" => $request["telefono"],
			"celular" => $request["celular"],
			"email" => $request["correo"],
			"estado" => 1,
			"user_create" => "MM",
			"user_update" => "MM",
		]);
		
		Proveedores_rnt_idioma::create([
			'idioma_id' => 1,
			'proveedor_rnt_id' => $proveedorCrear->id,
			'nombre' => $request["nombre_comercial_plataforma"]
		]);
		
		
		$objeto["numero_rnt"] = $request->numero_rnt;
		$objeto["estado"] = $request->estado;
		$objeto["municipio"] = $request->municipio;
		$objeto["departamento"] = $request->departamento;
		$objeto["nombre_comercial"] = $request->nombre_comercial;
		$objeto["nombre_comercial_plataforma"] = $request->nombre_comercial_plataforma;
		$objeto["categoria"] = $request->categoria;
		$objeto["sub_categoria"] = $request->sub_categoria;
		$objeto["direccion_comercial"] = $request->direccion_comercial;
		$objeto["telefono"] = $request->telefono;
		$objeto["celular"] = $request->celular;
		$objeto["correo"] = $request->correo;
		$objeto['es_correcto'] = 1;
		
        return ["success" => true, 'proveedor' => $objeto];
    }
    
    public function MutarRegistro($registro){
        $objeto["numero_rnt"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Numero del RNT"]))) ;
        $objeto["estado"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Estado"]))) ;
        $objeto["municipio"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Municipio"]))) ;
        $objeto["departamento"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Departamento"]))) ;
        $objeto["nombre_comercial"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Nombre Comercial RNT"]))) ;
        $objeto["nombre_comercial_plataforma"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Nombre Comercial Plataforma"]))) ;
        $objeto["categoria"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Categoria"]))) ;
        $objeto["sub_categoria"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Subcategoria"]))) ;
        $objeto["direccion_comercial"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Direccion Comercial"]))) ;
        $objeto["telefono"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Telefono"]))) ;
        $objeto["celular"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Celular"]))) ;
        $objeto["correo"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Correo Electronico"]))) ;
        return $objeto;
    }
    
    public function validaDiferencias($registro, $proveedorIng){
        
        $resultante = collect($registro)->diff($proveedorIng);
        
        return $resultante->all();
    }
    
    public function MutarEditarRegistro($objeto, $proveedor){
        $objeto["numero_rnt2"] = $proveedor["numero_rnt"];
        $objeto["estado2"] = $proveedor["estado"];
        $objeto["municipio2"] = $proveedor["municipio"];
        $objeto["departamento2"] = $proveedor["departamento"];
        $objeto["nombre_comercial2"] = $proveedor["nombre_comercial"];
        $objeto["nombre_comercial_plataforma2"] = $proveedor["nombre_comercial_plataforma"];
        $objeto["categoria2"] = $proveedor["categoria"];
        $objeto["sub_categoria2"] = $proveedor["sub_categoria"];
        $objeto["direccion_comercial2"] = $proveedor["direccion_comercial"];
        $objeto["telefono2"] = $proveedor["telefono"];
        $objeto["celular2"] = $proveedor["celular"];
        $objeto["correo2"] = $proveedor["correo"];
        return $objeto;
    }
    
	public function validarRegistro($registro,$estadosProveedor,$subCategorias,$municipios){
        
        $sw = 0;
        $campos = "";
        if($registro["numero_rnt"] == null || $registro["numero_rnt"] == ""){
            $sw = 1;
            $campos .= "Numero del RNT requerido";
        }
        
        if($registro["estado"] == null || $registro["estado"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Estado requerido";
        }else{
        	$estado = $estadosProveedor->where('nombre',$registro["estado"])->first();
            if($estado == null){
            	$sw = 1;
	            if(strlen($campos)>0){$campos .= ", ";}
	            $campos .= "Estado digitado no se encuentra ingresado en el sistema";
            }else{
            	$registro["estados_proveedor_id"] = $estado->id;	
            }
        }
        
        if($registro["municipio"] == null || $registro["municipio"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Municipio requerido";
        }else{
        	$mun = $municipios->where('nombre',$registro["municipio"])->first();
        	if($mun == null){
            	$sw = 1;
	            if(strlen($campos)>0){$campos .= ", ";}
	            $campos .= "Municipio digitado no se encuentra ingresado en el sistema";
            }else{
            	$registro["municipio_id"] = $mun->id;
            }
        }
        
        if($registro["nombre_comercial"] == null || $registro["nombre_comercial"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Nombre Comercial RNT requerido";
        }
        
        
        if($registro["sub_categoria"] == null || $registro["sub_categoria"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Subcategoria requerido";
        }else{
        	$subCat = $subCategorias->where('nombre',$registro["sub_categoria"])->first();
            if($subCat == null){
            	$sw = 1;
	            if(strlen($campos)>0){$campos .= ", ";}
	            $campos .= "SubCategoría digitada no se encuentra ingresada en el sistema";
            }else{
            	$registro["categoria_proveedores_id"] = $subCat->id;
            }
        }
        
        if($registro["direccion_comercial"] == null || $registro["direccion_comercial"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Direccion Comercial requerido";
        }
        
        if($registro["telefono"] == null || $registro["telefono"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Telefono requerido";
        }
        
        if($registro["celular"] == null || $registro["celular"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Celular requerido";
        }
        
        if($registro["correo"] == null || $registro["correo"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Correo Electronico requerido";
        }
        
        $campos .= ".";
        if($sw == 1){
            return ["success" => false, 'campos' => $campos];
        }
        
        return ["success" => true, "registro" => $registro];
    }
 
    public static function MayusculaTilde($cadena){
        $cadena = str_replace("á", "Á", $cadena); 
		$cadena = str_replace("é", "É", $cadena); 
		$cadena = str_replace("í", "Í", $cadena); 
		$cadena = str_replace("ó", "Ó", $cadena); 
		$cadena = str_replace("ú", "Ú", $cadena); 
        return trim($cadena);
    }
    
    public static function compare($array1, $array2){
		$result = array();

		foreach ($array1 as $key => $value) {

			if (!is_array($array2) || !array_key_exists($key, $array2)) {
				$result[$key] = $value;
				continue;
			}

			if (is_array($value)) {
				$recursiveArrayDiff = static::compare($value, $array2[$key]);

				if (count($recursiveArrayDiff)) {
					$result[$key] = $recursiveArrayDiff;
				}

				continue;
			}

			if ($value != $array2[$key]) {
				$result[$key] = $value;
			}
		}

		return $result;
	}
    
}
