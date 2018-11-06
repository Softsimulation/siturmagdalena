@extends('layout._publicLayout')
@section('title', $noticia->tituloNoticia)
@section('estilos')
<link rel="stylesheet" href="{{asset('/css/public/print.css')}}" media="print"/>
<style>
    #contenidoNoticia h1, #contenidoNoticia h2, #contenidoNoticia h3, #contenidoNoticia h4, #contenidoNoticia h5, #contenidoNoticia h6,
    #contenidoNoticia strong{
        font-weight: 500;
    }
    header{
        margin-bottom: 2%;
    }
    h1 small.btn-block, h2 small.btn-block, h3 small.btn-block, h4 small.btn-block, h5 small.btn-block, h6 small.btn-block {
        line-height: 2;
    }
    
    main h1, main h2, main h3, main h4, main h5, main h6 {
        color: #004a87;
    }
    .btn.btn-circle {
        font-size: 1.5rem;
        line-height: 1.35;
        padding: .5rem;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        text-align: center;
    }
    #shareButtons{
        margin-top: .5rem;
        
    }
</style>
@endsection

@section('meta_og')
<meta property="og:title" content="{{$noticia->tituloNoticia}}. Publicado por SITUR Magdalena." />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$noticia->resumenNoticia}}"/>
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li><a href="/">Inicio</a></li>
      <li><a href="/promocionNoticia/listado">Noticias</a></li>
      <li class="active">{{$noticia->tituloNoticia}}</li>
    </ol>
    <h2>{{$noticia->tituloNoticia}} <small class="btn-block">{{$noticia->nombreTipoNoticia}}</small></h2>
    <hr>
    <blockquote style="white-space:pre-line;">{{$noticia->resumenNoticia}}</blockquote>
    
    @if ($multimedias != null && count($multimedias) > 0)
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($multimedias); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $multimedias[$i]->portada ? 'class=active' : '' }}></li>
        @endfor
      </ol>
      
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @for($i = 0; $i < count($multimedias); $i++)
        <div class="item {{  $multimedias[$i]->portada ? 'active' : '' }}">
          <img src="{{$multimedias[$i]->ruta}}" alt="{{$multimedias[$i]->texto}}">
          
        </div>
        @endfor
      </div>
    
      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div>
    @endif
    <div id="contenidoNoticia">
        {!! $noticia->texto !!}
    </div>
    @if ($noticia->enlaceFuente != null)
    <div class="text-right">
          <p><i>Fuente: <a href="{{$noticia->enlaceFuente}}" target="_blank">Clic para ir a la fuente</a></i></p>  
    </div>
    @endif
    <div id="shareButtons" class="text-right">
        <p>Comparte esta publicación</p>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{\Request::url()}}" role="button" class="btn btn-circle btn-primary" title="Compartir en Facebook" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-facebook" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Facebook</span>
        </a>
        <a href="https://twitter.com/home?status= {{$noticia->tituloNoticia}} por SITUR Magdalena. Lee más en {{\Request::url()}}" role="button" class="btn btn-circle btn-info" title="Compartir en Twitter" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-twitter" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Twitter</span>
        </a>
        <a href="https://plus.google.com/share?url={{\Request::url()}}" role="button" class="btn btn-circle btn-danger" title="Compartir en Google +" target="_blank" rel="noopener noreferrer">
            <span class="ion-social-googleplus" aria-hidden="true"></span>
            <span class="sr-only">Compartir en Google +</span>
        </a>
        <button type="button" class="btn btn-circle btn-default" title="Imprimir esta publicación" onclick="window.print();return false;">
            <span class="ion-android-print" aria-hidden="true"></span>
            <span class="sr-only">Imprimir esta publicación</span>
        </button>
    </div>
    
 
</div>

@endsection
@section('javascript')
<script defer>
    $(document).ready(function(){
        $('#contenidoNoticia h1').replaceWith(function(){
            return $("<h2 />", {html: $(this).html()});
        });
        $('#contenidoNoticia h2').replaceWith(function(){
            return $("<h3 />", {html: $(this).html()});
        });
        
    });
</script>
@endsection
