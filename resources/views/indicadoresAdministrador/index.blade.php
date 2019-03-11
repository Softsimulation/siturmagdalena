@extends('layout._AdminLayout')

@section('Title','Administrador de Indicadores :: SITUR Cesar')
@section('app','ng-app="admin.indicadores"')

@section('controller','ng-controller="indicadoresCtrl"')

@section('titulo','Indicadores')
@section('subtitulo','Cálculo de indicadores')

@section('content')

   <div class="blank-page widget-shadow scroll" id="style-2 div1">
       <div class ="row">
           <div class ="col-xs-12">
               <button  type="button" ng-click="abrirModal()" class="btn btn-lg btn-success">Añadir indicador</button>
           </div>
       </div>
       <br/>
        <div class="row">
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover" ng-show="indicadoresMedicion.length > 0">
                    <thead>
                        <tr>
                            <th>Nombre del Indicador</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th>Fecha Carga</th>
                            <th>Fecha Finalización</th>
                            <th style="width: 130px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in indicadoresMedicion | itemsPerPage: 10">
                            <td>@{{item.indicador}}</td>
                            <td>@{{item.mes}}</td>
                            <td>@{{item.anio}}</td>
                            <td>@{{item.estado}}</td>
                            <td>@{{item.fecha_carga |date: "dd/MM/yyyy HH:mm:ss"}}</td>
                            <td>@{{item.fecha_finalizacion |date: "dd/MM/yyyy HH:mm:ss"}}</td>
                            <td style="width: 130px;">
                                <button class="btn btn-default btn-xs" ng-click="recalcular(item.id)" title="recalcular">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                </button>                            
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning" role="alert" ng-if="indicadoresMedicion.length == 0">
                    No hay indicadores
                </div>
            </div>

            <div class="col-xs-12" style="text-align: center;">
                <dir-pagination-controls></dir-pagination-controls>
            </div>
        </div>
       
    </div>

    <!-- Modal calcular indicador-->
    <div class="modal fade" id="calcularIndicadores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Calcular indicador</h4>
                </div>
                <form role="form" name="indicadorForm" novalidate>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                            </div>
                
                        <div class="row">
                            <div class="col-md-6 col-xs-6 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.nombre.$touched) && indicadorForm.nombre.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span> Tipo Medición</label>
                                    <select name="nombre" class="form-control" ng-model="indicador.tipo" id="inputNombre" ng-options ="it.id as it.nombre for it in tiposMedicion" required>
                                        <option value="" disabled>--Seleccione--</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-xs-6 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.indicador.$touched) && indicadorForm.indicador.$error.required}">
                                    <label class="control-label" for="inputIndicador"><span class="asterisk">*</span> Tipo Medición</label>
                                    <select name="indicador" class="form-control" ng-model="indicador.indicador_id" id="inputNombre" ng-options ="it.id as it.idiomas[0].nombre for it in indicadores | filter:{tipo_medicion_indicador_id:indicador.tipo} " required>
                                        <option value="" disabled>--Seleccione--</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-xs-6 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.mes.$touched) && indicadorForm.mes.$error.required}">
                                    <label class="control-label" for="mes"><span class="asterisk">*</span> Meses</label>
                                    <select name="mes" class="form-control" ng-model="indicador.mes" id="inputMes" ng-options ="it.id as it.nombre for it in meses" required>
                                        <option value="" disabled>--Seleccione--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.anio.$touched) && indicadorForm.anio.$error.required}">
                                    <label class="control-label" for="anio"><span class="asterisk">*</span> Años</label>
                                    <select name="anios" class="form-control" ng-model="indicador.anio" id="inputAnios" ng-options ="it.id as it.anio for it in anios" required>
                                        <option value="" disabled>--Seleccione--</option>
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

<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/indicadores/services.js')}}"></script>
<script src="{{asset('/js/administrador/indicadores/indicador.js')}}"></script>
@endsection