@extends('layout._publicLayout')
@section('title', 'Noticias')


@section('content')
    <h1>Noticias</h1>
    
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
    {!!$informes->links()!!}
@endsection