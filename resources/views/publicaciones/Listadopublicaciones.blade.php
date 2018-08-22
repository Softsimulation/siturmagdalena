@extends('layout._AdminLayout')
@section('app','ng-app="appProyect"')

@section('content')
   
    <div ng-controller="ListadoPublicacionCtrl" >
        

          <div class="panel-group Panel-group">
                <div class="title">
                    Publicaciones

                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-offset-5 col-sm-4">
                            <div class="form-group input-group">
                                <input id="input" class="form-control input-search" type="search" placeholder="Búsqueda" ng-model="searchpublicacion" aria-describedby="iconsearch">
                                <span class="input-group-addon" id="iconsearch"><i class="glyphicon glyphicon-search"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <span class="chip">@{{( publicaciones |filter: searchpublicacion).length}} Resultados</span>
                        </div>
                    </div>
                    <div class="row">
     
                                    <div dir-paginate="publicacion in publicaciones |filter:searchpublicacion|itemsPerPage: 10" pagination-id="pagepublicacion"> 
                                    <div class="card" style="width: 18rem;" class="col-md-4">
                                      <img class="card-img-top" src="@{{publicacion.portada}}" alt="Card image cap">
                                      <div class="card-body">
                                        <h5 class="card-title">@{{publicacion.titulo}} </h5>
                                        <p class="card-text">@{{publicacion.descripcion}}.</p>
                                        <a href="/verPubliacion/@{{publicacion.id}}" class="btn btn-primary"> ver </a>
                                      </div>
                                    </div>

                                    </div>
                                    <div ng-show="( publicaciones |filter: searchpublicacion).length == 0">
                                        <div colspan="7" style="text-align:center;">
                                            <div class="well" style="margin:0">
                                                <p style="margin:0">No se encontraron publicaciones.</p>
                                            </div>
                                        </div>
                                    </div>
                             
                        </div>
                        <div class="col-xs-12 text-center">
                            <dir-pagination-controls pagination-id="pagepublicacion"></dir-pagination-controls>
                        </div>
                    </div>
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