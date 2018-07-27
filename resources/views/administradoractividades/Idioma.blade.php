
@extends('layout._AdminLayout')

@section('title', 'Editar actividad')

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

@section('TitleSection', 'Editar idioma de la actividad')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="actividadesApp"')

@section('controller','ng-controller="actividadesIdiomaController"')

@section('content')
<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
    <h1 class="title1">Idioma: @{{idioma.nombre}}</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <!--Información básica-->
        <div id="info" class="tab-pane fade in active">
            <h2>Datos de la actividad</h2>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Los campos marcados con <strong>*</strong> son obligatorios.
            </div>
            <form novalidate role="form" name="editarActividadForm">
                <div class="row">
                    <div class="form-group col-sm-12" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.nombre.$touched) && crearActividadForm.nombre.$error.required}">
                        <label for="nombre">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">*</span>
                            <input ng-model="actividad.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la actividad (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.descripcion.$touched) && crearActividadForm.descripcion.$error.required}">
                        <label for="descripcion">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">*</span>
                            <textarea style="resize: none;" ng-model="actividad.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la actividad (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                        </div>
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
</div>
@endsection

@section('javascript')
<script src="{{asset('/js/administrador/actividades/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/services.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
@endsection
