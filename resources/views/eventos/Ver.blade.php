
@extends('layout._publicLayout')

@section('Title','Eventos')

@section('TitleSection','Eventos')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$evento->eventosConIdiomas[0]->nombre}} Edicion {{$evento->eventosConIdiomas[0]->edicion or 'No disponible'}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Descripción: {{$evento->eventosConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Valor mínimo: {{$evento->valor_min}} Valor máximo: {{$evento->valor_max}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Fecha de inicio: {{$evento->fecha_in}} Fecha de fin: {{$evento->fecha_fin}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Teléfono: {{$evento->telefono or 'No disponible'}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Página web: {{$evento->web or 'No disponible'}}
        </div>
    </div>
    {{-- La posición 0 es la portada --}}
    <div class="row">
        <img src="{{$evento->multimediaEventos[0]->ruta}}"></img>
    </div>
    <div class="row">
        {{-- La cuenta empieza desde 1 porque la primera posición es la portada --}}
        @for($i = 1; $i < count($evento->multimediaEventos[0]->ruta); $i++)
        <img src="{{$evento->multimediaEventos[0]->ruta}}"></img>
        @endfor
    </div>
    <div class="row">
        <iframe src="{{$video_promocional}}">
        </iframe>
    </div>
    <br/>
    <h4>Sitios: </h4>
    <div class="row">
        @foreach ($evento->sitiosConEventos as $sitio)
        <div class="col-sm-12 col-md-12 col-xs-12">
            {{$sitio->sitiosConIdiomas[0]->nombre}}
        </div>
        @endforeach
    </div>
@endsection
