@extends('layout._AdminLayout')

@section('title', 'Autenticación')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
        }
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Autenticación')

@section('content')

<div role="tabpanel" class="tab-pane" id="dependencias">
                        <div  style="padding:30px">
                            <br>
                            @if(Session::has('message'))
                                <span class="messages">
                                    <span class="color_errores">{{Session::get('message')}}</span>
                                </span>
                            @endif
                            <br><br>
                                
                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="login">
                                <form class="form-horizontal" name="formLogin"  action="/login/autenticacion" method="POST" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <div class="form-group row col-sm-12 col-xs-12" >
                                      
                                      <input type="text" name="userName" class="form-control" id="inputEmail3" placeholder="Nombre de usuario">
                                      
                                  </div>
                
                                 <div class="form-group col-sm-12 col-xs-12" >
                                    
                                      <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Contraseña">
                                    
                                  </div>
                                  <div class="form-group col-sm-12 col-xs-12" style="text-align:center;">
                                      
                                      <button type="submit" class="btn btn-default" id="btn-login">Iniciar sesión</button>
                                      
                                  </div>
                                  
                                </form>
                            </div>
                        </div>
                    </div>
                    @endsection