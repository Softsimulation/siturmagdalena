
@extends('layout._AdminLayout')

@section('title', 'Editar proveedor')

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
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('TitleSection', 'Editar proveedor')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="proveedoresApp"')

@section('controller','ng-controller="proveedoresEditarController"')
@section('titulo','Proveedores')
@section('subtitulo','Formulario para edición de proveedores')
@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Proveedor a modificar:</p>
        <h3 style="margin: 0">@{{proveedorNombre}}</h3>
    </div>
    
</div>

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
   
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
            <li><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
            <li><a data-toggle="tab" href="#adicional">Información adicional</a></li>
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
                
               
                <form novalidate role="form" name="editarProveedorForm">
                    <fieldset>
                        <legend>Información básica del proveedor</legend>
                        <div class="alert alert-info">
                            <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                        </div>
                        <div class="row">
                            <!--<div class="col-xs-12 col-sm-12">-->
                            <!--    <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.proveedor.$touched) && editarProveedorForm.proveedor.$error.required}">-->
                            <!--        <label for="proveedor"><span class="asterisk">*</span> Proveedor</label>-->
                            <!--        <ui-select theme="bootstrap" ng-change="selectionChanged($select.selected)" ng-required="true" ng-model="proveedor.datosGenerales.proveedor_rnt_id" id="proveedor" name="proveedor">-->
                            <!--           <ui-select-match placeholder="Nombre del proveedor.">-->
                            <!--               <span ng-bind="$select.selected.razon_social"></span>-->
                            <!--           </ui-select-match>-->
                            <!--           <ui-select-choices repeat="proveedor.id as proveedor in (proveedores| filter: $select.search)">-->
                            <!--               <span ng-bind="proveedor.razon_social" title="@{{proveedor.razon_social}}"></span>-->
                            <!--           </ui-select-choices>-->
                            <!--        </ui-select>-->
                                        
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-xs-12 col-sm-12">-->
                            <!--    <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.descripcion.$touched) && editarProveedorForm.descripcion.$error.required}">-->
                            <!--        <label for="descripcion"><span class="asterisk">*</span> Descripción</label>-->
                            <!--        <textarea style="resize: none;" ng-model="proveedor.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del proveedor (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>-->
                                        
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.valor_minimo.$touched) && (editarProveedorForm.valor_minimo.$error.required || editarProveedorForm.valor_minimo.$error.min)}">
                                    <label for="valor_minimo"><span class="asterisk">*</span> Valor mínimo ($)</label>
                                    <input min="0" ng-model="proveedor.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números."/>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group" ng-class="{'has-error': (editarProveedorForm.$submitted || editarProveedorForm.valor_maximo.$touched) && (editarProveedorForm.valor_maximo.$error.required || editarProveedorForm.valor_maximo.$error.min)}">
                                    <label for="valor_maximo"><span class="asterisk">*</span> Valor máximo ($) <span class="text-error" aria-hidden="true" ng-if="editarProveedorForm.valor_maximo.$error.min">El valor máximo no puede ser menor al valor mínimo</span></label>
                                    <input min="@{{proveedor.datosGenerales.valor_minimo}}" ng-model="proveedor.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                                    
                                </div>
                            </div>
                            <!--<div class="col-xs-12 col-sm-4">-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="horario">Horario</label>-->
                            <!--        <input ng-model="proveedor.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-xs-12 col-sm-8">
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
                                <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
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
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <strong>Tenga en cuenta que para subir imágenes.</strong>
                        <ul>
                            <li>Se recomienda que las imágenes presenten buena calidad (mínimo recomendado 850px × 480px).</li>
                            <li>Puede subir máximo 5 imágenes. El peso de cada imagen debe ser menor o igual a 2MB.</li>
                            <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://compressor.io" target="_blank">compressor.io <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                            <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
                        </ul>
                    </div>
                    <form novalidate role="form" name="multimediaForm">
                        <div class="row">
                            
                            <h4><span class="asterisk">*</span> Imagen de portada</h4>
                            <div class="col-sm-12">
                                <file-input ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                            </div>
                            <h4>Subir imágenes</h4>
                            <div class="col-sm-12">
                                <file-input ng-model="imagenes" preview="previewImagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label for="video_promocional"><h4>Video promocional</h4></label>
                                <input type="text" ng-model="video_promocional" name="video_promocional" id="video_promocional" class="form-control" placeholder="URL del video de YouTube" />
                            </div>
                            <div class="col-sm-12 text-center">
                                <hr />
                                <button ng-click="guardarMultimedia()" type="submit" class="btn btn-lg btn-success" >Guardar</button>
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
                            <div class="col-sm-12">
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="perfiles">Actividades <span class="text-error text-msg">(Seleccione al menos una actividad)</span></label>
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-click="guardarAdicional()">Guardar</button>
                                <a href="{{asset('/administradorproveedores')}}" class="btn btn-lg btn-default">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </fieldset>
                
                
                
            </div>
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
@endsection
