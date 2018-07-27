
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', "Crear periodo" )
@section('app','ng-app="appIndicadoresSecundarios"')
@section('controller','ng-controller="EstadisticasSecundariasCtrl"')


@section('content')

<div>
    
   <a type="button" class="btn btn-success" ng-click="OpenModalIndicador()" >Agregar</a> 
   
   <div class="panel-group"  ng-repeat="item in data" >
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse@{{$index}}"> @{{item.nombre}} </a>
        </h4>
      </div>
      <div id="collapse@{{$index}}" class="panel-collapse collapse">
        <div class="panel-body">
                
                <a type="button" class="btn btn-success btn-xs btn-add" ng-click="OpenModalIndicador(item)" >Editar</a>
                <a type="button" class="btn btn-success btn-xs btn-add" ng-click="OpenModal(true,null,item)" >Agregar</a>
                <table class="table table-hover">
                    <thead>
                        <th>Años</th>
                        <th style="width:60px" ></th>
                    </thead>
                    
                    <tbody>
                        
                        <tr ng-repeat="it in item.series[0].valores_tiempo | groupBy: 'anio_id'" >
                            <td>@{{ (anios|filter:{'id':it[0].anio_id} )[0].anio }}</td>
                            <td>
                                <button type="submit" class="btn btn-default btn-xs" ng-click="OpenModal(false,it[0].anio_id,item)" >
                                  Ver/Editar
                                </button>
                            </td>
                        </tr>
                        
                        <tr ng-repeat="it in item.series[0].valores_rotulo | groupBy: 'anio_id'" >
                            <td>@{{ (anios|filter:{'id':it[0].anio_id} )[0].anio }}</td>
                            <td>
                                <button type="submit" class="btn btn-default btn-xs" ng-click="OpenModal(false,it[0].anio_id,item)" >
                                  Ver/Editar
                                </button>
                            </td>
                        </tr>
                        
                        <tr ng-if="item.series[0].valores_tiempo.length==0 && item.series[0].valores_rotulo.length==0" >
                            <td colspan="2" >
                                <div class="alert alert-info" style="margin-bottom:0" >No se encontraron registros almacenados</div>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
        </div>
      </div>
    </div>
  </div>
   
   
    
</div>   

  
<!-- Modal para configurar datos de un indicador -->
<div id="modalConfiData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> @{{indicador.nombre}}  @{{ indicador.yearID ? ' - ' + (anios|filter:{'id':indicador.yearID} )[0].anio  : ''}}  </h4>
      </div>
      <form name="form" >
          
          <div class="modal-body">
            
            <div class="row" ng-if="indicador.es_crear" >
                <div class="col-md-3" >
                    <div class="form-group">
                        <label>Año:</label>
                        <select class="form-control" id="sel2" ng-model="indicador.yearID" ng-options="item.id as item.anio for item in anios" ng-change="changeSelectYear()" >
                        </select>
                    </div>
                </div>
            </div>
            
            <br>
            
            <div class="table-responsive"  ng-if="indicador.rotulos.length>0">
                
                <table class="table table-hover">
                    <thead>
                        <th>Series/Rotulos</th>
                        <th ng-repeat="rotulo in indicador.rotulos" >@{{rotulo.nombre}}</th>
                    </thead>
                    
                    <tbody>
                        <tr ng-repeat="serie in indicador.series" ng-init="serie.valores=[]" >
                            <td>@{{serie.nombre}}</td>
                            <th ng-repeat="rotulo in indicador.rotulos" ng-init="serie.valores[$index] = initValorRotulos(rotulo.id,serie.valores_rotulo) " >
                               <input type="number" class="form-control" ng-model="serie.valores[$index].valor" style="width:70px;" />
                            </th>
                        </tr>
                    </tbody>
                </table>
                
            </div>
            
            <div  class="table-responsive" ng-if="indicador.rotulos.length==0">
                
                <table class="table table-hover">
                    <thead>
                        <th>Series/Rotulos</th>
                        <th ng-repeat="mes in meses" >@{{mes.nombre}}</th>
                    </thead>
                    
                    <tbody>
                        <tr ng-repeat="serie in indicador.series" ng-init="serie.valores=[]" >
                            <td>@{{serie.nombre}}</td>
                            <th ng-repeat="mes in meses" ng-init="serie.valores[$index] = initValorMeses(mes.id,serie.valores_tiempo) " >
                               <input type="number" class="form-control" ng-model="serie.valores[$index].valor" style="width:70px;" />
                            </th>
                        </tr>
                    </tbody>
                </table>
                
            </div>
            
            
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" ng-click="guardarData()" >Guardar</button>
          </div>
      </form>
      
    </div>

  </div>
