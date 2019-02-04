<?php
header("Access-Control-Allow-Origin: *");

function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

function getItemType($type){
    $path = ""; $name = "";
    switch($type){
        case(1):
            $name = trans('resources.entidad.actividades');
            $path = "/actividades/ver/";
            break;
        case(2):
            $name = trans('resources.entidad.atracciones');
            $path = "/atracciones/ver/";
            break;
        case(3):
            $name = trans('resources.entidad.destinos');
            $path = "/destinos/ver/";
            break;
        case(4):
            $name = trans('resources.entidad.eventos');
            $path = "/eventos/ver/";
            break; 
        case(5):
            $name = trans('resources.entidad.rutasTuristicas');
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path);
}

$tituloPagina = "Proveedores";

$colorTipo = ['primary','success','danger', 'info', 'warning'];


?>
@extends('layout._publicLayout')

@section('Title', '¿Qué hacer?')

@section('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    
    <style>
        .tile .tile-caption h3 {
            margin: 0;
            font-size: 1rem;
            text-transform: uppercase;
            font-weight: 700;
        }
        .ionicons-inline {
            font-size: 1.5rem;
        }
        .tile .tile-img .text-overlap {
            font-family: Roboto, sans-serif;
        }
        .tile-date {
            font-size: 0.875rem;
            font-family: Roboto, sans-serif;
            color: #757575;
        }
        .nav-bar > .brand a img{
            width: auto;
            height: 72px;
        }
        #opciones{
            text-align:right;
        }
        #opciones button, #opciones form{
            display:inline-block;
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
            max-width: 220px;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 60;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
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
    
@endsection

@section('TitleSection','Actividades')

@section('meta_og')
<meta property="og:title" content="que hacer" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="¿Qué hacer?"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection

@section('content')
<div class="header-list">
    <div class="container">
        @if(isset($_GET['tipo']))
        <ol class="breadcrumb">
          
          <li><a href="/quehacer">{{trans('resources.menu.servicios')}}</a></li>
          <li class="active">{{$tituloPagina}}</li>
          
        </ol>
        @endif
        <h2 class="title-section">{{$tituloPagina}}</h2>
        <div id="opciones">
            <button type="button" class="btn btn-default" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.vistaLista')}}</span></button>
            <button type="button" class="btn btn-default" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.vistaMosaico')}}</span></button>
            <form class="form-inline">
                <div class="form-group">
                    <label class="sr-only" for="searchMain">{{trans('resources.header.campoDeBusqueda')}}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchMain" placeholder="{{trans('resources.header.queDeseaBuscar')}}" maxlength="255">
                        <div class="input-group-addon"><button type="submit" class="btn btn-default" title="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.buscar')}}</span></button></div>
                    </div>
                    
                </div>
                
            </form>
            <!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
        </div>
    </div>
</div>
<div class="container">
    
    
    
    <hr/>
    @if($proveedores != null && count($proveedores) > 0)
    <div id="listado" class="tiles">
    @for($i = 0; $i < count($proveedores); $i++)
        {{$proveedores[$i]}}
        
    @endfor
    </div>
    @else
    <div class="alert alert-info">
        <p>{{trans('resources.listado.noHayElementos')}}</p>
    </div>
    @endif
</div>
    
@endsection
@section('javascript')
<script>
    $(document).ready(function(){
       $('.nav-bar > .brand a img').attr('src','/res/logo/white/72.png');
    });
</script>
<script>
    function changeViewList(obj, idList, view){
        var element, name, arr;
        element = document.getElementById(idList);
        name = view;
        element.className = "tiles " + name;
    }
</script>
@endsection