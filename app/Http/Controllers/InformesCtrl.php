<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;
use File;
use App\Models\Categoria_Documento;
use App\Models\Tipo_Documento;
use App\Models\Publicacione;
use App\Models\Publicaciones_idioma;
use App\Models\Idioma;
use App\Models\Suscriptore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class InformesCtrl extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        
        //$this->middleware('role:Admin');
        $this->middleware('permissions:list-informe|create-informe|read-informe|edit-informe|estado-informe|delete-informe',['only' => ['getConfiguracion','getDataconfiguracion'] ]);
        $this->middleware('permissions:create-informe|edit-informe',['only' => ['postGuardaridioama'] ]);
        $this->middleware('permissions:create-informe',['only' => ['postCrear'] ]);
        $this->middleware('permissions:edit-informe',['only' => ['postEditar','postEliminaridioma'] ]);
        $this->middleware('permissions:estado-informe',['only' => ['postCambiarestado'] ]);
        if(Auth::user() != null){
            $this->user = User::where('id',Auth::user()->id)->first(); 
        }
        
    }
    
    function getConfiguracion(){
        return View("informes.configuracion");
    }
    
    
    function getDataconfiguracion(Request $request){
        //publicaciones_idioma::where("publicaciones_id",">",1)->delete();
        //Publicacione::where("estado",true)->delete();
        return [
               "informes"=> Publicacione::with([ "idiomas"=>function($q){ $q->with('idioma'); }, 
                                                 "tipo"=>function($q){ $q->with([ "tipoDocumentoIdiomas"=>function($qq){ $qq->where("idioma_id",1); } ]); }, 
                                                 "categoria"=>function($q){ $q->with([ "categoriaDocumentoIdiomas"=>function($qq){ $qq->where("idioma_id",1); } ]); } 
                                                ])->orderBy('id')->get(),
               "tipos"=> Tipo_Documento::where("estado",true)->with([ "tipoDocumentoIdiomas"=>function($q){ $q->where("idioma_id",1); } ])->get(),
               "categorias"=> Categoria_Documento::where("estado",true)->with([ "categoriaDocumentoIdiomas"=>function($q){ $q->where("idioma_id",1); } ])->get(),
               "idiomas"=> Idioma::get()
            ];
       
    }
    
    public function postCambiarestado(Request $request){
        
        $informe = Publicacione::find($request->id);
        
        if($informe){
            $informe->estado = !$informe->estado;
            $informe->save();
            return [ "success"=>true, "estado"=>$informe->estado ];
        }
        return [ "success"=>false, "error"=>"Informe no existe en el sistema." ];
    }
    
    
    public function postCrear(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'Titulo' => 'required|max:500',
			'Descripcion' => 'required|max:1000',
			'PalabrasClaves' => 'required|max:1000',
			'Autor' => 'required|max:250',
			'Volumen' => 'required|max:250',
			'Categoria' => 'required|exists:categoria_documento,id',
			'Tipo' => 'required|exists:tipo_documento,id',
			'FechaCreacion' => 'required|date',
			'FechaPublicacion' => 'required|date',
			'Archivo' => 'required|mimes:pdf',
			'Portada' => 'required|image',
    	]);
       
    	if($validator->fails()){ dd($validator->errors());
    		return redirect('informes/configuracion')->with([ "post"=>true, "success"=>false, "mensaje"=> "Error al intentar guardar, por favor vuelva a intentarlo." ]);
		}
        
        $informe = new Publicacione();
        $informe->autores = $request->Autor;
        $informe->volumen = $request->Volumen;
        $informe->categoria_doucmento_id= $request->Categoria;
        $informe->tipo_documento_id = $request->Tipo;
        $informe->fecha_creacion = $request->FechaCreacion;
        $informe->fecha_publicacion = $request->FechaPublicacion;
        
        $informe->portada = "";
        $informe->ruta = "";
        $informe->estado = true;
        $informe->user_create = "Admin";
        $informe->user_update = "Admin";
        $informe->save();
        
        $documentoNombre = "archivo.pdf";
        Storage::disk('multimedia-informes')->put('informe-'.$informe->id.'/'.$documentoNombre, File::get($request->Archivo) );
        
        $portadaNombre = "portada.".pathinfo($request->Portada->getClientOriginalName(), PATHINFO_EXTENSION);
        Storage::disk('multimedia-informes')->put('informe-'.$informe->id.'/'.$portadaNombre, File::get($request->Portada));
        
        $informe->portada = "/multimedia/informes/informe-".$informe->id."/".$portadaNombre;
        $informe->ruta = "/multimedia/informes/informe-".$informe->id."/".$documentoNombre;
        $informe->save();
        
        $pubId = new publicaciones_idioma();
        $pubId->nombre = $request->Titulo;
        $pubId->descripcion = $request->Descripcion;
        $pubId->palabrasclaves = $request->PalabrasClaves;
        $pubId->publicaciones_id = $informe->id;
        $pubId->idioma_id = 1;
        $pubId->save();
        
        $suscriptores = Suscriptore::all();
        foreach($suscriptores as $suscriptor){
            if($suscriptor != null){
                $fecha_actual = Carbon::now();
                $data = [];
                $data["email"] = $suscriptor->email;
                $data["nombre"] = $pubId->nombre;
                $data["noticia"] = false;
                $data["informe"] = true;
                $data["publicacion"] = false;
                $data["ruta"] = $informe->ruta;
                try{
                    \Mail::send('Email.Publicaciones', $data, function($message) use ($suscriptor){
                   //remitente
                   $message->from(env('CONTACT_MAIL'), env('CONTACT_NAME'));
         
                   //asunto
                   $message->subject("Nuevo informe – SITUR Magdalena.");
         
                   //receptor
                   $message->to($suscriptor->email, $suscriptor->email);
                    });
                }catch(\Exception $e){
                    // Never reached
                    //return $e;
                }
                
            }
        }
        
        return redirect('informes/configuracion')->with([ "post"=>true, "success"=>true, "mensaje"=> "La creación de la publicación se ha realizado exitosamente." ]);
        
    }
    
    public function postEditar(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:publicaciones,id',
			'autores' => 'required|max:250',
			'volumen' => 'required|max:250',
			'Categoria' => 'required|exists:categoria_documento,id',
			'Tipo' => 'required|exists:tipo_documento,id',
			'fechaCreacion' => 'required|date',
			'fechaPublicacion' => 'required|date',
			'Archivo' => 'mimes:pdf',
			'Portada' => 'image',
    	]);
       
    	if($validator->fails()){
    		return redirect('informes/configuracion')->with([ "post"=>true, "success"=>false, "mensaje"=> "Error al intentar guardar, por favor vuelva a intentarlo." ]);
		}
        
        $informe = Publicacione::find($request->id);
        $informe->autores = $request->autores;
        $informe->volumen = $request->volumen;
        $informe->categoria_doucmento_id= $request->Categoria;
        $informe->tipo_documento_id = $request->Tipo;
        $informe->fecha_creacion = $request->fechaCreacion;
        $informe->fecha_publicacion = $request->fechaPublicacion;
        
        $informe->user_update = "Admin";
        
        if($request->Archivo){
            $documentoNombre = "archivo.pdf";
            Storage::disk('multimedia-informes')->put('informe-'.$informe->id.'/'.$documentoNombre, File::get($request->Archivo) );
            $informe->ruta = "/multimedia/informes/informe-".$informe->id."/".$documentoNombre;
        }
        
        if($request->Portada){
            $portadaNombre = "portada.".pathinfo($request->Portada->getClientOriginalName(), PATHINFO_EXTENSION);
            Storage::disk('multimedia-informes')->put('informe-'.$informe->id.'/'.$portadaNombre, File::get($request->Portada));
            $informe->portada = "/multimedia/informes/informe-".$informe->id."/".$portadaNombre;
        }
        
        $informe->save();
        
        
        return redirect('informes/configuracion')->with([ "post"=>true, "success"=>true, "mensaje"=> "La edición de la publicación se ha realizado exitosamente." ]);
        
    }
    
    
    public function postGuardaridioama(Request $request){ 
        
        $validator = \Validator::make($request->all(), [
            'publicaciones_id' => 'required|exists:publicaciones,id',
            'idioma_id' => 'required|exists:idiomas,id',
			'nombre' => 'required|max:5000',
			'descripcion' => 'required|max:1000',
			'palabrasclaves' => 'required|max:1000',
    	]);
       
    	if($validator->fails()){
            return ["success"=>false,'errores'=>$validator->errors()];
        }
        
        $pubId = publicaciones_idioma::where([ ["publicaciones_id",$request->publicaciones_id], ["idioma_id",$request->idioma_id] ])->first();
        
        if($pubId==null){
            $pubId = new publicaciones_idioma();
            $pubId->publicaciones_id = $request->publicaciones_id;
            $pubId->idioma_id = $request->idioma_id;
        }
        
        $pubId->nombre = $request->nombre;
        $pubId->descripcion = $request->descripcion;
        $pubId->palabrasclaves = $request->palabrasclaves; 
        $pubId->save();
        
        $pubId["idioma"] = Idioma::find($pubId->idioma_id);
        
        return [ "success"=>true, "idioma"=>$pubId ];
    }
    
    
    public function postEliminaridioma(Request $request){
        
        $r = publicaciones_idioma::where([ ["publicaciones_id",$request->publicaciones_id], ["idioma_id",$request->idioma_id] ])->delete();
        
        if($r){
            return [ "success"=>true ];
        }
        return [ "success"=>true, "error"=>"Error al intentar eliminar idioma, por favor intentelo de nuevo." ];
    }
    
    
}
