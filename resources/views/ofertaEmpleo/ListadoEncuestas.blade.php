
@extends('layout._AdminLayout')

@section('title', 'Encuestas oferta y empleo')

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

@section('TitleSection', 'Listado encuestas oferta y empleo')

@section('app','ng-app="proveedoresoferta"')

@section('controller','ng-controller="listadoecuesta"')

@section('content')

 <input type="hidden" ng-model="id" ng-init="id={{$id}}" />

<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

<div class="container">
       <div class="row">
            <h1 class="title1">Encuestas</h1>
            <br>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                    <input type="text" style="margin-bottom: .5em;" ng-model="prop.searchAntiguo" class="form-control" id="inputSearch" placeholder="Buscar registro...">
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                    <span class="chip" style="margin-bottom: .5em;">@{{(encuestas|filter:prop.searchAntiguo).length}} resultados</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                  <thead>
                        <tr>
                            <th>Id</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Estado</th>
                            <th style="width: 80px;"></th>
                        </tr>
                    </thead>
                     <tbody>
                        <tr dir-paginate="item in encuestas|filter:prop.searchAntiguo|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.mes}}</td>
                            <td>@{{item.anio}}</td>
                            <td>@{{item.estado}}</td>
                            <td><a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad==1 )" href="@{{ruta}}/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-pencil"></span></a></td>   </td>
                           
                        </tr>
                    </tbody>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="encuestas.length == 0 || (encuestas|filter:prop.searchAntiguo).length == 0">No hay resultados disponibles <span ng-show="(encuestas|filter:prop.searchAntiguo).length == 0">para la búsqueda '@{{prop.searchAntiguo}}'. <a href="#" ng-click="prop.searchAntiguo = ''">Presione aquí</a> para ver todos los resultados.</span></div>
                </div>
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_antiguos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
    <div class='carga'>
    </div>
</div>

@endsection


@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/proveedoresapp.js')}}"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/servicesproveedor.js')}}"></script>
        
@endsection