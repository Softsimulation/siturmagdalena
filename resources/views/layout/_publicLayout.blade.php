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
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div id="preloader" aria-hidden="true">
        <div>
            <div class="loader"></div>
            <h1>Cargando...</h1>
            <h4>Por favor espere</h4>
            <img src="/img/brand/default.png" alt="" role="presentation">
        </div>
    </div>
	<header>
		<div id="situr-main-brand" class="brand">
			<a href="#">
				<img src="{{asset('img/brand/default.png')}}" alt="Logo de SITUR Magdalena">
				<h1 class="sr-only">SITUR Magdalena</h1>
			</a>
			
		</div>
		<div id="nav-bar-main">
			<div id="toolbar-main">
			    <a href="#content-main" id="goto-top" class="sr-only">Ir al contenido</a>
				<a href="#" target="_blank" class="btn btn-xs btn-link" rel="noreferrer noopener" title="Ir a Twitter"><span class="ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
				<a href="#" target="_blank" class="btn btn-xs btn-link" rel="noreferrer noopener" title="Ir a Facebook"><span class="ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>
				<a href="#" target="_blank" class="btn btn-xs btn-link" rel="noreferrer noopener" title="Ir a Instagram"><span class="ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>
				<!-- *AQUI IRIA EL PLUGIN DEL CLIMA* -->
				<a href="#" class="btn btn-xs btn-link">Mapa del sitio</a>
				<form name="searchMainForm" method="get" action="">
					<label class="sr-only" for="searchMainTBox">Campo de búsqueda</label>
					<input type="text" id="searchMainTBox" name="search" maxlength="255" placeholder="¿Qué desea buscar?" required autocomplete="off"/>
					<button type="submit" class="btn btn-xs btn-link"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Buscar</span></button>
				</form>
				<form name="currencyForm" method="get" action="">
					<label class="sr-only" for="currencyMain">Cambio de moneda</label>
					<select id="currencyMain" name="currency" onchange="this.form.submit();">
						<option value="COP" selected>COP</option>
						<option value="USD">USD</option>
						<option value="EUR">EUR</option>
					</select>
				</form>
				<form name="langForm" method="get" action="">
					<label class="sr-only" for="languange">Selección de idioma</label>
					<select id="languange" name="lang" onchange="this.form.submit();">
						<option value="es" selected>Español</option>
						<option value="en">Inglés</option>
					</select>
				</form>
				<a href="#" class="btn btn-xs btn-link"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="hidden-xs">Iniciar sesión</span></a>
			</div>
			<div id="navbar-mobile" class="text-center">
                <button type="button" class="btn btn-block btn-primary" title="Menu de navegación"><span aria-hidden="true" class="ion-navicon-round"></span><span class="sr-only">Menú de navegación</span></button>
            </div>
			<div id="nav-menu-main">
				<nav role="navigation" id="nav-main">
                    <ul role="menubar">
                        <li>
                            <a role="menuitem" href="/">Inicio</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#">Estadísticas</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-experiencias" aria-haspopup="true" aria-expanded="false">Experiencias</a>
                            <div class="sub-menu" id="menu-experiencias">
                                <div class="sub-menu-list">
                                    
                                    <ul role="menu" aria-label="Experiencias">
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-beach hidden-xs hidden-sm" aria-hidden="true"></span> Sol y playa</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-account-child hidden-xs hidden-sm" aria-hidden="true"></span> Cultura</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-leaf hidden-xs hidden-sm" aria-hidden="true"></span> Naturaleza</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-swim hidden-xs hidden-sm" aria-hidden="true"></span> Náutico</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-church hidden-xs hidden-sm" aria-hidden="true"></span> Religioso</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-calendar-clock hidden-xs hidden-sm" aria-hidden="true"></span> Reuniones y eventos</a>
                                        </li>
                                    </ul>
                                           
                                </div>
                                <div class="sub-menu-preview hidden-xs hidden-sm">
                                    <h2>Experiencias</h2>
                                    <hr/>
                                    <ul class="tiles tiles-mini">
                                        
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="data:image/jpeg;base64,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" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="http://aventurecolombia.com/sites/default/files/santa_marta_1_1.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="https://cuponassets.cuponatic-latam.com/backendCo/uploads/imagenes_descuentos/125832/9602ad9a26fea0b2606330c44dce54c6d069c8f3.XL2.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    <hr/>
                                    <div class="text-right">
                                        <a class="btn btn-primary" href="#">Ver más</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-queHacer" aria-haspopup="true" aria-expanded="false">Qué hacer</a>
                            <div class="sub-menu" id="menu-queHacer">
                                <div class="sub-menu-list">
                                    <ul role="menu" aria-label="Qué hacer">
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-calendar hidden-xs hidden-sm" aria-hidden="true"></span> Eventos</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-beach hidden-xs hidden-sm" aria-hidden="true"></span> Atracciones</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-run hidden-xs hidden-sm" aria-hidden="true"></span> Actividades</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-map-marker hidden-xs hidden-sm" aria-hidden="true"></span> Destinos</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-map-marker-distance hidden-xs hidden-sm" aria-hidden="true"></span> Rutas turísticas</a>
                                        </li> 
                                    </ul>
                                           
                                </div>
                                <div class="sub-menu-preview hidden-xs hidden-sm">
                                    <h2>Qué hacer</h2>
                                    <hr/>
                                    <ul class="tiles tiles-mini">
                                        
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="data:image/jpeg;base64,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" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="https://cuponassets.cuponatic-latam.com/backendCo/uploads/imagenes_descuentos/125832/9602ad9a26fea0b2606330c44dce54c6d069c8f3.XL2.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="http://aventurecolombia.com/sites/default/files/santa_marta_1_1.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="data:image/jpeg;base64,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" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr/>
                                    <div class="text-right">
                                        <a class="btn btn-primary" href="#">Ver más</a>
                                    </div>
                                </div>
                            </div>
                            
                        </li>
                        
                        <li>
                            <a role="menuitem" href="#menu-servicios" aria-haspopup="true" aria-expanded="false">Servicios</a>
                            <div class="sub-menu" id="menu-servicios">
                                <div class="sub-menu-list">
                                    <ul role="menu" aria-label="Servicios">
                                
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-hotel hidden-xs hidden-sm" aria-hidden="true"></span> Alojamientos</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-silverware-fork-knife hidden-xs hidden-sm" aria-hidden="true"></span> Establecimientos de gratronomía</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-airplane hidden-xs hidden-sm" aria-hidden="true"></span> Agencias de viaje</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-soccer-field hidden-xs hidden-sm" aria-hidden="true"></span> Establecimientos de esparcimiento y similares</a>
                                        </li>
                                        <li role="none">
                                            <a role="menuitem" href="#"><span class="mdi mdi-bus hidden-xs hidden-sm" aria-hidden="true"></span> Transporte especializado</a>
                                        </li>
                                    </ul>
                                           
                                </div>
                                <div class="sub-menu-preview hidden-xs hidden-sm">
                                    <h2>Servicios</h2>
                                    <hr/>
                                    <ul class="tiles tiles-mini">
                                        
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="data:image/jpeg;base64,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" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="http://aventurecolombia.com/sites/default/files/santa_marta_1_1.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="tile tile-overlap">
                                            <a href="#">
                                                <div class="tile-img">
                                                    <img src="https://cuponassets.cuponatic-latam.com/backendCo/uploads/imagenes_descuentos/125832/9602ad9a26fea0b2606330c44dce54c6d069c8f3.XL2.jpg" alt=""/>
                                                    <div class="text-overlap"><p>Parque Nacional Natural Tayrona</p></div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    <hr/>
                                    <div class="text-right">
                                        <a class="btn btn-primary" href="#">Ver más</a>
                                    </div>
                                </div>
                            </div>
                            <!--<ul role="menu" id="menu-servicios" aria-label="Servicios">-->
                                
                            <!--    <li role="none">-->
                            <!--        <a role="menuitem" href="#">Alojamientos</a>-->
                            <!--    </li>-->
                            <!--    <li role="none">-->
                            <!--        <a role="menuitem" href="#">Establecimientos de gratronomía</a>-->
                            <!--    </li>-->
                            <!--    <li role="none">-->
                            <!--        <a role="menuitem" href="#">Agencias de viaje</a>-->
                            <!--    </li>-->
                            <!--    <li role="none">-->
                            <!--        <a role="menuitem" href="#">Establecimientos de esparcimiento y similares</a>-->
                            <!--    </li>-->
                            <!--    <li role="none">-->
                            <!--        <a role="menuitem" href="#">Transporte especializado</a>-->
                            <!--    </li>-->
                            <!--</ul>-->
                        </li>
                        <li>
                            <a role="menuitem" href="#">Noticias</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#">Publicaciones</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#">Planifica tu viaje</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#">Mapa</a>
                        </li>
                    </ul>
                </nav>
			</div>
		</div>
	</header>
	
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