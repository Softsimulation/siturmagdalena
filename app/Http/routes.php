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

Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');

Route::controller('/administradoratracciones', 'AdministradorAtraccionController');

Route::controller('/administrardepartamentos', 'AdministrarDepartamentosController');

Route::get('/actividades', 'TurismoReceptorController@actividades');

Route::controller('/administrarpaises', 'AdministrarPaisesController');

Route::get('/CrearGrupoViaje', function () {
    return view('CrearGrupoViaje');
});

Route::get('/', function () {
    return view('welcome');
});
