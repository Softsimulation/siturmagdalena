@extends('layout._sostenibilidadHogarLayout')

@section('title', 'SOSTENIBILIDAD DE LAS ACTIVIDADES TURÍSTICAS- HOGARES')

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

@section('TitleSection', 'COMPONENTE ECONÓMICO')

@section('Progreso', '99.99%')

@section('NumSeccion', '99.99%')

@section('controller','ng-controller="economicoController"')

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
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.21 ¿Cree que el turismo contribuirá, a largo plazo, a mejorar la situación económica de los habitantes de Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="contribuira" value="1" required name="contribuira" ng-model="encuesta.contribuira">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="contribuira" value="0" required name="contribuira" ng-model="encuesta.contribuira">
                                NO
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="contribuira" value="-1" required name="contribuira" ng-model="encuesta.contribuira">
                                NS/NR
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.contribuira.$touched">
                    <span class="label label-danger" ng-show="datosForm.contribuira.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        
        <div class="panel panel-success" ng-show="encuesta.contribuira == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.21.1 Teniendo en  cuenta lo  anterior, ¿Qué  aspectos  cree  que mejorarían  la  situación  económica del Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea placeholder="Presione aquí para ingresar su respuesta" ng-model="encuesta.aspectos_mejorar" class="form-control" name="aspectos_mejorar" ng-required="encuesta.contribuira == 1" ></textarea>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.aspectos_mejorar.$touched">
                    <span class="label label-danger" ng-show="datosForm.aspectos_mejorar.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22 De los siguientes subsectores por favor indique, ¿En cuál presta un servicio turístico en el departamento? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in sectoresTurismo">
                            <label>
                                <input type="checkbox" name="sectoresTurismo" checklist-model="encuesta.sectoresTurismo"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==7">:<input type="text" name="otroSectorTurismo" style="display: inline-block;" class="form-control" id="otroSectorTurismo" placeholder="Escriba su otra opción" ng-model="encuesta.otroSectorTurismo" ng-change="validarOtro(1)" ng-required="encuesta.sectoresTurismo.indexOf(7) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.sectoresTurismo.$touched">
                    <span class="label label-danger" ng-show="encuesta.sectoresTurismo.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroSectorTurismo.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.sectoresTurismo.indexOf(6) == -1 && encuesta.sectoresTurismo.length > 0">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22.1 ¿Es el turismo su actividad económica principal? Es decir, la principal fuente de generación de ingresos?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="es_fuente" value="1" name="es_fuente" ng-required="encuesta.sectoresTurismo.indexOf(6) == -1 && encuesta.sectoresTurismo.length > 0" ng-model="encuesta.es_fuente">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="es_fuente" value="0" name="es_fuente" ng-required="encuesta.sectoresTurismo.indexOf(6) == -1 && encuesta.sectoresTurismo.length > 0" ng-model="encuesta.es_fuente">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.es_fuente.$touched">
                    <span class="label label-danger" ng-show="datosForm.es_fuente.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.sectoresTurismo.indexOf(6) == -1 && encuesta.sectoresTurismo.length > 0">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.22.2 ¿En qué actividad económica se desempeñaba antes de dedicarse a turismo?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in sectoresEconomia">
                            <label>
                                <input type="checkbox" name="sectoresEconomia" checklist-model="encuesta.sectoresEconomia"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==12">:<input type="text" name="otroSectorEconomia" style="display: inline-block;" class="form-control" id="otroSectorEconomia" placeholder="Escriba su otra opción" ng-model="encuesta.otroSectorEconomia" ng-change="validarOtro(2)" ng-required="encuesta.sectoresEconomia.indexOf(12) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.sectoresEconomia.$touched">
                    <span class="label label-danger" ng-show="encuesta.sectoresEconomia.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroSectorEconomia.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.23 De los siguientes beneficios económicos que se generan por el turismo, ¿Cuáles cree que han mejorado o desmejorado en Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única para la calificación</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>BENEFICIOS - Temporada Baja</th>
                                    <th ng-repeat="item in calificacionesFactor">@{{item.nombre}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in beneficios| filter: {'tipo_temporada': true}">
                                    <td>
                                        @{{item.nombre}} <input type="text" class="form-control" ng-if="item.id==18" ng-model="item.otroBeneficio" >
                                        <span class="label label-danger" ng-show="datosForm.beneficio_@{{item.id}}.$error.required && datosForm.$submitted">* Requerido.</span>
                                    </td>
                                    <td ng-repeat="cal in calificacionesFactor" style="text-align: center;">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="beneficio_@{{item.id}}" value="@{{cal.id}}" ng-model="item.califcacion" required >       
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>BENEFICIOS - Temporada Alta</th>
                                    <th ng-repeat="item in calificacionesFactor">@{{item.nombre}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in beneficios| filter: {'tipo_temporada': false}">
                                    <td>
                                        @{{item.nombre}} <input type="text" class="form-control" ng-if="item.id==24" ng-model="item.otroBeneficio" >
                                        <span class="label label-danger" ng-show="datosForm.beneficio_@{{item.id}}.$error.required && datosForm.$submitted">* Requerido.</span>
                                    </td>
                                    <td ng-repeat="cal in calificacionesFactor" style="text-align: center;">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="beneficio_@{{item.id}}" value="@{{cal.id}}" ng-model="item.califcacion" required >       
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
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.24 Califique como positivos o negativos los impactos económicos del turismo en el Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="impacto_economico" value="1" name="impacto_economico" required ng-model="encuesta.impacto_economico">
                                POSITIVOS
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="impacto_economico" value="0" name="impacto_economico" required ng-model="encuesta.impacto_economico">
                                NEGATIVOS
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.impacto_economico.$touched">
                    <span class="label label-danger" ng-show="datosForm.impacto_economico.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.25 De los siguientes riesgos económicos en función del turismo sostenible ¿Cuáles considera que representan un riesgo alto, medio o bajo en el Magdalena? </b></h3>
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
                                        @{{item.nombre}} <input type="text" class="form-control" ng-if="item.id==28" ng-model="item.otroRiesgo" >
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
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.26 ¿Conoce la marca que acaba de ver?  </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="conoce_marca" value="1" name="conoce_marca" required ng-model="encuesta.conoce_marca">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="conoce_marca" value="0" name="conoce_marca" required ng-model="encuesta.conoce_marca">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.conoce_marca.$touched">
                    <span class="label label-danger" ng-show="datosForm.conoce_marca.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.27 Dando cumplimiento a la ley de Protección de datos personales, solicito su autorización para que SITUR Magdalena pueda contactarlo nuevamente. ¿Está usted de acuerdo? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="autoriza_tratamiento" value="1" name="autoriza_tratamiento" required ng-model="encuesta.autoriza_tratamiento">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="autoriza_tratamiento" value="0" name="autoriza_tratamiento" required ng-model="encuesta.autoriza_tratamiento">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.autoriza_tratamiento.$touched">
                    <span class="label label-danger" ng-show="datosForm.autoriza_tratamiento.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.28 Ya para terminar, le solicito su autorización para que SITUR Magdalena comparta sus respuestas con las entidades que contrataron el proyecto, ¿Está usted de acuerdo? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="autorizacion" value="1" name="autorizacion" required ng-model="encuesta.autorizacion">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="autorizacion" value="0" name="autorizacion" required ng-model="encuesta.autorizacion">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.autorizacion.$touched">
                    <span class="label label-danger" ng-show="datosForm.autorizacion.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="row" style="text-align:center">
            <a href="/sostenibilidadhogares/componenteambiental/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection


