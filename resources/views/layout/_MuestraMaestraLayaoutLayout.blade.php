<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema de Información Turistica del Magdalena y Santa Marta">
    <meta name="author" content="SITUR Magdalena">
    <title>@yield('Title')</title>
    <link rel="icon" type="image/ico" href="{{asset('Content/icons/favicon-96x96.png')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!--<link href="{{asset('/css/bootstrap-material-design.css')}}" rel="stylesheet" type="text/css" />-->
    <link href="{{asset('/css/ripples.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ionicons.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/styleLoading.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
   

<!-- Graph CSS 

<!-- jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="{{asset('css/dashboard/icon-font.min.css')}}" type='text/css' />
<!-- //lined-icons -->
<script src="{{asset('js/administrador/dashboard/jquery-1.10.2.min.js')}}"></script>
<script src="{{asset('js/administrador/dashboard/amcharts.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/serial.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/light.js')}}"></script>	
<script src="{{asset('js/administrador/dashboard/radar.js')}}"></script>	
<link href="{{asset('css/dashboard/barChart.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('css/dashboard/fabochart.css')}}" rel='stylesheet' type='text/css' />
<!--clock init-->



   
   
        
    @yield('estilos')
    <style>
        .carga {
           display: none;
           position: fixed;
           z-index: 1500;
           top: 0;
           left: 0;
           height: 100%;
           width: 100%;
           background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        
        body.charging { overflow: hidden; }
        body.charging .carga { display: block; }
        
        html {
            font-size: 16px;
        }
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
            .btn-default-focus{
                outline: none;
                outline-offset: 0;
                box-shadow: none;
                background-color: transparent;
            }
            .ui-select-multiple.ui-select-bootstrap .ui-select-match-item{
                font-size: 12px;
            }
             .ADMdtp-box footer .timeSelectIcon, .ADMdtp-box footer .today, .ADMdtp-box footer .calTypeContainer p{
                fill: darkorange;
                color: darkorange;
            }
            .ADMdtp-box footer .calTypeContainer p{
                display: none;
            }
    </style>
</head>
<body @yield('app')  @yield('controller') >
    
    <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1>{{ trans('resources.LabelPreloader') }}</h1>
            <h4>Resource.LabelPorFavorEspere</h4>
            <img src="{{asset('Content/image/logo.min.png')}}" width="200" />
        </div>
    </div>
    
        <header>
            
            <div class="banner">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-2">
                           
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <h1 style="margin-top: 0.6em; text-transform: uppercase"><strong>@yield('Title')</strong></h1>
                        </div>
                        <div class="col-xs-12 col-md-1">
                            <div class="btn-group">
                                <a href="bootstrap-elements.html" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown"><i class="material-icons">menu</i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/MuestraMaestra/periodos">Volver</a></li>
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
            
        </header>
    
       <div class="page-container">
   <!--/content-inner-->
        <div class="left-content">
           <div class="inner-content">
        	<!-- header-starts -->
        		<div class="header-section">
        					<!--menu-right-->
        			
        					<!--//menu-right-->
				    <div class="clearfix"></div>
			    </div>
				<!-- //header-ends -->
			    <div class="title-section">
                    <h3 style="margin-top: 0.5em;"><strong>@yield('TitleSection')</strong></h3>
                </div>
                
                <div class="container">
                    @yield('content')
                </div>
                
                <!--/charts-inner-->
        	</div>
        		<!--//outer-wp-->
        	</div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('/Content/bootstrap_material/dist/js/material.min.js')}}"></script>
    <script src="{{asset('/Content/bootstrap_material/dist/js/ripples.min.js')}}"></script>
    <script>
        $.material.init();
    </script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-repeat-n.min.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/plugins/object-table.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    
    <script src="{{asset('/js/administrador/administrador.js')}}"></script>
    <script src="{{asset('/js/administrador/grupo_viaje.js')}}"></script>
    <script src="{{asset('/js/administrador/grupoViajeServices.js')}}"></script>
    <script src="{{asset('/js/administrador/temporadas.js')}}"></script>
  
    <script src="{{asset('/js/importacionRnt/importarRnt.js')}}"></script>
    <script src="{{asset('/js/importacionRnt/proveedorService.js')}}"></script>
    
    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>

    <script>  $.material.init(); </script>

    <script>
            // $(window).on('scroll', function () {
            //     if (!$('.alert').hasClass('no-fixed')) {
            //         if ($(this).scrollTop() > 190) {
            //             $('.alert').addClass('alert-fixed');
            //         } else {
            //             $('.alert').removeClass('alert-fixed');
            //         }
            //     }
            // });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
    </script>
    @yield("javascript")
    <noscript>Su buscador no soporta Javascript!</noscript>
   
    <div class="carga" ></div>
   
</body>
</html>