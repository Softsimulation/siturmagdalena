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
                <!--<button type="button" class="btn btn-lg btn-circled" title="Marcar como favorito" data-toggle="modal" data-target="#modalIniciarSesion">-->
                <!--  <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>-->
                <!--</button>-->
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
    <section id="caracteristicas" class="section">
        <div class="container">
            <h3 class="title-section">Ubicación</h3>
        </div>
            <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>-->
            <div class="row" style="margin: 0;">
                <div class="col-xs-12">
                    <div id="map"></div>
                </div>
                
            </div>
        
    </section>

    
@endsection
@section('javascript')
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNCXa64urvn7WPRdFSW29prR-SpZIHZPs&callback=initMap">
</script>
<script>
    
    function initMap() {
          var sitiosConActividades = <?php print($actividad->sitiosConActividades); ?>;
          console.log(sitiosConActividades);
          var lat = 10.1287919, long = -75.366555;
          var posInit = {lat: lat, lng: long};
          // Initialize and add the map
          var map = new google.maps.Map(
              document.getElementById('map'), {zoom: 8, center: posInit});
          for (i = 0; i < sitiosConActividades.length; i++) { 
              var pos = {lat: parseFloat(sitiosConActividades[i].latitud), lng: parseFloat(sitiosConActividades[i].longitud)};
              var marker = new google.maps.Marker({position: pos, map: map});
          }
            
        }
        function changeViewList(obj, idList, view){
            var element, name, arr;
            element = document.getElementById(idList);
            name = view;
            element.className = "tiles " + name;
        } 
        function showStars(input){
            //var checksFacilLlegar = document.getElementsByName(input.name);
            $("input[name='" + input.name + "']+label>.ionicons-inline").removeClass('ion-android-star');
            $("input[name='" + input.name + "']+label>.ionicons-inline").addClass('ion-android-star-outline');
            for(var i = 0; i < parseInt(input.value); i++){
                $("label[for='" + input.name + "-" + (i+1) + "'] .ionicons-inline").removeClass('ion-android-star-outline');
                $("label[for='" + input.name + "-" + (i+1) + "'] .ionicons-inline").addClass('ion-android-star');
                //console.log(checksFacilLlegar[i].value);
            }
        }
        
</script>
<script>
    $(document).ready(function(){
        $('#modalComentario').on('hidden.bs.modal', function (e) {
            $(this).find('form')[0].reset();
            $(this).find('.checks .ionicons-inline').removeClass('ion-android-star');
            $(this).find('.checks .ionicons-inline').addClass('ion-android-star-outline');
        })
    });
    $('.toSection').on('click', function(e){
       $('.section').removeClass('active');
       $($(this).attr('href')).addClass('active');
    });
</script>
@endsection