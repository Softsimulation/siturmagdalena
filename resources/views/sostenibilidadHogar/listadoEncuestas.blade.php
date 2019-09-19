
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas de sostenibilidad - hogares')

@section('app','ng-app="listadoEncuestasHogarSostenibilidadApp"')

@section('controller','ng-controller="listadoEncuestasSostenibilidadHogarCtrl"')

@section('titulo','Encuestas de sostenibilidad - hogares')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-encuestaSostenibilidadHogares'))
        <a href="/sostenibilidadhogares/crear" type="button" class="btn btn-lg btn-success">
          Agregar encuesta
        </a>
    @endif
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>      
</div>
<div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != '' && search != undefined)">
    <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
      
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <thead>
                        <tr>                     
                            <th style="width: 60px;">No. de encuesta</th>
                            <th>Encuestado</th>
                            <th>Dirección</th>
                            <th>Barrio</th>
                            <th>Encuestador</th>
                            <th style="max-width: 130px;">Estado</th>
                            <th style="max-width: 90px;">Última sección</th>
                            <th style="width: 70px;">Opciones</th>
                            
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                                
                            <td><input type="text" ng-model="search.id" name="id" id="id" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.encuestado" name="encuestado" id="encuestado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.direccion" name="direccion" id="direccion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.barrio" name="barrio" id="barrio" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.encuestador" name="encuestador" id="encuestador" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.ultimaSeccion" name="ultimaSeccion" id="ultimaSeccion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in encuestas|filter:search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.encuestado}}</td>
                            <td>@{{item.direccion}}</td>
                            <td>@{{item.barrio}}</td>
                            <td>@{{item.encuestador}}</td>
                            <td>@{{item.estado}}</td>
                            <td style="text-align: center;">@{{item.ultimaSeccion}}</td>
                            <td style="text-align: center;">
                                @if(Auth::user()->contienePermiso('edit-encuestaSostenibilidadHogares'))
                                    <a href="/sostenibilidadhogares/editar/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                                @endif
                                <button  id="dLabel" type="button" class="btn btn-xs btn-default" title="Historial encuesta" ng-click="historialEncuesta(item)">
                                        <span class="glyphicon glyphicon-list-alt"></span><span class="sr-only">Historial</span>
                               </button>
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
              <dir-pagination-controls pagination-id="paginacion_encuestas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    <div class='carga'>

    </div>
    <div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="modalHistorial">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Historial encuestas </h4>
            </div>
    
                <div class="modal-body">

      
	     <div class="row">
            <div class="col-xs-12 table-overflow">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        
                            <th>Nombre</th>
                            <th>fecha cambio</th>
                            <th>Estado </th>
                            <th>Mensaje</th>
        
                        </tr>
                
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in historial_encuestas |itemsPerPage:10 as results" pagination-id="paginacion_encuestas_historial" >
                               
                   
                            <td>@{{item.user_create}}</td>
                            <td>@{{item.estados_encuesta.nombre}}</td>
                            <td>@{{item.fecha_cambio | date:'dd-MM-yyyy'}}</td>
                            <td>@{{item.observacion }}</td>
                          
                        </tr>    
                    </tbody>
                    
                </table>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <dir-pagination-controls pagination-id="paginacion_encuestas_historial"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>
        </div>




                </div>

                <div class="modal-footer text-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                   
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/encuestas/sostenibilidadHogar/listado.js')}}"></script>
<script src="{{asset('/js/encuestas/sostenibilidadHogar/services.js')}}"></script>
@endsection


