@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Oferta de agencia de viaje :: SITUR Magdalena')

@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
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

@section('TitleSection', 'Oferta de agencia de viaje')

@section('Progreso', '50%')

@section('NumSeccion', '50%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="ofertaAgenciaViajesCtrl"')

@section('content') 

<div class="container">
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores">
            -@{{error[0]}}
        </div>

    </div>
    <input type="hidden" ng-model="encuesta.id" ng-init="encuesta.id={{$id}}" />
    <form role="form" name="DatosForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Personas que viajaron según destino</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th></th>
                                <th class="text-center">Número total de personas</th>
                                <th class="text-center">¿Qué porcentaje fue comprado por residentes en el Magdalena? (%)</th>
                                <th class="text-center">¿Qué porcentaje fue comprado por residentes en Colombia fuera del Magdalena? (%)</th>
                            </tr> 
                            <tr ng-repeat="i in destinos">

                                <td class="text-center">@{{i.nombre}}
                                <input type="hidden" ng-model="encuesta.personas[$index].opciones_personas_destino_id" ng-init="encuesta.personas[$index].opciones_personas_destino_id=i.id" />
                                </td>
                                <td>   
                                    <input type="number" class="form-control" min="0" name="numerototal@{{$index}}" ng-model="encuesta.personas[$index].numerototal" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>                                    
                                    <input type="number" class="form-control" min="0" max="100" name="nacional@{{$index}}" ng-model="encuesta.personas[$index].nacional" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>                                    
                                    <input type="number" class="form-control" min="0" max="100" name="internacional@{{$index}}" ng-model="encuesta.personas[$index].internacional" ng-required="true" placeholder="Solo números"/>
                                </td>

                            </tr>                          
                        </table>
                    </div>
                    <div ng-repeat="i in destinos">
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.numerototal@{{$index}}.$touched">                                                                                           
                                <span class="label label-danger" ng-show="DatosForm.numerototal@{{$index}}.$error.required">*El numero total de personas de la fila @{{$index+1}} es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.numerototal@{{$index}}.$error.number">*El numero total de personas de la fila @{{$index+1}} debe ser un número</span>
                                <span class="label label-danger" ng-show="DatosForm.numerototal@{{$index}}.$error.min">*El numero total de personas de la fila @{{$index+1}} debe ser mayor que 0</span>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.nacional@{{$index}}.$touched">
                                <span class="label label-danger" ng-show="DatosForm.nacional@{{$index}}.$error.required">*El porcentaje comprado por los residentes en el magdalena en la fila @{{$index+1}} es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional@{{$index}}.$error.number">*El porcentaje comprado por los residentes en el magdalena en la fila @{{$index+1}} debe ser un número</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional@{{$index}}.$error.max">*El porcentaje comprado por los residentes en el magdalena en la fila @{{$index+1}} debe ser menor o igual que 100</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional@{{$index}}.$error.min">*El porcentaje comprado por los residentes en el magdalena en la fila @{{$index+1}} debe ser mayor que 0</span>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.internacional@{{$index}}.$touched">
                                <span class="label label-danger" ng-show="DatosForm.internacional@{{$index}}.$error.required">*El porcentaje comprado por los residentes fuera del magdalena en la fila @{{$index+1}} es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional@{{$index}}.$error.number">*El porcentaje comprado por los residentes fuera del magdalena en la fila @{{$index+1}} debe ser un número</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional@{{$index}}.$error.max">*El porcentaje comprado por los residentes fuera del magdalena en la fila @{{$index+1}} debe ser menor o igual que 100</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional@{{$index}}.$error.min">*El porcentaje comprado por los residentes fuera del magdalena en la fila @{{$index+1}} debe ser mayor que 0</span>
                            </span>
                        </div>
                   </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Personas que viajaron con planes, cuyo destino fue Santa Marta</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th></th>
                                <th class="text-center">Número total de personas</th>
                                <th class="text-center">¿Qué porcentaje fue comprado por residentes en el Magdalena? (%)</th>
                                <th class="text-center">¿Qué porcentaje fue comprado por residentes en Colombia fuera del Magdalena? (%)</th>
                                <th class="text-center">¿Qué porcentaje fue comprado por residentes en el extranjero? (%)</th>
                            </tr>
                            <tr>
                                <td class="text-center">¿Cuántas personas viajaron con planes con destino Santa / Magdalena?</td>
                                <td>
                                    <input type="number"  name="numero" ng-model="encuesta.numero" min="0" class="form-control" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number"  name="magdalena"  ng-model="encuesta.magdalena" min="0" max="100" class="form-control" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number"  name="nacional" ng-model="encuesta.nacional" min="0" max="100" class="form-control" ng-required="true" placeholder="Solo números"/>
                                </td>
                                <td>
                                    <input type="number"  name="internacional" ng-model="encuesta.internacional" min="0" max="100" class="form-control" ng-required="true" placeholder="Solo números"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>

                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.numero.$touched">
                                <span class="label label-danger" ng-show="DatosForm.numero.$error.required">*El número total de personas es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.numero.$error.number">*El número total de personas debe ser un número</span>      
                                <span class="label label-danger" ng-show="DatosForm.numero.$error.min">*El número total de personas debe ser mayor que 0</span>                                
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.magdalena.$touched">
                                <span class="label label-danger" ng-show="DatosForm.magdalena.$error.required">*El porcentaje comprado por residentes en el magdalena es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.magdalena.$error.number">*El porcentaje comprado por residentes en el magdalena debe ser un número</span> 
                                <span class="label label-danger" ng-show="DatosForm.magdalena.$error.max">*El porcentaje comprado por residentes en el magdalena debe ser menor o igual que 100</span>
                                <span class="label label-danger" ng-show="DatosForm.magdalena.$error.min">*El porcentaje comprado por residentes en el magdalena debe ser mayor que 1</span>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.nacional.$touched">
                                <span class="label label-danger" ng-show="DatosForm.nacional.$error.required">*El porcentaje comprado por residentes fuera del magdalena es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional.$error.number">*El porcentaje comprado por residentes fuera del magdalena debe ser un número</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional.$error.max">*El porcentaje comprado por residentes fuera del magdalena debe ser menor o igual que 100</span>
                                <span class="label label-danger" ng-show="DatosForm.nacional.$error.min">*El porcentaje comprado por residentes fuera del magdalena debe ser mayor que 1</span>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <span ng-show="DatosForm.$submitted || DatosForm.internacional.$touched">
                                <span class="label label-danger" ng-show="DatosForm.internacional.$error.required">*El porcentaje comprado por residentes en el extranjero es obligatorio</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional.$error.number">*El porcentaje comprado por residentes en el extranjero debe ser un número</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional.$error.max">*El porcentaje comprado por residentes en el extranjero debe ser menor o igual que 100</span>
                                <span class="label label-danger" ng-show="DatosForm.internacional.$error.max">*El porcentaje comprado por residentes en el extranjero debe ser mayor que 1</span>
                            </span>
                        </div>


                    </div>
                </div>
            </div>
        </div>
       

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/agenciaviajes/{{$id}}" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>
        <br />

    </form>
    <div class='carga'>

    </div>
</div>
@endsection
