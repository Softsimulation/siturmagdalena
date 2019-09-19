<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;
use File;
use Illuminate\Support\Facades\DB;
use App\Models\Informacion_departamento;
use App\Models\Inoformacion_departamento_imagenes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class InformacionDepartamentoCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['AcercaDe','Requisitos', 'PlanificaTuViaje','LugaresSugeridos'] ]);
        //$this->middleware('permissions:acerca-departamento|requisitos-viaje',['except' => ['AcercaDe','Requisitos', 'PlanificaTuViaje'] ]);
        
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
     public function LugaresSugeridos(){
             $idIdioma = \Config::get('app.locale') == 'es' ? 1 : 2;
        
        $query = DB::select("(SELECT actividades.id AS id,  
                 actividades.calificacion_legusto AS calificacion_legusto, 
                 1 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 actividades_con_idiomas.nombre AS nombre,
                 multimedias_actividades.ruta AS portada 
             FROM actividades INNER JOIN actividades_con_idiomas ON actividades_con_idiomas.actividades_id = actividades.id AND actividades_con_idiomas.idiomas = ?
                 INNER JOIN multimedias_actividades ON actividades.id = multimedias_actividades.actividades_id AND multimedias_actividades.portada = true 
             WHERE actividades.estado = true AND actividades.sugerido = true) UNION 
             (SELECT atracciones.id AS id,  
                 atracciones.calificacion_legusto AS calificacion_legusto, 
                 2 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 sitios_con_idiomas.nombre AS nombre,
                 multimedia_sitios.ruta AS portada 
             FROM atracciones INNER JOIN sitios ON sitios.id = atracciones.sitios_id 
                 INNER JOIN sitios_con_idiomas ON sitios.id = sitios_con_idiomas.sitios_id AND sitios_con_idiomas.idiomas_id = ?
                 INNER JOIN multimedia_sitios ON sitios.id = multimedia_sitios.sitios_id AND multimedia_sitios.portada = true 
             WHERE atracciones.estado = true AND atracciones.sugerido = true) UNION 
             (SELECT destino.id AS id,  
                 destino.calificacion_legusto AS calificacion_legusto, 
                 3 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 destino_con_idiomas.nombre AS nombre, 
                 multimedia_destino.ruta AS portada 
             FROM destino INNER JOIN destino_con_idiomas ON destino.id = destino_con_idiomas.destino_id AND destino_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_destino ON destino.id = multimedia_destino.destino_id AND multimedia_destino.portada = true 
             WHERE destino.estado = true AND destino.sugerido = true) UNION 
             (SELECT eventos.id AS id,  
                 null AS calificacion_legusto, 
                 4 AS tipo, 
                 eventos.fecha_in AS fecha_inicio, 
                 eventos.fecha_fin AS fecha_fin, 
                 eventos_con_idiomas.nombre AS nombre,
                 multimedia_evento.ruta AS portada 
             FROM eventos INNER JOIN eventos_con_idiomas ON eventos.id = eventos_con_idiomas.eventos_id AND eventos_con_idiomas.idiomas_id = ? 
                 INNER JOIN multimedia_evento ON eventos.id = multimedia_evento.eventos_id AND multimedia_evento.portada = true 
             WHERE eventos.estado = true AND eventos.sugerido = true) UNION 
             (SELECT rutas.id AS id,  
                 null AS calificacion_legusto, 
                 5 AS tipo, 
                 NOW() AS fecha_inicio, 
                 NOW() AS fecha_fin, 
                 rutas_con_idiomas.nombre AS nombre,
                 rutas.portada AS portada 
             FROM rutas INNER JOIN rutas_con_idiomas ON rutas.id = rutas_con_idiomas.ruta_id AND rutas_con_idiomas.idioma_id = ?  
             WHERE rutas.estado = true AND rutas.sugerido = true) ORDER BY tipo LIMIT 3", [$idIdioma, $idIdioma, $idIdioma, $idIdioma, $idIdioma]);
        
     
        return View("informacionDepartamento.sugeridos",['sugeridos' => $query  ]);
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
