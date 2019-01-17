@extends('layout._publicLayout')

@section('Title','Reset password')

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
 <h1>Resetear el password</h1>
 @if (count($errors) > 0)
  <div class="alert alert-danger">
   Los datos introducidos en el formulario son incorrectos.
  </div>
 @endif
 <hr />
 <form method="POST" action="{{url('password/reset')}}">
  {{csrf_field()}}
  <input type="hidden" name="token" value="{{$token}}" />

  <div class="form-group">
   <label for="email">Email:</label>
   <input type="email" class="form-control" name="email" value="{{Input::old('email')}}" />
   <div class="text-danger">{{$errors->first('email')}}</div>
  </div>

  <div class="form-group">
   <label for="password">Password:</label>
   <input type="password" class="form-control" name="password" />
   <div class="text-danger">{{$errors->first('password')}}</div>
  </div>

  <div class="form-group">
   <label for="password_confirmation">Confirmar Password:</label>
   <input type="password" class="form-control" name="password_confirmation" />
  </div>
  <button type="submit" class="btn btn-primary">Resetear Password</button>
 </form>
 </div>
@stop
