@extends('layout._publicLayout')

@section('title', '')

@section('estilos')

<link href="{{asset('/css/public/main.css')}}" rel="stylesheet">
<style>
    #layer9 path:hover {
        fill: blue!important;
        cursor: pointer;
    }
</style>
@endsection
@section('meta_og')
    <meta property="og:title" content="SITUR Magdalena" />
    <meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
    <meta property="og:description" content="Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H"/>
@endsection

@section('content')
<section id="slider">
    <div id="carousel-main-page" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-main-page" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-main-page" data-slide-to="1"></li>
        <li data-target="#carousel-main-page" data-slide-to="2"></li>
      </ol>
    
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="{{asset('img/slider/slide1.jpg')}}" alt="" role="presentation">
          <div class="carousel-caption">
            <h2>Transporte terrestre de pasajeros (Bus, buseta, taxi, automóvil) <small>fue el medio de transporte más utilizado para llegar al Magdalena en el 2017</small></h2>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('img/slider/slide2.jpg')}}" alt="" role="presentation">
          <div class="carousel-caption">
            <h2>Vacaciones, recreo y ocio <small>fue el motivo principal de viaje en el 2017</small></h2>
          </div>
        </div>
        <div class="item">
          <img src="{{asset('img/slider/slide3.jpg')}}" alt="" role="presentation">
          <div class="carousel-caption">
            <h2>Hotel <small>fue el tipo de alojamiento más utilizado en el 2017</small></h2>
          </div>
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
</section>
<aside id="stats-links">
    <ul>
        <li>
            <a href="/indicadores/receptor">
                <span class="stats stats-receptor" aria-hidden="true"></span>
                Turismo receptor
            </a>
        </li>
        <li>
            <a href="/indicadores/interno">
                <span class="stats stats-interno" aria-hidden="true"></span>
                Turismo interno
            </a>
        </li>
        <li>
            <a href="/indicadores/emisor">
                <span class="stats stats-emisor" aria-hidden="true"></span>
                Turismo emisor
            </a>
        </li>
        <li>
            <a href="/indicadores/oferta">
                <span class="stats stats-oferta" aria-hidden="true"></span>
                Oferta turística
            </a>
        </li>
        <li>
            <a href="/indicadores/empleo">
                <span class="stats stats-empleo" aria-hidden="true"></span>
                Impacto en el empleo
            </a>
        </li>
        <li>
            <a href="/indicadores/sostenibilidad">
                <span class="stats stats-sostenible" aria-hidden="true"></span>
                Sostenibilidad turística
            </a>
        </li>
        <li>
            <a href="/indicadores/secundarios">
                <span class="stats stats-secundarias" aria-hidden="true"></span>
                Estadísticas secundarias
            </a>
        </li>
    </ul>
</aside>
<div id="tituloSitur" class="text-center">
    <a href="#">¿Qué es SITUR?</a>
    <div class="title">
        <div class="container">
            <h2>SITUR Capítulo Magdalena</h2>    
        </div>
    </div>
    
    
</div>
<img src="{{asset('img/brand/banner.png')}}" alt="" role="presentation" class="img-responsive">
<div id="introduce" class="container">
    <p>Es el Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H encargado de recopilar datos e información sobre la actividad turística del departamento de Magdalena, Colombia.</p>
    <p>En SITUR Magdalena actualmente se pueden encontrar:</p>
    <ul id="elementosSitur" class="text-center">
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
    
    <div style="width: 100%; background-color: #eee;text-align:center;display:flex;align-items: center; justify-content: center;flex-wrap: wrap;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <svg
                       xmlns:dc="http://purl.org/dc/elements/1.1/"
                       xmlns:cc="http://creativecommons.org/ns#"
                       xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                       xmlns:svg="http://www.w3.org/2000/svg"
                       xmlns="http://www.w3.org/2000/svg"
                       xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                       xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                       version="1.1"
                       id="svg2"
                       sodipodi:docname="Mapa del Mgdalena2.svg"
                       inkscape:version="0.92.1 r15371"
                       x="0px"
                       y="0px"
                       viewBox="-191 -348.2 895.5 1496.2"
                       xml:space="preserve"
                       width="450"
                       height="370"><metadata
                         id="metadata81"><rdf:RDF><cc:Work
                             rdf:about=""><dc:format>image/svg+xml</dc:format><dc:type
                               rdf:resource="http://purl.org/dc/dcmitype/StillImage" /><dc:title /></cc:Work></rdf:RDF></metadata><defs
                         id="defs79" /><style
                         type="text/css"
                         id="style10">
                    	.st0{fill:#FFD28B;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;}
                    	.st1{fill:#FFC8C8;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;}
                    	.st2{fill:#BEBAD7;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;}
                    	.st3{fill:#FFFD99;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;}
                    	.st4{fill:#AFF2AD;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;}
                    	.st5{fill:none;stroke:#646464;stroke-width:2;stroke-linejoin:round;}
                    	.st6{display:none;}
                    	.st7{display:inline;fill:#323232;fill-opacity:0.3922;}
                    </style><sodipodi:namedview
                         fit-margin-bottom="0"
                         fit-margin-right="0"
                         showguides="true"
                         fit-margin-left="0"
                         fit-margin-top="0"
                         showgrid="false"
                         borderopacity="1.0"
                         bordercolor="#666666"
                         pagecolor="#ffffff"
                         id="base" /><g
                         id="layer9"
                         transform="translate(-2196.3206,-270.19498)"
                       ><path  data-toggle="tooltip" title="Santa Bárbara de Pinto" onclick="cambiar(25,'path5020')"
                           id="path5020"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st0"
                           d="m 2511.1,1072.5 -3,2.2 -4.2,0.5 -3.6,-2.1 -2.6,2.1 -4.2,4.4 -2.9,0.3 -1.8,-0.5 -2.3,-0.8 -5.7,3.1 -0.5,4.2 -4.2,-0.8 -4.2,3.1 -0.3,2.9 -5.7,2.3 -3.4,-0.8 -2.1,3.6 v 3.4 l -7.3,3.9 -3.4,-1.6 -1.6,6.8 -6.5,10.1 -6.7,3.4 -4.7,9.6 1.8,1 -4.4,10.4 -2.9,-1.6 -2.9,6 1.6,6 -7.8,4.2 -3.4,0.3 0.8,6 -2.3,0.5 h -4.2 l -1.6,-0.5 -3.4,1 -1,2.3 h -1.6 l -2.9,-1.6 -14.5,-1 -0.3,-2.3 -4.2,4.2 -4.2,-2.1 h -2.9 -5.4 l -3.9,3.9 -7.3,4.7 -2.1,-2.9 -3.9,1 -13.7,0.5 -1.6,3.4 -8.8,-1.8 -8.3,7.3 0.1,2.4 h -2.8 l 0.2,-33.6 2.4,-1.3 1.3,-20.2 8.3,-0.2 0.9,2.8 2,1.3 2.4,-2.6 0.4,1.1 3.7,-0.2 1.1,2 h 3.5 l 3.5,-2.2 1.5,-4 6.4,-2.6 9.2,-3.5 3.1,-7.5 2.2,-4.2 19.1,-1.3 2.9,3.5 3.1,1.3 4,-0.7 1.8,1.7 v 3.9 l 6.4,2.2 10.1,-2.9 7,-3.3 2.4,1.1 0.9,-5.3 -1.1,-2.2 h 1.1 5.1 l 5.7,-5.9 1.1,-16.5 -2.4,-3.5 -0.9,-3.3 2.2,-1.8 -0.7,-8.6 -3.7,-2 -0.7,-5.5 3.1,-0.7 3.3,-4.8 h 7 l 0.6,2.4 4.4,1.3 3.5,2.8 0.4,-1.8 2.6,-1.8 0.7,-3.3 7,-5.1 1.5,-2.9 5.3,-4.6 4.8,-1.1 -0.6,-2.2 3.5,-3.7 5.1,-1.5 1.5,-4.6 5.1,-1.7 6.2,1.1 2.9,2.9 1.5,-0.6 1.8,-3.9 2.2,-0.7 3.7,-0.6 v -6.8 l 2.6,-1.8 2,2.4 6.8,0.2 13,-6.2 -2,-2.4 9.7,-8.1 0.2,-3.7 8.4,-5.3 -0.2,-2.4 0.7,-2 9.2,0.9 2.6,-2.2 5.1,-1.5 -1.5,-2 v -2.2 l 0.7,-1.8 0.6,-7 -1.3,-2.8 0.9,-2.8 2.8,0.9 16,-2 1.3,-1.7 6.6,0.9 2.6,3.5 5.9,0.9 3.1,-2.8 -1.1,-1.3 0.4,-1.8 0.2,-2.2 2.6,-2.9 3.9,-0.7 -1.5,-14.5 2.4,-1.8 -0.4,-2.2 3.9,-1.7 2.4,3.9 1.7,-2.2 6.2,-0.6 -0.2,-7 4.2,-0.4 0.7,-1.3 5,-0.2 0.4,7.9 h 2.9 l 0.4,1.5 -4.8,6.2 0.4,0.7 5,-0.4 3.7,1.7 0.9,6.4 -1.1,3.3 1.1,1.1 1.5,11.2 4.8,2.6 3.7,-3.5 13,-1.5 2.9,4.2 4,0.7 3.7,-2.8 1.7,-2.8 2.4,0.2 10.6,-2 2,-0.9 h 4.6 l 2.4,-2.2 -1.5,-1.1 v -2.2 l 2.8,1.5 1.5,-1.7 2.9,-0.2 4.5,3.2 0.3,2.5 3.4,4.6 -2.2,6.5 2.2,2.6 -0.5,5 1.9,4 -4.4,3.3 -24.4,13.2 -8.8,5.3 -2.5,-0.9 -2,1.8 -1.6,-0.1 -1.2,-3.8 -1.2,-3.1 -2,-0.8 -3.5,0.2 -2.6,-0.4 -0.8,2 -1.8,1.8 -2.6,-0.4 -0.2,3.7 -3.1,-0.3 -6.7,-1.8 -2.9,2.8 -3.3,0.4 -2.9,1.4 -1.6,-1.6 h -1.5 l -0.2,3.5 -2.5,0.4 -2.6,1.8 -1,-1 -1.4,1 h -1.4 l -0.8,-1 -3.5,1.4 -1.6,2.4 h -1.8 l -4.7,-1.9 -3.3,2.3 -2.3,4.2 -5.8,-1.6 0.7,-5.8 -3,-2.8 -5.5,-0.7 -1.7,3.5 -12.9,-0.4 -4.9,2.9 -5.4,6.7 -0.3,4.6 -4.6,1.7 -2.4,-2.4 -4.7,4.2 -0.7,3 -3.7,1.3 -0.3,3.7 -5.2,4.3 -5.8,4.6 -1.8,7 -6,6.4 -5.3,3.1 -7.1,4.7 -2.6,3 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(22,'path5009')"
                           id="path5009"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st1"
                           d="m 2693.4,923.7 3.9,-4.5 1,-3.1 -2.4,-3.5 -1.1,-3.2 -2.2,-10.8 -1.2,-4.7 -1.8,-0.3 -0.3,-4.1 -4.1,-0.3 -1.6,-4.2 -4.9,-0.8 -2,-1.4 -1.2,-2.9 -3.3,0.2 -3.7,-2 -1.4,-2 -2,-5.1 -4.5,-1.8 -4,-1.4 0.3,-5.4 -3.4,-3.3 -1.4,-3.5 1.1,-2.9 -4.6,-3 -1,-4.1 -3.5,-2 -1,-1.6 0.2,-2.9 -2.6,-3.7 -3.3,-2.2 -1,-2.4 -0.4,-3.3 -4.3,-3.3 -4.7,-2.7 -1.4,-4.9 -4.3,-5.9 -3.2,-1.3 -2.8,1.1 -6.6,-3.5 -3.5,2.5 -3.4,0.8 -2.2,-3.7 -4.3,-3 -1.2,-2.2 -0.8,-4.3 -2.4,-10.2 -4.5,-3.7 -4.7,-1.6 -3.3,-7.7 -3.1,-3.7 -2.1,1.6 h -6.7 l -4.9,8.8 -6.5,-5.5 -4.2,1.8 -7.5,-0.5 -5.7,3.6 1.6,2.3 -3.4,6.8 -13,0.8 -4.7,3.4 -2.1,3.1 -3.1,0.3 -5.2,-4.7 -3.4,-1.8 0.3,-1.6 2.9,-2.6 -1,-1.8 -4.4,-0.5 -6.2,-4.2 -7,1.8 -1.6,-2.9 0.5,-2.9 -2.6,-1.6 -4.4,3.1 -2.3,-2.3 h -5.2 l -4.2,2.9 -1.6,-0.3 -7.3,3.1 -1,2.1 -4.4,1 -6.5,6 -1.3,12.2 -4.9,6.5 0.3,2.3 2.1,1.8 -3.6,4.9 1.6,1 v 5.2 l 1.3,1.8 -1.6,2.1 0.8,2.6 -2.6,1.6 -1.3,8.2 v 3 l -2.9,1.6 1.6,2.1 -0.5,7 -2.3,3.4 2.3,0.8 3.6,9.1 -0.3,7 -3.6,2.1 -2.1,6 -2.6,3.6 3.1,1.3 -0.8,4.7 4.2,7.3 -2.3,3.1 4.2,5.5 4.9,1.8 2.6,2.6 8.8,0.3 3.1,2.6 -0.3,1.8 2.1,4.4 -1,2.9 0.5,5.2 4.7,1.3 3.1,-0.8 0.3,-3.9 1.3,-0.5 5.7,2.9 v 4.7 l 5.2,0.5 2.9,4.7 -2.6,2.6 0.3,2.9 1.6,9.4 9.1,7.8 h 2.1 l 1.6,2.3 -0.3,3.1 2.6,1.6 -0.5,4.7 -3.9,6.2 0.3,3.6 -2.6,2.9 -0.3,3.6 -2.6,2.9 2.6,1.8 -2.3,6.5 0.7,2.3 2.6,-1.5 -0.3,-2.3 2.3,-3.1 3.4,0.5 3.4,-2.3 0.8,-10.7 3.4,-4.4 9.1,-3.9 3.6,-3.6 h 6.5 l 7,-7.5 h 3.9 l 1.3,-3.1 -1.8,-1.3 3.1,-4.4 0.3,-2.9 h 2.6 l 4.7,-4.4 0.3,-1.8 2.6,-0.8 2.3,1 5.2,-0.5 10.6,-8.6 5.2,-1 7,-7.5 6.5,-2.9 c 0,0 4.2,1.6 7,0.3 2.8,-1.3 3.6,-1.6 3.6,-1.6 l 3.1,1.8 5.2,-4.9 10.9,1.8 -0.8,-4.2 2.9,-0.3 5.7,2.1 0.8,2.6 h 3.4 l 8.8,2.9 1.8,-1.6 2.3,1.6 5.2,-2.1 4.4,1.8 2.6,-1.8 2.9,0.5 0.3,4.9 h 5.2 l 1.6,4.9 2.1,-3.4 h 2.1 l 5.2,2.1 h 4.2 l 4.2,1.6 1.6,-3.6 4.2,-1.3 -2.3,-2.6 1.6,-1 8.4,0.2 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(3,'path4218')"
                           id="path4218"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st2"
                           d="m 2799.5,270.7 -5.5,0.2 -11.6,-4.6 c 0,0 -1.1,1.1 -1.7,1.8 -0.6,0.7 -8.1,-1.3 -8.1,-1.3 l -7.9,-12.7 -15.2,-4 -3.7,-7.2 -6.2,0.4 -2.9,2.1 -5,5.1 -3.1,0.2 -2.4,2.8 -6.1,0.4 -0.9,-0.6 -7.8,5.8 -4,3.5 -3.9,5.7 v 4.5 l -1.8,3.1 -2.9,1.8 -1,2.2 0.4,4.5 -2.2,2.7 -8.3,3.3 -7.1,5.5 -4.5,2 -1,3.9 v 1 l -2.9,4.7 -5.7,2.2 -3.5,2 -4.9,4.9 -4.1,2 -7.1,5.5 -3.3,0.6 -2.2,-0.6 -3.7,0.2 -5.5,3.5 -2.9,1.2 0.6,2.7 -1.8,2 -1,-0.2 -2.2,-2.7 -2,2.4 -1,3.5 -2.6,2.7 -2,-0.8 -2.6,0.4 0.2,0.6 3.3,0.8 -1.4,2.4 -2.9,-0.8 -2.2,-0.6 -4.9,1.4 -3.1,0.8 -2.2,2.7 -6.3,5.1 -5.3,2.7 -5.3,1.6 -2.6,3.3 -5.9,3.3 -2.2,-0.2 -1,-0.8 -0.8,1 -0.2,2 -1.4,3.1 -1.8,1.6 -4.9,4.1 -8.1,2.9 h -3.1 l -4.1,3.1 -3.9,3.3 -0.2,4.9 -1.4,2.9 0.4,3.7 -1.8,5.9 -3.9,1.8 -2.2,2.9 -0.4,1.6 -3.7,-0.2 -2.9,-2.7 -2.4,-1.2 -1.4,-3.1 0.2,-2 -1.8,-5.3 -2,0.2 -1,1.6 -4.3,0.2 -1.8,1 -1.6,-2 v -2.2 l -1,-1.2 -2.2,-0.4 -2.2,1 -3.7,-0.2 -2.7,0.6 -0.3,0.9 -4.3,0.4 -2.4,-1.8 -2,-2.9 -2,-1.2 -2.4,0.2 h -1.2 l -1.6,-1.8 -1,-3.7 -1.6,-2.2 -3.5,-2 -4.7,-2.2 h -1.4 l -4.3,-0.1 -1.8,-0.5 h -3.3 l 0.2,1.8 -0.6,0.8 -1.6,-1.2 h -0.8 l -2,-3.1 -4.9,-1 -1.4,0.2 -2,-2.9 h -2.9 l -1.8,-0.4 -1.6,0.6 -2.2,-0.6 2.4,5.1 2.6,0.9 1.8,7.9 -1.5,1.8 1.3,5.1 2.4,1.1 14.9,20.9 5.7,-1.3 4,2.4 2,-1.1 2,0.2 -0.6,5.7 5.1,1.3 0.4,2.8 -1.7,3.9 0.2,4.4 5,11 -3.5,0.4 -4,0.6 h -6.2 l 1.1,3.9 -3.3,1.7 -3.7,3.1 1.5,1.9 11.5,3.7 4.9,0.3 3.5,4 -0.6,1.7 2.3,1.4 0.3,2.9 3.2,1.2 0.3,-1.7 2,-1.4 2.3,-2.3 1.7,1.4 2.9,2 2.9,4.6 h 2 l 2.3,0.9 1.2,-0.6 0.6,-3.2 1.4,-1.2 1.7,1.2 -0.3,2.9 -0.6,2 0.6,0.6 2.9,0.3 1.4,2.3 -4.3,2.6 -1.4,2 2,2.9 3.5,-0.6 1.2,-2 h 1.4 v 2.3 l 0.9,1.7 2.9,-1.4 0.9,1.7 2.9,2.3 3.5,2.3 h 4.6 l 2,0.6 3.5,2.3 1.7,3.2 -0.6,4 1.7,6.1 1.7,2.3 1.7,2.6 1.7,-0.6 0.3,-2.9 2.3,-1.7 2.5,3.5 5.5,1.2 h 3.5 l 3.5,5.5 2,-0.8 2,-1.2 1.4,0.8 4.5,0.4 2.4,-2.7 10,-5.3 14.7,-4.3 1.6,-1.4 3.9,-11.8 2.4,-2.7 2.6,-6.7 c 0,0 3.5,-1 4.1,-1.8 0.6,-0.8 3.1,-2.2 3.1,-2.2 l 1.6,0.8 3.3,3.9 1,0.2 1.4,-1 6.1,-0.8 6.7,-5.1 4.3,-4.3 V 461 l 1.6,-1.4 2.2,0.4 3.1,0.2 5.7,4.1 2.6,-0.2 0.6,-1 h 5.3 l 4.5,0.8 1.8,2 h 2.2 l 1,-1.4 V 461 l 0.8,-0.6 3.3,0.8 7.3,1.2 4.3,-1.4 3.9,-3.9 3.3,-2.4 5.9,-1.2 0.2,-2.4 1.8,-0.8 2,1.4 1.8,0.6 h 2.4 l 0.4,-0.8 4.7,-5.1 1.8,-1 1.6,-3.1 0.6,-1.8 2.2,0.6 5.3,-1.4 4.9,0.4 2.6,-4.3 2.6,-2.9 5.1,-1.4 2,-0.6 1,-2.9 3.5,-1.2 3.7,-0.2 3.3,1.4 1.8,2.2 2.2,0.2 1.2,-3.1 0.6,-4.1 3.3,-2 c 0,0 0.4,-1.2 1.4,-1 1,0.2 2.4,0.4 2.4,0.4 l 2,-1 0.4,-1.8 2.4,-2 4.5,-1 4.3,-3.8 6.5,-2.3 V 405 l 4,0.6 5,-4.2 1.1,-3.5 -2.2,-1.8 -0.7,-4.2 -2.8,-2.4 1.3,-2.4 h 10.6 l 2.9,-1.1 1.8,-2.4 6.1,-1.3 3.2,0.4 0.6,-2.2 3,-3.7 -2.1,-9.5 4.1,-1.7 0.9,-4 4.9,-2.4 -1.9,-9.9 5,-3.5 4.3,-0.3 0.1,-6.3 3.1,0.4 2.3,3.8 7.8,-3.1 -2.5,-3.3 -0.5,-3.1 5.5,-3.2 -1.6,-4.4 v -3.1 l 3.4,0.2 7.5,-5.7 -5.6,-4.2 -7,0.7 -0.2,-2.9 -3.3,-3.3 -5.4,0.8 -3.4,-6.1 -6,-1.3 -6.9,-0.1 -0.6,-4.5 -5.2,1.7 -4.6,-0.3 -3.1,-2.2 -3.7,2.5 -2.8,-1.3 3.8,-5.1 -3.9,-3.4 2.3,-4 2.8,-1.7 1.9,-3.1 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(0,'path5103')"
                           id="path5103"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccccccccsccccccccccscccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2829.8,270.2 2.3,-3.2 -5.4,-11.8 -0.5,-6.6 -2.1,-3.5 1.3,-4 -6.3,-3.7 -6.2,-9.8 v -9.1 l -3.2,-4.3 2.7,-12.4 -3.8,-3.8 1.6,-6.5 -8.6,-10.2 -5.9,-3.8 4.3,-8.6 -0.5,-8.1 4.5,-1.3 0.3,-3 -2.6,-2.3 -0.1,-3.6 8.1,-7 1.6,-5.4 -6.1,-1.3 1.2,-2.7 -2.6,-1.9 4.5,-5 -4.8,-2.7 4.3,-2.2 -2.2,-2.7 -3.2,-1.6 3.2,-2.2 v -5.4 l 4.5,-2.8 1,-4.7 -3.7,-2.5 0.2,-4.6 -4.1,-0.7 -1.8,-1.7 2.4,-1.9 -2,-2 0.3,-2.8 4,-0.1 -0.5,-2.8 2.3,-1.5 3.7,2 3.4,-2.9 6.4,-2.9 1.8,-9.2 3.5,0.2 1.8,-4.4 6.6,-3.7 3.3,0.9 3.5,-2.6 -2.4,-3.7 0.9,-2 2.6,-0.9 1.3,-9.2 -1.8,-4 v -2 l 4.4,-0.2 -2.7,-2.7 2.9,-1.1 1.4,-1.5 -1.1,-2.1 4,-0.9 2,-9.2 -2.9,-3.7 -0.7,-3.7 -9.1,0.4 -2,-1.1 -8.7,1.5 -5.6,2 -7.2,0.2 -5.6,2.2 -3.9,-1.1 -10.2,2 -3,1.3 h -2.4 l -2,-2.2 -9.3,-2.4 -2.8,-1.3 -2.8,1.3 -1.1,1.5 -1.7,-0.7 -2.8,2 h -2.2 l -6.8,-0.9 -1.1,-1.6 -11.3,-2.6 -9.1,-3.3 -4.4,0.5 -5.1,5.9 -8.6,0.4 -9.3,-2.7 -12.8,-3.3 -11,-3.7 h -9 l -2.6,-3.5 -7.3,-3.7 -9,-7.5 -4.6,-3.5 -5.7,-0.4 -3.3,-1.1 -2.4,-2 -6.6,-1.6 -1.5,-1.3 h -2.4 l -2.2,-1.5 -6.2,-0.2 -2.6,-1.6 0.5,-2 -1.8,-2.6 -1.1,1.5 -1.5,-1.6 -0.2,-2.4 h -2.7 l -0.7,-1.5 -2.4,-0.5 -0.7,1.1 -2.6,-2.2 1.6,-1.1 -1.6,-1.8 h -6 l -1.3,2 -2.7,-3.5 -5.7,0.4 -2.6,-1.5 -2.2,2.2 -1.5,-2.9 -3.3,1.1 -2.7,-0.4 -0.5,-2 h -2.4 l -1.8,1.1 0.2,1.8 -2.6,0.2 -0.4,2 -1.1,-0.7 -2.7,-2 0.5,-2.6 -1.3,-1.5 -2.2,0.9 -3.7,1.5 -1.1,2.4 1.3,2.7 1.8,1.5 -1.8,3.5 -2,0.5 -1.6,-0.7 -2.7,0.2 v -1.8 l 2.4,-0.5 -2.2,-2.9 -1.6,-0.7 0.5,-2 1.3,-1.8 -2,0.2 -1.3,2.9 -3.3,-0.9 -1.3,-1.5 -0.4,2.2 -0.9,3.7 -1.6,0.7 2.9,3.5 -0.9,2.6 0.4,2 -1.3,2.7 -3.5,-1.1 0.9,-2.6 -1.6,1.3 -1,-1.4 -2.6,2.2 -2.2,-1.5 -1.6,-3.3 1.5,-2.9 1.3,-1.3 -1.3,-3.7 -1.3,1.3 -2.2,-1.1 -1.5,-1.1 -0.4,-3.5 -0.7,-1.3 -3.1,2.6 v 1.8 l 2.4,4.2 -0.2,1.8 2.4,2 0.9,2.4 -1.5,1.6 -1.3,2.2 -2,-0.9 0.9,-1.6 -0.5,-1.3 -2.7,0.2 -1.6,-2 1.5,-1.3 -4,-1.6 -0.7,-1.8 -2.5,0.9 v 1.8 l 0.5,1.1 -1.3,2.6 2.4,2.4 -2,1.3 -1.8,-0.4 -1.1,0.9 h -1.8 l 0.9,-1.8 v -3.7 l -2.2,1.1 -3.1,-1.5 2.4,-2.4 v -2 l -4.2,-1.3 v 2.2 l -2.7,0.7 -0.5,4 -2.7,1.1 -2.6,-1.6 -1.1,1.1 4.6,5.9 1.1,3.5 3.1,2 v 1.6 l 1.5,1.5 -4.4,1.9 -2.2,-0.2 -1.1,-1.8 h -1.5 l -1.3,3.5 -2.9,-0.7 -0.4,-4 1.8,-1.8 -3.1,-0.4 -1.5,-0.7 -1.3,1.1 -1.3,0.9 -1.8,-0.5 -1.6,1.1 -0.9,2.4 -1.8,-0.4 v -1.6 l -2.2,-0.9 -1.3,0.4 0.4,3.1 1.8,1.3 -1.1,2.4 -1.8,3.8 -1.3,2 -0.2,1.8 -1.3,0.2 -0.9,1.8 -2.4,0.4 v 2.7 l 3.7,0.4 1.5,-0.7 0.4,2.4 3.1,0.2 0.2,1.8 -2,0.5 -2.6,0.9 -1.3,1.8 -6,2 -3.3,-0.7 -2.6,2.6 0.7,1.3 2.4,-1.6 1.1,0.9 -1.3,1.6 0.9,1.1 v 3.1 l -3.5,4.4 -2.2,1.5 -0.4,1.5 h -3.1 l -2,1.5 -1.5,3.1 h -1.5 l -1.1,0.5 2.6,2.7 1.5,0.7 v 2.2 l -1.1,1.3 2.7,0.5 1.1,4.4 -2.2,8.8 -3.8,2.9 v 2 l -1.5,1.1 1.1,1.8 2.6,1.6 2.4,9.1 2.2,7.7 -2.7,5.7 -1.3,4.8 0.5,2.7 -1.3,2.2 v 1.1 l 2.2,0.5 v 2.7 l 1.5,2.4 3.1,0.9 2,4.9 1.1,5.7 -0.9,4.6 1.7,3.4 4,-2.2 2.1,-3.6 3.1,1.3 8.3,-6.5 3.6,-3.4 h 4.2 l 1.3,1.6 9.1,-1.8 c 0,0 5.4,0 7,0 1.6,0 3.4,2.3 3.4,2.3 l 3.9,-3.9 1.3,-0.3 4.9,-2.1 3.6,2.1 3.1,-0.3 -2.1,4.7 2.9,2.6 v 8.3 c 0,0 1.6,0.3 3.6,0.5 2.1,0.3 2.3,2.9 2.3,2.9 l 5.4,-3.4 1.3,2.6 1.3,2.9 -1.3,3.4 5.4,3.9 7,-2.6 4.2,0.5 3.6,-3.9 4.7,0.3 c 0,0 2.6,4.2 2.6,5.2 0,1 -2.1,1.6 -2.1,1.6 l -0.8,7.8 3.6,2.9 3.1,-1.6 0.8,2.3 7.8,2.6 1.6,1.8 1.8,-0.8 0.3,-4.9 3.4,0.8 5.2,-0.8 3.9,3.4 v 2.3 l 4.4,3.9 1,4.7 3.4,-1.6 6.2,0.5 2.6,3.1 5.7,-0.3 5.4,0.5 5.4,2.9 2.9,-1.8 6.7,-0.5 2.3,-3.4 3.9,4.7 v 5.7 l 1.8,1.3 1.8,-0.8 4.2,0.5 2.3,3.1 9.1,-0.5 5.4,0.5 3.9,5.2 -2.6,3.1 -1.3,3.9 3.9,4.4 -1,5.7 -1.6,2.3 1.3,5.5 -2.3,2.1 2.3,4.4 -3.6,4.2 1.8,2.6 -2.3,4.9 -4.7,1.6 -0.3,3.9 -1.8,3.6 3.9,1 0.3,5.2 4.2,-0.8 v 1 l 3.4,4.2 -1,3.6 5.4,2.1 7,-4.2 v 3.9 l 5.4,0.3 3.9,2.6 5.2,-2.3 3.1,1.8 9.3,-1 3.6,-3.4 13,-6.2 3.8,3.3 3.4,-2.6 6.2,-0.4 3.7,7.2 15.2,4 7.9,12.7 c 0,0 7.5,2 8.1,1.3 0.6,-0.7 1.7,-1.8 1.7,-1.8 l 11.6,4.6 5.5,-0.2 17.1,8.8 2,-3.1 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(8,'path5138')"
                           id="path5138"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2453.7,439.1 1.5,0.6 2.2,3.7 h 1.2 l 0.6,2 3.5,1.8 4.3,1.4 3.7,-3.1 3.3,-1.7 -1.1,-3.9 h 6.2 l 4,-0.6 3.5,-0.4 -5,-11 -0.2,-4.4 1.7,-3.9 -0.4,-2.8 -5.1,-1.3 0.6,-5.7 -2,-0.2 -2,1.1 -4,-2.4 -5.7,1.3 -14.9,-20.9 -2.4,-1.1 -1.3,-5.1 1.5,-1.8 -1.8,-7.9 -2.6,-0.9 -2.6,-5.1 -1.8,-4.8 -2.4,-4.3 -3.1,-2.7 0.2,-3.9 -1,-2.9 -2.9,-2.7 -4.3,-1.4 -3.5,-1.2 -3.1,-0.2 -3.1,-4.7 -4.3,-2.2 -1.2,-0.8 -0.2,-3.3 -1.4,-0.8 0.6,-2.2 0.2,-1.2 -1.4,-0.8 h -1.6 l -2.4,-4.3 -1,-0.8 -2.2,0.2 -5.1,-1.4 -3.1,-2.4 -5.1,-2.4 -5.7,-1.4 -2.2,-1.6 -0.2,-2.2 0.4,-2.1 -3.6,1.1 -4.6,4.6 -1.7,8.4 -3.5,4.3 -12.1,6.1 -6.3,1.2 -3.7,-1.4 -2.6,1.4 -1.2,-0.3 1.7,-4.3 -5.4,2.3 0.8,2.9 2,1.4 2.3,4.9 -2,3.7 -2.3,0.9 -0.9,4.6 -1.2,0.6 1.2,1.7 -0.9,1.2 -1.7,0.6 -1.7,4 -4.3,2.6 0.9,6.1 1.7,0.6 2.3,-2 3.7,1.2 3.2,2.6 4.6,1.7 2.9,4 3.2,2.6 4,5.8 1.7,1.4 3.2,0.6 0.6,1.2 2.9,-0.6 3.2,-1.4 h 5.8 l 2.6,1.7 v 1.7 l 3.5,4.6 3.2,2.3 h 3.5 l 4.3,-0.3 3.7,2.3 8.3,1.2 4.9,-1.7 0.9,-1.4 1.4,-0.3 1.4,2 2.6,1.2 h 2.6 l 1.7,0.9 0.6,1.4 2.9,0.9 3.2,-0.6 2.3,1.2 v 1.4 l 2.3,5.2 3.2,2.3 2.6,1.2 4.3,1.4 v 2 l 2.6,4.6 1.2,2.3 4.3,3.2 1.2,3.5 3.2,7.8 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(21,'path2693')"
                           id="path2693"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st2"
                           d="m 2365.6,1008.9 -5.4,1.6 -4.2,3.1 -0.3,1.3 -8,1.3 0.3,-3.6 -3.1,-2.9 -3.1,0.5 -4.2,-4.7 -3.8,-0.6 5.1,-8.7 -7.5,-1 -1.7,-3 v 0 l 3.9,-4.7 1.2,-3.6 9.9,-5.8 -4.2,-1.1 -4.4,-12.5 -4.9,-4.7 2.6,-2.6 2.1,-13.2 2.6,-0.8 1,-4.4 3.9,-2.6 0.3,-5.7 3.9,-3.1 -0.5,-7.8 4.9,-2.3 -4.4,-6 -9.6,5.5 -4.9,-1.6 v -8.3 l -3.1,-6.5 4.7,-15.8 2.6,-3.4 -7.8,-4.7 -3.1,-2.9 -10.1,-1 -7.8,-4.4 v -2.6 l -2.9,-2.6 8.8,-2.6 1,-5.7 7,-8.8 h 2.6 l 1.8,-1.6 15,-5.5 0.5,-3.9 8.3,-6.2 v -6.2 l -2.6,-1 3.1,-2.6 -0.3,-15.3 4.4,-8.1 9.6,-7.5 3.7,-5.4 3.8,1.2 -2.3,4.4 2.3,1 1.6,-2.3 6.2,0.3 3.4,4.2 4.7,-0.5 9.3,9.9 0.3,2.9 -1.3,1.8 5.7,5.5 3.4,5.7 4.2,-1.6 3.9,5.2 7.3,2.9 7,7.8 1.3,4.4 h 6 l 1.3,3.1 2.6,1.8 v 2.9 l -2.9,1.6 1.6,2.1 -0.5,7 -2.3,3.4 2.3,0.8 3.6,9.1 -0.3,7 -3.6,2.1 -2.1,6 -2.6,3.6 3.1,1.3 -0.8,4.7 4.2,7.3 -2.3,3.1 4.2,5.5 4.9,1.8 2.6,2.6 8.8,0.3 3.1,2.6 -0.3,1.8 2.1,4.4 -1,2.9 0.5,5.2 4.7,1.3 3.1,-0.8 0.3,-3.9 1.3,-0.5 5.7,2.9 v 4.7 l 5.2,0.5 2.9,4.7 -2.6,2.6 0.3,2.9 1.6,9.4 9.1,7.8 h 2.1 l 1.6,2.3 -0.3,3.1 2.6,1.6 -0.5,4.7 -3.9,6.2 0.3,3.6 -2.6,2.9 -0.3,3.6 -2.6,2.9 2.6,1.8 -2.3,6.5 0.7,2.2 -1.1,0.6 h -3.6 l -1.8,4.7 -2.6,2.9 0.3,3.4 -1.3,0.8 -1.8,-0.3 -4.4,2.9 -4.7,4.2 -3.6,-3.6 -2.3,1.3 -1.3,2.9 h -3.6 l -2.6,-1.6 -1,2.3 -6.5,0.8 -4.4,-0.5 -3.1,4.4 -4.4,2.1 -0.8,-5.7 -2.9,-0.5 -0.8,-2.6 -4.7,-4.9 -7,-3.6 -4.2,3.1 -5.7,1 -5.2,-2.1 -5.6,3.5 -11.4,8.9 -2.7,0.4 -0.7,-1.4 -2,0.4 -0.4,-3.3 -0.8,-0.8 1,-2.2 -1,-2.3 -8.3,-3.8 -0.1,-2.2 -4.6,-5.3 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(18,'path2663')"
                           id="path2663"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2335.7,760.1 2.1,0.2 8.1,0.4 2.6,-4 8.1,-6.2 h 2.2 l -2.8,-4.2 -1.7,-1.7 v -2.2 l -2.8,-2.2 3.3,-1.5 0.7,-5.9 -1.5,-0.9 2,-4.2 1.8,-0.6 3.9,-7.2 -0.2,-3.3 -2.9,-1.1 0.7,-2.8 -2.8,-2.8 2,-2 1.5,-5.7 1.7,-3.3 4,-1.5 0.6,-2.8 -2.2,-2 0.2,-5.3 -4.2,-2.8 -2.8,-4.4 -5.3,-1.7 -2.6,-1.7 -0.6,-2.6 -8.1,-10.5 -4.8,-2.6 -0.2,-5 -6.2,-1.3 -4.2,-2.9 -1.4,-3.1 -5.8,-0.8 v -3.7 l -2.4,-2.4 -4.2,-0.4 -2.9,-2.9 0.9,-3.1 -1.5,-2.4 -5.8,-1.3 -6.5,1.3 -3.3,3.3 -3.7,0.2 -4.6,5.3 -9.4,2.6 -3.9,-1.3 -2.8,3.5 -2,-2 -4,-0.7 -4.8,2.4 -5,-2.4 0.6,-4.4 -4.1,-1.2 -0.5,4.9 2.6,4.6 -2.2,5.1 -3.9,5 -0.2,5 1.1,2.2 -5,2.6 -0.2,2.6 -7.9,0.2 -0.6,3.5 2,2.6 -2,2.8 v 5 l -5.1,0.6 -4.2,-2 -3.9,2.9 2.4,1.1 1.1,11.6 -2.6,2 3.7,1.3 1.1,2.2 2.9,1.1 0.6,3.9 -1.3,2.6 2.4,6.6 -1.5,6.2 -3.1,0.2 -4.4,4 -5.1,0.9 -1.1,-1.7 -1.1,1.3 0.6,5.3 2.6,5.7 -3.5,2 -0.2,4.8 -2.2,0.7 -4.6,-1.3 -3.3,-4 v -2.8 l -3.5,-0.9 0.6,2.6 -0.4,2.2 1.8,2.8 -1.7,1.3 -0.6,7 3.2,7.3 6,1.7 1.7,6.1 8.3,-1.5 1.1,2.8 6.8,1.7 4.6,-0.2 1.5,3.7 h 3.9 l 8.1,2.8 3.5,4 h 4.6 l 7,7.2 1.8,5.1 8.7,5.4 2.1,-8.1 0.6,-6.4 3.2,-4.5 2.1,-7 -1.7,-2.8 -5.8,-3.4 -0.9,-4.7 2.1,-4.9 2.1,-2.6 1.4,-3.4 4.2,0.2 h 3.7 l 7,4 7,0.2 7,-3.5 5.5,-5 25.9,10.1 1.1,1.2 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(13,'path2649')"
                           id="path2649"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2177.5,650 -1.7,-1.5 4.4,-6.6 -1.5,-2.8 0.6,-1.7 7.9,-0.4 -3.9,-8.1 -2.8,-4.6 -2.4,0.9 -3.9,-2.8 -2.7,0.1 h -3.7 l -1.5,1.8 -4,0.4 -0.4,-4.2 0.7,-1.3 -1.5,-2.2 -6.2,2 v -3.1 l -2.9,-3.9 -3.7,1.1 -2.2,2.4 h -7.9 l -4.4,-2.2 -1.7,-2.2 -5.5,-1.1 -3.3,-4.8 -6.6,-0.2 -2.2,-3.7 -7.7,0.4 -7.3,2.9 -8.3,9 -1.1,6.1 1.1,2.4 -2.4,2.9 -9.2,4.8 0.9,1.7 -5.1,8.8 0.5,1.6 3.2,-0.5 2.6,-1.8 2.6,0.4 v -1.8 l 3.1,1.7 4,-0.7 3.1,-2.9 2,-0.4 2.9,-3.1 8.4,-3.3 6.8,4.6 2,3.8 4.6,0.6 2.4,-0.9 2.2,1.5 0.4,2.9 3.5,1.3 0.6,6.4 12.1,8.4 3.1,0.2 3.1,3.5 5.7,-0.2 6.2,-2.8 2.8,-3.3 2.8,2.9 2.8,-1.8 3.3,-6.2 2.6,1.1 2.7,-1.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(2,'path2713')"
                           id="path2713"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2500.5,389.8 -0.6,0.9 -4.3,0.4 -2.4,-1.8 -2,-2.9 -2,-1.2 -2.4,0.2 h -1.2 l -1.6,-1.8 -1,-3.7 -1.6,-2.2 -3.5,-2 -4.7,-2.2 h -1.4 -4.3 l -0.7,-0.3 0.4,-18.3 -3.7,2.9 h -2.2 l -2.2,-4.4 -4.4,-0.4 2.6,-5.3 v -7 l -4.6,-2 -1.1,-8.3 -2.8,-3.3 -0.2,-5.5 1.7,-7.2 -2.4,-2 -0.2,-3.3 2.9,-2.6 0.6,-6.1 -0.9,-1.7 -4,-0.2 -8.1,-6.2 -0.7,-4.2 4,-4 0.7,-7.9 0.9,-1.8 v -2.6 l -5.9,-0.9 -1.7,-3.1 -2.8,-0.9 1.3,-1.1 0.7,-4.2 3.1,-0.7 0.4,-2 -2,-0.6 -1.1,-4.6 2.8,-0.6 1.2,-1.5 3.6,0.6 1.1,2 2.6,-4.2 3.3,-0.7 1.5,0.9 -1.5,2.6 h 8.6 l 2.6,-1.7 2.8,0.2 1.7,-2.8 -1.1,-3.1 -1.8,-0.2 -1.3,-2.4 2.9,-5.9 -0.6,-4.4 -8.8,0.2 -3.5,-1.5 0.2,-5.1 9.4,-0.4 0.9,-2 -2.4,-2.8 -0.2,-2.8 -2,-0.9 2.8,-4.2 3.5,1.3 0.2,-4.8 2.4,-1.7 -2,-2.2 2,-1.8 -1.8,-2 c 0,0 4.6,-0.4 5.7,-0.7 1.1,-0.4 1.1,-0.9 1.1,-0.9 l -0.9,-2.8 h 2.2 l 6.6,-3.3 6.1,2.2 2.8,-1.8 h 4.2 l 6.8,3.3 4,7.7 -0.7,2.8 -1.7,1.1 3.5,4.8 3.7,0.4 1.3,7.5 2.4,1.8 -3.1,4.2 -2.9,-1.8 1.1,5.1 4,7 -1.5,0.9 v 6.6 l 2.6,2.6 4.2,6.8 1.3,-0.4 0.2,-3.7 2.6,-1.8 2.9,-0.4 3.7,-8.4 -3.1,-3.1 0.2,-8.4 2.6,-0.2 7.3,5.1 v 2 l 1.7,3.3 -1.3,3.3 -4,3.3 1.7,1.8 -1.7,6.8 7.5,11.6 2,7 -3.1,0.2 0.4,1.8 -2,0.4 0.2,1.8 -1.1,0.9 0.7,1.3 2,-0.2 7,4 2,5.5 -0.4,3.7 -2,3.5 0.2,1.7 2.4,-0.2 0.6,0.7 -0.9,1.5 -0.2,2 -2.8,4 0.2,9.9 -1.5,0.2 0.4,3.9 -2.8,3.5 h -2.8 l -1.5,4.6 -2.6,0.2 -4.6,4.6 -3.9,2.4 -2.8,1.5 2,3.3 h -2.2 l -3.9,5.1 2.2,2.8 -1.7,1.5 2.4,5.1 v 1.3 l 3.7,1.8 -0.2,2.8 -6.4,0.4 -4.6,3.5 1.5,0.9 1.3,4 h -2.8 l -4.6,5.1 -1.3,0.6 0.6,2.9 -2.8,0.7 -2,2.2 0.4,1.7 h 2.6 l 1.1,2 -2.8,2.4 -1.7,0.7 -0.7,2.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(5,'path5157')"
                           id="path5157"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st1"
                           d="m 2431,172.9 -10,3.3 -15.8,6.2 -22,3.5 -28.8,0.4 -4.6,0.2 h -20.9 l -19.1,-4.5 0.7,71 -0.6,4.2 1,3.6 -0.6,0.3 -0.9,3.7 0.6,3.2 c 0,0 1.4,2.9 1.2,4 -0.3,1.2 0,7.2 0,7.2 l 5.5,4 3.7,4.9 v 8.6 l 1.4,9.5 -2.3,9.8 1.7,3.7 0.6,9.5 0.9,5.8 1.7,1.4 4.3,-0.3 4.9,-2 1.7,-2 6.6,-2.9 -1.7,4.3 1.2,0.3 2.6,-1.4 3.7,1.4 6.3,-1.2 12.1,-6.1 3.5,-4.3 1.7,-8.4 4.6,-4.6 3.5,-1.1 -0.3,2.1 0.2,2.2 2.2,1.6 5.7,1.4 5.1,2.4 3.1,2.4 5.1,1.4 2.2,-0.2 1,0.8 2.4,4.3 h 1.6 l 1.4,0.8 -0.2,1.2 -0.6,2.2 1.4,0.8 0.2,3.3 1.2,0.8 4.3,2.2 3.1,4.7 3.1,0.2 3.5,1.2 4.3,1.4 2.9,2.7 1,2.9 -0.2,3.9 3.1,2.7 2.4,4.3 1.6,4.7 2.4,0.8 1.6,-0.6 1.8,0.4 h 2.9 l 2,2.9 1.4,-0.2 4.9,1 2,3.1 h 0.8 l 1.6,1.2 0.6,-0.8 -0.2,-1.8 h 3.3 l 1.1,0.3 v 0 l 0.4,-18.2 -3.7,2.9 h -2.2 l -2.2,-4.4 -4.4,-0.4 2.6,-5.3 v -7 l -4.6,-2 -1.1,-8.3 -2.8,-3.3 -0.2,-5.5 1.7,-7.2 -2.4,-2 -0.2,-3.3 2.9,-2.6 0.6,-6.1 -0.9,-1.7 -4,-0.2 -8.1,-6.2 -0.7,-4.2 4,-4 0.7,-7.9 0.9,-1.8 v -2.6 l -5.9,-0.9 -1.7,-3.1 -2.8,-0.9 1.3,-1.1 0.7,-4.2 3.1,-0.7 0.4,-2 -2,-0.6 -1.1,-4.6 2.8,-0.6 0.8,-1.7 -1.2,-2.7 -4.8,1.1 -0.7,-2.4 -3.1,0.7 -2,-1.7 1.7,-1.7 0.7,-2 4,-1.3 v -2.4 l -2.6,-2 1.7,-4.8 2,-0.6 0.2,-1.5 3.1,-1.5 3.7,-5 -0.9,-3.3 v -2.8 l -3.9,-5 0.7,-44.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(6,'path5162')"
                           id="path5162"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st2"
                           d="m 2167.2,335.6 11.3,-0.7 4.8,1.5 3.7,-2 3.9,2.6 h 8.4 l 17.8,-5.7 1.1,1.3 -0.9,4 2.4,1.3 v 1.8 l 1.7,-0.2 1.8,-3.5 5.1,0.2 1.8,-0.7 1.1,1.3 6.4,-0.6 7.3,-9 3.1,3.5 13.9,-4 4.8,-3.7 7.2,-0.2 7.5,-3.5 11.6,-0.6 12.4,2.9 5.6,-1.9 6.7,4.1 -3,5.6 0.9,8.7 6.9,-0.5 1.9,-1.3 -1.8,-1.4 -0.9,-5.8 -0.6,-9.5 -1.7,-3.7 2.3,-9.8 -1.4,-9.5 V 288 l -3.7,-4.9 -5.5,-4 c 0,0 -0.3,-6.1 0,-7.2 0.3,-1.2 -1.2,-4 -1.2,-4 l -0.6,-3.2 0.9,-3.7 0.6,-0.3 -1,-3.6 0.6,-4.2 -0.7,-70.9 -1.7,-0.4 -15.8,-2.5 -3.2,-1.9 -4,0.4 -12.8,-4.9 -28.3,-9.5 -8.3,-1.9 -18.2,-3.8 -12.4,-6.4 -8.7,-4.4 -3,-1.8 -37,-15.7 -3.3,-1.6 -2.4,-2 -11.8,-5.4 -6.1,-0.7 -4.3,-2 -0.7,-1.3 -1.7,-0.7 -5.4,0.8 -10.5,-3.3 -5.7,-2.7 -7.4,-2 -6.5,-3.5 1.8,3.8 0.9,5.6 2,2.5 2.5,3.8 v 3.3 l 0.3,4.8 4.1,8.5 5.4,5.5 2.9,2.6 3,0.5 1.3,0.5 7.9,0.5 4.5,1.3 3.4,6.1 3,2.1 8.6,12 7.1,14.2 1.1,5.5 -0.4,3.9 0.3,3.3 -0.4,3.4 -0.3,0.7 0.1,3.4 0.5,3.9 1.2,4.3 3.6,3.1 4.9,2 2.2,2.1 6.2,2.6 3.3,2 -0.4,3.7 -8.4,6.6 -2.2,3.2 0.6,4.7 0.4,3.8 -0.3,3.6 -0.8,2.4 0.3,7.1 -2.4,6.3 v 5.4 l 3.5,9.7 -0.1,8.1 2.6,9.2 2.9,5.7 0.9,8.5 -2.3,6.1 0.4,8.5 1,9.2 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(7,'path5167')"
                           id="path5167"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2168.7,343.3 1,5.3 v 9 l -2.9,10.1 -2.5,3.2 -3,1.6 -3.8,1.9 -3.4,3.5 -0.5,2.6 1.7,4.2 6.3,5.7 2.5,1.9 2.6,8.2 -0.4,3.8 0.4,3.5 -4.4,6.3 11.4,3.1 5,-1.8 4,0.9 1.5,-7.7 7,-2.9 4.6,-0.4 0.9,1.3 2.8,0.2 0.7,4 3.9,4.8 v 5.5 l 2.2,2.4 7,-3.3 1.5,1.1 -3.9,9.2 -1.4,7.9 5.8,3.3 5,0.6 5.3,-2.6 2.8,2.2 -1.7,2.9 0.7,2.8 36.3,-0.2 3.9,3.3 4.4,-2 -1.7,-2.8 2,-5.7 -2.8,-2.6 5.7,-2.6 3.1,0.2 2.9,-3.9 1.1,1.1 11,2 0.9,-4 1.5,-2 4.8,5.3 2.4,-1.8 1.8,1.7 5,-1.7 2.9,-4.8 7,-4.6 -1.8,-4.4 16.3,-11.9 -0.4,-5.3 4.4,-6.4 -0.9,-5 -3.9,-0.9 4.8,-6.8 -2.8,-4.2 h -2 l -2.9,-2 0.6,-3.5 -0.5,-4.9 -1.7,-0.5 -0.9,-6.1 4.3,-2.6 1.7,-4 1.7,-0.6 0.9,-1.2 -1.2,-1.7 1.2,-0.6 0.9,-4.6 2.3,-0.9 2,-3.7 -2.3,-4.9 -2,-1.4 -0.9,-2.8 -1.1,0.5 -1.7,2 -4.9,2 -4.1,0.2 -2.1,1.3 -6.9,0.5 -0.9,-8.7 3,-5.6 -6.7,-4.1 -5.6,1.9 -12.4,-2.9 -11.6,0.6 -7.5,3.5 -7.2,0.2 -4.8,3.7 -13.9,4 -3.1,-3.5 -7.3,9 -6.4,0.6 -1.1,-1.3 -1.8,0.7 -5.1,-0.2 -1.8,3.5 -1.7,0.2 v -1.8 l -2.4,-1.3 0.9,-4 -1.1,-1.3 -17.8,5.7 h -8.4 l -3.9,-2.6 -3.7,2 -4.8,-1.5 -11.4,0.6 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(9,'path5172')"
                           id="path5172"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2114,500.1 6.7,-2 5.7,-2.8 11.6,-0.2 1.3,0.7 15.6,1.7 6.1,3.7 3.5,-2 6.4,0.9 1.5,1.3 6.4,-1.7 12.1,-9.4 2.4,-6.2 5.1,-6.6 6.2,-7.3 2.4,-6.2 -0.2,-16 2,-1.8 0.6,-7.5 1.4,-8.1 3.9,-9.2 -1.5,-1.1 -7,3.3 -2.2,-2.4 v -5.5 l -3.9,-4.8 -0.7,-4 -2.8,-0.2 -0.9,-1.3 -4.6,0.4 -7,2.9 -1.5,7.7 -4,-0.9 -5,1.8 -11.4,-3.1 -2.8,4.1 -0.3,19.8 -2.6,6.9 -9.3,3.6 -3.5,3.4 -6.5,1 -3,5.3 -3.1,3.9 -3.2,3.6 -3.2,0.7 -2.6,1.8 -1.8,5.8 0.7,3.4 -0.9,2.9 -3.5,3.2 -0.8,5.2 -1.6,8.9 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(11,'path5177')"
                           id="path5177"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st1"
                           d="m 2084.2,544.6 2,0.3 4,3.8 11.2,5.9 5.7,-0.7 2.9,4.6 h 2.9 l 2,-1.1 1.3,0.2 0.9,2.4 5.1,0.2 1.7,4 5,5.5 4.6,-0.2 5.3,6.6 2,-2.6 h 7 l 1.3,2 h 3.7 l 0.6,3.7 1.1,2 -0.2,4.6 6.1,3.9 2.2,-0.7 5,10.5 9.2,6.2 4.4,0.1 1.5,0.5 1.5,4.2 0.2,3.1 5,7 2.9,0.2 3.3,6.2 2.8,1.8 12.1,-5 2.9,-0.4 3.3,-1.7 1.8,2.2 v 2.4 l 3.1,2.2 v 3.1 l 2.2,-0.7 4.6,-1.3 3.5,0.7 h 4.8 l 4,2.8 2.2,-0.6 2.6,5 2.4,-0.2 1.4,1.1 v 0 l 4.3,1.3 -0.6,4.4 5,2.4 4.8,-2.4 4,0.7 2,2 2.8,-3.5 3.9,1.3 9.4,-2.6 4.6,-5.3 3.7,-0.2 3.3,-3.3 6.5,-1.5 -0.8,-5 -3.9,-4.6 v -5.9 l -3.7,-2.9 -5,-4.4 v -3.5 l -5.5,-1.8 -2.4,-1.1 -2,-3.9 -5.9,-4 -0.4,-2.4 -1.7,-1.1 0.9,-2 -0.7,-2.2 -10.3,-11.4 1.8,-5.7 -0.2,-7 -2.4,-4.4 0.9,-2.4 -6.4,-4.2 -0.6,0.9 -5.7,-0.6 -4.6,2.9 -4.6,0.6 -1.5,-1.3 -5.3,2.6 -0.2,2.2 -3.3,0.7 -2.8,-4.4 0.2,-15.6 -1.1,-1.7 1.1,-1.5 -0.4,-2.4 -1.7,-1.7 -1.3,-6.1 1.7,-1.5 0.9,-3.7 -3.1,-4.4 -1.5,-5.3 1.7,-0.6 h 1.7 l 1.1,-6.1 -2.4,-2.2 -0.4,-6.8 2.8,-2.6 0.7,-6.1 -7.3,-0.2 -4.4,-2.2 -3.1,0.9 -2,2.4 -1.5,-5.1 -4.2,-3.7 -2.6,-2.6 -3,0.1 -5.2,6.7 -2.4,6.2 -12.1,9.4 -6.4,1.7 -1.5,-1.3 -6.4,-0.9 -3.5,2 -6.1,-3.7 -15.6,-1.7 -1.3,-0.7 -11.6,0.2 -5.7,2.8 -6.7,2 v 3.3 l 0.1,2.6 -1.7,3.9 -3.4,5.3 -2.2,3.8 -2.1,2.6 -2.9,1.8 -5.7,2.6 -6,3.6 -4,6 -2.2,4.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(12,'path5182')"
                           id="path5182"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2056.2,628.9 8.6,0.5 -0.2,3.7 -1.7,3.3 5.1,3.3 2.3,3.6 5.8,-1 -0.6,-1.6 5.1,-8.8 -0.9,-1.7 9.2,-4.8 2.4,-2.9 -1.1,-2.4 1.1,-6.1 8.3,-9 7.3,-2.9 7.7,-0.4 2.2,3.7 6.6,0.2 3.3,4.8 5.5,1.1 1.7,2.2 4.4,2.2 h 7.9 l 2.2,-2.4 3.7,-1.1 2.9,3.9 v 3.1 l 6.2,-2 1.5,2.2 -0.7,1.3 0.4,4.2 4,-0.4 1.5,-1.8 h 3.6 l 1,-3.5 1.8,-0.2 0.9,-2.4 2,-0.7 1.1,-1.8 -0.6,-3.9 3.4,-4.3 -4.7,-0.2 -9.2,-6.2 -5,-10.5 -2.2,0.7 -6.1,-3.9 0.2,-4.6 -1.1,-2 -0.6,-3.7 h -3.7 l -1.3,-2 h -7 l -2,2.6 -5.3,-6.6 -4.6,0.2 -5,-5.5 -1.7,-4 -5.1,-0.2 -0.9,-2.4 -1.3,-0.2 -2,1.1 h -2.9 l -2.9,-4.6 -5.7,0.7 -11.2,-5.9 -4,-3.9 -1.9,-0.3 0.6,12 -2.3,6.5 -1.8,5.2 -7.9,11 -1.4,3.5 -5.2,6 -2.9,11.2 -3.8,13.6 -3.4,5.4 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(4,'path4224')"
                           id="path4224"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st1"
                           d="m 2835.3,385 -1.4,4.7 0.6,4.9 -2.5,3 1.1,6.6 5.1,4.3 -1.9,1.8 -0.2,9.1 -3.2,6.9 -5.8,1.5 -2,3.7 6.8,-0.2 5,0.5 -0.1,4.1 3.7,4.1 10.7,3.7 -2,3.2 4.3,3.3 -0.4,10 3.6,3.2 -2.1,4.9 -5.6,1.2 -1.9,-2 -4.1,-0.5 -3.7,3.3 -4.3,1.3 -2.1,-3.3 -12.6,-0.5 -2.6,3.9 h -2.2 l -4.1,-3 -4.6,2.4 -0.2,3.3 -0.9,5 -4.1,1.5 v 1.7 l 3.7,4.4 -0.4,3.5 -4.1,3.3 -5.5,1.9 -7.6,-3.6 -4.2,-1.9 -3.3,0.9 -2.6,1.2 -3.5,-0.6 -1,2.2 1.8,3.9 -0.2,2.2 -1.8,1 -0.8,1.6 3.3,1.6 -2,1.2 -1.4,1.8 v 1.6 l -1.4,2.2 -2.2,-0.6 -1.8,-1 h -2.2 l -2.9,2.7 v -2.9 l -6.3,-1.2 -3.3,1.2 -1.8,-0.6 0.4,2.2 -4.5,2 -1.8,3.1 -0.2,2 -1.6,2.4 -4.7,0.8 -2.2,2.9 -1.8,2.4 h -3.1 l -1.8,1.8 0.8,1 -1.4,2.4 -2.9,-0.2 -0.8,-1.2 -1.2,0.4 -2.6,3.1 -1.4,-1.2 h -1.6 l -1,0.8 -2.4,-0.8 h -2.9 l -3.3,2.7 -1,2 -1,-1.2 -3.1,-0.8 -4.9,-4.7 v -2.7 l -2.6,1.6 -5.3,0.6 h -1 l -3.3,1 -1.4,3.5 -2.4,1 -4.7,-1.4 -2.6,-0.2 -2.2,3.1 h -2 l -3.9,-0.8 -1.6,-1.2 -1.8,0.8 -2.4,-0.2 -0.2,1 -0.4,1.6 -2.4,1 -3.7,-0.2 -3.9,1.2 -5.3,2.9 -2.4,2.4 -3.5,2 -0.4,1.2 0.4,2.4 -0.8,1.8 -1.8,2 -2.1,1.3 -3.3,0.4 -2.7,4 -3.7,1 -0.3,2.8 -2.9,0.3 -1.7,2.3 2.4,0.9 0.6,2.9 v 2.6 l -1.9,1.4 -1.2,2.2 2.9,3 0.1,3 -1,0.3 h -2 l -0.6,1.4 1.3,2 -1.7,3.6 -0.3,3.2 -0.9,1 -2.3,0.1 -0.9,1.7 0.6,1 -1,2 -5,3.9 -5.5,2.6 -0.4,1 -8.1,-5.5 v -4.6 l -6.1,-15.6 -2.4,-2.4 v -2.2 l -5.3,-3.7 2,-2.9 -3.5,-3.3 -3.1,0.4 -2.4,-4.4 -3.9,-0.4 1.1,2.4 -1.1,5.5 -3.3,0.7 -3.3,2.6 -8.4,-9.9 -4,-10.1 -9.2,-7.3 -0.4,-3.3 -7.9,-9.4 -1.7,0.4 -0.2,1.7 -2.8,2.9 -0.2,2 -4.4,4 -1.7,0.2 -3.3,-1.7 -3.3,1.1 -2.6,2.9 -4.4,0.2 -0.2,2.9 -2.9,2.2 -2.7,4.5 -4.2,-6 -4.6,-2.4 -3.7,-7 v -2 l -3.7,-1.5 -0.2,-9 3.3,-0.2 0.7,-5.5 -2.2,-0.9 v -2.8 l 2.2,-2.4 -2.8,-4 1.3,-8.3 -1.8,-3.9 -3.5,-1.8 0.2,-3.1 -3.3,-4.4 -0.7,-3.7 2,-1.1 0.6,-4.6 -2.6,-1.8 -5.7,-1.1 -5.9,-3.1 -2.6,-6.1 -0.1,-7.9 -1.8,-4.4 -3.7,-2.1 -0.6,-6.1 -4.2,-4.5 -3.2,-0.9 -1.9,-3.4 v -5.3 l 3.7,2.8 1.5,0.6 2.2,3.7 h 1.2 l 0.6,2 3.5,1.8 4.3,1.5 1.4,2 10.2,3.3 1.3,0.4 4.9,0.3 3.5,4 -0.6,1.7 2.3,1.4 0.3,2.9 3.2,1.2 0.3,-1.7 2,-1.4 2.3,-2.3 1.7,1.4 2.9,2 2.9,4.6 h 2 l 2.3,0.9 1.2,-0.6 0.6,-3.2 1.4,-1.2 1.7,1.2 -0.3,2.9 -0.6,2 0.6,0.6 2.9,0.3 1.4,2.3 -4.3,2.6 -1.4,2 2,2.9 3.5,-0.6 1.2,-2 h 1.4 v 2.3 l 0.9,1.7 2.9,-1.4 0.9,1.7 2.9,2.3 3.5,2.3 h 4.6 l 2,0.6 3.5,2.3 1.7,3.2 -0.6,4 1.7,6.1 1.7,2.3 1.7,2.6 1.7,-0.6 0.3,-2.9 2.3,-1.7 2.5,3.5 5.5,1.2 h 3.5 l 3.5,5.5 2,-0.8 2,-1.2 1.4,0.8 4.5,0.4 2.4,-2.7 10,-5.3 14.7,-4.3 1.6,-1.4 3.9,-11.8 2.4,-2.7 2.6,-6.7 c 0,0 3.5,-1 4.1,-1.8 0.6,-0.8 3.1,-2.2 3.1,-2.2 l 1.6,0.8 3.3,3.9 1,0.2 1.4,-1 6.1,-0.8 6.7,-5.1 4.3,-4.3 v -7.1 l 1.6,-1.4 2.2,0.4 3.1,0.2 5.7,4.1 2.6,-0.2 0.6,-1 h 5.3 l 4.5,0.8 1.8,2 h 2.2 l 1,-1.4 V 461 l 0.8,-0.6 3.3,0.8 7.3,1.2 4.3,-1.4 3.9,-3.9 3.3,-2.4 5.9,-1.2 0.2,-2.4 1.8,-0.8 2,1.4 1.8,0.6 h 2.4 l 0.4,-0.8 4.7,-5.1 1.8,-1 1.6,-3.1 0.6,-1.8 2.2,0.6 5.3,-1.4 4.9,0.4 2.6,-4.3 2.6,-2.9 5.1,-1.4 2,-0.6 1,-2.9 3.5,-1.2 3.7,-0.2 3.3,1.4 1.8,2.2 2.2,0.2 1.2,-3.1 0.6,-4.1 3.3,-2 c 0,0 0.4,-1.2 1.4,-1 1,0.2 2.4,0.4 2.4,0.4 l 2,-1 0.4,-1.8 2.4,-2 4.5,-1 4.3,-3.8 6.5,-2.3 V 405 l 4,0.6 5,-4.2 1.1,-3.5 -2.2,-1.8 -0.7,-4.2 -2.8,-2.4 1.3,-2.4 h 10.6 l 2.9,-1.1 1.8,-2.4 6.1,-1.3 3.2,0.3 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(16,'path4230')"
                           id="path4230"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccsccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2545.7,728.4 -2.6,-3.6 -1,-3.5 -2.8,-1.5 -0.4,-3.5 -2,-2.2 -2,-3.9 2,-2.4 -2,-3.7 -1.3,-0.7 -0.6,-5.3 -3.1,-2.8 -0.4,-3.5 0.4,-2.8 -1.7,-1.5 1.7,-2.2 v -1.1 l 2,-0.4 -0.4,-2 -2.6,-1.1 v -5.5 l -1.1,-1.5 1.1,-4 -2.4,-4.2 -3.9,-2.9 -2,-0.7 1.5,-2.4 -0.4,-9.9 0.7,-2.4 -2.4,-2.8 -6.8,2.4 -8.1,4.8 -0.7,2.9 -3.5,1.8 -2.4,-2.2 -1.7,-3.3 -3.9,2 -1.5,-2 -2.9,0.2 0.2,1.8 -1.1,2.6 c 0,0 -1.5,-0.7 -2.6,0.4 -1.1,1.1 -2.6,2.8 -2.6,2.8 h -2.6 l -2.8,-2.8 h -4 l -3.2,-5.6 0.1,-2.3 1.7,-1.5 0.2,-2.4 3.1,-1.8 -0.2,-5.3 1.5,-1.7 -0.6,-3.9 4.6,-2.9 -1.5,-2.8 2.4,-4.4 2.2,-0.9 0.7,-3.7 -1.3,-1.8 2.9,-3.5 0.6,-7.9 -2.6,-3.7 1.8,-2.6 -2.6,-2 2.6,-3.5 0.4,-6.1 3.3,-7.5 7.3,-2 -0.4,-3.7 3.3,-2.8 -0.9,-3.1 -2.2,-0.7 1.7,-1.7 2.8,-0.4 1.3,-3.9 0.1,-2.5 v 0 l 2.7,-4.5 2.9,-2.2 0.2,-2.9 4.4,-0.2 2.6,-2.9 3.3,-1.1 3.3,1.7 1.7,-0.2 4.4,-4 0.2,-2 2.8,-2.9 0.2,-1.7 1.7,-0.4 7.9,9.4 0.4,3.3 9.2,7.3 4,10.1 8.4,9.9 3.3,-2.6 3.3,-0.7 1.1,-5.5 -1.1,-2.4 3.9,0.4 2.4,4.4 3.1,-0.4 3.5,3.3 -2,2.9 5.3,3.7 v 2.2 l 2.4,2.4 6.1,15.6 v 4.6 l 8,5.5 -0.7,1.6 -4.6,3.5 -4.2,1.4 -2.9,3.5 v 3.2 l 1.6,2.5 -0.7,2.6 -1,3.3 -6,1.6 c 0,0 -1.9,2 -2.7,2 -0.9,0 -4.9,0.3 -4.9,0.3 l -1.3,1.2 v 1.9 l -1.9,1.6 0.3,3.3 -0.9,2.9 2.2,1.9 v 2.9 l -3,1.7 -2,2.2 -0.9,3.3 -2.7,3.6 -4,3 -0.6,3.5 -2.7,4.6 -0.7,2.7 1.6,2.9 0.4,3.3 -0.1,2.3 1.2,3.9 v 3.3 l -2.2,4.5 -4.5,2.6 -1.3,3.6 2.2,2.3 1.6,4 -0.4,8.2 -1.7,1.6 -2.4,1.2 -1,1.9 v 1.9 l -1.9,3.6 -2.7,3 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(17,'path4235')"
                           id="path4235"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccsccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2574.9,769.6 -5.6,-6 -2.3,-2.2 -3,-0.6 -1.6,-3.2 -0.6,-6.3 -1.9,-3.2 -0.9,-3.2 -7.3,-7.1 -0.7,-3 -5.3,-6.6 -2.5,-3.5 -1,-3.5 -2.8,-1.5 -0.4,-3.5 -2,-2.2 -2,-3.9 2,-2.4 -2,-3.7 -1.3,-0.7 -0.6,-5.3 -3.1,-2.8 -0.4,-3.5 0.4,-2.8 -1.7,-1.5 1.7,-2.2 v -1.1 l 2,-0.4 -0.4,-2 -2.6,-1.1 v -5.5 l -1.1,-1.5 1.1,-4 -2.4,-4.2 -3.9,-2.9 -2,-0.7 1.5,-2.4 -0.4,-9.9 0.7,-2.4 -2.4,-2.8 -6.8,2.4 -8.1,4.8 -0.7,2.9 -3.5,1.8 -2.4,-2.2 -1.7,-3.3 -3.9,2 -1.5,-2 -2.9,0.2 0.2,1.8 -1.1,2.6 c 0,0 -1.5,-0.7 -2.6,0.4 -1.1,1.1 -2.6,2.8 -2.6,2.8 h -2.6 l -2.8,-2.8 h -4 l -3,-5.3 -5.2,2.9 -7.9,1.3 -2.6,0.2 -0.9,2 4.6,4.8 2.4,2.9 -0.4,11.9 -3.1,2 2.2,4.6 -2.8,2.9 1.1,4.4 -1.7,1.5 v 2.2 l -2,-2 h -2.9 l -0.6,2.8 -2,-0.4 -1.7,-4.6 -3.7,-0.6 -1.7,-2.4 -0.2,-3.7 -6.1,-2.8 -1.7,0.4 -2.9,-3.7 -0.2,-3.5 -3.1,-0.2 -0.9,-4.2 1.5,-1.3 -2.6,-3.5 -5.5,-0.2 -5.1,-6.2 1.7,-3.3 -3.7,-1.7 -2.2,2.6 -6.4,-2.2 -5.5,-5.7 -10.5,-2.6 -2.2,1.1 -2.2,-3.1 -3.5,-1.1 -3.1,1.7 -1.8,-2.4 1.5,-5.5 -2.1,-4.1 -4.7,-0.4 -3.3,-1.5 -1.6,-3.2 -1.7,-4.2 -7.9,-0.8 -3.9,-0.7 -0.9,-7.3 -2.9,-2.2 -2.2,0.4 -5.1,0.2 -2.6,4.9 -4.4,0.5 0.2,3.3 -1.3,2.8 -4.6,-5.3 -1.7,5.8 1.6,6.7 2.1,5.9 0.6,4.8 h -4.2 l -1.3,2.9 -1.1,4.9 1.4,3 4.2,2.9 6.2,1.3 0.2,5 4.8,2.6 8.1,10.5 0.6,2.6 2.6,1.7 5.3,1.7 2.8,4.4 4.2,2.8 -0.2,5.3 2.2,2 -0.6,2.8 -4,1.5 -1.7,3.3 -1.5,5.7 -2,2 2.8,2.8 -0.7,2.8 2.9,1.1 0.2,3.3 -3.9,7.2 -1.8,0.6 -2,4.2 1.5,0.9 -0.7,5.9 -3.3,1.5 2.8,2.2 v 2.2 l 1.7,1.7 2.8,4.2 h -2.2 l -8.1,6.2 -2.6,4 -8.1,-0.4 -2,-0.1 0.3,12.5 h 3.6 l 4.4,-0.8 1.6,2.3 2.1,-2.3 8.3,1.6 2.1,3.6 4.4,1 1.6,1.3 1.6,0.3 2.9,2.7 3.8,1.2 -2.3,4.4 2.3,1 1.6,-2.3 6.2,0.3 3.4,4.2 4.7,-0.5 9.3,9.9 0.3,2.9 -1.3,1.8 5.7,5.5 3.4,5.7 4.2,-1.6 3.9,5.2 7.3,2.9 7,7.8 1.3,4.4 h 6 l 1.3,3.1 2.6,1.8 1.3,-8.3 2.6,-1.6 -0.8,-2.6 1.6,-2.1 -1.3,-1.8 v -5.2 l -1.6,-1 3.6,-4.9 -2.1,-1.8 -0.3,-2.3 4.9,-6.5 1.3,-12.2 6.5,-6 4.4,-1 1,-2.1 7.3,-3.1 1.6,0.3 4.2,-2.9 h 5.2 l 2.3,2.3 4.4,-3.1 2.6,1.6 -0.5,2.9 1.6,2.9 7,-1.8 6.2,4.2 4.4,0.5 1,1.8 -2.9,2.6 -0.3,1.6 3.4,1.8 5.2,4.7 3.1,-0.3 2.1,-3.1 4.7,-3.4 13,-0.8 3.4,-6.8 -1.6,-2.3 5.7,-3.6 7.5,0.5 4.2,-1.8 6.5,5.5 4.9,-8.8 h 6.7 l 2.1,-1.6 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(29,'path5036')" 
                           id="path5036"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2603.9,1167.2 -2.8,5.2 2.6,7.2 6,6.1 12.1,-0.3 2.3,5 5.7,2.1 -1.8,7.5 -0.4,4.8 2.5,5.8 -5.2,3.9 2.9,10.7 -5.7,5.9 -2.2,3.3 -3.3,3.5 0.6,4.5 3.9,6.5 -1.9,5.1 5.8,4.9 7.6,-1.3 19.2,5 9.7,0.3 1.8,-3.7 4.2,-2.8 7.9,1.2 3.1,5.7 -1.7,8.3 -6,7.6 -0.1,10.7 4.7,9.6 9.3,6.5 10.1,8.2 4.4,2.3 3.3,3.8 5.9,3.1 5,5.1 5,5.1 -2.3,3.8 1,3.2 -3.8,-0.8 -4.3,0.6 3.2,4.6 h -3.2 l -0.8,2.3 1.3,2.5 -2.6,2.1 -3.1,-2.6 -4.2,4.3 0.6,12.8 -2.6,1.9 0.1,6.1 -4.7,2 3,3.3 -3.5,3.7 -0.9,3.4 -4.1,1.8 -3.8,-0.2 1.6,6.2 -11.1,5.9 -14.3,-21.9 -1.8,-0.4 -2.9,1.8 h -8.6 l -5,2 -3.5,-4.9 -4.6,0.2 -3.4,-1.1 -2.5,-5.2 -6.8,-1.6 -3.4,0.5 -0.8,2.1 -2.3,2.9 -4.8,-2.4 -5.1,0.7 -3,-3.7 h -6.9 l -0.3,-5.2 2.5,-4.4 5.7,2 2.4,-1 -5.7,-3.9 -2.6,-4.2 -5.2,-5.3 -6.2,5.3 -5.2,-0.6 -4,-3 0.3,-8.3 h -2.2 l -3.4,1.2 0.2,2.8 -2.2,6.1 -5.9,5 -4.4,-0.4 -4.8,-4.3 -3.3,-0.2 -2.9,2.2 -6.8,4.3 -6.9,-3.8 -2.6,-3.5 0.9,-2.6 -3.3,-2 -4.6,1.8 -5.3,2.6 -2.6,-1.8 -2.3,-4.6 3.7,-2.2 1.8,1.3 3.6,-1.5 0.9,-3.6 -2.8,-2.4 -4.6,-5.2 h -1.8 l -2.5,1.7 -2.7,1.3 h -7.1 l -0.3,-3.9 2.8,-2.7 -2.4,-3.5 -4.2,1.1 -2.2,-0.7 -2.6,-1 -1.9,-2.2 1.9,-3.9 10.5,-10 3.1,-1.6 16.7,-13.6 5.2,-2.9 10.4,-9.1 -1,-3.7 4.2,-3.7 1.8,-9.9 -0.5,-5.2 -2.3,-2.6 2.6,-2.9 -2.3,-2.6 v -3.9 l 1.6,-3.4 0.5,-6.3 4.7,-0.8 1.3,-1.8 5.2,-0.3 1.8,1.6 5.5,0.5 1.3,-2.3 v -2.6 l 2.3,-5.2 5.5,-2.6 1.3,-9.9 -1,-2.3 4.9,-13.8 1,-4.2 4.9,-3.1 -5.5,-6.3 2.9,-0.3 v -5 l 3.9,-2.3 2.6,0.8 2.1,-3.4 h 1.6 l 3.4,-3.7 3.9,-1.8 h 6.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(28,'path5041')"  
                           id="path5041"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st2"
                           d="m 2490.7,1319.2 1.4,-4.4 -3.1,-2.9 -4.6,-1.1 -3.5,-0.3 -4.7,-4 -5.5,-7.5 -1.6,-4.5 -6.3,1.4 -3.2,-5 4.7,-2.7 -0.9,-2.3 -2.6,-2.6 -6.4,-7.7 -3.6,-6.5 -3.7,-3.1 -4.5,1.4 -4.2,-1 -7.7,4.4 -9.3,2.8 -3.1,-3 -1.2,-4 1.3,-5.2 4.5,-4.6 -0.4,-5.1 -2.5,-6.1 6.2,-4.4 1.8,0.3 2.3,-2.6 h 5.2 l 1,-3.9 1,-1.6 5.2,0.3 3.4,-7.8 2.1,-8.9 -1.8,-6 4.7,-5.5 h 3.9 v -4.2 l 2.3,-1.6 3.4,0.8 2.9,-1.8 h 4.2 l 1.6,-1.6 8.6,-5 v -4.7 l -6,-2.3 -1.6,-5.2 1,-3.1 h 3.6 l 2.1,-1.6 2.1,0.5 3.1,-1.8 v -2.3 l 8.9,-6.3 2.9,-0.3 v -2.3 l 1.8,-1 2.6,2.9 1.8,-2.1 2.3,1.6 h 2.1 l -0.3,-3.1 2.6,-1 5.7,2.9 3.1,4.7 7,1.3 2.6,-3.7 4.2,-6.3 4.9,-2.9 7.8,-7.3 4.4,-1.8 3.6,-6.8 3.1,-8.3 4.4,-0.5 1.3,-2.3 7,-0.3 2.3,1.6 3.1,-2.6 h 9.6 l 4.2,3.4 2.9,-1.6 5,0.4 1.1,1.3 7.4,-1.3 7.6,4.3 -4.6,4.9 v 9.9 l -4,7.2 2.9,4.3 v 5.6 h -6.6 l -3.9,1.8 -3.4,3.7 h -1.6 l -2.1,3.4 -2.6,-0.8 -3.9,2.3 v 5 l -2.9,0.3 5.5,6.3 -4.9,3.1 -1,4.2 -4.9,13.8 1,2.3 -1.3,9.9 -5.5,2.6 -2.3,5.2 v 2.6 l -1.3,2.3 -5.5,-0.5 -1.8,-1.6 -5.2,0.3 -1.3,1.8 -4.7,0.8 -0.5,6.3 -1.6,3.4 v 3.9 l 2.3,2.6 -2.6,2.9 2.3,2.6 0.5,5.2 -1.8,9.9 -4.2,3.7 1,3.7 -10.4,9.1 -5.2,2.9 -16.7,13.6 -3.1,1.6 -10.5,10 -1.9,3.8 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(27,'path5046')"
                           id="path5046"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st1"
                           d="m 2360.2,1236.6 2,-4.9 4.9,-4.6 -0.5,-4.2 3.6,-3.9 h 3.1 c 0,0 -0.8,-3.4 1.3,-4.2 2.1,-0.8 8.8,-6.2 8.8,-6.2 l 4.2,-1.6 25.9,-22.3 10.6,-9.6 23.9,-12.5 6,-4.7 1.6,-6 -1.3,-4.2 -1,-5.2 6.5,-6.8 0.5,-6 7,-6 5.7,-6 3.1,-3.6 -0.8,-2.3 3.6,-6 2.3,-1.6 3.4,-5.5 -0.8,-9.4 0.5,-3.4 4.4,-2.6 -0.2,-4.4 2,0.5 2.9,-0.3 4.2,-4.4 2.6,-2.1 3.6,2.1 4.2,-0.5 2.9,-2.2 4,-0.1 2.1,4.1 6.7,1.2 1.1,3 6.3,0.4 3.3,2.1 4.1,-0.5 3.2,6.3 4,4.8 6.9,1.8 3.4,3.1 -0.7,3.9 7.6,6.2 2.8,4.7 7.3,0.3 8.5,3.3 7.1,6.4 4.7,6.7 -5.1,-0.4 -2.9,1.6 -4.2,-3.4 h -9.6 l -3.1,2.6 -2.3,-1.6 -7,0.3 -1.3,2.3 -4.4,0.5 -3.1,8.3 -3.6,6.8 -4.4,1.8 -7.8,7.3 -4.9,2.9 -4.2,6.3 -2.6,3.7 -7,-1.3 -3.1,-4.7 -5.7,-2.9 -2.6,1 0.3,3.1 h -2.1 l -2.3,-1.6 -1.8,2.1 -2.6,-2.9 -1.8,1 v 2.3 l -2.9,0.3 -8.9,6.3 v 2.3 l -3.1,1.8 -2.1,-0.5 -2.1,1.6 h -3.6 l -1,3.1 1.6,5.2 6,2.3 v 4.7 l -8.6,5 -1.6,1.6 h -4.2 l -2.9,1.8 -3.4,-0.8 -2.3,1.6 v 4.2 h -3.9 l -4.7,5.5 1.8,6 -2.1,8.9 -3.4,7.8 -5.2,-0.3 -1,1.6 -1,3.9 h -5.2 l -2.3,2.6 -1.8,-0.3 -6.3,4.5 -15.1,-9.5 -4.9,-2.4 -4.6,-2.9 -6.6,-1.5 -12.4,2.3 -8,3.7 -5.5,5.2 -5,-1.7 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(26,'path5051')"  
                           id="path5051"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2354.6,1238.4 -6.1,-10.7 -2.9,-6.5 -3.3,-6.7 -1.9,-6 -1.3,-5.1 -5,0.9 -3.3,-2.3 -11,3.6 -5.8,4.4 -7.3,7.1 -8.2,4.7 -1.5,-0.5 -0.6,-3.3 4.9,-1.8 -1.3,-2.9 4.4,-4.9 v -4.2 l -3.6,-0.3 3.4,-3.1 v -3.4 l 4.4,-4.2 h 3.4 l 2.9,-1.6 -2.1,-1.8 -0.3,-1.6 4.4,-4.2 -1.3,-1.3 v -2.4 l 8.3,-7.3 8.8,1.8 1.6,-3.4 13.7,-0.5 3.9,-1 2.1,2.9 7.3,-4.7 3.9,-3.9 h 5.4 2.9 l 4.2,2.1 4.2,-4.2 0.3,2.3 14.5,1 2.9,1.6 h 1.6 l 1,-2.3 3.4,-1 1.6,0.5 h 4.2 l 2.3,-0.5 -0.8,-6 3.4,-0.3 7.8,-4.2 -1.6,-6 2.9,-6 2.9,1.6 4.4,-10.4 -1.8,-1 4.7,-9.6 6.7,-3.4 6.5,-10.1 1.6,-6.8 3.4,1.6 7.3,-3.9 v -3.4 l 2.1,-3.6 3.4,0.8 5.7,-2.3 0.3,-2.9 4.2,-3.1 4.2,0.8 0.5,-4.2 5.7,-3.1 2.4,0.9 v 4.2 l -4.4,2.6 -0.5,3.4 0.8,9.4 -3.4,5.5 -2.3,1.6 -3.6,6 0.8,2.3 -3.1,3.6 -5.7,6 -7,6 -0.5,6 -6.5,6.8 1,5.2 1.3,4.2 -1.6,6 -6,4.7 -23.9,12.5 -10.6,9.6 -25.9,22.3 -4.2,1.6 c 0,0 -6.7,5.5 -8.8,6.2 -2.1,0.7 -1.3,4.2 -1.3,4.2 h -3.1 l -3.6,3.9 0.5,4.2 -4.9,4.7 -2.1,4.8 -2.7,2.7 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(24,'path5056')" 
                           id="path5056"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st4"
                           d="m 2218.7,1139.2 -0.3,-5.6 3.1,-5 3.3,0.6 2.2,-1.3 2.2,-4.4 2.2,-1.1 3.5,-4.4 -1.5,-1.1 0.9,-1.5 0.7,-3.5 6.2,-2.4 0.6,-9.2 -2,-4.6 v -3.3 l 6.8,-7.3 4.4,-10.8 2.2,-0.4 7.5,-1.7 3.1,-2.8 v -4.6 l 2.6,-2 0.2,-3.1 7.7,0.8 3.5,-3 3.7,-3.3 3,-4.1 3.6,-9 -1.5,-8.5 4.2,-4.9 7.5,-4.8 3.6,-5.7 -0.6,-9.7 3,-8.1 10.5,-5.7 -0.4,2.2 2.3,2.9 8.3,3.9 2.6,2.6 5.6,-0.4 4.3,0.6 4.2,4.7 3.1,-0.5 3.1,2.9 -0.3,3.6 8,-1.3 0.3,-1.3 4.2,-3.1 5.4,-1.6 2.9,-3.4 4.6,5.2 0.1,2.3 8.4,3.9 0.9,2.3 -1.1,2.1 0.8,0.9 0.4,3.2 2,-0.4 0.7,1.5 2.7,-0.4 11.5,-8.9 5.6,-3.5 5.2,2.1 5.7,-1 4.2,-3.1 7,3.6 4.7,4.9 0.8,2.6 2.9,0.5 0.8,5.7 4.4,-2.1 3.1,-4.4 4.4,0.5 6.5,-0.8 1,-2.3 2.6,1.6 h 3.6 l 1.3,-2.9 2.3,-1.3 3.6,3.6 4.7,-4.2 4.4,-2.9 1.8,0.3 1.3,-0.8 -0.3,-3.4 2.6,-2.9 1.8,-4.7 h 3.7 l 3.6,-2.1 -0.3,-2.3 2.3,-3.1 3.4,0.5 3.4,-2.3 0.8,-10.7 3.4,-4.4 9.1,-3.9 3.6,-3.6 h 6.5 l 7,-7.5 h 3.9 l 1.3,-3.1 -1.8,-1.3 3.1,-4.4 0.3,-2.9 h 2.6 l 4.7,-4.4 0.3,-1.8 2.6,-0.8 2.3,1 5.2,-0.5 10.6,-8.6 5.2,-1 7,-7.5 6.5,-2.9 c 0,0 4.2,1.6 7,0.3 2.8,-1.3 3.6,-1.6 3.6,-1.6 l 3.1,1.8 5.2,-4.9 10.9,1.8 -0.8,-4.2 2.9,-0.3 5.7,2.1 0.8,2.6 h 3.4 l 8.8,2.9 1.8,-1.6 2.3,1.6 5.2,-2.1 4.4,1.8 2.6,-1.8 2.9,0.5 0.3,4.9 h 5.2 l 1.6,4.9 2.1,-3.4 h 2.1 l 5.2,2.1 h 4.2 l 4.2,1.6 1.6,-3.6 4.2,-1.3 -2.3,-2.6 1.6,-1 8.5,0.2 0.1,5 1.6,4.3 3.7,1.8 0.9,4.5 3,1 4.7,5.9 0.8,4.3 -1.1,3.6 0.4,4.5 -4.6,-3.3 -2.9,0.2 -1.5,1.7 -2.8,-1.5 v 2.2 l 1.5,1.1 -2.4,2.2 h -4.6 l -2,0.9 -10.6,2 -2.4,-0.2 -1.7,2.8 -3.7,2.8 -4,-0.7 -2.9,-4.2 -13,1.5 -3.7,3.5 -4.8,-2.6 -1.5,-11.2 -1.1,-1.1 1.1,-3.3 -0.9,-6.4 -3.7,-1.7 -5,0.4 -0.4,-0.7 4.8,-6.2 -0.4,-1.5 h -2.9 l -0.4,-7.9 -5,0.2 -0.7,1.3 -4.2,0.4 0.2,7 -6.2,0.6 -1.7,2.2 -2.4,-3.9 -3.9,1.7 0.4,2.2 -2.4,1.8 1.5,14.5 -3.9,0.7 -2.6,2.9 -0.2,2.2 -0.4,1.8 1.1,1.3 -3.1,2.8 -5.9,-0.9 -2.6,-3.5 -6.6,-0.9 -1.3,1.7 -16,2 -2.8,-0.9 -0.9,2.8 1.3,2.8 -0.6,7 -0.7,1.8 v 2.2 l 1.5,2 -5.1,1.5 -2.6,2.2 -9.2,-0.9 -0.7,2 0.2,2.4 -8.4,5.3 -0.2,3.7 -9.7,8.1 2,2.4 -13,6.2 -6.8,-0.2 -2,-2.4 -2.6,1.8 v 6.8 l -3.7,0.6 -2.2,0.7 -1.8,3.9 -1.5,0.6 -2.9,-2.9 -6.2,-1.1 -5.1,1.7 -1.5,4.6 -5.1,1.5 -3.5,3.7 0.6,2.2 -4.8,1.1 -5.3,4.6 -1.5,2.9 -7,5.1 -0.7,3.3 -2.6,1.8 -0.4,1.8 -3.5,-2.8 -4.4,-1.3 -0.6,-2.4 h -7 l -3.3,4.8 -3.1,0.7 0.7,5.5 3.7,2 0.7,8.6 -2.2,1.8 0.9,3.3 2.4,3.5 -1.1,16.5 -5.7,5.9 h -5.1 -1.1 l 1.1,2.2 -0.9,5.3 -2.4,-1.1 -7,3.3 -10.1,2.9 -6.4,-2.2 v -3.9 l -1.8,-1.7 -4,0.7 -3.1,-1.3 -2.9,-3.5 -19.1,1.3 -2.2,4.2 -3.1,7.5 -9.2,3.5 -6.4,2.6 -1.5,4 -3.5,2.2 h -3.5 l -1.1,-2 -3.7,0.2 -0.4,-1.1 -2.4,2.6 -2,-1.3 -0.9,-2.8 -8.3,0.2 -1.3,20.2 -2.4,1.3 -0.2,33.6 h 2.7 l 1.4,1.2 -4.4,4.2 0.3,1.6 2.1,1.8 -2.9,1.6 h -3.4 l -4.4,4.2 v 3.4 l -3.4,3.1 3.6,0.3 v 4.2 l -4.4,4.9 1.3,2.9 -4.9,1.8 0.6,3.2 -3.3,5.9 -5.4,-0.4 -2.9,-4.3 -4,0.2 -1,-10.7 -4.9,-5.8 -2.9,-2.4 -2.5,-2.4 -2.2,-3.5 -2.2,-4.2 -3.5,-3.2 1.1,-7 -2.2,-4.5 -2.9,-2.7 -4.5,0.5 -5.6,-0.5 -7.6,-5.6 -7.3,-3.4 -3.6,-9.1 0.3,-11.3 -2.8,-3.3 -7.1,-4.3 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(23,'path5061')" 
                           id="path5061"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2218.4,1133.6 3.1,-5 3.3,0.6 2.2,-1.3 2.2,-4.4 2.2,-1.1 3.5,-4.4 -1.5,-1.1 0.9,-1.5 0.7,-3.5 6.2,-2.4 0.6,-9.2 -2,-4.6 v -3.3 l 6.8,-7.3 4.4,-10.8 2.2,-0.4 7.5,-1.7 3.1,-2.8 v -4.6 l 2.6,-2 0.3,-3.1 7.6,0.8 3.5,-3 v 0 l 3.7,-3.3 3,-4.1 3.6,-9 -1.5,-8.7 v -5.5 h -4 l -1.7,-2.3 -1.5,-1.1 1.5,-1.1 0.6,-5.3 -2.6,-3.2 1.7,-2.6 v -4.7 l 1.9,-2.8 v -1.7 l -1.9,-0.9 -1.7,-2.8 -3.4,-1.5 -2.8,-4.1 -2.6,-1.3 -1.1,-1.9 1.9,-2.1 -1.3,-2.3 -3.4,-1.1 -0.4,-4.7 -1.7,-1.7 h -1.5 l -0.2,-1.5 h -1.1 l -0.4,-2.1 -1.9,0.4 -2.1,-1.3 h -3 l -3.2,-3.8 -1.2,-5.2 -3,3.8 -3.5,2.1 -8.7,5.5 h -3.6 l -10.2,4 -2,2.9 -5,-3.3 h -10.1 l -12.4,7.8 -2.6,5.4 1.6,2.2 2.2,-1.3 4.3,4 2.9,4.7 1.8,0.4 3.3,1.5 1.5,3.6 -1.5,5.5 -0.1,6.4 -7,5.5 -6.4,5.3 h -5.7 l -1.5,3.1 -1.5,1.5 -5.3,0.7 -2,1.7 v 2.2 l -2.6,0.9 -3.1,4 -2,-5 -2,1.7 -3.1,-2.4 h -2.6 l -4.2,-3.3 -2.4,1.1 0.2,3.9 -2.4,2 -5.7,1.3 -0.2,2.6 -5.3,7 -0.4,6.2 -4,4.4 h -1.4 l 0.7,6 -8.5,9.7 -8.5,8.3 -3.9,5.5 4.8,8.4 8.3,-5.4 7.9,-7.2 13.6,1.9 7.4,9.3 1.9,6.7 -0.5,6.5 5.8,4.9 6.1,-2.2 11.7,-4 5.6,4.8 5.1,0.8 5,3.3 5,13.7 3.5,3 7.3,0.9 6.7,0.6 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(20,'path5066')"  
                           id="path5066"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccc"
                           inkscape:connector-curvature="0"
                           class="st0"
                           d="m 2133.8,1063.8 h 1.4 l 4,-4.4 0.4,-6.2 5.3,-7 0.2,-2.6 5.7,-1.3 2.4,-2 -0.2,-3.9 2.4,-1.1 4.2,3.3 h 2.6 l 3.1,2.4 2,-1.7 2,5 3.1,-4 2.6,-0.9 v -2.2 l 2,-1.7 5.3,-0.7 1.5,-1.5 1.5,-3.1 h 5.7 l 6.4,-5.3 7,-5.5 0.1,-6.4 1.5,-5.5 -1.5,-3.6 -3.3,-1.5 -1.8,-0.4 -2.9,-4.7 -4.3,-4 -2.2,1.3 -1.6,-2.2 2.6,-5.4 12.4,-7.7 10.2,0.1 4.9,3.3 1.9,-2.9 10.2,-4 h 3.6 l 8.7,-5.5 3.5,-2.1 3,-3.8 1.2,5.2 3.2,3.8 h 3 l 2.1,1.3 1.9,-0.4 0.4,2.1 h 1.1 l 0.2,1.5 h 1.5 l 1.7,1.7 0.4,4.7 3.4,1.1 1.3,2.3 -1.9,2.1 1.1,1.9 2.6,1.3 2.8,4.1 3.4,1.5 1.7,2.8 1.9,0.9 v 1.7 l -1.9,2.8 v 4.7 l -1.7,2.6 2.6,3.2 -0.6,5.3 -1.5,1.1 1.5,1.1 1.7,2.3 h 4 l 0.3,5.3 3.9,-4.4 7.5,-4.8 3.6,-5.7 -0.6,-9.7 3,-8.1 10.5,-5.7 -0.4,2.2 2.3,2.9 8.3,3.9 2.6,2.6 6,-0.5 5.2,-8.6 -7.5,-1 -1.8,-3 v 0 l 4,-4.7 1.2,-3.6 9.9,-5.8 -4.2,-1.1 -4.4,-12.5 -4.9,-4.7 2.6,-2.6 2.1,-13.2 2.6,-0.8 1,-4.4 3.9,-2.6 0.3,-5.7 3.9,-3.1 -0.5,-7.8 4.9,-2.3 -4.4,-6 -9.6,5.5 -4.9,-1.6 v -8.3 l -3.1,-6.5 4.7,-15.8 2.6,-3.4 -7.8,-4.7 -3.1,-2.9 -10.1,-1 -7.8,-4.4 v -2.6 l -2.9,-2.6 8.8,-2.6 1,-5.7 7,-8.8 h 2.6 l 1.8,-1.6 15,-5.5 0.5,-3.9 8.3,-6.2 v -6.2 l -2.6,-1 3.1,-2.6 -0.3,-15.3 4.4,-8.1 9.6,-7.5 3.7,-5.4 -2.9,-2.6 -1.6,-0.3 -1.6,-1.3 -4.4,-1 -2.1,-3.6 -8.3,-1.6 -2.1,2.3 -1.6,-2.3 -4.4,0.8 h -3.6 l -0.3,-12.5 -0.7,-1.2 -25.9,-10.1 -5.5,5 -7,3.5 -7,-0.2 -7,-4 h -3.7 l -4.2,-0.2 -1.4,3.4 -2.1,2.6 -2.1,4.9 0.9,4.7 5.8,3.4 1.7,2.8 -2.1,7 -3.2,4.5 -0.6,6.4 -2.6,9.8 v 3.4 l -1.1,3.8 -3.8,1.9 -3.4,6.4 -0.4,5.3 -1.2,4 -2.9,3.3 2.8,2.6 -0.6,3.7 -3.9,0.2 -2.4,1.5 -4.8,-6.4 -4.2,0.4 -5.3,-2.8 -6.2,3.5 -3.5,4.8 -1.3,-1.8 -3.7,0.4 -4,-2.9 -9.4,5.1 -1.1,2.2 -8.1,0.7 -2.4,-0.7 -8.8,-2.2 -4.6,-3.5 -1.7,5.3 -3.7,3.9 -5.7,1.1 -6.2,4.2 -6.1,0.2 0.7,4.6 -0.2,4 -4.2,2.9 -0.7,2.6 h -3.7 l -0.9,-2.4 -6.6,-0.9 -0.2,2.9 -2.8,1.5 h -5.7 l -0.4,3.9 -9.7,5.1 -5.1,-1.3 -2,3.3 -3.3,1.8 -4.6,0.2 -2.4,2.9 -9,3.1 15.2,17.8 0.3,14.5 -6.6,13.9 -6.9,3 -1.8,8.9 1.1,8.4 7.1,8.5 6.8,2.2 4.6,-5.7 5.5,-1.3 3.5,7.1 -0.3,24.1 3.2,3.4 7.2,1.1 4.2,-0.7 2.5,3.2 1.4,5 -1.4,2.4 -0.9,5.9 -0.8,6.6 -3.3,4.3 -6.7,3.1 -5.3,5.8 -5.4,3.8 -4.3,5.2 -1.5,5.9 c 0,0 0.7,5.5 0.7,7.1 0,1.6 6,2.7 6,2.7 l 5,8.7 4.1,3.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(19,'path5071')" 
                           id="path5071"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st3"
                           d="m 2129.4,764.6 6.6,-3.2 1.1,-3.3 6.8,-0.7 4.4,7.2 4.8,2.4 1.3,2.6 7.7,-5.3 15.6,-6.2 6.1,4.8 13.4,0.2 4.9,-0.7 6.1,1.5 1.7,6.1 8.3,-1.5 1.1,2.8 6.8,1.7 4.6,-0.2 1.5,3.7 h 3.9 l 8.1,2.8 3.5,4 h 4.6 l 7,7.2 1.8,5.1 8.7,5.4 -0.5,1.7 v 3.4 l -1.1,3.8 -3.8,1.9 -3.4,6.4 -0.4,5.3 -1.2,4 -2.9,3.3 2.8,2.6 -0.6,3.7 -3.9,0.2 -2.4,1.5 -4.8,-6.4 -4.2,0.4 -5.3,-2.8 -6.2,3.5 -3.5,4.8 -1.3,-1.8 -3.7,0.4 -4,-2.9 -9.4,5.1 -1.1,2.2 -8.1,0.7 -2.4,-0.7 -8.8,-2.2 -4.6,-3.5 -1.7,5.3 -3.7,3.9 -5.7,1.1 -6.2,4.2 -6.1,0.2 0.7,4.6 -0.2,4 -4.2,2.9 -0.7,2.6 h -3.7 l -0.9,-2.4 -6.6,-0.9 -0.2,2.9 -2.8,1.5 h -5.7 l -0.4,3.9 -9.7,5.1 -5.1,-1.3 -2,3.3 -3.3,1.8 -4.6,0.2 -2.4,2.9 -9,3.1 -11,-6.9 -5.1,-5.1 -6.5,-7.5 -3.1,-6.4 -3.3,-8 0.3,-8.3 2.7,-10.3 3.9,-7.2 0.6,-19.9 10.5,-9.3 16,-5.1 7.3,-7.3 2.5,-6.5 10.4,-6.1 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(15,'path5187')" 
                           id="path5187"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st2"
                           d="m 2126.9,756.1 -14.7,-12.1 -3,-7 -0.6,-2 4.3,-3.4 h 2.9 l 2.2,-3.7 2.4,-0.9 2,3.1 0.2,-3.5 2.2,-4 7.5,-2.6 5.1,-8.1 4.2,1.7 1.8,1.3 h 5.5 l 0.9,1.8 -1.3,4.4 1.3,0.9 3.1,-3.1 4.2,-0.2 2.8,-3.3 -1.3,-5 2.2,-1.3 2,-3.5 -2.2,-3.9 v -6.2 l -5,-4.2 -1.8,-5.1 4.4,-2 1.7,-1.3 2.6,-0.2 0.4,-1.1 -2,-3.5 5.1,-3.7 2.4,-3.3 -2,-4.2 7.5,-6.8 h 5 v -2.9 l 3.3,-2.9 -2.2,-4.4 -2.5,0.2 -1.7,-1.5 4.4,-6.6 -1.5,-2.8 0.6,-1.7 7.9,-0.4 -3.9,-8.1 -2.8,-4.6 -2.4,0.9 -3.9,-2.8 h -2.8 l 0.9,-3.3 1.8,-0.2 0.9,-2.4 2,-0.7 1.1,-1.8 -0.6,-3.9 3.2,-4.3 1.4,0.3 1.5,4.2 0.2,3.1 5,7 2.9,0.2 3.3,6.2 2.8,1.8 12.1,-5 2.9,-0.4 3.3,-1.7 1.8,2.2 v 2.4 l 3.1,2.2 v 3.1 l 2.2,-0.7 4.6,-1.3 3.5,0.7 h 4.8 l 4,2.8 2.2,-0.6 2.6,5 2.4,-0.2 1.7,1.2 v 0 l -0.6,4.9 2.6,4.6 -2.2,5.1 -3.9,5 -0.2,5 1.1,2.2 -5,2.6 -0.2,2.6 -7.9,0.2 -0.6,3.5 2,2.6 -2,2.8 v 5 l -5.1,0.6 -4.2,-2 -3.9,2.9 2.4,1.1 1.1,11.6 -2.6,2 3.7,1.3 1.1,2.2 2.9,1.1 0.6,3.9 -1.3,2.6 2.4,6.6 -1.5,6.2 -3.1,0.2 -4.4,4 -5.1,0.9 -1.1,-1.7 -1.1,1.3 0.6,5.3 2.6,5.7 -3.5,2 -0.2,4.8 -2.2,0.7 -4.6,-1.3 -3.3,-4 v -2.8 l -3.5,-0.9 0.6,2.6 -0.4,2.2 1.8,2.8 -1.7,1.3 -0.6,7 3.5,7.4 -5.3,0.9 -13.4,-0.2 -6.1,-4.8 -15.6,6.2 -7.7,5.3 -1.3,-2.6 -4.8,-2.4 -4.4,-7.2 -6.8,0.7 -1.1,3.3 -6.6,3.2 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(14,'path5147')"
                           id="path5147"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st0"
                           d="m 2056.3,629.6 -6.8,12.8 -3.4,6.4 -0.7,6.9 -4.5,9.5 -7.9,16.6 2.6,12.8 6.6,8.4 7.9,3.8 10.8,-2.9 9.8,0.5 3.3,4.4 12,4.5 9.3,7.6 12.1,10.6 1.1,3.5 4.3,-3.5 h 2.9 l 2.2,-3.7 2.4,-0.9 2,3.1 0.2,-3.5 2.2,-4 7.5,-2.6 5.1,-8.1 4.2,1.7 1.8,1.3 h 5.5 l 0.9,1.8 -1.3,4.4 1.3,0.9 3.1,-3.1 4.2,-0.2 2.8,-3.3 -1.3,-5 2.2,-1.3 2,-3.5 -2.2,-3.9 v -6.2 l -5,-4.2 -1.8,-5.1 4.4,-2 1.7,-1.3 2.6,-0.2 0.4,-1.1 -2,-3.5 5.1,-3.7 2.4,-3.3 -2,-4.2 7.5,-6.8 h 5 v -2.9 l 3.3,-2.9 -2.2,-4.4 -2.3,0.2 -2.8,1.7 -2.6,-1.1 -3.3,6.2 -2.8,1.8 -2.8,-2.9 -2.8,3.3 -6.2,2.8 -5.7,0.2 -3.1,-3.5 -3.1,-0.2 -12.1,-8.4 -0.6,-6.4 -3.5,-1.3 -0.4,-2.9 -2.2,-1.5 -2.4,0.9 -4.5,-0.6 -2.1,-3.9 -6.8,-4.6 -8.4,3.3 -2.9,3.1 -2,0.4 -3.1,2.9 -4,0.7 -3.1,-1.7 v 1.8 l -2.6,-0.4 -2.6,1.8 -2.8,0.5 -6.1,1.1 -2.3,-3.6 -5.1,-3.3 1.7,-3.3 0.2,-3.7 -8.6,-0.5 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(10,'path5136')"
                           id="path5136"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st0"
                           d="m 2465.4,462.9 -1.8,-4.4 -3.7,-2.1 -0.6,-6.1 -4.2,-4.5 -3.2,-0.9 -1.9,-3.4 v -5.4 l -3.2,-7.8 -1.2,-3.5 -4.3,-3.2 -1.2,-2.3 -2.6,-4.6 v -2 l -4.3,-1.4 -2.6,-1.2 -3.2,-2.3 -2.3,-5.2 v -1.4 l -2.3,-1.2 -3.2,0.6 -2.9,-0.9 -0.6,-1.4 -1.7,-0.9 h -2.6 l -2.6,-1.2 -1.4,-2 -1.4,0.3 -0.9,1.4 -4.9,1.7 -8.3,-1.2 -3.7,-2.3 -4.3,0.3 h -3.5 l -3.2,-2.3 -3.5,-4.6 V 386 l -2.6,-1.7 h -5.8 l -3.2,1.4 -2.9,0.6 -0.6,-1.2 -3.2,-0.6 -1.7,-1.4 -4,-5.8 -3.2,-2.6 -2.9,-4 -4.6,-1.7 -3.2,-2.6 -3.7,-1.2 -2.3,1.9 0.5,4.9 -0.6,3.5 2.9,2 h 2 l 2.8,4.2 -4.8,6.8 3.9,0.9 0.9,5 -4.4,6.4 0.4,5.3 -16.3,11.9 1.8,4.4 -7,4.6 -2.9,4.8 -5,1.7 -1.8,-1.7 -2.4,1.8 -4.8,-5.3 -1.5,2 -0.9,4 -11,-2 -1.1,-1.1 -2.9,3.9 -3.1,-0.2 -5.7,2.6 2.8,2.6 -2,5.7 1.7,2.8 -4.4,2 -3.9,-3.3 -36.3,0.2 -0.7,-2.8 1.7,-2.9 -2.8,-2.2 -5.3,2.6 -5,-0.6 -5.9,-3.5 -0.6,7.9 -2,1.8 0.2,16 -2.4,6.2 -6.2,7.3 3.1,-0.2 2.6,2.6 4.2,3.7 1.5,5.1 2,-2.4 3.1,-0.9 4.4,2.2 7.3,0.2 -0.7,6.1 -2.8,2.6 0.4,6.8 2.4,2.2 -1.1,6.1 h -1.7 l -1.7,0.6 1.5,5.3 3.1,4.4 -0.9,3.7 -1.7,1.5 1.3,6.1 1.7,1.7 0.4,2.4 -1.1,1.5 1.1,1.7 -0.2,15.6 2.8,4.4 3.3,-0.7 0.2,-2.2 5.3,-2.6 1.5,1.3 4.6,-0.6 4.6,-2.9 5.7,0.6 0.6,-0.9 6.4,4.2 -0.9,2.4 2.4,4.4 0.2,7 -1.8,5.7 10.3,11.4 0.7,2.2 -0.9,2 1.7,1.1 0.4,2.4 5.9,4 2,3.9 2.4,1.1 5.5,1.8 v 3.5 l 5,4.4 3.7,2.9 v 5.9 l 3.9,4.6 1,5.3 5.6,1.2 1.5,2.4 -0.9,3.1 2.9,2.9 4.2,0.4 2.4,2.4 v 3.7 l 5.8,0.6 1,-4.7 1.3,-2.9 h 4.2 l -0.6,-4.8 -2.1,-5.9 -1.6,-6.7 1.7,-5.8 4.6,5.3 1.3,-2.8 -0.2,-3.3 4.4,-0.5 2.6,-4.9 5.1,-0.2 2.2,-0.4 2.9,2.2 0.9,7.3 3.9,0.7 7.9,0.8 1.7,4.2 1.6,3.2 3.3,1.5 4.7,0.4 2.1,4.1 -1.5,5.5 1.8,2.4 3.1,-1.7 3.5,1.1 2.2,3.1 2.2,-1.1 10.5,2.6 5.5,5.7 6.4,2.2 2.2,-2.6 3.7,1.7 -1.7,3.3 5.1,6.2 5.5,0.2 2.6,3.5 -1.5,1.3 0.9,4.2 3.1,0.2 0.2,3.5 2.9,3.7 1.7,-0.4 6.1,2.8 0.2,3.7 1.7,2.4 3.7,0.6 1.7,4.6 2,0.4 0.6,-2.8 h 2.9 l 2,2 V 692 l 1.7,-1.5 -1.1,-4.4 2.8,-2.9 -2.2,-4.6 3.1,-2 0.4,-11.9 -2.4,-2.9 -4.6,-4.8 0.9,-2 2.6,-0.2 7.9,-1.3 5.1,-2.8 v 0 -2.7 l 1.7,-1.5 0.2,-2.4 3.1,-1.8 -0.2,-5.3 1.5,-1.7 -0.6,-3.9 4.6,-2.9 -1.5,-2.8 2.4,-4.4 2.2,-0.9 0.7,-3.7 -1.3,-1.8 2.9,-3.5 0.6,-7.9 -2.6,-3.7 1.8,-2.6 -2.6,-2 2.6,-3.5 0.4,-6.1 3.3,-7.5 7.3,-2 -0.4,-3.7 3.3,-2.8 -0.9,-3.1 -2.2,-0.7 1.7,-1.7 2.8,-0.4 1.3,-3.9 0.1,-2.5 -4.3,-5.9 -4.6,-2.4 -3.7,-7 v -2 l -3.7,-1.5 -0.2,-9 3.3,-0.2 0.7,-5.5 -2.2,-0.9 v -2.8 l 2.2,-2.4 -2.8,-4 1.3,-8.3 -1.8,-3.9 -3.5,-1.8 0.2,-3.1 -3.3,-4.4 -0.7,-3.7 2,-1.1 0.6,-4.6 -2.6,-1.8 -5.7,-1.1 -5.9,-3.1 -2.6,-6.1 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /><path onclick="cambiar(1,'path2625')"
                           id="path2625"
                           sodipodi:nodetypes="ccccccccscccccccccsccccccccccsccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st0"
                           d="m 2471,124.2 2.1,-3.6 3.1,1.3 8.3,-6.5 3.6,-3.4 h 4.2 l 1.3,1.6 9.1,-1.8 c 0,0 5.4,0 7,0 1.6,0 3.4,2.3 3.4,2.3 l 3.9,-3.9 1.3,-0.3 4.9,-2.1 3.6,2.1 3.1,-0.3 -2.1,4.7 2.9,2.6 v 8.3 c 0,0 1.6,0.3 3.6,0.5 2.1,0.3 2.3,2.9 2.3,2.9 l 5.4,-3.4 1.3,2.6 1.3,2.9 -1.3,3.4 5.4,3.9 7,-2.6 4.2,0.5 3.6,-3.9 4.7,0.3 c 0,0 2.6,4.2 2.6,5.2 0,1 -2.1,1.6 -2.1,1.6 l -0.8,7.8 3.6,2.9 3.1,-1.6 0.8,2.3 7.8,2.6 1.6,1.8 1.8,-0.8 0.3,-4.9 3.4,0.8 5.2,-0.8 3.9,3.4 v 2.3 l 4.4,3.9 1,4.7 3.4,-1.6 6.2,0.5 2.6,3.1 5.7,-0.3 5.4,0.5 5.4,2.9 2.9,-1.8 6.7,-0.5 2.3,-3.4 3.9,4.7 v 5.7 l 1.8,1.3 1.8,-0.8 4.2,0.5 2.3,3.1 9.1,-0.5 5.4,0.5 3.9,5.2 -2.6,3.1 -1.3,3.9 3.9,4.4 -1,5.7 -1.6,2.3 1.3,5.5 -2.3,2.1 2.3,4.4 -3.6,4.2 1.8,2.6 -2.3,4.9 -4.7,1.6 -0.3,3.9 -1.8,3.6 3.9,1 0.3,5.2 4.2,-0.8 v 1 l 3.4,4.2 -1,3.6 5.4,2.1 7,-4.2 v 3.9 l 5.4,0.3 3.9,2.6 5.2,-2.3 3.1,1.8 9.3,-1 3.6,-3.4 13,-6.2 4.1,3.1 v 0 l -4.7,4.8 -3.1,0.2 -2.4,2.8 -6.1,0.4 -0.9,-0.6 -7.8,5.8 -4,3.5 -3.9,5.7 v 4.5 l -1.8,3.1 -2.9,1.8 -1,2.2 0.4,4.5 -2.2,2.7 -8.3,3.3 -7.1,5.5 -4.5,2 -1,3.9 v 1 l -2.9,4.7 -5.7,2.2 -3.5,2 -4.9,4.9 -4.1,2 -7.1,5.5 -3.3,0.6 -2.2,-0.6 -3.7,0.2 -5.5,3.5 -2.9,1.2 0.6,2.7 -1.8,2 -1,-0.2 -2.2,-2.7 -2,2.4 -1,3.5 -2.6,2.7 -2,-0.8 -2.6,0.4 0.2,0.6 3.3,0.8 -1.4,2.4 -2.9,-0.8 -2.2,-0.6 -4.9,1.4 -3.1,0.8 -2.2,2.7 -6.3,5.1 -5.3,2.7 -5.3,1.6 -2.6,3.3 -5.9,3.3 -2.2,-0.2 -1,-0.8 -0.8,1 -0.2,2 -1.4,3.1 -1.8,1.6 -4.9,4.1 -8.1,2.9 h -3.1 l -4.1,3.1 -3.9,3.3 -0.2,4.9 -1.4,2.9 0.4,3.7 -1.8,5.9 -3.9,1.8 -2.2,2.9 -0.4,1.6 -3.7,-0.2 -2.9,-2.7 -2.4,-1.2 -1.4,-3.1 0.2,-2 -1.8,-5.3 -2,0.2 -1,1.6 -4.3,0.2 -1.8,1 -1.6,-2 v -2.2 l -1,-1.2 -2.2,-0.4 -2.2,1 -3.7,-0.2 -2.4,0.5 0.3,-2.4 1.7,-0.7 2.8,-2.4 -1.1,-2 h -2.6 l -0.4,-1.7 2,-2.2 2.8,-0.7 -0.6,-2.9 1.3,-0.6 4.6,-5.1 h 2.8 l -1.3,-4 -1.5,-0.9 4.6,-3.5 6.4,-0.4 0.2,-2.8 -3.7,-1.8 v -1.3 l -2.4,-5.1 1.7,-1.5 -2.2,-2.8 3.9,-5.1 h 2.2 l -2,-3.3 2.8,-1.5 3.9,-2.4 4.6,-4.6 2.6,-0.2 1.5,-4.6 h 2.8 l 2.8,-3.5 -0.4,-3.9 1.5,-0.2 -0.2,-9.9 2.8,-4 0.2,-2 0.9,-1.5 -0.6,-0.7 -2.4,0.2 -0.2,-1.7 2,-3.5 0.4,-3.7 -2,-5.5 -7,-4 -2,0.2 -0.7,-1.3 1.1,-0.9 -0.2,-1.8 2,-0.4 -0.4,-1.8 3.1,-0.2 -2,-7 -7.5,-11.6 1.7,-6.8 -1.7,-1.8 4,-3.3 1.3,-3.3 -1.7,-3.3 v -2 l -7.3,-5.1 -2.6,0.2 -0.2,8.4 3.1,3.1 -3.7,8.4 -2.9,0.4 -2.6,1.8 -0.2,3.7 -1.3,0.4 -4.2,-6.8 -2.6,-2.6 v -6.6 l 1.5,-0.9 -4,-7 -1.1,-5.1 2.9,1.8 3.1,-4.2 -2.4,-1.8 -1.3,-7.5 -3.7,-0.4 -3.5,-4.8 1.7,-1.1 0.7,-2.8 -4,-7.7 -6.8,-3.3 h -4.2 l -2.8,1.8 -6.1,-2.2 -6.6,3.3 h -2.2 l 0.9,2.8 c 0,0 0,0.6 -1.1,0.9 -1.1,0.4 -5.7,0.7 -5.7,0.7 l 1.8,2 -2,1.8 2,2.2 -2.4,1.7 -0.2,4.8 -3.5,-1.3 -2.8,4.2 2,0.9 0.2,2.8 2.4,2.8 -0.9,2 -9.4,0.4 -0.2,5.1 3.5,1.5 8.8,-0.2 0.6,4.4 -2.9,5.9 1.3,2.4 1.8,0.2 1.1,3.1 -1.7,2.8 -2.8,-0.2 -2.6,1.7 h -8.6 l 1.5,-2.6 -1.5,-0.9 -3.3,0.7 -2.6,4.2 -1.1,-2 -4,-0.8 -1.1,-2.7 -4.8,1.1 -0.7,-2.4 -3.1,0.7 -2,-1.7 1.7,-1.7 0.7,-2 4,-1.3 v -2.4 l -2.6,-2 1.7,-4.8 2,-0.6 0.2,-1.5 3.1,-1.5 3.7,-5 -0.9,-3.3 v -2.8 l -3.9,-5 0.7,-44.6 7.7,-5 4,-4.1 1.6,-3.9 0.4,-4.1 1.9,-1.6 6.7,-4.9 -0.2,-1.9 -0.2,-2.5 5,-3.9 2.5,-4.2 1.9,-3.2 -1.5,-2.6 z"
                           style="fill:#d9d9d9;stroke:#646464;stroke-width:0.5;stroke-linejoin:round;fill-opacity:0.28627452" /></g><g
                         id="layer10"
                         transform="translate(-2196.3206,-270.19498)"
                         inkscape:groupmode="layer"
                         inkscape:label="Departamentos"><path
                           id="path5008"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccscccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st5"
                           d="m 2841,13.5 -2,-1.1 -8.7,1.5 -5.6,2 -7.2,0.2 -5.6,2.2 -3.9,-1.3 -10.2,2 -3,1.3 h -2.4 l -2,-2.2 -9.3,-2.4 -2.8,-1.3 -2.8,1.3 -1.1,1.5 -1.7,-0.7 -2.8,2 h -2.2 l -6.8,-0.9 -1.1,-1.6 -11.3,-2.6 -9.1,-3.3 -4.4,0.5 -5.1,5.9 -8.6,0.4 -9.3,-2.7 -12.8,-3.3 -11,-3.7 h -9 l -2.6,-3.5 -7.3,-3.7 -9,-7.5 -4.6,-3.5 -5.7,-0.4 -3.3,-1.1 -2.4,-2 -6.6,-1.6 -1.5,-1.3 h -2.4 l -2.2,-1.5 -6.2,-0.2 -2.6,-1.6 0.5,-2 -1.8,-2.6 -1.1,1.5 -1.5,-1.6 -0.2,-2.4 h -2.7 l -0.7,-1.5 -2.4,-0.5 -0.7,1.1 -2.6,-2.2 1.6,-1.1 -1.6,-1.8 h -6 l -1.3,2 -2.7,-3.5 -5.7,0.4 -2.6,-1.5 -2.2,2.2 -1.5,-2.9 -3.3,1.1 -2.7,-0.4 -0.5,-2 h -2.4 l -1.8,1.1 0.2,1.8 -2.6,0.2 -0.4,2 -1.1,-0.7 -2.7,-2 0.5,-2.6 -1.3,-1.5 -2.2,0.9 -3.7,1.5 -1.1,2.4 1.3,2.7 1.8,1.5 -1.8,3.5 -2,0.5 -1.6,-0.7 -2.7,0.2 v -1.8 l 2.4,-0.5 -2.2,-2.9 -1.6,-0.7 0.5,-2 1.3,-1.8 -2,0.2 -1.3,2.9 -3.3,-0.9 -1.3,-1.5 -0.4,2.2 -0.9,3.7 -1.6,0.7 2.9,3.5 -0.9,2.6 0.4,2 -1.3,2.7 -3.5,-1.1 0.9,-2.6 -1.6,1.3 -1,-1.4 -2.6,2.2 -2.2,-1.5 -1.6,-3.3 1.5,-2.9 1.3,-1.3 -1.3,-3.7 -1.3,1.3 -2.2,-1.1 -1.5,-1.1 -0.4,-3.5 -0.7,-1.3 -3.1,2.6 v 1.8 l 2.4,4.2 -0.2,1.8 2.4,2 0.9,2.4 -1.5,1.6 -1.3,2.2 -2,-0.9 0.9,-1.6 -0.5,-1.3 -2.7,0.2 -1.6,-2 1.5,-1.3 -4,-1.6 -0.7,-1.8 -2.5,0.9 v 1.8 l 0.5,1.1 -1.3,2.6 2.4,2.4 -2,1.3 -1.8,-0.4 -1.1,0.9 h -1.8 l 0.9,-1.8 v -3.7 l -2.2,1.1 -3.1,-1.5 2.4,-2.4 v -2 l -4.2,-1.3 v 2.2 l -2.7,0.7 -0.5,4 -2.7,1.1 -2.6,-1.6 -1.1,1.1 4.6,5.9 1.1,3.5 3.1,2 v 1.6 l 1.5,1.5 -4.4,1.9 -2.2,-0.2 -1.1,-1.8 h -1.5 l -1.3,3.5 -2.9,-0.7 -0.4,-4 1.8,-1.8 -3.1,-0.4 -1.5,-0.7 -1.3,1.1 -1.3,0.9 -1.8,-0.5 -1.6,1.1 -0.9,2.4 -1.8,-0.4 v -1.6 l -2.2,-0.9 -1.3,0.4 0.4,3.1 1.8,1.3 -1.1,2.4 -1.8,3.8 -1.3,2 -0.2,1.8 -1.3,0.2 -0.9,1.8 -2.4,0.4 v 2.7 l 3.7,0.4 1.5,-0.7 0.4,2.4 3.1,0.2 0.2,1.8 -2,0.5 -2.6,0.9 -1.3,1.8 -6,2 -3.3,-0.7 -2.6,2.6 0.7,1.3 2.4,-1.6 1.1,0.9 -1.3,1.6 0.9,1.1 v 3.1 l -3.5,4.4 -2.2,1.5 -0.4,1.5 h -3.1 l -2,1.5 -1.5,3.1 h -1.5 l -1.1,0.5 2.6,2.7 1.5,0.7 v 2.2 l -1.1,1.3 2.7,0.5 1.1,4.4 -2.2,8.8 -3.8,2.9 v 2 l -1.5,1.1 1.1,1.8 2.6,1.6 2.4,9.1 2.2,7.7 -2.7,5.7 -1.3,4.8 0.5,2.7 -1.3,2.2 v 1.1 l 2.2,0.5 v 2.7 l 1.5,2.4 3.1,0.9 2,4.9 1.1,5.7 -0.9,4.6 1.6,3.8 1.6,2.1 -1.9,3.2 -2.5,4.2 -5,3.9 0.2,2.5 0.2,1.9 -6.7,4.9 -1.9,1.6 -0.4,4.1 -1.6,3.9 -4,4.1 -7.7,5.1 -6.2,4.6 -10,3.3 -15.8,6.2 -22,3.5 -28.8,0.4 -4.6,0.2 h -20.9 l -20.8,-4.9 -15.8,-2.5 -3.2,-1.9 -4,0.4 -12.8,-4.9 -28.3,-9.5 -8.3,-1.9 -18.2,-3.8 -12.4,-6.4 -8.7,-4.4 -3,-1.8 -37,-15.7 -3.3,-1.6 -2.4,-2 -11.8,-5.4 -6.1,-0.7 -4.3,-2 -0.7,-1.3 -1.7,-0.7 -5.4,0.8 -10.5,-3.3 -5.7,-2.7 -7.4,-2 -6.5,-3.5 1.8,3.8 0.9,5.6 2,2.5 2.5,3.8 v 3.3 l 0.3,4.8 4.1,8.5 5.4,5.5 2.9,2.6 3,0.5 1.3,0.5 7.9,0.5 4.5,1.3 3.4,6.1 3,2.1 8.6,12 7.1,14.2 1.1,5.5 -0.4,3.9 0.3,3.3 -0.4,3.4 -0.3,0.7 0.1,3.4 0.5,3.9 1.2,4.3 3.6,3.1 4.9,2 2.2,2.1 6.2,2.6 3.3,2 -0.4,3.7 -8.4,6.6 -2.2,3.2 0.6,4.7 0.4,3.8 -0.3,3.6 -0.8,2.4 0.3,7.1 -2.4,6.3 v 5.4 l 3.5,9.7 -0.1,8.1 2.6,9.2 2.9,5.7 0.9,8.5 -2.3,6.1 0.4,8.5 1,9.2 1.8,9.1 1,5.3 v 9 l -2.9,10.1 -2.5,3.2 -3,1.6 -3.8,1.9 -3.4,3.5 -0.5,2.6 1.7,4.2 6.3,5.7 2.5,1.9 2.6,8.2 -0.4,3.8 0.4,3.5 -7.2,10.4 -0.3,19.8 -2.6,6.9 -9.3,3.6 -3.5,3.4 -6.5,1 -3,5.3 -3.1,3.9 -3.2,3.6 -3.2,0.7 -2.6,1.8 -1.8,5.8 0.7,3.4 -0.9,2.9 -3.5,3.2 -0.8,5.2 -1.6,8.9 -0.1,5.6 0.1,2.6 -1.7,3.9 -3.4,5.3 -2.2,3.8 -2.1,2.6 -2.9,1.8 -5.7,2.6 -6,3.6 -4,6 -2.2,4.5 0.8,16.5 -2.3,6.5 -1.8,5.2 -7.9,11 -1.4,3.5 -5.2,6 -2.9,11.2 -3.8,13.6 -3.4,5.4 0.3,10.6 -6.8,12.8 -3.4,6.4 -0.7,6.9 -4.5,9.5 -7.9,16.6 2.6,12.8 6.6,8.4 7.9,3.8 10.8,-2.9 9.8,0.5 3.3,4.4 12,4.5 9.3,7.6 12.1,10.6 1.8,5.5 3,7 14.7,12.1 2.5,8.5 -3.5,5.5 -10.4,6.1 -2.5,6.5 -7.3,7.3 -16,5.1 -10.5,9.3 -0.6,19.9 -3.9,7.2 -2.7,10.3 -0.3,8.3 3.3,8 3.1,6.4 6.5,7.5 5.1,5.1 10.9,6.9 15.3,17.9 0.3,14.5 -6.6,13.9 -6.9,3 -1.8,8.9 1.1,8.4 7.1,8.5 6.8,2.2 4.6,-5.7 5.5,-1.3 3.5,7.1 -0.3,24.1 3.2,3.4 7.2,1.1 4.2,-0.7 2.5,3.2 1.4,5 -1.4,2.4 -0.9,5.9 -0.8,6.6 -3.3,4.3 -6.7,3.1 -5.3,5.8 -5.4,3.8 -4.3,5.2 -1.5,5.9 c 0,0 0.7,5.5 0.7,7.1 0,1.6 6,2.7 6,2.7 l 5,8.7 4.1,3.5 0.8,7.3 -8.5,9.7 -8.5,8.3 -3.9,5.5 4.8,8.4 8.3,-5.4 7.9,-7.2 13.6,1.9 7.4,9.3 1.9,6.7 -0.5,6.5 5.8,4.9 6.1,-2.2 11.7,-4 5.6,4.8 5.1,0.8 5,3.3 5,13.7 3.5,3 7.3,0.9 7.8,0.8 7.1,4.3 2.8,3.3 -0.3,11.3 3.6,9.1 7.3,3.4 7.6,5.6 5.6,0.5 4.5,-0.5 2.9,2.7 2.2,4.5 -1.1,7 3.5,3.2 2.2,4.2 2.2,3.5 2.5,2.4 2.9,2.4 4.9,5.8 1,10.7 4,-0.2 2.9,4.3 5.4,0.4 4.9,-5.3 8.1,-4.7 7.3,-7.1 5.8,-4.4 11,-3.6 3.3,2.3 5,-0.9 1.3,5.1 1.9,6 3.3,6.7 2.9,6.5 6.1,10.7 7.8,2.5 5.5,-5.2 8,-3.7 12.4,-2.3 6.6,1.5 4.6,2.9 4.9,2.4 15.2,9.5 2.5,6 0.4,5.1 -4.5,4.6 -1.3,5.2 1.2,4 3.1,3 9.3,-2.8 7.7,-4.4 4.2,1 4.5,-1.4 3.7,3.1 3.6,6.5 6.4,7.7 2.6,2.6 0.9,2.3 -4.7,2.7 3.2,5 6.3,-1.4 1.6,4.5 5.5,7.5 4.7,4 3.5,0.3 4.6,1.1 3.1,2.9 -1.4,4.4 2.7,3 2.6,1 2.2,0.7 4.2,-1.1 2.4,3.5 -2.8,2.7 0.3,3.9 h 7.1 l 2.7,-1.3 2.5,-1.7 h 1.8 l 4.6,5.2 2.8,2.4 -0.9,3.6 -3.6,1.5 -1.8,-1.3 -3.7,2.2 2.3,4.6 2.6,1.8 5.3,-2.6 4.6,-1.8 3.3,2 -0.9,2.6 2.6,3.5 6.9,3.8 6.8,-4.3 2.9,-2.2 3.3,0.2 4.8,4.3 4.4,0.4 5.9,-5 2.2,-6.1 -0.2,-2.8 3.4,-1.2 h 2.2 l -0.3,8.3 4,3 5.2,0.6 6.2,-5.3 5.2,5.3 2.6,4.2 5.7,3.9 -2.4,1 -5.7,-2 -2.5,4.4 0.3,5.2 h 6.9 l 3,3.7 5.1,-0.7 4.8,2.4 2.3,-2.9 0.8,-2.1 3.4,-0.5 6.8,1.6 2.5,5.2 3.4,1.1 4.6,-0.2 3.5,4.9 5,-2 h 8.6 l 2.9,-1.8 1.8,0.4 14.3,21.9 11.1,-5.9 -1.6,-6.2 3.8,0.2 4.1,-1.8 0.9,-3.4 3.5,-3.7 -3,-3.3 4.7,-2 -0.1,-6.1 2.6,-1.9 -0.6,-12.8 4.2,-4.3 3.1,2.6 2.6,-2.1 -1.3,-2.5 0.8,-2.3 h 3.2 l -3.2,-4.6 4.3,-0.6 3.8,0.8 -1,-3.2 2.3,-3.8 -5,-5.1 -5,-5.1 -5.9,-3.1 -3.3,-3.8 -4.4,-2.3 -10.1,-8.2 -9.3,-6.5 -4.7,-9.6 0.1,-10.7 6,-7.6 1.7,-8.3 -3.1,-5.7 -7.9,-1.2 -4.2,2.8 -1.8,3.7 -9.7,-0.3 -19.2,-5 -7.6,1.3 -5.8,-4.9 1.9,-5.1 -3.9,-6.5 -0.6,-4.5 3.3,-3.5 2.2,-3.3 5.7,-5.9 -2.9,-10.7 5.2,-3.9 -2.5,-5.8 0.4,-4.8 1.8,-7.5 -5.7,-2.1 -2.3,-5 -12.1,0.3 -6,-6.1 -2.6,-7.2 2.8,-5.2 v -6.6 l -2.9,-4.3 4,-7.2 v -9.9 l 4.6,-4.9 -7.6,-4.3 -7.4,1.3 -5.7,-8 -7.1,-6.4 -8.5,-3.3 -7.3,-0.3 -2.8,-4.7 -7.6,-6.2 0.7,-3.9 -3.4,-3.1 -6.9,-1.8 -4,-4.8 -3.2,-6.3 -4.1,0.5 -3.3,-2.1 -6.3,-0.4 -1.1,-3 -6.7,-1.2 -2.2,-4.1 2.6,-3 7.1,-4.7 5.3,-3.1 6,-6.4 1.8,-7 5.8,-4.6 5.2,-4.3 0.3,-3.7 3.7,-1.3 0.7,-3 4.7,-4.2 2.4,2.4 4.6,-1.7 0.3,-4.6 5.4,-6.7 4.9,-2.9 12.9,0.4 1.7,-3.5 5.5,0.7 3,2.8 -0.7,5.8 5.8,1.6 2.3,-4.2 3.3,-2.3 4.7,1.9 h 1.8 l 1.6,-2.4 3.5,-1.4 0.8,1 h 1.4 l 1.4,-1 1,1 2.6,-1.8 2.5,-0.4 0.2,-3.5 h 1.5 l 1.6,1.6 2.9,-1.4 3.3,-0.4 2.9,-2.8 6.7,1.8 3.1,0.3 0.2,-3.7 2.6,0.4 1.8,-1.8 0.8,-2 2.6,0.4 3.5,-0.2 2,0.8 1.2,3.1 1.2,3.8 1.6,0.1 2,-1.8 2.5,0.9 8.8,-5.3 24.4,-13.2 4.4,-3.3 -1.9,-4 0.5,-5 -2.2,-2.6 2.2,-6.5 -3.4,-4.6 -0.7,-6.8 1.1,-3.6 -0.8,-4.3 -4.7,-5.9 -3,-1 -0.9,-4.5 -3.7,-1.8 -1.6,-4.3 -0.2,-6.7 3.9,-4.5 1,-3.1 -2.4,-3.5 -1.1,-3.2 -2.2,-10.8 -1.2,-4.7 -1.8,-0.3 -0.3,-4.1 -4.1,-0.3 -1.6,-4.2 -4.9,-0.8 -2,-1.4 -1.2,-2.9 -3.3,0.2 -3.7,-2 -1.4,-2 -2,-5.1 -4.5,-1.8 -4,-1.4 0.3,-5.4 -3.4,-3.3 -1.4,-3.5 1.1,-2.9 -4.6,-3 -1,-4.1 -3.5,-2 -1,-1.6 0.2,-2.9 -2.6,-3.7 -3.3,-2.2 -1,-2.4 -0.4,-3.3 -4.3,-3.3 -4.7,-2.7 -1.4,-4.9 -4.3,-5.9 -3.2,-1.3 -2.8,1.1 -6.6,-3.5 -3.5,2.5 -3.4,0.8 -2.2,-3.7 -4.3,-3 -1.2,-2.2 -0.8,-4.3 -2.4,-10.2 -4.5,-3.7 -4.7,-1.6 -3.3,-7.7 -3.5,-4.3 -5.6,-6 -2.3,-2.2 -3,-0.6 -1.6,-3.2 -0.6,-6.3 -1.9,-3.2 -0.9,-3.2 -7.3,-7.1 -0.7,-3 -5.3,-6.4 0.4,-1.3 2.7,-3 1.9,-3.6 v -1.9 l 1,-1.9 2.4,-1.2 1.7,-1.6 0.4,-8.2 -1.6,-4 -2.2,-2.3 1.3,-3.6 4.5,-2.6 2.2,-4.5 v -3.3 l -1.2,-3.9 0.1,-2.3 -0.4,-3.3 -1.6,-2.9 0.7,-2.7 2.7,-4.6 0.6,-3.5 4,-3 2.7,-3.6 0.9,-3.3 2,-2.2 3,-1.7 V 646 l -2.2,-1.9 0.9,-2.9 -0.3,-3.3 1.9,-1.6 v -1.9 l 1.3,-1.2 c 0,0 4,-0.3 4.9,-0.3 0.9,0 2.7,-2 2.7,-2 l 6,-1.6 1,-3.3 0.7,-2.6 -1.6,-2.5 v -3.2 l 2.9,-3.5 4.2,-1.4 4.6,-3.5 1.2,-2.6 5.5,-2.6 5,-3.9 1,-2 -0.6,-1 0.9,-1.7 2.3,-0.1 0.9,-1 0.3,-3.2 1.7,-3.6 -1.3,-2 0.6,-1.4 h 2 l 1,-0.3 -0.1,-3 -2.9,-3 1.2,-2.2 1.9,-1.4 v -2.6 l -0.6,-2.9 -2.4,-0.9 1.7,-2.3 2.9,-0.3 0.3,-2.8 3.7,-1 2.7,-4 3.3,-0.4 2.1,-1.3 1.8,-2 0.8,-1.8 -0.4,-2.4 0.4,-1.2 3.5,-2 2.4,-2.4 5.3,-2.9 3.9,-1.2 3.7,0.2 2.4,-1 0.4,-1.6 0.2,-1 2.4,0.2 1.8,-0.8 1.6,1.2 3.9,0.8 h 2 l 2.2,-3.1 2.6,0.2 4.7,1.4 2.4,-1 1.4,-3.5 3.3,-1 h 1 l 5.3,-0.6 2.6,-1.6 v 2.7 l 4.9,4.7 3.1,0.8 1,1.2 1,-2 3.3,-2.7 h 2.9 l 2.4,0.8 1,-0.8 h 1.6 l 1.4,1.2 2.6,-3.1 1.2,-0.4 0.8,1.2 2.9,0.2 1.4,-2.4 -0.8,-1 1.8,-1.8 h 3.1 l 1.8,-2.4 2.2,-2.9 4.7,-0.8 1.6,-2.4 0.2,-2 1.8,-3.1 4.5,-2 -0.4,-2.2 1.8,0.6 3.3,-1.2 6.3,1.2 v 2.9 l 2.9,-2.7 h 2.2 l 1.8,1 2.2,0.6 1.4,-2.2 v -1.6 l 1.4,-1.8 2,-1.2 -3.3,-1.6 0.8,-1.6 1.8,-1 0.2,-2.2 -1.8,-3.9 1,-2.2 3.5,0.6 2.6,-1.2 3.3,-0.9 4.2,1.9 7.6,3.6 5.5,-1.9 4.1,-3.3 0.4,-3.5 -3.7,-4.4 v -1.7 l 4.1,-1.5 0.9,-5 0.2,-3.3 4.6,-2.4 4.1,3 h 2.2 l 2.6,-3.9 12.6,0.5 2.1,3.3 4.3,-1.3 3.7,-3.3 4.1,0.5 1.9,2 5.6,-1.2 2.1,-4.9 -3.6,-3.2 0.4,-10 -4.3,-3.3 2,-3.2 -10.7,-3.7 -3.7,-4.1 0.1,-4.1 -5,-0.5 -6.8,0.2 2,-3.7 5.8,-1.5 3.2,-6.9 0.2,-9.1 1.9,-1.8 -5.1,-4.3 -1.1,-6.6 2.5,-3 -0.6,-4.9 1.4,-4.7 -11.7,-2.4 0.7,-2.3 3,-3.7 -2.1,-9.5 4.1,-1.7 0.9,-4 4.9,-2.4 -1.9,-9.9 5,-3.5 4.3,-0.3 0.1,-6.3 3.1,0.4 2.3,3.8 7.8,-3.1 -2.5,-3.3 -0.5,-3.1 5.5,-3.2 -1.6,-4.4 v -3.1 l 3.4,0.2 7.5,-5.7 -5.6,-4.2 -7,0.7 -0.2,-2.9 -3.3,-3.3 -5.4,0.8 -3.4,-6.1 -6,-1.3 -6.9,-0.1 -0.6,-4.5 -5.2,1.7 -4.6,-0.3 -3.1,-2.2 -3.7,2.5 -2.8,-1.3 3.8,-5.1 -3.9,-3.4 2.3,-4 2.8,-1.7 3.8,-6.2 11.3,-6.2 2.3,-3.2 -5.4,-11.8 -0.5,-6.6 -2.1,-3.5 1.3,-4 -6.3,-3.7 -6.2,-9.8 v -9.1 l -3.2,-4.3 2.7,-12.4 -3.8,-3.8 1.6,-6.5 -8.6,-10.2 -5.9,-3.8 4.3,-8.6 -0.5,-8.1 4.5,-1.3 0.3,-3 -2.6,-2.3 -0.1,-3.6 8.1,-7 1.6,-5.4 -6.1,-1.3 1.2,-2.7 -2.6,-1.9 4.5,-5 -4.8,-2.7 4.3,-2.2 -2.2,-2.7 -3.2,-1.6 3.2,-2.2 v -5.4 l 4.5,-2.8 1,-4.7 -3.7,-2.5 0.2,-4.6 -4.1,-0.7 -1.8,-1.7 2.4,-1.9 -2,-2 0.3,-2.8 4,-0.1 -0.5,-2.8 2.3,-1.5 3.7,2 3.4,-2.9 6.4,-2.9 1.8,-9.2 3.5,0.2 1.8,-4.4 6.6,-3.7 3.3,0.9 3.5,-2.6 -2.4,-3.7 0.9,-2 2.6,-0.9 1.3,-9.2 -1.8,-4 v -2 l 4.4,-0.2 -2.7,-2.7 2.9,-1.1 1.4,-1.5 -1.1,-2.1 4,-0.9 2,-9.2 -2.9,-3.7 -0.7,-3.7 z"
                           style="fill:none;stroke:#646464;stroke-width:2;stroke-linejoin:round" /><path
                           id="path4078"
                           sodipodi:nodetypes="ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st5"
                           d="m 2002,552.3 2.9,2.2 3.5,5.6 6.2,3.2 2.1,5.3 2.3,3.6 3.7,4 2.3,2.3 15.7,19.7 15.3,20.8 m 618.3,781.5 0.1,0.5 2.8,1.5 -1.5,4.8 -2.8,2.4 0.6,9.5 m -438.6,-0.1 -1,-4.7 0.5,-5.9 -4.3,-3.5 -3.8,3.7 -3.5,-0.6 2.2,-2.9 -0.5,-4.6 -8.5,-12.8 -1.6,-7.7 -10.4,-7.8 -5.6,-2.9 -2.9,-5.7 -4.4,-2.5 0.9,-2.4 -9.3,0.5 -4.8,2.8 -11.8,-2.4 -8.2,-4.1 -6.9,-5.7 -3.1,-4.7 -0.5,-3.7 -7.4,0.7 -3.1,2.3 -7.5,-1.3 -0.5,-2.7 -4.1,-3 h -5.3 l -8.6,-1.9 -6.8,-4.3 -0.9,-6.4 -3.2,-10 -5.6,-9.7 -5.6,-13.8 1.8,-7.7 -2.9,-4.2 -6.4,-0.2 -3.3,-2.6 -2.6,-4.6 -6.1,-2.4 -5.7,2.7 -4.7,-3.2 -1.5,-7.4 -2.1,-3.8 1.5,-4.7 -2.5,-8.4 3.6,-4.6 -1.9,-5.6 v -9.1 l -6.2,-7.9 -6.6,-1 -2.6,-4.1 3.1,-6.2 -1.8,-2.1 1.8,-5.6 0.2,-4.3 -4.7,-2.9 -2.5,-11.9 2.9,-4.5 1.1,-4.9 -3.4,-3.9 -7.8,-3.6 -1.2,-4.1 6.9,-2.4 -0.6,-3 7.4,-7.1 0.1,-4.7 6.4,-7 -3,-2.8 4.3,-6.8 1.7,-6.6 6.8,-1.6 h 3.5 l 5.9,-4.4 -1.8,-2.9 -10.6,-0.9 -3.3,-5.3 -4.3,-1.3 -2.8,-2.9 -2.4,-0.9 -4.4,1.4 -2.2,-5.2 -7.2,2.1 7.4,-8.6 -4.3,-2.4 -7.7,7.4 -5.7,7.3 -7.4,1.5 -2.9,-2.7 h -7.1 m 831,-831.8 5.5,-4.2 10.1,1.1 8.6,-3.5 7.9,1.8 7.8,-2.2 13.1,-0.4 6.6,-6.1 9.1,-2.1"
                           style="fill:none;stroke:#646464;stroke-width:2;stroke-linejoin:round" /></g><g
                         id="layer13"
                         transform="translate(-2196.3206,-630.90006)"
                         inkscape:groupmode="layer"
                         inkscape:label="Poblaciones"
                         class="st6"
                         style="display:none"><path
                           id="path2738"
                           sodipodi:nodetypes="ccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2438.9,528.1 3,1.7 4.2,0.3 0.8,3.6 8.8,2.9 -0.3,-1.8 h 3.4 l 0.5,-5.2 h 6 l 0.3,-1.8 -7,-0.3 -5.2,-5.7 1.3,-3.4 -3.9,-2.3 -1.5,3.6 -3.2,3.4 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path2745"
                           sodipodi:nodetypes="cccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2483.1,780.2 4.4,0.7 1.3,-1.5 h 5.9 l 1.1,-3.1 -3.7,-2.2 -3.9,1.1 -2,-0.2 -0.7,-2.6 -3.3,-0.2 -2.4,1.3 h -1.7 l -0.6,3.3 5.1,1.1 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path2747"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2226.4,855.6 1.5,0.4 v 2.9 l 1.5,0.6 1.8,-2.9 1.1,-0.2 2,0.9 1.5,-0.2 0.2,-1.8 2.2,-0.7 1.5,-2.2 -2.9,-1.1 -3.7,-2.4 -4.2,0.9 -2.2,1.8 -0.3,4 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path2749"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2493.3,827.5 v 1.2 l -2,0.6 v 0 l -4.1,-1.5 0.4,-3.5 -1.6,-4 -2,0.7 -1,3.7 1.7,1.7 -0.5,1.7 -2,0.4 -1.6,-4 -3.8,-0.1 -1,-0.7 1.4,-3.5 -1.3,-1.3 3.2,-4 3.1,-3.7 h 2.7 l 1.6,-1.1 1.5,-1 1,0.1 1.9,3.6 -0.3,0.5 2.5,5.3 2.8,2.2 -0.4,2.5 -2.2,1.9 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7414"
                           sodipodi:nodetypes="cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2462.7,447.4 0.2,-1.1 -1.4,-1.4 -1.6,-3.8 1.8,-0.4 0.5,-3.1 3.4,-2.2 1.3,1.6 6.5,0.9 1.4,3.4 -1.3,3.1 h -4 l -2.7,1.8 -1.6,1.4 z m 60.5,-53.1 -4.7,-2.7 -3.2,1.4 -0.4,-3.1 2,-1.8 4.7,0.5 1.8,-0.9 3.8,-0.2 -0.9,1.1 -0.4,2 -2,1.3 z m -55.1,-0.7 0.3,5.5 -2.1,4.4 h -4.9 l -2.1,2.8 1.1,3.9 -2.2,8.8 -3.7,2.9 -1.1,3.1 3.9,-1.6 h 3.6 l 4.4,-4.9 4.4,1 6.2,-3.9 -7,-2.1 -1,-9.6 3.4,-2.3 6,0.8 3.6,-0.5 -0.5,3.1 2.9,1.6 2.6,-4.4 3.4,-3.4 9.9,-1.8 1.8,0.8 0.3,3.9 2.1,0.5 5.4,-5.5 -0.3,-1.8 h -5.7 l -1.3,-1.3 2.3,-1.8 v -5.5 l 3.9,-2.3 -4.4,-7 -7.3,0.8 -3.6,-5.7 -7,1 -0.5,-2.3 2.1,-1.6 -4.4,-1.3 -3.5,0.3 0.6,2 2.9,0.6 0.2,1.6 -4.3,1.5 -1.3,2 -6.4,2 -3.2,-0.9 -2.5,2.8 0.8,0.9 2.1,-1.5 1.2,1.1 -1.1,1.4 0.9,1.3 v 2.9 l -3.3,4.5 -1.5,1.2 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-4"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7431"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2122.3,841.6 2.4,0.2 2.8,-2.4 0.6,-3.5 1.7,-1.9 -2.4,-3 -2.8,2.8 -2.4,5.8 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-5"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-29"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-98"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-3"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-86"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7468"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2420.3,542.4 -4.7,-1.7 -0.3,-1.7 10.7,-3.4 4.2,-1.4 2.2,-1.7 2.5,1.4 -0.8,2.9 -5.2,2.5 -3.4,-1.4 -3.2,0.8 0.5,2.9 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7470"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2515.6,678.2 h -2 l -0.6,-3.9 -1.5,-1.3 0.9,-1.9 0.4,-2 2.6,-1.5 2.8,3.7 -0.6,4.1 1.1,1.7 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-986"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-62"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-38"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7493"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2229.5,1119.3 -1.6,-0.3 -0.7,-2 h -1.1 l -1.7,1.3 -2.3,-0.1 -0.4,-2 -1.5,-1.1 1.6,-1.3 1.5,0.1 0.5,1.1 1.5,0.1 1.7,-1.2 1.3,-0.5 0.5,1.1 1.5,-0.5 1.1,0.7 0.5,1.7 -0.9,1.1 -0.1,1.5 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-26"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7502"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2130.9,1263.7 -1.9,-0.9 -0.2,-1.9 -3,-0.9 -0.4,-2.1 -2.6,-1.1 0.4,-1.9 2.5,-1.1 0.4,-2.8 2.5,-0.9 1.1,1.7 0.8,0.2 v -1.7 l 2.1,-1.1 0.2,0.9 1.1,0.6 0.6,-1.3 h 0.9 l 1.5,2.6 1.7,0.6 1.9,-1.9 0.4,1.9 0.9,0.6 0.4,1.3 -1.9,1.1 -1.1,3 -5.1,1.9 -1.5,2.8 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-27"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7513"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2461.6,1224.9 -5.4,0.4 -1.7,2.3 -2.5,-1.4 1.2,-2.8 2.2,-0.6 -0.2,-2.4 3.4,-3.4 1.3,-0.2 -1.3,3.7 1.9,0.7 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-57"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-827"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-80"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7537"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2317.8,1568.8 -0.8,-3.1 -2.5,-1.1 1.2,-2.5 1.6,-0.4 0.5,0.7 2.3,-1.1 2,0.6 v 1.4 l 1.9,2.6 -3.8,1.1 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-20"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><circle
                           id="path2785-26-89"
                           class="st7"
                           cx="450.09906"
                           cy="27.178518"
                           r="2.2748232"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7553"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2616.3,1729.9 -4.3,-1.3 0.2,-2.7 -2.2,-2.3 2,-4 1.8,1.2 1.8,-1.3 3.3,-0.8 2,1.3 -2.2,2.7 1.8,4.5 -1.5,2.3 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /><path
                           id="path7597"
                           inkscape:connector-curvature="0"
                           class="st7"
                           d="m 2168.5,667.9 1.7,-0.2 V 666 l 1.6,-2.1 -0.6,-2.6 -2.3,-0.7 -1.1,-1.3 -2.2,-0.2 1.8,3.7 z"
                           style="display:inline;fill:#323232;fill-opacity:0.39220001" /></g></svg>
                </div>
                <div class="col-xs-12 col-md-8" id="infoMunicipio">
                    
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript' async defer>
(function(){ var widget_id = 'zhv9Au2YIb';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
@endsection

@section('javascript')
<script>
var municipios = [];
$(document).ready(function(){
    
    
    $.getJSON( "/testMunicipios.json", function( data ) {
      municipios = data;
    });
    
});
function getMunicipio(id){
        for(var i = 0; i < municipios.length; i++){
            if(municipios[i].id == id){
                return municipios[i];
            }
        }
        return null;
    }
function cambiar(id, idElement){
    console.log(id);
    $('#layer9 path').css('fill','#d9d9d9');//#d9d9d9
    document.getElementById(idElement).style.fill = 'blue';
    var municipio = getMunicipio(id);
    if(municipio != null){
        console.log(municipio);
        var h2 = '<h2>' + municipio.municipio + '</h2>'
        document.getElementById('infoMunicipio').innerHTML = h2
    }
    
}
    
</script>
@endsection
