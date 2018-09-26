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

@section('TitleSection', 'COMPONENTE AMBIENTAL')

@section('Progreso', '66.66%')

@section('NumSeccion', '66.66%')

@section('controller','ng-controller="ambientalController"')

@section('content')

<div class="content">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />   
    
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
    
    <form name="ambientalForm" novalidate role="form">
        
       <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.14 ¿Cuáles áreas protegidas identifica en Magdalena? </b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta abierta</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="areas" name="areas" ng-model="ambiental.areas_protegidas" class="form-control" placeholder="Escriba aquí su razón" ng-maxlength="2000" ng-required="true"></textarea>
                    </div>
                </div>
                <span ng-show="ambientalForm.$submitted || ambientalForm.areas.$touched">
                    <span class="label label-danger" ng-show="ambientalForm.areas.$error.required">Campo requerido</span>
                 </span>
            </div>
        </div>
        
         <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>15. ¿Qué nivel de conocimiento tiene sobre las especies de flora y fauna características del Magdalena</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary" ng-repeat="ite in criterios">
                                <label>
                                    <input type="radio" value="@{{ite.id}}" name="criteriosC" ng-model="ambiental.criterios_calificacion_id" required>
                                    @{{ite.nombre}}
                                </label>
                            </div>
                            <span ng-show="ambientalForm.$submitted || ambientalForm.criteriosC.$touched">
                                <span class="label label-danger" ng-show="ambientalForm.criteriosC.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
        </div>
        
         <div class="panel panel-success" ng-show="ambiental.criterios_calificacion_id!=4 && ambiental.criterios_calificacion_id != undefined">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.15.1. ¿Sabe si en Magdalena existe una guía que caracterice la flora, fauna y especies en vía de extinción para la conservación de los mismos?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="true" name="existe_guia" ng-model="ambiental.existe_guia" ng-required="ambiental.criterios_calificacion_id!=4">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" ng-value="false" name="existe_guia" ng-model="ambiental.existe_guia"  ng-required="ambiental.criterios_calificacion_id!=4">
                                    No
                                </label>
                            </div>
                            <span ng-show="ambientalForm.$submitted || ambientalForm.existe_guia.$touched">
                                <span class="label label-danger" ng-show="ambientalForm.existe_guia.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.16 ¿Ha  participado  en  alguna  de  las  siguientes  actividades  para  conservar  el  medio ambiente del Magdalena?</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="checkbox" ng-repeat="ite in actividades">
                                <label>
                                    <input type="checkbox" ng-disabled="bandera==false && ite.id==6" checklist-model="ambiental.actividades" name ="actividad" checklist-value="ite.id" > @{{ite.nombre}}
                                </label>
                                <input type="text" style="display: inline-block;" class="form-control" id="inputOtro_ambiental" placeholder="Escriba su otra opción" ng-model="ambiental.otroActividad" ng-blur="verificarOtro(ambiental.actividades,6,ambiental.otroActividad,bandera)" ng-if="ite.id==6" />
                            </div>
                            <span ng-show="ambientalForm.$submitted || ambientalForm.actividad.$touched">
                                <span class="label label-danger" ng-show="ambiental.actividades.length==0">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
         </div>
         
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.17 Indique que acciones realiza en su hogar para manejar residuos sólidos y preservar el medio ambiente</b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="checkbox" ng-repeat="ite in acciones | filter:{tipo_accion_id:1}">
                                <label>
                                    <input type="checkbox" ng-disabled="bandera1==false && ite.id==15" checklist-model="ambiental.residuos" name ="residuo" checklist-value="ite.id" > @{{ite.nombre}}
                                </label>
                                <input type="text" style="display: inline-block;" class="form-control" id="inputOtro_accion1" placeholder="Escriba su otra opción" ng-model="ambiental.otroAccion1" ng-blur="verificarOtro(ambiental.residuos,15,ambiental.otroAccion1,bandera1)" ng-if="ite.id==15" />
                            </div>
                            <span ng-show="ambientalForm.$submitted || ambientalForm.residuo.$touched">
                                <span class="label label-danger" ng-show="ambiental.residuos.length==0">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
         </div>
        <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.18 De la siguiente lista indique, ¿Cómo ayuda a reducir el consumo de agua y energía en su hogar? </b></h3>
                </div>
                <div class="panel-footer"><b>Respuesta múltiple</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="checkbox" ng-repeat="ite in acciones | filter:{tipo_accion_id:2}">
                                <label>
                                    <input type="checkbox" ng-disabled="bandera2==false && ite.id==8" checklist-model="ambiental.aguas" name ="agua" checklist-value="ite.id" > @{{ite.nombre}}
                                </label>
                                <input type="text" style="display: inline-block;" class="form-control" id="inputOtro_accion2" placeholder="Escriba su otra opción" ng-model="ambiental.otroAccion2" ng-blur="verificarOtro(ambiental.aguas,8,ambiental.otroAccion2,bandera2)" ng-if="ite.id==8" />
                            </div>
                            <span ng-show="ambientalForm.$submitted || ambientalForm.agua.$touched">
                                <span class="label label-danger" ng-show="ambiental.aguas.length==0">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
         </div>
        
                 <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.6 De las siguientes situaciones en función del turismo sostenible, ¿Cuáles considera que representan  un riesgo  alto, medio  o bajo en  Magdalena</b></h3>
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
                                            @{{item.nombre}} <input type="text" name="otroRiesgo" ng-required="verificarOtroTabla(riesgos,21)" class="form-control" ng-if="item.id==21" ng-model="item.otroRiesgo" >
                                            <span class="label label-danger" ng-show="ambientalForm.riesgo_@{{item.id}}.$error.required && ambientalForm.$submitted">* Requerido.</span>
                                            <span class="label label-danger" ng-if="item.id==21"  ng-show="ambientalForm.otroRiesgo.$error.required && ambientalForm.$submitted">Campo Otro Requerido.</span>
                                        </td>
                                        <td ng-repeat="cal in criterios">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="riesgo_@{{item.id}}" value="@{{cal.id}}" ng-model="item.calificacion" ng-required="item.id != 21" >       
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>P.20 Califique como positivo o negativo el efecto que ha tenido el turismo en el medio ambiente en Magdalena</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" ng-value="true" name="efecto_turismo" ng-model="ambiental.efecto_turismo" required>
                                Positivo
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" ng-value="false" name="efecto_turismo" ng-model="ambiental.efecto_turismo" required>
                                Negativo
                            </label>
                        </div>
                        <span ng-show="ambientalForm.$submitted || ambientalForm.efecto_turismo.$touched">
                            <span class="label label-danger" ng-show="ambientalForm.efecto_turismo.$error.required">Campo requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div> 
         
        <div class="row" style="text-align:center">
            <a href="/sostenibilidadhogares/componentesocial/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <button type="submit" class="btn btn-raised btn-success" ng-click="guardar()">Guardar</button>
        </div>
    </form>
    
    <div class='carga'>

    </div>
</div>

@endsection