@extends('layout._publicLayout')
@section('title', '')


@section('content')
    <h1>Publicaciones</h1>
    <form method="GET" action="/promocionPublicacion/listado">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipoInforme" class="control-label">Tipo de publicacion</label>
                    <select class="form-control" id="tipoPublicacion" name="tipoPublicacion">
                        <option value="" selected disable>Seleccione tipo de publicación</option>
                        @foreach($tipos as $tipo)
                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                        <label class="sr-only">Búsqueda</label>
                        <input type="text" name="buscar" class="form-control input-lg" id="buscar" placeholder="Buscar publicación...">
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    
                </div>
            </div> 
            <div class="col-xs-12 col-md-2">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
			</div>
        </form>
    <br><br>
    @if ($publicaciones != null || count($publicaciones) > 0)
        @foreach ($publicaciones as $publicacion)
        {{$publicacion}}
            Título : {{$publicacion->titulo}}
            <br>
            <img src="{{$publicacion->portada}}" alt="">
            Portada : {{$publicacion->portada}}
            <br>
            Descripción : {{$publicacion->descripcion}}
            <br>
            Tipo de publicación : {{$publicacion->tipopublicacion->idiomas[0]->nombre}}
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        @endforeach
    @endif
    {!!$publicaciones->links()!!}
@endsection