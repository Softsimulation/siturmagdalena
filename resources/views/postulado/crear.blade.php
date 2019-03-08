@extends('layout._publicLayout')

@section('title', 'Crear usuario')

@section('estilos')
    <style>
        

        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        label{
            font-weight: 500;
            margin: 0;
        }
    </style>
    
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
@endsection

@section('TitleSection', 'Crear usuario')



@section('content')
<div class="container" ng-app="postuladoApp" ng-controller="crearPostuladoCtrl">
    
    @if(isset($id))
        <input type="hidden" ng-model="id" ng-init="id={{ Session::get('vacante')}}" />
    @endif

    
    
    <h2 class="title1">Registro de postulado</h2>
    <div class="row">
        <div class="alert alert-danger" ng-if="errores != null">
            <h3>Corriga los siguientes errores:</h3>
            <div ng-repeat="error in errores">
                -@{{error[0]}}
            </div>
        </div>    
    </div>
    
    @if( Auth::check() )
        <div class="alert alert-info" role="alert" style="text-align: center;">Si el usuario ya se encuentra registrado en el sistema se recomienda que utilice el correo con el cual inicia sesión.</div>
    @endif
    
    
        <form role="form" name="crearForm" novalidate>
             <fieldset>
                <legend>Formulario de registro</legend>
                <div class="alert alert-info">
                    <p>Todos los campos de información son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.nombres.$touched) && crearForm.nombres.$error.required }">
                            <label class="control-label" for="nombres">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese el o los nombres del usuario. Máx. 255 caracteres" maxlength="255" ng-model="usuario.nombres" required />
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.apellidos.$touched) && crearForm.apellidos.$error.required }">
                            <label class="control-label" for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese el o los apellidos del usuario. Máx. 255 caracteres" maxlength="255" ng-model="usuario.apellidos" required />
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group" ng-class="{ 'has-error':((crearForm.$submitted || crearForm.email.$touched) && (crearForm.email.$error.required || crearForm.email.$error.email))}">
                            <label class="control-label" for="email">Correo electrónico</label>
                            <input class="form-control" type="email" name="email" id="email"  placeholder="Ej: micorreo@dominio.com. Máx. 255 caracteres" maxlength="255" ng-model="usuario.email" required />
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.email">El campo no es de tipo correo</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4" ng-class="{ 'has-error':(((crearForm.$submitted || crearForm.fecha_nacimiento.$touched) && crearForm.fecha_nacimiento.$error.required))}">
                        <div class="form-group" >
                            <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento</label>
                            <adm-dtp name="fecha_nacimiento" id="fecha_nacimiento" ng-model='usuario.fecha_nacimiento' maxdate="@{{fechaActual}}"options="optionFecha" placeholder="Ingrese fecha de nacimiento" ng-required="true"></adm-dtp>
                            <span class="text-error" ng-show="(crearForm.$submitted || crearForm.fecha_nacimiento.$touched) && crearForm.fecha_nacimiento.$error.required">Campo requerido</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.profesion.$touched) && crearForm.profesion.$error.required }">
                            <label class="control-label" for="profesion">Profesión</label>
                            <input type="text" class="form-control" name="profesion" id="profesion" placeholder="Ingrese la profesión. Máx. 255 caracteres" maxlength="255" ng-model="usuario.profesion" required />
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label for="sexo" class="control-label btn-block">Sexo</label>
                            <div class="radio radio-primary" style="display:inline-block;">
                                <label>
                                    <input type="radio"  value="1" name="sexo" required ng-model="usuario.sexo">
                                    Masculino
                                </label>
                            </div>
                            <div class="radio radio-primary" style="display:inline-block;">
                                <label>
                                    <input type="radio"  value="0" name="sexo" required ng-model="usuario.sexo">
                                    Femenino
                                </label>
                            </div>
                            <span class="text-error btn-block" ng-show="(crearForm.$submitted || crearForm.sexo.$touched) && crearForm.sexo.$error.required">El campo es requerido</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4" ng-class="{'has-error' : (crearForm.$submitted || crearForm.departamento.$touched) && crearForm.departamento.$error.required}">
                        <div class="form-group">
                            <label for="departamento" class="control-label">Departamento de residencia</label>
                            <ui-select id="departamento"  name="departamento" ng-model="usuario.departamento" ng-change="changemunicipio()"  ng-required="true">
                                <ui-select-match placeholder="Seleccione departamento">@{{$select.selected.nombre}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in departamentos | filter:$select.search">
                                    @{{item.nombre}}
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4" ng-class="{'has-error' : (crearForm.$submitted || crearForm.municipio.$touched) && crearForm.municipio.$error.required}">
                        <div class="form-group">
                            <label for="municipio" class="control-label">Municipio de residencia</label>
                            <ui-select id="municipio"  name="municipio" ng-model="usuario.municipio_id"  ng-required="true">
                                <ui-select-match placeholder="Seleccione municipio">@{{$select.selected.nombre}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in municipios | filter:$select.search">
                                    @{{item.nombre}}
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{ 'has-error':((crearForm.$submitted || crearForm.password1.$touched) && crearForm.password1.$error.required)}">
                            <label class="control-label" for="password1">Contraseña</label>
                            <input class="form-control" type="password" name="password1" id="password1" ng-model="usuario.password1" required maxlength="150" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{ 'has-error':((crearForm.$submitted || crearForm.password2.$touched) && (crearForm.password2.$error.required || usuario.password2 != usuario.password1))}">
                            <label class="control-label" for="password2">Confirmar contraseña</label>
                            <input class="form-control" type="password" name="password2" id="password2" ng-model="usuario.password2" required maxlength="150" />
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" class="btn btn-lg btn-success" ng-click="guardarUsuario()" >Guardar</button> 
                    </div>
                </div>
            </fieldset>
            
            
            
            <div class="row" style="text-align: center;">
                <div class="col-xs-12">
                       <a class="btn btn-primary" href="/registrar/autenticacion/facebook">
                            Facebook
                        </a>
                        <a class="btn btn-primary" href="/registrar/autenticacion/google">
                            Google
                        </a>
                </div>
            </div>
        </form>
    <div class='carga'>

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