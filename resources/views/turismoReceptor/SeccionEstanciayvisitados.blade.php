@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
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
@endsection

@section('TitleSection', 'Estancia y visitados')

@section('Progreso', '16.66%')

@section('NumSeccion', '16%')

@section('controller','ng-controller="estancia"')

@section('content')
    <div class="main-page">

    <form role="form" name="EstanciaForm" novalidate>
        <input type="hidden" ng-model="id" ng-init="id={{$id}}" />

        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>@Resource.EncuestaMsgError:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.length>0">
                -@{{error[0]}}
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
                                        <select ng-model="es.Municipio" name="municipio@{{$index}}" style="width:100%" ng-change="cambioselectmunicipio(es)" class="form-control" ng-options="municipio.id as municipio.nombre for municipio in Datos.Municipios " ng-required="true">
                                            <!--EncuestaEstanciaP1Col1Select1. Selecione un municipio-->
                                            <option value="" disabled>Selecione un municipio</option>
                                        </select>
                                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.municipio@{{$index}}.$touched">
                                            <!--P1Col1Alert1. Debe seleccionar un municipio-->
                                            <span class="label label-danger" ng-show="EstanciaForm.municipio@{{$index}}.$error.required">Debe seleccionar un municipio</span>
                                        </span> 
                                    </th>
                                    <th>

                                        <input class="form-control" name="noche@{{$index}}" ng-change="cambionoches(es)" min= "0" type="number" ng-model="es.Noches" placeholder="1" ng-required ="true"/><br />
                                        <span class="messages" ng-show="EstanciaForm.$submitted || EstanciaForm.noche@{{$index}}.$touched">
                                            <!--EncuestaEstanciaP1Col2Select1Alert1. El campo es obligatorio-->
                                            <span class="label label-danger"  ng-show="EstanciaForm.noche@{{$index}}.$error.required">*El campo es obligatorio</span>
                                            <!--EncuestaEstanciaP1Col2Select1Alert2. No es un número válido-->
                                            <span class="label label-danger"  ng-show="EstanciaForm.noche@{{$index}}.$error.number">*No es un número válido</span>
                                            <!--EncuestaEstanciaP1Col2Alert3. El número de noches debe ser mínimo 0 -->
                                            <span class="label label-danger" ng-show="EstanciaForm.noche@{{$index}}.$error.min">*El número de noches debe ser mínimo 0</span>
                                        </span>
                                    </th>
                                    <th>

                                        <select ng-model="es.Alojamiento" name="alojamiento@{{$index}}" style="width:100%"  ng-change="cambioselectalojamiento(es)" class="form-control" ng-options="alojamiento.id as alojamiento.tipos_alojamiento_con_idiomas[0].nombre for alojamiento in Datos.Alojamientos " ng-required="true">
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
                                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.alojamiento@{{$index}}.$touched">
                                            <!--EncuestaEstanciaP1Col3Select1Alert1. Debe seleccionar un tipo de alojamiento-->
                                            <span class="label label-danger" ng-show="EstanciaForm.alojamiento@{{$index}}.$error.required">Debe seleccionar un tipo de alojamiento</span>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que actividades realizó en el Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="activ in Datos.Actividadesrelizadas" >
                            <label>
                                <input type="checkbox" checklist-model="encuesta.ActividadesRelizadas" name= "actividadesr"  checklist-value="activ"  ng-click="cambioActividadesRealizadas(activ)" > @{{activ.actividades_realizadas_con_idiomas[0].nombre}}
                            </label>
                            <span ng-if="activ.id == 19">:<input type="text" name="otroActividad" style="display: inline-block;" class="form-control" id="otroActividad" placeholder="Escriba su otra opción" ng-model="activ.otroActividad" ng-change="validarOtroActividad(activ)" ng-required="validarRequeridoOtroActividad()"/></span>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.actividadesr.$touched || encuesta.ActividadesRelizadas.length > 0">
                            <!--EncuestaEstanciaP2Alert1. Debe seleccionar alguno de los valores-->
                            <span class="label label-danger" ng-show="encuesta.ActividadesRelizadas.length == 0">* Debe seleccionar alguno de los valores</span>
                            <span class="label label-danger" ng-show="EstanciaForm.otroActividad.$error.required">* Debe escribir el otro.</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        
        <div class="panel panel-success" ng-repeat="opcion in encuesta.ActividadesRelizadas" ng-if="opcion.opciones.length > 0" >
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cúales? (@{{opcion.actividades_realizadas_con_idiomas[0].nombre}})</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="item in opcion.opciones">
                            <label>
                                <input type="checkbox" name ="opcion_@{{opcion.id}}" id="opcion_@{{opcion.id}}" checklist-model="opcion.Respuestas" checklist-value="item.id" > @{{item.opciones_actividades_realizadas_idiomas[0].nombre}}
                            </label>
                            <span ng-if="item.id==22 || item.id==26 || item.id==34">:<input type="text" name="opcionOtro_@{{opcion.id}}" style="display: inline-block;" class="form-control" id="opcionOtro_@{{opcion.id}}" placeholder="Escriba su otra opción" ng-model="opcion.otro" ng-change="validarOtro(item.id,opcion)" ng-required="(item.id==22 || item.id==26 || item.id==34) && validarContenido(item.id,opcion)"/></span>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.opcion_@{{opcion.id}}.$touched || opcion.Respuestas.length > 0">
                            <span class="label label-danger" ng-show="opcion.Respuestas.length == 0 || opcion.Respuestas == undefined">* Debe seleccionar alguna opción</span>
                            <span class="label label-danger" ng-show="EstanciaForm.opcionOtro_@{{opcion.id}}.$error.required">* Debe escribir el otro.</span>
                        </span>

                    </div>
                </div>

            </div>
        </div>
        
        


        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/editardatos/@{{id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar()">
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>

</div>

@endsection

