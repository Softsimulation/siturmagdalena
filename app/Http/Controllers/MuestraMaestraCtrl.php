<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
    
    public function getPeriodos(){
        return View("MuestraMaestra.listado");
    }
    
    
    public function getDatalistado(){
        return  Periodos_medicion::get();
    }
    
    public function getDatacongiguracion($id){
        return [
                "proveedores"=> Proveedores_rnt::with([ "idiomas"=>function($q){ $q->where("idioma_id",1); } ])->get(["id", "latitud","longitud", "estados_proveedor_id"]),
                "periodo"=> Periodos_medicion::where("id",$id)->with([ "zonas"=>function($q){  $q->with("encargados"); } ])->first(),
                "digitadores"=>Digitador::get(),
            ];
    }
    
    
    public function postGuardarperiodo(Request $request){
        
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
		
        $periodo = Periodos_medicion::find($request->id);
        
        if(!$periodo){ 
            $periodo = new Periodos_medicion(); 
            $periodo->user_create = "ADMIN";
            $periodo->estado = true;
        }
        
        $periodo->nombre = $request->nombre;
        $periodo->fecha_inicio = $request->fecha_inicio;
        $periodo->fecha_fin = $request->fecha_fin;
        $periodo->user_update = "ADMIN";
        $periodo->save();
        
        return ["success"=>true, "periodo"=>$periodo];
        
    }
    
    public function postGuardarzona(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'periodo' => 'required|exists:periodos_mediciones,id',
			'nombre' => 'required|max:250',
			'posicion_1' => 'required',
			'posicion_2' => 'required',
			'posicion_3' => 'required',
			'posicion_4' => 'required',
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
        
        $zonas = Zona::where([ ["id","!=",$request->id], ["periodo_medicion_id",$request->periodo] ])->get();
        
        foreach($zonas as $zona){
            
            if( (floatval($zona->posicion_1)>=$request->posicion_1 && floatval($zona->posicion_3)<=$request->posicion_1) || 
                (floatval($zona->posicion_1)>=$request->posicion_3 && floatval($zona->posicion_3)<=$request->posicion_3) ||
                ($request->posicion_1>=floatval($zona->posicion_1) && $request->posicion_3<=floatval($zona->posicion_3)) ){
                 
                    if( (floatval($zona->posicion_2)>=$request->posicion_2 && floatval($zona->posicion_4)<=$request->posicion_2) || 
                        (floatval($zona->posicion_2)>=$request->posicion_4 && floatval($zona->posicion_4)<=$request->posicion_4) ||
                        ($request->posicion_2>=floatval($zona->posicion_2) && $request->posicion_4<=floatval($zona->posicion_4)) ){
                        return ["success"=>false, "Error"=>"La zona que intestas guardar, no debe colisionar con otra zona." ];
                    }   
            }
        }
        
        $zona = Zona::find($request->id);
        
        if(!$zona){ 
            $zona = new Zona();
            $zona->periodo_medicion_id = $request->periodo;
            $zona->user_create = "ADMIN";
            $zona->estado = true;
        }
        
        $zona->nombre = $request->nombre;
        $zona->posicion_1 = $request->posicion_1;
        $zona->posicion_2 = $request->posicion_2;
        $zona->posicion_3 = $request->posicion_3;
        $zona->posicion_4 = $request->posicion_4;
        $zona->user_update = "ADMIN";
        $zona->save();
        
        $zona->encargados()->detach();
        $zona->encargados()->attach( $request->encargados );
        
        return ["success"=>true, "data"=>Periodos_medicion::where("id",$request->periodo)->with([ "zonas"=>function($q){  $q->with("encargados"); } ])->first(), ];
        
    }
    
    public function getExcel($id){ 

        $zona = Zona::find($id);
        if($zona){
            $proveedores = Proveedores_rnt::with([ "estadop", "categoria" ])->get();
            $proveedoresAux = [];
            foreach($proveedores as $proveedor){
                
                if( floatval($proveedor->latitud) >= floatval($zona->posicion_3) && floatval($proveedor->latitud) <= floatval($zona->posicion_1) && floatval($proveedor->longitud) >= floatval($zona->posicion_4) && floatval($proveedor->longitud) <=floatval($zona->posicion_2)){
                    
                    $proveedor["nombreCategoria"] =  Categoria_Proveedor_Con_Idioma::where("categoria_proveedores_id",$proveedor->categoria_proveedores_id )->pluck("nombre")->first();
                                                                 
                    $proveedor["tipo"] = Tipo_Proveedor::join("tipo_proveedores_con_idiomas","tipo_proveedores.id","=","tipo_proveedores_id")
                                                       ->where("tipo_proveedores.id",$proveedor->categoria->tipo_proveedores_id )->pluck("nombre")->first();
                    array_push($proveedoresAux, $proveedor );
                }
                
            } 
     
            Excel::create('Periodo', function($excel) use($proveedoresAux, $zona) {
    
                    $excel->sheet('data', function($sheet) use($proveedoresAux, $zona) {
                        //$sheet->setAutoFilter('A9:O9');
                        $sheet->getStyle('A9:O1000' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                        
                        $sheet->cells('A9:O1000', function($cells) {
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                        });
                        $sheet->loadView('MuestraMaestra.formatoDescarga', [ 'proveedores'=> $proveedoresAux, "zona"=>$zona ] );
                    });
    
            })->export('xls');
        }
    }
    
    
    public function getVer($id){  
        $zona = Zona::find($id);
        $proveedores = Proveedores_rnt::with([ "estadop", "categoria" ])->get();
        $proveedoresAux = [];
        
        
        
        foreach($proveedores as $proveedor){
            
            array_push($proveedoresAux, [ "latitud"=>floatval($proveedor->latitud), 
                       "longitud"=>floatval($proveedor->longitud),
                       "zona"=> [ "posicion_1"=>floatval($zona->posicion_1) ,"posicion_2"=>floatval($zona->posicion_2) ,"posicion_3"=>floatval($zona->posicion_3) ,"posicion_4"=>floatval($zona->posicion_4)  ]
                    ] );
            
            if( floatval($proveedor->latitud) >= floatval($zona->posicion_1) && floatval($proveedor->latitud) <= floatval($zona->posicion_3) && floatval($proveedor->longitud) >= floatval($zona->posicion_2) && floatval($proveedor->longitud) <=floatval($zona->posicion_4)){
                
                $proveedor["nombreCategoria"] =  Categoria_Proveedor_Con_Idioma::where("categoria_proveedores_id",$proveedor->categoria_proveedores_id )->pluck("nombre")->first();
                                                             
                $proveedor["tipo"] = Tipo_Proveedor::join("tipo_proveedores_con_idiomas","tipo_proveedores.id","=","tipo_proveedores_id")
                                                   ->where("tipo_proveedores.id",$proveedor->categoria->tipo_proveedores_id )->pluck("nombre")->first();
                array_push($proveedoresAux, $proveedor );
            }
            
        } 
        dd($proveedoresAux);
    }
    
}
