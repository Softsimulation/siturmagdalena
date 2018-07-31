<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
	public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
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
		
		$cabeceras = [
			"Numero del RNT",
			"Estado",
			"Municipio",
			"Nombre Comercial RNT",
			"NIT",
			"Digito de Verificacion",
			"Nombre Gerente",
			"Categoria",
			"Subcategoria",
			"Direccion Comercial",
			"Telefono",
			"Celular",
			"Correo Electronico",
			"Ultimo Anio Act RNT",
			"Sostenibilidad Turistica",
			"Turismo Aventura",
			"hab2",
			"cam2",
			"emp2",
			"Latitud",
			"Longitud",
			"Nombre Comercial Plataforma",
		];
		
		if($cabeceras != $header){
		    return ["success" => false, "errores" => [["Verifique que las cabeceras cumplen con los requisitos del archivo."]] ];
		}
		
		$arreglo = $reader->readAll();
		$arreglo = collect($arreglo);
		
		if(count($arreglo) > 2000){
			return ["success" => false, "errores" => [["El documento debe tener no más de 2000 registros."]] ];
		}
		
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
		    $registro = $validar['success'] ? $validar["registro"] : $registro;
		    
		    $similar = $proveedoresIngresados->filter(function($value, $key)use($registro){
		    	return $value['nit'] == $registro['nit'] || ( $value['digito_verificacion'] == $registro['digito_verificacion'] && $value['digito_verificacion'] != 0 && $value['digito_verificacion'] != null ) || ($value['correo'] == $registro['correo'] && strpos($value['correo'], '@') !== false);
		    })->first();
		    
		    $registro['es_correcto'] = $validar['success'] ? 1 : 0;
		    $registro['campos'] = $validar['campos'];
		    
		    if($validar['success'] && !$similar){
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
	        		"latitud" => isset($registro["latitud"]) ? $registro["latitud"] : null,
	        		"longitud" => isset($registro["longitud"]) ? $registro["longitud"] : null,
	        		"nit" => isset($registro["nit"]) ? $registro["nit"] : null,
	        		"digito_verificacion" => isset($registro["digito_verificacion"]) ? $registro["digito_verificacion"] : null,
	        		"nombre_gerente" => isset($registro["nombre_gerente"]) ? $registro["nombre_gerente"] : null,
	        		"ultimo_anio_rnt" => isset($registro["ultimo_anio_rnt"]) ? $registro["ultimo_anio_rnt"] : null,
	        		"sostenibilidad_rnt" => isset($registro["sostenibilidad_rnt"]) ? $registro["sostenibilidad_rnt"] : null,
	        		"turismo_aventura" => isset($registro["turismo_aventura"]) ? $registro["turismo_aventura"] : null,
	        		"hab2" => isset($registro["hab2"]) ? $registro["hab2"] : null,
	        		"cam2" => isset($registro["cam2"]) ? $registro["cam2"] : null,
	        		"emp2" => isset($registro["emp2"]) ? $registro["emp2"] : null,
	        		"estado" => 1,
	        		"user_create" => $this->user->username,
	        		"user_update" => $this->user->username,
	        	]);
	        	
	        	if($registro["nombre_comercial_plataforma"] != null){
	        		$proveedorIdioma = $proveedorCrear->proveedor_rnt_idioma->where('idioma_id',1)->first();
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
		    }
		    
		    
		    if($similar){
		    	$registro = $this->MutarEditarRegistro($registro,$similar);
		    	$registro['id'] = $similar->id;
	    		$registro['es_similar'] = 1;
		    }else{
		    	$registro['es_similar'] = 0;
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
			//'departamento' => 'required|max:255',
			'nombre_comercial' => 'required|max:455',
			'nombre_comercial_plataforma' => 'required|max:455',
			'categoria' => 'required|max:255',
			'sub_categoria' => 'required|max:255',
			'direccion_comercial' => 'required|max:455',
			'telefono' => 'required|max:255',
			'celular' => 'required|max:255',
			'correo' => 'required|max:455',
			'latitud' => 'required',
			'longitud' => 'required',
			'nit' => 'max:150',
			'nombre_gerente' => 'max:250',
			'sostenibilidad_rnt' => 'max:50',
			'turismo_aventura' => 'max:50',
			'digito_verificacion' => 'required',
			'ultimo_anio_rnt' => 'required',
			'hab2' => 'required',
			'cam2' => 'required',
			'emp2' => 'required',
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
		$proveedor->latitud = isset($request->latitud) ? $request->latitud : $proveedor->latitud;
		$proveedor->longitud = isset($request->longitud) ? $request->longitud : $proveedor->longitud;
		$proveedor->nit = isset($request->nit) ? $request->nit : null;
		$proveedor->digito_verificacion = isset($request->digito_verificacion) ? $request->digito_verificacion : null;
		$proveedor->nombre_gerente = isset($request->nombre_gerente) ? $request->nombre_gerente : null;
		$proveedor->ultimo_anio_rnt = isset($request->ultimo_anio_rnt) ? $request->ultimo_anio_rnt : null;
		$proveedor->sostenibilidad_rnt = isset($request->sostenibilidad_rnt) ? $request->sostenibilidad_rnt : null;
		$proveedor->turismo_aventura = isset($request->turismo_aventura) ? $request->turismo_aventura : null;
		$proveedor->hab2 = isset($request->hab2) ? $request->hab2 : null;
		$proveedor->cam2 = isset($request->cam2) ? $request->cam2 : null;
		$proveedor->emp2 = isset($request->emp2) ? $request->emp2 : null;
		$proveedor->user_update = $this->user->username;
		$proveedor->save();
		
		$proveedorIdioma = $proveedor->proveedor_rnt_idioma->where('idioma_id',1)->first();
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
		
		$objeto["id"] = $proveedor->id;
		$objeto["numero_rnt"] = $request->numero_rnt;
		$objeto["numero_rnt2"] = $request->numero_rnt;
		$objeto["estado"] = $request->estado;
		$objeto["estado2"] = $request->estado;
		$objeto["municipio"] = $request->municipio;
		$objeto["municipio2"] = $request->municipio;
		// $objeto["departamento"] = $request->departamento;
		// $objeto["departamento2"] = $request->departamento;
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
		$objeto["latitud"] = $request->latitud;
		$objeto["latitud2"] = $request->latitud;
		$objeto["longitud"] = $request->longitud;
		$objeto["longitud2"] = $request->longitud;
		
		$objeto["nit"] = $request->nit;
		$objeto["nit2"] = $request->nit;
		$objeto["digito_verificacion"] = $request->digito_verificacion;
		$objeto["digito_verificacion2"] = $request->digito_verificacion;
		$objeto["nombre_gerente"] = $request->nombre_gerente;
		$objeto["nombre_gerente2"] = $request->nombre_gerente;
		$objeto["ultimo_anio_rnt"] = $request->ultimo_anio_rnt;
		$objeto["ultimo_anio_rnt2"] = $request->ultimo_anio_rnt;
		$objeto["sostenibilidad_rnt"] = $request->sostenibilidad_rnt;
		$objeto["sostenibilidad_rnt2"] = $request->sostenibilidad_rnt;
		$objeto["turismo_aventura"] = $request->turismo_aventura;
		$objeto["turismo_aventura2"] = $request->turismo_aventura;
		$objeto["hab2"] = $request->hab2;
		$objeto["hab22"] = $request->hab2;
		$objeto["cam2"] = $request->cam2;
		$objeto["cam22"] = $request->cam2;
		$objeto["emp2"] = $request->emp2;
		$objeto["emp22"] = $request->emp2;
		
		$objeto['es_correcto'] = 1;
		$objeto['es_similar'] = 0;
		
        return ["success" => true, 'proveedor' => $objeto];
    }
    
    public function postCrearproveedor(Request $request){
        $validator = \Validator::make($request->all(), [
			'numero_rnt' => 'required|max:50|unique:proveedores_rnt,numero_rnt',
			'estado' => 'required|max:255',
			'municipio' => 'required|max:255',
			// 'departamento' => 'required|max:255',
			'nombre_comercial' => 'required|max:455',
			'nombre_comercial_plataforma' => 'required|max:455',
			'categoria' => 'required|max:255',
			'sub_categoria' => 'required|max:255',
			'direccion_comercial' => 'required|max:455',
			'telefono' => 'required|max:255',
			'celular' => 'required|max:255',
			'correo' => 'required|max:455',
			'latitud' => 'required',
			'longitud' => 'required',
			'nit' => 'required|max:150',
			'nombre_gerente' => 'required|max:250',
			'sostenibilidad_rnt' => 'required|max:50',
			'turismo_aventura' => 'required|max:50',
			'digito_verificacion' => 'required',
			'ultimo_anio_rnt' => 'required',
			'hab2' => 'required',
			'cam2' => 'required',
			'emp2' => 'required',
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
			"latitud" => isset($request["latitud"]) ? $request["latitud"] : null,
			"longitud" => isset($request["longitud"]) ? $request["longitud"] : null,
			"nit" => isset($request["nit"]) ? $request["nit"] : null,
    		"digito_verificacion" => isset($request["digito_verificacion"]) ? $request["digito_verificacion"] : null,
    		"nombre_gerente" => isset($request["nombre_gerente"]) ? $request["nombre_gerente"] : null,
    		"ultimo_anio_rnt" => isset($request["ultimo_anio_rnt"]) ? $request["ultimo_anio_rnt"] : null,
    		"sostenibilidad_rnt" => isset($request["sostenibilidad_rnt"]) ? $request["sostenibilidad_rnt"] : null,
    		"turismo_aventura" => isset($request["turismo_aventura"]) ? $request["turismo_aventura"] : null,
    		"hab2" => isset($request["hab2"]) ? $request["hab2"] : null,
    		"cam2" => isset($request["cam2"]) ? $request["cam2"] : null,
    		"emp2" => isset($request["emp2"]) ? $request["emp2"] : null,
			"estado" => 1,
			"user_create" => $this->user->username,
			"user_update" => $this->user->username,
		]);
		
		Proveedores_rnt_idioma::create([
			'idioma_id' => 1,
			'proveedor_rnt_id' => $proveedorCrear->id,
			'nombre' => $request["nombre_comercial_plataforma"]
		]);
		
		$objeto["id"] = $proveedorCrear->id;
		$objeto["numero_rnt"] = $request->numero_rnt;
		$objeto["estado"] = $request->estado;
		$objeto["municipio"] = $request->municipio;
		// $objeto["departamento"] = $request->departamento;
		$objeto["nombre_comercial"] = $request->nombre_comercial;
		$objeto["nombre_comercial_plataforma"] = $request->nombre_comercial_plataforma;
		$objeto["categoria"] = $request->categoria;
		$objeto["sub_categoria"] = $request->sub_categoria;
		$objeto["direccion_comercial"] = $request->direccion_comercial;
		$objeto["telefono"] = $request->telefono;
		$objeto["celular"] = $request->celular;
		$objeto["correo"] = $request->correo;
		$objeto['es_correcto'] = 1;
		$objeto['es_similar'] = 0;
		$objeto["latitud"] = $request->latitud;
		$objeto["longitud"] = $request->longitud;
		$objeto["nit"] = $request->nit;
		$objeto["digito_verificacion"] = $request->digito_verificacion;
		$objeto["nombre_gerente"] = $request->nombre_gerente;
		$objeto["ultimo_anio_rnt"] = $request->ultimo_anio_rnt;
		$objeto["sostenibilidad_rnt"] = $request->sostenibilidad_rnt;
		$objeto["turismo_aventura"] = $request->turismo_aventura;
		$objeto["hab2"] = $request->hab2;
		$objeto["cam2"] = $request->cam2;
		$objeto["emp2"] = $request->emp2;
		
        return ["success" => true, 'proveedor' => $objeto];
    }
    
    public function postCrearhabilitarproveedor(Request $request){
    	$validator = \Validator::make($request->all(), [
			'id' => 'required|exists:proveedores_rnt,id',
			'numero_rnt' => 'required|max:50|unique:proveedores_rnt,numero_rnt,'.$request->id,
			'estado' => 'required|max:255',
			'municipio' => 'required|max:255',
			// 'departamento' => 'required|max:255',
			'nombre_comercial' => 'required|max:455',
			'nombre_comercial_plataforma' => 'required|max:455',
			'categoria' => 'required|max:255',
			'sub_categoria' => 'required|max:255',
			'direccion_comercial' => 'required|max:455',
			'telefono' => 'required|max:255',
			'celular' => 'required|max:255',
			'correo' => 'required|max:455',
			'latitud' => 'required',
			'longitud' => 'required',
			'nit' => 'max:150',
			'nombre_gerente' => 'max:250',
			'sostenibilidad_rnt' => 'max:50',
			'turismo_aventura' => 'max:50',
			'digito_verificacion' => 'required',
			'ultimo_anio_rnt' => 'required',
			'hab2' => 'required',
			'cam2' => 'required',
			'emp2' => 'required',
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
		$proveedor->estado = 0;
		$proveedor->save();
		
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
			"latitud" => isset($request["latitud"]) ? $request["latitud"] : null,
			"longitud" => isset($request["longitud"]) ? $request["longitud"] : null,
			"nit" => isset($request["nit"]) ? $request["nit"] : null,
    		"digito_verificacion" => isset($request["digito_verificacion"]) ? $request["digito_verificacion"] : null,
    		"nombre_gerente" => isset($request["nombre_gerente"]) ? $request["nombre_gerente"] : null,
    		"ultimo_anio_rnt" => isset($request["ultimo_anio_rnt"]) ? $request["ultimo_anio_rnt"] : null,
    		"sostenibilidad_rnt" => isset($request["sostenibilidad_rnt"]) ? $request["sostenibilidad_rnt"] : null,
    		"turismo_aventura" => isset($request["turismo_aventura"]) ? $request["turismo_aventura"] : null,
    		"hab2" => isset($request["hab2"]) ? $request["hab2"] : null,
    		"cam2" => isset($request["cam2"]) ? $request["cam2"] : null,
    		"emp2" => isset($request["emp2"]) ? $request["emp2"] : null,
			"estado" => 1,
			"user_create" => $this->user->username,
			"user_update" => $this->user->username,
		]);
		
		Proveedores_rnt_idioma::create([
			'idioma_id' => 1,
			'proveedor_rnt_id' => $proveedorCrear->id,
			'nombre' => $request["nombre_comercial_plataforma"]
		]);
		
		$objeto["id"] = $proveedorCrear->id;
		$objeto["numero_rnt"] = $request->numero_rnt;
		$objeto["estado"] = $request->estado;
		$objeto["municipio"] = $request->municipio;
		// $objeto["departamento"] = $request->departamento;
		$objeto["nombre_comercial"] = $request->nombre_comercial;
		$objeto["nombre_comercial_plataforma"] = $request->nombre_comercial_plataforma;
		$objeto["categoria"] = $request->categoria;
		$objeto["sub_categoria"] = $request->sub_categoria;
		$objeto["direccion_comercial"] = $request->direccion_comercial;
		$objeto["telefono"] = $request->telefono;
		$objeto["celular"] = $request->celular;
		$objeto["correo"] = $request->correo;
		$objeto['es_correcto'] = 1;
		$objeto['es_similar'] = 0;
		$objeto["latitud"] = $request->latitud;
		$objeto["longitud"] = $request->longitud;
		$objeto["nit"] = $request->nit;
		$objeto["digito_verificacion"] = $request->digito_verificacion;
		$objeto["nombre_gerente"] = $request->nombre_gerente;
		$objeto["ultimo_anio_rnt"] = $request->ultimo_anio_rnt;
		$objeto["sostenibilidad_rnt"] = $request->sostenibilidad_rnt;
		$objeto["turismo_aventura"] = $request->turismo_aventura;
		$objeto["hab2"] = $request->hab2;
		$objeto["cam2"] = $request->cam2;
		$objeto["emp2"] = $request->emp2;
		
        return ["success" => true, 'proveedor' => $objeto];
    }
    
    public function MutarRegistro($registro){
        $objeto["numero_rnt"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Numero del RNT"]))) ;
        $objeto["estado"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Estado"]))) ;
        $objeto["municipio"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Municipio"]))) ;
        // $objeto["departamento"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Departamento"]))) ;
        $objeto["nombre_comercial"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Nombre Comercial RNT"]))) ;
        $objeto["nombre_comercial_plataforma"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Nombre Comercial Plataforma"]))) ;
        $objeto["categoria"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Categoria"]))) ;
        $objeto["sub_categoria"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Subcategoria"]))) ;
        $objeto["direccion_comercial"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Direccion Comercial"]))) ;
        $objeto["telefono"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Telefono"]))) ;
        $objeto["celular"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Celular"]))) ;
        $objeto["correo"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Correo Electronico"]))) ;
        $objeto["longitud"] = floatval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["Longitud"]))) );
        $objeto["latitud"] = floatval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["Latitud"]))) );
        
        $objeto["digito_verificacion"] = intval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["Digito de Verificacion"]))) );
        $objeto["nombre_gerente"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Nombre Gerente"])));
        $objeto["ultimo_anio_rnt"] = intval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["Ultimo Anio Act RNT"]))) );
        $objeto["sostenibilidad_rnt"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Sostenibilidad Turistica"]))) ;
        $objeto["turismo_aventura"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["Turismo Aventura"]))) ;
        $objeto["hab2"] = $registro["hab2"] != "-" ? intval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["hab2"]))) ) : null;
        $objeto["cam2"] = $registro["cam2"] != "-" ? intval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["cam2"]))) ) : null;
        $objeto["emp2"] = $registro["emp2"] != "-" ? intval( $this->MayusculaTilde(utf8_encode(strtoupper($registro["emp2"]))) ) : null;
        $objeto["nit"] = $this->MayusculaTilde(utf8_encode(strtoupper($registro["NIT"]))) ;
        
        $objeto["longitud"] = $objeto["longitud"] == 0 ? null : $objeto["longitud"];
        $objeto["latitud"] = $objeto["latitud"] == 0 ? null : $objeto["latitud"];
        
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
        // $objeto["departamento2"] = $proveedor["departamento"];
        $objeto["nombre_comercial2"] = $proveedor["nombre_comercial"];
        $objeto["nombre_comercial_plataforma2"] = $proveedor["nombre_comercial_plataforma"];
        $objeto["categoria2"] = $proveedor["categoria"];
        $objeto["sub_categoria2"] = $proveedor["sub_categoria"];
        $objeto["direccion_comercial2"] = $proveedor["direccion_comercial"];
        $objeto["telefono2"] = $proveedor["telefono"];
        $objeto["celular2"] = $proveedor["celular"];
        $objeto["correo2"] = $proveedor["correo"];
        $objeto["latitud2"] = $proveedor["latitud"];
        $objeto["longitud2"] = $proveedor["longitud"];
        $objeto["nit2"] = $proveedor["nit"];
        $objeto["digito_verificacion2"] = $proveedor["digito_verificacion"];
        $objeto["nombre_gerente2"] = $proveedor["nombre_gerente"];
        $objeto["ultimo_anio_rnt2"] = $proveedor["ultimo_anio_rnt"];
        $objeto["sostenibilidad_rnt2"] = $proveedor["sostenibilidad_rnt"];
        $objeto["turismo_aventura2"] = $proveedor["turismo_aventura"];
        $objeto["hab22"] = $proveedor["hab2"];
        $objeto["cam22"] = $proveedor["cam2"];
        $objeto["emp22"] = $proveedor["emp2"];
        
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
        
        if($registro["latitud"] == null || $registro["latitud"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Latitud requerido";
        }
        
        if($registro["longitud"] == null || $registro["longitud"] == ""){
            $sw = 1;
            if(strlen($campos)>0){$campos .= ", ";}
            $campos .= "Longitud requerido";
        }
        
        $campos .= ".";
        if($sw == 1){
            return ["success" => false, 'campos' => $campos];
        }
        
        return ["success" => true, "registro" => $registro, 'campos' => null];
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
