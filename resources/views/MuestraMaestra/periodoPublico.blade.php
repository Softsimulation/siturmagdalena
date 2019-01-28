
@extends('layout._publicLayout')

@section('Title','Muestra maestra')
@section('TitleSection', $periodo->nombre )


@section('estilos')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style type="text/css">
    
        #alertProveedores{
            position: fixed;
            max-width: 80%;
            bottom: 24px;
            border-radius: 2px;
            margin: 0;
            right: 4%;
            box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
            background-color: white;
            z-index: 10;
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
            z-index: 100;
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
        .form-control {
    height: auto;
}
        
        /*////////////////////////////////////////////*/
    .ui-select-multiple.ui-select-bootstrap input.ui-select-search{ width:100% !important; border: 0; }
        .panel-default>.panel-heading a:after {
            content: "-";
            position: absolute;
            right: .75rem;
            color: #ddd;
        }
        .panel-default>.panel-heading a.collapsed:after{
            content: "+";    
        }
        
        .panel-default>.panel-heading a {
            padding: .5rem;
            padding-right: 1.5rem;
            display: block;
            position: relative;
        }
        .panel-default>.panel-heading{
            padding: 0;
        }
        .dropdown-menu .material-icons {
            font-size: 1rem;
        }
        /*.custom-marker .menuZona button:hover, .custom-marker .menuZona button:focus {*/
        /*    opacity: 1;*/
        /*}*/
        /*.custom-marker .menuZona button {*/
        /*    margin-left: 3px;*/
        /*    border: 0;*/
        /*    opacity: .5;*/
        /*}*/
        .panel-title{
            font-size:1rem;
            color:#333;
        }
        header, .title-section{
            display:none;
        }
        #contentPage{
            width: 100%;
            position: relative;
        }
        #cont-filtros, #contentMap{
            display: block;
            width: 100%;
        }
        #cont-filtros{
            z-index: 1;
            background-color: white;
            padding: .5rem;
            -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            -moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
            overflow-x: hidden;
        }
        #cont-filtros > h2{
            margin: 0;
            text-align: center;
            margin-left: -10px;
            margin-right: -10px;
            margin-bottom: 1rem;
            background: #eee;
            padding: 5px;
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        #cont-filtros > h2 >a{
            color: white;
            padding: 0;
        }
        #logoSitur{
            height: 90px;
            margin: 0 auto;
        }
        #tituloMuestraMaestra{
            font-size: 1.286rem;
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            margin: .5rem 0;
            color: #616161;
        }
        #filtros-buttons{
            position:absolute;
            left: 0;
            top: 4%;
            z-index: 20;
            background-color: white;
            display: flex;
            flex-direction: column;
            border-top-right-radius: 2px;
            border-bottom-right-radius: 2px;
            box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 4px -1px;
        }
        #filtros-buttons .btn:not(.btn-danger){
            background-color: white;
        }
        #filtros-buttons .material-icons {
            font-size: 1rem;
            color: #616161;
        }
        #mapa{
            height: 100%!important;
        }
        .list-details{
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .list-details li{
            padding: .5rem 0;
        }
        .list-details li:not(:last-child){
            border-bottom: 1px solid #eee;
        }
        .form-group{
            margin-bottom: .5rem;
        }
        #filtrosProveedor .form-control {
            border-radius: 0;
            box-shadow: none;
            border-left: 0;
            border-right: 0;
            border-color: #eee;
        }
        #filtrosProveedor, #filtrosZonas {
            background-color: white;
            border-radius: 2px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            padding-top: 5px;
        }
        .panel-group .panel+.panel {
            margin-top: 0;
            border-radius: 0;
        }
        .panel{
            border: 0;
        }
        .panel-group .panel-default>.panel-heading {
            background-color: white;
        }
        .panel-group .panel-default:not(:last-child)>.panel-heading {
            border-bottom: 1px solid #eee;
            
        }
        #filtrosProveedor .form-control::placeholder, #filtrosProveedor input::placeholder {
            color: #d1d1d1;
            font-size: 15px;
        }
        @media only screen and (min-width: 768px) {
         
            #contentMap{
                position: fixed;
                width: calc(100% - 350px);
                margin-left: 350px;
                height: 100%;
            }
            #contentMap.showed{
                width: 100%;
                margin-left: 0;
            }
            #cont-filtros{
                position:fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 350px;
            }
        }
        
        .activo{
            background: #00954129;
            color: black;
        }
        
        #mySidenav .control-label{
            margin-bottom: 0px;
        }
        #mySidenav .form-control-static{
            padding-top: 0px;
        }
        #mySidenav .form-group {
            margin-bottom: 8px;
        }
        #mySidenav .checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline{ margin-left: -2px; }
        
        .list-details li {
            padding: .3rem 0;
        }
        .filtros_tabla_bloques td{ padding: 5px 25px !important; }
        #logos, footer{
            display:none;
        }
    </style>
