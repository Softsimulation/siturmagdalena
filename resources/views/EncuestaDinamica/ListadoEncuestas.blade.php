@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection','Configuración encuesta Ad Hoc')
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="ListarEncuestasRealizadasCtrl"')




@section('content')

<div>


    <input type="hidden" id="id" value="{{$id}}" />

    <div class="row" >

       <div class="col-md-12">
           
           
          <h2><h2>@{{encuesta.idiomas[0].nombre}}</h2></h2>
          <h4>Listado de encuestas</h4>
          
          
          <a class="btn btn-link btn-primary" href="/encuesta/listado" >Volver al listado</a>
          <button class="btn btn-success" ng-click="openModalAddEncuesta()" >+ Agregar</button>
          
          <table class="table table-striped">
            <thead>
              <tr>
                <th style="width:50px;" ></th>
                <th>Nombres y apellidos</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th style="width: 20px;" >Estado</th>
                <th style="width: 140px;" ></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="encuesta in encuesta.encuestas" >
                <td>@{{$index+1}}</td>
                <td>@{{ encuesta.nombres +' '+ encuesta.apellidos}}</td>
                <td>@{{ encuesta.email}}</td>
                <td>@{{ encuesta.telefono}}</td>
                <td>@{{ encuesta.estado.nombre }}</td>
                <td>
                    <a class="btn btn-xs btn-primary" href="/encuestaAdHoc/{{$id}}?cod=@{{encuesta.codigo}}" > ver  </a>
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
            <h4 class="modal-title">Agregar encuesta</h4>
          </div>
           <form name="form" >
              <div class="modal-body">
                 
                 <div class="row" >
                    
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error' : (form.$submitted || form.nombre.$touched) && form.nombre.$error.required}">
                            <label class="control-label">Nombres</label><br>
                            <input type="text" class="form-control" name="nombre" ng-model="usuario.nombres" placeholder="Nombres" required />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error' : (form.$submitted || form.apellidos.$touched) && form.apellidos.$error.required}">
                            <label class="control-label">Apellidos</label><br>
                            <input type="text" class="form-control" name="apellidos" ng-model="usuario.apellidos" placeholder="Apellidos" required />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error' : (form.$submitted || form.correo.$touched) && !form.correo.$valid}">
                            <label class="control-label">Correo electronico</label><br>
                            <input type="email" class="form-control" name="correo" ng-model="usuario.email" placeholder="Correo electronico" required />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error' : (form.$submitted || form.telefono.$touched) && form.correo.$error.required}">
                            <label class="control-label">Teléfono</label><br>
                            <input type="text" class="form-control" name="telefono" ng-model="usuario.telefono" placeholder="No teléfonico" required />
                        </div>
                    </div>
                       
                </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" ng-click="agregarencuestaUSuario()" value="Guardar" />
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
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/serviAdmin.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/appAdmin.js')}}"></script>
@endsection