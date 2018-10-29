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
        
        $this->middleware('auth');
        $this->middleware('role:Admin');
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
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
        return  Periodos_medicion::get();
    }
    
    public function getDatacongiguracion($id){
        
        
        return [
               
                "proveedores"=> DB::select("SELECT *from proveedores_formales"),
                                     
                "proveedoresInformales" => DB::select("SELECT *from listado_proveedores_informales"),
                
                "periodo"=> Periodos_medicion::where("id",$id)
                                             ->with([ "zonas"=>function($q){ $q->with(["encargados","coordenadas"]); } ])->first(),
                
                "digitadores"=>Digitador::get(),
                
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
                                                                 "destino"=>function($q){ $q->with( ["destinoConIdiomas"=>function($qq){ $qq->where("idiomas_id",1); }] ); }
                                                                ])->get(),
                "estados"=> Estado_proveedor::where("id","!=",7)->get(),
                
                "municipios"=> municipio::where("departamento_id",1411)->select('id','nombre')->get() 
                //Proveedores_rnt::join("municipios","municipios.id","=","municipio_id")->select('municipios.id','municipios.nombre')->distinct()->get()
                
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

        $zona = Zona::where("id",$id)->with("encargados")->first();
        if($zona){
         
            $proveedores = new Collection( DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) ) );
            $proveedoresInformales = new Collection( DB::select("SELECT *from proveedor_informal_zonas(?)", array( $zona->id ) ) );
            
            $zona->es_generada = true;
            $zona->save();
            
            Excel::create('Periodo', function($excel) use($proveedores, $proveedoresInformales, $zona) {
    
                    $excel->sheet('data', function($sheet) use($proveedores, $proveedoresInformales, $zona) {
                        
                        $sheet->getStyle('A9:O1000' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        
                        $sheet->cells('A9:O1000', function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $sheet->loadView('MuestraMaestra.formatoDescarga', [ 'proveedores'=> $proveedores, "proveedoresInformales"=>$proveedoresInformales, "zona"=>$zona ] );
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
        
        $proveedores = Proveedores_rnt::where([ ["latitud","!=",null], ["longitud","!=",null] ])
                                      ->with([ "estadoP", "idiomas"=>function($q){ $q->where("idioma_id",1); } ])->get();
        
        $proveedoresInformales = Proveedores_informale::where([ ["latitud","!=",null], ["longitud","!=",null] ])->get();
        
        $vista =  View("MuestraMaestra.formatoKML", [ "proveedores"=>$proveedores, "zonas"=>$zonas, "proveedoresInformales"=>$proveedoresInformales, "periodo"=>$periodoData] )->render();
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
            
            return $proveedores = new Collection(DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) ));
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
        
            $proveedores = DB::select("SELECT *from proveedor_zonas(?)", array( $zona->id ) );
            $proveedoresInformales =  DB::select("SELECT *from proveedor_informal_zonas(?)", array( $zona->id ) );
            
            foreach($proveedores as $proveedor){
                $proveedor->{"muestra"} = Muestra_proveedor::where([ ["zona_id",$zona->id], ["proveedor_rnt_id",$proveedor->id] ])->first();
            } 
            
            foreach($proveedoresInformales as $proveedor){
                $proveedor->{"muestra"} = Muestra_proveedores_informale::where([ ["zona_id",$zona->id], ["proveedores_informal_id",$proveedor->id] ])->first();
            } 

            return [ 
                      "success"=>true, 
                      "zona"=>$zona, 
                      "proveedores"=>$proveedores,
                      "proveedoresInformales"=>$proveedoresInformales,
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
                $muestra->user_create = $this->user->username;
                $muestra->estado = true;
            }
            
            $muestra->estado_proveedor_id = $item["muestra"]["estado_proveedor_id"];
            $muestra->rnt = $item["muestra"]["rnt"];
            $muestra->nombre_proveedor = $item["muestra"]["nombre_proveedor"];
            $muestra->direccion = $item["muestra"]["direccion"];
            $muestra->categoria_proveedor_id = $item["muestra"]["categoria_proveedor_id"];
            $muestra->observaciones = $item["muestra"]["observaciones"];
            $muestra->user_update = $this->user->username;
            $muestra->save();
        }
        
        
        foreach($request->proveedoresInformales as $item){
            
            $muestra = Muestra_proveedores_informale::where([ ["zona_id",$request->zona], ["proveedores_informal_id",$item["id"]] ])->first();
            
            if( !$muestra ){
                $muestra = new Muestra_proveedores_informale();
                $muestra->zona_id = $request->zona;
                $muestra->proveedores_informal_id = $item["id"];
                $muestra->user_create = $this->user->username;
                $muestra->estado = true;
            }
            
            $muestra->estado_proveedor_id = $item["muestra"]["estado_proveedor_id"];
            $muestra->nombre_proveedor = $item["muestra"]["nombre_proveedor"];
            $muestra->direccion = $item["muestra"]["direccion"];
            $muestra->categoria_proveedor_id = $item["muestra"]["categoria_proveedor_id"];
            $muestra->observaciones = $item["muestra"]["observaciones"];
            $muestra->user_update = $this->user->username;
            $muestra->save();
        }
        
        
        return [ "success"=>true ];
    }
    
    public function getExcelinfozona($id){
        
        $proveedores = Muestra_proveedor::where("zona_id",$id)
                                        ->with([ "estadop",
                                                 "categoria"=>function($q){ $q->with([ 
                                                                                       "categoriaProveedoresConIdiomas"=>function($qq){ $qq->where("idiomas_id",1); },
                                                                                       "tipoProveedore"=>function($qq){ $qq->with(["tipoProveedoresConIdiomas"=>function($qqq){$qqq->where("idiomas_id",1);} ]); },
                                                                                    ]);
                                                                          },
                                                 "proveedor"=>function($q){ 
                                                                            $q->with([  "estadop", 
                                                                                        "categoria"=>function($q){ $q->with([ 
                                                                                                                               "categoriaProveedoresConIdiomas"=>function($qq){ $qq->where("idiomas_id",1); },
                                                                                                                               "tipoProveedore"=>function($qq){ $qq->with(["tipoProveedoresConIdiomas"=>function($qqq){$qqq->where("idiomas_id",1);}
                                                                                                                            ]);
                                                                                                    },
                                                                                    ]);
                                                                          }
                                                                                    ]);
                                                                          } 
                                                     ])->get();
        //return View("MuestraMaestra.formatoDescargaInformacionZona", [ "proveedores"=> $proveedores ]);
        Excel::create('Data', function($excel) use($proveedores) {
    
                    $excel->sheet('data', function($sheet) use($proveedores) {
                        $sheet->setAutoFilter('A1:O1');
                        $sheet->loadView('MuestraMaestra.formatoDescargaInformacionZona', [ 'proveedores'=> $proveedores ] );
                    });
    
            })->export('xls');
        
    }
    
    
    ///////////////////////////////////////////////////
    
    
    public function getExcelinfoperiodo($id){
        
        
        $proveedores = new Collection(DB::select("SELECT *from proveedores_periodos(?)", array($id) ));
        $proveedoresInformales = new Collection(DB::select("SELECT *from proveedores_informales_periodos(?)", array($id) ));
        
                           
        //return View("MuestraMaestra.formatoDescargaInformacionPeriodo", [ "proveedores"=> $proveedores, "proveedoresInformales"=> $proveedoresInformales ]);
        Excel::create('Data', function($excel) use($proveedores, $proveedoresInformales) {
    
                    $excel->sheet('data', function($sheet) use($proveedores, $proveedoresInformales) {
                        $sheet->setAutoFilter('A1:O1');
                        $sheet->loadView('MuestraMaestra.formatoDescargaInformacionPeriodo', [ 'proveedores'=> $proveedores, "proveedoresInformales"=> $proveedoresInformales ] );
                    });
    
            })->export('xls');
        
    }
    
    
    
    //////////////////////////////////////////
    
    
    public function postGuardarproveedorinformal(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'nombre' => 'required|max:250',
			'idcategoria' => 'required|exists:categoria_proveedores,id',
			'municipio_id' => 'required|exists:municipios,id',
			'latitud' => 'required',
			'longitud' => 'required',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
        
        $proveedor = Proveedores_informale::find($request->id);
        if(!$proveedor){
            $proveedor =  new Proveedores_informale();
            $proveedor->estados_proveedor_id = 7;
            $proveedor->latitud = $request->latitud;
            $proveedor->longitud = $request->longitud;
            $proveedor->user_create = $this->user->username;
            $proveedor->estado = true;
            
            $proveedor->codigo = Proveedores_informale::where( "municipio_id", $request->municipio_id )->max("codigo") + 1;
            
        }
        
        $proveedor->razon_social = $request->nombre;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->categoria_proveedor_id = $request->idcategoria;
        $proveedor->municipio_id = $request->municipio_id;
        $proveedor->user_update = $this->user->username;
        $proveedor->save();
        
        return [ "success"=>true, "proveedor"=> DB::select("SELECT *from listado_proveedores_informales where id = ". $proveedor->id )[0] ];
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
