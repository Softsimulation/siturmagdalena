<?php $__env->startSection('Title','Caracterización del hogar - Turísmo interno y emisor :: SITUR'); ?>


<?php $__env->startSection('estilos'); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('TitleSection','Caracterización del hogar'); ?>
<?php $__env->startSection('Progreso','0%'); ?>
<?php $__env->startSection('NumSeccion','0%'); ?>
<?php $__env->startSection('Control','ng-controller="crear_Hogar"'); ?>

<?php $__env->startSection('contenido'); ?>
<div>
    <input type="hidden" ng-model="encuesta.Temporada_id" ng-init="encuesta.Temporada_id=<?php echo e($id); ?>" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Corrige los errores:</b></label>
        <br />
        <div ng-repeat="error in errores">
            -{{error[0]}}
        </div>

    </div>
    <form name="DatosForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P4. Información del encuestado-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Información de la vivienda</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgCompleteInformacion')); ?></b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Fecha de aplicación</label>
                            <div class="col-xs-12">
                                <input type="date" class="form-control" id="inputNombreEncuestado" name="fecha_aplicacion" ng-model="encuesta.Fecha_aplicacion" placeholder="yyyy-mm-dd" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.fecha_aplicacion.$touched">
                                    <!--P4P1Input1. El campo fecha de aplicación es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.fecha_aplicacion.$error.required">*El campo es requerido</span>
                                    <span class="label label-danger" ng-show="DatosForm.fecha_aplicacion.$error.date">*El campo debe ser una fecha válida</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Hora de aplicación</label>
                            <div class="col-xs-12">
                                <input type="time" class="form-control" id="inputNombreEncuestado" name="hora_aplicacion" ng-model="encuesta.Hora_aplicacion" placeholder="hh:mm" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.hora_aplicacion.$touched">
                                    <!--P4P1Input1. El campo nombre es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.hora_aplicacion.$error.required">*El campo es requerido</span>
                                    <span class="label label-danger" ng-show="DatosForm.hora_aplicacion.$error.time">*El campo debe ser una hora valida</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="inputPaisResidencia" class="col-xs-12 control-label">Municipio</label>

                            <div class="col-xs-12">

                                <select class="form-control" ng-model="municipio" id="inputPaisResidencia" name="municipio" ng-change="changebarrio()" ng-required="true">
                                    <option value="" disabled>Seleccione un municipio</option>
                                    <option ng-repeat="item in municipios" value="{{item.id}}">{{item.nombre}}</option>
                                </select>

                                <span ng-show="DatosForm.$submitted || DatosForm.municipio.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.municipio.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">

                            <label for="inputDepartamentoResidencia" class="col-xs-12 control-label">Barrio</label>

                            <div class="col-xs-12">
                                <!--P4P10Select1. Seleccione un Barrio-->
                                <select class="form-control" id="inputDepartamentoResidencia" name="barrio" ng-model="encuesta.Barrio" ng-required="true">
                                    <option value="" disabled>Seleccione un barrio</option>
                                    <option ng-repeat="item in barrios" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                <!--P4P10Alert1. El campo Barrio de residencia es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.barrio.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.barrio.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>                   
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label for="inputEstrato" class="col-xs-12 control-label">Estrato</label>

                            <div class="col-xs-12">
                                <select class="form-control" ng-model="encuesta.Estrato"  name="estrato" ng-required="true">
                                    <option value="" disabled>Seleccione un estrato</option>
                                    <option ng-repeat="item in estratos" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                <span ng-show="DatosForm.$submitted || DatosForm.estrato.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.estrato.$error.required">*El campo es requerido</span>                                   
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputDireccion" class="col-xs-12 control-label">Dirección</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="inputDireccion" name="direccion" ng-model="encuesta.Direccion" ng-required="true" placeholder="Dirección" />
                                <span ng-show="DatosForm.$submitted || DatosForm.direccion.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.direccion.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Telefono Fijo</label>
                            <div class="col-xs-12">
                                <input type="text" class="form-control" id="inputNombreEncuestado" name="telefono" ng-model="encuesta.Telefono" ng-required="true" placeholder="Telefono fijo" />
                                <span ng-show="DatosForm.$submitted || DatosForm.telefono.$touched">
                                    <!--P4P1Input1. El campo fecha de aplicación es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.telefono.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>                    

                </div>
            </div>
        </div>       

        <div class="panel panel-success">
            <div class="panel-heading p1">                
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Información del hogar</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgCompleteInformacion')); ?></b></div>
            <div class="panel-body">
                <a class="btn btn-raised btn-info" style="background-color:#337ab7;" ng-click="nuevo()">Agregar integrante</a>
                <table class="table table-hover table-striped" ng-show="encuesta.integrantes.length>0">
                    <thead>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Jefe de hogar</th>
                            <th class="text-center" style="width: 120px">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="i in encuesta.integrantes">
                            <td>{{i.Nombre}}</td>
                            <td class="text-center">
                                <div class="radio radio-primary" style="display: inline-block;margin-top: 0; margin-bottom: 0;">
                                    <label>
                                        <input type="radio" name="integrantes" ng-model="encuesta.jefe_hogar" value="$index">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" style="margin: 0;padding: 5px 10px;" ng-click="nuevo($index)" title="Editar"><i class="material-icons">mode_edit</i></button>
                                <button type="button" class="btn btn-danger btn-sm" style="margin: 0;padding: 5px 10px;" ng-click="Eliminar($index)" title="Eliminar"><i class="material-icons">delete</i></button>
                                <!--   <i class="material-icons"  style="cursor:pointer;">content_paste</i>-->
                            </td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P4. Información del encuestado-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Datos del entrevistado</b></h3>
            </div>
            <div class="panel-footer"><b><?php echo e(trans('resources.EncuestaMsgCompleteInformacion')); ?></b></div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Nombre</label>
                            <div class="col-xs-12">
                                <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                <input type="text" class="form-control" id="inputNombreEncuestado" name="nombre_entrevistado" ng-model="encuesta.Nombre_Entrevistado" placeholder="Nombre" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.nombre_entrevistado.$touched">
                                    <!--P4P1Input1. El campo nombre es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.nombre_entrevistado.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Celular</label>
                            <div class="col-xs-12">                               
                                <input type="text" class="form-control" id="inputNombreEncuestado" name="celular_entrevistado" ng-model="encuesta.Celular_Entrevistado" placeholder="Celular" />
                                <span ng-show="DatosForm.$submitted || DatosForm.celular_entrevistado.$touched">
                                    <!--P4P1Input1. El campo nombre es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.celular_entrevistado.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Email</label>
                            <div class="col-xs-12">
                                <input type="email" class="form-control" id="inputNombreEncuestado" name="email_entrevistado" ng-model="encuesta.Email_Entrevistado" placeholder="Email"  />
                                <span ng-show="DatosForm.$submitted || DatosForm.email_entrevistado.$touched">
                                    <!--P4P1Input1. El campo nombre es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.email_entrevistado.$error.required">*El campo es requerido</span>
                                    <span class="label label-danger" ng-show="DatosForm.email_entrevistado.$error.email">*El campo debe ser un email válido</span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                </div>


               
            </div>

        <div class="row" style="text-align:center">
            <input type="submit" class="btn btn-raised btn-success" ng-click="enviar()" value="Guardar" />
        </div>
        
        <div class='carga'>

        </div>

    </form>
    <div id="inte" class="modal" data-backdrop="static" 
   data-keyboard="false" >
        <form name="IntegranteForm" novalidate>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Agregar integrante</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Nombre</label>
                                    <div class="col-xs-12">
                                        <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                        <input type="text" class="form-control" id="inputNombreEncuestado" name="nombre" ng-model="integrante.Nombre" placeholder="Nombre" ng-required="true" />
                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.nombre.$touched">
                                            <!--P4P1Input1. El campo nombre es requerido-->
                                            <span class="label label-danger" ng-show="IntegranteForm.nombre.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">


                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Edad</label>
                                    <div class="col-xs-12">
                                        <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                        <input type="number" class="form-control" id="inputNombreEncuestado" name="edad" ng-model="integrante.Edad" placeholder="Edad" ng-required="true" />
                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.edad.$touched">
                                            <!--P4P1Input1. El campo edad es requerido-->
                                            <span class="label label-danger" ng-show="IntegranteForm.edad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="IntegranteForm.edad.$error.number">*El campo debe ser un número</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Sexo</label>
                                    <div class="col-xs-12">
                                        <div class="radio radio-primary" style="display: inline-block;">
                                            <label>
                                                <!--P4P4Radio1. Hombre-->
                                                <input type="radio" name="sexo" ng-model="integrante.Sexo" value="true" ng-required="true">
                                                <?php echo e(trans('resources.EncuestaGeneralP4P4Radio1')); ?>

                                            </label>
                                        </div>
                                        <div class="radio radio-primary" style="display: inline-block;">
                                            <label>
                                                <!--P4P4Radio2. Mujer-->
                                                <input type="radio" name="sexo" ng-model="integrante.Sexo" value="false" ng-required="true">
                                                <?php echo e(trans('resources.EncuestaGeneralP4P4Radio2')); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">

                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.sexo.$touched">
                                            <!--P4P4Alert1. El campo sexo es requerido-->
                                            <span class="label label-danger" ng-show="IntegranteForm.sexo.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">

                          <!--
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Telefono</label>
                                    <div class="col-xs-12">
                                        <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado--><!--
                                        <input type="text" class="form-control" id="inputNombreEncuestado" name="telefono" ng-model="integrante.Telefono" placeholder="Telefono"  />
                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.telefono.$touched">
                                            <!--P4P1Input1. El campo nombre es requerido--><!--
                                            <span class="label label-danger" ng-show="IntegranteForm.telefono.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                                                                                               
                                                                                               -->

                            <div class="col-xs-12 col-sm-12 col-md-">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Celular</label>
                                    <div class="col-xs-12">
                                        <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                        <input type="text" class="form-control" id="inputNombreEncuestado" name="celular" ng-model="integrante.Celular" placeholder="Celular"  />
                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.celular.$touched">
                                            <!--P4P1Input1. El campo nombre es requerido-->
                                            <span class="label label-danger" ng-show="IntegranteForm.celular.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Email</label>
                                    <div class="col-xs-12">
                                        <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                        <input type="email" class="form-control" id="inputNombreEncuestado" name="email" ng-model="integrante.Email" placeholder="Email"  />
                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.email.$touched">
                                            <!--P4P1Input1. El campo nombre es requerido-->
                                            <span class="label label-danger" ng-show="IntegranteForm.email.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="IntegranteForm.email.$error.email">*El campo debe ser un email válido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>                      

                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Nivel de educación</label>
                                    <div class="col-xs-12">

                                        <select class="form-control" ng-model="integrante.Nivel_Educacion" id="inputPaisResidencia" name="nivel" ng-required="true">
                                            <option value="" disabled>Seleccione un nivel de educación</option>
                                            <option ng-repeat="item in niveles" value="{{item.id}}">{{item.nombre}}</option>
                                        </select>

                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.nivel.$touched">
                                            <span class="label label-danger" ng-show="IntegranteForm.nivel.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">Finalizó un viaje que habia emprendido en ...</label>
                                    <div class="col-xs-12">

                                        <select class="form-control" ng-model="integrante.Viaje" id="inputPaisResidencia" name="viaje" ng-required="true">
                                            <option value="" disabled>Seleccione una opción</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>

                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.Viaje.$touched">
                                            <span class="label label-danger" ng-show="IntegranteForm.Viaje.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                             <div class="row">                  
                            <div class="col-xs-12 col-sm-12 col-md-12" ng-if="integrante.Viaje == '0'">
                                <div class="form-group">
                                    <label for="inputNombreEncuestado" class="col-xs-12 control-label">¿Por qué motivos no realizó ningún viaje?</label>
                                    <div class="col-xs-12">

                                        <select class="form-control" ng-model="integrante.Motivo" id="inputPaisResidencia" name="motivo" ng-required="integrante.Viaje == '0'">
                                            <option value="" disabled>Seleccione una opción</option>
                                            <option ng-repeat="item in motivos" value="{{item.id}}">{{item.nombre}}</option>
                                        </select>

                                        <span ng-show="IntegranteForm.$submitted || IntegranteForm.Motivo.$touched">
                                            <span class="label label-danger" ng-show="IntegranteForm.Motivo.$error.required">*El campo es requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>.
                        <button type="submit"  class="btn btn-primary" ng-click="SavePersona()" >Guardar</button>                       
                    </div>
                </div>
            </div>            
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout._encuestaInternoLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>