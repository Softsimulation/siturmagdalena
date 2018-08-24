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

@section('TitleSection', 'COMPONENTE SOCIO-CULTURAL')

@section('Progreso', '33.33%')

@section('NumSeccion', '33.33%')

@section('controller','ng-controller="socioCulturalController"')

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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.1 En una escala de 1 a 10, donde 1 es Muy Malo y 10 Excelente. ¿Cómo considera que es el trato general de los visitantes cuando se les está prestando el servicio turístico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td ng-repeat="n in [] | range:10">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" id="trato_general" value="@{{n}}" name="trato_general" required ng-model="encuesta.trato_general">
                                                @{{n}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.trato_general.$touched">
                    <span class="label label-danger" ng-show="datosForm.trato_general.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.2 ¿Cree que los turistas que llegan a @{{proveedor.razon_social}} respetan y conservan las tradiciones, monumentos, grupos étnicos y población residente en general?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="respetan_normas" value="1" name="respetan_normas" required ng-model="encuesta.respetan_normas">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="respetan_normas" value="0" name="respetan_normas" required ng-model="encuesta.respetan_normas">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.respetan_normas.$touched">
                    <span class="label label-danger" ng-show="datosForm.respetan_normas.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.3 Con una calificación de alto, medio o bajo, ¿Cómo califica el nivel de conocimiento del personal de su empresa de los servicios, productos y atractivos culturales que ofrece @{{proveedor.razon_social}}? </b></h3>
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
        
        <div class="panel panel-success" ng-if="encuesta.criterios_calificacion_id != 4 && encuesta.criterios_calificacion_id != undefined">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P. 3.1 ¿Ofrecen información oportuna a los visitantes sobre los servicios, productos y atractivos culturales que hay en @{{proveedor.razon_social}}? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ofrece_informacion" value="1" name="ofrece_informacion" ng-required="encuesta.criterios_calificacion_id != 4 && encuesta.criterios_calificacion_id != undefined" ng-model="encuesta.ofrece_informacion">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ofrece_informacion" value="0" name="ofrece_informacion" ng-required="encuesta.criterios_calificacion_id != 4 && encuesta.criterios_calificacion_id != undefined" ng-model="encuesta.ofrece_informacion">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.ofrece_informacion.$touched">
                    <span class="label label-danger" ng-show="datosForm.ofrece_informacion.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.4 ¿Su empresa adelanta o participa en alguna de las siguientes acciones para conservar y rescatar la cultura de donde opera?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in accionesCulturales| orderBy : 'peso'">
                            <label>
                                <input type="checkbox" name="accionesCulturales" checklist-model="encuesta.accionesCulturales"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==8">:<input type="text" name="otroCultural" style="display: inline-block;" class="form-control" id="otroCultural" placeholder="Escriba su otra opción" ng-model="encuesta.otroCultural" ng-change="validarOtro(1)" ng-required="encuesta.accionesCulturales.indexOf(8) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.accionesCulturales.$touched">
                    <span class="label label-danger" ng-show="encuesta.accionesCulturales.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroCultural.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.5 En una escala de 1 a 10, donde 1 es nada importante y 10 muy importante. ¿Cuál es el nivel de importancia de la sostenibilidad sociocultural en la actividad turística que presta?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td ng-repeat="n in [] | range:10">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" id="nivel_importancia" value="@{{n}}" name="nivel_importancia" required ng-model="encuesta.nivel_importancia">
                                                @{{n}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.nivel_importancia.$touched">
                    <span class="label label-danger" ng-show="datosForm.nivel_importancia.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.6 ¿Su establecimiento cuenta con un reporte, agenda o programa de responsabilidad social?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="responsabilidad_social" value="1" name="responsabilidad_social" required ng-model="encuesta.responsabilidad_social">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="responsabilidad_social" value="0" name="responsabilidad_social" required ng-model="encuesta.responsabilidad_social">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.responsabilidad_social.$touched">
                    <span class="label label-danger" ng-show="datosForm.responsabilidad_social.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.responsabilidad_social == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.6.1 De las siguientes razones o motivos ¿Cuáles fueron determinantes en su empresa para adoptar el programa de responsabilidad social? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in motivosResponsabilidad">
                            <label>
                                <input type="checkbox" name="motivosResponsabilidad" checklist-model="encuesta.motivosResponsabilidad"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==9">:<input type="text" name="otroMotivoResp" style="display: inline-block;" class="form-control" id="otroMotivoResp" placeholder="Escriba su otra opción" ng-model="encuesta.otroMotivoResp" ng-change="validarOtro(2)" ng-required="encuesta.motivosResponsabilidad.indexOf(9) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.motivosResponsabilidad.$touched">
                    <span class="label label-danger" ng-show="encuesta.motivosResponsabilidad.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroMotivoResp.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.responsabilidad_social == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b> P.6.2 ¿En qué año asumieron el compromiso de una agenda relacionada con responsabilidad social?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="anio_compromiso" name="anio_compromiso" ng-model="encuesta.anio_compromiso" placeholder="Presione aquí para ingresar el año"  />
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.anio_compromiso.$touched">
                    <span class="label label-danger" ng-show="datosForm.anio_compromiso.$error.number">* Sólo números.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.responsabilidad_social == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b> P.6.3 ¿Desde qué año adoptaron normas relacionadas con la responsabilidad social? </b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="anio_normas" name="anio_normas" ng-model="encuesta.anio_normas" placeholder="Presione aquí para ingresar el año de adopción"  />
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.anio_normas.$touched">
                    <span class="label label-danger" ng-show="datosForm.anio_normas.$error.number">* Sólo números.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="tipoProveedor == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.7 ¿Su establecimiento posee espacios accesibles para personas en condición de discapacidad?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="espacios_accesibles" value="1" name="espacios_accesibles" ng-required="tipoProveedor == 1" ng-model="encuesta.espacios_accesibles">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="espacios_accesibles" value="0" name="espacios_accesibles" ng-required="tipoProveedor == 1" ng-model="encuesta.espacios_accesibles">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.espacios_accesibles.$touched">
                    <span class="label label-danger" ng-show="datosForm.espacios_accesibles.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.espacios_accesibles == 1 && tipoProveedor == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.7.1 ¿Cuántas habitaciones tiene su establecimiento?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="numero_habitaciones" name="numero_habitaciones" ng-model="encuesta.numero_habitaciones" ng-required="encuesta.espacios_accesibles == 1 && tipoProveedor == 1" placeholder="Presione aquí para ingresar el número de habitaciones"  />
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.numero_habitaciones.$touched">
                    <span class="label label-danger" ng-show="datosForm.numero_habitaciones.$error.required">*El campo es requerido.</span>
                    <span class="label label-danger" ng-show="datosForm.numero_habitaciones.$error.number">* Sólo números.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="encuesta.espacios_accesibles == 1 && tipoProveedor == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.7.2 Por tipo de discapacidad  por favor indique el número de habitaciones  accesibles. Tenga en cuenta que si una habitación   es accesible para varias categorías de discapacidad, éstas deben indicarse en "Discapacidad múltiple"</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>TIPO DISCAPACIDAD</th>
                                    <th># HABITACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in tiposDiscapacidad">
                                    <td>@{{item.nombre}}</td>
                                    <td>
                                        <input type="number" name="discapacidad_@{{item.id}}" class="form-control" ng-model="item.numero_habitacion" ng-required="encuesta.espacios_accesibles == 1 && tipoProveedor == 1" />
                                        <span ng-show="datosForm.$submitted || datosForm.discapacidad_@{{item.id}}.$touched">
                                            <span class="label label-danger" ng-show="datosForm.discapacidad_@{{item.id}}.$error.required">*El campo es requerido.</span>
                                        </span>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.8 ¿Su establecimiento ha implementado alguno de los siguientes esquemas de información accesible?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in esquemasAccesibles">
                            <label>
                                <input type="checkbox" name="esquemasAccesibles" checklist-model="encuesta.esquemasAccesibles"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==8">:<input type="text" name="otroEsquemaAcc" style="display: inline-block;" class="form-control" id="otroEsquemaAcc" placeholder="Escriba su otra opción" ng-model="encuesta.otroEsquemaAcc" ng-change="validarOtro(3)" ng-required="encuesta.esquemasAccesibles.indexOf(8) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.esquemasAccesibles.$touched">
                    <span class="label label-danger" ng-show="encuesta.esquemasAccesibles.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroEsquemaAcc.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.esquemasAccesibles.indexOf(7) == -1">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.8.1 ¿Qué beneficios espera que se generen con la implementación de esquemas de información accesible en su establecimiento? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in beneficiosEsquema">
                            <label>
                                <input type="checkbox" name="beneficiosEsquema" checklist-model="encuesta.beneficiosEsquema"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==7">:<input type="text" name="otroBeneficio" style="display: inline-block;" class="form-control" id="otroBeneficio" placeholder="Escriba su otra opción" ng-model="encuesta.otroBeneficio" ng-change="validarOtro(4)" ng-required="encuesta.beneficiosEsquema.indexOf(7) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.beneficiosEsquema.$touched">
                    <span class="label label-danger" ng-show="encuesta.beneficiosEsquema.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroBeneficio.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.esquemasAccesibles.indexOf(7) == -1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.8.2 ¿Conoce usted las herramientas (software) que ha implementado el MinTIC para que las personas con discapacidad visual, auditiva y con sordoceguera tengan acceso a las tecnologías de información y comunicación (TIC)? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="conoce_herramienta_tic" value="1" name="conoce_herramienta_tic" ng-required="encuesta.esquemasAccesibles.indexOf(7) == -1" ng-model="encuesta.conoce_herramienta_tic">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="conoce_herramienta_tic" value="0" name="conoce_herramienta_tic" ng-required="encuesta.esquemasAccesibles.indexOf(7) == -1" ng-model="encuesta.conoce_herramienta_tic">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.conoce_herramienta_tic.$touched">
                    <span class="label label-danger" ng-show="datosForm.conoce_herramienta_tic.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="encuesta.esquemasAccesibles.indexOf(7) == -1 && encuesta.conoce_herramienta_tic == 1">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.8.2.1 ¿Ha implementado estas herramientas en su empresa?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="implementa_herramienta_tic" value="1" name="implementa_herramienta_tic" ng-required="encuesta.esquemasAccesibles.indexOf(7) == -1 && encuesta.conoce_herramienta_tic == 1" ng-model="encuesta.implementa_herramienta_tic">
                                SI
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="implementa_herramienta_tic" value="0" name="implementa_herramienta_tic" ng-required="encuesta.esquemasAccesibles.indexOf(7) == -1 && encuesta.conoce_herramienta_tic == 1" ng-model="encuesta.implementa_herramienta_tic">
                                NO
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.implementa_herramienta_tic.$touched">
                    <span class="label label-danger" ng-show="datosForm.implementa_herramienta_tic.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.9 De los siguientes riesgos o problemáticas socioculturales en función del turismo sostenible, ¿Cuáles considera que representan un riesgo alto, medio o bajo en @{{proveedor.razon_social}}?</b></h3>
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
                                        @{{item.nombre}} <input type="text" class="form-control" ng-if="item.id==8" ng-model="item.otroRiesgo" >
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.10 ¿Cuál debería ser la contribución de turismo a  la conservación  de patrimonio  sociocultural de @{{proveedor.razon_social}}?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea placeholder="Presione aquí para ingresar su respuesta" ng-model="encuesta.contribucion_turismo" class="form-control" name="contribucion_turismo" required></textarea>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.contribucion_turismo.$touched">
                    <span class="label label-danger" ng-show="datosForm.contribucion_turismo.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="row" style="text-align:center">
            <a href="/sostenibilidadpst/editarencuesta/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection


