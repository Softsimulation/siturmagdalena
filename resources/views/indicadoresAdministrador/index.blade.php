@extends('layout._AdminLayout')

@section('Title','Administrador de Indicadores :: SITUR Cesar')
@section('app','ng-app="admin.indicadores"')

@section('controller','ng-controller="indicadoresCtrl"')

@section('titulo','Indicadores')
@section('subtitulo','Cálculo de indicadores')

@section('content')

   <div class="blank-page widget-shadow scroll" id="style-2 div1">
       <div class="flex-list">
           <button  type="button" ng-click="abrirModal()" class="btn btn-lg btn-success">Añadir indicador</button>
            <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>   
        </div>
        <div class="text-center" ng-if="(indicadoresMedicion | filter:search).length > 0 && (indicadoresMedicion != undefined)">
            <p>Hay @{{(indicadoresMedicion | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
        </div>
        <div class="alert alert-info" ng-if="indicadoresMedicion.length == 0">
            <p>No hay registros almacenados</p>
        </div>
        <div class="alert alert-warning" ng-if="(indicadoresMedicion | filter:search).length == 0 && indicadoresMedicion.length > 0">
            <p>No existen registros que coincidan con su búsqueda</p>
        </div>
        <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.indicador.length > 0 || search.mes.length > 0 || search.anio.length > 0 || search.estado.length > 0 || search.fecha_carga.length > 0 || search.fecha_finalizacion.length > 0)">
            Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
        </div>   
       <br/>
        <div class="row">
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover" ng-show="indicadoresMedicion.length > 0">
                    <thead>
                        <tr>
                            <th>Medición</th>
                            <th>Nombre del Indicador</th>
                            <th>Temporada</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th>Fecha Carga</th>
                            <th>Fecha Finalización</th>
                            <th style="width: 130px;"></th>
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                            <td><input type="text" ng-model="search.indicador" name="indicador" id="indicador" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.mes" name="mes" id="mes" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.anio" name="anio" id="anio" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fecha_carga" name="fecha_carga" id="fecha_carga" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fecha_finalizacion" name="fecha_finalizacion" id="fecha_finalizacion" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in indicadoresMedicion |filter:search | itemsPerPage: 10">
                            <td>@{{item.indicador}}</td>
                            <td>@{{item.temporada}}</td>
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
                            
                            <div class="col-md-6 col-xs-6 col-sm-6" ng-show="indicador.tipo != 2 && indicador.tipo != 3 ">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.mes.$touched) && indicadorForm.mes.$error.required}">
                                    <label class="control-label" for="mes"><span class="asterisk">*</span> Meses</label>
                                    <select name="mes" class="form-control" ng-model="indicador.mes" id="inputMes" ng-options ="it.id as it.nombre for it in meses" ng-required="indicador.tipo != 2 && indicador.tipo != 3">
                                        <option value="" disabled>--Seleccione--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6 col-sm-6" ng-show="indicador.tipo != 2 && indicador.tipo != 3 ">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.anio.$touched) && indicadorForm.anio.$error.required}">
                                    <label class="control-label" for="anio"><span class="asterisk">*</span> Años</label>
                                    <select name="anios" class="form-control" ng-model="indicador.anio" id="inputAnios" ng-options ="it.id as it.anio for it in anios" ng-required="indicador.tipo != 2 && indicador.tipo != 3">
                                        <option value="" disabled>--Seleccione--</option>
                                    </select>
                                </div>
                            </div>
    
                            
                            
                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="indicador.tipo == 2 || indicador.tipo == 3">
                                <div class="form-group" ng-class="{'has-error': (indicadorForm.$submitted || indicadorForm.temporada.$touched) && indicadorForm.temporada.$error.required}">
                                        <label class="control-label" for="temporada"><span class="asterisk">*</span> Temporada</label>
                                        <select name="temporada" class="form-control" ng-model="indicador.temporada" id="inputTemporada" ng-options ="it.id as it.nombre for it in temporadas" ng-required="indicador.tipo == 2 || indicador.tipo == 3">
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