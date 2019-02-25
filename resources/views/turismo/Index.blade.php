<?php
/*
* Vista para listados del portal
*/
$colorTipo = ['label-primary','label-success','label-danger', 'label-info', 'label-warning'];

function getItemType($type){
    $path = ""; $name = ""; $title = "";
    switch($type){
        case(1):
            $title = "Actividades";
            $name = "Actividad";
            $path = "/actividades/ver/";
            $controller = 'ActividadesController';
            break;
        case(2):
            $title = "Atracciones";
            $name = "Atracción";
            $path = "/atracciones/ver/";
            $controller = 'AtraccionesController';
            break;
        case(3):
            $title = "Destinos";
            $name = "Destino";
            $path = "/destinos/ver/";
            $controller = 'DestinosController';
            break;
        case(4):
            $title = "Eventos";
            $name = "Evento";
            $path = "/eventos/ver/";
            $controller = 'EventosController';
            break; 
        case(5):
            $title = "Rutas turísticas";
            $name = "Ruta turística";
            $path = "/rutas/ver/";
            $controller = 'RutasTuristicasController';
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path, 'title' => $title, 'controller' => $controller);
}

$tipoItem = (isset($_GET['tipo'])) ? $_GET['tipo'] : 0 ;

$tituloPagina = ($tipoItem) ? getItemType($tipoItem)->title : "Qué hacer";

$countItems = false;

for($i = 0; $i < count($query); $i++){
    if($tipoItem && $query[$i]->tipo == $tipoItem){
        $countItems = true;
        break;
    }
}
$countItems = ($tipoItem) ? $countItems : count($query) > 0;
?>
@extends('layout._publicLayout')

@section('Title', '¿Qué hacer en el departamento del Cesar?')


