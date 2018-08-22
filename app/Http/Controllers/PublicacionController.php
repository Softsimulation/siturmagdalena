<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Publicacion;
use App\Models\Pais;
use App\Models\Palabra;
use App\Models\Autor;
use App\Models\Tema;
use App\Models\Idioma;
use App\Models\Estado;
use App\Models\Publicacion_tema;
use App\Models\Publicacion_autor;
use App\Models\TipoPublicacion;
use Carbon\Carbon;


class PublicacionController extends Controller
{ 
    
    public function publicaciones() {
        return view('publicaciones.publicaciones');
	}
          
       public function CrearPublicacion() {
        return view('publicaciones.CrearPublicacion');
	}      
   public function EditarPublicacion($id) {
        return view('publicaciones.EditarPublicacion',array('id' => $id));
	}    
	  public function ListadoPublicacionesAdmin() {
        return view('publicaciones.publicaciones');
	}   
	
	 public function ListadoPublicaciones() {
        return view('publicaciones.Listadopublicaciones');
	}  
      
    public function getPublicacion() {
        
        $Tipos = TipoPublicacion::join("idiomas_has_tipos_publicaciones_obras","idiomas_has_tipos_publicaciones_obras.tipos_publicaciones_obras_id","=","tipos_publicaciones_obras.id")->where("idiomas_has_tipos_publicaciones_obras.idiomas_id","=",1)->select("idiomas_has_tipos_publicaciones_obras.nombre as nombre ","tipos_publicaciones_obras.id as id")->get();
    
        $Temas = Tema::join("idiomas_has_temas","idiomas_has_temas.temas_id","=","temas.id")->where("idiomas_has_temas.idiomas_id","=",1)->select("idiomas_has_temas.nombre as nombre ","temas.id as id")->get();
         
        $idiomas = Idioma::where("estado",true)->get();
         
        $paises = Pais::join("paises_con_idiomas","paises_con_idiomas.pais_id","=","paises.id")->where("paises_con_idiomas.idioma_id","=",1)->select("paises_con_idiomas.nombre as nombre ","paises.id as id")->get();
        
        $personas = Autor::get();
         
         return ["tipos"=>$Tipos,"temas"=>$Temas,"paises"=>$paises,"personas"=>$personas];
         
	}      
            
    public function getListado() {
        
        $estados = Estado::get();
         $publicaciones = Publicacion::with( ["tipopublicacion"=>function($qrr){$qrr->with(["idiomas" => function($qrrr){ $qrrr->where("idiomas_id",1); } ])  ;}, "estadoPublicacion" ])->get();
         return ["Publicaciones"=>$publicaciones,"estados"=>$estados];
         
	}
	
	    public function getListadoPublico() {
        $idioma = 1;
       
         $publicaciones = Publicacion::with( ["tipopublicacion"=>function($qrr){$qrr->with(["idiomas" => function($qrrr){ $qrrr->where("idiomas_id",1); } ])  ;},
         "temas" =>function($qrr2){$qrr2->with(["idiomas" => function($qrrr2){ $qrrr2->where("idiomas_id",1); } ])  ;},
         "palabras"
         ])->where("estado","=",true)->where("estados_id","=",1)->get();
         return ["Publicaciones"=>$publicaciones];
         
	}
	
	
	public function getPublicacionEdit( $id){
	    
	    $Tipos = TipoPublicacion::join("idiomas_has_tipos_publicaciones_obras","idiomas_has_tipos_publicaciones_obras.tipos_publicaciones_obras_id","=","tipos_publicaciones_obras.id")->where("idiomas_has_tipos_publicaciones_obras.idiomas_id","=",1)->select("idiomas_has_tipos_publicaciones_obras.nombre as nombre ","tipos_publicaciones_obras.id as id")->get();
    
        $Temas = Tema::join("idiomas_has_temas","idiomas_has_temas.temas_id","=","temas.id")->where("idiomas_has_temas.idiomas_id","=",1)->select("idiomas_has_temas.nombre as nombre ","temas.id as id")->get();
         
        $idiomas = Idioma::where("estado",true)->get();
         
        $paises = Pais::join("paises_con_idiomas","paises_con_idiomas.pais_id","=","paises.id")->where("paises_con_idiomas.idioma_id","=",1)->select("paises_con_idiomas.nombre as nombre ","paises.id as id")->get();
        
        $personas = Autor::get();
        
        $publicacion = Publicacion::with(["personas","temas","palabras"])->where("id","=",$id)->first();
        
        $publicacion->temasId =  $publicacion->temas->pluck("id");
    
    
         return ["tipos"=>$Tipos,"temas"=>$Temas,"paises"=>$paises,"personas"=>$personas,"publicacion" => $publicacion];
	    
	}

	public function cambiarEstadoPublicacion(Request $request){
	      
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:publicaciones_obras,id'
          
        ],[
 
            'id.required' => 'la publicacion es requerida.',
            'id.exists' => 'No existe publicación'
            ]
        );
	   if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	   $publicacion = Publicacion::where("id","=",$request->id)->first();

	   $publicacion->estado = !$publicacion->estado ;
	   $publicacion->save();
	   return [ "success"=>true];
	}

	public function EstadoPublicacion(Request $request){
	      
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:publicaciones_obras,id',
             'estados_id'=>"required|exists:estados,id"
        ],[
 
            'id.required' => 'la publicacion es requerida.',
            'id.exists' => 'No existe publicación',
            'estados_id.required' => 'el estado  es requerida.',
            'estados_id.exists' => 'No existe estado'
            ]
        );
	   if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	   $publicacion = Publicacion::where("id","=",$request->id)->first();

	   $publicacion->estados_id = $request->estados_id;
	   $publicacion->save();
	   $dato = Publicacion::with( ["tipopublicacion"=>function($qrr){$qrr->with(["idiomas" => function($qrrr){ $qrrr->where("idiomas_id",1); } ])  ;}, "estadoPublicacion" ])->where("id","=",$request->id)->first();
	   return [ "success"=>true,"publicacion"=>$dato];
	}
	
	
	public function eliminarPublicacion(Request $request){
	      
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:publicaciones_obras,id'
          
        ],[
 
            'id.required' => 'la publicacion es requerida.',
            'id.exists' => 'No existe publicación'
            ]
        );
	   if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	   $publicacion = Publicacion::where("id","=",$request->id)->first();
	   $publicacion->temas()->detach();
	   $publicacion->personas()->detach();
	   $publicacion->palabras()->detach();
       \File::delete(public_path() .  $publicacion->ruta);
       \File::delete(public_path() .  $publicacion->autorizacion);
       \File::delete(public_path() .  $publicacion->portada);
	   $publicacion->delete();
	   return [ "success"=>true];
	}


	public function guardarPublicacion(Request $request){
	    $dato = json_decode($request->personas);
	    $request->personas = $dato;
	    $dato2 = json_decode($request->palabrasClaves);
        $request->palabrasClaves = $dato2;
	   
	  
	   $validator = \Validator::make($request->all(), [
           
            'titulo' => 'required|string|min:1|max:255',
            'tipos_publicaciones_obras_id' => 'required|exists:tipos_publicaciones_obras,id',
            'personas.*.paisid' => 'exists:paises,id',
            'temas.*' => 'exists:temas,id',
            'personas'=>'required',
            'personas'=>'required',
            'palabrasClaves'=>'required',
            'temas'=>'required',
            'personas.*.nombre' => 'required|string|min:1|max:255',
            'personas.*.apellido' => 'required|string|min:1|max:255',
            'personas.*.email' => 'required|string|min:1|max:255',
            'soporte_carta'=>'required|mimes:pdf',
            'soporte_publicacion'=>'required|mimes:pdf',
            'portada'=>'required|mimes:jpg,jpeg,png'
          
        ],[
            'titulo.string' => 'El titulo debe ser de tipo string.',
            'titulo.min' => 'El titulo debe ser mínimo de 1 carácter.',
            'titulo.max' => 'El titulo debe ser maximo de 255 carácteres.',
            'tipos_publicaciones_id.required' => 'El tipo de publicacion es requerida.',
            'tipos_publicaciones_id.exists' => 'El tipo de publicacion debe existir.',
            'personas.*.paisid' => 'No existe pais.',
            'temas.*.exists' => 'No existe tema',
            'personas.*.nombre.string' => 'El nombre persona debe ser de tipo string.',
            'personas.*.nombre.min' => 'El nombre persona debe ser mínimo de 1 carácter.',
            'personas.*.nombre.max' => 'El nombre persona debe ser maximo de 255 carácteres.',
            'personas.*.apellido.string' => 'El apellido persona debe ser de tipo string.',
            'personas.*.apellido.min' => 'El apellido persona debe ser mínimo de 1 carácter.',
            'personas.*.apellido.max' => 'El apellido persona debe ser maximo de 255 carácteres.',
            ]
        );
	   if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	   $publicacion = new Publicacion();
	   $nombrecarta =  $publicacion->id.$request->titulo.$request->tipoid."-"."Carta".date("Ymd-H:i:s").".".$request->soporte_carta->getClientOriginalExtension();
	   \Storage::disk('Publicaciones')->put(str_replace(" ", "_", $nombrecarta),  \File::get($request->soporte_carta));
	   $nombrepubli=  $publicacion->id.$request->titulo.$request->tipoid."-"."Publicacion".date("Ymd-H:i:s").".".$request->soporte_publicacion->getClientOriginalExtension();
	   \Storage::disk('Publicaciones')->put(str_replace(" ", "_", $nombrepubli),  \File::get($request->soporte_publicacion));
	   $nombreportada=  $publicacion->id.$request->titulo.$request->tipoid."-"."Portada".date("Ymd-H:i:s").".".$request->portada->getClientOriginalExtension();
	   \Storage::disk('Publicaciones')->put(str_replace(" ", "_", $nombreportada),  \File::get($request->portada));
	   $publicacion->ruta =  "/public/"."Publicaciones".str_replace(" ", "_", $nombrepubli);
	   $publicacion->autorizacion = "/public/"."Publicaciones/".str_replace(" ", "_", $nombrecarta); 
	   $publicacion->portada = "/public/"."Publicaciones/".str_replace(" ", "_", $nombreportada);
	   $publicacion->titulo = $request->titulo;
	   $publicacion->resumen = $request->resumen;
	   $publicacion->descripcion = $request->descripcion;
	   $publicacion->tipos_publicaciones_obras_id = $request->tipos_publicaciones_obras_id;
	   $publicacion->estado = true;
	   $publicacion->estados_id = 3;
	   $publicacion->save();
	   
   
   
	   $publicacion->personas()->detach();
	   foreach($request->personas as $personar){
	       $persona = Autor::where("email","=",$personar->email)->first();
	       if($persona == null){
	           $persona = new Autor();
	           $persona->nombres = $personar->nombres;
               $persona->apellidos = $personar->apellidos;
               $persona->email = $personar->email;
               $persona->paises_id = $personar->paises_id;
               $persona->save();
	       }
	      $publicacion->personas()->attach($persona->id);
	       
	   }
	   
	   $publicacion->palabras()->detach();
	    foreach($request->palabrasClaves as $palabra){
	       $palabraClave = Palabra::where("nombre","=",$palabra->text)->first();
	       if($palabraClave == null){
	           $palabraClave = new Palabra();
	           $palabraClave->nombre =$palabra->text;
               $palabraClave->estado = true;
               $palabraClave->save();
	       }
	       
	      
	       $publicacion->palabras()->attach($palabraClave->id);
	   }

         $publicacion->temas()->detach();
	     $publicacion->temas()->attach($request->temas);
	 
	   

	   return [ "success"=>true];
        
	    
	}
	
	
	public function editPublicacion(Request $request){
	    
	    $dato = json_decode($request->personas);
	    $request->personas = $dato;
	    $dato2 = json_decode($request->palabrasClaves);
        $request->palabrasClaves = $dato2;
	   
	 
	   $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:publicaciones_obras,id',
            'titulo' => 'required|string|min:1|max:255',
            'tipos_publicaciones_obras_id' => 'required|exists:tipos_publicaciones_obras,id',
            'personas.*.paises_id' => 'exists:paises,id',
            'temasId.*' => 'required|exists:temas,id',
            'personas'=>'required',
            'palabrasClaves'=>'required',
            'personas.*.nombres' => 'required|string|min:1|max:255',
            'personas.*.apellidos' => 'required|string|min:1|max:255',
            'personas.*.email' => 'required|string|min:1|max:255',
            'soporte_carta'=>'mimes:pdf',
            'soporte_publicacion'=>'mimes:pdf',
            'portada'=>'mimes:jpg,jpeg,png'
          
        ],[
            'titulo.string' => 'El titulo debe ser de tipo string.',
            'titulo.min' => 'El titulo debe ser mínimo de 1 carácter.',
            'titulo.max' => 'El titulo debe ser maximo de 255 carácteres.',
            'tipos_publicaciones_id.required' => 'El tipo de publicacion es requerida.',
            'tipos_publicaciones_id.exists' => 'El tipo de publicacion debe existir.',
            'personas.*.paisid' => 'No existe pais.',
            'temas.*.exists' => 'No existe tema',
            'personas.*.nombre.string' => 'El nombre persona debe ser de tipo string.',
            'personas.*.nombre.min' => 'El nombre persona debe ser mínimo de 1 carácter.',
            'personas.*.nombre.max' => 'El nombre persona debe ser maximo de 255 carácteres.',
            'personas.*.apellido.string' => 'El apellido persona debe ser de tipo string.',
            'personas.*.apellido.min' => 'El apellido persona debe ser mínimo de 1 carácter.',
            'personas.*.apellido.max' => 'El apellido persona debe ser maximo de 255 carácteres.',
            ]
        );
	   if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
	   $publicacion = Publicacion::where("id","=",$request->id)->first();
	   if($request->soporte_carta != null){
	   \File::delete(public_path() .  $publicacion->autorizacion);
	   $nombrecarta =  $publicacion->id.$request->tipoid."-"."Carta".date("Ymd-H:i:s").".".$request->soporte_carta->getClientOriginalExtension();
	   $publicacion->autorizacion = $nombrecarta;
	   }
	   if($request->soporte_publicacion!= null){
	     \File::delete(public_path() .  $publicacion->ruta);
	   $nombrepubli=  $publicacion->id.$request->tipoid."-"."Publicacion".date("Ymd-H:i:s").".".$request->soporte_publicacion->getClientOriginalExtension();
	   $publicacion->ruta = $nombrepubli;
	   }
	   
	   if($request->portada!= null){
      \File::delete(public_path() .  $publicacion->portada);
	   $nombreportada=  $publicacion->id.$request->tipoid."-"."Portada".date("Ymd-H:i:s").".".$request->portada->getClientOriginalExtension();
	   $publicacion->portada = $nombreportada;
	   }
	   
	   
	   
	   $publicacion->titulo = $request->titulo;
	   $publicacion->resumen = $request->resumen;
	   $publicacion->descripcion = $request->descripcion;
	   $publicacion->tipos_publicaciones_obras_id = $request->tipos_publicaciones_obras_id;
	   $publicacion->estado = false;
	   $publicacion->save();
	  
	   $publicacion->temas()->detach();
	   $publicacion->personas()->detach();
	   $publicacion->palabras()->detach();
	  
	   foreach($request->personas as $personar){
	       $persona = Autor::where("email","=",$personar->email)->first();
	       if($persona == null){
	           $persona = new Autor();
	           $persona->nombres = $personar->nombres;
               $persona->apellidos = $personar->apellidos;
               $persona->email = $personar->email;
               $persona->paises_id = $personar->paises_id;
               $persona->save();
	       }
	      $publicacion->personas()->attach($persona->id);
	       
	   }
	   
	  
	    foreach($request->palabrasClaves as $palabra){
	       $palabraClave = Palabra::where("nombre","=",$palabra->nombre)->first();
	       if($palabraClave == null){
	           $palabraClave = new Palabra();
	           $palabraClave->nombre =$palabra->nombre;
               $palabraClave->estado = true;
               $palabraClave->save();
	       }
	       
	      
	       $publicacion->palabras()->attach($palabraClave->id);
	   }

	     $publicacion->temas()->attach($request->temasId);
	 
	   

	   return [ "success"=>true];
        
	    
	}
	
	
	
	
	

	

}