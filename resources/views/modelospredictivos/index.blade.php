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
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.categoria.$touched) && addForm.categoria.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Variable a entrenar</label>
                                    <ui-select multiple  id="variable"  name="variable" ng-model="modelos.variables"  ng-required="true">
                                       <ui-select-match placeholder="Seleccione variables (multiple)">@{{$item.nombre}}</ui-select-match>
                                       <ui-select-choices repeat="item.id as item in encabezados | filter:$select.search">
                                           @{{item.nombre}}
                                       </ui-select-choices>
                                   </ui-select>
                                </div>
                            </div>
                            
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.mes.$touched) && addForm.mes.$error.required}">
                                    <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Variable a predecir</label>
                                    <select name="mes" class="form-control" ng-model="modelos.predicion" id="inputNombre" ng-required="true">
                                        <option value="" disabled>--Seleccione--</option>
                                        
                                    </select>
                                </div>
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