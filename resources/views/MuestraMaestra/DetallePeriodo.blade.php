
@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection', $periodo->nombre )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="DetalleMuestraMaestraCtrl"')


@section('content')
    
    <input type="hidden" id="periodo" value="{{$periodo->id}}" />
    
    
    
    <div class="row" >
        
        <div class="col-md-3" id="cont-filtros"  >
            <div>
                <h2>
                    <a class="btn" href="/MuestraMaestra/periodos" title="Regresar al listado" >
                       <i class="material-icons">arrow_back</i>
                    </a>  
                    <span title="@{{dataPerido.nombre}}" >@{{dataPerido.nombre}}</span>
                </h2> 
                
                <br>
                
                <div class="form-group">
                    <div class="checkbox" style="font-size:1.3em;">
                       <label><input type="checkbox" ng-model="filtro.verZonas" ng-change="verOcultarZonas()" >Ver zonas</label>
                    </div>
                </div>
                
                <hr>
                
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="filtro.busqueda" placeholder="Busqueda general" />
                </div>
                
                <br>
                
                <div class="panel-group">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse1" >Tipos proveedores</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                           <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox" ng-repeat="it in tiposProveedores" >
                                       <label>  
                                              <input type="checkbox" checklist-model="filtro.tipo" checklist-value="it.id" checklist-change="changeTipoProveedor()" > 
                                              @{{it.tipo_proveedores_con_idiomas[0].nombre}} (@{{ getCantidadPorTipo(it.id) }})
                                        </label>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                
                </div>
                <div class="panel-group">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse2" >Categoria proveedor</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                           <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox" ng-repeat="it in cateGoriasPRoveedores" >
                                       <label>
                                            <input type="checkbox" checklist-model="filtro.categorias" checklist-value="it.id"  >
                                            @{{it.categoria_proveedores_con_idiomas[0].nombre}} (@{{getCantidadPorCategoria(it.id)}})
                                        </label>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                
                </div>
                <div class="panel-group">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse3" >Estado proveedor</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                           <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox" ng-repeat="it in estados" >
                                       <label>
                                           <input type="checkbox" checklist-model="filtro.estados" checklist-value="it.id" > 
                                           @{{it.nombre}} (@{{getCantidadPorEstado(it.id)}})
                                        </label>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                
                </div>
                <div class="panel-group">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse4" >Sectores</a>
                            </h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                           <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox" ng-repeat="it in sectoresZonas" >
                                       <label>
                                           <input type="checkbox" checklist-model="filtro.sectoresProv" checklist-value="it.id" > 
                                           @{{it.destino.destino_con_idiomas[0].nombre +' - '+ it.sectores_con_idiomas[0].nombre}}
                                        </label>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                
                </div>
                
                
                 <div class="form-group" >
                    <label class="control-label" for="sectorF" >Municipios</label>
                    <ui-select multiple ng-model="filtro.municipios" name="sectorF" id="sectorF" theme="bootstrap" sortable="true"  ng-required="true" >
                        <ui-select-match placeholder="Seleccione un municipio">
                            <span>@{{$item.nombre}}</span>
                        </ui-select-match>
                        <ui-select-choices repeat="t.id as t in (municipios |filter:$select.search)">
                            <div class="item-ui-select" > 
                                <p>@{{t.nombre}} </p>
                            </div>
                        </ui-select-choices>
                    </ui-select>
                </div>
                
                <br>
                
                <div class="panel-group">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse5" >Filtrar zonas</a>
                            </h4>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <label class="control-label" for="sectorF" >Municipios - sector</label>
                                    <ui-select multiple ng-model="filtro.sectores" name="sectorF" id="sectorF" theme="bootstrap" sortable="true"  ng-required="true" >
                                        <ui-select-match placeholder="Seleccione un sector o municipio">
                                            <span>@{{$item.destino.destino_con_idiomas[0].nombre +' - '+ $item.sectores_con_idiomas[0].nombre}}</span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (sectores |filter:$select.search)">
                                            <div class="item-ui-select" > 
                                                <p><b>Municipio:</b> @{{t.destino.destino_con_idiomas[0].nombre}} </p>
                                                <p><b>Sector:</b> @{{t.sectores_con_idiomas[0].nombre}} </p>
                                            </div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <br>
                                <div class="form-group" >
                                    <label class="control-label" for="ms" >Encargados</label>
                                    <ui-select multiple ng-model="filtro.encargados" name="ms" id="ms" theme="bootstrap" sortable="true"  ng-required="true" >
                                        <ui-select-match placeholder="Seleccione los municipios">
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
                
                </div>
                
                <button class="btn btn-block btn-danger btn-sm" ng-click="limpiarFiltros()"  >
                    Limpiar todos los filtros
                </button>
                
            </div>
        </div>
        
        <div class="col-md-9" style="padding:0" >
            
            
            <div class="btn-map" >
                <div class="dropdown">
                      <a class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 3px;" >
                         <i class="material-icons">menu</i>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a href ng-click="verTablaZonas()" >Ver tabla de zonas</a></li>
                        <li><a href="/MuestraMaestra/excelinfoperiodo/{{$periodo->id}}" download >Decargar excel de la muestra</a></li>
                        <li><a href ng-click="exportarFileKML()" >Exportar KML</a></li>
                      </ul>
                </div>
            </div>
            
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="@{{styloMapa}}" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
              
                <marker ng-repeat="pro in proveedores|filter:filtro.busqueda|filter:filterProveedores|filter:filterProveedoresSectorMunicipio" position="@{{pro.latitud}},@{{pro.longitud}}"  id="@{{pro.id}}"
                    icon="@{{ getIcono(pro.estados_proveedor_id) }}" on-click="showInfoMapa(event,pro)" label="@{{pro.idiomas[0].nombre}}" >     
                </marker>
        
                <shape index="fig-@{{$index}}" ng-repeat="item in dataPerido.zonas|filter:filterZonas" fill-color="@{{item.color}}" 
                    name="polygon" paths="@{{item.coordenadas}}" on-click="showInfoNumeroPS(event, item, proveedores)" 
                    editable="@{{item.editar}}" draggable="@{{item.editar}}" on-dragend="ChangedPositions()" >
                    
                     <custom-marker position="@{{item.coordenadas[0][0]}},@{{item.coordenadas[0][1]}}" >
                        
                        <div class="menuZona" >
                            <div class="dropdown">
                              <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                 @{{item.nombre}} <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href="/MuestraMaestra/excel/@{{item.id}}?tipo=@{{tipoPro.id}}&categoria=@{{ filtro.categorias.join() }}" download ><i class="material-icons">arrow_downward</i> Generar Excel</a></li>
                                <li><a href="/MuestraMaestra/llenarinfozona/@{{item.id}}" ><i class="material-icons">border_color</i> Cargar datos</a></li>
                              </ul>
                            </div>
                            <button class="btn btn-xs btn-success" type="button" ng-if="item.editar" ng-click="guardarEditarPosicion()" > 
                                 Guardar
                            </button>
                            <button class="btn btn-xs btn-danger" type="button" ng-if="item.editar" ng-click="cancelarEditarPosicion()"> 
                                 Cancelar
                            </button>
                        </div>
                           
                     </custom-marker>
                </shape>
                
            </ng-map>
            
        </div>
        
    </div>
    
    
    <div id="mySidenav" class="sidenav">
        <div class="cabecera" >
            <h4> Detalles @{{ proveedor ? ' del proveedor' : ' de la zona' }} 
                 <a href="javascript:void(0)" class="closebtn" ng-click="closeInfoMapa()">&times;</a>
            </h4>
        </div>
      
      
        <div class="contenido" ng-show="proveedor" >
            <div class="item-info" >
                <p>Nombre</p>
                <p><b>@{{proveedor.razon_social}}</b></>
            </div>
            
            <div class="item-info" >
                <p>RNT</p>
                <p><b>@{{proveedor.numero_rnt}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Estado</p>
                <p><b>@{{proveedor.estadop.nombre}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Direción</p>
                <p><b>@{{proveedor.direccion}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Tipo de proveedor</p>
                <p><b>@{{proveedor.tipoCategoria.tipo}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Categoria de proveedor</p>
                <p><b>@{{proveedor.tipoCategoria.categoria}}</b></p>
            </div>
                
        </div>
        
        <div class="contenido" ng-show="detalleZona" >
            <div class="item-info" >
                <p>Nombre</p>
                <p><b>@{{detalleZona.nombre}}</b></>
            </div>
             <div class="item-info" >
                <p>Encargaddos</p>
                <p>
                  <span ng-repeat="it in detalleZona.encargados" > @{{it.codigo}}, </span>
                <p/>
            </div>
            <div class="item-info" >
                <p>Número de prestadores: @{{detalleZona.total}}</p>
            </div>
            
            <br>
            <h4>Tipos de proveedores</h4>
            <div class="item-info" ng-repeat="it in detalleZona.tiposProveedores" >
                <hr>
                <p>@{{it.nombre}}: @{{it.cantidad}}</p>
            </div>
            
            <br>
            <h4>Estados de proveedores</h4>
            <div class="item-info" ng-repeat="it in detalleZona.estadosProveedores" >
                <hr>
                <p>@{{it.nombre}}: @{{it.cantidad}}</p>
            </div>
            
            
                
        </div>

    </div>
      
    

<!-- Modal para ver la tabla de zonas -->
<div id="modalDetallesZonas" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancelarAgregarZona()">&times;</button>
        <h4 class="modal-title">Zonas</h4>
      </div>
       <div class="modal-body">
            
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>SECTOR</th>
                  <th>BLOQUE</th>
                  <th>ENCARGADOS</th>
                  <th>PRESTADORES (Estado – Categoría)</th>
                  <th>GENERADA</th>
                  <th>PLANILLA</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="z in detalle" >
                  <th>@{{$index+1}}</th>
                  <td>@{{ (sectores|filter:{id:z.sector_id}:true)[0].sectores_con_idiomas[0].nombre }}</td>
                  <td>@{{z.nombre}}</td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.encargados" > @{{it.codigo}} </li> 
                      </ul>
                  </td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.estadosProveedores" > @{{it.nombre}}: @{{it.cantidad}} </li> 
                      </ul>
                      
                      <br>
                      
                      <ul>
                         <li ng-repeat="it in z.tiposProveedores" > @{{it.nombre}}: @{{it.cantidad}} </li> 
                      </ul>
                  </td>
                  <td>@{{z.es_generada ? "Si" : "No"}}</td>
                  <td>
                    <a href="/MuestraMaestra/excel/@{{z.id}}?tipo=@{{tipoPro.id}}&categoria=@{{ filtro.categorias.join() }}" download >
                        Descargar
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            
            
        </div>
        <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
        </div>
    </div>

  </div>
</div>
    

@endsection

@section('estilos')
    <style type="text/css">
        #cont-filtros{
            z-index: 1;
            padding: 0;
        }
        #cont-filtros > div {
            min-height: 700px;
            padding: 10px;
            -webkit-box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
            box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.75);
        }
        #cont-filtros > div > h2{
            margin-top: -10px;
            margin-left: -10px;
            margin-right: -10px;
            background: red;
            padding: 5px;
            font-size: 1.5em;
            font-weight: bold;
            color: white;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        #cont-filtros > div > h2 >a{
            color: white;
            padding: 0;
        }
        #mapa{
            height: 700px;
            width: 100%;
        }
        .menuZona{
            display: inline-flex;
            margin-top: 50px;
        }
        .custom-marker .menuZona button {
            margin-left: 3px; 
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
        .panel-body {
            padding: 10px 5px;
        }
        .item-ui-select{
            border: 1px solid #00000014;
            border-left: none;
            border-right: none;
            padding: 4px 0px;  
        }
        .item-ui-select p{
            margin: 0px;
        }
        
        /* style slider para el detalle del mapa */
        
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 130;
            top: 0;
            left: 0;
            background-color: white;
            border-right: 1px solid #00000061;
            overflow-x: hidden;
            transition: 0.5s;
        }
        
        .sidenav .cabecera{
            background: red;
            height: 40px;
            color: white;
            padding: 2px;
        }
        
        .sidenav .contenido{
            padding: 15px;
        }
        
        .sidenav .contenido .item-info{
            margin-bottom: 10px;
        }
        
        .sidenav .contenido .item-info hr{
            margin: 0px;
        }
        
        .sidenav .contenido .item-info p{
            margin-bottom: 1px;
        }
        
        .sidenav .closebtn {
            float: right;
            font-size: 2em;
            margin-top: -11px;
            color: white;
        }
        
        /*////////////////////////////////////////////*/
        .ui-select-multiple.ui-select-bootstrap input.ui-select-search{ width:100% !important; }
        
    </style>
@endsection



@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
