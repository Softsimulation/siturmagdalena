
@extends('layout._AdminLayout')

@section('title', 'Listado de atracciones')

@section('estilos')
    <style>
        
        .messages {
            color: #FA787E;
        }

        .row {
            margin: 1em 0 0;
        }
        
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de atracciones')

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesIndexController"')

@section('titulo','Atracciones')
@section('subtitulo','El siguiente listado cuenta con @{{atracciones.length}} registro(s)')

@section('content')
<div class="flex-list">
    <a href="/administradoratracciones/crear" role="button" class="btn btn-lg btn-success">
      Agregar atracciones
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de atracciones</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar atracción...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(atracciones | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(atracciones | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="atracciones.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(atracciones | filter:prop.search).length == 0 && atracciones.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="tiles">
    <div class="tile inline-tile" dir-paginate="atraccion in atracciones | filter:prop.search | itemsPerPage:10" pagination-id="pagination_atracciones">
        <div class="tile-img">
            <img ng-src="@{{atraccion.sitio.multimedia_sitios.length > 0 ?  atraccion.sitio.multimedia_sitios[0].ruta : 'img/app/noimage.jpg'}}" alt="@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}</h3>
            </div>
            <p>@{{atraccion.sitio.sitios_con_idiomas[0].descripcion | limitTo:255}}<span ng-if="atraccion.sitio.sitios_con_idiomas[0].descripcion.length > 255">...</span></p>
            <div class="inline-buttons">
                <a href="/administradoratracciones/editar/@{{atraccion.id}}" class="btn btn-warning">Editar</a>
                <button class="btn btn-@{{atraccion.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(atraccion)">@{{atraccion.estado ? 'Desactivar' : 'Activar'}}</button>
                <a href="/administradoratracciones/idioma/@{{atraccion.id}}/@{{traduccion.idioma.id}}" class="btn btn-default" ng-repeat="traduccion in atraccion.sitio.sitios_con_idiomas"> @{{traduccion.idioma.culture}}</a>
                <button type="button" ng-click="modalIdioma(atraccion)" class="btn btn-default" ng-if="atraccion.sitio.sitios_con_idiomas.length < idiomas.length"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></button>
            </div>  
            
        </div>
    </div>
</div>

<div class="row">
  <div class="col-xs-12 text-center">
      <dir-pagination-controls pagination-id="pagination_atracciones"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
  </div>
</div>
    
<div class='carga'>

</div>

<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo idioma para la atracción</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:atraccionEdit.sitio.sitios_con_idiomas" class="form-control">
                            <option value="">Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-success">Enviar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/services.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/app.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="/js/plugins/ng-map.js"></script>
@endsection