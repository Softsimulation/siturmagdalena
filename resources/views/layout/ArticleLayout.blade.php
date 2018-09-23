<!DOCTYPE html>
<html lang="es">
    <head>
    	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H">
        <meta name="keywords" content="SITUR Magdalena, Visita Magdalena, Visit Magdalena, Turismo en el Magdalena, estadisticas Magdalena, Magdalena" />
        <meta name="author" content="Softsimulation S.A.S" />
        <meta name="copyright" content="SITUR Capítulo Magdalena, Softsimulation S.A.S" />
        <meta property="og:title" content="SITUR Magdalena" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.siturmagdalena.com" />
        <meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
        <meta property="og:description" content="Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H"/>
        <title>@yield('Title') SITUR Magdalena</title>
        <link rel='manifest' href='{{asset("/manifest.json")}}'>
        <meta name='mobile-web-app-capable' content='yes'>
        <meta name='apple-mobile-web-app-capable' content='yes'>
        <meta name='application-name' content='SITUR Magdalena'>
        <meta name='apple-mobile-web-app-status-bar-style' content='blue'>
        <meta name='apple-mobile-web-app-title' content='SITUR Magdalena'>
        <link rel='icon' sizes='192x192' href='{{asset("/img/brand/192.png")}}'>
        <link rel='apple-touch-icon' href='{{asset("/img/brand/192.png")}}'>
        <meta name='msapplication-TileImage' content='{{asset("/img/brand/144.png")}}'>
        <meta name='msapplication-TileColor' content='#004A87'>
        <meta name="theme-color" content="#004A87" />
        <meta http-equiv="cache-Control" content="max-age=21600" />
        <meta http-equiv="cache-control" content="no-cache" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.6.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="{{asset('/css/public/style.css')}}" type="text/css" />
        <link href="{{asset('/css/public/style_768.css')}}" rel="stylesheet" media="(min-width: 768px)">
        <link href="{{asset('/css/public/style_992.css')}}" rel="stylesheet" media="(min-width: 992px)">
        <link href="{{asset('/css/public/style_1200.css')}}" rel="stylesheet" media="(min-width: 1200px)">
        <link href="{{asset('/css/public/style_1600.css')}}" rel="stylesheet" media="(min-width: 1600px)">
        @yield('estilos')
        <style>
            #introduce p, #introduce ul{
                font-weight: 300;
                font-size: 1.325rem;
                text-align:center;
                margin: 0;
                padding-top: .5rem;
                padding-bottom: 1rem;
            }
            .tiles.tiles-mini .tile:hover {
                border-color: white;
            }
            
            .tiles.tiles-mini .tile {
                border: 2px solid transparent!important;
            }
            .icon-lg{
                font-size: 2rem;
                margin: 0 .5rem;
            }
            footer ul{
                list-style: none;
                margin: 0;
                padding-left: 1rem;
            }
            /*main img{
                background-image: url('/img/bg-img.jpg');
            }*/
        </style>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        @include('layout.partial.headerPublic')
    	
    	<main id="content-main" role="main">
    	    @yield('content')    
    	</main>
    	<footer>
    	    <div id="logosApoyoSitur" class="container text-center">
    	        <img src="{{asset('img/brand/others/logo_mincit.png')}}" alt="Logo de Ministerio de Comercio, Industria y Turismo">
    	        <img src="{{asset('img/brand/others/logo_fontur.png')}}" alt="Logo de FONTUR">
    	        <img src="{{asset('img/brand/others/logo_gobierno.png')}}" alt="Logo de Gobierno de Colombia">
    	        <img src="{{asset('img/brand/others/logo_cotelco.png')}}" alt="Logo de Cotelco Magdalena">
    	    </div>
    	    <div class="info-footer">
    	        <div class="container">
        	        <div class="row">
        	            <div class="col-xs-12 col-sm-6 col-md-4">
        	                <h3>Información de contacto</h3>
        	                
        	                <ul class="list-footer">
                                <li><span class="glyphicon glyphicon-earphone"></span> Oficina: (+57) (5) 422 2289. Celular: (300) 531 5837<br></li>
                                <li><span class="glyphicon glyphicon-map-marker"></span> Calle 24 N° 3-99. Torre empresarial Banco de Bogotá<br>Oficina 9-10</li>
                            </ul>
        	            </div>
        	            <div class="col-xs-12 col-sm-6 col-md-4 text-center">
        	                <h3>Síguenos en nuestras redes sociales</h3>
        	                <div class="text-center">
        	                    <a href="#" target="_blank" rel="noreferrer noopener"><span class="icon-lg ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
                				<a href="#" target="_blank" rel="noreferrer noopener"><span class="icon-lg ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>
                				<a href="#" target="_blank" rel="noreferrer noopener"><span class="icon-lg ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>
        	                </div>
        	                <p>O descarga nuestra aplicación móvil</p>
        	            </div>
        	            <div class="col-xs-12 col-sm-6 col-md-4">
        	                <h3>Enlaces de interés</h3>
        	                <ul>
        	                    <li><a href="http://www.citur.gov.co/" target="_blank" rel="noreferrer noopener">Centro de Información Turística de Colombia CITUR</a></li>
        	                    <li><a href="http://www.mincit.gov.co/" target="_blank" rel="noreferrer noopener">Ministerio de Comercio, Industria y Turismo de Colombia</a></li>
        	                    <li><a href="http://www.magdalena.gov.co/" target="_blank" rel="noreferrer noopener">Gobernación de Magdalena</a></li>
        	                    <li><a href="http://www.santamarta.gov.co/" target="_blank" rel="noreferrer noopener">Alcaldía Distrital de Santa Marta</a></li>
        	                </ul>
        	                
        	            </div>
        	        </div>
        	    </div>
        	    <div class="sign-footer">
        	        <div class="container text-center">
        	            Desarrollado por <a href="http://softsimulation.com/" target="_blank" rel="noreferrer noopener">Softsimulation S.A.S</a> - SITUR Magdalena &copy; 2018
        	            <a href="#goto-top" class="sr-only">Volver al inicio</a>
        	        </div>
        	        
        	    </div>
    	    </div>
    	    
    		
    	</footer>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{asset('/js/public/script-main.js')}}"></script>
        <!--<script src="{{asset('/js/vibrant.js')}}"></script>-->
        <!--<script src="{{asset('/js/public/run_vibrant.js')}}"></script>-->
        @yield("javascript")
        <script type="text/javascript">
            if ('serviceWorker' in navigator) {
                console.log('CLIENT: service worker situr Magdalena registration in progress.');
                navigator.serviceWorker.register('/service-worker.js', { scope: '/' }).then(function () {
                    console.log('CLIENT: service worker situr Magdalena registration complete.');
                }, function () {
                    console.log('CLIENT: service worker situr Magdalena registration failure.');
                });
            } else {
                console.log('CLIENT: service worker situr Magdalena is not supported.');
                document.getElementsByTagName("html")[0].setAttribute("manifest", "/cache.appcache");
            }
        </script>
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function (event) {
                
                $('#preloader').delay(250).fadeOut("fast");
            });
            
        </script>
    </body>
</html>