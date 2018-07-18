<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;

class LoginController extends Controller
{
    public function getLogin(){
        return view('Login');
    }
    public function postAutenticacion(Request $request){
        $user = User::where('email',$request->userName)->first();
        //return $user->password;
        if($user != null || \Hash::check($user->password, $request->password)){
            Auth::login($user);
            return redirect()->intended('usuario/listadousuarios'); 
            
        }else{
            return redirect()->intended('login/login')->with('message', 'Credenciales no validas');
        }
        
    }
}
