
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
            <div class="flex-list">
                <div class="form-group has-feedback" style="display: inline-block;">
                    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
                </div>      
            </div>
            <br>
            <div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != undefined)">
                <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
            </div>
            <div class="alert alert-info" ng-if="encuestas.length == 0">
                <p>No hay registros almacenados</p>
            </div>
            <div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
                <p>No existen registros que coincidan con su búsqueda</p>
            </div>
            <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.id.length > 0 || search.mes.length > 0 || search.anio.length > 0 || search.estado.length > 0 )">
                Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
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
                        <tr ng-show="mostrarFiltro == true">
                                    
                            <td><input type="text" ng-model="search.id" name="id" id="id" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.mes" name="mes" id="mes" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.anio" name="anio" id="anio" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                     <tbody>
                        <tr dir-paginate="item in encuestas|filter:search|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.mes}}</td>
                            <td>@{{item.anio}}</td>
                            <td>@{{item.estado}}</td>
                             <td><a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad ==1 &&((item.mes_id%3 == 0) || (ruta == '/ofertaempleo/caracterizacion')) )" href="@{{ruta}}/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta oferta" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-edit"></span></a>
                               <a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad == 1 )" href="/ofertaempleo/empleomensual/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta empleo" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-pencil"></span></a>  
                                <a ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad == 1 )" href="/ofertaempleo/empleadoscaracterizacion/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta empleo capacitaciones" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-lock"></span></a>  
                              
                               </td>
                        
                        </tr>
                    </tbody>
                    </table>
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