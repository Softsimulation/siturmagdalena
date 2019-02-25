
@extends('layout._MuestraMaestraLayaoutLayout')

@section('Title','Muestra maestra')
@section('TitleSection', $periodo->nombre )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="MuestraMaestraCtrl"')

@section('estilos')
    <style type="text/css">
        .fade.in {
            overflow: auto !important;
        }
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
        
        /*////////////////////////////////////////////*/
        .ui-select-multiple.ui-select-bootstrap input.ui-select-search{ width:100% !important; }
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
            top: 10%;
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
    </style>
    <style>
      /* The location pointed to by the popup tip. */
      .popup-tip-anchor {
        height: 0;
        position: absolute;
        /* The max width of the info window. */
        width: 200px;
      }
      /* The bubble is anchored above the tip. */
      .popup-bubble-anchor {
        position: absolute;
        width: 100%;
        bottom: /* TIP_HEIGHT= */ 8px;
        left: 0;
      }
      /* Draw the tip. */
      .popup-bubble-anchor::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        /* Center the tip horizontally. */
        transform: translate(-50%, 0);
        /* The tip is a https://css-tricks.com/snippets/css/css-triangle/ */
        width: 0;
        height: 0;
        /* The tip is 8px high, and 12px wide. */
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: /* TIP_HEIGHT= */ 8px solid white;
      }
      /* The popup bubble itself. */
      .popup-bubble-content {
        position: absolute;
        top: 0;
        left: 0;
        transform: translate(-50%, -100%);
        /* Style the info window. */
        background-color: white;
        padding: 5px;
        border-radius: 5px;
        font-family: sans-serif;
        overflow-y: auto;
        max-height: 60px;
        box-shadow: 0px 2px 10px 1px rgba(0,0,0,0.5);
      }
    </style>
@endsection

