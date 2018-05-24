
@extends('layout._encuestaInternoLayout')

@section('Title','Transporte utilizado - Encuesta interno y emisor :: SITUR Atlántico')


@section('estilos')
    <style>
        .title-section {
            background-color: #16469e !important;
        }
    </style>
    <style>
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
@section('TitleSection','Transporte utilizado')
@section('Progreso','60%')
@section('NumSeccion','60%')
@section('Control','ng-controller="transporte"')
@section('contenido')
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form role="form" name="transForm" novalidate>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Qué tipo de transporte utilizó para recorrer-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál fue el medio de transporte utilizado para recorrer la mayor distancia durante el viaje?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in transportes" ng-if="item.id != 10">
                            <label>
                                <input type="radio" name="mover" ng-value="item.id" ng-model="transporte.Mover" ng-required="true"> @{{item.nombre}}
                            </label>
                            <i ng-if="item.id==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoTransporte"
                               style="text-align:right;">
                            </i>
                        </div>
                    </div>
                </div>
                <span ng-show="transForm.$submitted || transForm.mover.$touched">
                    <span class="label label-danger" ng-show="transForm.mover.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>

        <div ng-if="transporte.Mover == 6" class="panel panel-success">
            <div class="panel-heading">
                <!-- Nombre de la empresa de transporte-->
                <h3 class="panel-title"><b> ¿Cuál es el nombre de la empresa de transporte terrestre de pasajeros utilizados desde una ciudad de Colombia al Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="empresa" class="form-control" ng-model="transporte.Empresa" placeholder="Digite la empresa" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="#" class="btn btn-raised btn-default">{{trans('resources.EncuestaBtnAnterior')}}</a>
            <input type="submit" class="btn btn-raised btn-success" value="{{trans('resources.EncuestaBtnSiguiente')}}" ng-click="guardar()">
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
@endsection