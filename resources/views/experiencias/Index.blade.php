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

$tituloPagina = ($tipoItem) ? getItemType($tipoItem)->title : "Experiencias";

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

@section('Title', '¿Qué hacer en el departamento del Magdalena?')


@section('meta_og')
<meta property="og:title" content="{{$tituloPagina}}" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="{{$tituloPagina}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        
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
                grid-template-columns: repeat(2,  calc(50% - .5rem));
            }
        }
        @media only screen and (min-width: 1024px) {
            .tiles{
                grid-template-columns: repeat(3, calc(33.33% - .5rem));
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
            max-width: 270px;
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
    @if(isset($bg_path))
    <style>
        .header-list{
            background-image: url(/img/headers/{{$bg_path}});
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
        .nav-tabs {
            text-align: center;
            border-bottom: 0;
            position: sticky;
            top: 0;
            z-index: 10;
            padding: 1rem;
            padding-bottom: .5rem;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            width: 100%;
            background: white;
        }
        
        .nav-tabs>li {
            float: none;
            display: inline-block;
        }
        .nav-tabs>li>a {
            border-radius: 4px;
            box-shadow: 0px 1px 3px rgba(0,0,0,.35);
            background: white;
            border: 0;
        }
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
            background: dodgerblue;
            color: white;
            border: 0;
        }
        .mb-1{
            margin-bottom: .25rem;
        }
        .mb-2{
            margin-bottom: .5rem;
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
            <h2 class="title-section">{{$experiencia->tipoTurismoConIdiomas[0]->nombre}}</h2>
           
        </div>
        
    </div>
    
    <div class="container">
        <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#destinos" aria-controls="destinos" role="tab" data-toggle="tab" class="text-center mb-2">
                    <span class="mdi mdi-map-marker btn-block" aria-hidden="true"></span>
                    Destinos
                </a>
            </li>
            @if(count($atracciones) > 0)
            <li role="presentation">
                <a href="#atracciones" aria-controls="atracciones" role="tab" data-toggle="tab" class="text-center mb-2">
                    <span class="mdi mdi-beach btn-block" aria-hidden="true"></span>
                    Atracciones
                </a>
            </li>
            @endif
            @if(count($actividades) > 0)
            <li role="presentation">
                <a href="#actividades" aria-controls="actividades" role="tab" data-toggle="tab" class="text-center mb-2">
                    <span class="mdi mdi-run btn-block" aria-hidden="true"></span>
                    Actividades
                </a>
            </li>
            @endif
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="destinos">
                @if(count($destinos) > 0)
                <h3 class="text-center text-uppercase text-muted">Destinos para conocer</h3>
                <div class="tiles mb-3">
                    @foreach($destinos as $destino)
                    <div class="tile tile-overlap">
                        <div class="tile-img">
                            @if(count($destino->multimedia) > 0)
                                <img src="{{ $destino->multimedia->first()->ruta }}" alt="Imagen de presentación de {{ $destino->multimedia->first()->text_alternativo }}"/>
                            @else
                                <img src="/img/brand/72.png" alt="Imagen para {{$destino->langContent->first()->nombre}} no disponible"/>
                            @endif
                        </div>
                        <div class="tile-body">
                            <div class="tile-caption">
                                <h4><a href="/destinos/ver/{{$destino->id}}">{{$destino->langContent->first()->nombre}}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a class="btn btn-success text-uppercase" href="/quehacer/index?tipo=3">Ver más destinos de {{$experiencia->tipoTurismoConIdiomas->first()->nombre}}</a>
                </div>
                <br>
                @endif
            </div>
            <div role="tabpanel" class="tab-pane fade" id="atracciones">
                @if(count($atracciones) > 0)
                <h3 class="text-center text-uppercase text-muted">Atracciones que puedes visitar</h3>
                <div class="tiles mb-3">
                    @foreach($atracciones as $atraccion)
                    <div class="tile tile-overlap">
                        <div class="tile-img @if(is_null($atraccion->portada)) img-error @endif">
                        
                        @if(!is_null($atraccion->portada))
                            
                            <img src="{{$atraccion->portada->ruta}}" alt="{{$atraccion->portada->text_alternativo}}">
                        
                        @else
                            <img src="/img/brand/72.png" alt="Imagen para {{$atraccion->langContent->first()->nombre}} no disponible"/>
                    
                        @endif
                        </div>
                        <div class="tile-body">
                            <div class="tile-caption">
                                <h4><a href="/atracciones/ver/{{$atraccion->id}}">{{$atraccion->langContent->first()->nombre}}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a class="btn btn-success text-uppercase" href="/quehacer/index?tipo=2&experiencias%5B%5D={{$experiencia->id}}">Ver más atracciones de {{$experiencia->tipoTurismoConIdiomas->first()->nombre}}</a>
                </div>
                @endif
            </div>
            <div role="tabpanel" class="tab-pane fade" id="actividades">
                @if(count($actividades) > 0)
                <h3 class="text-center text-uppercase text-muted">Actividades que puedes realizar</h3>
                <div class="tiles mb-3">
                    @foreach($actividades as $actividad)
                    <div class="tile tile-overlap">
                        <div class="tile-img">
                            @if(count($actividad->multimedia) > 0)
                                <img src="{{ $actividad->multimedia->first()->ruta }}" alt="Imagen de presentación de {{ $actividad->multimedia->first()->text_alternativo }}"/>
                            @else
                                <img src="/img/brand/72.png" alt="Imagen para {{$actividad->langContent->first()->nombre}} no disponible"/>
                            @endif
                        </div>
                        <div class="tile-body">
                            <div class="tile-caption">
                                <h4><a href="/actividades/ver/{{$actividad->id}}">{{$actividad->langContent->first()->nombre}}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <a class="btn btn-success text-uppercase" href="/quehacer/index?tipo=1&experiencias%5B%5D={{$experiencia->id}}">Ver más actividades de {{$experiencia->tipoTurismoConIdiomas->first()->nombre}}</a>
                </div>
                @endif
            </div>
          </div>
        
        </div>
        
        
        
        
        
        
        <br/>
        <!--<div id="listado" class="tiles">-->
            
        <!--    <?php $hasTipo = 0 ?>-->
        <!--    @foreach($query as $entidad)-->
        <!--    @if(!$tipoItem || ($tipoItem && $entidad->tipo == $tipoItem))-->
        <!--    <?php $hasTipo = $hasTipo + 1 ?>-->
        <!--    <div class="tile tile-overlap">-->
        <!--        <div class="tile-img">-->
        <!--            @if($entidad->portada != "")-->
        <!--            <img src="{{ $entidad->portada }}" alt="Imagen de presentación de {{ $entidad->nombre }}"/>-->
        <!--            @endif-->
        <!--        </div>-->
        <!--        <div class="tile-body">-->
        <!--            <div class="tile-caption">-->
        <!--                <h3><a href="{{URL::action(getItemType($entidad->tipo)->controller.'@getVer', ['id' => $entidad->id])}}">{{ $entidad->nombre }}</a></h3>-->
        <!--                <span class="label {{$colorTipo[$entidad->tipo - 1]}}">{{getItemType($entidad->tipo)->name}}</span>-->
        <!--                @if($entidad->tipo == 4)-->
        <!--                <p class="label tile-date">Del {{date('d/m/Y', strtotime($entidad->fecha_inicio))}} al {{date('d/m/Y', strtotime($entidad->fecha_fin))}}</p>-->
        <!--                @endif-->
        <!--            </div>-->
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
        <!--            <div class="tile-buttons">-->
        <!--                <div class="inline-buttons">-->
        <!--                    <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 0.0) ? (($entidad->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">1</span></button>-->
        <!--                    <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 1.0) ? (($entidad->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">2</span></button>-->
        <!--                    <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 2.0) ? (($entidad->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">3</span></button>-->
        <!--                    <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 3.0) ? (($entidad->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">4</span></button>-->
        <!--                    <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 4.0) ? (($entidad->calificacion_legusto <= 4.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">5</span></button>-->
                            
        <!--                </div>-->
                        
                        
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    @endif-->
        <!--    @endforeach-->
            <!--<div class="tile tile-overlap">
        <!--        <div class="tile-img">-->
        <!--            <img src="http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg" alt=""/>-->
        <!--        </div>-->
        <!--        <div class="tile-body">-->
        <!--            <div class="tile-caption">-->
        <!--                <h3><a href="#">Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”</a></h3>    -->
        <!--            </div>-->
        <!--            <div class="tile-buttons">-->
        <!--                <div class="inline-buttons">-->
        <!--                    <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">1</span></button>-->
        <!--                    <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">2</span></button>-->
        <!--                    <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">3</span></button>-->
        <!--                    <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">4</span></button>-->
        <!--                    <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">5</span></button>-->
        <!--                </div>-->
        <!--                <button type="button" title="Añadir a favorito"><span class="mdi mdi-heart-outline" aria-hidden="true"></span><span class="sr-only">Añadir a favorito</span></button>-->
                        
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div> -->-->
            
        <!--</div>-->
        <!--@if(!$hasTipo)-->
        <!--    <div class="alert alert-info">-->
        <!--        <p>No hay registro que mostrar</p>-->
        <!--    </div>-->
        <!--@endif-->
    </div>

@endsection

@section('javascript')
<!--<script src="{{asset('/js/public/vibrant.js')}}"></script>-->
<!--<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>-->


<script src="{{asset('/js/experiencias/script.js')}}"></script>

