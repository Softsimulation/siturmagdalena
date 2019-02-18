<?php
    use Illuminate\Support\Facades\Input;
?>
@extends('layout._publicLayout')
@section('title', 'Publicaciones')

@section('estilos')
<style>
    .row{
        width: calc(100% + 30px);
    }
    .tile .tile-img.no-img{
        background-color: white;
    }
    .tile .tile-img.no-img img{
        height: 100px;
    }
    .tiles .tile .tile-img.no-img {
        height: 100px;
    }
    .content-head {
        padding-top: 1rem;
        background-color: whitesmoke;
        box-shadow: 0px 2px 4px -2px rgba(0,0,0,.35);
    }
    .header-list{
        background-image: url(../../img/headers/cafe.jpg);
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
        font-size: 2.5rem;
        background-color: rgba(0,0,0,.2);
        padding: .25rem .5rem;
        margin-bottom: 1rem;
        border-radius: 10px;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="header-list">
    <div class="container text-center">
        <h2 class="title-section text-uppercase text-blue">Biblioteca digital</h2>
    </div>
</div>

<div class="container">
    <div class="well mt-3">
        <form method="GET" action="/promocionPublicacion/listado">
            <div class="row">
                
                
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group has-feedback">
                            <label class="sr-only" for="buscar">Búsqueda</label>
                            <input type="text" name="buscar" class="form-control" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif maxlength="255" autocomplete="off">
                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-4">
                    
                    
                        <div class="form-group">
                            <label for="tipoPublicacion" class="control-label sr-only">Tipo de publicación</label>
                            <select class="form-control" id="tipoPublicacion" name="tipoPublicacion" onchange="this.form.submit()">
                                <option value="" selected @if((isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == "") || !isset($_GET['tipoPublicacion'])) disabled @endif>@if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] != "") Ver todos los registros @else - Seleccione el tipo de publicación -  @endif</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}" @if(isset($_GET['tipoPublicacion']) && $_GET['tipoPublicacion'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                           
                        </div>
                        
                    
                </div>
                <div class="col-xs-12 col-md-3 col-lg-2">
        			<button type="submit" class="btn btn-block btn-success" title="Buscar"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        		</div>
            </div>
        </form>
    </div>
    @if(isset($_GET['buscar']) || isset($_GET['tipoPublicacion']))
    <div class="text-center">
        <a href="/promocionPublicacion/listado" class="btn btn-default">Limpiar filtros</a>
    </div>
    @endif
    <br>
    @if ($publicaciones != null || count($publicaciones) > 0)
    <div class="tiles">
        @foreach ($publicaciones as $publicacion)
            <div class="tile @if(strlen($publicacion->titulo) >= 200 || strlen($publicacion->resumen) > 200) two-places @endif">
                <div class="tile-img @if(!$publicacion->portada) no-img @endif">
                    @if($publicacion->portada)
                    <img src="{{$publicacion->portada}}" alt="" role="presentation">
                    @else
                    <img src="/img/news.png" alt="" role="presentation">
                    @endif
                    <div class="text-overlap">
                        <a href="/promocionPublicacion/listado/?tipoNoticia={{$publicacion->tipopublicacion->idiomas[0]->nombre}}"><span class="label label-info">{{$publicacion->tipopublicacion->idiomas[0]->nombre}}</span></a>
                    </div>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="/promocionPublicacion/ver/{{$publicacion->id}}">{{$publicacion->titulo}}</a></h3>
                    </div>
                
                    
                    <p>{{$publicacion->resumen}}</p>
                    <div class="text-right">
                        <a href="/promocionPublicacion/ver/{{$publicacion->idPublicacion}}" class="btn btn-xs btn-link">Ver más</a>
                    </div>
                
                    
                </div>
            </div>
        @endforeach
    </div>
    {!!$publicaciones->appends(Input::except('page'))->links()!!}
    @else
    <div class="alert alert-info">
        <p>No hay elementos publicados en este momento.</p>
    </div>
    @endif
    
</div>
    
@endsection