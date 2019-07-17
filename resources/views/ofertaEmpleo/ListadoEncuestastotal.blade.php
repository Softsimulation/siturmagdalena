
@extends('layout._AdminLayout')

@section('title', 'Encuestas oferta y empleo')

@section('estilos')
    <style>
        .dropdown-menu .btn {
            text-align: left;
            padding: .25rem 1.25rem;
            font-weight: 400;
            text-transform: initial;
            color: #333;
            font-size: .875rem;
            box-shadow: none;
        }
        .dropdown-menu .btn:hover {
            box-shadow: none;
        }
        .btn.dropdown-toggle {
            text-transform: initial;
            font-weight: 500;
        }
        #inputGroupFilter .col-xs-12{
            margin-bottom: 1rem;
        }
        #inputGroupFilter .btn{
            font-weight: 500;
        }
    </style>
@endsection

@section('app','ng-app="proveedoresoferta"')

@section('controller','ng-controller="listadoecuestatotal"')

@section('titulo','Encuestas')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')

<div class="flex-list" ng-show="encuestas.length > 0">
    <div class="form-group has-feedback" style="display: inline-block;">
        <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span> Filtrar registros</button>
    </div>      
</div>

<br/>
<div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != undefined && (encuestas | filter:search).length != encuestas.length)">
    <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.id.length > 0 || search.codigo.length > 0 || search.mes.length > 0 || search.anio.length > 0 || search.razon_social.length > 0 || search.tipo.length > 0 || search.categoria.length > 0 || search.estado.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>


<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

