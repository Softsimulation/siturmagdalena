@extends('layout._AdminLayout')

@section('Title','Administrador de temporadas :: SITUR Magdalena')
@section('app','ng-app="admin.temporadas"')
@section ('estilos')
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <style>
        

        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .ADMdtp-box.ADMdtp-calendar-container{
                z-index: 1060!important;
        }
    </style>
@endsection
@section('controller','ng-controller="temporadasCtrl"')
@section('titulo','Temporadas')
@section('subtitulo','El siguiente listado cuenta con @{{temporadas.length}} registro(s)')
@section('content')
<div class="main-page" >
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        
        <div class="row">
            <div class="col-xs-12 text-center">
                <input type="button" ng-click="pasarC()" class="btn btn-lg btn-success" value="Crear temporada" />
                <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
            </div>
        </div>
        <br/>
        <div class="text-center" ng-if="(temporadas | filter:search).length > 0 && (search != undefined)">
            <p>Hay @{{(temporadas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
        </div>
        <div class="alert alert-info" ng-if="temporadas.length == 0">
            <p>No hay registros almacenados</p>
        </div>
        <div class="alert alert-warning" ng-if="(temporadas | filter:search).length == 0 && temporadas.length > 0">
            <p>No existen registros que coincidan con su búsqueda</p>
        </div>
        <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.Nombre.length > 0 || search.Name.length > 0 || search.Fecha_ini.length > 0 || search.Fecha_fin.length > 0 )">
            Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
        </div>
        <div class="row">
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover" ng-show="temporadas.length > 0">
                    <thead>
                        <tr>
                            <th>Nombre en español</th>
                            <th>Nombre en inglés</th>
                            <th>Fecha inicial</th>
                            <th>Fecha final</th>
                            <th>Estado</th>
                            <th style="width: 130px;"></th>
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                                    
                            <td><input type="text" ng-model="search.Nombre" name="Nombre" id="Nombre" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.Name" name="Name" id="Name" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.Fecha_ini" name="Fecha_ini" id="Fecha_ini" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.Fecha_fin" name="Fecha_fin" id="Fecha_fin" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.Estado" name="Estado" id="Estado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in temporadas | filter:search | itemsPerPage: 10">
                            <td>@{{item.Nombre}}</td>
                            <td>@{{item.Name}}</td>
                            <td>@{{item.Fecha_ini |date: "dd/MM/yyyy"}}</td>
                            <td>@{{item.Fecha_fin |date: "dd/MM/yyyy"}}</td>
                            <td>
                                <label ng-if="item.Estado" >Activo</label>
                                <label ng-if="!item.Estado" >Desactivado</label>
                            </td>
                            <td style="width: 130px;">
                                <button class="btn btn-default btn-xs" ng-click="pasarE(item)" title="Editar">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                                <button class="btn btn-default btn-xs" ng-if="!item.Estado" ng-click="cambiarEstado(item)" title="Activar">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>
                                <button class="btn btn-default btn-xs" ng-if="item.Estado" ng-click="cambiarEstado(item)" title="Desactivar">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                <a ng-if="item.Estado" href="/temporada/ver/@{{item.id}}" title="Ver" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning" role="alert" ng-if="temporadas.length == 0">
                    No hay temporadas
                </div>
            </div>

            <div class="col-xs-12" style="text-align: center;">
                <dir-pagination-controls></dir-pagination-controls>
            </div>
        </div>
    </div>

    <!-- Modal crear temporada-->
    <div class="modal fade" id="crearTemporada" tabindex="-1" role="dialog" aria-labelledby="labelModalCrearTemporada">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="labelModalCrearTemporada">Agregar temporada</h4>
                </div>
                <form role="form" name="addForm" novalidate>
                        
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                            </div>
                        <div class="alert alert-info">
                            <p>Todos los campos en este formulario son requeridos.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error':((addForm.$submitted || addForm.nombre.$touched) && addForm.nombre.$error.required)}">
                                    <label class="control-label" for="inputNombre">Nombre en español de la temporada</label>
                                    <input type="text" class="form-control" name="nombre" id="inputNombre" placeholder="Ingrese nombre en español de la temporada" ng-model="temporada.Nombre" ng-required="true" />
                                    
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error':((addForm.$submitted || addForm.name.$touched) && addForm.name.$error.required)}">
                                    <label class="control-label" for="inputName">Nombre en inglés de la temporada</label>
                                    <input type="text" class="form-control" name="name" id="inputName" placeholder="Ingrese nombre en inglés de la temporada" ng-model="temporada.Name" ng-required="true" />
                                    
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    
                                        <label class="control-label" for="inputNombre">Fecha inicial</label>
                                        <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_ini" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha inicial"></adm-dtp>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                   
                                        <label class="control-label" for="inputNombre">Fecha final</label>
                                        <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_fin" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha final"></adm-dtp>
                                    
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

    <!-- Modal editar temporada-->
    <div class="modal fade" id="editarTemporada" tabindex="-1" role="dialog" aria-labelledby="labelModalEditarTemporada">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="labelModalEditarTemporada">Editar temporada</h4>
                </div>
                <form role="form" name="editForm" novalidate>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                        </div>
                        <div class="alert alert-info">
                            <p>Todos los campos en este formulario son requeridos.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error':((editForm.$submitted || editForm.nombre.$touched) && editForm.nombre.$error.required)}">
                                    <label class="control-label" for="inputNombre">Nombre de la temporada</label>
                                    <input type="text" ng-model="temporada.Nombre" class="form-control" name="nombre" id="inputNombre" placeholder="Ingrese nombre de la temporada" ng-model="temporada.Nombre" ng-required="true" />
                                    
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error':((editForm.$submitted || editForm.name.$touched) && editForm.name.$error.required)}">
                                    <label class="control-label" for="inputName">Nombre en inglés de la temporada</label>
                                    <input type="text" class="form-control" name="name" id="inputName" placeholder="Ingrese nombre en inglés de la temporada" ng-model="temporada.Name" ng-required="true" />
                                    
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    
                                        <label class="control-label" for="inputNombre">Fecha inicial</label>
                                        <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_ini" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha inicial"></adm-dtp>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                   
                                        <label class="control-label" for="inputNombre">Fecha final</label>
                                        <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_fin" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha final"></adm-dtp>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="editar()" class="btn btn-success">Guardar cambio</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
@endsection
@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/administrador/temporada/temporadas.js')}}"></script>
<script src="{{asset('/js/administrador/temporada/services.js')}}"></script>
@endsection