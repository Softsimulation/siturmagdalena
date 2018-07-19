
@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Actividad comercial :: SITUR Magdalena')

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

@section('Progreso', '20%')

@section('NumSeccion', '20%')

@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="seccionActividadComercialAdmin"')

@section('content')
 
    <input type="hidden" ng-model="Id" ng-init="Id={{$Id}}" />
    <input type="hidden" ng-model="Sitio" ng-init="Sitio={{$Sitio}}" />
    <input type="hidden" ng-model="Anio" ng-init="Anio={{$Anio}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form name="ActividadForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>  ¿El establecimiento tuvo actividad comercial?</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionOpcion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <select class="form-control" name="actividadComercial" ng-model="actividad.Comercial" ng-required="true">
                            <option value="" disabled selected>@Resource.EncuestaMsgListaDesplegable</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <span ng-show="ActividadForm.$submitted || ActividadForm.actividadComercial.$touched">
                    <span class="label label-danger" ng-show="ActividadForm.actividadComercial.$error.required">*El campo es requerido.</span>
                </span>
            </div>

        </div>

        <div class="panel panel-success" ng-if="actividad.Comercial==1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cúantos días en el mes?</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <input class="form-control" type="number" id="numeroDias" name="numeroDias" ng-model="actividad.NumeroDias" min="1" max="31" ng-required="true" placeholder="Solo números">
                    </div>
                </div>
                <span ng-show="ActividadForm.$submitted || ActividadForm.numeroDias.$touched">
                    <span class="label label-danger" ng-show="ActividadForm.numeroDias.$error.required">*El campo es requerido.</span>
                    <span class="label label-danger" ng-show="ActividadForm.numeroDias.$error.number">*El campo debe ser un número.</span>
                    <span class="label label-danger" ng-show="ActividadForm.numeroDias.$error.min">*El campo debe ser mayor que 1.</span>
                    <span class="label label-danger" ng-show="ActividadForm.numeroDias.$error.max">*El campo debe ser menor o igual que 31.</span>
                </span>

            </div>
        </div>

        <div class="row" style="text-align:center">
            <a class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>


@endsection
