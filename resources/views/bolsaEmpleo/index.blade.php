@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo - Vacantes')

@section('TitleSection', 'Lista de vacantes')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="listarVacantesController"')

@section('titulo','Bolsa de empleo')
@section('subtitulo','El siguiente listado cuenta con @{{vacantes.length}} registro(s)')

@section('estilos')
    <style>
        body{
            overflow: visible;
        }
    </style>
@endsection

@section('content')
<div class="flex-list">
    <a role="button" class="btn btn-lg btn-success" href="/bolsaEmpleo/crear">
      Crear vacante
    </a>
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de vacante</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar vacante...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(vacantes|filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(vacantes|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="vacantes.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(vacantes|filter:prop.search).length == 0 && vacantes.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

    
    <br><br>
    <div class="alert alert-danger" ng-if="errores != null">
        <h6>Errores</h6>
        <span class="messages" ng-repeat="error in errores">
              <span>@{{error}}</span>
        </span>
    </div>
            
    <div class="row" ng-show="(vacantes|filter:prop.search).length > 0 && vacantes.length > 0">
        <div class="col-xs-12" style="overflow-x: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Nombre vacante</th>
                        <th>Municipio</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th style="width: 120px;">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr dir-paginate="item in vacantes|filter:prop.search |orderBy:'es_publico':true|itemsPerPage:10 as results" pagination-id="paginacion_vacantes" >
                    
                        <td>@{{item.proveedores_rnt.razon_social}}</td>
                        <td>@{{item.nombre}}</td>
                        <td>@{{item.municipio.nombre}}</td>
                        <td>@{{item.tipos_cargos_vacante.nombre}}</td>
                        <td ng-if="item.es_publico">Publicado</td><td ng-if="!item.es_publico">NO Publicado</td>
                        <td>
                            <a class="btn btn-xs btn-default" href="/bolsaEmpleo/editarvacante/@{{item.id}}" title="Editar vacante" ><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="btn btn-xs btn-default" href="/bolsaEmpleo/postulados/@{{item.id}}" title="Postulados" ><span class="glyphicon glyphicon-user"></span></a>
                            <a class="btn btn-xs btn-default" title="Publicar" ng-click="cambiarEstadoPublicar(item)" ng-if="!item.es_publico"><span class="glyphicon glyphicon-ok"></span></a>
                            <a class="btn btn-xs btn-default" title="Quitar publicación" ng-click="cambiarEstadoPublicar(item)" ng-if="item.es_publico"><span class="glyphicon glyphicon-remove"></span></a>
                            <a class="btn btn-xs btn-default" title="Activar" ng-click="cambiarEstado(item)" ng-if="!item.estado && item.es_publico"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a class="btn btn-xs btn-default" title="Desactivar" ng-click="cambiarEstado(item)" ng-if="item.estado && item.es_publico"><span class="glyphicon glyphicon-eye-close"></span></a>
                            
                            
                        </td>
                    </tr>
                </tbody>
                
            </table>
            
        </div>
        
    </div>
    <div class="row">
      <div class="col-xs-12 text-center">
      <dir-pagination-controls pagination-id="paginacion_vacantes"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
      </div>
    </div>
    
    <div class='carga'>
    
    </div> 
    
@endsection

@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/main.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/bolsaEmpleoService.js')}}"></script>
@endsection