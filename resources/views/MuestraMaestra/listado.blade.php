@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection','Listado de mediciones')
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="ListarPeriodosCtrl"')

@section('titulo','Muestra maestra')
@section('subtitulo','El siguiente listado cuenta con @{{periodos.length}} registro(s)')

@section('content')
@section('content')
<div class="flex-list">
    <a href="/MuestraMaestra/crearperiodo" type="button" class="btn btn-lg btn-success">
      Agregar periodo
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de periodos</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar periodo...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(periodos | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(periodos | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="periodos.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(periodos | filter:prop.search).length == 0 && periodos.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

    <div class="row">

       <div class="col-xs-12 table-overflow">
        
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr dir-paginate="item in periodos|filter:prop.search |itemsPerPage:10" pagination-id="paginacion_periodos">
                
                <td>@{{item.nombre}}</td>
                <td>@{{item.fecha_inicio}}</td>
                <td>@{{item.fecha_fin}}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-xs btn-default" ng-click="openModalEditPeriodo(item,$index)" title="Editar registro"><span class="glyphicon glyphicon-pencil"></span> <span class="sr-only">Editar</span> </button>
                    <a class="btn btn-xs btn-default" href="/MuestraMaestra/periodo/@{{item.id}}" title="Ver detalles"><span class="glyphicon glyphicon-eye-open"></span> <span class="sr-only">Ver</span> </a>
                </td>
              </tr>
            </tbody>
          </table>
          
        </div>

    </div>
    <div class="row">
      <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="paginacion_periodos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
      </div>
    </div>
    <div class='carga'>

    </div>
    
    
    <!-- Modal agregar periodo -->
    <div class="modal fade" id="modalAgregarPerido" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Periodo de medición</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="form" novalidate>
                    <div class="modal-body">
    
                        <div class="row">
                          
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}">
                                    <label class="control-label" for="pregunta"><span class="asterisk">*</span> Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="periodo.nombre" required />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">    
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.fechaInicio.$touched) && form.fechaInicio.$error.required}">
                                    <label class="control-label" for="fechaInicio"><span class="asterisk">*</span> Fecha inicio</label>
                                    <adm-dtp full-data="date1" maxdate="@{{date2.unix}}" name="fechaInicio" id="fechaInicio" ng-model='periodo.fecha_inicio' options="optionFecha" ng-required="true"></adm-dtp>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.fechaFin.$touched) && form.fechaFin.$error.required}">
                                    <label class="control-label" for="fechaFin"><span class="asterisk">*</span> Fecha fin</label>
                                    <adm-dtp full-data="date2" mindate="@{{date1.unix}}" name="fechaFin" id="fechaFin" ng-model='periodo.fecha_fin' options="optionFecha" ng-required="true"></adm-dtp>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer" >
                        
                        <button type="submit" ng-click="guardarPeriodo()" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   

@endsection

@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
