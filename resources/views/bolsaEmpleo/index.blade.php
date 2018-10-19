@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo - Vacantes')

@section('TitleSection', 'Lista de vacantes')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="listarVacantesController"')

@section('estilos')
    <style>
        body{
            overflow: visible;
        }
    </style>
@endsection

@section('content')
    
    <br><br>
    <div class="alert alert-danger" ng-if="errores != null">
        <h6>Errores</h6>
        <span class="messages" ng-repeat="error in errores">
              <span>@{{error}}</span>
        </span>
    </div>
    
    <div class="container">
        <div class="blank-page widget-shadow scroll" id="style-2 div1">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-lg-2 col-md-3">
                    <a href="/bolsaEmpleo/crear" class="btn btn-primary">Crear vacante</a>
                </div>
                
                
                <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                    <input type="text" style="margin-bottom: .5em;" ng-model="prop.search" class="form-control" id="inputSearch" placeholder="Buscar vacante...">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                    <span class="chip" style="margin-bottom: .5em;">@{{(vacantes|filter:prop.search).length}} resultados</span>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Empresa</th>
                            <th>Nombre vacante</th>
                            <th>Municipio</th>
                            <th>Categoria</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        <tr dir-paginate="item in vacantes|filter:prop.search |itemsPerPage:10 as results" pagination-id="paginacion_vacantes" >
                            <td></td>
                            <td>@{{item.proveedores_rnt.razon_social}}</td>
                            <td>@{{item.nombre}}</td>
                            <td>@{{item.municipio.nombre}}</td>
                            <td>@{{item.tipos_cargos_vacante.nombre}}</td>
                            <td ng-if="item.es_publico">Publicado</td><td ng-if="!item.es_publico">NO Publicado</td>
                            <td style="text-align: center;">
                                <a class="btn" title="Publicar" ng-click="cambiarEstadoPublicar(item)" ng-if="!item.es_publico"><span class="glyphicon glyphicon-ok"></span></a>
                                <a class="btn" title="Quitar publicación" ng-click="cambiarEstadoPublicar(item)" ng-if="item.es_publico"><span class="glyphicon glyphicon-remove"></span></a>
                                <a class="btn" title="Activar" ng-click="cambiarEstado(item)" ng-if="!item.estado && item.es_publico"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a class="btn" title="Desactivar" ng-click="cambiarEstado(item)" ng-if="item.estado && item.es_publico"><span class="glyphicon glyphicon-eye-close"></span></a>
                                <a class="btn" href="/bolsaEmpleo/editarvacante/@{{item.id}}" title="Editar vacnte" ><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn" href="/bolsaEmpleo/postulados/@{{item.id}}" title="Postulados" ><span class="glyphicon glyphicon-user"></span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="vacantes.length == 0 || (vacantes|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(vacantes|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
                </div>
                
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_vacantes"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
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