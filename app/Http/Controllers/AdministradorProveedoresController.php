<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdministradorProveedoresController extends Controller
{
    //
    
    public function getCrear(){
        return view('administradorproveedores.Crear');
    }
}
