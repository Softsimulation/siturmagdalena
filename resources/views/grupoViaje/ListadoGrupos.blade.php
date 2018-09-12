
@extends('layout._AdminLayout')

@section('title', 'Listado grupo de viaje')

@section('estilos')
    <style>
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

    </style>
@endsection

@section('TitleSection', 'Listado grupos de viaje')

@section('app','ng-app="receptor.grupo_viaje"')

@section('controller','ng-controller="index_grupo"')

@section('titulo','Grupos de viaje')
@section('subtitulo','El siguiente listado cuenta con @{{grupos.length}} registro(s)')

@section('content')
<div class="flex-list">
    <a href="/grupoviaje/grupoviaje" type="button" class="btn btn-lg btn-success">
      Agregar grupo
    </a> 
    <div class="form-group has-feedback" style="display: inline-block;">
        <label class="sr-only">Búsqueda de grupo</label>
        <input type="text" ng-model="prop.search" class="form-control input-lg" id="inputEmail3" placeholder="Buscar grupo...">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
    </div>      
</div>
<div class="text-center" ng-if="(grupos).length > 0 && (prop.search != '' && prop.search != undefined)">
    <p>Hay @{{(grupos | filter:prop.search).length}} registro(s) que coinciden con su búsqueda</p>
</div>
<div class="alert alert-info" ng-if="grupos.length == 0">
    <p>No hay registros almacenados</p>
</div>
<div class="alert alert-warning" ng-if="(grupos | filter:prop.search).length == 0 && grupos.length > 0">
    <p>No existen registros que coincidan con su búsqueda</p>
</div>    

        <div class="row">
            <div class="col-xs-12 table-overflow">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de aplicación</th>
                        <th>Lugar de aplicación</th>
                        <th>Nombre de usuario</th>
                        <th>Encuestas diligenciadas</th>
                        <th style="width: 80px"></th>
                        
                    </tr>
                    <tr dir-paginate="g in grupos |filter:prop.search | itemsPerPage:10" pagination-id="paginacion_grupos" >
                        <td>
                            @{{g.id}}
                        </td>
                        <td>@{{g.fecha_aplicacion | date:'dd-MM-yyyy'}}</td>
                        <td>@{{g.lugares_aplicacion_encuestum.nombre}}</td>
                        <td>@{{g.digitadore.user.nombre}}</td>
                        <td>@{{g.visitantes.length}}/@{{g.personas_encuestadas}}</td>
                        <td style="text-align: center;">
                            <a href="/grupoviaje/vergrupo/@{{g.id}}" class="btn btn-xs btn-default" title="Ver información del grupo">
                                <span class="glyphicon glyphicon-eye-open"aria-hidden="true"></span><span class="sr-only">Ver detalles</span>
                            </a>
                        </td>
                    </tr>
                </table>
                
            </div>
            
        </div>
        <div class="row">
          <div class="col-xs-12 text-center">
          <dir-pagination-controls pagination-id="paginacion_grupos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
        
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

