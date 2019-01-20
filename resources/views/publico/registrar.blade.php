@extends('layout._publicLayout')

@section('Title','Registrar')

@section ('estilos')
    <style>
        header{
            position: static;
            background-color: black;
            margin-bottom: 1rem;
        }
        .nav-bar > .brand a img{
            height: auto;
        }
        /*main{*/
        /*    padding: 2% 0;*/
        /*}*/
    </style>
@endsection
@section('content')
    <div class="container">
        <h2 class="title-section">Registro</h2>
        @if($errores != null)
            <div class="alert alert-danger">
                <h6>Errores</h6>
                @foreach($errores as $error)
                    <span class="messages">
                          <span>{{$error}}</span>
                    </span>
                @endforeach
            </div> 
        @endif
        @if($mensajeExito != null)
            <div class="alert alert-success">
                <h6>Exito</h6>
                <span class="messages">
                      <span>{{$mensajeExito}}</span><br/>
                </span>
            </div>
        @endif
        <form id="signupform" name="registrarForm" class="form-horizontal" role="form" action="/registrar/registrarusuario" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" required/>
			</div>
			<div class="form-group">
                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese su nombre" required/>
			</div>
			<div class="form-group">
                <input type="password" class="form-control" name="password1" id="password1" placeholder="Contraseña" required/>
			</div>
			<div class="form-group">
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmar contraseña" required/>
			</div>
			<div class="form-group">
			    <button type="submit" class="btn btn-success">Enviar</button>
			</div>
        </form>
        
        
<a class="btn btn-primary" href="/registrar/autenticacion/facebook">
    Facebook
</a>
<a class="btn btn-primary" href="/registrar/autenticacion/google">
    Google
</a>
    </div>

@endsection