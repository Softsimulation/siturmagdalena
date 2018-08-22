
@extends('layout._AdminLayout')

@section('title', 'Editar idioma')

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

@section('TitleSection', 'Editar idioma')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="eventosApp"')

@section('controller','ng-controller="eventosIdiomaController"')

@section('content')
<div class="col-sm-12">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
    <h1 class="title1">Idioma: @{{idioma.nombre}}</h1>
    <br />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradoreventos')}}">Volver al listado</a>
    </div>
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <!--Información básica-->
        <h2>Datos del evento</h2>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                    <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Los campos marcados con asterisco son obligatorios.</strong> </div>
                </div>
            </div>
        </div>
        <form novalidate role="form" name="editarIdiomaForm">
            <div class="row">
                <div class="form-group col-sm-8" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                        <input ng-model="evento.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del evento (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="edicion">Edición</label>
                    <input ng-model="evento.datosGenerales.edicion" type="text" name="edicion" id="edicion" class="form-control" placeholder="Máximo 50 caracteres."/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                    <label for="descripcion">Descripción</label>
                    <div class="input-group">
                        <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                        <textarea style="resize: none;" ng-model="evento.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del evento (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="horario">Horario</label>
                    <input ng-model="evento.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
