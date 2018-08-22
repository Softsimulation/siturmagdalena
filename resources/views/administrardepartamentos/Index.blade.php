
@extends('layout._AdminLayout')

@section('title', 'Listado de departamentos')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de departamentos')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="departamentosApp"')

@section('controller','ng-controller="departamentosController"')

@section('content')
<div class="container">
    <h1 class="title1">Lista de departamentos</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <button type="button" class="btn btn-primary" ng-click="nuevoDepartamentoModal()">
                  Insertar departamento
                </button>
                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Importar csv
                </button>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" placeholder="Búsqueda de grupos de viaje (id, fecha, lugar)">
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3" style="text-align: center;">
                <span class="chip">@{{(departamentos|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <div class="collapse row" id="collapseExample">
          <div class="well">
              <div class="alert alert-danger row" ng-if="erroresCSV != null">
                    <label><b>Errores:</b></label>
                    <br />
                    <div ng-repeat="error in erroresCSV" ng-if="error.length>0">
                        -@{{error[0]}}
                    </div>
                </div>
              <div class="row">
                <div class="alert alert-info">
                    <label><b>Importante:</b></label>
                    <br />
                    El archivo debe tener solamente las columnas "nombreDepartamento" y "nombrePais".
                </div>
            </div>
            <div class="row">
                <form class="form-inline" method="post" novalidate role="form" name="importarCsvForm" class="form-horizontal" enctype="multipart/form-data">
        			<div class="form-group">
        			    <input required type="file" name="import_file" accept=".csv" file-input='import_file' />
        			</div>
        			<button class="btn btn-primary" ng-click="importarCsv()">Import File</button>
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
                        <th>País</th>
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
                            <a href="javascript:void(0)" ng-click="verDepartamentoModal(departamento)">
                                <span class="glyphicon glyphicon-eye-open" title="Ver país"></span>
                            </a> 
                            <!--<a ng-repeat="idioma in pais.paises_con_idiomas" ng-click="editarPaisModal(pais, idioma.idioma.id)" title="Editar @{{idioma.idioma.nombre}}" href="javascript:void(0)">-->
                            <!--    @{{idioma.idioma.culture | uppercase}} -->
                            <!--</a>-->
                            <!--<a ng-click="agregarNombre(pais)" href="javascript:void(0)" ng-if="pais.paises_con_idiomas.length != idiomas.length" title="Agregar nombre en otro idioma">-->
                            <!--    <span class="glyphicon glyphicon-plus">-->
                                    
                            <!--    </span>-->
                            <!--</a>-->
                            <a href="javascript:void(0)" ng-click="editarDepartamentoModal(departamento)">
                                <span class="glyphicon glyphicon-pencil" title="Editar país"></span>
                            </a> 
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning" role="alert" ng-show="departamentos.length == 0 || (departamentos|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(departamentos|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="pagination_departamentos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    </div>
    
    <div class='carga'>

    </div>
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
                    <label for="pais">País</label>
                    <ui-select theme="bootstrap" ng-required="true" ng-model="departamento.pais_id" id="pais" name="pais">
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
            <button ng-click="guardarDepartamento()" ng-if="sw != 3" type="submit" class="btn btn-primary">Guardar</button>
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