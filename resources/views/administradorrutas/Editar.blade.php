
@extends('layout._AdminLayout')

@section('title', 'Formulario para la modificación de rutas turísticas')

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


@section('app', 'ng-app="rutasApp"')

@section('controller','ng-controller="rutasEditarController"')

@section('titulo','Rutas turísticas')
@section('subtitulo','Formulario para la modificación de rutas turísticas')

@section('content')
<div class="text-center">
    <div class="alert alert-info">
        <p>Ruta a modificar:</p>
        <h3 style="margin: 0">@{{rutaNombre}}</h3>
    </div>
    
</div>
<input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#multimedia">Multimedia</a></li>
    <li><a data-toggle="tab" href="#adicional">Información adicional</a></li>
</ul>
        <div class="tab-content">
            
            <!--Multimedia-->
            <div id="multimedia" class="tab-pane fade in active">
                <fieldset>
                    <legend>Multimedia</legend>
                    @include('layout.partial._recomendacionesSubidaImagenes')
                    <form novalidate role="form" name="multimediaForm">
                        <div class="row">
                            <label><span class="asterisk">*</span> Imagen de portada</label>
                            <div class="col-sm-12">
                                <file-input ng-model="portadaIMG" preview="previewportadaIMG" accept="image/*" icon-class="glyphicon glyphicon-plus" id-input="portadaIMG" label="Seleccione la imagen de portada."></file-input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button ng-click="guardarMultimedia()" type="submit" class="btn btn-lg btn-success" >Guardar</button>
                                <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
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
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (informacionAdicionalForm.$submitted || informacionAdicionalForm.atracciones.$touched) && informacionAdicionalForm.atracciones.$error.required}">
                                    <label for="atracciones"><span class="asterisk">*</span> Atracciones de la ruta <span class="text-error text-msg">(Seleccione al menos una atracción)</span></label>
                                    <ui-select name="atracciones" id="atracciones" multiple ng-required="true" ng-model="ruta.adicional.atracciones" theme="bootstrap" close-on-select="false" >
                                        <ui-select-match placeholder="Seleccione uno o varios perfiles de usuario.">
                                            <span ng-bind="$item.sitio.sitios_con_idiomas[0].nombre"></span>
                                        </ui-select-match>
                                        <ui-select-choices repeat="atraccion.id as atraccion in (atracciones| filter: $select.search)">
                                            <span ng-bind="atraccion.sitio.sitios_con_idiomas[0].nombre" title="@{{atraccion.sitio.sitios_con_idiomas[0].nombre}}"></span>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit"  class="btn btn-lg btn-success" ng-click="guardarAdicional()">Guardar</button>
                                 <a href="{{asset('/administradorrutas')}}" class="btn btn-lg btn-default">Cancelar</a>
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
<script src="{{asset('/js/administrador/rutas/crearController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/indexController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/idiomaController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/editarController.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/services.js')}}"></script>
<script src="{{asset('/js/administrador/rutas/app.js')}}"></script>
@endsection