@section('content')
    
    <input type="hidden" id="periodo" value="{{$periodo->id}}" />
    
    
 
    <div id="alertProveedores" class="alert alert-info" ng-show="proveedoresFuera.length>0" >
      <a href="#" class="close" ng-click="proveedoresFuera=[]" >&times;</a>
      <strong>Atención, prestadores fuera de un bloque!</strong> 
       <p>Se encontraron @{{proveedoresFuera.length}} prestadores fuera de los bloques.</p> 
       <details>
          <summary>Clic para ver prestadores</summary>
          <ul style="max-height: 300px; overflow: auto;">
              <li ng-repeat="it in proveedoresFuera track by $index">
                 <a ng-click="centrarMapaAlProveedor(it)" href > @{{it.nombre}}</a>
              </li>
          </ul>
        </details>
    </div>

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
                <div class="form-group has-feedback">
                    <label class="sr-only">Búsqueda general de prestadores</label>
                    <input type="text" class="form-control" ng-model="filtro.busqueda" placeholder="Búsqueda general en proveedores" ng-keyup="filtroProveedoresInput($event)" data-toggle="tooltip" data-placement="top" title="Presione enter para buscar" maxlength="255"/>
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
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
            
            <div id="filtrosZonas" >
                
                <div class="checkbox" style="margin:5px;" ng-init="verLabels=false"  >
                   <label><input type="checkbox" ng-model="verLabels" ng-change="verOcultarLabels(verLabels)" >Ver etiquestas</label>
                </div>
                
                
                <div class="checkbox" style="margin:5px;" >
                   <label><input type="checkbox" ng-model="filtro.verZonas" ng-change="verOcultarZonas()" >Ver bloques</label>
                </div>
                
                <div class="panel-group" ng-show="filtro.verZonas == true">
            
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                               <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse5" >Filtrar bloques</a>
                            </h4>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="form-group" >
                                    <label class="control-label" for="sectorF" >Municipios - sector</label>
                                    <ui-select multiple ng-model="filtro.sectores" name="sectorF" id="sectorF" theme="bootstrap" ng-required="true" ng-change="filterZonas();" >
                                        <ui-select-match placeholder="Seleccione un sector o municipio">
                                            <span>@{{$item.destino.destino_con_idiomas[0].nombre +' - '+ $item.sectores_con_idiomas[0].nombre}}</span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (sectores | filter:$select.search)">
                                            <div class="item-ui-select" > 
                                                <p><b>Municipio:</b> @{{t.destino.destino_con_idiomas[0].nombre}} </p>
                                                <p><b>Sector:</b> @{{t.sectores_con_idiomas[0].nombre}} </p>
                                            </div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                <br>
                                <div class="form-group" >
                                    <label class="control-label" for="encargados" >Encargados</label>
                                    <ui-select multiple ng-model="filtro.encargados" name="encargados" id="encargados" theme="bootstrap"  ng-required="true" ng-change="filterZonas();" >
                                        <ui-select-match placeholder="Seleccione los encargados">
                                            <span ng-bind="$item.user.nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="t.id as t in (digitadores2 | filter:$select.search)">
                                            <div class="item-ui-select" > 
                                                  <p>@{{t.user.nombre}}</p>
                                            </div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                
                </div>    
                
            </div>
            
            <button class="btn btn-block btn-danger btn-sm" ng-click="limpiarFiltros()"  >
                Limpiar todos los filtros
            </button>
            
        </div>
        <div id="contentMap" ng-class="{ 'showed': pantallaCompleta }">
            <div id="filtros-buttons">
                <a class="btn" href="/MuestraMaestra/periodos" title="Regresar al listado" >
                   <i class="material-icons">reply</i>
                </a>  
                <div class="btn-map">
                    
                    
                    <div class="dropdown">
                          <a class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                             <i class="material-icons">menu</i>
                          </a>
                          <ul class="dropdown-menu">
                              @if(Auth::user()->contienePermiso('list-bloque'))
                                  <li><a href ng-click="verTablaZonas()" ><i class="material-icons">table_chart</i> Ver tabla de bloques</a></li>
                              @endif
                              @if(Auth::user()->contienePermiso('excel-muestra'))
                                  <li><a href ng-click="exportarFileExcelGeneral()" ><i class="material-icons">arrow_downward</i> Descargar excel de la muestra</a></li>
                              @endif
                              @if(Auth::user()->contienePermiso('KML-muestra'))
                                <li>
                                    <a href ng-click="exportarFileKML()" ><i class="material-icons">arrow_downward</i> Exportar KML</a>
                                </li>
                             @endif
                             @if(Auth::user()->contienePermiso('create-proveedorMuestra'))
                                <li><a href ng-click="openMensajeAddProveedorInformal()" ><i class="material-icons">add_location</i> Agregar proveedor informal</a></li>
                             @endif
                            @if(Auth::user()->contienePermiso('create-zona'))
                                <li><a href ng-click="openMensajeAddZona()" ng-show="!es_crear_zona" ><i class="material-icons">add</i> Agregar bloque</a></li>
                            @endif
                          </ul>
                    </div>
                    
                    <button type="button" id="btn-add" class="btn btn-danger btn-sm" ng-click="cancelarAgregarZonaPRoveedor()" ng-show="es_crear_zona || es_crear_proveedor" style="margin-left: 5px;position: absolute; left: 100%;" >
                        Cancelar
                    </button>
                    
                </div>
                <button type="button" class="btn" title="Ocultar menu" ng-click="pantallaCompleta=true" ng-show="!pantallaCompleta">
                   <i class="material-icons">arrow_back</i>
                </button>  
                <button type="button" class="btn" title="Ver menu" ng-click="pantallaCompleta=false" ng-show="pantallaCompleta" >
                    <i class="material-icons">arrow_forward</i>
                </button>  
            </div>
            <ng-map id="mapa" zoom="9" center="@{{centro}}" styles="@{{styloMapa}}" map-type-control="true" street-view-control="true" street-view-control-options="{position: 'RIGHT_BOTTOM'}"  > 
                <drawing-manager ng-if="es_crear_zona || es_crear_proveedor"
                      on-overlaycomplete="onMapOverlayCompleted()"
                      drawing-control-options="{position: 'TOP_CENTER',drawingModes:['@{{figuraCrear}}']}"
                      drawingControl="true" drawingMode="null">
                    </drawing-manager>
            </ng-map>
        </div>
            
    </div>
    
    
    <div id="mySidenav" class="sidenav">
        <div class="cabecera" >
            <h4 style="padding-left: 5px; font-weight: bold;" > Detalles del @{{ proveedor ? ' prestador' : ' bloque' }} 
                 <a ng-if="!detalleZona.editar" href="javascript:void(0)" class="closebtn" ng-click="closeInfoMapa()">&times;</a>
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
            
            @if(Auth::user()->contienePermiso('edit-proveedorMuestra'))
                <button class="btn btn-block btn-success btn-sm" ng-click="openModalZonaProveedores(proveedor)"  ng-if="!proveedor.rnt" >
                    <i class="glyphicon glyphicon-pencil"></i> Editar información
                </button>
                  
                <button class="btn btn-block btn-primary btn-sm" ng-click="editarPosicionProveedor()" ng-show="!proveedor.editar" >
                   <i class="glyphicon glyphicon-map-marker"></i> Cambiar ubicación
                </button>
            @endif
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
                  <span ng-repeat="it in detalleZona.encargados" > @{{it.user.nombre}}, </span>
                <p/>
            </div>
            <div class="item-info" >
                <p>Número de prestadores: @{{detalleZona.numeroPrestadoresFormales+detalleZona.numeroPrestadoresInformales}}</p>
                <p style="font-size: 11px;margin: 0;" >Formales: @{{detalleZona.numeroPrestadoresFormales}}, Informales: @{{detalleZona.numeroPrestadoresInformales}} </p>
            </div>
            
            <details style="margin-top: 10px;" >
              <summary style="font-size: 1rem; font-weight: bold;" >Categorías</summary>
              <ul class="list-details">
                <li ng-repeat="it in detalleZona.tiposProveedores">
                    @{{it.nombre}} 
                    <p style="font-size: 11px;margin: 0;" >Formales: @{{it.cantidad[0]}}, Informales: @{{it.cantidad[1]}} </p>
                </li>
              </ul>
            </details>
           
            <details style="margin-top: 10px;" >
                <summary style="font-size: 1rem; font-weight: bold;" >Estados de los prestadores</summary>
                <ul class="list-details">
                    <li ng-repeat="it in detalleZona.estadosProveedores">@{{it.nombre}}: @{{it.cantidad}}</li>
                </ul>
            </details>
            
            <br>
            <ul class="list-details" >
                @if(Auth::user()->contienePermiso('edit-zona'))
                    <li><a href ng-click="openModalZona(detalleZona)" ><i class="material-icons">edit</i> Ver/Editar</a></li>
                    <li><a href ng-click="editarPosicionZona(detalleZona)" ><i class="material-icons">edit</i> Editar ubicación</a></li>
                @endif
                @if(Auth::user()->contienePermiso('delete-zona'))
                    <li><a href ng-click="eliminarZona(detalleZona)" ><i class="material-icons">delete_forever</i> Eliminar</a></li>
                @endif
                @if(Auth::user()->contienePermiso('excel-zona'))
                    <li><a href ng-click="exportarFileExcelZona(detalleZona)" ><i class="material-icons">arrow_downward</i> Generar Excel</a></li>
                @endif
                @if(Auth::user()->contienePermiso('llenarInfo-zona|excel-infoZona'))
                    <li><a href="/MuestraMaestra/llenarinfozona/@{{detalleZona.id}}" ><i class="material-icons">border_color</i> Tabular bloque</a></li>
                @endif
            </ul>
            
            <div class="btn-group" role="group"  ng-show="detalleZona.editar" style="width:100%;" >
              <button type="button" class="btn btn-danger" ng-click="cancelarEditarPosicion()" style="width:50%;">Cancelar</button>
              <button type="button" class="btn btn-success" ng-click="guardarEditarPosicion()" style="width:50%;">Guardar</button>
            </div>
            
        </div>

    </div>
      
    
    <!-- Modal para gregar zona -->
