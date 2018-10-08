@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection','Configuración encuesta Ad Hoc')
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="ListarEncuestasRealizadasCtrl"')

@section('titulo','Encuestas ADHOC - Respuestas')
@section('subtitulo','El siguiente listado cuenta con @{{encuesta.encuestas.length}} registro(s)')

@section('content')
<div class="alert alert-info text-center">
    <p>Encuesta:</p>
    <h3 style="margin: 0">@{{encuesta.idiomas[0].nombre}}</h3>
</div>
<div class="flex-list">
    <button type="button" class="btn btn-lg btn-success" ng-click="openModalAddEncuesta()" class="btn btn-lg btn-success" ng-if="encuesta.tipos_encuestas_dinamica_id==3">
      Agregar encuestado
    </button>
    <a class="btn btn-lg btn-default" href="/encuesta/listado" >Volver al listado</a>
</div>
<div>


    <input type="hidden" id="id" value="{{$id}}" />

    <div class="row" >

       <div class="col-md-12">
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:50px;" ></th>
                <th>Nombres y apellidos</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th style="width: 20px;">Estado</th>
                <th style="width: 110px;">Opciones</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in encuesta.encuestas" >
                <td>@{{$index+1}}</td>
                <td>@{{ item.nombres +' '+ item.apellidos}}</td>
                <td>@{{ item.email}}</td>
                <td>@{{ item.telefono}}</td>
                <td>@{{ item.estado.nombre }}</td>
                <td class="text-center">
                    <a class="btn btn-xs btn-default" href="/encuestaAdHoc/@{{item.codigo}}" title="Ver detalle"><span class="glyphicon glyphicon-eye-open"></span><span class="sr-only">Ver detalle</span></a>
                    <button type="button" class="btn btn-xs btn-default" ng-click="copiarLink(item.codigo)" ng-show="encuesta.tipos_encuestas_dinamica_id==3" title="Copiar enlace">
                        <span class="glyphicon glyphicon-link"></span><span class="sr-only">Copiar enlace</span>
                    </button>
                </td>
              </tr>
            </tbody>
          </table>
          
          <div class="alert alert-info" ng-if="encuesta.encuestas.length==0"  >
              No se encontraron registros almacenados
          </div>
          
        </div>

    </div>
    
    
    
    <!-- Modal -->
    <div id="modalAgregarEncuesta" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar encuestado</h4>
          </div>
           <form name="form" novalidate>
              <div class="modal-body">
                 
                 <div class="row" >
                    
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}">
                            <label class="control-label"><span class="asterisk">*</span> Nombres</label><br>
                            <input type="text" class="form-control" name="nombre" ng-model="usuario.nombres" placeholder="Nombres" required />
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.apellidos.$touched) && form.apellidos.$error.required}">
                            <label class="control-label"><span class="asterisk">*</span> Apellidos</label><br>
                            <input type="text" class="form-control" name="apellidos" ng-model="usuario.apellidos" placeholder="Apellidos" required />
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.correo.$touched) && !form.correo.$valid}">
                            <label class="control-label">Correo electrónico</label><br>
                            <input type="email" class="form-control" name="correo" ng-model="usuario.email" placeholder="Correo electronico" />
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group" ng-class="{'has-error' : (form.$submitted || form.telefono.$touched) && form.correo.$error.required}">
                            <label class="control-label">Teléfono</label><br>
                            <input type="text" class="form-control" name="telefono" ng-model="usuario.telefono" placeholder="No. teléfonico" />
                        </div>
                    </div>
                       
                </div>
                
              </div>
              <div class="modal-footer">
                
                  <input type="submit" class="btn btn-success" ng-click="agregarencuestaUSuario()" value="Guardar" />
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
              
            </form>
        </div>
    
      </div>
    </div>

</div>
 
@endsection
 
@section('estilos') 
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
       .error input, .error select{
                border: 1px solid red;
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