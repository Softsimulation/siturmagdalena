@extends('layout._AdminLayout')

@section('title', 'Listado de sliders')

@section('estilos')
    
    <style>
        
        .box-tigger img {
         cursor:zoom-in;
       }
        
       .box-tigger-activo {
            position: fixed;
            margin: 0;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: #292929;
            z-index: 1000;
            will-change: opacity;
            text-align: center;
        }
        
        .box-tigger-activo img {
            cursor:zoom-out;
            z-index: 1000;
            top: 10%;
            height: 65%;
            width: auto;
            margin-top: 5%;
            position: relative;
        }
        .box-tigger-activo p {
          color: white;
        }
       .box-tigger-activo button,.box-tigger-activo a {
         display:none;
       }
        .padding {
          padding:2%;
        }
        input.ui-select-search.input-xs.ng-pristine.ng-untouched.ng-valid {
            width:100% !important;
        }
        .tile .btn:not(.btn-link) {
            box-shadow: none;
        }
        .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
            margin: 0;
        }
        .previewUpload[src=""] {
            display: none;
        }
        .btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open > .dropdown-toggle.btn-default.focus, .open > .dropdown-toggle.btn-default:focus, .open > .dropdown-toggle.btn-default:hover {
            background-color: transparent;
            color: white;
        }
        .dropdown-menu {
            bottom: 100%;
            right: 0;
            top: auto;
            left: auto;
        }
    </style>
    <style>
        .tile{
    position: relative;
    height: 151px;
    padding: 0;
    background: inherit;
	overflow: hidden;
}
.tile img{
    width: 100%;
    height: auto;
}
.tile .tittle{
    
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 2px;
    z-index: 2;
    background-color: rgba(0,0,0,.85);
    color:white;
}
.tile .tittle .dropdown{
    position:absolute;
    right:0;
    bottom: 0;
}
.tile .tittle p{
    margin: .5rem;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    padding-right: 3rem;
}
.tile .tittle .btn {
    background: transparent;
    color:white
}
.tile .tittle.activos .btn {
    color:black;
}
.imagenActual{
    height: 200px;
    width: auto;
    margin: 0 auto;
}
.tile .tittle.activos {
    background-color: yellowgreen;
    color:black;
}
/*.desactivados {
    background-color: #e0e3e5;
}*/

.box-tigger:not(.box-tigger-activo) img {
    height: 100%;
    width: auto;
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translateY(-50%) translateX(-50%);
    transform: translateY(-50%) translateX(-50%);
}
.btn-float-card {
    position: absolute;left: 0px;top: 10px; z-index: 5; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,.4);
}
.btn-float-card:hover {
    background-color: white;
}
.text-float-card {
    z-index: 5;
    position: absolute;
    bottom: 0;
    left: 0;
    background: rgba(255,255,255,.7);
    font-size: 1.2rem;
    margin: 0;
    padding: .5rem 0;
	width: 100%;
}
.text-float-card :hover{
	background: white;
}
@media only screen and (min-width: 1400px){
    .tile {
        height: 200px;
    }
}
    </style>
@endsection

@section('TitleSection', 'Listado de sliders')

@section('app','ng-app="admin.slider"')

@section('controller','ng-controller="listadoSlidersCtrl"')

@section('titulo','Galería de imágenes')
@section('subtitulo','El siguiente listado cuenta con @{{sliders.length}} registro(s)')

