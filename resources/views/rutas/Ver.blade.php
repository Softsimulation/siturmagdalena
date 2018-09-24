
@extends('layout._publicLayout')

@section('Title','Rutas')

@section('TitleSection','Rutas')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$ruta->rutasConIdiomas[0]->nombre}}</h1>
        </div>
    </div>
    <div class="row">
        <img src="{{$ruta->portada}}"></img>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            {{$ruta->rutasConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row">
        @foreach ($ruta->rutasConAtracciones as $atraccion)
        <div class="col-sm-12 col-md-12 col-xs-12">
            Atraccion {{$atraccion->id}}: {{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}
        </div>
        @endforeach
    </div>
@endsection
