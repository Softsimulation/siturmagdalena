@extends('layout._AdminLayout')

@section('title', 'Ver noticia')

@section('estilos')
    <style>
        .row {
            margin: 1em 0 0;
        }
        .blank-page {
            padding: 1em;
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
        .carga>.text{
            position: absolute;
            display:block;
            text-align:center;
            width: 100%;
            top: 40%;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
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

@section('TitleSection', 'Ver noticia')

@section('app','ng-app="admin.noticia"')

@section('controller','ng-controller="verNoticiaCtrl"')

@section('content')
    <div class="container">
          <meta property="og:url"           content="http://situr-luifer.c9users.io/VerNoticia/2" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="SITUR" />
  <meta property="og:description"   content="SITUR" />
  <meta property="og:image"         content="@{{portada.ruta}}" />
        <input type="hidden" ng-init="idNoticia={{$idNoticia}}" ng-model="idNoticia" />
        <div>
            <br><br>
            <ul class="nav nav-tabs col-md-12 col-sm-12 col-xs-12" role="tablist">
                <li role="informacionGeneral" class="active"><a href="#informacionGeneral" aria-controls="informacionGeneral" role="tab" data-toggle="tab">Información general</a></li>
                <li role="multimedia" role="multimedia"><a href="#multimedia" aria-controls="multimedia" role="tab" data-toggle="tab">Multimedia</a></li>
              </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="informacionGeneral" style="padding:30px">
                
                <br><br>
                
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <label for="tipoNoticia">Tipo de noticia</label>
                        <input type="text" class="form-control" id="tipoNoticia" value="@{{noticia.nombreTipoNoticia}}" placeholder="Información no suministrada" readonly/>
                      
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <!--<input type="text" class="form-control" id="tituloNoticia" value="@{{noticia.tituloNoticia}}" placeholder="Información no suministrada" required/>-->
                        <p>@{{noticia.tituloNoticia}}</p>
                    </div>
                </div>
                <br>
                <div class="row" ng-if="portada != null">
                    <div class="col-xs-12">
                        <img src="@{{portada.ruta}}"/>
                    </div>
                    
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="resumenNoticia">Resumen</label>
                          <p>@{{noticia.resumenNoticia}}</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <div ng-html="noticia.texto"></div>
                    </div>
                </div>
                <br>
                <div class="row" ng-if="noticia.enlaceFuente != null">
                    <div class="col-xs-12">
                        <label for="fuenteNoticia">Fuente</label>
                        <p>@{{noticia.enlaceFuente}}</p>
                      
                    </div>
                </div>
                <br>
            </div>
            
            <div role="tabpanel" class="tab-pane" id="multimedia" style="padding:30px">
                <br><br>
                <button ng-if="editar.idIdioma == 1" type="button" class="btn btn-success btn-block" ng-click="abrirModalCrearNoticia()">Agregar multimedia</button>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-hover">
                            <tr>
                                <th>Adjunto</th>
                                <th>Texto alternativo</th>
                                <th>Portada</th>
                                
                            </tr>
                            
                            <tr ng-repeat="x in multimediasNoticias">
                                <td> 
                                  <a href="@{{x.ruta}}" target="_blank">Archivo adjunto @{{$index+1}}</a>
                                </td>
                                <td>@{{x.texto}}</td>
                                <td>@{{x.portada == true ? 'Si' : 'No'}}</td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                <div class="col-md-12" ng-if="multimediasNoticias.length == 0">
                      <div class="alert alert-info" role="alert"><b>No se ha creado multimedia para esta noticia</b></div>
                  </div>
            </div>
        </div>
        <!--<a target="_blank" href="http://www.facebook.com/sharer.php?u=http://situr-luifer.c9users.io/Noticias/2-20180504-00:22:52.jpg">Compartir FB</a>-->
    </div>
@endsection
@section('javascript')
<script src="{{asset('/js/plugins/angular-material/angular-animate.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-aria.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-messages.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-material/angular-material.min.js')}}"></script>
<script src="{{asset('/js/plugins/material.min.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('/js/plugins/ckeditor/ngCkeditor-v2.0.1.js')}}"></script>
<script src="{{asset('/js/dir-pagination.js')}}"></script>
<script src="{{asset('/js/administrador/noticias/noticias.js')}}"></script>
<script src="{{asset('/js/administrador/noticias/noticiaServices.js')}}"></script>
@endsection