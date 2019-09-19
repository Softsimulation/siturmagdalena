
@extends('layout._AdminLayout')

@section('title', 'Ver grupo de viaje')

@section('TitleSection', 'Ver grupo de viaje')

@section('app','ng-app="receptor.grupo_viaje"')

@section('controller','ng-controller="ver_grupo"')

@section('titulo','Grupos de viaje')
@section('subtitulo','Visualización de detalles de un grupo de viaje')

@section('content')
    

    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <div class="text-center">
        @if(Auth::user()->contienePermiso('create-encuestaReceptor'))
            <a href="/turismoreceptor/datosencuestados/{{$id}}" class="btn btn-lg btn-success">Crear encuesta</a>
        @endif
        @if(Auth::user()->contienePermiso('edit-grupoViaje'))
            <a href="/grupoviaje/editar/{{$id}}" class="btn btn-lg btn-warning">Editar grupo</a>
        @endif
    </div>
    <hr/>
        <div class="row">
            <div class="col-xs-12">
                <h3>Grupo de viaje @{{grupo.id}}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-12 col-sm-6">
                <label>Fecha de aplicación</label>
                <p>{{$grupo->fecha_aplicacion}}</p><br />
            </div>
            <div class="col-md-4 col-xs-12 col-sm-6">
                <label>Lugar de aplicación</label>
                <p>{{$grupo->lugar_aplicacion_id}} - {{$grupo->lugaresAplicacionEncuestum->nombre}}</p><br />
            </div>
            <div class="col-md-3 col-xs-12 col-sm-6">
                <label>Tipo de viaje</label>
                <p>{{$grupo->tipo_viaje_id}} - {{$grupo->tiposViaje->tiposViajeConIdiomas[0]->nombre}}</p><br />
            </div>
            <div class="col-md-2 col-xs-12 col-sm-6">
                <label>Personas encuestadas</label>
                <p>@{{grupo.personas_encuestadas}}</p><br />
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-overflow">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Tamaño del grupo de viaje</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mayores de 15 años PRES</td>
                            <td>@{{grupo.mayores_quince}}</td>
                        </tr>
                        <tr>
                            <td>Menores de 15 años PRES</td>
                            <td>@{{grupo.menores_quince}}</td>
                        </tr>
                        <tr>
                            <td>Mayores de 15 años NO PRES</td>
                            <td>@{{grupo.mayores_quince_no_presentes}}</td>
                        </tr>
                        <tr>
                            <td>Menores de 15 años NO PRES</td>
                            <td>@{{grupo.menores_quince_no_presentes}}</td>
                        </tr>
                        <tr>
                            <td>Personas del Magdalena</td>
                            <td>@{{grupo.personas_magdalena}}</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td>@{{total}}</td>
                        </tr>
                    </tbody> 
                </table>
            </div>
            
            
        </div>

            <fieldset>
                <legend>Encuestas del grupo</legend>
                <div class="row">
                    <div class="col-xs-12 table-overflow">
                        <table class="table table-hover table-striped" ng-if="grupo.visitantes.length != 0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Sexo</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th style="width: 100px;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="e in grupo.visitantes">
                                    <td>@{{e.id}}</td>
                                    <td>@{{e.nombre}}</td>
                                    <td ng-if="e.sexo">M</td><td ng-if="!e.sexo">F</td>
                                    <td>@{{e.email}}</td>
                                    <td>@{{e.historial_encuestas[0].estados_encuesta.nombre}}</td>
                                    @if(Auth::user()->contienePermiso('edit-encuestaReceptor'))
                                        <td class="text-center"><a href="/turismoreceptor/editardatos/@{{e.id}}" class="btn btn-xs btn-default" title="Editar registro"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        <div class="alert alert-info" ng-if="grupo.visitantes.length == 0">
                            <p>No hay encuestas digitadas</p>
                        </div>
                    </div>
                </div>
            </fieldset>
        
    
    <div class='carga'>

    </div>

@endsection

@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/administrador/grupo_viaje.js')}}"></script>
<script src="{{asset('/js/administrador/grupoViajeServices.js')}}"></script>
@endsection
