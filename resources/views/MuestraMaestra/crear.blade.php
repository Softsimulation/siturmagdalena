
@extends('layout._MuestraMaestraLayaoutLayout')

@section('title','Muestra maestra')
@section('TitleSection', "Crear periodo" )
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="CrearPeriodoCtrl"')

@section('titulo','Muestra maestra')
@section('subtitulo','Formulario de registro de periodo en muestra maestra')


@section('estilos')
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
    </style>
@endsection

@section('content')
   
        <input type="hidden" id="periodo" value="{{$ultipoPeriodoID}}" />
        
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
            <h2>Crear perido</h2> 
            
            <form name="formCrear" novalidate>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.nombre.$touched) && formCrear.nombre.$error.required}">
                            <label class="control-label" for="pregunta"><span class="asterisk">*</span> Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="dataPerido.nombre" required maxlength="255"/>
                        </div>
                    </div>
                </div> 
                <br>
                <div class="row">   
                    <div class="col-md-12">
                        <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.fechaInicio.$touched) && formCrear.fechaInicio.$error.required}">
                            <label class="control-label" for="fechaInicio"><span class="asterisk">*</span> Fecha inicio</label>
                            <adm-dtp full-data="date1" maxdate="@{{date2.unix}}" name="fechaInicio" id="fechaInicio" ng-model='dataPerido.fecha_inicio' options="optionFecha" ng-required="true"></adm-dtp>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">     
                    <div class="col-md-12">
                        <div class="form-group" ng-class="{'has-error' : (formCrear.$submitted || formCrear.fechaFin.$touched) && formCrear.fechaFin.$error.required}">
                            <label class="control-label" for="fechaFin"><span class="asterisk">*</span> Fecha fin</label>
                            <adm-dtp full-data="date2" mindate="@{{date1.unix}}" name="fechaFin" id="fechaFin" ng-model='dataPerido.fecha_fin' options="optionFecha" ng-required="true"></adm-dtp>
                        </div>
                    </div>
                </div> 
                <br>
                <div class="row"> 
                    <div class="col-md-12">
                        <br>
                       <button type="submit" class="btn btn-block btn-success" ng-click="guardar()" >Guardar</button>
                    </div>
                </div>
                
            </form>
            
        </div>
        <div id="contentMap">
            <div id="filtros-buttons">
                <a class="btn" href="/MuestraMaestra/periodos" title="Regresar al listado" >
                   <i class="material-icons">reply</i>
                </a> 
            </div>
            <ng-map id="mapa" zoom="9" center="[10.4113014,-74.4056612]" styles="@{{styloMapa}}" map-type-control="true" map-type-control-options="{position:'BOTTOM_CENTER'}"  > 
              
                <marker ng-repeat="pro in proveedores" position="@{{pro.latitud}},@{{pro.longitud}}"  id="@{{pro.id}}"
                    icon="@{{ getIcono(pro) }}" on-click="showInfoMapa(event,pro,$index)"  >     
                </marker>
        
        
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
    
    
    <br>
    
    <!--
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
    
    -->

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
            <button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
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
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="/js/plugins/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
