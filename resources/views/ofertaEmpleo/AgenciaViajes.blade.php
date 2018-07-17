
@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Agencias de viaje :: SITUR Magdalena')

@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
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
        .checkbox .form-group {
            display: inline-block;
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

@section('TitleSection', 'Agencias de viaje')

@section('Progreso', '30%')

@section('NumSeccion', '30%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="caracterizacionAgenciaViajesCtrl"')


@section('content')

<div class="container">
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    
    </div>
    <input type="hidden" ng-model="encuesta.id" ng-init="encuesta.id={{$id}}" />
    <form role="form" name="DatosForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">               
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Qué tipo de servicios presta la agencia de viajes?</b></h3>
            </div>
            <div class="panel-footer"><b>Selección Múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="servicio in servicios">
                            <label>
                                <input type="checkbox" ng-model="servicios" name="servicios" checklist-model="encuesta.TipoServicios" checklist-value="servicio.id" >@{{servicio.nombre}}
                                <input type="text" class="form-control" name="otro" ng-model="encuesta.Otro" ng-if="servicio.id == 5" placeholder="Ingrese otro servicio"/> 
                            </label>

                        </div>
                        
                        <!-- P6Alert1. El campo motivo principal es requerido-->
                        <span ng-show="DatosForm.$submitted || DatosForm.servicios.$touched">
                            <span class="label label-danger" ng-show="encuesta.TipoServicios.length  == 0">*Debe seleccionar algún tipo de servicio</span>
                        </span>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿La Agencia ofrece planes turísticos con destino Santa Marta y/o Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Selección única opción</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select name="planes" ng-model="encuesta.Planes" class="form-control" ng-required="true">
                            <option value="" disabled>Presione aquí para seleccionar su respuesta</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                        <span ng-show="DatosForm.$submitted || DatosForm.planes.$touched">
                            <!-- P6P2Alert1. La duración de la parada es requerida cuando el motivo es transito-->
                            <span class="label label-danger" ng-show="DatosForm.planes.$error.required">*Debe seleccionar si ofrece planes o no</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection
