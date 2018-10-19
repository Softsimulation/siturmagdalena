@extends('layout._publicLayout')
@section('title', '')


@section('content')
Tipo de noticia : {{$noticia->nombreTipoNoticia}}
<br>
Título noticia : {{$noticia->tituloNoticia}}
@if ($portada != null)
    <br>
    Portada : {{$portada->ruta}}
    <br>
    Texto alternativo portada : {{$portada->texto}}
@endif
<br>
Resumen : {{$noticia->resumenNoticia}}
<br>
Texto noticia : {{$noticia->texto}}

@if ($noticia->enlaceFuente != null)
    <br>
    Fuente noticia : {{$noticia->enlaceFuente}}
@endif

<br>
<br>
<br>
<br>
Multimedias: 
@if ($multimedias != null || count($multimedias) > 0)
    @foreach ($multimedias as $multimedia)
        <br>
        Portada : {{$multimedia->portada == 1 ? 1 : 0}}
        <br>
        Ruta : {{$multimedia->ruta}}
        <br>
        Texto alternativo : {{$multimedia->texto}}
        <br>
        <br>
        <br>
        <br>
        <br>
    @endforeach
@endif
@endsection
