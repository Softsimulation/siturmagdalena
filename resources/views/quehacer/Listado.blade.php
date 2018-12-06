<?php
/*
* Vista para listados del portal
*/
$colorTipo = ['bg-primary','bg-success','bg-danger', 'bg-info', 'bg-warning'];

function getItemType($type){
    $path = ""; $name = ""; $title = "";
    switch($type){
        case(1):
            $title = "Actividades";
            $name = "Actividad";
            $path = "/actividades/ver/";
            break;
        case(2):
            $title = "Atracciones";
            $name = "Atracción";
            $path = "/atracciones/ver/";
            break;
        case(3):
            $title = "Destinos";
            $name = "Destino";
            $path = "/destinos/ver/";
            break;
        case(4):
            $title = "Eventos";
            $name = "Evento";
            $path = "/eventos/ver/";
            break; 
        case(5):
            $title = "Rutas turísticas";
            $name = "Ruta turística";
            $path = "/rutas/ver/";
            break;
    }
    return (object)array('name'=>$name, 'path'=>$path, 'title' => $title);
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
<div id="listado" class="tiles">
    
    @foreach($query as $entidad)
    @if(!$tipoItem || ($tipoItem && $entidad->tipo == $tipoItem))
    <div class="tile tile-overlap">
        <div class="tile-img">
            @if($entidad->portada != "")
            <img src="{{ $entidad->portada }}" alt="Imagen de presentación de {{ $entidad->nombre }}"/>
            @endif
        </div>
        <div class="tile-body">
            <div class="tile-caption">
                <h3><a href="{{getItemType($entidad->tipo)->path}}{{ $entidad->id }}">{{ $entidad->nombre }}</a></h3>
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
</div>