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

@section('TitleSection', 'COMPONENTE SOCIO-CULTURAL')

@section('Progreso', '33.33%')

@section('NumSeccion', '33.33%')

@section('controller','ng-controller="socialController"')

@section('content')

<div class="container">
   
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />   
    
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
    
    <form name="socialForm" role="form" novalidate>
 
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b>P1. ¿Le agrada la llegada de turistas a Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Pregunta con selección única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="opt2" ng-model="social.es_agradable" >
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="opt2" ng-model="social.es_agradable" >
                                    No
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="null" name="opt2" ng-model="social.es_agradable" >
                                    No sabe /No responde
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <div class="panel panel-success">
            <div class="panel-heading p3">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.2 En una escala de 1 a 10, donde 1 es Muy Malo y 10 Excelente. ¿Cómo califica el trato entre los habitantes de Magdalena y los turistas? </b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;">
                        <table  align="center" name="tabla_calificacion" class="table table-striped">
                            <tbody>
                                <tr>
                                    <td ng-repeat="n in [] | range:10">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" id="trato_general" value="@{{n}}" name="trato_general" required ng-model="social.calificacion">
                                                @{{n}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="socialForm.$submitted || socialForm.trato_general.$touched">
                    <span class="label label-danger" ng-show="socialForm.trato_general.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P3. Califique como alto, medio y bajo su nivel de conocimiento de los servicios, productos y atractivos culturales que ofrece Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary" ng-repeat="ite in criterios">
                                <label>
                                    <input type="radio" value="@{{ite.id}}" name="criteriosC" ng-model="social.criterios_calificacion_id" required>
                                    @{{ite.nombre}}
                                </label>
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.criteriosC.$touched">
                                <span class="label label-danger" ng-show="socialForm.criteriosC.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
       
        <div class="panel panel-success" ng-show="social.criterios_calificacion_id!=4 && social.criterios_calificacion_id != undefined">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.3.1. ¿Ofrece información a los visitantes sobre los servicios, productos, atractivos turísticos y culturales que hay en Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="ofreceInfo" ng-model="social.ofrece_informacion" ng-required="social.criterios_calificacion_id!=4">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="ofreceInfo" ng-model="social.ofrece_informacion"  ng-required="social.criterios_calificacion_id!=4">
                                    No
                                </label>
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.ofreceInfo.$touched">
                                <span class="label label-danger" ng-show="socialForm.ofreceInfo.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.4 ¿Ha sido parte de alguna asociación o gremio que ofrezca servicios turísticos en Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="gremio" ng-model="social.pertenece_gremio" required>
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="gremio" ng-model="social.pertenece_gremio" required>
                                    No
                                </label>
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.gremio.$touched">
                                <span class="label label-danger" ng-show="socialForm.gremio.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.5 ¿Ha participado en  alguna  de  las  siguientes  acciones  para  conservar  y  rescatar  la  cultura  del Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="checkbox" ng-repeat="ite in culturales| orderBy : 'peso'">
                                <label>
                                    <input type="checkbox" ng-disabled="bandera==false && ite.id==9" checklist-model="social.culturales" name ="cultural" checklist-value="ite.id" > @{{ite.nombre}}
                                </label>
                                <input type="text" style="display: inline-block;" class="form-control" id="inputOtro_cultura" placeholder="Escriba su otra opción" ng-model="social.otroCultura" ng-blur="verificarOtro(social.culturales,9,social.otroCultura)" ng-if="ite.id==9" />
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.cultural.$touched">
                                <span class="label label-danger" ng-show="social.culturales.length==0">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
         </div>
         
         <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.6 De las siguientes situaciones en función del turismo sostenible, ¿Cuáles considera que representan  un riesgo  alto, medio  o bajo en  Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>RIESGOS</th>
                                        <th ng-repeat="item in criterios">@{{item.nombre}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in riesgos">
                                        <td>
                                            @{{item.nombre}} <input type="text" name="otroRiesgo" ng-required="verificarOtroTabla(riesgos,8)" class="form-control" ng-if="item.id==8" ng-model="item.otroRiesgo" >
                                            <span class="label label-danger" ng-show="socialForm.riesgo_@{{item.id}}.$error.required && socialForm.$submitted">* Requerido.</span>
                                            <span class="label label-danger" ng-if="item.id==8"  ng-show="socialForm.otroRiesgo.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in criterios">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="riesgo_@{{item.id}}" value="@{{cal.id}}" ng-model="item.calificacion" ng-required="item.id != 8" >       
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> P.7 En una escala de 1 a 10, donde 1 es Muy Insatisfecho y 10 Muy Satisfecho, ¿Cómo calificaría su nivel de satisfacción con la llegada de turistas a Magdalena?</b></h3>
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
                                                <input type="radio" id="nivel_sastifacion" value="@{{n}}" name="nivel_sastifacion" required ng-model="social.nivel_sastifacion">
                                                @{{n}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <span ng-show="socialForm.$submitted || socialForm.nivel_sastifacion.$touched">
                    <span class="label label-danger" ng-show="socialForm.nivel_sastifacion.$error.required">*El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b>P8. ¿Cree que la llegada de turistas ha incidido en la calidad de vida de Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta  única </b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="cambian_turistas" ng-model="social.cambian_turistas" >
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="cambian_turistas" ng-model="social.cambian_turistas" >
                                    No
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="null" name="cambian_turistas" ng-model="social.cambian_turistas" >
                                    No sabe /No responde
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="panel panel-success" ng-show="social.cambian_turistas==  true">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.8.1 De los siguientes factores de calidad de vida, ¿Cuáles cree que han mejorado, desmejorado o permanecen igual en Magdalena, como consecuencia del turismo?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>FACTORES</th>
                                        <th ng-repeat="item in calificacionFactor">@{{item.nombre}}</th>
                                        <th>No sabe/ No responde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in factores | filter:{ tipo_factor_id: 1 } ">
                                        <td>
                                            @{{item.nombre}} <input type="text" name="otroFactor1" ng-required="verificarOtroTabla(factores,11)" class="form-control" ng-if="item.id==11" ng-model="item.otroFactor1" >
                                             <span class="label label-danger" ng-if="item.id==11"  ng-show="socialForm.otroFactor1.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in calificacionFactor" style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_1_@{{item.id}}" value="@{{cal.id}}" ng-model="item.calificacion">       
                                                </label>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_1_@{{item.id}}" ng-value="null" ng-model="item.calificacion" >       
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
                    <h3 class="panel-title"><b>P9. ¿Cree que, desde la llegada de turistas, la conservación de patrimonio cultural ha tenido alguna afectación? </b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta  única </b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="conservacion" ng-model="social.conservacion_patrimonio_id" >
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="conservacion" ng-model="social.conservacion_patrimonio_id" >
                                    No
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="null" name="conservacion" ng-model="social.conservacion_patrimonio_id" >
                                    No sabe /No responde
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-success" ng-show="social.conservacion_patrimonio_id== true">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.9.1 De las siguientes situaciones en función del turismo sostenible, ¿Cuáles considera que representan  un riesgo  alto, medio  o bajo en  Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>FACTORES</th>
                                        <th ng-repeat="item in calificacionFactor">@{{item.nombre}}</th>
                                        <th>No sabe/ No responde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in factores | filter:{ tipo_factor_id: 2 } ">
                                        <td>
                                            @{{item.nombre}} <input type="text" name="otroFactor2"  ng-required="verificarOtroTabla(factores,29)" class="form-control" ng-if="item.id==29" ng-model="item.otroFactor2" >
                                            <span class="label label-danger" ng-if="item.id==29"  ng-show="socialForm.otroFactor2.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in calificacionFactor">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_2_@{{item.id}}" value="@{{cal.id}}" ng-model="item.calificacion" >       
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_2_@{{item.id}}" ng-model="item.calificacion" ng-value="null" >       
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
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.10 ¿Posee viviendas, distintas a la vivienda donde reside, que estén siendo destinadas para turismo en  Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="viviendas_turisticas" ng-model="social.viviendas_turisticas" required>
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="viviendas_turisticas" ng-model="social.viviendas_turisticas" required>
                                    No
                                </label>
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.viviendas_turisticas.$touched">
                                <span class="label label-danger" ng-show="socialForm.viviendas_turisticas.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="panel panel-success" ng-show="social.viviendas_turisticas == true">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.10.1 ¿Cuántas de sus viviendas tienen uso turístico actualmente?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta abierta</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" name="numero" class="form-control" min="1"  ng-model="social.cantidad" placeholder="Presione aquí para ingresar el número de viviendas" ng-required="social.viviendas_turisticas == true"/>
                        </div>
                    </div>
                    <span ng-show="socialForm.$submitted || socialForm.numero.$touched">
                        <span class="label label-danger" ng-show="socialForm.numero.$error.required">* El campo es requerido.</span>
                        <span class="label label-danger" ng-show="socialForm.numero.$error.number">* Debe introducir solo numeros.</span>
                        <span class="label label-danger" ng-show="!socialForm.numero.$valid">* Solo numeros iguales o mayores que uno.</span>
                    </span>
                </div>
        </div>
        
         <div class="panel panel-success" ng-show="social.viviendas_turisticas == true">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.10.2 ¿Por qué decidió cambiar el uso de su vivienda para turismo? </b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="razon_cambio" name="razon_cambio" ng-model="social.razon_cambio" class="form-control" placeholder="Escriba aquí su razón" ng-required="social.viviendas_turisticas == true"></textarea>
                    </div>
                </div>
                <span ng-show="socialForm.$submitted || socialForm.razon_cambio.$touched">
                    <span class="label label-danger" ng-show="socialForm.razon_cambio.$error.required">Campo requerido</span>
                 </span>
            </div>
        </div> 
        
        <div class="panel panel-success" ng-show="social.viviendas_turisticas == true">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.10.3 Por favor indique sólo para la primera vivienda que destinó para turismo y que esté activa actualmente, ¿Hace cuánto tiempo (meses) está siendo utilizada para este fin? </b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta abierta</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" name="numero_meses" class="form-control" min="1"  ng-model="social.numero_meses" placeholder="Presione aquí para ingresar el número de meses" ng-required="social.viviendas_turisticas == true"/>
                        </div>
                    </div>
                    <span ng-show="socialForm.$submitted || socialForm.numero_meses.$touched">
                        <span class="label label-danger" ng-show="socialForm.numero_meses.$error.required">* El campo es requerido.</span>
                        <span class="label label-danger" ng-show="socialForm.numero_meses.$error.number">* Debe introducir solo numeros.</span>
                        <span class="label label-danger" ng-show="!socialForm.numero_meses.$valid">* Solo numeros iguales o mayores que uno.</span>
                    </span>
                </div>
        </div>
        
        <div class="panel panel-success" ng-show="social.viviendas_turisticas == true">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.10.4 ¿Cuántas de las propiedades mencionadas anteriormente están inscritas en el Registro Nacional de Turismo (RNT)? </b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta abierta</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" name="cuantas_rnt" class="form-control" min="0"  ng-model="social.cuantas_rnt" placeholder="Presione aquí para ingresar la cantidad de RNT" ng-required="social.viviendas_turisticas == true"/>
                        </div>
                    </div>
                    <span ng-show="socialForm.$submitted || socialForm.cuantas_rnt.$touched">
                        <span class="label label-danger" ng-show="socialForm.cuantas_rnt.$error.required">* El campo es requerido.</span>
                        <span class="label label-danger" ng-show="socialForm.cuantas_rnt.$error.number">* Debe introducir solo numeros.</span>
                        <span class="label label-danger" ng-show="!socialForm.cuantas_rnt.$valid">* Solo numeros iguales o mayores que cero.</span>
                    </span>
                </div>
        </div>
         
        <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b>P.11 De los siguientes factores de identidad cultural, ¿En cuáles percibe que el turismo ha tenido un efecto positivo o negativo en Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>FACTORES</th>
                                        <th>Positivo</th>
                                        <th>Negativo</th>
                                        <th>No sabe/ No responde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in factoresPositivos">
                                        <td>
                                            @{{item.nombre}} <input type="text" name="otroFactor3" ng-required="verificarOtroTabla(factoresPositivos,36)" class="form-control" ng-if="item.id==36" ng-model="item.otroFactor3" >
                                             <span class="label label-danger" ng-if="item.id==36"  ng-show="socialForm.otroFactor3.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_3_@{{item.id}}" ng-value="true" ng-model="item.calificacion" >       
                                                </label>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_3_@{{item.id}}" ng-value="false" ng-model="item.calificacion" >       
                                                </label>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="factor_3_@{{item.id}}" ng-value="null"  ng-model="item.calificacion"  >       
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
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.11.1 Califique como positivo o negativo el efecto que ha tenido el turismo en las costumbres y tradiciones en Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="efecto_turismo" ng-model="social.efecto_turismo" required>
                                    Positivo
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="efecto_turismo" ng-model="social.efecto_turismo" required>
                                    Negativo
                                </label>
                            </div>
                            <span ng-show="socialForm.$submitted || socialForm.efecto_turismo.$touched">
                                <span class="label label-danger" ng-show="socialForm.efecto_turismo.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
         
        <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.12 De los siguientes beneficios socioculturales que se generan por el turismo, ¿Cuáles cree que han mejorado, desmejorado o permanecen igual en Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                             
                             <h4>BENEFICIOS</h4>
                             
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Temporada baja</th>
                                        <th ng-repeat="ite in calificacionFactor">@{{ite.nombre}}</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in beneficios | filter:{ tipo_temporada: true } ">
                                        <td>
                                            @{{item.nombre}} <input type="text" class="form-control" ng-required="verificarOtroTabla(beneficios,6)" name="otroBB" ng-if="item.id==6" ng-model="item.beneficioBajo" >
                                            <span class="label label-danger" ng-show="socialForm.beneficioB@{{item.id}}.$error.required && socialForm.$submitted">* Requerido.</span>
                                            <span class="label label-danger" ng-if="item.id==6"  ng-show="socialForm.otroBB.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in calificacionFactor" style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="beneficioB@{{item.id}}" ng-value="cal.id" ng-model="item.calificacion" ng-required="item.id != 6" >       
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                         <div class="col-md-12" style="overflow-x: auto;">
                             
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Temporada Alta</th>
                                        <th ng-repeat="ite in calificacionFactor">@{{ite.nombre}}</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in beneficios | filter:{ tipo_temporada: false } ">
                                        <td>
                                            @{{item.nombre}}  <input type="text" class="form-control" name="beneficioAlto" ng-required="verificarOtroTabla(beneficios,12)"  ng-if="item.id==12" ng-model="item.beneficioAlto" >
                                            <span class="label label-danger" ng-show="socialForm.beneficioA@{{item.id}}.$error.required && socialForm.$submitted">* Requerido.</span>
                                            <span class="label label-danger" ng-if="item.id==12"  ng-show="socialForm.beneficioAlto.$error.required && socialForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in calificacionFactor" style="text-align: center;">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="beneficioA@{{item.id}}" ng-value="cal.id" ng-model="item.calificacion" ng-required="item.id != 12" >       
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
                    <h3 class="panel-title"><b>P.13 Mencione los efectos positivos y negativos generados por el turismo en la conservación de las costumbres, tradiciones y patrimonio cultural del Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                         <div class="col-md-12" style="overflow-x: auto;">
                            <table  align="center" name="tabla_calificacion" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Positivo</th>
                                        <th>Negativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><textarea id="positivo" name="positivo" ng-model="social.positivo" class="form-control" placeholder="Escriba aquí su razón"></textarea></td>
                                        <td><textarea id="negativo" name="negativo" ng-model="social.negativo" class="form-control" placeholder="Escriba aquí su razón"></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
         </div>
         <div class="row" style="text-align:center">
             <a href="/sostenibilidadhogares/editar/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <button type="submit" class="btn btn-raised btn-success" ng-click="guardar()">Guardar</button>
        </div>
    </form>
    
    
    
    <div class='carga'>

    </div>
</div>

@endsection