@extends('layout._AdminLayout')
@section('app','ng-app="appProyect"')

@section('content')
    <div ng-controller="publicacionEditarCtrl" >
             <input type="hidden" name="id" ng-model="id" ng-init="id={{$id}}"/>
        <h2>Editar Publicacion</h2>
        <div class="alert alert-danger" ng-if="errores != null">
                    <h6>Errores</h6>
                    <span class="messages" ng-repeat="error in errores">
                          <span>@{{error}}</span>
                    </span>
                </div>  
        <form role="form" name="formEditar" novalidate>
    
               <div class = "row">
                    <div class="col-md-6  col-xs- 6 col-sm-6">
                          <label>Titulo</label>
                          <input type="text" name="titulo" class="form-control" ng-model="publicacion.titulo" required/>
                          <span ng-show= "formEditar.$submitted || formEditar.titulo.$touched">
                              <span ng-show="formEditar.titulo.$error.required">* El campo es obligatorio.</span>
                              
                          </span>
                      </div>
                        <div class="col-md-6  col-xs- 6 col-sm-6">
                              <label>Tipo</label>
                              <select ng-model="publicacion.tipos_publicaciones_obras_id" name="tipo" style="width:100%" class="form-control" ng-options="tipo.id as tipo.nombre for tipo in tipos" ng-required="true">
                                    <option value="" disabled>Seleccione un tipo de publicación</option>
                                </select>
                                <span ng-show="formEditar.$submitted || formEditar.tipo.$touched">
                                    
                                    <span class="label label-danger" ng-show="formEditar.tipo.$error.required">Debe seleccionar un tipo de publicación</span>
                                </span>                                         
                        </div>
                          
                  </div>
                  
                <div class="row" >
                  
                    <div class="col-sm-12">
                    <div class="form-group" >
                        <label for="tema">Temas</label>
                        <ui-select multiple ng-model="publicacion.temasId" theme="bootstrap">
                            <ui-select-match placeholder="Seleccione temas (múltiple)">@{{$item.nombre}}</ui-select-match>
                            <ui-select-choices repeat="item.id as item in temas | filter:$select.search">
                                <div ng-bind-html="item.nombre | highlight: $select.search"></div>
                            </ui-select-choices>
                        </ui-select>
                        <span ng-show="formEditar.$submitted">
                            <span class="label label-danger" ng-show="formEditar.$submitted && publicacion.temas.length == 0 ">Debe seleccionar un tipo de publicación</span>
                        </span>          
                    </div>
                </div>
                    
                </div>  
   
                  
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="descripcion">Descripción </label>
                            <textarea  class="form-control" name="descripcion" id="descripcion" ng-model="publicacion.descripcion" placeholder="Información no suministrada" rows="4"></textarea>
                        </div>
                    </div>
                </div>
              <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="resumen">Resumen </label>
                            <textarea  class="form-control" name="resumen" id="resumen" ng-model="publicacion.resumen" placeholder="Información no suministrada" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                  
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="resumen">Palabras claves </label>
                               <tags-input ng-model="publicacion.palabras" display-property="nombre" ></tags-input>
                            <p>Model: @{{publicacion.palabrasClaves}}</p>
                        </div>
                    </div>
                </div> 
                  
                <div class=row>
                    <div class="col-xs-4 margin-4-sm">
                        <label class="u-block"><span class="asterisk">*</span>Adjuntar publicación</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                    Seleccionar archivo <input type="file" id="soporte_publicacion" name="soporte_publicacion" file-input='soporte_publicacion' style="display: none;">
                                </span>
                            </label>
                            <input id="nombreArchivoSeleccionadoPublicacion" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>
    
                        </div>
                    

                    </div>
                    <div class="col-xs-4 margin-4-sm">
                        <label class="u-block"><span class="asterisk">*</span>Adjuntar portada</label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                    Seleccionar archivo <input type="file" id="portada" name="portada" file-input='portada' style="display: none;">
                                </span>
                            </label>
                            <input id="nombreArchivoSeleccionadoPublicacion" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>
    
                        </div>
                       

                    </div>
                    <div class="col-xs-4 margin-4-sm">
                                <label class="u-block"><span class="asterisk">*</span>Adjuntar soporte</label>
                                <div class="input-group" >
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary" title="Seleccionar archivo" data-toggle="tooltip" data-placement="right">
                                            Seleccionar archivo <input type="file" id="soporte_carta" name="soporte_carta" file-input='soporte_carta' style="display: none;">
                                        </span>
                                    </label>
                                    <input id="nombreArchivoSeleccionadoCarta" type="text" class="form-control" placeholder="Peso máximo 5MB" readonly>
                              

                    </div>
                      
                  </div>
   
                </div>
   
        <div class="panel-body">
               
                   <h2>Autores</h2> <button ng-click="abrirAgregarPersona()"  class="btn btn-sm btn-default texto_azul" title="Agregar Autor"><span >Agregar</span></button>
                   <span class="text-error" ng-show="formEditar.$submitted  && publicacion.personas.length == 0">Debe agregar por lo menos un autor</span>
                   <table class="table">
                      <thead>
                        <tr>
                          <th>Email</th>
                          <th>Nombre</th>
                          <th>Apellido</th>
                          <th>Pais</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr  ng-repeat = "persona in publicacion.personas">
                          <td>     
                                <input type="email" name="email@{{$index}}" class="form-control" ng-model="persona.email" ng-change="buscarPersona(persona)" required/>
                                    <span ng-show= "formEditar.$submitted || formEditar.email@{{$index}}.$touched">
                                    <span ng-show="formEditar.email@{{$index}}.$error.required">* El campo es obligatorio.</span>
                                    <span ng-show="formEditar.$submitted || formEditar.email@{{$index}}.$touched && formEditar.email@{{$index}}.$error.email">No es un correo válido</span>
                            </span></td>
                          <td> 
                          <input type="text" name="nombre@{{$index}}" class="form-control" ng-model="persona.nombres" required/>
                              <span ng-show= "formEditar.$submitted || formEditar.nombre@{{$index}}.$touched">
                                   <span ng-show="formEditar.nombre@{{$index}}.$error.required">* El campo es obligatorio.</span>
                                          </span>
                        </td>
                        <td>
                                 <input type="text" name="apellido@{{$index}}" class="form-control" ng-model="persona.apellidos" required/>
                                  <span ng-show= "formEditar.$submitted || formEditar.apellido@{{$index}}.$touched">
                                  <span ng-show="formEditar.apellido@{{$index}}.$error.required">* El campo es obligatorio.</span>
                                  </span>
                            
                        </td>
                         <td>
                                   <select ng-model="persona.paises_id" name="pais@{{$index}}" style="width:100%" class="form-control" ng-options="pais.id as pais.nombre for pais in paises" ng-required="true">
                                    <option value="" disabled>Seleccione un pais</option>
                                    </select>
                                            <span ng-show="formEditar.$submitted || formEditar.pais@{{$index}}.$touched">
                                                
                                                <span class="label label-danger" ng-show="formEditar.pais@{{$index}}.$error.required">Debe seleccionar un pais</span>
                                            </span>                      
                         </td>
                         <td>
                             <button ng-click="remove($index)"><span class="glyphicon glyphicon-remove-sign"></span></button>
                             
                         </td>
                        
                        </tr>
                      </tbody>
                    </table>
                
           </div>
        
               
               
               
        <div class"row center-block">
            <input type="submit"  class="btn btn-success" value="Guardar"  ng-click="editarPublicacion()">
        </div>
       
        </form>
    
    
    </div>
   

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