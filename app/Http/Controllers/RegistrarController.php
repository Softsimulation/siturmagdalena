<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Socialite;


class RegistrarController extends Controller
{
     
    public function postRegistrarusuario(Request $request) {
        $validator = \Validator::make($request->all(), [
            'nombres' => 'string|min:1|max:255|required',
            'email' => 'required',
            'password1' => 'required',
            'password2' =>'required',
            
        ],[
            'nombres.string' => 'El nombre debe ser de tipo string.',
            'nombres.min' => 'El nombre debe ser mínimo de 1 caracter.',
            'nombres.max' => 'El nombre debe ser maximo de 255 caracteres.',
            'nombres.required' => 'El nombre es requerido.',
            'email.required' => 'El email es requerido.',
            'password1.required' => 'La contraseña es requerida.',
            'password2.required' => 'La confirmación de la contraseña es requerida.',
            ]
        );
        
        if($validator->fails()){
            return ["success"=>false,"errores"=>$validator->errors()];
        }
        $errores = [];
        if(User::where('email',$request->email)->count() > 0){ 
            $errores["Email"][0] = "El email ingresado ya se encuentra registrado en el sistema";
        }
        if($request->password1 != $request->password2){ 
            $errores["password"][0] = "Las contraseñas no coinciden";
        }
        
        if(sizeof($errores) > 0){
            return view('publico.situr.registrar',array('errores' => $errores,'mensajeExito'=>null));
        }
        
        $user = new User();
        $user->username = $request->email;
        $user->nombre = $request->nombres;
        $user->password = $request->password1;
        $user->email = $request->email;
        $user->estado = 1;
        $user->save();
        
        return view('publico.situr.registrar',array('errores' => null,'mensajeExito'=>"Registro guardado satisfactoriamente"));
	}
	public function getAutenticacion($provider){
	    return Socialite::driver($provider)->redirect();
	    //return $id;
	}
	
	public function getHandleprovidercallback($provider)
    {
        
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->user(); 
        //dd($social_user);
        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) { 
            return $this->authAndRedirect($user); // Login y redirección
        } else {  
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = User::create([
                'nombre' => $social_user->name,
                'email' => $social_user->email,
                'username' => $social_user->email,
                'estado' => 1,
            ]);


            return $this->authAndRedirect($user); // Login y redirección
        }
    }
    
    public function authAndRedirect($user)
    {
        Auth::login($user);

        return redirect()->to('/');
    }
}