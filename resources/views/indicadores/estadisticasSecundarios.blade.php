@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="secundariasCtrl"')

@section('estilos')

<style type="text/css">
    #selectGrafica .btn-select{
        display: inline-flex;
        align-items: center;
        border-radius: 0;
        width: calc(100% - 26px);
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
        display:flex;
        align-items:center;
        background: transparent;
    }
    .menu-descraga .dropdown button .material-icons{
        margin-right: .5rem;
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
    .icono{
        height: 22px;
        margin-right: 5px;
    }
    .btn-outline-primary{
        background-color: white;
        color: #004A87;
        border-color: #004A87;
        border-radius: 6px;
    }
    .btn-outline-primary:hover{
        background-color: #004A87;
        color: white;
    }
    .dropdown-menu{
        width: 100%;
        text-align:left;
    }
    .dropdown-menu>li>a{
        white-space: normal;
    }
    .dropdown-menu>li>button:hover {
        background-color: #eee;
    }
    .dropdown-menu>li>button {
        display: block;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: normal;
        font-size: 1rem;
        width: 100%;
        border: 0;
        background-color: inherit;
        padding: .5rem 1rem;
    }
</style>

@endsection


@section('content')
<h2 class="text-center"><small class="btn-block">Estadísticas secundarias</small> @{{indicador.nombre}}</h2>
<hr>

<div class="dropdown text-center" ng-init="indicadorSelect={{$indicadores[0]['id']}}">
  <button type="button" class="btn btn-outline-primary text-uppercase dropdown-toggle"id="dropdownMenuIndicadores" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ver más estadísticas <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></button>
  
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuIndicadores" ng-init="buscarData( {{$indicadores[0]['id']}} )">
    @foreach ($indicadores as $indicador)
        <li ng-class="{'active': (indicadorSelect=={{$indicador['id']}}) }">
          <button type="button" ng-click="changeIndicador({{$indicador['id']}})">{{$indicador["nombre"]}}</button>
        </li>
    @endforeach
    
  </ul>
</div>
<br>

<div ng-if="indicador == undefined" class="text-center">
    <img src="/img/spinner-200px.gif" alt="" role="presentation" style="display:inline-block; margin: 0 auto;">    
</div>
<div class="card" ng-init="indicadorSelect={{$indicadores[0]['id']}}" ng-show="indicador != undefined">
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <form name="form" >
                <div class="row filtros" >
                    <div class="col-xs-12 col-sm-6 col-md-5" >
                        <div class="input-group">
                            <label class="input-group-addon">Período </label>
                            <select class="form-control" ng-model="filtro.year" ng-change="filtrarDatos()" ng-options="y.id as y.anio for y in periodos" requerid >
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="col-xs-12 col-sm-6 col-md-5" >
                        <div class="input-group" id="selectGrafica" >
                            <label class="input-group-addon">Gráfica </label>
                            <div class="btn-group" style="width: 100%;">
                                <button type="button" class="btn btn-default btn-select">
                                   <img src="@{{graficaSelect.icono}}" class="icono" ></img> @{{graficaSelect.nombre || " "}}
                                </button>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret "></span>
                                </button>
                                <ul class="dropdown-menu menuTipoGrafica" role="menu">
                                    <li ng-repeat="item in indicador.graficas" ng-click="changeTipoGrafica(item)"  >
                                        <a> <img src="@{{item.icono}}" class="icono" ></img> @{{item.nombre}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> 
                    
                    <div class="col-xs-12 col-md-2 menu-descraga" >
                    
                        <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                              <i class="material-icons">cloud_download</i> Descargar
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right">
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
            
            <a class="item-footer" style="float:right;margin-right: 10px;" href="http://www.citur.gov.co/" target="_blank"  >
                <img src="/Content/image/presentacion_CITUR-01.png" width="65">
            </a>
            
        </div>
    </div>
    
    
    <div class="panel panel-default" ng-show="data.length>0" >
            <div class="panel-heading">
                <i class="material-icons">table_chart</i> <span id="tituloIndicadorGrafica" > @{{tituloIndicadorGrafica}} </span>
                <a href id="descargarTABLA" >
                     <img src="/Content/graficas/excel.png" class="icono" ></img>
                </a>
            </div>
            <div class="panel-body" id="customers" style="overflow-x: auto;width: 100%;margin-right: 0;" >
                
                <table class="table table-striped" ng-if="!series" >
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


@endsection





@section('javascript')
    <script src="{{asset('/js/plugins/jspdf.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-filter.js')}}"></script>
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
            
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $("#customers").html()

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = "datos.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();

            
            /*
            var pdf = new jsPDF('l', 'pt', 'letter');
            pdf.text(20, 20, $("#tituloIndicadorGrafica").html() );

            var margins = { top: 50, bottom: 20, left: 20, width: 522 };
    
            pdf.fromHTML( $('#customers')[0], margins.left, margins.top,
                { 
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': { '#bypassme': function (element, renderer) { return true; } }
                },
                function (dispose) { 
                    pdf.save('datos.pdf');
                },
                margins
            );
            */
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