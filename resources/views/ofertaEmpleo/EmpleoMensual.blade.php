 @extends('layout._ofertaEmpleoLayaout')

@section('Title','Empleo Mensual :: SITUR Magdalena')


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
@section('TitleSection','Empleo Mensual')
@section('Progreso','80%')
@section('NumSeccion','80%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="empleoMensual"')

@section('content')

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
    
    <form role="form" name="empleoForm" novalidate>

        <div class="numEmpleados">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Empleados </b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteTabla</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <th class="text-center" colspan="4" rowspan="2" >Pregunta \ empleados nivel</th>
                                            <th class="text-center" colspan="2" > 
                                                 Directivos 
                                            </th>
                                                <th class="text-center" colspan="2" > 
                                                 Mandos medios
                                            </th>
                                                <th class="text-center" colspan="2" > 
                                                 Operativo
                                            </th>
                                            <th class="text-center" rowspan="2" >Total</th>
                                         
                                        </tr>
                                        <tr>
                                            <th>M</th> <th>F</th>
                                            <th>M</th> <th>F</th>
                                            <th>M</th> <th>F</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                            <td colspan="4" >
                                                ¿Cuántos trabajadores hay por nivel y género?
                                            </td>
                                             <td>
                                                <input type="number" min="0" class="form-control" name="sexo" ng-model="cargo(1).hombres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="sexof" ng-model="cargo(1).mujeres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="sexo2" ng-model="cargo(2).hombres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexo2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="sexo2f" ng-model="cargo(2).mujeres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexo2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="sexo3" ng-model="cargo(3).hombres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexo3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="sexo3f" ng-model="cargo(3).mujeres" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sexo3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sexo3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                            <td style="text-align: right"><strong>@{{Totalcargo()}}</strong></td>
                                        </tr>
                                        
                                    <tr>
                                            <td colspan="3"  rowspan="5" >
                                                ¿por favor clasifique sus empleados en el siguiente rango de edad?
                                            </td>
                                              <td >
                                                   1. Menores de 20 años 
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="docea18" ng-model="edadempleado(1,1).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea18.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea18.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea18.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea18.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="docea18f" ng-model="edadempleado(1,0).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea18f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea18f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea18f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea18f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="docea182" ng-model="edadempleado(2,1).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea182.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea182.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea182.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea182.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="docea182f" ng-model="edadempleado(2,0).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea182f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea182f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea182f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea182f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="docea183" ng-model="edadempleado(3,1).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea183.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea183.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea183.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea183.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="docea183f" ng-model="edadempleado(3,0).docea18" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.docea183f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.docea183f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea183f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.docea183f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                               
                                            
                                            <td style="text-align: right"><strong>@{{Total('Edad','docea18')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                  2. 21-30 años 
                                            </td>
                                          <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea25" ng-model="edadempleado(1,1).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea25.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea25f" ng-model="edadempleado(1,0).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea25f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea25f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea252" ng-model="edadempleado(2,1).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea252.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea252f" ng-model="edadempleado(2,0).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea252f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea252f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea253" ng-model="edadempleado(3,1).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea253.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="diecinuevea253f" ng-model="edadempleado(3,0).diecinuevea25" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.diecinuevea253f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.diecinuevea253f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                            
                                            
                                            <td style="text-align: right"><strong>@{{Total('Edad','diecinuevea25')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                 3. 31-40 años 
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa40" ng-model="edadempleado(1,1).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa40.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa40f" ng-model="edadempleado(1,0).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa40f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa40f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa402" ng-model="edadempleado(2,1).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa402.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa402f" ng-model="edadempleado(2,0).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa402f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa402f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa403" ng-model="edadempleado(3,1).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa403.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="ventiseisa403f" ng-model="edadempleado(3,0).ventiseisa40" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ventiseisa403f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ventiseisa403f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                            
                                            
                                            <td style="text-align: right"><strong>@{{Total('Edad','ventiseisa40')}}</strong></td>
                                        </tr>
                                    <tr>
                                         <td>
                                              4. 41-50 años 
                                        </td>
                                         <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa64" ng-model="edadempleado(1,1).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa64.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa64f" ng-model="edadempleado(1,0).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa64f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa64f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa642" ng-model="edadempleado(2,1).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa642.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa642f" ng-model="edadempleado(2,0).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa642f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa642f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa643" ng-model="edadempleado(3,1).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa643.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="cuarentayunoa643f" ng-model="edadempleado(3,0).cuarentayunoa64" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuarentayunoa643f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuarentayunoa643f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                        
                                        <td style="text-align: right"><strong>@{{Total('Edad','cuarentayunoa64')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                             5. Mayores de 50 años 
                                        </td>
                                        <td>
                                                <input type="number" min="0" class="form-control" name="mas65" ng-model="edadempleado(1,1).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas65.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas65.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas65.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas65.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="mas65f" ng-model="edadempleado(1,0).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas65f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas65f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas65f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas65f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="mas652" ng-model="edadempleado(2,1).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas652.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas652.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas652.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas652.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="mas652f" ng-model="edadempleado(2,0).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas652f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas652f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas652f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas652f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="mas653" ng-model="edadempleado(3,1).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas653.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas653.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas653.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas653.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="mas653f" ng-model="edadempleado(3,0).mas65" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.mas653f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.mas653f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas653f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.mas653f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                        
                                        <td style="text-align: right"><strong>@{{Total('Edad','mas65')}}</strong></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                            <td colspan="3"  rowspan="6" >
                                                El título educativo más alto alcanzado por cada nivel es:
                                            </td>
                                              <td >
                                                   1. Ninguno 
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ninguno" ng-model="eduacionempleado(1,1).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ninguno.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ningunof" ng-model="eduacionempleado(1,0).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ningunof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ningunof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ningunof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ningunof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="ninguno2" ng-model="eduacionempleado(2,1).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ninguno2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="ninguno2f" ng-model="eduacionempleado(2,0).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ninguno2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="ninguno3" ng-model="eduacionempleado(3,1).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ninguno3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="ninguno3f" ng-model="eduacionempleado(3,0).ninguno" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.ninguno3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.ninguno3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                            
                                            <td style="text-align: right"><strong>@{{Total('Edad','ventiseisa40')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                 2. Bachiller
                                            </td>
                                       <td>
                                                <input type="number" min="0" class="form-control" name="bachiller" ng-model="eduacionempleado(1,1).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachiller.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="bachillerf" ng-model="eduacionempleado(1,0).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachillerf.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachillerf.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachillerf.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachillerf.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="bachiller2" ng-model="eduacionempleado(2,1).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachiller2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="bachiller2f" ng-model="eduacionempleado(2,0).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachiller2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="bachiller3" ng-model="eduacionempleado(3,1).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachiller3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="bachiller3f" ng-model="eduacionempleado(3,0).bachiller" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.bachiller3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.bachiller3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                                                        
                                            <td style="text-align: right"><strong>@{{Total('Educacion','bachiller')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                3. Técnico 
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="tecnico" ng-model="eduacionempleado(1,1).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnico.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="tecnicof" ng-model="eduacionempleado(1,0).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnicof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnicof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnicof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnicof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="tecnico2" ng-model="eduacionempleado(2,1).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnico2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="tecnico2f" ng-model="eduacionempleado(2,0).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnico2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="tecnico3" ng-model="eduacionempleado(3,1).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnico3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="tecnico3f" ng-model="eduacionempleado(3,0).tecnico" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnico3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnico3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                                                        
                                            <td style="text-align: right"><strong>@{{Total('Educacion','tecnico')}}</strong></td>
                                        </tr>
                                    <tr>
                                         <td>
                                              4. Tecnológico 
                                        </td>
                                         <td>
                                                <input type="number" min="0" class="form-control" name="tecnologo" ng-model="eduacionempleado(1,1).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="tecnologof" ng-model="eduacionempleado(1,0).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="tecnologo2" ng-model="eduacionempleado(2,1).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologo2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="tecnologo2f" ng-model="eduacionempleado(2,0).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologo2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="tecnologo3" ng-model="eduacionempleado(3,1).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologo3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="tecnologo3f" ng-model="eduacionempleado(3,0).tecnologo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.tecnologo3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.tecnologo3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                                                    
                                        <td style="text-align: right"><strong>@{{Total('Educacion','tecnologo')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                            5. Universitario 
                                        </td>
                                       <td>
                                                <input type="number" min="0" class="form-control" name="universitario" ng-model="eduacionempleado(1,1).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitario.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitario.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="universitariof" ng-model="eduacionempleado(1,0).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitariof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitariof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitariof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitariof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="universitario2" ng-model="eduacionempleado(2,1).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitario2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="universitario2f" ng-model="eduacionempleado(2,0).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitario2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="universitario3" ng-model="eduacionempleado(3,1).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitario3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="universitario3f" ng-model="eduacionempleado(3,0).universitario" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.universitario3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.universitario3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                        <td style="text-align: right"><strong>@{{Total('Educacion','universitario')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                           6. Posgrado  (Especialización, maestría, doctorado)
                                        </td>
                                        <td>
                                                <input type="number" min="0" class="form-control" name="posgrado" ng-model="eduacionempleado(1,1).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgrado.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="posgradof" ng-model="eduacionempleado(1,0).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgradof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgradof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgradof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgradof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="posgrado2" ng-model="eduacionempleado(2,1).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgrado2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="posgrado2f" ng-model="eduacionempleado(2,0).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgrado2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="posgrado3" ng-model="eduacionempleado(3,1).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgrado3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="posgrado3f" ng-model="eduacionempleado(3,0).posgrado" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.posgrado3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.posgrado3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                        
                                        <td style="text-align: right"><strong>@{{Total('Educacion','posgrado')}}</strong></td>
                                    </tr>
                                    
                                    <tr>
                                            <td colspan="4" >
                                                ¿Cuántos empleados dominan como segundo idioma el inglés?
                                            </td>
                                             <td>
                                                <input type="number" min="0" class="form-control" name="sabeningles" ng-model="ingleempleado(1,1).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeningles.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="sabeninglesf" ng-model="ingleempleado(1,0).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeninglesf.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeninglesf.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeninglesf.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeninglesf.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="sabeningles2" ng-model="ingleempleado(2,1).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeningles2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="sabeningles2f" ng-model="ingleempleado(2,0).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeningles2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="sabeningles3" ng-model="ingleempleado(3,1).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeningles3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="sabeningles3f" ng-model="ingleempleado(3,0).sabeningles" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.sabeningles3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.sabeningles3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                            <td style="text-align: right"><strong>@{{Total('ingles','sabeningles')}}</strong></td>
                                        </tr>
                                        
                                        
                                    <tr>
                                            <td colspan="3"  rowspan="7" >
                                               ¿Cuántos trabajadores se encuentran vinculados cómo?
                                            </td>
                                              <td >
                                                   1. Personal temporal contratado directamente  
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="contrato_direto" ng-model="vinculacionempleado(1,1).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_direto.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="contrato_diretof" ng-model="vinculacionempleado(1,0).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_diretof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_diretof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_diretof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_diretof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="contrato_direto2" ng-model="vinculacionempleado(2,1).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_direto2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="contrato_direto2f" ng-model="vinculacionempleado(2,0).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_direto2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="contrato_direto3" ng-model="vinculacionempleado(3,1).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_direto3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="contrato_direto3f" ng-model="vinculacionempleado(3,0).contrato_direto" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.contrato_direto3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.contrato_direto3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>                                            
                                            <td style="text-align: right"><strong>@{{Total('Vinculacion','contrato_direto')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                 2. Personal temporal contratado a través de agencia  
                                            </td>
                                      <td>
                                            <input type="number" min="0" class="form-control" name="personal_agencia" ng-model="vinculacionempleado(1,1).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agencia.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="personal_agenciaf" ng-model="vinculacionempleado(1,0).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agenciaf.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agenciaf.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agenciaf.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agenciaf.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="personal_agencia2" ng-model="vinculacionempleado(2,1).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agencia2.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                               <td>
                                            <input type="number" min="0" class="form-control" name="personal_agencia2f" ng-model="vinculacionempleado(2,0).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agencia2f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia2f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="personal_agencia3" ng-model="vinculacionempleado(3,1).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agencia3.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="personal_agencia3f" ng-model="vinculacionempleado(3,0).personal_agencia" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.personal_agencia3f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.personal_agencia3f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                                                            
                                            <td style="text-align: right"><strong>@{{Total('Vinculacion','personal_agencia')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                3. Personal permanente 
                                            </td>
                                            <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanente" ng-model="vinculacionempleado(1,1).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanente.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanentef" ng-model="vinculacionempleado(1,0).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanentef.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanentef.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanentef.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanentef.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanente2" ng-model="vinculacionempleado(2,1).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanente2.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                                       <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanente2f" ng-model="vinculacionempleado(2,0).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanente2f.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2f.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2f.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente2f.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                                
                                               <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanente3" ng-model="vinculacionempleado(3,1).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanente3.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                                
                                               <td>
                                                    <input type="number" min="0" class="form-control" name="personal_permanente3f" ng-model="vinculacionempleado(3,0).personal_permanente" placeholder="0" ng-required="true"/>
                                                    <span ng-show="empleoForm.$submitted || empleoForm.personal_permanente3f.$touched">
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3f.$error.required">*Es requerido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3f.$error.number">*Formato no válido</span>
                                                        <span class="label label-danger" ng-show="empleoForm.personal_permanente3f.$error.min">*Números mayores a 0</span>
                                                    </span>
                                                </td>
                                            
                                            <td style="text-align: right"><strong>@{{Total('Vinculacion','personal_permanente')}}</strong></td>
                                        </tr>
                                    <tr>
                                         <td>
                                             4. Trabajador familiar  
                                        </td>
                                       <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiar" ng-model="vinculacionempleado(1,1).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiar.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiarf" ng-model="vinculacionempleado(1,0).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiarf.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiarf.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiarf.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiarf.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiar2" ng-model="vinculacionempleado(2,1).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiar2.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                               <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiar2f" ng-model="vinculacionempleado(2,0).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiar2f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar2f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiar3" ng-model="vinculacionempleado(3,1).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiar3.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="trabajador_familiar3f" ng-model="vinculacionempleado(3,0).trabajador_familiar" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.trabajador_familiar3f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.trabajador_familiar3f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                    
                                        
                                        <td style="text-align: right"><strong>@{{Total('Vinculacion','trabajador_familiar')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                           5. Propietario/Socio  
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="propietario" ng-model="vinculacionempleado(1,1).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietario.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietario.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="propietariof" ng-model="vinculacionempleado(1,0).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietariof.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietariof.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietariof.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietariof.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="propietario2" ng-model="vinculacionempleado(2,1).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietario2.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietario2.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario2.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario2.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                               <td>
                                            <input type="number" min="0" class="form-control" name="propietario2f" ng-model="vinculacionempleado(2,0).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietario2f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietario2f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario2f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario2f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="propietario3" ng-model="vinculacionempleado(3,1).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietario3.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietario3.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario3.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario3.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="propietario3f" ng-model="vinculacionempleado(3,0).propietario" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.propietario3f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.propietario3f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario3f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.propietario3f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
            
                                        <td style="text-align: right"><strong>@{{Total('Vinculacion','propietario')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                          6. Aprendiz o estudiante por convenio 
                                        </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="aprendiz" ng-model="vinculacionempleado(1,1).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendiz.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="aprendizf" ng-model="vinculacionempleado(1,0).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendizf.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendizf.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendizf.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendizf.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="aprendiz2" ng-model="vinculacionempleado(2,1).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendiz2.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                           <td>
                                        <input type="number" min="0" class="form-control" name="aprendiz2f" ng-model="vinculacionempleado(2,0).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendiz2f.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2f.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2f.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz2f.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    
                                   <td>
                                        <input type="number" min="0" class="form-control" name="aprendiz3" ng-model="vinculacionempleado(3,1).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendiz3.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    
                                   <td>
                                        <input type="number" min="0" class="form-control" name="aprendiz3f" ng-model="vinculacionempleado(3,0).aprendiz" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.aprendiz3f.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3f.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3f.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.aprendiz3f.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                                                            
                                        <td style="text-align: right"><strong>@{{Total('Vinculacion','aprendiz')}}</strong></td>
                                    </tr>
                                    <tr>
                                         <td>
                                          7. Trabajador por cuenta propia
                                        </td>
                                        <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propia" ng-model="vinculacionempleado(1,1).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propia.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propiaf" ng-model="vinculacionempleado(1,0).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propiaf.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propiaf.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propiaf.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propiaf.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propia2" ng-model="vinculacionempleado(2,1).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propia2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propia2f" ng-model="vinculacionempleado(2,0).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propia2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propia3" ng-model="vinculacionempleado(3,1).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propia3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="cuenta_propia3f" ng-model="vinculacionempleado(3,0).cuenta_propia" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.cuenta_propia3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.cuenta_propia3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                    
                                        <td style="text-align: right"><strong>@{{Total('Vinculacion','cuenta_propia')}}</strong></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                            <td colspan="3"  rowspan="2" >
                                               ¿Cuántos trabajadores tienen jornada laboral?
                                            </td>
                                              <td >
                                                  Completo
                                            </td>
                                   <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completo" ng-model="tiempoempleado(1,1).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completo.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completof" ng-model="tiempoempleado(1,0).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completof.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completof.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completof.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completof.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completo2" ng-model="tiempoempleado(2,1).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completo2.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                           <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completo2f" ng-model="tiempoempleado(2,0).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completo2f.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2f.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2f.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo2f.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    
                                   <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completo3" ng-model="tiempoempleado(3,1).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completo3.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                    
                                   <td>
                                        <input type="number" min="0" class="form-control" name="tiempo_completo3f" ng-model="tiempoempleado(3,0).tiempo_completo" placeholder="0" ng-required="true"/>
                                        <span ng-show="empleoForm.$submitted || empleoForm.tiempo_completo3f.$touched">
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3f.$error.required">*Es requerido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3f.$error.number">*Formato no válido</span>
                                            <span class="label label-danger" ng-show="empleoForm.tiempo_completo3f.$error.min">*Números mayores a 0</span>
                                        </span>
                                    </td>
                                               
                                            <td style="text-align: right"><strong>@{{Total('Empleo','tiempo_completo')}}</strong></td>
                                        </tr>
                                    <tr>
                                             <td>
                                                  Tiempo parcial
                                            </td>
                                        <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempo" ng-model="tiempoempleado(1,1).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempof" ng-model="tiempoempleado(1,0).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempof.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempof.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempof.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempof.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempo2" ng-model="tiempoempleado(2,1).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempo2.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                   <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempo2f" ng-model="tiempoempleado(2,0).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempo2f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo2f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempo3" ng-model="tiempoempleado(3,1).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempo3.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            
                                           <td>
                                                <input type="number" min="0" class="form-control" name="medio_tiempo3f" ng-model="tiempoempleado(3,0).medio_tiempo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.medio_tiempo3f.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3f.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3f.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.medio_tiempo3f.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                                        
                                            <td style="text-align: right"><strong>@{{Total('Empleo','medio_tiempo')}}</strong></td>
                                        </tr>
                                    
                                    
                                    <tr>
                                            <td colspan="4" >
                                                Remuneración promedio
                                            </td>
                                     <td>
                                            <input type="number" min="0" class="form-control" name="valor" ng-model="remuneracion(1,1).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valor.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valor.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="valorf" ng-model="remuneracion(1,0).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valorf.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valorf.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valorf.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valorf.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        <td>
                                            <input type="number" min="0" class="form-control" name="valor2" ng-model="remuneracion(2,1).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valor2.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valor2.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor2.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor2.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                               <td>
                                            <input type="number" min="0" class="form-control" name="valor2f" ng-model="remuneracion(2,0).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valor2f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valor2f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor2f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor2f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="valor3" ng-model="remuneracion(3,1).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valor3.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valor3.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor3.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor3.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                        
                                       <td>
                                            <input type="number" min="0" class="form-control" name="valor3f" ng-model="remuneracion(3,0).valor" placeholder="0" ng-required="true"/>
                                            <span ng-show="empleoForm.$submitted || empleoForm.valor3f.$touched">
                                                <span class="label label-danger" ng-show="empleoForm.valor3f.$error.required">*Es requerido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor3f.$error.number">*Formato no válido</span>
                                                <span class="label label-danger" ng-show="empleoForm.valor3f.$error.min">*Números mayores a 0</span>
                                            </span>
                                        </td>
                                            
                                            <td style="text-align: right"><strong></strong></td>
                                        </tr>
                                    
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="numVacantes">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Número de vacantes </b></h3>
                </div>
                <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <th class="text-center">Operativo</th>
                                            <th class="text-center">Administrativo</th>
                                            <th class="text-center">Gerencial</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="VacanteOperativo" ng-model="empleo.VacanteOperativo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.VacanteOperativo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="VacanteAdministrativo" ng-model="empleo.VacanteAdministrativo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.VacanteAdministrativo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteAdministrativo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteAdministrativo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteAdministrativo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="VacanteGerencial" ng-model="empleo.VacanteGerencial" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.VacanteGerencial.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td style="text-align: right"><strong> @{{empleo.VacanteOperativo+empleo.VacanteAdministrativo+empleo.VacanteGerencial}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
         <div class="razonVacantes">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Número de vacantes </b></h3>
                </div>
                <div class="panel-footer"><b>De las vacantes mencionadas anteriormente, cuantas fueron por la siguiente razón</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <th class="text-center">Apertura de nueva sucursal(es) o ampliación de las actuales</th>
                                            <th class="text-center">Crecimiento en ventas de la empresa </th>
                                            <th class="text-center">Reemplazo de empleado</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="apertura" ng-model="empleo.Razon.apertura" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.apertura.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.apertura.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.apertura.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.apertura.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="crecimiento" ng-model="empleo.Razon.crecimiento" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.crecimiento.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.crecimiento.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.crecimiento.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.crecimiento.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td>
                                                <input type="number" min="0" class="form-control" name="remplazo" ng-model="empleo.Razon.remplazo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.remplazo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.remplazo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.remplazo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.remplazo.$error.min">*Números mayores a 0</span>
                                                </span>
                                            </td>
                                            <td style="text-align: right"><strong> @{{empleo.Razon.apertura+empleo.Razon.crecimiento+empleo.Razon.remplazo}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        

        
        
        
        
        <div class="row" style="text-align:center">
            <a href="{{$ruta}}/{{$id}}" class="btn btn-raised btn-default" >@Resource.EncuestaBtnAnterior</a>
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
    @endsection
