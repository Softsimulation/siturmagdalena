<!DOCTYPE HTML>
<html>
<head>
<title>Panel Administrador</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="SITUR, SISTEMA DE INFORMACIÓN TURÍSTICO DEL DEPARTAMENTO" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="{{asset('css/dashboard/style.css')}}" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="{{asset('css/dashboard/font-awesome.css')}}" rel="stylesheet"> 
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
<script src="{{asset('js/administrador/dashboard/css3clock.js')}}"></script>
<!--Easy Pie Chart-->
<!--skycons-icons-->
<script src="{{asset('js/administrador/dashboard/skycons.js')}}"></script>

<script src="{{asset('js/administrador/dashboard/jquery.easydropdown.js')}}"></script>

<!--//skycons-icons-->
</head> 
<body>
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
				
									<!--/charts-inner-->
									</div>
										<!--//outer-wp-->
									</div>
									 <!--footer section start-->
										<footer>
										   <p>&copy 2018 Todos los derechos reservados | Desarrollado por <a href="https://softsimulation.com/" target="_blank">SoftSimulation S.A.S</a></p>
										</footer>
									<!--footer section end-->
								</div>
						
				<!--//content-inner-->
				
				
				
				
				
				
				
			<!--/sidebar-menu-->
				<div class="sidebar-menu">
					<header class="logo">
		 <img  class="img-responsive" width="304" height="236" src="{{asset('Content/image/logo.png')}}"> 
			
				</header>
			<div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
			<!--/down-->
							<div class="down">	
									  <a href="#"><img src="images/admin.jpg"></a>
									  <a href="#"><span class=" name-caret">Usuario</span></a>
									 <p>Rol</p>
									<ul>
									<li><a class="tooltips" href=""><span>Profile</span><i class="lnr lnr-user"></i></a></li>
										<li><a class="tooltips" href="#"><span>Settings</span><i class="lnr lnr-cog"></i></a></li>
										<li><a class="tooltips" href="#"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
										</ul>
									</div>
							   <!--//down-->
                           <div class="menu">
									<ul id="menu" >
										
										 <li id="menu-academico" ><a href="#"><i class="fa fa-table"></i> <span> Turismo Receptor</span></span></a>
										   <ul id="menu-academico-sub" >
											<ligv id="menu-academico-avaliacoes" ><a href="{{asset('grupoviaje/listadogrupos')}}"> Grupo de viajes</a></li>
											<li id="menu-academico-boletim" ><a href="{{asset('turismoreceptor/listadoencuestas')}}">Listado de encuestas</a></li>
											
											
										  </ul>
										</li>
										 <li id="menu-academico" ><a href="#"><i class="fa fa-file-text-o"></i> <span>Turismo Interno y Emisor</span></a>
											 <ul id="menu-academico-sub" >
												<li id="menu-academico-avaliacoes" ><a href="{{asset('temporada')}}">Temporada</a></li>
												<li id="menu-academico-boletim" ><a href="validation.html">Validation Forms</a></li>
										
											  </ul>
										 </li>
								
									<li id="menu-academico" ><a href="#"><i class="lnr lnr-book"></i> <span>Administrar paises</span> </span></a>
										  <ul id="menu-academico-sub" >
										    <li id="menu-academico-avaliacoes" ><a href="{{asset('administrarpaises')}}">Paises</a></li>
										    <li id="menu-academico-boletim" ><a href="{{asset('administrardepartamentos')}}">Departamentos</a></li>
											<li id="menu-academico-boletim" ><a href="{{asset('administrarmunicipios')}}">Municipios</a></li>
											
										  </ul>
									 </li>
								
									 
									 <li><a href="{{asset('MuestraMaestra/periodos')}}"><i class="lnr lnr-envelope"></i> <span>Muestra Maestra</span></a>
									
									</li>
							        <li id="menu-academico" ><a href="{{asset('encuesta/listado')}}"><i class="lnr lnr-layers"></i> <span>Encuetas ADHOC</span></a>
							
									 </li>
								
								
								  </ul>
								</div>
							  </div>
							  
							  
							  
							  
							  
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<link rel="stylesheet" href="css/vroom.css">
<script type="text/javascript" src="js/vroom.js"></script>
<script type="text/javascript" src="js/TweenLite.min.js"></script>
<script type="text/javascript" src="js/CSSPlugin.min.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>

<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
</body>
</html>