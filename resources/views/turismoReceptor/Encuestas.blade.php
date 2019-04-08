
@extends('layout._AdminLayout')

@section('title', 'Listado de encuestas')

@section('estilos')
<style>
    .table .dropdown-menu{
        left: auto;
        right: 0;
    }
</style>
@endsection

@section('app','ng-app="encuestaListado"')

@section('controller','ng-controller="listadoEncuestas2Ctrl"')

@section('titulo','Encuestas de turísmo receptor')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    @if(Auth::user()->contienePermiso('create-encuestaReceptor'))
        <a href="/turismoreceptor/datosencuestados" type="button" class="btn btn-lg btn-success">
          Agregar encuesta
        </a>
    @ENDIF
    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
</div>
<div class="flex-list">
    <p> Fecha inicial
        <adm-dtp name="fecha_inicial" id="fecha_inicial" ng-model='fecha_inicial'  maxdate="'@{{fecha_final}}'"
                                             options="optionFecha" ng-required="true"></adm-dtp>
    </p>
    <p> Fecha final
        <adm-dtp name="fecha_final" id="fecha_final" ng-model='fecha_final' mindate="'@{{fecha_inicial}}'"
                                             options="optionFecha" ng-required="true"></adm-dtp>
    </p>
    <button type="button" class="btn btn-info" ng-click="buscarEncuestasPorRango()">Buscar</button>
    <button type="button" class="btn btn-info" ng-click="refrescar()">Refrescar</button>
</div>
<div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != undefined)">
    <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.id.length > 0 || search.idgrupo.length > 0 || search.lugaraplicacion.length > 0 || search.fechaaplicacion.length > 0 || search.fechallegada.length > 0 || search.username.length > 0 || search.estado.length > 0 || search.ultima.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>
    
        <div class="row">
            <div class="col-xs-12 table-overflow">
                <table class="table table-striped">
                    <thead>
                        <tr>
                                                  
                            <th>No. de encuesta</th>
                            <th style="width: 60px;">Grupo</th>
                            <th>Lugar de aplicación</th>
                            <th style="width: 90px;">Fecha de aplicación</th>
                            <th style="width: 90px;">Fecha de llegada</th>
                            <th>Encuestador</th>
                            <th style="width: 130px;">Estado</th>
                            <th style="width: 70px;">Última sección</th>
                            <th style="width: 120px;">Opciones</th>
                        
                        </tr>
                        <!--<tr dir-paginate="item in encuestas|filter:{Filtro:filtroEstadoEncuesta}| filter:filtrarCampo | filter:prop.search  |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >-->
                        <tr ng-show="mostrarFiltro == true">
                            
                            <td><input type="text" ng-model="search.id" name="id" id="id" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.idgrupo" name="idgrupo" id="idgrupo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.lugaraplicacion" name="lugaraplicacion" id="lugaraplicacion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fechaaplicacion" name="fechaaplicacion" id="fechaaplicacion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.fechallegada" name="fechallegada" id="fechallegada" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.username" name="username" id="username" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.ultima" name="ultima" id="ultima" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in encuestas| filter:search  |itemsPerPage:10 as results" pagination-id="paginacion_encuestas" >
                        
                            <td>@{{item.id}}</td>
                            <td>@{{item.idgrupo}}</td>
                            <td>@{{item.lugaraplicacion}}</td>
                            <td>@{{item.fechaaplicacion | date:'dd-MM-yyyy'}}</td>
                            <td>@{{item.fechallegada | date:'dd-MM-yyyy'}}</td>
                            <td>@{{item.username}}</td>
                            <td>@{{item.estado}}</td>
                            <td style="text-align: center;">@{{item.ultima}}</td>
                            <td style="text-align: center;">
                                @if(Auth::user()->contienePermiso('edit-encuestaReceptor'))
                                    <div class="dropdown" style="display: inline-block;">
                                      <button  id="dLabel" type="button" class="btn btn-xs btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Ir a la sección de la encuesta">
                                        Ir a
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu" aria-labelledby="dLabel">
                                        <li><a href="/turismoreceptor/seccionestancia/@{{item.id}}">Estancia y visitados</a></li>
                                        <li><a href="/turismoreceptor/secciontransporte/@{{item.id}}">Transporte</a></li>
                                        <li><a href="/turismoreceptor/secciongrupoviaje/@{{item.id}}">Viaje en grupo</a></li>
                                        <li><a href="/turismoreceptor/secciongastos/@{{item.id}}">Gastos</a></li>
                                        <li><a href="/turismoreceptor/seccionpercepcionviaje/@{{item.id}}">Percepcción del viaje</a></li>
                                        <li><a href="/turismoreceptor/seccionfuentesinformacion/@{{item.id}}">Fuentes de información</a></li>
                                      </ul>
                                    </div>
                                    <a class="btn btn-xs btn-default" href="/turismoreceptor/editardatos/@{{item.id}}" title="Editar encuesta" ng-if="item.EstadoId != 7 && item.EstadoId != 8"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                                @endif
                            </td>
                        </tr>    
                    </tbody>
                    
                </table>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <dir-pagination-controls pagination-id="paginacion_encuestas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>
        </div>
    <div class='carga'>

    </div>

@endsection
@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/encuestas/turismoReceptor/listadoEncuestas.js')}}"></script>
<script src="{{asset('/js/encuestas/turismoReceptor/services/receptorServices.js')}}"></script>
@endsection

