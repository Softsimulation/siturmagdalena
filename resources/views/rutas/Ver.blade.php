<?php 
    $ordenMapa = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N" , "O", "P", "Q", "R", "S", "T", "V", "W", "X", "Y", "Z"];
?>


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
        .d-flex{
            display:flex;
        }
        .flex-wrap{
            flex-wrap: wrap;
        }
        .justify-content-center{
            justify-content: center;
        }
        .list-group-flush li:first-child {
            border-top: 0;
        }
        .list-group-flush li:last-child {
            border-bottom: 0;
        }
        .list-group-flush .list-group-item {
            border-right: 0;
            border-left: 0;
            border-radius: 0;
        }
        .badge-red{
            background: red;
            border: 1px solid white;
            box-shadow: 0px 0px 2px 0px rgba(0,0,0,.65);
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
            <div class="col-lg-6" style="padding: 0;">
            <div id="map" style="height: 400px; margin-bottom: .5rem;"></div>
            </div>
            <div class="col-lg-6" style="max-height: 400px; overflow:auto;">
                <ul class="list-group list-group-flush">
                    @foreach ($ruta->rutasConAtracciones as $index => $atraccion)
                    <li class="list-group-item">
                        <div class="media">
                          <div class="media-left">
                            <a href="/atracciones/ver/{{$atraccion->atraccion_id}}">
                              @if(count($atraccion->sitio->multimediaSitios) > 0)
                              <img class="media-object" style="width: 128px;" src="{{$atraccion->sitio->multimediaSitios->first()->ruta}}" alt="Fotografia de {{$atraccion->sitio->sitiosConIdiomas->first()->nombre}}">
                              @else
                              <img src="/img/brand/72.png" alt="" role="presentation">
                              @endif
                            </a>
                          </div>
                          <div class="media-body">
                            <h5 class="media-heading">@if($ordenMapa[$index])<span class="badge badge-red">{{$ordenMapa[$index]}}</span>@endif {{$atraccion->sitio->sitiosConIdiomas->first()->nombre}}</h5>
                            <!-- <p>{{$atraccion->sitio->sitiosConIdiomas->first()->descripcion}}</p> -->
                            <div class="text-right">
                                <a href="/atracciones/ver/{{$atraccion->atraccion_id}}" class="btn btn-sm btn-success"> Ver atracción <span class="sr-only">{{$atraccion->sitio->sitiosConIdiomas->first()->nombre}}</span></a>
                            </div>
                            
                          </div>
                        </div>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- <div class="container mt-3 pt-3 pb-3">
            <p style="white-space: pre-line;">{{$ruta->rutasConIdiomas->first()->descripcion}}</p>
            <p>Las atracciones que contiene esta ruta turística son:</p>
            <div class="d-flex flex-wrap justify-content-center">
                @foreach ($ruta->rutasConAtracciones as $atraccion)
                <div class="card col-md-4 col-xl-3 no-gutters mx-2">
                   
                  @if(count($atraccion->sitio->multimediaSitios) > 0)
                  <img src="{{$atraccion->sitio->multimediaSitios->first()->ruta}}" class="card-img-top" alt="Fotografia de {{$atraccion->sitio->sitiosConIdiomas->first()->nombre}}">
                  @endif
                  <div class="card-body">
                    <h5 class="card-title">{{$atraccion->sitio->sitiosConIdiomas->first()->nombre}}</h5>
                    <a href="/atracciones/ver/{{$atraccion->id}}" class="btn btn-sm btn-success">Ver atracción</a>
                  </div>
                </div>
                
                @endforeach
            </div>
        </div> -->

        
        
        
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
@section('javascript')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&callback=initMap">
</script>
<script>
    function initMap() {
        
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var lat = 9.2700371, long = -74.6345401;
        var rutas = <?php echo $ruta->rutasConAtracciones ?>;
        
      // The location of Uluru
      var pos = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 8, center: pos});
      // The marker, positioned at Uluru
      
      
      if(rutas.length > 0){
          if(rutas.length > 1){
              calculateAndDisplayRoute(directionsService, directionsDisplay, rutas);
          }else{
           //    var marker = new google.maps.Marker({position: pos, map: map});
              
          }
      }else{
          alert("La ruta turística no contiene lugares que mostrar");
      }
      directionsDisplay.setMap(map);
    }
    function calculateAndDisplayRoute(directionsService, directionsDisplay, rutas) {
        var waypts = [];
        
        //var checkboxArray = document.getElementById('waypoints');
        for (var i = 1; i < rutas.length - 1; i++) {
          
            waypts.push({
              location: new google.maps.LatLng(rutas[i].sitio.latitud, rutas[i].sitio.longitud),
              stopover: true
            });
          
        }
        console.log(waypts);
        directionsService.route({
          origin: new google.maps.LatLng(rutas[0].sitio.latitud, rutas[0].sitio.longitud),
          destination: new google.maps.LatLng(rutas[rutas.length - 1].sitio.latitud, rutas[rutas.length - 1].sitio.longitud),
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            // var summaryPanel = document.getElementById('directions-panel');
            // summaryPanel.innerHTML = '';
            // // For each route, display summary information.
            // for (var i = 0; i < route.legs.length; i++) {
            //   var routeSegment = i + 1;
            //   summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
            //       '</b><br>';
            //   summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
            //   summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
            //   summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            // }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
</script>
@endsection