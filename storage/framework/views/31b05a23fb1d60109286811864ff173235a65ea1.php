<?php $__env->startSection('title', 'Encuesta turismo receptor'); ?>

<?php $__env->startSection('estilos'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('TitleSection', 'Estancia y visitados'); ?>

<?php $__env->startSection('Progreso', '16.66%'); ?>

<?php $__env->startSection('NumSeccion', '16%'); ?>

<?php $__env->startSection('controller','ng-controller="estancia"'); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-page">

    <form role="form" name="EstanciaForm" novalidate>
        <input type="hidden" ng-model="id" ng-init="id=<?php echo e($id); ?>" />

        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>@Resource.EncuestaMsgError:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -{{error[0]}}
            </div>

        </div>
        <br />
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P1. Duración de la estancia-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Duración de la estancia</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <!-- P1Col1. Municipio visitado-->
                                        Municipio visitado
                                    </th>
                                    <th>
                                        <!-- P1Col2. Número de noches-->
                                        Número de noches
                                    </th>
                                    <th>
                                        <!-- P1Col3. Tipo de Alojamiento utilizadoa-->
                                        Tipo de Alojamiento utilizado
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                           data-original-title="Si utilizó más de un servicio de alojamiento en este municipio, seleccione en el que pasó el mayor número de noches.">
                                        </i>
                                        
                                    </th>
                                    <th>
                                        <!-- P1Col4. Destino Principal-->
                                        Destino Principal
                                    </th>
                                    <th>
                                        <!--EncuestaEstanciaBtnAgregarDest. Agregar destino-->
                                        <button type="button" class="btn btn-success" ng-click="agregar()" title="Agregar destino"><i class="material-icons">add</i></button>
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaAgregarDestino"
                                           style="text-align:right;">
                                        </i>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr ng-repeat="es in encuesta.Estancias">
                                    <th>
                                        <select ng-model="es.Municipio" name="municipio{{$index}}" style="width:100%" ng-change="cambioselectmunicipio(es)" class="form-control" ng-options="municipio.id as municipio.nombre for municipio in Datos.Municipios " ng-required="true">
                                            <!--EncuestaEstanciaP1Col1Select1. Selecione un municipio-->
                                            <option value="" disabled>Selecione un municipio</option>
                                        </select>
                                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.municipio{{$index}}.$touched">
                                            <!--P1Col1Alert1. Debe seleccionar un municipio-->
                                            <span class="label label-danger" ng-show="EstanciaForm.municipio{{$index}}.$error.required">Debe seleccionar un municipio</span>
                                        </span> 
                                    </th>
                                    <th>

                                        <input class="form-control" name="noche{{$index}}" ng-change="cambionoches(es)" min= "0" type="number" ng-model="es.Noches" placeholder="1" ng-required ="true"/><br />
                                        <span class="messages" ng-show="EstanciaForm.$submitted || EstanciaForm.noche{{$index}}.$touched">
                                            <!--EncuestaEstanciaP1Col2Select1Alert1. El campo es obligatorio-->
                                            <span class="label label-danger"  ng-show="EstanciaForm.noche{{$index}}.$error.required">*El campo es obligatorio</span>
                                            <!--EncuestaEstanciaP1Col2Select1Alert2. No es un número válido-->
                                            <span class="label label-danger"  ng-show="EstanciaForm.noche{{$index}}.$error.number">*No es un número válido</span>
                                            <!--EncuestaEstanciaP1Col2Alert3. El número de noches debe ser mínimo 0 -->
                                            <span class="label label-danger" ng-show="EstanciaForm.noche{{$index}}.$error.min">*El número de noches debe ser mínimo 0</span>
                                        </span>
                                    </th>
                                    <th>

                                        <select ng-model="es.Alojamiento" name="alojamiento{{$index}}" style="width:100%"  ng-change="cambioselectalojamiento(es)" class="form-control" ng-options="alojamiento.id as alojamiento.tipos_alojamiento_con_idiomas[0].nombre for alojamiento in Datos.Alojamientos " ng-required="true">
                                            <!--EncuestaEstanciaP1Col3Select1. Selecione tipo de alojamiento-->
                                            <option value="" disabled>Selecione tipo de alojamiento</option>
                                            
                                        </select>
                                        
                                        <i ng-if="es.Alojamiento==2" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoHotel"
                                            style="text-align:right;">
                                        </i>
                                        <i ng-if="es.Alojamiento==3" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoPosada"
                                           style="text-align:right;">
                                        </i>
                                        <i ng-if="es.Alojamiento==4" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoHostal"
                                           style="text-align:right;">
                                        </i>
                                        <i ng-if="es.Alojamiento==5" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoFinca"
                                           style="text-align:right;">
                                        </i>
                                        <i ng-if="es.Alojamiento==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoCentro"
                                           style="text-align:right;">
                                        </i>
                                        <i ng-if="es.Alojamiento==10" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="@Resource.AyudaTipoAlojamientoUtilizadoApartamento"
                                           style="text-align:right;">
                                        </i>
                                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.alojamiento{{$index}}.$touched">
                                            <!--EncuestaEstanciaP1Col3Select1Alert1. Debe seleccionar un tipo de alojamiento-->
                                            <span class="label label-danger" ng-show="EstanciaForm.alojamiento{{$index}}.$error.required">Debe seleccionar un tipo de alojamiento</span>
                                        </span> 


                                    </th>
                                    
                                    <th style="text-align: center;">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" ng-model="encuesta.Principal" ng-value="es.Municipio">

                                            </label>
                                        </div>
                                    </th>

                                    <th style="text-align: center;">
                                        <!--EncuestaEstanciaBtnEliminarDest. Eliminar destino-->
                                        <button type="button" class="btn btn-danger" ng-click="quitar(es)" title="Eliminar destino"><i class="material-icons">close</i></button>
                                    </th>

                                </tr>


                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P2. ¿Que actividades realizó en el Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que actividades realizó en el Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="activ in Datos.Actividadesrelizadas" >
                            <label>
                                <input type="checkbox" checklist-model="encuesta.ActividadesRelizadas" name= "actividadesr"  checklist-value="activ.id"  ng-click="cambioActividadesRealizadas()" > {{activ.actividades_realizadas_con_idiomas[0].nombre}}
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que playas visitó en el Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="atrac in Datos.Atracciones | filter : { IdT : 77 }">
                            <label>
                                <input type="checkbox" name ="atraccionplaya" checklist-model="encuesta.AtraccionesP" checklist-value="atrac.Id" > {{atrac.Nombre}}
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
                                <input type="checkbox" name="tiponatural" checklist-model="encuesta.TipoAtraccionesN" checklist-value="tipo.Id"> {{tipo.Nombre}}
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
                                <input type="checkbox" name="atraccionparque" checklist-model="encuesta.AtraccionesN" checklist-value="atrac.Id"> {{atrac.Nombre}}
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
                                <input type="checkbox" name="tipomuseos" checklist-model="encuesta.TipoAtraccionesM" checklist-value="tipo.Id"> {{tipo.Nombre}}
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
                                <input type="checkbox" name="atraccionmuseo" checklist-model="encuesta.AtraccionesM" checklist-value="atrac.Id"> {{atrac.Nombre}}
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
                                <input type="checkbox" name ="actividadesh"checklist-model="encuesta.ActividadesH" checklist-value="actividad.Id"> {{actividad.Nombre}}
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
                                <input type="checkbox"  name ="actividadesd" checklist-model="encuesta.ActividadesD" checklist-value="actividad.Id"> {{actividad.Nombre}}
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P10. ¿Qué actividades deportivas realizó durante su estancia?-->
                <h3 class="panel-title"><b> ¿Cuál fue su atracción favorita?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select ng-model="encuesta.Favorito" style="width:100%" class="form-control" ng-options="atrac.Id as atrac.Nombre  for atrac in Datos.AtraccionesPortal">
                            <!--EncuestaEstanciaP10OptionValue. Selecione una atracción-->
                            <option value="" disabled>Selecione una atracción</option>
                        </select>

                    </div>
                </div>

            </div>

        </div>


        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/editardatos/{{id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar()">
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout._encuestaLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>