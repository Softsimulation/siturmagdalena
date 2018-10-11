
@extends('layout._AdminLayout')

@section('title', 'Proveedores oferta y empleo')


@section('TitleSection', 'Listado proveedores oferta y empleo')

@section('app','ng-app="proveedoresoferta"')

@section('controller','ng-controller="listado"')

@section('titulo','Proveedores de oferta y empleo')
@section('subtitulo','El siguiente listado cuenta con @{{proveedores.length}} registro(s)')

@section('content')

<div class="flex-list" ng-show="proveedores.length > 0">
    <div class="form-group has-feedback" style="display: inline-block;">
        <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span> Filtrar registros</button>
    </div>      
</div>

<br/>
<div class="text-center" ng-if="(proveedores | filter:search).length > 0 && (search != undefined && (proveedores | filter:search).length != proveedores.length)">
    <p>Hay @{{(proveedores | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="proveedores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(proveedores | filter:search).length == 0 && proveedores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.rnt.length > 0 || search.razon_social.length > 0 || search.subcategoria.length > 0 || search.categoria.length > 0 || search.email.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>

<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>

</div>    

            <div class="row">
                <div class="col-xs-12 table-overflow">
                    <table class="table table-striped">
                        <thead>
                            <tr>                           
                                <th>Número de RNT</th>
                                <th>Nombre comercial</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>Contacto</th>
      
                                <th style="width: 110px;"></th>
                            </tr>
                            <tr ng-show="mostrarFiltro == true">
                                    
                                <td><input type="text" ng-model="search.rnt" name="rnt" id="rnt" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.razon_social" name="razon_social" id="razon_social" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.subcategoria" name="subcategoria" id="subcategoria" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.categoria" name="categoria" id="categoria" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                                <td><input type="text" ng-model="search.email" name="email" id="email" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                                <td></td>
                            </tr>
                        </thead>
                         <tbody>
                            <tr dir-paginate="item in proveedores|filter:search|itemsPerPage:10 as results" pagination-id="paginacion_antiguos" >
                                
                                <td>@{{item.rnt}}</td>
                                <td>@{{item.razon_social}}</td>
                                <td>@{{item.subcategoria}}</td>
                                <td>@{{item.categoria}}</td>
                                <td style="overflow: hidden; text-overflow:ellipsis;">@{{item.email}}</td>
                      
                                <td style="text-align: center;">
                                <a href="/ofertaempleo/activar/@{{item.proveedor_rnt_id}}" class="btn btn-default btn-xs" title="Editar" ><span class="ionicons-padding ion-edit"></span><span class="sr-only">Editar</span></a>
                                <a href="/ofertaempleo/encuesta/@{{item.id}}" class="btn btn-default btn-xs" title="Encuesta sin realizar"><span class="ionicons ion-document"></span><span class="sr-only">Encuestas sin realizar</span></a>
                                <a href="/ofertaempleo/encuestas/@{{item.id}}" class="btn btn-default btn-xs" title="Encuesta realizadas"><span class="ionicons ion-clipboard"></span><span class="sr-only">Encuestas realizadas</span></a>
                                </td>
                            </tr>
                         </tbody>
                    </table>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <dir-pagination-controls pagination-id="paginacion_antiguos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
                </div>
            </div>
    <div class='carga'>
    </div>

@endsection


@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/proveedoresapp.js')}}"></script>
<script src="{{asset('/js/encuestas/ofertaempleo/servicesproveedor.js')}}"></script>
        
@endsection