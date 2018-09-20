@extends('layout._publicLayout')

@section('Title', 'Bolsa de empleo - Vacantes')

@section('content')
    <h1>Bolsa de empleo - Vacantes</h1>
    
    @foreach($vacantes as $vacante)
        <div class="row">
            <div class="col-xs-12">
                <p>{{$vacante->nombre}}</p>
                <p>{{$vacante->proveedoresRnt->razon_social}} - {{$vacante->proveedoresRnt->nit}}</p>
                <p>{{$vacante->proveedoresRnt->direccion}}</p>
            </div>
        </div>
        <br>
    @endforeach
    
    <div class="row">
        <table>
            <th>
                <td></td>
            </th>
        </table>
    </div>
    
@endsection