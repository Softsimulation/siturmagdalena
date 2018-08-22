
@extends('layout._AdminLayout')

@section('title', 'Nuevo evento')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

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

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
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

@section('TitleSection', 'Nuevo evento')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="eventosApp"')

@section('controller','ng-controller="eventosCrearController"')

@section('content')
<div class="col-sm-12">
    <h1 class="title1">Insertar evento</h1>
    <br />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradoreventos')}}">Volver al listado</a>
    </div>
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
                <h2>Datos del evento</h2>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                            <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Los campos marcados con asterisco son obligatorios.</strong> </div>
                        </div>
                    </div>
                </div>
                <form novalidate role="form" name="crearEventoForm">
                    <div class="row">
                        <div class="form-group col-sm-8" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.nombre.$touched) && crearEventoForm.nombre.$error.required}">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input ng-model="evento.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del evento (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="edicion">Edición</label>
                            <input class="form-control" placeholder="Máximo 50 caracteres." max="50" ng-model="evento.datosGenerales.edicion" type="text" name="edicion" id="edicion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.descripcion.$touched) && crearEventoForm.descripcion.$error.required}">
                            <label for="descripcion">Descripción</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <textarea style="resize: none;" ng-model="evento.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del evento (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.valor_minimo.$touched) && crearEventoForm.valor_minimo.$error.required}">
                            <label for="valor_minimo">Valor mínimo ($)</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input min="0" ng-model="evento.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-4" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.valor_maximo.$touched) && crearEventoForm.valor_maximo.$error.required}">
                            <label for="valor_maximo">Valor máximo ($)</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input min="@{{evento.datosGenerales.valor_minimo}}" ng-model="evento.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-4" ng-class="{'has-error': (crearEventoForm.$submitted || crearEventoForm.tipo_evento.$touched) && crearEventoForm.tipo_evento.$error.required}">
                            <label for="tipo_evento">Tipo de evento</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
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
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-xs-12 col-md-6" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(crearEventoForm.$submitted || crearEventoForm.fecha_inicio.$touched) && crearEventoForm.fecha_inicio.$error.required]">
                            <label class="control-label" for="fecha_inicio">Fecha de inicio del evento</label> <span class="text-error" ng-show="(crearEventoForm.$submitted || crearEventoForm.fechaini.$touched) && crearEventoForm.fechaini.$error.required">(El campo es obligatorio)</span>
                            <div class="input-group" id='fecha_inicio'>
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <adm-dtp name="fecha_inicio" id="fecha_inicio" ng-model='evento.datosGenerales.fecha_inicio' full-data="fecha_inicio_detail" mindate="@{{fechaActual}}" maxdate="@{{fecha_final_detail.unix}}"
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(crearEventoForm.$submitted || crearEventoForm.fechaini.$touched) && crearEventoForm.fechaini.$error.required"></span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-xs-12 col-md-6" ng-class="{true:'form-group has-error has-feedback',false:'form-group'}[(crearEventoForm.$submitted || crearEventoForm.fecha_final.$touched) && crearEventoForm.fecha_final.$error.required]">
                            <label class="control-label" for="fecha_final">Fecha de finalización del evento</label> <span class="text-error" ng-show="(crearEventoForm.$submitted || crearEventoForm.fecha_final.$touched) && crearEventoForm.fecha_final.$error.required">(El campo es obligatorio)</span>
                            <div class="input-group" id='fechafin'>
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <adm-dtp name="fecha_final" id="fecha_final" ng-model='evento.datosGenerales.fecha_final' full-data="fecha_final_detail" mindate="@{{fecha_inicio_detail.unix}}" disable='@{{!evento.datosGenerales.fecha_inicio}}'
                                                 options="optionFecha" ng-required="true"></adm-dtp>
                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(crearEventoForm.$submitted || crearEventoForm.fecha_final.$touched) && crearEventoForm.fecha_final.$error.required"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="telefono">Teléfono</label>
                            <input ng-model="evento.datosGenerales.telefono" type="tel" name="telefono" id="telefono" class="form-control" placeholder="Máximo 100 caracteres."/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="horario">Horario</label>
                            <input ng-model="evento.datosGenerales.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="pagina_web">Página web</label>
                            <input ng-model="evento.datosGenerales.pagina_web" type="text" name="pagina_web" id="pagina_web" class="form-control" placeholder="Máximo 255 caracteres."/>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (evento.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade">
                <h3>Multimedia</h3>
                <div class="alert-warning alert-dismissible" role="alert">
                    <strong>Tenga en cuenta que para subir imágenes.</strong>
                    <ul>
                        <li>Se recomienda que las imágenes presenten buena calidad (mínimo recomendado 850px × 480px).</li>
                        <li>Puede subir máximo 5 imágenes por atracción. El peso de cada imagen debe ser menor o igual a 2MB.</li>
                        <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://compressor.io" target="_blank">compressor.io <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                        <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
                    </ul>
                </div>
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
                            <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (evento.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
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
                        <div class="col-sm-12">
                            <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Perfiles del turista <small>(Seleccione al menos un perfil)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="evento.adicional.perfiles" theme="bootstrap" close-on-select="false" >
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
                        <div class="col-sm-12">
                            <label for="sitios"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Sitios <small>(Seleccione al menos un sitio)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="evento.adicional.sitios" theme="bootstrap" close-on-select="false" >
                                <ui-select-match placeholder="Seleccione uno o varios sitios.">
                                    <span ng-bind="$item.sitios_con_idiomas[0].nombre"></span>
                                </ui-select-match>
                                <ui-select-choices repeat="sitio.id as sitio in (sitios| filter: $select.search)">
                                    <div ng-bind="sitio.sitios_con_idiomas[0].nombre" title="@{{sitio.sitios_con_idiomas[0].nombre}}"></div>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Categorías de turismo <small>(Seleccione al menos una categoría)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="evento.adicional.categorias" theme="bootstrap" close-on-select="false" >
                                <ui-select-match placeholder="Seleccione una o varias categorías de turismo.">
                                    <span ng-bind="$item.categoria_turismo_con_idiomas[0].nombre"></span>
                                </ui-select-match>
                                <ui-select-choices repeat="categoria.id as categoria in (categorias_turismo| filter: $select.search)">
                                    <span ng-bind="categoria.categoria_turismo_con_idiomas[0].nombre" title="@{{categoria.categoria_turismo_con_idiomas[0].nombre}}"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit"  class="btn btn-lg btn-success" ng-class="{'disabled': (evento.id == -1)}" ng-click="guardarAdicional()">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
@endsection
