@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection','Configuración encuesta Ad Hoc')
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="ListarEncuestasCtrl"')

@section('titulo','Encuestas ADHOC')
@section('subtitulo','El siguiente listado cuenta con @{{encuestas.length}} registro(s)')

@section('content')
<div class="flex-list">
    <button type="button" class="btn btn-lg btn-success" ng-click="openModalAddEncuesta()" class="btn btn-lg btn-success">
      Agregar encuesta
    </button> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-lg btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span><span class="sr-only">Filtros</span></button>
    </div>      
</div>
<br/>
<div class="text-center" ng-if="(encuestas | filter:search).length > 0 && (search != undefined)">
    <p>Hay @{{(encuestas | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="encuestas.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(encuestas | filter:search).length == 0 && encuestas.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>
<div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.tipo.nombre.length > 0 || search.estado.nombre.length > 0 || search.subcategoria.length > 0 || search.categoria.length > 0 || search.email.length > 0)">
    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
</div>
<div>
    
    <div class="row" >

       <div class="col-md-12">
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Encuesta</th>
                <th>Tipo</th>
                <th style="width: 20px;" >Estado</th>
                <th style="width: 152px;">Opciones</th>
              </tr>
              <tr ng-show="mostrarFiltro == true">
                                    
                    <td><input type="text" ng-model="search.nombreEsp" name="nombreEsp" id="nombreEsp" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td><input type="text" ng-model="search.tipo.nombre" name="tipo" id="tipo" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td><input type="text" ng-model="search.estado.nombre" name="estado" id="estado" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
              <tr dir-paginate="encuesta in encuestas | filter:search | itemsPerPage:10">
                <td>@{{ (encuesta.idiomas|filter:{ 'idiomas_id':1 })[0].nombre}}</td>
                <td>@{{ encuesta.tipo.nombre }}</td>
                <td>@{{ encuesta.estado.nombre }}</td>
                <td>
                    <a class="btn btn-xs btn-default" href="/encuesta/configurar/@{{encuesta.id}}" role="button" title="Ver encuesta"><span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">Ver encuesta</span></a>
                    <div class="dropdown" style="display: inline-block" >
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown"  >
                            Más opciones
                         <span class="caret"></span>
                        </button>
                        
                        <ul class="dropdown-menu" >
                            
                            <li ng-if=" (encuesta.tipos_encuestas_dinamica_id==1 || encuesta.tipos_encuestas_dinamica_id==2) && encuesta.estados_encuestas_id>1 ">
                                <a href="javascript:void(0)" ng-click="openModalCopiar(encuesta)" >
                                    Copiar enlace
                                </a>
                            </li>
                            
                            <li>
                                <a href="javascript:void(0)" ng-click="OpenModalCambiarEstado(encuesta)" >
                                    Cambiar estado
                                </a>
                            </li>
                            <li>
                                <a href="/encuesta/listar/@{{encuesta.id}}" >
                                    Listado de respuestas
                                </a>
                            </li>
                            <li>
                                <a href="/encuesta/estadisticas/@{{encuesta.id}}" >
                                    Estadísticas
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" ng-click="exportarData(encuesta.id)" >
                                    Descargar datos
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" ng-click="duplicarEncuesta(encuesta)" >
                                    Duplicar encuesta
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li ng-repeat="item in encuesta.idiomas" >
                              <a href="javascript:void(0)" ng-click="OpenModalIdiomaEncuesta(encuesta,item)">Información en @{{item.idioma.nombre}} </a>
                            </li>
                            <li ng-if="encuesta.estados_encuestas_id==1" >
                                <a href="javascript:void(0)" ng-click="OpenModalIdiomaEncuesta(encuesta)" >Agregar información en otro idioma</a>
                            </li>
                            
                        </ul> 
                    </div>
                </td>
              </tr>
            </tbody>
          </table>
         
          
        </div>

    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
          <dir-pagination-controls max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
        </div>
    </div>
    
    
    <!-- Modal duplicar encuesta-->
    <div class="modal fade" id="modalDuplicarEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Duplicar encuesta</h4>
                </div>
                <form name="formDE" novalidate>
                    <div class="modal-body">
                        
                        <h1 class="text-center" >Duplicar encuesta</h1>
                        <h3 class="text-center" >¿Esta seguro de duplicar la encuesta?</h3>
                        
                        <br><br>
                        
                        <div class="row">
                          
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formDE.$submitted || formDE.tipoED.$touched) && formDE.tipoED.$error.required}">
                                    <label class="control-label" for="tipoED"><span class="asterisk">*</span>  Tipo encuesta</label>
                                    <select class="form-control" name="tipoED" id="tipoED" ng-model="duplicarencuesta.tipo" ng-options="item.id as item.nombre for item in tipos" required >
                                        <option  disabled selected value="" >Selecione un tipo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" ng-click="guardarDuplicarEncuesta()" class="btn btn-success">Guardar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <!-- Modal agregar encuesta-->
    <div class="modal fade" id="modalAgregarEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar encuesta</h4>
                </div>
                <form name="formEncuesta" novalidate>
                    <div class="modal-body">
    
                        <div class="row">
                          
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuesta.$submitted || formEncuesta.nombre.$touched) && formEncuesta.nombre.$error.required}">
                                    <label class="control-label" for="pregunta"><span class="asterisk">*</span> Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" ng-model="encuesta.nombre" required />
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuesta.$submitted || formEncuesta.descripcion.$touched) && formEncuesta.descripcion.$error.required}">
                                    <label class="control-label" for="descripcion">Descripcion</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" ng-model="encuesta.descripcion" placeholder="Descripción" rows="5" style="resize: none;"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuesta.$submitted || formEncuesta.tipoEncuesta.$touched) && formEncuesta.tipoEncuesta.$error.required}">
                                    <label class="control-label" for="tipoEncuesta"><span class="asterisk">*</span>  Tipo encuesta</label>
                                    <select class="form-control" name="tipoEncuesta" id="tipoEncuesta" ng-model="encuesta.tipos_encuestas_dinamica_id" ng-options="item.id as item.nombre for item in tipos" required >
                                        <option  disabled selected value="" >Selecione un tipo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        
                        <button type="submit" ng-click="guardarEncuesta()" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal agregar idioma encuesta-->
    <div class="modal fade" id="modalIdiomaEncuesta" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Idioma de encuesta</h4>
                </div>
               
                <form name="formEncuestaI" novalidate>
                    <div class="modal-body">
                        
                        <div class="row">
                            
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuestaI.$submitted || formEncuestaI.idioma.$touched) && formEncuestaI.idioma.$error.required}">
                                    <label class="control-label" for="idioma"><span class="asterisk">*</span> Idioma</label>
                                    <select class="form-control" id="idioma" name="idioma" ng-model="idomaEncuesta.idiomas_id" ng-options="item.id as item.nombre for item in idiomas" ng-disabled="es_editar" required>
                                        <option value="" disabled selected >Idioma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuestaI.$submitted || formEncuestaI.preguntaI.$touched) && formEncuestaI.preguntaI.$error.required}">
                                    <label class="control-label" for="preguntaI"><span class="asterisk">*</span> Nombre</label>
                                    <input type="text" class="form-control" id="preguntaI" name="preguntaI" placeholder="Nombre" ng-model="idomaEncuesta.nombre" required />
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuestaI.$submitted || formEncuestaI.descripcionI.$touched) && formEncuestaI.descripcionI.$error.required}">
                                    <label class="control-label" for="descripcionI">Descripcion</label>
                                    <textarea class="form-control" id="descripcionI" name="descripcionI" ng-model="idomaEncuesta.descripcion" placeholder="Descripción" rows="5" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer center" >
                        
                        <button type="submit" ng-click="guardarIdiomaEncuesta()" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Estados de encuesta</h4>
                </div>
                <form name="formEncuestaE" novalidate>
                    <div class="modal-body">
                        
                        <div class="row">
                            
                            <div class="col-md-12">
                               <p>@{{ (CambiarEstado.idiomas|filter:{'id':1})[0].nombre }}</p>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'has-error' : (formEncuestaE.$submitted || formEncuestaE.idioma.$touched) && formEncuestaE.idioma.$error.required}">
                                    <label class="control-label" for="idioma"><span class="asterisk">*</span> Estado de encuesta</label>
                                    <select class="form-control" id="idioma" name="idioma" ng-model="CambiarEstado.estados_encuestas_id" ng-options="item.id as item.nombre for item in estados" required>
                                        <option value="" disabled selected >Selecciones un estado</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
    
                        
                    </div>
                    <div class="modal-footer center" >
                        
                        <button type="submit" ng-click="guardarEstadoEncuesta()" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
    <!-- Modal copiar link -->
    <div class="modal fade" id="modalCopyLink" tabindex="-1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Copiar enlace</h4>
                </div>
                
                <div class="modal-body">
                    
                    <div class="input-group">
                        <input id="link" type="text" class="form-control" name="link" id="link" ng-model="link" >
                        <span class="input-group-addon" ng-click="copiarLink()" ><i class="glyphicon glyphicon-duplicate" ></i></span>
                    </div>
                    
                </div>
                <div class="modal-footer center" >
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                
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
       .table .dropdown-menu{
           left: auto;
           right: 0;
       }
    </style>

@endsection

@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/serviAdmin.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/appAdmin.js')}}"></script>
@endsection