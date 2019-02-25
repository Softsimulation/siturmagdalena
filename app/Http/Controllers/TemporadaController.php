<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Temporada;
use App\Models\Hogar;
use App\Models\Persona;
use App\Models\Viaje;

class TemporadaController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        //$this->middleware('role:Admin');
        $this->middleware('permissions:list-temporada|create-temporada|read-temporada|edit-temporada|estado-temporada|create-encuestaInterno|edit-encuestaInterno',['only' => ['getIndex','getGettemporadas'] ]);
        $this->middleware('permissions:create-temporada|edit-temporada',['only' => ['postGuardartemporada'] ]);
        $this->middleware('permissions:read-temporada',['only' => ['getVer','getCargardatos'] ]);
        $this->middleware('permissions:estado-temporada',['only' => ['postCambiarestado'] ]);
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
        
        
    }
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
        })->with('edificacione.barrio')->with('edificacione.estrato')->with('digitadore.user')->get();
        
        $encuestas=Viaje::where('es_principal',true)->whereHas('persona.hogare.edificacione',function($q)use($temporada){
            $q->where('temporada_id',$temporada->id);
        })->with('persona.hogare.digitadore.user')->with('persona.hogare.edificacione.barrio.municipio')->with('persona.hogare.edificacione.estrato')->orderby('id')->get();
        
        return ['temporada'=>$temporada,'encuestas'=>$encuestas];
        
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
               'Fecha_ini'=>'required|date|before:tomorrow',
               'Fecha_fin'=>'required|date|after:Fecha_ini|before:tomorrow'
               
            ],["Fecha_ini.required"=>"La fecha de inicio de la temporada es requerida",
               "Fecha_fin.required"=>"La fecha de fin de la temporada es requerida",
               "Fecha_ini.date"=>"La fecha de inicio debe ser una fecha valida",
               "Fecha_ini.before"=>"La fecha de inicio no debe ser futura",
               "Fecha_fin.date"=>"La fecha de fin debe ser una fecha valida",
               "Fecha_fin.after"=>"La fecha de fin debe ser posterior a la fecha de inicio",
               
               
               ]);
            
        if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        
        if($request->id == null){
            
            $aux=Temporada::where(function ($query) use ($request) {
                
                                        $query->where('fecha_ini', '>=', $request->Fecha_ini);
                                        $query->where('fecha_ini', '<=', $request->Fecha_fin);
                                        
                                    })->orwhere(function ($query) use ($request) {
                                        
                                        $query->where('fecha_fin', '>=', $request->Fecha_ini);
                                        $query->where('fecha_fin', '<=', $request->Fecha_fin);
                                        
                                    })->orwhere(function ($query) use ($request) {
                                        
                                        $query->where('fecha_ini', '<', $request->Fecha_ini);
                                        $query->where('fecha_fin', '>', $request->Fecha_fin);
                                        
                                    })->get();
        }else{
            
            $aux=Temporada::where('id','!=',$request->id)->where(function($query1) use ($request){
                
                                    $query1->where(function ($query) use ($request) {
                
                                        $query->where('fecha_ini', '>=', $request->Fecha_ini);
                                        $query->Where('fecha_ini', '<=', $request->Fecha_fin);
                                        
                                    })->orwhere(function ($query) use ($request) {
                                        
                                        $query->where('fecha_fin', '>=', $request->Fecha_ini);
                                        $query->Where('fecha_fin', '<=', $request->Fecha_fin);
                                        
                                    })->orwhere(function ($query) use ($request) {
                                        
                                        $query->where('fecha_ini', '<', $request->Fecha_ini);
                                        $query->Where('fecha_fin', '>', $request->Fecha_fin);
                                        
                                    });
                
            })->get();
            
            
        }
                                
        if($aux->count()>0){
            
            return ["success"=>false,"errores"=>["temporada"=>["Ya existen una temporada creada para estas fechas"]]];
            
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
        $temporada->user_create = $this->user->username;
        $temporada->user_update = $this->user->username;
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
