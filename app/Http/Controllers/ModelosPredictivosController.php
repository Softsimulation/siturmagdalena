<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class ModelosPredictivosController extends Controller
{
    
    public function getIndex(){


        return view('modelospredictivos.index');


    }

}
