@extends('layout._encuestaLayout')

@section('title', 'Encuesta turismo receptor')

@section('estilos')
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
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" role="alert" ng-if="errores" ng-repeat="error in errores">
       @{{error[0]}}
    </div>
  
    <form role="form" name="GastoForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P1. Seleccione los gastos realizados por usted antes (gastos de preparación del viaje al Magdalena) y durante su viaje al Magdalena-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>  Seleccione los gastos realizados por usted antes (gastos de preparación del viaje al Atlántico) y durante su viaje al Atlántico</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" value="1" name="opt1" ng-model="encuestaReceptor.RealizoGasto" ng-required="true">
                                Realicé gastos en el destino
                            </label>
                        </div>
                        <div class="radio radio-primary">
                            <label>
                                <input type="radio" value="0" name="opt1" ng-change="limpiarGasto()" ng-model="encuestaReceptor.RealizoGasto" ng-required="true">
                                No realicé ningún tipo de gasto
                            </label>
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.opt1.$touched">
                            <span class="label label-danger" ng-show="GastoForm.opt1.$error.required">Campo requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="gastosRealizados" ng-show="encuestaReceptor.RealizoGasto==1">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <!-- P2. ¿El viaje al departamento hizo parte de un paquete/plan turístico o excursión?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> El viaje al departamento hizo parte de un paquete/plan turístico o excursión</b></h3>
                </div>
                <div class="panel-footer"><b>Pregunta con selección única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="1" name="opt2" ng-model="encuestaReceptor.ViajoDepartamento" ng-required="encuestaReceptor.RealizoGasto==1">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" value="0" name="opt2" ng-change="limpiarPaquete()" ng-model="encuestaReceptor.ViajoDepartamento" ng-required="encuestaReceptor.RealizoGasto==1">
                                    No
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt2.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt2.$error.required">Campo requerido</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ViajeDepartamento" ng-show="encuestaReceptor.ViajoDepartamento==1">

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- Información del paquete turístico-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Información del paquete turístico</b></h3>
                    </div>
                    <div class="panel-footer"><b>Complete la siguiente información</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P1. ¿Cuánto pagó usted por el paquete turístico o excursión?-->
                                    <label for="pago" class="col-md-12 control-label" style="color:dimgray;">¿Cuánto pagó usted por el paquete turístico o excursión?</label>

                                    <div class="col-md-12">
                                        <input type="number" ng-required="encuestaReceptor.ViajoDepartamento==1" class="form-control" min="1" name="pago" ng-model="encuestaReceptor.CostoPaquete" placeholder="Solo números">
                                        <span ng-show="GastoForm.$submitted || GastoForm.pago.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.pago.$error.min">* El valor debe ser mayor a 0.</span>
                                            <span class="label label-danger" ng-show="GastoForm.pago.$error.required">* Campo requerido.</span>
                                            <span class="label label-danger" ng-show="GastoForm.pago.$error.number">* Solo números.</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P2. Moneda de compra del paquete turístico o excursión-->
                                    <label for="selectDivisa" class="col-md-12 control-label" style="color:dimgray;">Moneda de compra del paquete turístico o excursión</label>

                                    <div class="col-md-12">
                                        <select id="selectDivisa" class="form-control" ng-model="encuestaReceptor.DivisaPaquete" name="Divisa" ng-options="item.id as item.nombre for item in divisas" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                            <!-- P5P2Input1. Seleccione una moneda-->
                                            <option value="0" selected disabled>Seleccione una moneda</option>
                                        </select>
                                        <span ng-show="GastoForm.$submitted || GastoForm.Divisa.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.Divisa.$error.required">Campo requerido</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <!-- P5P3. ¿A cuántas personas cubrió?-->
                                    <label for="personas_cubiertas" class="col-md-12 control-label" style="color:dimgray;">¿A cuántas personas cubrió?</label>

                                    <div class="col-md-12">
                                        <input type="number" class="form-control" min="1" name="personas_cubiertas" ng-model="encuestaReceptor.PersonasCubrio" ng-required="encuestaReceptor.ViajoDepartamento==1" placeholder="Solo números">
                                        <span ng-show="GastoForm.$submitted || GastoForm.personas_cubiertas.$touched">
                                            <span class="label label-danger" ng-show="GastoForm.personas_cubiertas.$error.min">* El valor debe ser mayor a 0.</span>
                                            <span class="label label-danger" ng-show="GastoForm.personas_cubiertas.$error.required">* Campo requerido.</span>
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
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿El paquete/plan turístico incluyó municipios fuera del Atlántico?</b></h3>
                    </div>
                    <div class="panel-footer"><b>Pregunta con selección única</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="1" name="opt5" ng-model="encuestaReceptor.IncluyoOtros" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                        Si
                                    </label>
                                </div>
                                <div class="radio radio-primary">
                                    <label>
                                        <input type="radio" value="0" name="opt5" ng-change="limpiarMunicipios()" ng-model="encuestaReceptor.IncluyoOtros" ng-required="encuestaReceptor.ViajoDepartamento==1">
                                        No
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted || GastoForm.opt5.$touched">
                                    <span class="label label-danger" ng-show="GastoForm.opt5.$error.required">Campo requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-show="encuestaReceptor.IncluyoOtros==1">
                    <div class="panel-heading">
                        <!-- ¿Qué otras ciudades/municipios fuera del Magdalena incluyó el paquete/plan turístico?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué otras ciudades/municipios fuera del Atlántico incluyó el paquete/plan turístico?</b></h3>
                    </div>
                    <div class="panel-footer"><b>Presione aquí para desplegar las opciones</b></div>
                    <div class="panel-body">
                        <div class="row">
                            
                            <div class="form-group">
                                <label class="control-label" for="municipios">Municipios</label>
                                    <ui-select multiple  id="municipios"  name="municipios" ng-model="encuestaReceptor.Municipios"  ng-required="encuestaReceptor.IncluyoOtros == 1">
                                       <ui-select-match placeholder="Seleccione municipios (multiple)">@{{$item.nombre}}</ui-select-match>
                                       <ui-select-choices repeat="item.id as item in municipios | filter:$select.search">
                                           @{{item.nombre}}
                                       </ui-select-choices>
                                   </ui-select>
                            </div>
                                <span ng-show="GastoForm.$submitted">
                                        <span class="label label-danger" ng-show="(encuestaReceptor.Municipios.length == 0 ||  encuestaReceptor.Municipios == null) && encuestaReceptor.IncluyoOtros==1">Campo requerido</span>
                                </span>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <!-- P6. El paquete/plan turístico o excursión fue comprado a:-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> El paquete/plan turístico o excursión fue comprado a</b></h3>
                    </div>
                    <div class="panel-footer"><b>Pregunta con selección única</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary" ng-repeat="prov in tipos">
                                    <label>
                                        <input type="radio" id="radio-@{{prov.id}}" value="@{{prov.id}}" ng-change="limpiarLocalizacion()" name="proveedor" ng-model="encuestaReceptor.Proveedor" ng-required="encuestaReceptor.ViajoDepartamento==1" >
                                        @{{prov.nombre}}
                                    </label>
                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="GastoForm.proveedor.$error.required">Campo requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-success" ng-show="encuestaReceptor.Proveedor==1">
                    <div class="panel-heading">
                        <!-- P7. ¿En donde está ubicada la agencia de viajes/operador turístico?-->
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿En donde está ubicada la agencia de viajes/operador turístico?</b></h3>
                    </div>
                    <div class="panel-footer"><b>Pregunta con selección única</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="radio radio-primary" ng-repeat="opc in opciones">
                                    <label>
                                        <input type="radio" id="radio-opt-@{{opc.id}}" value="@{{opc.id}}" name="lugar" ng-model="encuestaReceptor.LugarAgencia" ng-required="encuestaReceptor.Proveedor==1" >
                                        @{{opc.nombre}}
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
                        <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Qué productos y servicios incluía el paquete turístico o excursión?</b></h3>
                    </div>
                    <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox" ng-repeat="servicio in servicios">
                                    <label>
                                        <input type="checkbox" checklist-model="encuestaReceptor.ServiciosIncluidos" checklist-value="servicio.id"> @{{servicio.nombre}}
                                    </label>

                                </div>
                                <span ng-show="GastoForm.$submitted">
                                    <span class="label label-danger" ng-show="(encuestaReceptor.ServiciosIncluidos.length == 0 ||  encuestaReceptor.ServiciosIncluidos == null) && encuestaReceptor.ViajoDepartamento==1">Campo requerido</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <!--P8A. ¿Desea proporcionar información adicional de sus gastos?-->
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Desea proporcionar información adicional de sus gastos</b></h3>
                </div>
                <div class="panel-footer"><b>Pregunta con selección única</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gatsi" value="1" name="opt6" ng-model="encuestaReceptor.GastosAparte" ng-required="encuestaReceptor.RealizoGasto==1">
                                    Si
                                </label>
                            </div>
                            <div class="radio radio-primary">
                                <label>
                                    <input type="radio" id="gastno" value="0" name="opt6" ng-model="encuestaReceptor.GastosAparte" ng-required="encuestaReceptor.RealizoGasto==1" />
                                    No
                                </label>
                            </div>
                            <span ng-show="GastoForm.$submitted || GastoForm.opt6.$touched">
                                <span class="label label-danger" ng-show="GastoForm.opt6.$error.required">Campo requerido</span>
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
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>Indique los gastos totales hechos por usted, para usted o su grupo de viaje. No coloque gastos induviduale</b></h3>
                </div>
                <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover" style="min-height: 500px;">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <!--P9Col1. Rubro-->
                                            <th class="text-center" style="width:20%;">Rubro</th>
                                            <!--P9Col2. Cantidad pagada-->
                                            <th class="text-center" style="width:55%;">Cantidad pagada</th>
                                            <!--P9Col3. ¿A cuántas personas cubrió?-->
                                            <th class="text-center" style="width:10%;">¿A cuántas personas cubrió?</th>
                                            <!--P9Col4. Fue pagado por otra persona u organización/ empresa diferente a usted o a su grupo de viaje -->
                                            <th class="text-center" style="width:15%;">Fue pagado por otra persona u organización/ empresa diferente a usted o a su grupo de viaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="rub in rubros">
                                            
                                            <td style="width:20%;">@{{rub.rubros_con_idiomas[0].nombre}}</td>
                                            <td style="width:55%;">
                                                <div class="row">
                                                    <!--<div class="col-xs-12 col-md-6">
                                                        
                                                        <h5 style="margin-bottom: 0;"><b>Fuera del Atlántico</b></h5>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                   
                                                                    <label for="gastoFuera" class="col-md-12 control-label" style="color:dimgray;">Cantidad</label>

                                                                    <div class="col-md-12">
                                                                        <input type="number" class="form-control" name="cantFuera@{{$index}}" placeholder="0" min="1" ng-model="rub.gastos_visitantes[0].cantidad_pagada_fuera" ng-required="rub.gastos_visitantes[0].divisas_fuera != null || rub.gastos_visitantes[0].personas_cubiertas != null && rub.gastos_visitantes[0].cantidad_pagada_magdalena == null ">
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.cantFuera@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="GastoForm.cantFuera@{{$index}}.$error.min">*El valor debe ser mayor a 0</span>
                                                                            <span class="label label-danger" ng-show="GastoForm.cantFuera@{{$index}}.$error.number">* Solo números.</span>
                                                                            <span class="label label-danger" ng-show="GastoForm.cantFuera@{{$index}}.$error.required">* Campo requerido.</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    
                                                                    <label for="selecDivisa2" class="col-md-2 control-label" style="color:dimgray;">Divisa</label>

                                                                    <div class="col-md-10">
                                                                        <select id="selectDivisa2" class="form-control" name="divisaFuera@{{$index}}" ng-options ="item.id as item.nombre for item in divisas" ng-required="rub.gastos_visitantes[0].cantidad_pagada_fuera != null || rub.gastos_visitantes[0].personas_cubiertas != null && rub.gastos_visitantes[0].cantidad_pagada_magdalena == null" ng-model="rub.gastos_visitantes[0].divisas_fuera">
                                                                           
                                                                            <option value="">Seleccionar divisa</option>
                                                                          
                                                                        </select>
                                                                        <span ng-show="GastoForm.$submitted || GastoForm.divisaFuera@{{$index}}.$touched">
                                                                            <span class="label label-danger" ng-show="GastoForm.divisaFuera@{{$index}}.$error.required">* Campo requerido.</span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    <div class="col-xs-12 col-md-12">
                                                        <!--P9Col2Title2. En el Magdalena-->
                                                        
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="gastoFuera" class="control-label" style="color:dimgray;">Cantidad</label>
                                                                    <input type="number" class="form-control" name="cantDentro@{{$index}}" min="1" placeholder="Cantidad" ng-blur="cambiarAlquiler(rub)" ng-model="rub.gastos_visitantes[0].cantidad_pagada_magdalena" ng-required ="rub.gastos_visitantes[0].divisas_magdalena != null || rub.gastos_visitantes[0].personas_cubiertas != null" >
                                                                    <span ng-show="GastoForm.$submitted || GastoForm.cantDentro@{{$index}}.$touched">
                                                                        <span class="label label-danger" ng-show="GastoForm.cantDentro@{{$index}}.$error.min">*El valor debe ser mayor a 0</span>
                                                                        <span class="label label-danger" ng-show="GastoForm.cantDentro@{{$index}}.$error.number">* Solo números.</span>
                                                                        <span class="label label-danger" ng-show="GastoForm.cantDentro@{{$index}}.$error.required">* Campo requerido.</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="selectDivisa" class="control-label" style="color:dimgray;">Divisa</label>
                                                                    <select id="selectDivisa3" class="form-control" name="divisaDentro@{{$index}}" ng-blur="cambiarAlquiler(rub)" ng-options ="item.id as item.nombre for item in divisas" ng-model="rub.gastos_visitantes[0].divisas_magdalena" ng-required="rub.gastos_visitantes[0].cantidad_pagada_magdalena != null || rub.gastos_visitantes[0].personas_cubiertas != null">
                                                                        <option value="">Seleccionar divisa</option>
                                                                    </select>
                                                                    <span ng-show="GastoForm.$submitted || GastoForm.divisaDentro@{{$index}}.$touched">
                                                                       <span class="label label-danger" ng-show="GastoForm.divisaDentro@{{$index}}.$error.required">* Campo requerido.</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:10%;">
                                                <label class="control-label">&nbsp;</label>
                                                <input type="number" min="1" class="form-control" name="personas@{{$index}}" ng-model="rub.gastos_visitantes[0].personas_cubiertas" ng-blur="cambiarAlquiler(rub)" placeholder="0" ng-required="rub.gastos_visitantes[0].cantidad_pagada_magdalena != null || rub.gastos_visitantes[0].divisas_magdalena != null"/>
                                                <span ng-show="GastoForm.$submitted || GastoForm.personas@{{$index}}.$touched">
                                                    <span class="label label-danger" ng-show="GastoForm.personas@{{$index}}.$error.number">* Solo números.</span>
                                                    <span class="label label-danger" ng-show="GastoForm.personas@{{$index}}.$error.min">* El valor debe ser mayor a 0.</span>
                                                    <span class="label label-danger" ng-show="GastoForm.personas@{{$index}}.$error.required">* Campo requerido.</span>
                                                </span>
                                                
                                            </td>
                                            <td style="width:15%;">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="asumido@{{$index}}"  ng-model="rub.gastos_visitantes[0].gastos_asumidos_otros" value="true"> Si
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
        
        <div class="panel panel-success" ng-show="abrirTerrestre">
            <div class="panel-heading">
                <!-- ¿Cuál es el nombre de la empresa de transporte terrestre de pasajeros utilizado desde una ciudad de Colombia al Magdalena?-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> ¿Cuál es el nombre de la empresa de transporte terrestre de pasajeros utilizado desde una ciudad de Colombia al Atlántico?</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="empresa" ng-minlength="1" ng-maxlength="150" class="form-control" ng-model="encuestaReceptor.Empresa" ng-required="abrirTerrestre" placeholder="Presione aquí para ingresar la empresa de transporte"/>
                    </div>
                </div>
                <span  ng-show="GastoForm.$submitted || GastoForm.empresa.$touched">
                    <span class="label label-danger" ng-show="GastoForm.empresa.$error.maxlength">* El campo no debe superar los 150 caracteres.</span>
                    <span class="label label-danger" ng-show="GastoForm.empresa.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>
        
        <div class="panel panel-success" ng-show="abrirAlquiler">
            <div class="panel-heading">
                <!-- >El alquiler de vehículo fue realizado en:-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> El alquiler de vehículo fue realizado en</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in opciones">
                            <label ng-show="item.id != 3">
                                <input type="radio" name="alquiler" ng-value="item.id" ng-model="encuestaReceptor.Alquiler" ng-required="abrirAlquiler"> @{{item.nombre}}
                            </label>

                        </div>
                    </div>
                </div>
                <span  ng-show="GastoForm.$submitted || GastoForm.alquiler.$touched">
                    <span class="label label-danger" ng-show="GastoForm.alquiler.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success" ng-show="abrirRopa">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> En dónde fue realizado el mayor gasto de productos como ropa, calzado,  artesanías etc. (bienes duraderos) antes y durante el viaje a Atlántico : Respuesta única</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta con selección única</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="radio" ng-repeat="item in opciones">
                            <label>
                                <input type="radio" name="ropa" ng-value="item.id" ng-model="encuestaReceptor.Ropa" ng-required="abrirRopa"> @{{item.nombre}}
                            </label>

                        </div>
                    </div>
                </div>
                <span  ng-show="GastoForm.$submitted || GastoForm.ropa.$touched">
                    <span class="label label-danger" ng-show="GastoForm.ropa.$error.required">* El campo es requerido.</span>
                </span>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <!-- P10. Los gastos de las personas que conformaron el grupo de viaje fueron pagados por:-->
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span>  Los gastos de las personas que conformaron el grupo de viaje fueron pagados por:</b></h3>
            </div>
            <div class="panel-footer"><b>Pregunta de selección múltiple</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox" ng-repeat="fin in financiadores" ng-show="!(encuestaReceptor.RealizoGasto==0 && fin.id==1)">
                            <label>
                                <input type="checkbox" checklist-model="encuestaReceptor.Financiadores" name ="Financiadores" checklist-value="fin.id" > @{{fin.nombre}}
                            </label>
                            
                        </div>
                        <span ng-show="GastoForm.$submitted || GastoForm.Financiadores.$touched">
                            <span class="label label-danger" ng-show="encuestaReceptor.Financiadores.length == 0 ||  encuestaReceptor.Financiadores == null">Campo requerido</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <a href="/turismoreceptor/secciongrupoviaje/{{$id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
