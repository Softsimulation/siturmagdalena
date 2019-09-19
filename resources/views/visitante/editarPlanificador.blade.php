@extends('layout._publicLayout')

@section('Title', 'Editar planificador')

@section('estilos')
    <style>
    .main-page{
        margin-top: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0px 2px 2px 0px rgba(0,0,0,.35);
        background-color: white;
        border-radius: 6px;
    }
    
    .ADMdtp-box footer {
       /*height: 1.7em;*/
       position: relative;
       overflow: hidden;
       background: transparent;
       color: #333;
       border: 0;
       margin: 0;
       padding: 0;
    }
    
    .ADMdtp-box header{
        background: white;
    }
    .parallax {
        /* The image used */
        background-image: url("/res/bg.jpg");
    
        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .header-bg-fixed{
        text-align: center;
        padding: 1rem;
    }
    .header-bg-fixed h2{
        text-transform: uppercase;
        background-color: white;
        padding: .5rem 1rem;
        border-radius: 4px;
        margin-top: 0;
        color: #18337e;
    }
    .row{
        margin: 0;
    }
    </style>
    <link href="{{asset('/css/public/b4.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/favoritos.css')}}" rel="stylesheet" type="text/css" />  
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script>
@endsection



@section('content')
<div class="main-page container" ng-app="visitanteApp" ng-controller="editarPlanificadorCtrl">
    <div class="header-bg-fixed pb-0">
        <h2>Editar planificador</h2>
        <p>Planifica tu viaje y guarda marca como favorito los lugares que más te gusten.</p>
    </div>
    <input type="hidden" ng-model="Id" ng-init="Id={{$id}}" />
    <!--<div class="container">-->
    <!--    <div class="row" ng-if="intrucciones.ver">-->
            
    <!--    </div>-->
    <!--</div>-->
    
    
    <!--<div style="text-align: center;border-top: 1px solid lightgray;">-->
    <!--    <button type="button" class="btn btn-default" style="border-top-left-radius: 0; border-top-right-radius: 0;margin-bottom: 1em;border-top: 0;" ng-click="intrucciones.ver = !intrucciones.ver">-->
    <!--        <span ng-if="!intrucciones.ver">Mostrar instrucciones</span><span ng-if="intrucciones.ver">Ocultar instrucciones</span>-->
    <!--    </button>-->
    <!--</div>-->
    
    <div class="alert alert-danger" ng-if="errores != null">
        <h4><b>Corrige los errores:</b></h4>
        
        <div ng-repeat="error in errores">
            -@{{error[0]}}
        </div>
    </div>
    
    @if (Auth::check())
        <div class="text-center">
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalAyuda">¿Necesitas ayuda? Has clic aquí para saber cómo navegar en esta página</button>
        </div>
        
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="title-fav" ng-if="favoritos.length > 0"><h3 class="font-weight-normal">Mis favoritos</h3></div>
                    
                    <ul class="list-group list-group-flush" ng-if="favoritos.length > 0">
                        <li class="list-group-item" dir-paginate="fav in favoritos|itemsPerPage:10" pagination-id="fav" id="fav-@{{fav.Id}}" ng-drag="true" ng-drag-data="fav" ng-drag-success="onDragComplete($data,$event, fav.Id)" draggable="false" title="Arrastre y suelte en un día de un planificador">
                            <div class="d-flex align-items-center">
                                <span class="fas fa-grip-lines-vertical text-muted p-1" aria-hidden="true"></span>
                                <img ng-src="@{{fav.Imagen}}" alt="Imagen de @{{fav.Nombre}}" width="50">
                                <p class="m-0 p-2" style="flex: 1 1 auto;">@{{fav.Nombre}}</p>
                                <div style="min-width: 56px;">
                                    <button type="button" class="btn btn-xs btn-link" ng-click="quitarFavoritos(fav)" title="Quitar de favoritos">
                                        <span class="ion-android-favorite-outline text-danger" aria-hidden="true"></span>
                                        <span class="sr-only">Quitar de favoritos</span>
                                    </button>
                                    
                                    <a href="/eventos/ver/@{{fav.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="fav.Tipo== 4">
                                        <span class="ion-android-open" aria-hidden="true"></span>
                                        <span class="sr-only">Ver detalle favorito</span>
                                    </a>
                                    <a href="/actividades/ver/@{{fav.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="fav.Tipo== 2">
                                        <span class="ion-android-open" aria-hidden="true"></span>
                                        <span class="sr-only">Ver detalle favorito</span>
                                    </a>
                                    <a href="/atracciones/ver/@{{fav.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="fav.Tipo== 1">
                                        <span class="ion-android-open" aria-hidden="true"></span>
                                        <span class="sr-only">Ver detalle favorito</span>
                                    </a>
                                    <a href="/proveedor/ver/@{{fav.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="fav.Tipo== 3">
                                        <span class="ion-android-open" aria-hidden="true"></span>
                                        <span class="sr-only">Ver detalle favorito</span>
                                    </a>
                                    
                                </div>
                            </div>
                            
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-12" style="text-align: center; padding-top: 2em; padding-bottom: 2em;" ng-if="favoritos.length == 0">
                            <!--Aún no tiene favoritos seleccionados-->
                            <h2 class="h2 font-weight-normal">Aún no tiene favoritos seleccionados</strong></h2>
                            <!--Te invitamos a navegar por nuestro portal y conocer todas las actividades, atracciones, eventos y proveedores de servicios turísticos dispuestos para ti-->
                            <p>Te invitamos a navegar por nuestro portal y conocer todas las actividades, atracciones, eventos y proveedores de servicios turísticos dispuestos para tir</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="text-align: center;">

                            <dir-pagination-controls max-size="8"
                                                     direction-links="true"
                                                     boundary-links="true" pagination-id="fav">
                            </dir-pagination-controls>

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 d-flex flex-wrap align-items-center" ng-if="planificador == null">
                    <br />
                    <div ng-if="planificadores.length == 0 && favoritos.length > 0" style="text-align: center; padding-top: 2em; padding-bottom: 2em;">
                        <!--¿Aún no has hecho tu primer planificador?-->
                        <h2 class="h2 font-weight-normal">¿Aún no has hecho tu primer planificador?</h2>
                        <!--Presiona en el botón Agregar planificador y empieza-->
                        <p>Presiona en el botón Agregar planificador y empieza</p>
                    </div>
                    <div ng-if="favoritos.length ==  0 && planificadores.length == 0" style="text-align: center; padding-top: 2em; padding-bottom: 2em;">
                        <!--Para crear un planificador debe tener favoritos seleccionados-->
                        <h2 class="h2 font-weight-normal">Para crear un planificador debe tener favoritos seleccionados</h2>
                    </div>
                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 d-flex flex-wrap align-items-center" ng-if="planificador != null">
                    <div id="planificadores" class="panel panel-default w-100">
                        <div class="panel-heading heading-planificador">
                            <div class="row">
                                <div class="col-xs-9">
                                    @{{planificador.Nombre}} <small>(@{{planificador.Fecha_inicio}} - @{{planificador.Fecha_fin}})</small>
                                </div>
                                <div class="col-xs-3" style="text-align: right;">
                                    <button type="button" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="bottom" ng-click="abrirEditarPlanificador()" title="Editar planificador">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        <span class="sr-only">Editar planificador</span>
                                    </button>
                                    
                                    <!--<span class="glyphicon glyphicon-remove" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="@Resource.LabelFavEliminarPlanificador"></span>-->
                                </div>
                            </div>


                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="accordion@{{planificador.Id}}" role="tablist" aria-multiselectable="true">

                                <div class="panel panel-default" ng-repeat="dia in planificador.Dias" ng-drop="true" ng-drop-success="onDropComplete($index,dia,planificador,$data,$event)">
                                    <div class="panel-heading heading-dias" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion@{{planificador.Id}}" href="#collapse@{{$index}}_@{{planificador.Id}}" aria-expanded="false" aria-controls="collapseTwo" style="cursor: pointer;">
                                        <div class="row">
                                            <div class="col-xs-10">
                                                <p class="panel-title font-weight-normal">

                                                    Día @{{$index + 1}} <small>(@{{dia.Items.length}} items)</small>

                                                </p>
                                            </div>
                                            <div class="col-xs-2 text-right">
                                                <button type="button" class="btn btn-xs btn-default" ng-click="removeDay(planificador, $index)" title="Remover día">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                    <span class="sr-only">Remover día</span>
                                                </button>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <div id="collapse@{{$index}}_@{{planificador.Id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading@{{$index}}">
                                        <div class="panel-body p-1">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item" ng-repeat="item in dia.Items|orderBy:'Orden'">
                                                    <div class="d-flex align-items-center">
                                                        <img ng-src="@{{item.Imagen}}" alt="Imagen de @{{item.Nombre}}" width="50">
                                                        <p class="m-0 p-2" style="flex: 1 1 auto;">@{{item.Nombre}}</p>
                                                        <div style="min-width: 90px;">
                                                            <button type="button" class="btn btn-xs btn-link" ng-click="deleteItem($index,dia.Items)" title="Remover ítem">
                                                                <span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>
                                                                <span class="sr-only">Remover ítem</span>
                                                            </button>
                                                            <button type="button" class="btn btn-xs btn-link" ng-click="ordenarItem(item,dia.Items)" title="Ordenar ítem">
                                                                <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
                                                                <span class="sr-only">Ordenar ítem</span>
                                                            </button>
                                                            <a href="/eventos/ver/@{{item.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="item.Tipo== 4">
                                                                <span class="ion-android-open" aria-hidden="true"></span>
                                                                <span class="sr-only">Ver detalle favorito</span>
                                                            </a>
                                                            <a href="/actividades/ver/@{{item.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="item.Tipo== 2">
                                                                <span class="ion-android-open" aria-hidden="true"></span>
                                                                <span class="sr-only">Ver detalle favorito</span>
                                                            </a>
                                                            <a href="/atracciones/ver/@{{item.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="item.Tipo== 1">
                                                                <span class="ion-android-open" aria-hidden="true"></span>
                                                                <span class="sr-only">Ver detalle favorito</span>
                                                            </a>
                                                            <a href="/proveedor/ver/@{{item.Id}}" class="btn btn-xs btn-link" target="_blank" title="Ver detalle favorito" ng-if="item.Tipo== 3">
                                                                <span class="ion-android-open" aria-hidden="true"></span>
                                                                <span class="sr-only">Ver detalle favorito</span>
                                                            </a>
                                                            
                                                        </div>
                                                    </div>
                                                    <!--<span class="badge" ng-click="deleteItem($index,dia.Items)" title="Remover ítem"><i class="glyphicon glyphicon-remove"></i></span>-->
                                                    <!--<span class="badge" ng-show="!$first" ng-click="ordenarItem(item,dia.Items)" title="Ordenar ítem"><i class="glyphicon glyphicon-chevron-up"></i></span>-->
                                                    <!--<img ng-src="@{{item.Imagen}}" alt="" width="50"> @{{item.Nombre}}-->
                                                </li>
                                            </ul>
                                            <!--Arrastre y suelte los items que desea agregar a este día-->
                                            <p ng-if="dia.Items.length == 0">Arrastre y suelte los items que desea agregar a este día</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Agregue días al planificador para poder agregar items. Recuerde que solo podrá añadir el número de días indicado en el rango de fecha ingresado al crear el planificador.-->
                                <p ng-if="planificador.Dias.length == 0">
                                    Agregue días al planificador para poder agregar items. Recuerde que solo podrá añadir el número de días indicado en el rango de fecha ingresado al crear el planificador.
                                </p>

                            </div>

                        </div>
                        <div class="panel-footer" style="cursor: pointer;" ng-click="addDay(planificador)">
                            <div class="row">
                                <div class="col-xs-10">
                                    Agregar día
                                </div>
                                <div class="col-xs-2" style="text-align: right">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12" style="text-align: center">
                    <!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span></button>-->
                    <button type="button" class="btn btn-lg btn-success" ng-click="guardar()" ><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                </div>
            </div>
            
            <br />
            
            
            <div class="row" ng-show="listaPlanificadores.length > 0">
                <h2 class="col-xs-12">Planificadores anteriores</h2>
                <div class="col-xs-12 col-sm-12 col-md-6 col-test" dir-paginate="planificador in listaPlanificadores | orderBy: 'Fecha_inicio'|itemsPerPage:6" pagination-id="plan" ng-show="listaPlanificadores.length > 0">
                    <div id="listaplanificadores" class="panel panel-default">
                        <div class="panel-heading heading-planificador">
                            <div class="row">
                                <div class="col-xs-12">
                                    @{{planificador.Nombre}} (@{{planificador.Fecha_inicio | date:'dd-MM-yyyy'}} - @{{planificador.Fecha_fin | date:'dd-MM-yyyy'}})
                                </div>
                                
                            </div>


                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="accordion-old-@{{planificador.Id}}" role="tablist" aria-multiselectable="true">

                                <div class="panel panel-default" ng-repeat="dia in planificador.Dias">
                                    <div class="panel-heading heading-dias" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion-old-@{{planificador.Id}}" href="#collapse-old-@{{$index}}_@{{planificador.Id}}" aria-expanded="true" aria-controls="collapseTwo" style="cursor: pointer;" ng-if="$first">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="panel-title">

                                                    Día @{{$index + 1}} <small>(@{{dia.Items.length}} items)</small>

                                                </h4>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="panel-heading heading-dias" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion-old-@{{planificador.Id}}" href="#collapse-old-@{{$index}}_@{{planificador.Id}}" aria-expanded="false" aria-controls="collapseTwo" style="cursor: pointer;" ng-if="!$first">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4 class="panel-title">

                                                    Día @{{$index + 1}} <small>(@{{dia.Items.length}} items)</small>

                                                </h4>
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <div id="collapse-old-@{{$index}}_@{{planificador.Id}}" ng-class="{true:'panel-collapse collapse in',false:'panel-collapse collapse'}[$first]"  role="tabpanel" aria-labelledby="heading@{{$index}}">
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <li class="list-group-item" ng-repeat="item in dia.Items|orderBy:'Orden'">
                                                    <span class="badge" ng-if="item.Tipo==4"><a href="/eventos/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="ion-android-open"></i></a></span>
                                                    <span class="badge" ng-if="item.Tipo==2"><a href="/actividades/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="ion-android-open"></i></a></span>
                                                    <span class="badge" ng-if="item.Tipo==1"><a href="/atracciones/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="ion-android-open"></i></a></span>
                                                    <span class="badge" ng-if="item.Tipo==3"><a href="/proveedor/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="ion-android-open"></i></a></span>
                                                    <!--<span class="badge" ng-click="deleteItem($index,dia.Items)" title="@Resource.LabelFavRemoverItem"><i class="glyphicon glyphicon-remove"></i></span>-->
                                                    <!--<span class="badge" ng-show="!$first" ng-click="ordenarItem($index,dia.Items)" title="@Resource.LabelFavOrdenarItem"><i class="glyphicon glyphicon-chevron-up"></i></span>-->
                                                    <img ng-src="@{{item.Imagen}}" alt="" width="50"> @{{item.Nombre}}
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="panel-footer" style="cursor: pointer;">
                            <a href="/visitante/miplanificador/@{{planificador.Id}}">
                                <div class="row">
                                    <div class="col-xs-10">
                                        Ver detalles del planificador
                                    </div>
                                    <div class="col-xs-2" style="text-align: right">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12" style="text-align: center;">
                    
                        <dir-pagination-controls max-size="8"
                                                 direction-links="true"
                                                 boundary-links="true" pagination-id="plan">
                        </dir-pagination-controls>

                </div>
            </div>
            
            
            <!-- Modal editar planificador-->
            <div class="modal fade" id="modalEditarPlanificador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            	<div class="modal-dialog" role="document">
            		<div class="modal-content">
            			<div class="modal-header">
            				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            				<h4 class="modal-title" id="myModalLabel">Editar planificador</h4>
            			</div>
            			<form name="editarForm" role="form" novalidate>
            				<div class="modal-body">
            					<div class="row">
            						<div class="col-xs-12">
            							<div class="form-group" ng-class="{'has-error': (editarForm.$submitted || editarForm.inputCrearNombre.$touched) && editarForm.inputCrearNombre.$error.required}">
            								<label for="inputCrearNombre">Nombre</label>
            								<input type="text" class="form-control" id="inputCrearNombre" name="inputCrearNombre" ng-model="nuevoPlanificador.Nombre" placeholder="Ingrese el nombre del planificador" required>
            							</div>
            						</div>
            					
            						<div class="col-xs-12 col-sm-6">
            							<div class="form-group" ng-class="{'has-error': (editarForm.$submitted || editarForm.Fecha_inicio.$touched) && editarForm.Fecha_inicio.$error.required}">
            								<label for="Fecha_inicio">Fecha inicio</label>
            								<adm-dtp name="Fecha_inicio" id="Fecha_inicio" ng-model='nuevoPlanificador.Fecha_inicio' mindate="@{{fechaActual}}" maxdate="'@{{nuevoPlanificador.Fecha_fin}}'" options="optionFecha" placeholder="Ingrese fecha de inicio" ng-required="true"></adm-dtp>
            								<span ng-if="(editarForm.$submitted || editarForm.Fecha_inicio.$touched) && editarForm.Fecha_inicio.$error.required">Requerido</span>
            							</div>
            						</div>
            
            						<div class="col-xs-12 col-sm-6">
            							<div class="form-group" ng-class="{'has-error': (editarForm.$submitted || editarForm.Fecha_fin.$touched) && editarForm.Fecha_fin.$error.required}">
            								<label for="Fecha_fin">Fecha fin</label>
            								<adm-dtp name="Fecha_fin" id="Fecha_fin" ng-model='nuevoPlanificador.Fecha_fin' mindate="'@{{nuevoPlanificador.Fecha_inicio}}'"options="optionFecha" placeholder="Ingrese fecha de inicio" ng-required="true"></adm-dtp>
            								<span ng-if="(editarForm.$submitted || editarForm.Fecha_fin.$touched) && editarForm.Fecha_fin.$error.required">Requerido</span>
            							</div>
            						</div>
            					</div>
            				</div>
            				<div class="modal-footer">
            					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            					<button type="submit" class="btn btn-success" ng-click="editarPlanificador()">Editar</button>
            				</div>
            			</form>
            		</div>
            	</div>
            </div>
            
        <!-- Modal ayuda -->
            <div class="modal fade" id="modalAyuda" tabindex="-1" role="dialog" aria-labelledby="modalAyudaLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalAyudaLabel">¿Qué hacer en esta página?</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <img src="/img/instruccion_planificador_1.png" alt="" class="img-responsive" role="presentation" aria-hidden="true">
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <p><strong>Para guardar tus favoritos</strong></p>
                            <ol class="text-secondary">
                                <!--Navegue en el portal a través de las diferentes atracciones, actividades, proveedores de servicio turístico y eventos publicados.-->
                                <li>Navegue en el portal a través de las diferentes lugares, atracciones, actividades y demás cosas que tenemos para ti.</li>
                                <!--Presione en el botón Guardar como favorito indicado con el icono de un corazón.-->
                                <li>Presione en el botón Guardar como favorito indicado con el icono de un corazón.</li>
                                <!--Podrá listar sus favoritos en la opción Planifica tu viaje ubicado en la barra de navegación-->
                                <li>Podrá listar sus favoritos en la opción Planifica tu viaje ubicado en la barra de navegación</li>
                            </ol>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p><strong>Para crear un planificador</strong></p>
                            <ol class="text-secondary">
                                <!--Presione el botón Crear planificador e ingrese la información solicitada.-->
                                <li>Presione el botón Crear planificador e ingrese la información solicitada.</li>
                                <!--Agregue los días en los que realizará alguna actividad.-->
                                <li>Agregue los días en los que realizará alguna actividad.</li>
                                <!--Arrastre sus favoritos y sueltelos en los días agregados. Podrá organizar los elementos arrastrados en los días.-->
                                <li>Arrastre sus favoritos y sueltelos en los días agregados. Podrá organizar los elementos arrastrados en los días.</li>
                                <!--Cuando termine guarde los cambios para no perder la información. Luego podrá imprimir o compartir su planificador.-->
                                <li>Cuando termine guarde los cambios para no perder la información. Luego podrá imprimir o compartir su planificador.</li>
                            </ol>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <img src="/img/instruccion_planificador_2.png" alt="" class="img-responsive" role="presentation" aria-hidden="true">
                        </div>
                        
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
        
    @else
    <div class="text-center">
        <div class="jumbotron" style="text-align: center;font-size: 4em; padding-top: 2em; padding-bottom: 2em;">
            <span class="glyphicon glyphicon-lock" style="font-size: 2.5em;"></span>
            <!--Para acceder a esta funcionalidad debe iniciar sesión-->
            <h2>Para acceder a esta funcionalidad debe iniciar sesión</h2>
            <!--Si aún no te encuentras registrado te invitamos a registrarte en nuestro Portal-->
            <p>Si aún no te encuentras registrado te invitamos a registrarte en nuestro Portal</p>
            <div class="row">
                <div class="col-xs-6 col-md-6 col-md-6" style="text-align: right;">
                    <a href="/login/login" class="btn btn-lg btn-default">Iniciar sesión</a>
                </div>
                <!--<div class="col-xs-6 col-md-6 col-md-6" style="text-align: left;">-->
                <!--    <a href="/Account/Register" class="btn btn-lg btn-success">Registrarse</a>-->
                <!--</div>-->
            </div>
        </div>
        
    </div>
        
    @endif
    
    <div class='carga'>

    </div>
</div>
@endsection

@section('javascript')
    <script src="{{asset('/js/ADM-dateTimePicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}" async></script>
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/ngDraggable.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/list.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/visitante/main.js')}}"></script>
    <script src="{{asset('/js/visitante/service.js')}}"></script>
@endsection