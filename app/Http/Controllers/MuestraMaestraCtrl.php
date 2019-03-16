<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Proveedores_rnt;
use App\Models\Categoria_Proveedor;
use App\Models\Zona;
use App\Models\Periodos_medicion;
use App\Models\Digitador;
use App\Models\Estados_proveedor_rnt;
use App\Models\Municipio;
use App\Models\Tipo_Proveedor;
use App\Models\Categoria_Proveedor_Con_Idioma;
use App\Models\Coordenadas_zona;
use App\Models\Estado_proveedor;
use App\Models\Muestra_proveedor;
use App\Models\Sector;
use App\Models\Proveedores_informale;
use App\Models\Muestra_proveedores_informale;

use DB;
use Excel;



class MuestraMaestraCtrl extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth', ['except' => ['getDetalles','getDatacongiguracion']] );
        //$this->middleware('role:Admin|Estadistico', ['except' => ['getDetalles','getDatacongiguracion']] );
        
        $this->middleware('permissions:list-periodosMuestra|create-periodosMuestra|read-periodosMuestra|edit-periodosMuestra|
        excel-muestra|KML-muestra|
        agregar-zona|edit-zona|delete-zona',
        ['only' => ['getPeriodos','getDatalistado']]);
        $this->middleware('permissions:read-muestraMaestra|create-periodosMuestra',['only' => ['getDatacongiguracion'] ]);
        $this->middleware('permissions:create-periodosMuestra',['only' => ['postCrearperiodo'] ]);
        $this->middleware('permissions:edit-periodosMuestra',['only' => ['postEditarperiodo'] ]);
        
        $this->middleware('permissions:excel-muestra',['only' => ['getExcelinfoperiodo'] ]);
        $this->middleware('permissions:KML-muestra',['only' => ['getGeojsonzone'] ]);
        $this->middleware('permissions:create-zona',['only' => ['postAgregarzona'] ]);
        $this->middleware('permissions:edit-zona',['only' => ['postEditarzona','postEditarposicionzona'] ]);
        $this->middleware('permissions:delete-zona',['only' => ['postEliminarzona'] ]);
        $this->middleware('permissions:excel-zona',['only' => ['getExcel'] ]);
        $this->middleware('permissions:llenarInfo-zona|excel-infoZona',['only' => ['postGuardarinfozona','getLlenarinfozona','getExcelinfozona'] ]);
        $this->middleware('permissions:create-proveedorMuestra|edit-proveedorMuestra',['only' => ['postGuardarproveedorinformal'] ]);
        $this->middleware('permissions:edit-proveedorMuestra',['only' => ['postGuardarproveedorinformal','postEditarubicacionproveedor'] ]);
        
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    
    
    public function getDetalles(){
        
        $periodo = Periodos_medicion::orderBy('id', 'desc')->first();
        if($periodo){ return View("MuestraMaestra.periodoPublico", [ "periodo"=> $periodo ]); }
        
        return "No existen periodos en el sitema";
    }
    
    public function getPeriodo($id){  
        
        $periodo = Periodos_medicion::find($id);
        
        if($periodo){
            
            return View("MuestraMaestra.periodo", [ "periodo"=> $periodo ]);
        }
        
        return "Error";
    }
    
    public function getDetalleperiodo($id){
        
        $periodo = Periodos_medicion::find($id);
        
        if($periodo){
            
            return View("MuestraMaestra.DetallePeriodo", [ "periodo"=> $periodo ]);
        }
        
        return "Error";
    }
    
    public function getPeriodos(){
        return View("MuestraMaestra.listado");
    }
    
    public function getCrearperiodo(){
        $idUltimoPeriodo = Periodos_medicion::orderBy('id', 'desc')->pluck("id")->first();
        return View("MuestraMaestra.crear", [ "ultipoPeriodoID"=>$idUltimoPeriodo ]);
    }
    
    public function getDatalistado(){
        return  Periodos_medicion::orderBy("id","DESC")->get();
    }
    
    public function getDatacongiguracion($id){
        
        return json_encode([
               
                "proveedores"=> DB::select("SELECT *from informacion_proveedores_muestra_maestra(?)", array($id) ),
               
                "periodo"=> Periodos_medicion::where("id",$id)
                                             ->with([ "zonas"=>function($q){ $q->with(["encargados"=>function($qq){ $qq->with("user"); } ,"coordenadas"]); } ])->first(),
                
                "digitadores"=>Digitador::whereHas("user", function($q){ $q->where("estado",true); } )->with("user")->get(),
                
                "tiposProveedores"=>Tipo_Proveedor::with([ 
                                                       "tipoProveedoresConIdiomas"=>function($q){ $q->where("idiomas_id",1); },
                                                       "categoriaProveedores"=>function($q){ 
                                                            $q->with([ "categoriaProveedoresConIdiomas"=>function($qq){ 
                                                                     $qq->where("idiomas_id",1);
                                                                } ]); 
                                                           },
                                            ])->select("id")->get(),
                                            
                "sectores"=> Sector::where("estado",true)->with([ 
                                                                 "sectoresConIdiomas"=>function($q){ $q->where("idiomas_id",1); },
                                                                 "destino"=>function($q){ $q->with( ["destinoConIdiomas"=>function($qq){ $qq->where("idiomas_id",1)->select("id","idiomas_id","destino_id","nombre"); }] )->select("id"); }
                                                                ])->select("id","destino_id")->get(),
                "estados"=> Estado_proveedor::where("id","!=",7)->get(),
                
                "municipios"=> municipio::where("departamento_id",1411)->select('id','nombre')->get() 
                //Proveedores_rnt::join("municipios","municipios.id","=","municipio_id")->select('municipios.id','municipios.nombre')->distinct()->get()
                
            ]);
    }
    
    
    public function postEditarperiodo(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:periodos_mediciones,id',
			'nombre' => 'required|max:250',
			'fecha_inicio' => 'required',
			'fecha_fin' => 'required'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		
		$periodos = Periodos_medicion::where(function ($query) use ($request) {
                                $query
                                  ->where  ([ ["fecha_inicio",">=",$request->fecha_inicio], ["fecha_inicio", "<=",$request->fecha_fin],])
                                  ->orWhere([ ["fecha_fin", ">=",  $request->fecha_inicio], ["fecha_fin",  "<=",  $request->fecha_fin],])
                                  ->orWhere([ ["fecha_inicio","<=",$request->fecha_inicio], ["fecha_fin",">=",    $request->fecha_fin],]);
                            })->where("id","!=",$request->id)->count();
        
        if( $periodos>0 ){
    		return ["success"=>false, "Error"=>"El periodo que intentas guardar, se cruza con uno ya existente." ];
		}
		
        $periodo = Periodos_medicion::find($request->id);
        $periodo->nombre = $request->nombre;
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->user_update = $this->user->username;
        $periodo->save();
        
        return ["success"=>true, "periodo"=>$periodo];
        
    }
    
    
    public function postCrearperiodo(Request $request){ 
         
        $validator = \Validator::make($request->all(), [
			'nombre' => 'required|max:250',
			'fecha_inicio' => 'required',
			'fecha_fin' => 'required'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		
		$periodos = Periodos_medicion::where(function ($query) use ($request) {
                                $query
                                  ->where  ([ ["fecha_inicio",">=",$request->fecha_inicio], ["fecha_inicio", "<=",$request->fecha_fin],])
                                  ->orWhere([ ["fecha_fin", ">=",  $request->fecha_inicio], ["fecha_fin",  "<=",  $request->fecha_fin],])
                                  ->orWhere([ ["fecha_inicio","<=",$request->fecha_inicio], ["fecha_fin",">=",    $request->fecha_fin],]);
                            })->where("id","!=",$request->id)->count();
        
        if( $periodos>0 ){
    		return ["success"=>false, "Error"=>"El periodo que intentas guardar, se cruza con uno ya existente." ];
		}
		
        $periodo = new Periodos_medicion(); 
        $periodo->nombre = $request->nombre;
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->user_update = $this->user->username;
        $periodo->user_create = $this->user->username;
        $periodo->estado = true;
        $periodo->save();
        
        foreach($request->zonas as $z){
            $zona = new Zona();
            $zona->periodo_medicion_id = $periodo->id;
            $zona->nombre = $z["nombre"];
            $zona->color =  $z["color"];
            $zona->sector_id =  $z["sector_id"];
            $zona->user_update = $this->user->username;
            $zona->user_create = $this->user->username;
            $zona->estado = true;
            $zona->es_generada = false;
            $zona->es_tabulada = false;
            $zona->save();
            
            foreach($z["coordenadas"] as $coordenada){ 
                $zona->coordenadas()->save( new Coordenadas_zona( [ "x"=>$coordenada[0], "y"=>$coordenada[1] ] ) );
            }
            
            $zona->encargados()->attach( $z["encargados"] );
        }
        
        DB::select("SELECT *from crear_info_muestra_proveedores(?)", array($periodo->id) );
        
        return [ "success"=>true , "id"=>$periodo->id ];
        
    }
    
    public function postAgregarzona(Request $request){ 
        
        $validator = \Validator::make($request->all(), [
			'periodo' => 'required|exists:periodos_mediciones,id',
			'sector_id' => 'required|exists:sectores,id',
			'nombre' => 'required|unique:zonas,nombre,null,null,periodo_medicion_id,' .$request->periodo. '|max:250',
			'encargados' => 'array|min:1',
			'encargados.*' => 'exists:digitadores,id',
			'coordenadas' => 'array|min:3',
			'color' => 'required',
    	]);
       
    	if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()]; }
        
        $polygono = "";
        foreach($request->coordenadas as $coordenada){ 
            $polygono = $polygono . $coordenada["x"]  ." ". $coordenada["y"] .",";
        }
        $polygono = $polygono . $request->coordenadas[0]["x"]  ." ". $request->coordenadas[0]["y"];
        
        $validarZonas = new Collection( DB::select("SELECT *from interseccion_coordenadas(?,?,?)", array( "POLYGON(( $polygono ))" , -1 , $request->periodo )) );
        if( $validarZonas[0]->interseccion_coordenadas ){
    		return ["success"=>false,"error"=>"La zona que intentas guardar se intersecta con otra del mismo periodo." ];
		}
        
        $zona = new Zona();
        $zona->periodo_medicion_id = $request->periodo;
        $zona->sector_id = $request->sector_id;
        $zona->nombre = $request->nombre;
        $zona->color = $request->color;
        $zona->user_update = $this->user->username;
        $zona->user_create = $this->user->username;
        $zona->estado = true;
        $zona->es_generada = false;
        $zona->es_tabulada = false;
        $zona->save();
        
        foreach($request->coordenadas as $coordenada){ 
            $zona->coordenadas()->save( new Coordenadas_zona($coordenada) );
        }
        
        $zona->encargados()->detach();
        $zona->encargados()->attach( $request->encargados );
        
        return [ "success"=> true, "zona"=> Zona::where("id",$zona->id)->with(["encargados","coordenadas"])->first() ];
        
    }
    
    public function postEditarzona(Request $request){ 
        
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:zonas,id',
			'sector_id' => 'required|exists:sectores,id',
			'nombre' => 'required|unique:zonas,nombre,' .$request->id. ',id,periodo_medicion_id,' .$request->periodo_medicion_id. '|max:250',
			'encargados' => 'array|min:1',
			'encargados.*' => 'exists:digitadores,id',
			'nombre' => 'required|max:250',
			'color' => 'required',
    	]);
       
    	if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()];	}
		
		
        $zona = Zona::find($request->id);
        $zona->sector_id = $request->sector_id;
        $zona->nombre = $request->nombre;
        $zona->color = $request->color;
        $zona->user_update = $this->user->username;
        $zona->save();
        
        $zona->encargados()->detach();
        $zona->encargados()->attach( $request->encargados );
        
        return [ "success"=> true, "zona"=> Zona::where("id",$zona->id)->with(["encargados"])->first() ];
        
    }
    
    public function postEliminarzona(Request $request){
        
        $zona = Zona::where([ ["id",$request->zona], ["periodo_medicion_id",$request->periodo] ])->first();
        
        if($zona){
            $zona->encargados()->detach();
            Coordenadas_zona::where("zona_id",$zona->id)->delete();
            $zona->delete();
            return [ "success"=>true ];
        }
        return [ "success"=>false ];
    }
    
    public function postEditarposicionzona(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'id' => 'required|exists:zonas,id',
			'coordenadas' => 'array|min:3',
    	]);
       
    	if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()]; }
		
		
		$zona = Zona::find($request->id);
		
		$polygono = "";
        foreach($request->coordenadas as $coordenada){ 
            $polygono = $polygono . $coordenada[0]  ." ". $coordenada[1] .",";
        }
        $polygono = $polygono . $request->coordenadas[0][0] ." ". $request->coordenadas[0][1];
        
        $validarZonas = new Collection( DB::select("SELECT *from interseccion_coordenadas(?,?,?)", array( "POLYGON(( $polygono ))" , $zona->id , $zona->periodo_medicion_id )) );
        if( $validarZonas[0]->interseccion_coordenadas ){
    		return ["success"=>false,"error"=>"La zona que intentas guardar se intersecta con otra del mismo periodo." ];
		}
        
        
        $zona->user_update = $this->user->username;
        $zona->coordenadas()->delete();
        
        foreach($request->coordenadas as $coordenada){ 
            $zona->coordenadas()->save( new Coordenadas_zona([ "zona_id"=>$zona->id, "x"=>$coordenada[0], "y"=>$coordenada[1] ]) );
        }
        
        return [ "success"=> true, "zona"=> Zona::where("id",$zona->id)->with(["encargados","coordenadas"])->first() ];
        
    }
    
    
    public function getExcel($id){ 

        $zona = Zona::where("id",$id)->with([ "encargados"=>function($qq){ $qq->with("user"); }] )->first();
        if($zona){
         
            $proveedores = new Collection( DB::select("SELECT *from informacion_proveedores_muestra_maestra_zonas(?)", array( $zona->id ) ) );

            $zona->es_generada = true;
            $zona->save();
            
            Excel::create('Periodo', function($excel) use($proveedores, $zona) {
    
                    $excel->sheet('data', function($sheet) use($proveedores, $zona) {
                        
                        $sheet->getStyle('A9:O1000' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        
                        $sheet->cells('A9:O1000', function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $sheet->loadView('MuestraMaestra.formatoDescarga', [ 'proveedores'=> $proveedores, "zona"=>$zona ] );
                    });
    
            })->export('xls');
        }
    }
    
    
    public function getVer($id){  
       
        $zona = Zona::where("id",$id)->with("encargados")->first(); 
        $proveedores = Proveedores_rnt::with([ "estadop", "categoria" ])->get();
        $proveedoresAux = [];
        
        $polygon = Coordenadas_zona::where("zona_id",$zona->id)->get(['x as lat','y as lng'])->toArray();
        
        foreach($proveedores as $proveedor){
            
            $point = [ "lat"=>$proveedor->latitud, "lng"=>$proveedor->longitud ];
            
            $validacion = \GeometryLibrary\PolyUtil::containsLocation($point,$polygon);
            
            if( $validacion ){
                
                $proveedor["nombreCategoria"] =  Categoria_Proveedor_Con_Idioma::where("categoria_proveedores_id",$proveedor->categoria_proveedores_id )->pluck("nombre")->first();
                                                             
                $proveedor["tipo"] = Tipo_Proveedor::join("tipo_proveedores_con_idiomas","tipo_proveedores.id","=","tipo_proveedores_id")
                                                   ->where("tipo_proveedores.id",$proveedor->categoria->tipo_proveedores_id )->pluck("nombre")->first();
                array_push($proveedoresAux, $proveedor );
            }
            
        } 
        return $proveedoresAux;
    }
    
    
    public function getGeojsonzone($periodo){
        
        $periodoData = Periodos_medicion::find($periodo);
        
        $zonas = Zona::where("periodo_medicion_id",$periodo)->with(["coordenadas"=>function($q){ $q->orderBy('id', 'desc'); } ])->get();
        
        $proveedores = new Collection(DB::select("SELECT *from informacion_proveedores_muestra_maestra(?)", array($periodo) ));
        
        $vista =  View("MuestraMaestra.formatoKML", [ "proveedores"=>$proveedores, "zonas"=>$zonas, "periodo"=>$periodoData] )->render();
        return  str_replace("&", " ", $vista);
       
    }
    
    
    private function getArray($array){
        $list = [];
        foreach($array as $item){
           array_push($list, [ $item->y, $item->x ] );
        }
        array_push($list, $list[0] );
        return $list;
    }
    
    ////////////////////////////////////////////////////
    
    public function getDetallezonas($id){
        $periodo = Periodos_medicion::find($id);
        
        if($periodo){
            
            return View( "MuestraMaestra.DetalleZonas", [ "periodo"=> $id ] );
        }
        
        return "Error periodo no encontrada"; 
    }
    
    public function getDatadetallezonas($id){
        
        $periodo = Periodos_medicion::where("id",$id)->with([ "zonas"=>function($q){ $q->with("encargados"); } ])->first();
        
        foreach($periodo->zonas as $zona){
            
            $proveedores = new Collection(DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) ));
            $proveedoresInformales = new Collection(DB::select("SELECT *from proveedor_informal_zonas(?)", array( $zona->id ) ));
            
            $zona["formales"] = count($proveedores);
            $zona["informales"] = count($proveedoresInformales);
            $zona["categorias"] = $this->getCantidadProveedorPorCategoria($zona->id,$proveedores,$proveedoresInformales);
            $zona["estados"] = $this->getCantidadProveedorPorEstado($zona->id,$proveedores,$proveedoresInformales);
            
        }
        return $periodo;
        
    }
    
    private function getCantidadProveedorPorCategoria($id, $prov1, $prov2){
        $categorias = Tipo_Proveedor::with([ "tipoProveedoresConIdiomas"=>function($q){ $q->where("idiomas_id",1); } ])->select("id")->get();
        $data = [];
        
        foreach($categorias as $ctg){
            $d = [
                   "id" => $ctg->id,
                   "nombre"=> $ctg->tipoProveedoresConIdiomas[0]->nombre,
                   "formales"=> $prov1,
                   "informales"=> $prov2->where("idcategoria", $ctg->id )->count(),
                ];
            array_push($data,$d);
        }
        return $data;
    }
    private function getCantidadProveedorPorEstado($id, $prov1, $prov2){
        $estados = Estado_proveedor::where("id","!=",7)->get(); 
        $data = [];
        
        foreach($estados as $std){
            $d = [
                   "id" => $std->id,
                   "nombre"=> $std->nombre,
                   "formales"=> $prov1->where("idestado", $std->id )->count()
                ];
            array_push($data,$d);
        }
        return $data;
    }
    ////////////////////////////////////////////////////
    
    public function getLlenarinfozona($id){
        $zona = Zona::find($id);
        if($zona){
            return View( "MuestraMaestra.llenarInfoZona", [ "zona"=> $id, "periodo"=>$zona->periodo_medicion_id ] );
        }
        return "Error zona no encontrada"; 
    }
    
    
    public function getDatazonallenarinfo($id){
       
        $zona = Zona::where("id",$id)->with("encargados")->first();
        
        if($zona){
            
            return [ 
                      "success"=>true, 
                      "zona"=>$zona, 
                      "proveedores"=> DB::select("SELECT *from informacion_proveedores_muestra_maestra_zonas(?)", array( $zona->id ) ),
                      "tiposProveedores"=>Tipo_Proveedor::with([ 
                                                       "tipoProveedoresConIdiomas"=>function($q){ $q->where("idiomas_id",1)->select("id","tipo_proveedores_id","nombre"); },
                                                       "categoriaProveedores"=>function($q){ 
                                                           $q->select("id","tipo_proveedores_id")
                                                              ->with([ "categoriaProveedoresConIdiomas"=>function($qq){ 
                                                                     $qq->where("idiomas_id",1)->select("id","categoria_proveedores_id","nombre");
                                                                } ]); 
                                                           },
                                            ])->select("id")->get(),
                        "estados"=> Estado_proveedor::get()
                    ];
        }

        return ["success"=>false];
    }
    
    
    public function postGuardarinfozona(Request $request){
        
        $zona = Zona::find($request->zona);
        
        if($zona){
        
           foreach($request->proveedores as $item){
                
                
                if($item["rnt"]){
                    
                    $muestra = Muestra_proveedor::find($item["id"]);
                    
                    if($muestra){
                        
                        if ( $item["estado_muestra_id"] ) { 
                            $muestra->estado_proveedor_id = $item["estado_muestra_id"];
                        }
                        if ( $item["rnt_muestra"] ) { 
                            $muestra->rnt = $item["rnt_muestra"];
                        }
                        if ( $item["nombre_muestra"] ) {
                            $muestra->nombre_proveedor = $item["nombre_muestra"];
                        }
                        if ( $item["direccion_muestra"] ) {
                            $muestra->direccion = $item["direccion_muestra"];
                        }
                        if ( $item["subcategoria_muestra_id"] ) {
                            $muestra->categoria_proveedor_id = $item["subcategoria_muestra_id"];
                        }
                        if ( $item["observaciones_muestra"] ) {
                            $muestra->observaciones = $item["observaciones_muestra"];
                        }
                        
                        $muestra->user_update = $this->user->username;
                        $muestra->save();
                    }
                    
                }
                else{
                    
                    $muestra = Muestra_proveedores_informale::find($item["id"]);
                    
                    if($muestra){
                    
                        if ( $item["estado_muestra_id"] ) {
                            $muestra->estado_proveedor_id = $item["estado_muestra_id"];
                        }
                        if ( $item["rnt_muestra"] ) {
                            $muestra->rnt = $item["rnt_muestra"];
                        }
                        if ( $item["nombre_muestra"] ) {
                            $muestra->nombre_proveedor = $item["nombre_muestra"];
                        }
                        if ( $item["direccion_muestra"] ) {
                            $muestra->direccion = $item["direccion_muestra"];
                        }
                        if ( $item["subcategoria_muestra_id"] ) {
                            $muestra->categoria_proveedor_id = $item["subcategoria_muestra_id"];
                        }
                        if ( $item["observaciones_muestra"] ) {
                            $muestra->observaciones = $item["observaciones_muestra"];
                        }
                        
                        $muestra->user_update = $this->user->username;
                        $muestra->save();
                    }
                }
                
            }
        
            if( $zona->es_tabulada != true ){
                $zona->es_tabulada = true;
                $zona->tabulador = $this->user->digitador->id;
                $zona->save();
            }
        }
        
        return [ "success"=>true ];
    }
    
    public function getExcelinfozona($id){
        
        Excel::create('Data', function($excel) use($id) {
    
                    $excel->sheet('data', function($sheet) use($id) {
                        
                        $sheet->setAutoFilter('A1:O1');
                        
                        $sheet->row(1, [
                            'RNT', 'ActRNT', 'Estado', 'ActEstado', 'Nombre Comercial', 'ActNombreComercial', 'Direccion Comercial', 'ActDirComercial', 'CodCategoria', 'ActCodCategoria', 'CodSubcategoria', 'ActCodSubcategoria', 'Municipio', 'ActMunicipio', 'Novedades', 'GEOPOSICIÓN - LATITUD Y LONGITUD'
                        ]);
                        
                        $proveedores =  new Collection( DB::select("SELECT *from informacion_proveedores_muestra_maestra_zonas(?)", array( $id ) ) ); 
                        foreach($proveedores as $index => $proveedor) {
                            $sheet->row($index+2, [
                                $proveedor->rnt ? $proveedor->rnt : 'No tiene' , $proveedor->rnt_muestra, $proveedor->estado_rnt, $proveedor->estado_muestra, $proveedor->nombre_rnt, $proveedor->nombre_muestra, $proveedor->direccion_rnt, $proveedor->direccion_muestra, $proveedor->categoria_rnt, $proveedor->categoria_muestra, $proveedor->subcategoria_rnt, $proveedor->subcategoria_muestra, $proveedor->municipio_rnt, $proveedor->municipio_rnt,  $proveedor->observaciones_muestra, $proveedor->latitud .' '. $proveedor->longitud
                            ]);	
                        }
                        
                    });
        })->export('xls');
        
    }
    
    
    ///////////////////////////////////////////////////
    
    
    public function getExcelinfoperiodo($id){

        Excel::create('Data', function($excel) use($id) {
    
                    $excel->sheet('data', function($sheet) use($id) {
                        
                        $sheet->setAutoFilter('A1:O1');
                        
                        $sheet->row(1, [
                            'RNT', 'ActRNT', 'Estado', 'ActEstado', 'Nombre Comercial', 'ActNombreComercial', 'Direccion Comercial', 'ActDirComercial', 'CodCategoria', 'ActCodCategoria', 'CodSubcategoria', 'ActCodSubcategoria', 'Municipio', 'ActMunicipio', 'Novedades', 'GEOPOSICIÓN - LATITUD Y LONGITUD'
                        ]);
                        
                        $proveedores = new Collection( DB::select("SELECT *from informacion_proveedores_muestra_maestra(?)", array($id) ) );
                        foreach($proveedores as $index => $proveedor) {
                            $sheet->row($index+2, [
                                $proveedor->rnt ? $proveedor->rnt : 'No tiene' , $proveedor->rnt_muestra, $proveedor->estado_rnt, $proveedor->estado_muestra, $proveedor->nombre_rnt, $proveedor->nombre_muestra, $proveedor->direccion_rnt, $proveedor->direccion_muestra, $proveedor->categoria_rnt, $proveedor->categoria_muestra, $proveedor->subcategoria_rnt, $proveedor->subcategoria_muestra, $proveedor->municipio_rnt, $proveedor->municipio_rnt,  $proveedor->observaciones_muestra, $proveedor->latitud .' '. $proveedor->longitud
                            ]);	
                        }
                        
                    });
    
            })->export('xls');
        
    }
    
    
    
    //////////////////////////////////////////
    
    
    public function postGuardarproveedorinformal(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'nombre_rnt' => 'required|max:250',
			'idPeriodo' => 'required|exists:periodos_mediciones,id',
			'subcategoria_rnt_id' => 'required|exists:categoria_proveedores,id',
			'municipio_rnt_id' => 'required|exists:municipios,id',
			'latitud' => 'required',
			'longitud' => 'required',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
        
        $proveedor = Muestra_proveedores_informale::find($request->id);
        if(!$proveedor){
            $proveedor =  new Muestra_proveedores_informale();
            $proveedor->periodos_medicion_id = $request->idPeriodo;
            $proveedor->estado_proveedor_informal = 7;
            $proveedor->latitud = $request->latitud;
            $proveedor->longitud = $request->longitud;
            $proveedor->user_create = $this->user->username;
            $proveedor->estado = true;
            
            $proveedor->codigo = Muestra_proveedores_informale::where( "municipio_id", $request->municipio_id )->max("codigo") + 1;
            
        }
        
        $proveedor->nombre_proveedor_informal = $request->nombre_rnt;
        $proveedor->direccion_informal = $request->direccion_rnt;
        $proveedor->categoria_proveedor_informal = $request->subcategoria_rnt_id;
        $proveedor->municipio_id = $request->municipio_rnt_id;
        $proveedor->user_update = $this->user->username;
        $proveedor->save();
        
        
        $proveedores = new Collection(DB::select("SELECT *from informacion_proveedores_muestra_maestra(?)", array($proveedor->periodos_medicion_id) ));
       
        return [ "success"=>true,"proveedor"=> $proveedores->where("id",$proveedor->id)->where("rnt",null)->first() ];
    }
    
    public function postEditarubicacionproveedor(Request $request){
        
        
        $validator = \Validator::make($request->all(), [
			'id' => 'required',
			'latitud' => 'required',
			'longitud' => 'required'
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
        
        $proveedor = null;
        if($request->rnt){
            $proveedor = Muestra_proveedor::find($request->id);
        }
        else{
            $proveedor = Muestra_proveedores_informale::find($request->id);
        } 
        $proveedor->latitud  = $request->latitud;
        $proveedor->longitud = $request->longitud;
        $proveedor->save();
        
        return [ "success"=>true ];
    }
 
 
    public function getImportar(){ 
        
        return Proveedores_informale::get();
        
        $rows = Excel::load('storage/datos.xlsx')->get();
        foreach($rows as $row){
           $muni = Municipio::whereRaw("lower(nombre) = '" . strtolower($row["municipio"]) . "'" )->first();
           $cate = Categoria_Proveedor_Con_Idioma::whereRaw("lower(nombre) = '" . strtolower($row["subcategoria"]) . "'" )->first();
           
            $proveedor = new Proveedores_informale();
            $proveedor->estados_proveedor_id = 7;
            $proveedor->latitud = $row->latitud;
            $proveedor->longitud = $row->longitud;
            $proveedor->user_create = "Admin";
            $proveedor->estado = true;
            
            $proveedor->codigo = Proveedores_informale::where( "municipio_id", $muni->id )->max("codigo") + 1;
                
            $proveedor->razon_social = $row->nombre;
            $proveedor->direccion = $row->direccion;
            $proveedor->telefono = "";
            $proveedor->categoria_proveedor_id = $cate->categoria_proveedores_id;
            $proveedor->municipio_id = $muni->id;
            $proveedor->user_update = "Admin";
            $proveedor->save();
           
        }
        return [ "success"=>true ];
    }
    
}
