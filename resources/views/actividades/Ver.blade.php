
@extends('layout._publicLayout')

@section('Title','Actividades')

@section('TitleSection','Actividades')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$actividad->actividadesConIdiomas[0]->nombre}}</h1>
        </div>
    </div>
    {{-- La posición 0 es la portada --}}
    <h3>Portada</h3>
    <div class="row">
        <img src="{{$actividad->multimediasActividades[0]->ruta}}"></img>
    </div>
    <h3>Imágenes</h3>
    <div class="row">
        {{-- La cuenta empieza desde 1 porque la primera posición es la portada --}}
        @for($i = 1; $i < count($actividad->multimediasActividades); $i++)
        <img src="{{$actividad->multimediasActividades[$i]->ruta}}"></img>
        @endfor
    </div>
    <h3>Descripción</h3>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            {{$actividad->actividadesConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row text-center">
        <div class="col-sm-12 col-md-12 col-xs-12">
            Valores: ${{$actividad->valor_min}} - ${{$actividad->valor_max}}
        </div>
    </div>
@endsection
