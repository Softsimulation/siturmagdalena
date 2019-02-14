<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function postLogin(Request $request){
        $credenciales = $request->only('username','password');
        $token=null;
        
        try{
            if(!$token=JWTAuth::attempt($credenciales))
            {
                return response(['mensaje' => 'Contraseña o Usuario Invalidos'],401);
            }
        }catch(JWTException $ex){
            return response(['mensaje' => 'Error interno del servidor'],500);
        }
        $user = JWTAuth::toUser($token);

        return response()->json(compact('token', 'user'));
    }
}
