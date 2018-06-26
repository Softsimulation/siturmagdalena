<?php $__env->startSection('title', 'Encuesta turismo receptor'); ?>

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
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('TitleSection', 'Encuesta turismo receptor'); ?>

<?php $__env->startSection('Progreso', '0%'); ?>

<?php $__env->startSection('NumSeccion', '0%'); ?>

<?php $__env->startSection('controller','ng-controller="crear"'); ?>

<?php $__env->startSection('content'); ?>
    
<div class="container">
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -{{error[0]}}
        </div>

    </div>
    <form role="form" name="DatosForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P1. Grupo de Viaje-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Grupo de Viaje</b></h3>
            </div>
            <div class="panel-footer"><b>Presione aquí para desplegar las opciones</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select name="grupo" class="form-control" ng-model="encuesta.Grupo" ng-required="true">
                            <!--P1Select1. Presione aquí para seleccionar un grupo-->
                            <option value="" disabled>Presione aquí para seleccionar algún grupo</option>
                            <option ng-repeat="item in grupos" value="{{item}}">{{item}}</option>
                        </select>
                        <span ng-show="DatosForm.$submitted || DatosForm.grupo.$touched">
                            <!--P1Alert1. El campo grupo de Viaje es requerido.-->
                            <span class="label label-danger" ng-show="DatosForm.grupo.$error.required">*El campo grupo de Viaje es requerido.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P2. Encuestador-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Encuestador</b></h3>
            </div>
            <div class="panel-footer"><b>Presione aquí para desplegar las opciones</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="encuestador" ng-model="encuesta.Encuestador" ng-required="true">
                            <!--P2Select1. Presione aquí para seleccionar un encuestador-->
                            <option value="" disabled>Presione aquí para seleccionar un encuestador</option>
                            <option ng-repeat="item in encuestadores" value="{{item.id}}">{{item.asp_net_user.username}}</option>
                        </select>
                        <span class="text-danger" ng-show="DatosForm.$submitted || DatosForm.encuestador.$touched">
                            <!--P2Alert1. El campo encuestador es requerido.-->
                            <span class="label label-danger" ng-show="DatosForm.encuestador.$error.required">*El campo encuestador es requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P3. Fecha de viaje-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Fecha de viaje</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <!--P3P1. Fecha de Llegada-->
                            <label for="fechaLlegada" class="col-xs-12 control-label">Fecha de Llegada</label>

                            <div class="col-xs-12">
                                <input type="date" class="form-control" id="fechaLlegada" name="llegada" ng-model="encuesta.Llegada" placeholder="@Resource.EncuestaGeneralP3P1" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.llegada.$touched">
                                    <!--P3P1Alert1. El campo fecha de llegada es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.llegada.$error.required">*El campo fecha de llegada es requerido</span>
                                    <span class="label label-danger" ng-show="DatosForm.llegada.$error.date">*El campo fecha de llegada debe ser una fecha válida</span>
                                    <span class="label label-danger" ng-show="DatosForm.llegada.$error.max">*El campo fecha de llegada debe ser menor o igual al día de hoy</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <!--P3P2. Fecha de Salida-->
                            <label for="fechaSalida" class="col-xs-12 control-label">Fecha de Salida</label>

                            <div class="col-xs-12">
                                <input type="date" id="fechaSalida" name="salida" class="form-control" ng-model="encuesta.Salida" placeholder="@Resource.EncuestaGeneralP3P2" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.salida.$touched">
                                    <!--P3P2Alert1. El campo fecha de salida es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.salida.$error.required">*El campo fecha de salida es requerido</span>
                                    <span class="label label-danger" ng-show="DatosForm.salida.$error.date">*El campo fecha de salida debe ser una fecha válida</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P4. Información del encuestado-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Información del encuestado</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <!--P4P1. Nombre del Encuestado-->
                            <label for="inputNombreEncuestado" class="col-xs-12 control-label">Nombre del Encuestado</label>

                            <div class="col-xs-12">
                                <!--P4P1Input1. Presione aquí para ingresar el nombre del Encuestado-->
                                <input type="text" class="form-control" id="inputNombreEncuestado" name="nombre" ng-model="encuesta.Nombre" placeholder="Presione aquí para ingresar el nombre del Encuestado" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.nombre.$touched">
                                    <!--P4P1Input1. El campo nombre es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.nombre.$error.required">*El campo nombre es requerido</span>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <!--P4P2. Email-->
                            <label for="inputEmail" class="col-xs-12 control-label">Email</label>

                            <div class="col-xs-12">
                                <!--P4P3Input1. Ingrese su email-->
                                <input type="email" class="form-control" name="email" placeholder="Ingrese su email" ng-model="encuesta.Email" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.email.$touched">
                                    <!--P4P2Alert1. El campo email es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.email.$error.required">*El campo email es requerido</span>
                                    <!--P4P2Alert2. El campo email no es un email válido-->
                                    <span class="label label-danger" ng-show="DatosForm.email.$error.email">*El campo email no es un email válido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <!--P4P3. Edad-->
                            <label for="inputEdad" class="col-xs-12 control-label">Edad</label>

                            <div class="col-xs-12">
                                <!--P4P3Input1. Ingrese su edad-->
                                <input type="number" class="form-control" name="edad" min="16" max="150" placeholder="Ingrese su edad" ng-model="encuesta.Edad" ng-required="true" />
                                <span ng-show="DatosForm.$submitted || DatosForm.edad.$touched">
                                    <!--P4P3Alert1. El campo edad es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.edad.$error.required">*El campo edad es requerido</span>
                                    <!--P4P3Alert2. El campo edad debe ser un numero valido-->
                                    <span class="label label-danger" ng-show="DatosForm.edad.$error.number">*El campo edad debe ser un numero valido</span>
                                    <!--P4P3Alert3. El campo edad debe ser mayor a 15-->
                                    <span class="label label-danger" ng-show="DatosForm.edad.$error.min">*El campo edad debe ser mayor a 15</span>
                                    <!--P4P3Alert4. El campo edad debe ser menor a 150-->
                                    <span class="label label-danger" ng-show="DatosForm.edad.$error.max">*El campo edad debe ser menor a 150</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <!--P4P4. Sexo-->
                            <label class="col-xs-12 control-label">Sexo</label>

                            <div class="col-xs-12">
                                
                                <div class="radio radio-primary" style="display: inline-block;">
                                    <label>
                                        <!--P4P4Radio1. Hombre-->
                                        <input type="radio" name="sexo" ng-model="encuesta.Sexo" value="true" ng-required="true">
                                        Hombre
                                    </label>
                                </div>
                                <div class="radio radio-primary" style="display: inline-block;">
                                    <label>
                                        <!--P4P4Radio2. Mujer-->
                                        <input type="radio" name="sexo" ng-model="encuesta.Sexo" value="false" ng-required="true">
                                        Mujer
                                    </label>
                                </div>

                                <span ng-show="DatosForm.$submitted || DatosForm.sexo.$touched">
                                    <!--P4P4Alert1. El campo sexo es requerido-->
                                    <span class="label label-danger" ng-show="DatosForm.sexo.$error.required">*El campo sexo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <!--P4P5. Celular-->
                            <label for="inputCelular" class="col-xs-12 control-label">Celular</label>

                            <div class="col-xs-12">
                                <!--P4P5Input1. Ingrese su teléfono celular-->
                                <input type="text" class="form-control" id="inputCelular" name="celular" pattern="^\+?\d{1,3}?[- .]?\(?(?:\d{2,3})\)?[- .]?\d\d\d[- .]?\d\d\d\d$" placeholder="Ingrese su teléfono celular" ng-model="encuesta.Celular" />
                                <span ng-show="DatosForm.$submitted || DatosForm.celular.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.celular.$error.pattern">*El celular no tiene un formato válido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="form-group">
                            <!--P4P6. Teléfono-->
                            <label for="inputTelefono" class="col-xs-12 control-label">Teléfono</label>

                            <div class="col-xs-12">
                                <!--P4P6Input1. Opcional-->
                                <input type="text" class="form-control" id="inputTelefono" name="telefono" pattern="([0-9])+|[+]([0-9])+" placeholder="Opcional" ng-model="encuesta.Telefono" />
                                <span ng-show="DatosForm.$submitted || DatosForm.telefono.$touched">
                                    <!--P4P5Alert1. El campo telefono no es valido-->
                                    <span class="label label-danger" ng-show="DatosForm.telefono.$error.pattern">*El campo telefono no es valido</span>

                                </span>

                            </div>
                        </div>
                    </div>
                    <div ng-class="{true:'col-xs-12 col-sm-12 col-md-3',false:'col-xs-12 col-sm-12 col-md-6'}[encuesta.Nacimiento == 3]">
                        <div class="form-group">
                            <!--P4P7. ¿En dónde nació?-->
                            <label for="inputDondeNacio" class="col-xs-12 control-label">¿En dónde nació?</label>

                            <div class="col-xs-12">
                                <!--P4P7Select1. Seleccione el lugar de nacimiento-->
                                <select class="form-control" id="inputDondeNacio" name="nacimiento" ng-model="encuesta.Nacimiento" ng-required="true">
                                    <option value="" disabled>Seleccione el lugar de nacimiento</option>
                                    <option ng-repeat="item in lugares" value="{{item.id}}">{{item.opciones_lugares_con_idiomas[0].nombre}}</option>
                                </select>
                                <!--P4P7Alert1. El campo en donde nació es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.nacimiento.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.nacimiento.$error.required">*El campo es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3" ng-if="encuesta.Nacimiento == 3">
                        <div class="form-group">
                            <!--P4P8. País de Nacimiento-->
                            <label for="inputPaisNacimiento" class="col-xs-12 control-label">País de Nacimiento</label>

                            <div class="col-xs-12">
                                <!--P4P8Select1. Seleccione el país de nacimiento-->
                                <select class="form-control" id="inputPaisNacimiento" ng-model="encuesta.Pais_Nacimiento" name="pais_nacimiento" ng-required="encuesta.Nacimiento == 3">
                                    <option value="" disabled>Seleccione el país de nacimiento</option>
                                    <option ng-repeat="item in paises" value="{{item.id}}">{{item.paises_con_idiomas[0].nombre}}</option>
                                </select>
                                <!--P4P8Alert1. El campo pais de nacimiento es requerido-->
                                <span class="label label-danger" ng-show="!DatosForm.$pristine && DatosForm.pais_nacimiento.$error.required">*El campo pais de nacimiento es requerido</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <!--P4P9. País de Residencia-->
                            <label for="inputPaisResidencia" class="col-xs-12 control-label">País de Residencia</label>

                            <div class="col-xs-12">
                                <!--P4P9Select1. País de Residencia-->
                                <select class="form-control" ng-model="pais_residencia" id="inputPaisResidencia" name="pais_residencia" ng-change="changedepartamento()" ng-required="true">
                                    <option value="" disabled>País de Residencia</option>
                                    <option ng-repeat="item in paises" value="{{item.id}}">{{item.paises_con_idiomas[0].nombre}}</option>
                                </select>
                                <!--P4P9Alert1. País de Residencia-->
                                <span ng-show="DatosForm.$submitted || DatosForm.pais_residencia.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.pais_residencia.$error.required">*El campo pais de residencia es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <!--P4P10. Departamento de Residencia-->
                            <label for="inputDepartamentoResidencia" class="col-xs-12 control-label">Departamento de Residencia</label>

                            <div class="col-xs-12">
                                <!--P4P10Select1. Seleccione un Departamento-->
                                <select class="form-control" id="inputDepartamentoResidencia" name="departamento" ng-model="departamento" ng-change="changemunicipio()" ng-required="true">
                                    <option value="" disabled>Seleccione un Departamento</option>
                                    <option ng-repeat="item in departamentos" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                <!--P4P10Alert1. El campo Departamento de residencia es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.departamento.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.departamento.$error.required">*El campo Departamento de residencia es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <!--P4P11. Ciudad de Residencia-->
                            <label for="inputCiudadResidencia" class="col-xs-12 control-label">Ciudad de Residencia</label>
                            <!--P4P11. Seleccione un Municipio-->
                            <div class="col-xs-12">
                                <select class="form-control" id="inputCiudadResidencia" name="ciudad" ng-model="encuesta.Municipio" ng-required="true">
                                    <option value="" disabled>Seleccione un Municipio</option>
                                    <option ng-repeat="item in municipios" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                <!--P4P11. El campo Ciudad de residencia es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.ciudad.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.ciudad.$error.required">*El campo Ciudad de residencia es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="panel panel-success" ng-if="pais_residencia != 47">
            <div class="panel-heading p1">
                <!-- P5. ¿Cual fue su destino principal en colombia?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cual fue su destino principal en colombia?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <!-- P5P1. Departamento-->
                            <label for="inputDepartamentoDestino" class="col-xs-12 control-label">Departamento</label>

                            <div class="col-xs-12">
                                <!-- P5P1Select1. Seleccione un Departamento-->
                                <select class="form-control" id="inputDepartamentoDestino" name="departamento_p" ng-model="departamentod.id" ng-change="changemunicipiocolombia()" ng-required="pais_residencia != 47">
                                    <option value="" disabled>Seleccione un Departamento</option>
                                    <option ng-repeat="item in departamentos_colombia" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                {{departamento_p}}
                                <!-- P5P1Alert1. El campo departamento del destino principal es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.departamento_p.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.departamento_p.$error.required">*El campo departamento del destino principal es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <!-- P5P2. Municipio-->
                            <label for="inputMunicipioDestino" class="col-xs-12 control-label">Municipio</label>

                            <div class="col-xs-12">
                                <!-- P5P2Select1. Seleccione un Municipio-->
                                <select class="form-control" name="destino" ng-model="encuesta.Destino" ng-required="pais_residencia != 47">
                                    <option value="" disabled>Seleccione un Municipio</option>
                                    <option ng-repeat="item in municipios_colombia" value="{{item.id}}">{{item.nombre}}</option>
                                </select>
                                <!-- P5P2Alert1. El campo municipio del destino principal es requerido-->
                                <span ng-show="DatosForm.$submitted || DatosForm.destino.$touched">
                                    <span class="label label-danger" ng-show="DatosForm.destino.$error.required">*El campo municipio del destino principal es requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P6. ¿Cuál fué el motivo principal para venir al departamento del Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál fué el motivo principal para venir al departamento del Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in motivos">
                            <label>
                                <input type="radio" ng-change="cambiomotivo()" name="motivo" ng-model="encuesta.Motivo" value="{{item.id}}" ng-required="true">{{item.motivos_viaje_con_idiomas[0].nombre}} <input type="text" class="form-control" name="otro" ng-model="encuesta.Otro" ng-change="otro()" ng-if="item.id == 18" />
                            </label>
                        </div>
                        <!-- P6Alert1. El campo motivo principal es requerido-->
                        <span ng-show="DatosForm.$submitted || DatosForm.motivo.$touched">
                            <span class="label label-danger" ng-show="DatosForm.motivo.$error.required">*El campo motivo principal es requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="encuesta.Motivo == 5">
            <div class="panel-heading">
                <!-- P6P1. ¿La finalidad del servicio medico es?-->
                <h3 class="panel-title"><b> ¿La finalidad del servicio medico es?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in medicos">
                            <label>
                                <input type="radio" name="medico" ng-model="encuesta.Salud" value="{{item.id}}" ng-required="encuesta.Motivo == 5">{{item.tipos_atencion_salud_con_idiomas[0].nombre}}
                            </label>
                        </div>
                        <!-- P6P1Alert1. El campo finalidad del servicio medico es obligatorio-->
                        <span ng-show="DatosForm.$submitted || DatosForm.medico.$touched">
                            <span class="label label-danger" ng-show="DatosForm.medico.$error.required">* El campo finalidad del servicio medico es obligatorio</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="encuesta.Motivo == 3">
            <div class="panel-heading">
                <!-- P6P2. ¿Cuantas hora duro/durara la parada mas larga en el Magdalena?-->
                <h3 class="panel-title"><b>¿Cuantas hora duro/durara la parada mas larga en el Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente información</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input name="horas" type="number" ng-model="encuesta.Horas" class="form-control" ng-required="encuesta.Motivo == 3" placeholder="Soló números" />
                        <span ng-show="DatosForm.$submitted || DatosForm.horas.$touched">
                            <!-- P6P2Alert1. La duración de la parada es requerida cuando el motivo es transito-->
                            <span class="label label-danger" ng-show="DatosForm.horas.$error.required">*La duración de la parada es requerida cuando el motivo es transito</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P7. ¿Quien va a diligenciar la encuesta?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Quien va a diligenciar la encuesta?</b></h3>
            </div>
            <div class="panel-footer"><b>Presione aquí para desplegar las opciones</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="actor" ng-model="encuesta.Actor" ng-required="true">
                            <!--P7Op1. Selecciona una persona-->
                            <option value="" disabled>Selecciona una persona</option>
                            <!--P7Op2. Visitante-->
                            <option value="true">Visitante</option>
                            <!--P7Op3. Encuestador-->
                            <option value="false">Encuestador</option>
                        </select>
                        <span ng-show="DatosForm.$submitted || DatosForm.actor.$touched">
                            <!--P7Alert1. Encuestador-->
                            <span class="label label-danger" ng-show="DatosForm.actor.$error.required">*El campo diligenciar encuesta es requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="encuesta.Actor=='true'">
            <div class="panel-heading">
                <!-- P7. ¿Quien va a diligenciar la encuesta?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿En que idioma se va a diligenciar la encuesta?</b></h3>
            </div>
            <div class="panel-footer"><b>Presione aquí para desplegar las opciones</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="idioma" ng-model="encuesta.Idioma" ng-required="encuesta.Actor">
                            <!--P7Op1. Selecciona una opción-->
                            <option value="" disabled>Seleccione una opcion</option>
                            <!--P7Op2. Español-->
                            <option value="false">Español</option>
                            <!--P7Op3. Inglés-->
                            <option value="true">Inglés</option>

                        </select>
                        <span ng-show="DatosForm.$submitted || DatosForm.idioma.$touched">
                            <!--P7Alert1. Encuestador-->
                            <span class="label label-danger" ng-show="DatosForm.actor.idioma.required">*El campo es requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout._encuestaLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>