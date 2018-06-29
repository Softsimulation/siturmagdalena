
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', $periodo->nombre )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="MuestraMaestraCtrl"')


@section('content')
    
    <div class="row" >
         <div class="col-md-3" >
             <div class="form-group">
                <label>Tipo proveedor</label>
                <select class="form-control"  ng-model="tipoPro" ng-options="x as x.tipo_proveedores_con_idiomas[0].nombre for x in tiposProveedores" ng-change="filtro.categorias=[]" >
                  <option value="" selected >Tipo proveedor</option>
                </select>
              </div>
         </div>
         <div class="col-md-5" >
            <div class="form-group">
                
                <div class="form-group">
                    <label>Categoria proveedor</label>
                    <ui-select multiple  ng-model="filtro.categorias" class="form-control"  >
                        <ui-select-match placeholder="Categoria" >@{{$item.categoria_proveedores_con_idiomas[0].nombre}}</ui-select-match>
                        <ui-select-choices repeat="x.id as x in tipoPro.categoria_proveedores | filter: $select.search">
                          <small ng-bind-html="x.categoria_proveedores_con_idiomas[0].nombre | highlight: $select.search"></small>
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
        </div>
        <div style="float:right;">
            <a class="btn btn-primary btn-sm" ng-click="exportarFileKML()" style="margin-right:15px;margin-top:30px;" >Exportar KML</a>
        </div>
    </div>
   
    <br>
   
    <div class="row"  >
        
        <input type="hidden" id="periodo" value="{{$periodo->id}}" />
        
        
        <a class="btn btn-primary btn-sm btn-map" href="/MuestraMaestra/periodos" >Volver al listado</a>
        <button type="button" id="btn-add" class="btn btn-success btn-sm btn-map" ng-click="openMensajeAddZona()" style="margin-top:45px;" >Agregar zona</button>
  
      <div class="col-md-12">
          
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="@{{styloMapa}}" map-type-control="false" street-view-control="false" > 
              
                <marker ng-repeat="pro in proveedores|filter:filterProveedores" position="@{{pro.latitud}},@{{pro.longitud}}"  id="@{{pro.id}}"
                    icon="@{{ getIcono(pro.estados_proveedor_id) }}" on-click="showInfoMapa(event,pro)">
                </marker>
                
                <info-window id="infoProveedor" >
                        <div style="text-align:center" >
                            <h4 class="positive" style="text-align:center" >@{{proveedor.idiomas[0].nombre}} </h4>
                        </div>
                </info-window>
              
                <shape index="fig-@{{$index}}" ng-repeat="item in dataPerido.zonas" fill-color="@{{item.color}}"
                    name="polygon" paths="@{{item.coordenadas}}" on-click="showInfoNumeroPS(event, item, proveedores)" >
                    
                     <custom-marker position="@{{item.coordenadas[0][0]}},@{{item.coordenadas[0][1]}}" >
                        
                        <div>
                            <div class="dropdown">
                              <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                 @{{item.nombre}} <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href ng-click="openModalZona(item)" ><i class="material-icons">border_color</i> Ver/Editar</a></li>
                                <li><a href ng-click="eliminarZona(item,$index)" ><i class="material-icons">delete_forever</i> Eliminar</a></li>
                                <li><a href="/MuestraMaestra/excel/@{{item.id}}?tipo=@{{tipoPro.id}}&categoria=@{{ filtro.categorias.join() }}" download ><i class="material-icons">arrow_downward</i> Generar Excel</a></li>
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
        <button type="button" class="close" data-dismiss="modal" ng-click="cancelarAgregarZona()">&times;</button>
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
            
            <br>
            
            <div class="row">    
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.color.$touched) && form.color.$error.required}" >
                      <label for="name">Color: @{{zona.color}} </label>
                      <input type="color" class="form-control" id="color" name="color" ng-model="zona.color" required >
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" ng-click="cancelarAgregarZona()">Cancelar</button>
            <button type="submit" class="btn btn-primary" ng-click="guardarZona()" >Guardar</button>
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
        
        .gmnoprint > div > div > span {
            padding: 6px 15px !important;
        }
        .dropdown-menu {
            left: inherit !important;
        }        
    </style>
@endsection



@section('javascript')
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
