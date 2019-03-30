@extends('layout._AdminLayout')

@section('Title','Administrador de Infografias :: SITUR Magdalena')
@section('app','ng-app="admin.infografias"')

@section('controller','ng-controller="Infografiactrl"')

@section('titulo','Infografias')
@section('subtitulo','Herramienta de Generación de Infografias')

@section('content')
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        
        <div class="row">
            <form role="form" name="addForm" novalidate>
                      
                <div class="alert alert-danger" ng-if="errores != null">
                    <p ng-repeat="error in errores" >
                        -@{{error[0]}}
                    </p>
                </div>
        
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.mes.$touched) && addForm.mes.$error.required}">
                            <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Mes</label>
                            <select name="mes" class="form-control" ng-model="infografia.mes" id="inputNombre" required>
                                <option value="" disabled>--Seleccione--</option>
                                <option ng-repeat="mes in meses" value="@{{mes.id}}">@{{mes.nombre}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group" ng-class="{'has-error': (addForm.$submitted || addForm.anio.$touched) && addForm.anio.$error.required}">
                            <label class="control-label" for="inputNombre"><span class="asterisk">*</span>Años</label>
                            <select name="anio" class="form-control" ng-model="infografia.anio" id="inputNombre" required>
                                <option value="" disabled>--Seleccione--</option>
                                <option ng-repeat="anio in anios" value="@{{anio.anio}}">@{{anio.anio}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                  
                <button type="button" ng-click="generar()" class="btn btn-default" >Generar</button>
            </form>
        </div>
        
        <div>@{{datoinfografia}}</div>
        
    </div>
        
   

@endsection
@section('javascript')
<script src="{{asset('/js/administrador/infografias/infografias.js')}}"></script>
<script src="{{asset('/js/administrador/infografias/services.js')}}"></script>
@endsection 