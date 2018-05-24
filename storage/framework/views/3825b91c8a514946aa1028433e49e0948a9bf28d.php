<?php $__env->startSection('Title','Fuentes de información - Turísmo interno y emisor :: SITUR'); ?>


<?php $__env->startSection('estilos'); ?>
    <style>
        .title-section {
            background-color: #16469e !important;
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('TitleSection','Fuentes de información'); ?>
<?php $__env->startSection('Progreso','100%'); ?>
<?php $__env->startSection('NumSeccion','100%'); ?>
<?php $__env->startSection('Control','ng-controller="fuentesInterno"'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="main-page">
    <input type="hidden" ng-model="id" ng-init="id=<?php echo e($id); ?>" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b><?php echo e(trans('resources.EncuestaMsgError')); ?>:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -{{error[0]}}
        </div>
    </div>
    <form role="form" name="inForm" novalidate>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿ Antes del viaje, de qué forma usted se enteró de los destinos turísticos visitados?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Antes del viaje, de qué forma usted se enteró de los destinos turísticos visitados?</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgSeleccionMultiple')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesAntes">
                            <label>
                                <input type="checkbox" name="fuentesAntes" checklist-model="enteran.FuentesAntes" checklist-value="it.id" ng-change="validar(2, it.id)"> {{it.nombre}}
                            </label>
                            <span ng-if="it.id==14">:<input type="text" name="otroFantes" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-model="enteran.OtroFuenteAntes" ng-change="validarOtro(0)" ng-required="enteran.FuentesAntes.indexOf(14) !== -1" /></span>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted || inForm.fuentesAntes.$touched">
                    <span class="label label-danger" ng-show="enteran.FuentesAntes.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="inForm.otroFantes.$error.required">* Debe escribir quien fue el otro acompañante.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Durante el viaje, de qué forma usted buscó más información sobre destinos turísticos?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Durante el viaje, de qué forma usted buscó más información sobre destinos turísticos?</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgSeleccionMultiple')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesDurante">
                            <label>
                                <input type="checkbox" name="fuentesDurante" checklist-model="enteran.FuentesDurante" ng-disabled="(enteran.FuentesDurante.indexOf(13) > -1 && it.id!=13)" ng-change="validar(0, it.id)" checklist-value="it.id"> {{it.nombre}}
                            </label>
                            <span ng-if="it.id==14">:<input type="text" name="otroDurante" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-disabled="enteran.FuentesDurante.indexOf(13) > -1 " ng-model="enteran.OtroFuenteDurante" ng-change="validarOtro(1)" ng-required="enteran.FuentesDurante.indexOf(14) != -1" /></span>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted || inForm.fuentesDurante.$touched">
                    <span class="label label-danger" ng-show="enteran.FuentesDurante.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="inForm.otroDurante.$error.required">* Debe escribir quien fue el otro acompañante.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Después del viaje en qué redes sociales compartió su experiencia de viaje (Comentarios, fotos, etc)?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Después del viaje en qué redes y medios sociales compartió su experiencia de viaje (Comentarios, fotos, etc)?</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgSeleccionMultiple')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in redes" style="margin-bottom: .5em;">
                            <label>
                                <input type="checkbox" name="redes" checklist-model="enteran.Redes" ng-disabled="enteran.Redes.indexOf(1) > -1 && it.id != 1" ng-change="validar(1, it.id)" checklist-value="it.id"> {{it.nombre}}
                            </label>
                        </div>

                    </div>
                </div>
                <span ng-show="inForm.$submitted || inForm.redes.$touched">
                    <span class="label label-danger" ng-show="enteran.Redes.length == 0">* Debe seleccionar alguno de los valores.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Le gustaría que le enviáramos información sobre el Magdalena a su correo electrónico?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span><?php echo e(trans('resources.EncuestaFuenteInfoP4')); ?></b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgSeleccionUnica')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="alojamientoSi" name="correo" value="1" ng-required="true" ng-model="enteran.Correo">
                                <?php echo e(trans('resources.EncuestaReSi')); ?>

                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="alojamientoNo" name="correo" value="0" ng-required="true" ng-model="enteran.Correo">
                                <?php echo e(trans('resources.EncuestaReNo')); ?>

                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.correo.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Le gustaría que le enviáramos una invitación por redes sociales para seguir al Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <?php echo e(trans('resources.EncuestaFuenteInfoP5')); ?></b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgSeleccionUnica')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlSi" name="invitacion" ng-required="true" value="1" ng-model="enteran.Invitacion">
                                 <?php echo e(trans('resources.EncuestaReSi')); ?>

                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlNo" name="invitacion" ng-required="true" value="0" ng-model="enteran.Invitacion">
                                <?php echo e(trans('resources.EncuestaReNo')); ?>

                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.invitacion.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>

        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en facebook?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> <?php echo e(trans('resources.EncuestaFuenteInfoP6')); ?></b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="<?php echo e(trans('resources.EncuestaFuenteInfoP6Input1')); ?>" ng-model="enteran.NombreFacebook" />
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en Twitter?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> <?php echo e(trans('resources.EncuestaFuenteInfoP7')); ?></b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="<?php echo e(trans('resources.EncuestaFuenteInfoP7Input1')); ?>" ng-model="enteran.NombreTwitter" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading"> 
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> De acuerdo a su experiencia durante el viaje realizado, calique B (Bueno) R (Regular) M (Malo), el siguiente grupo de preguntas referente a los servicios utilizados y al entorno turístico visitado: </b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SERVICIOS</th>
                                    <th>B</th>
                                    <th>R</th>
                                    <th>M</th>
                                    <th>No aplica</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="e in experiencias|filter:{tipo:false}" >
                                    <td>{{e.nombre}} <span ng-show="inForm.$submitted && inForm.calificacion_{{e.Id}}.$error.required">(Requerido)</span></td>
                                    <td ng-repeat="c in calificaciones" style="text-align:center">
                                        <div class="radio radio-primary" style="display: inline-block; margin:0">
                                            <label>
                                                <input type="radio"  name="calificacion_{{e.id}}" ng-model="e.valor" value="{{c.id}}" ng-required="true">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="text-align:center">
                                        <div class="radio radio-primary" style="display: inline-block; margin:0">
                                            <label>
                                                <input type="radio" name="calificacion_{{e.id}}" ng-model="e.valor" value="-1" ng-required="true" />
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="text-align: center">
                                        ENTORNO TURÍSTICO
                                    </th>
                                    <th colspan="3"></th>
                                </tr>
                                <tr ng-repeat="e in experiencias|filter:{tipo:true}">
                                    <td>{{e.nombre}} <span ng-show="inForm.$submitted && inForm.calificacion_{{e.id}}.$error.required">(Requerido)</span></td>
                                    <td ng-repeat="c in calificaciones" style="text-align:center">
                                        <div class="radio radio-primary" style="display: inline-block; margin:0">
                                            <label>
                                                <input type="radio" name="calificacion_{{e.id}}" ng-model="e.valor" value="{{c.id}}" ng-required="true">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="text-align:center">
                                        <div class="radio radio-primary" style="display: inline-block; margin:0">
                                            <label>
                                                <input type="radio" name="calificacion_{{e.id}}" ng-model="e.valor" value="-1" ng-required="true" />
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

        <div class="row" style="text-align:center">
            <a href="/turismointerno/gastos/{{id}}" class="btn btn-raised btn-default"><?php echo e(trans('resources.EncuestaBtnAnterior')); ?></a>
            <input type="submit" class="btn btn-raised btn-success" value="<?php echo e(trans('resources.EncuestaBtnSiguiente')); ?>" ng-click="guardar()">
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout._encuestaInternoLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>