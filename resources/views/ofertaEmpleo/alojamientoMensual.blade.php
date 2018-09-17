@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta de oferta y empleo')
@section('establecimeinto', 'establecimeinto')
@section('app','ng-app="appEncuestaAlojamiento"')
@section('controller','ng-controller="AlojamientoMensualCtrl"')

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
        .checkbox .form-group {
            display: inline-block;
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

@section('content')

<div class="main-page">
    
    <input type="hidden" id="id" value="{{$id}}" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    
    <form name="AlojamientoForm" novalidate>
        
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Selecciones las modalidades de alojamiento que ofrece su establecimiento</b></h3>
            </div>
            <div class="panel-footer"><b>Seleccione una opción</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-offset-1 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em" >
                            <label>
                                <input type="checkbox"  ng-model="servicios.habitacion" ng-true-value="true" ng-false-value="false"  > Habitaciones
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.apartamento" ng-true-value="true" ng-false-value="false" > Apartamentos
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.casa" ng-true-value="true" ng-false-value="false"  > Casas
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.cabana" ng-true-value="true" ng-false-value="false" > Cabañas
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <div class="checkbox" style="display: inline-block; margin-right: 1em">
                            <label>
                                <input type="checkbox"  ng-model="servicios.camping" ng-true-value="true" ng-false-value="false" > Camping
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <span ng-show="ErrorServicio && !servicios.habitacion && !servicios.apartamento && !servicios.casa && !servicios.cabana && !servicios.camping">
                            <span class="label label-danger" >* Selecione por lo menos un servicio.</span>
                        </span>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="panel panel-success" ng-if="servicios.habitacion">
            <div class="panel-heading">

                <h3 class="panel-title">
                    <b><span class="asterik glyphicon glyphicon-asterisk"></span>Habitaciones (@{{alojamiento.habitaciones[0].total}} en total) </b>
                    <span style="float: right;" ng-if="mideOcupacion==1" >Tasa de ocupación: @{{ ((alojamiento.habitaciones[0].habitaciones_ocupadas / (alojamiento.habitaciones[0].total*numero_dias))*100) | number:2 }} % </span>
                    <span style="float: right;" ng-if="mideOcupacion==0" >Tasa de ocupación: @{{ ((alojamiento.habitaciones[0].habitaciones_ocupadas / (alojamiento.habitaciones[0].total_camas*numero_dias))*100) | number:2 }} % </span>
                </h3>
            </div>
            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                  <th> </th>
                                  <th>Mes</th>
                              </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td > 
                                        ¿En que mide su porcentaje de ocupación?  
                                        <div style="display: inline-flex;align-items: baseline;" >
                                            <div class="radio radio-inline radio-primary">
                                                <label>
                                                    <input type="radio" value="1" name="mideOcupacion" ng-model="mideOcupacion" ng-required="servicios.habitacion"> Habitaciones
                                                </label>
                                            </div>
                                            <div class="radio radio-inline radio-primary">
                                                <label>
                                                    <input type="radio" value="0" name="mideOcupacion" ng-model="mideOcupacion" ng-required="servicios.habitacion"> Camas
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr ng-if="mideOcupacion==0" >
                                    <td>
                                        Número total de camas que posee el establecimiento
                                        <span ng-show="carForm.$submitted || carForm.numeroCamas.$touched">
                                            <span class="label label-danger" ng-show="carForm.numeroCamas.$error.required">* El número total de camas es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCamas.$error.number">* El número total de camas debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCamas.$error.min">* El número total de camas debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="numeroCamas" class="form-control" min="0" ng-model="alojamiento.habitaciones[0].total_camas" ng-required="servicios.habitacion" placeholder="Ingrese aquí el número total de camas" />
                                    </td>
                                </tr>
                                <tr ng-if="mideOcupacion==1" >
                                    <td>
                                        Total habitaciones (Por favor no incluir habitaciones para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.totalH.$touched">
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.required">* El número total de habitaciones es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.number">* El número total de habitaciones debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.totalH.$error.min">* El número total de habitaciones debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="totalH" class="form-control" min="0" ng-model="alojamiento.habitaciones[0].total" ng-required="servicios.habitacion" placeholder="Ingrese aquí el número total de habitaciones" />
                                </td>

                                <tr>
                                    <td>Tarifa de habitación doble estándar incluido impuestos ($) en el mes
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionTarifa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="HabitacionTarifa" id="HabitacionTarifa" class="form-control" ng-model="alojamiento.habitaciones[0].tarifa" min="1000"  type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                <td>¿Cuántas habitaciones se ocuparon durante el mes? (Es la suma de habitaciones vendidas cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionOcupa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.min">*El campo debe ser mayor que 1</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.max">*Este campo no puede ser mayor al número total de habitaciones por el número de días de actividad comercial.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="HabitacionOcupa" id="HabitacionOcupa" class="form-control" ng-model="alojamiento.habitaciones[0].habitaciones_ocupadas" min="1" max="@{{(alojamiento.habitaciones[0].total_camas||alojamiento.habitaciones[0].total)*numero_dias}}" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.apartamento">
            <div class="panel-heading">

                <h3 class="panel-title">
                    <b><span class="asterik glyphicon glyphicon-asterisk"></span>Apartamentos (@{{alojamiento.apartamentos[0].total}} en total)</b>
                    <span style="float: right;" >Tasa de ocupación</span>
                </h3>
            </div>
            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Mes</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        Tarifa del apartamento incluido impuestos ($) en el mes
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosTarifa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="ApartamentosTarifa" id="ApartamentosTarifa" class="form-control" ng-model="alojamiento.apartamentos[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿cuántas apartamentos se ocuparon durante el mes?  (Es la suma de apartamentos vendidos cada noche del mes) Si usted vendió el mismo apartamento por 15 días, entonces, el apartamento fue ocupado 15 veces.
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosCamas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.max">*Este campo no puede ser mayor al número total de apartamentos por el número de días de actividad comercial.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosCamas" id="ApartamentosCamas" class="form-control" ng-model="alojamiento.apartamentos[0].capacidad_ocupada" min="1" max="@{{alojamiento.apartamentos[0].total*numero_dias}}" ng-required="true" placeholder="Solo números"/></td>
                                
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.casa">
            <div class="panel-heading">

                <h3 class="panel-title">
                    <b><span class="asterik glyphicon glyphicon-asterisk"></span>Casas (@{{alojamiento.casas[0].total}} en total)</b>
                    <span style="float: right;" >Tasa de ocupación</span>
                </h3>
            </div>
            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Mes</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Tarifa de la casa incluido impuestos ($) en el mes
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaTarifa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTarifa.$error.min">*El campo debe ser mayor que $1000.</span>
                                        </span>
                                    </td>
                                    <td><input name="CasaTarifa" id="CasaTarifa" class="form-control" ng-model="alojamiento.casas[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuántas casas se ocuparon durante el mes? (Es la suma de casas vendidas cada noche del mes) Si usted vendió la misma casa por 15 días, entonces, la casa fue ocupada 15 veces.
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaCapacidad.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCapacidad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCapacidad.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCapacidad.$error.max">*Este campo no puede ser mayor al número total de casas por el número de días de actividad comercial.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaCapacidad" id="CasaCapacidad" class="form-control" ng-model="alojamiento.casas[0].capacidad_ocupadas" min="1" max="@{{alojamiento.casas[0].total*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
                                 
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.cabana">
            <div class="panel-heading">

                <h3 class="panel-title">
                    <b><span class="asterik glyphicon glyphicon-asterisk"></span>Cabañas(@{{alojamiento.cabanas[0].total}} en total)</b>
                    <span style="float: right;" >Tasa de ocupación</span>
                </h3>
            </div>
            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Mes</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        Tarifa de la cabaña incluido impuestos ($) en el mes
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabTarifa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="CabTarifa" id="CabTarifa" class="form-control" ng-model="alojamiento.cabanas[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuántas cabañas se ocuparon durante el mes? (Es la suma de cabañas vendidas cada noche del mes) Si usted vendió la misma cabaña por 15 días, entonces, la cabaña fue ocupada 15 veces.
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabaniaCapacidad.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabaniaCapacidad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabaniaCapacidad.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabaniaCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabaniaCapacidad.$error.max">*Este campo no puede ser mayor al número total de cabañas por el número de días de actividad comercial.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CabaniaCapacidad" id="CabaniaCapacidad" class="form-control" ng-model="alojamiento.cabanas[0].capacidad_ocupada" min="1" max="@{{alojamiento.cabanas[0].total*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
                                
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.camping"> 
            <div class="panel-heading">

                <h3 class="panel-title">
                    <b><span class="asterik glyphicon glyphicon-asterisk"></span>Camping (@{{alojamiento.campings[0].area}} en total)</b>
                    <span style="float: right;" >Tasa de ocupación</span>
                </h3>
            </div>
            <div class="panel-footer"><b>Complete la tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th>Mes</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        Tarifa del camping incluido impuestos ($) en el mes
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CamTarifa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTarifa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTarifa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTarifa.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input name="CamTarifa" id="CamTarifa" class="form-control" ng-model="alojamiento.campings[0].tarifa" min="1000" type="number" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuántas parcelas (N° de espacios para carpas-casas rodantes) se ocuparon durante el mes? (Es la suma de espacios vendidos cada noche del mes) Si usted vendió solo un espacio por 15 días, 
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CampingCapacidad.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CampingCapacidad.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CampingCapacidad.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CampingCapacidad.$error.min">*El campo debe ser mayor que 1.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CampingCapacidad.$error.max">*Este campo no puede ser mayor al número total de parcelas por el número de días de actividad comercial.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CampingCapacidad" id="CampingCapacidad" class="form-control" ng-model="alojamiento.campings[0].capacidad_ocupada" min="1" max="@{{alojamiento.campings[0].area*numero_dias}}" ng-required="true" placeholder="Solo números" /></td>
                                    
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/caracterizacion/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
    </form>
    <div class='carga'>

    </div>
</div>

<div class='carga'></div>

@endsection


@section('javascript')
    <script src="{{asset('/js/encuestas/ofertaempleo/alojamiento.js')}}"></script>
    <script src="{{asset('/js/encuestas/ofertaempleo/servicios.js')}}"></script>
@endsection