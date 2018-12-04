
@extends('layout._AdminLayout')

@section('Title','Administración de información pública')

@section('app','ng-app="AppInformacionDepartamento"')
@section('controller','ng-controller="informacionDepartamentoCtrl"')

@section('titulo','Información pública')

@section('subtitulo','Página de configuración de información pública')

@section('estilos')
<style>
    .cke_bottom {
        display: none;
    }
</style>
@endsection

@section('content')
    
    <input type="hidden" id="id" value="{{$id}}" />
    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="active" role="presentation">
            <a id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true" >Información general</a>
        </li>
        <li role="presentation">
            <a id="multimedia-tab" data-toggle="tab" href="#multimedia" role="tab" aria-controls="multimedia" aria-selected="false" >Multimedia</a>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent" style="padding: 25px;" >
        <div class="tab-pane fade in active" id="general" role="tabpanel" aria-labelledby="home-tab">
            
            
            <form role="form" name="crearForm"  novalidate>
                <fieldset>
                    <legend>Información general</legend>
                    <div class="alert alert-info">Todos los campos en este formulario son obligatorios</div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.tituloinformacion.$touched) && crearForm.tituloinformacion.$error.required}">
                                <label for="tituloinformacion">Título</label>
                                <input type="text" class="form-control" name="tituloinformacion" id="tituloinformacion" ng-model="informacion.titulo" maxlength="500" placeholder="Ingrese un título" required/>
                            
                            </div>
                            
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error':(crearForm.$submitted || crearForm.textinformacion.$touched) && crearForm.textinformacion.$error.required}">
                                <label for="textoinformacion">Cuerpo</label>
                                <ng-ckeditor  
                                              id="textoinformacion"
                                              name="textinformacion"
                                              ng-model="informacion.cuerpo"
                                              ng-disabled="editorDIsabled" 
                                              skin="moono" 
                                              remove-buttons="Image" 
                                              remove-plugins="iframe,flash,smiley"
                                              required
                                              >
                                </ng-ckeditor>
                            </div>
                            
                        </div>
                        <div class="col-xs-12 text-center">
                            <hr>
                            <button type="submit" ng-click="guardar()" class="btn btn-lg btn-success">Guardar</button>
                        </div>  
                    </div>
                </fieldset>
                
                <br>
                
                
            </form>
                
        </div>
        <div class="tab-pane fade" id="multimedia" role="tabpanel" aria-labelledby="profile-tab">
               
               <div class="row" >
                     <div class="col-md-12" >
                            <form role="form" name="formVideo" novalidate >
                                <div class="input-group">
                                  <input type="url" class="form-control" placeholder="URL de video" ng-model="informacion.video"  required >
                                  <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit" ng-click="guardarvideo()" >Guardar</button>
                                  </span>
                                </div>
                            </form>
                     </div>
               </div>
               
               <br><br>
               
                <div class="row" >
                    <div class="col-md-12" >
                        <file-input id-input="galeria" ng-model="galeria" accept="image/*" label="Agregar imagenes" icon-class="ion-ios-photos" icon="" multiple ></file-input>
                        <button class="btn btn-success" ng-click="guardarGaleria()" ng-show="galeria.length>0" >
                            Guardar imagenes
                        </button>
                    </div>
                    <div class="col-md-12" >
                        <h2>Imagenes de galeria</h2>
                        
                        <div class="alert" ng-if="informacion.imagenes.length==0" >
                            <div class="alert-info" >
                                <b>0 imagenes</b>, No se encontraron imágenes almacenadas para la galería.
                            </div>
                        </div>
                        <div class="tiles">
                            <div class="tile" ng-repeat="item in informacion.imagenes">
                                <div class="tile-img">
                                    <img ng-src="@{{item.ruta}}" alt="" role="presentation"/>
                                </div>
                                <div class="tile-body text-center">
                                    <button type="button" ng-click="eliminarImagen(item.id, $index)" class="btn btn-sm btn-danger">Eliminar</button>
                                </div>
                            </div>
                        </div>
                        <!--<div class="cont-imagenes row">-->
                        <!--    <div class="col-xs-12 col-md-4" ng-repeat="item in informacion.imagenes"  >-->
                        <!--        <div class="item" >-->
                        <!--            <img ng-src="@{{item.ruta}}" />-->
                        <!--            <button ng-click="eliminarImagen(item.id, $index)"  >Eliminar</button>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                    </div>
                </div>
                
        </div>
    </div>
    
    

            

@endsection


@section('javascript')
    <script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
    <script src="{{asset('/js/plugins/directiva-files.js')}}"></script>
    <script src="{{asset('/js/informacionDepartamento/servicios.js')}}"></script>
    <script src="{{asset('/js/informacionDepartamento/app.js')}}"></script>
@endsection
