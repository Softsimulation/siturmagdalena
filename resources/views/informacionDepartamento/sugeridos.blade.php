<?php 
function getItemType($type){
    $path = ""; $name = "";
    switch($type){
        case(1):
            $name = trans('resources.menu.menuQueHacer.actividades');
            $path = "/actividades/ver/";
            break;
        case(2):
            $name = trans('resources.menu.menuQueHacer.atracciones');
            $path = "/atracciones/ver/";
            break;
        case(3):
            $name = trans('resources.menu.menuQueHacer.destinos');
            $path = "/destinos/ver/";
            break;
        case(4):
            $name = trans('resources.menu.menuQueHacer.eventos');
            $path = "/eventos/ver/";
            break; 
        case(5):
            $name = trans('resources.menu.menuQueHacer.rutasTuristicas');
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path);
}
$colorTipo = ['primary','success','danger', 'info', 'warning'];
?> 
@extends('layout._publicLayout')

@section ('estilos')
    <style>
        .nav-bar > .brand a img{
            height: auto;
        }
        .carousel-inner:after{
            background-color: transparent;
        }
        header{
            margin-bottom: 2%;
        }
        .title-section{
            color: #004a87;
            text-align: center;
        }
        .carousel-inner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .carousel-inner>.item>img {
            min-height: 100%;
            min-width: 100%;
            height: auto;
            max-height: none;
            max-width: none;
        }
        @media only screen and (min-width: 768px) {
            .carousel-inner>.item {
                height: 450px;
            }    
        }
        @media only screen and (min-width: 992px) {
            .carousel-inner>.item {
                height: 500px;
            }
        }
    </style>
@endsection
@section('content')
@if(count($sugeridos))
    <div class="title-custom-section">
        <div class="container">
            <h2 class="text-uppercase text-center">Lugares sugeridos</h2>
        </div><br>
        <br>
        <br>
    </div>
    <div class="container">
        <div class="tiles">
            @foreach($sugeridos as $sugerido)
            <div class="tile">
                <div class="tile-img">
                    <img src="{{$sugerido->portada}}" alt="" role="presentation">
                    <div class="text-overlap">
                        <span class="label label-{{$colorTipo[$sugerido->tipo - 1]}}">{{getItemType($sugerido->tipo)->name}}</span>
                        <h3>
                            <a href="{{getItemType($sugerido->tipo)->path}}{{$sugerido->id}}">{{$sugerido->nombre}}</a>
                            @if($sugerido->tipo == 4)
                            <small class="btn-block" style="color: white;font-style: italic">{{trans('resources.rangoDeFechaEvento', ['fechaInicio' => date('d/m/Y', strtotime($sugerido->fecha_inicio)), 'fechaFin' => date('d/m/Y', strtotime($sugerido->fecha_fin))])}}</small>
                            @endif
                            <div class="text-right"><a href="{{getItemType($sugerido->tipo)->path}}{{$sugerido->id}}" class="btn btn-xs btn-info">Ver más <span class="sr-only">acerca de {{$sugerido->nombre}}</span></a></div>
                        </h3>
                        
                    </div>
                    
                </div>
                <!--<div class="tile-body">-->
                <!--    <div class="tile-caption">-->
                <!--        <h3><a href="#">{{$sugerido->nombre}}</a></h3>-->
                        
                <!--    </div>-->
                <!--</div>-->
            </div>
            @endforeach
        </div>
    </div>
    
    @endif
@endsection

