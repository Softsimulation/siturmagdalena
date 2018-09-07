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





Route::controller('/EstadisticasSecundarias','EstadisticasSecundariasCtrl');

Route::controller('/temporada','TemporadaController');
Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');

Route::controller('/sostenibilidadhogares','SostenibilidadHogaresController');

Route::controller('/administradoratracciones', 'AdministradorAtraccionController');

Route::controller('/administradoractividades', 'AdministradorActividadesController');

Route::controller('/administradordestinos', 'AdministradorDestinosController');

Route::controller('/administrarmunicipios', 'AdministrarMunicipiosController');

Route::controller('/sostenibilidadpst', 'SostenibilidadPstController');

Route::controller('/importarRnt','ImportacionRntController');

Route::controller('/administradorproveedores', 'AdministradorProveedoresController');

Route::controller('/administradoreventos', 'AdministradorEventosController');

Route::controller('/administradorrutas', 'AdministradorRutasController');

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
Route::get('/llenarEncuestaAdHoc/{idEncuesta}', 'EncuestaDinamicaCtrl@anonimos' );
Route::controller('/encuesta','EncuestaDinamicaCtrl');

Route::controller('/informes','InformesCtrl');


Route::controller('/usuario','UsuarioController');
Route::controller('/email','EmailController');
Route::controller('/login','LoginController');
Route::controller('/noticias','NoticiaController');

Route::group(['prefix' => 'publicaciones','middleware'=>'auth'], function () {
    
    Route::get('/listadonuevas', 'PublicacionController@publicaciones');
    Route::get('/crear', 'PublicacionController@CrearPublicacion');
    Route::get('/editar/{id}', 'PublicacionController@EditarPublicacion');
    Route::get('/listado', 'PublicacionController@ListadoPublicaciones');
    Route::get('/listadoadmin', 'PublicacionController@ListadoPublicacionesAdmin');
    Route::get('/getPublicacion', 'PublicacionController@getPublicacion');
    Route::get('/getListadoPublico', 'PublicacionController@getListadoPublico');
    Route::get('/getListado', 'PublicacionController@getListado');
    Route::post('/guardarPublicacion', 'PublicacionController@guardarPublicacion' );
    Route::post('/editPublicacion', 'PublicacionController@editPublicacion' );
    Route::post('/eliminarPublicacion', 'PublicacionController@eliminarPublicacion' );
    Route::post('/cambiarEstadoPublicacion', 'PublicacionController@cambiarEstadoPublicacion' );
    Route::get('/getPublicacionEdit/{id}', 'PublicacionController@getPublicacionEdit');
    Route::post('/EstadoPublicacion', 'PublicacionController@EstadoPublicacion' );
    
});

