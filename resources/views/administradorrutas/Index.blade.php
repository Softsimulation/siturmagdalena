
@extends('layout._AdminLayout')

@section('title', 'Listado de rutas turísticas')

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

@section('TitleSection', 'Listado de rutas turísticas')

@section('titulo','Rutas turísticas')

@section('subtitulo','El siguiente listado cuenta con @{{rutas.length}} registro(s)')

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasIndexController"')

@section('content')
<div class="flex-list">
    <a href="/administradorrutas/crear" role="button" class="btn btn-lg btn-success">
      Agregar ruta turística
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de rutas turísticas</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar ruta turística...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(rutas | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(rutas | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="rutas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(rutas | filter:prop.search).length == 0 && rutas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="tiles">
    <div class="tile inline-tile" dir-paginate="ruta in rutas | filter:prop.search | itemsPerPage:10" pagination-id="pagination_rutas">
        <div class="tile-img">
            <img ng-src="@{{ruta.portada != null ?  ruta.portada : 'img/app/noimage.jpg'}}" alt="@{{ruta.rutas_con_idiomas[0].nombre}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{ruta.rutas_con_idiomas[0].nombre}}</h3>
            </div>
            <p>@{{ruta.rutas_con_idiomas[0].descripcion | limitTo:255}}<span ng-if="ruta.rutas_con_idiomas[0].descripcion.length > 255">...</span></p>
            <div class="inline-buttons">
                <a href="/administradorrutas/editar/@{{ruta.id}}" class="btn btn-warning">Editar</a>
                <button class="btn btn-@{{ruta.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(ruta)">@{{ruta.estado ? 'Desactivar' : 'Activar'}}</button>
                <a href="/administradorrutas/idioma/@{{ruta.id}}/@{{traduccion.idioma.id}}" class="btn btn-default" ng-repeat="traduccion in ruta.rutas_con_idiomas"> @{{traduccion.idioma.culture}}</a>
                <button type="button" ng-click="modalIdioma(ruta)" class="btn btn-default" ng-if="ruta.rutas_con_idiomas.length < idiomas.length"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></button>
            </div>  
            
        </div>
    </div>
</div>

<div class="row">
  <div class="col-xs-12 text-center">
      <dir-pagination-controls pagination-id="pagination_rutas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
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
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:rutaEdit.rutas_con_idiomas" class="form-control">
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
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
@endsection