
@extends('layout._AdminLayout')

@section('title', 'Editar grupo de viaje')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        p {
            font-size: 1em;
        }
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            font-size: .9em;
        }
        .row {
            margin: 1em 0 0;
        }

    </style>
@endsection

@section('TitleSection', 'Editar grupo de viaje')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('controller','ng-controller="editar_grupo"')

@section('content')
    

<div class="container">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <h1 class="title1">Editar grupo de viaje</h1><br/>
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="alert alert-danger" ng-if="errores != null">
            <label><b>Corrige los errores:</b></label>
            <br />
            <div ng-repeat="error in errores" ng-if="error.errores.length>0">
                -@{{error[0]}}
            </div>
        </div>
        <form role="form" name="ediForm" novalidate>
            <div class="row">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                        <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>La información marcada con asterisco debe ser ingresada obligatoriamente</strong> </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-xs-12 col-md-4">
                    <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(ediForm.$submitted || ediForm.fechaini.$touched) && ediForm.fechaini.$error.required]">
                        <label class="control-label" for="date_apli">Fecha de aplicación</label> <span class="text-error" ng-show="(ediForm.$submitted || ediForm.fechaini.$touched) && ediForm.fechaini.$error.required">(El campo es obligatorio)</span>
                        <div class="input-group" id='date_apli2'>
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <input type="text" id="date_apli" name="date_apli" class="form-control" placeholder="Fecha de aplicación" ng-model="grupo.Fecha" required autocomplete="off" />
                            <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(ediForm.$submitted || ediForm.fechaini.$touched) && ediForm.fechaini.$error.required"></span>
                            <div class="input-group-addon" title="Seleccionar fecha"><span class="glyphicon glyphicon-calendar"></span></div>

                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-xs-12 col-md-5">
                    <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(ediForm.$submitted || ediForm.sitio.$touched) && ediForm.sitio.$error.required]">
                        <label class="control-label" for="sitio">Lugar de aplicación</label> <span class="text-error" ng-show="(ediForm.$submitted || ediForm.sitio.$touched) && ediForm.sitio.$error.required">(El campo es obligatorio)</span>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <select ng-model="grupo.Sitio" name="sitio" id="sitio" class="form-control" ng-options="sitio.id as sitio.nombre for sitio in lugares_aplicacion" required>
                                <option value="" disabled>Selecione un sitio</option>
                                
                            </select>
                            <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(ediForm.$submitted || ediForm.sitio.$touched) && ediForm.sitio.$error.required"></span>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-xs-12 col-md-3">
                    <div class="form-group" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(ediForm.$submitted || ediForm.personas.$touched) && (ediForm.personas.$error.required || ediForm.personas.$error.number || ediForm.personas.$error.min || grupo.PersonasEncuestadas > grupo.Mayores15)]">
                        <label class="control-label" for="personas">Personas encuestadas</label>
                        <div class="input-group">
                            <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                            <input type="number" class="form-control" name="personas" id="personas" min="1" ng-model="grupo.PersonasEncuestadas" placeholder="Solo números" required />
                            <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(ediForm.$submitted || ediForm.personas.$touched) && (ediForm.personas.$error.required || ediForm.personas.$error.number || ediForm.personas.$error.min || grupo.PersonasEncuestadas > grupo.Mayores15)"></span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row" ng-show="(ediForm.$submitted || ediForm.personas.$touched) && (ediForm.personas.$error.required || ediForm.personas.$error.number || ediForm.personas.$error.min || grupo.PersonasEncuestadas > grupo.Mayores15)">
                <div class="col-xs-12">
                    <div class="alert alert-danger" role="alert">
                        <h3>Recuerde que...</h3>
                        <p ng-show="ediForm.personas.$error.required">El campo <b>Personas encuestadas</b> es requerido.</p>
                        <p ng-show="ediForm.personas.$error.number">En el campo <b>Personas encuestadas</b> debe introducir solo números.</p>
                        <p ng-show="ediForm.personas.$error.min">En el campo <b>Personas encuestadas</b> debe ingresar solo números iguales o mayores que 1.</p>
                        <p ng-show="grupo.PersonasEncuestadas > grupo.Mayores15">La cantidad de personas encuestadas NO puede ser mayor a la cantidad de personas mayores a 15 años presentes.</p>
                    </div>
                </div>
            </div>

            <hr />
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tipo"class="col-xs-12 control-label" style="padding-left: 0;">Tipo de viaje (Obligatorio) <span class="label label-danger" ng-show="(ediForm.$submitted || ediForm.tipo.$touched) && ediForm.tipo.$error.required">El campo es requerido.</span></label>
                        <div class="col-xs-12" style="padding-left: 0;">
                            
                            <label class="checkbox-inline" ng-repeat="tipo in tipos_viajes">
                                <input ng-show="tipo.tipos_viaje_con_idiomas.length > 0" type="radio" name="tipo" value="@{{tipo.id}}" ng-model="grupo.Tipo" required /> @{{tipo.tipos_viaje_con_idiomas[0].nombre}}
                            </label>

                        </div>

                    </div>
                    
                </div>
            </div>
            <hr />

            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-info" role="alert" style="padding: .5em;">
                        Complete los siguientes campos de información
                    </div>
                </div>
                <div class="col-xs-12">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 80%">Tamaño del grupo de viaje</th>
                                <th style="width: 20%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Mayores de 15 años PRES</td>
                                <td><input type="number" class="form-control" ng-model="grupo.Mayores15" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Menores de 15 años PRES</td>
                                <td><input type="number" class="form-control" ng-model="grupo.Menores15" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Mayores de 15 años NO PRES</td>
                                <td><input type="number" class="form-control" ng-model="grupo.Mayores15No" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Menores de 15 años NO PRES</td>
                                <td><input type="number" class="form-control" ng-model="grupo.Menores15No" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Personas del Magdalena</td>
                                <td><input type="number" class="form-control" ng-model="grupo.PersonasMag" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td><span style="color:black;font-weight:bold">Total</span></td>
                                <td>@{{total}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <span class="label label-danger" ng-show="crearForm.$submitted && total == 0">
                        Debe introducir alguno de los valores
                    </span>
                </div>

            </div>

            <div class="row" style="text-align: center;">
                <a href="/grupoviaje/listadogrupos" class="btn btn-default">Cancelar</a>
                <input type="submit" ng-click="editar()" value="Guardar" class="btn btn-success">
                
            </div>
        </form>
    </div>
    
    <div class='carga'>

    </div>
</div>

@endsection


