@extends('layout._AdminLayout')

@section('title', 'Editar noticia')

@section('estilos')
<style>
    .cke_bottom {
        display: none!important;
    }
</style>
@endsection

@section('TitleSection', 'Editar noticia')

@section('app','ng-app="admin.noticia"')

@section('controller','ng-controller="editarNoticiaCtrl"')

@section('titulo','Noticias')
@section('subtitulo','Formulario de edición de noticias')

@section('content')
        <input type="hidden" ng-init="editar2.idNoticia={{$idNoticia}}" ng-model="editar2.idNoticia" />
        <input type="hidden" ng-init="editar2.idIdioma={{$idIdioma}}" ng-model="editar2.idIdioma" />
        <div>
            <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                <li role="informacionGeneral" class="active"><a href="#informacionGeneral" aria-controls="informacionGeneral" role="tab" data-toggle="tab">Información general</a></li>
                <li role="multimedia" role="multimedia"><a href="#multimedia" aria-controls="multimedia" role="tab" data-toggle="tab">Multimedia</a></li>
              </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="informacionGeneral">
                
                <div class="alert alert-danger" ng-if="errores != null">
                    <h6>Errores</h6>
                    <span class="messages" ng-repeat="error in errores">
                          <span>*@{{error[0]}}</span><br/>
                    </span>
                </div>
                <form role="form" name="crearForm"  novalidate>
                    <fieldset>
                        <legend>Información general</legend>
                        <div class="alert alert-info">Los campos marcados con un asterisco (*) son obligatorios.</div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.tituloNoticia.$touched) && crearForm.tituloNoticia.$error.required}">
                                    <label for="tituloNoticia" class="control-label"><span class="asterisk">*</span>Título</label>
                                    <input type="text" class="form-control" name="tituloNoticia" id="tituloNoticia" ng-model="noticia.tituloNoticia" maxlength="255" placeholder="Ingrese el título de la noticia. Máx. 255 caracteres." required/>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.tipoNoticia.$touched) && crearForm.tipoNoticia.$error.required}">
                                    <label class="control-label" for="tipoNoticia"><span class="asterisk">*</span> Tipo de noticia</label>
                                    <select class="form-control" name="tipoNoticia" id="tipoNoticia" ng-options="tipo.tipos_noticias_id as tipo.nombre for tipo in tiposNoticias" ng-model="noticia.tipoNoticia" required>
                                        <option value="" selected disabled>Seleccione un tipo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.resumenNoticia.$touched) && crearForm.resumenNoticia.$error.required}">
                                    <label for="resumenNoticia"><span class="asterisk">*</span> Antetítulo</label>
                                    <textarea class="form-control" name="resumenNoticia" id="resumenNoticia" ng-model="noticia.resumenNoticia" row="3" maxlength="500" placeholder="Ingrese un antetítulo. Máx. 500 caracteres" required></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.textoNoticia.$touched) && crearForm.textoNoticia.$error.required}">
                                    <label for="textoNoticia" class="control-label"><span class="asterisk">*</span> Decripción o contenido</label>
                                    <ng-ckeditor  
                                                  ng-model="noticia.texto"
                                                  ng-disabled="editorDIsabled" 
                                                  skin="moono" 
                                                  remove-buttons="Image" 
                                                  remove-plugins="iframe,flash,smiley"
                                                  required
                                                  name="textoNoticia"
                                                  >
                                    </ng-ckeditor>
                                    <span class="text-error" ng-if="(crearForm.$submitted || crearForm.textoNoticia.$touched) && crearForm.textoNoticia.$error.required">Este campo es obligatorio</span>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group" ng-class="{'has-error': (crearForm.$submitted || crearForm.fuenteNoticia.$touched) && crearForm.fuenteNoticia.$error.url}">
                                    <label for="fuenteNoticia" class="control-label">Enlace de fuente</label>
                                    <input type="url" class="form-control" name="fuenteNoticia" id="fuenteNoticia" ng-model="noticia.fuenteNoticia" maxlength="500" placeholder="Ej: http://www.dominio.com"/>
                                    <span class="text-error" ng-show="(crearForm.$submitted || crearForm.fuenteNoticia.$touched) && crearForm.fuenteNoticia.$error.url">Debe ingresar una URL válida. Ej: http://www.dominio.com</span>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <hr/>
                                <button type="submit" ng-click="guardarNoticia()" class="btn btn-lg btn-success">Guardar</button>
                                <a href="/noticias/listadonoticias" class="btn btn-lg btn-default">Volver</a>
                            </div>
                        </div>
                    </fieldset>
                    <!--<br>
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <label><span class="asterisco">*</span>Tipo de noticia</label>
                            <select class="form-control" name="tipoNoticia" id="tipoNoticia" ng-options="tipo.tipos_noticias_id as tipo.nombre for tipo in editar.idioma.tiposNoticias" ng-model="noticia.tipoNoticia" required>
                                <option value="" disabled selected>Seleccione un tipo</option>
                            </select>
                            
                            <span class="messages" ng-show="crearForm.$submitted || crearForm.tipoNoticia.$touched">
                                <span ng-show="crearForm.tipoNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                            </span>
                          
                        </div>
                    </div>-->
                </form>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="multimedia" style="padding:30px">
                <fieldset>
                    <legend>Multimedia <button type="button" class="btn btn-xs btn-link" ng-click="abrirModalCrearNoticia()" ng-if="noticia.idIdioma == 1">Agregar multimedia</button></legend>
                    <div class="row">
                        <div class="col-xs-12 table-overflow">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Adjunto</th>
                                        <th>Texto alternativo</th>
                                        <th>Portada</th>
                                        <th style="width:90px;">Acciones</th>
                                        
                                    </tr>    
                                </thead>
                                <tbody>
                                    <tr ng-repeat="x in multimediasNoticias">
                                        <td> 
                                        
                                          <a href="@{{x.ruta}}" target="_blank" title="Clic para ver imagen adjunta @{{$index+1}}">
                                              <img src="@{{x.ruta}}" alt="Imagen adjunta en registro @{{$index+1}}" style="max-height: 90px;">    
                                          </a>
                                          
                                        </td>
                                        <td >@{{x.texto}}</td>
                                        <td>@{{x.portada == true ? 'Si' : 'No'}}</td>
                                        
                                        <td>
                                          <!--<a ng-if="x.texto!=null" href="" ng-click="abrirModalTextoAlternativo(x)" class="btn btn-default" title="Editar texto alternativo"><span class="glyphicon glyphicon-edit"></span></a>-->
                                            <button ng-if="x.texto!=null" type="button" ng-click="abrirModalEditarMultimedia(x)" class="btn btn-xs btn-default" title="Editar texto alternativo"><span class="glyphicon glyphicon-pencil"></span></button>
                                            <button ng-if="x.texto==null" type="button" ng-click="abrirModalTextoAlternativo(x)" class="btn btn-xs btn-default" title="Editar texto alternativo"><span class="glyphicon glyphicon-plus"></span></button>
                                            <button type="button" ng-if="noticia.idIdioma == 1" ng-click="eliminarMultimedia(x)" class="btn btn-xs btn-default" title="Eliminar multimedia"><span class="glyphicon glyphicon-trash"></span></button>
                                        </td>
                                    </tr>    
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="col-xs-12 text-center" ng-if="multimediasNoticias.length == 0">
                          <div class="alert alert-info" role="alert">No se ha creado multimedia para esta noticia</div>
                        </div>
                    </div>    
                </fieldset>
                
                
            </div>
        </div>
        
        <div class="modal fade" id="modalCrearNoticia" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="crearMultimediaForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Guardar multimedia</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                            <h6>Errores</h6>
                            <span class="messages" ng-repeat="error in errores">
                                  <span>*@{{error[0]}}</span><br/>
                            </span>
                        </div>
                        <div class="alert alert-info">
                            <p>Los campos marcados con un asterisco (*) son obligatorios</p>
                        </div>
                        
                            <!--<div class="row">
                                <div class="col-xs-12">
                                    <div class="alert alert-warning">
                                        <strong>* Adjuntar archivos formatos PDF.</strong>
                                        <br>
                                        <strong>* Adjuntar máximo tres archivos.</strong>
                                        <br>
                                        <strong>* Tamaño de archivos 10 MB.</strong>
                                    </div>
                                    <lf-ng-md-file-input lf-files="galeria" id="galeria" name="galeria" lf-totalsize="2MB" lf-mimetype="jpg,jpeg,png"  lf-on-file-click="onFileClick" lf-on-file-remove="onFileRemove" preview drag multiple></lf-ng-md-file-input>
                                    <div ng-messages="formRespuesta.galeria.$error">
                                        <br>
                                        <div ng-message="totalsize"><span class="color_errores">Archivos demasiados pesados para subir.</span></div>
                                        <div ng-message="mimetype" ><span class="color_errores">Solo archivos png, jpg o jpeg.</span></div>
                                    </div>  
            
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group" ng-class="{'has-error': (crearMultimediaForm.$submitted || crearMultimediaForm.Galeria.$touched) && (crearMultimediaForm.Galeria.$error.required || Galeria == null || Galeria.length == 0 ) }">
                                        <label class="control-label" for="Galeria"><span class="asterisk">*</span> Subir imagen</label> <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="La imagen debe tener un peso de 2MB y debe ser de formato jpeg, jpg o png"></span>
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                                    <span class="glyphicon glyphicon-upload"></span><span class="sr-only">Seleccionar archivo</span> <input type="file" id="Galeria" name="Galeria" file-input='Galeria' style="display: none;" accept="image/jpeg,image/png" required>
                                                </span>
                                            </label>
                                            <input id="GaleriaNoticia" type="text" class="form-control" placeholder="Peso máximo 2MB" readonly>
                                        </div>
                                    </div>
                                    
                                    <span class="messages" ng-show="crearMultimediaForm.$submitted && (Galeria == null || Galeria.length == 0 ) ">* El campo es obligatorio.</span>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group" ng-class="{'has-error':(crearMultimediaForm.$submitted || crearMultimediaForm.texto_alternativo.$touched) && crearMultimediaForm.texto_alternativo.$error.required}">
                                        <label for="texto_alternativo" class="control-label"><span class="asterisk">*</span> Texto alternativo</label>
                                        <textarea class="form-control" name="texto_alternativo" ng-model="multimedia.texto_alternativo" row="3" placeholder="Ingrese una breve descripción del contenido de la imagen seleccionada. Máx. 100 caracteres" maxlength="100" required></textarea>
                                           
                                    </div>
                                    
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label"><span class="asterisk">*</span> ¿Es portada?</label><br>
                                        <input type="radio" ng-model="multimedia.portadaNoticia" name="portadaNoticia" value="1" required>Si
                                        <input type="radio" ng-model="multimedia.portadaNoticia" name="portadaNoticia" value="0" required>No
                                        <br>
                                        <span class="text-error" ng-if="(crearMultimediaForm.$submitted || crearMultimediaForm.portadaNoticia.$touched) && crearMultimediaForm.portadaNoticia.$error.required"> El campo es obligatorio</span>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarMultimedia()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="modalTextoAlternativo" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="guardarTextoAlternativoForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Guardar texto alternativo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                            <h6>Errores</h6>
                            <span class="messages" ng-repeat="error in errores">
                                  <span>*@{{error[0]}}</span><br/>
                            </span>
                        </div>
                        <div class="alert alert-info">Los campos son obligatorios</div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group" ng-class="{'has-error':(guardarTextoAlternativoForm.$submitted || guardarTextoAlternativoForm.texto_alternativo.$touched) && guardarTextoAlternativoForm.texto_alternativo.$error.required}">
                                        <label for="texto_alternativo"><span class="asterisk">*</span> Texto alternativo</label>
                                        <textarea class="form-control" name="texto_alternativo" id="texto_alternativo" ng-model="textoAlternativo.textoAlternativo" row="3" placeholder="El texto alternativo es una breve descripción del contenido de una imagen. Máx. 100 caracteres." maxlength="100" required></textarea>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="guardarAlternativo()">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="modalEditarMultimedia" role="dialog">
            <div class="modal-dialog">
                <form role="form" name="editarMultimediaForm"  novalidate>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar multimedia</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" ng-if="errores != null">
                            <h6>Errores</h6>
                            <span class="messages" ng-repeat="error in errores">
                                  <span>*@{{error[0]}}</span><br/>
                            </span>
                        </div>
                        <div class="alert alert-info">
                            <p>Los campos marcados con un asterisco (*) son obligatorios</p>
                        </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group" ng-class="{'has-error':(editarMultimediaForm.$submitted || editarMultimediaForm.Galeria.$touched) && editarMultimediaForm.Galeria.$error.required}">
                                        <label class="control-label" id="GaleriaEditar">Subir imagen <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="La imagen debe tener un peso de 2MB y debe ser de formato jpeg, jpg o png"></span></label>
                                        <div class="input-group">
                                            <label class="input-group-btn">
                                                <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                                    <span class="glyphicon glyphicon-upload"></span><span class="sr-only">Seleccionar archivo</span> <input type="file" id="GaleriaEditar" name="Galeria" file-input='Galeria' style="display: none;" accept="image/jpeg,image/png" required>
                                                </span>
                                            </label>
                                            <input id="GaleriaNoticiaEditar" type="text" class="form-control" placeholder="Peso máximo 2MB" readonly>
                                        </div> 
                                        <a href="@{{multimediaEditar.ruta}}" target="_blank">
                                            <span class="text-error text-msg">Clic para ver archivo subido actualmente</span>
                                        </a>
                                    </div>
                                    
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group" ng-class="{'has-error':(editarMultimediaForm.$submitted || editarMultimediaForm.texto_alternativo.$touched) && editarMultimediaForm.texto_alternativo.$error.required}">
                                        <label for="texto_alternativo_editar" class="control-label"><span class="asterisk">*</span> Texto alternativo</label>
                                        <textarea class="form-control" name="texto_alternativo" id="texto_alternativo_editar" ng-model="multimediaEditar.texto_alternativo" row="3" placeholder="El texto alternativo es una breve descripción del contenido de una imagen. Máx. 100 caracteres." maxlength="100" required></textarea>
                                    </div>
                                  
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label><span class="asterisk">*</span>¿Es portada?</label><br>
                                        <input type="radio" ng-model="multimediaEditar.portadaNoticia" name="portadaNoticia" value="1" required>Si
                                        <input type="radio" ng-model="multimediaEditar.portadaNoticia" name="portadaNoticia" value="2" required>No    
                                    </div>
                                    <br>
                                        <span class="text-error" ng-if="(editarMultimediaForm.$submitted || editarMultimediaForm.portadaNoticia.$touched) && editarMultimediaForm.portadaNoticia.$error.required"> El campo es obligatorio</span>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" ng-click="editarMultimedia()">Guardar</button>
                    </div>
                </div>
                </form>
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
<script src="{{asset('/js/administrador/noticias/noticias.js')}}"></script>
<script src="{{asset('/js/administrador/noticias/noticiaServices.js')}}"></script>
<script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imagen").change(function () {
            readURL(this);
        });

        $(document).on('change', ':file', function () {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover()

            $(':file').on('fileselect', function (event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if (input.length) {
                    input.val(log);
                } else {
                    //if (log) alert(log);
                }

            });

        });

    </script>
@endsection
 