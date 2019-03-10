<!DOCTYPE html>
<html @if(Config::get('app.locale') == 'es')lang="es-CO"@endif @if(Config::get('app.locale') == 'en')lang="en-US"@endif>
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
        .weather{
            margin:0 .5rem;
            display: flex;
            align-items: center;
        }
        .weather span:first-child{
            font-size: 1.5rem;
            margin-right: .25rem;
        }
        #widget_valor {
            color: #333;
            font-family: Futura, sans-serif;
            font-size: 1rem;
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
    <!-- vista parcial de cabecera de vista pública -->
    @include('layout.partial.headerPublic')
    
	<main id="content-main" role="main">
	    @yield('content')    
	</main>
	
	<!-- vista parcial de pie de página de vista pública -->
    @include('layout.partial.footerPublic')
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('/js/public/script-main.js')}}"></script>
    <!--<script src="{{asset('/js/vibrant.js')}}"></script>-->
    <!--<script src="{{asset('/js/public/run_vibrant.js')}}"></script>-->
    @yield("javascript")
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js"></script>
    <script>
        // v3.1.0
        //Docs at http://simpleweatherjs.com
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
      <!-- Global site tag (gtag.js) -Código de seguimiento Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106392208-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-106392208-1');
</script>
<script async>
    // window.setTimeout(function(){
    //     document.getElementById('widget_valor').style.color = '#333';
    // },100);
</script>
<script async>
    function searchForm(event) {
        event.preventDefault(); // disable normal form submit behavior
        var win = window.open("https://www.google.com.co/search?q=site:http://www.siturmagdalena.com+" + document.globalSearchForm.search.value, '_blank');
        win.focus();
        
        return false; // prevent further bubbling of event
    }
</script>
 <!-- fin de código de seguimiento-->
 <script>
     var srcList = $('#content-main img').map(function() {
        this.onerror = function(){
            this.src = "/img/brand/72.png";
            
            this.style.width ="auto";
            this.style.height ="auto";
            this.style.minWidth ="0";
            this.style.minHeight ="0";
            
            this.parentElement.className += " img-error";
        }
        return this;
    }).get();
    
    
    function fitImages(){
        var imgs = $('.tile-img:not(.img-error) img');
        for(var i = 0; i < imgs.length; i++){
            if(imgs[i].naturalWidth > imgs[i].naturalHeight){
        		imgs[i].style.width = "100%";
        		imgs[i].style.height = "auto";
        		if(imgs[i].offsetHeight < imgs[i].parentElement.offsetHeight){
        			imgs[i].style.height = "100%";
        			imgs[i].style.width = "auto";
        		}
        	}else{
    			imgs[i].style.height = "100%";
        		imgs[i].style.width = "auto";
        		if(imgs[i].offsetWidth < imgs[i].parentElement.offsetWidth){
        			imgs[i].style.width = "100%";
        			imgs[i].style.height = "auto";
        		}
            }
           
        }
    }
    //fitImages();
    // var imgs = $('.tile-img:not(.img-error) img');
    // console.log(Array.from(imgs));
    // for(var i = 0; i < imgs.length; i++){
    //     imgs[i].onload = function(){
    //         console.log("primero onload");
    //         if(this.naturalWidth > this.naturalHeight){
    //     		this.style.width = "100%";
    //     		this.style.height = "auto";
    //     		if(this.offsetHeight < this.parentElement.offsetHeight){
    //     			this.style.height = "100%";
    //     			this.style.width = "auto";
    //     		}
    //     	}else{
    // 			this.style.height = "100%";
    //     		this.style.width = "auto";
    //     		if(this.offsetWidth < this.parentElement.offsetWidth){
    //     			this.style.width = "100%";
    //     			this.style.height = "auto";
    //     		}
    //         }
    //     };
    // }
    window.onload = function () { fitImages(); }
    document.getElementsByTagName("BODY")[0].onresize = function() {fitImages()};
 </script>
</body>
</html>