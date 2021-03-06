<?php
use Illuminate\Support\Facades\Input;
header("Access-Control-Allow-Origin: *");

function parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

function getItemType($type){
    $path = ""; $name = ""; $headerImg = "";
    switch($type){
        case(1):
            $name = trans('resources.menu.menuServicios.alojamientos');
            $headerImg = "alojamientos.png";
            $path = "/actividades/ver/";
            break;
        case(2):
            $name = trans('resources.menu.menuServicios.establecimientosDeGastronomia');
            $headerImg = "restaurante_1366.png";
            $path = "/atracciones/ver/";
            break;
        case(3):
            $name = trans('resources.menu.menuServicios.agenciasDeViaje');
            $headerImg = "agencias.png";
            $path = "/destinos/ver/";
            break;
        case(4):
            $name = trans('resources.menu.menuServicios.establecimientosDeEsparcimiento');
            $headerImg = "esparcimiento.png";
            $path = "/eventos/ver/";
            break; 
        case(5):
            $name = trans('resources.menu.menuServicios.transporteEspecializado');
            $headerImg = "agencias.png";
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path, 'headerImg'=>$headerImg);
}

$tituloPagina = "Prestadores de servicios turísticos";
if(isset($params) && $params != null){
    $tituloPagina = getItemType($params)->name;
}

$colorTipo = ['primary','success','danger', 'info', 'warning'];


?>
@extends('layout._publicLayout')

@section('Title', $tituloPagina)

