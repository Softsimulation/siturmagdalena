
@extends('layout._AdminLayout')

@section('title', 'Nueva actividad')

@section('estilos')
    <style>
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

        .row {
            margin: 1em 0 0;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        
    </style>
@endsection

@section('TitleSection', 'Nueva actividad')

@section('app', 'ng-app="actividadesApp"')

@section('controller','ng-controller="actividadesCrearController"')

@section('titulo','Actividades')
@section('subtitulo','Formulario para el registro de actividades')

@section('content')
    
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
    <li ng-class="{'disabled': (actividad.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
    <li ng-class="{'disabled': (actividad.id == -1)}"><a data-toggle="tab" href="#adicional">Información adicional</a></li>
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
        
        <form novalidate role="form" name="crearActividadForm">
            <fieldset>
                <legend>Información básica de la actividad</legend>
                <div class="alert alert-info">
                    <p>Todos los campos de información solicitados en este formulario son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.nombre.$touched) && crearActividadForm.nombre.$error.required}">
                            <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                            <input ng-model="actividad.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la actividad (Máximo 150 caracteres)"/>
                            
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.descripcion.$touched) && crearActividadForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                            <ng-ckeditor  
                                      ng-model="actividad.datosGenerales.descripcion"
                                      id="descripcion" 
                                      skin="moono" 
                                      remove-buttons="Image" 
                                      remove-plugins="iframe,flash,smiley"
                                      name="descripcion"
                                      required
                                      >
                            </ng-ckeditor>
                            <span class="messages" ng-show="crearActividadForm.$submitted || crearActividadForm.descripcion.$touched">
                                <span ng-show="crearActividadForm.descripcion.$error.required" class="text-error">* El campo es obligatorio.</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.valor_minimo.$touched) && (crearActividadForm.valor_minimo.$error.required || crearActividadForm.valor_minimo.$error.min)}">
                            <label for="valor_minimo"><span class="asterisk">*</span> Valor mínimo ($)</label>
                            <input min="0" ng-model="actividad.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.valor_maximo.$touched) && (crearActividadForm.valor_maximo.$error.required || crearActividadForm.valor_maximo.$error.min)}">
                            <label for="valor_maximo"><span class="asterisk">*</span> Valor máximo ($)</label>
                            <input min="@{{actividad.datosGenerales.valor_minimo}}" ng-model="actividad.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            <span class="text-error" ng-if="(crearActividadForm.$submitted || crearActividadForm.valor_maximo.$touched) && crearActividadForm.valor_maximo.$error.min">El valor máximo no puede ser menor al mínimo</span>        
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                        <a href="{{ url()->previous() }}" class="btn btn-lg btn-default">Volver</a>
                    </div>
                </div>
            </fieldset>
            
        </form>
    </div>
    
    <!--Multimedia-->
    <div id="multimedia" class="tab-pane fade">
        <fieldset>
            <legend>Multimedia</legend>
            @include('layout.partial._recomendacionesSubidaImagenes')
            <form novalidate role="form" name="multimediaForm">
                <div class="row">
                    <label><span class="asterisk">*</span> Imagen de portada</label>
                    <div class="col-sm-12">
                        <file-input text ng-model="portadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                    </div>
                </div>
                <div>
                    <br>
                    <label>Galería de imágenes</label>
                    <div class="col-sm-12">
                        <file-input text ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <hr/>
                        <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (actividad.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                        <a href="{{asset('/administradoractividades')}}" class="btn btn-lg btn-default">Cancelar</a>
                    </div>
                </div>
            </form>    
        </fieldset>
        
    </div>
    
    <!--Información adicional-->
    <div id="adicional" class="tab-pane fade">
        
        <form novalidate role="form" name="informacionAdicionalForm">
            <fieldset>
                <legend>Información adicional</legend>
                <div class="alert alert-info">
                    <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                </div>
                <div class="col-xs-12">
                    <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.sitios.$touched) && informacionAdicionalForm.sitios.$error.required}">
                        <label for="sitios"><span class="asterisk">*</span> Sitios <span class="text-error text-msg">(Seleccione al menos un sitio)</span></label>
                        <ui-select name="sitios" id="sitios" multiple ng-required="true" ng-model="actividad.adicional.sitios" theme="bootstrap" close-on-select="false" >
                            <ui-select-match placeholder="Seleccione uno o varios sitios.">
                                <span ng-bind="$item.sitios_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="sitio.id as sitio in (sitios| filter: $select.search)">
                                <span ng-bind="sitio.sitios_con_idiomas[0].nombre" title="@{{sitio.sitios_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.perfiles.$touched) && informacionAdicionalForm.perfiles.$error.required}">
                        <label for="perfiles"><span class="asterisk">*</span> Perfiles del turista <span class="text-error text-msg">(Seleccione al menos un perfil)</span></label>
                        <ui-select name="perfiles" id="perfiles" multiple ng-required="true" ng-model="actividad.adicional.perfiles" theme="bootstrap" close-on-select="false" >
                            <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                                <span ng-bind="$item.perfiles_usuarios_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="perfil.id as perfil in (perfiles_turista| filter: $select.search)">
                                <span ng-bind="perfil.perfiles_usuarios_con_idiomas[0].nombre" title="@{{perfil.perfiles_usuarios_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.categorias.$touched) && informacionAdicionalForm.categorias.$error.required}">
                        <label for="categorias"><span class="asterisk">*</span> Categorías de turismo <span class="text-error text-msg">(Seleccione al menos una categoría)</span></label>
                        <ui-select name="categorias" id="categorias" multiple ng-required="true" ng-model="actividad.adicional.categorias" theme="bootstrap" close-on-select="false" >
                            <ui-select-match placeholder="Seleccione una o varias categorías de turismo.">
                                <span ng-bind="$item.categoria_turismo_con_idiomas[0].nombre"></span>
                            </ui-select-match>
                            <ui-select-choices repeat="categoria.id as categoria in (categorias_turismo| filter: $select.search)">
                                <span ng-bind="categoria.categoria_turismo_con_idiomas[0].nombre" title="@{{categoria.categoria_turismo_con_idiomas[0].nombre}}"></span>
                            </ui-select-choices>
                        </ui-select>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <hr/>
                    <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (actividad.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                    <a href="{{asset('/administradoractividades')}}" class="btn btn-lg btn-default">Cancelar</a>
                </div>
            </fieldset>
            
        </form>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/services.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection
