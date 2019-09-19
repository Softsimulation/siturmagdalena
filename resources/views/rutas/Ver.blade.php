
@extends('layout._publicLayout')

@section('Title', $ruta->rutasConIdiomas[0]->nombre)

@section('TitleSection', $ruta->rutasConIdiomas[0]->nombre)

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <style>
        .section{
            display: none;
        }
        .section.active{
            display:block;
        }
    </style>
@endsection

@section('meta_og')
<meta property="og:title" content="Conoce {{$ruta->rutasConIdiomas[0]->nombre}} en el departamento del Magdalena" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$ruta->rutasConIdiomas[0]->descripcion}}"/>
@endsection

@section('content')
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>
        
      </ol>
    
      <!-- Wrapper for slides -->
        
      
      <div class="carousel-inner">
        <div class="item active">
          <img src="{{$ruta->portada}}" alt="Imagen de presentación de {{$ruta->rutasConIdiomas[0]->descripcion}}">
          
        </div>
      </div>
      <div class="carousel-caption">
          <h2>
              {{$ruta->rutasConIdiomas[0]->nombre}}
          </h2>
          
      </div>
    </div>
    <div id="menu-page">
        <div class="container">
            <ul id="menu-page-list">
                <li>
                    <a href="#informacionGeneral" class="toSection">
						<i class="ionicons ion-information-circled" aria-hidden="true"></i>
						<span class="hidden-xs">Información general</span>
					</a>
                </li>
                
            </ul>
        </div>
    </div>
    <section id="informacionGeneral" class="section active">
        <div class="container">
            <h3 class="title-section">{{$ruta->rutasConIdiomas[0]->nombre}}</h3>
           
            <div class="row">
               
                <div class="col-xs-12 col-md-12">
                    
                    <p style="white-space: pre-line;">{{$ruta->rutasConIdiomas[0]->descripcion}}</p>
                </div>
               
            </div>
            @if($ruta->rutasConAtracciones)
            <p>En esta ruta podrá encontrar las siguientes atracciones:</p>
             <div class="tiles">
                    @foreach ($ruta->rutasConAtracciones as $atraccion)
                    <div class="tile">
                        <div class="tile-body">
                            <div class="tile-caption">
                                <h3><a href="/atracciones/ver/{{$atraccion->id}}">{{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}</a></h3>
                            </div>
                            
                        </div>
                       
                    </div>
                    @endforeach
                </div>
                @endif
        </div>
        
    </section>

    <!--<div class="row">-->
    <!--    <div class="col-sm-12 col-md-12 col-xs-12 text-center">-->
    <!--        <h1>Nombre: {{$ruta->rutasConIdiomas[0]->nombre}}</h1>-->
    <!--    </div>-->
    <!--</div>-->
    <!--<div class="row">-->
    <!--    <img src="{{$ruta->portada}}"></img>-->
    <!--</div>-->
    <!--<div class="row">-->
    <!--    <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-4 col-sm-offset-4">-->
    <!--        {{$ruta->rutasConIdiomas[0]->descripcion}}-->
    <!--    </div>-->
    <!--</div>-->
    
@endsection
