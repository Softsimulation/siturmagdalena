@{
    ViewBag.Title = "Gastos - Turísmo interno y emisor :: SITUR";
    Layout = "~/Views/Shared/_encuestaInternoLayout.cshtml";
}
@section estilos{
    <style>
        .title-section {
            background-color: #16469e !important;
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
            z-index: 11 !important;
        }
    </style>
}
@{
    ViewBag.TitleSection = Resource.EncuestaGastosTitulo;

}
@{
    ViewBag.Progreso = "80%";
    ViewBag.NumSeccion = "80%";
}

<div class="main-page" ng-controller="gasto">
    <input type="hidden" ng-model="id" ng-init="id=@ViewBag.id" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -{{error.errores[0].ErrorMessage}}
        </div>
    </div>

    <form role="form" name="GastoForm" novalidate>

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P1. Seleccione los gastos realizados por usted antes (gastos de preparación del viaje al Magdalena) y durante su viaje al Magdalena-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP1</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" value="1" name="opcion" ng-model="encuestaInterno.RealizoGasto" ng-required="true">
                                @Resource.EncuestaGastosP1Op1
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" value="0" name="opcion" ng-model="encuestaInterno.RealizoGasto" ng-required="true">
                                @Resource.EncuestaGastosP1Op2
                            </label>
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.opcion.$touched">
                            <span class="label label-danger" ng-show="GastoForm.opcion.$error.required">* El campo es requerido.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="gastosRealizados" ng-show="encuestaInterno.RealizoGasto==1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿El viaje hizo parte de un paquete/plan turístico o excursión?</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="1" name="opt2" ng-model="encuestaInterno.ViajePaquete" ng-required="encuestaInterno.RealizoGasto==1">
                                    @Resource.EncuestaReSi
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="0" name="opt2" ng-model="encuestaInterno.ViajePaquete" ng-required="encuestaInterno.RealizoGasto==1">
                                    @Resource.EncuestaReNo
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt2.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt2.$error.required">* El campo es requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ViajeDepartamento" ng-if="encuestaInterno.ViajePaquete==1">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- Información del paquete turístico-->
                        <h3 class="panel-title"><b>@Resource.EncuestaGastosP5</b></h3>
                    </div>
                    <div class="panel-footer"><b>Complete la siguiente información</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-5">
                                <div class="form-group">
                                    <!-- P5P1. ¿Cuánto pagó usted por el paquete turístico o excursión?-->
                                    <label for="costo" class="col-md-12 control-label" style="color:dimgray;"><span class="asterik glyphicon glyphicon-asterisk" style="font-size: .9em;"></span> @Resource.EncuestaGastosP5P1</label>

                                    <div class="col-md-12">
                                        <i class="material-icons" title="Aproximadamente en pesos colombianos" style="font-size: 1.6em;position: relative; top: 8px;">help</i> <input type="number" class="form-control" min="1000" name="costo" ng-model="encuestaInterno.CostoPaquete" placeholder="@Resource.EncuestaMsgSoloNumeros" ng-required="encuestaInterno.ViajePaquete==1" style="display: inline-block; width: 90%;">
                                    </div>
                                    <span ng-show="GastoForm.$submitted || GastoForm.costo.$touched">
                                        <span class="label label-danger" ng-show="GastoForm.costo.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="GastoForm.costo.$error.min">* El valor mínimo es de 1.000 pesos</span>
                                        <span class="label label-danger" ng-show="GastoForm.costo.$error.number">* Sólo números</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P2. Moneda de compra del paquete turístico o excursión-->
                                    <label for="selectDivisa" class="col-md-12 control-label" style="color:dimgray;"><span class="asterik glyphicon glyphicon-asterisk" style="font-size: .9em;"></span> @Resource.EncuestaGastosP5P2</label>

                                    <div class="col-md-12">
                                        <select id="selectDivisa" class="form-control" ng-model="encuestaInterno.DivisaPaquete" name="Divisa" ng-required="encuestaInterno.ViajePaquete==1">
                                            <!-- P5P2Input1. Seleccione una moneda-->
                                            <option value="">@Resource.EncuestaGastosP5P2Input1</option>
                                            <option ng-repeat="div in opciones.divisas" value="{{div.Id}}">{{div.Nombre}}</option>
                                        </select>
                                        <span ng-show="GastoForm.$submitted || GastoForm.Divisa.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.Divisa.$error.required">* El campo es requerido.</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div class="form-group">
                                    <!-- P5P3. ¿A cuántas personas cubrió?-->
                                    <label for="personas_cubiertas" class="col-md-12 control-label" style="color:dimgray;">@Resource.EncuestaGastosP5P3</label>

                                    <div class="col-md-12">
                                        <input type="number" class="form-control" min="1" name="personas_cubiertas" ng-model="encuestaInterno.PersonasCubrio" placeholder="@Resource.EncuestaMsgSoloNumeros">
                                        <span ng-show="GastoForm.$submitted || GastoForm.personas_cubiertas.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.personas_cubiertas.$error.min">* El valor debe ser mayor a 0.</span>
                                            <span class="label label-danger" ng-show="GastoForm.personas_cubiertas.$error.number">* Solo números.</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-show="encuestaInterno.DivisaPaquete==39">
                    <div class="panel-heading">
                        <!-- P2. ¿Cuál fue la modalidad efectuada en el pago del paquete turístico?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál fue la modalidad efectuada en el pago del paquete turístico?</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" id="efectivo" value="1" name="opt3" ng-model="encuestaInterno.ModalidadPago" ng-required="encuestaInterno.DivisaPaquete==39">
                                        Efectivo
                                    </label>
                                </div>
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" id="credito" value="0" name="opt3" ng-model="encuestaInterno.ModalidadPago" ng-required="encuestaInterno.DivisaPaquete==39">
                                        Tarjeta de crédito
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted || GastoForm.opt3.$touched">
                                    <span class="label label-danger" ng-show="GastoForm.opt3.$error.required">* El campo es requerido.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- P6. El paquete/plan turístico o excursión fue comprado a una agencia de viajes u operador turístico:-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> El paquete/plan turístico o excursión fue comprado a una agencia de viajes u operador turístico</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="1" name="opt1" ng-model="encuestaInterno.AgenciaViaje" ng-required="encuestaInterno.ViajePaquete==1">
                                        @Resource.EncuestaReSi
                                    </label>
                                </div>
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="0" name="opt1" ng-model="encuestaInterno.AgenciaViaje" ng-required="encuestaInterno.ViajePaquete==1">
                                        @Resource.EncuestaReNo
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted || GastoForm.opt1.$touched">
                                    <span class="label label-danger" ng-show="GastoForm.opt1.$error.required">* El campo es requerido.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-show="encuestaInterno.AgenciaViaje==1">
                    <div class="panel-heading">
                        <!-- P7. ¿En donde está ubicada la agencia de viajes/operador turístico?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP7</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary" ng-repeat="opc in opciones.opciones_lugares">
                                    <label>
                                        <input type="radio" id="radio-opt-{{opc.Id}}" value="{{opc.Id}}" name="lugar" ng-model="encuestaInterno.LugarAgencia" ng-required="encuestaInterno.AgenciaViaje==1">
                                        {{opc.Nombre}}
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="GastoForm.lugar.$error.required">* El campo es requerido.</span>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- P8. ¿Qué productos y servicios incluía el paquete turístico o excursión?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP8</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox" ng-repeat="servicio in opciones.servicios_paquete">
                                    <label>
                                        <input type="checkbox" checklist-model="encuestaInterno.ServiciosIncluidos" checklist-value="servicio.Id"> {{servicio.Nombre}}
                                    </label>

                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="(encuestaInterno.ServiciosIncluidos.length == 0 ||  encuestaInterno.ServiciosIncluidos == null) && encuestaInterno.ViajePaquete==1">* El campo es requerido.</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Desea proporcionar información adicional de sus gastos?</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gatsi" value="1" name="opt6" ng-model="encuestaInterno.GastosAparte" ng-required="encuestaInterno.RealizoGasto==1">
                                    @Resource.EncuestaReSi
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gastno" value="0" name="opt6" ng-model="encuestaInterno.GastosAparte" ng-required="encuestaInterno.RealizoGasto==1">
                                    @Resource.EncuestaReNo
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt6.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt6.$error.required">* El campo es requerido.</span>
                            </span>
                            <span ng-show="GastoForm.$submitted || encuestaInterno.GastosAparte == 0 && encuestaInterno.ViajePaquete == 0">
                                <span class="label label-danger" ng-show="encuestaInterno.GastosAparte == 0 && encuestaInterno.ViajePaquete == 0">*Si indico que realizo gastos, debe ingresar algun gasto hecho (si viajo como paquete turístico o al menos un gasto adicional).</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success" ng-show="encuestaInterno.GastosAparte == 1">
                <div class="panel-heading">
                    <!-- P9. Indique los gastos totales hechos por usted, para usted o su grupo de viaje. No coloque gastos individuales-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP9</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover" style="min-height: 500px;">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <!--P9Col1. Rubro-->
                                            <th class="text-center" style="width:35%;">@Resource.EncuestaGastosP9Col1</th>
                                            <!--P9Col2. Cantidad pagada-->
                                            <th class="text-center" style="width:25%;">@Resource.EncuestaGastosP9Col2</th>
                                            <!--P9Col3. ¿A cuántas personas cubrió?-->
                                            <th class="text-center" style="width:15%;">@Resource.EncuestaGastosP9Col3</th>
                                            <!--P9Col4. Fue pagado por otra persona u organización/ empresa diferente a usted o a su grupo de viaje -->
                                            <th class="text-center" style="width:25%;">@Resource.EncuestaGastosP9Col4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="rub in opciones.rubros">
                                            <td style="width:35%;">{{rub.Nombre}}</td>
                                            <td style="width:25%;">
                                                <div class="row">
                                                    <input type="hidden" ng-init="encuestaInterno.lista[$index].IdRubro=rub.Id" />
                                                    <input type="hidden" ng-init="encuestaInterno.lista[$index].NombreRubro=rub.Nombre" />
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="cantidadFuera{{$index}}" class="col-md-12 control-label" style="color:dimgray;">Fuera del Magdalena </label>
                                                        <input type="number" class="form-control" name="cantidadFuera{{$index}}" placeholder="0" min="1000" ng-model="encuestaInterno.lista[$index].CantidadFuera">
                                                        <span ng-show="GastoForm.$submitted || GastoForm.cantidadFuera{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="GastoForm.cantidadFuera{{$index}}.$error.min">*El valor mínimo es de 1.000 pesos</span>
                                                            <span class="label label-danger" ng-show="GastoForm.cantidadFuera{{$index}}.$error.number">* Solo números.</span>
                                                        </span>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <label for="cantidad{{$index}}" class="col-md-12 control-label" style="color:dimgray;">Dentro del Magdalena</label>
                                                        <input type="number" class="form-control" name="cantidad{{$index}}" placeholder="0" min="1000" ng-model="encuestaInterno.lista[$index].Cantidad">
                                                        <span ng-show="GastoForm.$submitted || GastoForm.cantidad{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="GastoForm.cantidad{{$index}}.$error.min">*El valor mínimo es de 1000 pesos</span>
                                                            <span class="label label-danger" ng-show="GastoForm.cantidad{{$index}}.$error.number">* Solo números.</span>
                                                        </span>
                                                    </div>
                                                    <div class="col-xs-12">
                                                        <span ng-show="GastoForm.$submitted || GastoForm.personas{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="encuestaInterno.lista[$index].PersonasCubiertas != null && encuestaInterno.lista[$index].CantidadFuera==null && encuestaInterno.lista[$index].Cantidad==null ">*Debe llenar una cantidad</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:15%;">
                                                <input type="number" min="1" class="form-control" name="personas{{$index}}" ng-model="encuestaInterno.lista[$index].PersonasCubiertas" placeholder="0" />
                                                <span ng-show="GastoForm.$submitted || GastoForm.cantidadFuera{{$index}}.$touched || GastoForm.cantidad{{$index}}.$touched || GastoForm.personas{{$index}}.$touched || GastoForm.asumido{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="encuestaInterno.lista[$index].OtrosAsumidos==true  && encuestaInterno.lista[$index].PersonasCubiertas==null && (encuestaInterno.lista[$index].Cantidad!=null  || encuestaInterno.lista[$index].CantidadFuera!=null) ">*Requerido este campo</span>
                                                    <span class="label label-danger" ng-show="encuestaInterno.lista[$index].OtrosAsumidos==false && encuestaInterno.lista[$index].PersonasCubiertas==null && (encuestaInterno.lista[$index].Cantidad!=null  || encuestaInterno.lista[$index].CantidadFuera!=null) ">*Requerido este campo</span>
                                                    <span class="label label-danger" ng-show="encuestaInterno.lista[$index].OtrosAsumidos==null && encuestaInterno.lista[$index].PersonasCubiertas==null && (encuestaInterno.lista[$index].Cantidad!=null  || encuestaInterno.lista[$index].CantidadFuera!=null) ">*Requerido este campo</span>
                                                    <span class="label label-danger" ng-show="encuestaInterno.lista[$index].OtrosAsumidos==true  && encuestaInterno.lista[$index].PersonasCubiertas==null && encuestaInterno.lista[$index].Cantidad==null &&  encuestaInterno.lista[$index].CantidadFuera==null">*Requerido este campo</span>
                                                </span>
                                                <span ng-show="GastoForm.$submitted || GastoForm.personas{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="GastoForm.personas{{$index}}.$error.min">*El valor debe ser mayor a 0.</span>
                                                    <span class="label label-danger" ng-show="GastoForm.personas{{$index}}.$error.number">* Solo números.</span>
                                                </span>
                                            </td>
                                            <td style="width:25%;text-align: center;">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="asumido{{$index}}" ng-model="encuestaInterno.lista[$index].OtrosAsumidos" value="true"> Si
                                                    </label>
                                                </div>
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

        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P10. Los gastos de las personas que conformaron el grupo de viaje fueron pagados por:-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP10</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionMultiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="fin in opciones.financiadores_viajes" ng-show="!(encuestaInterno.RealizoGasto==0 && fin.Id==1)">
                            <label>
                                <input type="checkbox" checklist-model="encuestaInterno.Financiadores" name="Financiadores" checklist-value="fin.Id"> {{fin.Nombre}}
                            </label>
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.Financiadores.$touched">
                            <span class="label label-danger" ng-show="encuestaInterno.Financiadores.length == 0 ||  encuestaInterno.Financiadores == null">* El campo es requerido.</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="/encuestaInterno/Transporte/@ViewBag.id" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>
        <br />
</form>

    <div class='carga'>

    </div>
</div>
@section javascript{
    <script>
        $('[data-toggle="tooltip"]').tooltip()
        $(window).on('scroll', function () {

            if ($('#tgastos').length && $(this).width() > 992) {
                if ($(this).scrollTop() > $('#tgastos').offset().top && $(this).scrollTop() < ($('#tgastos').offset().top + $('#tgastos').height())) {
                    $('#head-tgastos').width($('#tgastos').width());
                    $('#head-tgastos').addClass('thead-fixed');
                } else {
                    $('#head-tgastos').removeClass('thead-fixed');
                }
            } else {
                $('#head-tgastos').css('width', 'auto');
                $('#head-tgastos').removeClass('thead-fixed');
            }


        });
        $(window).on('resize', function () {
            if ($('#tgastos').length && $(this).width() > 992) {
                if ($(this).scrollTop() > $('#tgastos').offset().top && $(this).scrollTop() < ($('#tgastos').offset().top + $('#tgastos').height())) {
                    $('#head-tgastos').width($('#tgastos').width());

                }
            } else {
                $('#head-tgastos').css('width', 'auto');
                $('#head-tgastos').removeClass('thead-fixed');
            }

        })
    </script>
}





