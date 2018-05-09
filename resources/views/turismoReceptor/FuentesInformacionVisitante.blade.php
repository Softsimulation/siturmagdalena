@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
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
@endsection

@section('TitleSection', 'Como se enteran los visitantes sobre el departamento del Magdalena')

@section('Progreso', '100%')

@section('NumSeccion', '100%')

@section('controller','ng-controller="enteran-crear"')

@section('content')
<div class="container">
    <input type="hidden" ng-model="id" ng-init="" />
    <div class="alert alert-danger" ng-if="errores != null">
        
        <h4><b>@Resource.EncuestaMsgError:</b></h4>
        
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error.errores[0].ErrorMessage}}
        </div>
    </div>
    <form role="form" name="inForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- ¿ Antes de venir al departamento del Magdalena, de qué forma usted se enteró de los destinos turísticos visitados?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaFuenteInfoP1</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesAntes">
                            <label>
                                <input type="checkbox" name="fuentesAntes" checklist-model="enteran.FuentesAntes"  checklist-value="it.Id" ng-change="validar(2, it.Id)" > @{{it.Nombre}}
                            </label>
                            <span ng-if="it.Id==14">:<input type="text" name="otroFantes" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-model="enteran.OtroFuenteAntes" ng-change="validarOtro(0)" ng-required="enteran.FuentesAntes.indexOf(14) !== -1"/></span>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaFuenteInfoP2</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in fuentesDurante">
                            <label>
                                <input type="checkbox" name="fuentesDurante" checklist-model="enteran.FuentesDurante" ng-disabled="(enteran.FuentesDurante.indexOf(13) > -1 && it.Id!=13)" ng-change="validar(0, it.Id)" checklist-value="it.Id"> @{{it.Nombre}}
                            </label>
                            <span ng-if="it.Id==14">:<input type="text" name="otroDurante" style="display: inline-block;" class="form-control" id="inputOtro_atrativo" placeholder="Escriba su otra opción" ng-disabled="enteran.FuentesDurante.indexOf(13) > -1 " ng-model="enteran.OtroFuenteDurante" ng-change="validarOtro(1)" ng-required="enteran.FuentesDurante.indexOf(14) != -1" /></span>
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaFuenteInfoP3</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="it in redes" style="margin-bottom: .5em;">
                            <label>
                                <input type="checkbox" name="redes" checklist-model="enteran.Redes" ng-disabled="enteran.Redes.indexOf(1) > -1 && it.Id != 1" ng-change="validar(1, it.Id)" checklist-value="it.Id"> @{{it.Nombre}}
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaFuenteInfoP4</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio"  id="alojamientoSi" value="1" ng-model="enteran.Correo" >
                                @Resource.EncuestaReSi
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio"  id="alojamientoNo" value="-1" ng-model="enteran.Correo"  >
                                @Resource.EncuestaReNo
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
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaFuenteInfoP5</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlSi" value="1" ng-model="enteran.Invitacion">
                                @Resource.EncuestaReSi
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" id="controlNo" value="-1" ng-model="enteran.Invitacion">
                                @Resource.EncuestaReNo
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en facebook?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> @Resource.EncuestaFuenteInfoP6</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="@Resource.EncuestaFuenteInfoP6Input1" ng-model="enteran.NombreFacebook"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success" ng-if="enteran.Invitacion==1">
            <div class="panel-heading">
                <!-- ¿Cómo podemos buscarlo en Twitter?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> <span class=""></span> @Resource.EncuestaFuenteInfoP7</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" style="display: inline-block;" class="form-control" id="inputFacebook" placeholder="@Resource.EncuestaFuenteInfoP7Input1" ng-model="enteran.NombreTwitter" />
                    </div>
                </div>
            </div>
        </div>
        

        <div class="row" style="text-align:center">
            <a href="/EncuestaReceptor/PercepcionViaje/@ViewBag.id" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" value="@Resource.EncuestaBtnSiguiente" ng-click="guardar() ">
        </div>
        <br />
    </form>
    <div class='carga'>

    </div>
</div>

@endsection