@section('content')
    <div class="text-center">
        <button class="btn btn-lg btn-success" type="button" ng-click="abrirModalCrearSlider()">Agregar imagen</button>
    </div>
    <hr>
    
    <div>
    <div class="alert alert-danger" ng-repeat="error in errores">
        *@{{error[0]}}
    </div>
    <div class="row">
        <div class=" col-xs-12 col-md-4 col-sm-6" ng-repeat="slider in sliders| orderBy:'-estadoSlider'">
            <div class="card tile">
                <div class="box-tigger" onclick="tigger_box(this)" >
                    <img src="@{{slider.rutaSlider}}" />
                </div>
               
                <div class="tittle" ng-class="{'activos':slider.estadoSlider==1 && slider.prioridadSlider!=0,'desactivados':slider.estadoSlider==0 && slider.prioridadSlider==0}">
                    <p title="@{{slider.tituloSlider}}">@{{slider.tituloSlider}}</p>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" title="Ver más opciones">
                            <span class="glyphicon glyphicon-option-vertical"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li ng-if="slider.estadoSlider==0"><a href="" ng-click="activarSlider(slider)">Activar</a></li>
                            <li ng-if="slider.estadoSlider==1"><a href="" ng-click="desactivarSlider(slider)" >Desactivar</a></li>
                            <li ng-if="slider.noIdiomas.length != 0"><a href="" ng-click="abrirModalAgregarIdiomaSlider(slider)" >Agregar idioma</a></li>
                            <li ng-repeat="idioma in slider.idiomas"><a href="" ng-click="abirModalEditarSlider(idioma.id,slider)" >Editar @{{idioma.nombre}} </a>
                            <li ng-if="slider.prioridadSlider!=1 && slider.prioridadSlider !=0"><a href="" ng-click="subirPrioridadSlider(slider)" >Subir Prioridad</a></li>
                            <li ng-if="slider.prioridadSlider!=8 && slider.prioridadSlider !=0"><a href="" ng-click="bajarPrioridadSlider(slider)" >Bajar Prioridad</a></li>
                        </ul>
                    </div>
                </div>
            </div>        
        </div>
        <div class="col-xs-12" ng-if="sliders.length == 0">
            <div class="alert alert-info">
                <p>No se han ingresado imágenes en el sistema.</p>
            </div>
        </div>
    </div>