<div id="modalAddZona" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" ng-click="cancelarAgregarZonaPRoveedor()" class="close" data-dismiss="modal" >&times;</button>
        <h4 class="modal-title">Bloque</h4>
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
                                <span ng-bind="$item.user.nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (digitadores |filter:$select.search)">
                                <span ng-bind="t.user.nombre" title="@{{t.user.nombre}}"></span>
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
                                <span>@{{$select.selected.destino.destino_con_idiomas[0].nombre +' - '+ $select.selected.sectores_con_idiomas[0].nombre}}</span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (sectores |filter:$select.search)">
                                <div class="item-ui-select" > 
                                    <p><b>Municipio:</b> @{{t.destino.destino_con_idiomas[0].nombre}} </p>
                                    <p><b>Sector:</b> @{{t.sectores_con_idiomas[0].nombre}} </p>
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
                      <label for="name">Color: @{{zona.color}} </label>
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
<div class="modal fade" id="modalDetallesZonas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 95%;" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ng-click="cancelarAgregarZona()">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bloques</h4>
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
                <tr ng-repeat="z in (detalle|filter:busquedaZonas|filter:{ 'es_generada':filterTabla.planillada, 'es_tabulada':filterTabla.tabulada }) as detalleFiltrada " >
                  <td>
                      <p>  <b>BLOQUE:</b> @{{z.nombre}} </p>
                      <p>  <b>SECTOR:</b> @{{(sectores|filter:{id:z.sector_id}:true)[0].sectores_con_idiomas[0].nombre}} </p>
                      <p>  
                            <b>ENCARGADOS:</b> 
                            <ul>
                                <li ng-repeat="it in z.encargados" > @{{it.user.nombre}} </li> 
                            </ul>
                      </p>
                  </td>
                  <td>
                      
                        <details style="margin-top: 10px;" >
                          <summary style="font-size: 1rem; font-weight: bold;" >Categorías</summary>
                          <ul class="list-details">
                            <li ng-repeat="it in z.tiposProveedores">
                                @{{it.nombre}} 
                                <p style="font-size: 11px;margin: 0;" >Formales: @{{it.cantidad[0]}}, Informales: @{{it.cantidad[1]}} </p>
                            </li>
                          </ul>
                        </details>
                       
                        <details style="margin-top: 10px;" >
                            <summary style="font-size: 1rem; font-weight: bold;" >Estados de los prestadores</summary>
                            <ul class="list-details">
                                <li ng-repeat="it in z.estadosProveedores">@{{it.nombre}}: @{{it.cantidad}}</li>
                            </ul>
                        </details>
                      
                  </td>
                  <td>
                        <p>  <b>GENERADA:</b> @{{z.es_generada ? "Si" : "No"}} </p>
                        <a href  ng-click="exportarFileExcelZona(z)" title="Descragar excel" >
                            Descargar
                        </a>
                  </td>
                  <td>
                        <p>  <b>TABULADA:</b> @{{z.es_tabulada ? "Si" : "No"}} </p>
                        <p>  <b>TABULADOR:</b> @{{z.tabulador.user.nombre || '-'}} </p>
                        <a href="/MuestraMaestra/llenarinfozona/@{{z.id}}" title="Tabular bloque"  >
                            TABULAR
                        </a>
                  </td>
                </tr>
              </tbody>
            </table>
            
            <div class="alert alert-info" ng-show="detalleFiltrada.length==0"  >
                0 Resultados en la busqueda
            </div>

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
        <h4 class="modal-title">Proveedor</h4>
      </div>
      <form name="formP" >
      
          <div class="modal-body">
            
            <div class="row">    
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.nombreP.$touched) && formP.nombreP.$error.required}" >
                      <label>Nombre:</label>
                      <input type="text" class="form-control"  name="nombreP" ng-model="proveedorInformal.nombre" placeholder="Nombre del establecimiento" required >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.muniP.$touched) && formP.muniP.$error.required}">
                        <label class="control-label" for="muniP">Municipio</label>
                        <ui-select  ng-model="proveedorInformal.municipio_id" name="muniP" id="muniP" theme="bootstrap" sortable="true"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione una categoria">
                                <span ng-bind="$select.selected.nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (municipios |filter:$select.search)">
                                <span ng-bind="t.nombre" title="@{{t.nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                
            </div>
            
            <br>
        
            <div class="row">    
                <div class="col-md-12" style="padding-right:15px!important; padding-left:15px!important;" >
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.ditecionP.$touched) && formP.ditecionP.$error.required}" >
                      <label>Dirección:</label>
                      <input type="text" class="form-control"  name="ditecionP" ng-model="proveedorInformal.direccion" placeholder="Direción" required >
                    </div>
                </div>
                <!--
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.telefono.$touched) && formP.telefono.$error.required}" >
                      <label>Teléfono:</label>
                      <input type="text" class="form-control"  name="telefono" ng-model="proveedorInformal.telefono" placeholder="Número de teléfono" >
                    </div>
                </div>
                -->
            </div>
            
            <br>
            
            <div class="row">    
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.tipoP.$touched) && formP.tipoP.$error.required}">
                        <label class="control-label" for="tipoP">Categoría</label>
                        <ui-select  ng-model="TipoProveedorInformal.select" name="tipoP" id="tipoP" theme="bootstrap" sortable="true" ng-change="proveedorInformal.categoria_proveedor_id=null; proveedorInformal.idcategoria=null;"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione un tipo">
                                <span ng-bind="$select.selected.tipo_proveedores_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t as t in (tiposProveedores |filter:$select.search)">
                                <span ng-bind="t.tipo_proveedores_con_idiomas[0].nombre" title="@{{t.tipo_proveedores_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group" ng-class="{'error' : (formP.$submitted || formP.tipoP.$touched) && formP.tipoP.$error.required}">
                        <label class="control-label" for="tipoP">Subcategoría</label>
                        <ui-select  ng-model="proveedorInformal.idcategoria" name="tipoP" id="tipoP" theme="bootstrap" sortable="true"  ng-required="true" >
                            <ui-select-match placeholder="Seleccione una categoria">
                                <span ng-bind="$select.selected.categoria_proveedores_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="t.id as t in (TipoProveedorInformal.select.categoria_proveedores |filter:$select.search)">
                                <span ng-bind="t.categoria_proveedores_con_idiomas[0].nombre" title="@{{t.categoria_proveedores_con_idiomas[0].nombre}}"></span>
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


@endsection

@section('javascript')
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/testapp/scripts/markerclusterer.js"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="/js/plugins/tokml.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="/js/plugins/geoxml3.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
