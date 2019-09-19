@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo :: Listado de postulados en una vacante')

@section('TitleSection', 'Listado de postulados en una vacante')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="postuladosVacanteController"')

@section('titulo','Bolsa de empleo')
@section('subtitulo','Listado de postulados en una vacante. @{{vacante.postulaciones.length}} postulado(s) registrado(s).')

@section('estilos')
<style>
    .tile {
        width: 100%;
        background-color: white;
        box-shadow: 0px 1px 2px 0px rgba(0,0,0,.35);
    }
    .m-0{
        margin: 0;
    }
    .collapse{
        padding-top:2%;
    }
    .collapse .form-group label{
        border-bottom:1px dotted #ddd;
    }
    .collapse .form-group label+.form-control-static {
        padding: 0;
    }
    .collapse {
        border: 1px solid #eee;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    
    <div class="alert alert-danger" ng-if="errores != null">
        <h6>Errores</h6>
        <span class="messages" ng-repeat="error in errores">
              <span>@{{error}}</span>
        </span>
    </div>
    
    <div class="tile" style="width: 100%;">
        <div class="tile-body" style="width: 100%;">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="proveedor" class="control-label">Empresa</label>
                        <p class="form-control-static">@{{vacante.proveedores_rnt.razon_social}}</p>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="proveedor" class="control-label">Nombre de la vacante</label>
                        <p class="form-control-static">@{{vacante.nombre}}</p>
                        
                    </div>
                </div>
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#collapseInformacionVacante" aria-expanded="false" aria-controls="collapseInformacionVacante">Ver más información de la vacante</button>
                </div>
            </div>
        </div>
        
    </div>
    
   
       <div class="collapse" id="collapseInformacionVacante">
            
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group" >
                        <label for="nombre_vacante" class="control-label">Nombre de la vacante</label>
                        <p class="form-control-static">@{{vacante.nombre}}</p>
                        
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group" >
                        <label for="numero_vacantes" class="control-label">Número de vacantes</label>
                        <p class="form-control-static">@{{vacante.numero_vacantes}}</p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <p class="form-control-static">@{{vacante.descripcion}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4" ng-if="vacante.numero_maximo_postulaciones">
                    <div class="form-group">
                        <label for="numero_maximo_postulaciones" class="control-label">No. máximo de postulaciones</label>
                        <p class="form-control-static">@{{vacante.numero_maximo_postulaciones}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4" ng-if="vacante.fecha_vencimiento">
                    <div class="form-group" >
                        <label for="fecha_vencimiento" class="control-label">Fecha de vencimiento</label>
                        <p class="form-control-static">@{{vacante.fecha_vencimiento}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="anios_experiencia" class="control-label">Años de experiencia</label>
                        <p class="form-control-static">@{{vacante.anios_experiencia}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="municipio" class="control-label">Municipio</label>
                        <p class="form-control-static">@{{vacante.municipio.nombre}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="nivelEducacion" class="control-label">Nivel de educación</label>
                        <p class="form-control-static">@{{vacante.nivel_educacion.nombre}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4" >
                    <div class="form-group">
                        <label for="tipo_cargo_vacante_id" class="control-label">Tipo de cargo</label>
                        <p class="form-control-static">@{{vacante.tipos_cargos_vacante.nombre}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4" ng-if="vacante.salario_minimo">
                    <div class="form-group">
                        <label for="salario_minimo" class="control-label">Salario mínimo</label>
                        <p class="form-control-static">@{{vacante.salario_minimo}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4" ng-if="vacante.salario_maximo">
                    <div class="form-group">
                        <label for="salario_maximo" class="control-label">Salario máximo</label>
                        <p class="form-control-static">@{{vacante.salario_maximo}}</p>
                    </div>
                </div>
                <div class="col-xs-12 col-xs-12">
                    <div class="form-group">
                        <label for="requisitos">Requisitos</label>
                        <p class="form-control-static">@{{vacante.requisitos}}</p>
                    </div>
                </div>
            </div>
            
        </div>
            <br>
            <div class="row">
                <div class="col-xs-12" style="overflow-x: auto;">
                    <legend>Postulados <a ng-if="vacante.postulaciones.length > 0" href="/bolsaEmpleo/generararchivosvacante/@{{vacante.id}}" title="Descargar adjuntos" target="_blank" class="btn btn-xs btn-link"><span class="glyphicon glyphicon-download-alt"></span> Descargar</a></legend>
                    
                    <table class="table table-striped">
                        <tr>
                            <th>Nombre</th>
                            <th>Profesión</th>
                            <th>Municipio</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                        <tr dir-paginate="item in vacante.postulaciones|itemsPerPage:10 as results" pagination-id="paginacion_vacantes" >
                            
                            <td>@{{item.postulados_vacante.nombres}} @{{item.postulados_vacante.apellidos}}</td>
                            <td>@{{item.postulados_vacante.profesion}}</td>
                            <td>@{{item.postulados_vacante.municipio.nombre}}</td>
                            <td>@{{item.postulados_vacante.user.email}}</td>
                            <td style="text-align: center;">
                                <a class="btn btn-xs btn-default" href="@{{item.ruta_hoja_vida}}" target="_blank" title="Hoja de vida" ><span class="glyphicon glyphicon-paperclip"></span><span class="sr-only">Hoja de vida</span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-info" role="alert" ng-show="vacante.postulaciones.length == 0">No hay postulados registrados en esta vacante.</div>
                </div>
            </div>
            <div class="row">
              <div class="col-xs-12 text-center">
              <dir-pagination-controls pagination-id="paginacion_vacantes"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        <div class="text-center">
            <hr/>
                <a href="/bolsaEmpleo/vacantes" class="btn btn-lg btn-default">Volver</a>
        </div>
        
        <div class='carga'>
    
        </div>
    
@endsection

@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/main.js')}}"></script>
    <script src="{{asset('/js/administrador/bolsaEmpleo/bolsaEmpleoService.js')}}"></script>
@endsection