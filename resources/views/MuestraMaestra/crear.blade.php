
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', "Crear periodo" )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="CrearPeriodoCtrl"')

@section('titulo','Muestra maestra')
@section('subtitulo','Formulario de registro de periodo en muestra maestra')

@section('content')
   
    <input type="hidden" id="periodo" value="{{$ultipoPeriodoID}}" />
   
        <form name="formCrear" novalidate>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.nombre.$touched) && formCrear.nombre.$error.required}">
                        <label class="control-label" for="pregunta"><span class="asterisk">*</span> Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="dataPerido.nombre" required maxlength="255"/>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.fechaInicio.$touched) && formCrear.fechaInicio.$error.required}">
                        <label class="control-label" for="fechaInicio"><span class="asterisk">*</span> Fecha inicio</label>
                        <adm-dtp full-data="date1" maxdate="@{{date2.unix}}" name="fechaInicio" id="fechaInicio" ng-model='dataPerido.fecha_inicio' options="optionFecha" ng-required="true"></adm-dtp>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.fechaFin.$touched) && formCrear.fechaFin.$error.required}">
                        <label class="control-label" for="fechaFin"><span class="asterisk">*</span> Fecha fin</label>
                        <adm-dtp full-data="date2" mindate="@{{date1.unix}}" name="fechaFin" id="fechaFin" ng-model='dataPerido.fecha_fin' options="optionFecha" ng-required="true"></adm-dtp>
                    </div>
                </div>
                <div class="col-md-2">
                    <br>
                   <button type="submit" class="btn btn-block btn-success" ng-click="guardar()" >Guardar</button>
                </div>
            </div>
            
        </form>
    
    <br>
    
    <div class="row"  >                
        
        <div class="col-md-12">
            
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="@{{styloMapa}}" map-type-control="false" street-view-control="false" > 
              
                <marker ng-repeat="pro in proveedores" position="@{{pro.latitud}},@{{pro.longitud}}"  id="@{{pro.id}}"
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
                                <li><a href ng-click="openModalZona(item)" ><span class="glyphicon glyphicon-pencil"></span> Ver/Editar</a></li>
                                <li><a href ng-click="eliminarZona(item.nombre,$index)" ><span class="glyphicon glyphicon-trash"></span>  Eliminar</a></li>
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
                <div class="col-xs-12 col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}" >
                      <label for="name"><span class="asterisk">*</span> Nombre</label>
                      <input type="text" class="form-control" id="name" name="nombre" ng-model="zona.nombre" required >
                    </div>
                </div>
                <div class="col-xs-12 col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.encargado.$touched) && form.encargado.$error.required}">
                        <label class="control-label" for="encargado"><span class="asterisk">*</span> Encargados</label>
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
                <div class="col-xs-12 col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.color.$touched) && form.color.$error.required}" >
                      <label for="name"><span class="asterisk">*</span>  Color: @{{zona.color}} </label>
                      <input type="color" class="form-control" id="color" name="color" ng-model="zona.color" required >
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Cerrar" >Cancelar</button>
            <button type="submit" class="btn btn-success" ng-click="guardarzona()" >Guardar</button>
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
                
    </style>
@endsection



@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
