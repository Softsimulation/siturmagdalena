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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Con cuántos vehículos cuenta el establecimiento para alquilar diariamente?</b></h3>
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

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>  ¿El establecimiento tuvo actividad comercial?</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccione una opción</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <select class="form-control" name="actividadComercial" ng-model="alquiler.Comercial" ng-required="true">
                            <option value="" disabled selected>Seleccione</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <span ng-show="AlquilerForm.$submitted || AlquilerForm.actividadComercial.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.actividadComercial.$error.required">*El campo es requerido.</span>
                </span>
            </div>

        </div>

        <div class="panel panel-success" ng-if="alquiler.Comercial==1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cúantos días en el mes?</b></h3>
            </div>
            <div class="panel-footer"><b>Comprete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <input class="form-control" type="number" id="numeroDias" name="numeroDias" ng-model="alquiler.NumeroDias" min="1" max="31" ng-required="true" placeholder="Solo números">
                    </div>
                </div>
                <span ng-show="AlquilerForm.$submitted || AlquilerForm.numeroDias.$touched">
                    <span class="label label-danger" ng-show="AlquilerForm.numeroDias.$error.required">*El campo es requerido.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.numeroDias.$error.number">*El campo debe ser un número.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.numeroDias.$error.min">*El campo debe ser mayor que 1.</span>
                    <span class="label label-danger" ng-show="AlquilerForm.numeroDias.$error.max">*El campo debe ser menor o igual que 31.</span>
                </span>

            </div>
        </div>


        <div class="row" style="text-align:center">
          
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Guardar" />
        </div>


    </form>
    <div class='carga'>

    </div>


@endsection