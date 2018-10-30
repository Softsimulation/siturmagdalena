@extends('layout._publicLayout')
@section('title', 'Noticias')


@section('content')
<div class="container">
    <h1>Noticias</h1>
    <form method="GET" action="/promocionNoticia/listado">
        <div class="row">
            
            <div class="col-md-3">
                
                
                    <div class="form-group">
                        <label for="tipoNoticia" class="control-label">Tipo de noticia</label>
                        <select class="form-control" id="tipoNoticia" name="tipoNoticia" onchange="this.form.submit()">
                            <option value="" selected @if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] == "") disabled @endif>@if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] != "") Ver todos los registros @else - Seleccione el tipo de turísmo -  @endif</option>
                            @foreach($tiposNoticias as $tipo)
                                <option value="{{$tipo->id}}" @if(isset($_GET['tipoNoticia']) && $_GET['tipoNoticia'] == $tipo->id) selected @endif>{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                
            </div>
            <div class="col-md-3">
                <div class="form-group has-feedback">
                        <label class="sr-only">Búsqueda</label>
                        <input type="text" name="buscar" class="form-control" id="buscar" placeholder="Buscar publicación..." @if(isset($_GET['buscar'])) value="{{$_GET['buscar']}}" @endif>
                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                    
                </div>
            </div>
            <div class="col-xs-12 col-md-2">
    			<button type="submit" class="btn btn-primary" title="Buscar"><span class="glyphicon glyphicon-search"></span><span class="sr-only">Buscar</span></button>
    		</div>
        </div>
    </form>
    <br><br>
    @if ($noticias != null || count($noticias) > 0)
    <div class="tiles tile-list">
        @foreach ($noticias as $noticia)
        <div class="tile">
            <div class="tile-body">
                <div class="tile-caption">
                    <h3><a href="/promocionNoticia/ver/{{$noticia->idNoticia}}">{{$noticia->tituloNoticia}}</a></h3>
                </div>
                <a href="/promocionNoticia/listado/?tipoNoticia={{$noticia->nombreTipoNoticia}}"><span class="label label-primary">{{$noticia->nombreTipoNoticia}}</span></a>
                <div class="inline-buttons">
                    <a href="#" class="btn btn-xs btn-link">Ver más</a>
                </div>
            </div>
        </div>
           
        @endforeach
    </div>
    @endif
        
    
    {!!$noticias->links()!!}
</div>
    
@endsection