<?php
    use Illuminate\Support\Facades\Input;
?>
@extends('layout._publicLayout')
@section('title', 'Informes')

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
            width: calc(50% - 1rem)!important;
        }   
        
    }
    @media only screen and (min-width: 992px) {
        .tiles .tile:not(.inline-tile){
            width: calc(33.3% - 1rem)!important;
        }    
        .tile .tile-img .text-overlap h3{
            font-size: 1.25rem;
        }
        .tile .tile-img, .tiles .tile .tile-img {
            height: 280px;
        }
        
    }
    .content-head{
        margin-bottom :1rem;
    }
</style>
@endsection

@section('content')
<div class="content-head">
    <div class="container">
        <h2 class="text-uppercase">Informes</h2>
        <hr/>
        <form method="GET" action="/promocionInforme/listado">
            <div class="row">
                
                
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <div class="form-group">
                        <label for="categoriaInforme" class="control-label">Categoría de informe</label>
                        <select class="form-control" id="categoriaInforme" name="categoriaInforme">
                            <option value="" selected disable>Seleccione la categoría de informe</option>
                            @foreach($categorias as $categoria)
                                <option value="{{$categoria->categoria_documento_id}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-5">
                    
                    
                        <div class="form-group">
                            <label for="tipoInforme" class="control-label">Tipo de informe</label>
                            <select class="form-control" id="tipoInforme" name="tipoInforme" onchange="this.form.submit()">
                                <option value="" selected @if(isset($_GET['tipoInforme']) && $_GET['tipoInforme'] == "") disabled @endif>@if(isset($_GET['tipoInforme']) && $_GET['tipoInforme'] != "") Ver todos los registros @else - Seleccione el tipo de informe -  @endif</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}" @if(isset($_GET['tipoInforme']) && $_GET['tipoInforme'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    
                </div>
                <div class="col-xs-12 col-md-3 col-lg-2" style="display: flex; align-items: flex-end">
                    
        			<button type="submit" class="btn btn-block btn-success" title="Buscar" style="margin-bottom: 1rem;"><span class="glyphicon glyphicon-search"></span> Buscar</button>
        		</div>
            </div>
        </form>
    </div>
</div>
<div class="container">
    @if(isset($_GET['buscar']) || isset($_GET['categoriaInforme']) || isset($_GET['tipoInforme']))
    <div class="text-center">
        <a href="/promocionInforme/listado" class="btn btn-default">Limpiar filtros</a>
    </div>
    @endif
    <!--@if ($informes != null || count($informes) > 0)-->
    <!--    @foreach ($informes as $informe)-->
    <!--        Tipo de informe : {{$informe->tipoInforme}}-->
    <!--        <br>-->
    <!--        Categoría de informe : {{$informe->categoriaInforme}}-->
    <!--        <br>-->
    <!--        Autores : {{$informe->autores}}-->
    <!--        <br>-->
    <!--        Título : {{$informe->tituloInforme}}-->
    <!--        <br>-->
    <!--        Descripción : {{$informe->descripcion}}-->
    <!--        <br>-->
    <!--        Fecha de creación : {{$informe->fecha_creacion}}-->
    <!--        <br>-->
    <!--        Fecha de publicación : {{$informe->fecha_publicacion}}-->
    <!--        <br>-->
    <!--        Portada : {{$informe->portada}}-->
    <!--        <br>-->
    <!--        <a target="_blank" href="{{$informe->ruta}}">Ver PDF</a>-->
    <!--        <br>-->
    <!--        <a href="ver/{{$informe->id}}">Ver más de informe</a>-->
    <!--    @endforeach-->
    <!--@endif-->
    
    @if ($informes != null && count($informes) > 0)
    <div class="tiles">
        @foreach ($informes as $informe)
        <div class="tile">
            <div class="tile-img @if(!$informe->portada) no-img @endif">
                @if($informe->portada)
                <img src="{{$informe->portada}}" alt="" role="presentation">
                @else
                <img src="/img/news.png" alt="" role="presentation">
                @endif
                <div class="text-overlap" style="flex-direction: column; align-items: end;">
                    <span class="label label-info" style="margin-bottom: 1rem;">{{$informe->tipoInforme}}</span>
                    
                    <span class="label label-info">{{$informe->categoriaInforme}}</span>
                </div>
            </div>
            <div class="tile-body">
                <div class="tile-caption">
                    <h3><a href="{{$informe->ruta}}" target="_blank">{{$informe->tituloInforme}}</a></h3>
                </div>
                <em class="text-muted">
                    @if($informe->autores)
                    <span class="ion-person" aria-hidden="true"></span><span class="sr-only">Autores</span> {{$informe->autores}}
                    @endif
                    @if($informe->fecha_publicacion)
                     - <span class="ion-calendar" aria-hidden="true"></span><span class="sr-only">Fecha de publicación</span> {{$informe->fecha_publicacion}}
                    @endif
                </em>
                <p class="text-muted">{{$informe->descripcion}}</p>
                <div class="text-right">
                    <!--<a href="/promocionInforme/ver/{{$informe->id}}" class="btn btn-xs btn-link">Descargar PDF</a>-->
                    <a href="{{$informe->ruta}}" target="_blank" class="btn btn-xs btn-success">Descargar PDF</a>
                </div>
            </div>
        </div>
           
        @endforeach
    </div>
    <div class="text-center">
        {!!$informes->appends(Input::except('page'))->links()!!}
    </div>
    @else
    <div class="alert alert-info">
        <p>No hay elementos publicados en este momento.</p>
    </div>
    @endif
    {!!$informes->links()!!}
</div>

    
    
@endsection