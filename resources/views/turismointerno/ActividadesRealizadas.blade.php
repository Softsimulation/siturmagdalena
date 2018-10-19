
@extends('layout._encuestaInternoLayout')

@section('Title','Duración de la estancia y lugares visitados - Encuesta interno y emisor :: SITUR Magdalena')


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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Que actividades realizó en el Magdalena?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="activ in Datos.Actividadesrelizadas" >
                            <label>
                                <input type="checkbox" checklist-model="encuesta.ActividadesRelizadas" name= "actividadesr"  checklist-value="activ"  ng-click="cambioActividadesRealizadas(activ)" > @{{activ.actividades_realizadas_con_idiomas[0].nombre}}
                                 <input type="text" style="display: inline-block;" class="form-control" name ="opcionp@{{$index}}" id="opcionp@{{activ.id}}" ng-if="activ.actividades_realizadas_con_idiomas[0].nombre == 'Otro'" ng-model="Actividad(activ.id).otro" ng-disabled="!existeActividad(activ.id)" ng-required="existeActividad(activ.id)" >
                                 <span ng-show="EstanciaForm.$submitted || EstanciaForm.opcionp@{{activ.id}}.$touched">
                                      <span class="label label-danger" ng-show="EstanciaForm.opcionp@{{activ.id}}.$error.required">* Debe escribir otro</span>
                              
                                  </span>
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

        
        <div ng-repeat = "opcion in encuesta.ActividadesRelizadas">
            <div class="panel panel-success" ng-if="opcion.opciones_actividades_realizadas_internos.length > 0">
            <div class="panel-heading">
                <!-- P4. ¿Qué parques naturales, Cascadas, ríos, pozos, balnearios, zoológicos y jardines botánicos visitó?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿ Qué @{{opcion.actividades_realizadas_con_idiomas[0].nombre}}? </b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="opcion2 in opcion.opciones_actividades_realizadas_internos">
                            <label>
                                <input type="checkbox" name="opcion2" checklist-model="encuesta.OpcionesActividades" checklist-value="opcion2"> @{{opcion2.nombre}}
                                 <input type="text" ng-if="opcion2.nombre == 'Otro'" style="display: inline-block;" class="form-control" name ="opcion@{{opcion2.id}}" id="opcion@{{opcion2.id}}" ng-disabled="!existeOpcion(opcion2.id)" ng-model="Opcion(opcion2.id).otro"  ng-required="existeOpcion(opcion2.id)"/>
                                  <span ng-show="EstanciaForm.$submitted || EstanciaForm.opcion@{{opcion2.id}}.$touched">
                                      <span class="label label-danger" ng-show="EstanciaForm.opcion@{{opcion2.id}}.$error.required">* Debe escribir otro</span>
                              
                                  </span>
                                  
                            </label>
                        </div>
                        <span ng-show="EstanciaForm.$submitted || EstanciaForm.opcion2.$touched">
                            <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                            <span class="label label-danger" ng-show="requeridoOpciones(opcion.opciones_actividades_realizadas_internos)">* Debe seleccionar @{{opcion.actividades_realizadas_con_idiomas[0].nombre}}</span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
        <div ng-repeat = "opcion3 in opcion.opciones_actividades_realizadas_internos">
                    <div class="panel panel-success" ng-if="buscarSub(opcion3)">
                    <div class="panel-heading">
                        <!-- P4. ¿Qué parques naturales, Cascadas, ríos, pozos, balnearios, zoológicos y jardines botánicos visitó?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>¿ Qué @{{opcion3.nombre}}? </b></h3>
                    </div>
                    <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox" ng-repeat="opcion4 in opcion3.sub_opciones_actividades_realizadas_internos">
                                    <label>
                                        <input type="checkbox" name="opcion4" checklist-model="encuesta.SubOpcionesActividades" checklist-value="opcion4.id"> @{{opcion2.nombre}}
                                         
                                   
                                    </label>
                                </div>
                                <span ng-show="EstanciaForm.$submitted || EstanciaForm.opcion4.$touched">
                                    <!--EncuestaEstanciaP4Alert1. Debe seleccionar alguna visita a parques, cascadas, ríos-->
                                    <span class="label label-danger" ng-show="requeridoSubOpciones(opcion3.sub_opciones_actividades_realizadas_internos)">* Debe seleccionar @{{opcion3.nombre}}</span>
                                </span>
                            </div>
                        </div>
            
                    </div>
                </div>
        </div>
        
        
        </div>
        
      
   


        <div class="row" style="text-align:center">
            <a href="/turismointerno/viajeprincipal/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar()">
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>

</div>

@endsection
