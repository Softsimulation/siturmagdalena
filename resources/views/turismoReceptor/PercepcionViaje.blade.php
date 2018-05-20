@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
    <style>
        .title-section {
            background-color: #16469e!important;
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
        
    </style>    
@endsection

@section('TitleSection', 'Percepción del viaje al departamento del Atlántico')

@section('Progreso', '83.31%')

@section('NumSeccion', '83%')

@section('controller','ng-controller="percepcion-crear"')

@section('content')
<div class="container" >
    <input type="hidden" ng-model="Id" ng-init="Id={{$id}}" />
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
    <form role="form" name="PercepcionForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- ¿Durante su viaje utilizó servicio de alojamiento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Durante su viaje utilizó servicio de alojamiento?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="alojamientoSi" value="1" name="alojamiento"  ng-required="true" ng-model="calificacion.Alojamiento">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="alojamientoNo" name="alojamiento" ng-required="true" ng-change="limpiar(calificacion.Alojamiento,1,7)" value="0" ng-model="calificacion.Alojamiento" >
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.alojamiento.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.alojamiento.$error.required">*El campo Durante su viaje utilizó servicio de alojamiento es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="calificacion.Alojamiento==1">
            <div class="panel-heading p2">
                <!-- Calificación del servicio de alojamiento-->
                <h3 class="panel-title"><b>Calificación del servicio de alojamiento</b></h3>
            </div>
            <!-- Califique en una escala del 1 al 10, donde 1 es Muy insatisfecho y 10 Muy satisfecho-->
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es Muy insatisfecho y 10 Muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped" ng-required="calificacion.Alojamiento==1">
                            <thead>
                                <tr>
                                    <th> @{{aspectos[0].aspectos_evaluados_con_idiomas[0].nombre}} </th>
                                    @for ($j = 1; $j <= 10; $j++)
                                        <th> {{$j}} </th>
                                    @endfor
                                </tr>

                            </thead>
                            <tbody>
                                <tr ng-repeat="it in aspectos[0].items_evaluars">
                                    <td> @{{it.items_evaluar_con_idiomas[0].nombre}}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio"  id="alojamiento_@{{it.id}}_{{$i}}" name="alojamiento_@{{it.id}}"  ng-model="it.radios" ng-checked="checkedRadio('alojamiento_@{{it.id}}_{{$i}}', it.radios.Valor,{{$i}})" ng-value="{Id:it.id,Valor:{{$i}}}">

                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <!-- ¿Durante su viaje utilizó servicios de restaurante?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Durante su viaje utilizó servicios de restaurante?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="restauranteSi" value="1" name="restaurante" ng-required="true" ng-model="calificacion.Restaurante">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="restauranteNo" name="restaurante" ng-required="true" ng-change="limpiar(calificacion.Restaurante,8,12)" value="0" ng-model="calificacion.Restaurante">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.restaurante.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.restaurante.$error.required">*El campo Durante su viaje utilizó servicios de restaurante es requerido.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success" ng-if="calificacion.Restaurante==1">
            <div class="panel-heading">
                <!-- Calificación del servicio de restaurante-->
                <h3 class="panel-title"><b>Calificación del servicio de restaurante</b></h3>
            </div>
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es muy insatisfecho y 10 muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> @{{aspectos[1].aspectos_evaluados_con_idiomas[0].nombre}} </th>
                                    @for ($j = 1; $j <= 10; $j++)
                                        <th> {{$j}} </th>
                                    @endfor
                                </tr>

                            </thead>
                            <tbody>
                                <tr ng-repeat="it in aspectos[1].items_evaluars">
                                    <td> @{{it.items_evaluar_con_idiomas[0].nombre}}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                    
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" id="restaurante_@{{it.id}}_{{$i}}" name="restaurante_@{{it.id}}_{{$i}}" ng-checked="checkedRadio('restaurante_@{{it.id}}_{{$i}}', it.radios.Valor,{{$i}})"  ng-model="it.radios" ng-value="{Id:it.id,Valor:{{$i}}}">
                                                    
                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                   
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- ¿Durante su viaje utilizó servicio de alojamiento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Desea calificar el aspecto de factores ambientales durante sus estancia?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="factoresSi" value="1" name="factores"  ng-required="true" ng-model="calificacion.Factores">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="factoresNo" name="factores" ng-required="true" ng-change="limpiar(calificacion.Factores,13,15)" value="0" ng-model="calificacion.Factores" >
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.factores.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.factores.$error.required">*El campo Durante su viaje utilizó servicio de factores ambientales es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="calificacion.Factores==1">
            <div class="panel-heading">
                <h3 class="panel-title"><b>@{{aspectos[2].aspectos_evaluados_con_idiomas[0].nombre}}</b></h3>
            </div>
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es muy insatisfecho y 10 muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40%;"> @{{aspectos[2].aspectos_evaluados_con_idiomas[0].nombre}} </th>
                                    @for ($j = 1; $j <= 10; $j++)
                                    
                                        <th> {{$j}} </th>
                                    @endfor
                                    <th> Sin Respuesta </th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr ng-repeat="it in aspectos[2].items_evaluars">
                                    <td> @{{it.items_evaluar_con_idiomas[0].nombre}}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                    
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factores_@{{it.id}}" id="factores_@{{it.id}}_{{$i}}" ng-checked="checkedRadio('factores_@{{it.id}}_{{$i}}', it.radios.Valor,{{$i}})"  ng-model="it.radios" ng-value="{Id:it.id,Valor:{{$i}}}">

                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                    <td>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" ng-checked="it.radios==null" ng-click="limpiarFila(it.id)" name="infraestructura_@{{it.id}}" value="0">
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
            <div class="panel-heading p1">
                <!-- ¿Durante su viaje utilizó servicio de alojamiento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Desea calificar el aspecto de ocio y recreación durante sus estancia?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ocioSi" value="1" name="ocio"  ng-required="true" ng-model="calificacion.Ocio">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ocioNo" name="ocio" ng-required="true" ng-change="limpiar(calificacion.Ocio,17,20)" value="0" ng-model="calificacion.Ocio" >
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.ocio.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.ocio.$error.required">*El campo Durante su viaje utilizó servicio de ocio y recreación es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="calificacion.Ocio == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b>@{{aspectos[3].aspectos_evaluados_con_idiomas[0].nombre}}</b></h3>
            </div>
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es muy insatisfecho y 10 muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40%"> @{{aspectos[3].aspectos_evaluados_con_idiomas[0].nombre}} </th>
                                    @for ($j = 1; $j <= 10; $j++)
                                    
                                        <th> {{$j}} </th>
                                    @endfor
                                    <th> Sin Respuesta </th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr ng-repeat="it in aspectos[3].items_evaluars">
                                    <td> @{{it.items_evaluar_con_idiomas[0].nombre}}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="ocio_@{{it.id}}" ng-model="it.radios" id="ocio_@{{it.id}}_{{$i}}" ng-checked="checkedRadio('ocio_@{{it.id}}_{{$i}}', it.radios.Valor,{{$i}})"  ng-value="{Id:it.id,Valor:{{$i}}}">

                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                    <td>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" ng-checked="it.radios==null" ng-click="limpiarFila(it.id)" name="infraestructura_@{{it.id}}" value="0">
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
            <div class="panel-heading p1">
                <!-- ¿Durante su viaje utilizó servicio de alojamiento?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Desea calificar el aspecto de infraestructura durante sus estancia?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ocio2Si" value="1" name="inf"  ng-required="true" ng-model="calificacion.Infra">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="ocio1No" name="inf" ng-required="true" ng-change="limpiar(calificacion.Infra,17,20)" value="0" ng-model="calificacion.Infra" >
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.infraestructura.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.infraestructura.$error.required">*El campo Durante su viaje utilizó servicio de infraestructura es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-if="calificacion.Infra == 1">
            <div class="panel-heading">
                <h3 class="panel-title"><b>@{{aspectos[4].aspectos_evaluados_con_idiomas[0].nombre}}</b></h3>
            </div>
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es muy insatisfecho y 10 muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 40%"> @{{aspectos[4].aspectos_evaluados_con_idiomas[0].nombre}} </th>
                                    @for ($j = 1; $j <= 10; $j++)
                                    
                                        <th> {{$j}} </th>
                                    @endfor
                                    <th> Sin Respuesta </th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr ng-repeat="it in aspectos[4].items_evaluars">
                                    <td> @{{it.items_evaluar_con_idiomas[0].nombre}}</td>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="infraestructura_@{{it.id}}" id="infraestructura_@{{it.id}}_{{$i}}" ng-checked="checkedRadio('infraestructura_@{{it.id}}_{{$i}}', it.radios.Valor,{{$i}})" ng-model="it.radios" ng-value="{Id:it.id,Valor:{{$i}}}">

                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                    
                                    <td>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio"  ng-checked="it.radios==null" ng-click="limpiarFila(it.id)" name="infraestructura_@{{it.id}}" value="0">
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
                <!-- ¿Cuál fue el  atractivo y/o el elemento de la ciudad que más llamó su atención?-->
                <h3 class="panel-title"><b> Sostenibilidad ¿Realizó alguna de las siguientes actividades para ayudar a la conservación del medio ambiente en Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="item in actividades" >
                            <label>
                                <input type="checkbox" ng-disabled="bandera==false && item.id==12" checklist-model="calificacion.Elementos"  checklist-value="item.id"> @{{item.nombre}}
                            </label>
                            <input type="text" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-model="calificacion.OtroElementos" ng-change="verificarOtro()" ng-if="item.id==12" />
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- ¿Durante su viaje utilizó servicio de alojamiento?-->
                <h3 class="panel-title"><b> ¿Fue informado sobre las normas y cuidados que debe tener el visitante con la flora y fauna de Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="infraestructuraSi" value="1" name="infraestructura"  ng-model="calificacion.Flora">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="infraestructuraNo" name="infraestructura"  value="0" ng-model="calificacion.Flora" >
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Qué recomendaría para lograr atraer más visitantes al Magdalena?-->
                <h3 class="panel-title"><b>Qué aspectos no le gustaron de Atlántico?</b></h3>
            </div>
            <!-- Resalte en detalle aspectos que realmente le disgustaron-->
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="recomendaciones" name="recomendaciones" ng-model="calificacion.Recomendaciones" class="form-control" placeholder="Escriba aquí su recomendación"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- Experiencia de viaje-->
                <h3 class="panel-title"><b>Sostenibilidad</b></h3>
            </div>
            <div class="panel-footer"><b>En una escala de 1 a 10, donde 1 es Mal trato y 10 Trato excelente. ¿Cómo califica el trato que reciben los turistas en Barranquilla? Respuesta única.</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped" ng-required="true">
                            
                            <tbody>
                                <tr>
                                    
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="sotenibilidada_@{{it.Id}}" ng-model="calificacion.Sostenibilidad" value="{{$i}}">
                                                    {{$i}}
                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- Experiencia de viaje-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Experiencia de viaje</b></h3>
            </div>
            <div class="panel-footer"><b>Califique en una escala del 1 al 10, donde 1 es muy insatisfecho y 10 muy satisfecho</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped" ng-required="true">
                            
                            <tbody>
                                <tr>
                                    
                                    @for ($i = 1; $i <= 10; $i++)
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="experiencia_@{{it.Id}}" ng-model="calificacion.Calificacion" value="{{$i}}">
                                                    {{$i}}
                                                </label>
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <span ng-show="PercepcionForm.$submitted || PercepcionForm.tabla_calificacion.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.tabla_calificacion.$error.required">*El campo experiencia de viaje es requerido.</span>
                    <span class="label label-danger" ng-show="calificacion.Calificacion==null">*El campo experiencia de viaje es requerido.</span>
                </span>
            </div>

        </div>
        
        
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Volvería a visitar el departamento del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Volvería a visitar el departamento del Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary" ng-repeat="it in veces">
                            <label>
                                <input type="radio" id="veces_@{{it.id}}" value="@{{it.id}}" name="radioVolveria" ng-required="true" ng-model="calificacion.Volveria">
                                @{{it.volveria_visitar_con_idiomas[0].nombre}}
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.radioVolveria.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.radioVolveria.$error.required">*El campo volveria a visitar el Atlántico es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Recomendaría visitar el departamento del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Recomendaría visitar el departamento del Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary" ng-repeat="it in veces">
                            <label>
                                <input type="radio" id="recomenda_@{{it.id}}" value="@{{it.id}}" name="radioRecomienda" ng-required="true" ng-model="calificacion.Recomienda">
                                @{{it.volveria_visitar_con_idiomas[0].nombre}}
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.radioRecomienda.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.radioRecomienda.$error.required">*El campo recomendaría visitar el Atlántico es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Cuántas veces ha venido al Magdalena en los últimos dos años?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuántas veces ha venido al Atlántico en los últimos dos años?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="selectVeces" ng-model="calificacion.VecesVisitadas" ng-required="true" ng-init="calificacion.VecesVisitadas = '0'">
                            <option value="0" selected disabled>Presione aquí para desplegar opciones</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                            <option>10+</option>
                        </select>
                    </div>
                    
                </div>
                <span ng-show="PercepcionForm.$submitted || PercepcionForm.selectVeces.$touched">
                    <span class="label label-danger" ng-show="PercepcionForm.selectVeces.$error.required">*El campo volveria a visitar el Atlántico es requerido.</span>
                    <span class="label label-danger" ng-show="calificacion.VecesVisitadas==0">*El campo volveria a visitar el Atlántico es requerido.</span>

                </span>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/secciongastos/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
@endsection

