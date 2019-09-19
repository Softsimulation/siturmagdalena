
@extends('layout._AdminLayout')

@section('title', 'Listado de países')

@section('TitleSection', 'Listado de países')

@section('app', 'ng-app="paisesApp"')

@section('controller','ng-controller="paisesController"')

@section('titulo','Países')
@section('subtitulo','El siguiente listado cuenta con @{{paises.length}} registro(s)')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-pais'))
        <button type="button" class="btn btn-lg btn-success" ng-click="nuevoPaisModal()">
          Agregar país
        </button>
    @endif
    @if(Auth::user()->contienePermiso('importar-pais'))
        <button type="button" class="btn btn-lg btn-primary" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Importar CSV
        </button>
    @endif
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de países</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar país...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(paises|filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(paises|filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="paises.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(paises|filter:prop.search).length == 0 && paises.length > 0">
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
                <form class="form-inline text-center" method="post" novalidate role="form" name="importarCsvForm" class="form-horizontal" enctype="multipart/form-data">
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
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Idiomas</th>
                        <th>Última modificación</th>
                        <th>Usuario</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                    <tr dir-paginate="pais in paises |filter:prop.search | itemsPerPage:10" pagination-id="pagination_paises" >
                        <td>
                            @{{pais.id}}
                        </td>
                        <td>
                            <p ng-repeat="pais_idioma in pais.paises_con_idiomas">
                                @{{pais_idioma.nombre}}
                            </p>
                        </td>
                        <td>
                            <p ng-repeat="pais_idioma in pais.paises_con_idiomas">
                                @{{pais_idioma.idioma.culture}}
                            </p>
                        </td>
                        <td>@{{pais.updated_at | date:'dd/MM/yyyy'}}</td>
                        <td>@{{pais.user_update}}</td>
                        <td style="text-align: center;">
                            @if(Auth::user()->contienePermiso('read-pais'))
                                <button type="button" class="btn btn-xs btn-default" ng-click="verPaisModal(pais, pais.paises_con_idiomas[0].idioma_id)">
                                    <span class="glyphicon glyphicon-eye-open" title="Ver país"></span><span class="sr-only">Ver detalles</span>
                                </button>
                            @endif
                            @if(Auth::user()->contienePermiso('edit-pais'))
                                <button type="button" class="btn btn-xs btn-default" ng-repeat="idioma in pais.paises_con_idiomas" ng-click="editarPaisModal(pais, idioma.idioma.id)" title="Editar @{{idioma.idioma.nombre}}">
                                    @{{idioma.idioma.culture | uppercase}} 
                                </button>
                                <button type="button" class="btn btn-xs btn-default" ng-click="agregarNombre(pais)" ng-if="pais.paises_con_idiomas.length != idiomas.length" title="Agregar nombre en otro idioma">
                                    <span class="glyphicon glyphicon-plus">
                                        
                                    </span><span class="sr-only">Agregar nombre en otro idioma</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                </table>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_paises"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="paisesModal" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregarPais">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabelAgregarPais">Agregar país</h4>
        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>Errores:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -@{{error[0]}}
            </div>
        </div>
      </div>
      <form novalidate role="form" name="paisForm">
          <div class="modal-body">
                <input type="hidden" ng-model="pais.id" ng-require="">
                <div class="form-group" ng-class="{'has-error': ((paisForm.$submitted || paisForm.nombre.$touched) && paisForm.nombre.$error.required) }">
                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                    <input ng-disabled="sw == 3" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del país" ng-model="pais.nombre"/>
                </div>
                <div class="form-group" ng-class="{'has-error': ((paisForm.$submitted || paisForm.idioma.$touched) && paisForm.idioma.$error.required) }">
                    <label for="idioma"><span class="asterisk">*</span> Idioma</label>
                    <select ng-disabled="sw == 2" name="idioma" required ng-model="pais.idioma" ng-change="verNombre(pais.idioma)" ng-options="idioma.id as idioma.nombre for idioma in idiomas" class="form-control">
                        <option value="" disabled>Seleccione un idioma</option>
                    </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button ng-click="guardarPais()" ng-if="sw != 3" type="submit" class="btn btn-success">Guardar</button>
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
<script src="{{asset('/js/administrador/paises/paisesController.js')}}"></script>
<script src="{{asset('/js/administrador/paises/services.js')}}"></script>
<script src="{{asset('/js/administrador/paises/app.js')}}"></script>
@endsection