@extends('layout._sostenibilidadPstLayout')

@section('title', 'SOSTENIBILIDAD DE LAS ACTIVIDADES TURÍSTICAS - PRESTADORES SERVICIOS TURÍSTICOS (PST)')

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
    </style>
@endsection

@section('TitleSection', 'COMPONENTE AMBIENTAL')

@section('Progreso', '66.66%')

@section('NumSeccion', '66.66%')

@section('controller','ng-controller="ambientalController"')

@section('content')
    
<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form role="form" name="datosForm" novalidate>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.11 ¿Cuáles  áreas  protegidas promociona en @{{proveedor.razon_social}}?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea ng-model="encuesta.areas_promociona" placeholder="Presione aquí para ingresar su respuesta" class="form-control" name="areas_promociona" required></textarea>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.areas_promociona.$touched">
                    <span class="label label-danger" ng-show="datosForm.areas_promociona.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.12 ¿Qué  nivel  de  conocimiento  tienen  los  empleados  sobre  las  especies  de  flora  y  fauna  características  de @{{proveedor.razon_social}}? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td ng-repeat="item in criteriosCalificacion">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" id="criterios_calificacion_id" value="@{{item.id}}" name="criterios_calificacion_id" required ng-model="encuesta.criterios_calificacion_id">
                                                @{{item.nombre}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.criterios_calificacion_id.$touched">
                    <span class="label label-danger" ng-show="datosForm.criterios_calificacion_id.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P. 12.1 ¿Sabe si @{{proveedor.razon_social}} tiene una guía que caracterice la flora, fauna y especies en vía de extinción para la conservación de los mismos? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_guia" value="1" name="tiene_guia" required ng-model="encuesta.tiene_guia">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_guia" value="0" name="tiene_guia" required ng-model="encuesta.tiene_guia">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.tiene_guia.$touched">
                    <span class="label label-danger" ng-show="datosForm.tiene_guia.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.13 ¿La empresa adelanta o ha participado en alguna de las siguientes actividades para conservar el medio ambiente en @{{proveedor.razon_social}}? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in actividadesAmbiente| orderBy: 'peso'">
                            <label>
                                <input type="checkbox" name="actividadesAmbiente" checklist-model="encuesta.actividadesAmbiente"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==13">:<input type="text" name="otroActividad" style="display: inline-block;" class="form-control" id="otroActividad" placeholder="Escriba su otra opción" ng-model="encuesta.otroActividad" ng-change="validarOtro(1)" ng-required="encuesta.actividadesAmbiente.indexOf(13) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.actividadesAmbiente.$touched">
                    <span class="label label-danger" ng-show="encuesta.actividadesAmbiente.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroActividad.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.14 De los siguientes programas o contribuciones para la conservación y protección de la biodiversidad, ¿En cuáles ha participado su empresa?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in programasConservacion">
                            <label>
                                <input type="checkbox" name="programasConservacion" checklist-model="encuesta.programasConservacion"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==8">:<input type="text" name="otroPrograma" style="display: inline-block;" class="form-control" id="otroPrograma" placeholder="Escriba su otra opción" ng-model="encuesta.otroPrograma" ng-change="validarOtro(2)" ng-required="encuesta.programasConservacion.indexOf(8) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.programasConservacion.$touched">
                    <span class="label label-danger" ng-show="encuesta.programasConservacion.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroPrograma.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.15 De los siguientes riesgos o problemáticas ambientales en función del turismo sostenible, ¿Cuáles  cree  que  representan  un riesgo alto, medio o bajo en @{{proveedor.razon_social}}?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única para la calificación</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>RIESGOS</th>
                                    <th ng-repeat="item in criteriosCalificacion">@{{item.nombre}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in tiposRiesgos">
                                    <td>
                                        @{{item.nombre}} <input type="text" class="form-control" ng-if="item.id==21" ng-model="item.otroRiesgo" >
                                        <span class="label label-danger" ng-show="datosForm.riesgo_@{{item.id}}.$error.required && datosForm.$submitted">* Requerido.</span>
                                    </td>
                                    <td ng-repeat="cal in criteriosCalificacion" style="text-align: center;">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="riesgo_@{{item.id}}" value="@{{cal.id}}" ng-model="item.califcacion" required >       
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.16 De los siguientes planes de mitigación de cambio climático ¿Cuáles ha implementado su empresa? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in planesMitigacion">
                            <label>
                                <input type="checkbox" name="planesMitigacion" checklist-model="encuesta.planesMitigacion"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==9">:<input type="text" name="otroMitigacion" style="display: inline-block;" class="form-control" id="otroMitigacion" placeholder="Escriba su otra opción" ng-model="encuesta.otroMitigacion" ng-change="validarOtro(7)" ng-required="encuesta.planesMitigacion.indexOf(9) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.planesMitigacion.$touched">
                    <span class="label label-danger" ng-show="encuesta.planesMitigacion.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroMitigacion.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.17 ¿Su establecimiento tiene informes de gestión ambiental, informes de reciclaje o estadísticas de residuos?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_informe_gestion" value="1" name="tiene_informe_gestion" required ng-model="encuesta.tiene_informe_gestion">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_informe_gestion" value="0" name="tiene_informe_gestion" required ng-model="encuesta.tiene_informe_gestion">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.tiene_informe_gestion.$touched">
                    <span class="label label-danger" ng-show="datosForm.tiene_informe_gestion.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.tiene_informe_gestion == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.17.1 ¿Con qué frecuencia realiza el informe? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td ng-repeat="item in periodosInformes">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" id="periodos_informe_id" value="@{{item.id}}" name="periodos_informe_id" ng-required="encuesta.tiene_informe_gestion == 1" ng-model="encuesta.periodos_informe_id">
                                                @{{item.nombre}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.periodos_informe_id.$touched">
                    <span class="label label-danger" ng-show="datosForm.periodos_informe_id.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.tiene_informe_gestion == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.17.2 ¿Mide el volumen de residuos producidos por los turistas en su establecimiento? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="mide_residuos" value="1" name="mide_residuos" ng-required="encuesta.tiene_informe_gestion == 1" ng-model="encuesta.mide_residuos">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="mide_residuos" value="0" name="mide_residuos" ng-required="encuesta.tiene_informe_gestion == 1" ng-model="encuesta.mide_residuos">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.mide_residuos.$touched">
                    <span class="label label-danger" ng-show="datosForm.mide_residuos.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.18 De las siguientes actividades relacionadas con el manejo de residuos ¿Cuáles ha implementado su empresa?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in actividadesResiduos">
                            <label>
                                <input type="checkbox" name="actividadesResiduos" checklist-model="encuesta.actividadesResiduos"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==8">:<input type="text" name="otroActividadRes" style="display: inline-block;" class="form-control" id="otroActividadRes" placeholder="Escriba su otra opción" ng-model="encuesta.otroActividadRes" ng-change="validarOtro(3)" ng-required="encuesta.actividadesResiduos.indexOf(8) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.actividadesResiduos.$touched">
                    <span class="label label-danger" ng-show="encuesta.actividadesResiduos.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroActividadRes.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.19 ¿Cuáles de las siguientes medidas ha adoptado la empresa para reducir el consumo de agua?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in accionesAgua">
                            <label>
                                <input type="checkbox" name="accionesAgua" checklist-model="encuesta.accionesAgua"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==7">:<input type="text" name="otroAgua" style="display: inline-block;" class="form-control" id="otroAgua" placeholder="Escriba su otra opción" ng-model="encuesta.otroAgua" ng-change="validarOtro(4)" ng-required="encuesta.accionesAgua.indexOf(7) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.accionesAgua.$touched">
                    <span class="label label-danger" ng-show="encuesta.accionesAgua.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroAgua.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.20 ¿Hace uso de aguas recicladas como una medida adicional de gestión en la empresa? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="agua_reciclabe" value="1" required name="agua_reciclabe" ng-model="encuesta.agua_reciclabe">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="agua_reciclabe" value="0" required name="agua_reciclabe" ng-model="encuesta.agua_reciclabe">
                                NO
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="agua_reciclabe" value="-1" required name="agua_reciclabe" ng-model="encuesta.agua_reciclabe">
                                NS/NR
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.agua_reciclabe.$touched">
                    <span class="label label-danger" ng-show="datosForm.agua_reciclabe.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.agua_reciclabe == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.20.1 Por favor indique ¿Qué tipo de agua reciclada/residual utiliza y qué uso le da?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tipo de agua</th>
                                    <th>Uso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <textarea class="form-control" ng-required="encuesta.agua_reciclabe == 1" placeholder="Presione aquí para ingresar su respuesta" ng-model="encuesta.tipo_agua" name="tipo_agua"></textarea>
                                    </td>
                                    <td>
                                        <textarea class="form-control" ng-required="encuesta.agua_reciclabe == 1" placeholder="Presione aquí para ingresar su respuesta" ng-model="encuesta.uso_agua" name="uso_agua"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted">
                    <span class="label label-danger" ng-show="datosForm.tipo_agua.$error.required">*El campo tipo de agua es requerido.</span>
                    <span class="label label-danger" ng-show="datosForm.uso_agua.$error.required">*El campo uso de agua es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.21 De las siguientes medidas, ¿Cuáles ha adoptado su empresa para reducir el consumo de energía? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in accionesEnergia">
                            <label>
                                <input type="checkbox" name="accionesEnergia" checklist-model="encuesta.accionesEnergia"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==17">:<input type="text" name="otroEnergia" style="display: inline-block;" class="form-control" id="otroEnergia" placeholder="Escriba su otra opción" ng-model="encuesta.otroEnergia" ng-change="validarOtro(5)" ng-required="encuesta.accionesEnergia.indexOf(17) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.accionesEnergia.$touched">
                    <span class="label label-danger" ng-show="encuesta.accionesEnergia.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroEnergia.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22 ¿La empresa hace uso de fuentes de energías renovables? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="energias_renovables" value="1" required name="energias_renovables" ng-model="encuesta.energias_renovables">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="energias_renovables" value="0" required name="energias_renovables" ng-model="encuesta.energias_renovables">
                                NO
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="energias_renovables" value="-1" required name="energias_renovables" ng-model="encuesta.energias_renovables">
                                NS/NR
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.energias_renovables.$touched">
                    <span class="label label-danger" ng-show="datosForm.energias_renovables.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.energias_renovables == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22.1 ¿La empresa tiene un manual o informe de uso eficiente de  energía  y  energía renovable? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_manual" value="1" ng-required="encuesta.energias_renovables == 1" name="tiene_manual" ng-model="encuesta.tiene_manual">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_manual" value="0" ng-required="encuesta.energias_renovables == 1" name="tiene_manual" ng-model="encuesta.tiene_manual">
                                NO
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="tiene_manual" value="-1" ng-required="encuesta.energias_renovables == 1" name="tiene_manual" ng-model="encuesta.tiene_manual">
                                NS/NR
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.tiene_manual.$touched">
                    <span class="label label-danger" ng-show="datosForm.tiene_manual.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.energias_renovables == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22.2 Por favor indique el tipo de energía renovable que utiliza.</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in tiposEnergia">
                            <label>
                                <input type="checkbox" name="tiposEnergia" checklist-model="encuesta.tiposEnergia"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==4">:<input type="text" name="otroRenovable" style="display: inline-block;" class="form-control" id="otroRenovable" placeholder="Escriba su otra opción" ng-model="encuesta.otroRenovable" ng-change="validarOtro(6)" ng-required="encuesta.tiposEnergia.indexOf(4) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.tiposEnergia.$touched">
                    <span class="label label-danger" ng-show="encuesta.tiposEnergia.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroRenovable.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="row" style="text-align:center">
            <a href="/sostenibilidadpst/sociocultural/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection


