@extends('layout._publicLayout')

@section('title', 'Mi planificador')

@section('estilos')
    <style>
    header{
        position: static;
        background-color: black;
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

        
    </style>
    
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/sweetalert.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/object-table-style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/ADM-dateTimePicker.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select.min.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/select2.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('/css/favoritos.css')}}" rel="stylesheet" type="text/css" />  
    <script src="{{asset('/js/plugins/angular.min.js')}}"></script> 
@endsection

@section('TitleSection', 'Mi planificador')

@section('content')
    <div class="container" ng-app="visitanteApp" ng-controller="planificador">
        <input type="hidden" ng-model="Id" ng-init="Id={{$id}}" />
        <div class="jumbotron" style="background-color: transparent;">
            <div class="row hide-page show-print">
                <div class="col-xs-12" style="text-align: center;">
                    <img src="/Content/image/logo2.png" alt="Logo Situr" height="160" />
                </div>
            </div>
            <h1 class="titulo">@{{planificador.Nombre}}</h1>
    
            <div id="planificadores" class="panel panel-default">
                <div class="panel-heading heading-planificador">
                    <div class="row">
                        <div class="col-xs-9">
                            @{{planificador.Nombre}} (@{{planificador.Fecha_inicio | date:'dd/MM/yyyy'}} - @{{planificador.Fecha_fin | date:'dd/MM/yyyy'}})
                        </div>
                        <div class="col-xs-3" style="text-align: right;">
                            <!--<span class="glyphicon glyphicon-pencil" style="margin-right: 1em; cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="Editar planificador"></span>-->
                            <!--<span class="glyphicon glyphicon-remove" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" title="@Resource.LabelFavEliminarPlanificador"></span>-->
                        </div>
                    </div>
    
    
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion@{{planificador.Id}}" role="tablist" aria-multiselectable="true">
    
                        <div class="panel panel-default" ng-repeat="dia in planificador.Dias">
                            <div class="panel-heading heading-dias" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion@{{planificador.Id}}" href="#collapse@{{$index}}_@{{planificador.Id}}" aria-expanded="false" aria-controls="collapseTwo" style="cursor: pointer;">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="panel-title">
    
                                            Día @{{$index + 1}} <small>(@{{dia.Items.length}} items)</small>
    
                                        </h4>
                                    </div>
                                </div>
    
                            </div>
                            <div id="collapse@{{$index}}_@{{planificador.Id}}" ng-class="{true:'panel-collapse collapse in',false:'panel-collapse collapse'}[$first]" role="tabpanel" aria-labelledby="heading@{{$index}}">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" ng-repeat="item in dia.Items">
                                            <span class="badge hide-print" ng-if="item.Tipo==4"><a href="/eventos/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="glyphicon glyphicon-new-window"></i></a></span>
                                            <span class="badge hide-print" ng-if="item.Tipo==2"><a href="/actividades/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="glyphicon glyphicon-new-window"></i></a></span>
                                            <span class="badge hide-print" ng-if="item.Tipo==1"><a href="/atracciones/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="glyphicon glyphicon-new-window"></i></a></span>
                                            <span class="badge hide-print" ng-if="item.Tipo==3"><a href="/proveedor/ver/@{{item.Id}}" target="_blank" title="Ver detalle"><i class="glyphicon glyphicon-new-window"></i></a></span>
                                            <!--<span class="badge hide-print" ng-show="!$first" ng-click="ordenarItem($index,dia.Items)" title="@Resource.LabelFavOrdenarItem"><i class="glyphicon glyphicon-chevron-up"></i></span>-->
                                            <div class="list-group-item-img">
                                                <img ng-src="@{{item.Imagen}}" alt="">
                                            </div>
                                            @{{item.Nombre}}
                                            <p class="hide-page show-print" style="font-size: 12px; overflow: auto; white-space: normal">@{{item.Descripcion}}</p>
                                            <p class="hide-page show-print">Dirección: @{{item.Direccion}}</p>
                                            <p class="hide-page show-print">Teléfono: @{{item.Telefono}}</p>
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
    
            </div>
            @if (!Auth::check())
                <div class="row hide-print">
                    <div class="col-xs-12" style="text-align: center;">
                        <button type="button" class="btn btn-lg btn-primary btn-orange" data-toggle="modal" data-target="#modalCrearPlanificador"><span class="glyphicon glyphicon-plus"></span> Agregar planificador</button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalCrearPlanificador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    
                                    </div>
                                    <div class="modal-body">
                                        <div class="row" style="padding: 0;">
                                            <div class="jumbotron" style="text-align: center;font-size: 4em; padding-top: 2em; padding-bottom: 2em;">
                                                <span class="glyphicon glyphicon-lock" style="font-size: 2.5em;"></span>
                                                <!--Para acceder a esta funcionalidad debe iniciar sesión-->
                                                <h2>Para acceder a esta funcionalidad debe iniciar sesión</h2>
                                                <!--Si aún no te encuentras registrado te invitamos a registrarte en nuestro Portal-->
                                                <p>Si aún no te encuentras registrado te invitamos a registrarte en nuestro Portal</p>
    
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6 col-md-6" style="text-align: right;">
                                                        <a href="/Account/Login" class="btn btn-lg btn-default">Iniciar sesión</a>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6 col-md-6" style="text-align: left;">
                                                        <a href="/Account/Register" class="btn btn-lg btn-success">Registrarse</a>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            @else
                <div class="row hide-print">
                    <div class="col-xs-12" style="text-align: center;">
                        <h3>Compartir @{{planificador.Nombre}}</h3>
                    </div>
                    <div class="col-xs-12" style="text-align: center;">
                        <!--<a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://siturmagdalena.com/Visitante/MiPlanificador/@ViewBag.Id&picture=https://www.siturmagdalena.com/Content/image/logo2.png&title=@ViewBag.Titulo', 'facebook-share-dialog', 'width=626,height=436'); return false;" class="btn btn-viewMore blue"><span class="ion-social-facebook"></span> Facebook</a>-->
                        <!--<a href="#" onclick="window.open('https://plus.google.com/share?url=' + encodeURIComponent(location.href), 'Google +', 'width=420,height=466'); return false;" class="btn btn-viewMore red"><span class="ion-social-googleplus"></span> Google +</a>-->
                        <!--<a href="#" onclick="window.open('https://twitter.com/intent/tweet?hashtags=SiturMagdalena&text=' + document.querySelector('.titulo').innerHTML + '&original_referer=' + encodeURIComponent(location.href) + '&tw_p=tweetbutton&url=' + encodeURIComponent(location.href), 'Twitter', 'width=640,height=250'); return false;" class="btn btn-viewMore lightblue"><span class="ion-social-twitter"></span> Twitter</a>-->
        
                    </div>
                    <div class="col-xs-12" style="text-align: center;">
                        <button type="button" class="btn btn-viewMore green" onclick="window.print()">
                            <i class="glyphicon glyphicon-print"></i> Imprimir este planificador
                        </button>
                    </div>
        
                </div>
            @endif
    
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