</div>
    
    <!-- Modal agregar slider-->
    <div class="modal fade" id="modalAgregarSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar imagen</h4>
                </div>
                <div class="alert alert-danger" ng-repeat="error in errores">
                    *@{{error[0]}}
                </div>
                <form role="form" name="crearSliderForm" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12" style="margin-left: 0; margin-right: 0;">
                                <div class="form-group"´id="upload-ini">
                                    <label class="control-label" for="imagenSlider"><span class="asterisk">*</span> Subir imagen <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="La imagen debe tener un peso de 2MB y debe ser de formato jpeg, jpg o png"></span></label>
                                    <div class="input-upload" title="Presione para seleccionar un logo">
                                        <label for="imagenSlider">
                                            <div class="content-input-upload">
                                                <!--<img id="preview-upload" ng-if="!programa.portada" src="~/Content/Imagenes/escudo.png" alt="Imagen previa" />-->
                                                <img id="imagen-slider-crear" class="previewUpload" src="@{{programa.portada}}" alt="Imagen previa" />
                                                <div class="content">
                                                    <span class="ion-camera"></span><br />
                                                    Presione para seleccionar un logotipo (Opcional)
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" id="imagenSlider" name="imagenSlider" file-input='imagenSlider' accept=".jpg,.jpeg,.png" />
                                    </div>
                                    <span class="text-error" ng-show="(crearSliderForm.$submitted) && imagenSlider == null">La imagen es requerida</span>
                                </div>
                                
                                
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error':((crearSliderForm.$submitted || crearSliderForm.textoAlternativoSlider.$touched) && crearSliderForm.textoAlternativoSlider.$error.required)}">
                                    <label class="control-label" for="textoAlternativoSlider"><span class="asterisk">*</span> Texto alternativo</label>
                                    <textarea class="form-control" name="textoAlternativoSlider" id="textoAlternativoSlider" placeholder="Ingrese texto alternativo de la imagen seleccionada. El texto alternativo es una breve descripción del contenido de la imagen. Máx. 100 caracteres" ng-model="slider.textoAlternativoSlider" rows="4" required maxlength="100"></textarea>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="tituloSlider">Título</label>
                                    <input type="text" class="form-control" name="tituloSlider" id="tituloSlider" placeholder="Ingrese título de la imagen. Máx. 150 caracteres" maxlength="150" ng-model="slider.tituloSlider" />
    
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="enlaceInterno"><span class="asterisk">*</span> Tipo de enlace de acceso</label>
                                    <br/>
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="slider.enlaceInterno" value="1" required>Enlace interno</label>
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="slider.enlaceInterno" value="0" required>Enlace externo</label>
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="slider.enlaceInterno" value="2" required>No posee</label>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==0">
                                <div class="form-group" ng-class="{'has-error':((crearSliderForm.$submitted || crearSliderForm.enlaceExternoSlider.$touched) && (crearSliderForm.enlaceExternoSlider.$error.required || crearSliderForm.enlaceExternoSlider.$error.url))}">
                                    <label class="control-label" for="enlaceExternoSlider"><span class="asterisk">*</span> Enlace externo</label>
                                    <input type="url" class="form-control" name="enlaceExternoSlider" id="enlaceExternoSlider" placeholder="Ingrese enlace de acceso de la imagen. Máx. 500 caracteres" maxlength="500" ng-model="slider.enlaceExternoSlider" ng-required="slider.enlaceInterno==0" />
                                    
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.tipoEntidadIdSlider.$touched) && crearSliderForm.tipoEntidadIdSlider.$error.required }">
                                    <label class="control-label" for="tipoEntidadIdSlider"><span class="asterisk">*</span> Tipo de entidad</label>
                                    <select ng-model="slider.tipoEntidadIdSlider" class="form-control" id="tipoEntidadIdSlider" name="tipoEntidadIdSlider" ng-required="slider.enlaceInterno==1">
                                        <option value="" selected disabled>Seleccione el tipo de entidad</option>
                                        <option value="1">Actividad</option>
                                        <option value="2">Atracción</option>
                                        <option value="3">Destino</option>
                                        <option value="4">Evento</option>
                                        <option value="5">Ruta</option>
                                        <option value="6">Proveedor</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==1">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.actividadIdSlider.$touched) && slider.actividadIdSlider == null }">
                                    <label for="actividadIdSlider" class="control-label"><span class="asterisk">*</span> Actividad</label>
                                    <ui-select ng-model="slider.actividadIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione actividad">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.actividades_id as item in actividades | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==2">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.atraccionIdSlider.$touched) && slider.atraccionIdSlider == null }">
                                    <label for="atraccionIdSlider" class="control-label"><span class="asterisk">*</span> Atracción</label>
                                    <ui-select ng-model="slider.atraccionIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione atracción">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.id as item in atracciones | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==3">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.destinoIdSlider.$touched) && slider.destinoIdSlider == null }">
                                    <label for="atraccionIdSlider"><span class="asterisk">*</span>Destino</label>
                                    <ui-select ng-model="slider.destinoIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione destino">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.destino_id as item in destinos | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==4">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.eventoIdSlider.$touched) && slider.eventoIdSlider == null }">
                                    <label for="eventoIdSlider"><span class="asterisk">*</span> Evento</label>
                                    <ui-select ng-model="slider.eventoIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione evento">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.eventos_id as item in eventos | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==5">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.rutaIdSlider.$touched) && slider.rutaIdSlider == null }">
                                    <label for="rutaIdSlider"><span class="asterisk">*</span>Ruta</label>
                                    <ui-select ng-model="slider.rutaIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione ruta">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.ruta_id as item in rutas | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                            <div class="col-xs-12" ng-if="slider.enlaceInterno==1 && slider.tipoEntidadIdSlider==6">
                                <div class="form-group" ng-class="{'has-error': (crearSliderForm.$submitted || crearSliderForm.proveedorIdSlider.$touched) && slider.proveedorIdSlider == null }">
                                    <label for="proveedorIdSlider"><span class="asterisk">*</span>Proveedor</label>
                                    <ui-select ng-model="slider.proveedorIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione proveedor">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.proveedor_rnt_id as item in proveedores | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarSlider()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal editar slider-->
    <div class="modal fade" id="modalEditarSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar imagen</h4>
                </div>
                <div class="alert alert-danger" ng-repeat="error in errores">
                    *@{{error[0]}}
                </div>
                <form role="form" name="editarSliderForm" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12" id="upload-ini" style="margin-left: 0; margin-right: 0;">
                                <label><span class="asterisk">*</span> Subir imagen</label> <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="La imagen debe tener un peso de 2MB y debe ser de formato jpeg, jpg o png"></span>
                                <div class="input-upload" title="Presione para seleccionar un logo">
                                    <label for="imagenSliderEditar">
                                        <div class="content-input-upload">
                                            <!--<img id="preview-upload" ng-if="!programa.portada" src="~/Content/Imagenes/escudo.png" alt="Imagen previa" />-->
                                            <img id="imagen-slider-editar" class="previewUpload" src="@{{sliderEditar.rutaSlider}}" alt="Imagen previa" />
                                            <div class="content">
                                                <span class="ion-camera"></span><br />
                                                Presione para seleccionar un logotipo (Opcional)
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" id="imagenSliderEditar" name="imagenSliderEditar" file-input='imagenSliderEditar' accept=".jpg,.jpeg,.png" />
                                </div>
                                
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error':((editarSliderForm.$submitted || editarSliderForm.textoAlternativoSlider.$touched) && editarSliderForm.textoAlternativoSlider.$error.required)}">
                                    <label class="control-label" for="textoAlternativoSlider"><span class="asterisk">*</span>Texto alternativo</label>
                                    <textarea class="form-control" name="textoAlternativoSlider" id="textoAlternativoSlider" placeholder="Ingrese texto alternativo de la imagen." ng-model="sliderEditar.textoAlternativoSlider" rows="4" required></textarea>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="tituloSlider">Título</label>
                                    <input type="text" class="form-control" name="tituloSlider" id="tituloSlider" placeholder="Ingrese título de la imagen. Máx. 150 caracteres" maxlength="150" ng-model="sliderEditar.tituloSlider" />
    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12" ng-show="sliderEditar.enlaceInterno != 2 && sliderEditar.enlaceAccesoSlider != null">
                                <div class="form-group">
                                    <label class="control-label u-block" for="enlaceAcceso"><span class="asterisk">*</span>Enlace de acceso</label>
                                    <input type="text" class="form-control"id="enlaceAcceso" value="@{{sliderEditar.enlaceAccesoSlider}}" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label u-block" for="enlaceInterno"><span class="asterisk">*</span>Tipo de enlace de acceso</label>
                                    <br />
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="sliderEditar.enlaceInterno" value="1" >Enlace interno</label>
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="sliderEditar.enlaceInterno" value="-1" >Enlace externo</label>
                                    <label class="radio-inline"><input type="radio" name="enlaceInterno" id="enlaceInterno" ng-model="sliderEditar.enlaceInterno" value="2">No posee</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==-1">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error':((editarSliderForm.$submitted || editarSliderForm.enlaceExternoSliderEditar.$touched) && (editarSliderForm.enlaceExternoSliderEditar.$error.required || editarSliderForm.enlaceExternoSliderEditar.$error.url))}">
                                    <label class="control-label" for="enlaceExternoSliderEditar"><span class="asterisk" ng-show="sliderEditar.enlaceAccesoSlider == null">*</span>Enlace externo</label>
                                    <input type="url" class="form-control" name="enlaceExternoSliderEditar" id="enlaceExternoSliderEditar" placeholder="Ingrese enlace de acceso del slider. Máx. 500 caracteres" maxlength="500" ng-model="sliderEditar.enlaceExternoSlider" ng-required="sliderEditar.enlaceInterno==-1 && sliderEditar.enlaceAccesoSlider == null" />
                                    <span class="text-error" ng-show="(editarSliderForm.$submitted || editarSliderForm.enlaceExternoSlider.$touched) && editarSliderForm.enlaceExternoSlider.$error.required">&nbsp;</span>
                                    <span class="text-error" ng-show="(editarSliderForm.$submitted || editarSliderForm.enlaceExternoSlider.$touched) && editarSliderForm.enlaceExternoSlider.$error.url">El valor ingresado debe ser una dirección url</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.tipoEntidadIdSliderEditar.$touched) && crearsliderEditarForm.tipoEntidadIdSliderEditar.$error.required }">
                                    <label class="control-label" for="tipoEntidadIdSliderEditar"><span class="asterisk">*</span>Tipo de Entidad</label>
                                    <select ng-model="sliderEditar.tipoEntidadIdSlider" class="form-control" id="tipoEntidadIdSliderEditar" name="tipoEntidadIdSliderEditar" ng-required="sliderEditar.enlaceInterno==1 && sliderEditar.enlaceAccesoSlider == null">
                                        <option value="" selected disabled>Seleccione el tipo de entidad</option>
                                        <option value="1"  >Actividad</option>
                                        <option value="2"  >Atracción</option>
                                        <option value="3"  >Destino</option>
                                        <option value="4"  >Evento</option>
                                        <option value="5"  >Ruta</option>
                                        <option value="6"  >Proveedor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdsliderEditar==1">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.actividadIdSliderEditar.$touched) && sliderEditar.actividadIdSlider == null }">
                                    <label for="actividadIdSliderEditar"><span class="asterisk">*</span>Actividad</label>
                                    <ui-select ng-model="sliderEditar.actividadIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione actividad">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.actividades_id as item in actividades | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdSlider==2">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.atraccionIdsliderEditar.$touched) && sliderEditar.atraccionIdSlider == null }">
                                    <label for="atraccionIdsliderEditar"><span class="asterisk">*</span>Atracción</label>
                                    <ui-select ng-model="sliderEditar.atraccionIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione atracción">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.id as item in atracciones | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdSlider==3">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.destinoIdsliderEditar.$touched) && sliderEditar.destinoIdSlider == null }">
                                    <label for="atraccionIdsliderEditar"><span class="asterisk">*</span>Destino</label>
                                    <ui-select ng-model="sliderEditar.destinoIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione destino">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.destino_id as item in destinos | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdSlider==4">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.eventoIdsliderEditar.$touched) && sliderEditar.eventoIdSlider == null }">
                                    <label for="eventoIdsliderEditar"><span class="asterisk">*</span>Evento</label>
                                    <ui-select ng-model="sliderEditar.eventoIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione evento">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.eventos_id as item in eventos | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdSlider==5">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'has-error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.rutaIdsliderEditar.$touched) && sliderEditar.rutaIdSlider == null }">
                                    <label for="rutaIdsliderEditar"><span class="asterisk">*</span>Ruta</label>
                                    <ui-select ng-model="sliderEditar.rutaIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione ruta">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.ruta_id as item in rutas | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="row" ng-if="sliderEditar.enlaceInterno==1 && sliderEditar.tipoEntidadIdSlider==6">
                            <div class="col-xs-12 ">
                                <div class="form-group" ng-class="{'error': (crearsliderEditarForm.$submitted || crearsliderEditarForm.proveedorIdsliderEditar.$touched) && sliderEditar.proveedorIdSlider == null }">
                                    <label for="proveedorIdsliderEditar"><span class="asterisk">*</span>Proveedor</label>
                                    <ui-select ng-model="sliderEditar.proveedorIdSlider" theme="bootstrap">
                                        <ui-select-match placeholder="Seleccione proveedor">@{{$select.selected.nombre}}</ui-select-match>
                                        <ui-select-choices repeat="item.proveedor_rnt_id as item in proveedores | filter:$select.search">
                                            <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="editarSlider()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal agregar idioma slider-->
    <div class="modal fade" id="modalAgregarIdiomaSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar idioma</h4>
                </div>
                <div class="alert alert-danger" ng-repeat="error in errores">
                    *@{{error[0]}}
                </div>
                <form role="form" name="agregarIdiomaSliderForm" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (agregarIdiomaSliderForm.$submitted || agregarIdiomaSliderForm.idiomaIdSlider.$touched) && agregarIdiomaSliderForm.idiomaIdSlider.$error.required }">
                                    <label class="control-label" for="idiomaIdSlider"><span class="asterisk">*</span> Nuevo idioma</label>
                                    <select ng-options="item.id as item.nombre for item in agregarIdiomaSlider.noIdiomas" ng-model="agregarIdiomaSlider.idiomaIdSlider" class="form-control" id="idiomaIdSlider" name="idiomaIdSlider" required>
                                        <option value="" selected disabled>Seleccione un idioma</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <figure>
                                    <figcaption>Imagen actual</figcaption>
                                  <img class="img-responsive" ng-src="@{{agregarIdiomaSlider.imagenActual}}" alt="" role="presentation"/>
                                  
                                </figure>
                                <br>
                            </div>
    
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error':((agregarIdiomaSliderForm.$submitted || agregarIdiomaSliderForm.textoAlternativoSlider.$touched) && agregarIdiomaSliderForm.textoAlternativoSlider.$error.required)}">
                                    <label class="control-label" for="textoAlternativoSlider"><span class="asterisk">*</span> Texto alternativo</label>
                                    <textarea class="form-control" name="textoAlternativoSlider" id="textoAlternativoSlider" placeholder="Ingrese una breve descripción del contenido de la imagen seleccionada. Máx. 100 caracteres" maxlength="100" ng-model="agregarIdiomaSlider.textoAlternativoSlider" rows="4" required></textarea>
                                    <span class="text-error" ng-show="(agregarIdiomaSliderForm.$submitted || agregarIdiomaSliderForm.textoAlternativoSlider.$touched) && agregarIdiomaSliderForm.textoAlternativoSlider.$error.required">Campo requerido</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label" for="tituloSlider">Título</label>
                                    <input type="text" class="form-control" name="tituloSlider" id="tituloSlider" placeholder="Ingrese título de la imagen. Máx. 150 caracteres" maxlength="150" ng-model="agregarIdiomaSlider.tituloSlider" />
    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="agregarIdioma()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal activar slider-->
    <div class="modal fade" id="modalActivarSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Activar imagen</h4>
                </div>
                <div class="alert alert-danger" ng-repeat="error in errores">
                    *@{{error[0]}}
                </div>
                <form role="form" name="activarSliderForm" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (activarSliderForm.$submitted || activarSliderForm.prioridadSliderActivar.$touched) && (activarSliderForm.prioridadSliderActivar.$error.required || activarSliderForm.prioridadSliderActivar.$error.min || activarSliderForm.prioridadSliderActivar.$error.max) }">
                                    <label class="control-label" for="prioridadSliderActivar">Prioridad de la imagen</label>
                                    <input type="number" class="form-control" name="prioridadSliderActivar" id="prioridadSliderActivar" placeholder="Ingrese la prioridad de la imagen. Min. 1 caracteres" min="1" max="8" ng-model="sliderActivar.prioridadSliderActivar" required />
                                    <span class="text-danger" ng-show="activarSliderForm.prioridadSliderActivar.$error.number"> Solo números </span>
                                    <span class="text-danger" ng-show="activarSliderForm.prioridadSliderActivar.$error.min"> Número no válido </span>
                                    <span class="text-danger" ng-show="activarSliderForm.prioridadSliderActivar.$error.max"> Número no válido </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="activarSlider2()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>        
@endsection

@section('javascript')
<script src="{{asset('/js/plugins/angular-material/angular-animate.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-aria.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-messages.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-material.min.js')}}"></script>
<script src="{{asset('/js/plugins/material.min.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/administrador/sliders/sliders.js')}}"></script>
<script src="{{asset('/js/administrador/sliders/sliderServices.js')}}"></script>

<script defer>

    function readURL(input , idPreview) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(idPreview).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#modalAgregarSlider").on('shown.bs.modal', function () {
        $('#imagen-slider-crear').attr('src', '');
    });

    $("#imagenSlider").change(function () {
        readURL(this, "#imagen-slider-crear");
    });
    $("#imagenSliderEditar").change(function () {
        readURL(this, "#imagen-slider-editar");
    });
</script>
@endsection