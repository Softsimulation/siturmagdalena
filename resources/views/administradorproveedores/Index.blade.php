
@extends('layout._AdminLayout')

@section('title', 'Listado de proveedores')

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

@section('TitleSection', 'Listado de proveedores')

@section('app', 'ng-app="proveedoresApp"')

@section('controller','ng-controller="proveedoresIndexController"')
@section('titulo','Proveedores')
@section('subtitulo','El siguiente listado cuenta con @{{proveedores.length}} registro(s)')
@section('content')
<div class="flex-list">
    <a href="/administradorproveedores/crear" type="button" class="btn btn-lg btn-success" data-toggle="tooltip" data-placement="bottom" title="Esta acción permitirá publicar un proveedor que se encuentre almacenado en el sistema.">
      Publicar proveedor
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de proveedor</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar proveedor...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(proveedores | filter:prop.search).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(proveedores | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="proveedores.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(proveedores | filter:prop.search).length == 0 && proveedores.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>

<div class="tiles">
    <div class="tile inline-tile" dir-paginate="proveedor in proveedores | filter:prop.search | itemsPerPage:10" pagination-id="pagination_proveedores">
        <div class="tile-img">
            <img ng-src="@{{proveedor.multimedia_proveedores.length > 0 ?  proveedor.multimedia_proveedores[0].ruta : 'img/app/noimage.jpg'}}" alt="@{{proveedor.proveedor_rnt.razon_social}}"/>
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3>@{{proveedor.proveedor_rnt.razon_social}}</h3>
            </div>
            <p>@{{proveedor.proveedor_rnt.proveedor_rnt_idioma[0].descripcion}}</p>
            <div class="inline-buttons">
                <a href="/administradorproveedores/editar/@{{proveedor.id}}" class="btn btn-warning">Editar</a>
                <button class="btn btn-@{{proveedor.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(proveedor)">@{{proveedor.estado ? 'Desactivar' : 'Activar'}}</button>
                <a href="/administradorproveedores/idioma/@{{proveedor.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in proveedor.proveedor_rnt.idiomas" class="btn btn-default" title="@{{traduccion.idioma.culture}}"> @{{traduccion.idioma.culture}}</a>
                <a href="javascript:void(0)" ng-click="modalIdioma(proveedor)" ng-if="proveedor.proveedor_rnt.idiomas.length < idiomas.length" class="btn btn-default" title="Agregar idioma"> <span class="glyphicon glyphicon-plus"></span><span class="sr-only">Agregar idioma</span></a>
                
            </div>  
            
        </div>
    </div>
</div>


    <div class="row">
      <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="pagination_proveedores"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
      </div>
    </div>

    <div class='carga'>

    </div>

<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo idioma para el proveedor</h4>
                </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:proveedorEdit.proveedor_rnt.idiomas" class="form-control">
                            <option value="">Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-success">Ir</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/services.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection