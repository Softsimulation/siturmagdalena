<?php $__env->startSection('title','Muestra maestra'); ?>
<?php $__env->startSection('TitleSection', $periodo->nombre ); ?>
<?php $__env->startSection('app','ng-app="appMuestraMaestra"'); ?>
<?php $__env->startSection('controller','ng-controller="MuestraMaestraCtrl"'); ?>


<?php $__env->startSection('content'); ?>
    
    <input type="hidden" id="periodo" value="<?php echo e(utf8_encode($periodo->id)); ?>" />
    
    
 
        <div class="alert alert-info" ng-show="proveedoresFuera.length>0" >
          <a href="#" class="close" ng-click="proveedoresFuera=[]" >&times;</a>
          <strong>Atención proveedores fuera de la zona.!</strong> 
           Se encontraron los siguientes proveedores fuera de una zona: 
          <span ng-repeat="it in proveedoresFuera track by $index" > {{it}},</span>
        </div>

    
    <div class="row" >
        
        <div class="col-md-3" id="cont-filtros" ng-show="!pantallaCompleta"  >
            <div>
                <h2>
                    <a class="btn" href="/MuestraMaestra/periodos" title="Regresar al listado" >
                       <i class="material-icons">reply</i>
                    </a>  
                    <span title="{{dataPerido.nombre}}" >{{dataPerido.nombre}}</span>
                    <a class="btn" href title="Ocultar menu" ng-click="pantallaCompleta=true" style="float: right;" >
                       <i class="material-icons">arrow_back</i>
                    </a>  
                </h2> 
                
                <br>
                
                <div class="form-group">
                    <div class="checkbox" style="font-size:1.1em;margin-top: 0;">
                       <label><input type="checkbox" ng-model="filtro.verZonas" ng-change="verOcultarZonas()" >Ver zonas</label>
                    </div>
                </div>
                
                <hr style="margin: 3%;">
                
                <b>Proveedores</b>
                <div class="radio">
                  <label>
                    <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="1" checked> Todos
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="2"> Formales
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="3"> Informales
                  </label>
                </div>
                
                <hr style="margin: 3%;">
                
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" ng-model="filtro.busqueda" placeholder="Búsqueda general en proveedores" />
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
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
                                              {{it.tipo_proveedores_con_idiomas[0].nombre}} ({{ getCantidadPorTipo(it.id) }})
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
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse2" >Categoría proveedor</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                           <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox" ng-repeat="it in cateGoriasPRoveedores" >
                                       <label>
                                            <input type="checkbox" checklist-model="filtro.categorias" checklist-value="it.id"  >
                                            {{it.categoria_proveedores_con_idiomas[0].nombre}} ({{getCantidadPorCategoria(it.id)}})
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
                                           {{it.nombre}} ({{getCantidadPorEstado(it.id)}})
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
                                           {{it.destino.destino_con_idiomas[0].nombre +' - '+ it.sectores_con_idiomas[0].nombre}}
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
                            <span>{{$item.nombre}}</span>
                        </ui-select-match>
                        <ui-select-choices repeat="t.id as t in (municipios |filter:$select.search)">
                            <div class="item-ui-select" > 
                                <p>{{t.nombre}} </p>
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
                                            <span>{{$item.destino.destino_con_idiomas[0].nombre +' - '+ $item.sectores_con_idiomas[0].nombre}}</span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (sectores |filter:$select.search)">
                                            <div class="item-ui-select" > 
                                                <p><b>Municipio:</b> {{t.destino.destino_con_idiomas[0].nombre}} </p>
                                                <p><b>Sector:</b> {{t.sectores_con_idiomas[0].nombre}} </p>
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
                                            <span ng-bind="t.codigo" title="{{t.codigo}}"></span>
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
        
        <div class="col-md-9" ng-class="{ 'col-md-12': pantallaCompleta }"  style="padding:0" >
            
            <div class="btn-map" >
                
                <a class="btn btn-default" href title="Ver menu" ng-click="pantallaCompleta=false" style="padding: 0 3px;" ng-show="pantallaCompleta" >
                    <i class="material-icons">arrow_forward</i>
                </a>  
                
                <div class="dropdown">
                      <a class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 3px; margin-left: 5px;" >
                         <i class="material-icons">menu</i>
                      </a>
                      <ul class="dropdown-menu">
                        <li><a href ng-click="verTablaZonas()" ><i class="material-icons">table_chart</i> Ver tabla de zonas</a></li>
                        <li><a href="/MuestraMaestra/excelinfoperiodo/<?php echo e(utf8_encode($periodo->id)); ?>" download ><i class="material-icons">arrow_downward</i> Decargar excel de la muestra</a></li>
                        <li>
                            <a href ng-click="exportarFileKML()" ><i class="material-icons">arrow_downward</i> Exportar KML</a>
                        </li>
                        <li><a href ng-click="openMensajeAddProveedorInformal()" ><i class="material-icons">add_location</i> Agregar proveedor informal</a></li>
                        <li><a href ng-click="openMensajeAddZona()" ng-show="!es_crear_zona" ><i class="material-icons">add</i> Agregar zona</a></li>
                      </ul>
                </div>
                
                <button type="button" id="btn-add" class="btn btn-danger btn-sm" ng-click="cancelarAgregarZonaPRoveedor()" ng-show="es_crear_zona" style="margin-left: 5px;" >
                    Cancelar crear zona
                </button>
                
            </div>
            
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="{{styloMapa}}" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
              
                <marker ng-repeat="pro in proveedores|filter:filtro.busqueda|filter:filterProveedores" position="{{pro.latitud}},{{pro.longitud}}"  id="{{pro.id}}"
                    icon="{{ getIcono(pro.estados_proveedor_id) }}" on-click="showInfoMapa(event,pro,$index)" label="{{pro.razon_social}}"
                    draggable="{{pro.editar}}" on-dragend="ChangedPositionsProveedor()" >     
                </marker>
        
                <shape index="fig-{{$index}}" ng-repeat="item in dataPerido.zonas|filter:filterZonas" fill-color="{{item.color}}" 
                    name="polygon" paths="{{item.coordenadas}}" on-click="showInfoNumeroPS(event, item, proveedores)" 
                    editable="{{item.editar}}" draggable="{{item.editar}}" on-dragend="ChangedPositions()" >
                    
                     <custom-marker position="{{item.coordenadas[0][0]}},{{item.coordenadas[0][1]}}" >
                        
                        <div class="menuZona" >
                            <div class="dropdown">
                              <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                 {{item.nombre}} <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href ng-click="openModalZona(item)" ><i class="material-icons">edit</i> Ver/Editar</a></li>
                                <li><a href ng-click="editarPosicionZona(item,$index)" ><i class="material-icons">edit</i> Editar ubicación</a></li>
                                <li><a href ng-click="eliminarZona(item,$index)" ><i class="material-icons">delete_forever</i> Eliminar</a></li>
                                <li><a href="/MuestraMaestra/excel/{{item.id}}?tipo={{tipoPro.id}}&categoria={{ filtro.categorias.join() }}" download ><i class="material-icons">arrow_downward</i> Generar Excel</a></li>
                                <li><a href="/MuestraMaestra/llenarinfozona/{{item.id}}" ><i class="material-icons">border_color</i> Cargar datos</a></li>
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
                
                <drawing-manager ng-if="es_crear_zona || es_crear_proveedor"
                      on-overlaycomplete="onMapOverlayCompleted()"
                      drawing-control-options="{position: 'TOP_CENTER',drawingModes:['{{figuraCrear}}']}"
                      drawingControl="true" drawingMode="null">
                    </drawing-manager>
                </ng-map>
                
            </ng-map>
            
        </div>
        
    </div>
    
    
    <div id="mySidenav" class="sidenav">
        <div class="cabecera" >
            <h4> Detalles {{ proveedor ? ' del proveedor' : ' de la zona' }} 
                 <a href="javascript:void(0)" class="closebtn" ng-click="closeInfoMapa()">&times;</a>
            </h4>
        </div>
      
        <div class="contenido" ng-show="proveedor" >
            <div class="item-info" >
                <p>Nombre</p>
                <p><b>{{proveedor.razon_social}}</b></>
            </div>
            
            <div class="item-info" >
                <p>RNT</p>
                <p><b>{{proveedor.numero_rnt || 'No disponible'}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Estado</p>
                <p><b>{{proveedor.estadop.nombre || 'No disponible'}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Direción</p>
                <p><b>{{proveedor.direccion}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Tipo de proveedor</p>
                <p><b>{{proveedor.tipoCategoria.tipo}}</b></p>
            </div>
            
            <div class="item-info" >
                <p>Categoria de proveedor</p>
                <p><b>{{proveedor.tipoCategoria.categoria}}</b></p>
            </div>
            
            <button class="btn btn-block btn-success btn-sm" ng-click="openModalZonaProveedores(proveedor)"  ng-if="!proveedor.numero_rnt" >
                <i class="glyphicon glyphicon-pencil"></i> Editar información
            </button>
              
            <button class="btn btn-block btn-primary btn-sm" ng-click="editarPosicionProveedor()" ng-show="!proveedor.editar" >
               <i class="glyphicon glyphicon-map-marker"></i> Cambiar ubicación
            </button>
            
            <br>
            <div class="btn-group" role="group"  ng-show="proveedor.editar" style="width:100%;" >
              <button type="button" class="btn btn-danger" ng-click="cancelarEditarPosicionProveedor()" style="width:50%;">Cancelar</button>
              <button type="button" class="btn btn-success" ng-click="guardarEditarPosicionProveedor()" style="width:50%;">Guardar</button>
            </div>
                
        </div>
        
        <div class="contenido" ng-show="detalleZona" >
            <div class="item-info" >
                <p>Nombre</p>
                <p><b>{{detalleZona.nombre}}</b></>
            </div>
             <div class="item-info" >
                <p>Encargaddos</p>
                <p>
                  <span ng-repeat="it in detalleZona.encargados" > {{it.codigo}}, </span>
                <p/>
            </div>
            <div class="item-info" >
                <p>Número de prestadores: {{detalleZona.total}}</p>
            </div>
            
            <br>
            <h4>Tipos de proveedores</h4>
            <div class="item-info" ng-repeat="it in detalleZona.tiposProveedores" >
                <hr>
                <p>{{it.nombre}}: {{it.cantidad}}</p>
            </div>
            
            <br>
            <h4>Estados de proveedores</h4>
            <div class="item-info" ng-repeat="it in detalleZona.estadosProveedores" >
                <hr>
                <p>{{it.nombre}}: {{it.cantidad}}</p>
            </div>
            
            
                
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
                                <span ng-bind="t.codigo" title="{{t.codigo}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
            </div>
            
            <br>
            
            <div class="row">
                
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.sector.$touched) && form.sector.$error.required}" >
                      <label for="name">Sector:</label>
                      <ui-select ng-model="zona.sector_id" name="sector" id="sector" theme="bootstrap" sortable="true"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione un sector">
                                <span>{{$select.selected.destino.destino_con_idiomas[0].nombre +' - '+ $select.selected.sectores_con_idiomas[0].nombre}}</span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (sectores |filter:$select.search)">
                                <div class="item-ui-select" > 
                                    <p><b>Municipio:</b> {{t.destino.destino_con_idiomas[0].nombre}} </p>
                                    <p><b>Sector:</b> {{t.sectores_con_idiomas[0].nombre}} </p>
                                </div>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                
            </div>
            
            <br>
            
            <div class="row">      
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (form.$submitted || form.color.$touched) && form.color.$error.required}" >
                      <label for="name">Color: {{zona.color}} </label>
                      <input type="color" class="form-control" id="color" name="color" ng-model="zona.color" required >
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" ng-click="cancelarAgregarZonaPRoveedor()">Cancelar</button>
            <button type="submit" class="btn btn-success" ng-click="guardarZona()" >Guardar</button>
          </div>
          
      </form>
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
                  <th>{{$index+1}}</th>
                  <td>{{ (sectores|filter:{id:z.sector_id}:true)[0].sectores_con_idiomas[0].nombre }}</td>
                  <td>{{z.nombre}}</td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.encargados" > {{it.codigo}} </li> 
                      </ul>
                  </td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.estadosProveedores" > {{it.nombre}}: {{it.cantidad}} </li> 
                      </ul>
                      
                      <br>
                      
                      <ul>
                         <li ng-repeat="it in z.tiposProveedores" > {{it.nombre}}: {{it.cantidad}} </li> 
                      </ul>
                  </td>
                  <td>{{z.es_generada ? "Si" : "No"}}</td>
                  <td>
                    <a href="/MuestraMaestra/excel/{{z.id}}?tipo={{tipoPro.id}}&categoria={{ filtro.categorias.join() }}" download >
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
    

    <!-- Modal para gregar proveedores informales -->