@section('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    
    <style>
        .tile .tile-caption h3 {
            margin: 0;
            font-size: 1rem;
            text-transform: uppercase;
            font-weight: 700;
        }
        .ionicons-inline {
            font-size: 1.5rem;
        }
        .tile .tile-img .text-overlap {
            font-family: Roboto, sans-serif;
        }
        .tile-date {
            font-size: 0.875rem;
            font-family: Roboto, sans-serif;
            color: #757575;
        }
        .nav-bar > .brand a img{
            width: auto;
            height: 72px;
        }
        #opciones{
            text-align:right;
            /*background-color: white;*/
            padding: 4px .5rem;
            margin-top: 1rem;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position:relative;
            z-index: 2;
            /*box-shadow: 0px -1px 5px -2px rgba(0,0,0,.3);*/
        }
        #opciones>button, #opciones form{
            display:inline-block;
            border: 0;
            margin: 0 2px;
        }
        #opciones button {
            box-shadow: 0px 1px 3px 0px rgba(0,0,0,.3);
            background-color: white;
            border-radius: 50%;
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
        #collapseFilter{
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            max-width: 220px;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 60;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
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
        .filtros {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            background: white;
            padding: .5rem;
            height: 100%;
            width: 270px;
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,.35);
            overflow: auto;
            display:none;
        }
        .filtros .panel-default>.panel-heading+.panel-collapse>.panel-body{
            max-height: 350px;
            overflow: auto;
        }
        .filtros .panel {
            border: 0;
        }
        .filtros .panel-group .panel+.panel {
            margin: 0;
            border-top: 1px solid #ddd;
        }
        .filtros .panel-default>.panel-heading {
            background-color: white;
            padding: 0;
        }
        .filtros .panel-title {
            font-size: 1rem;
            font-weight: 500;
        }
        .filtros .panel-title>a {
            padding: .5rem 0;
            display: block;
        }
        .filtros .panel-default>.panel-heading .panel-title>a[aria-expanded=true], .filtros .panel-default>.panel-heading .panel-title>a{
            position:relative;
        }
        .filtros .panel-default>.panel-heading .panel-title>a[aria-expanded=true]:before {
            content: "-";
        }
        .filtros .panel-default>.panel-heading .panel-title>a:before {
            content: "+";
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            font-size: 2rem;
            align-items: center;
            padding: 0 1rem;
            font-family: Open sans,sans-serif;
            font-weight: 700;
            color: #d3d3d3;
        }
        .filtros ::-webkit-scrollbar {
            width: 8px;
        }
         
        .filtros ::-webkit-scrollbar-track {
            /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); */
            background: #eee;
            border-radius: 10px;
        }
         
        .filtros ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); */
            background: rgba(0,0,0,0.15); 
        }
        .filtros ::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.35);
        }
        .filtros #btnClose{
            position:absolute;
            top: 1rem;
            right: 1rem;
            border: 0;
        }
    </style>
    @if(isset($params))
    <style>
        .header-list{
            background-image: url(../../img/headers/<?php echo getItemType($params)->headerImg ?>);
            background-size: cover;
            min-height: 200px;
            background-position: bottom;
            display: flex;
            align-items: flex-end;
            position:relative;
        }
        
        .header-list:after{
            content: "";
            position:absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            min-height: 70px;
            background-image: url(../../img/headers/banner_bottom.png);
            background-size: 100% auto;
            background-repeat: no-repeat;
            background-position: bottom;
            z-index: 1;
        }
        .header-list:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            z-index: 0;
            background: rgba(0,0,0,0.3);
            background: -moz-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(0,0,0,0.3)), color-stop(100%, rgba(246,41,12,0)));
            background: -webkit-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -o-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: -ms-linear-gradient(left, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            background: linear-gradient(to right, rgba(0,0,0,0.3) 0%, rgba(246,41,12,0) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#f6290c', GradientType=1 );
        }
        .header-list>.container{
            position:relative;
            z-index: 2;
        }
        .title-section{
            color: white;
            text-shadow: 0px 1px 3px rgba(0,0,0,.65);
            font-size: 2rem;
            background-color: rgba(0,0,0,.2);
            padding: .25rem .5rem;
            border-radius: 10px;
            display: inline-block;
        }
        .w-100{
            width: 100%;
        }
    </style>
    @endif
@endsection

@section('TitleSection','Actividades')

@section('meta_og')
<meta property="og:title" content="Proveedores de servicios turísticos" />
<meta property="og:image" content="{{asset('/res/img/brand/128.png')}}" />
<meta property="og:description" content="Conoce los proveedores de servicios turísticos en el Magdalena"/>
@endsection

@section ('estilos')
    <link href="{{asset('/css/public/pages.css')}}" rel="stylesheet">
    <link href="{{asset('/css/public/details.css')}}" rel="stylesheet">
    <link href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" rel="stylesheet">
    
@endsection

@section('content')
<div class="header-list">
    <div class="container">
        
        <h2 class="title-section">{{$tituloPagina}}</h2>
        <div id="opciones">
             @if($proveedores != null && count($proveedores) > 0)
             <button type="button" id="btnFiltros" class="btn btn-default" title="Mostrar filtros" onclick="toggleFilter();"><span class="mdi mdi-filter"></span> <span class="d-none d-sm-inline-block sr-only">Mostrar filtros</span></button>
             @endif
            <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','tile-list')" title="Vista de lista"><span class="mdi mdi-view-sequential" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.vistaLista')}}</span></button>
            <button type="button" class="btn btn-default d-none d-sm-inline-block" onclick="changeViewList(this,'listado','')" title="Vista de mosaico"><span class="mdi mdi-view-grid" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.vistaMosaico')}}</span></button>
            <!--<form class="form-inline" action="/proveedor/index" method="get">-->
            <!--    <div class="form-group">-->
            <!--        <label class="sr-only" for="searchMain">{{trans('resources.header.campoDeBusqueda')}}</label>-->
            <!--        <div class="input-group">-->
            <!--            <input type="text" class="form-control" id="searchMain" name="buscar" placeholder="{{trans('resources.header.queDeseaBuscar')}}" maxlength="255">-->
            <!--            <div class="input-group-addon"><button type="submit" class="btn btn-default" title="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.buscar')}}</span></button></div>-->
            <!--        </div>-->
            <!--        <input type="hidden" name="tipo" value="{{isset($_GET['tipo']) ? $_GET['tipo'] : ''}}" />-->
            <!--    </div>-->
                
            <!--</form>-->
            <!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-filter" aria-hidden="true" title="Filtrar resultados" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"></span><span class="sr-only">Filtrar resultados</span></button>-->
        </div>
    </div>
