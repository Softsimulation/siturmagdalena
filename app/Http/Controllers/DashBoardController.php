<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashBoardController extends Controller
{
    public function getIndex(){
        return view('DashBoard.DashBoard');
    }
}