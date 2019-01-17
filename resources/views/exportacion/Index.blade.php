@extends('layout._AdminLayout')

@section('Title','Administrador de Exportaciones :: SITUR Atlántico')
@section('app','ng-app="admin.exportaciones"')

@section('controller','ng-controller="ExportacionCtrl"')

@section('titulo','Exportación')
@section('subtitulo','Herramienta de exportación')

@section('content')
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        
        <div class="row">
            <div class="col-xs-12 text-center">
                <input type="button" ng-click="exportar()" class="btn btn-lg btn-success" value="Generar exportación" />
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover" ng-show="exportaciones.length > 0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de realización</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Periodo</th>
                            <th>Estado</th>
                            <th>Usuario</th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in exportaciones | itemsPerPage: 10">
                            <td>@{{item.nombre}}</td>
                            <td>@{{item.fecha_realizacion}}</td>
                            <td>@{{item.fecha_inicio |date: "dd/MM/yyyy"}}</td>
                            <td>@{{item.fecha_fin |date: "dd/MM/yyyy"}}</td>
                            <td>@{{item.periodo}}</td>
                            <td>@{{item.estado}}</td>
                            <td>@{{item.usuario_realizado}}</td>
                            <td>@{{item.ruta}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning" role="alert" ng-if="exportaciones.length == 0">
                    No hay exportaciones
                </div>
            </div>

            <div class="col-xs-12" style="text-align: center;">
                <dir-pagination-controls></dir-pagination-controls>
            </div>
        </div>
        -->
    </div>

    <!-- Modal crear exportacion-->
    <div class="modal fade" id="exportacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Generar exportación</h4>
                </div>
                <form role="form" name="addForm" novalidate>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                            </div>
                
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.nombre.$touched) && addForm.nombre.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span> Exportacion a realizar</label>
                                    <select name="nombre" class="form-control" ng-model="exportacion.nombre" id="inputNombre" required>
                                        <option value="" disabled>--Seleccione--</option>
                                        <option value="receptor">Turismo Receptor</option>
                                        <option value="interno">Turismo Interno</option>
                                        <option value="sostenibilidad">Sostenibilidad PST</option>
                                        <option value="hogares">Sostenibilidad Hogares</option>
                                        <option value="ofertayempleo">Oferta y Empleo</option>
                                    </select>
                                </div>
                            </div>
                            
                           <div class="col-md-6 col-xs-12 col-sm-12" ng-show="exportacion.nombre == 'receptor' || exportacion.nombre == 'interno' || exportacion.nombre == 'sostenibilidad' || exportacion.nombre == 'hogares'">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.fechainicio.$touched) && addForm.fechainicio.$error.required}">
                                    <label class="control-label" for="fechaInicio"><span class="asterisk">*</span> Fecha inicial</label>
                                    <adm-dtp name="fechainicio" id="fechaInicio" ng-model="exportacion.fecha_inicial" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" ng-required="exportacion.nombre == 'receptor' || exportacion.nombre == 'interno' || exportacion.nombre == 'sostenibilidad'"></adm-dtp>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12"  ng-show="exportacion.nombre == 'receptor' || exportacion.nombre == 'interno' || exportacion.nombre == 'sostenibilidad' || exportacion.nombre == 'hogares'">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.fechafin.$touched) && addForm.fechafin.$error.required}">
                                    <label class="control-label" for="fechaFin"><span class="asterisk">*</span> Fecha final</label>
                                    <adm-dtp name="fechafin" id="fechaFin" ng-model="exportacion.fecha_final" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" ng-required="exportacion.nombre == 'receptor' || exportacion.nombre == 'interno' || exportacion.nombre == 'sostenibilidad'"></adm-dtp>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-xs-12 col-sm-12"  ng-show="exportacion.nombre == 'ofertayempleo'">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.categoria.$touched) && addForm.categoria.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Categoria</label>
                                    <select name="categoria" class="form-control" ng-model="exportacion.categoria" id="inputNombre" ng-required="exportacion.nombre == 'ofertayempleo' ">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option value="1">Agencia de viajes</option>
                                        <option value="2">Agencias Operadoras</option>
                                        <option value="3">Alojamiento</option>
                                        <option value="4">Restaurantes</option>
                                        <option value="5">Transporte</option>
                                        <option value="6">Empleo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-xs-12 col-sm-12"  ng-show="exportacion.nombre == 'ofertayempleo'">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.mes.$touched) && addForm.mes.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Mes</label>
                                    <select name="mes" class="form-control" ng-model="exportacion.mes" id="inputNombre" ng-required="exportacion.nombre == 'ofertayempleo' ">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="mes in meses" value="@{{mes.id}}">@{{mes.mes.nombre}} - @{{mes.anio.anio}}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardar()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/exportacion/exportaciones.js')}}"></script>
<script src="{{asset('/js/administrador/exportacion/services.js')}}"></script>
@endsection 