</div>
<div class="container">
    @if($proveedores != null && count($proveedores) > 0)
        <div class="filtros">
            <h4>Filtros</h4>
            <form class="form-inline" action="/proveedor/index" method="get">
                <div class="form-group w-100">
                    <label class="sr-only" for="searchMain">{{trans('resources.header.campoDeBusqueda')}}</label>
                    <div class="input-group w-100">
                        <input type="text" class="form-control" id="searchMain" name="buscar" placeholder="{{trans('resources.header.queDeseaBuscar')}}" maxlength="255" required>
                        <div class="input-group-addon"><button type="submit" class="btn btn-block btn-default" title="Buscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span><span class="sr-only">{{trans('resources.listado.buscar')}}</span></button></div>
                    </div>
                    <input type="hidden" name="tipo" value="{{isset($_GET['tipo']) ? $_GET['tipo'] : ''}}" />
                </div>
                
            </form>
        </div>
    @endif
    
    <hr/>
    @if($proveedores != null && count($proveedores) > 0)
    <div id="listado" class="tiles">
    @for($i = 0; $i < count($proveedores); $i++)
    @if(count($proveedores[$i]->proveedor) > 0)
    @if(count($proveedores[$i]->proveedor[0]->multimediaProveedores) > 0)
    {{$proveedores[$i]->proveedor[0]->multimediaProveedores}}
    @endif
    @endif
        <div class="tile">
            
            
                @if(count($proveedores[$i]->proveedor) > 0)
                    @if ($proveedores[$i]->proveedor[0]->multimediaProveedores != null && count($proveedores[$i]->proveedor[0]->multimediaProveedores) > 0)
                        <div class="tile-img">
                            <img src="{{$proveedores[$i]->proveedor[0]->multimediaProveedores[0]->ruta}}" alt="Imagen de presentación de {{$proveedores[$i]->razon_social}}"/>
                        
                    @else
                    <div class="tile-img img-error">
                        <img src="/img/hotel.png" alt="" role="presentation" style="height: 96px;">
                    </div>
                    @endif
                @else
                    <div class="tile-img img-error">
                        <img src="/img/hotel.png" alt="" role="presentation" style="height: 96px;">
                    </div>
                @endif
                <!--<div class="text-overlap">-->
                <!--    <span class="label label-{{$colorTipo[1]}}">{{getItemType(5)->name}}</span>-->
                <!--</div>-->
            
            
            <div class="tile-body">
                
                <div class="tile-caption">
                    
                    <h3><a href="/proveedor/ver/{{$proveedores[$i]->id}}">{{$proveedores[$i]->razon_social}}</a></h3>
                    <p class="text-muted">{{$proveedores[$i]->categoria->categoriaProveedoresConIdiomas[0]->nombre}}</p>
                </div>
                @if (count($proveedores[$i]->proveedor) > 0 != null)
                    <div class="btn-block ranking">
        	              <span class="{{ ($proveedores[$i]->proveedor[0]->calificacion_legusto > 0.0) ? (($proveedores[$i]->proveedor[0]->calificacion_legusto <= 0.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
        	              <span class="{{ ($proveedores[$i]->proveedor[0]->calificacion_legusto > 1.0) ? (($proveedores[$i]->proveedor[0]->calificacion_legusto <= 1.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
        	              <span class="{{ ($proveedores[$i]->proveedor[0]->calificacion_legusto > 2.0) ? (($proveedores[$i]->proveedor[0]->calificacion_legusto <= 2.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
        	              <span class="{{ ($proveedores[$i]->proveedor[0]->calificacion_legusto > 3.0) ? (($proveedores[$i]->proveedor[0]->calificacion_legusto <= 3.9) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
        	              <span class="{{ ($proveedores[$i]->proveedor[0]->calificacion_legusto > 4.0) ? (($proveedores[$i]->proveedor[0]->calificacion_legusto <= 5.0) ? 'ionicons-inline ion-android-star-half' : 'ionicons-inline ion-android-star') : 'ionicons-inline ion-android-star-outline'}}" aria-hidden="true"></span>
        	              <span class="sr-only">Posee una calificación de {{$proveedores[$i]->proveedor[0]->calificacion_legusto}}</span>
    	            </div>
    	        @endif  
            </div>
        </div>
    @endfor
    </div>
    <div class="text-center">
       {{ $proveedores->appends($_GET)->links() }}
    </div>
    @else
    <div class="alert alert-info">
        <p>No hay prestadores de servicios turísticos publicados actualmente.</p>
    </div>
    @endif
</div>
    
@endsection
@section('javascript')
<script src="{{asset('/js/vibrant.js')}}"></script>
<script src="{{asset('/js/public/run_vibrant.js')}}"></script>
<script>
    $(document).ready(function(){
       $('.nav-bar > .brand a img').attr('src','/res/logo/white/72.png');
    });
</script>
<script>
function toggleFilter(){
    $('.filtros').toggle("fast","linear");
}
window.addEventListener('click', function(e){
	
	if (!document.getElementsByClassName('filtros')[0].contains(e.target) && !document.getElementById('btnFiltros').contains(e.target)){
      	$('.filtros').fadeOut("fast","linear");
    }
})
    function changeViewList(obj, idList, view){
        var element, name, arr;
        element = document.getElementById(idList);
        name = view;
        element.className = "tiles " + name;
    }
</script>
@endsection