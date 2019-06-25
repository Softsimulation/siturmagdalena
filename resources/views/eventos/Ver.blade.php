<?php
header("Access-Control-Allow-Origin: *");
function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>


@section ('estilos')
<link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <style>
        
        
        .section{
            display: none;
        }
        .section.active{
            display:block;
        }
        .tiles .tile{
            width: auto;
            padding: .5rem;
        }
    </style>
@endsection


@section('Title',$evento->eventosConIdiomas[0]->nombre)

@section('meta_og')
<meta property="og:title" content="Conoce {{$evento->eventosConIdiomas[0]->nombre}} en el departamento del Magdalena" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$evento->eventosConIdiomas[0]->descripcion}}"/>
@endsection

@section('content')
    @if(count($evento->multimediaEventos) > 0)
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($evento->multimediaEventos); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
    
      <!-- Wrapper for slides -->
        
      
      <div class="carousel-inner">
        @for($i = 0; $i < count($evento->multimediaEventos); $i++)
        <div class="item {{  $i === 0 ? 'active' : '' }}">
          <img src="{{$evento->multimediaEventos[$i]->ruta}}" alt="Imagen de presentación de {{$evento->eventosConIdiomas[0]->nombre}}">
          
        </div>
        @endfor
        
      </div>
      <div class="carousel-caption">
          <h2>{{$evento->eventosConIdiomas[0]->nombre}}
              @if($evento->eventosConIdiomas[0]->edicion)
              <small class="btn-block">
	              Ed. {{$evento->eventosConIdiomas[0]->edicion}} del {{date("d/m/y", strtotime($evento->fecha_in))}} al {{date("d/m/y", strtotime($evento->fecha_fin))}}
	            
	          </small>
	          @endif
          </h2>
          <div class="text-center">
            @if(Auth::check())
                <form role="form" action="/eventos/favorito" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="evento_id" value="{{$evento->id}}" />
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
      <a class="left carousel-control" href="#carousel-main-page" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control" href="#carousel-main-page" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div>
    @endif
    <div id="menu-page">
        <div class="container">
            <ul id="menu-page-list">
                <li>
                    <a href="#informacionGeneral" class="toSection">
						<i class="ionicons ion-information-circled" aria-hidden="true"></i>
						<span class="hidden-xs">Información general</span>
					</a>
                </li>
     <!--           <li>-->
     <!--               <a href="#caracteristicas" class="toSection">-->
					<!--	<i class="ionicons ionicons ion-android-pin" aria-hidden="true"></i>-->
					<!--	<span class="hidden-xs">Ubicación</span>-->
					<!--</a>-->
     <!--           </li>-->
            </ul>
        </div>
    </div>
    
    <section id="informacionGeneral" class="section active">
        <div class="container">
            @if(count($evento->multimediaEventos) > 0)
            <h3 class="title-section">{{$evento->eventosConIdiomas[0]->nombre}}
            @else
            <div class="text-center">
                <h2>{{$evento->eventosConIdiomas[0]->nombre}}
                  @if($evento->eventosConIdiomas[0]->edicion)
                  <small class="btn-block">
    	              Ed. {{$evento->eventosConIdiomas[0]->edicion}} del {{date("d/m/y", strtotime($evento->fecha_in))}} al {{date("d/m/y", strtotime($evento->fecha_fin))}}
    	            
    	          </small>
    	          @endif
              </h2>
            </div>
            @endif
             
            </h3>
            <div class="row">
                <div class="col-xs-12">
                    @if($video_promocional != null)
                    <iframe src="https://www.youtube.com/embed/<?php echo parse_yturl($video_promocional); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;margin-bottom: 1rem;"></iframe>
                    @endif
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
                @endif
                <div class="col-xs-12 col-md-8">

                    <div class="mb-3">{!! $evento->eventosConIdiomas[0]->descripcion !!}</div>

                </div>
                <div class="col-xs-12 col-md-4">
                    <ul class="list">
                        <li>
                            <div class="row align-items-center">
                                <div class="col-xs-2">
                                    <span class="ionicons ion-android-time" aria-hidden="true"></span> <span class="sr-only">Horario</span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <label>Horario</label>
                                        <p class="form-control-static">
                                            Del {{date("d/m/y", strtotime($evento->fecha_in))}} al {{date("d/m/y", strtotime($evento->fecha_fin))}}
                                        </p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </li>
                        <li>
                            <div class="row align-items-center">
                                <div class="col-xs-2">
                                    <span class="ionicons ion-cash" aria-hidden="true"></span> <span class="sr-only">Rango de valores</span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <label>Valor estimado</label>
                                        @if($evento->valor_min == 0 && $evento->valor_max == 0)
                                        <p class="form-control-static">
                                            Sin costo
                                        </p>
                                        @else
                                        <p class="form-control-static">
                                            Desde ${{number_format($evento->valor_min)}} hasta ${{number_format($evento->valor_max)}}
                                        </p>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </li>
                        @if($evento->telefon != null)
                        <li>

                            <div class="row align-items-center">
                                <div class="col-xs-2">
                                    <span class="ionicons ion-android-call" aria-hidden="true"></span> <span class="sr-only">Teléfono</span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <p class="form-control-static">{{$evento->telefono}}</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        @endif
                        @if($evento->web != null)
                        <li>
                            <div class="row align-items-center">
                                <div class="col-xs-2">
                                    <span class="ionicons ion-android-globe" aria-hidden="true"></span> <span class="sr-only">Sitio web</span>
                                </div>
                                <div class="col-xs-10">
                                    <div class="form-group">
                                        <label>Sitio web</label>
                                        <p class="form-control-static">
                                            <a href="{{$evento->web}}" target="_blank" rel="noopener noreferrer">Clic para ir al sitio web</a>
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                        </li>
                        @endif
                        
                    </ul>    
                </div>
            </div>
            
        </div>
        @if(count($evento->sitiosConEventos))
        <div class="container">
            <h2 class="title-section text-uppercase">Sitios que visitar
               
            </h2>
            <div class="tiles">
                @foreach ($evento->sitiosConEventos as $sitio)
                <div class="tile">
                    <div class="tile-body">
                        <div class="tile-caption">
                            <h3>{{$sitio->sitiosConIdiomas[0]->nombre}}</h3>
                        </div>
                    </div>
                    
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>


