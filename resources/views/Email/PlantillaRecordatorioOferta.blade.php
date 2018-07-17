<html>
	<head>
		<title>PLANTILLA DE CORREO</title>
		<style>
			*{
				font-family: Arial, sans-serif;
			}
			body{
				background-color: #CFD8DC;
				margin: 0;
				font-size: 14px;
			}
			.container{
				width: 80%;
				margin: 4% auto;
				background-color: white;
				box-shadow: 0px 0px 3px 0px rgba(0,0,0,.35);
				border-radius: 5px;
				overflow: hidden;
			}
			.container>.header{
				border-bottom: .5px solid lightgrey;
				padding: .5em 4%;
				text-align: center;
				background-color: #F5F5F5;
				
			}
			.container>.header>img{
				height: 100px;
			}
			.container>.title{
				padding: .2em 4%;
				background-color: dodgerblue;
				color: white;
				text-align: center;
			}
			.container>.title>h1{
				font-size: 1.5em;
				display: inline;
				margin: 0;
				text-transform: uppercase;
			}
			p{
				text-align: justify;
			}
			.container>.content{
				padding: 1em 4%;
			}
			.container>.footer{
				border-top: .5px solid lightgrey;
				padding: .5em 4%;
				text-align: center;
			}

		</style>
	</head>
	<body>
	<div class="container">
		<div class="header">
			<img src="https://siturmagdalena.com/Content/image/logo.min.png" alt="logo">
		</div>
		<div class="title">
			<h1>Recordatorio MinCIT – SITUR Magdalena.</h1>
		</div>
		<div class="content">
			<p>Estimado/a</p>
			<p>Sr (a)  <b>{{$nombre}}</b></p>
			<p>Cordial Saludo:</p>
            <p>Recientemente lo invitamos a diligenciar la siguiente encuesta para el mes de {{$mes}}  de {{$anio}} la cual, permitirá caracterizar el impacto económico que genera su establecimiento en beneficio del sector turístico.</p>
			
            <p>Sin embargo, notamos que aún no la ha diligenciado y agradecemos su valiosa participación para generar estadísticas confiables del departamento de Magdalena.</p>
			
			
            <p>Para diligenciarla presione el siguiente <a href="https://www.siturmagdalena.com/Account/login">link</a></p>
			

            <p>El Ministerio de Comercio, Industria y Turismo cordialmente insiste en que su colaboración es vital para poder generar información que permita el desarrollo del sector; y le recordamos que la información que usted nos suministre será tratada con total confidencialidad de acuerdo al mandato de Ley Habeas Data para el tratamiento de información privada. Así mismo, funcionarios del MinCIT y de SITUR estarán cerciorándose de que la encuesta se encuentre totalmente diligenciada.</p>
			<p>Si tiene alguna inquietud no dude en comunicarse al correo: <a href="mailto:info@siturmagdalena.com">info@siturmagdalena.com</a></p>
			<p>Muchas gracias por su tiempo y dedicación al desarrollo del sector turístico del departamento del Magdalena.</p>

			<p>Atentamente,</p>
            <p>Equipo SITUR Magdalena</p>
            <p>Si tiene alguna inquietud no dude en comunicarse al correo: <a href="mailto:info@siturmagdalena.com">info@siturmagdalena.com</a></p>
            <p>Muchas gracias por su tiempo y dedicación al desarrollo del sector turístico del departamento del Magdalena.</p>

		</div>
		<div class="footer">
			<img src="https://siturmagdalena.com/Content/icons/logos2.png" alt="Logos" height="60">
		</div>
	</div>
		

	</body>
</html>