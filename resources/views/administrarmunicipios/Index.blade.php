
@extends('layout._AdminLayout')

@section('Title', 'Listado de municipios')

@section('app', 'ng-app="municipiosApp"')

@section('controller','ng-controller="municipiosController"')

@section('titulo','Municipios')
@section('subtitulo','El siguiente listado cuenta con @{{municipios.length}} registro(s)')

@section('content')
<div class="flex-list">
    <button type="button" class="btn btn-lg btn-success" ng-click="nuevoMunicipioModal()">
      Agregar municipio
    </button> 
    <button type="button" class="btn btn-lg btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
      Importar CSV
    </button> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de municipios</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar municipio...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(municipios|filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(municipios|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="municipios.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(municipios|filter:prop.search).length == 0 && municipios.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

        <div class="collapse" id="collapseExample">
          <div class="well">
              <div class="alert alert-danger" ng-if="erroresCSV != null">
                    <label><b>Errores:</b></label>
                    <br />
                    <div ng-repeat="error in erroresCSV" ng-if="error.length>0">
                        -@{{error[0]}}
                    </div>
                </div>
                <div class="alert alert-info">
                    <h3 style="margin: .5rem 0;"><strong>Importante</strong></h3>
                    <p>El archivo debe tener solamente las columnas "nombreMunicipio", "nombreDepartamento" y "nombrePais".</p>
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
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Departamento, País</th>
                            <th>Última modificación</th>
                            <th>Usuario</th>
                            <th style="text-align: center;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="municipio in municipios | filter:prop.search | itemsPerPage:10" pagination-id="pagination_municipios" >
                            <td>
                                @{{municipio.id}}
                            </td>
                            <td>
                                @{{municipio.nombre}}
                            </td>
                            
                            <td>
                                @{{imprimirNombre(municipio.departamento_id)}}
                            </td>
                            <td>@{{municipio.updated_at | date:'dd-MM-yyyy'}}</td>
                            <td>@{{municipio.user_update}}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-xs btn-default" ng-click="verMunicipioModal(municipio)">
                                    <span class="glyphicon glyphicon-eye-open" title="Ver municipio"></span><span class="sr-only">Ver municipio</span>
                                </button> 
                                <!--<a ng-repeat="idioma in pais.paises_con_idiomas" ng-click="editarPaisModal(pais, idioma.idioma.id)" title="Editar @{{idioma.idioma.nombre}}" href="javascript:void(0)">-->
                                <!--    @{{idioma.idioma.culture | uppercase}} -->
                                <!--</a>-->
                                <!--<a ng-click="agregarNombre(pais)" href="javascript:void(0)" ng-if="pais.paises_con_idiomas.length != idiomas.length" title="Agregar nombre en otro idioma">-->
                                <!--    <span class="glyphicon glyphicon-plus">-->
                                        
                                <!--    </span>-->
                                <!--</a>-->
                                <button type="button" class="btn btn-xs btn-default" ng-click="editarMunicipioModal(municipio)">
                                    <span class="glyphicon glyphicon-pencil" title="Editar municipio"></span><span class="sr-only">Ver municipio</span>
                                </button> 
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
               
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_municipios"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    
    <div class='carga'>

    </div>

<!-- Modal -->
<div class="modal fade" id="municipiosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
      <form novalidate role="form" name="municipioForm">
          <div class="modal-body">
                <input type="hidden" ng-model="municipio.id" ng-require="">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input ng-disabled="sw == 3" required type="text" name="nombre" class="form-control" placeholder="Nombre del municipio" ng-model="municipio.nombre"/>
                </div>
                <div class="form-group" ng-class="{'error': (municipioForm.$submitted || municipioForm.pais.$touched) && municipioForm.departamento.$error.required }">
                    <label for="departamento">Departamento</label>
                    <ui-select ng-required="true" ng-model="municipio.departamento_id" id="departamento" name="departamento">
                       <ui-select-match placeholder="Nombre del departamento">
                           <span ng-bind="$select.selected.nombre"></span>
                       </ui-select-match>
                       <ui-select-choices repeat="departamento.id as departamento in (departamentos| filter: $select.search)">
                           <span ng-bind="departamento.nombre + ', ' + departamento.paise.paises_con_idiomas[0].nombre" title="@{{departamento.nombre}} @{{departamento.paise.paises_con_idiomas[0].nombre}}"></span>
                       </ui-select-choices> 
                    </ui-select>
                    <!--<select ng-disabled="sw == 3" name="departamento" required ng-model="municipio.departamento_id" ng-options="departamento.id as departamento.nombre + ', ' + departamento.paise.paises_con_idiomas[0].nombre for departamento in departamentos" class="form-control">-->
                    <!--    <option value="">Seleccione un departamento</option>-->
                    <!--</select>-->
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button ng-click="guardarMunicipio()" ng-if="sw != 3" type="submit" class="btn btn-success">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/municipios/municipiosController.js')}}"></script>
<script src="{{asset('/js/administrador/municipios/services.js')}}"></script>
<script src="{{asset('/js/administrador/municipios/app.js')}}"></script>
@endsection