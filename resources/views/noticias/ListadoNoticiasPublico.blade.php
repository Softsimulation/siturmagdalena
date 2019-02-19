<?php
    use Illuminate\Support\Facades\Input;
?>
@extends('layout._publicLayout')
@section('title', 'Noticias')

@section('estilos')
<style>
    .row{
        width: calc(100% + 30px);
    }
    .tile .tile-img.no-img{
        background-color: white;
    }
    /*.tile .tile-img.no-img img{*/
    /*    height: 100px;*/
    /*}*/
    /*.tiles .tile .tile-img.no-img {*/
    /*    height: 100px;*/
    /*}*/
    .content-head {
        padding-top: 1rem;
        background-color: whitesmoke;
        box-shadow: 0px 2px 4px -2px rgba(0,0,0,.35);
    }
    .tile .tile-img{
        position:relative;
    }
    .tile .tile-img:not(.img-error) img{
          min-height: 100%;
          min-width: 100%;
          height: auto;
          max-height: none;
          max-width: none;
          width: 100%;
    }
    .tile .tile-img.no-img img {
        width: auto;
        min-width: 0;
        min-height: 0;
        height: auto;
    }
    .tile .tile-img .text-overlap{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    .tile .tile-img .text-overlap p {
        color: white;
        font-weight: 500;
        margin: 0;
        font-size: .875rem;
    }
    .tile .tile-img .text-overlap h3{
        font-size: 1.125rem;
        margin: 0;
        margin-bottom: .5rem;
        border-bottom: 2px solid white;
    }
    
    .tile .tile-img .text-overlap .tile-caption{
        position:absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.035);
        background: -moz-linear-gradient(top, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.45) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(0,0,0,0.0)), color-stop(100%, rgba(0,0,0,0.45)));
        background: -webkit-linear-gradient(top, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.45) 100%);
        background: -o-linear-gradient(top, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.45) 100%);
        background: -ms-linear-gradient(top, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.45) 100%);
        background: linear-gradient(to bottom, rgba(0,0,0,0.0) 0%, rgba(0,0,0,0.45) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f85032', endColorstr='#000000', GradientType=0 );
    }
    
    .tile .tile-img .text-overlap p, .tile .tile-img .text-overlap h3{
        position:relative;
        background: none!important;
    }
    .text-overlap .label.label-info {
        margin-left: -.5rem;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
        font-weight: 500;
        font-size: 1rem;
    }
    .tile .tile-img, .tiles .tile .tile-img {
        height: 280px;
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
    .header-list{
            background-image: url(../../img/headers/atardecer.jpg);
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
    @media only screen and (min-width: 768px) {
        .tile .tile-img:not(.img-error) img{
            width: 100%;
        }
        .tile .tile-img, .tiles .tile .tile-img {
            height: 300px;
        }   
        .tiles .tile:not(.inline-tile){
            width: calc(100% - 1rem)!important;
        }   
        .carousel-inner>.item {
            height: 450px;
        }
    }
    @media only screen and (min-width: 992px) {
        .tiles .tile:not(.inline-tile){
            width: calc(50% - 1rem)!important;
        }    
        .tile .tile-img .text-overlap h3{
            font-size: 1.25rem;
        }
        .tile .tile-img, .tiles .tile .tile-img {
            height: 280px;
        }
        .carousel-inner>.item {
            height: 500px;
        }
    }
</style>
@endsection

@section('content')

<div class="header-list">
    <div class="container text-center">
        <h2 class="title-section text-uppercase text-blue">Noticias</h2>
    </div>
</div>
<div class="container">
    
    <div class="well mt-3">
        <form method="GET" action="/promocionNoticia/listado">
            <div class="row">
                
                
                <div class="col-xs-12 col-md-5 col-lg-6">
                    <div class="form-group has-feedback m-0">
                            <label class="sr-only">Búsqueda</label>
                            <input type="text" name="buscar" class="form-control" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif maxlength="255" autocomplete="off">
                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4">
                    
                    
                        <div class="form-group m-0">
                            <label for="tipoNoticia" class="control-label sr-only">Tipo de noticia</label>
                            <select class="form-control" id="tipoNoticia" name="tipoNoticia" onchange="this.form.submit()">
                                <option value="" selected @if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] == "") disabled @endif>@if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] != "") Ver todos los registros @else - Seleccione el tipo de turísmo -  @endif</option>
                                @foreach($tiposNoticias as $tipo)
                                    <option value="{{$tipo->id}}" @if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
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
    @if(isset($_GET['buscar']) || isset($_GET['tipoNoticia']))
    <div class="text-center">
        <a href="/promocionNoticia/listado" class="btn btn-default">Limpiar filtros</a>
    </div>
    @endif
    <br>
    @if ($noticias != null || count($noticias) > 0)
    <div class="tiles">
        @foreach ($noticias as $noticia)
        <div class="tile">
            <div class="tile-img <?php if(!$noticia->portada)echo "img-error" ?>">
                @if($noticia->portada)
                <img src="{{$noticia->portada}}" alt="" role="presentation">
                @else
                <img src="/img/brand/72.png" class="no-fit" alt="" role="presentation">
                @endif
                <div class="text-overlap">
                    <a class="btn-block tile-label-top" href="/promocionNoticia/listado/?tipoNoticia={{$noticia->nombreTipoNoticia}}"><span class="label label-info">{{$noticia->nombreTipoNoticia}}</span></a>
                    <div class="tile-caption">
                        <h3><a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">{{$noticia->tituloNoticia}}</a></h3>
                        <p>{{$noticia->resumen}}</p>
                        <div class="text-right">
                            <a class="btn btn-xs btn-success mb-3 mr-2 text-uppercase shadow" href="/promocionNoticia/ver/{{$noticia->idNoticia}}">Leer más <span class="sr-only">acerca de la noticia titulada {{$noticia->tituloNoticia}}</span></a>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!--<div class="tile-body">-->
            <!--    <div class="tile-caption">-->
            <!--        <h3><a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">{{$noticia->tituloNoticia}}</a></h3>-->
            <!--    </div>-->
            <!--    <p>{{$noticia->resumen}}</p>-->
            <!--    <div class="text-right">-->
            <!--        <a href="/promocionNoticia/ver/{{$noticia->idNoticia}}" class="btn btn-xs btn-link">Ver más</a>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
           
        @endforeach
    </div>
    
    <div class="text-center">
        {!!$noticias->appends(Input::except('page'))->links()!!}
    </div>
    @else
    <div class="alert alert-info">
        <p>No hay elementos publicados en este momento.</p>
    </div>
    @endif
    
    
    
</div>
    
@endsection