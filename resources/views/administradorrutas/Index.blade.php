
@extends('layout._AdminLayout')

@section('title', 'Listado de rutas')

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

@section('TitleSection', 'Listado de rutas')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasIndexController"')

@section('content')
<div class="col-sm-12">
    <h1 class="title1">Lista de rutas turísticas</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <a href="/administradorrutas/crear" type="button" class="btn btn-primary" >
                  Insertar ruta turística
                </a>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Búsqueda de rutas">
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3" style="text-align: center;">
                <span class="chip">@{{(rutas|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <ul class="media-list">
                    <li dir-paginate="ruta in rutas | filter:prop.search | itemsPerPage:10" pagination-id="pagination_rutas" class="media">
                        <div class="media-left">
                            <a href="/administradorrutas/editar/@{{ruta.id}}">
                                <img class="media-object" style="width: 400px; height: 200px;" 
                                src="@{{ruta.portada != null ?  ruta.portada : 'img/app/noimage.jpg'}}" 
                                alt="@{{ruta.rutas_con_idiomas[0].nombre}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@{{ruta.rutas_con_idiomas[0].nombre}} @{{ruta.rutas_con_idiomas[0].edicion != null ? '-' : ''}} @{{ruta.rutas_con_idiomas[0].edicion}}</h4>
                            <p class="text-justify">
                                @{{ruta.rutas_con_idiomas[0].descripcion | limitTo:400}}...
                            </p>
                            <br>
                            <p class="text-left">
                                <button class="btn btn-@{{ruta.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(ruta)">@{{ruta.estado ? 'Desactivar' : 'Activar'}}</button>
                                <a href="/administradorrutas/idioma/@{{ruta.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in ruta.rutas_con_idiomas"> @{{traduccion.idioma.culture}}</a>
                                <a href="javascript:void(0)" ng-click="modalIdioma(ruta)" ng-if="ruta.rutas_con_idiomas.length < idiomas.length"> <span class="glyphicon glyphicon-plus"></span></a>
                                <a href="/administradorrutas/editar/@{{ruta.id}}"> <span class="glyphicon glyphicon-pencil"></span></a>
                            </p>
                        </div>
                    </li>
                </ul>
                <div class="alert alert-warning" role="alert" ng-show="rutas.length == 0 || (rutas|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(rutas|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="pagination_rutas"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
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
                <h4 class="modal-title">Nuevo idioma para la ruta</h4>
                </div>
                <div class="modal-body">
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas | idiomaFilter:rutaEdit.rutas_con_idiomas" class="form-control">
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