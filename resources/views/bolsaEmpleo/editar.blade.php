@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo - Vacantes')

@section('TitleSection', 'Edición de vacante')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="editarVacanteController"')

@section('estilos')
    <style>
        body{
            overflow: visible;
        }
    </style>
@endsection

@section('content')
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
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
                            <ui-select id="proveedor"  name="proveedor" ng-model="vacante.proveedores_rnt_id"  ng-required="true">
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
                            <input type="text" class="form-control" id="nombre_vacante" name="nombre_vacante" ng-model="vacante.nombre" ng-maxlength="250" placeholder="Presione aquí para ingresar el nombre de la vacante" required />
                            <span ng-show="datosForm.$submitted || datosForm.nombre_vacante.$touched">
                                <span class="label label-danger" ng-show="datosForm.nombre_vacante.$error.required">*El campo nombre de vacante es requerido</span>
                                <span class="label label-danger" ng-show="datosForm.nombre_vacante.$error.maxlength">*El campo no debe superar los 250 caracteres.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.numero_vacantes.$touched) && datosForm.numero_vacantes.$error.required}">
                            <label for="numero_vacantes" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Número de vacantes</label>
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
                        <div class="form-group" ng-class="{'error' : (datosForm.$submitted || datosForm.descripcion.$touched) && datosForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="glyphicon glyphicon-asterisk"></span> Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" ng-model="vacante.descripcion" rows="5" placeholder="Ingrese la descripción de la vacante." required></textarea>
                            <span ng-show="datosForm.$submitted || datosForm.descripcion.$touched">
                                <span class="label label-danger" ng-show="datosForm.descripcion.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="numero_maximo_postulaciones" class="control-label">No. máximo de postulaciones</label>
                            <input  type="number" class="form-control" min="1" ng-model="vacante.numero_maximo_postulaciones" name="numero_maximo_postulaciones" placeholder="Min 1. (Opcional)" />
                            <span ng-show="datosForm.$submitted || datosForm.numero_maximo_postulaciones.$touched">
                                <span class="label label-danger" ng-show="datosForm.numero_maximo_postulaciones.$error.min">*El campo acepta valores mayores o iguales que 1.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="fecha_vencimiento" class="control-label">Fecha de vencimiento</label>
                            <adm-dtp name="fecha_vencimiento"  id="fecha_vencimiento" ng-model='vacante.fecha_vencimiento' mindate="@{{fechaActual}}"options="optionFecha" placeholder="Ingrese fecha de vencimiento"></adm-dtp>
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
                            <ui-select id="municipio" name="municipio" ng-model="vacante.municipio_id"  ng-required="true">
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
                            <select class="form-control" id="nivelEducacion" name="nivelEducacion" ng-model="vacante.nivel_educacion_id" ng-options="item.id as item.nombre for item in nivelesEducacion" required>
                                <option value="" selected disable>Seleccion nivel de educación</option>
                            </select>
                            <span ng-show="datosForm.$submitted || datosForm.nivelEducacion.$touched">
                                <span class="label label-danger" ng-show="datosForm.nivelEducacion.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4" ng-class="{'error' : (datosForm.$submitted || datosForm.tipo_cargo_vacante_id.$touched) && datosForm.tipo_cargo_vacante_id.$error.required}">
                        <div class="form-group">
                            <label for="tipo_cargo_vacante_id" class="control-label"><span class="glyphicon glyphicon-asterisk"></span> Tipo de cargo</label>
                            <ui-select id="tipo_cargo_vacante_id"  name="tipo_cargo_vacante_id" ng-model="vacante.tipo_cargo_vacante_id"  ng-required="true">
                                <ui-select-match placeholder="Seleccione tipo de cargo">@{{$select.selected.nombre}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in tiposCargos | filter:$select.search">
                                    @{{item.nombre}}
                                </ui-select-choices>
                            </ui-select>
                            <span ng-show="datosForm.$submitted || datosForm.tipo_cargo_vacante_id.$touched">
                                <span class="label label-danger" ng-show="datosForm.tipo_cargo_vacante_id.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="salario_minimo" class="control-label">Salario mínimo</label>
                            <input type="number" class="form-control" min="0" max="@{{vacante.salario_maximo != undefined ? vacante.salario_maximo : 9999999999999999}}" ng-model="vacante.salario_minimo" name="salario_minimo" placeholder="Ingrese salario mínimo. Min 0"/>
                            <span ng-show="datosForm.$submitted || datosForm.salario_minimo.$touched">
                                <span class="label label-danger" ng-show="datosForm.salario_minimo.$error.min">*El campo acepta valores mayores o iguales que 0.</span>
                                <span class="label label-danger" ng-show="datosForm.salario_minimo.$error.max">*El campo acepta valores mayores o iguales que el salario máximo ó 0.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="salario_maximo" class="control-label">Salario máximo</label>
                            <input type="number" class="form-control" min="@{{vacante.salario_minimo != undefined ? vacante.salario_minimo : 0}}" ng-model="vacante.salario_maximo" name="salario_maximo" placeholder="Ingrese salario máximo. Min 0"/>
                            <span ng-show="datosForm.$submitted || datosForm.salario_maximo.$touched">
                                <span class="label label-danger" ng-show="datosForm.salario_maximo.$error.min">*El campo acepta valores mayores o iguales que el salario mínimo ó 0.</span>
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
                    <div class="col-xs-12">
                        <a href="/bolsaEmpleo/vacantes" class="btn btn-raised btn-default">Volver</a>
                        <input type="submit" class="btn btn-raised btn-info" ng-click="guardar()" value="Guardar" />
                    </div>
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
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/main.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/bolsaEmpleoService.js')}}"></script>
@endsection