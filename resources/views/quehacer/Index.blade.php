<?php
/*
* Vista para listados del portal
*/
$colorTipo = ['label-primary','label-success','label-danger', 'label-info', 'label-warning'];

function getItemType($type){
    $path = ""; $name = ""; $title = "";
    switch($type){
        case(1):
            $title = "Actividades";
            $name = "Actividad";
            $path = "/actividades/ver/";
            $headerImg = "actividades.png";
            $controller = 'ActividadesController';
            break;
        case(2):
            $title = "Atracciones";
            $name = "Atracción";
            $path = "/atracciones/ver/";
            $headerImg = "atracciones.png";
            $controller = 'AtraccionesController';
            break;
        case(3):
            $title = "Destinos";
            $name = "Destino";
            $path = "/destinos/ver/";
            $headerImg = "destinos.png";
            $controller = 'DestinosController';
            break;
        case(4):
            $title = "Eventos";
            $name = "Evento";
            $path = "/eventos/ver/";
            $headerImg = "religioso.png";
            $controller = 'EventosController';
            break; 
        case(5):
            $title = "Rutas turísticas";
            $name = "Rutas turísticas";
            $path = "/rutas/ver/";
            $headerImg = "rutas.png";
            $controller = 'RutasTuristicasController';
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path, 'title' => $title, 'controller' => $controller, 'headerImg' => $headerImg);
}

$tipoItem = (isset($_GET['tipo'])) ? $_GET['tipo'] : 0 ;

$tituloPagina = ($tipoItem) ? getItemType($tipoItem)->title : "Qué hacer";

$countItems = false;

for($i = 0; $i < count($query); $i++){
    if($tipoItem && $query[$i]->tipo == $tipoItem){
        $countItems = true;
        break;
    }
}
$countItems = ($tipoItem) ? $countItems : count($query) > 0;
?>
@extends('layout._publicLayout')

@section('Title', '¿Qué hacer en el departamento del Cesar?')


@section('meta_og')
<meta property="og:title" content="{{$tituloPagina}}" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="{{$tituloPagina}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="{{asset('/css/slider/ion.rangeSlider.min.css')}}" rel="stylesheet">
    <style>
        .carga {
            display: none;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(http://situr-jader-jeffrj.c9users.io/Content/Cargando.gif) 50% 50% no-repeat;
            background-image: url(http://situr-jader-jeffrj.c9users.io/Content/Cargando.gif);
            background-position-x: 50%;
            background-position-y: 50%;
            background-size: initial;
            background-repeat-x: no-repeat;
            background-repeat-y: no-repeat;
            background-attachment: initial;
            background-origin: initial;
            background-clip: initial;
            background-color: rgba(0, 0, 0, 0.57);
        }
        #opciones{
            text-align:right;
            /*background-color: white;*/
            padding: 4px .5rem;
            margin-top: 1rem;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position:relative;
            z-index: 2;
            /*box-shadow: 0px -1px 5px -2px rgba(0,0,0,.3);*/
        }
        #opciones>button, #opciones form{
            display:inline-block;
            border: 0;
            margin: 0 2px;
        }
        #opciones button {
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);
            background-color: white;
            border-radius: 50%;
        }
        #opciones button:hover{
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.2);
        }
        .input-group .form-control{
            font-size: 1rem;
            height: auto;
        }
        .input-group .input-group-addon {
            padding: 0;
        }
        .input-group .input-group-addon .btn{
            border-radius: 2px;
            border: 0;
        }
        #collapseFilter{
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            min-width: 250px;
            max-width: 280px;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 1rem;
        }
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text .btn {
            border-radius: 0;
            border: 0;
        }
        
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
            padding: 0;
        }
        
        .card-header {
            padding: 2px .5rem;
        }
        .card-header .btn {
            padding: 0;
            color: #333;
            white-space: wrap;
        }
        .tile.tile-overlap .tile-img {
            background-image: url(/img/no-image.jpg);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .label {
            display: inline-block;
            padding: .2rem .5rem;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 2px;
            margin-bottom: 2px;
        }
        .tile-date {
            display:inline-block;
            background-color: #ddd;
            color: #333;
        }
        .tile.tile-overlap .tile-img img {
            font-size: 0.875rem;
            text-align: center;
            color: dimgrey;
        }
        .title-section{
            text-transform: uppercase;
            font-weight: 700;
            color: #004a87;
        }
    </style>
    <style>
        .tiles{
            display: grid;
            -ms-display: grid;
            grid-template-columns: 100%;
            grid-template-rows: auto;
            grid-column-gap: .875rem;
            grid-row-gap: .875rem;
        }
        .tiles:before{
            content: none;
        }
        .tiles .tile:not(.inline-tile){
            width: 100%;
            margin: 0;
        }
        .tiles.tile-list {
            grid-template-columns: 100%;
        }
        
        .tiles.tile-list .tile:not(.inline-tile) {
            width: 100%!important;
        }
        @media only screen and (min-width: 768px) {
            .tiles{
                grid-template-columns: repeat(2, 50%);
            }
        }
        @media only screen and (min-width: 1024px) {
            .tiles{
                grid-template-columns: repeat(3, 33.33%);
            }
        }
        label{
            font-weight: 400;
        }
        .filtros {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            background: white;
            padding: .5rem;
            height: 100%;
            width: 270px;
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.35);
            overflow: auto;
            display:none;
        }
        .filtros .panel-default>.panel-heading+.panel-collapse>.panel-body{
            max-height: 350px;
            overflow: auto;
        }
        .filtros .panel {
            border: 0;
        }
        .filtros .panel-group .panel+.panel {
            margin: 0;
            border-top: 1px solid #ddd;
        }
        .filtros .panel-default>.panel-heading {
            background-color: white;
            padding: 0;
        }
        .filtros .panel-title {
            font-size: 1rem;
            font-weight: 500;
        }
        .filtros .panel-title>a {
            padding: .5rem 0;
            display: block;
        }
        .filtros .panel-default>.panel-heading .panel-title>a[aria-expanded=true], .filtros .panel-default>.panel-heading .panel-title>a{
            position:relative;
        }
        .filtros .panel-default>.panel-heading .panel-title>a[aria-expanded=true]:before {
            content: "-";
        }
        .filtros .panel-default>.panel-heading .panel-title>a:before {
            content: "+";
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            font-size: 2rem;
            align-items: center;
            padding: 0 1rem;
            font-family: Open sans,sans-serif;
            font-weight: 700;
            color: #d3d3d3;
        }
        .filtros ::-webkit-scrollbar {
            width: 8px;
        }
         
        .filtros ::-webkit-scrollbar-track {
            /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); */
            background: #eee;
            border-radius: 10px;
        }
         
        .filtros ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); */
            background: rgba(0,0,0,0.15); 
        }
        .filtros ::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.35);
        }
        .filtros #btnClose{
            position:absolute;
            top: 1rem;
            right: 1rem;
            border: 0;
        }
    </style>
    @if(isset($_GET['tipo']))
    <style>
        .header-list{
            background-image: url(../../img/headers/<?php echo getItemType($_GET['tipo'])->headerImg ?>);
            background-size: cover;
            min-height: 200px;
            background-position: bottom;
            display: flex;
            align-items: flex-end;
            position:relative;
        }
        
        .header-list:after{
            content: "";
            position:absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            min-height: 70px;
            background-image: url(../../img/headers/banner_bottom.png);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: bottom;
            z-index: 1;
        }
        .header-list:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            z-index: 0;
            background: rgba(0,0,0,0.3);
            background: -moz-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,0,0,0.3)), color-stop(100%, rgba(246,41,12,0)));
            background: -webkit-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -o-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -ms-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: linear-gradient(to right, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#f6290c', GradientType=1 );
        }
        .header-list>.container{
            position:relative;
            z-index: 2;
        }
        .title-section{
            color: white;
            text-shadow: 0px 1px 3px rgba(0,0,0,.65);
            font-size: 2.125rem;
            background-color: rgba(0,0,0,.2);
            padding: .25rem .5rem;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
    @endif
@endsection

@section('content')
    <div class="header-list">
        <div class="container">
            @if(false)
            <ol class="breadcrumb">
              
              <li><a href="/quehacer">{{trans('resources.menu.queHacer')}}</a></li>
              <li class="active">{{$tituloPagina}}</li>
              
            </ol>
            @endif
            <h2 class="title-section">{{$tituloPagina}}</h2>
            
            <div id="opciones">
                <button type="button" id="btnFiltros" class="btn btn-default" title="Mostrar filtros" onclick="toggleFilter();"><span class="mdi mdi-filter"></span> <span class="d-none d-sm-inline-block sr-only">Mostrar filtros</span></button>
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">Vista de lista</span></button>
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">Vista de mosaico</span></button>
                <!--<form id="formSearch" method="POST" action="{{URL::action('QueHacerController@postSearch')}}" class="form-inline">-->
                <!--    {{ csrf_field() }}-->
                <!--    <div class="col-auto">-->
                <!--      <label class="sr-only" for="searchMain">Buscador general</label>-->
                <!--      <div class="input-group">-->
                <!--        <input type="text" class="form-control" name="searchMain" id="searchMain" placeholder="¿Qué desea buscar?" maxlength="255">-->
                <!--        <div class="input-group-prepend">-->
                <!--          <div class="input-group-text">-->
                <!--              <button type="submit" class="btn btn-default" title="Buscar"><span class="mdi mdi-magnify" aria-hidden="true"></span><span class="sr-only">Buscar</span></button>-->
                <!--          </div>-->
                <!--        </div>-->
                <!--      </div>-->
                <!--    </div>-->
                <!--</form>-->
                <!--<button type="button" class="btn btn-default"><span class="mdi mdi-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
            </div>
        </div>
        
    </div>
    
    <div class="container">
        <br/>
        <div class="filtros">
            <h4>Filtros</h4>
            <button id="btnClose" class="btn btn-xs btn-link" title="Cerrar filtros" onclick="toggleFilter();">&times;</button>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#destinos_panel" aria-expanded="true" aria-controls="destinos_panel">
                      Destinos
                    </a>
                  </h4>
                </div>
                <div id="destinos_panel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    @foreach($destinos as $destino)
                        <label>
                          <input onchange="change(this, destinos, {{$destino->id}})" type="checkbox"> {{$destino->destinoConIdiomas[0]->nombre}}
                        </label>
                        <br>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#experiencias" aria-expanded="false" aria-controls="experiencias">
                      Experiencias
                    </a>
                  </h4>
                </div>
                <div id="experiencias" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    @foreach($experiencias as $experiencia)
                        <label>
                          <input type="radio" onclick="exp = {{$experiencia->id}}" name="experiencia" value="{{$experiencia->id}}"> {{$experiencia->tipoTurismoConIdiomas[0]->nombre}}
                        </label>
                        <br>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#categorias_turismo" aria-expanded="false" aria-controls="categorias_turismo">
                      Categorías de turismo
                    </a>
                  </h4>
                </div>
                <div id="categorias_turismo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    @foreach($categorias as $categoria)
                        <label>
                          <input onchange="change(this, categorias, {{$categoria->id}})" type="checkbox"> {{$categoria->categoriaTurismoConIdiomas[0]->nombre}}
                        </label>
                        <br>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#perfiles_panel" aria-expanded="false" aria-controls="perfiles_panel">
                      Perfiles de turista
                    </a>
                  </h4>
                </div>
                <div id="perfiles_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    @foreach($perfiles as $perfil)
                        <label>
                          <input onchange="change(this, perfiles, {{$perfil->id}})" type="checkbox"> {{$perfil->perfilesUsuariosConIdiomas[0]->nombre}}
                        </label>
                        <br>
                    @endforeach
                  </div>
                </div>
              </div>
              <!--<div class="panel panel-default">-->
              <!--  <div class="panel-heading" role="tab" id="headingTwo">-->
              <!--    <h4 class="panel-title">-->
              <!--      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#perfiles" aria-expanded="false" aria-controls="perfiles">-->
              <!--        Tipos de atracción-->
              <!--      </a>-->
              <!--    </h4>-->
              <!--  </div>-->
              <!--  <div id="perfiles" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">-->
              <!--    <div class="panel-body">-->
              <!--      @foreach($perfiles as $perfil)-->
              <!--          <label>-->
              <!--            <input type="checkbox"> {{$perfil->perfilesUsuariosConIdiomas[0]->nombre}}-->
              <!--          </label>-->
              <!--          <br>-->
              <!--      @endforeach-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p>Rango de precios</p>
                </div>
                <div class="col-xs-12">
                    <input id="demo" type="text" class="js-range-slider" name="my_range" value="" />
                </div>
            </div>
            <br>
            <div class="btn-group" role="group" aria-label="...">
                <button onclick="formSubmit()" type="button" class="btn btn-success">Filtrar</button>
                <button onclick="clearFilters()" type="button" class="btn btn-danger">Limpiar</button>
            </div>
        </div>
        <div id="listado" class="tiles">
            
            <?php $hasTipo = 0 ?>
            @foreach($query as $entidad)
            @if(!$tipoItem || ($tipoItem && $entidad->tipo == $tipoItem))
            <?php $hasTipo = $hasTipo + 1 ?>
            <div class="tile tile-overlap">
                <div class="tile-img">
                    @if($entidad->portada != "")
                    <img src="{{ $entidad->portada }}" alt="Imagen de presentación de {{ $entidad->nombre }}"/>
                    @endif
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="{{URL::action(getItemType($entidad->tipo)->controller.'@getVer', ['id' => $entidad->id])}}">{{ $entidad->nombre }}</a></h3>
                        @if(!isset($_GET['tipo']))
                        <span class="label {{$colorTipo[$entidad->tipo - 1]}}">{{getItemType($entidad->tipo)->name}}</span>
                        @endif
                        @if($entidad->tipo == 4)
                        <p class="label tile-date">Del {{date('d/m/Y', strtotime($entidad->fecha_inicio))}} al {{date('d/m/Y', strtotime($entidad->fecha_fin))}}</p>
                        @endif
                    </div>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 0.0) ? (($entidad->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 1.0) ? (($entidad->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 2.0) ? (($entidad->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 3.0) ? (($entidad->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 4.0) ? (($entidad->calificacion_legusto <= 4.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">5</span></button>
                            
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            <!--<div class="tile tile-overlap">
                <div class="tile-img">
                    <img src="http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg" alt=""/>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="#">Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”</a></h3>    
                    </div>
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">5</span></button>
                        </div>
                        <button type="button" title="Añadir a favorito"><span class="mdi mdi-heart-outline" aria-hidden="true"></span><span class="sr-only">Añadir a favorito</span></button>
                        
                    </div>
                </div>
            </div> -->
            
        </div>
        {!! $query->render() !!}
        @if(!$hasTipo)
            <div class="alert alert-info">
                <p>No hay registro que mostrar</p>
            </div>
        @endif
    </div>
    <div class="carga"></div>

@endsection

@section('javascript')
<!--<script src="{{asset('/js/public/vibrant.js')}}"></script>-->
<!--<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>-->

<script>

var colorTipo = ['bg-primary','bg-success','bg-danger', 'bg-info', 'bg-warning'];

function getItemType(type){
    switch(type){
        case(1):
            title = "Actividades";
            name = "Actividad";
            path = "/actividades/ver/";
            controller = 'ActividadesController';
            break;
        case(2):
            title = "Atracciones";
            name = "Atracción";
            path = "/atracciones/ver/";
            controller = 'AtraccionesController';
            break;
        case(3):
            title = "Destinos";
            name = "Destino";
            path = "/destinos/ver/";
            controller = 'DestinosController';
            break;
        case(4):
            title = "Eventos";
            name = "Evento";
            path = "/eventos/ver/";
            controller = 'EventosController';
            break; 
        case(5):
            title = "Proveedores";
            name = "Proveedores";
            path = "/proveedor/ver/";
            controller = 'ProveedorController';
            break;
    }
    return {'name':name, 'path':path, 'title' : title, 'controller' : controller};
}
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function toggleFilter(){
    $('.filtros').toggle("fast","linear");
}
window.addEventListener('click', function(e){
	
	if (!document.getElementsByClassName('filtros')[0].contains(e.target) && !document.getElementById('btnFiltros').contains(e.target)){
      	$('.filtros').fadeOut("fast","linear");
    }
})
var tipoItem = getParameterByName('tipo') != undefined ? getParameterByName('tipo') : 0 ;
    function changeViewList(obj, idList, view){
        var element, name, arr;
        $('#'+idList).fadeOut("slow");
        element = document.getElementById(idList);
        
        
        setTimeout(function(){
            name = view;
            element.className = "tiles " + name;
            $('#'+idList).fadeIn("slow");
        },350);
        
    }
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = '{{URL::action("QueHacerController@postFiltrar")}}';
    var resetUrl = '{{URL::action("QueHacerController@getReset")}}';
    
    $('#formSearch').submit(function(){
        $.ajax({
          type: "POST",
          url: '{{URL::action("QueHacerController@postSearch")}}',
          data: {
              'search': $('#searchMain').val()
          },
          success: function (data){
              if (!data.success){
                  alert('No hay resultados para su búsqueda');
              }
              var html = '';
              for(var i = 0; i < data.query.length; i++){
                if(!tipoItem || (tipoItem && data.query[i].tipo == tipoItem)){
                    html += '<div class="tile tile-overlap">'
                                +'<div class="tile-img">';
                        if(data.query[i].portada != ""){
                            html += '<img src="'+data.query[i].portada +'" alt="Imagen de presentación de '+ data.query[i].nombre +'"/>';
                        }
                    html +=     +'</div>'
                                    +'<div class="tile-body">'
                                        +'<div class="tile-caption">'
                                            +'<h3><a href="'+getItemType(data.query[i].tipo).path+data.query[i].id +'">'+ data.query[i].nombre +'</a></h3>'
                                            +'<span class="label '+colorTipo[data.query[i].tipo - 1]+'">'+getItemType(data.query[i].tipo).name+'</span>'
                                        +'</div>'
                                        +'<div class="tile-buttons">'
                                            +'<div class="inline-buttons">';
                    //Acá falta las fechas en los eventos
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 0.0) ? ((data.query[i].calificacion_legusto <= 0.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 1.0) ? ((data.query[i].calificacion_legusto <= 1.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 2.0) ? ((data.query[i].calificacion_legusto <= 2.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 3.0) ? ((data.query[i].calificacion_legusto <= 3.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>'; 
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 4.0) ? ((data.query[i].calificacion_legusto <= 4.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button></div></div></div></div></div>';
              }
              }
              $('#listado').html(html);
          },
          dataType: 'json'
        });
        return false;
    });
        
</script>
<script src="{{asset('/js/plugins/slider/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('/js/quehacer/script.js')}}"></script>
@endsection