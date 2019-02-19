
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas de sostenibilidad - PST')

@section('app','ng-app="listadoEncuestasSApp"')

@section('controller','ng-controller="listadoEncuestasSostenibilidadCtrl"')

@section('titulo','Encuestas de sostenibilidad - PST')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-encuestaSostenibilidadPST'))
        <a href="/sostenibilidadpst/configuracionencuesta" type="button" class="btn btn-lg btn-success">
          Agregar encuesta
        </a>
    @endif
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>      
</div>
<div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != undefined)">
    <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.id.length > 0 || search.idgrupo.length > 0 || search.lugaraplicacion.length > 0 || search.fechaaplicacion.length > 0 || search.fechallegada.length > 0 || search.username.length > 0 || search.estado.length > 0 || search.ultima.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <thead>
                        <tr>                        
                            <th>Número de encuesta</th>
                            <th>Número RNT</th>
                            <th style="width: 60px;">Proveedor</th>
                            <th>Lugar de aplicación</th>
                            <th>Fecha de aplicación</th>
                            <th>Encuestador</th>
                            <th style="width: 150px;">Estado</th>
                            <th style="width: 110px;">Última sección</th>
                            <th style="width: 70px;">Opciones</th>
                        
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                                
                            <td><input type="text" ng-model="search.id" name="id" id="id" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.rnt" name="rnt" id="rnt" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.nombre" name="nombre" id="nombre" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.lugarEncuesta" name="lugarEncuesta" id="lugarEncuesta" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fechaApicacion" name="fechaApicacion" id="fechaApicacion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.encuestador" name="encuestador" id="encuestador" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estadoEncuesta" name="estadoEncuesta" id="estadoEncuesta" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.numeroSeccion" name="numeroSeccion" id="numeroSeccion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in encuestas|filter:search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.rnt}}</td>
                            <td>@{{item.nombre}}</td>
                            <td>@{{item.lugarEncuesta}}</td>
                            <td>@{{item.fechaApicacion}}</td>
                            <td>@{{item.encuestador}}</td>
                            <td>@{{item.estadoEncuesta}}</td>
                            <td style="text-align: right;">@{{item.numeroSeccion}}</td>
                            <td style="text-align: center;">
                                @if(Auth::user()->contienePermiso('edit-encuestaSostenibilidadPST'))
                                    <a href="/sostenibilidadpst/editarencuesta/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                                @endif
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

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/sostenibilidad_proveedores/listado.js')}}"></script>
<script src="{{asset('/js/administrador/sostenibilidad_proveedores/services.js')}}"></script>
@endsection


