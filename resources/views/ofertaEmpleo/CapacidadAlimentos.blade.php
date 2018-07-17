
@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Capacidad de alimentos :: SITUR Magdalena')

@section('estilos')
    <style>
        .title-section {
            background-color: #4caf50 !important;
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

@section('TitleSection', 'Capacidad de alimentos')

@section('Progreso', '50%')

@section('NumSeccion', '50%')
@section('app','ng-app="ofertaempleo"')
@section('controller','ng-controller="capacidadAlimentosCtrl"')

@section('content')

<div class="main-page">

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores">
            -@{{error[0]}}
        </div>
    </div>

    <form role="form" name="capacidadForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><span class="asterik glyphicon glyphicon-asterisk"></span> Capacidad del establecimiento</b></h3>
            </div>
            <div class="panel-footer"><b>@Resource.EncuestaMsgCompleteInformacion</b></div>
            <div class="panel-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-if="alimentos.tipo==1">
                                <td>¿Cuántos platos de comida máximo se hubieran podido servir en promedio diariamente con el personal con en el que contó en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.platosMaximo.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.platosMaximo.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platosMaximo.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platosMaximo.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="platosMaximo" class="form-control" ng-model="alimentos.platosMaximo" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr ng-if="alimentos.tipo==1">
                                <td>¿Cuántos platos de comida se sirvieron efectivamente en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.platoServido.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.platoServido.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platoServido.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platoServido.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="platoServido" class="form-control" ng-model="alimentos.platoServido" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr ng-if="alimentos.tipo==1">
                                <td>¿Cuánto vale el plato de comida que más se vendió en el mes anterior? ($)
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.precioPlato.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.precioPlato.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.precioPlato.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.precioPlato.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="precioPlato" class="form-control" ng-model="alimentos.precioPlato" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr ng-if="alimentos.tipo==2">
                                <td>¿Cuántas unidades de comida máximo se hubieran podido servir en promedio diariamente con el personal con el que contó en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.platosPromedio.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.platosPromedio.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platosPromedio.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.platosPromedio.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="platosPromedio" class="form-control" ng-model="alimentos.platosPromedio" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                         
                               <tr ng-if="alimentos.tipo==2">
                                <td>¿Cuántas unidades de comida se sirvieron efectivamente en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.unidadServida.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.unidadServida.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.unidadServida.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.unidadServida.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="unidadServida" class="form-control" ng-model="alimentos.unidadServida" ng-required="true" placeholder="Solo números"/></td>
                            </tr>

                            <tr ng-if="alimentos.tipo==2">
                                <td>
                                    ¿Cuánto vale la unidad de comida que más se vendió en el mes anterior? ($)
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.precioUnidad.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.precioUnidad.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.precioUnidad.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.precioUnidad.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="precioUnidad" class="form-control" ng-model="alimentos.precioUnidad" ng-required="true" placeholder="Solo números" /></td>
                            </tr>


                            <tr>
                                <td>¿Cuántas bebidas máximo se hubieran podido servir en promedio diariamente con el personal con el que contó en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.bebidasMaximo.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasMaximo.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasMaximo.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasMaximo.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="bebidasMaximo" class="form-control" ng-model="alimentos.bebidasMaximo" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuántas bebidas se sirvieron efectivamente en el mes anterior?
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.bebidasServidas.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasServidas.$error.required">* El campo bebidas servidas es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasServidas.$error.number">* El campo bebidas servidas recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidasServidas.$error.min">* El campo bebidas servidas recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="bebidasServidas" class="form-control" ng-model="alimentos.bebidasServidas" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                            <tr>
                                <td>¿Cuál es el valor de la bebida que más se vendió en el mes anterior? ($)
                                    <span ng-show="capacidadForm.$submitted || capacidadForm.bebidaValor.$touched">
                                        <span class="label label-danger" ng-show="capacidadForm.bebidaValor.$error.required">* El campo es requerido.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidaValor.$error.number">* El campo recibe solo números.</span>
                                        <span class="label label-danger" ng-show="capacidadForm.bebidaValor.$error.min">* El campo recibe solo números iguales o mayores que 1.</span>
                                    </span>
                                </td>
                                <td><input type="number" min="1" name="bebidaValor" class="form-control" ng-model="alimentos.bebidaValor" ng-required="true" placeholder="Solo números"/></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

        <div class="row" style="text-align:center">
            <a href="/ofertaempleo/caracterizacionalimentos/@{{id}}" class="btn btn-raised btn-default">Anterior</a>
            <input type="submit" ng-click="guardar()" class="btn btn-raised btn-success" value="Siguiente" />
        </div>
        
    </form>

    


    <div class='carga'>

    </div>

</div>
@endsection
    