@extends('layout._publicLayout')

@section('title', '')

@section('content')
<section id="slider">
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-main-page" data-slide-to="1"></li>
      </ol>
    
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="{{asset('img/slider/slide1.JPG')}}" alt="" role="presentation">
          <div class="carousel-caption">
            <h2>Transporte terrestre de pasajeros (Bus, buseta, taxi, automóvil) <small>fue el medio de transporte más utilizado para llegar al Magdalena en el 2017</small></h2>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('img/slider/slide2.JPG')}}" alt="" role="presentation">
          <div class="carousel-caption">
            <h2>Vacaciones, recreo y ocio <small>fue el motivo principal de viaje en el 2017</small></h2>
          </div>
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
</section>
<aside id="stats-links">
    <ul>
        <li>
            <a href="#">
                <span class="stats stats-receptor" aria-hidden="true"></span>
                Turismo receptor
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-interno" aria-hidden="true"></span>
                Turismo interno
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-emisor" aria-hidden="true"></span>
                Turismo emisor
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-oferta" aria-hidden="true"></span>
                Oferta turística
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-empleo" aria-hidden="true"></span>
                Impacto en el empleo
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-sostenible" aria-hidden="true"></span>
                Sostenibilidad turística
            </a>
        </li>
        <li>
            <a href="#">
                <span class="stats stats-secundarias" aria-hidden="true"></span>
                Estadísticas secundarias
            </a>
        </li>
    </ul>
</aside>
<div class="title text-center">
    <a href="#">¿Qué es SITUR?</a>
    <div class="container">
        <h2>SITUR Capítulo Magdalena</h2>    
    </div>
    
</div>
<img src="{{asset('img/brand/banner.png')}}" alt="" role="presentation" class="img-responsive">
<div id="introduce" class="container">
    <p>Es el Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H encargado de recopilar datos e información sobre la actividad turística del departamento de Magdalena, Colombia.</p>
    <p>En SITUR Magdalena actualmente se pueden encontrar:</p>
    <ul class="text-center">
        <li>
            <a href="#">
                <span class="big-number">22</span>
                Actividades que puede realizar
            </a>
        </li>
        <li>
            <a href="#">
                <span class="big-number">85</span>
                Experiencias que no se puede perder
            </a>
        </li>
        <li>
            <a href="#">
                <span class="big-number">96</span>
                Proveedores de servicios turísticos
            </a>
        </li>
        <li>
            <a href="#">
                <span class="big-number">44</span>
                Publicaciones realizadas
            </a>
        </li>
    </ul>
</div>
<div id="statsMap">
    <!-- *AQUI VA EL SVG O EL PLUGIN QUE SE HAGA PARA EL MAPA Y SUS INDICADORE -->
    <div style="height: 300px; width: 100%; background-color: #eee;text-align:center;display:flex;align-items: center; justify-content: center;flex-wrap: wrap;">
        <h2 class="btn-block">Aquí va el mapa</h2>
        <p>Remover este div una vez se ubique el mapa.</p>
    </div>
</div>
@endsection
