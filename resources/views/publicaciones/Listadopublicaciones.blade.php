@extends('layout._AdminLayout')
@section('app','ng-app="appProyect"')

@section('controller','ng-controller="ListadoPublicacionCtrl"')

@section('titulo','Publicaciones')
@section('subtitulo','El siguiente listado cuenta con @{{publicaciones.length}} registro(s)')

@section('content')
<div class="flex-list">
    
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de publicaciones</label>
        <input type="text" ng-model="searchpublicacion" class="form-control input-lg" id="inputEmail3" placeholder="Buscar publicación...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(publicaciones |filter: searchpublicacion).length > 0 && (searchpublicacion != '' && searchpublicacion != undefined)">
    <p>Hay @{{(publicaciones |filter: searchpublicacion).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="publicaciones.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(publicaciones |filter: searchpublicacion).length == 0 && publicaciones.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="tiles">
    <div class="tile inline-tile" dir-paginate="publicacion in publicaciones |filter:searchpublicacion|itemsPerPage: 10" pagination-id="pagepublicacion">
        <div class="tile-img">
            <img ng-src="@{{publicacion.portada.length > 0 ?  publicacion.portada : 'img/app/noimage.jpg'}}" alt="@{{publicacion.titulo}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{publicacion.titulo}}</h3>
            </div>
            <p>@{{publicacion.descripcion}}</p>
            <div class="inline-buttons">
                <a href="/verPubliacion/@{{publicacion.id}}" class="btn btn-primary">Ver detalle</a>
                
            </div>  
            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-center">
        <dir-pagination-controls pagination-id="pagepublicacion"></dir-pagination-controls>
    </div>
</div>

@endsection
@section('javascript')
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select2.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/servicios.js')}}"></script>
    <script src="{{asset('/js/plugins/dirPagination.js')}}"></script>
    <script src="{{asset('/js/plugins/ng-tags-input.js')}}"></script>
    <script src="{{asset('/js/plugins/directiva.campos.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/appAngular.js')}}"></script>
@endsection