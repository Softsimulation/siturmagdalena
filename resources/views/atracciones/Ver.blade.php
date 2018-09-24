
@extends('layout._publicLayout')

@section('Title','Atracciones')

@section('TitleSection','Atracciones')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}</h1>
        </div>
    </div>
    {{-- La posición 0 es la portada --}}
    <div class="row">
        <img src="{{$atraccion->sitio->multimediaSitios[0]->ruta}}"></img>
    </div>
    <div class="row">
        {{-- La cuenta empieza desde 1 porque la primera posición es la portada --}}
        @for($i = 1; $i < count($atraccion->sitio->multimediaSitios); $i++)
        <img src="{{$atraccion->sitio->multimediaSitios[$i]->ruta}}"></img>
        @endfor
    </div>
    <div class="row">
        <iframe src="{{$video_promocional}}">
        </iframe>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            {{$atraccion->sitio->sitiosConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row">
        Longitud: {{$atraccion->sitio->longitud}} <br/>
        Latitud: {{$atraccion->sitio->latitud}}
    </div>
    <div class="row text-center">
        <div class="col-sm-12 col-md-12 col-xs-12">
            Horario: {{$atraccion->atraccionesConIdiomas[0]->horario}}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-md-4 col-xs-12">
            Recomendaciones: {{$atraccion->atraccionesConIdiomas[0]->recomendaciones}}
        </div>
        <div class="col-sm-4 col-md-4 col-xs-12">
            Reglas: {{$atraccion->atraccionesConIdiomas[0]->reglas}}
        </div>
        <div class="col-sm-4 col-md-4 col-xs-12">
            Cómo llegar: {{$atraccion->atraccionesConIdiomas[0]->como_llegar}}
        </div>
    </div>
    <div class="row text-center">
        <p class="col-md-12 col-sm-12">
            @foreach ($atraccion->sitio->sitiosConActividades as $actividad)
                Actividad - {{$actividad->id}}: 
                @if(count($actividad->multimediasActividades) > 0)
                    <img src='{{$actividad->multimediasActividades[0]->ruta}}'></img><br/>
                @endif
                {{$actividad->actividadesConIdiomas[0]->nombre}}<br/>
            @endforeach
        </p>
    </div>
@endsection
