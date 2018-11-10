@extends('layout._publicLayout')

@section('title', '')

@section('estilos')

    <link href="{{asset('/css/public/main.css')}}" rel="stylesheet">
    <link href="{{asset('/Content/styleMap.css')}}" rel="stylesheet">
    <style>
        .red {
            background-color: coral!important;
            color: white;
        }
        .white {
            background-color: white!important;
            color: black;
        }
        .gm-iv-address {
            height: 56px!important;
        }
        div[dir="ltr"] {
            top:auto!important;
            bottom: 30px!important;
        }
        
    </style>

@endsection

@section('content')

  <div ng-app="AppMapa"  ng-controller="mapa"class="container-fluid" style="padding-left: 0; padding-right: 0;" >
        <div class="row no-gutters">
            <div class="col-xs-12">
                <div class="content-map">
                    <div class="st-filter-pane" ng-show="!showInfoEntidad">
                        <div class="panel-group" style="margin-bottom: 0;" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 0; background-color: transparent;" role="tab" id="headingOne">
                                    <div class="st-filter-title-pane" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <div class="row">
                                            <div class="col-xs-9"><span class="ion-funnel"></span> <strong> Atracciones</strong></div>
                                            <div class="col-xs-3"><span class="glyphicon glyphicon glyphicon-menu-down"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div>
                                        <input type="text" class="form-control" placeholder="@Resource.LabelBuscar" ng-model="buscarFiltroAtracciones" />
                                    </div>
                                    <button class="st-btn-clean-radio" ng-click="filtro.tipoAtraciones=[]" ng-class="{true:'selected',false:'unselected'}[filtro.tipoAtraciones.length==0]" ng-show="filtro.tipoAtraciones.length>0">
                                        <i style="font-size: 1.1em;" class="ion-android-cancel"></i>  Limpiar Filtro
                                    </button>
                                    <div class="panel-body" style="max-height: 100%; color: black;padding: 0; max-height: 400px; overflow-y: auto;">
                                        
                                        <div class="checkbox" ng-repeat="tipo in tipoAtracciones|filter:buscarFiltroAtracciones" >
                                           <label>  
                                                  <input type="checkbox" checklist-model="filtro.tipoAtraciones" checklist-value="tipo.id" checklist-change="changeIcons()" > 
                                                  @{{tipo.tipo_atracciones_con_idiomas[0].nombre}} 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" style="padding: 0; background-color: transparent;" role="tab" id="headingTwo">
                                    <div class="st-filter-title-pane" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <div class="row">
                                            <div class="col-xs-9"><span class="ion-funnel"></span> <strong>Proveedores</strong></div>
                                            <div class="col-xs-3"><span class="glyphicon glyphicon glyphicon-menu-down"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body" style="max-height: 100%; color: black;padding: 0; max-height: 400px;overflow-y: auto;">
                                        <div class="checkbox" ng-repeat="tipo in tipoProveedores" >
                                           <label>  
                                                  <input type="checkbox" checklist-model="filtro.tipoProveedor" checklist-value="tipo.id" checklist-change="changeIcons()" > 
                                                  @{{tipo.tipo_proveedores_con_idiomas[0].nombre}} 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="infoEntidad" ng-show="showInfoEntidad">
                        <div class="content-info-entidad">
                            <button type="button" class="st-btn-back" ng-click="showInfoEntidad = false"><span class="ion-android-arrow-back"></span></button>
                            <div class="content-img">
                                <img src="@{{detalle.portada}}" alt=""/>
                            </div>
                            <h4>@{{detalle.nombre}}</h4>
                            <div class="content-rate">
                                <span ng-class="{true:'ion-android-star',false:'ion-android-star-outline'}[CalificacionEntidad >= 1]"></span>
                                <span ng-class="{true:'ion-android-star',false:'ion-android-star-outline'}[CalificacionEntidad >= 2]"></span>
                                <span ng-class="{true:'ion-android-star',false:'ion-android-star-outline'}[CalificacionEntidad >= 3]"></span>
                                <span ng-class="{true:'ion-android-star',false:'ion-android-star-outline'}[CalificacionEntidad >= 4]"></span>
                                <span ng-class="{true:'ion-android-star',false:'ion-android-star-outline'}[CalificacionEntidad == 5]"></span>
                            </div>
                            
                        </div>
                        <div class="buttons-detail-map">
                            <a href="@{{detalle.url}}" target="_blank" class="btn st-btn-detail-map">Ver más</a>
                        </div>
                    </div> 
                    <ng-map zoom="8" center="[10.4113014,-74.4056612]" styles="[{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ]" style="height: 550px" map-type-control="false" street-view-control="true" on-zoom_changed="zoomChanged()">
                        
                        <!--................................Marcadores..............................-->
                        <marker ng-repeat="dest in destinos | limitTo : limiteDest"
                                position="@{{dest.latitud}},@{{dest.longitud}}"
                                icon="/Content/icons/maps/destino.png"
                                id="@{{dest.id}}"
                                on-click="showInfo(event, dest.id,dest.destino_con_idiomas[0].nombre, dest.multimedia_destinos[0].ruta, '/destinos/ver/' + dest.id )"
                                title="Destino: @{{dest.destino_con_idiomas[0].nombre}}"></marker>

                        <marker ng-repeat="atr in atracciones|filter:filterAtracciones| limitTo : limiteAtr"
                                position="@{{atr.sitio.latitud}},@{{atr.sitio.longitud}}"
                                icon="@{{atr.icono}}"
                                id="@{{atr.id}}"
                                on-click="showInfo(event, atr.id,atr.sitio.sitios_con_idiomas[0].nombre,atr.sitio.multimedia_sitios[0].ruta,'/atracciones/ver/' + atr.id)"
                                title="Atraccion: @{{atr.sitio.sitios_con_idiomas[0].nombre}}"></marker>

                        <marker ng-repeat="prov in proveedores|filter:filterProveedores | limitTo : limiteProv"
                                position="@{{prov.latitud}},@{{prov.longitud}}"
                                icon="@{{prov.icono}}"
                                id="@{{prov.id}}"
                                on-click="showInfo(event, prov.id, prov.razon_social,prov.proveedor[0].multimedia_proveedores[0].ruta,'/Proveedor/ver/' + prov.id)"
                                title="Proveedor: @{{prov.razon_social}}"></marker>
                                
                    </ng-map>
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
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/testapp/scripts/markerclusterer.js"></script>
    <script src="{{asset('/js/plugins/ng-map.js')}}"></script>
    <script src="{{asset('/js/mapa/servicios.js')}}"></script>
    <script src="{{asset('/js/mapa/app.js')}}"></script>
@endsection