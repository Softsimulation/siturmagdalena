
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

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasIdiomaController"')

@section('content')
<div class="col-sm-12">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
    <h1 class="title1">Idioma: @{{idioma.nombre}}</h1>
    <br />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradorrutas')}}">Volver al listado</a>
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
                <div class="row">
                    <div class="form-group col-sm-12" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <input ng-model="ruta.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la ruta (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                            <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                        <label for="descripcion">Descripción</label>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <textarea style="resize: none;" ng-model="ruta.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la ruta (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                            <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="recomendaciones">Recomendaciones</label>
                        <textarea ng-model="ruta.datosGenerales.recomendacion" style="resize: none;" rows="5" name="recomendaciones" id="recomendaciones" class="form-control" placeholder="De 100 a 1,000 caracteres."></textarea>
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
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
@endsection
