@extends('layout._publicLayout')

@section('Title', 'Vacante')

@section('content')
    <h1>Vacante - {{$vacante->nombre}}</h1>
    
    <div class="row">
        <div class="col-xs-12">
            <h2>{{$vacante->proveedoresRnt->razon_social}} - {{$vacante->proveedoresRnt->nit}}</h2>
            <p>{{$vacante->proveedoresRnt->direccion}}</p>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-md-4">
            <p>Apertura: {{$vacante->fecha_inicio}}</p>
            @if(isset($vacante->fecha_fin))<p>Cierre: {{$vacante->fecha_fin}}</p>@endif
            <p>Lugar: {{$vacante->municipio->nombre}}, {{$vacante->municipio->departamento->nombre}}</p>
            <p>Nivel de educación: {{$vacante->nivelEducacion->nombre}}</p>
            <p>No. de vacantes: {{$vacante->numero_vacantes}}</p>
            @if(isset($vacante->salario))<p>Salario: {{$vacante->salario}}</p>@endif
            <p>Años de experiencia: {{$vacante->anios_experiencia}}</p>
        </div>
        <div class="col-md-4">
            <p>
                Perfil:
                {{$vacante->perfil}}
            </p>
            <p>
                Requisitos:
                {{$vacante->requisitos}}
            </p>
        </div>
    </div>
    
    <div class="row">
        
        @foreach($otrasVacantes as $otraVacante)
            <div class="col-md-4">
                <p>{{$otraVacante->nombre}}</p>
            </div>
        @endforeach
    </div>
    
@endsection