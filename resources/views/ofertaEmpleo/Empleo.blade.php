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
        .headTable, #fixedtableheader0{
            background-color: #eee;
        }
    </style>
@endsection
@section('TitleSection','Empleo Mensual')
@section('Progreso','80%')
@section('NumSeccion','80%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="empleo"')

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
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Hombres</th>
                                            <th class="text-center">Mujeres</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                             <tr>
                                                <td>Directivos tiempo completo</td>
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
                                
                                            <td style="text-align: right">@{{tiempoempleado(1,1).tiempo_completo + tiempoempleado(1,0).tiempo_completo }}</td>
                                          
                                            </tr>
                                             <tr>
                                                <td>Mandos medios tiempo completo</td>
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
                                               
                                            <td style="text-align: right">@{{tiempoempleado(2,1).tiempo_completo + tiempoempleado(2,0).tiempo_completo }}</td>
                                            </tr>
                                             <tr>
                                              <td>Operativo tiempo completo</td>
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
                                              <td style="text-align: right">@{{tiempoempleado(3,1).tiempo_completo + tiempoempleado(3,0).tiempo_completo }}</td>
                                            </tr>
                                            
                                             <tr>
                                                <td>Directivos medio tiempo</td>
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
                 
                                                <td style="text-align: right">@{{tiempoempleado(1,1).medio_tiempo + tiempoempleado(1,0).medio_tiempo }}</td>
                                          
                                            </tr>
                                             <tr>
                                                <td>Mandos medios medio tiempo</td>
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
                      
                                               
                                                <td style="text-align: right">@{{tiempoempleado(2,1).medio_tiempo + tiempoempleado(2,0).medio_tiempo }}</td>
                                            </tr>
                                             <tr>
                                                <td>Operativo medio tiempo</td>
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

                                     
                                            <td style="text-align: right">@{{tiempoempleado(3,1).medio_tiempo + tiempoempleado(3,0).medio_tiempo }}</td>
                                            </tr>
                                            <tr>
                                                <td >Total</td>
                                                <td style="text-align: right">@{{tiempoempleado(1,1).tiempo_completo + tiempoempleado(1,1).medio_tiempo + tiempoempleado(2,1).tiempo_completo + tiempoempleado(2,1).medio_tiempo + tiempoempleado(3,1).tiempo_completo + tiempoempleado(3,1).medio_tiempo}}</td>
                                                <td style="text-align: right">@{{tiempoempleado(1,0).tiempo_completo + tiempoempleado(1,0).medio_tiempo + tiempoempleado(2,0).tiempo_completo + tiempoempleado(2,0).medio_tiempo + tiempoempleado(3,0).tiempo_completo + tiempoempleado(3,0).medio_tiempo }}</td>
                                                <td style="text-align: right">@{{Total('Empleo','medio_tiempo')}}</td>
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
                <div class="panel-footer"><b>¿En el mes cuantas vacantes se generaron por cada nivel?</b></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="overflow-x: auto;">
                                <table id="tgastos" class="table table-condensed table-bordered table-hover">
                                    <thead id="head-tgastos">
                                        <tr>
                                            <th class="text-center">Directivos</th>
                                            <th class="text-center">Mandos medios</th>
                                            <th class="text-center">Operativo</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <td>
                                                <input type="number" min="0" class="form-control" name="VacanteGerencial" ng-model="empleo.VacanteGerencial" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.VacanteGerencial.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteGerencial.$error.min">*Números mayores a 0</span>
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
                                                <input type="number" min="0" class="form-control" name="VacanteOperativo" ng-model="empleo.VacanteOperativo" placeholder="0" ng-required="true"/>
                                                <span ng-show="empleoForm.$submitted || empleoForm.VacanteOperativo.$touched">
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.required">*Es requerido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.number">*Formato no válido</span>
                                                    <span class="label label-danger" ng-show="empleoForm.VacanteOperativo.$error.min">*Números mayores a 0</span>
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
        
         <div class="razonVacantes" ng-show="vacantesSi()">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Razón de vacantes </b></h3>
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
            
            <input type="submit" class="btn btn-raised btn-success" ng-click="guardar()" value="Siguiente" />
        </div>
        <br />
    </form>

    <div class='carga'>

    </div>
    @endsection

    @section('javascript')
    <script type="text/javascript" src="{{asset('/js/fixedtableheader.js')}}"></script>
    <script type="text/javascript"> 
    $(document).ready(function() { 
       $('#tablaEmpleo').fixedtableheader({ 
             headerrowsize:2,
             highlightclass: 'headTable' 
           });  
    }); 
    </script>
    @endsection