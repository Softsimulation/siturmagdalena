@extends('layout._AdminLayout')

@section('title', 'Ver noticia')

@section('estilos')
    <style>
        .descripcionNoticia h1, .descripcionNoticia h2, .descripcionNoticia h3, .descripcionNoticia h4, .descripcionNoticia h5, .descripcionNoticia h6, 
        .descripcionNoticia strong{
            font-weight: 500;
        }
    </style>
@endsection

@section('TitleSection', 'Ver noticia')

@section('app','ng-app="admin.noticia"')

@section('controller','ng-controller="verNoticiaCtrl"')

@section('titulo','Noticias')
@section('subtitulo','Visualización de detalles de noticia')

@section('content')
    <input type="hidden" ng-init="idNoticia={{$idNoticia}}" ng-model="idNoticia" />
       
       <div class="alert alert-info">
           <p>Esta es una visualización de información de la noticia publicada. Para editar <a href="/noticias/vistaeditar/@{{noticia.id}}/1">haga clic aquí</a>. Para ver la página pública de la noticia <a href="/promocionNoticia/ver/@{{noticia.id}}">haga clic aqui</a>.</p>
       </div>
       
                <h3>@{{noticia.tituloNoticia}} <small class="btn-block">@{{noticia.nombreTipoNoticia}}</small></h3>
                
                <!--<img  ng-if="portada != null" src="@{{portada.ruta}}" alt="" role="presentation">-->
                
                <p style="white-space:pre-line;"><i>@{{noticia.resumenNoticia}}</i></p>
                
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" ng-show="multimediasNoticias.length > 0">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" ng-repeat="img in multimediasNoticias" data-slide-to="@{{$index}}" ng-class="{'active': $index == 0}"></li>
                    
                  </ol>
                
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item" ng-repeat="img in multimediasNoticias" ng-class="{'active': $index == 0}">
                      <img ng-src="@{{img.ruta}}" alt="" role="presentation" class="img-responsive">
                      
                    </div>

                  </div>
                
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                  </a>
                </div>
                <br>
                <div ng-html="noticia.texto" class="descripcionNoticia"></div>
                
                <p class="text-right"><i>Fuente: <a href="@{{noticia.enlaceFuente}}">Clic para ver la fuente de esta noticia</a></i></p>
                
           
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
<script defer>
    $(document).ready(function(){
        setTimeout(function(){
            $('.descripcionNoticia h1').replaceWith(function(){
                return $("<h2 />", {html: $(this).html()});
            });
            $('.descripcionNoticia h2').replaceWith(function(){
                return $("<h3 />", {html: $(this).html()});
            });
        },1000);
        
    });
</script>
@endsection