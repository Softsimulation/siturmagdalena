@extends('layout._publicLayout')

@section('Title', 'Vacante')

@section('content')
    
    @if(Session::has('message'))
        <div class="alert alert-info" role="alert" style="text-align: center;">{{Session::get('message')}}</div>
    @endif
    
    
    
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
            @if(isset($vacante->fecha_vencimiento))<p>Cierre: {{$vacante->fecha_vencimiento}}</p>@endif
            <p>Lugar: {{$vacante->municipio->nombre}}, {{$vacante->municipio->departamento->nombre}}</p>
            <p>Nivel de educación: {{$vacante->nivelEducacion->nombre}}</p>
            <p>No. de vacantes: {{$vacante->numero_vacantes}}</p>
            @if(isset($vacante->salario_minimo))<p>Salario mínimo: {{$vacante->salario_minimo}}</p>@endif
            @if(isset($vacante->salario_maximo))<p>Salario mínimo: {{$vacante->salario_maximo}}</p>@endif
            <p>Años de experiencia: {{$vacante->anios_experiencia}}</p>
        </div>
        <div class="col-md-4">
            <p>
                Perfil:
                {{$vacante->descripcion}}
            </p>
            <p>
                Requisitos:
                {{$vacante->requisitos}}
            </p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <a href="/postulado/postular/{{$vacante->id}}">Postularme</a>
        </div>
        <div class="col-xs-12">
            <a href="/promocionBolsaEmpleo/vacantes">Volver</a>
        </div>
    </div>
    
    <div class="row">
        
        @foreach($otrasVacantes as $otraVacante)
            <div class="col-md-4">
                <p>{{$otraVacante->nombre}}</p>
                <p>{{$otraVacante->descripcion}}</p>
            </div>
        @endforeach
    </div>
    
@endsection