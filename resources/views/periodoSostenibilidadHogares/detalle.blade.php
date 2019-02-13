@extends('layout._AdminLayout')

@section('Title','Detalle del periodo')

@section('app','ng-app="periodosSostenibilidadHogaresApp"')

@section('controller','ng-controller="verPeriodosSostenibilidadHogaresController"')

@section('titulo','Periodo')
@section('subtitulo','Detalle del periodo')

@section('content')

<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="text-center">
        <a href="/periodoSostenibilidadHogares/listado" class="btn btn-lg btn-default">Volver</a>
        <a href="/sostenibilidadhogares/crear/@{{id}}" class="btn btn-lg btn-success">Crear encuesta</a><br /><br />    
    </div>
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error[0]}}
        </div>
    </div>
    
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="form-group form-group-lang">
                    <label>Nombre</label> <!--<button type="button" class="btn btn-xs btn-link" data-lang="en">Ver en idioma <span class="langToShow">Inglés</span></button>-->
                    <p class="langSelected">@{{periodo.nombre}}</p>
                </div>
                
            </div>

            <div class="col-md-4 col-xs-12 col-sm-12">
                <label>Fecha inicial</label>
                <p>@{{periodo.fecha_inicial | date:'dd/MM/yyyy'}}</p>
            </div>
            
            <div class="col-md-4 col-xs-12 col-sm-12">
                <label>Fecha final</label>
                <p>@{{periodo.fecha_final | date:'dd/MM/yyyy'}}</p>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                <input type="text" style="margin-bottom: .5em;" ng-model="prop.search" class="form-control" id="inputSearch" placeholder="Buscar encuesta...">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                <span class="chip" style="margin-bottom: .5em;">@{{(periodo.encuestas|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 60px;">No. de encuesta</th>
                        <th>Encuestado</th>
                        <th>Dirección</th>
                        <th>Barrio</th>
                        <th>Encuestador</th>
                        <th style="max-width: 130px;">Estado</th>
                        <th style="max-width: 90px;">Última sección</th>
                        <th style="width: 70px;">Opciones</th>
                    </tr>
                    <tr dir-paginate="item in periodo.encuestas|filter:prop.search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                        <td>@{{item.id}}</td>
                        <td>@{{item.nombre_encuestado}}</td>
                        <td>@{{item.direccion}}</td>
                        <td>@{{item.barrio.nombre}}</td>
                        <td>@{{item.digitador.user.nombre}}</td>
                        <td>@{{item.estado.nombre}}</td>
                        <td style="text-align: center;">@{{item.numero_sesion}}</td>
                        <td style="text-align: center;">
                            <a href="/sostenibilidadhogares/editar/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                        </td>
                    </tr>
                </table>
                <div class="alert alert-warning" role="alert" ng-show="periodo.encuestas.length == 0 || (periodo.encuestas|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(periodo.encuestas|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="paginacion_encuestas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>

    </div>

    <div class='carga'>

    </div>

</div>
@endsection
@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/administrador/periodos_sostenibilidad_hogares/main.js')}}"></script>
    <script src="{{asset('/js/administrador/periodos_sostenibilidad_hogares/service.js')}}"></script>
@endsection 