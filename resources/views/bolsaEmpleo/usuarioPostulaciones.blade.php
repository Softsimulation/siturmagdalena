@extends('layout._publicLayout')

@section('Title', 'Vacante')

@section('content')
    
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif
    
    
    
    <h1>Postulaciones - {{$user->datosAdicionales->nombres}} {{$user->datosAdicionales->apellidos}}</h1>
    
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped">
                <tr>
                    <th>Vacante</th>
                    <th>Entidad</th>
                    <th>Municipio</th>
                    <th>Fecha de postulación</th>
                    <th></th>
                </tr>
                @if(count($user->datosAdicionales->postulaciones) > 0)
                    @foreach($user->datosAdicionales->postulaciones as $postulacion)
                        <tr>
                            <td>{{$postulacion->ofertasVacante->nombre}}</td>
                            <td>{{$postulacion->ofertasVacante->proveedoresRnt->razon_social}}</td>
                            <td>{{$postulacion->ofertasVacante->municipio->nombre}}</td>
                            <td>{{$postulacion->fecha_postulacion}}</td>
                            <td><a class="btn" href="{{$postulacion->ruta_hoja_vida}}" target="_blank" title="Hoja de vida" ><span class="glyphicon glyphicon-paperclip"></span></a></td>
                        </tr>
                    @endforeach()
                @endif
            </table>
            @if(count($user->datosAdicionales->postulaciones) == 0)
                <div class="alert alert-info" role="alert" >El usuario no tiene postulaciones registradas en el sistema</div>
            @endif
        </div>
    </div>
    
    
@endsection