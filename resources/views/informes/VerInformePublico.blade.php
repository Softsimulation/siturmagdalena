@extends('layout._publicLayout')
@section('title', '')


@section('content')
    <h1>Informe</h1>
    
    <br><br>
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
            Palabras claves : {{$informe->PalabrasClaves}}
            <br>
            Fecha de creación : {{$informe->fecha_creacion}}
            <br>
            Fecha de publicación : {{$informe->fecha_publicacion}}
            <br>
            Portada : {{$informe->portada}}
            <br>
            <a target="_blank" href="{{$informe->ruta}}">Ver PDF</a>
@endsection