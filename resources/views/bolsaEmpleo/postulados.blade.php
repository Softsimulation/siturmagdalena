@extends('layout._AdminLayout')

@section('title', 'Bolsa de empleo - Vacantes')

@section('TitleSection', 'Edición de vacante')

@section('app','ng-app="bolsaEmpleoApp"')

@section('controller','ng-controller="postuladosVacanteController"')

@section('estilos')
    <style>
        body{
            overflow: visible;
        }
    </style>
@endsection

@section('content')
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <br><br>
    <div class="alert alert-danger" ng-if="errores != null">
        <h6>Errores</h6>
        <span class="messages" ng-repeat="error in errores">
              <span>@{{error}}</span>
        </span>
    </div>
    
    <div class="container">
       <div>
            
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="proveedor" class="control-label">Empresa</label>
                        <input type="text" class="form-control" name="proveedor" value="@{{vacante.proveedores_rnt.razon_social}}" readonly />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group" >
                        <label for="nombre_vacante" class="control-label">Nombre de la vacante</label>
                        <input type="text" class="form-control" id="nombre_vacante" name="nombre_vacante" value="@{{vacante.nombre}}" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" >
                        <label for="numero_vacantes" class="control-label">Número de vacantes</label>
                        <input type="number" class="form-control" value="@{{vacante.numero_vacantes}}" name="numero_vacantes"  readonly/>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="5" readonly>@{{vacante.descripcion}}</textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="numero_maximo_postulaciones" class="control-label">No. máximo de postulaciones</label>
                        <input type="number" class="form-control" value="@{{vacante.numero_maximo_postulaciones}}" name="numero_maximo_postulaciones" placeholder="No ingresado" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" >
                        <label for="fecha_vencimiento" class="control-label">Fecha de vencimiento</label>
                        <input type="text" name="fecha_vencimiento" class="form-control" value="@{{vacante.fecha_vencimiento}}" readonly placeholder="No ingresado" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="anios_experiencia" class="control-label">Años de experiencia</label>
                        <input type="number" class="form-control" value="@{{vacante.anios_experiencia}}" name="anios_experiencia" placeholder="No ingresado" readonly/>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="municipio" class="control-label">Municipio</label>
                        <input type="text" name="municipio" class="form-control" value="@{{vacante.municipio.nombre}}" readonly placeholder="No ingresado" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nivelEducacion" class="control-label">Nivel de educación</label>
                        <input type="text" name="nivelEducacion" class="form-control" value="@{{vacante.nivel_educacion.nombre}}" readonly placeholder="No ingresado" />
                    </div>
                </div>
                <div class="col-md-4" >
                    <div class="form-group">
                        <label for="tipo_cargo_vacante_id" class="control-label">Tipo de cargo</label>
                        <input type="text" name="tipo_cargo_vacante_id" class="form-control" value="@{{vacante.tipos_cargos_vacante.nombre}}" readonly placeholder="No ingresado" />
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4" >
                    <div class="form-group">
                        <label for="salario_minimo" class="control-label">Salario mínimo</label>
                        <input type="number" class="form-control" value="@{{vacante.salario_minimo}}" name="salario_minimo" placeholder="No ingresado" readonly/>
                    </div>
                </div>
                <div class="col-md-4" >
                    <div class="form-group">
                        <label for="salario_maximo" class="control-label">Salario máximo</label>
                        <input type="number" class="form-control" value="@{{vacante.salario_maximo}}" name="salario_maximo" placeholder="No ingresado" readonly/>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="requisitos">Requisitos</label>
                        <textarea class="form-control" name="requisitos" id="requisitos" rows="5" readonly>@{{vacante.requisitos}}</textarea>
                    </div>
                </div>
            </div>
                
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <h6>Postulados <a ng-if="vacante.postulaciones.length > 0" href="/bolsaEmpleo/generararchivosvacante/@{{vacante.id}}" title="Descargar adjuntos" target="_blank" class="btn btn-primary"><span class="glyphicon glyphicon-download-alt"></span></a></h6>
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Profesión</th>
                            <th>Municipio</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                        <tr dir-paginate="item in vacante.postulaciones|itemsPerPage:10 as results" pagination-id="paginacion_vacantes" >
                            <td></td>
                            <td>@{{item.postulados_vacante.nombres}} @{{item.postulados_vacante.apellidos}}</td>
                            <td>@{{item.postulados_vacante.profesion}}</td>
                            <td>@{{item.postulados_vacante.municipio.nombre}}</td>
                            <td>@{{item.postulados_vacante.user.email}}</td>
                            <td style="text-align: center;">
                                <a class="btn" href="@{{item.ruta_hoja_vida}}" target="_blank" title="Hoja de vida" ><span class="glyphicon glyphicon-paperclip"></span></a>
                            </td>
                        </tr>
                    </table>
                    <div class="alert alert-info" role="alert" ng-show="vacante.postulaciones.length == 0">No hay postulados registrados en esta vacante.</div>
                </div>
            </div>
            <div class="row">
              <div class="col-6" style="text-align:center;">
              <dir-pagination-controls pagination-id="paginacion_vacantes"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
              </div>
            </div>
        </div>
        
        <br><br>
        <div class="row" style="text-align:center">
            <div class="col-xs-12">
                <a href="/bolsaEmpleo/vacantes" class="btn btn-raised btn-default">Volver</a>
            </div>
        </div>
        
        <div class='carga'>
    
        </div> 
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