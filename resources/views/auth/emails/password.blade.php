
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
			<h1>Reset password MinCIT – SITUR Magdalena.</h1>
		</div>
		<div class="content">
		    <p><strong>Haz click en el siguiente enlace para resetear el password:</strong></p>
            <a href="{{url('/password/reset/')}}/{{$token}}">Resetear mi password</a>

		</div>
		<div class="footer">
			<img src="https://siturmagdalena.com/Content/icons/logos2.png" alt="Logos" height="60">
		</div>
	</div>
		

	</body>
</html>