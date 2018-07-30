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

Route::controller('/indicadores','IndicadoresCtrl');





Route::controller('/EstadistivasSecunarias','EstadisticasSecundariasCtrl');

Route::controller('/temporada','TemporadaController');
Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');

Route::controller('/sostenibilidadhogares','SostenibilidadHogaresController');

Route::get('/administradoratracciones/datos-idioma/{id}/{idIdioma}', 'AdministradorAtraccionController@getDatosIdioma');

Route::controller('/administradoratracciones', 'AdministradorAtraccionController');

Route::controller('/administradoractividades', 'AdministradorActividadesController');

Route::controller('/administradordestinos', 'AdministradorDestinosController');

Route::controller('/administrarmunicipios', 'AdministrarMunicipiosController');

Route::controller('/sostenibilidadpst', 'SostenibilidadPstController');

Route::controller('/importarRnt','ImportacionRntController');

Route::controller('/administradorproveedores', 'AdministradorProveedoresController');

Route::controller('/administrardepartamentos', 'AdministrarDepartamentosController');
Route::controller('/ofertaempleo','OfertaEmpleoController');

Route::get('/actividades', 'TurismoReceptorController@actividades');

Route::controller('/administrarpaises', 'AdministrarPaisesController');

Route::get('/CrearGrupoViaje', function () {
    return view('CrearGrupoViaje');
});

Route::get('/', function () {
    return view('home.index');
});


Route::controller('/MuestraMaestra','MuestraMaestraCtrl');


Route::get('/encuestaAdHoc/{encuesta}/registro', 'EncuestaDinamicaCtrl@getRegistrodeusuarios' );
Route::get('/encuestaAdHoc/{encuesta}', 'EncuestaDinamicaCtrl@encuesta' );
Route::controller('/encuesta','EncuestaDinamicaCtrl');

Route::controller('/usuario','UsuarioController');
Route::controller('/email','EmailController');
Route::controller('/login','LoginController');
Route::controller('/noticias','NoticiaController');