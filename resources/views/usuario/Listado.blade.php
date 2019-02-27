
@extends('layout._AdminLayout')

@section('title', 'Usuarios')

@section('titulo','Usuarios')
@section('subtitulo','El siguiente listado cuenta con @{{usuarios.length}} registro(s)')

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
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            z-index: 1000;
            display: block;
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            z-index: 1000;
            display: block;
        }
    </style>
@endsection

@section('app','ng-app="admin.usuario"')

@section('controller','ng-controller="listadoUsuariosCtrl"')

@section('content')
<div class="flex-list">
    <a href="/usuario/guardar" role="button" class="btn btn-lg btn-success">
      Crear usuario
    </a> 
    <button ng-click="enviarCorreos()" ng-if="usuariosCorreos.ids.length > 0" type="button" class="btn btn-lg btn-primary">
      Enviar correos
    </button> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de usuarios</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar usuarios...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(usuarios | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(usuarios | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="usuarios.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(usuarios | filter:prop.search).length == 0 && usuarios.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<p class="text-muted text-center">Seleccione usuarios para ver más opciones</p>
        <div class="row">
            <div class="col-xs-12" style="overflow: auto;">
                <div>
                    <table class="table table-hover table-responsive Table">
                        <thead>
                            <tr>
                                <th></th>
                                <!--<th>#</th>-->
                                <th>Nombres</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody ng-init="currentPageUsuarios = 1">
                            <tr dir-paginate="usuario in usuarios|filter:prop.search|itemsPerPage: 10" current-page="currentPageUsuarios" ng-click="verDetalleUsuario($event, usuario)">
                                <td><input type="checkbox" checklist-model="usuariosCorreos.ids" checklist-value="usuario.id"></td>
                                <!--<td>@{{($index + 1) + (currentPageUsuarios - 1) * 10}}</td>-->
                                <td>@{{usuario.nombre}}</td>
                                <td>@{{usuario.email}}</td>
                                <td><span ng-repeat="rol in usuario.roles">@{{rol.display_name}}<span ng-if="!$last">,</span></span></td>
                                <td ng-if="usuario.estado == true">Activo</td>
                                <td ng-if="usuario.estado != true">Inactivo</td>
                                <td>
                                    <a href="/usuario/editar/@{{usuario.id}}" type="button" title="Editar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <button ng-if="usuario.estado == true" ng-click="cambiarEstado(usuario)" role="button" title="Desactivar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span></button>
                                    <button ng-if="usuario.estado != true" ng-click="cambiarEstado(usuario)" role="button" title="Activar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ok-circle"></span></button>
                                    <a href="/usuario/asignarpermisos/@{{usuario.id}}" type="button" title="Asignar permisos" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-lock"></span></a>
                                    <!--<button ng-click="asignarPermisosModal(usuario)" role="button" title="Asignar permisos" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-lock"></span></button>-->
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
        <div class="modal fade" id="modalAsignacionPermiso" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="asignarPermisosForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Asignación de permisos</h4>
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
                                <label class="form-group">Permisos</label>
                                <ui-select multiple sortable="true" ng-model="asignarPermiso.permisos" theme="select2" title="Escoja permisos" style="width:100%;">
                                    <ui-select-match placeholder="Seleccione permisos">@{{$item.display_name}}</ui-select-match>
                                    <ui-select-choices repeat="item.id as item in permisos | filter: $select.search">
                                      <div ng-bind-html="item.display_name | highlight: $select.search"></div>
                                    </ui-select-choices>
                                  </ui-select>
                    
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="asignacionPermisos()">Asignar</button>
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
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/usuarios/usuarios.js')}}"></script>
<script src="{{asset('/js/administrador/usuarios/usuarioServices.js')}}"></script>
@endsection