@endsection

@section('content')
    
<div ng-app="appMuestraMaestra" ng-controller="MuestraMaestraCtrl" >
        
   
    <input type="hidden" id="periodo" value="{{$periodo->id}}" />
    
    <div id="contentPage">
        <div id="cont-filtros" ng-show="!pantallaCompleta">
            <img id="logoSitur" src="{{asset('Content/image/logo.min.png')}}" alt="Logo SITUR Magdalena" class="img-responsive"/>
            <h1 id="tituloMuestraMaestra">Muestra maestra</h1>
            <h2>
                {{$periodo->nombre}}  
            </h2> 
            
            <div id="filtrosProveedor">
                <div style="margin-bottom: .5rem;">
                    <label class="control-label" style="margin-left: 5px;" >Prestadores</label><br/>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="1" checked ng-change="filterProveedores()" > Todos<span style="font-size: 9px;">(@{{TotalFormales+TotalInformales}})</span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="2" ng-change="filterProveedores()" > Formales<span style="font-size: 9px;">(@{{TotalFormales}})</span>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadios" ng-model="filtro.tipoProveedores" value="3" ng-change="filterProveedores()" ng-click="filtro.estados=[]" > Informales<span style="font-size: 9px;">(@{{TotalInformales}})</span>
                    </label> 
                </div>
                <br>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  
                  <div class="panel panel-default" ng-show="tiposProveedores.length > 0">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                          Categoría de prestadores
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                            <div class="checkbox" ng-repeat="it in tiposProveedores" >
                               <label>  
                                      <input type="checkbox" checklist-model="filtro.tipo" checklist-value="it.id" checklist-change="changeTipoProveedor();filterProveedores();" > 
                                      @{{it.tipo_proveedores_con_idiomas[0].nombre}} 
                                      <p style="font-size: 11px;" > 
                                        <span ng-if="filtro.tipoProveedores==1" > 
                                         <b>Total: </b> @{{it.cantidad.formales + it.cantidad.informales}}, <b>Formales: </b> @{{it.cantidad.formales}}, <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==2" > 
                                         <b>Formales: </b> @{{it.cantidad.formales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==3" > 
                                         <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                      </p>
                                </label>
                            </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="panel panel-default" ng-show="cateGoriasPRoveedores.length > 0">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Subcategoría de prestadores
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                            <div class="checkbox" ng-repeat="it in cateGoriasPRoveedores" >
                               <label>
                                    <input type="checkbox" checklist-model="filtro.categorias" checklist-value="it.id" checklist-change="filterProveedores();"  >
                                    @{{it.categoria_proveedores_con_idiomas[0].nombre}}
                                    <p style="font-size: 11px;" > 
                                        <span ng-if="filtro.tipoProveedores==1" > 
                                         <b>Total: </b> @{{it.cantidad.formales + it.cantidad.informales}}, <b>Formales: </b> @{{it.cantidad.formales}}, <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==2" > 
                                         <b>Formales: </b> @{{it.cantidad.formales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==3" > 
                                         <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                    </p>
                                </label>
                            </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="panel panel-default" ng-show="estados.length > 0">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Estado del proveedor
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                            <div class="checkbox" ng-repeat="it in estados" >
                               <label>
                                   <input type="checkbox" checklist-model="filtro.estados" checklist-value="it.id" checklist-change="filterProveedores();" > 
                                   @{{it.nombre}} (@{{it.cantidad}})
                                </label>
                            </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="panel panel-default" ng-show="sectoresZonas.length > 0">
                    <div class="panel-heading" role="tab" id="headingFour">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                          Sectores
                        </a>
                      </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <div class="checkbox" ng-repeat="it in sectoresZonas" >
                               <label>
                                   <input type="checkbox" checklist-model="filtro.sectoresProv" checklist-value="it.id" checklist-change="filterProveedores();" > 
                                       @{{it.destino.destino_con_idiomas[0].nombre +' - '+ it.sectores_con_idiomas[0].nombre}}
                                       <p style="font-size: 11px;" > 
                                            <span ng-if="filtro.tipoProveedores==1" > 
                                             <b>Total: </b> @{{it.cantidad.formales + it.cantidad.informales}}, <b>Formales: </b> @{{it.cantidad.formales}}, <b>Informales: </b> @{{it.cantidad.informales}}
                                            </span>
                                            <span ng-if="filtro.tipoProveedores==2" > 
                                             <b>Formales: </b> @{{it.cantidad.formales}}
                                            </span>
                                            <span ng-if="filtro.tipoProveedores==3" > 
                                             <b>Informales: </b> @{{it.cantidad.informales}}
                                            </span>
                                       </p>
                                </label>
                            </div>
                        </div>
                            
                    </div>
                  </div>
                  
                  <div class="panel panel-default" ng-show="estados.length > 0">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseMunicipios" aria-expanded="false" aria-controls="collapseMunicipios">
                           Municipios
                        </a>
                      </h4>
                    </div>
                    <div id="collapseMunicipios" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                            <div class="checkbox" ng-repeat="it in municipios" >
                               <label>
                                   <input type="checkbox" checklist-model="filtro.municipios" checklist-value="it.id" checklist-change="filterProveedores();" > 
                                   @{{it.nombre}} 
                                   <p style="font-size: 11px;" > 
                                        <span ng-if="filtro.tipoProveedores==1" > 
                                         <b>Total: </b> @{{it.cantidad.formales + it.cantidad.informales}}, <b>Formales: </b> @{{it.cantidad.formales}}, <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==2" > 
                                         <b>Formales: </b> @{{it.cantidad.formales}}
                                        </span>
                                        <span ng-if="filtro.tipoProveedores==3" > 
                                         <b>Informales: </b> @{{it.cantidad.informales}}
                                        </span>
                                   </p>
                                </label>
                            </div>
                      </div>
                    </div>
                </div>
                  
                  
                </div>
                
            </div>
            
            <hr style="margin: 4%;">
            
            <button class="btn btn-block btn-danger btn-sm" ng-click="limpiarFiltros()"  >
                Limpiar todos los filtros
            </button>
            
        </div>
        <div id="contentMap" ng-class="{ 'showed': pantallaCompleta }">
            <div id="filtros-buttons">
                <a class="btn" href="/" title="Regresar a la página inicial" >
                   <i class="material-icons">home</i>
                </a>  
                <button type="button" class="btn" title="Ocultar menu" ng-click="pantallaCompleta=true" ng-show="!pantallaCompleta">
                   <i class="material-icons">arrow_back</i>
                </button>  
                <button type="button" class="btn" title="Ver menu" ng-click="pantallaCompleta=false" ng-show="pantallaCompleta" >
                    <i class="material-icons">arrow_forward</i>
                </button>  
            </div>
            <ng-map id="mapa" zoom="9" center="@{{centro}}" styles="@{{styloMapa}}" map-type-control="false" street-view-control="true" street-view-control-options="{position: 'RIGHT_BOTTOM'}"  > 
            </ng-map>
        </div>
            
    </div>
    
    
    <div id="mySidenav" class="sidenav">
        <div class="cabecera" >
            <h4> Detalles del @{{ proveedor ? ' prestador' : ' bloque' }} 
                 <a href="javascript:void(0)" class="closebtn" ng-click="closeInfoMapa()">&times;</a>
            </h4>
        </div>
      
        <div class="contenido" ng-show="proveedor" >
            <div class="form-group">
                <label class="control-label">Nombre</label>
                <p class="form-control-static">@{{proveedor.nombre}}</p>
            </div>
            <div class="form-group">
                <label class="control-label">RNT</label>
                <p class="form-control-static">@{{proveedor.rnt || 'No tiene'}}</p>
            </div>
            <div class="form-group">
                <label class="control-label">Estado</label>
                <p class="form-control-static">@{{proveedor.estado || 'No tiene'}}</p>
            </div>
            <div class="form-group">
                <label class="control-label">Dirección</label>
                <p class="form-control-static">@{{proveedor.direccion}}</p>
            </div>
            <div class="form-group">
                <label class="control-label">Categoría</label>
                <p class="form-control-static">@{{proveedor.categoria}}</p>
            </div>
            <div class="form-group">
                <label class="control-label">Subcategoría</label>
                <p class="form-control-static">@{{proveedor.subcategoria}}</p>
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
                <p><b>@{{detalleZona.nombre}}</b></>
            </div>
             <div class="item-info" >
                <p>Encargaddos</p>
                <p>
                  <span ng-repeat="it in detalleZona.encargados" > @{{it.codigo}}, </span>
                <p/>
            </div>
            <div class="item-info" >
                <p>Número de prestadores: @{{detalleZona.numeroPrestadoresFormales+detalleZona.numeroPrestadoresInformales}}</p>
                <p style="font-size: 11px;margin: 0;" >Formales: @{{detalleZona.numeroPrestadoresFormales}}, Informales: @{{detalleZona.numeroPrestadoresInformales}} </p>
            </div>
            
            <br>
            <h4>Categoría</h4>
            <ul class="list-details">
                <li ng-repeat="it in detalleZona.tiposProveedores">
                    @{{it.nombre}} 
                    <p style="font-size: 11px;margin: 0;" >Formales: @{{it.cantidad[0]}}, Informales: @{{it.cantidad[1]}} </p>
                </li>
            </ul>
            
            <br>
            <h4>Estados de los prestadores</h4>
            <ul class="list-details">
                <li ng-repeat="it in detalleZona.estadosProveedores">@{{it.nombre}}: @{{it.cantidad}}</li>
            </ul>
            
            
            
                
        </div>

    </div>
      
    
    <!-- Modal para ver la tabla de zonas -->
    <div id="modalDetallesZonas" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg" style="width: 95%;" >
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="cancelarAgregarZona()">&times;</button>
            <h4 class="modal-title">Bloques</h4>
          </div>
           <div class="modal-body">
                
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Detalles</th>
                      <th>PRESTADORES (Categoría - Estado)</th>
                      <th style="width:200px;" >PLANILLA</th>
                      <th style="width:200px;" >TABULACIÓN</th>
                    </tr>
                    <tr class="filtros_tabla_bloques" >
                        <td colspan="2" >
                            <input type="text" class="form-control" ng-model="busquedaZonas" placeholder="Busqueda por nombre, sector y Encargado."  />
                        </td>
                        <td>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.planillada"  name="optradio1">Todas</label>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.planillada" value="true" name="optradio1">Si</label>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.planillada" value="false" name="optradio1">No</label>
                        </td>
                        <td>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.tabulada" name="optradio2">Todas</label>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.tabulada" value="true" name="optradio2">Si</label>
                            <label class="radio-inline"><input type="radio" ng-model="filterTabla.tabulada" value="false" name="optradio2">No</label>
                        </td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="z in detalle|filter:busquedaZonas|filter:{ 'es_generada':filterTabla.planillada, 'es_tabulada':filterTabla.tabulada } " >
                      <td>
                          <p>  <b>BLOQUE:</b> @{{z.nombre}} </p>
                          <p>  <b>SECTOR:</b> @{{(sectores|filter:{id:z.sector_id}:true)[0].sectores_con_idiomas[0].nombre}} </p>
                          <p>  
                                <b>ENCARGADOS:</b> 
                                <ul>
                                    <li ng-repeat="it in z.encargados" > @{{it.codigo}} </li> 
                                </ul>
                          </p>
                      </td>
                      <td>
                          
                          <div class="row" >
                              <div class="col-md-6" >
                                  <ul>
                                     <li style="list-style: none;" ><b>Categorías</b></li>
                                     <li ng-repeat="it in z.tiposProveedores" > 
                                        @{{it.nombre}}: @{{it.cantidad[0]+it.cantidad[1]}}
                                        <p style="font-size:11px" >Formales:@{{it.cantidad[0]}}, informales:@{{it.cantidad[1]}}</p> 
                                     </li> 
                                  </ul>
                              </div>
                              <div class="col-md-6" >
                                    <ul>
                                        <li style="list-style: none;" ><b>Estados</b></li>
                                        <li ng-repeat="it in z.estadosProveedores" > @{{it.nombre}}: @{{it.cantidad}} </li> 
                                    </ul>
                              </div>
                          </div>
                          
                      </td>
                      <td>
                            <p>  <b>GENERADA:</b> @{{z.es_generada ? "Si" : "No"}} </p>
                            <a href  ng-click="exportarFileExcelZona(z)" >
                                Descargar
                            </a>
                      </td>
                      <td>
                            <p>  <b>TABULADA:</b> @{{z.es_tabulada ? "Si" : "No"}} </p>
                            <p>  <b>TABULADOR:</b> @{{z.tabulador || '-'}} </p>
                            <a href  ng-click="exportarFileExcelZona(z)" >
                                TABULAR
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
    
</div>

@endsection

@section('javascript')
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="/js/plugins/geoxml3.js"></script>
    <script src="{{asset('/js/muestraMaestra/public/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/public/app.js')}}"></script>
@endsection
