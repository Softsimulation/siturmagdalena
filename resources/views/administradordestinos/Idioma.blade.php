
@extends('layout._AdminLayout')

@section('title', 'Formulario para la modificación de información en otro idioma')

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosIdiomaController"')

@section('titulo','Destinos')
@section('subtitulo','Formulario para la modificación de información en otro idioma')

@section('content')

<div class="text-center">
    <div class="alert alert-info">
        <p>Idioma a modificar:</p>
        <h3 style="margin: 0">@{{idioma.nombre}}</h3>
    </div>
    
</div>

<input type="hidden" ng-model="id" ng-init="id={{$id}}" />
<input type="hidden" ng-model="idIdioma" ng-init="idIdioma={{$idIdioma}}" />
<div class="alert alert-danger" ng-if="errores != null">
    <label><b>Errores:</b></label>
    <br />
    <div ng-repeat="error in errores" ng-if="error.length>0">
        -@{{error[0]}}
    </div>
</div>
    <!--Información básica-->
    <div id="info" class="tab-pane fade in active">
        
        <form novalidate role="form" name="editarDestinoForm">
            <fieldset>
                <legend>Información básica</legend>
                <div class="alert alert-info">
                    <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (editarDestinoForm.$submitted || editarDestinoForm.nombre.$touched) && editarDestinoForm.nombre.$error.required}">
                            <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                            <input ng-model="destino.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del destino (Máximo 150 caracteres)" maxlength="150"/>
                            
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (editarDestinoForm.$submitted || editarDestinoForm.descripcion.$touched) && editarDestinoForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                            <textarea style="resize: none;" ng-model="destino.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del destino (De 100 a 1,000 caracteres)" maxlength="1000"></textarea>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                        <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
                    </div>
                </div>
            </fieldset>
           
        </form>
    </div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/services.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
@endsection
