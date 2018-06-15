
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', $periodo->nombre )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="MuestraMaestraCtrl"')


@section('content')
   
    <div class="row"  >
        
        <input type="hidden" id="periodo" value="{{$periodo->id}}" />
        
        <a class="btn btn-primary btn-sm btn-map" href="/MuestraMaestra/periodos" >Volver al listado</a>
        <button type="button" id="btn-add" class="btn btn-success btn-sm btn-map" ng-click="openModalZona(null)" style="margin-top: 45px;" >Agregar zona</button>
  
      <div class="col-md-12">
            
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="[{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ]" map-type-control="false" street-view-control="true" >
              
                <marker ng-repeat="pro in proveedores" id="marker-@{{pro.id}}"  icon="{ url: '@{{pro.icono}}'}"
                      position="@{{pro.latitud}},@{{pro.longitud}}" on-click="map.showInfoWindow('bar@{{pro.id}}')">
                  
                    <info-window id="bar@{{pro.id}}" >
                        <div style="text-align:center" >
                            <h4 class="positive" style="text-align:center" >@{{pro.idiomas[0].nombre}} </h4>
                        </div>
                    </info-window>
                  
                </marker>
              
                <shape ng-repeat="item in dataPerido.zonas" index="@{{$index}}" fill-color="@{{ !item.id ? '#FF0000' : ''}}"
                    name="rectangle" editable="@{{(item.isNuevo || item.isEditar)}}" draggable="@{{(item.isNuevo || item.isEditar)}}"
                    bounds="@{{coordenadasRectangulo(item)}}"
                    on-bounds_changed="boundsChanged()">
            
                     <custom-marker position="@{{item.tex1}},@{{item.tex2}}" >
                        
                        <div>
                            <div class="dropdown">
                              <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                 @{{item.nombre}} <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li ng-if="(item.isNuevo || item.isEditar)" ><a href ng-click="guardarZona(item)" >Guardar</a></li>
                                <li><a href ng-click="openModalZona(item)" >Ver/Editar</a></li>
                                <li><a href ng-click="editarPosicionZona(item)" >Editar posición</a></li>
                                <li><a href="/MuestraMaestra/excel/@{{item.id}}" download >Generar Excel</a></li>
                              </ul>
                            </div>
                        </div>
                           
                     </custom-marker>
                </shape>
                  
            </ng-map>
            
        </div>
      
    </div>
    
    
    <!-- Modal para gregar zona -->
<div id="modalAddZona" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Zona</h4>
      </div>
      <form name="form" >
      
          <div class="modal-body">
            
            <div class="row">    
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}" >
                      <label for="name">Nombre:</label>
                      <input type="text" class="form-control" id="name" name="nombre" ng-model="zona.nombre" required >
                    </div>
                </div>
            </div>
            
            <br>
        
            <div class="row">    
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.encargado.$touched) && form.encargado.$error.required}">
                        <label class="control-label" for="encargado">Encargados</label>
                        <ui-select multiple ng-model="zona.encargados" name="encargado" id="encargado" theme="bootstrap" sortable="true"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione un tipo">
                                <span ng-bind="$item.codigo"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (digitadores |filter:$select.search)">
                                <span ng-bind="t.codigo" title="@{{t.codigo}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" ng-click="agregarZona()" >Guardar</button>
          </div>
          
      </form>
    </div>

  </div>
</div>
    

@endsection

@section('estilos')
    <style type="text/css">
        #mapa{
            height: 700px;
            width: 100%;
        }
        .custom-marker .dropdown {
            bottom: -30px;
            left: 28px; 
        }
        .container, .container .row, .container .col-md-12{
            padding: 0px !important;
            margin:0 !important;
            width: 100% !important;
        }
        .btn-map{
            position: absolute;
            z-index: 100;
            margin: 10px;
        }
        
        #modalAddZona .dropdown-menu {
           left: 0px;
        }
        
    </style>
@endsection



@section('javascript')
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
