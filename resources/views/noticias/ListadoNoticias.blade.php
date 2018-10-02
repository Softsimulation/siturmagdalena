@extends('layout._AdminLayout')

@section('title', 'Listado de noticias')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
        }
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de noticias')

@section('app','ng-app="admin.noticia"')

@section('controller','ng-controller="listadoNoticiasCtrl"')

@section('titulo','Noticias')
@section('subtitulo','El siguiente listado cuenta con @{{noticias.length}} registro(s)')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <a href="/noticias/crearnoticia" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-offset-5 col-sm-4">
                <div class="form-group input-group">
                    <input id="input" class="form-control input-search" type="search" placeholder="Búsqueda" ng-model="search" aria-describedby="iconsearch">
                    <span class="input-group-addon" id="iconsearch"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <div class="col-sm-3">
                <span class="chip">@{{( noticias |filter: search).length}} Resultados</span>
            </div>
        </div>
      <div class="row">
        <div class="col-md-3">
          <h5>Filtrar por tipo de noticia</h5>
          <select class="form-control" name="accion" id="accion" ng-options="tipo.id as tipo.nombre for tipo in tiposNoticias" ng-model="tipoNoticia" ng-required="true">
            <option value="">Seleccione una acción</option>
          </select>
        </div>
        
      </div>
      <br>
              
      <table class="table table-hover">
          <tr>
              <th>Título</th>
              <th>Tipo de noticia</th>
              <th>Estado</th>
              <th>Acción</th>
              
          </tr>
          
          <tr dir-paginate="x in noticias | filter:{idTipoNoticia:tipoNoticia} | filter:search | itemsPerPage:10" pagination-id="paginacion_noticias">
              <td>@{{x.tituloNoticia}}</td>
              <td>@{{x.nombreTipoNoticia}}</td>
              <td >@{{x.estado == true ? 'Activo' : 'Inactivo'}}</td>
              <td>
                <!--<a href="/noticias/vistaeditar/@{{x.idNoticia}}/1" class="btn btn-default" title="Editar noticia" style="float:left"><span class="glyphicon glyphicon-pencil"></span></a>-->
                <a href="/noticias/vernoticia/@{{x.idNoticia}}" class="btn btn-default" title="Ver noticia" style="float:left"><span class="glyphicon glyphicon-eye-open"></span></a>
                <a href="" ng-click="cambiarEstado(x)" class="btn btn-default" title="Cambiar estado" style="float:left"><span class="glyphicon glyphicon-transfer"></span></a>
                <!--<a href="" ng-click="eliminarNoticia(x)" class="btn btn-default" title="Eliminar noticia" style="float:left"><span class="glyphicon glyphicon-remove"></span></a>-->
                <a ng-repeat="idioma in x.idiomas[0].idiomas" href="/noticias/vistaeditar/@{{x.idNoticia}}/@{{idioma.id}}" class="btn btn-default" title="Editar @{{idioma.nombre}}" style="float:left">@{{idioma.culture}}</a>
                  <a ng-if="x.idiomas[0].idiomas.length < cantIdiomas" href="/noticias/nuevoidioma/@{{x.idNoticia}}" class="btn btn-default" title="Agregar idioma" style="float:left"><span class="glyphicon glyphicon-plus"></span></a>
              </td>
          </tr>
          
      </table>
      
       <div class="row" ng-if="(noticias | filter:{idTipoNoticia:tipoNoticia} | filter:buscar).length==0 || noticias==null">
         <div class="alert alert-warning" style="text-align:center"><h5>No se encontró noticias</h5></div>
       </div> 
       <div class="row" ng-if="noticias.length > 0 && (noticias|filter:search).length == 0">
         <div class="alert alert-info" style="text-align:center"><h5>No hay elementos para la búsqueda realizada</h5></div>
       </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="paginacion_noticias"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
@endsection

@section('javascript')
<script src="{{asset('/js/plugins/angular-material/angular-animate.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-aria.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-messages.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-material.min.js')}}"></script>
<script src="{{asset('/js/plugins/material.min.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/noticias/noticias.js')}}"></script>
<script src="{{asset('/js/administrador/noticias/noticiaServices.js')}}"></script>
@endsection