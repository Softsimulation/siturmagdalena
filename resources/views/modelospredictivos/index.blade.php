@extends('layout._AdminLayout')

@section('Title','Modelos Predictivos :: SITUR Magdalena')
@section('app','ng-app="admin.modelospredictivos"')

@section('controller','ng-controller="IndexCtrl"')

@section('titulo','Modelos Predictivos')
@section('subtitulo','Herramienta de predicion del turismo')

@section('content')
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        
        <form role="form" name="addForm" novalidate>
                        <div class="modal-body">
                            <!--
                            <div class="alert alert-danger" ng-if="errores != null">
                                <p ng-repeat="error in errores" >
                                    -@{{error[0]}}
                                </p>
                            </div>
                            -->
                        <div class="row">  

                        <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.mes.$touched) && addForm.mes.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Variable a predecir</label>
                                    <select ng-change="cambio()" name="mes" class="form-control" ng-model="modelos.predicion" id="inputNombre" ng-required="true">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in variablespredecir" value="@{{item.id}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div>                      
                            
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.variable.$touched) && addForm.variable.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Variable a entrenar</label>
                                    <ui-select multiple  id="variable"  name="variable" ng-model="modelos.variables"  ng-required="true">
                                       <ui-select-match placeholder="Seleccione variables (multiple)">@{{$item.nombre}}</ui-select-match>
                                       <ui-select-choices repeat="item.id as item in encabezados | filter:$select.search">
                                           @{{item.nombre}}
                                       </ui-select-choices>
                                   </ui-select>
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('actividad')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.actividades.$touched) && addForm.actividades.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Actividades realizadas</label>
                                    <select name="actividades" class="form-control" ng-model="modelos.actividad" id="inputNombre" ng-required="modelos.variables.indexOf('actividad')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in actividades" value="@{{item.id}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('pais')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.pais.$touched) && addForm.pais.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Paises</label>
                                    <select name="pais" class="form-control" ng-model="modelos.pais" id="inputNombre" ng-required="modelos.variables.indexOf('pais')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in paises" value="@{{item.nombre}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('departamento')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.departamento.$touched) && addForm.departamento.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Departamentos</label>
                                    <select name="departamento" class="form-control" ng-model="modelos.departamento" id="inputNombre" ng-required="modelos.variables.indexOf('departamento')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in departamentos|filter:{pais:modelos.pais}" value="@{{item.nombre}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('municipio')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.municipio.$touched) && addForm.municipio.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Municipios</label>
                                    <select name="municipio" class="form-control" ng-model="modelos.municipio" id="inputNombre" ng-required="modelos.variables.indexOf('municipio')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in municipios|filter:{departamento:modelos.departamento}" value="@{{item.nombre}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('motivo_viaje')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.motivo_viaje.$touched) && addForm.motivo_viaje.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Variable a predecir</label>
                                    <select name="mes" class="form-control" ng-model="modelos.motivo_viaje" id="motivo_viaje" ng-required="modelos.variables.indexOf('motivo_viaje')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                        <option ng-repeat="item in motivos" value="@{{item.nombre}}">@{{item.nombre}}</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('sexo')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.sexo.$touched) && addForm.sexo.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Sexo</label>
                                    <select name="sexo" class="form-control" ng-model="modelos.sexo" id="inputNombre" ng-required="modelos.variables.indexOf('sexo')>-1">
                                        <option value="" disabled>--Seleccione--</option>
                                       <option value="Masculino">Masculino</option>
                                       <option value="Femenino">Femenino</option>                                        
                                    </select>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('edad')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.edad.$touched) && addForm.edad.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Edad</label>
                                    <input type="number" class="form-control" name="edad" ng-model="modelos.edad" ng-required= "modelos.variables.indexOf('edad')>-1"/>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('numero_noches')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.numero_noches.$touched) && addForm.numero_noches.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Numero de noches</label>
                                    <input type="number" class="form-control" name="numero_noches" placeholder="Numero de noches" ng-model="modelos.numero_noches" ng-required= "modelos.variables.indexOf('numero_noches')>-1"/>
                                </div>
                            </div> 

                            <div class="col-md-12 col-xs-12 col-sm-12" ng-show="modelos.variables.indexOf('gasto')>-1">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.gasto.$touched) && addForm.gasto.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Gasto</label>
                                    <input type="number" class="form-control" name="gasto" placeholder="Gasto" ng-model="modelos.gasto" ng-required= "modelos.variables.indexOf('gasto')>-1"/>
                                </div>
                            </div>

                            <div class="col-md-12" ng-show="ver">
                                    @{{data.variable}} : @{{data.data[0].visitante|number:2}}
                            </div> 
                            
                        </div>
                    </div>                    
                        <button type="submit" ng-click="predecir()" class="btn btn-success">Predecir</button> 
                </form>
       
    </div>    

@endsection
@section('javascript')
<script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/administrador/modelospredictivos/modelos.js')}}"></script>
<script src="{{asset('/js/administrador/modelospredictivos/services.js')}}"></script>
@endsection 