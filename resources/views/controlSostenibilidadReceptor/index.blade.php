@extends('layout._AdminLayout')

@section('title', 'Control Sostenibilidad Receptor')

@section('TitleSection', 'Lista de registros')

@section('app','ng-app="controlSosRecpApp"')

@section('controller','ng-controller="controlSostenibilidadCtrl"')

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
                    <button type="button" ng-click="abrirModalCrear()" class="btn btn-primary">Crear registro</button>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Estado</th>
                            <th>Fecha inicial</th>
                            <th>Fecha final</th>
                            <th></th>
                        </tr>
                        <tr dir-paginate="item in registros |itemsPerPage:10 as results" pagination-id="paginacion_registros" >
                            <td></td>
                            <td ng-if="item.estado">Activo</td><td ng-if="!item.estado">Inactivo</td>
                            <td>@{{item.fecha_inicial}}</td>
                            <td>@{{item.fecha_final}}</td>
                            <td style="text-align: center;">
                                <a class="btn" title="Activar" ng-click="cambiarEstado(item)" ng-if="!item.estado"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a class="btn" title="Desactivar" ng-click="cambiarEstado(item)" ng-if="item.estado"><span class="glyphicon glyphicon-eye-close"></span></a>
                                <a class="btn" title="Editar registro" ng-click="abrirEditar(item)" ><span class="glyphicon glyphicon-pencil"></span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="registros.length == 0">No hay registros ingresados</div>
                </div>
                
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_registros"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
    </div>
    
    <div class='carga'>
    
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Activar sostenibilidad</h4>
          </div>
          
          <form name="crearForm" novalidate>
              <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.fecha_inicial.$touched) && crearForm.fecha_inicial.$error.required}">
                            <label class="control-label" for="fecha_inicial"><span class="asterisk">*</span> Fecha de inicio de activación</label>
                            <adm-dtp name="fecha_inicial" id="fecha_inicial" ng-model='registro.fecha_inicial' mindate="@{{fechaActual}}" maxdate="'@{{registro.fecha_final}}'"
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                             <span class="text-error" ng-show="(crearForm.$submitted || crearForm.fecha_inicial.$touched) && crearForm.fecha_inicial.$error.required">El campo es obligatorio</span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.fecha_final.$touched) && crearForm.fecha_final.$error.required}">
                            <label class="control-label" for="fecha_final"><span class="asterisk">*</span> Fecha final de activación</label>
                            <adm-dtp name="fecha_final" id="fecha_final" ng-model='registro.fecha_final' mindate="'@{{registro.fecha_inicial}}'"
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                             <span class="text-error" ng-show="(crearForm.$submitted || crearForm.fecha_final.$touched) && crearForm.fecha_final.$error.required">El campo es obligatorio</span>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" ng-click="guardar()">Activar sostenibilidad</button>
              </div>
          </form>
          
        </div>
      </div>
    </div>
    
    
    <!-- Modal -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Activar sostenibilidad</h4>
          </div>
          
          <form name="editarForm" novalidate>
              <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group" ng-class="{'has-error':(editarForm.$submitted || editarForm.fecha_inicial.$touched) && editarForm.fecha_inicial.$error.required}">
                            <label class="control-label" for="fecha_inicial"><span class="asterisk">*</span> Fecha de inicio de activación</label>
                            <adm-dtp name="fecha_inicial" id="fecha_inicial" ng-model='registro.fecha_inicial' mindate="@{{fechaActual}}" maxdate="'@{{registro.fecha_final}}'"
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                             <span class="text-error" ng-show="(editarForm.$submitted || editarForm.fecha_inicial.$touched) && editarForm.fecha_inicial.$error.required">El campo es obligatorio</span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <div class="form-group" ng-class="{'has-error':(editarForm.$submitted || editarForm.fecha_final.$touched) && editarForm.fecha_final.$error.required}">
                            <label class="control-label" for="fecha_final"><span class="asterisk">*</span> Fecha final de activación</label>
                            <adm-dtp name="fecha_final" id="fecha_final" ng-model='registro.fecha_final' mindate="'@{{registro.fecha_inicial}}'"
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                             <span class="text-error" ng-show="(editarForm.$submitted || editarForm.fecha_final.$touched) && editarForm.fecha_final.$error.required">El campo es obligatorio</span>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" ng-click="editar()">Editar</button>
              </div>
          </form>
          
        </div>
      </div>
    </div>
    
@endsection

@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/administrador/control_sostenibilidad_receptor/main.js')}}"></script>
    <script src="{{asset('/js/administrador/control_sostenibilidad_receptor/service.js')}}"></script>
@endsection