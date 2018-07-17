@extends('layout._AdminLayout')

@section('Title','Ver temporada')

@section ('estilos')
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

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection
@section('app','ng-app="situr_admin"')
@section('content')

<div class="main-page" ng-controller="verTemporadaCtrl">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    <h1 class="title1">Ver temporada</h1><br />
    <a href="/turismointerno/hogar/@{{id}}" class="btn btn-primary">Crear hogar</a><br /><br />
    <div class="alert alert-danger" ng-if="errores != null">
        <label><b>@Resource.EncuestaMsgError:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.errores.length>0">
            -@{{error[0]}}
        </div>
    </div>
    
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Nombre en español</label>
                <p>@{{temporada.Nombre}}</p>
            </div>
            
            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Nombre en inglés</label>
                <p>@{{temporada.Name}}</p>
            </div><br /><br /><br />

            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Fecha inicial</label>
                <p>@{{temporada.Fecha_ini}}</p>
            </div>
            
            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Fecha final</label>
                <p>@{{temporada.Fecha_fin}}</p>
            </div>

        </div>

        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#hogares" aria-controls="hogares" role="tab" data-toggle="tab">Hogares</a></li>
                <li role="presentation"><a href="#personas" aria-controls="personas" role="tab" data-toggle="tab">Personas</a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="hogares">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <input type="text" style="margin-bottom: .5em;" ng-model="prop.search1" class="form-control" id="inputSearch" placeholder="Buscar hogar...">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" style="text-align: center;">
                        <span class="chip" style="margin-bottom: .5em;">@{{(temporada.Hogares|filter:prop.search1).length}} resultados</span>
                    </div>
                </div>
                <div class="row" ng-show="prop.search1.length > 0 && (temporada.Hogares|filter:prop.search1).length != 0">
                    <div class="col-xs-12">
                        <div class="alert alert-success" role="alert" style="padding: .5em; margin-bottom: 0;">
                            @{{(temporada.Hogares|filter:prop.search1).length}} hogares han sido encontradas para la búsqueda '@{{prop.search1}}'
                        </div>
                    </div>
                </div>
                <div class="row" ng-show="temporada.Hogares.length > 0">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Barrio</th>
                                    <th>Dirección</th>
                                    <th>Estrato</th>
                                    <th>Encuestador</th>
                                    <th>Nombre entrevistado</th>
                                    <th>Fecha aplicación</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="item in temporada.Hogares|filter:prop.search1|itemsPerPage:10 as results" pagination-id="hogarP" style="border-bottom: .5px solid lightgray">
                                    <td>@{{$index+1}}</td>
                                    <td>@{{item.edificacione.barrio.nombre}}</td>
                                    <td>@{{item.edificacione.direccion}}</td>
                                    <td>@{{item.edificacione.estrato.nombre}}</td>
                                    <td>@{{item.digitadore.asp_net_user.Email}}</td>
                                    <td>@{{item.edificacione.nombre_entrevistado}}</td>
                                    <td>@{{item.fecha_realizacion }}</td>
                                    <td>
                                        <a href="/turismointerno/editarhogar/@{{item.id}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12" ng-if="(temporada.Hogares|filter:prop.search1).length == 0 && temporada.Hogares.length != 0">
                    <div class="alert alert-warning" role="alert">
                        No hay resultados para la búsqueda '@{{prop.search1}}'. <a href="#" ng-click="prop.search1 = ''">Presione aquí</a> para volver a mostrar todos los resultados.
                    </div>
                </div>
                <div class="row" ng-show="temporada.Hogares.length == 0">
                    <div class="col-xs-12">
                        <div class="alert alert-warning" role="alert">
                            No hay hogares ingresados
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                        <dir-pagination-controls max-size="8"
                                                 direction-links="true"
                                                 boundary-links="true"
                                                 pagination-id="hogarP">
                        </dir-pagination-controls>
                    </div>


                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade" id="personas">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <input type="text" style="margin-bottom: .5em;" ng-model="prop.search" class="form-control" id="inputSearch" placeholder="Buscar persona...">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6" style="text-align: center;">
                        <span class="chip" style="margin-bottom: .5em;">@{{(temporada.Personas|filter:prop.search).length}} resultados</span>
                    </div>
                </div>
                <div class="row" ng-show="prop.search.length > 0 && (temporada.Personas|filter:prop.search).length != 0">
                    <div class="col-xs-12">
                        <div class="alert alert-success" role="alert" style="padding: .5em; margin-bottom: 0;">
                            @{{(temporada.Personas|filter:prop.search).length}} personas han sido encontradas para la búsqueda '@{{prop.search}}'
                        </div>
                    </div>
                </div>
                <div class="row" ng-show="temporada.Personas.length > 0">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>IdPersona</th>
                                    <th>IdHogar</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Dirección</th>
                                    <th>Estrato</th>
                                    <th>Encuestador</th>
                                    <th>Fecha de Salida</th>
                                    <th>Última sección</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="item in temporada.Personas|filter:prop.search|itemsPerPage:10 as results" pagination-id="personaP" style="border-bottom: .5px solid lightgray">
                                    <td>@{{item.id}}</td>
                                    <td>@{{item.hogare.id}}</td>
                                    <td>@{{item.nombre}}</td>
                                    <td>@{{item.email}}</td>
                                    <td>@{{item.hogare.direccion}}</td>
                                    <td>@{{item.hogare.estrato}}</td>
                                    <td>@{{item.hogare.digitadore.asp_net_user.Email}}</td>
                                    <td>@{{item.viajes[0].fecha_inicio}}</td>
                                    <td>@{{item.viajes[0].ultima_sesion}}</td>
                                    <td>
                                        <a href="/turismointerno/viajesrealizados/@{{item.id}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12" ng-if="(temporada.Personas|filter:prop.search).length == 0 && temporada.Personas.length != 0">
                    <div class="alert alert-warning" role="alert">
                        No hay resultados para la búsqueda '@{{prop.search}}'. <a href="#" ng-click="prop.search = ''">Presione aquí</a> para volver a mostrar todos los resultados.
                    </div>
                </div>
                <div class="row" ng-show="temporada.Personas.length == 0">
                    <div class="col-xs-12">
                        <div class="alert alert-warning" role="alert">
                            No hay personas encuestadas ingresados
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                        <dir-pagination-controls max-size="8"
                                                 direction-links="true"
                                                 boundary-links="true"
                                                 pagination-id="personaP">
                        </dir-pagination-controls>
                    </div>


                </div>
            </div>
        </div>


            


    </div>

    <div class='carga'>

    </div>

</div>
@endsection