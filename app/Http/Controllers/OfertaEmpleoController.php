<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

class OfertaEmpleoController extends Controller
{
    //
    
    
    public function getCrearEncuesta(){
        return view('ofertaempleo.CrearEncuesta');
    }
    
    public function getEncuestaspendientes($id){
        
        $now = Carbon::now();
        
        return $now;

    }
    
    
}
