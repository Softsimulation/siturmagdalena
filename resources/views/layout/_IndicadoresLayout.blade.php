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
        
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{\Request::url()}}" />
        @yield('meta_og')
        <title>@yield('title') SITUR Magdalena</title>
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.6.95/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="{{asset('/css/public/style.css')}}" type="text/css" />
        <link href="{{asset('/css/public/style_768.css')}}" rel="stylesheet" media="(min-width: 768px)">
        <link href="{{asset('/css/public/style_992.css')}}" rel="stylesheet" media="(min-width: 992px)">
        <link href="{{asset('/css/public/style_1200.css')}}" rel="stylesheet" media="(min-width: 1200px)">
        <link href="{{asset('/css/public/style_1600.css')}}" rel="stylesheet" media="(min-width: 1600px)">
        <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
        @yield('estilos')
        <style>
            .weather{
            margin:0 .5rem;
            display: flex;
            align-items: center;
        }
        .weather span:first-child{
            font-size: 1.5rem;
            margin-right: .25rem;
        }
        /*Google traductor*/
            .goog-te-gadget img {
                display: none!important;
            }
            .goog-te-gadget-simple {
                background: transparent!important;
                color: #333!important;
                border: 0!important;
            }
            .goog-te-gadget-simple .goog-te-menu-value span {
                color: #333!important;
                font-size: 1rem!important;
                padding-right: .5rem!important;
                font-family: Futura, sans-serif!important;
            }
            .goog-te-banner {
                background: black!important;
                color: white!important;
            }
            .goog-te-button div {
                background: transparent!important;
                border: 0!important;
            }
            .goog-te-button button {
                color: white!important;
                border: 0!important;
                background-color: transparent!important;
                font-family: Futura, sans-serif!important;
            }
            .goog-te-button {
                border: 0!important;
            }
            .goog-te-menu-value span {
                color: white!important;
                font-family: Futura, sans-serif!important;
            }
        </style>
    </head>
    <body @yield('app') @yield('controller') >
        <!-- vista parcial de cabecera de vista pública -->
        @include('layout.partial.headerPublic')
        
        <main id="content-main" class="container" role="main">
            @yield('content')
        </main>
        
        <!-- vista parcial de pie de página de vista pública -->
        @include('layout.partial.footerPublic')
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{asset('/js/public/script-main.js')}}"></script>
        
        <script src="{{asset('/js/sweetalert.min.js')}}" async></script>
        
        
        <script type="text/javascript" defer>
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
        <script>
        $(document).ready(function() {
            
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.onreadystatechange = function() { 
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
                $("#weatherPluginJs").html(JSON.parse(xmlHttp.responseText).main.temp + "°C");
            }
            xmlHttp.open("GET", "http://api.openweathermap.org/data/2.5/weather?id=3668605&units=metric&APPID=08adc9a38979ce8b46e5fe3c0f50cd4a", true); // true for asynchronous 
            xmlHttp.send(null);
            
        });

    </script>
        @yield('javascript')
        
        <noscript>Su buscador no soporta Javascript!</noscript>
        
    </body>
</html>