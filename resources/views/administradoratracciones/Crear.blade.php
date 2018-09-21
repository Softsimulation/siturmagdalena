
@extends('layout._AdminLayout')

@section('title', 'Nueva atracción')

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
        
        .ui-select-container{
            width: 100%;
        }
        .ui-select-container span{
            margin-top: 0;
        }
    </style>
@endsection

@section('TitleSection', 'Nueva atracción')

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesCrearController"')
@section('titulo','Atracciones')
@section('subtitulo','Formulario para el registro de atracciones')

@section('content')

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
    <li ng-class="{'disabled': (atraccion.id == -1)}"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
    <li ng-class="{'disabled': (atraccion.id == -1)}"><a data-toggle="tab" href="#adicional">Información adicional</a></li>
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
        
        
        <form novalidate role="form" name="crearAtraccionForm">
            <fieldset>
                <legend>Información básica de la atracción</legend>
                <div class="alert alert-info">
                    <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-2 col-sm-12">
                        <div class="form-group" ng-class="{'has-error': (crearAtraccionForm.$submitted || crearAtraccionForm.nombre.$touched) && crearAtraccionForm.nombre.$error.required}">
                            <label for="nombre"><span class="asterisk">*</span> Nombre</label>
                            <input ng-model="atraccion.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la atracción. Máx. 150 caracteres"/>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-12">
                        <div class="form-group" ng-class="{'has-error': (crearAtraccionForm.$submitted || crearAtraccionForm.descripcion.$touched) && crearAtraccionForm.descripcion.$error.required}">
                            <label for="descripcion"><span class="asterisk">*</span> Descripción</label>
                            <textarea style="resize: none;" ng-model="atraccion.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la atracción (De 100 a 1,000 caracteres)"></textarea>
                            
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-4">
                        <div class="form-group" ng-class="{'has-error': (crearAtraccionForm.$submitted || crearAtraccionForm.valor_minimo.$touched) && (crearAtraccionForm.valor_minimo.$error.required || crearAtraccionForm.valor_minimo.$error.min)}">
                            <label for="valor_minimo"><span class="asterisk">*</span> Valor mínimo ($)</label>
                            <input ng-model="atraccion.datosGenerales.valor_minimo" min="0" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números."/>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-4">
                        <div class="form-group" ng-class="{'has-error': (crearAtraccionForm.$submitted || crearAtraccionForm.valor_maximo.$touched) && (crearAtraccionForm.valor_maximo.$error.required || crearAtraccionForm.valor_maximo.$error.min)}">
                            <label for="valor_maximo"><span class="asterisk">*</span>  Valor máximo ($)</label>
                            <input min="@{{atraccion.datosGenerales.valor_minimo}}" ng-model="atraccion.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números."/>
                            <span class="text-error" ng-if="(crearAtraccionForm.$submitted || crearAtraccionForm.valor_maximo.$touched) && crearAtraccionForm.valor_maximo.$error.min">El valor máximo no puede ser menor al mínimo</span>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-4">
                        <div class="form-group" ng-class="{'has-error': (crearAtraccionForm.$submitted || crearAtraccionForm.sector.$touched) && crearAtraccionForm.sector.$error.required}">
                            <label for="sector"><span class="asterisk">*</span> Sector</label>
                            <ui-select theme="bootstrap" ng-required="true" ng-model="atraccion.datosGenerales.sector_id" id="sector" name="sector">
                               <ui-select-match placeholder="Nombre del sector.">
                                   <span ng-bind="$select.selected.sectores_con_idiomas[0].nombre"></span>
                               </ui-select-match>
                               <ui-select-choices group-by="groupByDestino" repeat="sector.id as sector in (sectores| filter: $select.search)">
                                   <span ng-bind="sector.sectores_con_idiomas[0].nombre" title="@{{sector.sectores_con_idiomas[0].nombre}}"></span>
                               </ui-select-choices>
                            </ui-select>
                            
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input ng-model="atraccion.datosGenerales.direccion" type="text" name="direccion" id="direccion" class="form-control" placeholder="Máximo 150 caracteres."/>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-group">
                            <label for="horario">Horario</label>
                            <input ng-model="atraccion.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input ng-model="atraccion.datosGenerales.telefono" type="tel" name="telefono" id="telefono" class="form-control" placeholder="Máximo 100 caracteres."/>
                        </div>
                        <div class="form-group">
                            <label for="pagina_web">Página web</label>
                            <input ng-model="atraccion.datosGenerales.pagina_web" type="text" name="pagina_web" id="pagina_web" class="form-control" placeholder="Ej: http://www.dominio.com. Máx. 255 caracteres."/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label for="actividad">Periodo de actividad e inactividad</label>
                            <textarea style="resize: none;" rows="4" class="form-control" id="actividad" name="actividad" ng-model="atraccion.datosGenerales.actividad" placeholder="Máximo 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label for="recomendaciones">Recomendaciones</label>
                            <textarea style="resize: none;" rows="6" class="form-control" id="recomendaciones" name="recomendaciones" ng-model="atraccion.datosGenerales.recomendaciones" placeholder="Máximo 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label for="reglas">Reglas</label>
                            <textarea style="resize: none;" rows="6" class="form-control" id="reglas" name="reglas" ng-model="atraccion.datosGenerales.reglas" placeholder="Reglas o normas que deben seguir los visitantes. Máximo 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <label for="como_llegar">Cómo llegar</label>
                            <textarea style="resize: none;" rows="6" class="form-control" id="como_llegar" name="como_llegar" ng-model="atraccion.datosGenerales.como_llegar" placeholder="Pasos o indicaciones para llegar al lugar. Máximo 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 form-inline text-center">
                        <div class="form-group">
                            <label for="adress">Dirección</label>
                            <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                        </div>
                        <button type="button" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                    </div>
                    <div class="col-xs-12" >
                        <div id="direccion_map" style="height: 400px;margin: 1rem 0;">
                            
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
                        <a href="{{asset('/administradoratracciones')}}" class="btn btn-lg btn-default">Cancelar</a>
                    </div>
                </div>
            </fieldset>
            
        </form>
    </div>
    
    <!--Multimedia-->
    <div id="multimedia" class="tab-pane fade">
        <h3>Multimedia</h3>
        @include('layout.partial._recomendacionesSubidaImagenes')
        <form novalidate role="form" name="multimediaForm">
            <div class="row">
                <h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Imagen de portada</h4>
                <div class="col-sm-12">
                    <file-input ng-model="portadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                </div>
            </div>
            <div>
                <h4>Subir imágenes</h4>
                <div class="col-sm-12">
                    <file-input ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="video_promocional"><h4>Video promocional</h4></label>
                    <input type="text" name="video_promocional" id="video_promocional" class="form-control" placeholder="URL del video de YouTube" />
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (atraccion.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
                </div>
            </div>
        </form>
    </div>
    
    <!--Información adicional-->
    <div id="adicional" class="tab-pane fade">
        <h3>Información adicional</h3>
        <div class="row">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                    <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Los campos marcados con asterisco son obligatorios.</strong> </div>
                </div>
            </div>
        </div>
        <form novalidate role="form" name="informacionAdicionalForm">
            <div class="row">
                <div class="col-sm-12" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.perfiles.$touched) && informacionAdicionalForm.perfiles.$error.required}">
                    <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Perfiles del turista <small>(Seleccione al menos un perfil)</small></h4></label>
                    <ui-select name="perfiles" id="perfiles" multiple ng-required="true" ng-model="atraccion.adicional.perfiles" theme="bootstrap" close-on-select="false" >
                        <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                            <span ng-bind="$item.perfiles_usuarios_con_idiomas[0].nombre"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="perfil.id as perfil in (perfiles_turista| filter: $select.search)">
                            <span ng-bind="perfil.perfiles_usuarios_con_idiomas[0].nombre" title="@{{perfil.perfiles_usuarios_con_idiomas[0].nombre}}"></span>
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.tipos.$touched) && informacionAdicionalForm.tipos.$error.required}">
                    <label for="tipos"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Tipo de atracciones <small>(Seleccione al menos un tipo de atracción)</small></h4></label>
                    <ui-select name="tipos" id="tipos" multiple ng-required="true" ng-model="atraccion.adicional.tipos" theme="bootstrap" close-on-select="false" >
                        <ui-select-match placeholder="Seleccione uno o varios tipos de atracciones.">
                            <span ng-bind="$item.tipo_atracciones_con_idiomas[0].nombre"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="tipo.id as tipo in (tipos_atracciones| filter: $select.search)">
                            <div ng-bind="tipo.tipo_atracciones_con_idiomas[0].nombre" title="@{{tipo.tipo_atracciones_con_idiomas[0].nombre}}"></div>
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.categorias.$touched) && informacionAdicionalForm.categorias.$error.required}">
                    <label for="categorias"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Categorías de turismo <small>(Seleccione al menos una categoría)</small></h4></label>
                    <ui-select name="categorias" id="categorias" multiple ng-required="true" ng-model="atraccion.adicional.categorias" theme="bootstrap" close-on-select="false" >
                        <ui-select-match placeholder="Seleccione una o varias categorías de turismo.">
                            <span ng-bind="$item.categoria_turismo_con_idiomas[0].nombre"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="categoria.id as categoria in (categorias_turismo| filter: $select.search)">
                            <span ng-bind="categoria.categoria_turismo_con_idiomas[0].nombre" title="@{{categoria.categoria_turismo_con_idiomas[0].nombre}}"></span>
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="perfiles"><h4>Actividades <small>(Seleccione al menos una actividad)</small></h4></label>
                    <ui-select multiple ng-model="atraccion.adicional.actividades" theme="bootstrap" close-on-select="false" >
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
            <br>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (atraccion.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                </div>
            </div>
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
<script src="{{asset('/js/administrador/atracciones/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/services.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/app.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
@endsection
