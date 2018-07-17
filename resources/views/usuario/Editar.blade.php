@extends('layout._AdminLayout')

@section('title', 'Guardar usuario')

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
        p {
            font-size: .9em;
        }
        .row {
            margin: 1em 0 0;
        }
    </style>
@endsection

@section('TitleSection', 'Guardar usuario')

@section('app','ng-app="admin.usuario"')

@section('controller','ng-controller="editarUsuarioCtrl"')

@section('content')


<div class="main-page">
    <h1 class="title1">Editar usuario</h1><br />
    <div class="alert alert-danger" ng-if="errores != null">
        <h3>Corriga los siguientes errores:</h3>
        <div ng-repeat="error in errores">
            -@{{error[0]}}
        </div>
    </div>

    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <form role="form" name="crearForm" novalidate>
            <input type="hidden" name="id" id="id" ng-init="usuario.id={{$id}}"/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="input-group">
                        <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Todos los campos son obligatorios</strong> </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group" ng-class="{'error': (crearForm.$submitted || crearForm.nombres.$touched) && crearForm.nombres.$error.required }">
                        <label class="control-label" for="nombres"><span class="asterisk">*</span>Nombres</label>
                        <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Ingrese el o los nombres del docente. Máx. 255 caracteres" maxlength="255" ng-model="usuario.nombres" required />
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.required))}">
                        <label class="control-label" for="email"><span class="asterisk">*</span>Correo electrónico</label>
                        <input class="form-control" type="email" name="email" id="email"  placeholder="Ej: micorreo@dominio.com. Máx. 255 caracteres" maxlength="255" ng-model="usuario.email" required />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.email.$touched) && crearForm.email.$error.required">&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.password1.$touched) && (usuario.password1!= usuario.password2)))}">
                        <label class="control-label" for="password1">Contraseña nueva</label>
                        <input class="form-control" type="password" name="password1" id="password1" ng-model="usuario.password1" ng-maxlength="150" />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.password1.$touched) && (usuario.password1!= usuario.password2)">&nbsp;</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" ng-class="{ 'error':(((crearForm.$submitted || crearForm.password2.$touched) && (usuario.password1!= usuario.password2) ))}">
                        <label class="control-label" for="password2">Confirmar contraseña</label>
                        <input class="form-control" type="password" name="password2" id="password2" ng-model="usuario.password2" ng-maxlength="150" />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.password2.$touched) && (usuario.password1!= usuario.password2)">&nbsp;</span>
                        <span class="text-error" ng-show="usuario.password2 != usuario.password1">&nbsp;</span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-group"><span class="asterisk">*</span>Roles</label>
                  <ui-select multiple sortable="true" ng-model="usuario.rol" theme="select2" title="Escoja rol(es)" style="width:100%;">
                    <ui-select-match placeholder="Seleccione rol(es)">@{{$item.display_name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in roles | filter: $select.search">
                      <div ng-bind-html="item.display_name | highlight: $select.search"></div>
                    </ui-select-choices>
                  </ui-select>
        
                </div>
              </div>
            

            <div class="row" style="text-align: center;">
                <a type="button" class="btn btn-default" href="/usuario/listadousuarios">Cancelar</a>
                <button type="button" class="btn btn-success" ng-click="editarUsuario()" ng-disabled="crearForm.$invalid">Guardar</button>
            </div>
        </form>
    </div>
    <div class='carga'>

    </div>

    
</div>
@endsection