<div class="container">
    <div id="inputGroupFilter" class="row" ng-if="encuestas.length > 0 && mostrarFiltro == true">
          <div class="col-xs-12 col-md-6">
              Caracterizaciónz<br>
              <div class="btn-group" role="group" aria-label="Caracterización">
                  <button type="button" class="btn btn-default" ng-class="{'active': search.caracterizacionFiltro == 1}" ng-click="search.caracterizacionFiltro = 1">Realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.caracterizacionFiltro == 2}" ng-click="search.caracterizacionFiltro = 2">No realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.caracterizacionFiltro == undefined}" ng-click="search.caracterizacionFiltro = undefined">Todas</button>
              </div>
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.caracterizacionFiltro" ng-value="1">-->
              <!--  Realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.caracterizacionFiltro" ng-value="2">-->
              <!--  No realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.caracterizacionFiltro" ng-value="">-->
              <!--  Todas-->
              <!--</label>-->
          </div>    
          <div class="col-xs-12 col-md-6">
              Oferta<br>
              <div class="btn-group" role="group" aria-label="Oferta">
                  <button type="button" class="btn btn-default" ng-class="{'active': search.ofertaFiltro == 1}" ng-click="search.ofertaFiltro = 1">Realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.ofertaFiltro == 2}" ng-click="search.ofertaFiltro = 2">No realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.ofertaFiltro == undefined}" ng-click="search.ofertaFiltro = undefined">Todas</button>
              </div>
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.ofertaFiltro" ng-value="1">-->
              <!--  Realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.ofertaFiltro" ng-value="2">-->
              <!--  No realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.ofertaFiltro" ng-value="">-->
              <!--  Todas-->
              <!--</label>-->
          </div>
          <div class="col-xs-12 col-md-6">
              Capacitación<br>
              <div class="btn-group" role="group" aria-label="Capacitación">
                  <button type="button" class="btn btn-default" ng-class="{'active': search.capacitacionFiltro == 1}" ng-click="search.capacitacionFiltro = 1">Realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.capacitacionFiltro == 2}" ng-click="search.capacitacionFiltro = 2">No realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.capacitacionFiltro == undefined}" ng-click="search.capacitacionFiltro = undefined">Todas</button>
              </div>
              
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.capacitacionFiltro" ng-value="1">-->
              <!--  Realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.capacitacionFiltro" ng-value="2">-->
              <!--  No realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.capacitacionFiltro" ng-value="">-->
              <!--  Todas-->
              <!--</label>-->
          </div>
          <div class="col-xs-12 col-md-6">
              Empleo<br>
              <div class="btn-group" role="group" aria-label="Empleo">
                  <button type="button" class="btn btn-default" ng-class="{'active': search.empleoFiltro == 1}" ng-click="search.empleoFiltro = 1">Realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.empleoFiltro == 2}" ng-click="search.empleoFiltro = 2">No realizadas</button>
                  <button type="button" class="btn btn-default" ng-class="{'active': search.empleoFiltro == undefined}" ng-click="search.empleoFiltro = undefined">Todas</button>
              </div>
              
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.empleoFiltro" ng-value="1">-->
              <!--  Realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.empleoFiltro" ng-value="2">-->
              <!--  No realizadas-->
              <!--</label>-->
              <!--<label>-->
              <!--  <input type="radio" ng-model="search.empleoFiltro" ng-value="">-->
              <!--  Todas-->
              <!--</label>-->
          </div>
          
      </div>
       <div class="row">
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                  <thead>
                      
                        <tr>
                            <th>ID</th>
                            <th>Cód.</th>
                            <th>Mes</th>
                            <th>Año</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Sub-Categoría</th>
                            <th>Estado</th>
                            <th style="width: 80px;">Acciones</th>
                        </tr>
                        <tr ng-show="mostrarFiltro == true">
                                    
                            <td><input type="text" ng-model="search.id" name="id" id="id" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.codigo" name="codigo" id="codigo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.mes" name="mes" id="mes" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.anio" name="anio" id="anio" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.razon_social" name="razon_social" id="razon_social" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.tipo" name="tipo" id="tipo" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.categoria" name="categoria" id="categoria" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td><input type="text" ng-model="search.estado" name="estado" id="estado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                            <td></td>
                        </tr>
                    </thead>
                     <tbody>
                        <tr dir-paginate="item in encuestas|filter:search |itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                            <td>@{{item.id}}</td>
                            <td>@{{item.codigo}}</td>
                            <td>@{{item.mes}}</td>
                            <td>@{{item.anio}}</td>
                            <td>@{{item.razon_social}}</td>
                            <td>@{{item.tipo}}</td>
                            <td>@{{item.categoria}}</td>
                            <td>@{{item.estado}}</td>
                            
                            <td>
                                @if(Auth::user()->contienePermiso('edit-encuestaOfertaEmpleo|create-encuestaOfertaEmpleo'))
                                    <div class="dropdown">
                                      <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu@{{item.id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-pencil"></span> Editar encuentas
                                        <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu@{{item.id}}">
                                        <li>
                                            <button class="btn btn-sm btn-block btn-default" ng-if="(item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular' ) || (item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)" ng-click = "caracterizacionEmpleo(item)">Encuesta de caracterización <span ng-show="item.caracterizacion" class="ion-checkmark-round text-success" title="Realizada"></span><span ng-show="!item.caracterizacion" class="ion-help text-muted" title="No realizada"></span></button>
                                        </li>
                                        <li>
                                            <button class="btn btn-sm btn-block btn-default" ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular') && item.actividad ==1 && ((item.mes_id%3 == 0) || (item.tipo_id == 1)) && ((item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4) && item.actividad==1))" ng-click="ofertaEmpleo(item)">Encuesta oferta <span ng-show="item.oferta" class="ion-checkmark-round text-success" title="Realizada"></span><span ng-show="!item.oferta" class="ion-help text-muted" title="No realizada"></span></button>
                                        </li>
                                        <li>
                                            <a href="/ofertaempleo/empleomensual/@{{item.id}}" ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular') && item.actividad == 1 ) && ((item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4) && item.actividad==1)">Encuesta empleo <span ng-show="item.empleo" class="ion-checkmark-round text-success" title="Realizada"></span><span ng-show="!item.empleo" class="ion-help text-muted" title="No realizada"></span></a>
                                        </li>
                                        <li>
                                            <a href="/ofertaempleo/empleadoscaracterizacion/@{{item.id}}" ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular') && item.actividad == 1 ) && ((item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4) && item.actividad==1)">Encuesta empleo de capacitaciones <span ng-show="item.capacitacion" class="ion-checkmark-round text-success" title="Realizada"></span><span ng-show="!item.capacitacion" class="ion-help text-muted" title="No realizada"></span></a>
                                        </li>
                                     
                                      </ul>
                                    </div>
                                @endif
                                <!--<div>-->
                                <!--<button ng-if="(item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular' )" ng-click = "caracterizacionEmpleo(item)" class="btn btn-default btn-sm" title="Editar encuesta caracterizacion" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)"><span class="glyphicon glyphicon-edit"></span></button><p ng-show="item.caracterizacion == true">Realizó</p><p ng-show="item.caracterizacion != true">No realizó</p>-->
                                <!--</div>-->
                                <!--<div ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad ==1 &&((item.mes_id%3 == 0) || (item.tipo_id == 1)) )">-->
                                <!--    <button  ng-click = "ofertaEmpleo(item)" class="btn btn-default btn-sm" title="Editar encuesta oferta" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-edit"></span></button><p   ng-show="item.oferta == true">Realizó</p><p ng-show="item.oferta != true">No realizó</p>-->
                                <!--</div>-->
                                <!--<div ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad == 1 )">-->
                                <!--    <a  href="/ofertaempleo/empleomensual/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta empleo" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-pencil"></span></a>  <p ng-show="item.empleo == true">Realizó</p><p ng-show="item.empleo != true">No realizó</p>-->
                                <!--</div>-->
                                <!--<div ng-if="((item.estado!='Cerrada' || item.estado!='Cerrada Calculada' || item.estado!='Cerrada sin calcular')&& item.actividad == 1 )">-->
                                <!--    <a  href="/ofertaempleo/empleadoscaracterizacion/@{{item.id}}" class="btn btn-default btn-sm" title="Editar encuesta empleo capacitaciones" ng-if="(item.estado_id != 7 || item.estado_id != 8 || item.estado_id != 4)&& item.actividad==1"><span class="glyphicon glyphicon-lock"></span></a><p ng-show="item.capacitacion == true">Realizó</p><p ng-show="item.capacitacion != true">No realizó</p>  -->
                                <!--</div>-->
                                  </br>
                                  <div>
                                    <button   class="btn btn-default btn-sm" title="Historial encuesta" ng-click="historialEncuesta(item)">
                                        <span class="glyphicon glyphicon-list-alt"></span><span class="sr-only">Historial</span>
                                   </button>
                                   <p >Historial</p> 
                                    </div>
                 
                                   <div>
                                    <button ng-click="elimarEncuesta(item)" title="Cambiar estado de visualización" class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-trash"></span>                               
                                            <span class="sr-only">Elminar encuesta</span>
                                    </button>
                                    <p >Eliminar</p>  
                                   </div>
                                
                            </td>
                            
                            
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

<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="modalHistorial">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Historial encuestas </h4>
            </div>
    
                <div class="modal-body">

      
	     <div class="row">
            <div class="col-xs-12 table-overflow">
                <table class="table table-striped">
                    <thead>
                        <tr>
                           
                            <th>Nombre</th>
                            <th>fecha cambio</th>
                            <th>Estado </th>
                       
        
                        </tr>
                
                    </thead>
                    <tbody>
                        <tr dir-paginate="item in historial_encuestas |itemsPerPage:10 as results" pagination-id="paginacion_encuestas_historial" >
                               

                            <td>@{{item.user.nombre}}</td>
                            <td>@{{item.estados_encuesta.nombre}}</td>
                            <td>@{{item.fecha_cambio | date:'dd-MM-yyyy'}}</td>
                   
                          
                        </tr>    
                    </tbody>
                    
                </table>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <dir-pagination-controls pagination-id="paginacion_encuestas_historial"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>
        </div>




                </div>

                <div class="modal-footer text-right">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                   
                    </div>
                </div>

        </div>
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