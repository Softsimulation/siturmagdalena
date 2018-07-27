@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="receptorCtrl"')


@section('content')

<div class="card" ng-init="indicadorSelect={{$indicadores[0]['id']}}" >
    
    <ul class="list-group" ng-init="buscarData( {{$indicadores[0]['id']}} )" >
        @foreach ($indicadores as $indicador)
            <li class="list-group-item" ng-click="changeIndicador({{$indicador['id']}})" ng-class="{'active': (indicadorSelect=={{$indicador['id']}}) }"  >
               {{$indicador["idiomas"][0]["nombre"]}}
            </li>
        @endforeach
    </ul>
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <form name="form" >
                <div class="row filtros" >
                    <div class="col-md-3" >
                        <div class="input-group">
                            <label class="input-group-addon">Período </label>
                            <select class="form-control" ng-model="yearSelect" ng-change="filtro.year=yearSelect.year;filtrarDatos()" ng-options="y as y.year for y in periodos" requerid >
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3" ng-show="yearSelect.mes" >
                        <div class="input-group">
                            <label class="input-group-addon">Mes</label>
                            <select class="form-control" ng-model="filtro.mes" ng-change="filtrarDatos()" ng-options="m.mes as m.mes for m in periodos | filter:{ 'id': yearSelect.id }" ng-requerid="yearSelect.mes"  >
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4" ng-if="indicadorSelect==5">
                        <div class="input-group" >
                            <label class="input-group-addon colorInd">Gasto promedio </label>
                            <select class="form-control" ng-model="filtro.tipoGasto" id="SelectTipoGasto" ng-change="filtrarDatos()" >
                                <option value="1" >Total</option>
                                <option value="2">Por día</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4" >
                        <div class="input-group" id="selectGrafica" >
                            <label class="input-group-addon">Gráfica </label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-select" style="height:34px;" >
                                   <i class="material-icons">@{{graficaSelect.icono}}</i> @{{graficaSelect.nombre || " "}}
                                </button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret "></span>
                                </button>
                                <ul class="dropdown-menu menuTipoGrafica" role="menu">
                                    <li ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica(item)"  >
                                        <a> <i class="material-icons">@{{item.icono}}</i> @{{item.nombre}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="col-md-1 menu-descraga" >
                    
                        <div class="dropdown">
                          <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                              <i class="material-icons">menu</i>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href id="descargarPNG" >Descargar grafica : PNG</a></li>
                           <!-- <li><a href id="descargarJPG" >Download JPG image</a></li> -->
                            <li><a href id="descargarPDF" >Descargar grafica : PDF</a></li>
                            <li><a href id="descargarGraficaTabla" >Descargar grafica y tabla de datos : PDF</a></li>
                          </ul>
                        </div>
                        
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="panel-body">
            <canvas id="base" class="chart-base" chart-type="graficaSelect.codigo" fill="black" style="background: white;"
              chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores" chart-dataset-override="override" >
            </canvas>
            
            <!--
            <a class="item-footer" style="float:left;margin-bottom:-20px;" href data-toggle="modal" data-target="#modalData"  >
                <i class="material-icons">table_chart</i> Tabla de datos
            </a>
            -->
            <a class="item-footer" style="float:right;margin-right: 10px;" href="http://www.citur.gov.co/" target="_blank"  >
                <img src="/Content/image/presentacion_CITUR-01.png" width="65">
            </a>
            
        </div>
    </div>
    
    
    <div class="panel panel-default" ng-show="data.length>0" >
            <div class="panel-heading">
                <i class="material-icons">table_chart</i> <span id="tituloIndicadorGrafica" > @{{tituloIndicadorGrafica}} </span>
                <a href id="descargarTABLA" >
                     <i class="material-icons">picture_as_pdf</i> 
                </a>
            </div>
            <div class="panel-body" id="customers" >
                
                <table class="table table-striped" ng-if="!series"   >
                    <thead>
                      <tr>
                        <th>@{{indicador.idiomas[0].eje_x}} </th>
                        <th>Cantidad</th>
                        <th ng-if="dataExtra" >Media</th>
                        <th ng-if="dataExtra" >Mediana</th>
                        <th ng-if="dataExtra" >Moda</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  ng-repeat="label in labels" >
                        <td>@{{label}}</td>
                        <td>@{{data[$index]}}</td>
                        <td ng-if="dataExtra" >@{{dataExtra.media[$index]}}</td>
                        <td ng-if="dataExtra" >@{{dataExtra.mediana[$index]}}</td>
                        <td ng-if="dataExtra" >@{{dataExtra.moda[$index]}}</td>
                      </tr>
                    </tbody>
                </table>
                
                <table class="table table-striped" ng-if="series" >
                    <thead>
                      <tr>
                        <th></th>
                        <th ng-repeat="item in labels" >@{{item}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="datos in data track by $index" >
                        <td>@{{series[$index]}}</td>
                        <td ng-repeat="d in datos track by $index">@{{d}}</td>
                      </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    
</div>

<!--
<div class="modal" tabindex="-1" role="dialog" id="modalData" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> @{{indicador.idiomas[0].nombre}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
-->

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
    #modalData td, #modalData th{ padding: 1px; }
    
    .filtros .input-group-addon{
        background-color: #009541!important;
        border-color: #009541!important;
        color: #fff!important;
        font-weight: 700!important;
    }
    .menu-descraga, .menu-descraga .dropdown{
            float: right;
    }
    .menu-descraga .dropdown button{
        border: none;
        background: transparent;
    }
    #descargarTABLA{
        float: right;
        color: black;
    }
    #descargarTABLA i{
        font-size:2em;
    }
    .panel-body{
        padding:0!important;
        padding-top:20px !important;
    }
</style>

@endsection


@section('javascript')
    <script src="{{asset('/js/plugins/jspdf.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/chartsjs-plugin-data-labels.js')}}"></script>
    <script src="{{asset('/js/indicadores/appIndicadores.js')}}"></script>
    <script src="{{asset('/js/indicadores/servicios.js')}}"></script> 
    
    <script>
    
        $("#descargarPNG").on("click", function(){
            var canvas = document.getElementById("base");
            descargar( canvas.toDataURL() );
        });
        
        $("#descargarJPG").on("click", function(){
            var canvas = document.getElementById("base");
            descargar( canvas.toDataURL() );
        });
        
        $("#descargarPDF").on("click", function(){
            var canvas = document.getElementById("base");
            var imgData = canvas.toDataURL();
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.addImage(imgData, 'JPEG', 0, 20, 800,400);
            pdf.save("download.pdf");
        });
        
        function descargar(img){
            var link = document.createElement("a");
            link.download = "Grafica";
            link.href = img;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        
        $("#descargarTABLA").on("click", function(){ 
            
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.text(20, 20, $("#tituloIndicadorGrafica").html() );

            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.fromHTML( $('#customers')[0], margins.left, margins.top,
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { pdf.save('datos.pdf'); },
                margins
            );
            
        });
        
        $("#descargarGraficaTabla").on("click", function(){ 
            
            var pdf = new jsPDF('l', 'pt', 'letter');
            
            
            var canvas = document.getElementById("base");
            var imgData = canvas.toDataURL();
             
            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.addImage(imgData, 'JPEG', 0, 20, 800,400);
            
            pdf.addPage();
            pdf.text(20, 20, $("#tituloIndicadorGrafica").html() );
            
            pdf.fromHTML( $('#customers')[0], margins.left,  margins.top, 
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { pdf.save('datos.pdf'); },
                margins
            );
            
        });
        
    </script>
    
@endsection