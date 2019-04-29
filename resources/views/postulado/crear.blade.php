@extends('layout._publicLayout')

@section('title', 'Crear usuario')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

        .filter-select {
            color: darkgray;
            border: 1px solid lightgrey;
            font-family: Arial;
            font-size: 1.2em;
        }

        .messages {
            color: #FA787E;
        }

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .mensaje-caracteres {
            float: right;
            margin-top: -2px;
            padding: 0px;
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
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .row {
            margin: 1em 0 0;
        }
        label {
            font-weight: 500;
        }
    </style>
    
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/styleLoading.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('TitleSection', 'Crear usuario')



@section('content')
<div class="main-page" ng-app="postuladoApp" ng-controller="crearPostuladoCtrl">
    <div class="container">
        @if(isset($id))
            <input type="hidden" ng-model="id" ng-init="id={{ Session::get('vacante')}}" />
        @endif
    
        
        
        <h1 class="title1 text-center">Registro de usuario</h1>
        <div class="row">
            <div class="alert alert-danger" ng-if="errores != null">
                <h3>Corriga los siguientes errores:</h3>
                <div ng-repeat="error in errores">
                    -@{{error[0]}}
                </div>
            </div>    
        </div>
        <p class="text-center">Puede iniciar sesión mediante las siguientes redes sociales</p>
        <div class="text-center mb-3">
            <a class="btn btn-primary" href="/registrar/autenticacion/facebook">
                Facebook
            </a>
            <a class="btn btn-danger" href="/registrar/autenticacion/google">
                Google
            </a>
        </div>
        <p class="text-center">O puede registrarse a través del siguiente formulario</p>
        <!--<div class="alert alert-info" role="alert" style="text-align: center;">Debe llenar los datos de configuración</div>-->
        
        @if( Auth::check() )
            <div class="alert alert-info" role="alert" style="text-align: center;">Si el usuario ya se encuentra registrado en el sistema se recomienda que utilice el correo con el cual inicia sesión.</div>
        @endif
        
        <form role="form" name="crearForm" novalidate>
            <fieldset>
                <legend>Formuario de registro de usuario</legend>
                <div class="alert alert-info">
                    Todos los campos del formulario son obligatorios
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error': (crearForm.$submitted || crearForm.nombres.$touched) && crearForm.nombres.$error.required }">
                            <label class="control-label" for="nombres">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese el o los nombres del usuario. Máx. 255 caracteres" maxlength="255" ng-model="usuario.nombres" required />
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.nombres.$touched) && crearForm.nombres.$error.required">El campo es requerido</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error': (crearForm.$submitted || crearForm.apellidos.$touched) && crearForm.apellidos.$error.required }">
                            <label class="control-label" for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese el o los apellidos del usuario. Máx. 255 caracteres" maxlength="255" ng-model="usuario.apellidos" required />
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.apellidos.$touched) && crearForm.apellidos.$error.required">El campo es requerido</span>
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.required))}">
                            <label class="control-label" for="email">Correo electrónico</label>
                            <input class="form-control" type="email" name="email" id="email"  placeholder="Ej: micorreo@dominio.com. Máx. 255 caracteres" maxlength="255" ng-model="usuario.email" required />
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.required">Campo requerido</span>
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.email">El campo no es de tipo correo</span>
                        </div>
                    </div>
                    <div class="col-md-3" ng-class="{ 'error':(((crearForm.$submitted || crearForm.fecha_nacimiento.$touched) && crearForm.fecha_nacimiento.$error.required))}">
                        <div class="form-group" >
                            <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento</label>
                            <adm-dtp name="fecha_nacimiento" id="fecha_nacimiento" ng-model='usuario.fecha_nacimiento' maxdate="@{{fechaActual}}"options="optionFecha" placeholder="Ingrese fecha de nacimiento" ng-required="true"></adm-dtp>
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.fecha_nacimiento.$touched) && crearForm.fecha_nacimiento.$error.required">Campo requerido</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" ng-class="{'error': (crearForm.$submitted || crearForm.profesion.$touched) && crearForm.profesion.$error.required }">
                            <label class="control-label" for="profesion">Profesión</label>
                            <input type="text" class="form-control" name="profesion" id="profesion" placeholder="Ingrese la profesión. Máx. 255 caracteres" maxlength="255" ng-model="usuario.profesion" ng-required="id !== undefined" />
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.profesion.$touched) && crearForm.profesion.$error.required">El campo es requerido</span>
                        </div>
                    </div>
                </div>
            </fieldset>
            
            
            
            
            
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sexo" class="control-label">Sexo</label>
                        <div id="sexo">
                            <label class="radio-inline">
                              <input type="radio" name="sexo" ng-model="usuario.sexo" id="sexo-1" value="1"> Masculino
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="sexo" ng-model="usuario.sexo" id="sexo-2" value="0"> Femenino
                            </label>
                        </div>
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.sexo.$touched) && crearForm.sexo.$error.required">El campo es requerido</span>
                    </div>
                </div>
                <div class="col-md-4" ng-class="{'error' : (crearForm.$submitted || crearForm.departamento.$touched) && crearForm.departamento.$error.required}">
                    <div class="form-group">
                        <label for="departamento" class="control-label">Departamento de residencia</label>
                        <ui-select id="departamento"  name="departamento" ng-model="usuario.departamento" ng-change="changemunicipio()"  ng-required="true">
                            <ui-select-match placeholder="Seleccione departamento">@{{$select.selected.nombre}}</ui-select-match>
                            <ui-select-choices repeat="item.id as item in departamentos | filter:$select.search">
                                @{{item.nombre}}
                            </ui-select-choices>
                        </ui-select>
                        <span ng-show="crearForm.$submitted || crearForm.departamento.$touched">
                            <span class="label label-danger" ng-show="crearForm.departamento.$error.required">*El campo es requerido</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-4" ng-class="{'error' : (crearForm.$submitted || crearForm.municipio.$touched) && crearForm.municipio.$error.required}">
                    <div class="form-group">
                        <label for="municipio" class="control-label">Municipio de residencia</label>
                        <ui-select id="municipio"  name="municipio" ng-model="usuario.municipio_id"  ng-required="true">
                            <ui-select-match placeholder="Seleccione municipio">@{{$select.selected.nombre}}</ui-select-match>
                            <ui-select-choices repeat="item.id as item in municipios | filter:$select.search">
                                @{{item.nombre}}
                            </ui-select-choices>
                        </ui-select>
                        <span ng-show="crearForm.$submitted || crearForm.municipio.$touched">
                            <span class="label label-danger" ng-show="crearForm.municipio.$error.required">*El campo es requerido</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.password1.$touched) && crearForm.password1.$error.required))}">
                        <label class="control-label" for="password1">Contraseña</label>
                        <input class="form-control" type="password" name="password1" id="password1" ng-model="usuario.password1" required ng-maxlength="150" />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.password1.$touched) && crearForm.password1.$error.required">*EL campo es requerido</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.password2.$touched) && crearForm.password2.$error.required))}">
                        <label class="control-label" for="password2">Confirmar contraseña</label>
                        <input class="form-control" type="password" name="password2" id="password2" ng-model="usuario.password2" required ng-maxlength="150" />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.password2.$touched) && crearForm.password2.$error.required">*EL campo es requerido</span>
                        <span class="text-error" ng-show="usuario.password2 != usuario.password1">Verifique que las constraseñas coincidas</span>
                    </div>
                </div>
            </div>
            
            <div class="row" style="text-align: center;">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-success" ng-click="guardarUsuario()" >Guardar</button>    
                </div>
            </div>
        </form>
    <div class='carga'>

    </div>

    
    </div>
    
</div>
@endsection

@section('javascript')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
    
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}" async></script>
    <script src="{{asset('/js/postulado/main.js')}}"></script>
    <script src="{{asset('/js/postulado/service.js')}}"></script>
@endsection