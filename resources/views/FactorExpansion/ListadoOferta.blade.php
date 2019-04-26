
@extends('layout._AdminLayout')

@section('title', 'Factor de expansión de oferta y empleo')

@section('titulo','Factor de expansión de oferta y empleo')
@section('subtitulo','El siguiente listado cuenta con @{{factores.length}} registro(s)')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
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
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
@endsection

@section('app','ng-app="admin.factoresExpansion"')

@section('controller','ng-controller="listadoFactoresOfertaCtrl"')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-factorExpansion'))
        <a href="" role="button" class="btn btn-lg btn-success" ng-click="crearFactorModal()" >Crear Factor de expansión
        </a>
    @endif
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
         
</div>
<div class="text-center" ng-if="(factores | filter:search).length > 0 && (factores != undefined)">
    <p>Hay @{{(factores | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="factores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(factores | filter:search).length == 0 && factores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.cantidad.length > 0 || search.d_tamanio_empresa.nombre.length > 0 || search.d_municipio_interno.nombre.length > 0 || search.mes.length > 0 || search.tipoProveedor.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>   
<p class="text-muted text-center">Seleccione indicadores para ver más opciones</p>
        <div class="row">
            <div class="col-xs-12" style="overflow: auto;">
                <div>
                    <table class="table table-hover table-responsive Table">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Municipio</th>
                                <th>Tipo de proveedor</th>
                                <th>Tamaño de la empresa</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                            <tr ng-show="mostrarFiltro == true">
                                    
                                <td><input type="text" ng-model="search.mes" name="mesFiltro" id="mesFiltro" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.d_municipio_interno.nombre" name="municipioFiltro" id="municipioFiltro" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.tipoProveedor" name="tipoProveedorFiltro" id="tipoProveedorFiltro" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.d_tamanio_empresa.nombre" name="tamanioEmpresaFiltro" id="tamanioEmpresaFiltro" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.cantidad" name="cantidadFiltro" id="cantidadFiltro" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody ng-init="currentPageFactores = 1">
                            <tr dir-paginate="factor in factores|filter:search|itemsPerPage: 10" current-page="currentPageFactores" ng-click="verDetalleUsuario($event, usuario)">
                                <td>@{{factor.mes}}</td>
                                <td>@{{factor.d_municipio_interno.nombre}}</td>
                                <td>@{{factor.tipoProveedor}}</td>
                                <td>@{{factor.d_tamanio_empresa.nombre}}</td>
                                <td>@{{factor.cantidad}}</td>
                                <td>
                                    @if(Auth::user()->contienePermiso('edit-factorExpansion'))
                                        <a href="" ng-click="editarFactorModal(factor)" class="btn btn-xs btn-default" title="Editar factor"><span class="glyphicon glyphicon-pencil"></span></a>
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="col-xs-12 text-center">
                        <dir-pagination-controls></dir-pagination-controls>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalCrearFactor" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="crearFactorForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear indicador</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                            <h6>Errores</h6>
                            <span class="messages" ng-repeat="error in errores">
                                  <span>*@{{error[0]}}</span><br/>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="mesFactorCrear"><span class="asterisk">*</span>Mes</label>
                                <select class="form-control" name="mesFactorCrear" id="mesFactorCrear" ng-options='mese.id as (mese.mes.nombre + " " + mese.anio.anio) for mese in meses' ng-model="crearFactor.mes_id" required>
                                    <option value="">Seleccione un tipo</option>
                                </select>
                                
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.mesFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.mesFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="municipioFactorCrear"><span class="asterisk">*</span>Municipio</label>
                                <ui-select ng-model="crearFactor.municipio_id" id="municipioFactorCrear" name="municipioFactorCrear" required>
                                    <ui-select-match placeholder="Seleccionar un municipio">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="municipio.id as municipio in (municipios| filter: $select.search)">
                                        <span ng-bind="municipio.nombre" title="@{{municipio.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.municipioFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.municipioFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="tipoProveedorFactorCrear"><span class="asterisk">*</span>Tipo Proveedor</label>
                                <ui-select ng-model="crearFactor.tipoProveedor_id" id="tipoProveedorFactorCrear" name="tipoProveedorFactorCrear" required>
                                    <ui-select-match placeholder="Seleccionar un tipo de proveedor">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="tipoProveedor.tipo_proveedores_id as tipoProveedor in (tiposProveedores| filter: $select.search)">
                                        <span ng-bind="tipoProveedor.nombre" title="@{{tipoProveedor.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.tipoProveedorFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.tipoProveedorFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="tamanioEmpresaFactorCrear"><span class="asterisk">*</span>Tamaño de la empresa</label>
                                <ui-select ng-model="crearFactor.tamanioEmpresa_id" id="tamanioEmpresaFactorCrear" name="tamanioEmpresaFactorCrear" required>
                                    <ui-select-match placeholder="Seleccionar tamaño de la empresa">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="tamanio.id as tamanio in (tamaniosEmpresa| filter: $select.search)">
                                        <span ng-bind="tamanio.nombre" title="@{{tamanio.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.tamanioEmpresaFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.tamanioEmpresaFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="generalFactorCrear"><span class="asterisk">*</span>¿Qué tipo de factor aplicar?</label>
                                <br>
                                <input type="radio" name="generalFactorCrear" id="generalFactorCrear" ng-model="crearFactor.es_general" value="0" required>General
                                <input type="radio" name="generalFactorCrear" id="generalFactorCrear" ng-model="crearFactor.es_general" value="1" required>Específico
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.generalFactorCrear.$touched">
                                    <br>
                                    <span ng-show="crearFactorForm.generalFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row" ng-if="crearFactor.es_general == 1">
                            <div class="col-xs-12">
                                <label for="proveedorRntFactorCrear"><span class="asterisk">*</span>Proveedor RNT</label>
                                <ui-select ng-model="crearFactor.proveedor_rnt_id" id="proveedorRntFactorCrear" name="proveedorRntFactorCrear" ng-required="crearFactor.es_general == 1">
                                    <ui-select-match placeholder="Seleccionar un proveedor rnt">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="proveedor.id as proveedor in (proveedoresRnt| filter: $select.search)">
                                        <span ng-bind="proveedor.nombre" title="@{{proveedor.nombre}}"></span>
                                        <br />
                                        <small>
                                            RNT: @{{proveedor.rnt}}
                                        </small>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.proveedorRntFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.proveedorRntFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="ofertaFactorCrear"><span class="asterisk">*</span>¿A que sección pertenece este factor?</label>
                                <br>
                                <input type="radio" name="ofertaFactorCrear" id="ofertaFactorCrear" ng-model="crearFactor.es_oferta" value="1" required>Oferta
                                <input type="radio" name="ofertaFactorCrear" id="ofertaFactorCrear" ng-model="crearFactor.es_oferta" value="0" required>Empleo
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.ofertaFactorCrear.$touched">
                                    <br>
                                    <span ng-show="crearFactorForm.ofertaFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="cantidadFactorCrear"><span class="asterisk">*</span>Valor factor</label>
                                <input type="number" placeholder="Valor del factor de expansión" class="form-control" name="cantidadFactorCrear" id="cantidadFactorCrear" ng-model="crearFactor.cantidad" required/>
                                <span class="messages" ng-show="crearFactorForm.$submitted || crearFactorForm.cantidadFactorCrear.$touched">
                                    <span ng-show="crearFactorForm.cantidadFactorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="crearFactorMetodo()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="modalEditarFactor" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="editarFactorForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear indicador</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                            <h6>Errores</h6>
                            <span class="messages" ng-repeat="error in errores">
                                  <span>*@{{error[0]}}</span><br/>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="mesFactorEditar"><span class="asterisk">*</span>Mes</label>
                                <select class="form-control" name="mesFactorEditar" id="mesFactorEditar" ng-options='mese.id as (mese.mes.nombre + " " + mese.anio.anio) for mese in meses' ng-model="editarFactor.mes_id" required>
                                    <option value="">Seleccione un tipo</option>
                                </select>
                                
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.mesFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.mesFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="municipioFactorEditar"><span class="asterisk">*</span>Municipio</label>
                                <ui-select ng-model="editarFactor.municipio_id" id="municipioFactorEditar" name="municipioFactorEditar" required>
                                    <ui-select-match placeholder="Seleccionar un municipio">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="municipio.id as municipio in (municipios| filter: $select.search)">
                                        <span ng-bind="municipio.nombre" title="@{{municipio.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.municipioFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.municipioFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="tipoProveedorFactorEditar"><span class="asterisk">*</span>Tipo Proveedor</label>
                                <ui-select ng-model="editarFactor.tipoProveedor_id" id="tipoProveedorFactorEditar" name="tipoProveedorFactorEditar" required>
                                    <ui-select-match placeholder="Seleccionar un tipo de proveedor">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="tipoProveedor.tipo_proveedores_id as tipoProveedor in (tiposProveedores| filter: $select.search)">
                                        <span ng-bind="tipoProveedor.nombre" title="@{{tipoProveedor.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.tipoProveedorFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.tipoProveedorFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="tamanioEmpresaFactorEditar"><span class="asterisk">*</span>Tamaño de la empresa</label>
                                <ui-select ng-model="editarFactor.tamanioEmpresa_id" id="tamanioEmpresaFactorEditar" name="tamanioEmpresaFactorEditar" required>
                                    <ui-select-match placeholder="Seleccionar tamaño de la empresa">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="tamanio.id as tamanio in (tamaniosEmpresa| filter: $select.search)">
                                        <span ng-bind="tamanio.nombre" title="@{{tamanio.nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.tamanioEmpresaFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.tamanioEmpresaFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="generalFactorEditar"><span class="asterisk">*</span>¿Qué tipo de factor aplicar?</label>
                                <br>
                                <input type="radio" name="generalFactorEditar" id="generalFactorEditar" ng-model="editarFactor.es_general" value="0" required>General
                                <input type="radio" name="generalFactorEditar" id="generalFactorEditar" ng-model="editarFactor.es_general" value="1" required>Específico
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.generalFactorEditar.$touched">
                                    <br>
                                    <span ng-show="editarFactorForm.generalFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row" ng-if="editarFactor.es_general == 1">
                            <div class="col-xs-12">
                                <label for="proveedorRntFactorEditar"><span class="asterisk">*</span>Proveedor RNT</label>
                                <ui-select ng-model="editarFactor.proveedor_rnt_id" id="proveedorRntFactorEditar" name="proveedorRntFactorEditar" ng-required="editarFactor.es_general == 1">
                                    <ui-select-match placeholder="Seleccionar un proveedor rnt">
                                        <span ng-bind="$select.selected.nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="proveedor.id as proveedor in (proveedoresRnt| filter: $select.search)">
                                        <span ng-bind="proveedor.nombre" title="@{{proveedor.nombre}}"></span>
                                        <br />
                                        <small>
                                            RNT: @{{proveedor.rnt}}
                                        </small>
                                    </ui-select-choices>
                                </ui-select>
                                
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.proveedorRntFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.proveedorRntFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="ofertaFactorEditar"><span class="asterisk">*</span>¿A que sección pertenece este factor?</label>
                                <br>
                                <input type="radio" name="ofertaFactorEditar" id="ofertaFactorEditar" ng-model="editarFactor.es_oferta" value="1" required>Oferta
                                <input type="radio" name="ofertaFactorEditar" id="ofertaFactorEditar" ng-model="editarFactor.es_oferta" value="0" required>Empleo
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.ofertaFactorEditar.$touched">
                                    <br>
                                    <span ng-show="editarFactorForm.ofertaFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="cantidadFactorEditar"><span class="asterisk">*</span>Valor factor</label>
                                <input type="number" placeholder="Valor del factor de expansión" class="form-control" name="cantidadFactorEditar" id="cantidadFactorEditar" ng-model="editarFactor.cantidad" required/>
                                <span class="messages" ng-show="editarFactorForm.$submitted || editarFactorForm.cantidadFactorEditar.$touched">
                                    <span ng-show="editarFactorForm.cantidadFactorEditar.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="editarFactorMetodo()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    <div class='carga'>

    </div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/factores_expansion/factoresExpansion.js')}}"></script>
<script src="{{asset('/js/administrador/factores_expansion/factoresExpansionServices.js')}}"></script>
@endsection

