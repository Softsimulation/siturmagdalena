
@extends('layout._AdminLayout')

@section('title', 'Nueva atracción')

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

@section('TitleSection', 'Nueva atracción')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('app', 'ng-app="atraccionesApp"')

@section('controller','ng-controller="atraccionesCrearController"')

@section('content')
<div class="container">
    <h1 class="title1">Insertar atracción</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#info">Información básica</a></li>
            <li><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
            <li><a data-toggle="tab" href="#adicional">Información adicional</a></li>
        </ul>
        <div class="tab-content">
            <!--Información básica-->
            <div id="info" class="tab-pane fade in active">
                <h2>Datos de la atracción</h2>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Los campos marcados con <strong>*</strong> son obligatorios.
                </div>
                <form novalidate role="form" name="crearAtraccionForm">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">*</span>
                                <input ng-model="atraccion.nombre" required type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la atracción (Máximo 150 caracteres)" aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="descripcion">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">*</span>
                                <textarea style="resize: none;" ng-model="atraccion.descripcion" rows="5" required name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la atracción (De 100 a 1,000 caracteres)" aria-describedby="basic-addon1"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="valor_minimo">Valor mínimo ($)</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">*</span>
                                <input ng-model="atraccion.valor_minimo" required type="number" name="valor_minimo" id="valor_minimo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="valor_maximo">Valor máximo ($)</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">*</span>
                                <input ng-model="atraccion.valor_maximo" required type="numbers" name="valor_maximo" id="valor_maximo" class="form-control" placeholder="Sólo números." aria-describedby="basic-addon1"/>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="sector">Sector</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">*</span>
                                <ui-select theme="bootstrap" ng-required="true" ng-model="atraccion.sector_id" id="sector" name="sector">
                                   <ui-select-match placeholder="Nombre del sector.">
                                       <span ng-bind="$select.selected.sectores_con_idiomas[0].nombre"></span>
                                   </ui-select-match>
                                   <ui-select-choices group-by="sector.destino.destino_con_idiomas[0].nombre" repeat="sector.id as sector in (sectores| filter: $select.search)">
                                       <span ng-bind="sector.sectores_con_idiomas[0].nombre" title="@{{sector.sectores_con_idiomas[0].nombre}}"></span>
                                   </ui-select-choices>
                                </ui-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="direccion">Dierección</label>
                            <input ng-model="atraccion.direccion" type="text" name="direccion" id="direccion" class="form-control" placeholder="Máximo 150 caracteres."/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="horario">Horario</label>
                            <input ng-model="atraccion.horario" type="text" name="horario" id="horario" class="form-control" placeholder="Máximo 255 caracteres."/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input ng-model="atraccion.telefono" type="tel" name="telefono" id="telefono" class="form-control" placeholder="Máximo 100 caracteres."/>
                            </div>
                            <div class="form-group">
                                <label for="pagina_web">Página web</label>
                                <input ng-model="atraccion.pagina_web" type="text" name="pagina_web" id="pagina_web" class="form-control" placeholder="Máximo 255 caracteres."/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="actividad">Periodo de actividad e inactividad</label>
                                <textarea style="resize: none;" rows="4" class="form-control" id="actividad" name="actividad" ng-model="atraccion.actividad" placeholder="Máximo 1,000 caracteres."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="recomendaciones">Recomendaciones</label>
                            <textarea style="resize: none;" rows="5" class="form-control" id="recomendaciones" name="recomendaciones" ng-model="atraccion.recomendaciones" placeholder="Máximo 1,000 caracteres."></textarea>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="reglas">Reglas</label>
                            <textarea style="resize: none;" rows="5" class="form-control" id="reglas" name="reglas" ng-model="atraccion.reglas" placeholder="Reglas o normas que deben seguir los visitantes. Máximo 1,000 caracteres."></textarea>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="como_llegar">Como llegar</label>
                            <textarea style="resize: none;" rows="5" class="form-control" id="como_llegar" name="como_llegar" ng-model="atraccion.como_llegar" placeholder="Pasos o indicaciones para llegar al lugar. Máximo 1,000 caracteres."></textarea>
                        </div>
                    </div>
                    <div class="row" style="display: flex;">
                        <form class="form-inline" novalidate>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="adress">Dirección</label>
                                    <input required type="text" class="form-control" id="address" name="address" placeholder="Ingrese una dirección">
                                </div>
                            </div>
                            <div class="col-sm-3" style="align-self: flex-end;">
                                <button type="submit" ng-click="searchAdress()" class="btn btn-default">Buscar</button>
                            </div>
                        </form>
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
                            <button type="submit" class="btn btn-lg btn-success">Guardar cambios</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade">
                <h3>Multimedia</h3>
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Tenga en cuenta que para subir imágenes.</strong>
                    <ul>
                        <li>Se recomienda que las imágenes presenten buena calidad (mínimo recomendado 850px × 480px).</li>
                        <li>Puede subir máximo 5 imágenes por atracción. El peso de cada imagen debe ser menor o igual a 2MB.</li>
                        <li>Si alguna de sus imágenes sobrepasa el tamaño permitido se le sugiere comprimir la imagen en <a href="https://compressor.io" target="_blank">compressor.io <span class="glyphicon glyphicon-share"></span></n></a>, <a href="http://optimizilla.com" target="_blank">optimizilla.com <span class="glyphicon glyphicon-share"></span></a>, o cualquier otro compresor de imágenes.</li>
                        <li>Para seleccionar varias imágenes debe mantener presionada la tecla ctrl o arrastre el ratón sobre las imágenes que desea seleccionar.</li>
                    </ul>
                </div>
            </div>
            
            <!--Información adicional-->
            <div id="adicional" class="tab-pane fade">
                <h3>Información adicional</h3>
                <p>Some content in menu 2.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('/js/administrador/atracciones/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/services.js')}}"></script>
<script src="{{asset('/js/administrador/atracciones/app.js')}}"></script>
<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
<script src="{{asset('/js/plugins/gmaps.js')}}"></script>
@endsection
