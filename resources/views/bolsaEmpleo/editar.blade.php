@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo :: Formulario de edición de vacante')

@section('TitleSection', 'Formulario de edición de vacante')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="editarVacanteController"')

@section('titulo','Bolsa de empleo')
@section('subtitulo','Formulario de edición de vacante')


@section('content')
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    
       <div>
            <form name="datosForm" role="form" novalidate>
                <fieldset>
                    <legend>Formulario de edición de vacante</legend>
                    <div class="alert alert-danger" ng-if="errores != null">
                        <h6>Errores</h6>
                        <span class="messages" ng-repeat="error in errores">
                              <span>@{{error}}</span>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.proveedor.$touched) && datosForm.proveedor.$error.required}">
                                <label for="proveedor" class="control-label"><span class="asterisk">*</span> Empresa</label>
                                <ui-select id="proveedor"  name="proveedor" ng-model="vacante.proveedores_rnt_id"  ng-required="true">
                                    <ui-select-match placeholder="Seleccione empresa">@{{$select.selected.razon_social}}</ui-select-match>
                                    <ui-select-choices repeat="item.id as item in proveedores | filter:$select.search">
                                        @{{item.razon_social}}
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.nombre_vacante.$touched) && datosForm.nombre_vacante.$error.required}">
                                <label for="nombre_vacante" class="control-label"><span class="asterisk">*</span> Nombre de la vacante</label>
                                <input type="text" class="form-control" id="nombre_vacante" name="nombre_vacante" ng-model="vacante.nombre" maxlength="250" placeholder="Ingrese el nombre de la vacanta. Máx. 255 caracteres" required />
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.nombre_vacante.$touched) && datosForm.nombre_vacante.$error.maxlength">El campo no debe superar los 250 caracteres.</span>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.numero_vacantes.$touched) && (datosForm.numero_vacantes.$error.required || datosForm.numero_vacantes.$error.min)}">
                                <label for="numero_vacantes" class="control-label"><span class="asterisk">*</span> Número de vacantes</label>
                                <input type="number" class="form-control" min="1" ng-model="vacante.numero_vacantes" name="numero_vacantes" id="numero_vacantes" placeholder="Ingrese número de vacantes. Mín. 1" required/>
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.numero_vacantes.$touched) && datosForm.numero_vacantes.$error.min">*El campo acepta valores mayores o iguales que 1.</span>
                               
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.descripcion.$touched) && datosForm.descripcion.$error.required}">
                                <label for="descripcion" class="control-label"><span class="asterisk">*</span> Descripción</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" ng-model="vacante.descripcion" rows="5" placeholder="Ingrese la descripción de la vacante. Máx. 1500 caracteres" maxlength="1500" required></textarea>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.numero_maximo_postulaciones.$touched) && datosForm.numero_maximo_postulaciones.$error.min}">
                                <label for="numero_maximo_postulaciones" class="control-label">No. máximo de postulaciones</label>
                                <input type="number" class="form-control" min="1" ng-model="vacante.numero_maximo_postulaciones" name="numero_maximo_postulaciones" id="numero_maximo_postulaciones" placeholder="Mín 1. (Opcional)" />
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.numero_maximo_postulaciones.$touched) && datosForm.numero_maximo_postulaciones.$error.min">El campo acepta valores mayores o iguales que 1.</span>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" >
                                <label for="fecha_vencimiento" class="control-label">Fecha de vencimiento</label>
                                <adm-dtp name="fecha_vencimiento" id="fecha_vencimiento" ng-model='vacante.fecha_vencimiento' mindate="@{{fechaActual}}"options="optionFecha" placeholder="Ingrese fecha de vencimiento"></adm-dtp>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.anios_experiencia.$touched) && (datosForm.anios_experiencia.$error.required || datosForm.anios_experiencia.$error.min)}">
                                <label for="anios_experiencia" class="control-label"><span class="asterisk">*</span> Años de experiencia</label>
                                <input type="number" class="form-control" min="0" ng-model="vacante.anios_experiencia" name="anios_experiencia" id="anios_experiencia" placeholder="Ingrese años. Mín. 0" required/>
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.anios_experiencia.$touched) && datosForm.anios_experiencia.$error.min">El campo acepta valores mayores o iguales que 0.</span>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.municipio.$touched) && datosForm.municipio.$error.required}">
                                <label for="municipio" class="control-label"><span class="asterisk">*</span> Municipio</label>
                                <ui-select id="municipio"  name="municipio" id="municipio" ng-model="vacante.municipio_id"  ng-required="true">
                                    <ui-select-match placeholder="Seleccione municipio">@{{$select.selected.nombre}}</ui-select-match>
                                    <ui-select-choices repeat="item.id as item in municipios | filter:$select.search">
                                        @{{item.nombre}}
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.nivelEducacion.$touched) && datosForm.nivelEducacion.$error.required}">
                                <label for="nivelEducacion" class="control-label"><span class="asterisk">*</span> Nivel de educación</label>
                                <select class="form-control" id="nivelEducacion" name="nivelEducacion" id="nivelEducacion" ng-model="vacante.nivel_educacion_id" ng-options="item.id as item.nombre for item in nivelesEducacion" required>
                                    <option value="" selected disable>Seleccion nivel de educación</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.tipo_cargo_vacante_id.$touched) && datosForm.tipo_cargo_vacante_id.$error.required}">
                                <label for="tipo_cargo_vacante_id" class="control-label"><span class="asterisk">*</span> Tipo de cargo</label>
                                <ui-select id="tipo_cargo_vacante_id"  name="tipo_cargo_vacante_id" id="tipo_cargo_vacante_id" ng-model="vacante.tipo_cargo_vacante_id"  ng-required="true">
                                    <ui-select-match placeholder="Seleccione tipo de cargo">@{{$select.selected.nombre}}</ui-select-match>
                                    <ui-select-choices repeat="item.id as item in tiposCargos | filter:$select.search">
                                        @{{item.nombre}}
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4" >
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.salario_minimo.$touched) && (datosForm.salario_minimo.$error.min || datosForm.salario_minimo.$error.max)}">
                                <label for="salario_minimo" class="control-label">Salario mínimo</label>
                                <input type="number" class="form-control" min="0" max="@{{vacante.salario_maximo != undefined ? vacante.salario_maximo : 9999999999999999}}" ng-model="vacante.salario_minimo" name="salario_minimo" id="salario_minimo" placeholder="Ingrese salario mínimo. Mín. 0"/>
                                
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.salario_minimo.$touched) && datosForm.salario_minimo.$error.min">*El campo acepta valores mayores o iguales que 0.</span>
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.salario_minimo.$touched) && datosForm.salario_minimo.$error.max">*El campo acepta valores mayores o iguales que el salario máximo ó 0.</span>
                              
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4" >
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.salario_maximo.$touched) && datosForm.salario_maximo.$error.min}">
                                <label for="salario_maximo" class="control-label">Salario máximo</label>
                                <input type="number" class="form-control" min="@{{vacante.salario_minimo != undefined ? vacante.salario_minimo : 0}}" ng-model="vacante.salario_maximo" name="salario_maximo" id="salario_maximo" placeholder="Ingrese salario máximo. Mín. 0"/>
                                <span class="text-error" ng-show="(datosForm.$submitted || datosForm.salario_maximo.$touched) && datosForm.salario_maximo.$error.min">*El campo acepta valores mayores o iguales que el salario mínimo ó 0.</span>
                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error' : (datosForm.$submitted || datosForm.requisitos.$touched) && datosForm.requisitos.$error.required}">
                                <label for="requisitos"><span class="asterisk">*</span> Requisitos</label>
                                <textarea class="form-control" name="requisitos" id="requisitos" ng-model="vacante.requisitos" rows="5" placeholder="Ingrese los requisitos de la vacante. Máx. 1500 caracteres." maxlength="1500" required></textarea>
                                
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <hr/>
                        <a role="button" href="/bolsaEmpleo/vacantes" class="btn btn-lg btn-default">Volver</a>
                        <input type="submit" class="btn btn-lg btn-success" ng-click="guardar()" value="Guardar" />
                       
                    </div>
                </fieldset>
                
            </form>
        </div>
        
        <div class='carga'>
    
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