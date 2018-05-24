<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Información Turistica del Magdalena">
    <meta name="author" content="SITUR Magdalena">
    <title>@yield('Title')</title>
    <link rel="icon" type="image/ico" href="{{asset('Content/icons/favicon-96x96.png')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/bootstrap-material-design.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/ripples.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ionicons.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/styleLoading.css')}}" rel='stylesheet' type='text/css' />
    @yield('estilos')
    <style>
        .banner {
            background-color: white;
            padding-top: 1em;
            padding-bottom: 1em;
            color: dimgray;
            text-align: center;
            font-weight: 700;
        }

            .banner img {
                height: 6em;
            }

        .title-section {
            background-color: dodgerblue;
            color: white;
            width: 100%;
            padding: 4%;
            padding-top: .5em;
            padding-bottom: .5em;
            text-align: center;
            /*margin-bottom: 1em;*/
        }

        .asterik {
            color: red;
            font-size: 1em;
        }

        .checkbox {
            margin-bottom: 0.5em;
        }

        .checkbox label, .radio label {
            color: dimgray;
        }

        .form-group {
            margin: 0;
        }

        .table > tbody > tr > td {
            padding-bottom: 0;
            font-weight: 400;
            font-size: 16px;
        }

        .table > thead > tr > th {
            text-align: center;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            vertical-align: middle;
        }

        .dropdown-menu {
            left: -85%;
        }

        .fixed {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .alert-fixed {
            position: fixed;
            width: 80%;
            top: 2%;
            left: 10%;
            box-shadow: 0px 0px 3px 0px rgba(0,0,0,.5);
            z-index: 10;
        }

        .control-label {
            color: dimgrey !important;
        }

        .label-danger {
            font-size: 1em;
        }

        .progress {
            height: 1.4em;
        }

        .progress-bar {
            font-size: 1.2em;
            font-weight: 500;
            line-height: 1.3em;
        }

        .radio label, label.radio-inline {
            padding-left: 1.8em;
        }

        footer {
            width: 100%;
            background-color: rgba(0,0,0,.35);
            padding: 1em;
            text-align: right;
        }

        #log form {
            float: none !important;
        }

            #log form a {
                text-decoration: none;
                color: #333 !important;
                font-size: 1em !important;
                font-weight: 400;
                padding: 3px 20px;
            }
            .tooltip-inner {
                text-align:left !important;
            }
    </style>
</head>
<body ng-app="encuestaInterno">
    <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1>{{ trans('resources.LabelPreloader') }}</h1>
            <h4>{{ trans('resources.LabelPorFavorEspere')}}</h4>
            <img src="{{asset('Content/image/logo.min.png')}}" width="200" />
        </div>
    </div>
    <header>
        <div class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <img src="{{asset('Content/image/logo.png')}}" alt="Logo" />
                    </div>
                    <div class="col-xs-12 col-md-9">
                        <h1 style="margin-top: 0.6em; text-transform: uppercase"><strong>Encuesta de turísmo interno y emisor</strong></h1>
                    </div>
                    <div class="col-xs-12 col-md-1">
                        <div class="btn-group">
                            <a href="bootstrap-elements.html" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown"><i class="material-icons">menu</i></a>
                            <ul class="dropdown-menu">
                                <li><a href="/temporada">Volver</a></li>
                                <li class="divider"></li>
                                <li id="log">
                                    <!--
                                    using (Html.BeginForm("LogOff", "Account", FormMethod.Post, new { id = "logoutForm", @class = "navbar-right" }))
                                    {
                                        Html.AntiForgeryToken()

                                        <a href="javascript:document.getElementById('logoutForm').submit()" style="color: white;font-size: 1.2em;"><span class="ion-android-person"></span> Resource.LabelCerrarSesion</a>
                                    }
                                    -->
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="title-section">
            <h3 style="margin-top: 0.5em;"><strong>@yield('TitleSection')</strong></h3>
        </div>
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-info" style="width: yield('Progreso')">@yield('NumSeccion')</div>
        </div>
    </header>
    <div class="container" @yield('Control')>
        @yield('contenido')

    </div>
    <!--
    if (ViewContext.HttpContext.User.IsInRole("Admin") || ViewContext.HttpContext.User.IsInRole("Digitador"))
    {
        <footer id="seccion" ng-controller="seccionCtrl">
            <select class="selectLenguage" style="margin: 0" ng-options="seccion as seccion.nombre for seccion in secciones track by seccion.id" ng-model="seccionSelected">
                <option value="" selected disabled>Ir a la sección</option>
            </select>
        </footer>
    }
    -->

   
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
    <script src="{{asset('/js/plugins/jquery.min.js')}}"></script>

    <script src="{{asset('/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/plugins/material.min.js')}}"></script>
    <script src="{{asset('/js/plugins/ripples.min.js')}}"></script>
    <script>
            $.material.init();
    </script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-repeat-n.min.js')}}"></script>
    <script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/selectjp.js')}}"></script>

    <script src="{{asset('/js/encuestas/turismointerno/encuestaInterno.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/transporte.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/gasto.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/Hogares.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/ActividadesRealizadas.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/ViajesRealizados.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/services.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/fuentesinformacion.js')}}"></script>
    <script src="{{asset('/js/encuestas/turismointerno/servicios.js')}}"></script>
    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>
    <script>
            $(window).on('scroll', function () {
                if (!$('.alert').hasClass('no-fixed')) {
                    if ($(this).scrollTop() > 190) {
                        $('.alert').addClass('alert-fixed');
                    } else {
                        $('.alert').removeClass('alert-fixed');
                    }
                }
                
            });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
    </script>
    @yield("javascript")
    <noscript>Su buscador no soporta Javascript!</noscript>
</body>
</html>

