<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Sistema de Información Turistica del Magdalena">
    <meta name="author" content="SITUR Magdalena">

    <title>@yield('Title')</title>
    <link rel="icon" type="image/ico" href="{{asset('/Content/icons/favicon-96x96.png')}}" />
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css" />
    <!-- estilo administrador -->
    <link href="{{asset('/css/styleAdmin.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- estilo de listas -->
    <link href="{{asset('/css/list.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/select2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/styleSelectJP.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/galeria.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/object-table-style.css')}}" rel="stylesheet" type="text/css" />
    <!-- font-awesome -->
    
    <link href="{{asset('/font-awesome/css/font-awesome.css')}}" rel='stylesheet' type='text/css' />
    
    <!-- //font-awesome -->
    <!-- Metis Menu -->
    <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/styleLoading.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/select.css')}}" rel="stylesheet" type="text/css" />
    <!--//Metis Menu -->
    @yield("estilos")
    @yield("head")
    <style>
        .pagination > li > a {
            font-family: Arial;
            padding: .5em 1em;
            font-size: 1.1em;
        }
        .chip {
            display: inline-block;
            background-color: rgba(0, 126, 255,.35);
            border-radius: 15px;
            padding: .5em 1em;
            font-size: .9em;
        }
        .table > tbody > tr > td, .table > thead > tr > th {
            vertical-align: middle;
        }
        .fa-li {
            left: 1px;
            top: 12px;
        }
    </style>
</head>
<body ng-app="situr_admin" class="cbp-spmenu-push">
    
     <div id="preloader">
        <div>
            <div class="loader"></div>
            <h1>{{trans('resources.LabelPreloader')}}</h1>
            <h4>{{trans('resources.LabelPorFavorEspere')}}</h4>
            <img src="{{asset('/Content/image/logo.min.png')}}" width="200" />
        </div>
    </div>
    <header class="sticky-header header-section ">
        <div class="header-left">
            <!--toggle button-->
            <button id="showLeftPush"><i class="fa fa-bars"></i></button>
            <!--//toggle button-->
            <!--logo situr -->
            <div class="logo">
                <a href="{{asset('/')}}"><img src="{{asset('/Content/icons/logo_situr.png')}}" height="60"/></a>
            </div>
            <!--//logo-->
        </div>
        <div class="header-right">
           <div class="profile_details">
                <ul>
                    <li class="dropdown profile_details_drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile_img">
                                <div class="user-name">
                                    <p>Situr</p>

                                </div>
                                <i class="fa fa-angle-down lnr"></i>
                                <i class="fa fa-angle-up lnr"></i>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li> 
                                <a href="/logout"><i class="fa fa-sign-out"></i> Cerrar sesión</a> 
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="clearfix"> </div>
    </header>
    
     <!--menu vertical-->
    <div class="sidebar" role="navigation">
        <div class="navbar-collapse">
            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <ul class="nav" id="side-menu">
                   <li>
                        <a href="/temporada" class="chart-nav"><i class="fa fa-book nav_icon"></i> Temporada</a>
                    </li>
                </ul>
                
                <div class="clearfix"> </div>
                <!-- //sidebar-collapse -->
            </nav>
        </div>
    </div>
    
    <div id="page-wrapper">
            @yield('contenido')
    </div>
    <!--footer-->
    <div class="footer">
        <p>&copy; {{\Carbon\Carbon::now()->format('Y')}} SITUR MAGDALENA. Todos los derechos reservados</p>
    </div>
    <!--//footer-->
    
    <script src="{{asset('/js/plugins/jquery.min.js')}}"></script>
    <script src="{{asset('/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/plugins/modernizr.custom.js')}}"></script>
    <script src="{{asset('/js/plugins/metisMenu.min.js')}}"></script>
    <script src="{{asset('/js/plugins/custom.js')}}"></script>
    <script src="{{asset('/js/plugins/classie.js')}}"></script>
    <script>
        $(window).load(function () { $("#preloader").delay(1e3).fadeOut("slow") });
    </script>
    <script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;

			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
			function showSubmenu() {

			}
    </script>
    
    <script src="{{asset('/js/plugins/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/ng-map.min.js')}}"></script>
    <script src="{{asset('/js/plugins/dirPagination.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-repeat-n.min.js')}}"></script>
    <script src="{{asset('/js/plugins/ui-bootstrap-tpls.min.js')}}"></script>
    <script src="{{asset('/js/plugins/object-table.js')}}"></script>
    <script src="{{asset('/js/plugins/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/selectjp.js')}}"></script>
    <script src="{{asset('/js/plugins/select.js')}}"></script>
    <script src="{{asset('/js/plugins/galeria.js')}}"></script>
    <!--  -->
   <script src="{{asset('/js/plugins/galeria.js')}}"></script>
   <script src="{{asset('/js/plugins/galeria.js')}}"></script>
   <script src="{{asset('/js/plugins/select2.min.js')}}"></script>
   
   <script src="{{asset('/js/administrador/administrador.js')}}"></script>
   <script src="{{asset('/js/administrador/temporadas.js')}}"></script>
    @yield('javascript')
    <noscript>Su buscador no soporta Javascript!</noscript>
</body>
</html>