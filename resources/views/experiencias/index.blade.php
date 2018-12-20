@extends('layout._publicLayout')

@section('Title', 'Experiencias en el Magdalena')

@section('meta_og')
<meta property="og:title" content="Experiencias" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="Conoce las experiencias que te esperan en el departamento Magdalena"/>

@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        header{
            margin-bottom: 2%;   
        }
    </style>
@endsection

@section('content')
sdfs
 {{$destinos}}
@endsection