@extends('layout._AdminLayout')

@section('Title','Administrador de temporadas :: SITUR Atlántico')
@section('app','ng-app="admin.temporadas"')

@section ('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

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
        .row {
            margin-top: 1em;
        }
        .ADMdtp-box.ADMdtp-calendar-container{
                z-index: 1060!important;
        }
    </style>
@endsection
@section('controller','ng-controller="temporadasCtrl"')

@section('content')

<div class='container'>
            
            <div class="main-page" >
               
                <div class="blank-page widget-shadow scroll" id="style-2 div1">
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="button" ng-click="pasarC()" class="btn btn-primary" value="Crear temporada" />
                        </div>
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
                                </thead>
                                <tbody>
                                    <tr dir-paginate="item in temporadas | itemsPerPage: 10">
                                        <td>@{{item.Nombre}}</td>
                                        <td>@{{item.Name}}</td>
                                        <td>@{{item.Fecha_ini |date: "dd/MM/yyyy"}}</td>
                                        <td>@{{item.Fecha_fin |date: "dd/MM/yyyy"}}</td>
                                        <td>
                                            <label ng-if="item.Estado" >Activo</label>
                                            <label ng-if="!item.Estado" >Desactivado</label>
                                        </td>
                                        <td style="width: 130px;">
                                            <button class="btn btn-default btn-sm" ng-click="pasarE(item)">
                                                <span class="glyphicon glyphicon-pencil" title="Editar"></span>
                                            </button>
                                            <button class="btn btn-default btn-sm" ng-if="!item.Estado" ng-click="cambiarEstado(item)">
                                                <span class="glyphicon glyphicon-ok" title="Activar"></span>
                                            </button>
                                            <button class="btn btn-default btn-sm" ng-if="item.Estado" ng-click="cambiarEstado(item)">
                                                <span class="glyphicon glyphicon-remove" title="Desactivar"></span>
                                            </button>
                                            <a ng-if="item.Estado" href="/temporada/ver/@{{item.id}}" title="Ver" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-eye-open"></span></a>
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
                <div class="modal fade" id="crearTemporada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Agregar temporada</h4>
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
                                            <div class="form-group">
                                                <label class="control-label" for="inputNombre"><span style="color:red;">*</span> Nombre en español de la temporada</label>
                                                <input type="text" class="form-control" name="nombre" id="inputNombre" placeholder="Ingrese nombre en español de la temporada" ng-model="temporada.Nombre" ng-required="true" />
                                                <span class="messages" ng-show="addForm.$submitted || addForm.nombre.$touched">
                                                    <span ng-show="addForm.nombre.$error.required">* El campo es requerido.</span>
                                                </span>
                                            </div>
                                        </div>
            
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" for="inputName"><span style="color:red;">*</span> Nombre en inglés de la temporada</label>
                                                <input type="text" class="form-control" name="name" id="inputName" placeholder="Ingrese nombre en inglés de la temporada" ng-model="temporada.Name" ng-required="true" />
                                                <span class="messages" ng-show="addForm.$submitted || addForm.name.$touched">
                                                    <span ng-show="addForm.name.$error.required">* El campo es requerido.</span>
                                                </span>
                                            </div>
                                        </div>
            
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                
                                                    <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha inicial</label>
                                                    <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_ini" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha inicial"></adm-dtp>
                                            </div>
                                        </div>
            
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                               
                                                    <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha final</label>
                                                    <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_fin" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha final"></adm-dtp>
                                                
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" ng-click="guardar()" class="btn btn-primary">Crear</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            
                <!-- Modal editar temporada-->
                <div class="modal fade" id="editarTemporada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Agregar temporada</h4>
                            </div>
                            <form role="form" name="editForm" novalidate>
                                <div class="modal-body">
                                    <div class="alert alert-danger" ng-if="errores != null">
                                            <p ng-repeat="error in errores" >
                                                -@{{error[0]}}
                                            </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" for="inputNombre"><span style="color:red;">*</span> Nombre de la temporada</label>
                                                <input type="text" ng-model="temporada.Nombre" class="form-control" name="nombre" id="inputNombre" placeholder="Ingrese nombre de la temporada" ng-model="temporada.Nombre" ng-required="true" />
                                                <span class="messages" ng-show="editForm.$submitted || editForm.nombre.$touched">
                                                    <span ng-show="editForm.nombre.$error.required">* El campo es requerido.</span>
                                                </span>
                                            </div>
                                        </div>
            
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label" for="inputName"><span style="color:red;">*</span> Nombre en inglés de la temporada</label>
                                                <input type="text" class="form-control" name="name" id="inputName" placeholder="Ingrese nombre en inglés de la temporada" ng-model="temporada.Name" ng-required="true" />
                                                <span class="messages" ng-show="editForm.$submitted || editForm.name.$touched">
                                                    <span ng-show="editForm.name.$error.required">* El campo es requerido.</span>
                                                </span>
                                            </div>
                                        </div>
            
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                
                                                    <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha inicial</label>
                                                    <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_ini" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha inicial"></adm-dtp>
                                            </div>
                                        </div>
            
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                               
                                                    <label class="control-label" for="inputNombre"><span style="color:red;">*</span>Fecha final</label>
                                                    <adm-dtp name="fechaAplicacion" id="fechaAplicacion" ng-model="temporada.Fecha_fin" maxdate="'{{\Carbon\Carbon::now()->format('Y-m-d')}}'" options="optionFecha" placeholder="Ingrese fecha final"></adm-dtp>
                                                
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" ng-click="editar()" class="btn btn-primary">Guardar cambio</button>
                                </div>
                            </form>
            
                        </div>
                    </div>
                </div>
            
            </div>
            
</div>
@endsection
@section('javascript')
<script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/temporada/temporadas.js')}}"></script>
<script src="{{asset('/js/administrador/temporada/services.js')}}"></script>
@endsection