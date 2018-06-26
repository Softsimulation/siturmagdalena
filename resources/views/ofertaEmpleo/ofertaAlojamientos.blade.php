@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta de oferta y empleo')
@section('establecimeinto', 'establecimeinto')
@section('app','ng-app="appEncuestaAlojamiento"')
@section('controller','ng-controller="OfertaAlojamientoCtrl"')


@section('content')

<div class="main-page">
    
    <input type="hidden" id="id" value="{{$id}}" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error.errores[0].ErrorMessage}}
        </div>
    </div>
    
    <form name="AlojamientoForm" novalidate>

        <div class="panel panel-success" ng-if="servicios.habitacion">
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Habitaciones</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
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
                                    <td>¿Cuántas personas realizaron Check in o ingresaron durante el mes?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionPersonas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionPersonas.$error.min">*El campo debe ser mayor que $1,000.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="HabitacionPersonas" id="HabitacionPersonas" class="form-control" ng-model="alojamiento.habitaciones[0].numero_personas" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Magdalena? (De otros departamentos de Colombia)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionCol.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionCol.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionCol.$error.number">*El campo debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="HabitacionCol" name="HabitacionCol" class="form-control" ng-model="alojamiento.habitaciones[0].viajeros_locales" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior son extranjeros?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionExtra.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionExtra.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionExtra.$error.number">*El campo debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="HabitacionExtra" name="HabitacionExtra" class="form-control" ng-model="alojamiento.habitaciones[0].viajeros_extranjeros"  ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántas habitaciones se ocuparon durante el mes? (Es la suma de habitaciones vendidas cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionOcupa.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionOcupa.$error.min">*El campo debe ser mayor que 1</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="HabitacionOcupa" id="HabitacionOcupa" class="form-control" ng-model="alojamiento.habitaciones[0].habitaciones_ocupadas" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.HabitacionTotal.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.HabitacionTotal.$error.min">*El campo debe ser mayor que 1</span>
                                        </span>   
                                    </td>
                                    <td><input type="number" name="HabitacionTotal" id="HabitacionTotal" class="form-control" ng-model="alojamiento.habitaciones[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.apartamento">
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Apartamentos</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
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
                                    <td>¿Con cuántas apartamentos se ocuparon durante el mes?  (Es la suma de apartamentos vendidos cada noche del mes) Si usted vendió el mismo apartamento por 15 días, entonces, el apartamento fue ocupado 15 veces.
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosCamas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCamas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosCamas" id="ApartamentosCamas" class="form-control" ng-model="alojamiento.apartamentos[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros se hospedaron durante el mes?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosPersonas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosPersonas.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span> 
                                    </td>
                                    <td><input type="number" name="ApartamentosPersonas" id="ApartamentosPersonas" class="form-control" ng-model="alojamiento.apartamentos[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Magdalena? (De otros departamentos de Colombia)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosCol.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCol.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosCol.$error.number">*El campo debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="ApartamentosCol" name="ApartamentosCol" class="form-control" ng-model="alojamiento.apartamentos[0].viajeros_colombianos" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior son extranjeros?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosExtra.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosExtra.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosExtra.$error.number">*El campo debe ser un número.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" id="ApartamentosExtra" name="ApartamentosExtra" class="form-control" ng-model="alojamiento.apartamentos[0].viajeros_extranjeros" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.ApartamentosTotal.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTotal.$error.required">*El campo es requerido</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.ApartamentosTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="ApartamentosTotal" id="ApartamentosTotal" class="form-control" ng-model="alojamiento.apartamentos[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.casa">
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Casas</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
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
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaCapacidad" id="CasaCapacidad" class="form-control" ng-model="alojamiento.casas[0].capacidad_ocupadas" min="1" ng-required="true" placeholder="Solo números" /></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros se hospedaron durante el mes?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaPersonas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CasaPersonas" id="CasaPersonas" class="form-control" ng-model="alojamiento.casas[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Magdalena? (De otros departamentos de Colombia)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaCol.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCol.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaCol.$error.number">*El campo debe ser un número.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" id="CasaCol" name="CasaCol" class="form-control" ng-model="alojamiento.casas[0].viajeros_colombia" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior son extranjeros?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaExtra.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaExtra.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaExtra.$error.number">*El campo debe ser un número.</span>
                                        </span>       
                                    </td>
                                    <td><input type="number" id="CasaExtra" name="CasaExtra" class="form-control" ng-model="alojamiento.casas[0].viajeros_extranjeros" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CasaTotal.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CasaTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="CasaTotal" id="CasaTotal" class="form-control" ng-model="alojamiento.casas[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.cabana">
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Cabañas</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
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
                                        </span>
                                    </td>
                                    <td><input type="number" name="CabaniaCapacidad" id="CabaniaCapacidad" class="form-control" ng-model="alojamiento.cabanas[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números" /></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros se hospedaron durante el mes?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabPersonas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="CabPersonas" id="CabPersonas" class="form-control" ng-model="alojamiento.cabanas[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior tienen residencia fuera del Magdalena? (De otros departamentos de Colombia)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabCol.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabCol.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabCol.$error.number">*El campo debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="CabCol" name="CabCol" class="form-control" ng-model="alojamiento.cabanas[0].viajeros_colombia" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior son extranjeros?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabExtra.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabExtra.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabExtra.$error.number">*El campo debe ser un número.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" id="CabExtra" name="CabExtra" class="form-control" ng-model="alojamiento.cabanas[0].viajeros_extranjeros" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CabTotal.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CabTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>     
                                    </td>
                                    <td><input type="number" name="CabTotal" id="CabTotal" class="form-control" ng-model="alojamiento.cabanas[0].total_huespedes" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-success" ng-if="servicios.camping"> 
            <div class="panel-heading">

                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Camping</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
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
                                        </span>
                                    </td>
                                    <td><input type="number" name="CampingCapacidad" id="CampingCapacidad" class="form-control" ng-model="alojamiento.campings[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números" /></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros se hospedaron durante el mes?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CamPersonas.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamPersonas.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamPersonas.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamPersonas.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" name="CamPersonas" id="CamPersonas" class="form-control" ng-model="alojamiento.campings[0].viajeros" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Cuántos viajeros que ingresaron durante el mes anterior son extranjeros?
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CamExtra.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamExtra.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamExtra.$error.number">*El campo debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td><input type="number" id="CamExtra" name="CamExtra" class="form-control" ng-model="alojamiento.campings[0].viajeros_extranjeros" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                                <tr>
                                    <td>¿Total huéspedes durante noches del mes de anterior? (Es la sumatoria de los huéspedes que se encontraban registrados cada noche del mes)
                                        <span ng-show="AlojamientoForm.$submitted || AlojamientoForm.CamTotal.$touched">
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTotal.$error.required">*El campo es requerido.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTotal.$error.number">*El campo debe ser un número.</span>
                                            <span class="label label-danger" ng-show="AlojamientoForm.CamTotal.$error.min">*El campo debe ser mayor que 1.</span>
                                        </span>    
                                    </td>
                                    <td><input type="number" name="CamTotal" id="CamTotal" class="form-control" ng-model="alojamiento.campings[0].capacidad_ocupada" min="1" ng-required="true" placeholder="Solo números"/></td>
                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>

            </div>

        </div>

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/caracterizacion/{{$id}}" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>
    </form>
    <div class='carga'>

    </div>
</div>

@endsection


@section('javascript')
    <script src="{{asset('/js/encuestas/ofertaempleo/alojamiento.js')}}"></script>
    <script src="{{asset('/js/encuestas/ofertaempleo/servicios.js')}}"></script>
@endsection