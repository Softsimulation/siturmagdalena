@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta de oferta y empleo')
@section('establecimeinto', 'establecimeinto')
@section('app','ng-app="appEncuestaAlojamiento"')
@section('controller','ng-controller="CaracterizacionAlojamientoCtrl"')


@section('content')

<div class="main-page" >
    
    <input type="hidden" id="id" value="{{$id}}" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error.errores[0].ErrorMessage}}
        </div>
    </div>

    <form role="form" name="carForm" novalidate>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Selecciones las modalidades de alojamiento que ofrece su establecimiento</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionOpcion</b></div>
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

        <div class="panel panel-success" ng-if="servicios.habitacion" >
            <div class="panel-heading">
                <h3 class="panel-title"><b> Habitaciones </b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tbody>
                                <tr>
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
                                <tr>
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
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxH.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxH.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxH" class="form-control" min="0" ng-model="alojamiento.habitaciones[0].capacidad" ng-required="servicios.habitacion" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.apartamento">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Apartamentos </b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Total apartamentos (Por favor no incluir apartamentos para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.numeroApto.$touched">
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.required">* El número total de apartamentos es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.number">* El número total de apartamentos debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroApto.$error.min">* El número total de apartamentos debe ser mayor o igual que 1.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="numeroApto" class="form-control" min="1" ng-model="alojamiento.apartamentos[0].total" ng-required="servicios.apartamento" placeholder="Ingrese aquí el número total de apartamentos" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxA.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxA.$error.min">*  La capacidad máxima debe ser mayor o igual que 1.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxA" class="form-control" min="1" ng-model="alojamiento.apartamentos[0].capacidad" ng-required="servicios.apartamento" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Habitaciones promedio por apartamento
                                        <span ng-show="carForm.$submitted || carForm.habitacionesApto.$touched">
                                            <span class="label label-danger" ng-show="carForm.habitacionesApto.$error.required">* El campo habitaciones por promedio es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.habitacionesApto.$error.number">*  El campo habitaciones por promedio debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.habitacionesApto.$error.min">*  El campo habitaciones por promedio debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="habitacionesApto" class="form-control" min="1" ng-model="alojamiento.apartamentos[0].habitaciones" ng-required="servicios.apartamento" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.casa">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Casas </b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Total casas (Por favor no incluir casas para el personal de la empresa)
                                        <span ng-show="carForm.$submitted || carForm.numeroCasas.$touched">
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.required">* El número total de casas es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.number">* El número total de casas debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.numeroCasas.$error.min">* El número total de casas debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="numeroCasas" class="form-control" min="0" ng-model="alojamiento.casas[0].total" ng-required="servicios.casa" placeholder="Ingrese aquí el número total de casas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                        <span ng-show="carForm.$submitted || carForm.capacidadMaxC.$touched">
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.required">* La capacidad máxima es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.number">* La capacidad máxima debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.capacidadMaxC.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="capacidadMaxC" class="form-control" min="0" ng-model="alojamiento.casas[0].capacidad" ng-required="servicios.casa" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Número promedio de personas por casa
                                        <span ng-show="carForm.$submitted || carForm.promedioC.$touched">
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.required">* El número promedio de personas es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.number">* El número promedio de personas debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.promedioC.$error.min">* El número promedio de personas debe ser mayor que 0.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="promedioC" class="form-control" min="0" ng-model="alojamiento.casas[0].promedio" ng-required="servicios.casa" placeholder="Ingrese aquí el número promedio de personas por casa" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Habitaciones promedio por casa
                                        <span ng-show="carForm.$submitted || carForm.habitacionesCasa.$touched">
                                            <span class="label label-danger" ng-show="carForm.habitacionesCasa.$error.required">* El campo habitaciones por promedio es requerido.</span>
                                            <span class="label label-danger" ng-show="carForm.habitacionesCasa.$error.number">*  El campo habitaciones por promedio debe ser un número.</span>
                                            <span class="label label-danger" ng-show="carForm.habitacionesCasa.$error.min">*  El campo habitaciones por promedio debe ser un número.</span>
                                        </span>
                                    </td>
                                    <td style="width: 15%;min-width: 50px">
                                        <input type="number" name="habitacionesCasa" class="form-control" min="1" ng-model="alojamiento.casas[0].habitaciones" ng-required="servicios.casa" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.cabana">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Cabañas </b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table">
                            <tr>
                                <td>
                                    Total cabañas (Por favor no incluir cabañas para el personal de la empresa)
                                    <span ng-show="carForm.$submitted || carForm.numeroCab.$touched">
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.required">* El número promedio de cabañas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.number">* El número promedio de cabañas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.numeroCab.$error.min">* El número promedio de cabañas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="numeroCab" class="form-control" min="0" ng-model="alojamiento.cabanas[0].total" ng-required="servicios.cabana" placeholder="Ingrese aquí el número total de cabañas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    ¿Cuál es la capacidad máxima de alojamiento en personas? (Por favor no cuente las personas que pueden hospedarse en camas creadas a petición del cliente)
                                    <span ng-show="carForm.$submitted || carForm.capacidadMaxCb.$touched">
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.required">* La capacidad máxima es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.number">* La capacidad máxima debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCb.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="capacidadMaxCb" class="form-control" min="0" ng-model="alojamiento.cabanas[0].capacidad" ng-required="servicios.cabana" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Número promedio de personas por cabaña
                                    <span ng-show="carForm.$submitted || carForm.promedioP.$touched">
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.required">* El número promedio de personas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.number">* El número promedio de personas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.promedioP.$error.min">* El número promedio de personas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="promedioP" class="form-control" min="0" ng-model="alojamiento.cabanas[0].promedio" ng-required="servicios.cabana" placeholder="Ingrese aquí el número promedio de personas por cabaña" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Habitaciones promedio por cabaña
                                    <span ng-show="carForm.$submitted || carForm.habitacionesCab.$touched">
                                        <span class="label label-danger" ng-show="carForm.habitacionesCab.$error.required">* El campo habitaciones por promedio es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.habitacionesCab.$error.number">*  El campo habitaciones por promedio debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.habitacionesCab.$error.min">*  El campo habitaciones por promedio debe ser un número.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="habitacionesCab" class="form-control" min="1" ng-model="alojamiento.cabanas[0].habitaciones" ng-required="servicios.cabana" placeholder="Ingrese aquí la capacidad máxima de alojamiento en personas" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div class="panel panel-success" ng-if="servicios.camping">
            <div class="panel-heading">
                <h3 class="panel-title"><b> Camping </b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table">
                            <tr>
                                <td>
                                    Área del terreno para Camping? (m2)
                                    <span ng-show="carForm.$submitted || carForm.areaC.$touched">
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.required">* El área es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.number">* El área debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.areaC.$error.min">* El área debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="areaC" class="form-control" min="0" ng-model="alojamiento.campings[0].area" ng-required="servicios.camping" placeholder="Ingrese aquí el área del terreno para camping en m2" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Total parcelas (N° espacios para carpas)
                                    <span ng-show="carForm.$submitted || carForm.totalP.$touched">
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.required">* El número total de parcelas es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.number">* El número total de parcelas debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.totalP.$error.min">* El número total de parcelas debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="totalP" class="form-control" min="0" ng-model="alojamiento.campings[0].total_parcelas" ng-required="servicios.camping" placeholder="Ingrese aquí el número total de parcelas" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Capacidad en número de personas
                                    <span ng-show="carForm.$submitted || carForm.capacidadMaxCg.$touched">
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.required">* La capacidad máxima es requerido.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.number">* La capacidad máxima debe ser un número.</span>
                                        <span class="label label-danger" ng-show="carForm.capacidadMaxCg.$error.min">* La capacidad máxima debe ser mayor que 0.</span>
                                    </span>
                                </td>
                                <td style="width: 15%;min-width: 50px">
                                    <input type="number" name="capacidadMaxCg" class="form-control" min="0" ng-model="alojamiento.campings[0].capacidad" ng-required="servicios.camping" placeholder="Ingrese aquí la capacidad en número de personas" />
                                </td>
                            </tr>
                        </table>
                    </div>

                    
                </div>
                
            </div>
        </div>

        <div class="row" style="text-align:center">
            <input type="submit" ng-click="guardar()" class="btn btn-raised btn-success" value="Siguiente" />
        </div>
    </form>

    <div class='carga'> </div>
</div>

@endsection


@section('javascript')
    <script src="{{asset('/js/encuestas/ofertaempleo/alojamiento.js')}}"></script>
    <script src="{{asset('/js/encuestas/ofertaempleo/servicios.js')}}"></script>
@endsection