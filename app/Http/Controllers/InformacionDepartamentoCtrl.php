<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;
use File;
use App\Models\Informacion_departamento;
use App\Models\Inoformacion_departamento_imagenes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class InformacionDepartamentoCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['AcercaDe','Requisitos', 'PlanificaTuViaje'] ]);
        $this->middleware('role:Admin|Promocion',['except' => ['AcercaDe','Requisitos', 'PlanificaTuViaje'] ]);
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
    }
    
    public function AcercaDe(){
        return View("informacionDepartamento.detalle", [ "informacion"=>Informacion_departamento::with("imagenes")->where( "id",1 )->first()  ] );
    }
    
    public function Requisitos(){
        return View("informacionDepartamento.detalle", [ "informacion"=>Informacion_departamento::with("imagenes")->where( "id",2 )->first()  ] );
    }
    
    public function PlanificaTuViaje(){
        return View("informacionDepartamento.detalle", [ "informacion"=>Informacion_departamento::with("imagenes")->where( "id",3 )->first()  ] );
    }
    
    public  function getConfiguracionacercade(){
        return View("informacionDepartamento.configuracion", [ "id"=>1 ] );
    }
    
    public  function getConfiguracionrequisitos(){
        return View("informacionDepartamento.configuracion", [ "id"=>2 ]);
    }
    
    public  function getConfiguracionplanificatuviaje(){
        return View("informacionDepartamento.configuracion", [ "id"=>3 ] );
    }
    
    public  function getData($id){
        return Informacion_departamento::with("imagenes")->where( "id",$id )->first();
    }
    
    public  function postGuardar(Request $request){
        
        $validator = \Validator::make($request->all(),[
            'id' => 'required|exists:informacion_departamento,id',
            'titulo' => 'required|string|max:500',
            'cuerpo' => 'required'
        ],[
            'id.required' => 'Error en los datos.',
            'id.exists' => 'Error en los datos.',
            'titulo.required' => 'El titulo es requerido.',
            'titulo.max' => 'El titulo supera el maximo número de caracteres.',
            'cuerpo.required' => 'El cuerpo es requerido.',
            ]
        );
        
        if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()]; }
        
        $informacion = Informacion_departamento::find($request->id);
        
        $informacion->titulo = $request->titulo;
        $informacion->cuerpo = $request->cuerpo;
        $informacion->user_update = "Admin";
        
        $informacion->save();
        
        return [ "success"=>true ];
    }
    
    public  function postGuardarvideo(Request $request){
        
        $validator = \Validator::make($request->all(),[
            'id' => 'required|exists:informacion_departamento,id',
            'video' => 'required|string',
        ],[
            'id.required' => 'Error en los datos.',
            'id.exists' => 'Error en los datos.',
            'video.required' => 'El titulo es requerido.',
            ]
        );
        
        if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()]; }
        
        $informacion = Informacion_departamento::find($request->id);
        
        $informacion->video = $request->video;
        $informacion->user_update = "Admin";
        $informacion->save();
        
        return [ "success"=>true ];
    }
    
    public function postGuardargaleria(Request $request){
        
        
        $validator = \Validator::make($request->all(),[
            'id' => 'required|exists:informacion_departamento,id',
            'galeria' => 'required|array|min:1',
        ],[
            'id.required' => 'Error en los datos.',
            'id.exists' => 'Error en los datos.',
            'galeria.required' => 'Imagenes requerida.',
            'galeria.array' => 'Imagenes requerida.',
            'galeria.min' => 'Imagenes requerida.'
            ]
        );
        
        if($validator->fails()){ return ["success"=>false,"errores"=>$validator->errors()]; }
        
        
       
        foreach($request->galeria  as $file){
            $imagen = new Inoformacion_departamento_imagenes();
            $imagen->informacion_id = $request->id;
            
            $portadaNombre = "imagen_". ($this->random_string()) .".". pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            Storage::disk('multimedia-informacion-departamento')->put( $portadaNombre , File::get($file));
            
            $imagen->ruta = "/multimedia/informacion-departamento/" . $portadaNombre;
            $imagen->user_create = "Admin";
            $imagen->user_update = "Admin";
            $imagen->estado = true;
            $imagen->save();
        }
        
        $informacion = Informacion_departamento::find($request->id);
        
        return ["success"=>true , "imagenes"=> $informacion->imagenes ];
    }
    
    public function postEliminarimagen(Request $request){
        $imagen = Inoformacion_departamento_imagenes::find($request->id);
        if($imagen){ 
            $filename = public_path() . $imagen->ruta;
           \File::delete($filename);
            $imagen->delete(); 
            return ["success"=>true];
        }
        return ["success"=>false];
    }
    
    
    function random_string() { 
        $length = 20;
        $key = ''; 
        $keys = array_merge(range(0, 9), range('a', 'z')); 
    
        for ($i = 0; $i < $length; $i++) { 
         $key .= $keys[array_rand($keys)]; 
        } 
    
        return $key; 
    } 
    
}
