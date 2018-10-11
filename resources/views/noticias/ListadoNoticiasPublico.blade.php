@extends('layout._publicLayout')
@section('title', 'Noticias')


@section('content')
    <h1>Noticias</h1>
    <form method="GET" action="/promocionNoticia/listado">
        <div class="row">
            
            <div class="col-md-3">
                
                
                    <div class="form-group">
                        <label for="tipoNoticia" class="control-label">Tipo de noticia</label>
                        <select class="form-control" id="tipoNoticia" name="tipoNoticia">
                            <option value="" selected disable>Seleccione tipo de noticia</option>
                            @foreach($tiposNoticias as $tipo)
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
        </div>
    </form>
    <br><br>
    @if ($noticias != null || count($noticias) > 0)
        @foreach ($noticias as $noticia)
            <br>
            Tipo noticia : {{$noticia->nombreTipoNoticia}}
            <br>
            Título noticia : {{$noticia->tituloNoticia}}
            <br>
            <a href="ver/{{$noticia->idNoticia}}">Ver</a>
            <br>
            <br>
            <br>
            <br>
        @endforeach
    @endif
    {!!$noticias->links()!!}
@endsection