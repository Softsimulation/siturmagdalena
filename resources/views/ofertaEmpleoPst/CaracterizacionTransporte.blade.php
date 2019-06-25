@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Caracterización de transporte :: SITUR Magdalena')

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

@section('TitleSection', 'Caracterización de transporte')

@section('Progreso', '30%')

@section('NumSeccion', '30%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="caracterizacionTransporteCtrl"')

@section('content')

<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores">
            -@{{error[0]}}
        </div>
    </div>
    <form name="caracterizacionForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Con que tipo de transporte cuenta?</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccion Multiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-true-value="1" ng-model="transporte.Terrestre"> Terrestre
                            </label>
                            
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-true-value="2" ng-model="transporte.Aereo"> Aéreo
                            </label>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-true-value="3" ng-model="transporte.Maritimo"> Marítimo
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" ng-if="transporte.Terrestre">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Terrestre Municipal</b></h3>
            </div>
            <div class="panel-footer"><b>Campo numero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="vehiculosTerrestre">¿Con cuantos vehículos cuenta la empresa para el transporte de pasajeros?</label>
                            <input class="form-control" type="number" id="vehiculosTerrestre" name="vehiculosTerrestre" ng-model="transporte.VehiculosTerrestre" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.vehiculosTerrestre.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosTerrestre.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosTerrestre.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="personasVehiculosTerrestre">¿Cuantas personas pueden transportar máximo su flota de vehículos?</label>
                            <input class="form-control" type="number" id="personasVehiculosTerrestre" name="personasVehiculosTerrestre" ng-model="transporte.PersonasVehiculosTerrestre" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.personasVehiculosTerrestre.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosTerrestre.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosTerrestre.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success" ng-if="transporte.Aereo">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Aéreo</b></h3>
            </div>
            <div class="panel-footer"><b>Campo numero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="vehiculosAereo">¿Con cuantos vehículos cuenta la empresa para el transporte de pasajeros?</label>
                            <input class="form-control" type="number" id="vehiculosAereo" name="vehiculosAereo" ng-model="transporte.VehiculosAereo" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.vehiculosAereo.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosAereo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosAereo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="personasVehiculosAereo">¿Cuantas personas pueden transportar máximo su flota de vehículos?</label>
                            <input class="form-control" type="number" id="personasVehiculosAereo" name="personasVehiculosAereo" ng-model="transporte.PersonasVehiculosAereo" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.personasVehiculosAereo.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosAereo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosAereo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success" ng-if="transporte.Maritimo">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Marítimo</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCampoNumero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="vehiculosMaritimo">¿Con cuantos vehículos cuenta la empresa para el transporte de pasajeros?</label>
                            <input class="form-control" type="number" id="vehiculosMaritimo" name="vehiculosMaritimo" ng-model="transporte.VehiculosMaritimo" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.vehiculosMaritimo.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosMaritimo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.vehiculosMaritimo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="personasVehiculosMaritimo">¿Cuantas personas pueden transportar máximo su flota de vehículos?</label>
                            <input class="form-control" type="number" id="personasVehiculosMaritimo" name="personasVehiculosMaritimo" ng-model="transporte.PersonasVehiculosMaritimo" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.personasVehiculosMaritimo.$touched">
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosMaritimo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="caracterizacionForm.personasVehiculosMaritimo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                </div>

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

                        <select class="form-control" name="actividadComercial" ng-model="transporte.Comercial" ng-required="true">
                            <option value="" disabled selected>Seleccione</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.actividadComercial.$touched">
                    <span class="label label-danger" ng-show="caracterizacionForm.actividadComercial.$error.required">*El campo es requerido.</span>
                </span>
            </div>

        </div>

        <div class="panel panel-success" ng-if="transporte.Comercial==1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cúantos días en el mes?</b></h3>
            </div>
            <div class="panel-footer"><b>Comprete la información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <input class="form-control" type="number" id="numeroDias" name="numeroDias" ng-model="transporte.NumeroDias" min="1" max="31" ng-required="true" placeholder="Solo números">
                    </div>
                </div>
                <span ng-show="caracterizacionForm.$submitted || caracterizacionForm.numeroDias.$touched">
                    <span class="label label-danger" ng-show="caracterizacionForm.numeroDias.$error.required">*El campo es requerido.</span>
                    <span class="label label-danger" ng-show="caracterizacionForm.numeroDias.$error.number">*El campo debe ser un número.</span>
                    <span class="label label-danger" ng-show="caracterizacionForm.numeroDias.$error.min">*El campo debe ser mayor que 1.</span>
                    <span class="label label-danger" ng-show="caracterizacionForm.numeroDias.$error.max">*El campo debe ser menor o igual que 31.</span>
                </span>

            </div>
        </div>
        
        <div class="row" style="text-align:center">
           
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" ng-disabled="(transporte.Aereo == undefined || transporte.Aereo == false) && (transporte.Terrestre == undefined || transporte.Terrestre == false) && (transporte.Maritimo == undefined || transporte.Maritimo == false)"/>
        </div>
    </form>
    <div class='carga'>

    </div>
</div>
@endsection