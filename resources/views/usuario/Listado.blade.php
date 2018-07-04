
@extends('layout._AdminLayout')

@section('title', 'Listado de usuarios')

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
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de usuarios')

@section('app','ng-app="admin.usuario"')

@section('controller','ng-controller="listadoUsuariosCtrl"')

@section('content')
    

<div class="container">
    <h1 class="title1">Listado de encuestas</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-2" style="text-align: center;">
                <a href="/usuario/guardar" class="btn btn-primary" style="margin-bottom: .5em;">Crear usuario</a>
            </div>
              
            <div class="col-sm-offset-3 col-sm-4">
                <div class="form-group input-group">
                    <input id="input" class="form-control input-search" type="search" placeholder="Búsqueda" ng-model="search" aria-describedby="iconsearch">
                    <span class="input-group-addon" id="iconsearch"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            
            <div class="col-sm-3">
                <span class="chip">@{{( usuarios |filter: search|filter: filtroRol).length}} Resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12" style="overflow: auto;">
                <div>
                    <table class="table table-hover table-responsive Table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody ng-init="currentPageUsuarios = 1">
                            <tr dir-paginate="usuario in usuarios|filter:search|itemsPerPage: 10" current-page="currentPageUsuarios" ng-click="verDetalleUsuario($event, usuario)">
                                <td>@{{($index + 1) + (currentPageUsuarios - 1) * 10}}</td>
                                <td>@{{usuario.username}}</td>
                                <td>@{{usuario.email}}</td>
                                <td><span ng-repeat="rol in usuario.roles">@{{rol.display_name}}<span ng-if="!$last">,</span></span></td>
                                <td ng-if="usuario.estado == true">Activo</td>
                                <td ng-if="usuario.estado != true">Inactivo</td>
                                <td>
                                    <a href="/usuario/editar/@{{usuario.id}}" type="button" title="Editar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="" ng-if="usuario.estado == true" ng-click="cambiarEstado(usuario)" type="button" title="Desactivar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ban-circle"></span></a>
                                    <a href="" ng-if="usuario.estado != true" ng-click="cambiarEstado(usuario)" type="button" title="Activar usuario" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ok-circle"></span></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="col-md-12" ng-if="usuarios.length > 0 && (usuarios|filter:search).length == 0" style="padding-bottom: 1rem;">
                        <div class="alert alert-info" role="alert"><b>No hay elementos para la búsqueda realizada</b></div>
                    </div>

                    <div class="col-md-12" ng-if="usuarios.length == 0">
                        <div class="alert alert-info" role="alert"><b>No hay usuarios registrados en el sistema</b></div>
                    </div>
                    <div class="col-md-12 text-center">
                        <dir-pagination-controls></dir-pagination-controls>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='carga'>

    </div>
</div>

@endsection


