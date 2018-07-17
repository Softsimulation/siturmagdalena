@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta oferta y empleo')

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

@section('TitleSection', 'Actividad Comercial')

@section('Progreso', '50%')

@section('NumSeccion', '50%')

@section('app','ng-app="oferta.alquilarTransporte"')

@section('controller','ng-controller="seccionAlquiler"')

@section('content')

<h1>Caracterización del  Alquiler de Vehiculo</h1>

<div class="container" ng-controller="seccionAlquiler">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form name="AlquilerForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Con cuantos vehículos cuenta el establecimiento para el alquiler?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input class="form-control" type="number" id="vehiculosAlquiler" name="vehiculosAlquiler" ng-model="alquiler.VehiculosAlquiler" min="1" ng-required="true" placeholder="Digite su respuesta">
                    </div>
                </div>

                <span ng-show="AlquilerForm.$submitted || AlquilerForm.vehiculosAlquiler.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.vehiculosAlquiler.$error.required">*El campo cuantos vehículos cuenta el establecimiento para el alquiler es requerido.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.vehiculosAlquiler.$error.number">*El campo cuantos vehículos cuenta el establecimiento para el alquiler deber ser un número.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.vehiculosAlquiler.$error.min">*El campo cuantos vehículos cuenta el establecimiento para el alquiler deber ser mayor que 1.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Cuántos vehículos alquila en promedio al día?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente informaciónn</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input class="form-control" type="number" id="promedioDia" name="promedioDia" ng-model="alquiler.PromedioDia" min="1" max="@{{alquiler.VehiculosAlquiler}}" ng-required="true" placeholder="Ingrese solo números">
                    </div>
                </div>

                <span ng-show="AlquilerForm.$submitted || AlquilerForm.promedioDia.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.promedioDia.$error.required">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje es requerido.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.promedioDia.$error.number">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje debe ser un número.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.promedioDia.$error.min">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje debe ser mayor que 1.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.promedioDia.$error.max">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje no puede ser superior que el total de vehículos disponibles.</span>
                    
                </span>
            </div>
        </div>



        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Cuántos vehículos alquiló en total en el trimestre anterior?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input class="form-control" type="number" id="totalTrimestre" name="totalTrimestre" ng-model="alquiler.TotalTrimestre" min="1" ng-required="true" placeholder="Ingrese solo números">
                    </div>
                </div>
                <span ng-show="AlquilerForm.$submitted || AlquilerForm.totalTrimestre.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.totalTrimestre.$error.required">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje es requerido.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.totalTrimestre.$error.number">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje debe ser un número.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.totalTrimestre.$error.min">*El campo cuántos vehículos alquiló en total en el trimestre anterior de viaje debe ser mayor que 1.</span>
                  
                </span>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál es la tarifa promedio para el alquiler de vehículos?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <input class="form-control" type="number" id="Tarifa" name="Tarifa" ng-model="alquiler.Tarifa" min="1000" ng-required="true" placeholder="Ingrese solo números">
                    </div>
                </div>
                <span ng-show="AlquilerForm.$submitted || AlquilerForm.Tarifa.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.Tarifa.$error.required">*El campo cuál es la tarifa promedio para el alquiler de vehículos es requerido.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.Tarifa.$error.number">*El campo cuál es la tarifa promedio para el alquiler de vehículos deber ser un número.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.Tarifa.$error.min">*El campo cuál es la tarifa promedio para el alquiler de vehículos deber ser mayor que $1000.</span>
                </span>
            </div>
        </div>

        <div class="row" style="text-align:center">
          
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Guardar" />
        </div>


    </form>
    <div class='carga'>

    </div>
</div>

@endsection