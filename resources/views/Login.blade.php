
<!DOCTYPE HTML>
<html>
<head>
<title>Inicio de Sesión de SITUR MAGDALENA</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Sistema de Información Turística del Magdalena y de Santa Marta D.T.C.H">
<meta name="keywords" content="SITUR Magdalena, Visita Magdalena, Visit Magdalena, Turismo en el Magdalena, estadisticas Magdalena, Magdalena" />
<meta name="author" content="Softsimulation S.A.S" />
<meta name="copyright" content="SITUR Capítulo Magdalena, Softsimulation S.A.S" />

<meta property="og:type" content="website" />
<meta property="og:url" content="{{\Request::url()}}" />
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
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="{{asset('css/dashboard/style.css')}}" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="{{asset('css/dashboard/font-awesome.css')}}" rel="stylesheet"> 
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="{{asset('css/dashboardcss/icon-font.min.css')}}" type='text/css' />
<!-- //lined-icons -->
<style>
	.error_page{
		background-image: url('/img/bg-login.jpg');
		background-size: cover;
		background-position: center;
	}
	.login input[type="submit"]{
		border: 2px solid #019bd3;
		background: #1b5f9d;
	}
</style>
<!--clock init-->
</head> 
<body>
								<!--/login-->
								
									   <div class="error_page">
												<!--/login-top-->
												
													<div class="error-top">
													
													    <div class="login">
													    	<img src="{{asset('img/brand/default.png')}}" alt="Logo de SITUR Magdalena" style="margin-bottom: 1rem;">
														<h3 class="inner-tittle t-inner">Inicio de Sesión</h3>
														 @if(Session::has('message'))
                                                            <span class="messages">
                                                                <span style="
															    color: red;
															    border-radius: 3px;
															    padding: 1px;
															    font-weight: bold;
															    font-size: 0.6em;">
                                                                	{{Session::get('message')}}</span>
                                                            	</span>
                                                        @endif
																<div class="buttons login">
																			
																		</div>
																<form action="/login/autenticacion" method="POST">
																		<input type="text" name="userName" class="text" placeholder="Email" >
																		<input type="password" name="password" placeholder="Contraseña">
																		<div class="submit"><input type="submit" value="Iniciar"/></div>
																		<div class="clearfix"></div>
																		
																		<div class="new">																
																			<div class="clearfix"></div>
																		</div>
																	</form>
																	<div>
																		<a href="/postulado/crear">Registrar usuario</a>
																	</div>
														</div>

														
													</div>
													
													
												<!--//login-top-->
										   </div>
						
										  	<!--//login-->
										    <!--footer section start-->
										<div class="footer">
												<div class="error-btn">
															
															</div>
										   <p>Situr Magdalena 2018 | Desarrollado por <a href="https://softsimulation.com/" target="_blank">Softsimulation S.A.S</a></p>
										</div>
									<!--footer section end-->
									<!--/404-->
<!--js -->

</body>
</html>