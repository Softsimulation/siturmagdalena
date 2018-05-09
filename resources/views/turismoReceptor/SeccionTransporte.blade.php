@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

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

    </style>
@endsection

@section('TitleSection', 'Transporte')

@section('Progreso', '33.33%')

@section('NumSeccion', '33%')

@section('controller','ng-controller="transporte"')

@section('content')
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error.errores[0].ErrorMessage}}
        </div>
    </div>
    <form role="form" name="transForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Qué tipo de transporte utilizó para llegar al departamento del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaTransporteP1</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in transportes" ng-if="item.Id != 10">
                            <label>
                                <input type="radio" name="llegar" ng-value="item.Id" ng-model="transporte.Llegar" ng-required="true"> @{{item.Nombre}}
                                <i ng-if="item.Id==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoTransporte"
                                   style="text-align:right;">
                                </i>
                            </label>
                            
                        </div>
                        
                    </div>
                </div>
                <span  ng-show="transForm.$submitted || transForm.llegar.$touched">
                    <span class="label label-danger" ng-show="transForm.llegar.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="transporte.Llegar == 6">
            <div class="panel-heading">
                <!-- ¿Cuál es el nombre de la empresa de transporte terrestre de pasajeros utilizado desde una ciudad de Colombia al Magdalena?-->
                <h3 class="panel-title"><b> @Resource.EncuestaTransporteP2</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="empresa" ng-minlength="1" ng-maxlength="150" class="form-control" ng-model="transporte.Empresa" placeholder="@Resource.EncuestaTransporteP2Input1"/>
                    </div>
                </div>
                <span  ng-show="transForm.$submitted || transForm.empresa.$touched">
                    <span class="label label-danger" ng-show="transForm.empresa.$error.maxlength">* El campo no debe superar los 150 caracteres.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Cuál fue el transporte utilizado la mayor parte del tiempo para desplazarse por el departamento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaTransporteP3</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in transportes" ng-if="item.Id != 9">
                            <label>
                                <input type="radio" name="mover" ng-value="item.Id" ng-model="transporte.Mover" ng-required="true"> @{{item.Nombre}}
                                <i ng-if="item.Id==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoTransporte"
                                   style="text-align:right;">
                                </i>
                            </label>

                        </div>
                    </div>
                </div>
                <span  ng-show="transForm.$submitted || transForm.mover.$touched">
                    <span class="label label-danger" ng-show="transForm.mover.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="transporte.Mover ==5">
            <div class="panel-heading">
                <!-- >El alquiler de vehículo fue realizado en:-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaTransporteP4</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in lugares">
                            <label>
                                <input type="radio" name="alquiler" ng-value="item.Id" ng-model="transporte.Alquiler"> @{{item.Nombre}}
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" style="text-align:center">
            <a href="/EncuestaReceptor/SeccionEstanciayvisitados/@ViewBag.id" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="@Resource.EncuestaBtnSiguiente" ng-click="guardar()">
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>

@endsection

