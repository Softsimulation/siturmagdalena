
@extends('layout._AdminLayout')

@section('title', 'Indicadores medición')

@section('titulo','Indicadores medición')
@section('subtitulo','El siguiente listado cuenta con @{{indicadores.length}} registro(s)')

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

@section('app','ng-app="admin.indicadoresMedicion"')

@section('controller','ng-controller="listadoIndicadoresMedicionCtrl"')

@section('content')
<div class="flex-list">
    <a href="" role="button" class="btn btn-lg btn-success" ng-click="crearIndicadorModal()" >Crear indicador
    </a> 
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
         
</div>
<div class="text-center" ng-if="(indicadores | filter:search).length > 0 && (indicadores != undefined)">
    <p>Hay @{{(indicadores | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="indicadores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(indicadores | filter:search).length == 0 && indicadores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.nombre.length > 0 || search.estadoIndicador.length > 0 || search.categoria.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>   
<p class="text-muted text-center">Seleccione indicadores para ver más opciones</p>
        <div class="row">
            <div class="col-xs-12" style="overflow: auto;">
                <div>
                    <table class="table table-hover table-responsive Table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            <tr ng-show="mostrarFiltro == true">
                                    
                                <td><input type="text" ng-model="search.nombre" name="nombre" id="nombre" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.categoria" name="categoria" id="categoria" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.estadoIndicador" name="estadoIndicador" id="estadoIndicador" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody ng-init="currentPageUsuarios = 1">
                            <tr dir-paginate="indicador in indicadores|filter:search|itemsPerPage: 10" current-page="currentPageUsuarios" ng-click="verDetalleUsuario($event, usuario)">
                                <td>@{{indicador.nombre}}</td>
                                <td>@{{indicador.categoria}}</td>
                                <td>@{{indicador.estadoIndicador}}</td>
                                <td>
                                    <a href="" ng-repeat="idioma in indicador.tieneIdiomas" class="btn btn-default" ng-click="editarIndicadorModal(indicador,idioma.id)" >@{{idioma.culture}} </a>
                                    <button type="button" ng-click="modalIdioma(indicador)" class="btn btn-default" ng-if="idiomas.length != indicador.tieneIdiomas.length"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></button>
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
        <div class="modal fade" id="modalEditarIndicador" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="editarIndicadorForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar indicador</h4>
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
                                <label for="nombreIndicador"><span class="asterisk">*</span>Nombre</label>
                                <input type="text" class="form-control" name="nombreIndicador" id="nombreIndicador" ng-model="editarIndicador.nombre" required/>
                                <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.nombreIndicador.$touched">
                                    <span ng-show="editarIndicadorForm.nombreIndicador.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeX"><span class="asterisk">*</span>Eje x</label>
                                <input type="text" class="form-control" name="ejeX" id="ejeX" ng-model="editarIndicador.eje_x" required/>
                                <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.ejeX.$touched">
                                    <span ng-show="editarIndicadorForm.ejeX.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeY"><span class="asterisk">*</span>Eje y</label>
                                <input type="text" class="form-control" name="ejeY" id="ejeY" ng-model="editarIndicador.eje_y" required/>
                                <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.ejeY.$touched">
                                    <span ng-show="editarIndicadorForm.ejeY.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="descripcionIndicador"><span class="asterisk">*</span>Descripción</label>
                                <textarea class="form-control" name="descripcionIndicador" id="descripcionIndicador" ng-model="editarIndicador.descripcion" row="3" required></textarea>
                                <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.descripcionIndicador.$touched">
                                    <span ng-show="editarIndicadorForm.descripcionIndicador.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row" ng-if="editarIndicador.idioma_id == 1">
                            <div class="col-xs-12">
                                <label for="formato"><span class="asterisk">*</span>Unidad de medida</label>
                                <input type="text" class="form-control" name="formato" id="formato" ng-model="editarIndicador.formato" ng-required="editarIndicador.idioma_id == 1"/>
                                <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.formato.$touched">
                                    <span ng-show="editarIndicadorForm.formato.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row" ng-if="editarIndicador.idioma_id == 1">
                            <div class="col-sm-12">
                                <div class="form-tiposGraficas" ng-class="{'has-error': (editarIndicadorForm.$submitted || editarIndicadorForm.tiposGraficas.$touched) && editarIndicadorForm.tiposGraficas.$error.required}">
                                    <label for="tiposGraficas"><span class="asterisk">*</span> Tipos gráficas <span class="text-error text-msg">(Seleccione al menos un tipo de gráfica)</span></label>
                                    <ui-select name="tiposGraficas" id="tiposGraficas" multiple ng-required="editarIndicador.idioma_id == 1" ng-model="editarIndicador.idsGraficas" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios tipos de gráficas.">
                                            <span ng-bind="$item.nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="tipo.id as tipo in (tiposGraficas| filter: $select.search)">
                                            <span ng-bind="tipo.nombre" title="@{{tipo.nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>    
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row" ng-if="editarIndicador.idioma_id == 1">
                            <div class="col-xs-12">
                                <div class="form-graficaPrincipal">
                                    <label><span class="asterisk">*</span>Gráfica principal</label>
                                    <select class="form-control" ng-required="editarIndicador.idioma_id == 1" name="graficaPrincipal" id="graficaPrincipal" ng-options="tipo.id as tipo.nombre for tipo in tiposGraficas" ng-model="editarIndicador.graficaPrincipal">
                                        <option value="">Seleccione un tipo</option>
                                    </select>
                                    
                                    <span class="messages" ng-show="editarIndicadorForm.$submitted || editarIndicadorForm.graficaPrincipal.$touched">
                                        <span ng-show="editarIndicadorForm.graficaPrincipal.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarIndicador()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="modalIdiomaIndicador" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="idiomaIndicadorForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Agregar idioma</h4>
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
                                <div class="form-group" ng-class="{'has-error': (idiomaIndicadorForm.$submitted || idiomaIndicadorForm.idiomaIdIndicador.$touched) && idiomaIndicadorForm.idiomaIdIndicador.$error.required }">
                                    <label class="control-label" for="idiomaIdIndicador"><span class="asterisk">*</span> Nuevo idioma</label>
                                    <select ng-options="item.id as item.nombre for item in idiomaIndicador.noIdiomas" ng-model="idiomaIndicador.idioma_id" class="form-control" id="idiomaIdIndicador" name="idiomaIdIndicador" required>
                                        <option value="" selected disabled>Seleccione un idioma</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="nombreIndicadorIdioma"><span class="asterisk">*</span>Nombre</label>
                                <input type="text" class="form-control" name="nombreIndicador" id="nombreIndicadorIdioma" ng-model="idiomaIndicador.nombre" required/>
                                <span class="messages" ng-show="idiomaIndicadorForm.$submitted || idiomaIndicadorForm.nombreIndicador.$touched">
                                    <span ng-show="idiomaIndicadorForm.nombreIndicador.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeXIdioma"><span class="asterisk">*</span>Eje x</label>
                                <input type="text" class="form-control" name="ejeX" id="ejeXIdioma" ng-model="idiomaIndicador.eje_x" required/>
                                <span class="messages" ng-show="idiomaIndicadorForm.$submitted || idiomaIndicadorForm.ejeX.$touched">
                                    <span ng-show="idiomaIndicadorForm.ejeX.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeYIdioma"><span class="asterisk">*</span>Eje y</label>
                                <input type="text" class="form-control" name="ejeY" id="ejeYIdioma" ng-model="idiomaIndicador.eje_y" required/>
                                <span class="messages" ng-show="idiomaIndicadorForm.$submitted || idiomaIndicadorForm.ejeY.$touched">
                                    <span ng-show="idiomaIndicadorForm.ejeY.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="descripcionIndicadorIdioma"><span class="asterisk">*</span>Descripción</label>
                                <textarea class="form-control" id="descripcionIndicadorIdioma" name="descripcionIndicador" ng-model="idiomaIndicador.descripcion" row="3" required></textarea>
                                <span class="messages" ng-show="idiomaIndicadorForm.$submitted || idiomaIndicadorForm.descripcionIndicador.$touched">
                                    <span ng-show="idiomaIndicadorForm.descripcionIndicador.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarIndicadorIdioma()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
        <div class="modal fade" id="modalCrearIndicador" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="crearIndicadorForm"  novalidate>
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
                                <label for="tipoMedicion"><span class="asterisco">*</span>Tipo de medición</label>
                                <select class="form-control" name="tipoMedicion" id="tipoMedicion" ng-options="tipo.id as tipo.nombre for tipo in tiposMediciones" ng-model="crearIndicador.tipo_medicion_indicador_id" required>
                                    <option value="">Seleccione un tipo</option>
                                </select>
                                
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.tipoMedicion.$touched">
                                    <span ng-show="crearIndicadorForm.tipoMedicion.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="nombreIndicadorCrear"><span class="asterisk">*</span>Nombre</label>
                                <input type="text" placeholder="Nombre del indicador" class="form-control" name="nombreIndicadorCrear" id="nombreIndicadorCrear" ng-model="crearIndicador.nombre" required/>
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.nombreIndicadorCrear.$touched">
                                    <span ng-show="crearIndicadorForm.nombreIndicadorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeXCrear"><span class="asterisk">*</span>Eje x</label>
                                <input type="text" placeholder="Nombre que se le dará al eje X" class="form-control" name="ejeXCrear" id="ejeXCrear" ng-model="crearIndicador.eje_x" required/>
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.ejeXCrear.$touched">
                                    <span ng-show="crearIndicadorForm.ejeXCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label for="ejeYCrear"><span class="asterisk">*</span>Eje y</label>
                                <input type="text" placeholder="Nombre que se le dará al eje Y" class="form-control" name="ejeYCrear" id="ejeYCrear" ng-model="crearIndicador.eje_y" required/>
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.ejeYCrear.$touched">
                                    <span ng-show="crearIndicadorForm.ejeYCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="descripcionIndicadorCrear"><span class="asterisk">*</span>Descripción</label>
                                <textarea placeholder="Descripción del indicador" class="form-control" name="descripcionIndicadorCrear" id="descripcionIndicadorCrear" ng-model="crearIndicador.descripcion" row="3" required></textarea>
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.descripcionIndicadorCrear.$touched">
                                    <span ng-show="crearIndicadorForm.descripcionIndicadorCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="formatoCrear"><span class="asterisk">*</span>Unidad de medida</label>
                                <input type="text" placeholder="Unidad de medida del indicador" class="form-control" name="formatoCrear" id="formatoCrear" ng-model="crearIndicador.formato" required/>
                                <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.formatoCrear.$touched">
                                    <span ng-show="crearIndicadorForm.formatoCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-tiposGraficasCrear" ng-class="{'has-error': (crearIndicadorForm.$submitted || crearIndicadorForm.tiposGraficasCrear.$touched) && crearIndicadorForm.tiposGraficasCrear.$error.required}">
                                    <label for="tiposGraficasCrear"><span class="asterisk">*</span> Tipos gráficas <span class="text-error text-msg">(Seleccione al menos un tipo de gráfica)</span></label>
                                    <ui-select name="tiposGraficas" id="tiposGraficas" multiple required ng-model="crearIndicador.idsGraficas" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios tipos de gráficas.">
                                            <span ng-bind="$item.nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="tipo.id as tipo in (tiposGraficas| filter: $select.search)">
                                            <span ng-bind="tipo.nombre" title="@{{tipo.nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>    
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-graficaPrincipalCrear">
                                    <label><span class="asterisk">*</span>Gráfica principal</label>
                                    <select class="form-control" required name="graficaPrincipalCrear" id="graficaPrincipalCrear" ng-options="tipo.id as tipo.nombre for tipo in tiposGraficas" ng-model="crearIndicador.graficaPrincipal">
                                        <option value="">Seleccione un tipo</option>
                                    </select>
                                    
                                    <span class="messages" ng-show="crearIndicadorForm.$submitted || crearIndicadorForm.graficaPrincipalCrear.$touched">
                                        <span ng-show="crearIndicadorForm.graficaPrincipalCrear.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="crearIndicadorMetodo()">Guardar</button>
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
<script src="{{asset('/js/administrador/indicadoresMedicion/indicadoresMedicion.js')}}"></script>
<script src="{{asset('/js/administrador/indicadoresMedicion/indicadoresMedicionServices.js')}}"></script>
@endsection

