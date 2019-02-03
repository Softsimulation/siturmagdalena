<?php
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>
@extends('layout._publicLayout')

@section('title', '')

@section ('estilos')
    <style>
        .nav-bar > .brand a img{
            height: auto;
        }
        .carousel-inner:after{
            background-color: transparent;
        }
        header{
            margin-bottom: 2%;
        }
        .title-section{
            color: #004a87;
            text-align: center;
        }
        .carousel-inner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        .carousel-inner>.item>img {
            min-height: 100%;
            min-width: 100%;
            height: auto;
            max-height: none;
            max-width: none;
        }
        @media only screen and (min-width: 768px) {
            .carousel-inner>.item {
                height: 450px;
            }    
        }
        @media only screen and (min-width: 992px) {
            .carousel-inner>.item {
                height: 500px;
            }
        }
    </style>
@endsection

@section('meta_og')
@if($informacion != null)
<meta property="og:title" content="{{$informacion->titulo}}. Miralo en SITUR Magdalena" />
@endif
<meta property="og:image" content="{{asset('/img/brand/96.png')}}" />
@endsection

@section('content')

    @if($informacion != null)
    <div class="container">
        <ol class="breadcrumb">
          <li>{{trans('resources.menu.conoceElMagdalena')}}</li>
          <li class="active">{{$informacion->titulo}}</li>
        </ol>
        <h2 class="title-section"><small class="btn-block">{{trans('resources.menu.conoceElMagdalena')}}</small> {{$informacion->titulo}}</h2>    
        @if(count($informacion->imagenes) > 0)

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            @for ($i = 0; $i < count($informacion->imagenes); $i++)
            <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" @if($i == 0) class="active" @endif></li>
            @endfor
          </ol>
        
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            @for ($i = 0; $i < count($informacion->imagenes); $i++)
            <div class="item @if($i == 0) active @endif">
              <img src="{{$informacion->imagenes[$i]->ruta}}" alt="" role="presentation" class="d-block w-100">
            </div>
            @endfor
          </div>
        
          <!-- Controls -->
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
          </a>
        </div>
        <br>
        @endif
        <div id="contentDetalle">
            <div class="row">
                @if($informacion->video)
                <div class="col-xs-12 col-md-6">
                    <iframe src="https://www.youtube.com/embed/<?php echo parse_yturl($informacion->video) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 300px;"></iframe>
                    
                </div>
                @endif
                <div class="col-xs-12 @if($informacion->video) col-md-6 @endif">
                    {!! $informacion->cuerpo !!}
                </div>
                
            </div>
            
        </div>
    
    
        <div id="shareButtons" class="text-center">
            <p>Comparte esta información</p>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" role="button" class="btn btn-primary" title="Compartir en Facebook" target="_blank" rel="noopener noreferrer">
                <span class="ion-social-facebook" aria-hidden="true"></span>
                <span class="d-none d-sm-inline-block">Facebook</span>
            </a>
            <a href="https://twitter.com/home?status= {{$informacion->titulo}} por SITUR Magdalena. Lee más en {{\Request::url()}}" role="button" class="btn btn-info" title="Compartir en Twitter" target="_blank" rel="noopener noreferrer">
                <span class="ion-social-twitter" aria-hidden="true"></span>
                <span class="d-none d-sm-inline-block">Twitter</span>
            </a>
            <!--<a href="https://plus.google.com/share?url={{\Request::url()}}" role="button" class="btn btn-danger" title="Compartir en Google +" target="_blank" rel="noopener noreferrer">-->
            <!--    <span class="ion-social-googleplus" aria-hidden="true"></span>-->
            <!--    <span class="d-none d-sm-inline-block">Google +</span>-->
            <!--</a>-->
        </div>
    </div>
    @else
    <div class="alert alert-info text-center">
        No se ha publicado información acerca de este tema
    </div>
    @endif
    
@endsection