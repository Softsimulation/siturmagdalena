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
    .tile .tile-img{
        background-color: white;
    }
    .tile .tile-img img{
        height: 100px;
    }
    .tiles .tile .tile-img {
        height: 100px;
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
            <div class="tile-img">
                <img src="/img/news.png" alt="" role="presentation">
            </div>
            <div class="tile-body">
                <div class="tile-caption">
                    <h3><a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">{{$noticia->tituloNoticia}}</a></h3>
                </div>
                <p><a href="/promocionNoticia/listado/?tipoNoticia={{$noticia->nombreTipoNoticia}}"><span class="label label-info">{{$noticia->nombreTipoNoticia}}</span></a></p>
                <div class="text-right">
                    <a href="/promocionNoticia/ver/{{$noticia->idNoticia}}" class="btn btn-xs btn-link">Ver más</a>
                </div>
            </div>
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