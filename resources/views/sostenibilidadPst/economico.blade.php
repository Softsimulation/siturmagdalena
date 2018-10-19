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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.23 Califique como positivos o negativos los impactos económicos del turismo en @{{proveedor.razon_social}}? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="es_positivo" value="1" name="es_positivo" required ng-model="encuesta.es_positivo">
                                POSITIVOS
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="es_positivo" value="0" name="es_positivo" required ng-model="encuesta.es_positivo">
                                NEGATIVOS
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.es_positivo.$touched">
                    <span class="label label-danger" ng-show="datosForm.es_positivo.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.24 ¿Qué porcentaje de proveedores  de su  empresa son del Magdalena ? Es decir, % de empresas locales que producen su bien o servicio en @{{proveedor.razon_social}}.</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="number" class="form-control" id="porcentaje" name="porcentaje" ng-model="encuesta.porcentaje" required placeholder="Presione aquí para ingresar el porcentaje" max="100"  />
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.porcentaje.$touched">
                    <span class="label label-danger" ng-show="datosForm.porcentaje.$error.required">*El campo es requerido.</span>
                    <span class="label label-danger" ng-show="datosForm.porcentaje.$error.max">*El campo no debe ser mayor que 100.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.24.1 De  los  proveedores  establecidos  en @{{proveedor.razon_social}}, por favor clasifíquelos de acuerdo al producto o servicio que suministran. </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in clasificacionesProveedor">
                            <label>
                                <input type="checkbox" name="clasificacionesProveedor" checklist-model="encuesta.clasificacionesProveedor"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==14">:<input type="text" name="otroClasificacion" style="display: inline-block;" class="form-control" id="otroClasificacion" placeholder="Escriba su otra opción" ng-model="encuesta.otroClasificacion" ng-change="validarOtro(1)" ng-required="encuesta.clasificacionesProveedor.indexOf(14) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.clasificacionesProveedor.$touched">
                    <span class="label label-danger" ng-show="encuesta.clasificacionesProveedor.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="datosForm.otroClasificacion.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.24.2 De los siguientes aspectos para seleccionar un proveedor, ¿Cuáles son los dos más importantes para su empresa? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in aspectosSeleccion">
                            <label>
                                <input type="checkbox" name="aspectosSeleccion" checklist-model="encuesta.aspectosSeleccion"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==9">:<input type="text" name="otroSeleccion" style="display: inline-block;" class="form-control" id="otroSeleccion" placeholder="Escriba su otra opción" ng-model="encuesta.otroSeleccion" ng-change="validarOtro(2)" ng-required="encuesta.aspectosSeleccion.indexOf(9) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.aspectosSeleccion.$touched">
                    <span class="label label-danger" ng-show="encuesta.aspectosSeleccion.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="encuesta.aspectosSeleccion.length != 2">* Debe seleccionar solo dos opciones.</span>
                    <span class="label label-danger" ng-show="datosForm.otroSeleccion.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.25 ¿Qué dificultades ha tenido su empresa al implementar las normas de sostenibilidad?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea placeholder="Presione aquí para ingresar su respuesta" ng-model="encuesta.dificultades" class="form-control" name="dificultades" required></textarea>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.dificultades.$touched">
                    <span class="label label-danger" ng-show="datosForm.dificultades.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.26 De los siguientes beneficios económicos que se generan por el turismo, ¿Cuáles cree que han mejorado o desmejorado en @{{proveedor.razon_social}}?</b></h3>
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
                                                <input type="radio" name="beneficio_@{{item.id}}" value="@{{cal.id}}" ng-model="item.califcacion" ng-required="item.id != 18" >       
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
                                                <input type="radio" name="beneficio_@{{item.id}}" value="@{{cal.id}}" ng-model="item.califcacion" ng-required="item.id != 24" >       
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.27 ¿Cuáles son los tres principales beneficios económicos percibidos en su empresa, por las acciones o actividades en sostenibilidad?  </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in beneficiosEconomicos">
                            <label>
                                <input type="checkbox" name="beneficiosEconomicos" checklist-model="encuesta.beneficiosEconomicos"  checklist-value="it.id" > @{{it.nombre}}
                            </label>
                            <span ng-if="it.id==12">:<input type="text" name="otroEconomico" style="display: inline-block;" class="form-control" id="otroEconomico" placeholder="Escriba su otra opción" ng-model="encuesta.otroEconomico" ng-change="validarOtro(3)" ng-required="encuesta.beneficiosEconomicos.indexOf(12) !== -1"/></span>
                        </div>
                    </div>
                </div>
                <span ng-show="datosForm.$submitted || datosForm.beneficiosEconomicos.$touched">
                    <span class="label label-danger" ng-show="encuesta.beneficiosEconomicos.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="encuesta.beneficiosEconomicos.length != 3">* Debe seleccionar solo 3 opciones.</span>
                    <span class="label label-danger" ng-show="datosForm.otroEconomico.$error.required">* Debe llenar la casilla otro.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.28 ¿Conoce la marca que acaba de ver?  </b></h3>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.29 Dando cumplimiento a la ley de Protección de datos personales, solicito su autorización para que SITUR-Magdalena pueda contactarlo nuevamente. ¿Está usted de acuerdo? </b></h3>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.30 Ya para terminar, le solicito su autorización para que SITUR-Magdalena comparta sus respuestas con las entidades que contrataron el proyecto, ¿Está usted de acuerdo? </b></h3>
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
            <a href="/sostenibilidadpst/ambiental/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

@endsection


