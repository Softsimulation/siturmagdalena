<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema de Información Turistica del Magdalena">
        <meta name="author" content="SITUR Magdalena">
        <title>@yield('title')</title>
        <link rel="icon" type="image/ico" href="{{secure_asset('/Content/icons/favicon-96x96.png')}}" />
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
        <link href="{{secure_asset('/Content/sweetalert.css')}}" rel='stylesheet' type='text/css' />
        
        <link href="{{secure_asset('/Content/ionicons/css/ionicons.min.css')}}" rel='stylesheet' type='text/css' />
        <link href="{{secure_asset('/Content/styleLoading.css')}}" rel='stylesheet' type='text/css' />
        
        <link href="{{secure_asset('/Content/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
        
        @yield('estilos')
        
    </head>
    <body @yield('app') @yield('controller') >
       
        <div id="preloader">
            <div>
                <div class="loader"></div>
                <h1>@Resource.LabelPreloader</h1>
                <h4>@Resource.LabelPorFavorEspere</h4>
                <img src="/Content/image/logo.min.png" width="200" />
            </div>
        </div>
        
        
        <div class="container" >
            @yield('content')
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{secure_asset('/js/plugins/angular.min.js')}}"></script>
        <script src="{{secure_asset('/js/bootstrap.min.js')}}"></script>
        
        <script src="{{secure_asset('/js/sweetalert.min.js')}}"></script>
        
        
        <script>
            $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
        </script>

        @yield('javascript')
        
        <noscript>Su buscador no soporta Javascript!</noscript>
        
    </body>
</html>