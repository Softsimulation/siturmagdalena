<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Temporada;
use App\Models\Hogar;
use App\Models\Persona;

class TemporadaController extends Controller
{
    public function getIndex(){
        
        return view('temporada.Index');
        
    }
    
    public function getVer($one){
        
        $id=$one;
        return view('temporada.Ver',compact('id'));
        
    }
    
    public function getCargardatos($one){
        
        $temporada=Temporada::where('id',$one)
        ->first(["id",
                  "nombre as Nombre",
                  "name as Name",
                  "fecha_ini as Fecha_ini",
                  "fecha_fin as Fecha_fin"
                  ]);
                  
        $temporada->Hogares=Hogar::whereHas('edificacione',function($q)use($temporada){
            $q->where('temporada_id',$temporada->id);
        })->with('edificacione.barrio')->with('edificacione.estrato')->get();
        
        $hogares=Persona::whereHas('viajes',function($q){
                
                $q->where('es_principal',true);
                
        })->with('viajes')->with('hogare.digitadore')->get();
        
        
        
        return ['temporada'=>$temporada,'hogares'=>$hogares];
        
    }
    
    public function getGettemporadas(){
        
        $temporadas=Temporada::orderby('created_at','desc')
                    ->get([
                            'id',
                            'nombre as Nombre',
                            'name as Name',
                            'fecha_ini as Fecha_ini',
                            'fecha_fin as Fecha_fin',
                            'estado as Estado']);
                            
        return ['temporadas'=>$temporadas];
        
    }
    
    public function postGuardartemporada(Request $request){
        
         $validator=\Validator::make($request->all(),[
                       
               'Nombre'=>'required',
               'Name'=>'required',
               'Fecha_ini'=>'required|date',
               'Fecha_fin'=>'required|date|after:Fecha_ini'
               
            ]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        if($request->id == null){
            $temporada=new Temporada();
        }else{
            $temporada=Temporada::find($request->id);
        }
        
        $temporada->nombre = $request->Nombre;
        $temporada->name = $request->Name;
        $temporada->fecha_ini = $request->Fecha_ini;
        $temporada->fecha_fin = $request->Fecha_fin;
        $temporada->user_create = "Situr";
        $temporada->user_update = "Situr";
        $temporada->save();
        
        return ['success' => true, 'temporada' => $temporada ];
    }
    
    public function postCambiarestado(Request $request){
        
         $validator=\Validator::make($request->all(),[
               'id'=>'required',
               'Estado'=>'required'
               
            ]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $temporada=Temporada::find($request->id);
        $temporada->estado=!$request->Estado;
        $temporada->save();
        
        return ['success'=>true,'estado'=>$temporada->estado];
        
    }
    
    
    
    
}
