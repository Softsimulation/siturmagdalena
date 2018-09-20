
@extends('layout._publicLayout')

@section('Title','Atracciones')

@section('TitleSection','Atracciones')

@section('content')
    {{print_r($atraccion->sitio->sitiosConIdiomas[0]->nombre)}}
@endsection
