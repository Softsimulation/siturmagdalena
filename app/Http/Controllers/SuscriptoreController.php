<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Idioma;
use App\Models\User;
use App\Models\Suscriptore;


class SuscriptoreController extends Controller
{
    public function postGuardarsuscriptor(Request $request){
        //return $request->all();
        if(Suscriptore::where('email',$request->email)->first() != null){
            return ["success"=>false,"errores"=>[["Ya el correo se encuentra registrado."]]];
        }
        
        
        $suscriptor = new Suscriptore();
        $suscriptor->email = $request->emailSuscriptor;
        $suscriptor->created_at = Carbon::now();
        $suscriptor->updated_at = Carbon::now();
        $suscriptor->save();
        
        return [Suscriptore::all()];
    }
}