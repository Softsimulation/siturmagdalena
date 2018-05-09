@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
        }
        .table > thead > tr > th {
            background-color: rgba(0,0,0,.1);
        }
        .jp-options {
            position: absolute; 
            background-color: white;
            z-index:2; 
            width: 95%; 
            max-height: 300px; 
            overflow-y: auto;
            -webkit-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75);
            box-shadow: 0px 3px 8px -1px rgba(0,0,0,0.75); 
            color: dimgray;
        }
        .jp-options>div{
            border-bottom: 0.5px solid rgba(0,0,0,.1);
            padding-left: 2%;
        }
        .jp-options > div label{
            cursor: pointer;
        }
        .st-list-tag {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .st-list-tag li{
            display: inline-block;
            margin-bottom: 0.5em;
            min-width: 8.3%;
            margin-right: 1em;
            border-radius: 20px;
            padding: 1em;
            padding-top: .5em;
            padding-bottom: .5em;
            background-color:dodgerblue;
            color:white;
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
        z-index:11!important;
        }
    </style>
@endsection

@section('TitleSection', 'Gastos')

@section('Progreso', '66.65%')

@section('NumSeccion', '66%')

@section('controller','ng-controller="gasto"')

@section('content')
<div class="main-page" >
    <input type="hidden" ng-model="id" ng-init="" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error.errores[0].ErrorMessage}}
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
                                <input type="radio" value="1" name="opt1" ng-model="encuestaReceptor.RealizoGasto" ng-required="true">
                                @Resource.EncuestaGastosP1Op1
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" value="0" name="opt1" ng-model="encuestaReceptor.RealizoGasto" ng-required="true">
                                @Resource.EncuestaGastosP1Op2
                            </label>
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.opt1.$touched">
                            <span class="label label-danger" ng-show="GastoForm.opt1.$error.required">@Resource.EncuestaCampoRequerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="gastosRealizados" ng-show="encuestaReceptor.RealizoGasto==1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP2</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="1" name="opt2" ng-model="encuestaReceptor.ViajoDepartamento" ng-required="encuestaReceptor.RealizoGasto==1">
                                    @Resource.EncuestaReSi
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="0" name="opt2" ng-model="encuestaReceptor.ViajoDepartamento" ng-required="encuestaReceptor.RealizoGasto==1">
                                    @Resource.EncuestaReNo
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt2.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt2.$error.required">@Resource.EncuestaCampoRequerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ViajeDepartamento" ng-show="encuestaReceptor.ViajoDepartamento==1">

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- Información del paquete turístico-->
                        <h3 class="panel-title"><b>@Resource.EncuestaGastosP5</b></h3>
                    </div>
                    <div class="panel-footer"><b>Complete la siguiente información</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P1. ¿Cuánto pagó usted por el paquete turístico o excursión?-->
                                    <label for="pago" class="col-md-12 control-label" style="color:dimgray;">@Resource.EncuestaGastosP5P1</label>

                                    <div class="col-md-12">
                                        <input type="number" class="form-control" min="1" name="pago" ng-model="encuestaReceptor.CostoPaquete" placeholder="@Resource.EncuestaMsgSoloNumeros">
                                        <span ng-show="GastoForm.$submitted || GastoForm.pago.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.pago.$error.min">* El valor debe ser mayor a 0.</span>
                                            <span class="label label-danger" ng-show="GastoForm.pago.$error.number">* Solo números.</span>
                                        </span>
                                        <span ng-show="GastoForm.$submitted || GastoForm.pago.$touched || GastoForm.Divisa.$touched">
                                            <span class="label label-danger" ng-show="encuestaReceptor.DivisaPaquete==39 && encuestaReceptor.CostoPaquete<1000">* El valor debe ser mínimo 1.000</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P2. Moneda de compra del paquete turístico o excursión-->
                                    <label for="selectDivisa" class="col-md-12 control-label" style="color:dimgray;"><span class="asterik glyphicon glyphicon-asterisk" style="font-size: .9em;"></span> @Resource.EncuestaGastosP5P2</label>

                                    <div class="col-md-12">
                                        <select id="selectDivisa" class="form-control" ng-model="encuestaReceptor.DivisaPaquete" name="Divisa" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                            <!-- P5P2Input1. Seleccione una moneda-->
                                            <option value="0" selected disabled>@Resource.EncuestaGastosP5P2Input1</option>
                                            <option ng-repeat="div in opciones.divisas" value="@{{div.Id}}">@{{div.Nombre}}</option>
                                        </select>
                                        <span ng-show="GastoForm.$submitted || GastoForm.Divisa.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.Divisa.$error.required">@Resource.EncuestaCampoRequerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P3. ¿A cuántas personas cubrió?-->
                                    <label for="personas_cubiertas" class="col-md-12 control-label" style="color:dimgray;">@Resource.EncuestaGastosP5P3</label>

                                    <div class="col-md-12">
                                        <input type="number" class="form-control" min="1" name="personas_cubiertas" ng-model="encuestaReceptor.PersonasCubrio" placeholder="@Resource.EncuestaMsgSoloNumeros">
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

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- P3. ¿El paquete/plan turístico incluyó municipios fuera del Magdalena?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP3</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="1" name="opt5" ng-model="encuestaReceptor.IncluyoOtros" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                        @Resource.EncuestaReSi
                                    </label>
                                </div>
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="0" name="opt5" ng-model="encuestaReceptor.IncluyoOtros" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                        @Resource.EncuestaReNo
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted || GastoForm.opt5.$touched">
                                    <span class="label label-danger" ng-show="GastoForm.opt5.$error.required">@Resource.EncuestaCampoRequerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-init="mostrarOpciones = ''" ng-show="encuestaReceptor.IncluyoOtros==1">
                    <div class="panel-heading">
                        <!-- ¿Qué otras ciudades/municipios fuera del Magdalena incluyó el paquete/plan turístico?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP4</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgListaDesplegable </b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="st-list-tag">
                                    <li ng-repeat="ciudad in opciones.municipios" ng-show="ciudad.selected == true" ng-click="quitarCiudad(ciudad)">
                                        @{{ciudad.Nombre}} - @{{ciudad.Departamento}} <span class="glyphicon glyphicon-remove"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12">
                                <div class="jp-select" id="select-item">
                                    <input type="text" class="form-control" id="inputSearchPerfil" name="searsearchCiudad" ng-model="searchCiudad" ng-change="mostrarOpciones = 'ciudad'" placeholder="@Resource.EncuestaGastosP4Input1" autocomplete="off" ng-click="mostrarOpciones = 'ciudad'">


                                    <div class="jp-options" ng-show="mostrarOpciones == 'ciudad'" ng-mouseover="mostrarOpciones = 'ciudad'" ng-mouseleave="mostrarOpciones = ''">
                                        <div ng-repeat="ciudad in opciones.municipios|filter:searchCiudad" ng-show="ciudad.selected == false;" style="background-color: white;">
                                            <label for="cbox-ciudad-@{{ciudad.Id}}" style="display:block;color: dimgray;">
                                                <div ng-show="ciudad.selected == false">
                                                    <!--div ng-class="{true: 'content red', false: 'content white'}[item.selected == true]"-->
                                                    @{{ciudad.Nombre}} - @{{ciudad.Departamento}}
                                                    <!--/div-->
                                                </div>
                                            </label>

                                            <input id="cbox-ciudad-@{{ciudad.Id}}" name="cbox-ciudad-@{{ciudad.Id}}" type="checkbox" style="z-index:-10;position: absolute; top: 0;left:0;opacity: 0;" checklist-model="encuestaReceptor.Municipios" checklist-value="ciudad.Id" ng-click="ciudad.selected = true">
                                        </div>
                                    </div>

                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="(encuestaReceptor.Municipios.length == 0 ||  encuestaReceptor.Municipios == null) && encuestaReceptor.IncluyoOtros==1">@Resource.EncuestaCampoRequerido</span>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- P6. El paquete/plan turístico o excursión fue comprado a:-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuestaGastosP6</b></h3>
                    </div>
                    <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary" ng-repeat="prov in opciones.proveedor_paquete">
                                    <label>
                                        <input type="radio" id="radio-@{{prov.Id}}" value="@{{prov.Id}}" name="proveedor" ng-model="encuestaReceptor.Proveedor" ng-required="encuestaReceptor.ViajoDepartamento==1" >
                                        @{{prov.Nombre}}
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="GastoForm.proveedor.$error.required">@Resource.EncuestaCampoRequerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-show="encuestaReceptor.Proveedor==1">
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
                                        <input type="radio" id="radio-opt-@{{opc.Id}}" value="@{{opc.Id}}" name="lugar" ng-model="encuestaReceptor.LugarAgencia" ng-required="encuestaReceptor.Proveedor==1" >
                                        @{{opc.Nombre}}
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
                                        <input type="checkbox" checklist-model="encuestaReceptor.ServiciosIncluidos" checklist-value="servicio.Id"> @{{servicio.Nombre}}
                                    </label>

                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="(encuestaReceptor.ServiciosIncluidos.length == 0 ||  encuestaReceptor.ServiciosIncluidos == null) && encuestaReceptor.ViajoDepartamento==1">@Resource.EncuestaCampoRequerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <!--P8A. ¿Desea proporcionar información adicional de sus gastos?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> @Resource.EncuetaGastosP8A</b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgSeleccionUnica</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gatsi" value="1" name="opt6" ng-model="encuestaReceptor.GastosAparte" ng-required="encuestaReceptor.RealizoGasto==1">
                                    @Resource.EncuestaReSi
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gastno" value="0" name="opt6" ng-model="encuestaReceptor.GastosAparte" ng-required="encuestaReceptor.RealizoGasto==1" />
                                    @Resource.EncuestaReNo
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt6.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt6.$error.required">@Resource.EncuestaCampoRequerido</span>
                            </span>
                            <span ng-show="GastoForm.$submitted || encuestaReceptor.GastosAparte == 0 && encuestaReceptor.ViajoDepartamento == 0">
                                <span class="label label-danger" ng-show="encuestaReceptor.GastosAparte == 0 && encuestaReceptor.ViajoDepartamento == 0">*Si indico que realizo gastos, debe ingresar algun gasto hecho (si viajo como paquete turístico o al menos un gasto adicional).</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success" ng-show="encuestaReceptor.GastosAparte == 1">
                <div class="panel-heading">
                    <!-- P9. Indique los gastos totales hechos por usted, para usted o su grupo de viaje. No coloque gastos induviduales-->
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
                                            <th class="text-center" style="width:20%;">@Resource.EncuestaGastosP9Col1</th>
                                            <!--P9Col2. Cantidad pagada-->
                                            <th class="text-center" style="width:55%;">@Resource.EncuestaGastosP9Col2</th>
                                            <!--P9Col3. ¿A cuántas personas cubrió?-->
                                            <th class="text-center" style="width:10%;">@Resource.EncuestaGastosP9Col3</th>
                                            <!--P9Col4. Fue pagado por otra persona u organización/ empresa diferente a usted o a su grupo de viaje -->
                                            <th class="text-center" style="width:15%;">@Resource.EncuestaGastosP9Col4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="rub in opciones.rubros">
                                            <td style="width:20%;">@{{rub.Nombre}}</td>
                                            <td style="width:55%;">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6">
                                                        <input type="hidden" ng-init="encuestaReceptor.lista[$index].IdRubro=rub.Id" />
                                                        <input type="hidden" ng-init="encuestaReceptor.lista[$index].NombreRubro=rub.Nombre" />
                                                        <!--P9Col2Title1. Fuera del Magdalena-->
                                                        <h5 style="margin-bottom: 0;"><b>@Resource.EncuestaGastosP9Col2Title1</b></h5>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <!--P9Col2Cantidad. Cantidad-->
                                                                    <label for="gastoFuera" class="col-md-12 control-label" style="color:dimgray;">@Resource.EncuestaGastosP9Col2Cantidad</label>

                                                                    <div class="col-md-12">
                                                                        <input type="number" class="form-control" name="cantFuera@{{$index}}" placeholder="0" min="1" ng-model="encuestaReceptor.lista[$index].CantidadFuera">
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].CantidadFuera==null && !(encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null)">*Requerido cantidad fuera</span>
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].DivisaFuera==39 && encuestaReceptor.lista[$index].CantidadFuera<1000">*El valor mínimo es de 1.000 pesos</span>
                                                                        </span>
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.cantFuera@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="GastoForm.cantFuera@{{$index}}.$error.min">*El valor debe ser mayor a 0</span>
                                                                            <span class="label label-danger" ng-show="GastoForm.cantFuera@{{$index}}.$error.number">* Solo números.</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <!--P9Col2Divisa. Divisa-->
                                                                    <label for="selecDivisa2" class="col-md-2 control-label" style="color:dimgray;">@Resource.EncuestaGastosP9Col2Divisa</label>

                                                                    <div class="col-md-10">
                                                                        <select id="selectDivisa2" class="form-control" name="divisaFuera@{{$index}}" ng-model="encuestaReceptor.lista[$index].DivisaFuera">
                                                                            <!-- EncuestaMsgSelecionarDivisa. Seleccionar divisa-->
                                                                            <option value="">@Resource.EncuestaMsgSeleccionarDivisa</option>
                                                                            <option ng-repeat="div in opciones.divisas" value="@{{div.Id}}">@{{div.Nombre}}</option>
                                                                        </select>
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].CantidadFuera!=null && (encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null) ">*Requerido divisa fuera</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <!--P9Col2Title2. En el Magdalena-->
                                                        <h5 style="margin-bottom: 0;"><b>@Resource.EncuestaGastosP9Col2Title2</b></h5>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="gastoFuera" class="col-md-12 control-label" style="color:dimgray;">@Resource.EncuestaGastosP9Col2Cantidad</label>

                                                                    <div class="col-md-12">
                                                                        <input type="number" class="form-control" name="cantDentro@{{$index}}" min="1" placeholder="Cantidad" ng-model="encuestaReceptor.lista[$index].CantidadDentro">
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].CantidadDentro==null && !(encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null) ">*Requerido cantidad dentro</span>
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].DivisaDentro==39 && encuestaReceptor.lista[$index].CantidadDentro<1000">*El valor mínimo es de 1.000 pesos</span>
                                                                        </span>
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.cantDentro@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="GastoForm.cantDentro@{{$index}}.$error.min">*El valor debe ser mayor a 0</span>
                                                                            <span class="label label-danger" ng-show="GastoForm.cantDentro@{{$index}}.$error.number">* Solo números.</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="selectDivisa" class="col-md-2 control-label" style="color:dimgray;">@Resource.EncuestaGastosP9Col2Divisa</label>

                                                                    <div class="col-md-10">
                                                                        <select id="selectDivisa3" class="form-control" name="divisaDentro@{{$index}}" ng-model="encuestaReceptor.lista[$index].DivisaDentro">
                                                                            <option value="">@Resource.EncuestaMsgSeleccionarDivisa</option>
                                                                            <option ng-repeat="div in opciones.divisas" value="@{{div.Id}}">@{{div.Nombre}}</option>
                                                                        </select>
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].CantidadDentro!=null && (encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null) ">*Requerido divisa dentro</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 text-center">
                                                        <span ng-show="GastoForm.$submitted || GastoForm.personas@{{$index}}.$touched">
                                                            <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].PersonasCubiertas != null && encuestaReceptor.lista[$index].CantidadFuera==null  && encuestaReceptor.lista[$index].CantidadDentro==null && (encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null) && (encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null)">*Debe llenar una cantidad</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:10%;">
                                                <input type="number" min="1" class="form-control" name="personas@{{$index}}" ng-model="encuestaReceptor.lista[$index].PersonasCubiertas" placeholder="0"/>
                                                <span ng-show="GastoForm.$submitted || GastoForm.personas@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="GastoForm.personas@{{$index}}.$error.number">* Solo números.</span>
                                                    <span class="label label-danger" ng-show="GastoForm.personas@{{$index}}.$error.min">* El valor debe ser mayor a 0.</span>
                                                </span>
                                                <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched ||GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched ||
                                                      GastoForm.personas@{{$index}}.$touched || GastoForm.asumido@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].OtrosAsumidos==true  && encuestaReceptor.lista[$index].PersonasCubiertas==null && ((encuestaReceptor.lista[$index].CantidadDentro!=null && !(encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null)) || (encuestaReceptor.lista[$index].CantidadFuera!=null  && !(encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null))) ">@Resource.EncuestaCampoRequerido</span>
                                                </span>
                                                <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched ||GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched ||
                                                      GastoForm.personas@{{$index}}.$touched || GastoForm.asumido@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].OtrosAsumidos==false && encuestaReceptor.lista[$index].PersonasCubiertas==null && ((encuestaReceptor.lista[$index].CantidadDentro!=null && !(encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null)) || (encuestaReceptor.lista[$index].CantidadFuera!=null  && !(encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null))) ">@Resource.EncuestaCampoRequerido</span>
                                                </span>
                                                <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched ||GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched ||
                                                      GastoForm.personas@{{$index}}.$touched || GastoForm.asumido@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].OtrosAsumidos==null && encuestaReceptor.lista[$index].PersonasCubiertas==null && ((encuestaReceptor.lista[$index].CantidadDentro!=null && !(encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null)) || (encuestaReceptor.lista[$index].CantidadFuera!=null  && !(encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null))) ">@Resource.EncuestaCampoRequerido</span>
                                                </span>
                                                <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched || GastoForm.cantFuera@{{$index}}.$touched ||GastoForm.divisaDentro@{{$index}}.$touched || GastoForm.cantDentro@{{$index}}.$touched ||
                                                      GastoForm.personas@{{$index}}.$touched || GastoForm.asumido@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="encuestaReceptor.lista[$index].OtrosAsumidos==true  && encuestaReceptor.lista[$index].PersonasCubiertas==null && encuestaReceptor.lista[$index].CantidadDentro==null &&  (encuestaReceptor.lista[$index].DivisaDentro== '' || encuestaReceptor.lista[$index].DivisaDentro==null) && encuestaReceptor.lista[$index].CantidadFuera==null  && (encuestaReceptor.lista[$index].DivisaFuera== '' || encuestaReceptor.lista[$index].DivisaFuera==null) ">@Resource.EncuestaCampoRequerido</span>
                                                </span>
                                            </td>
                                            <td style="width:15%;">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="asumido@{{$index}}"  ng-model="encuestaReceptor.lista[$index].OtrosAsumidos" value="true"> @Resource.EncuestaReSi
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
                        <div class="checkbox" ng-repeat="fin in opciones.financiadores_viajes" ng-show="!(encuestaReceptor.RealizoGasto==0 && fin.Id==1)">
                            <label>
                                <input type="checkbox" checklist-model="encuestaReceptor.Financiadores" name ="Financiadores" checklist-value="fin.Id" > @{{fin.Nombre}}
                            </label>
                            
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.Financiadores.$touched">
                            <span class="label label-danger" ng-show="encuestaReceptor.Financiadores.length == 0 ||  encuestaReceptor.Financiadores == null">@Resource.EncuestaCampoRequerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <a href="/EncuestaReceptor/SeccionViajeGrupo/@ViewBag.id" class="btn btn-raised btn-default">@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="@Resource.EncuestaBtnSiguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
@endsection

@section('javascript')
    <script>
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
@endsection


