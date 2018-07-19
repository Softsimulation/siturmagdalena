
@extends('layout._AdminLayout')

@section('title', 'Listado de atracciones')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de atracciones')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesIndexController"')

@section('content')
<div class="container">
    <h1 class="title1">Lista de atracciones</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <a href="/administradoratracciones/crear" type="button" class="btn btn-primary" >
                  Insertar atracción
                </a>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Búsqueda de atracciones">
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3" style="text-align: center;">
                <span class="chip">@{{(atracciones|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <ul class="media-list">
                    <li dir-paginate="atraccion in atracciones | filter:prop.search | itemsPerPage:10" pagination-id="pagination_atracciones" class="media">
                        <div class="media-left">
                            <a href="/administradoratracciones/editar/@{{atraccion.id}}">
                                <img class="media-object" style="width: 400px; height: 200px;" 
                                src="@{{atraccion.sitio.multimedia_sitios.length > 0 ?  atraccion.sitio.multimedia_sitios[0].ruta : 'img/app/noimage.jpg'}}" 
                                alt="@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}</h4>
                            <p class="text-justify">
                                @{{atraccion.sitio.sitios_con_idiomas[0].descripcion | limitTo:400}}...
                            </p>
                            <br>
                            <p class="text-left">
                                <button class="btn btn-@{{atraccion.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(atraccion)">@{{atraccion.estado ? 'Desactivar' : 'Activar'}}</button>
                                <a href="/administradoratracciones/idioma/@{{atraccion.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in atraccion.sitio.sitios_con_idiomas"> @{{traduccion.idioma.culture}}</a>
                                <a href="javascript:void(0)" ng-click="modalIdioma(atraccion)" ng-if="atraccion.sitio.sitios_con_idiomas.length < idiomas.length"> <span class="glyphicon glyphicon-plus"></span></a>
                                <a href="/administradoratracciones/editar/@{{atraccion.id}}"> <span class="glyphicon glyphicon-pencil"></span></a>
                            </p>
                        </div>
                    </li>
                </ul>
                <div class="alert alert-warning" role="alert" ng-show="atracciones.length == 0 || (atracciones|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(atracciones|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="pagination_atracciones"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    </div>
    
    <div class='carga'>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="idiomaModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo idioma para la atracción</h4>
                </div>
                <div class="modal-body">
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|filter:{id: idioma.id}:true" class="form-control">
                            <option value="">Seleccione un idioma</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" ng-click="nuevoIdioma()" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('javascript')
<script src="{{asset('/js/administrador/atracciones/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/services.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/app.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
@endsection