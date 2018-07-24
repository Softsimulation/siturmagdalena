
@extends('layout._ofertaEmpleoLayaout')

@section('Title','Caracterización de empleados :: SITUR Magdalena')


@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
        }

        .table > thead > tr > th {
            background-color: rgba(0,0,0,.1);
        }

        .jp-options {
            position: absolute;
            background-color: white;
            z-index: 2;
            width: 95%;
            max-height: 300px;
            overflow-y: auto;
            -webkit-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            color: dimgray;
        }

        .jp-options > div {
            border-bottom: 0.5px solid rgba(0,0,0,.1);
            padding-left: 2%;
        }

        .jp-options > div label {
            cursor: pointer;
        }

        .st-list-tag {
            list-style: none;
            margin: 0;
            padding: 0;
            white-space:0;
        }

        .st-list-tag li {
            display: inline-block;
            margin-bottom: 0.5em;
            min-width: 8.3%;
            margin-right: 1em;
            border-radius: 20px;
            padding: 1em;
            padding-top: .5em;
            padding-bottom: .5em;
            background-color: dodgerblue;
            color: white;
            text-align: center;
            font-weight: 400;
            cursor: pointer;
        }

        .thead-fixed {
            position: fixed;
            z-index: 10;
            width: 100%;
            top: 0;
            background-color: lightgray;
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

        .alert-fixed {
            z-index: 60;
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
@section('TitleSection','Caracterización de empleados')
@section('Progreso','90%')
@section('NumSeccion','90%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="empleoCaracterizacion"')

@section('content')

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="empleoForm" novalidate>

        <div class="capEmpleo">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Necesidades de capacitación: ¿Hubo cargos que requerían capacitación?</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="opt1" ng-model="empleo.capacitacion" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="opt1" ng-model="empleo.capacitacion" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.opt1.$touched">
                                <span class="label label-danger" ng-show="empleoForm.opt1.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

             <div class="panel panel-success" ng-show="empleo.capacitacion == 1">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Tematicas desarrolladas</b></h3>
                            </div>
                            <div class="panel-footer"><b>. Por favor indique en que temáticas ha capacitado la empresa y si fue realizada o no por la entidad</b></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="overflow-x: auto;">
                                            <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                                <thead id="head-tgastos">
                                                    <tr>
                                                        <th class="text-center">Nombre de la tematica</th>
                                                        <th class="text-center">Realiza por la empresa</th>
                                                       <th>
                                                        <!--EncuestaEstanciaBtnAgregarDest. Agregar destino-->
                                                        <button type="button" class="btn btn-success" ng-click="agregar()" title="Agregar tematica"><i class="material-icons">add</i></button>
                                                      
                                                    </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="tematica in empleo.tematicas">
                                                        <td>
                                                                          
                                                        <input type="text" name="temaCapacitacion@{{$index}}" ng-minlength="1" ng-maxlength="250" class="form-control" ng-model="tematica.nombre" placeholder="Ingrese los temas que realizó capacitación a sus empleados" ng-required="empleo.capacitacion ==1"/>
      
                                                        <span ng-show="empleoForm.$submitted || empleoForm.temaCapacitacion@{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="empleoForm.temaCapacitacion@{{$index}}.$error.required">* El campo es requerido.</span>
                                                        </span>
                                                        </td>
                                                        <td>
                                                            
                                                            <div class="radio radio-primary">
                                                                <label>
                                                                    <input type="radio" id="SiCapacitacion@{{$index}}" value="1" name="opt1@{{$index}}" ng-model="tematica.realizada_empresa" ng-required="true">
                                                                    Si
                                                                </label>
                                                            </div>
                                                            <div class="radio radio-primary">
                                                                <label>
                                                                    <input type="radio" id="NoCapacitacion@{{$index}}" value="0" name="opt1@{{$index}}" ng-model="tematica.realizada_empresa" ng-required="true">
                                                                    No
                                                                </label>
                                                            </div>
                                                            <span ng-show="empleoForm.$submitted || empleoForm.opt1@{{$index}}.$touched">
                                                                <span class="label label-danger" ng-show="empleoForm.opt1@{{$index}}.$error.required">* El campo es requerido.</span>
                                                            </span>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <!--EncuestaEstanciaBtnEliminarDest. Eliminar destino-->
                                                                <button type="button" class="btn btn-danger" ng-click="quitar(tematica)" title="Eliminar tematica"><i class="material-icons">close</i></button>
                                                        </td>
                                                    </tr>
                                                    
                                            
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
        
        <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>.Por favor indique del siguiente listado las necesidades de capacitación más relevantes para sus trabajadores (nivel administrativo y nivel operativo) a fin de mejorar la gestión actual de su establecimiento </b></h3>
            </div>
            <div class="panel-footer"><b>(puede escoger mínimo una o máximo tres opciones) </b></div>
            <div class="panel-body">
                <div class="row">
                    <h4 class="title" >Nivel 1. Gestión Gerencial o Administrativo</h4>
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="linea in data.lineas | filter:{tipo_nivel:true}">
                            <label>
                                <input type="checkbox" name="linea" checklist-model="empleo.lineasadmin" checklist-value="linea.id"> @{{linea.nombre}}
                                 
                                  
                            </label>
                        </div>
                        <span ng-show="empleoForm.$submitted || empleoForm.linea.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="empleo.lineasadmin.length < 1  ">* Debe seleccionar por lo menos un linea</span>
                             <span class="label label-danger" ng-show="empleo.lineasadmin.length > 3  ">* Debe seleccionar maximo 3</span>
                        </span>
                    </div>
                </div>
                  <div class="row">
                    <h4 class="title">Nivel 2. Gestión Operativa</h4>
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="linea in data.lineas | filter:{tipo_nivel:false}">
                            <label>
                                <input type="checkbox" name="lineaop" checklist-model="empleo.lineasopvt" checklist-value="linea.id"> @{{linea.nombre}}
                                 
                                  
                            </label>
                        </div>
                        <span ng-show="empleoForm.$submitted || empleoForm.lineaop.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="empleo.lineasopvt.length < 1  ">* Debe seleccionar por lo menos un linea</span>
                             <span class="label label-danger" ng-show="empleo.lineasopvt.length > 3  ">* Debe seleccionar maximo 3</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        
        </div>
        
        
        <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>. La capacitación que requieren los trabajadores de su establecimiento podría desarrollarse por medio de ¿qué tipo de programa de formación? </b></h3>
            </div>
            <div class="panel-footer"><b>(puede escoger mínimo una o máximo tres opciones) </b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="medio in data.medios">
                            <label>
                                <input type="checkbox" name="medio" checklist-model="empleo.medios" checklist-value="medio.id"> @{{medio.nombre}}
                                 <input type="text" ng-if="medio.id == 6" style="display: inline-block;" class="form-control" name ="opcion@{{medio.id}}" id="opcion@{{medio.id}}" ng-disabled="!existeOpcion(medio.id)" ng-model="empleo.otromedio"  ng-required="existeOpcion(medio.id)"/>
                                  <span ng-show="empleoForm.$submitted || empleoForm.opcion@{{medio.id}}.$touched">
                                      <span class="label label-danger" ng-show="empleoForm.opcion@{{medio.id}}.$error.required">* Debe escribir otro</span>
                              
                                  </span>
                                  
                            </label>
                        </div>
                        <span ng-show="empleoForm.$submitted || empleoForm.medio.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="empleo.medios.length < 1  ">* Debe seleccionar por lo menos un medio</span>
                             <span class="label label-danger" ng-show="empleo.medios.length > 3  ">* Debe seleccionar maximo 3</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        
        </div>
        

        <div>
        <div class="panel panel-success">
            <div class="panel-heading">
               
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Con quién contrataría los servicios para la capacitación de su talento humano?</b></h3>
            </div>
            <div class="panel-footer"><b>(puede escoger mínimo una o máximo tres opciones) </b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="tipo in data.tipos">
                            <label>
                                <input type="checkbox" name="tipo" checklist-model="empleo.tipos" checklist-value="tipo.id"> @{{tipo.nombre}}
                                 <input type="text" ng-if="tipo.id == 10" style="display: inline-block;" class="form-control" name ="opcion@{{tipo.id}}" id="opcion@{{tipo.id}}" ng-disabled="!existeTipo(tipo.id)" ng-model="empleo.otrotipo"  ng-required="existeTipo(tipo.id)"/>
                                  <span ng-show="empleoForm.$submitted || empleoForm.opcion@{{tipo.id}}.$touched">
                                      <span class="label label-danger" ng-show="empleoForm.opcion@{{tipo.id}}.$error.required">* Debe escribir otro</span>
                              
                                  </span>
                                  
                            </label>
                        </div>
                        <span ng-show="empleoForm.$submitted || empleoForm.tipo.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="empleo.tipos.length < 1  ">* Debe seleccionar por lo menos un tipo</span>
                             <span class="label label-danger" ng-show="empleo.tipos.length > 3  ">* Debe seleccionar maximo 3</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
       </div>   
       
       
       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>.Dando cumplimiento a la ley de Protección de datos Personales le solicito su autorización para que SITUR Magdalena pueda contactarlo nuevamente en caso de ser necesario ¿Está usted de acuerdo? </b></h3>
            </div>
            <div class="panel-footer"><b>si o no </b></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="autorizacion" ng-model="empleo.autorizacion" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="autorizacion" ng-model="empleo.autorizacion" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.autorizacion.$touched">
                                <span class="label label-danger" ng-show="empleoForm.autorizacion.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>

       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>D8 Ya para terminar, le solicito su autorización para que SITUR Magdalena comparta sus respuestas con las entidades que contrataron el proyecto si o no </b></h3>
            </div>
            <div class="panel-footer"><b>si o no </b></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="SiCapacitacion" value="1" name="esta_acuerdo" ng-model="empleo.esta_acuerdo" ng-required="true">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="NoCapacitacion" value="0" name="esta_acuerdo" ng-model="empleo.esta_acuerdo" ng-required="true">
                                    No
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.esta_acuerdo.$touched">
                                <span class="label label-danger" ng-show="empleoForm.esta_acuerdo.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>
        

       <div>
            <div class="panel panel-success">
            <div class="panel-heading">
         
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Por cual medio le gustaría actualizar la información </b></h3>
            </div>
            <div class="panel-footer"></div>
            <div class="panel-body">
                <div class="row">
                <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label ng-repeat ="medio in data.actualizaciones ">
                                    <input type="radio" id="SiCapacitacion" value="@{{medio.id}}" name="medios_actualizacion_id" ng-model="empleo.medios_actualizacion_id" ng-required="true">
                                    @{{medio.nombre}}
                                </label>
                            </div>
                            <span ng-show="empleoForm.$submitted || empleoForm.medios_actualizacion_id.$touched">
                                <span class="label label-danger" ng-show="empleoForm.medios_actualizacion_id.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                </div>

            </div>
        </div>
        </div>



        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/empleomensual/{{$id}}" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
@endsection


