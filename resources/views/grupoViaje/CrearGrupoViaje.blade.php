
@extends('layout._AdminLayout')

@section('title', 'Crear grupo de viaje')

@section('TitleSection', 'Crear grupo de viaje')

@section('app','ng-app="receptor.grupo_viaje"')

@section('controller','ng-controller="crear_grupo"')

@section('titulo','Grupos de viaje')
@section('subtitulo','Formulario de creación de grupo de viaje')

@section('content')
    

    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>

    </div>
    <form role="form" name="crearForm" novalidate>
            <div class="alert alert-info">
                <p>Los campos marcados con asterisco (*) son obligatorios. <strong>Debe ingresar por lo menos uno de los valores solicitados en la tabla de tamaño de grupo de viaje.</strong></p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.date_apli.$touched) && crearForm.date_apli.$error.required}">
                        <label class="control-label" for="date_apli"><span class="asterisk">*</span> Fecha de aplicación</label>
                        <adm-dtp name="date_apli" id="date_apli" ng-model='grupo.Fecha' full-data="date11_detail" maxdate="@{{fechaActual}}"
                                             options="optionFecha" ng-required="true"></adm-dtp>
                         <span class="text-error" ng-show="(crearForm.$submitted || crearForm.date_apli.$touched) && crearForm.date_apli.$error.required">El campo es obligatorio</span>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.sitio.$touched) && crearForm.sitio.$error.required}">
                        <label class="control-label" for="sitio"><span class="asterisk">*</span> Lugar de aplicación</label> 
                        <select ng-model="grupo.Sitio" name="sitio" id="sitio" class="form-control" ng-options="lugar_aplicacion.id as lugar_aplicacion.nombre for lugar_aplicacion in lugares_aplicacion" required>
                                <option value="" disabled>Selecione un sitio</option>
                            </select>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-xs-12 col-md-3">
                    <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.personas.$touched) && (crearForm.personas.$error.required || crearForm.personas.$error.number || crearForm.personas.$error.min || grupo.PersonasEncuestadas > grupo.Mayores15)}">
                        <label class="control-label" for="personas"><span class="asterisk">*</span> Personas encuestadas</label>
                        <input type="number" class="form-control" name="personas" id="personas" min="1" ng-model="grupo.PersonasEncuestadas" placeholder="Solo números" required />
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.personas.$touched) && crearForm.personas.$error.min">Valor mínimo: 1</span>                        
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.personas.$touched) && grupo.PersonasEncuestadas > grupo.Mayores15">El valor debe ser menor a cant. de personas mayores a 15 años PRES</span>
                    </div>
                </div>
            </div>
            

            <hr />
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="tipo"class="col-xs-12 control-label" style="padding-left: 0;"><span class="asterisk">*</span> Tipo de viaje </label>
                        <div class="col-xs-12" style="padding-left: 0;">

                                <label class="checkbox-inline" ng-repeat="tipo in tipos_viajes">
                                    <input ng-show="tipo.tipos_viaje_con_idiomas.length > 0" type="radio" name="tipo" value="@{{tipo.id}}" ng-model="grupo.Tipo" ng-required="true" /> @{{tipo.tipos_viaje_con_idiomas[0].nombre}}
                                </label>
                        </div>
                        <span class="text-error" ng-show="(crearForm.$submitted || crearForm.tipo.$touched) && crearForm.tipo.$error.required">El campo es requerido.</span>
                    </div>
                    
                </div>
            </div>
            <hr />
            <div class="row">
                
                <div class="col-xs-12 table-overflow">
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
                                <td><input type="number" class="form-control input-sm" ng-model="grupo.Mayores15" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Menores de 15 años PRES</td>
                                <td><input type="number" class="form-control input-sm" ng-model="grupo.Menores15" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Mayores de 15 años NO PRES</td>
                                <td><input type="number" class="form-control input-sm" ng-model="grupo.Mayores15No" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Menores de 15 años NO PRES</td>
                                <td><input type="number" class="form-control input-sm" ng-model="grupo.Menores15No" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td>Personas del Magdalena</td>
                                <td><input type="number" class="form-control input-sm" ng-model="grupo.PersonasMag" ng-change="calcular()" /></td>
                            </tr>
                            <tr style="border-bottom: .5px solid lightgray">
                                <td><span style="color:black;font-weight:bold">Total</span></td>
                                <td>@{{total}}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                
            </div>
            <div class="alert alert-danger" ng-show="crearForm.$submitted && total == 0">
                <p>Debe introducir alguno de los valores de la tabla de tamaño de grupo.</p>
            </div>
            <div class="text-center">
                <input type="submit" ng-click="guardar()" value="Guardar" class="btn btn-lg btn-success">
                <a href="/grupoviaje/listadogrupos" class="btn btn-lg btn-default">Cancelar</a>
            </div>
            <br>
        </form>
    <div class='carga'>

    </div>

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/grupo_viaje.js')}}"></script>
<script src="{{asset('/js/administrador/grupoViajeServices.js')}}"></script>
@endsection
