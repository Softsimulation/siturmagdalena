
@extends('layout._encuestaInternoLayout')

@section('Title','Duración de la estancia y lugares visitados - Encuesta interno y emisor :: SITUR Atlántico')


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
@section('TitleSection','Actividades Realizadas')
@section('Progreso','40%')
@section('NumSeccion','40%')
@section('Control','ng-controller="estancia"')

@section('contenido')

<div class="main-page" ng-controller="estancia">

    <form role="form" name="EstanciaForm" novalidate>
     
        <input type="hidden" ng-model="id" ng-init="id={{$id}}" />

        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>Errores:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -@{{error[0]}}
            </div>

        </div>
        <br />

              <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P2. ¿Que actividades realizó en el Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que actividades realizó en el Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="activ in Datos.Actividadesrelizadas" >
                            <label>
                                <input type="checkbox" checklist-model="encuesta.ActividadesRelizadas" name= "actividadesr"  checklist-value="activ.id"  ng-click="cambioActividadesRealizadas()" > @{{activ.actividades_realizadas_con_idiomas[0].nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.actividadesr.$touched">
                            <!--EncuestaEstanciaP2Alert1. Debe seleccionar alguno de los valores-->
                            <span class="label label-danger" ng-show="encuesta.ActividadesRelizadas.length == 0">* Debe seleccionar alguno de los valores</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(1)">
            <div class="panel-heading">
                <!-- P3. ¿Que playas visitó en el Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que playas visitó en el Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                     
                        <div class="checkbox" ng-repeat="atrac in Datos.Atracciones | filter : { IdT : 77 }">
                            <label>
                                <input type="checkbox" name ="atraccionplaya" checklist-model="encuesta.AtraccionesP" checklist-value="atrac.Id" > @{{atrac.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.atraccionplaya.$touched">
                            <!--EncuestaEstanciaP3Alert1. Debe seleccionar alguna playa-->
                            <span class="label label-danger" ng-show="encuesta.AtraccionesP.length == 0 && encuesta.ActividadesRelizadas.indexOf(1)>= 0">* Debe seleccionar alguna playa</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(2)">
            <div class="panel-heading">
                <!-- P4. ¿Qué parques naturales, Cascadas, ríos, pozos, balnearios, zoológicos y jardines botánicos visitó?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué parques naturales, Cascadas, ríos, pozos, balnearios, zoológicos y jardines botánicos visitó?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="tipo in Datos.TipoAtracciones | filter : { IdA : 2 }">
                            <label>
                                <input type="checkbox" name="tiponatural" checklist-model="encuesta.TipoAtraccionesN" checklist-value="tipo.Id"> @{{tipo.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.tiponatural.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="encuesta.TipoAtraccionesN.length == 0 && encuesta.ActividadesRelizadas.indexOf(2)>= 0 ">* Debe seleccionar alguna visita a parques, cascadas, ríos</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(2) && existetipon(94)">
            <div class="panel-heading">
                <!-- P5. ¿Qué parques?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué parques?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="atrac in Datos.Atracciones | filter : { IdT : 94 }">
                            <label>
                                <input type="checkbox" name="atraccionparque" checklist-model="encuesta.AtraccionesN" checklist-value="atrac.Id"> @{{atrac.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.atraccionparque.$touched">
                            <!--EncuestaEstanciaP5Alert1. Debe seleccionar algún parque-->
                            <span class="label label-danger" ng-show="encuesta.AtraccionesN.length == 0 && encuesta.TipoAtraccionesN.indexOf(94) >= 0 ">* Debe seleccionar algún parque</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(3)">
            <div class="panel-heading">
                <!-- P6. ¿Cuáles museos, casas de cultura, iglesias, santuarios y monumentos?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuáles museos, casas de cultura, iglesias, santuarios y monumentos?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="tipo in Datos.TipoAtracciones | filter : { IdA : 3 }">
                            <label>
                                <input type="checkbox" name="tipomuseos" checklist-model="encuesta.TipoAtraccionesM" checklist-value="tipo.Id"> @{{tipo.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.tipomuseos.$touched">
                            <!--EncuestaEstanciaP6Alert1. Debe seleccionar alguna opción-->
                            <span class="label label-danger" ng-show="encuesta.TipoAtraccionesM.length == 0 && encuesta.ActividadesRelizadas.indexOf(3)>= 0 ">* Debe seleccionar alguna opción</span>
                        </span>


                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(3) && existetipom(117)">
            <div class="panel-heading">
                <!-- P7. ¿Qué museos?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué museos?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="atrac in Datos.Atracciones | filter : { IdT : 117 }">
                            <label>
                                <input type="checkbox" name="atraccionmuseo" checklist-model="encuesta.AtraccionesM" checklist-value="atrac.Id"> @{{atrac.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.atraccionmuseo.$touched">
                            <!--EncuestaEstanciaP6Alert1. Debe seleccionar alguna opción-->
                            <span class="label label-danger" ng-show="encuesta.AtraccionesM.length == 0 && encuesta.TipoAtraccionesM.indexOf(117) >= 0 ">* Debe seleccionar alguna opción</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success" ng-if="existe(8)">
            <div class="panel-heading">
                <!-- P8. ¿Qué tipo de haciendas visitó?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué tipo de haciendas visitó?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="actividad in Datos.Actividades | filter : { IdA : 8 }">
                            <label>
                                <input type="checkbox" name ="actividadesh"checklist-model="encuesta.ActividadesH" checklist-value="actividad.Id"> @{{actividad.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.actividadesh.$touched">
                            <!--EncuestaEstanciaP6Alert1. Debe seleccionar alguna opción-->
                            <span class="label label-danger" ng-show="encuesta.ActividadesH.length == 0 && encuesta.ActividadesRelizadas.indexOf(8)>= 0 ">* Debe seleccionar alguna opción</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success" ng-if="existe(10)">
            <div class="panel-heading">
                <!-- P9. ¿Qué actividades deportivas realizó durante su estancia?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué actividades deportivas realizó durante su estancia?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="actividad in Datos.Actividades | filter : { IdA : 10 }">
                            <label>
                                <input type="checkbox"  name ="actividadesd" checklist-model="encuesta.ActividadesD" checklist-value="actividad.Id"> @{{actividad.Nombre}}
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.actividadesd.$touched">
                            <!--EncuestaEstanciaP6Alert1. Debe seleccionar alguna opción-->
                            <span class="label label-danger" ng-show="encuesta.ActividadesD.length == 0 && encuesta.ActividadesRelizadas.indexOf(10) >= 0 ">* Debe seleccionar una actividad</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
   


        <div class="row" style="text-align:center">
            <a href="/turismointerno/viajesrealizados/{{$idpersona}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar()">
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>

</div>

@endsection
