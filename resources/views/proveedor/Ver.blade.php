<?php
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
        .mb-3{
            margin-bottom: 1rem;
        }
        .mt-0{
            margin-top: 0;
        }
        .m-0{
            margin: 0;
        }
        .pt-3{
            padding-top: 1rem;
        }
        .p-3{
            padding: 1rem;
        }
    </style>
@endsection

@section('meta_og')
<meta property="og:title" content="Conoce {{$proveedor->proveedorRnt->razon_social}} en el departamento del Magdalena" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="{{$proveedor->proveedorRnt->razon_social}}"/>
@endsection

@section('Title','Proveedores')

@section('TitleSection','Proveedores')

@section('content')
@if(count($proveedor->multimediaProveedores) > 0)
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        @for($i = 0; $i < count($proveedor->multimediaProveedores); $i++)
            <li data-target="#carousel-main-page" data-slide-to="{{$i}}" {{  $i === 0 ? 'class=active' : '' }}></li>
        @endfor
      </ol>
    
      <!-- Wrapper for slides -->
        
      
      <div class="carousel-inner">
        @for($i = 0; $i < count($proveedor->multimediaProveedores); $i++)
        <div class="item {{  $i === 0 ? 'active' : '' }}">
          <img src="{{$proveedor->multimediaProveedores[$i]->ruta}}" alt="Imagen de presentación de {{$proveedor->proveedorRnt->razon_social}}">
          
        </div>
        @endfor
        
      </div>
      <div class="carousel-caption">
          <h2>{{$proveedor->proveedorRnt->razon_social}}
              <small class="btn-block">
	              <span class="{{ ($proveedor->calificacion_legusto > 0.0) ? (($proveedor->calificacion_legusto <= 0.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($proveedor->calificacion_legusto > 1.0) ? (($proveedor->calificacion_legusto <= 1.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($proveedor->calificacion_legusto > 2.0) ? (($proveedor->calificacion_legusto <= 2.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($proveedor->calificacion_legusto > 3.0) ? (($proveedor->calificacion_legusto <= 3.9) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="{{ ($proveedor->calificacion_legusto > 4.0) ? (($proveedor->calificacion_legusto <= 5.0) ? 'mdi mdi-star-half' : 'mdi mdi-star') : 'mdi mdi-star-outline'}}" aria-hidden="true"></span>
	              <span class="sr-only">Posee una calificación de {{$proveedor->calificacion_legusto}}</span>
	            
	          </small>
          </h2>
          <div class="text-center">
            @if(Auth::check())
                <form role="form" action="/proveedor/favorito" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="actividad_id" value="{{$proveedor->id}}" />
                    <button type="submit" class="btn btn-lg btn-circled btn-favorite m-0">
                      <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                    </button>    
                </form>
            @else
                <a role="button" class="btn btn-lg btn-circled m-0" title="Marcar como favorito" href="/login/login">
                  <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                </a>
            @endif
          </div>
      </div>
      <a class="left carousel-control" href="#carousel-main-page" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="right carousel-control" href="#carousel-main-page" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>
    </div>
    @else
    
    <div id="title-with-image" class="text-center p-3">
        <img src="/img/hotel.png" alt="" role="presentation">
        <h2 class="mt-0" style="color: #004A87">{{$proveedor->proveedorRnt->razon_social}}</h2>
        <div class="text-center">
        @if(Auth::check())
            <form role="form" action="/proveedor/favorito" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="actividad_id" value="{{$proveedor->id}}" />
                <button type="submit" class="btn btn-lg btn-circled btn-favorite m-0">
                  <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
                </button>    
            </form>
        @else
            <a role="button" class="btn btn-lg btn-circled m-0" title="Marcar como favorito" href="/login/login">
              <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
            </a>
        @endif
      </div>
    </div>
    
    
    @endif
    <div id="menu-page">
        <div class="container">
            <ul id="menu-page-list" class="justify-content-center">
                @if(count($proveedor->proveedorRnt->idiomas) > 0)
                <li>
                    <a href="#informacionGeneral" class="toSection">
						<i class="ionicons ion-information-circled" aria-hidden="true"></i>
						<span class="hidden-xs">Información general</span>
					</a>
                </li>
                @endif
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
    <section id="informacionGeneral" class="section @if(count($proveedor->proveedorRnt->idiomas) > 0) active @endif">
        @if(count($proveedor->multimediaProveedores) > 0)
        <h3 class="title-section">{{$proveedor->proveedorRnt->razon_social}}</h3>
        @endif
        @if($video_promocional != null)
        <iframe src="https://www.youtube.com/embed/{{print(parse_yturl($video_promocional))}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 350px;margin-bottom: 1rem;"></iframe>
        @endif
        @if(count($proveedor->proveedorRnt->idiomas) > 0)
        <div class="container">
            <div style="white-space: pre-line;">{!! $proveedor->proveedorRnt->idiomas->first()->descripcion !!}</div>
        </div>
        @endif
    </section>
    <section id="caracteristicas" class="section @if(count($proveedor->proveedorRnt->idiomas) == 0) active @endif">
        <div class="container">
            <h3 class="title-section">Ubicación</h3>
            <div class="row">
                <div class="col-md-8">
                    <div id="map"></div>
                </div>
                <div class="col-md-4">
                    <p class="text-muted">Más información</p>
                    <ul class="list-group">
                      @if($proveedor->proveedorRnt->direccion)
                      <li class="list-group-item">
                          <label class="d-block">Dirección</label>
                          {{$proveedor->proveedorRnt->direccion}}
                      </li>
                      @endif
                      @if($proveedor->proveedorRnt->email)
                      <li class="list-group-item">
                          <label class="d-block">Correo electrónico</label>
                          <a href="mailto:{{$proveedor->proveedorRnt->email}}" title="{{$proveedor->proveedorRnt->email}}" target="_blank">Ver email</a>
                      </li>
                      @endif
                    </ul>
                </div>
            </div>
        </div>
            <!--<p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam porttitor, augue quis tempus dictum, augue dui molestie sem, vitae molestie augue ipsum id turpis. Fusce feugiat vestibulum ante. Sed a consequat eros, finibus luctus nisl. In ut diam congue, condimentum sem vel, sagittis dolor. Nunc ut vestibulum ex, vitae eleifend metus. Proin id ex eu erat aliquet egestas. Fusce id suscipit velit, ut sodales turpis. Aliquam turpis risus, luctus vitae lobortis finibus, condimentum in felis. Pellentesque vel erat tellus. Suspendisse potenti. Integer porta sed lorem ac iaculis. Pellentesque pretium ex et convallis condimentum. In luctus leo nulla, eu finibus justo volutpat quis.</p>-->
            <!--<div class="row" style="margin: 0;">-->
            <!--    <div class="col-xs-12">-->
            <!--        <div id="map"></div>-->
            <!--    </div>-->
                
            <!--</div>-->
        
    </section>
    <section id="comentarios" class="section">
        
    </section>
<!--{{$proveedor}}-->
<!--{{$video_promocional}}-->
    
@endsection
@section('javascript')
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&callback=initMap">
</script>
<script>
    // Initialize and add the map
    function initMap() {
        var lat = parseFloat("<?php print($proveedor->proveedorRnt->latitud); ?>"), long = parseFloat("<?php print($proveedor->proveedorRnt->longitud); ?>");
      // The location of Uluru
      var uluru = {lat: lat, lng: long};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 8, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});
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
