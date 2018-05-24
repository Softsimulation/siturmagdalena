
@extends('layout._AdminLayout')

@section('title', 'Ver grupo de viaje')

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
        p {
            font-size: 1em;
        }
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            font-size: .9em;
        }
        .row {
            margin: 1em 0 0;
        }
    </style>
@endsection

@section('TitleSection', 'Ver grupo de viaje')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('controller','ng-controller="ver_grupo"')

@section('content')
    

<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <h1 class="title1">Ver grupo de viaje</h1><br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-6">
                <label>Fecha de aplicación</label>
                <p>{{$grupo->fecha_aplicacion}}</p><br />
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6">
                <label>Lugar de aplicación</label>
                <p>{{$grupo->lugar_aplicacion_id}} - {{$grupo->lugaresAplicacionEncuestum->nombre}}</p><br />
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <label>Tipo de viaje</label>
                <p>{{$grupo->tipo_viaje_id}} - {{$grupo->tiposViaje->tiposViajeConIdiomas[0]->nombre}}</p><br />
            </div>
            <div class="col-md-2 col-xs-12 col-sm-6">
                <label>Personas encuestadas</label>
                <p>@{{grupo.personas_encuestadas}}</p><br />
            </div>
        </div>

        <div class="row">
            
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Tamaño del grupo de viaje</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mayores de 15 años PRES</td>
                        <td>@{{grupo.mayores_quince}}</td>
                    </tr>
                    <tr>
                        <td>Menores de 15 años PRES</td>
                        <td>@{{grupo.menores_quince}}</td>
                    </tr>
                    <tr>
                        <td>Mayores de 15 años NO PRES</td>
                        <td>@{{grupo.mayores_quince_no_presentes}}</td>
                    </tr>
                    <tr>
                        <td>Menores de 15 años NO PRES</td>
                        <td>@{{grupo.menores_quince_no_presentes}}</td>
                    </tr>
                    <tr>
                        <td>Personas del Magdalena</td>
                        <td>@{{grupo.personas_magdalena}}</td>
                    </tr>
                    <tr>
                        <td><span style="color:black;font-weight:bold">Total</span></td>
                        <td>@{{total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <label>Encuestas del grupo</label><br />
            <table class="table table-hover" ng-if="grupo.visitantes.length != 0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="e in grupo.visitantes">
                        <td>@{{e.id}}</td>
                        <td>@{{e.nombre}}</td>
                        <td ng-if="e.sexo">M</td><td ng-if="!e.sexo">F</td>
                        <td>@{{e.email}}</td>
                        <td>@{{e.historial_encuestas[0].estados_encuesta.nombre}}</td>
                        <td><a href="/turismoreceptor/editardatos/@{{e.id}}">Editar</a></td>
                    </tr>
                </tbody>
            </table><br />
            <p ng-if="grupo.visitantes.length == 0">No hay encuestas digitadas</p><br />
            
        </div>
        <div class="row" style="text-align: center;">
            <a href="/turismoreceptor/datosencuestados" class="btn btn-primary">Crear encuesta</a>
            <a href="/grupoviaje/editar/{{$id}}" class="btn btn-success">Editar grupo</a>
        </div>
    </div>
    
    <div class='carga'>

    </div>
</div>

@endsection


