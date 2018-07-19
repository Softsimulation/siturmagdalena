<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;

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

use DB;
use Excel;



class MuestraMaestraCtrl extends Controller
{
    
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
        return  Periodos_medicion::get();
    }
    
    public function getDatacongiguracion($id){
        
        
        return [
                "proveedores"=> Proveedores_rnt::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                      ->with([ "estadop", "categoria", "idiomas"=>function($q){ $q->where("idioma_id",1); } ])
                                      ->get(),
                                      
                "proveedoresInformales" => Proveedores_informale::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                                      ->with("categoria")->get(),
                
                "periodo"=> Periodos_medicion::where("id",$id)
                                             ->with([ "zonas"=>function($q){ $q->with(["encargados","coordenadas"]); } ])->first(),
                
                "digitadores"=>Digitador::get(),
                
                "tiposProveedores"=>Tipo_Proveedor::with([ 
                                                       "tipoProveedoresConIdiomas"=>function($q){ $q->where("idiomas_id",1)->select("id","tipo_proveedores_id","nombre"); },
                                                       "categoriaProveedores"=>function($q){ 
                                                           $q->select("id","tipo_proveedores_id")
                                                              ->with([ "categoriaProveedoresConIdiomas"=>function($qq){ 
                                                                     $qq->where("idiomas_id",1)->select("id","categoria_proveedores_id","nombre");
                                                                } ]); 
                                                           },
                                            ])->select("id")->get(),
                "sectores"=> Sector::where("estado",true)->with([ 
                                                                 "sectoresConIdiomas"=>function($q){ $q->where("idiomas_id",1); },
                                                                 "destino"=>function($q){ $q->with( ["destinoConIdiomas"=>function($qq){ $qq->where("idiomas_id",1); }] ); }
                                                                ])->get(),
                "estados"=> Estado_proveedor::get(),
                
                "municipios"=> Proveedores_rnt::join("municipios","municipios.id","=","municipio_id")->select('municipios.id','municipios.nombre')->distinct()->get()
                
            ];
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
        $periodo->user_update = "ADMIN";
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
        $periodo->user_update = "ADMIN";
        $periodo->user_create = "ADMIN";
        $periodo->estado = true;
        $periodo->save();
        
        foreach($request->zonas as $z){
            $zona = new Zona();
            $zona->periodo_medicion_id = $periodo->id;
            $zona->nombre = $z["nombre"];
            $zona->color =  $z["color"];
            $zona->user_update = "ADMIN";
            $zona->user_create = "ADMIN";
            $zona->estado = true;
            $zona->save();
            
            foreach($z["coordenadas"] as $coordenada){ 
                $zona->coordenadas()->save( new Coordenadas_zona( [ "x"=>$coordenada[0], "y"=>$coordenada[1] ] ) );
            }
            
            $zona->encargados()->attach( $z["encargados"] );
        }
        
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
        $zona->user_update = "ADMIN";
        $zona->user_create = "ADMIN";
        $zona->estado = true;
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
        $zona->user_update = "ADMIN";
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
        
        
        $zona->user_update = "ADMIN";
        $zona->coordenadas()->delete();
        
        foreach($request->coordenadas as $coordenada){ 
            $zona->coordenadas()->save( new Coordenadas_zona([ "zona_id"=>$zona->id, "x"=>$coordenada[0], "y"=>$coordenada[1] ]) );
        }
        
        return [ "success"=> true, "zona"=> Zona::where("id",$zona->id)->with(["encargados","coordenadas"])->first() ];
        
    }
    
    
    public function getExcel($id){ 

        $zona = Zona::where("id",$id)->with("encargados")->first();
        if($zona){
         
            $proveedores = new Collection( DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) ) );
    
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
    
    
    public function postGeojsonzone(Request $request){
        
        $zonas = [];
        $proveedores = [];
        
        $dataZonas = Zona::where("periodo_medicion_id",$request->periodo)->with(["coordenadas"=>function($q){ $q->orderBy('id', 'desc'); } ])->get();
        
        $dataProveedores = [];
        
        if( $request->tipoProveedor && count($request->categorias)>0 ){
            $dataProveedores = Proveedores_rnt::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                          ->whereIn( "categoria_proveedores_id",$request->categorias )
                                          ->with([ "idiomas"=>function($q){ $q->where("idioma_id",1); } ])
                                          ->get( ["id", "latitud as lat", "longitud as lng"] );
        }
        else
        if( $request->tipoProveedor && count($request->categorias)==0 ){
            $dataProveedores = Proveedores_rnt::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                          ->whereHas('categoria', function ($q) use($request) { $q->where('tipo_proveedores_id', $request->tipoProveedor ); })
                                          ->with([ "idiomas"=>function($q){ $q->where("idioma_id",1); } ])
                                          ->get( ["id", "latitud as lat", "longitud as lng"] );
        }
        else{
            $dataProveedores = Proveedores_rnt::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                          ->with([ "idiomas"=>function($q){ $q->where("idioma_id",1); } ])
                                          ->get( ["id", "latitud as lat", "longitud as lng"] );
        }
        
        $periodo = Periodos_medicion::find($request->periodo);
        
        foreach($dataProveedores as $p){
            
            $proveedor = [
                            "type"=> "Feature",
                            "properties"=> [ "name"=> count($p->idiomas) > 0 ? $p->idiomas[0]->nombre : "---" ],
                            "geometry"=> [
                               "type"=> "Point",
                               "coordinates"=> [ floatval($p->lng), floatval($p->lat) ]
                            ]
                        ];
                        
            array_push($proveedores,$proveedor);
        }
        
        foreach($dataZonas as $z){
            
            $zona = [
                        "type"=> "Feature",
                        "properties"=> [ "name"=> $z->nombre, "fill"=> $z->color ],
                        "geometry"=> [
                           "type"=> "Polygon",
                           "coordinates"=>[ $this->getArray( $z->coordenadas ) ]
                        ]
                    ];
            
            array_push($zonas,$zona);
        }
        
        return [
                "type" => "FeatureCollection",
                "name"=> $periodo->nombre,
                "description"=> "Periodo de medición comprendido entre " .$periodo->fecha_inicio. " hasta " .$periodo->fecha_fin. ".",
                "features" => array_merge($zonas,$proveedores)
            ];
        
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
        
            $proveedores = DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) );
            
            foreach($proveedores as $proveedor){
                $proveedor->{"muestra"} = Muestra_proveedor::where([ ["zona_id",$zona->id], ["proveedor_rnt_id",$proveedor->id] ])->first();
            } 

            return [ 
                      "success"=>true, 
                      "zona"=>$zona, 
                      "proveedores"=>$proveedores,
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
        
        foreach($request->proveedores as $item){
            
            $muestra = Muestra_proveedor::where([ ["zona_id",$request->zona], ["proveedor_rnt_id",$item["id"]] ])->first();
            
            if( !$muestra ){
                $muestra = new Muestra_proveedor();
                $muestra->zona_id = $request->zona;
                $muestra->proveedor_rnt_id = $item["id"];
                $muestra->user_create = "BRCC";
                $muestra->estado = true;
            }
            
            $muestra->estado_proveedor_id = $item["muestra"]["estado_proveedor_id"];
            $muestra->rnt = $item["muestra"]["rnt"];
            $muestra->nombre_proveedor = $item["muestra"]["nombre_proveedor"];
            $muestra->direccion = $item["muestra"]["direccion"];
            $muestra->categoria_proveedor_id = $item["muestra"]["categoria_proveedor_id"];
            $muestra->observaciones = $item["muestra"]["observaciones"];
            $muestra->user_update = "BRCC";
            $muestra->save();
        }
        
        return [ "success"=>true ];
    }
    
    public function getExcelinfozona($id){
        
        $proveedores = Muestra_proveedor::where("zona_id",$id)->with([ "estadop", "proveedor"=>function($q){ $q->with("estadop"); } ])->get();
        //return View("MuestraMaestra.formatoDescargaInformacion", [ "proveedores"=> $proveedores ]);
        Excel::create('Data', function($excel) use($proveedores) {
    
                    $excel->sheet('data', function($sheet) use($proveedores) {
                        $sheet->setAutoFilter('A1:O1');
                        $sheet->loadView('MuestraMaestra.formatoDescargaInformacionZona', [ 'proveedores'=> $proveedores ] );
                    });
    
            })->export('xls');
        
    }
    
    
    ///////////////////////////////////////////////////
    
    
    public function getExcelinfoperiodo($id){
        
        $proveedores = Muestra_proveedor::whereHas('zona',function ($q) use($id){  $q->where( 'periodo_medicion_id', $id); })
                                        ->with([ "estadop", "proveedor"=>function($q){ $q->with(["municipio","estadop"]); } ])
                                        ->get();
                                   
        //return View("MuestraMaestra.formatoDescargaInformacionPeriodo", [ "proveedores"=> $proveedores ]);
        Excel::create('Data', function($excel) use($proveedores) {
    
                    $excel->sheet('data', function($sheet) use($proveedores) {
                        $sheet->setAutoFilter('A1:O1');
                        $sheet->loadView('MuestraMaestra.formatoDescargaInformacionPeriodo', [ 'proveedores'=> $proveedores ] );
                    });
    
            })->export('xls');
        
    }
    
    
    
    //////////////////////////////////////////
    
    
    public function postGuardarproveedorinformal(Request $request){
        
        $proveedor = Proveedores_informale::find($request->id);
        if(!$proveedor){
            $proveedor =  new Proveedores_informale();
            $proveedor->latitud = $request->latitud;
            $proveedor->longitud = $request->longitud;
            $proveedor->user_create = "Admin";
            $proveedor->estado = true;
        }
        
        $proveedor->razon_social = $request->razon_social;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->categoria_proveedor_id = $request->categoria_proveedor_id;
        $proveedor->user_update = "Admin";
        $proveedor->save();
        
        return [ "success"=>true, "proveedor"=>Proveedores_informale::where("id",$proveedor->id) ->with("categoria")->first() ];
    }
    
    public function postEditarubicacionproveedor(Request $request){
        
        
        $proveedor = null;
        if($request->numero_rnt){
            $proveedor = Proveedores_rnt::find($request->id);
        }
        else{
            $proveedor = Proveedores_informale::find($request->id);
        }
        $proveedor->latitud  = $request->latitud;
        $proveedor->longitud = $request->longitud;
        $proveedor->save();
        
        return [ "success"=>true ];
    }
    
}
