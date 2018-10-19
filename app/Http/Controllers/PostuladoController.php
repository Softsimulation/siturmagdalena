<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Municipio;
use App\Models\Departamento;
use App\Models\User;
use App\Models\Datos_Adicional_Usuario;
use App\Models\Oferta_Vacante;
use App\Models\Postulaciones_Vacante;

class PostuladoController extends Controller
{
    
    public function __construct()
	{
	    $this->middleware('auth', ['only' => ['postPostular'] ]);
	    
	}
    
    public function getCrear($id = null){
        return view('postulado.crear',['id' => $id]);
    }
    
    public function getDatoscrear(){
        $departamentos = Departamento::where('pais_id',47)->select('id','nombre')->get();
        
        return ["departamentos" => $departamentos];
    }
    
    public function getMunicipios($id){
        $municipios = Municipio::where('departamento_id',$id)->select('id','nombre')->orderBy('nombre')->get();
        return $municipios;
    }
    
    public function postCrearpostulado(Request $request){
        $validator = \Validator::make($request->all(), [
			'nombres' => 'required|max:150',
			'apellidos' => 'required|max:150',
			'email' => 'required|email|max:455',
			'fecha_nacimiento' => 'required',
			'profesion' => 'required|max:455',
			'sexo' => 'required|boolean',
			'municipio_id' => 'required|exists:municipios,id',
			'password1' => 'required|max:255',
			'password2' => 'required|max:255',
    	],[
       		
    	]);
       
    	if($validator->fails()){
    		return ["success"=>false,"errores"=>$validator->errors()];
		}
		
		if($request->password1 != $request->password2){
		    return ["success"=>false,"errores"=> [["Las constraseñas no coinciden."]] ];
		}
		
		$user = User::where('email', $request->email)->first();
		if($user){
		    if(!\Hash::check($request->password1, $user->password)){
		        return ["success"=>false,"errores"=> [["La contraseña no coincide con el usuario."]] ];    
		    }
		}else{
		    $user = User::create([
    	        'nombre' => $request->nombres,
    	        'email' => $request->email,
    	        'password' => $request->password1,
    	        'username' => $request->email,
    	        'estado' => 1
    	    ]);    
		}
	    
	    $postulado = Datos_Adicional_Usuario::create([
	        'users_id' => $user->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => date('Y-m-d H:i',strtotime(str_replace("/","-",$request->fecha_nacimiento))),
            'sexo' => $request->sexo,
            'profesion' => $request->profesion,
            'municipio_id' => $request->municipio_id,
            'user_create' => 'admin',
            'user_update' => 'admin',
            'estado' => true
        ]);
        
        if(!\Auth::check()){
            \Auth::login($user);    
        }
		
		return ["success" => true];
    }
    
    public function getPostular($id){
        
        \Session::set('vacante', $id);
        if(!(\Auth::check())){
            return \Redirect::to('/login/login');
        }
        
        $user = \Auth::user();
        
        if(!Oferta_Vacante::find($id)){
            return \Redirect::to('/promocionBolsaEmpleo/vacantes')
                    ->with('message', 'La vacante a la que desea acceder no se encuentra registrada en el sistema.')
                    ->withInput();
        }else{
            $vacante = Oferta_Vacante::find($id);
            if($vacante->fecha_vencimiento < date('Y-m-d') && $vacante->fecha_nacimiento != null){
                return \Redirect::to('/promocionBolsaEmpleo/ver/'.$vacante->id)
                    ->with('message', "La vacante ya ha vencido.")
                    ->withInput();
            }
            if($user->datosAdicionales){
                if(Postulaciones_Vacante::where('ofertas_vacante_id',$vacante->id)->where('datos_usuario_id', $user->id)->first()){
                    return \Redirect::to('/promocionBolsaEmpleo/ver/'.$vacante->id)
                        ->with('message', "El usuario ya se ha postulado a esta vacante")
                        ->withInput();
                }
                return view('postulado.postular', ['vacante' => $vacante]); 
            }else{
                return view('postulado.crear', ['id' => $id]);
            }    
        }
    }
    
    public function postPostular(Request $request){
        
        $validator = \Validator::make($request->all(), [
			'archivo' => 'required|max:5000',
			'vacante_id' => 'required|exists:ofertas_vacantes,id'
        ],[
        	'archivo.required' => 'El archivo es requerido.',
        	'archivo.max' => 'El peso del archivo no debe superar los 5Mb.'
          ]
        );
        if($validator->fails()){
            
            return \Redirect::to('/postulado/postular/'.$request->vacante_id)
                        ->with('validaciones', $validator->errors())
                        ->withInput();
        }
        
        $user = \Auth::user();
        $vacante = Oferta_Vacante::find($request->vacante_id);
        
        if(isset($vacante->numero_maximo_postulaciones)){
            if( count($vacante->postulaciones) == $vacante->numero_maximo_postulaciones ){
                return \Redirect::to('/postulado/postular/'.$request->vacante_id)
                        ->with('message', "La vacante ya superó el número máximo de postulaciones.")
                        ->withInput();
            }    
        }
        
        
        if(Postulaciones_Vacante::where('ofertas_vacante_id',$request->vacante_id)->where('datos_usuario_id', $user->id)->first()){
            return \Redirect::to('/postulado/postular/'.$request->vacante_id)
                        ->with('message', "El usuario ya se ha postulado a esta vacante")
                        ->withInput();
        }else{
            $file = $request->archivo;
            \Storage::disk('HojasDeVida')->put( 'vacante_'.$vacante->id .'/'. 'usuario_'.$user->id.'_'.date('Y-m-d H:i').$file->getClientOriginalName() ,  \File::get($file) );
            
            Postulaciones_Vacante::create([
                'ofertas_vacante_id' => $request->vacante_id,
                'datos_usuario_id' => $user->id,
                'fecha_postulacion' => date('Y-m-d'),
                'ruta_hoja_vida' => '/HojasDeVida/vacante_'.$vacante->id.'/'.'usuario_'.$user->id.'_'.date('Y-m-d H:i').$file->getClientOriginalName(),
                'estado' => 1,
    	        'user_create' => $user->username,
        		'user_update' => $user->username
            ]);
            
            
            // mail($user->email,"Postulación vacante ".$vacante->nombre,"USted a realizado una postulación a la vacante cuyo nombre es: " . $vacante->nombre);
            
            // mail($vacante->proveedoresRnt->email,"Vacante: ".$vacante->nombre,"Se ha registrado un nuevo postulado en la vacante: ".$vacante->nombre);
            
            return \Redirect::to('/promocionBolsaEmpleo/ver/'.$request->vacante_id)
                        ->with('message', 'Se ha realizado la postulación correctamente.')
                        ->withInput();    
        }
    }
    
    
}
