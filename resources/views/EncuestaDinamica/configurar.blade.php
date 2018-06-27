
@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection','Configuración encuesta Ad Hoc')
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="ConfigurarEncuestaCtrl"')

@section('content')

    <div class="row" >

        <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
        
        <div class="col-md-12">
            
            <a class="btn btn-link btn-primary" href="/encuesta/listado" >Volver al listado</a>
            
            <h2>@{{encuesta.idiomas[0].nombre}}</h2>
            
            
            <div ng-if="encuesta.secciones.length==0" class="alert alert-info" >
                0 secciones agregadas a la encuesta
            </div>
            
            <ul class="nav nav-tabs">
                <li  ng-repeat="item in encuesta.secciones" ng-class="{'active' : (tabOpen.activo==$index) }"   > 
                     <a data-toggle="tab" href="#tab@{{$index}}" ng-click="tabOpen.activo=$index" >Sección @{{$index+1}}</a>
                </li>
                @if($puedeEditar==true)
                    <li>
                        <button type="button" class="btn-agregar" ng-click="agregarSeccion()" title="Agregar nueva sección" >+ Agregar sección</button>
                    </li>
                @endif
            </ul>
            
            <div class="tab-content">
              <div id="tab@{{$index}}" class="tab-pane" ng-repeat="seccion in encuesta.secciones" ng-class="{'active' : (tabOpen.activo==$index) }" >
                   
                    <br><br>
                    
                    @if($puedeEditar)
                        <button type="button" class="btn btn-primary" ng-click="OpenModalAgregarPregunta(seccion)" >
                           + Agregar pregunta
                        </button>
                        <button type="button" ng-if="seccion.preguntas.length>1" class="btn btn-success" ng-click="openModalOrdenPreguntas(seccion)" style="float:right;" >
                            Cambiar orden de preguntas
                        </button>
                           
                        <br><br>
                    @endif
                    
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th style="width: 30px;" ></th>
                            <th>Pregunta</th>
                            <th style="width: 280px;" >Tipo campo</th>
                            <th style="width:  70px;" >Estado</th>
                            <th style="width: 110px;"></th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="pregunta in seccion.preguntas" >
                              <td>@{{$index+1}}</td>
                              <td>@{{ (pregunta.idiomas|filter:{ 'idiomas_id':1 })[0].pregunta }}</td>
                              <td>@{{pregunta.tipo_campo.tipo}}</td>
                              <td>@{{pregunta.es_visible ? 'Activa' : 'Inactiva'}}</td>
                              <td>
                                    @if($puedeEditar)
                                        <a class="btn btn-xs btn-primary" ng-click="verDetallePregunta(pregunta)" >ver</a>
                                        <div class="dropdown" style="float: right;" >
                                              <button type="button" class="btn btn-xs btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 <span class="caret"></span>
                                              </button>
                                              <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                   <li>
                                                        <a href ng-click="activarDesactivarPregunta(pregunta)" >
                                                             @{{ !pregunta.es_visible ? 'Activar' : 'Desactivar'}}
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                     <a href ng-click="eliminarPregunta(pregunta,$index)" >
                                                         Eliminar
                                                     </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li ng-repeat="item in pregunta.idiomas" >
                                                      <a href ng-click="OpenModalEditarIdiomaPregunta(pregunta,item)" >  @{{item.idioma.nombre}} </a>
                                                    </li>
                                                    <li><a href ng-click="OpenModalAgregarIdiomaPregunta(pregunta)" >+ Agregar</a></li>
                                                    <li class="divider"></li>
                                                    <li ng-if="pregunta.tipo_campos_id==3 || pregunta.tipo_campos_id==5 || pregunta.tipo_campos_id==6 || pregunta.tipo_campos_id==7">
                                                        <a href ng-click="openModalAgregarOpcion(pregunta)" >+ Agregar opción</a>
                                                    </li>
                                                    
                                              </ul> 
                                        </div>
                                    @else
                                        <div class="dropdown" style="float: right;" >
                                                  <button type="button" class="btn btn-xs btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     Idiomas <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                    <li ng-repeat="item in pregunta.idiomas" >
                                                      <a href ng-click="OpenModalEditarIdiomaPregunta(pregunta,item)" >  @{{item.idioma.nombre}} </a>
                                                    </li>
                                                  </ul> 
                                            </div>
                                    @endif
                              </td>
                               
                            </tr>
                            <tr ng-if="seccion.preguntas.length==0" >
                                <td colspan="5" class="alert alert-info" >0 preguntas agregadas</td>
                            </tr>
                        </tbody>
                             
                    </table>

                    <div style="text-align:center" >
                        
                        <a class="btn btn-default" href="" ng-click="tabOpen.activo=$index-1" ng-show="$index!=0" >Anterior</a>
                        <a class="btn btn-success" href="" ng-click="tabOpen.activo=$index+1" ng-show="$index!=encuesta.secciones.length-1" >Siguiente</a>
                        
                    </div>

              </div>
            </div>
           
            
        </div>
       
    </div>
    
        @if($puedeEditar)
            <!-- Modal cambiar el orden de las preguntas de una sección -->
            <div id="openModalOrdenPreguntas" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ordenar preguntas (Sección @{{tabOpen.activo+1}})</h4>
                  </div>
                  <div class="modal-body">
                      
                      
                      <ul class="list-group" dnd-list="ordenarPreguntas">
                          <li class="list-group-item"
                              ng-repeat="item in ordenarPreguntas"
                              dnd-draggable="item"
                              dnd-moved="ordenarPreguntas.splice($index, 1)"
                              dnd-effect-allowed="move"
                              ng-class="{'selected': models.selected === item}"
                              >
                                 @{{ (item.idiomas|filter:{ 'idiomas_id':1 })[0].pregunta }} 
                          </li>
                      </ul>
                      
                  </div>
                  <div class="modal-footer center">
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" ng-click="guardarOrdenPreguntas()" class="btn btn-success">Guardar</button>
                  </div>
                </div>
            
              </div>
            </div>
            
            <!-- Modal agregar pregunta-->
            <div class="modal fade" id="modalAgregarPregunta" tabindex="-1" >
                <div class="modal-dialog" ng-class="{'modal-lg':(pregunta.tipoCampo==8 || pregunta.tipoCampo==9)}" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="formPregunta" novalidate>
                            <div class="modal-body">
            
                                <div class="row">
                                  
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.pregunta.$touched) && formPregunta.pregunta.$error.required}">
                                            <label class="control-label" for="pregunta">Pregunta</label>
                                            <input type="text" class="form-control" id="pregunta" name="pregunta" placeholder="¿ Pregunta ?" ng-model="pregunta.pregunta" required />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.tipoCampo.$touched) && formPregunta.tipoCampo.$error.required}">
                                            <label class="control-label" for="tipoCampo">Tipo de campo</label>
                                            <select class="form-control" id="tipoCampo" name="tipoCampo" ng-model="pregunta.tipoCampo" ng-options="item.id as item.tipo for item in tiposCamos" required>
                                                <option value="" disabled selected>Tipo de campo</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.tipoCampo.$touched) && formPregunta.tipoCampo.$error.required}">
                                            <label class="control-label" for="esRequerido">El campo es requerido?</label><br>
                                            <div class="radio-inline">
                                              <label><input type="radio" name="esRequerido" ng-model="pregunta.esRequerido" ng-value="1" >Si</label>
                                            </div>
                                            <div class="radio-inline">
                                              <label><input type="radio" name="esRequerido" ng-model="pregunta.esRequerido" ng-value="0" >No</label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                
                                <div class="row" ng-if="pregunta.tipoCampo==1"  >
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.caracteres.$touched) && formPregunta.caracteres.$error.required}">
                                            <label class="control-label" for="caracteres">Número maximo de caracteres</label>
                                            <input type="number" class="form-control" id="caracteres" name="caracteres" placeholder="Número caracteres" ng-model="pregunta.caracteres" required />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" ng-if="pregunta.tipoCampo==2"  >
                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.minNumero.$touched) && formPregunta.minNumero.$error.required}">
                                            <label class="control-label" for="minNumero">Mínimo valor</label>
                                            <input type="number" class="form-control" id="minNumero" name="minNumero" placeholder="Número mínimo" ng-model="pregunta.minNumero" required />
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.maxNumero.$touched) && formPregunta.maxNumero.$error.required}">
                                            <label class="control-label" for="maxNumero">Máximo valor</label>
                                            <input type="number" class="form-control" id="maxNumero" name="maxNumero" placeholder="Número máxino" ng-model="pregunta.maxNumero" required />
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row" ng-if="pregunta.tipoCampo==3 || pregunta.tipoCampo==5 || pregunta.tipoCampo==6 || pregunta.tipoCampo==7 || pregunta.tipoCampo==8 || pregunta.tipoCampo==9" >
                                    
                                    <div class="col-md-6" ng-if="pregunta.tipoCampo==8 || pregunta.tipoCampo==9" >
                                       
                                         <br>
                                       
                                         <div class="row" >
                                          
                                             <div class="col-md-12">
                                               
                                                <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.maxNumero.$touched) && formPregunta.maxNumero.$error.required}">
                                                    <label class="control-label" >Agregar subpregunta</label>
                                                    <div class="input-group">
                                                      <input type="text" class="form-control" placeholder="Nueva opción" ng-model="subpregunta" >
                                                      <div class="input-group-btn">
                                                        <button class="btn btn-success" type="button" ng-click="pregunta.subPreguntas.push(subpregunta); subpregunta=null;" ng-disabled="!subpregunta" >
                                                             Agregar
                                                        </button>
                                                      </div>
                                                    </div>
                                                </div>
                                               
                                             </div>
                                         </div>
                                         
                                       
                                          <ul class="list-group">
                                            
                                            <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                              Subpreguntas
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in pregunta.subPreguntas track by $index" style="cursor:default" >
                                                @{{item}}  <span class="badge badge-primary badge-pill" ng-click="pregunta.subPreguntas.splice($index,1);" >X</span>
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="pregunta.subPreguntas.length==0" >
                                                0 Subpreguntas agregadas
                                            </li>
                                            
                                          </ul>
                                       
                                    </div>
                                    
                                    <div class="col-md-12" ng-class="{'col-md-6':(pregunta.tipoCampo==8 || pregunta.tipoCampo==9)}" >
                                       
                                         <br>
                                       
                                         <div class="row" >
                                          
                                             <div class="col-md-12">
                                               
                                                <div class="form-group" ng-class="{'error' : (formPregunta.$submitted || formPregunta.maxNumero.$touched) && formPregunta.maxNumero.$error.required}">
                                                    <label class="control-label" >Agregar opcion</label>
                                                    <div class="input-group">
                                                      <input type="text" class="form-control" placeholder="Nueva opción" ng-model="opcion" >
                                                      <div class="input-group-btn">
                                                        <button class="btn btn-success" type="button" ng-click="pregunta.opciones.push(opcion); opcion=null;" ng-disabled="!opcion" >
                                                             Agregar
                                                        </button>
                                                      </div>
                                                    </div>
                                                </div>
                                               
                                             </div>
                                         </div>
                                         
                                       
                                          <ul class="list-group">
                                            
                                            <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                              Opciones
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in pregunta.opciones track by $index" style="cursor:default" >
                                                @{{item}}  <span class="badge badge-primary badge-pill" ng-click="pregunta.opciones.splice($index,1);" >X</span>
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="pregunta.opciones.length==0" >
                                                0 opciones agregadas
                                            </li>
                                            
                                          </ul>
                                       
                                    </div>
                                </div>
                                
            
            
                            </div>
                            <div class="modal-footer center" >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" ng-click="guardarPregunta()" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
             <!-- Modal detalle pregunta-->
            <div class="modal fade" id="modalDetallePregunta" tabindex="-1" >
                <div class="modal-dialog" ng-class="{'modal-lg':(detallePregunta.tipo_campos_id==8 || detallePregunta.tipo_campos_id==9)}" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalle pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                            <div class="modal-body">
            
                                <div class="row">
                                  
                                    <div class="col-md-12">
                                        <div class="form-group" >
                                            <label class="control-label">Pregunta</label>
                                            <p>@{{ (detallePregunta.idiomas|filter:{ 'idiomas_id':1 })[0].pregunta }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipo de campo</label>
                                            <p>@{{ detallePregunta.tipo_campo.tipo }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label class="control-label">El campo es requerido?</label><br>
                                            <p>@{{ detallePregunta.pregunta.esRequerido ? 'Si' : 'No' }}</p>
                                        </div>
                                    </div>
                                  
                                </div>
                                
                                <div class="row" ng-if="detallePregunta.tipo_campos_id==1"  >
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Número máximo de caracteres</label>
                                            <p>@{{ detallePregunta.max_length }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" ng-if="pregunta.tipo_campos_id==2"  >
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Mínimo valor</label>
                                            <p>@{{ detallePregunta.valor_min }}</p>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Máximo valor</label>
                                            <p>@{{ detallePregunta.valor_max }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" ng-if="detallePregunta.tipo_campos_id==3 || detallePregunta.tipo_campos_id==5 || detallePregunta.tipo_campos_id==6 || detallePregunta.tipo_campos_id==7"  >
                                    <div class="col-md-12">
                                       
                                          <ul class="list-group">
                                            
                                            <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                              Opciones <span class="badge badge-primary badge-pill" ng-click="openModalAgregarOpcion(detallePregunta)" ><b>+ Agregar</b></span>
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in detallePregunta.opciones track by $index" style="cursor:default" >
                                               @{{ (item.idiomas|filter:{ 'idiomas_id':1 })[0].nombre }} <span class="badge badge-primary badge-pill" ng-click="eliminarOpionPregunta($index,item.id);" >X</span>
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="detallePregunta.opciones.length==0" >
                                                0 opciones agregadas
                                            </li>
                                            
                                          </ul>
                                       
                                    </div>
                                </div>
                                
                                
                                <div class="row" ng-if="detallePregunta.tipo_campos_id==8 || detallePregunta.tipo_campos_id==9"  >
                                    <div class="col-md-6">
                                       
                                          <ul class="list-group">
                                            
                                            <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                              Subpreguntas <!--<span class="badge badge-primary badge-pill" ng-click="openModalAgregarOpcion(detallePregunta)" ><b>+ Agregar</b></span>-->
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in detallePregunta.sub_preguntas track by $index" style="cursor:default" >
                                               @{{ (item.idiomas|filter:{ 'idiomas_id':1 })[0].nombre }} <!--<span class="badge badge-primary badge-pill" ng-click="eliminarOpionPregunta($index,item.id);" >X</span>-->
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="detallePregunta.sub_preguntas.length==0" >
                                                0 Subpreguntas agregadas
                                            </li>
                                            
                                          </ul>
                                       
                                    </div>
                                    
                                    <div class="col-md-6">
                                       
                                          <ul class="list-group">
                                            
                                            <li href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                              Opciones <!--<span class="badge badge-primary badge-pill" ng-click="openModalAgregarOpcion(detallePregunta)" ><b>+ Agregar</b></span>-->
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-repeat="item in detallePregunta.opciones_sub_preguntas track by $index" style="cursor:default" >
                                               @{{ (item.idiomas|filter:{ 'idiomas_id':1 })[0].nombre }} <!-- <span class="badge badge-primary badge-pill" ng-click="eliminarOpionPregunta($index,item.id);" >X</span> -->
                                            </li>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center" ng-if="detallePregunta.opciones_sub_preguntas.length==0" >
                                                0 Subpreguntas agregadas
                                            </li>
                                            
                                          </ul>
                                       
                                    </div>
                                </div>
                                
                                
            
            
                            </div>
                            <div class="modal-footer center" >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                    </div>
                </div>
            </div>
        
            <!-- Modal agregar idioma pregunta-->
            <div class="modal fade" id="modalAgregarIdiomaPregunta" tabindex="-1" >
                <div class="modal-dialog" ng-class="{'modal-lg': (detallePregunta.tipo_campos_id==8 || detallePregunta.tipo_campos_id==9)}" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Idioma pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="formPreguntaIdioma" novalidate>
                            <div class="modal-body">
            
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'error' : (formPreguntaIdioma.$submitted || formPreguntaIdioma.idioma.$touched) && formPreguntaIdioma.idioma.$error.required}">
                                            <label class="control-label" for="idioma">Idioma</label>
                                            <select class="form-control" id="idioma" name="idioma" ng-model="idomaPregunta.idioma" ng-options="item.id as item.nombre for item in idiomas" ng-disabled="es_editar" required>
                                                <option value="" disabled selected >Idioma</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'error' : (formPreguntaIdioma.$submitted || formPreguntaIdioma.preguntaI.$touched) && formPreguntaIdioma.preguntaI.$error.required}">
                                            <label class="control-label" for="preguntaI">Pregunta</label>
                                            <input type="text" class="form-control" id="preguntaI" name="preguntaI" ng-model="idomaPregunta.pregunta" placeholder="@{{ (detallePregunta.idiomas|filter:{ 'idiomas_id':1 })[0].pregunta }}" required />
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row" ng-if="idomaPregunta.tipoCampo==3 || idomaPregunta.tipoCampo==5 || idomaPregunta.tipoCampo==6 || idomaPregunta.tipoCampo==7"  >
                                    <div class="col-md-12">
                                       
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th>Subpreguntas</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr ng-repeat="item in idomaPregunta.opciones" >
                                                  <td>@{{$index+1}}</td>
                                                  <td>
                <input type="text" class="form-control" name="opcion@{{$index}}" ng-model="item.texto" placeholder="@{{ (detallePregunta.opciones[$index].idiomas|filter:{ 'idiomas_id':1 })[0].nombre }}" required />
                                                  </td>
                                            </tr>
                                            </tr>
                                          </tbody>
                                        </table>
                                       
                                    </div>
                                </div>
                                
                                <div class="row" ng-if="idomaPregunta.tipoCampo==8 || idomaPregunta.tipoCampo==9"  >
                                    <div class="col-md-6">
                                       
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th>Opción de respuesta</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr ng-repeat="item in idomaPregunta.subPreguntas" >
                                                  <td>@{{$index+1}}</td>
                                                  <td>
                <input type="text" class="form-control" name="opcion1@{{$index}}" ng-model="item.texto" placeholder="@{{ (detallePregunta.sub_preguntas[$index].idiomas|filter:{ 'idiomas_id':1 })[0].nombre }}" required />
                                                  </td>
                                            </tr>
                                            </tr>
                                          </tbody>
                                        </table>
                                       
                                    </div>
                                    
                                    <div class="col-md-6">
                                       
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr ng-repeat="item in idomaPregunta.opcionesSubPreguntas" >
                                                  <td>@{{$index+1}}</td>
                                                  <td>
                <input type="text" class="form-control" name="opcion2@{{$index}}" ng-model="item.texto" placeholder="@{{ (detallePregunta.opciones_sub_preguntas[$index].idiomas|filter:{ 'idiomas_id':1 })[0].nombre }}" required />
                                                  </td>
                                            </tr>
                                            </tr>
                                          </tbody>
                                        </table>
                                       
                                    </div>
                                    
                                </div>
                                
            
            
                            </div>
                            <div class="modal-footer center" >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" ng-click="guardarIdiomaPregunta()" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Modal agregar opcion pregunta con idiomas-->
            <div class="modal fade" id="modalAgregarOpcionPregunta" tabindex="-1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar opción pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="formOpcionIdioma" novalidate>
                            <div class="modal-body">
            
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group" >
                                            <label class="control-label">Pregunta</label>
                                            <p>@{{ (detallePregunta.idiomas|filter:{ 'idiomas_id':1 })[0].pregunta }}</p>
                                        </div>
                                    </div>
                                </div>   
                                
                                <div class="row"   >
                                    <div class="col-md-12">
                                       
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th></th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr ng-repeat="item in datOpcion.idiomas" >
                                                  <td>@{{item.nombre}}</td>
                                                  <td>
                                                        <input type="text" class="form-control" name="opcionI@{{$index}}" placeholder="Opcion en @{{item.nombre}}" ng-model="item.opcion"  required />
                                                  </td>
                                            </tr>
                                            </tr>
                                          </tbody>
                                        </table>
                                       
                                    </div>
                                </div>
                                
            
            
                            </div>
                            <div class="modal-footer center" >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" ng-click="guardarOpcionPregunta()" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
        @else    
            <!-- Modal detalle idioma pregunta-->
            <div class="modal fade" id="modalAgregarIdiomaPregunta" tabindex="-1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Idioma pregunta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form name="formPreguntaIdioma" novalidate>
                            <div class="modal-body">
            
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'error' : (formPreguntaIdioma.$submitted || formPreguntaIdioma.idioma.$touched) && formPreguntaIdioma.idioma.$error.required}">
                                            <label class="control-label" for="idioma">Idioma</label>
                                            <select class="form-control" id="idioma" name="idioma" ng-model="idomaPregunta.idioma" ng-options="item.id as item.nombre for item in idiomas" disabled>
                                                <option value="" disabled selected >Idioma</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12">
                                        <div class="form-group" ng-class="{'error' : (formPreguntaIdioma.$submitted || formPreguntaIdioma.preguntaI.$touched) && formPreguntaIdioma.preguntaI.$error.required}">
                                            <label class="control-label" for="preguntaI">Pregunta</label>
                                            <input type="text" class="form-control" id="preguntaI" name="preguntaI" ng-model="idomaPregunta.pregunta" disabled required />
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row" ng-if="idomaPregunta.tipoCampo==3 || idomaPregunta.tipoCampo==5 || idomaPregunta.tipoCampo==6 || idomaPregunta.tipoCampo==7"  >
                                    <div class="col-md-12">
                                       
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th>Opción</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr ng-repeat="item in idomaPregunta.opciones" >
                                                  <td>@{{$index+1}}</td>
                                                  <td>@{{item.texto}}</td>
                                            </tr>
                                            </tr>
                                          </tbody>
                                        </table>
                                       
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer center" >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        @endif
    

   
    <style type="text/css">
       .list-group-item { cursor: default; }
       #openModalOrdenPreguntas .list-group-item { cursor: move; }
       .btn-agregar{
            margin-left: 10px;
            font-size: 1.1em;
            padding: 5px 11px;
            background: #5bb85b;
            border: none;
            border-radius: 35px;
            color: white;
            font-weight: bold;
       }
       .btn-agregar:focus { outline: none; }
       .list-group-item>.badge { background: red; }
       #openModalOrdenPreguntas .list-group-item>.badge { background: black; }
       .center{ text-align:center; }
       li{
          list-style: none !important;
       }
    </style>

@endsection



@section('javascript')
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/serviAdmin.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/appAdmin.js')}}"></script>
@endsection