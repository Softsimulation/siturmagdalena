@extends('layout._publicLayout')
@section('title', '')


@section('content')
@if ($noticias != null || count($noticias) > 0)
    @foreach ($noticias as $noticia)
        <br>
        Tipo noticia : {{$noticia->nombreTipoNoticia}}
        <br>
        Título noticia : {{$noticia->tituloNoticia}}
        <br>
        
        <br>
        <br>
        <br>
        <br>
    @endforeach
@endif
@endsection