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
</style>
@endsection

@section('content')
    <h1>Informes</h1>
    
    <div class="row">
        
        <form method="GET" action="/promocionInforme/listado">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipoInforme" class="control-label">Tipo de informe</label>
                    <select class="form-control" id="tipoInforme" name="tipoInforme">
                        <option value="" selected disable>Seleccione tipo de informe</option>
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->tipo_documento_id}}">{{$tipo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="categoriaInforme" class="control-label">Tipo de informe</label>
                    <select class="form-control" id="categoriaInforme" name="categoriaInforme">
                        <option value="" selected disable>Seleccione categoría de informe</option>
                        @foreach($categorias as $categoria)
                            <option value="{{$categoria->categoria_documento_id}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div> 
            <div class="col-xs-12 col-md-2">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
			</div>
        </form>
        
    </div>
    <br><br>
    @if ($informes != null || count($informes) > 0)
        @foreach ($informes as $informe)
            Tipo de informe : {{$informe->tipoInforme}}
            <br>
            Categoría de informe : {{$informe->categoriaInforme}}
            <br>
            Autores : {{$informe->autores}}
            <br>
            Título : {{$informe->tituloInforme}}
            <br>
            Descripción : {{$informe->descripcion}}
            <br>
            Fecha de creación : {{$informe->fecha_creacion}}
            <br>
            Fecha de publicación : {{$informe->fecha_publicacion}}
            <br>
            Portada : {{$informe->portada}}
            <br>
            <a target="_blank" href="{{$informe->ruta}}">Ver PDF</a>
            <br>
            <a href="ver/{{$informe->id}}">Ver más de informe</a>
        @endforeach
    @endif
    
    @if ($informes != null || count($informes) > 0)
    <div class="tiles">
        @foreach ($informes as $informe)
        <div class="tile @if(strlen($informe->tituloInforme) >= 200 || strlen($informe->descripcion) > 230) two-places @endif">
            <div class="tile-img @if(!$informe->portada) no-img @endif">
                @if($informe->portada)
                <img src="{{$informe->portada}}" alt="" role="presentation">
                @else
                <img src="/img/news.png" alt="" role="presentation">
                @endif
                <div class="text-overlap">
                    <a href="/promocionInforme/listado/?tipoInforme={{$informe->tipoInforme}}"><span class="label label-info">{{$informe->tipoInforme}}</span></a>
                </div>
            </div>
            <div class="tile-body">
                <div class="tile-caption">
                    <h3><a href="/promocionInforme/ver/{{$informe->id}}">{{$informe->tituloInforme}}</a></h3>
                </div>
                <p>{{$informe->descripcion}}</p>
                <div class="text-right">
                    <a href="/promocionInforme/ver/{{$informe->id}}" class="btn btn-xs btn-link">Ver más</a>
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
@endsection