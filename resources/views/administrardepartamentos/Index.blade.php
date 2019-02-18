
@extends('layout._AdminLayout')

@section('Title', 'Listado de departamentos')

@section('app', 'ng-app="departamentosApp"')

@section('controller','ng-controller="departamentosController"')

@section('titulo','Departamentos')
@section('subtitulo','El siguiente listado cuenta con @{{departamentos.length}} registro(s)')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-departamento'))
        <button type="button" class="btn btn-lg btn-success" ng-click="nuevoDepartamentoModal()">
          Agregar departamento
        </button>
    @endif
    @if(Auth::user()->contienePermiso('importar-departamento'))
        <button type="button" class="btn btn-lg btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Importar CSV
        </button> 
    @endif
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de departamento</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar departamento...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(departamentos|filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(departamentos|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="departamentos.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(departamentos|filter:prop.search).length == 0 && departamentos.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

        <div class="collapse" id="collapseExample">
          <div class="well">
              <div class="alert alert-danger row" ng-if="erroresCSV != null">
                    <label><b>Errores:</b></label>
                    <br />
                    <div ng-repeat="error in erroresCSV" ng-if="error.length>0">
                        -@{{error[0]}}
                    </div>
                </div>
                <div class="alert alert-info">
                    <label><b>Importante:</b></label>
                    <p>El archivo debe tener solamente las columnas "nombreDepartamento" y "nombrePais".</p>
                </div>
            <div class="row">
                <form class="form-inline" method="post" novalidate role="form" name="importarCsvForm" class="form-horizontal" enctype="multipart/form-data">
        			<div class="form-group">
        			    <input required type="file" name="import_file" accept=".csv" file-input='import_file' />
        			</div>
        			<button class="btn btn-primary" ng-click="importarCsv()">Importar archivo</button>
        		</form>
            </div>
          </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Departamento</th>
                        <th>Última modificación</th>
                        <th>Usuario</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                    <tr dir-paginate="departamento in departamentos | filter:prop.search | itemsPerPage:10" pagination-id="pagination_departamentos" >
                        <td>
                            @{{departamento.id}}
                        </td>
                        <td>
                            @{{departamento.nombre}}
                        </td>
                        <td>
                            @{{nombreDelPais(departamento.pais_id)}}
                        </td>
                        <td>@{{departamento.updated_at | date:'dd-MM-yyyy'}}</td>
                        <td>@{{departamento.user_update}}</td>
                        <td style="text-align: center;">
                            @if(Auth::user()->contienePermiso('read-departamento'))
                                <button type="button" class="btn btn-xs btn-default" ng-click="verDepartamentoModal(departamento)">
                                    <span class="glyphicon glyphicon-eye-open" title="Ver departamento"></span>
                                    <span class="sr-only">Ver departamento</span>
                                </button>
                            @endif
                            <!--<a ng-repeat="idioma in pais.paises_con_idiomas" ng-click="editarPaisModal(pais, idioma.idioma.id)" title="Editar @{{idioma.idioma.nombre}}" href="javascript:void(0)">-->
                            <!--    @{{idioma.idioma.culture | uppercase}} -->
                            <!--</a>-->
                            <!--<a ng-click="agregarNombre(pais)" href="javascript:void(0)" ng-if="pais.paises_con_idiomas.length != idiomas.length" title="Agregar nombre en otro idioma">-->
                            <!--    <span class="glyphicon glyphicon-plus">-->
                                    
                            <!--    </span>-->
                            <!--</a>-->
                            @if(Auth::user()->contienePermiso('edit-departamento'))
                                <button type="button" class="btn btn-xs btn-default" ng-click="editarDepartamentoModal(departamento)">
                                    <span class="glyphicon glyphicon-pencil" title="Editar departamento"></span>
                                    <span class="sr-only">Editar departamento</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                </table>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_departamentos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    
    <div class='carga'>

    </div>

<!-- Modal -->
<div class="modal fade" id="departamentosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>Errores:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -@{{error[0]}}
            </div>
        </div>
      </div>
      <form novalidate role="form" name="departamentoForm">
          <div class="modal-body">
                <input type="hidden" ng-model="departamento.id" ng-require="">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input ng-disabled="sw == 3" required type="text" name="nombre" class="form-control" placeholder="Nombre del departamento" ng-model="departamento.nombre"/>
                </div>
                <div class="form-group" ng-class="{'error': (departamentoForm.$submitted || departamentoForm.pais.$touched) && departamentoForm.pais.$error.required }">
                    <label for="pais">Departamento</label>
                    <ui-select ng-required="true" ng-model="departamento.pais_id" id="pais" name="pais">
                       <ui-select-match placeholder="Nombre del país">
                           <span ng-bind="$select.selected.paises_con_idiomas[0].nombre"></span>
                       </ui-select-match>
                       <ui-select-choices repeat="pais.id as pais in (paises| filter: $select.search)">
                           <span ng-bind="pais.paises_con_idiomas[0].nombre" title="@{{pais.paises_con_idiomas[0].nombre}}"></span>
                       </ui-select-choices>
                   </ui-select>
                    <!--<select ng-disabled="sw == 3" name="pais" required ng-model="departamento.pais_id" ng-options="pais.id as pais.paises_con_idiomas[0].nombre for pais in paises" class="form-control">-->
                    <!--    <option value="">Seleccione un país</option>-->
                    <!--</select>-->
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button ng-click="guardarDepartamento()" ng-if="sw != 3" type="submit" class="btn btn-success">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class='carga'>

</div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/departamentos/departamentosController.js')}}"></script>
<script src="{{asset('/js/administrador/departamentos/services.js')}}"></script>
<script src="{{asset('/js/administrador/departamentos/app.js')}}"></script>
@endsection