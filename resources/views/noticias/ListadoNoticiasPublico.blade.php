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
    .tile .tile-img img{
          min-height: 100%;
          min-width: 100%;
          height: auto;
          max-height: none;
          max-width: none;
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
    .tile .tile-img .text-overlap p, .tile .tile-img .text-overlap h3{
        position:relative;
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
    @media only screen and (min-width: 768px) {
        .tile .tile-img img{
            height: 100%;
        }
        .tile .tile-img, .tiles .tile .tile-img {
            height: 300px;
        }   
        .tiles .tile:not(.inline-tile){
            width: calc(100% - 1rem)!important;
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
        
    }
</style>
@endsection

@section('content')
<div class="content-head">
    <div class="container">
        <h2 class="text-uppercase">Noticias</h2>
        <hr/>
        <form method="GET" action="/promocionNoticia/listado">
            <div class="row">
                
                
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group has-feedback">
                            <label class="sr-only">Búsqueda</label>
                            <input type="text" name="buscar" class="form-control" id="buscar" placeholder="¿Qué desea buscar?" @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif maxlength="255" autocomplete="off">
                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-4">
                    
                    
                        <div class="form-group">
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
</div>
<div class="container">
    
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
            <div class="tile-img @if(!$noticia->portada) no-img @endif">
                @if($noticia->portada)
                <img src="{{$noticia->portada}}" alt="" role="presentation">
                @else
                <img src="/img/news.png" alt="" role="presentation">
                @endif
                <div class="text-overlap">
                    <a class="btn-block" href="/promocionNoticia/listado/?tipoNoticia={{$noticia->nombreTipoNoticia}}"><span class="label label-info">{{$noticia->nombreTipoNoticia}}</span></a>
                    <div class="tile-caption">
                        <h3><a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">{{$noticia->tituloNoticia}}</a></h3>
                        <p>{{$noticia->resumen}}</p>
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