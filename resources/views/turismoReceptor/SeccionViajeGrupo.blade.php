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

@section('TitleSection', 'Viaje en grupo')

@section('Progreso', '49.99%')

@section('NumSeccion', '50%')

@section('controller','ng-controller="viaje_grupo"')

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
    <form role="form" name="grupoForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Cuántas personas incluyéndose usted, realizaron juntos el viaje desde la llegada hasta la salida del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaViajeGrupoP1</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCampoNumero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" name="numero" class="form-control" min="1"  ng-model="grupo.Numero" ng-change="verifica()" placeholder="@Resource.EncuestaViajeGrupoP1Input1" ng-required="true"/>
                    </div>
                </div>
                <span ng-show="grupoForm.$submitted || grupoForm.numero.$touched">
                    <span class="label label-danger" ng-show="grupoForm.numero.$error.required">* El campo es requerido.</span>
                    <span class="label label-danger" ng-show="grupoForm.numero.$error.number">* Debe introducir solo numeros.</span>
                    <span class="label label-danger" ng-show="!grupoForm.numero.$valid">* Solo numeros iguales o mayores que uno.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Quiénes eran esas personas?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaViajeGrupoP2</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="item in viaje_grupos">
                            <label>
                                <input type="checkbox" name="personas" checklist-model="grupo.Personas" checklist-value="item.Id"  ng-disabled="(grupo.Numero == 1 && item.Id != 1) || (grupo.Numero > 1 && item.Id == 1) || grupo.Numero == null || grupo.Numero < 1" ng-change="vchek(item.Id)" /> @{{item.Nombre}}
                            </label>
                             <input type="text" name="otro" class="form-control" ng-if="item.Id == 12" ng-model="grupo.Otro" ng-disabled="grupo.Numero == null || grupo.Numero <= 1" ng-change="verificarOtro()"  ng-required="grupo.Personas.indexOf(12) != -1" />
                        </div>
                    </div>
                </div>
                <span ng-show="grupoForm.$submitted || grupoForm.personas.$touched">
                    <span class="label label-danger" ng-show="grupo.Personas.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="grupoForm.otro.$error.required">* Debe escribir quien fue el otro acompañante.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="buscar(grupo.Personas, 9)">
            <div class="panel-heading">
                <!-- ¿Cuántos eran los otros turístas?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaViajeGrupoP3</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCampoNumero</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="number" name="numero_otros" min="1" class="form-control" ng-model="grupo.Numero_otros" placeholder="Presione aquí para ingresar el número de otros turístas" ng-required="grupo.Personas.indexOf(9) != -1"/>
                    </div>
                </div>
                <span ng-show="grupoForm.$submitted || grupoForm.numero_otros.$touched">
                    <span class="label label-danger" ng-show="grupoForm.numero_otros.$error.required">* Debe ingreser cuantos eran los otros turistas.</span>
                    <span class="label label-danger" ng-show="grupoForm.numero_otros.$error.number">* Debe introducir solo numeros.</span>
                    <span class="label label-danger" ng-show="!grupoForm.numero_otros.$valid">* Solo numeros iguales o mayores que uno.</span>
                </span>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <a href="/EncuestaReceptor/SeccionTransporte/@ViewBag.id" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="@Resource.EncuestaBtnSiguiente" ng-click="guardar()">
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
@endsection

