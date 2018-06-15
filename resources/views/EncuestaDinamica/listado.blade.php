@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection','Configuración encuesta Ad Hoc')
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="ListarEncuestasCtrl"')

@section('content')

<div>
   <a class="btn btn-link btn-primary" href="/encuesta/listado" >Volver al listado</a>
    <button class="btn btn-success" ng-click="openModalAddEncuesta()" >+ Agregar</button>

    <div class="row" >

       <div class="col-md-12">
          <h2>Listado de encuestas</h2>
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:50px;" ></th>
                <th>Encuesta</th>
                <th style="width: 20px;" >Estado</th>
                <th style="width: 70px;" ></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="encuesta in encuestas" >
                <td>@{{$index+1}}</td>
                <td>@{{ (encuesta.idiomas|filter:{ 'idiomas_id':1 })[0].nombre}}</td>
                <td>@{{ encuesta.estado.nombre }}</td>
                <td>
                    <a class="btn btn-xs btn-primary" href="/encuesta/configurar/@{{encuesta.id}}" > Ver </a>
                    <div class="dropdown" style="float: right;" >
                        <button type="button" class="btn btn-xs btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <span class="caret"></span>
                        </button>
                        
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>
                                <a href ng-click="OpenModalCambiarEstado(encuesta)" >
                                    Cambiar estado
                                </a>
                            </li>
                            <li>
                                <a href="/encuesta/listar/@{{encuesta.id}}" >
                                    Encuestas
                                </a>
                            </li>
                            <li>
                                <a href="/encuesta/estadisticas/@{{encuesta.id}}" >
                                    Estadisticas
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li ng-repeat="item in encuesta.idiomas" >
                              <a href ng-click="OpenModalIdiomaEncuesta(encuesta,item)" >  @{{item.idioma.nombre}} </a>
                            </li>
                            <li ng-if="encuesta.estados_encuestas_id==1" >
                                <a href ng-click="OpenModalIdiomaEncuesta(encuesta)" >+ Agregar</a>
                            </li>
                            <li class="divider"></li>
                            
                        </ul> 
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
          
          <div class="alert alert-info" ng-if="encuestas.length==0"  >
              No se encontraron registros almacenados
          </div>
          
        </div>

    </div>
    
    
    
    <!-- Modal agregar encuesta-->
    <div class="modal fade" id="modalAgregarEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="formEncuesta" novalidate>
                    <div class="modal-body">
    
                        <div class="row">
                          
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuesta.$submitted || formEncuesta.nombre.$touched) && formEncuesta.nombre.$error.required}">
                                    <label class="control-label" for="pregunta">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="encuesta.nombre" required />
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuesta.$submitted || formEncuesta.descripcion.$touched) && formEncuesta.descripcion.$error.required}">
                                    <label class="control-label" for="descripcion">Descripcion</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" ng-model="encuesta.descripcion" placeholder="Descripción" ></textarea>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardarEncuesta()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal agregar encuesta-->
    <div class="modal fade" id="modalIdiomaEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="formEncuestaI" novalidate>
                    <div class="modal-body">
                        
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuestaI.$submitted || formEncuestaI.idioma.$touched) && formEncuestaI.idioma.$error.required}">
                                    <label class="control-label" for="idioma">Idioma</label>
                                    <select class="form-control" id="idioma" name="idioma" ng-model="idomaEncuesta.idiomas_id" ng-options="item.id as item.nombre for item in idiomas" ng-disabled="es_editar" required>
                                        <option value="" disabled selected >Idioma</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
    
                        <div class="row">
                          
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuestaI.$submitted || formEncuestaI.preguntaI.$touched) && formEncuestaI.preguntaI.$error.required}">
                                    <label class="control-label" for="preguntaI">Nombre</label>
                                    <input type="text" class="form-control" id="preguntaI" name="preguntaI" placeholder="Nombre" ng-model="idomaEncuesta.nombre" required />
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuestaI.$submitted || formEncuestaI.descripcionI.$touched) && formEncuestaI.descripcionI.$error.required}">
                                    <label class="control-label" for="descripcionI">Descripcion</label>
                                    <textarea class="form-control" id="descripcionI" name="descripcionI" ng-model="idomaEncuesta.descripcion" placeholder="Descripción" ></textarea>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardarIdiomaEncuesta()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <!-- Modal cambiar estado encuesta-->
    <div class="modal fade" id="modalEstadosEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="formEncuestaE" novalidate>
                    <div class="modal-body">
                        
                        <div class="row">
                            
                            <div class="col-md-12">
                               <p>@{{ (CambiarEstado.idiomas|filter:{'id':1})[0].nombre }}</p>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'error' : (formEncuestaE.$submitted || formEncuestaE.idioma.$touched) && formEncuestaE.idioma.$error.required}">
                                    <label class="control-label" for="idioma">Estado encuesta</label>
                                    <select class="form-control" id="idioma" name="idioma" ng-model="CambiarEstado.estados_encuestas_id" ng-options="item.id as item.nombre for item in estados" required>
                                        <option value="" disabled selected >Estados</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
    
                        
                    </div>
                    <div class="modal-footer center" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardarEstadoEncuesta()" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
   
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
    </style>

@endsection

@section('javascript')
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/serviAdmin.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/appAdmin.js')}}"></script>
@endsection