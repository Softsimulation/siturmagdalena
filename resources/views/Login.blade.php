
<!DOCTYPE HTML>
<html>
<head>
<title>Inicio de Sesión de SITUR Atlántico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Augment Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
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

<!--clock init-->
</head> 
<body>
								<!--/login-->
								
									   <div class="error_page">
												<!--/login-top-->
												
													<div class="error-top">
													
													    <div class="login">
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
																		<div><a href="/postulado/crear">Registro de usuario</a></div>
																		<div class="new">																
																			<div class="clearfix"></div>
																		</div>
																	</form>
														</div>

														
													</div>
													
													
												<!--//login-top-->
										   </div>
						
										  	<!--//login-->
										    <!--footer section start-->
										<div class="footer">
												<div class="error-btn">
															
															</div>
										   <p>Situr Atlántico 2018 | Design by <a href="#" target="_blank">SOFTSIMULATION S.A.S</a></p>
										</div>
									<!--footer section end-->
									<!--/404-->
<!--js -->

</body>
</html>