@extends('layout._sostenibilidadPstLayout')

@section('title', 'SOSTENIBILIDAD DE LAS ACTIVIDADES TURÍSTICAS- PRESTADORES SERVICIOS TURÍSTICOS (PST)')

@section('estilos')
    <style>
        .title-section {
            background-color: #16469e !important;
        }
    </style>
    <style>
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
    </style>
@endsection

@section('TitleSection', 'Configuración de encuesta')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('controller','ng-controller="configuracionController"')

@section('content')
    
<div class="container">
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form role="form" name="datosForm" novalidate>
        
        
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Datos de encuesta</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <!--P3P1. Fecha de aplicación-->
                            <label for="fechaLlegada" class="col-xs-12 control-label">Fecha de aplicación</label>
                            <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model='encuesta.fechaAplicacion' maxdate="@{{fechaActual}}" ng-required="true" options="optionFecha" placeholder="Ingrese fecha de aplicación"></adm-dtp>
                            <span ng-show="datosForm.$submitted || datosForm.fechaAplicacion.$touched">
                                <!--P3P1Alert1. El campo fecha de llegada es requerido-->
                                <span class="label label-danger" ng-show="datosForm.fechaAplicacion.$error.required">*El campo fecha de aplicación es requerido</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="lugar_encuesta" class="col-xs-12 control-label">Lugar de la encuesta</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" name="lugar_encuesta" id="lugar_encuesta" ng-model="encuesta.lugar_encuesta" required />
                                <span ng-show="datosForm.$submitted || datosForm.lugar_encuesta.$touched">
                                    <span class="label label-danger" ng-show="datosForm.lugar_encuesta.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Establecimmiento</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccione establecimiento</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <ui-select id="establecimiento"  name="establecimiento" ng-model="encuesta.establecimiento"  ng-required="true">
                                <ui-select-match placeholder="Seleccione establecimiento">@{{$select.selected.razon_social}}</ui-select-match>
                                <ui-select-choices repeat="item as item in proveedores | filter:$select.search">
                                    @{{item.razon_social}}
                                </ui-select-choices>
                            </ui-select>
                            <span ng-show="datosForm.$submitted || datosForm.establecimiento.$touched">
                                <span class="label label-danger" ng-show="datosForm.establecimiento.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Encuestador</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccione encuestador</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <ui-select id="digitador_id"  name="digitador_id" ng-model="encuesta.digitador_id"  ng-required="true">
                                <ui-select-match placeholder="Seleccione encuestador">@{{$select.selected.user.nombre}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in encuestadores | filter:$select.search">
                                    @{{item.user.nombre}}
                                </ui-select-choices>
                            </ui-select>
                            <span ng-show="datosForm.$submitted || datosForm.digitador_id.$touched">
                                <span class="label label-danger" ng-show="datosForm.digitador_id.$error.required">*El campo es requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Información del establecimiento</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="nombre_contacto" class="col-xs-12 control-label">Nombre del contacto</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" ng-model="encuesta.nombre_contacto" placeholder="Presione aquí para ingresar el nombre del contacto" required />
                                <span ng-show="datosForm.$submitted || datosForm.nombre_contacto.$touched">
                                    <span class="label label-danger" ng-show="datosForm.nombre_contacto.$error.required">*El campo nombre del contacto es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="cargo" class="col-xs-12 control-label">Cargo</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="cargo" name="cargo" ng-model="encuesta.cargo" placeholder="Presione aquí para ingresar el cargo" required />
                                <span ng-show="datosForm.$submitted || datosForm.cargo.$touched">
                                    <span class="label label-danger" ng-show="datosForm.cargo.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="email" class="col-xs-12 control-label">Email</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="email" name="email" value="@{{encuesta.establecimiento.email}}" placeholder="No ingresado" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="celular" class="col-xs-12 control-label">Celular</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="celular" name="celular" value="@{{encuesta.establecimiento.celular}}" placeholder="No ingresado" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="telefono" class="col-xs-12 control-label">Teléfono</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="telefono" name="telefono" value="@{{encuesta.establecimiento.telefono}}" placeholder="No ingresado" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
        <div class="row" style="text-align:center">
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection


