<?php
Route::get('datosmapa','HomeController@Datosmapa');
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::controller('/InformacionDepartamento','InformacionDepartamentoCtrl');


Route::get('/Mapa/getData', 'MapaCtrl@getData');
//Route::controller('/Mapa', 'MapaCtrl');

Route::controller('/indicadores','IndicadoresCtrl');

Route::controller('/EstadisticasSecundarias','EstadisticasSecundariasCtrl');

Route::controller('/temporada','TemporadaController');
Route::controller('/turismointerno','TurismoInternoController');

Route::controller('/turismoreceptor','TurismoReceptorController');

Route::controller('/grupoviaje','GrupoViajeController');
Route::controller('/exportacion','ExportacionController');

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

Route::controller('/MuestraMaestra','MuestraMaestraCtrl');


Route::get('/encuestaAdHoc/{encuesta}/registro', 'EncuestaDinamicaCtrl@getRegistrodeusuarios' );
Route::get('/encuestaAdHoc/{encuesta}', 'EncuestaDinamicaCtrl@encuesta' );
Route::get('/llenarEncuestaAdHoc/{idEncuesta}', 'EncuestaDinamicaCtrl@anonimos' );
Route::controller('/encuesta','EncuestaDinamicaCtrl');

Route::controller('/informes','InformesCtrl');

Route::controller('/calcularindicadores', 'IndicadorAdministradorController');
Route::controller('/bolsaEmpleo','BolsaEmpleoController');

Route::controller('/promocionBolsaEmpleo','PublicoBolsaEmpleoController');

Route::controller('/postulado','PostuladoController');

Route::controller('/controlSostenibilidadReceptor','ControlSostenibilidadController');

Route::controller('/usuario','UsuarioController');
Route::controller('/email','EmailController');
Route::controller('/login','LoginController');
Route::controller('/noticias','NoticiaController');
Route::controller('/sliders','SliderController');
Route::controller('/suscriptores','SuscriptoreController');

Route::controller('/periodoSostenibilidadPst','PeriodoSostenibilidadPstController');
Route::controller('/periodoSostenibilidadHogares','PeriodoSostenibilidadHogarController');

Route::controller('/DashBoard','DashBoardController');

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



Route::group(['middleware' => 'cors'], function(){
   
  
   Route::controller('/authapi', 'ApiAuthController');
   Route::group(['middleware'=> 'jwt.auth'], function () {
        Route::controller('/turismoreceptoroapi','TurismoReceptorCorsController');
        Route::controller('/grupoviajeapi','GrupoViajeCorsController');
   });
   
   Route::controller('/ofertayempleoapi','ApiOfertaEmpleoController');
   
});


Route::controller('/visitante', 'VisitanteController');

Route::group(['middleware' => ['web']], function () {

    Route::get('/lang/{lang}', function ($lang) {
        session(['lang' => $lang]);
        return \Redirect::back();
    })->where([
        'lang' => 'en|es'
    ]);
    Route::controller('/promocionNoticia','PublicoNoticiaController');
    Route::controller('/promocionInforme','PublicoInformeController');
    Route::controller('/promocionPublicacion','PublicoPublicacionController');
    Route::get('/PlanificaTuViaje','InformacionDepartamentoCtrl@PlanificaTuViaje');
    Route::get('/Departamento/AcercaDe','InformacionDepartamentoCtrl@AcercaDe');
    Route::get('/Departamento/Requisitos','InformacionDepartamentoCtrl@Requisitos');
    Route::get('/Mapa', 'MapaCtrl@getIndex');
    
    // Public Jáder
    Route::controller('/quehacer', 'QueHacerController');
    
    Route::controller('/experiencias', 'ExperienciasController');
    
    Route::controller('/atracciones', 'AtraccionesController');
    
    Route::controller('/actividades', 'ActividadesController');
    
    Route::controller('/destinos', 'DestinosController');
    
    Route::controller('/rutas', 'RutasTuristicasController');
    
    Route::controller('/eventos', 'EventosController');
    
    Route::controller('/proveedor', 'ProveedoresController');

    Route::controller('/quehacer', 'QueHacerController');
    
    Route::controller('/turismo', 'TurismoController');

    Route::controller('/','HomeController');
    
    
    
});

