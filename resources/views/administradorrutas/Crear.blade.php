
@extends('layout._AdminLayout')

@section('title', 'Rutas turísticas')

@section('estilos')
    <style>
        
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasCrearController"')

@section('titulo','Rutas turísticas')
@section('subtitulo','Formulario para el registro de rutas turísticas')

@section('content')
    
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
        <li ng-class="{'disabled': (ruta.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
        <li ng-class="{'disabled': (ruta.id == -1)}"><a data-toggle="tab" href="#adicional">Información adicional</a></li>
    </ul>
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
        <div class="tab-content">
            <!--Información básica-->
            <div id="info" class="tab-pane fade in active">
               
                <form novalidate role="form" name="crearRutaForm">
                    
                    <fieldset>
                        <legend>Información básica</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearRutaForm.$submitted || crearRutaForm.nombre.$touched) && crearRutaForm.nombre.$error.required}">
                                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                                    <input ng-model="ruta.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la ruta (Máximo 150 caracteres)" maxlength="150"/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearRutaForm.$submitted || crearRutaForm.descripcion.$touched) && crearRutaForm.descripcion.$error.required}">
                                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                                    <ng-ckeditor  
                                              ng-model="ruta.datosGenerales.descripcion"
                                               
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              name="descripcion"
                                              required
                                              >
                                    </ng-ckeditor>
                                    <span class="messages" ng-show="crearRutaForm.$submitted || crearRutaForm.descripcion.$touched">
                                        <span ng-show="crearRutaForm.descripcion.$error.required" class="text-error">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="recomendaciones">Recomendaciones</label>
                                    <textarea ng-model="ruta.datosGenerales.recomendacion" style="resize: none;" rows="5" name="recomendaciones" id="recomendaciones" class="form-control" placeholder="De 100 a 1,000 caracteres." maxlength="1000"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <hr/>
                                <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (ruta.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
                                <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                        
                    </fieldset>
                    
                </form>
            </div>
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade">
                
                <form novalidate role="form" name="multimediaForm">
                    <fieldset>
                        <legend>Multimedia</legend>
                        @include('layout.partial._recomendacionesSubidaImagenes')
                        <div class="row">
                            <div class="col-xs-12">
                                <label><span class="asterisk">*</span> Imagen de portada</label>
                                <file-input ng-model="portadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                            </div>
                            
                            <div class="col-sm-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (ruta.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                        
                    </fieldset>
                    
                </form>
            </div>
            
            <!--Información adicional-->
            <div id="adicional" class="tab-pane fade">
                
                <form novalidate role="form" name="informacionAdicionalForm">
                    <fieldset>
                        <legend>Información básica</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.atracciones.$touched) && informacionAdicionalForm.atracciones.$error.required}">
                                    <label for="atracciones"><span class="asterisk">*</span> Atracciones de la ruta <span class="text-error text-msg">(Seleccione al menos una atracción)</span></label>
                                    <ui-select name="atracciones" id="atracciones" multiple ng-required="true" ng-model="ruta.adicional.atracciones" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                                            <span ng-bind="$item.sitio.sitios_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="atraccion.id as atraccion in (atracciones| filter: $select.search)">
                                            <span ng-bind="atraccion.sitio.sitios_con_idiomas[0].nombre" title="@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (ruta.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                                <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </fieldset>
                    
                </form>
            </div>
        </div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection
