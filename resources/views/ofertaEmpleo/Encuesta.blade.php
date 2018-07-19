
@extends('layout._ofertaEmpleoLayaout')

@section('title', 'Encuesta :: SITUR Magdalena')

@section('estilos')

    <style>
        .title-section {
            background-color: #4caf50 !important;
        }
    </style>
    <style>
        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat;
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
    </style>
@endsection

@section('TitleSection', 'Encuestas sin llenar')

@section('Progreso', '0')

@section('NumSeccion', '0')

@section('content')
<div class="container">
  
    <div class='carga'>

    </div>
    <form role="form" name="DatosForm" novalidate>
        <div class="panel panel-success">
            <div class="panel-heading p1">
                <!-- P1. Grupo de Viaje-->
                <h3 class="panel-title"><b>Encuestas sin llenar</b></h3>
            </div>           
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Mes</th>
                                <th>Año</th>
                                <th></th>
                            </tr>
                            @foreach ($meses as $mes)
                            
                            <tr>
                                <td align="center">{{$mes["mes"]}}</td>
                                <td align="center">{{$mes["anio"]}}</td>
                                <td style="width: 180px;"><a href="/ofertaempleo/actividadcomercial/{{$mes['mesId']}}/{{$mes['anio']}}/{{$id}}" class="btn btn-raised btn-default btn-sm" title="Llenar encuesta" style="margin: 0;"><i class="material-icons">assignment</i> Llenar encuesta</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        

        <br />

    </form>
    
</div>


@endsection