@section('meta_og')
<meta property="og:title" content="{{$tituloPagina}}" />
<meta property="og:image" content="{{asset('/img/brand/128.png')}}" />
<meta property="og:description" content="{{$tituloPagina}}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        header{
            margin-bottom: 2%;   
        }
        #opciones{
            text-align:right;
            background-color: white;
            padding: 4px .5rem;
            margin-top: 1rem;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position:relative;
            z-index: 2;
            box-shadow: 0px -1px 5px -2px rgba(0,0,0,.3);
        }
        #opciones>button, #opciones form{
            display:inline-block;
            border: 0;
            margin: 0 2px;
        }
        #opciones button {
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);
            background-color: white;
        }
        #opciones button:hover{
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.2);
        }
        .input-group .form-control{
            font-size: 1rem;
            height: auto;
        }
        .input-group .input-group-addon {
            padding: 0;
        }
        .input-group .input-group-addon .btn{
            border-radius: 2px;
            border: 0;
        }
        .mdi::before {
            font-size: 1rem;
        }
        #collapseFilter{
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            min-width: 250px;
            max-width: 280px;
            overflow: auto;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 100;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            padding: 1rem;
        }
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text .btn {
            border-radius: 0;
            border: 0;
        }
        
        .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
            padding: 0;
        }
        
        .card-header {
            padding: 2px .5rem;
        }
        .card-header .btn {
            padding: 0;
            color: #333;
            white-space: wrap;
        }
        .tile.tile-overlap .tile-img {
            background-image: url(/img/no-image.jpg);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .label {
            display: inline-block;
            padding: .2rem .5rem;
            font-size: .875rem;
            font-weight: 500;
            border-radius: 2px;
            margin-bottom: 2px;
        }
        .tile-date {
            display:inline-block;
            background-color: #ddd;
            color: #333;
        }
        .tile.tile-overlap .tile-img img {
            font-size: 0.875rem;
            text-align: center;
            color: dimgrey;
        }
        .title-section{
            text-transform: uppercase;
            font-weight: 700;
            color: #004a87;
        }
    </style>
@endsection

@section('content')
    <div class="header-list">
        <div class="container">
            @if(isset($_GET['tipo']))
            <ol class="breadcrumb">
              
              <li><a href="/quehacer">{{trans('resources.menu.queHacer')}}</a></li>
              <li class="active">{{$tituloPagina}}</li>
              
            </ol>
            @endif
            <h2 class="title-section">{{$tituloPagina}}</h2>
            
            <div id="opciones">
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">Vista de lista</span></button>
                <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">Vista de mosaico</span></button>
                <!--<form id="formSearch" method="POST" action="{{URL::action('QueHacerController@postSearch')}}" class="form-inline">-->
                <!--    {{ csrf_field() }}-->
                <!--    <div class="col-auto">-->
                <!--      <label class="sr-only" for="searchMain">Buscador general</label>-->
                <!--      <div class="input-group">-->
                <!--        <input type="text" class="form-control" name="searchMain" id="searchMain" placeholder="¿Qué desea buscar?" maxlength="255">-->
                <!--        <div class="input-group-prepend">-->
                <!--          <div class="input-group-text">-->
                <!--              <button type="submit" class="btn btn-default" title="Buscar"><span class="mdi mdi-magnify" aria-hidden="true"></span><span class="sr-only">Buscar</span></button>-->
                <!--          </div>-->
                <!--        </div>-->
                <!--      </div>-->
                <!--    </div>-->
                <!--</form>-->
                <!--<button type="button" class="btn btn-default"><span class="mdi mdi-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
            </div>
        </div>
        
    </div>
    
    <div class="container">
        <br/>
        <div id="listado" class="tiles">
            
            <?php $hasTipo = 0 ?>
            @foreach($query as $entidad)
            @if(!$tipoItem || ($tipoItem && $entidad->tipo == $tipoItem))
            <?php $hasTipo = $hasTipo + 1 ?>
            <div class="tile tile-overlap">
                <div class="tile-img">
                    @if($entidad->portada != "")
                    <img src="{{ $entidad->portada }}" alt="Imagen de presentación de {{ $entidad->nombre }}"/>
                    @endif
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="{{URL::action(getItemType($entidad->tipo)->controller.'@getVer', ['id' => $entidad->id])}}">{{ $entidad->nombre }}</a></h3>
                        <span class="label {{$colorTipo[$entidad->tipo - 1]}}">{{getItemType($entidad->tipo)->name}}</span>
                        @if($entidad->tipo == 4)
                        <p class="label tile-date">Del {{date('d/m/Y', strtotime($entidad->fecha_inicio))}} al {{date('d/m/Y', strtotime($entidad->fecha_fin))}}</p>
                        @endif
                    </div>
                    <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 0.0) ? (($entidad->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 1.0) ? (($entidad->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 2.0) ? (($entidad->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 3.0) ? (($entidad->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button" title="{{$entidad->calificacion_legusto}}"><span class="{{ ($entidad->calificacion_legusto > 4.0) ? (($entidad->calificacion_legusto <= 4.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span><span class="sr-only">5</span></button>
                            
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            <!--<div class="tile tile-overlap">
                <div class="tile-img">
                    <img src="http://www.valledupar.com/sistema-noticias/data/upimages/valledupar_poporos2.jpg" alt=""/>
                </div>
                <div class="tile-body">
                    <div class="tile-caption">
                        <h3><a href="#">Parque de la Leyenda Vallenata “Consuelo Araujo Noguera”</a></h3>    
                    </div>
                    <div class="tile-buttons">
                        <div class="inline-buttons">
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">1</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">2</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">3</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">4</span></button>
                            <button type="button"><span class="mdi mdi-star-outline" aria-hidden="true"></span><span class="sr-only">5</span></button>
                        </div>
                        <button type="button" title="Añadir a favorito"><span class="mdi mdi-heart-outline" aria-hidden="true"></span><span class="sr-only">Añadir a favorito</span></button>
                        
                    </div>
                </div>
            </div> -->
            
        </div>
        @if(!$hasTipo)
            <div class="alert alert-info">
                <p>No hay registro que mostrar</p>
            </div>
        @endif
    </div>

@endsection

@section('javascript')
<!--<script src="{{asset('/js/public/vibrant.js')}}"></script>-->
<!--<script src="{{asset('/js/public/setProminentColorImg.js')}}"></script>-->
<script>

var colorTipo = ['bg-primary','bg-success','bg-danger', 'bg-info', 'bg-warning'];

function getItemType(type){
    switch(type){
        case(1):
            title = "Actividades";
            name = "Actividad";
            path = "/actividades/ver/";
            controller = 'ActividadesController';
            break;
        case(2):
            title = "Atracciones";
            name = "Atracción";
            path = "/atracciones/ver/";
            controller = 'AtraccionesController';
            break;
        case(3):
            title = "Destinos";
            name = "Destino";
            path = "/destinos/ver/";
            controller = 'DestinosController';
            break;
        case(4):
            title = "Eventos";
            name = "Evento";
            path = "/eventos/ver/";
            controller = 'EventosController';
            break; 
        case(5):
            title = "Rutas turísticas";
            name = "Ruta turística";
            path = "/rutas/ver/";
            controller = 'RutasTuristicasController';
            break;
    }
    return {'name':name, 'path':path, 'title' : title, 'controller' : controller};
}
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var tipoItem = getParameterByName('tipo') != undefined ? getParameterByName('tipo') : 0 ;
    function changeViewList(obj, idList, view){
        var element, name, arr;
        element = document.getElementById(idList);
        name = view;
        element.className = "tiles " + name;
    }
        
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#formSearch').submit(function(){
        $.ajax({
          type: "POST",
          url: '{{URL::action("QueHacerController@postSearch")}}',
          data: {
              'search': $('#searchMain').val()
          },
          success: function (data){
              if (!data.success){
                  alert('No hay resultados para su búsqueda');
              }
              var html = '';
              for(var i = 0; i < data.query.length; i++){
                if(!tipoItem || (tipoItem && data.query[i].tipo == tipoItem)){
                    html += '<div class="tile tile-overlap">'
                                +'<div class="tile-img">';
                        if(data.query[i].portada != ""){
                            html += '<img src="'+data.query[i].portada +'" alt="Imagen de presentación de '+ data.query[i].nombre +'"/>';
                        }
                    html +=     +'</div>'
                                    +'<div class="tile-body">'
                                        +'<div class="tile-caption">'
                                            +'<h3><a href="'+getItemType(data.query[i].tipo).path+data.query[i].id +'">'+ data.query[i].nombre +'</a></h3>'
                                            +'<span class="label '+colorTipo[data.query[i].tipo - 1]+'">'+getItemType(data.query[i].tipo).name+'</span>'
                                        +'</div>'
                                        +'<div class="tile-buttons">'
                                            +'<div class="inline-buttons">';
                    //Acá falta las fechas en los eventos
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 0.0) ? ((data.query[i].calificacion_legusto <= 0.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 1.0) ? ((data.query[i].calificacion_legusto <= 1.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';            
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 2.0) ? ((data.query[i].calificacion_legusto <= 2.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>';
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 3.0) ? ((data.query[i].calificacion_legusto <= 3.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button>'; 
                    html += '<button type="button" title="'+data.query[i].calificacion_legusto+'"><span class="'+ ((data.query[i].calificacion_legusto > 4.0) ? ((data.query[i].calificacion_legusto <= 4.9) ? "ionicons-inline ion-android-star-half" : "ionicons-inline ion-android-star") : "ionicons-inline ion-android-star-outline")+'" aria-hidden="true"></span><span class="sr-only">1</span></button></div></div></div></div></div>';
              }
              }
              $('#listado').html(html);
          },
          dataType: 'json'
        });
        return false;
    });
        
</script>
@endsection