</div>


<!-- Modal para crear o editar indicador -->
<div id="modalIndicador" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Estadistica secundaria </h4>
      </div>
      <form name="formCrear" >
          
          <div class="modal-body">
            
            <div class="row" >
                <div class="col-md-6 form-group">
                  <label for="nombre">Nombre español:</label>
                  <input type="text" class="form-control" id="nombre" name="nomnbre" ng-model="indicadorCrearEditar.nombre"  >
                </div>
                <div class="col-md-6 form-group">
                  <label for="name">Nombre ingles:</label>
                  <input type="text" class="form-control" id="name" name="name" ng-model="indicadorCrearEditar.name" >
                </div>
            </div>
            
            <hr>
            
            <div class="row" >
                <div class="col-md-12">
                   
                   <div class="panel panel-info">
                      <div class="panel-heading"><b>Series</b> <a type="button" class="btn btn-success btn-xs" ng-click="indicadorCrearEditar.series.push({})"  >Agregar</a></div>
                      <div class="panel-body" style="padding:0" >
                      
                          <table class="table table-hover">
                            <thead>
                                <th>Serie en español</th>
                                <th>Serie en ingles</th>
                                <th></th>
                            </thead>
                            
                            <tbody>
                                
                                <tr ng-repeat="it in indicadorCrearEditar.series" >
                                    <td><input type="text" class="form-control" id="nombre" name="nombre" ng-model="it.nombre" ></td>
                                    <td><input type="text" class="form-control" id="name" name="name" ng-model="it.name" ></td>
                                </tr>
                                
                                <tr ng-if="indicadorCrearEditar.series.length==0" >
                                    <td colspan="3" >
                                        <div class="alert alert-warning " style="margin-bottom:0" >No se encontraron series</div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                      
                      </div>
                    </div>
                   
                </div>
            </div>
            
            <hr>
            
            <div class="row" >
                <div class="col-md-12" >
                    <b>Rotulos: </b>
                    <label class="radio-inline">
                      <input type="radio" id="inlineCheckbox1" value="0" ng-model="incluirRorulos" ng-click="indicadorCrearEditar.rotulos=[]" > Meses
                    </label>
                    <label class="radio-inline">
                      <input type="radio" id="inlineCheckbox2" value="1" ng-model="incluirRorulos" > Personalizado
                    </label>
                </div>
            </div>
            
            <br>
            
            <div ng-show="incluirRorulos==1" class="row" >
                <div class="col-md-12">
                   
                   <div class="panel panel-info">
                      <div class="panel-heading"><b>Rotulos</b> <a type="button" class="btn btn-success btn-xs" ng-click="indicadorCrearEditar.rotulos.push({})"  >Agregar</a></div>
                      <div class="panel-body" style="padding:0" >
                      
                          <table class="table table-hover">
                            <thead>
                                <th>Serie en español</th>
                                <th>Serie en ingles</th>
                                <th></th>
                            </thead>
                            
                            <tbody>
                                
                                <tr ng-repeat="it in indicadorCrearEditar.rotulos" >
                                    <td><input type="text" class="form-control" id="nombre" name="nombre" ng-model="it.nombre" ></td>
                                    <td><input type="text" class="form-control" id="name" name="name" ng-model="it.name" ></td>
                                </tr>
                                
                                <tr ng-if="indicadorCrearEditar.rotulos.length==0" >
                                    <td colspan="3" >
                                        <div class="alert alert-warning " style="margin-bottom:0" >No se encontraron rotulos</div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                      
                      </div>
                    </div>
                   
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success" ng-click="guardarIndicador()" >Guardar</button>
          </div>
      </form>
      
    </div>

  </div>
</div>

  
@endsection

@section('estilos')
    <style type="text/css">
    
       #modalConfiData .modal-dialog{ width: 95%; }
       .btn-add{
           float: right;
           color: white!important;
       }
       .panel-group {
            margin-bottom: 1px;
        }
        .panel-default>.panel-heading {
            background-color: #ffffff;
        }
        .panel-heading .accordion-toggle:after {
            content: "-";
            float: right;
            color: grey; 
        }
        .panel-heading .accordion-toggle.collapsed:after {
            content: "+";
            float: right;
            color: grey; 
        }
                
    </style>
@endsection



@section('javascript')
    <script src="{{asset('/js/estadisticasSecundarias/servicios.js')}}"></script>
    <script src="{{asset('/js/estadisticasSecundarias/app.js')}}"></script>
@endsection
