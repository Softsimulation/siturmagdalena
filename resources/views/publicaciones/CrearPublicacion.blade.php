@extends('layout._AdminLayout')
@section('app','ng-app="appProyect"')

@section('controller','ng-controller="publicacionCrearCtrl"')

@section('titulo','Publicaciones')
@section('title','Formulario de creación de publicaciones')
@section('subtitulo','Formulario de creación de publicaciones')

@section('estilos')
    <link href="{{asset('/css/ng-tags-input.bootstrap.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ng-tags-input.css')}}" rel='stylesheet' type='text/css' />
    
@endsection

@section('content')
        <div class="alert alert-danger" ng-if="errores != null">
            <h6>Errores</h6>
            <span class="messages" ng-repeat="error in errores">
                  <span>@{{error}}</span>
            </span>
        </div>  
        <form role="form" name="formCrear" novalidate>
            
            <fieldset>
                <legend>Formulario de edición de publicaciones</legend>
                <div class="alert alert-info">
                    <p>Los campos marcados con asterisco (*) son obligatorios.</p>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8">
                        <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.titulo.$touched) && formCrear.titulo.$error.required}">
                          <label for="titulo" class="control-label"><span class="asterisk">*</span> Título</label>
                          <input type="text" id="titulo" name="titulo" class="form-control" ng-model="publicacion.titulo" maxlength="255" placeholder="Ingrese el nombre de la publicación. Máx. 255 caracteres" required/>
                            
                        </div>
                          
                      </div>
                      <div class="col-xs-12 col-md-4">
                          <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.tipo.$touched) && formCrear.tipo.$error.required}">
                              <label id="tipo" class="control-label"><span class="asterisk">*</span> Tipo</label>
                              <select ng-model="publicacion.tipos_publicaciones_obras_id" name="tipo" id="tipo "class="form-control" ng-options="tipo.id as tipo.nombre for tipo in tipos" required>
                                    <option value="" disabled selected>Seleccione un tipo de publicación</option>
                              </select>    
                          </div>
                                                                 
                      </div>
                      <div class="col-xs-12">
                            <div class="form-group" ng-class="{'has-error': (formCrear.$submitted || formCrear.temas.$touched) && (formCrear.temas.$error.required || publicacion.temas.length == 0)}">
                                <label for="temas" class="control-label"><span class="asterisk">*</span> Temas <span class="text-error text-msg">(Multiple)</span></label>
                                <ui-select multiple ng-model="publicacion.temas" theme="bootstrap" name="temas" id="temas">
                                    <ui-select-match placeholder="Seleccione temas (múltiple)">@{{$item.nombre}}</ui-select-match>
                                    <ui-select-choices repeat="item.id as item in temas | filter:$select.search">
                                        <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                                    </ui-select-choices>
                                </ui-select>
                                <span class="text-error" ng-show="(formCrear.$submitted || formCrear.temas.$touched) && (formCrear.temas.$error.required || publicacion.temas.length == 0)">Debe seleccionar un tema de publicación</span>
                            </div>
                             
                       </div> 
                       <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="descripcion">Descripción</label>
                                <textarea  class="form-control" name="descripcion" id="descripcion" ng-model="publicacion.descripcion" placeholder="Ingrese una descripción. Máx. 500 caracteres." maxlength="500" rows="4" style="resize: none;"></textarea>
                            </div>
                       </div>
                       <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="resumen">Resumen </label>
                                <textarea  class="form-control" name="resumen" id="resumen" ng-model="publicacion.resumen" placeholder="Ingrese un resumen. Máx. 500 caracteres." maxlength="500" rows="4" style="resize: none;"></textarea>
                            </div>
                       </div>
                       <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="palabrasClave">Palabras claves </label>
                                   <tags-input ng-model="publicacion.palabrasClaves" id="palabrasClave" placeholder="Agregar palabra"></tags-input>
                               
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                          <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.soporte_publicacion.$touched) && (formCrear.soporte_publicacion.$error.required || soporte_publicacion == undefined)}">
                              <label class="control-label" for="soporte_publicacion"><span class="asterisk">*</span> Adjuntar publicación <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Solo archivos en formato PDF con un peso menor o igual a 15MB"></span></label>
                              <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                            <span class="glyphicon glyphicon-upload"></span><span class="sr-only">Seleccionar archivo</span> <input type="file" id="soporte_publicacion" name="soporte_publicacion" file-input='soporte_publicacion' style="display: none;"  accept=".pdf" required>
                                        </span>
                                    </label>
                                    <input id="nombreArchivoSeleccionadoPublicacion" type="text" class="form-control" placeholder="Peso máximo 15MB" readonly>
            
                                </div>
                                
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4">
                          <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.portada.$touched) && (formCrear.portada.$error.required || portada == undefined)}">
                              <label class="control-label" for="portada"><span class="asterisk">*</span> Adjuntar portada <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Solo archivos en formato JPG, JPEG y PNG con un peso menor o igual a 5MB"></span></label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                            <span class="glyphicon glyphicon-upload"></span><span class="sr-only">Seleccionar archivo</span> <input type="file" id="portada" name="portada" file-input='portada' style="display: none;"  accept=".jpg;.jpeg;.png">
                                        </span>
                                    </label>
                                    <input id="nombreArchivoSeleccionadoPortada" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>
            
                                </div>
                                
                          </div>
                      </div>
                      <div class="col-xs-12 col-md-4">
                          <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.soporte_carta.$touched) && (formCrear.soporte_carta.$error.required || soporte_carta == undefined)}">
                              <label class="control-label" for="soporte_carta"><span class="asterisk">*</span>Adjuntar soporte <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Solo archivos en formato PDF con un peso menor o igual a 15MB"></span></label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                            <span class="glyphicon glyphicon-upload"></span><span class="sr-only">Seleccionar archivo</span> <input type="file" id="soporte_carta" name="soporte_carta" file-input='soporte_carta' style="display: none;"  accept=".pdf">
                                        </span>
                                    </label>
                                    <input id="nombreArchivoSeleccionadoCarta" type="text" class="form-control" placeholder="Peso máximo 15MB" readonly>
                              
            
                                </div>
                                
                          </div>
                      </div>
                  </div>
            </fieldset>
            <fieldset>
                <legend>Autores <button type="button" class="btn btn-xs btn-link" ng-click="abrirAgregarPersona()">Agregar autor</button></legend>
                <div class="table-overflow">
                   <table class="table">
                      <thead>
                        <tr>
                          <th>Email</th>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>País</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="persona in publicacion.personas">
                          <td>     
                              <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.email@{{$index}}.$touched) && (formCrear.email@{{$index}}.$error.required || formCrear.email@{{$index}}.$error.email)}">
                                  <label class="sr-only" for="email@{{$index}}">Email</label>
                                  <input type="email" name="email@{{$index}}" id="email@{{$index}}" class="form-control input-sm" ng-model="persona.email" ng-change="buscarPersona(persona)" autocomplete="off" maxlength="300" placeholder="Ej: correo@dominio.com" required/>
                                  <span class="text-error" ng-show="(formCrear.$submitted || formCrear.email@{{$index}}.$touched) && formCrear.email@{{$index}}.$error.email">Formato de email incorrecto</span>
                              </div>
                                
                                    
                          </td>
                          <td> 
                              <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.nombre@{{$index}}.$touched) && formCrear.nombre@{{$index}}.$error.required}">
                                  <label class="sr-only" for="nombre@{{$index}}">Nombre</label>
                                  <input type="text" name="nombre@{{$index}}" id="nombre@{{$index}}" class="form-control input-sm" ng-model="persona.nombres" autocomplete="off" maxlength="255" placeholder="Nombre" required/>
                              </div>
                          
                          </td>
                          <td>
                              <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.apellido@{{$index}}.$touched) && formCrear.apellido@{{$index}}.$error.required}">
                                  <label class="sr-only" for="apellido@{{$index}}">Apellido</label>
                                  <input type="text" name="apellido@{{$index}}" class="form-control input-sm" ng-model="persona.apellidos" maxlength="255" autocomplete="off" placeholder="Apellido" required/>
                              </div>
                                 
                            
                          </td>
                          <td>
                              <div class="form-group" ng-class="{'has-error':(formCrear.$submitted || formCrear.pais@{{$index}}.$touched) && formCrear.pais@{{$index}}.$error.required}">
                                  <label class="sr-only" for="pais@{{$index}}">País</label>
                                  <select ng-model="persona.paises_id" name="pais@{{$index}}" id="pais@{{$index}}" class="form-control input-sm" ng-options="pais.id as pais.nombre for pais in paises" required>
                                      <option value="" disabled selected>Seleccione un país</option>
                                  </select>
                              </div>                      
                          </td>
                          <td>
                             <button type="button" ng-click="remove($index)" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span><span class="sr-only">Remover elemento</span></button>
                             
                          </td>
                        
                        </tr>
                        <tr class="info" ng-if="!formCrear.$submitted && publicacion.personas.length == 0">
                            <td colspan="5" class="text-center">
                                Presione el botón "Agregar autor" para añadir un registro
                            </td>
                        </tr>
                        <tr class="danger" ng-if="formCrear.$submitted && publicacion.personas.length == 0">
                            <td colspan="5" class="text-center">
                                Debe añadir por lo menos un autor
                            </td>
                        </tr>
                      </tbody>
                    </table>
                    
                </div>
            </fieldset>
              
            <div style="text-align: center;">
                <hr>
                <input type="submit" class="btn btn-lg btn-success" value="Guardar" ng-click="agregarPublicacion()">
                <a href="/publicaciones/listadonuevas" class="btn btn-lg btn-default">Volver</a>
            </div>
        </form>
    

@endsection
@section('javascript')
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

        $('body').on("click", ".goto", function (e) {
            e.preventDefault();
            $('.nav-tabs a[href="#historial"]').tab('show');
            var idDiv = ($(this).data('href') != undefined) ? $(this).data('href') : $(this).attr('href');

            $("html, body").delay(50).animate({ scrollTop: $(idDiv).offset().top - 45 }, 350);


        });
    </script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select2.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/servicios.js')}}"></script>
    <script src="{{asset('/js/plugins/dirPagination.js')}}"></script>
    <script src="{{asset('/js/plugins/ng-tags-input.js')}}"></script>
    <script src="{{asset('/js/plugins/directiva.campos.js')}}"></script>
    <script src="{{asset('/js/administrador/bibliotecadigital/appAngular.js')}}"></script>
@endsection