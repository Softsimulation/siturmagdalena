@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="receptorCtrl"')


@section('content')

<div class="card" >
    
    
  <div class="panel panel-default">
    <div class="panel-heading">
        
        <div class="row" >
            <div class="col-md-4" >
                <div class="input-group">
                    <label class="input-group-addon">Período </label>
                    <select class="form-control" ng-model="filtro.year" ng-options="y for y in periodos" >
                    </select>
                </div>
            </div>
            
            <div class="col-md-4" >
                <div class="input-group" id="selectGrafica" >
                    <label class="input-group-addon">Gráfica </label>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-select">
                           <i class="material-icons">@{{graficaSelect.icono}}</i> @{{graficaSelect.nombre}}
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret "></span>
                        </button>
                        <ul class="dropdown-menu menuTipoGrafica" role="menu">
                            <li ng-repeat="item in graficas" ng-click="changeTipoGrafica(item)"  >
                                <a> <i class="material-icons">@{{item.icono}}</i> @{{item.nombre}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
            
        </div>
        
    </div>
    <div class="panel-body">
        <canvas id="base" class="chart-base" chart-type="graficaSelect.tipo"
          chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores">
        </canvas>   
    </div>
    <div class="panel-footer">
        
        <a class="item-footer" >
            <i class="material-icons">table_chart</i> Tabla de datos
        </a>
        <a ng-click="descargarGrafica()" class="item-footer"  >
            <i class="material-icons">insert_photo</i> Descargar gráfica
        </a>
        
        <a class="item-footer" style="float:right;" href="http://www.citur.gov.co/" target="_blank"  >
            <img src="/Content/image/presentacion_CITUR-01.png" width="70" style="margin-top: -17px;">
        </a>
            
    </div>
  </div>
    
    
    
</div>

@endsection


@section('estilos')

<style type="text/css">
    #selectGrafica .btn-select{
        display: inline-flex;
        align-items: center;
        border-radius: 0;
    }
    #selectGrafica .btn-select i{
        font-size: 20px;
        margin-right: 5px;
    }
    .item-footer{
        display: inline-flex;
        align-items: center;
        cursor: default;
        margin-left: 20px;
    }
</style>

@endsection


@section('javascript')
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/indicadores/receptor.js')}}"></script>
    <script src="{{asset('/js/indicadores/servicios.js')}}"></script>
@endsection