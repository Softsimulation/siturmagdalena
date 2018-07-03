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
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<header>
		<div class="brand">
			<a href="#">
				<img src="{{asset('img/brand/default.png')}}" alt="Logo de SITUR Magdalena">
				<h1 class="sr-only">SITUR Magdalena</h1>
			</a>
			
		</div>
		<div id="nav-bar-main">
			<div id="toolbar-main">
			    <a href="#content-main" id="goto-top" class="sr-only">Ir al contenido</a>
				<a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
				<a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>
				<a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>
				<!-- *AQUI IRIA EL PLUGIN DEL CLIMA* -->
				<a href="#">Mapa del sitio</a>
				<form name="searchMainForm" method="get" action="">
					<label class="sr-only" for="searchMainTBox">Campo de búsqueda</label>
					<input type="text" id="searchMainTBox" name="search" maxlength="255" placeholder="Búsqueda..." required/>
					<button type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> <span class="sr-only">Buscar</span></button>
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
				<a href="#"><span span="glyphicon glyphicon-user" aria-hidden="true"></span> Iniciar sesión</a>
			</div>
			<div id="nav-menu-main">
				<nav role="navigation" id="nav-main">
                    <ul role="menubar">
                        <li>
                            <a role="menuitem" href="/">Inicio</a>
                        </li>
                        <li>
                            <a role="menuitem" href="/">Estadísticas</a>
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-experiencias" aria-haspopup="true" aria-expanded="false">Experiencias</a>
                            <ul role="menu" id="menu-experiencias" aria-label="Experiencias">
                                <li role="none">
                                    <a role="menuitem" href="#">Sol y playa</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Cultura</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Naturaleza</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Náutico</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Religioso</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Reuniones y eventos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a role="menuitem" href="#menu-queHacer" aria-haspopup="true" aria-expanded="false">Qué hacer</a>
                            <ul role="menu" id="menu-queHacer" aria-label="Qué hacer">
                                <li role="none">
                                    <a role="menuitem" href="#">Eventos</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Atracciones</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Actividades</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Destinos</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Rutas turísticas</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li>
                            <a role="menuitem" href="#menu-servicios" aria-haspopup="true" aria-expanded="false">Servicios</a>
                            <ul role="menu" id="menu-servicios" aria-label="Servicios">
                                <li role="none">
                                    <a role="menuitem" href="#">Alojamientos</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Establecimientos de gratronomía</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Agencias de viaje</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Establecimientos de esparcimiento y similares</a>
                                </li>
                                <li role="none">
                                    <a role="menuitem" href="#">Transporte especializado</a>
                                </li>
                            </ul>
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
	    <div class="container text-center">
	        <img src="{{asset('img/brand/others/logo_mincit.png')}}" alt="Logo de Ministerio de Comercio, Industria y Turismo">
	        <img src="{{asset('img/brand/others/logo_fontur.png')}}" alt="Logo de FONTUR">
	        <img src="{{asset('img/brand/others/logo_gobierno.png')}}" alt="Logo de Gobierno de Colombia">
	        <img src="{{asset('img/brand/others/logo_cotelco.png')}}" alt="Logo de Cotelco Magdalena">
	    </div>
	    <div class="container">
	        <div class="row">
	            <div class="col-xs-12 col-sm-6 col-md-4">
	                <h3></h3>
	            </div>
	            <div class="col-xs-12 col-sm-6 col-md-4">
	                <h3>Información de contacto</h3>
	                
	                <ul class="list-footer">
                        <li><span class="glyphicon glyphicon-earphone"></span> Oficina: (+57) (5) 422 2289. Celular: (300) 531 5837<br></li>
                        <li><span class="glyphicon glyphicon-map-marker"></span> Calle 24 N° 3-99. Torre empresarial Banco de Bogotá<br>Oficina 9-10</li>
                    </ul>
	            </div>
	            <div class="col-xs-12 col-sm-6 col-md-4">
	                <h3>Síguenos en nuestras redes sociales</h3>
	                <div class="text-center">
	                    <a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-twitter" aria-hidden="true"></span> <span class="sr-only">Twitter</span></a>
        				<a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-facebook" aria-hidden="true"></span> <span class="sr-only">Facebook</span></a>
        				<a href="#" target="_blank" rel="noreferrer noopener"><span class="ion-social-instagram" aria-hidden="true"></span> <span class="sr-only">Instagram</span></a>
	                </div>
	                <p>O descarga nuestra aplicación móvil</p>
	                
	            </div>
	        </div>
	    </div>
	    <div ="sign-footer">
	        <div class="container text-center">
	            Desarrollado por Softsimulation S.A.S - SITUR Magdalena &copy; 2018
	            <a href="#goto-top" class="sr-only">Volver al inicio</a>
	        </div>
	        
	    </div>
		
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('/js/public/script-main.js')}}"></script>
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
</body>
</html>