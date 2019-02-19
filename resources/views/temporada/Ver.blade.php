@extends('layout._AdminLayout')

@section('Title','Detalle de la temporada')

@section('app','ng-app="admin.temporadas"')

@section('titulo','Temporadas')
@section('subtitulo','Detalle de la temporada')

@section('content')

<div class="main-page" ng-controller="verTemporadaCtrl">
    <input type="hidden" ng-model="id" ng-init="id={{$id}}" />
    @if(Auth::user()->contienePermiso('edit-encuestaInterno|create-encuestaInterno'))
        <div class="text-center">
            <a href="/turismointerno/hogar/@{{id}}" class="btn btn-lg btn-success">Crear hogar</a><br /><br />    
        </div>
    @endif
    
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
                <div class="form-group form-group-lang">
                    <label>Nombre en español</label> <!--<button type="button" class="btn btn-xs btn-link" data-lang="en">Ver en idioma <span class="langToShow">Inglés</span></button>-->
                    <p class="langSelected" data-lang="es">@{{temporada.Nombre}}</p>
                    <p class="langSelected hidden" data-lang="en">@{{temporada.Name}}</p>
                </div>
                
            </div>
            
            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Nombre en inglés</label>
                <p>@{{temporada.Name}}</p>
            </div><br /><br /><br />

            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Fecha inicial</label>
                <p>@{{temporada.Fecha_ini | date:'dd/MM/yyyy'}}</p>
            </div>
            
            <div class="col-md-6 col-xs-12 col-sm-12">
                <label>Fecha final</label>
                <p>@{{temporada.Fecha_fin | date:'dd/MM/yyyy'}}</p>
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
                <div class="flex-list" ng-show="temporada.Hogares.length > 0">
                    <button type="button" ng-click="mostrarFiltro=!mostrarFiltro" class="btn btn-default" title="filtrar registros"><span class="glyphicon glyphicon-filter"></span> Filtrar resultados</button>
                </div>
                
                
                <div class="text-center" ng-if="(temporada.Hogares | filter:search).length > 0 && (search != undefined)">
                    <p>Hay @{{(temporada.Hogares | filter:search).length}} registro(s) que coinciden con su búsqueda</p>
                </div>
                <div class="alert alert-info" ng-if="temporada.Hogares.length == 0">
                    <p>No hay registros almacenados</p>
                </div>
                <div class="alert alert-warning" ng-if="(temporada.Hogares | filter:search).length == 0 && temporada.Hogares.length > 0">
                    <p>No existen registros que coincidan con su búsqueda</p>
                </div>
                <div class="alert alert-info" role="alert"  ng-show="mostrarFiltro == false && (search.edificacione.barrio.nombre.length > 0 || search.edificacione.direccion.length > 0 || search.edificacione.estrato.nombre.length > 0 || search.digitadore.user.username.length > 0 || search.edificacione.nombre_entrevistado.length > 0 || search.fecha_realizacion.length > 0)">
                    Actualmente se encuentra algunos de los filtros en uso, para reiniciar el listado de las encuestas haga clic <span><a href="#" ng-click="search = ''">aquí</a></span>
                </div>
                <div class="row" ng-show="temporada.Hogares.length > 0">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Barrio</th>
                                    <th>Dirección</th>
                                    <th>Estrato</th>
                                    <th>Encuestador</th>
                                    <th>Nombre entrevistado</th>
                                    <th>Fecha aplicación</th>
                                    <th></th>
                                </tr>
                                <tr ng-show="mostrarFiltro == true">
                                    
                                    <td><input type="text" ng-model="search.edificacione.barrio.nombre" name="nombreBarrio" id="nombreBarrio" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                    <td><input type="text" ng-model="search.edificacione.direccion" name="direccion" id="direccion" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                    <td><input type="text" ng-model="search.edificacione.estrato.nombre" name="nombreEstrato" id="nombreEstrato" class="form-control input-sm" id="inputSearch" maxlength="150" autocomplete="off"></td>
                                    <td><input type="text" ng-model="search.digitadore.user.username" name="nombreDigitador" id="nombreDigitador" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                                    <td><input type="text" ng-model="search.edificacione.nombre_entrevistado" name="nombreEntrevistado" id="nombreEntrevistado" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                                    <td><input type="text" ng-model="search.fecha_realizacion" name="fecha_realizacion" id="fecha_realizacion" class="form-control input-sm" maxlength="150" autocomplete="off"></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr dir-paginate="item in temporada.Hogares|filter:search|itemsPerPage:10 as results" pagination-id="hogarP" style="border-bottom: .5px solid lightgray">
                                    <td>@{{item.edificacione.barrio.nombre}}</td>
                                    <td>@{{item.edificacione.direccion}}</td>
                                    <td>@{{item.edificacione.estrato.nombre}}</td>
                                    <td>@{{item.digitadore.user.username}}</td>
                                    <td>@{{item.edificacione.nombre_entrevistado}}</td>
                                    <td>@{{item.fecha_realizacion | date:'dd-MM-yyyy' }}</td>
                                    <td>
                                        @if(Auth::user()->contienePermiso('edit-encuestaInterno|create-encuestaInterno'))
                                            <a href="/turismointerno/editarhogar/@{{item.id}}" class="btn btn-xs btn-default" title="Editar registro"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>
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
                
                <div class="flex-list">
                    <input type="text" style="margin-bottom: .5em;" ng-model="prop.searchPersona" class="form-control" id="inputSearch" placeholder="Buscar persona...">
                </div>
                
                
                <div class="text-center" ng-if="(temporada.Personas | filter:searchPersona).length > 0 && (searchPersona != undefined)">
                    <p>Hay @{{(temporada.Personas | filter:searchPersona).length}} registro(s) que coinciden con su búsqueda</p>
                </div>
                <div class="alert alert-info" ng-if="temporada.Personas.length == 0">
                    <p>No hay registros almacenados</p>
                </div>
                <div class="alert alert-warning" ng-if="(temporada.Personas | filter:searchPersona).length == 0 && temporada.Personas.length > 0">
                    <p>No existen registros que coincidan con su búsqueda</p>
                </div>
                
                <div class="row" ng-show="temporada.Personas.length > 0">
                    <div class="col-xs-12" style="overflow-x: auto;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID persona</th>
                                    <th>ID Hogar</th>
                                    <th>Nombre</th>
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
                                    <td>@{{item.persona.id}}</td>
                                    <td>@{{item.persona.hogare.id}}</td>
                                    <td>@{{item.persona.nombre}}</td>
                                    <td>@{{item.persona.hogare.edificacione.direccion}}</td>
                                    <td>@{{item.persona.hogare.edificacione.estrato.nombre}}</td>
                                    <td>@{{item.persona.hogare.digitadore.user.username}}</td>
                                    <td>@{{item.fecha_inicio}}</td>
                                    <td>@{{item.ultima_sesion}}</td>
                                    <td>
                                        @if(Auth::user()->contienePermiso('edit-encuestaInterno|create-encuestaInterno'))
                                            <a href="/turismointerno/viajesrealizados/@{{item.persona.id}}" class="btn btn-xs btn-default" title="Editar registro"><span class="glyphicon glyphicon-pencil"></span><span class="sr-only">Editar</span></a>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>
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
@section('javascript')
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/administrador/temporada/temporadas.js')}}"></script>
<script src="{{asset('/js/administrador/temporada/services.js')}}"></script>
<script>
    $('.showLang').on('click',function(){
        var lang = $(this)
    });
</script>
@endsection