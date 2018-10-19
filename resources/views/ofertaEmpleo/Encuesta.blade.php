
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

@section('app','ng-app="ofertaempleo"')

@section('controller','ng-controller="seccionActividadComercialAdmin"')

@section('content')
<div class="container">
   <input type="hidden" ng-model="Id" ng-init="Id={{$Id}}" />
       <div class="alert alert-danger" ng-if="errores != null">
        <label><b>Errores:</b></label>
        <br />
        <div ng-repeat="error in errores" ng-if="error.length>0">
            -@{{error[0]}}
        </div>
    </div>
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
                <div class="col-xs-12" ng-if="encuestas.length > 0">
                    <table class="table table-striped">
                  <thead>
                        <tr>
                                <th>Mes</th>
                                <th>Año</th>
                                <th></th>
                        </tr>
                    </thead>
                     <tbody>
                       
                        <tr ng-repeat="item in encuestas" >
                          
                          <td align="center">@{{item.mes}}</td>
                          <td align="center">@{{item.anio}}</td>
                          <td style="width: 180px;"><a ng-click="guardar(item)" class="btn btn-raised btn-default btn-sm" title="Llenar encuesta" style="margin: 0;"><i class="material-icons">assignment</i> Llenar encuesta</a>
                          </td>
                        
                        </tr>
                    </tbody>
                    </table>
                    <div class="alert alert-warning" role="alert" ng-show="encuestas.length == 0">No hay resultados disponibles</div>
                    </div>
                    </div>
      
            </div>
                </div>
            </div>
        </div>
        

        <br />

    </form>
    
</div>


@endsection
