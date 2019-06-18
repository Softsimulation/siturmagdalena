 @extends('layout._ofertaEmpleoLayaout')

@section('Title','Numero de empleados :: SITUR Magdalena')


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
            z-index: 60;
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
@section('TitleSection','Numero de empleados')
@section('Progreso','75%')
@section('NumSeccion','75%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="numeroEmpleados"')

@section('content')
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    <form name="empleoForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Número de empleados según el tipo de vinculación laboral</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Vinculación Laboral</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Personal temporal contratado directamente
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                           data-original-title="Corresponde a empleados contratados de forma verbal o escrita por un término fijo, para desarrollar labores específicas por una remuneración pactada. Se incluyen en este tipo de contratación los empleados contratados bajo la modalidad de destajo, jornal, obra, etc.">
                                        </i>

                                    </td>
                                    <td>
                                        <input class="form-control" type="number" id="Directo" name="Directo" ng-model="empleo.TemporalDirecto" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.TemporalDirecto.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.TemporalDirecto.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.TemporalDirecto.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Personal temporal contratado a través de Agencia
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                           data-original-title="Corresponde al personal eventual, sin vínculo laboral ni contractual, contratado con empresas especializadas en el suministro de personal por un término fijo.">
                                        </i>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" id="Temporal" name="Temporal" ng-model="empleo.TemporalAgencia" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.TemporalAgencia.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.TemporalAgencia.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.TemporalAgencia.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Personal permanente
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                           data-original-title="Personas contratadas para desempeñar labores por tiempo indefinido y que figuran en la nómina empresarial, para desarrollar labores relacionadas con la actividad principal de la empresa, exclusivamente, no obstante, se encuentre temporalmente ausente, como trabajadores con licencias remuneradas o en huelga.">
                                        </i>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" id="Permanente" name="Permanente" ng-model="empleo.Permanente" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Permanente.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Permanente.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Permanente.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aprendiz o estudiante por convenio
                                        <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""
                                           data-original-title="Empleados vinculados mediante contrato de aprendizaje, por tiempo definido, no mayor a dos años, y a quienes se les otorga una mensualidad, como apoyo de sostenimiento, que oscila entre 50% y 100% del salario mínimo, de acuerdo con el grado de formación en que se encuentre el aprendiz, en las diferentes modalidades educativas, universitaria, tecnológica o técnica.">
                                        </i>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" id="Aprendiz" name="Aprendiz" ng-model="empleo.Aprendiz" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Aprendiz.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Aprendiz.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Aprendiz.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <td><strong>@{{empleo.Aprendiz+empleo.Permanente+empleo.TemporalAgencia+empleo.TemporalDirecto}}</strong></td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Número de empleados según el rango de edad</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rango de edad</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>12 a 18 años</td>
                                    <td>
                                        <input class="form-control" value="0" type="number" id="Rango12" name="Rango12" ng-model="empleo.Rango12" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Rango12.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Rango12.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Rango12.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>19 a 25 años</td>
                                    <td>
                                        <input class="form-control" value="0" type="number" id="Rango19" name="Rango19" ng-model="empleo.Rango19" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Rango19.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Rango19.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Rango19.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>26 a 40 años</td>
                                    <td>
                                        <input class="form-control" value="0" type="number" id="Rango26" name="Rango26" ng-model="empleo.Rango26" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Rango26.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Rango26.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Rango26.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>41 a 64 años</td>
                                    <td>
                                        <input class="form-control" value="0" type="number" id="Rango41" name="Rango41" ng-model="empleo.Rango41" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Rango41.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Rango41.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Rango41.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>65 años y más</td>
                                    <td>
                                        <input class="form-control" value="0" type="number" id="Rango65" name="Rango65" ng-model="empleo.Rango65" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Rango65.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Rango65.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Rango65.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td>
                                        <strong>@{{empleo.Rango12+empleo.Rango19+empleo.Rango26+empleo.Rango41+empleo.Rango65}}</strong>
                                    </td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b>Género de los empleados</b></h3>
            </div>
            <div class="panel-footer"><b>Complete la siguiente tabla</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sexo</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hombres</td>
                                    <td>
                                        <input class="form-control" type="number" id="Hombre" name="Hombre" ng-model="empleo.Hombre" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Hombre.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Hombre.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Hombre.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mujeres</td>
                                    <td>
                                        <input class="form-control" type="number" id="Mujer" name="Mujer" ng-model="empleo.Mujer" ng-required="true" placeholder="Solo números">
                                        <span ng-show="empleoForm.$submitted || empleoForm.Mujer.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.Mujer.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.Mujer.$error.number">*Formato no válido</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><strong>@{{empleo.Hombre+empleo.Mujer}}</strong></td>
                                </tr>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="row" style="text-align:center">
            <a href="/EncuestaOfertaEmpleo/EmpleoMensual/@ViewBag.id" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

@endsection
