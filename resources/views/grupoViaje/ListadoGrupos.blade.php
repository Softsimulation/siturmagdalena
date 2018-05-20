
@extends('layout._AdminLayout')

@section('title', 'Listado grupo de viaje')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

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

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('TitleSection', 'Listado grupos de viaje')

@section('Progreso', '0%')

@section('NumSeccion', '0%')

@section('controller','ng-controller="index_grupo"')

@section('content')
    

<div class="container">
    <h1 class="title1">Listar grupos de viajes</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-4 col-md-2">
                <a href="/grupoviaje/grupoviaje" class="btn btn-primary">Insertar grupo</a>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-offset-3 col-md-4">
                <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Búsqueda de grupos de viaje (id, fecha, lugar)">

            </div>
            <div class="col-xs-12 col-sm-4 col-md-3" style="text-align: center;">
                <span class="chip">@{{(grupos|filter:prop.search).length}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                        <th>Id</th>
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
                        <td>@{{g.digitadore.asp_net_user.username}}</td>
                        <td>@{{g.visitantes.length}}/@{{g.personas_encuestadas}}</td>
                        <td><td style="text-align: center;"><a href="/grupoviaje/vergrupo/@{{g.id}}"><span class="glyphicon glyphicon-eye-open" title="Ver información del grupo"></span></a></td></td>
                    </tr>
                </table>
                <div class="alert alert-warning" role="alert" ng-show="grupos.length == 0 || (grupos|filter:prop.search).length == 0">No hay resultados disponibles <span ng-show="(grupos|filter:prop.search).length == 0">para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para ver todos los resultados.</span></div>
            </div>
            
        </div>
        <div class="row">
          <div class="col-6" style="text-align:center;">
          <dir-pagination-controls pagination-id="paginacion_grupos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>
          </div>
        </div>
    </div>
    
    <div class='carga'>

    </div>
</div>

@endsection


