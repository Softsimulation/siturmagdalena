
@extends('layout._encuestaInternoLayout')

@section('Title','Viajes realizados - Encuesta interno y emisor :: SITUR Madgalena')


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
@section('TitleSection','Viajes realizados')
@section('Progreso','20%')
@section('NumSeccion','20%')
@section('Control','ng-controller="viajes"')

@section('contenido')


<div class="main-page" ng-controller="viajes">
    <div class='carga'>

    </div>
    
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />

        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>{{trans('resources.EncuestaMsgError')}}:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -@{{error[0]}}
            </div>

        </div>

    <div class="alert alert-danger" ng-if="error != nul">
        <label><b>{{trans('Encuesta MsgError')}}:</b></label>
        <br />
        <div>
            @{{error}}
        </div>

    </div>
        <br />

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P1. Duración de la estancia-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Duración de la estancia</b></h3>
            </div>


            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">

                <input type="submit" class="btn btn-raised btn-success"  ng-disabled="ver" value="Agregar" ng-click="ver = true; clearForm()">

                <div class="row">
                    <div class="col-md-12" style="overflow-x: auto;" ng-show="Viajes.length > 0">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Viajes
                                    </th>
                                    <th>
                                        Fecha Inicial
                                    </th>
                                    <th>
                                        Fecha final
                                    </th>
                                    <th>
                                        Principal

                                    </th>
                                    <th style="width: 120px">

                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr ng-repeat="es in Viajes">
                                    <th>
                                        viaje @{{$index+1}}
                                    </th>
                                    <th>
                                        @{{es.fecha_inicio}}

                                    </th>
                                    <th>
                                        @{{es.fecha_final}}

                                    </th>

                                    <th style="text-align: center;">
                                        <div class="radio radio-primary" style="display: inline-block;margin-top: 0; margin-bottom: 0;">
                                            <label>
                                                <input type="radio" name="principal_viaje" ng-model="PrincipalViaje.id" ng-value="es.id" ng-click="c(es.id)">
                                            </label>
                                        </div>
                                    </th>

                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm " style="margin: 0;padding: 5px 10px;" data-placement="bottom" ng-click="editar(es)" title="Editar"><i class="material-icons">mode_edit</i> </button>
                                        <button type="button" class="btn btn-danger btn-sm" style="margin: 0;padding: 5px 10px;" ng-click="eliminar(es)"  ng-disabled="ver" title="Eliminar"><i class="material-icons">close</i> </button>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12" ng-show="Viajes.length == 0">
                        <div class="alert alert-info no-fixed">
                            <strong>No se han agregado viajes</strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
   
   <div ng-show="ver">
       <form role="form" name="EstanciaForm" novalidate>
           <div class="panel panel-success">
               <div class="panel-heading p1">
                   <!-- P3. Fecha de viaje-->
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Fecha del viaje principal</b></h3>
               </div>
               <div class="panel-footer"><b>Fecha de viaje</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-xs-12 col-sm-6 col-md-6">
                           <div class="form-group">
                               <!--P3P1. Fecha de Llegada-->
                               <label for="fechaLlegada" class="col-xs-12 control-label">fecha de inicio del viaje</label>

                               <div class="col-xs-12">
                                   <input type="date" class="form-control" id="fechaLlegada" name="llegada" ng-model="encuesta.Inicio" max="@DateTime.Now.ToString("yyyy-MM-dd")" placeholder="YYYY-MM-DD" ng-required="true" />
                                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.llegada.$touched">
                                       <!--P3P1Alert1. El campo fecha de llegada es requerido-->
                                       <span class="label label-danger" ng-show="EstanciaForm.llegada.$error.required">*El campo fecha de llegada es requerido</span>
                                       <span class="label label-danger" ng-show="EstanciaForm.llegada.$error.date">*Error en formato de fecha</span>
                                       <span class="label label-danger" ng-show="EstanciaForm.llegada.$error.max">*Supera la fecha maxima</span>
                                   </span>
                               </div>
                           </div>
                       </div>
                       <div class="col-xs-12 col-sm-6 col-md-6">
                           <div class="form-group">
                               <!--P3P2. Fecha de Salida-->
                               <label for="fechaSalida" class="col-xs-12 control-label">fecha fin del viaje</label>

                               <div class="col-xs-12">
                                   <input type="date" id="fechaSalida" name="salida" class="form-control" min="@{{encuesta.Inicio}}" ng-model="encuesta.Fin" placeholder="YYYY-MM-DD" ng-required="true" />
                                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.salida.$touched">
                                       <!--P3P2Alert1. El campo fecha de salida es requerido-->
                                       <span class="label label-danger" ng-show="EstanciaForm.salida.$error.required">*El campo fecha de salida es requerido</span>
                                       <span class="label label-danger" ng-show="EstanciaForm.salida.$error.date">*Error en formato de fecha</span>
                                       <span class="label label-danger" ng-show="EstanciaForm.salida.$error.min">debe ser mayor que la fecha de inicio</span>
                                   </span>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

            <div class="panel panel-success">
               <div class="panel-heading">
                   <!-- P1. Duración de la estancia-->
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Duración de la estancia</b></h3>
               </div>

               <div class="panel-footer"><b>Complete la tabla</b></div>
               <div class="panel-body">


                   <div class="row">
                       <div class="col-md-12" style="overflow-x:auto;">
                           <table class="table table-striped">
                               <thead>
                                   <tr>
                                       <th style="width: 16.6%">
                                           País
                                       </th>
                                       <th style="width: 16.6%">
                                           Departamento
                                       </th>
                                       <th style="width: 16.6%">
                                           Ciudad/Municipio
                                       </th>
                                       <th style="width: 8%">
                                           Número de noches

                                       </th>
                                       <th style="width: 22%">
                                           Tipo de Alojamiento utilizados
                                           <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                              data-original-title="">
                                           </i>
                                       </th>

                                       <th style="width: 10%">
                                           Destino Principal
                                       </th>
                                       <th>
                                           <!--EncuestaEstanciaBtnAgregarDest. Agregar destino-->
                                           <button type="button" class="btn btn-sm btn-success" style="margin: 0;padding: 5px 10px;" ng-click="agregar()" title="Agregar destino"><i class="material-icons">add</i></button>
                                           <i  class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title=""
                                              style="text-align:right;">
                                           </i>
                                       </th>

                                   </tr>
                               </thead>
                               <tbody>

                                   <tr ng-repeat="es in encuesta.Estancias">

                                       <th>
                                           <select ng-model="es.Pais" name="pais@{{$index}}" style="width:100%" class="form-control" ng-change="cambioselectpais(es)" ng-options="pais.id as pais.nombre for pais in Datos.Paises|orderBy: 'nombre' " ng-required="true">
                                               <!--EncuestaEstanciaP1Col1Select1. Selecione un municipio-->
                                               <option value="" disabled>Seleccione un país</option>
                                           </select>
                                           <span ng-show="EstanciaForm.$submitted || EstanciaForm.pais@{{$index}}.$touched">
                                               <!--P1Col1Alert1. Debe seleccionar un municipio-->
                                               <span class="label label-danger" ng-show="EstanciaForm.pais@{{$index}}.$error.required">Campo obligatorio</span>
                                           </span>
                                       </th>

                                       <th>

                                           <select ng-model="es.Departamento" name="departamento@{{$index}}" style="width:100%" class="form-control" ng-change="cambioselectdepartamento(es)" ng-options="departamento.id as departamento.nombre  for departamento in Datos.Depertamentos | filter: {idP : es.Pais }:true" ng-required="true">
                                               <!--EncuestaEstanciaP1Col1Select1. Selecione un municipio-->
                                               <option value="" disabled>Seleccione un departamento</option>
                                           </select>
                                           <span ng-show="EstanciaForm.$submitted || EstanciaForm.departamento@{{$index}}.$touched">
                                               <!--P1Col1Alert1. Debe seleccionar un municipio-->
                                               <span class="label label-danger" ng-show="EstanciaForm.departamento@{{$index}}.$error.required">Campo obligatorio</span>
                                           </span>
                                       </th>

                                       <th>

                                           <select ng-model="es.Municipio" name="municipio@{{$index}}" style="width:100%" ng-change="cambioselectmunicipio(es)" class="form-control" ng-options="municipio.id as municipio.nombre for municipio in Datos.Municipios | filter :{idD : es.Departamento}:true" ng-required="true">
                                               <!--EncuestaEstanciaP1Col1Select1. Selecione un municipio-->
                                               <option value="" disabled>Selecione un municipio</option>
                                           </select>
                                           <span ng-show="EstanciaForm.$submitted || EstanciaForm.municipio@{{$index}}.$touched">
                                               <!--P1Col1Alert1. Debe seleccionar un municipio-->
                                               <span class="label label-danger" ng-show="EstanciaForm.municipio@{{$index}}.$error.required">Campo obligatorio</span>
                                           </span>
                                       </th>

                                       <th>

                                           <input class="form-control" style="margin-bottom: -13px;" name="noche@{{$index}}" ng-change="cambionoches(es)" min="0" type="number" ng-model="es.Noches" placeholder="1" ng-required="true" /><br />
                                           <span class="messages" ng-show="EstanciaForm.$submitted || EstanciaForm.noche@{{$index}}.$touched">
                                               <!--EncuestaEstanciaP1Col2Select1Alert1. El campo es obligatorio-->
                                               <span class="label label-danger" ng-show="EstanciaForm.noche@{{$index}}.$error.required">Campo obligatorio</span>
                                               <!--EncuestaEstanciaP1Col2Select1Alert2. No es un número válido-->
                                               <span class="label label-danger" ng-show="EstanciaForm.noche@{{$index}}.$error.number">Solo números</span>
                                               <!--EncuestaEstanciaP1Col2Alert3. El número de noches debe ser mínimo 0 -->
                                               <span class="label label-danger" ng-show="EstanciaForm.noche@{{$index}}.$error.min">Números mayores a 0</span>
                                           </span>
                                       </th>
                                       <th>

                                           <select ng-model="es.Alojamiento" name="alojamiento@{{$index}}" style="width:100%" ng-change="cambioselectalojamiento(es)" class="form-control" ng-options="alojamiento.id as alojamiento.nombre for alojamiento in Datos.Alojamientos " ng-required="true">
                                               <!--EncuestaEstanciaP1Col3Select1. Selecione tipo de alojamiento-->
                                               <option value="" disabled>Seleccione alojamiento</option>
                                           </select>
                                           <i ng-if="es.Alojamiento==2" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <i ng-if="es.Alojamiento==3" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <i ng-if="es.Alojamiento==4" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <i ng-if="es.Alojamiento==5" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <i ng-if="es.Alojamiento==6" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <i ng-if="es.Alojamiento==10" class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="left" title="ayuda"
                                              style="text-align:right;">
                                           </i>
                                           <span ng-show="EstanciaForm.$submitted || EstanciaForm.alojamiento@{{$index}}.$touched">
                                               <!--EncuestaEstanciaP1Col3Select1Alert1. Debe seleccionar un tipo de alojamiento-->
                                               <span class="label label-danger" ng-show="EstanciaForm.alojamiento@{{$index}}.$error.required">Campo obligatorio</span>
                                           </span>

                                       </th>

                                       <th style="text-align: center;">
                                           <div class="radio radio-primary" style="display: inline-block;margin-top: 0; margin-bottom: 0;">
                                               <label>
                                                   <input type="radio" ng-model="encuesta.Principal" ng-value="es.Municipio">

                                               </label>
                                           </div>
                                       </th>

                                       <th style="text-align: center;">
                                           <!--EncuestaEstanciaBtnEliminarDest. Eliminar destino-->
                                           <button type="button" class="btn btn-sm btn-danger" style="margin: 0;padding: 5px 10px;" ng-click="quitar(es)" title="Eliminar destino"><i class="material-icons">close</i></button>
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

                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál fue el motivo principal del primer viaje?</b></h3>
               </div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <select ng-model="encuesta.Motivo" name="motivo" style="width:100%" class="form-control" ng-options="motivo.id as motivo.nombre for motivo in Datos.Motivos " ng-required="true">
                               <!--EncuestaEstanciaP1Col3Select1. Selecione tipo de alojamiento-->
                               <option value="" disabled>Seleccione un motivo</option>
                           </select>
                           <span ng-show="EstanciaForm.$submitted || EstanciaForm.motivo.$touched">
                               <!--EncuestaEstanciaP1Col3Select1Alert1. Debe seleccionar un tipo de alojamiento-->
                               <span class="label label-danger" ng-show="EstanciaForm.alojamiento.$error.required">Debe seleccionar un tipo de alojamiento</span>
                           </span>
                       </div>
                   </div>

               </div>

           </div>


           <div class="panel panel-success">
               <div class="panel-heading">

                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Con que frecuencia realiza este viaje?</b></h3>
               </div>
               <div class="panel-footer"><b>Seleccion Unica</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <div class="radio" ng-repeat="item in Datos.Frecuencias" ng-if="item.id != 10">
                               <label>
                                   <input type="radio" name="frecuencia" ng-value="item.id" ng-model="encuesta.Frecuencia" ng-required="true"> @{{item.frecuencia}}
                               </label>

                           </div>
                       </div>
                   </div>
                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.frecuencia.$touched">
                       <span class="label label-danger" ng-show="EstanciaForm.frecuencia.$error.required">El campo es requerido.</span>
                   </span>
               </div>
           </div>


           <div class="panel panel-success">
               <div class="panel-heading">
                   <!-- -->
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Cuántas personas incluyéndose usted, realizaron juntos el viaje desde la salida hasta el regreso al lugar de residencia?</b></h3>
               </div>
               <div class="panel-footer"><b>Campo Numero</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <input type="number" name="numero" class="form-control" min="1" ng-model="encuesta.Numero" ng-change="verifica()" ng-required="true" placeholder="Solo números"/>
                       </div>
                   </div>
                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.numero.$touched">
                       <span class="label label-danger" ng-show="EstanciaForm.numero.$error.required">El campo es requerido.</span>
                       <span class="label label-danger" ng-show="EstanciaForm.numero.$error.number">Debe introducir solo números.</span>
                       <span class="label label-danger" ng-show="!EstanciaForm.numero.$valid">Solo números iguales o mayores que 1.</span>
                   </span>
               </div>
           </div>

           <div class="panel panel-success">
               <div class="panel-heading">
                
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Quiénes eran esas personas?</b></h3>
               </div>
               <div class="panel-footer"><b>Seleccion Multiple</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <div class="checkbox" ng-repeat="item in Datos.Acompaniantes">
                               <label>
                                   <input type="checkbox" name="personas" checklist-model="encuesta.Personas" checklist-value="item.id" ng-disabled="(encuesta.Numero == 1 && item.id != 1) || (encuesta.Numero > 1 && item.id == 1) || encuesta.Numero == null || encuesta.Numero < 1" /> @{{item.nombre}}
                               </label>

                           </div>
                       </div>
                   </div>
                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.personas.$touched">
                       <span class="label label-danger" ng-show="EstanciaForm.Personas.length == 0">Debe seleccionar al menos una opción</span>

                   </span>
               </div>
               
           </div>




           <div class="panel panel-success" ng-if="existe(2)">
               <div class="panel-heading">
                   <!-- -->
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Cuántas personas del hogar? </b></h3>
               </div>
               <div class="panel-footer"><b>Campo Numero</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <input type="number" name="numerohogar" class="form-control" min="1" max="@{{TotalD}}" ng-model="encuesta.Numerohogar" ng-change="verificaT()" ng-required="true" placeholder="Ingrese el No. de personas del hogar"/>
                       </div>
                   </div>
                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.numerohogar.$touched">
                       <span class="label label-danger" ng-show="EstanciaForm.numerohogar.$error.required">El campo es requerido.</span>
                       <span class="label label-danger" ng-show="EstanciaForm.numerohogar.$error.number">Debe introducir solo números</span>
                       <span class="label label-danger" ng-show="!EstanciaForm.numerohogar.$valid">Número menor o igual @{{TotalD}}</span>
                   </span>
               </div>
           </div>


           <div class="panel panel-success" ng-if="existe(4)">
               <div class="panel-heading">
                   <!-- -->
                   <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿Cuántos eran otros turistas?  </b></h3>
               </div>
               <div class="panel-footer"><b>Campo Numero</b></div>
               <div class="panel-body">
                   <div class="row">
                       <div class="col-md-12">
                           <input type="number" name="numerotros" class="form-control" min="1" max="@{{TotalF}}" ng-model="encuesta.Numerotros" ng-change="verificaT()" ng-required="true" placeholder="Ingrese el Número de turístas"/>
                       </div>
                   </div>
                   <span ng-show="EstanciaForm.$submitted || EstanciaForm.numerotros.$touched">
                       <span class="label label-danger" ng-show="EstanciaForm.numerotros.$error.required">El campo es requerido.</span>
                       <span class="label label-danger" ng-show="EstanciaForm.numerotros.$error.number">Debe introducir solo números</span>
                       <span class="label label-danger" ng-show="!EstanciaForm.numerotros.$valid">Número menor o igual @{{TotalF}}</span>
                   </span>
               </div>
           </div>


           <div class="row" style="text-align:center">
               <input type="submit" class="btn btn-default" value="Cancelar" ng-click="cancelar()">
               <input type="submit" class="btn btn-raised btn-success" value="Guardar" ng-click="guardar()">
           </div>

       </form>
    </div>
    <div class="row">
        <div class="col-xs-12" style="text-align: center; border-top: .5px solid lightgrey">
            <a href="/turismointerno/editarhogar/{{$hogar}}" class="btn btn-raised btn-default" placeholder="Anterior">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguente" ng-click="siguiente()" ng-disabled="ver" placeholder="Siguiente">
        </div>
    </div>
    <br />
</div>
@endsection