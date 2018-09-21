@extends('layout._AdminLayout')
@section('app','ng-app="appProyect"')

@section('controller','ng-controller="publicacionCrearCtrl"')

@section('titulo','Publicaciones')
@section('subtitulo','Formulario de creación de publicaciones')

@section('content')
        <div class="alert alert-danger" ng-if="errores != null">
            <h6>Errores</h6>
            <span class="messages" ng-repeat="error in errores">
                  <span>@{{error}}</span>
            </span>
        </div>  
        <form role="form" name="formCrear" novalidate>
    
            <div class="row">
                <div class="col-md-6 col-xs-6 col-sm-6">
                    <div class="form-group" ng-class="{'has-error': (formCrear.$submitted || formCrear.titulo.$touched) && formCrear.titulo.$error.required}">
                        <label for="titulo"><span class="asterisk">*</span> Título</label>
                        <input type="text" name="titulo" class="form-control" ng-model="publicacion.titulo" placeholder="Ingrese el título" required/>
                    </div>
                     
                </div>
                <div class="col-md-6 col-xs-6 col-sm-6">
                    <div class="form-group" ng-class="{'has-error': (formCrear.$submitted || formCrear.tipo.$touched) && formCrear.tipo.$error.required}">
                        <label for="titulo"><span class="asterisk">*</span> Tipo de publicación</label>
                        <select ng-model="publicacion.tipos_publicaciones_obras_id" name="tipo" style="width:100%" class="form-control" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-required="true">
                            <option value="" disabled>Seleccione un tipo de publicación</option>
                        </select>
                    </div>
                                                                
                </div>
                <div class="col-xs-12">
                    <div class="form-group" ng-class="{'has-error': (formCrear.$submitted || formCrear.temas.$touched) && (formCrear.temas.$error.required || publicacion.temas.length == 0)}">
                        <label for="temas"><span class="asterisk">*</span> Temas</label>
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
                        <textarea  class="form-control" name="descripcion" id="descripcion" ng-model="publicacion.descripcion" placeholder="Ingrese una descripción" maxlength="500" rows="4" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="resumen">Resumen </label>
                        <textarea  class="form-control" name="resumen" id="resumen" ng-model="publicacion.resumen" placeholder="Ingrese un resumen" maxlength="500" rows="4" style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="resumen">Palabras claves </label>
                           <tags-input ng-model="publicacion.palabrasClaves"></tags-input>
                        <p>Model: @{{publicacion.palabrasClaves}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="u-block"><span class="asterisk">*</span> Adjuntar publicación</label>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                Archivo <input type="file" id="soporte_publicacion" name="soporte_publicacion" file-input='soporte_publicacion' style="display: none;">
                            </span>
                        </label>
                        <input id="nombreArchivoSeleccionadoPublicacion" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>

                    </div>
                    <span class="text-error" ng-show="formCrear.$submitted  && (soporte_publicacion == null || soporte_publicacion.length == 0 )">Debe adjuntar un soporte</span>

                </div>
                <div class="col-xs-12 col-md-4">
                    <label class="u-block"><span class="asterisk">*</span>Adjuntar portada</label>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                Archivo <input type="file" id="portada" name="portada" file-input='portada' style="display: none;">
                            </span>
                        </label>
                        <input id="nombreArchivoSeleccionadoPublicacion" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>

                    </div>
                    <span class="text-error" ng-show="formCrear.$submitted  && (portada == null || portada.length == 0 )">Debe adjuntar un soporte</span>

                </div>
                <div class="col-xs-12 col-md-4">
                        <label class="u-block"><span class="asterisk">*</span>Adjuntar soporte</label>
                        <div class="input-group" >
                            <label class="input-group-btn">
                                <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                    Archivo <input type="file" id="soporte_carta" name="soporte_carta" file-input='soporte_carta' style="display: none;">
                                </span>
                            </label>
                            <input id="nombreArchivoSeleccionadoCarta" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>
                        <span class="text-error" ng-show="formCrear.$submitted  && (soporte_carta == null || soporte_carta.length == 0 )">Debe adjuntar un soporte</span>

                    </div>
                      
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <fieldset>
                        <legend>Autores </legend>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>País</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="persona in publicacion.personas">
                                    <td>     
                                        <input type="email" name="email@{{$index}}" class="form-control input-sm" ng-model="persona.email" ng-change="buscarPersona(persona)" autocomplete="off" required/>
                                        <span class="text-error" ng-show="(formCrear.$submitted || formCrear.email@{{$index}}.$touched) && formCrear.email@{{$index}}.$error.required">Campo requerido</span>
                                        
                                    </td>
                                    <td> 
                                        <input type="text" name="nombre@{{$index}}" class="form-control input-sm" ng-model="persona.nombres" autocomplete="off" required/>
                                        <span class="text-error" ng-show="(formCrear.$submitted || formCrear.nombre@{{$index}}.$touched) && formCrear.nombre@{{$index}}.$error.required">Campo requerido</span>
                                        
                                    </td>
                                    <td>
                                        <input type="text" name="apellido@{{$index}}" class="form-control input-sm" ng-model="persona.apellidos" autocomplete="off" required/>
                                        <span class="text-error" ng-show="(formCrear.$submitted || formCrear.apellido@{{$index}}.$touched) && formCrear.apellido@{{$index}}.$error.required">Campo requerido</span>
                                        
                                    </td>
                                    <td>
                                        <select ng-model="persona.paises_id" name="pais@{{$index}}" style="width:100%" class="form-control input-sm" autocomplete="off" ng-options="pais.id as pais.nombre for pais in paises" ng-required="true">
                                        <option value="" disabled>Seleccione un pais</option>
                                        </select>
                                        <span class="text-error" ng-show="(formCrear.$submitted || formCrear.pais@{{$index}}.$touched) && formCrear.pais@{{$index}}.$error.required">Campo requerido</span>
                                                           
                                    </td>
                                    <td>
                                         <button ng-click="remove($index)" class="btn btn-xs btn-default" title="Remover registro"><span class="glyphicon glyphicon-trash"></span><span class="sr-only">Remover</span></button>
                                         
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <button type="button" ng-click="abrirAgregarPersona()" class="btn btn-sm btn-default texto_azul" title="Agregar Autor">Agregar autor</button>
                        </div>
                        <span class="text-error" ng-show="formCrear.$submitted  && publicacion.personas.length == 0">Debe agregar por lo menos un autor</span>
                    </fieldset>
                </div>
            </div>
            
               
            <div class="row">
                <div class="col-xs-12 text-center">
                    <hr/>
                    <input type="submit" class="btn btn-lg btn-success" value="Guardar" ng-click="agregarPublicacion()">
                </div>
            </div>
        </form>
    

@endsection
@section('javascript')
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