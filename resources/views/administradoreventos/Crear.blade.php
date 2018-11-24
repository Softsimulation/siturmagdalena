
@extends('layout._AdminLayout')

@section('title', 'Formulario para el registro de eventos')

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

@section('app', 'ng-app="eventosApp"')

@section('controller','ng-controller="eventosCrearController"')

@section('titulo','Eventos')
@section('subtitulo','Formulario para el registro de eventos')

@section('content')

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
        <li ng-class="{'disabled': (evento.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
        <li ng-class="{'disabled': (evento.id == -1)}"><a data-toggle="tab" href="#adicional">Información adicional</a></li>
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
                
                <form novalidate role="form" name="crearEventoForm">
                    <fieldset>
                        <legend>Información básica</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.nombre.$touched) && crearEventoForm.nombre.$error.required}">
                                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                                    <input ng-model="evento.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del evento (Máximo 150 caracteres)" maxlength="150"/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="edicion">Edición</label>
                                    <input class="form-control" placeholder="Máximo 50 caracteres." max="50" ng-model="evento.datosGenerales.edicion" type="text" name="edicion" id="edicion">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.descripcion.$touched) && crearEventoForm.descripcion.$error.required}">
                                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                                    <ng-ckeditor  
                                              ng-model="evento.datosGenerales.descripcion"
                                               
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              name="descripcion"
                                              required
                                              >
                                    </ng-ckeditor>
                                    <span class="messages" ng-show="crearEventoForm.$submitted || crearEventoForm.descripcion.$touched">
                                        <span ng-show="crearEventoForm.descripcion.$error.required" class="text-error">* El campo es obligatorio.</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.valor_minimo.$touched) && crearEventoForm.valor_minimo.$error.required}">
                                    <label for="valor_minimo"><span class="asterisk">*</span> Valor mínimo ($)</label>
                                    <input min="0" ng-model="evento.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números."/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.valor_maximo.$touched) && (crearEventoForm.valor_maximo.$error.required || crearEventoForm.valor_maximo.$error.min)}">
                                    <label for="valor_maximo"><span class="asterisk">*</span> Valor máximo ($)</label>
                                    <input min="@{{evento.datosGenerales.valor_minimo}}" ng-model="evento.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números."/>
                                    <span class="text-error" aria-hidden="true" ng-if="(crearEventoForm.$submitted || crearEventoForm.valor_maximo.$touched) && crearEventoForm.valor_maximo.$error.min">El valor máximo no puede ser menor al valor mínimo</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.tipo_evento.$touched) && crearEventoForm.tipo_evento.$error.required}">
                                    <label for="tipo_evento"><span class="asterisk">*</span> Tipo de evento</label>
                                    <ui-select theme="bootstrap" ng-required="true" ng-model="evento.datosGenerales.tipo_evento" id="tipo_evento" name="tipo_evento">
                                       <ui-select-match placeholder="Tipo de evento.">
                                           <span ng-bind="$select.selected.tipo_eventos_con_idiomas[0].nombre"></span>
                                       </ui-select-match>
                                       <ui-select-choices repeat="tipo.id as tipo in (tipos_evento| filter: $select.search)">
                                           <span ng-bind="tipo.tipo_eventos_con_idiomas[0].nombre" title="@{{tipo.tipo_eventos_con_idiomas[0].nombre}}"></span>
                                       </ui-select-choices>
                                    </ui-select>
                                      
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" ng-class="{'has-error':(crearEventoForm.$submitted || crearEventoForm.fecha_inicio.$touched) && crearEventoForm.fecha_inicio.$error.required}">
                                    <label class="control-label" for="fecha_inicio"><span class="asterisk">*</span> Fecha de inicio del evento</label> 
                                    <adm-dtp name="fecha_inicio" id="fecha_inicio" ng-model='evento.datosGenerales.fecha_inicio' full-data="fecha_inicio_detail" mindate="@{{fechaActual}}" maxdate="@{{fecha_final_detail.unix}}"
                                                         options="optionFecha" ng-required="true"></adm-dtp>
                                    <span class="text-error" ng-show="(crearEventoForm.$submitted || crearEventoForm.fechaini.$touched) && crearEventoForm.fechaini.$error.required">El campo es obligatorio</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group" ng-class="{'has-error':(crearEventoForm.$submitted || crearEventoForm.fecha_final.$touched) && crearEventoForm.fecha_final.$error.required}">
                                    <label class="control-label" for="fecha_final">Fecha de finalización del evento</label> 
                                    <adm-dtp name="fecha_final" id="fecha_final" ng-model='evento.datosGenerales.fecha_final' full-data="fecha_final_detail" mindate="@{{fecha_inicio_detail.unix}}" disable='@{{!evento.datosGenerales.fecha_inicio}}'
                                                         options="optionFecha" ng-required="true"></adm-dtp>
                                    <span class="text-error" ng-show="(crearEventoForm.$submitted || crearEventoForm.fecha_final.$touched) && crearEventoForm.fecha_final.$error.required">El campo es obligatorio</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input ng-model="evento.datosGenerales.telefono" type="tel" name="telefono" id="telefono" class="form-control" placeholder="Máximo 100 caracteres."/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="horario">Horario</label>
                                    <input ng-model="evento.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group">
                                    <label for="pagina_web">Página web</label>
                                    <input ng-model="evento.datosGenerales.pagina_web" type="text" name="pagina_web" id="pagina_web" class="form-control" placeholder="Máximo 255 caracteres."/>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (evento.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
                                <a href="{{asset('/administradoreventos')}}" class="btn btn-lg btn-default">Cancelar</a>
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
                            <div class="col-xs-12">
                                <br/>
                                <label>Subir imágenes</label>
                                <file-input ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                                
                            </div>
                            <div class="col-sm-12">
                                <br/>
                                <label for="video_promocional">Video promocional</label>
                                <input type="text" name="video_promocional" id="video_promocional" class="form-control" placeholder="URL del video de YouTube" maxlength="500"/>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (evento.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradoreventos')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            
            <!--Información adicional-->
            <div id="adicional" class="tab-pane fade">
                
                <form novalidate role="form" name="informacionAdicionalForm">
                    <fieldset>
                        <legend>Información adicional</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.perfiles.$touched) && informacionAdicionalForm.perfiles.$error.required}">
                                    <label for="perfiles"><span class="asterisk">*</span> Perfiles del turista <span class="text-error text-msg">(Seleccione al menos un perfil)</span></label>
                                    <ui-select name="perfiles" id="perfiles" multiple ng-required="true" ng-model="evento.adicional.perfiles" theme="bootstrap" close-on-select="false" >
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
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.sitios.$touched) && informacionAdicionalForm.sitios.$error.required}">
                                    <label for="sitios"><span class="asterisk">*</span> Sitios <span class="text-error text-msg">(Seleccione al menos un sitio)</span></label>
                                    <ui-select name="sitios" id="sitios" multiple ng-required="true" ng-model="evento.adicional.sitios" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios sitios.">
                                            <span ng-bind="$item.sitios_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="sitio.id as sitio in (sitios| filter: $select.search)">
                                            <div ng-bind="sitio.sitios_con_idiomas[0].nombre" title="@{{sitio.sitios_con_idiomas[0].nombre}}"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.categorias.$touched) && informacionAdicionalForm.categorias.$error.required}">
                                    <label for="categorias"><span class="asterisk">*</span> Categorías de turismo <span class="text-error text-msg">(Seleccione al menos una categoría)</span></label>
                                    <ui-select name="categorias" id="categorias" multiple ng-required="true" ng-model="evento.adicional.categorias" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione una o varias categorías de turismo.">
                                            <span ng-bind="$item.categoria_turismo_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="categoria.id as categoria in (categorias_turismo| filter: $select.search)">
                                            <span ng-bind="categoria.categoria_turismo_con_idiomas[0].nombre" title="@{{categoria.categoria_turismo_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (evento.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                                <a href="{{asset('/administradoreventos')}}" class="btn btn-lg btn-default">Cancelar</a>
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
<script src="{{asset('/js/administrador/eventos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/services.js')}}"></script>
<script src="{{asset('/js/administrador/eventos/app.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection
