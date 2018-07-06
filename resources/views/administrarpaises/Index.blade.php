
@extends('layout._AdminLayout')

@section('title', 'Listado de países')

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

@section('TitleSection', 'Listado de países')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="paisesApp"')

@section('controller','ng-controller="paisesController"')

@section('content')
<div class="container">
    <h1 class="title1">Lista de países</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-4 col-md-2">
                
            </div>
            
        </div>
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <button type="button" class="btn btn-primary" ng-click="nuevoPaisModal()">
                  Insertar país
                </button>
                <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Importar csv
                </button>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" placeholder="Búsqueda de países (id, nombre, departamento)">
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3" style="text-align: center;">
                <span class="chip">@{{(paises|filter:prop.search).length}} resultados</span>
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
                    El archivo debe tener solamente las columnas "nombreMunicipio", "nombreDepartamento" y "nombrePais".
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
                        <td>@{{pais.updated_at | date:'dd-MM-yyyy'}}</td>
                        <td>@{{pais.user_update}}</td>
                        <td style="text-align: center;">
                            <a href="javascript:void(0)" ng-click="verPaisModal(pais, pais.paises_con_idiomas[0].idioma_id)">
                                <span class="glyphicon glyphicon-eye-open" title="Ver país"></span>
                            </a> 
                            <a ng-repeat="idioma in pais.paises_con_idiomas" ng-click="editarPaisModal(pais, idioma.idioma.id)" title="Editar @{{idioma.idioma.nombre}}" href="javascript:void(0)">
                                @{{idioma.idioma.culture | uppercase}} 
                            </a>
                            <a ng-click="agregarNombre(pais)" href="javascript:void(0)" ng-if="pais.paises_con_idiomas.length != idiomas.length" title="Agregar nombre en otro idioma">
                                <span class="glyphicon glyphicon-plus">
                                    
                                </span>
                            </a>
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning" role="alert" ng-show="paises.length == 0 || (paises|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(paises|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="pagination_paises"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="paisesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
      <form novalidate role="form" name="paisForm">
          <div class="modal-body">
                <input type="hidden" ng-model="pais.id" ng-require="">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input ng-disabled="sw == 3" required type="text" name="nombre" class="form-control" placeholder="Nombre del país" ng-model="pais.nombre"/>
                </div>
                <div class="form-group" ng-class="{'error': ((paisForm.$submitted || paisForm.idioma.$touched) && paisForm.idioma.$error.required) }">
                    <label for="idioma">Idioma</label>
                    <select ng-disabled="sw == 2" name="idioma" required ng-model="pais.idioma" ng-change="verNombre(pais.idioma)" ng-options="idioma.id as idioma.nombre for idioma in idiomas" class="form-control">
                        <option value="">Seleccione un idioma</option>
                    </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button ng-click="guardarPais()" ng-if="sw != 3" type="submit" class="btn btn-primary">Guardar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class='carga'>

</div>
@endsection

@section('javascript')
<script src="{{asset('/js/administrador/paises/paisesController.js')}}"></script>
<script src="{{asset('/js/administrador/paises/services.js')}}"></script>
<script src="{{asset('/js/administrador/paises/app.js')}}"></script>
@endsection