
@extends('layout._AdminLayout')

@section('title', 'Nuevo destino')

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

@section('TitleSection', 'Nuevo destino')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="destinosApp"')

@section('controller','ng-controller="destinosCrearController"')

@section('content')
<div class="col-sm-12">
    <h1 class="title1">Insertar destino</h1>
    <br />
    <div class="col-col-sm-12">
        <a href="{{asset('/administradordestinos')}}">Volver al listado</a>
    </div>
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
            <li><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
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
                <h2>Datos del destino</h2>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1" style="background-color: rgba(255,216,0,.5)"><span class="glyphicon glyphicon-asterisk"></span></span>
                            <div role="textbox" class="form-control" style="background-color: rgba(255,216,0,.5)"><strong>Los campos marcados con asterisco son obligatorios.</strong> </div>
                        </div>
                    </div>
                </div>
                <form novalidate role="form" name="crearDestinoForm">
                    <div class="row">
                        <div class="form-group col-sm-6" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.nombre.$touched) && crearDestinoForm.nombre.$error.required}">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <input ng-model="destino.datosGenerales.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del destino (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(crearDestinoForm.$submitted || crearDestinoForm.nombre.$touched) && crearDestinoForm.nombre.$error.required"></span>
                            </div>
                        </div>
                        <div class="form-group col-sm-6" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.tipo.$touched) && crearDestinoForm.tipo.$error.required}">
                            <label for="sector">Tipo de destino</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <ui-select theme="bootstrap" ng-required="true" ng-model="destino.datosGenerales.tipo" id="tipo" name="tipo">
                                   <ui-select-match placeholder="Tipo de destino.">
                                       <span ng-bind="$select.selected.tipo_destino_con_idiomas[0].nombre"></span>
                                   </ui-select-match>
                                   <ui-select-choices repeat="tipo.id as tipo in (tipos_sitio| filter: $select.search)">
                                       <span ng-bind="tipo.tipo_destino_con_idiomas[0].nombre" title="@{{tipo.tipo_destino_con_idiomas[0].nombre}}"></span>
                                   </ui-select-choices>
                                </ui-select>
                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(crearDestinoForm.$submitted || crearDestinoForm.tipo.$touched) && crearDestinoForm.tipo.$error.required"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12" ng-class="{'has-error': (crearDestinoForm.$submitted || crearDestinoForm.descripcion.$touched) && crearDestinoForm.descripcion.$error.required}">
                            <label for="descripcion">Descripción</label>
                            <div class="input-group">
                                <div class="input-group-addon" title="Campo requerido"><span class="glyphicon glyphicon-asterisk"></span></div>
                                <textarea style="resize: none;" ng-model="destino.datosGenerales.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del destino (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                                <span class="glyphicon glyphicon-exclamation-sign form-control-feedback" aria-hidden="true" ng-if="(crearDestinoForm.$submitted || crearDestinoForm.descripcion.$touched) && crearDestinoForm.descripcion.$error.required"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: flex;">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="adress">Dirección</label>
                                <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                            </div>
                        </div>
                        <div class="col-sm-3" style="align-self: flex-end;">
                            <button type="button" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" >
                            <div id="direccion_map" style="height: 400px;">
                                
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button type="submit" ng-click="guardarDatosGenerales()" ng-class="{'disabled': (destino.id != -1)}" class="btn btn-lg btn-success">Guardar</button>
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
                        <h4>Galería de imágenes (Max. 5 imágenes)</h4>
                        <div class="col-sm-12">
                            <file-input ng-model="imagenes" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="imagenes" label="Seleccione las imágenes de la atracción." multiple max-files="5"></file-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <label for="video"><h4>Video (opcional)</h4></label>
                            <input type="text" name="video" id="video" class="form-control" placeholder="URL del video de YouTube" />
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <button ng-click="guardarMultimedia()" type="submit" ng-class="{'disabled': (destino.id == -1)}" class="btn btn-lg btn-success" >Guardar</button>
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
<script src="{{asset('/js/administrador/destinos/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/services.js')}}"></script>
<script src="{{asset('/js/administrador/destinos/app.js')}}"></script>
<script src="{{asset('/js/plugins/directiva-tigre.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
@endsection
