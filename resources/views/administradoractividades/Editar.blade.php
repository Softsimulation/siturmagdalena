
@extends('layout._AdminLayout')

@section('title', 'Editar actividad')

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
    </style>
@endsection

@section('TitleSection', 'Editar actividad')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="actividadesApp"')

@section('controller','ng-controller="actividadesEditarController"')

@section('content')
<div class="col-sm-12">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <h1 class="title1">@{{actividadNombre}} - Editar</h1>
    <br />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradoractividades')}}">Volver al listado</a>
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
                <h2>Datos de la actividad</h2>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                            <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Los campos marcados con asterisco son obligatorios.</strong> </div>
                        </div>
                    </div>
                </div>
                <form novalidate role="form" name="editarActividadForm">
                    <div class="row">
                        <div class="form-group col-sm-6" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.valor_minimo.$touched) && crearActividadForm.valor_minimo.$error.required}">
                            <label for="valor_minimo">Valor mínimo ($)</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input min="0" ng-model="actividad.datosGenerales.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" ng-class="{'has-error': (crearActividadForm.$submitted || crearActividadForm.valor_maximo.$touched) && crearActividadForm.valor_maximo.$error.required}">
                            <label for="valor_maximo">Valor máximo ($)</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input min="@{{actividad.datosGenerales.valor_minimo}}" ng-model="actividad.datosGenerales.valor_maximo" required type="number" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" ng-click="guardarDatosGenerales()" class="btn btn-lg btn-success">Guardar</button>
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
                <form novalidate role="form" name="editarMultimediaForm">
                    <div class="row">
                        <h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Imagen de portada</h4>
                        <div class="col-sm-12">
                            <file-input ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                        </div>
                    </div>
                    <div>
                        <h4>Subir imágenes</h4>
                        <div class="col-sm-12">
                            <file-input ng-model="imagenes" preview="previewImagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button ng-click="guardarMultimedia()" type="submit" class="btn btn-lg btn-success" >Guardar</button>
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
                            <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Sitios <small>(Seleccione al menos un sitio)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="actividad.adicional.sitios" theme="bootstrap" close-on-select="false" >
                                <ui-select-match placeholder="Seleccione uno o varios sitios.">
                                    <span ng-bind="$item.sitios_con_idiomas[0].nombre"></span>
                                </ui-select-match>
                                <ui-select-choices repeat="sitio.id as sitio in (sitios| filter: $select.search)">
                                    <span ng-bind="sitio.sitios_con_idiomas[0].nombre" title="@{{sitio.sitios_con_idiomas[0].nombre}}"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Perfiles del turista <small>(Seleccione al menos un perfil)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="actividad.adicional.perfiles" theme="bootstrap" close-on-select="false" >
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
                            <label for="perfiles"><h4><span class="text-danger"><span class="glyphicon glyphicon-asterisk"></span></span> Categorías de turismo <small>(Seleccione al menos una categoría)</small></h4></label>
                            <ui-select multiple ng-required="true" ng-model="actividad.adicional.categorias" theme="bootstrap" close-on-select="false" >
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
                            <button type="submit"  class="btn btn-lg btn-success" ng-click="guardarAdicional()">Guardar</button>
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
<script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/services.js')}}"></script>
<script src="{{asset('/js/administrador/actividades/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
@endsection
