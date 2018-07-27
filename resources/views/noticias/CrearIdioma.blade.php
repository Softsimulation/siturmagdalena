@extends('layout._AdminLayout')

@section('title', 'Crear noticia con nuevo idioma')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
        }
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Crear noticia con nuevo idioma')

@section('app','ng-app="admin.noticia"')

@section('controller','ng-controller="crearIdiomaCtrl"')

@section('content')
<div class="container">
    <input type="hidden" ng-init="noticia.idNoticia={{$idNoticia}}" ng-model="noticia.idNoticia" />
    <div class="row">
        <div class="col-xs-12">
            <a href="/noticias/listadonoticias" class="btn btn-success">Volver al listado</a>
        </div>
    </div>
    <div>
        <br><br>
        <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
            <li role="informacionGeneral" class="active"><a href="#informacionGeneral" aria-controls="informacionGeneral" role="tab" data-toggle="tab">Información general</a></li>
            <li role="multimedia" role="multimedia"><a href="#multimedia" aria-controls="multimedia" role="tab" data-toggle="tab">Multimedia</a></li>
          </ul>
    </div>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="informacionGeneral" style="padding:30px">
            
            <br><br>
            <div class="alert alert-danger" ng-if="errores != null">
                <h6>Errores</h6>
                <span class="messages" ng-repeat="error in errores">
                      <span>*@{{error[0]}}</span><br/>
                </span>
            </div>
            <form role="form" name="crearForm"  novalidate>
                <div class="row">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <label><span class="asterisco">*</span>Idiomas</label>
                            <select class="form-control" name="idiomaNoticia" id="idiomaNoticia" ng-options="idioma.id as idioma.nombre for idioma in idiomas" ng-model="noticia.idioma" required>
                                <option value="">Seleccione un tipo</option>
                            </select>
                            
                            <span class="messages" ng-show="crearForm.$submitted || crearForm.idiomaNoticia.$touched">
                                <span ng-show="crearForm.idiomaNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                            </span>
                          
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="tituloNoticia"><span class="asterisco">*</span>Título</label>
                        <input type="text" class="form-control" name="tituloNoticia" id="tituloNoticia" ng-model="noticia.tituloNoticia" required/>
                        <span class="messages" ng-show="crearForm.$submitted || crearForm.tituloNoticia.$touched">
                            <span ng-show="crearForm.tituloNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                        </span>
                      
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="resumenNoticia"><span class="asterisco">*</span>Antetítulo</label>
                        <textarea class="form-control" name="resumenNoticia" ng-model="noticia.resumenNoticia" row="3" required></textarea>
                        <span class="messages" ng-show="crearForm.$submitted || crearForm.resumenNoticia.$touched">
                            <span ng-show="crearForm.resumenNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                        </span>
                      
                    </div>
                </div>
                <br>
                <div class="row">
                    
                    <div class="col-xs-12">
                        <label for="textoNoticia"><span class="asterisco">*</span>Texto</label>
                        <ng-ckeditor  
                                      ng-model="noticia.texto"
                                      ng-disabled="editorDIsabled" 
                                      skin="moono" 
                                      remove-buttons="Image" 
                                      remove-plugins="iframe,flash,smiley"
                                      required
                                      >
                        </ng-ckeditor>
                    </div>
                    <span class="messages" ng-show="crearForm.$submitted || crearForm.textoNoticia.$touched">
                        <span ng-show="crearForm.textoNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                    </span>
                </div>
                <br>
                
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="submit" ng-click="guardarNoticia()" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
        
        <div role="tabpanel" class="tab-pane" id="multimedia" style="padding:30px">
            <br><br>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-hover">
                        <tr>
                            <th>Adjunto</th>
                            <th>Texto alternativo</th>
                            <th>Portada</th>
                            <th style="width:100px;">Acciones</th>
                            
                        </tr>
                        
                        <tr ng-repeat="x in multimediasNoticias">
                            <td> 
                              <a href="@{{x.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                            </td>
                            <td>@{{x.texto}}</td>
                            @{{x.portada == true ? 'Si' : 'No'}}
                            
                            <td>
                              <a ng-if="x.texto!=null" href="" ng-click="abrirModalTextoAlternativo(x)" class="btn btn-default" title="Editar texto alternativo" style="float:left"><span class="glyphicon glyphicon-edit"></span></a>
                              <a ng-if="x.texto==null" href="" ng-click="abrirModalTextoAlternativo(x)" class="btn btn-default" title="Editar texto alternativo" style="float:left"><span class="glyphicon glyphicon-plus"></span></a>
                            </td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="col-md-12" ng-if="multimediasNoticias.length == 0">
                  <div class="alert alert-info" role="alert"><b>No se ha creado multimedia para esta noticia</b></div>
              </div>
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
                            <div class="col-sm-12">
                                <label class="u-block"><span class="asterisk">*</span>Subir imagen</label><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="La imagen debe tener un peso de 2MB y debe ser de formato jpeg, jpg o png"></span>
                                <div class="input-group" ng-class="{'error': crearMultimediaForm.$submitted  && (Galeria == null || Galeria.length == 0 ) }">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                            Seleccionar archivo <input type="file" id="Galeria" name="Galeria" file-input='Galeria' style="display: none;" accept="image/jpeg,image/png">
                                        </span>
                                    </label>
                                    <input id="GaleriaNoticia" type="text" class="form-control" placeholder="Peso máximo 2MB" readonly>
                                </div>
                                <span class="messages" ng-show="crearMultimediaForm.$submitted && (Galeria == null || Galeria.length == 0 ) ">* El campo es obligatorio.</span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="texto_alternativo"><span class="asterisco">*</span>Texto alternativo</label>
                                <textarea class="form-control" name="texto_alternativo" ng-model="multimedia.texto_alternativo" row="3" required></textarea>
                                <span class="messages" ng-show="crearMultimediaForm.$submitted || crearMultimediaForm.texto_alternativo.$touched">
                                    <span ng-show="crearMultimediaForm.texto_alternativo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                </span>
                              
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <label><span class="asterisco">*</span>¿Es portada?</label><br>
                                <input type="radio" ng-model="multimedia.portadaNoticia" name="portadaNoticia" value="1" required>Si
                                <input type="radio" ng-model="multimedia.portadaNoticia" name="portadaNoticia" value="0" required>No
                            </div>
                            <div class="col-sm-12">
                              <span class="messages" ng-show="crearMultimediaForm.$submitted || crearMultimediaForm.portadaNoticia.$touched">
                                        <span ng-show="crearMultimediaForm.portadaNoticia.$error.required" class="color_errores">* El campo es obligatorio.</span>
                              </span>  
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
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="texto_alternativo"><span class="asterisco">*</span>Texto alternativo</label>
                                    <textarea class="form-control" name="texto_alternativo" ng-model="textoAlternativo.textoAlternativo" row="3" required></textarea>
                                    <span class="messages" ng-show="guardarTextoAlternativoForm.$submitted || guardarTextoAlternativoForm.texto_alternativo.$touched">
                                        <span ng-show="guardarTextoAlternativoForm.texto_alternativo.$error.required" class="color_errores">* El campo es obligatorio.</span>
                                    </span>
                                  
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
@endsection