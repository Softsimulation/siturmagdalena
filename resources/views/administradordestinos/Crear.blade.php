
@extends('layout._AdminLayout')

@section('title', 'Formulario para el registro de destinos')

@section('estilos')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css" type="text/css" />
    <style>
        
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosCrearController"')

@section('titulo','Destinos')
@section('subtitulo','Formulario para el registro de destinos')

@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
        <li ng-class="{'disabled': (destino.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
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
                
                <form novalidate role="form" name="crearDestinoForm">
                    
                    <fieldset>
                        <legend>Información básica</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.nombre.$touched) && crearDestinoForm.nombre.$error.required}">
                                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                                    <input ng-model="destino.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del destino (Máximo 150 caracteres)" maxlength="150"/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.tipo.$touched) && crearDestinoForm.tipo.$error.required}">
                                    <label for="sector"><span class="asterisk">*</span> Tipo de destino</label>
                                    <ui-select theme="bootstrap" ng-required="true" ng-model="destino.datosGenerales.tipo" id="tipo" name="tipo">
                                       <ui-select-match placeholder="Tipo de destino.">
                                           <span ng-bind="$select.selected.tipo_destino_con_idiomas[0].nombre"></span>
                                       </ui-select-match>
                                       <ui-select-choices repeat="tipo.id as tipo in (tipos_sitio| filter: $select.search)">
                                           <span ng-bind="tipo.tipo_destino_con_idiomas[0].nombre" title="@{{tipo.tipo_destino_con_idiomas[0].nombre}}"></span>
                                       </ui-select-choices>
                                    </ui-select>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.descripcion.$touched) && crearDestinoForm.descripcion.$error.required}">
                                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                                    <ng-ckeditor  
                                              ng-model="destino.datosGenerales.descripcion"
                                               
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              name="descripcion"
                                              required
                                              >
                                    </ng-ckeditor>
                                    <span class="messages" ng-show="crearDestinoForm.$submitted || crearDestinoForm.descripcion.$touched">
                                        <span ng-show="crearDestinoForm.descripcion.$error.required" class="text-error">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="informacion_practica">Información práctica</label>
                                    <textarea style="resize: none;" rows="6" class="form-control" id="informacion_practica" name="informacion_practica" ng-model="destino.datosGenerales.informacion_practica" placeholder="Máximo 1,000 caracteres."></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="reglas">Reglas</label>
                                    <textarea style="resize: none;" rows="6" class="form-control" id="reglas" name="reglas" ng-model="destino.datosGenerales.reglas" placeholder="Reglas o normas que deben seguir los visitantes. Máximo 1,000 caracteres."></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="como_llegar">Cómo llegar</label>
                                    <textarea style="resize: none;" rows="6" class="form-control" id="como_llegar" name="como_llegar" ng-model="destino.datosGenerales.como_llegar" placeholder="Pasos o indicaciones para llegar al lugar. Máximo 1,000 caracteres."></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 form-inline text-center">
                                <div class="form-group">
                                    <label for="adress">Dirección</label>
                                    <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                                </div>
                                <button type="button" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div id="direccion_map" style="height: 400px;margin: 1rem 0;">
                                
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (destino.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
                                <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
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
                    <form novalidate role="form" name="multimediaForm">
                        <div class="row">
                            <div class="col-xs-12">
                                <label><span class="asterisk">*</span> Imagen de portada</label>
                                <file-input text ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                                
                            </div>
                            <div class="col-xs-12">
                                <br/>
                                <label>Subir imágenes</label>
                                <file-input text ng-model="imagenes" preview="previewImagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                                
                            </div>
                            <div class="col-xs-12">
                                <br/>
                                <label for="video">Video promocional</label>
                                <input type="text" name="video" id="video" ng-model="video" class="form-control" placeholder="URL del video de YouTube" />
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (destino.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradordestinos')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </form>
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
<script src="{{asset('/js/administrador/destinos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/services.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyC55uUNZFEafP0702kEyGLlSmGE29R9s5k&libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js"></script>
@endsection
