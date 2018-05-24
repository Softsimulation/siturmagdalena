
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
        }
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Listado encuestas')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('controller','ng-controller="listadoEncuestasCtrl"')

@section('content')
    

<div class="container">
    <h1 class="title1">Listar encuestas</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-lg-2 col-md-3">
                <a href="/turismoreceptor/datosencuestados" class="btn btn-primary">Crear encuesta</a>
            </div>
            <div class="col-xs-12 col-sm-8 col-lg-2 col-md-3">
                <select class="form-control" ng-model="filtroEstadoEncuesta" ng-init="filtroEstadoEncuesta = ''">
                    <option value="" selected>Todas las encuestas</option>
                    <option value="calculadas">Calculadas</option>
                    <option value="sincalcular">Sin calcular</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                <select class="form-control" ng-model="campoSelected">
                    <option value="" selected>Cualquier campo</option>
                    <option value="fecha">Fecha de aplicación</option>
                    <option value="fechallegada">Fecha de llegada</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                <input type="text" style="margin-bottom: .5em;" ng-model="prop.search" class="form-control" id="inputSearch" placeholder="Buscar encuesta...">
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-2 col-md-12" style="text-align: center;">
                <span class="chip" style="margin-bottom: .5em;">@{{(encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 50px;"></th>                           
                            <th>Número de encuesta</th>
                            <th style="width: 60px;">Grupo</th>
                            <th>Lugar de aplicación</th>
                            <th>Fecha de aplicación</th>
                            <th>Fecha de llegada</th>
                            <th>Encuestador</th>
                            <th style="width: 150px;">Estado</th>
                            <th style="width: 110px;">Última sección</th>
                            <th style="width: 70px;"></th>
                        
                    </tr>
                    <tr dir-paginate="item in encuestas|filter:filtrarEncuesta|filter:filtrarCampo|filter:prop.search |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                        <td>@{{$index+1}}</td>
                            <td>@{{item.id}}</td>
                            <td>@{{item.grupo}}</td>
                            <td>@{{item.lugar}}</td>
                            <td>@{{item.fecha}}</td>
                            <td>@{{item.fechallegada | date:'dd-MM-yyyy'}}</td>
                            <td>@{{item.username}}</td>
                            <td>@{{item.estado}}</td>
                            <td style="text-align: right;">@{{item.ultima}}</td>
                            <td style="text-align: center;"><a href="/turismoreceptor/editardatos/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    </tr>
                </table>
                <div class="alert alert-warning" role="alert" ng-show="encuestas.length == 0 || (encuestas|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(encuestas|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
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


