
@extends('layout._AdminLayout')

@section('title', 'Formulario para el registro de proveedores')

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

@section('app', 'ng-app="proveedoresApp"')

@section('controller','ng-controller="proveedoresCrearController"')
@section('titulo','Proveedores')
@section('subtitulo','Formulario para el registro de proveedores')
@section('content')
{{-- <div class="alert alert-info">
    <p>En la pestaña Información básica debe ingresar la información del proveedor seleccionado en <strong>idioma inglés.</strong></p>
</div> --}}
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
            <li ng-class="{'disabled': (proveedor.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
            <li ng-class="{'disabled': (proveedor.id == -1)}"><a data-toggle="tab" href="#adicional">Información adicional</a></li>
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
                
                <form novalidate role="form" name="crearProveedorForm">
                    <fieldset>
                        <legend>Información básica del proveedor</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (crearProveedorForm.$submitted || crearProveedorForm.proveedor.$touched) && crearProveedorForm.proveedor.$error.required}">
                                    <label for="proveedor"><span class="asterisk">*</span> Proveedor</label>
                                    
                                    <ui-select theme="bootstrap" ng-change="selectionChanged($select.selected); proveedor.datosGenerales.nombre = $select.selected.razon_social" ng-required="true" ng-model="proveedor.datosGenerales.proveedor_rnt_id" id="proveedor" name="proveedor">
                                       <ui-select-match placeholder="Nombre del proveedor.">
                                           <span ng-bind="$select.selected.razon_social"></span>
                                       </ui-select-match>
                                       <ui-select-choices repeat="proveedor.id as proveedor in (proveedores| filter: $select.search)">
                                           <span ng-bind="proveedor.razon_social" title="@{{proveedor.razon_social}}"></span>
                                       </ui-select-choices>
                                    </ui-select>
                                    
                                </div>        
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (crearProveedorForm.$submitted || crearProveedorForm.nombre.$touched) && crearProveedorForm.nombre.$error.required}">
                                    <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                                    <input max="255" required ng-model="proveedor.datosGenerales.nombre" type="text" name="nombre" id="nombre" class="form-control" placeholder="Máximo 255 caracteres."/>
                                </div>
                            </div>
                            <!--<div class="col-xs-12 col-sm-6">-->
                            <!--    <div class="form-group col-sm-6">-->
                            <!--        <label for="nombre">Nombre</label>-->
                            <!--        <p class="form-control-static">@{{nombreProveedor}}</p>-->
                                    
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (crearProveedorForm.$submitted || crearProveedorForm.descripcion.$touched) && crearProveedorForm.descripcion.$error.required}">
                                    <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                                    <ng-ckeditor  
                                              ng-model="proveedor.datosGenerales.descripcion"
                                               
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              name="descripcion"
                                              required
                                              >
                                    </ng-ckeditor>
                                    <span class="messages" ng-show="crearProveedorForm.$submitted || crearProveedorForm.descripcion.$touched">
                                        <span ng-show="crearProveedorForm.descripcion.$error.required" class="text-error">* El campo es obligatorio.</span>
                                    </span>   
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (crearProveedorForm.$submitted || crearProveedorForm.valor_minimo.$touched) && (crearProveedorForm.valor_minimo.$error.required || crearProveedorForm.valor_minimo.$error.min)}">
                                    <label for="valor_minimo"><span class="asterisk">*</span> Valor mínimo ($)</label>
                                    <input min="0" ng-model="proveedor.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números."/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (crearProveedorForm.$submitted || crearProveedorForm.valor_maximo.$touched) && (crearProveedorForm.valor_maximo.$error.required || crearProveedorForm.valor_maximo.$error.min)}">
                                    <label for="valor_maximo"><span class="asterisk">*</span> Valor máximo ($)</label>
                                    <input min="@{{proveedor.datosGenerales.valor_minimo}}" ng-model="proveedor.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números."/>
                                    <span class="text-error" ng-if="(crearProveedorForm.$submitted || crearProveedorForm.valor_maximo.$touched) && crearProveedorForm.valor_maximo.$error.min">El valor máximo no puede ser menor al mínimo</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="horario">Horario</label>
                                    <input ng-model="proveedor.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="pagina_web">Página web</label>
                                    <input ng-model="proveedor.datosGenerales.pagina_web" type="url" name="pagina_web" id="pagina_web" class="form-control" placeholder="Máximo 255 caracteres."/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input ng-model="proveedor.datosGenerales.telefono" type="tel" name="telefono" id="telefono" class="form-control" placeholder="Máximo 100 caracteres."/>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (proveedor.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
                                <a href="{{asset('/administradorproveedores')}}" class="btn btn-lg btn-default">Cancelar</a>
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
                            <div class="col-xs-12">
                                <label><span class="asterisk">*</span> Imagen de portada</label>
                                <file-input ng-model="portadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                                
                            </div>
                            <div class="col-xs-12">
                                <br/>
                                <label>Subir imágenes</label>
                                <file-input ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                                
                            </div>
                            <div class="col-xs-12">
                                <br/>
                                <label for="video_promocional">Video promocional</label>
                                <input type="text" name="video_promocional" id="video_promocional" class="form-control" placeholder="URL del video de YouTube" />
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (proveedor.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradorproveedores')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                        
                    </form>
                </fieldset>
                
                
            </div>
            
            <!--Información adicional-->
            <div id="adicional" class="tab-pane fade">
                <fieldset>
                    <legend>Información adicional</legend>
                    <div class="alert alert-info">
                        <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                    </div>
                    <form novalidate role="form" name="informacionAdicionalForm">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.perfiles.$touched) && informacionAdicionalForm.perfiles.$error.required}">
                                    <label for="perfiles"><span class="asterisk">*</span> Perfiles del turista <span class="text-error text-msg">(Seleccione al menos un perfil)</span></label>
                                    <ui-select name="perfiles" id="perfiles" multiple ng-required="true" ng-model="proveedor.adicional.perfiles" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                                            <span ng-bind="$item.perfiles_usuarios_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="perfil.id as perfil in (perfiles_turista| filter: $select.search)">
                                            <span ng-bind="perfil.perfiles_usuarios_con_idiomas[0].nombre" title="@{{perfil.perfiles_usuarios_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.categorias.$touched) && informacionAdicionalForm.categorias.$error.required}">
                                    <label for="categorias"><span class="asterisk">*</span> Categorías de turismo <span class="text-error text-msg">(Seleccione al menos una categoría)</span></label>
                                    <ui-select name="categorias" id="categorias" multiple ng-required="true" ng-model="proveedor.adicional.categorias" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione una o varias categorías de turismo.">
                                            <span ng-bind="$item.categoria_turismo_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="categoria.id as categoria in (categorias_turismo| filter: $select.search)">
                                            <span ng-bind="categoria.categoria_turismo_con_idiomas[0].nombre" title="@{{categoria.categoria_turismo_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="perfiles">Actividades <small>(Seleccione al menos una actividad)</small></label>
                                <ui-select multiple ng-model="proveedor.adicional.actividades" theme="bootstrap" close-on-select="false" >
                                    <ui-select-match placeholder="Seleccione una o varias actividades.">
                                        <span ng-bind="$item.actividades_con_idiomas[0].nombre"></span>
                                    </ui-select-match>
                                    <ui-select-choices repeat="actividad.id as actividad in (actividades| filter: $select.search)">
                                        <span ng-bind="actividad.actividades_con_idiomas[0].nombre" title="@{{actividad.actividades_con_idiomas[0].nombre}}"></span>
                                    </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (proveedor.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                                <a href="{{asset('/administradorproveedores')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </fieldset>
                
                
            </div>
        </div>
@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/services.js')}}"></script>
<script src="{{asset('/js/administrador/proveedores/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
@endsection
