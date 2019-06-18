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

@section('TitleSection', 'Ocupacion comercial de agencias operadoras')

@section('Progreso', '50%')

@section('NumSeccion', '50%')

@section('app','ng-app="oferta.agenciasOperadoras"')

@section('controller','ng-controller="ocupacioncAgencias"')

@section('content')
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="ocupacionForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Ocupación comercial</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
            <div class="panel panel-body">
                <div class="row" style="overflow-x: auto">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Número total de personas</th>
                                <th>¿Qué porcentaje se prestó a residentes en Colombia excluyendo magdalenenses?</th>
                                <th>¿Qué porcentaje se prestó a residentes del extranjero?</th>
                                <th>¿Qué porcentaje se prestó a residentes en el Magdalena?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>¿A cuántas personas le prestaron servicios turísticos?</td>
                                <td>
                                    <input type="number" class="form-control" style="text-align: right;" name="totalP" min="0" ng-model="agencia.totalP" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number" class="form-control" style="text-align: right;" name="porcentajeC" min="0" max="100" ng-model="agencia.porcentajeC" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number" class="form-control" style="text-align: right;" name="porcentajeE" min="0" max="100" ng-model="agencia.porcentajeE" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number" class="form-control" style="text-align: right;" name="porcentajeM" min="0" max="100" ng-model="agencia.porcentajeM" ng-required="true" placeholder="Solo números"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <span ng-show="ocupacionForm.$submitted || ocupacionForm.totalP.$touched">
                        <span class="label label-danger" ng-show="ocupacionForm.totalP.$error.required">* El número total de personas es requerido.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.totalP.$error.number">* El campo número total de personas debe ser solo números.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.totalP.$error.min">* El campo número total de personas recibe solo números iguales o mayores que 0.</span>
                    </span>
                    <span ng-show="ocupacionForm.$submitted || ocupacionForm.porcentajeC.$touched">
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeC.$error.required">* El campo porcentaje prestado a residentes Colombianos exluyendo magdalenenses es requerido.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeC.$error.number">* El campo porcentaje prestado a residentes Colombianos exluyendo magdalenenses debe ser solo números.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeC.$error.min">* El campo porcentaje prestado a residentes Colombianos exluyendo magdalenenses recibe solo números iguales o mayores que 0.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeC.$error.max">* El campo porcentaje prestado a residentes Colombianos exluyendo magdalenenses recibe solo números iguales o mayores que 0 y menores o iguales que 100.</span>
                    </span>
                    <span ng-show="ocupacionForm.$submitted || ocupacionForm.porcentajeE.$touched">
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeE.$error.required">* El campo porcentaje prestado a residentes en el extranjero es requerido.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeE.$error.number">* El campo porcentaje prestado a residentes en el extranjero debe ser solo números.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeE.$error.min">* El campo porcentaje prestado a residentes en el extranjero recibe solo números iguales o mayores que 0.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeE.$error.max">* El campo porcentaje prestado a residentes en el extranjero recibe solo números iguales o mayores que 0 y menores o iguales que 100.</span>
                    </span>
                    <span ng-show="ocupacionForm.$submitted || ocupacionForm.porcentajeM.$touched">
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeM.$error.required">* El campo porcentaje prestado a residentes en el Magdalena es requerido.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeM.$error.number">* El campo porcentaje prestado a residentes en el Magdalena debe ser solo números.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeM.$error.min">* El campo porcentaje prestado a residentes en el Magdalena recibe solo números iguales o mayores que 0.</span>
                        <span class="label label-danger" ng-show="ocupacionForm.porcentajeM.$error.max">* El campo porcentaje prestado a residentes en el Magdalena recibe solo números iguales o mayores que 0 y menores o iguales que 100.</span>
                    </span>
                    <span ng-show="ocupacionForm.$submitted">
                        <span class="label label-danger" ng-show="(agencia.porcentajeC + agencia.porcentajeE + agencia.porcentajeM) != 100">* La suma de los valores porcentuales debe ser igual que 100.</span>
                    </span>
                </div>
            </div>
        </div>
        

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/caracterizacionagenciasoperadoras/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" ng-click="guardar()" class="btn btn-raised btn-success" value="Siguiente" />
        </div>
    </form>

    <div class='carga'>

    </div>
</div>

@endsection