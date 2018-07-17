
@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Caracterización alimentos :: SITUR Magdalena')

@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
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
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        label {
            color: dimgray;
        }
        .form-group label {
            font-size: 1em!important;
        }
        .label.label-danger {
            font-size: .9em;
            font-weight: 400;
            padding: .16em .5em;
        }
    </style>
@endsection

@section('TitleSection', 'Caracterización alimentos')

@section('Progreso', '30%')

@section('NumSeccion', '30%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="caracterizacionAlimentosCtrl"')

@section('content')

<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" >
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="carAlim" novalidate>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Especialidad del establecimiento:</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionOpcion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select id="especialidad" name="especialidad" class="form-control" ng-options="especialidad.id as especialidad.nombre for especialidad in especialidades" ng-model="alimentos.especialidad" ng-required="true">
                            <option value="" disabled>Seleccione una especialidad</option>
                        </select>
                    </div>
                </div>
                <span ng-show="carAlim.$submitted || carAlim.especialidad.$touched">
                    <span class="label label-danger" ng-show="carAlim.especialidad.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>

        

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿En el restaurante se sirven principalmente platos de comida o unidades de comida?</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionOpcion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select name="sirve" class="form-control" ng-options="item.id as item.nombre for item in actividades_servicios" ng-model="alimentos.sirvePlatos" ng-required="true">
                            <option value="" disabled>Seleccione un valor</option>
                        </select>
                    </div>
                </div>
                <span ng-show="carAlim.$submitted || carAlim.sirve.$touched">
                    <span class="label label-danger" ng-show="carAlim.sirve.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Número de mesas disponibles</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" name="mesas" class="form-control" min="1" ng-model="alimentos.mesas" ng-required="true" placeholder="Ingrese solo números"/>
                    </div>
                    <span ng-show="carAlim.$submitted || carAlim.mesas.$touched">
                        <span class="label label-danger" ng-show="carAlim.mesas.$error.required">* El campo es requerido.</span>
                        <span class="label label-danger" ng-show="carAlim.mesas.$error.number">* Debe introducir solo números.</span>
                        <span class="label label-danger" ng-show="!carAlim.mesas.$valid">* Solo números iguales o mayores que 1.</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Número de asientos disponibles</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" name="asientos" class="form-control" min="1" ng-model="alimentos.asientos" ng-required="true" placeholder="Ingrese solo números"/>
                    </div>
                    <span ng-show="carAlim.$submitted || carAlim.asientos.$touched">
                        <span class="label label-danger" ng-show="carAlim.asientos.$error.required">* El campo es requerido.</span>
                        <span class="label label-danger" ng-show="carAlim.asientos.$error.number">* Debe introducir solo números.</span>
                        <span class="label label-danger" ng-show="!carAlim.asientos.$valid">* Solo números iguales o mayores que 1.</span>
                    </span>
                </div>
            </div>
        </div>

        

        <div class="row" style="text-align:center">
            <input type="submit" ng-click="guardar()" class="btn btn-raised btn-success" value="Siguiente" />
        </div>
    </form>

    <div class='carga'>

    </div>
</div>
@endsection