
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

@section('TitleSection', 'Listado de eventos')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="eventosApp"')

@section('controller','ng-controller="eventosIndexController"')

@section('content')
<div class="col-sm-12">
    <h1 class="title1">Lista de eventos</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-6 col-md-5">
                <a href="/administradoreventos/crear" type="button" class="btn btn-primary" >
                  Insertar evento
                </a>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Búsqueda de eventos">
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3" style="text-align: center;">
                <span class="chip">@{{(eventos|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <ul class="media-list">
                    <li dir-paginate="evento in eventos | filter:busquedaEvento(prop.search) | itemsPerPage:10" pagination-id="pagination_eventos" class="media">
                        <div class="media-left">
                            <a href="/administradoreventos/editar/@{{evento.id}}">
                                <img class="media-object" style="width: 400px; height: 200px;" 
                                src="@{{evento.multimedia_eventos.length > 0 ?  evento.multimedia_eventos[0].ruta : 'img/app/noimage.jpg'}}" 
                                alt="@{{evento.eventos_con_idiomas[0].nombre}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">@{{evento.eventos_con_idiomas[0].nombre}} @{{evento.eventos_con_idiomas[0].edicion != null ? '-':''}} @{{evento.eventos_con_idiomas[0].edicion}}</h4>
                            <p class="text-justify">
                                @{{evento.eventos_con_idiomas[0].descripcion | limitTo:400}}...
                            </p>
                            <br>
                            <p class="text-left">
                                <button class="btn btn-@{{evento.estado ? 'danger' : 'success'}}" ng-click="desactivarActivar(evento)">@{{evento.estado ? 'Desactivar' : 'Activar'}}</button>
                                <a href="/administradoreventos/idioma/@{{evento.id}}/@{{traduccion.idioma.id}}" ng-repeat="traduccion in evento.eventos_con_idiomas"> @{{traduccion.idioma.culture}}</a>
                                <a href="javascript:void(0)" ng-click="modalIdioma(evento)" ng-if="evento.eventos_con_idiomas.length < idiomas.length"> <span class="glyphicon glyphicon-plus"></span></a>
                                <a href="/administradoreventos/editar/@{{evento.id}}"> <span class="glyphicon glyphicon-pencil"></span></a>
                            </p>
                        </div>
                    </li>
                </ul>
                <div class="alert alert-warning" role="alert" ng-show="eventos.length == 0 || (eventos|filter:busquedaEvento(prop.search)).length == 0">No hay resultados disponibles <span ng-show="(eventos|filter:busquedaEvento(prop.search)).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="pagination_eventos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
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
                <h4 class="modal-title">Nuevo idioma para el evento</h4>
                </div>
                <div class="modal-body">
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idioma">Elija un idioma</label>
                        <select ng-model="idiomaEditSelected" ng-options="idioma.id as idioma.nombre for idioma in idiomas|idiomaFilter:eventoEdit.eventos_con_idiomas" class="form-control">
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
<script src="{{asset('/js/administrador/eventos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/services.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/app.js')}}"></script>
@endsection