<div id="modalAddProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancelarAgregarZona()">&times;</button>
        <h4 class="modal-title">Proveedor informal</h4>
      </div>
      <form name="formP" >
      
          <div class="modal-body">
            
            <div class="row">    
                <div class="col-md-12">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.nombreP.$touched) && formP.nombreP.$error.required}" >
                      <label>Nombre:</label>
                      <input type="text" class="form-control"  name="nombreP" ng-model="proveedorInformal.razon_social" placeholder="Nombre del establecimiento" required >
                    </div>
                </div>
            </div>
            
            <br>
        
            <div class="row">    
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.ditecionP.$touched) && formP.ditecionP.$error.required}" >
                      <label>Dirección:</label>
                      <input type="text" class="form-control"  name="ditecionP" ng-model="proveedorInformal.direccion" placeholder="Direción" required >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.telefono.$touched) && formP.telefono.$error.required}" >
                      <label>Teléfono:</label>
                      <input type="text" class="form-control"  name="telefono" ng-model="proveedorInformal.telefono" placeholder="Número de teléfono" required >
                    </div>
                </div>
            </div>
            
            <br>
            
            <div class="row">    
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.tipoP.$touched) && formP.tipoP.$error.required}">
                        <label class="control-label" for="tipoP">Tipo proveedor</label>
                        <ui-select  ng-model="TipoProveedorInformal.select" name="tipoP" id="tipoP" theme="bootstrap" sortable="true" ng-change="proveedorInformal.categoria_proveedor_id=null"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione un tipo">
                                <span ng-bind="$select.selected.tipo_proveedores_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t as t in (tiposProveedores |filter:$select.search)">
                                <span ng-bind="t.tipo_proveedores_con_idiomas[0].nombre" title="{{t.tipo_proveedores_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.tipoP.$touched) && formP.tipoP.$error.required}">
                        <label class="control-label" for="tipoP">Categoría proveedor</label>
                        <ui-select  ng-model="proveedorInformal.categoria_proveedor_id" name="tipoP" id="tipoP" theme="bootstrap" sortable="true"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione una categoria">
                                <span ng-bind="$select.selected.categoria_proveedores_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (TipoProveedorInformal.select.categoria_proveedores |filter:$select.search)">
                                <span ng-bind="t.categoria_proveedores_con_idiomas[0].nombre" title="{{t.categoria_proveedores_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                
            </div>
            
            <br>
            
            <div class="row">    
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.latitud.$touched) && formP.latitud.$error.required}" >
                      <label>Latitud:</label>
                      <input type="text" class="form-control"  name="latitud" ng-model="proveedorInformal.latitud" required readonly >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.longitud.$touched) && formP.longitud.$error.required}" >
                      <label>Longitud:</label>
                      <input type="text" class="form-control"  name="longitud" ng-model="proveedorInformal.longitud" required readonly >
                    </div>
                </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" ng-click="cancelarAgregarZonaPRoveedor()">Cancelar</button>
            <button type="submit" class="btn btn-success" ng-click="guardarProveedorInformal()" >Guardar</button>
          </div>
          
      </form>
    </div>

  </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('estilos'); ?>
    <style type="text/css">
    
        .alert{
            position: fixed;
            width: 80%;
            bottom: 2%;
            top: initial !important;
            left: 10%;
            box-shadow: 0px 0px 3px 0px rgba(0,0,0,.5);
            z-index: 10;
        }
    
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
            background: #1b5f9d;
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
            margin-top: 10px;
            display: inline-flex;
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
            background: #1b5f9d;
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
<?php $__env->stopSection(); ?>



<?php $__env->startSection('javascript'); ?>
   
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="/js/plugins/geoxml3.js"></script>
    <script src="<?php echo e(utf8_encode(asset('/js/muestraMaestra/servicios.js'))); ?>"></script>
    <script src="<?php echo e(utf8_encode(asset('/js/muestraMaestra/app.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout._MuestraMaestraLayaoutLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>