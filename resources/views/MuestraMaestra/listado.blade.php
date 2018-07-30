@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection','Listado de mediciones')
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="ListarPeriodosCtrl"')

@section('content')

<div>
  
    <a class="btn btn-success" href="/MuestraMaestra/crearperiodo" >+ Agregar</a>

    <div class="row" >

       <div class="col-md-12">
        
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th>Nombre</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in periodos" >
                <td>@{{$index+1}}</td>
                <td>@{{item.nombre}}</td>
                <td>@{{item.fecha_inicio}}</td>
                <td>@{{item.fecha_fin}}</td>
                <td>
                    <a class="btn btn-xs btn-default" ng-click="openModalEditPeriodo(item,$index)" > Editar </a>
                    <a class="btn btn-xs btn-primary" href="/MuestraMaestra/periodo/@{{item.id}}" > Ver </a>
                </td>
              </tr>
            </tbody>
          </table>
          
          <div class="alert alert-info" ng-if="periodos.length==0"  >
              No se encontraron registros almacenados
          </div>
          
        </div>

    </div>
    
    
    
    <!-- Modal agregar periodo -->
    <div class="modal fade" id="modalAgregarPerido" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Periodo de medición</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="form" novalidate>
                    <div class="modal-body">
    
                        <div class="row">
                          
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}">
                                    <label class="control-label" for="pregunta">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="periodo.nombre" required />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group" ng-class="{'error' : (form.$submitted || form.fechaInicio.$touched) && form.fechaInicio.$error.required}">
                                    <label class="control-label" for="fechaInicio">Fecha inicio</label>
                                    <adm-dtp full-data="date1" maxdate="@{{date2.unix}}" name="fechaInicio" id="fechaInicio" ng-model='periodo.fecha_inicio' options="optionFecha" ng-required="true"></adm-dtp>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group" ng-class="{'error' : (form.$submitted || form.fechaFin.$touched) && form.fechaFin.$error.required}">
                                    <label class="control-label" for="fechaFin">Fecha fin</label>
                                    <adm-dtp full-data="date2" mindate="@{{date1.unix}}" name="fechaFin" id="fechaFin" ng-model='periodo.fecha_fin' options="optionFecha" ng-required="true"></adm-dtp>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardarPeriodo()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

</div>
   
    <style type="text/css">
     
       .btn-agregar{
            margin-left: 10px;
            font-size: 1.1em;
            padding: 5px 11px;
            background: #5bb85b;
            border: none;
            border-radius: 35px;
            color: white;
            font-weight: bold;
       }
       .btn-agregar:focus { outline: none; }
       .center{ text-align:center; }
    </style>

@endsection

@section('javascript')
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
