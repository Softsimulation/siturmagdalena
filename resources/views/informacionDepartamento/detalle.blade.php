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
    </style>
@endsection

@section('meta_og')
<meta property="og:title" content="{{$informacion->titulo}}. Miralo en SITUR Cesar" />
<meta property="og:image" content="{{asset('/img/brand/96.png')}}" />
@endsection

@section('content')
<div class="header-list without-options">
        <div class="container">
            <h2 class="title-section"><small class="d-block">Información del departamento</small> {{$informacion->titulo}}</h2>
            
        </div>
        
    </div>

    <div class="container">
    
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
            <div class="carousel-item @if($i == 0) active @endif">
              <img src="{{$informacion->imagenes[$i]->ruta}}" alt="" role="presentation" class="d-block w-100">
            </div>
            @endfor
          </div>
        
          <!-- Controls -->
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
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
        <a href="https://twitter.com/home?status= {{$informacion->titulo}} por SITUR Cesar. Lee más en {{\Request::url()}}" role="button" class="btn btn-info" title="Compartir en Twitter" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-twitter" aria-hidden="true"></span>
            <span class="d-none d-sm-inline-block">Twitter</span>
        </a>
        <a href="https://plus.google.com/share?url={{\Request::url()}}" role="button" class="btn btn-danger" title="Compartir en Google +" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-googleplus" aria-hidden="true"></span>
            <span class="d-none d-sm-inline-block">Google +</span>
        </a>
    </div>
    </div>
    
    
@endsection