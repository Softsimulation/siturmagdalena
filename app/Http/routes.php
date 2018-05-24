<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', function () {
    
    $date = new Carbon\Carbon('2018-04-02 00:00:00', 'Europe/London');  
    return  $date->diffInDays('2018-03-28 00:00:00');
    
    
});

Route::controller('/temporada','TemporadaController');
Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');

Route::get('/actividades', 'TurismoReceptorController@actividades');

Route::get('/CrearGrupoViaje', function () {
    return view('CrearGrupoViaje');
});
