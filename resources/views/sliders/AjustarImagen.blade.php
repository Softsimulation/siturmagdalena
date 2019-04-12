@extends('layout._AdminLayout')

@section('title', 'Listado de sliders')

@section('estilos')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css">
    <style>
        
        .box-tigger img {
         cursor:zoom-in;
       }
        
       .box-tigger-activo {
            position: fixed;
            margin: 0;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: #292929;
            z-index: 1000;
            will-change: opacity;
            text-align: center;
        }
        
        .box-tigger-activo img {
            cursor:zoom-out;
            z-index: 1000;
            top: 10%;
            height: 65%;
            width: auto;
            margin-top: 5%;
            position: relative;
        }
        .box-tigger-activo p {
          color: white;
        }
       .box-tigger-activo button,.box-tigger-activo a {
         display:none;
       }
        .padding {
          padding:2%;
        }
        input.ui-select-search.input-xs.ng-pristine.ng-untouched.ng-valid {
            width:100% !important;
        }
        .tile .btn:not(.btn-link) {
            box-shadow: none;
        }
        .input-group-btn:first-child > .btn, .input-group-btn:first-child > .btn-group {
            margin: 0;
        }
        .previewUpload[src=""] {
            display: none;
        }
        .btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open > .dropdown-toggle.btn-default.focus, .open > .dropdown-toggle.btn-default:focus, .open > .dropdown-toggle.btn-default:hover {
            background-color: transparent;
            color: white;
        }
        .dropdown-menu {
            bottom: 100%;
            right: 0;
            top: auto;
            left: auto;
        }
    </style>
    <style>
        .tile{
    position: relative;
    height: 151px;
    padding: 0;
    background: inherit;
	overflow: hidden;
}
.tile img{
    width: 100%;
    height: auto;
}
.tile .tittle{
    
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 2px;
    z-index: 2;
    background-color: rgba(0,0,0,.85);
    color:white;
}
.tile .tittle .dropdown{
    position:absolute;
    right:0;
    bottom: 0;
}
.tile .tittle p{
    margin: .5rem;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    padding-right: 3rem;
}
.tile .tittle .btn {
    background: transparent;
    color:white
}
.tile .tittle.activos .btn {
    color:black;
}
.imagenActual{
    height: 200px;
    width: auto;
    margin: 0 auto;
}
.tile .tittle.activos {
    background-color: yellowgreen;
    color:black;
}
/*.desactivados {
    background-color: #e0e3e5;
}*/

.box-tigger:not(.box-tigger-activo) img {
    height: 100%;
    width: auto;
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translateY(-50%) translateX(-50%);
    transform: translateY(-50%) translateX(-50%);
}
.btn-float-card {
    position: absolute;left: 0px;top: 10px; z-index: 5; background-color: white; box-shadow: 0px 1px 3px 0px rgba(0,0,0,.4);
}
.btn-float-card:hover {
    background-color: white;
}
.text-float-card {
    z-index: 5;
    position: absolute;
    bottom: 0;
    left: 0;
    background: rgba(255,255,255,.7);
    font-size: 1.2rem;
    margin: 0;
    padding: .5rem 0;
	width: 100%;
}
.text-float-card :hover{
	background: white;
}
@media only screen and (min-width: 1400px){
    .tile {
        height: 200px;
    }
}

    </style>
@endsection

@section('TitleSection', 'Ajustar imagen')

@section('app','ng-app="admin.slider"')

@section('controller','ng-controller="ajustarImagenCtrl"')

@section('titulo','Ajustar imagen')
@section('subtitulo','Puede ajustar la imagen como quiere que se aprecie en la página principal')

@section('content')
    <div class="row">
        <div class="alert alert-danger" ng-if="errores != null">
            <h3>Corriga los siguientes errores:</h3>
            <div ng-repeat="error in errores">
                -@{{error[0]}}
            </div>
        </div>    
    </div>
    <input type="hidden" ng-init="id={{$slider->id}}"/>
    <div class="container" style="margin-top:40px;">
       <div id="imagen">
            
            
        </div>
        <br><br>
        <div class="flex-list">
                <a ng-click="guardarAjuste()" class="btn btn-success">Guardar</a>
        </div>
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
<script src="{{asset('/js/plugins/select.min.js')}}"></script>
<script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
<script src="{{asset('/js/administrador/sliders/sliders.js')}}"></script>
<script src="{{asset('/js/administrador/sliders/sliderServices.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js"></script>
@endsection