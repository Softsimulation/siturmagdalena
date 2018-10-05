@extends('layout._AdminLayout')

@section('app','ng-app="appProyect"')
@section('controller','ng-controller="ListadoPublicacionCtrl"')

@section('titulo','Publicaciones')
@section('subtitulo','El siguiente listado cuenta con @{{publicaciones.length}} registro(s)')

@section('content')
<div class="flex-list">
    <a href="/publicaciones/crear" class="btn btn-lg btn-success" class="btn btn-lg btn-success">
        Crear publicaciones
    </a> 
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>     
</div>
<div class="text-center" ng-if="(publicaciones | filter:search).length > 0 && (search != undefined)">
    <p>Hay @{{(publicaciones | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="publicaciones.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(publicaciones | filter:search).length == 0 && publicaciones.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.titulo.length > 0 || search.tipoPublicacion.length > 0 || search.descripcion.length > 0 || search.estado.length > 0 )">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>

<div class="row">
    <div class="col-xs-12" style="overflow: auto;">
        
        <table class="table table-hover table-responsive Table" style="margin:0">
            <thead>
                <tr>
                    <!--<th style="width: 20px;"></th>-->
                    <th>Titulo</th>
                    <th>Tipo</th>                                                                          
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Visible</th>
                    <th style="width: 120px;">Opciones</th>
                </tr>
                <tr ng-show="mostrarFiltro == true">
                            
                    <td><input type="text" ng-model="search.titulo" name="titulo" id="titulo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td><input type="text" ng-model="search.tipoPublicacion" name="tipoPublicacion" id="tipoPublicacion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td><input type="text" ng-model="search.descripcion" name="descripcion" id="descripcion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td></td>
                </tr>
            </thead>
            <tbody ng-init="currentPagepublicacion = 1">
                <tr dir-paginate="publicacion in publicaciones |filter:search|itemsPerPage: 10" pagination-id="pagepublicacion" current-page="currentPagepublicacion">
                    <!--<td>@{{($index + 1) + (currentPagepublicacion - 1) * 10}}</td>-->
                    <td>@{{publicacion.titulo}}</td>
                   <td>@{{publicacion.tipopublicacion.idiomas[0].nombre}}</td>
                    <td>@{{publicacion.descripcion}}</td>
                    <td>@{{publicacion.estado_publicacion.nombre}}</td>
                    <td ng-show="publicacion.estado == 1">Si</td>
                    <td ng-show="publicacion.estado == 0">No</td>
                    <td>
                        <a href="/publicaciones/editar/@{{publicacion.id}}" type="button" title="Editar publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>  
                        <button ng-click="cambiarEstado(publicacion)" type="button" title="Cambiar visualización publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-transfer"></span></button>    
                        <button ng-click="eliminar(publicacion)" type="button" title="Eliminar publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span></button>    
                         <button ng-click="cambiarEstadoPublicacion(publicacion)" type="button" title="Cambiar estado publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-transfer"></span></button> 
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 text-center">
        <dir-pagination-controls pagination-id="pagepublicacion"></dir-pagination-controls>
    </div>
</div>
            
<div class="modal fade" id="modalCambiarEstado" tabindex="-1" role="dialog" aria-labelledby="modalCambiarEstado">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cambiar estado</h4>
            </div>
            <form role="form" name="cambiarForm" novalidate>
                <div class="modal-body">
                    <div class="alert alert-info">Todos los campos son obligatorios.</div>

                    <div class="alert alert-danger" ng-if="erroresDoc != null">
                        <h6>Errores</h6>
                        <div ng-repeat="error in erroresEstado" ng-if="error.errores.length>0">
                            @{{error.errores[0].ErrorMessage}}
                        </div>
                    </div>
                    
                    
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="form-group">
                            <label class="control-label">Titulo</label>
                            <p class="form-control-static">@{{estado.titulo}}</p>
                        </div>
                    </div>
    
                    <div class="col-xs-12 col-md-8">
                        <div class="form-group">
                            <label class="control-label">Descripción</label>
                            <p class="form-control-static">@{{estado.descripcion}}</p>
                        </div>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <div class="form-group" >
                            <label>Estado</label>
                            <select ng-model="estado.estados_id" name="tipo" style="width:100%" class="form-control" ng-options="item.id as item.nombre for item in estados" ng-required="true">
                                <option value="" disabled>Seleccione un estado</option>
                            </select>
                            <span ng-show="cambiarForm.$submitted || cambiarForm.tipo.$touched">
                                <span class="label label-danger" ng-show="cambiarForm.tipo.$error.required">Debe seleccionar un estado</span>
                            </span>      
                        </div>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" ng-click="cambioEstado()" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection
@section('javascript')
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select2.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/servicios.js')}}"></script>
    <script src="{{asset('/js/plugins/dirPagination.js')}}"></script>
    <script src="{{asset('/js/plugins/ng-tags-input.js')}}"></script>
    <script src="{{asset('/js/plugins/directiva.campos.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/appAngular.js')}}"></script>
@endsection