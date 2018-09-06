@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo - Vacantes')

@section('TitleSection', 'Creación de vacante')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="crearVacanteController"')

@section('estilos')
    <style>
        body{
            overflow: visible;
        }
    </style>
@endsection

@section('content')
    <br><br>
    <div class="alert alert-danger" ng-if="errores != null">
        <h6>Errores</h6>
        <span class="messages" ng-repeat="error in errores">
              <span>@{{error}}</span>
        </span>
    </div>
    
    <div class="container">
       <div>
            <form name="datosForm" role="form" novalidate>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.proveedor.$touched) && datosForm.proveedor.$error.required}">
                            <label for="proveedor" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Empresa</label>
                            <ui-select id="proveedor"  name="proveedor" ng-model="vacante.proveedor_id"  ng-required="true">
                                <ui-select-match placeholder="Seleccione empresa">@{{$select.selected.razon_social}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in proveedores | filter:$select.search">
                                    @{{item.razon_social}}
                                </ui-select-choices>
                            </ui-select>
                            <span ng-show="datosForm.$submitted || datosForm.proveedor.$touched">
                                <span class="label label-danger" ng-show="datosForm.proveedor.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.nombre_vacante.$touched) && datosForm.nombre_vacante.$error.required}">
                            <label for="nombre_vacante" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Nombre de la vacante</label>
                            <input type="text" class="form-control" id="nombre_vacante" name="nombre_vacante" ng-model="vacante.nombre_vacante" ng-maxlength="250" placeholder="Presione aquí para ingresar el nombre de la vacante" required />
                            <span ng-show="datosForm.$submitted || datosForm.nombre_vacante.$touched">
                                <span class="label label-danger" ng-show="datosForm.nombre_vacante.$error.required">*El campo nombre de vacante es requerido</span>
                                <span class="label label-danger" ng-show="datosForm.nombre_vacante.$error.maxlength">*El campo no debe superar los 250 caracteres.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.numero_vacantes.$touched) && datosForm.numero_vacantes.$error.required}">
                            <label for="numero_vacantes" class="col-xs-12 control-label"><span class="glyphicon glyphicon-asterisk"></span> Número de vacantes</label>
                            <input type="number" class="form-control" min="1" ng-model="vacante.numero_vacantes" name="numero_vacantes" placeholder="Ingrese número de vacantes. Min 1" required/>
                            <span ng-show="datosForm.$submitted || datosForm.numero_vacantes.$touched">
                                <span class="label label-danger" ng-show="datosForm.numero_vacantes.$error.required">*El campo es requerido</span>
                                <span class="label label-danger" ng-show="datosForm.numero_vacantes.$error.min">*El campo acepta valores mayores o iguales que 1.</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.perfil.$touched) && datosForm.perfil.$error.required}">
                            <label for="perfil"><span class="glyphicon glyphicon-asterisk"></span> Perfil</label>
                            <textarea class="form-control" name="perfil" id="perfil" ng-model="vacante.perfil" rows="5" required></textarea>
                            <span ng-show="datosForm.$submitted || datosForm.perfil.$touched">
                                <span class="label label-danger" ng-show="datosForm.perfil.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.fecha_inicio.$touched) && datosForm.fecha_inicio.$error.required}">
                            <label for="fecha_inicio" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Fecha de incio</label>
                            <adm-dtp name="fecha_inicio" id="fecha_inicio" ng-model='vacante.fecha_inicio' mindate="@{{fechaActual}}" maxdate="'@{{vacante.fecha_fin}}'" ng-required="true" options="optionFecha" placeholder="Ingrese fecha de inicio"></adm-dtp>
                            <span ng-show="datosForm.$submitted || datosForm.fecha_inicio.$touched">
                                <span class="label label-danger" ng-show="datosForm.fecha_inicio.$error.required">*El campo fecha de aplicación es requerido</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="fecha_fin" class="control-label">Fecha de finalización</label>
                            <adm-dtp name="fecha_fin" id="fecha_fin" ng-model='vacante.fecha_fin' mindate="'@{{vacante.fecha_inicio}}'"options="optionFecha" placeholder="Ingrese fecha de finalización"></adm-dtp>
                        </div>
                    </div>
                    <div class="col-md-4" ng-class="{'error' : (datosForm.$submitted || datosForm.anios_experiencia.$touched) && datosForm.anios_experiencia.$error.required}">
                        <div class="form-group">
                            <label for="anios_experiencia" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Años de experiencia</label>
                            <input type="number" class="form-control" min="0" ng-model="vacante.anios_experiencia" name="anios_experiencia" placeholder="Ingrese años. Min 0" required/>
                            <span ng-show="datosForm.$submitted || datosForm.anios_experiencia.$touched">
                                <span class="label label-danger" ng-show="datosForm.anios_experiencia.$error.required">*El campo es requerido</span>
                                <span class="label label-danger" ng-show="datosForm.anios_experiencia.$error.min">*El campo acepta valores mayores o iguales que 0.</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4" ng-class="{'error' : (datosForm.$submitted || datosForm.municipio.$touched) && datosForm.municipio.$error.required}">
                        <div class="form-group">
                            <label for="municipio" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Municipio</label>
                            <ui-select id="municipio"  name="municipio" ng-model="vacante.municipio_id"  ng-required="true">
                                <ui-select-match placeholder="Seleccione municipio">@{{$select.selected.nombre}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in municipios | filter:$select.search">
                                    @{{item.nombre}}
                                </ui-select-choices>
                            </ui-select>
                            <span ng-show="datosForm.$submitted || datosForm.municipio.$touched">
                                <span class="label label-danger" ng-show="datosForm.municipio.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4" ng-class="{'error' : (datosForm.$submitted || datosForm.nivelEducacion.$touched) && datosForm.nivelEducacion.$error.required}">
                        <div class="form-group">
                            <label for="nivelEducacion" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Nivel de educación</label>
                            <select class="form-control" id="nivelEducacion" name="nivelEducacion" ng-model="vacante.nivelEducacion" ng-options="item.id as item.nombre for item in nivelesEducacion" required>
                                <option value="" selected disable>Seleccion nivel de educación</option>
                            </select>
                            <span ng-show="datosForm.$submitted || datosForm.nivelEducacion.$touched">
                                <span class="label label-danger" ng-show="datosForm.nivelEducacion.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="salario" class="control-label">Salario</label>
                            <input type="number" class="form-control" min="0" ng-model="vacante.salario" name="salario" placeholder="Ingrese salario. Min 0"/>
                            <span ng-show="datosForm.$submitted || datosForm.salario.$touched">
                                <span class="label label-danger" ng-show="datosForm.salario.$error.min">*El campo acepta valores mayores o iguales que 0.</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.requisitos.$touched) && datosForm.requisitos.$error.required}">
                            <label for="requisitos"><span class="glyphicon glyphicon-asterisk"></span> Requisitos</label>
                            <textarea class="form-control" name="requisitos" id="requisitos" ng-model="vacante.requisitos" rows="5" required></textarea>
                            <span ng-show="datosForm.$submitted || datosForm.requisitos.$touched">
                                <span class="label label-danger" ng-show="datosForm.requisitos.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <br><br>
                <div class="row" style="text-align:center">
                    <a  class="btn btn-raised btn-default">Volver</a>
                    <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Guardar" />
                </div>
            </form>
        </div>
        
        <div class='carga'>
    
        </div> 
    </div>
    
    
    
@endsection

@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/main.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/bolsaEmpleoService.js')}}"></script>
@endsection