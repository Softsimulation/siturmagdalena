
@extends('layout._encuestaDinamicaLayout')

@section('Title','@{{seccion.encuesta.idiomas[0].nombre}}')
@section('TitleSection','@{{seccion.encuesta.idiomas[0].nombre}}')
@section('Control','ng-controller="RegistroUsuarioEncuestaCtrl"')




@section('contenido')

<div>
   
   <div class="row" >
       <div class="col-md-6" >
           <h2>Bienvenidos</h2>
           <h3>{{$encuesta->idiomas[0]->nombre}}</h3>
           <p>{{$encuesta->idiomas[0]->descripcion}}</p>
       </div>
        <div class="col-md-6" >
           <form name="form" >
                <div class="row" >
                    
                    <input type="hidden" ng-model="usuario.encuesta" ng-init="usuario.encuesta={{$encuesta->id}}" />
            
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
                            <input type="email" class="form-control" name="correo" ng-model="usuario.email" placeholder="Correo electronico" />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group" ng-class="{'error' : (form.$submitted || form.telefono.$touched) && form.correo.$error.required}">
                            <label class="control-label">Teléfono</label><br>
                            <input type="text" class="form-control" name="telefono" ng-model="usuario.telefono" placeholder="No teléfonico" />
                        </div>
                    </div>
                       
                </div>
                <div class="row" >
                    <div class="col-md-12" >
                        <input type="submit" class="btn btn-success btn-block" ng-click="registroUsuarioEncuesta()" value="Registrar" />
                    </div>
                </div>
            </form>
       </div>
   </div>
   
</div>
   
@endsection

@section('estilos')
    <style type="text/css">
       .error input, .error select{
                border: 1px solid red;
        }
    </style>
@endsection