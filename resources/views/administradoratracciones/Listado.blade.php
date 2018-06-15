
@extends('layout._AdminLayout')

@section('title', 'Listado de atracciones')

@section('estilos')
    <style>
        .panel-body {
            max-height: 400px;
            color: white;
        }

        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .image-preview-input-title {
            margin-left: 2px;
        }

        .messages {
            color: #FA787E;
        }

        form.ng-submitted input.ng-invalid {
            border-color: #FA787E;
        }

        form input.ng-invalid.ng-touched {
            border-color: #FA787E;
        }

        .carga {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.57) url(../../Content/Cargando.gif) 50% 50% no-repeat
        }
        /* Cuando el body tiene la clase 'loading' ocultamos la barra de navegacion */
        body.charging {
            overflow: hidden;
        }

        /* Siempre que el body tenga la clase 'loading' mostramos el modal del loading */
        body.charging .carga {
            display: block;
        }
        .row {
            margin: 1em 0 0;
        }
        .form-group {
            margin: 0;
        }
        .form-group label, .form-group .control-label, label {
            font-size: smaller;
        }
        .input-group {
            display: flex;
        }
        .input-group-addon {
            width: 3em;
        }
        .text-error {
            color: #a94442;
            font-style: italic;
            font-size: .7em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('TitleSection', 'Listado de atracciones')

<!--@section('Progreso', '0%')-->

<!--@section('NumSeccion', '0%')-->

<!--@section('controller','ng-controller="index_grupo"')-->

@section('content')
    

<div class="container">
    <h1 class="title1">Listar atracciones</h1>
    <br />
    <div class="blank-page widget-shadow scroll" id="style-2 div1">
        <div class="row" style="margin: 0;">
            <div class="col-xs-12 col-sm-4 col-md-2">
                <a class="btn btn-primary" data-toggle="modal" data-target="#nuevaAtraccionModal">Insertar atracción</a>
            </div>
            <!--<div class="col-xs-12 col-sm-8 col-md-offset-3 col-md-4">-->
            <!--    <input type="text" ng-model="prop.search" class="form-control" id="inputEmail3" placeholder="Búsqueda de grupos de viaje (id, fecha, lugar)">-->
            <!--</div>-->
            <div class="col-xs-12 col-sm-4 col-md-3" style="text-align: center;">
                <span class="chip">{{count($atracciones)}} resultados</span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tr>
                        <th>Id</th>
                        <th>Lugar</th>
                        <th>Teléfono</th>
                        <th>Valor min.</th>
                        <th>Valor max.</th>
                        <th style="width: 80px"></th>
                        
                    </tr>
                    @forelse ($atracciones as $atraccion)
                        <tr>
                            <td>
                                {{$atraccion.id}}
                            </td>
                            <td>{{$atraccion->sitio->sitiosConIdiomas[0]->nombre}}</td>
                            <td>{{$atraccion->telefono}}</td>
                            <td>{{$atraccion->valor_min}}</td>
                            <td>{{$atraccion->valor_min}}</td>
                            <td><td style="text-align: center;"><a href="/grupoviaje/vergrupo/{{$atraccion.id}}"><span class="glyphicon glyphicon-eye-open" title="Ver información de la atracción"></span></a></td></td>
                        </tr>
                    @empty
                        <div class="alert alert-warning" role="alert">No hay datos en el sistema</div>
                    @endforelse
                </table>
            </div>
            
        </div>
        <!--<div class="row">-->
        <!--  <div class="col-6" style="text-align:center;">-->
        <!--  <dir-pagination-controls pagination-id="paginacion_grupos"  max-size="5" direction-links="true" boundary-links="true"></dir-pagination-controls>-->
        <!--  </div>-->
        <!--</div>-->
    </div>
    
    <div class='carga'>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="nuevaAtraccionModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva atracción</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <label for=nombre"">
                            Nombre
                        </label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre de la atracción"/>
                    </div>
                    <div class="row">
                        <label for="idioma">Idioma</label>
                        <select required name="idioma" class="form-control">
                            <option invalid value="">Selecciones un idioma</option>
                            @foreach($idiomas as $idioma) 
                                <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


