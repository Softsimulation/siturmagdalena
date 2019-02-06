
@extends('layout._publicLayout')

@section('Title','Proveedores')

@section('TitleSection','Proveedores')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            <h1>Nombre: {{$proveedor->proveedorRnt->razon_social}}</h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12 text-center">
            Valor mínimo: {{$proveedor->valor_min}} Valor máximo: {{$proveedor->valor_max}}
        </div>
    </div>
    <div class="row">
        
        <div class="col-sm-4 col-md-4 col-xs-12 text-center">
            Página web: {{$proveedor->sitio_web}}
        </div>
        <div class="col-sm-4 col-md-4 col-xs-12 text-center">
            Teléfono: {{$proveedor->telefono}}
        </div>
    </div>
    {{-- La posición  0 es la portada --}}
    <div class="row">
        Portada:
        <img src="{{$proveedor->multimediaProveedores[0]->ruta}}"></img>
    </div>
    <div class="row">
        Imágenes:
        
        @for ($i = 1; $i < count($proveedor->multimediaProveedores); $i++)
            <img src="{{$proveedor->multimediaProveedores[$i]->ruta}}"></img>
        @endfor
    </div>
    <div class="row">
        Video Promocional
        <iframe src="{{$video_promocional}}">
        </iframe>
    </div>
    Actividades
    <div class="row">
        @foreach ($proveedor->actividadesProveedores as $actividad)
        <div class="col-sm-12 col-md-12 col-xs-12">
            Actividad {{$actividad->id}}: {{$actividad->actividadesConIdiomas[0]->nombre}}
        </div>
        @endforeach
    </div>
    
    <div class="text-center">
    @if(Auth::check())
        <form role="form" action="/proveedor/favorito" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="proveedor_id" value="{{$proveedor->id}}" />
            <button type="submit" class="btn btn-lg btn-circled btn-favorite">
              <span class="ion-android-favorite" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
            </button>    
        </form>
    @else
        <button type="button" class="btn btn-lg btn-circled" title="Marcar como favorito" data-toggle="modal" data-target="#modalIniciarSesion">
          <span class="ion-android-favorite-outline" aria-hidden="true"></span><span class="sr-only">Marcar como favorito</span>
        </button>
    @endif
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif  
  </div>
@endsection
