
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

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesIdiomaController"')

@section('content')
<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
    <h1 class="title1">Idioma: @{{idioma.nombre}}</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <!--Información básica-->
        <h2>Datos de la atracción</h2>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Los campos marcados con <strong>*</strong> son obligatorios.
        </div>
        <form novalidate role="form" name="editarIdiomaForm">
            <div class="row">
                <div class="form-group col-sm-12" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                    <label for="nombre">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">*</span>
                        <input ng-model="atraccion.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la atracción (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                    <label for="descripcion">Descripción</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">*</span>
                        <textarea style="resize: none;" ng-model="atraccion.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la atracción (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="actividad">Periodo de actividad e inactividad</label>
                        <textarea style="resize: none;" rows="2" class="form-control" id="actividad" name="actividad" ng-model="atraccion.datosGenerales.actividad" placeholder="Máximo 1,000 caracteres."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="horario">Horario</label>
                        <input ng-model="atraccion.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="recomendaciones">Recomendaciones</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="recomendaciones" name="recomendaciones" ng-model="atraccion.datosGenerales.recomendaciones" placeholder="Máximo 1,000 caracteres."></textarea>
                </div>
                <div class="form-group col-sm-4">
                    <label for="reglas">Reglas</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="reglas" name="reglas" ng-model="atraccion.datosGenerales.reglas" placeholder="Reglas o normas que deben seguir los visitantes. Máximo 1,000 caracteres."></textarea>
                </div>
                <div class="form-group col-sm-4">
                    <label for="como_llegar">Como llegar</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="como_llegar" name="como_llegar" ng-model="atraccion.datosGenerales.como_llegar" placeholder="Pasos o indicaciones para llegar al lugar. Máximo 1,000 caracteres."></textarea>
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