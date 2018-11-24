<?php
header("Access-Control-Allow-Origin: *");
//$paraTenerEnCuentaContieneAlgo = $atraccion->atraccionesConIdiomas[0]->recomendaciones != "" || $atraccion->atraccionesConIdiomas[0]->reglas != "" || $atraccion->atraccionesConIdiomas[0]->como_llegar != "" || count($atraccion->sitio->sitiosConActividades) > 0;
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>
@extends('layout._publicLayout')

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
<meta property="og:title" content="Conoce {{$actividad->actividadesConIdiomas[0]->nombre}} en el departamento del Magdalena" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$actividad->actividadesConIdiomas[0]->descripcion}}"/>
@endsection

@section('Title','Actividades')

@section('TitleSection','Actividades')

@section('content')
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($actividad->multimediasActividades); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
    
      <!-- Wrapper for slides -->
        
      
      <div class="carousel-inner">
        @for($i = 0; $i < count($actividad->multimediasActividades); $i++)
        <div class="item {{  $i === 0 ? 'active' : '' }}">
          <img src="{{$actividad->multimediasActividades[$i]->ruta}}" alt="Imagen de presentación de {{$actividad->actividadesConIdiomas[0]->nombre}}">
          
        </div>
        @endfor
        
      </div>
      <div class="carousel-caption">
          <h2>{{$actividad->actividadesConIdiomas[0]->nombre}}
              <small class="btn-block">
	              <span class="{{ ($actividad->calificacion_legusto > 0.0) ? (($actividad->calificacion_legusto <= 0.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($actividad->calificacion_legusto > 1.0) ? (($actividad->calificacion_legusto <= 1.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($actividad->calificacion_legusto > 2.0) ? (($actividad->calificacion_legusto <= 2.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($actividad->calificacion_legusto > 3.0) ? (($actividad->calificacion_legusto <= 3.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($actividad->calificacion_legusto > 4.0) ? (($actividad->calificacion_legusto <= 5.0) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="sr-only">Posee una calificación de {{$actividad->calificacion_legusto}}</span>
	            
	          </small>
          </h2>
          <div class="text-center">
            @if(Auth::check())
                <form role="form" action="/actividades/favorito" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="actividad_id" value="{{$actividad->id}}" />
                    <button type="submit" class="btn btn-lg btn-circled btn-favorite">
                      <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                    </button>    
                </form>
            @else
                <button type="button" class="btn btn-lg btn-circled" title="Marcar como favorito" data-toggle="modal" data-target="#modalIniciarSesion">
                  <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                </button>
            @endif
          </div>
      </div>
      <!-- Controls -->
      <!--<a class="left carousel-control" href="#carousel-main-page" role="button" data-slide="prev">-->
      <!--  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>-->
      <!--  <span class="sr-only">Anterior</span>-->
      <!--</a>-->
      <!--<a class="right carousel-control" href="#carousel-main-page" role="button" data-slide="next">-->
      <!--  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>-->
      <!--  <span class="sr-only">Siguiente</span>-->
      <!--</a>-->
    </div>
    <div id="menu-page">
        <div class="container">
            <ul id="menu-page-list" class="justify-content-center">
                <li>
                    <a href="#informacionGeneral" class="toSection">
						<i class="ionicons ion-information-circled" aria-hidden="true"></i>
						<span class="hidden-xs">Información general</span>
					</a>
                </li>
                <li>
                    <a href="#caracteristicas" class="toSection">
						<i class="ionicons ionicons ion-android-pin" aria-hidden="true"></i>
						<span class="hidden-xs">Ubicación</span>
					</a>
                </li>
                <li>
                    <a href="#comentarios" class="toSection">
						<i class="ionicons ion-chatbubbles" aria-hidden="true"></i>
						<span class="hidden-xs">Comentarios</span>
					</a>
                </li>
            </ul>
        </div>
    </div>
    <section id="informacionGeneral" class="section active">
        <div class="container">
            <h3 class="title-section">{{$actividad->actividadesConIdiomas[0]->nombre}}</h3>
            @if(Session::has('message'))
                <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
            @endif
            <div class="row">
                {{--<div class="col-xs-12">
                    @if($video_promocional != null)
                    <iframe src="https://www.youtube.com/embed/{{print(parse_yturl($video_promocional))}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;margin-bottom: 1rem;"></iframe>
                    @endif
                </div>--}}
                <div class="col-xs-12 col-md-8">
                    
                    <p style="white-space: pre-line;">{{$actividad->actividadesConIdiomas[0]->descripcion}}</p>
                </div>
                <div class="col-xs-12 col-md-4">
                    <ul class="list">
                        <li>
                            <div class="row align-items-center">
                                <div class="col-xs-2">
                                    <span class="ionicons ion-cash" aria-hidden="true"></span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <label>Valor estimado</label>
                                        <p class="form-control-static">
                                            ${{number_format($actividad->valor_min)}} - ${{number_format($actividad->valor_max)}}
                                        </p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </li>
                       
                    </ul>    
                </div>
            </div>
            
        </div>
        
    </section>
    
    <!-- Modal iniciar sesión-->
    <div class="modal fade" id="modalIniciarSesion" tabindex="-1" role="dialog" aria-labelledby="labelModalIniciarSesion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="labelModalIniciarSesion">Iniciar sesión</h4>
                </div>
                <div class="modal-body">
                    <p>Para calificar, comentar o agregar a sus favoritos este contenido debe iniciar sesión. Si aún no se encuentra registrado <a href="#">haga clic aquí</a></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Iniciar sesión</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection
