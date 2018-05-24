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

@section('TitleSection', 'Como se enteran los visitantes sobre el departamento del Atlántico')

@section('Progreso', '100%')

@section('NumSeccion', '100%')

@section('controller','ng-controller="enteran-crear"')

@section('content')
<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        
        <h4><b>Errores:</b></h4>
        
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form role="form" name="inForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿ Antes de venir al departamento del Magdalena, de qué forma usted se enteró de los destinos turísticos visitados?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Antes de venir al departamento del Atlántico, de qué forma usted se enteró de los destinos turísticos visitados?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesAntes">
                            <label>
                                <input type="checkbox" name="fuentesAntes" checklist-model="enteran.FuentesAntes"  checklist-value="it.id" ng-change="validar(2, it.id)" > @{{it.fuente_informacion_antes_viaje_con_idiomas[0].nombre}}
                            </label>
                            <span ng-if="it.id==14">:<input type="text" name="otroFantes" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-model="enteran.OtroFuenteAntes" ng-change="validarOtro(0)" ng-required="enteran.FuentesAntes.indexOf(14) !== -1"/></span>
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
                <!-- ¿Durante la permanencia en el Magdalena, de qué forma usted buscó más información sobre destinos turísticos?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Durante la permanencia en el Atlántico, de qué forma usted buscó más información sobre destinos turísticos?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesDurante">
                            <label>
                                <input type="checkbox" name="fuentesDurante" checklist-model="enteran.FuentesDurante" ng-disabled="(enteran.FuentesDurante.indexOf(13) > -1 && it.id!=13)" ng-change="validar(0, it.id)" checklist-value="it.id"> @{{it.fuentes_informacion_durante_viaje_con_idiomas[0].nombre}}
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
                <!-- ¿Después del viaje al Magdalena en qué redes sociales compartió su experiencia de viaje (Comentarios, fotos, etc)?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Después del viaje al Atlántico en qué redes sociales compartió su experiencia de viaje (Comentarios, fotos, etc)?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in redes" style="margin-bottom: .5em;">
                            <label>
                                <input type="checkbox" name="redes" checklist-model="enteran.Redes" ng-disabled="enteran.Redes.indexOf(1) > -1 && it.Id != 1" ng-change="validar(1, it.Id)" checklist-value="it.Id"> @{{it.Nombre}}
                            </label>
                            <span ng-if="it.Id==12">:<input type="text" name="otroRed" style="display: inline-block;" class="form-control" id="otroRed" placeholder="Escriba su otra opción" ng-disabled="enteran.Redes.indexOf(1) != -1 " ng-model="enteran.otroRed" ng-change="validarOtro(2)" ng-required="enteran.Redes.indexOf(12) != -1" /></span>
                        </div>
                        
                    </div>
                </div>
                <span ng-show="inForm.$submitted || inForm.redes.$touched">
                    <span class="label label-danger" ng-show="enteran.Redes.length == 0">* Debe seleccionar alguno de los valores.</span>
                    <span class="label label-danger" ng-show="inForm.otroRed.$error.required">* Debe escribir quien fue el otro acompañante.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Le gustaría que le enviáramos información sobre el Magdalena a su correo electrónico?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Le gustaría que le enviáramos información sobre el Atlántico a su correo electrónico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio"  id="alojamientoSi" value="1" ng-model="enteran.Correo" >
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio"  id="alojamientoNo" value="-1" ng-model="enteran.Correo"  >
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="!enteran.Correo">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿Le gustaría que le enviáramos una invitación por redes sociales para seguir al Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Le gustaría que le enviáramos una invitación por redes sociales para seguir al Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlSi" value="1" ng-model="enteran.Invitacion">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlNo" value="-1" ng-model="enteran.Invitacion">
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en facebook?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> ¿Cómo podemos buscarlo en facebook?</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="Escriba su cuenta de Facebook" ng-model="enteran.NombreFacebook"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en Twitter?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> ¿Cómo podemos buscarlo en Twitter?</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="Escriba su cuenta de Twitter" ng-model="enteran.NombreTwitter" />
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Sostenibilidad ¿Fue fácil encontrar los servicios, productos y atractivos de Atlántico?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="facilidad" id="facilidad" required value="1" ng-model="enteran.facilidad">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="facilidad" id="facilidad" required value="-1" ng-model="enteran.facilidad">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.facilidad.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Conoce la marca que acaba de ver?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="conoce_marca" id="conoce_marca" required value="1" ng-model="enteran.conoce_marca">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="conoce_marca" id="conoce_marca" required value="-1" ng-model="enteran.conoce_marca">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.conoce_marca.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Dando cumplimiento a la ley de Protección de datos personales, solicito su autorización para que pueda contactarlo nuevamente. ¿Está usted de acuerdo?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="acepta_autorizacion" id="acepta_autorizacion" required value="1" ng-model="enteran.acepta_autorizacion">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="acepta_autorizacion" id="acepta_autorizacion" required value="-1" ng-model="enteran.acepta_autorizacion">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.acepta_autorizacion.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Ya para terminar, le solicito su autorización para que SITUR ATLÁNTICO comparta sus respuestas con las entidades que contrataron el proyecto, ¿Está usted de acuerdo?</b></h3>
            </div>
            <div class="panel-footer"><b>Respuesta única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="acepta_tratamiento" id="acepta_tratamiento" required value="1" ng-model="enteran.acepta_tratamiento">
                                Si
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" name="acepta_tratamiento" id="acepta_tratamiento" required value="-1" ng-model="enteran.acepta_tratamiento">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <span ng-show="inForm.$submitted">
                    <span class="label label-danger" ng-show="inForm.acepta_tratamiento.$error.required">* Debe seleccionar alguna de las opciones.</span>
                </span>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/seccionpercepcionviaje/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="Siguiente" ng-click="guardar() ">
        </div>
        <br />
    </form>
    <div class='carga'>

    </div>
</div>

@endsection

