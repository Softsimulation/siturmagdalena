<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;
use App\Models\Role;
use App\Models\Role_User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getLogin(){
        return view('Login');
    }
    public function postAutenticacion(Request $request){
        if($request->userName == null || $request->password == null || $request->userName == '' || $request->password == '' ){
            return redirect()->intended('login/login')->with('message', 'Credenciales no validas');
        }
        $user = User::where('email',$request->userName)->first();
        //return $user->password;
        if(\Hash::check($request->password,$user->password)){
            if($user != null){
                Auth::login($user);
                return redirect()->intended('usuario/listadousuarios');    
            }
             
            
        }else{
            return redirect()->intended('login/login')->with('message', 'Credenciales no validas');
        }
        
    }
    public function getCerrarsesion(){
        Auth::logout();
        return redirect()->intended('/login/login');
    
    }
}