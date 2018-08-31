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
                                                <td>Directivos</td>
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
                                            <td style="text-align: right">@{{cargo(1).hombres + cargo(1).mujeres }}</td>
                                          
                                            </tr>
                                             <tr>
                                                <td>Mandos medios</td>
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
                                               
                                            <td style="text-align: right">@{{cargo(2).hombres + cargo(2).mujeres }}</td>
                                            </tr>
                                             <tr>
                                                <td>Operativo</td>
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
                        
                                     
                                            <td style="text-align: right">@{{cargo(3).hombres + cargo(3).mujeres }}</td>
                                            </tr>
                                            <tr>
                                                <td >Total</td>
                                                <td style="text-align: right">@{{cargo(1).hombres + cargo(2).hombres + cargo(3).hombres  }}</td>
                                                <td style="text-align: right">@{{cargo(1).mujeres + cargo(2).mujeres + cargo(3).mujeres }}</td>
                                                <td style="text-align: right">@{{cargo(1).hombres + cargo(2).hombres + cargo(3).hombres  + cargo(1).mujeres + cargo(2).mujeres + cargo(3).mujeres }}</td>
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