
@extends('layout._publicLayout')

@section('Title','Destinos')

@section('TitleSection','Destinos')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$destino->destinoConIdiomas[0]->nombre}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            Tipo de destino: {{$destino->tipoDestino->tipoDestinoConIdiomas[0]->nombre}}
        </div>
    </div>
    <div class="row">
        <img src="{{$destino->multimediaDestinos[0]->ruta}}"></img>
    </div>
    <div class="row">
        <iframe src="{{$video_promocional}}">
        </iframe>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">
            {{$destino->destinoConIdiomas[0]->descripcion}}
        </div>
    </div>
    <div class="row">
        Longitud: {{$destino->longitud}} <br/>
        Latitud: {{$destino->latitud}}
    </div>
@endsection