</div>
@endsection

@section('javascript')
    // <script>
    //     $(window).on('scroll', function () {
            
    //         if ($('#tgastos').length && $(this).width() > 992) {
    //             if ($(this).scrollTop() > $('#tgastos').offset().top && $(this).scrollTop() < ($('#tgastos').offset().top + $('#tgastos').height())) {
    //                 $('#head-tgastos').width($('#tgastos').width());
    //                 $('#head-tgastos').addClass('thead-fixed');
    //             } else {
    //                 $('#head-tgastos').removeClass('thead-fixed');
    //             }
    //         } else {
    //             $('#head-tgastos').css('width', 'auto');
    //             $('#head-tgastos').removeClass('thead-fixed');
    //         }
            

    //     });
    //     $(window).on('resize', function () {
    //         if ($('#tgastos').length && $(this).width() > 992) {
    //             if ($(this).scrollTop() > $('#tgastos').offset().top && $(this).scrollTop() < ($('#tgastos').offset().top + $('#tgastos').height())) {
    //                 $('#head-tgastos').width($('#tgastos').width());

    //             }
    //         } else {
    //             $('#head-tgastos').css('width', 'auto');
    //             $('#head-tgastos').removeClass('thead-fixed');
    //         }
            
    //     })
    // </script>
@endsection


