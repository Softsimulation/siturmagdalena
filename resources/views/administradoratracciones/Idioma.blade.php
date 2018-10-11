
@extends('layout._AdminLayout')

@section('title', 'Formulario para la modificación de información en otro idioma')

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesIdiomaController"')

@section('titulo','Atracciones')
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
<fieldset>
    <legend>Información básica</legend>
    <div class="alert alert-info">
        <p>Los campos marcados con asterisco (*) son obligatorios.</p>
    </div>
    <form novalidate role="form" name="editarIdiomaForm">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.nombre.$touched) && editarIdiomaForm.nombre.$error.required}">
                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                    <input max="150" ng-model="atraccion.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la atracción (Máximo 150 caracteres)"/>
                     
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group" ng-class="{'has-error': (editarIdiomaForm.$submitted || editarIdiomaForm.descripcion.$touched) && editarIdiomaForm.descripcion.$error.required}">
                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                    <textarea style="resize: none;" ng-model="atraccion.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la atracción (De 100 a 1,000 caracteres)"></textarea>
                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label for="actividad">Periodo de actividad e inactividad</label>
                    <textarea style="resize: none;" rows="2" class="form-control" id="actividad" name="actividad" ng-model="atraccion.datosGenerales.actividad" placeholder="Máximo 1,000 caracteres."></textarea>
                </div>
                <div class="form-group">
                    <label for="horario">Horario</label>
                    <input ng-model="atraccion.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="recomendaciones">Recomendaciones</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="recomendaciones" name="recomendaciones" ng-model="atraccion.datosGenerales.recomendaciones" placeholder="Máximo 1,000 caracteres."></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="reglas">Reglas</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="reglas" name="reglas" ng-model="atraccion.datosGenerales.reglas" placeholder="Reglas o normas que deben seguir los visitantes. Máximo 1,000 caracteres."></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <label for="como_llegar">Como llegar</label>
                    <textarea style="resize: none;" rows="5" class="form-control" id="como_llegar" name="como_llegar" ng-model="atraccion.datosGenerales.como_llegar" placeholder="Pasos o indicaciones para llegar al lugar. Máximo 1,000 caracteres."></textarea>
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <hr/>
                <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                <a href="{{asset('/administradoratracciones')}}" class="btn btn-lg btn-default">Cancelar</a>
            </div>
        </div>
        
    </form>
</fieldset>

        
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/services.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/app.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="/js/plugins/ng-map.js"></script>
@endsection
