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
        .checkbox .form-group {
            display: inline-block;
        }
    </style>
@endsection

@section('TitleSection', 'Actividad Comercial')

@section('Progreso', '30%')

@section('NumSeccion', '30%')

@section('app','ng-app="oferta.agenciasOperadoras"')


@section('controller','ng-controller="caracterizacionAgencia"')


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
    
        <form role="form" name="carForm" novalidate>
    
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Cuántos planes turísticos ofrece la empresa</b></h3>
                </div>
                <div class="panel-footer"><b>Complete la siguiente información</b></div>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" name="planes" class="form-control" min="1" ng-model="agencia.planes" ng-required="true" placeholder="Solo números"/>
                        </div>
                        <span ng-show="carForm.$submitted || carForm.planes.$touched">
                            <span class="label label-danger" ng-show="carForm.planes.$error.required">* El campo es requerido.</span>
                            <span class="label label-danger" ng-show="carForm.planes.$error.number">* Debe introducir solo números.</span>
                            <span class="label label-danger" ng-show="carForm.planes.$error.min">* Solo números iguales o mayores que 1.</span>
                        </span>
                    </div>
                </div>
            </div>
    
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> De las siguientes actividades deportivas, ¿Cuáles ofrece su empresa?</b></h3>
                </div>
                <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox" ng-repeat="actividad in actividades">
                                <label>
                                    <input type="checkbox" name="actividad" checklist-model="agencia.actividades" checklist-value="actividad.id"> @{{actividad.nombre}}
                                </label>
                                <span ng-if="actividad.id==15"><input type="text" name="otraD" style="display: inline-block;" class="form-control"  placeholder="Escriba su otra actividad deportiva" ng-model="agencia.otraD" ng-change="validarOtro(0)" ng-required="agencia.actividades.indexOf(15) != -1"/></span>
                            </div>
                            
                        </div>
                        <span ng-show="carForm.$submitted || carForm.actividad.$touched || carForm.otraD.$touched">
                            <span class="label label-danger" ng-show="agencia.actividades.length == 0">* El campo es requerido.</span>
                            <span class="label label-danger" ng-show="carForm.otraD.$error.required">* Debe escribir cuál fue la otra actividad deportiva.</span>
                        </span>
                    </div>
                </div>
            </div>
    
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b> Fuera de la actividades deportivas, ¿Qué otras actividades recreativas y culturales ofrece la empresa? </b></h3>
                </div>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="otraC" class="form-control" ng-model="agencia.otraC" placeholder="Ingrese aquí su respuesta"/>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Mencione por favor, qué tours o recorridos ofrece su compañía</b></h3>
                </div>
                <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox" ng-repeat="tour in toures">
                                <label>
                                    <input type="checkbox" name="tour" checklist-model="agencia.toures" checklist-value="tour.id"> @{{tour.nombre}}
                                </label>
                                <span ng-if="tour.id==14"><input type="text" name="otroT" style="display: inline-block;" class="form-control" placeholder="Escriba el otro tour" ng-model="agencia.otroT" ng-change="validarOtro(1)" ng-required="agencia.toures.indexOf(14) != -1" /></span>
                            </div>
    
                        </div>
                        <span ng-show="carForm.$submitted || carForm.tour.$touched || carForm.otroT.$touched">
                            <span class="label label-danger" ng-show="agencia.toures.length == 0">* El campo es requerido.</span>
                            <span class="label label-danger" ng-show="carForm.otroT.$error.required">* Debe escribir cuál es el otro tour.</span>
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

