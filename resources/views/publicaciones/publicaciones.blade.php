@extends('layout._AdminLayout')


@section('app','ng-app="appProyect"')

@section('content')
   
    <div ng-controller="ListadoPublicacionCtrl" >
        

      <div class="panel-group Panel-group">
                <div class="title">
                    Publicaciones

                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-offset-5 col-sm-4">
                            <div class="form-group input-group">
                                <input id="input" class="form-control input-search" type="search" placeholder="Búsqueda" ng-model="searchpublicacion" aria-describedby="iconsearch">
                                <span class="input-group-addon" id="iconsearch"><i class="glyphicon glyphicon-search"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <span class="chip">@{{( publicaciones |filter: searchpublicacion).length}} Resultados</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="overflow: auto;">
                            
                            <a href="/publicaciones/crear" class="btn btn-primary">Crear publicacion</a>
                            <br><br>
                            <table class="table table-hover table-responsive Table" style="margin:0">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;"></th>
                                        <th>Titulo</th>
                                        <th>Tipo</th>                                                                          
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Visible</th>
                                        <th style="width: 68px;">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody ng-init="currentPagepublicacion = 1">
                                    <tr dir-paginate="publicacion in publicaciones |filter:searchpublicacion|itemsPerPage: 10" pagination-id="pagepublicacion" current-page="currentPagepublicacion">
                                        <td>@{{($index + 1) + (currentPagepublicacion - 1) * 10}}</td>
                                        <td>@{{publicacion.titulo}}</td>
                                       <td>@{{publicacion.tipopublicacion.idiomas[0].nombre}}</td>
                                        <td>@{{publicacion.descripcion}}</td>
                                        <td>@{{publicacion.estado_publicacion.nombre}}</td>
                                        <td ng-show="publicacion.estado == 1">Si</td>
                                        <td ng-show="publicacion.estado == 0">No</td>
                                        <td>
                                            <a href="/publicaciones/editar/@{{publicacion.id}}" type="button" title="Editar publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>  
                                            <button ng-click="cambiarEstado(publicacion)" type="button" title="Cambiar visualización publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-transfer"></span></button>    
                                            <button ng-click="eliminar(publicacion)" type="button" title="Eliminar publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></button>    
                                             <button ng-click="cambiarEstadoPublicacion(publicacion)" type="button" title="Cambiar estado publicación" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-transfer"></span></button> 
                                        </td>
                                    </tr>
                                    <tr ng-show="( publicaciones |filter: searchpublicacion).length == 0">
                                        <td colspan="7" style="text-align:center;">
                                            <div class="well" style="margin:0">
                                                <p style="margin:0">No se encontraron publicaciones.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 text-center">
                            <dir-pagination-controls pagination-id="pagepublicacion"></dir-pagination-controls>
                        </div>
                    </div>
                </div>
            </div>
            
<div class="modal fade" id="modalCambiarEstado" tabindex="-1" role="dialog" aria-labelledby="modalCambiarEstado">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cambiar Estado</h4>
            </div>
            <form role="form" name="cambiarForm" novalidate>
                <div class="modal-body">
                    <div class="alert alert-warning">Todos los campos son obligatorios.</div>

                    <div class="alert alert-danger" ng-if="erroresDoc != null">
                        <h6>Errores</h6>
                        <div ng-repeat="error in erroresEstado" ng-if="error.errores.length>0">
                            @{{error.errores[0].ErrorMessage}}
                        </div>
                    </div>
                    
                    
                <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Titulo</label>
                                        <p class="form-control-static">@{{estado.titulo}}</p>
                                    </div>
                                </div>

                                <div class="col-md-8">
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
                <div class="modal-footer text-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" ng-click="cambioEstado()" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
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