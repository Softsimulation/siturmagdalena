
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', "Estadísticas secundarias" )
@section('app','ng-app="appIndicadoresSecundarios"')
@section('controller','ng-controller="EstadisticasSecundariasCtrl"')


@section('content')

<div>
    
   <a type="button" class="btn btn-success" ng-click="OpenModalIndicador()" >Agregar nueva estadística</a> 
   
   <br><br>
   
   <div class="panel-group"  ng-repeat="item in data" >
    <div class="panel panel-default" style="padding:0;" >
      <div class="panel-heading">
        <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse@{{$index}}"> @{{item.nombre}} </a>
        </h4>
      </div>
      <div id="collapse@{{$index}}" class="panel-collapse collapse">
        <div class="panel-body">
                
                
                <a type="button" class="btn  btn-xs btn-add" ng-class="{ 'btn-success':!item.es_visible , 'btn-danger':item.es_visible }" ng-click="activarDesactivarIndicador(item)" >
                    @{{ !item.es_visible ? "Visible" : "Ocultar" }}
                </a>
                
                <a type="button" class="btn btn-danger btn-xs btn-add" ng-click="eliminarIndicador(item,$index)" >Eliminar</a>
                <a type="button" class="btn btn-success btn-xs btn-add" ng-click="OpenModalIndicador(item)" >Editar</a>
                <a type="button" class="btn btn-success btn-xs btn-add" ng-click="OpenModal(true,null,item,dataValoresTiempo,dataValoresRotulos)" >Agregar</a>
                <table class="table table-hover">
                    <thead>
                        <th>Años</th>
                        <th style="width:60px" ></th>
                    </thead>
                    
                    <tbody>
                        
                        <tr ng-repeat="it in item.series[0].valores_tiempo | groupBy: 'anio_id' as dataValoresTiempo " >
                            <td>@{{ (anios|filter:{'id':it[0].anio_id} )[0].anio }}</td>
                            <td>
                                <button type="submit" class="btn btn-default btn-xs" ng-click="OpenModal(false,it[0].anio_id,item)" >
                                  Ver/Editar
                                </button>
                            </td>
                        </tr>
                        
                        <tr ng-repeat="it in item.series[0].valores_rotulo | groupBy: 'anio_id' as dataValoresRotulos" >
                            <td>@{{ (anios|filter:{'id':it[0].anio_id} )[0].anio }}</td>
                            <td>
                                <button type="submit" class="btn btn-default btn-xs" ng-click="OpenModal(false,it[0].anio_id,item)" >
                                  Ver/Editar
                                </button>
                            </td>
                        </tr>
                        
                        <tr ng-if="(item.series.length==0) || (item.series[0].valores_tiempo.length==0 && item.series[0].valores_rotulo.length==0)" >
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
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.selctYear.$touched) && form.selctYear.$error.required}" >
                        <label>Año:</label>
                        <select class="form-control" name="selctYear" ng-model="indicador.yearID" ng-options="item.id as item.anio for item in aniosFiltrados" ng-change="changeSelectYear()" required >
                            <option value="" disabled selected>Año</option>
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
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Estadística secundaria </h4>
      </div>
      <form name="formCrear" novalidate >
          
          <div class="modal-body">
            
            <div class="row" >
                <div class="col-md-6 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.nombre.$touched) && formCrear.nombre.$error.required}" >
                  <label for="nombre">Nombre español:</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" ng-model="indicadorCrearEditar.nombre" placeholder="Nombres en español" required  >
                </div>
                <div class="col-md-6 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.name.$touched) && formCrear.name.$error.required}" >
                  <label for="name">Nombre inglés:</label>
                  <input type="text" class="form-control" id="name" name="name" ng-model="indicadorCrearEditar.name" placeholder="Nombres en inglés" required >
                </div>
            </div>
            
            <br>
            
             <div class="row" >
                <div class="col-md-3 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.ejexe.$touched) && formCrear.ejexe.$error.required}" >
                  <label for="ejexe">Label eje X español:</label>
                  <input type="text" class="form-control" id="ejexe" name="ejexe" ng-model="indicadorCrearEditar.label_x" placeholder="Label eje X en español" required  >
                </div>
                <div class="col-md-3 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.ejexi.$touched) && formCrear.ejexi.$error.required}" >
                  <label for="ejexi">Label eje X inglés:</label>
                  <input type="text" class="form-control" id="ejexi" name="ejexi" ng-model="indicadorCrearEditar.label_x_en" placeholder="Label eje X en inglés" required >
                </div>
                
                <div class="col-md-3 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.ejeye.$touched) && formCrear.ejeye.$error.required}"  >
                  <label for="ejeye">Label eje Y español:</label>
                  <input type="text" class="form-control" id="ejeye" name="ejeye" ng-model="indicadorCrearEditar.label_y" placeholder="Label eje Y en español" required >
                </div>
                <div class="col-md-3 form-group" ng-class="{'error' : (formCrear.$submitted || formCrear.ejeyi.$touched) && formCrear.ejeyi.$error.required}" >
                  <label for="ejeyi">Label eje Y inglés:</label>
                  <input type="text" class="form-control" id="ejeyi" name="ejeyi" ng-model="indicadorCrearEditar.label_y_en" placeholder="Label eje Y en inglés" required >
                </div>
            </div>
            
            
            <hr>
            
            <div class="row" >
                                          
                 <div class="col-md-12">
                   
                    <div class="form-group" >
                        <label class="control-label" >Gráficas</label>
                        <div class="input-group">
                          <select class="form-control" ng-model="grafica" ng-change="grafica.pivot.principal=false"  ng-options="x as x.nombre for x in graficas" >
                              <opcion value="" selected >Selecione un tipo</opcion>
                          </select>
                          
                          <div class="input-group-addon checkbox" style="padding-bottom: 1px;padding-top: 8px;" >
                              <label><input type="checkbox" name="principal" ng-model="grafica.pivot.principal" >principal</label>
                          </div>
                          
                          <div class="input-group-btn">
                            <button class="btn btn-success" type="button" ng-click="agregarTipoGrafica()" ng-disabled="!grafica" >
                                 Agregar
                            </button>
                          </div>
                        </div>
                    </div>
                    
                 </div>
             </div>
             
             <ul class="list-group">
                
                <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                  Tipos de graficas
                </li>
                
                <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in indicadorCrearEditar.graficas track by $index" style="cursor:default" >
                    @{{item.nombre}} <span ng-show="item.pivot.principal" >(Es principal)</span>  <span class="badge" style="background: #da534e;" ng-click="indicadorCrearEditar.graficas.splice($index,1);" >X</span>
                </li>
                
                <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="indicadorCrearEditar.graficas.length==0" >
                    0 tipos de graficas agregadas
                </li>
                
                <li class="list-group-item alert-danger" ng-show="formCrear.$submitted && indicadorCrearEditar.graficas.length==0" >
                        Debe seleccionar por lo menos un tipo de grafica.
                </li>
                
            </ul>
            
            <hr>
            
            <div class="row" >
                <div class="col-md-12">
                   
                   <div class="panel panel-info" style="padding: 0;" >
                      <div class="panel-heading"><b>Series</b> <a type="button" class="btn btn-success btn-xs" ng-click="indicadorCrearEditar.series.push({})" style="padding: 1px 12px;font-weight:bold;"  >Agregar</a></div>
                      <div class="panel-body" style="padding:0" >
                      
                            <table class="table table-hover">
                                <thead>
                                    <th>Serie en español</th>
                                    <th>Serie en inglés </th>
                                    <th></th>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr ng-repeat="it in indicadorCrearEditar.series" >
                                        <td ng-class="{'error' : (formCrear.$submitted || formCrear.nombreS@{{$index}}.$touched) && formCrear.nombreS@{{$index}}.$error.required}" >
                                            <input type="text" class="form-control" id="nombreS@{{$index}}" name="nombreS@{{$index}}" ng-model="it.nombre" placeholder="Nombres en español" required >
                                        </td>
                                        <td ng-class="{'error' : (formCrear.$submitted || formCrear.nombreS2@{{$index}}.$touched) && formCrear.nombreS2@{{$index}}.$error.required}" >
                                            <input type="text" class="form-control" id="nombreS2@{{$index}}" name="nombreS2@{{$index}}" ng-model="it.name" placeholder="Nombres en inglés" required >
                                        </td>
                                        <td ng-show="indicadorCrearEditar.es_crear" >
                                            <button class="btn btn-xs btn-danger" ng-click="indicadorCrearEditar.series.splice($index,1);">X</button>
                                        </td>
                                    </tr>
                                    
                                    <tr ng-if="indicadorCrearEditar.series.length==0" >
                                        <td colspan="3" >
                                            <div class="alert-warning " style="margin-bottom:0" >No se encontraron series</div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        
                        <div class="alert-danger" ng-show="formCrear.$submitted && indicadorCrearEditar.series.length==0" >
                            Debe seleccionar por lo menos una serie.
                        </div>
                        
                      </div>
                    </div>
                   
                </div>
            </div>
            
            <hr>
            
            <div class="row" >
                <div class="col-md-12" >
                    <b>Rótulos: </b>
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
                   
                   <div class="panel panel-info" style="padding: 0;" >
                      <div class="panel-heading"><b>Rótulos</b> <a type="button" class="btn btn-success btn-xs" ng-click="indicadorCrearEditar.rotulos.push({})" style="padding: 1px 12px;font-weight:bold;" >Agregar</a></div>
                      <div class="panel-body" style="padding:0" >
                      
                            <table class="table table-hover">
                                <thead>
                                    <th>Rótulo en español</th>
                                    <th>Rótulo en inglés </th>
                                    <th></th>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr ng-repeat="it in indicadorCrearEditar.rotulos" >
                                        <td ng-class="{'error' : (formCrear.$submitted || formCrear.nameR1@{{$index}}.$touched) && formCrear.nameR1@{{$index}}.$error.required}" >
                                            <input type="text" class="form-control" id="nameR1@{{$index}}" name="nameR1@{{$index}}" ng-model="it.nombre" placeholder="Nombres en español" required >
                                        </td>
                                        <td ng-class="{'error' : (formCrear.$submitted || formCrear.nameR2@{{$index}}.$touched) && formCrear.nameR2@{{$index}}.$error.required}" >
                                            <input type="text" class="form-control" id="nameR2@{{$index}}" name="nameR2@{{$index}}" ng-model="it.name" placeholder="Nombres en inglés" required >
                                        </td>
                                        <td ng-show="indicadorCrearEditar.es_crear" >
                                            <button class="btn btn-xs btn-danger" ng-click="indicadorCrearEditar.rotulos.splice($index,1);">X</button>
                                        </td>
                                    </tr>
                                    
                                    <tr ng-if="indicadorCrearEditar.rotulos.length==0" >
                                        <td colspan="3" >
                                            <div class="alert alert-warning " style="margin-bottom:0" >No se encontraron rotulos</div>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                            <div class="alert-danger" ng-show="formCrear.$submitted && indicadorCrearEditar.rotulos.length==0" >
                                Debe seleccionar por lo menos uno rotulo.
                            </div>
                      
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
        .error .form-control{
            border:1px solid red;
        }
                
    </style>
@endsection



@section('javascript')
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/estadisticasSecundarias/servicios.js')}}"></script>
     <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
    <script src="{{asset('/js/estadisticasSecundarias/app.js')}}"></script>
@endsection
