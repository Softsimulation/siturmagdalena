
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas de sostenibilidad - hogares')

@section('app','ng-app="listadoEncuestasHogarSostenibilidadApp"')

@section('controller','ng-controller="listadoEncuestasSostenibilidadHogarCtrl"')

@section('titulo','Encuestas de sostenibilidad - hogares')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    <a href="/sostenibilidadhogares/crear" type="button" class="btn btn-lg btn-success">
      Agregar encuesta
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de encuestas</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar encuesta...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(encuestas | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(encuestas | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:prop.search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
      
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
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
                    <tr dir-paginate="item in encuestas|filter:prop.search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                        <td>@{{item.id}}</td>
                        <td>@{{item.encuestado}}</td>
                        <td>@{{item.direccion}}</td>
                        <td>@{{item.barrio}}</td>
                        <td>@{{item.encuestador}}</td>
                        <td>@{{item.estado}}</td>
                        <td style="text-align: center;">@{{item.ultimaSeccion}}</td>
                        <td style="text-align: center;">
                            <a href="/sostenibilidadhogares/editar/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                        </td>
                    </tr>
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
<script src="{{asset('/js/encuestas/sostenibilidadHogar/listado.js')}}"></script>
<script src="{{asset('/js/encuestas/sostenibilidadHogar/services.js')}}"></script>
@endsection


