@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Oferta de transporte :: SITUR Magdalena')

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
        input[type='number'] {
            text-align: right;
        }
    </style>
@endsection

@section('TitleSection', 'Oferta de transporte')

@section('Progreso', '50%')

@section('NumSeccion', '50%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="ofertaTransporteCtrl"')

@section('content')
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form name="ofertaForm" novalidate>
        <div class="panel panel-success" ng-if="tipos.indexOf(1)!=-1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Terrestre municipal</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCampoNumero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="totalTerrestre">¿Cuántas personas transportaron en total, en el mes anterior (promedio)?</label>
                            <input class="form-control" type="number" id="totalTerrestre" name="totalTerrestre" ng-model="transporte.TotalTerrestre" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.totalTerrestre.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.totalTerrestre.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.totalTerrestre.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="tarifaTerrestre">¿Cuál es la tarifa promedio para el alquiler de vehículos?</label>
                            <input class="form-control" type="number" id="tarifaTerrestre" name="tarifaTerrestre" ng-model="transporte.TarifaTerrestre" min="1000" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.tarifaTerrestre.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.tarifaTerrestre.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaTerrestre.$error.number">*El campo debe ser un número.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaTerrestre.$error.min">*El campo debe ser mayor a $1,000.</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success" ng-if="tipos.indexOf(2)!=-1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Aéreo</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCampoNumero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="totalAereo">¿Cuántas personas transportaron en total, en el mes anterior (promedio)?</label>
                            <input class="form-control" type="number" id="totalAereo" name="totalAereo" ng-model="transporte.TotalAereo" min="1" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.totalAereo.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.totalAereo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.totalAereo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="tarifaAereo">¿Cuál es la tarifa promedio para el alquiler de vehículos?</label>
                            <input class="form-control" type="number" id="tarifaAereo" name="tarifaAereo" ng-model="transporte.TarifaAereo" min="1000" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.tarifaAereo.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.tarifaAereo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaAereo.$error.number">*El campo debe ser un número.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaAereo.$error.min">*El campo debe ser mayor a $1,000.</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="tipos.indexOf(3)!=-1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Marítimo</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="totalMaritimo">¿Cuántas personas transportaron en total, en el mes anterior (promedio)?</label>
                            <input class="form-control" type="number" id="totalMaritimo" name="totalMaritimo" ng-model="transporte.TotalMaritimo" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.totalMaritimo.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.totalMaritimo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.totalMaritimo.$error.number">*El campo debe ser un número.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="tarifaMaritimo">¿Cuál es la tarifa promedio para el alquiler de vehículos?</label>
                            <input class="form-control" type="number" id="tarifaMaritimo" name="tarifaMaritimo" ng-model="transporte.TarifaMaritimo" min="1000" ng-required="true" placeholder="Digite su respuesta">
                            <span ng-show="ofertaForm.$submitted || ofertaForm.tarifaMaritimo.$touched">
                                <span class="label label-danger" ng-show="ofertaForm.tarifaMaritimo.$error.required">*El campo es requerido.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaMaritimo.$error.number">*El campo debe ser un número.</span>
                                <span class="label label-danger" ng-show="ofertaForm.tarifaMaritimo.$error.min">*El campo debe ser mayor a $1,000.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/caracterizaciontransporte/{{$id}}" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>

    </form>
</div>
@endsection