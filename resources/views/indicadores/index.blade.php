@extends('layout._IndicadoresLayout')


@section('app','ng-app="appIndicadores"')
@section('controller','ng-controller="IndicadoresCtrl"')

@section('estilos')

<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/pivot.css')}}" type="text/css" />
<link rel="stylesheet" href="{{asset('/js/plugins/pivotTable/dist/c3.min.css')}}" type="text/css" />
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
    .menu-descarga{
        position: absolute;
        right: 80px;
    }
    .menu-descarga, .menu-descarga .dropdown{
            float: right;
    }
    .menu-descarga .dropdown button{
        display:flex;
        align-items:center;
        background: transparent;
    }
    .menu-descarga .dropdown button .material-icons{
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
        height: 20px;
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
    .dropdown-menu>li>a {
        text-align: left;
        white-space: normal;
    }
    .dropdown-menu{
        width: 100%;
        text-align:center;
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
    .menu-descarga, .menu-descarga .dropdown{
            float: right;
    }
    .menu-descarga .dropdown button{
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


@section('content')

<h2 class="text-center"><small class="btn-block">Indicador</small> @{{indicador.idiomas[0].nombre}}</h2>
<hr>

<div class="dropdown text-center" ng-init="indicadorSelect={{$indicadores[0]['id']}}">
  <button type="button" class="btn btn-outline-primary text-uppercase dropdown-toggle"id="dropdownMenuIndicadores" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ver más estadísticas <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></button>
  
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuIndicadores" ng-init="buscarData( {{$indicadores[0]['id']}} )">
    @foreach ($indicadores as $indicador)
        <li ng-class="{'active': (indicadorSelect=={{$indicador['id']}}) }">
          <button type="button" ng-click="changeIndicador({{$indicador['id']}})">{{$indicador["idiomas"][0]['nombre']}}</button>
        </li>
    @endforeach
    
  </ul>
</div>

<br>

<div ng-if="indicador == undefined" class="text-center">
    <img src="/img/spinner-200px.gif" alt="" role="presentation" style="display:inline-block; margin: 0 auto;">    
</div>

<div class="card" ng-init="indicadorSelect={{$indicadores[0]['id']}}" ng-show="indicador != undefined">
    
    
    
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#tab1">Información</a></li>
      <li ><a data-toggle="tab" href="#tab2" >Tabla dinamica</a></li>
    </ul>
    
    <div class="tab-content">
      <div id="tab1" class="tab-pane fade in active">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form name="form" >
                        <div class="row filtros" >
                            <div class="col-xs-12 col-md-3" >
                                <div class="input-group">
                                    <label class="input-group-addon">Período </label>
                                    <select class="form-control" ng-model="yearSelect" ng-change="changePeriodo()" ng-options="y as y.year for y in periodos | unique: 'year'" requerid >
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-3" ng-show="yearSelect.mes" >
                                <div class="input-group">
                                    <label class="input-group-addon">Mes</label>
                                    <select class="form-control" ng-model="mesSelect" ng-change="filtro.id=mesSelect.id;filtro.mes=mesSelect.mes;filtrarDatos()" ng-options="m as m.mes for m in periodos | filter:{ 'year': yearSelect.year }" ng-requerid="yearSelect.mes"  >
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-md-4" ng-show="yearSelect.temporada" >
                                <div class="input-group">
                                    <label class="input-group-addon">Temporadas</label>
                                    <select class="form-control" id="SelectTemporada" ng-model="filtro.id" ng-change="filtrarDatos()" ng-options="t.id as t.temporada for t in periodos | filter:{ 'year': yearSelect.year }" ng-requerid="yearSelect.temporada"  >
                                    </select>
                                </div>
                            </div>
                            
                            @if( isset($aspectos) )
                            <div class="col-xs-12 col-md-3" ng-if="indicadorSelect==44">
                                <div class="input-group" >
                                    <label class="input-group-addon colorInd">Aspecto </label>
                                    <select class="form-control" ng-model="filtro.aspecto" id="aspecto" ng-change="filtrarDatos()" >
                                        <option value="" selectd >Todos</option>
                                        @for ($i = 0; $i < count($aspectos); $i++)
                                           <option value="{{$aspectos[$i]->aspecto_evaluacion}}" >{{$aspectos[$i]->nombre}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            @endif
                            
                            @if( isset($tipoExperiencia) )
                            <div class="col-xs-12 col-md-4" ng-if="indicadorSelect==61 || indicadorSelect==77">
                                <div class="input-group" ng-init="filtro.tipoExperiencia='{{$tipoExperiencia[0]['key']}}' " >
                                    <label class="input-group-addon colorInd">Tipo experiencia </label>
                                    <select class="form-control" ng-model="filtro.tipoExperiencia" id="experiencia" ng-change="filtrarDatos()" >
                                        <option value="{{$tipoExperiencia[0]['key']}}" >{{$tipoExperiencia[0]['nombre']}}</option>
                                        <option value="{{$tipoExperiencia[1]['key']}}" >{{$tipoExperiencia[1]['nombre']}}</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            
                            <div class="col-xs-12 col-md-3" ng-if="indicadorSelect==5">
                                <div class="input-group" >
                                    <label class="input-group-addon colorInd">Gasto promedio </label>
                                    <select class="form-control" ng-model="filtro.tipoGasto" id="SelectTipoGasto" ng-change="filtrarDatos()" >
                                        <option value="1" selectd >Total</option>
                                        <option value="2">Por día</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-6 col-md-3" >
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
                            
                        </div>    
                    </form>
                </div>
                <div class="panel-body">
                    
                    <div class="menu-descarga" >
                            
                        <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                              <i class="material-icons">cloud_download</i> Descargar
                          </button>
                          <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href id="descargarPNG" >Descargar gráfica : PNG</a></li>
                           <!-- <li><a href id="descargarJPG" >Download JPG image</a></li> -->
                            <li><a href id="descargarPDF" >Descargar gráfica : PDF</a></li>
                            <li><a href id="descargarGraficaTabla" >Descargar gráfica y tabla de datos : PDF</a></li>
                          </ul>
                        </div>
                        
                    </div>
                    
                    <canvas id="base" class="chart-base" chart-type="graficaSelect.codigo" fill="black" style="background: white;"
                      chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores" chart-dataset-override="override" >
                    </canvas>
                    
                    <a class="item-footer" style="float:right;margin-right: 10px;" href="http://www.citur.gov.co/" target="_blank"  >
                        <img src="/Content/image/presentacion_CITUR-01.png" width="65">
                    </a>
                    
                </div>
            </div>
           
           <p>
               Descripción: @{{indicador.idiomas[0].descripcion}}
           </p>
           
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
                                <td>@{{data[0][$index]}}</td>
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
      <div id="tab2" class="tab-pane fade">
          
            <a href id="descargarPivotTable" >
                 <img src="/Content/graficas/excel.png" class="icono" ></img>
            </a>
          
            <div class="row" >
                <div class="table-responsive col-lg-12 col-md-12 col-sm-12" style="max-height:490px">
                    <div id="tablaDinamica" style="min-height:430px;"></div>
                </div>
            </div>
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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/pivot.es.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/jquery-ui-touch-punch.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/d3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3.min.js')}}"></script>
    <script src="{{asset('/js/plugins/pivotTable/dist/c3_renderers.js')}}"></script>
    
    
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
            pdf.save( $("#tituloIndicadorGrafica").html() +".pdf");
        });
        
        function descargar(img){
            var link = document.createElement("a");
            link.download = $("#tituloIndicadorGrafica").html();
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
            link.download = $("#tituloIndicadorGrafica").html();
            link.href = uri + base64(format(template, ctx));
            link.click();
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
                function (dispose) { pdf.save( $("#tituloIndicadorGrafica").html() +'.pdf'); },
                margins
            );
            
        });
        
        
        $("#descargarPivotTable").on("click", function(){ 
            
            var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }); };

            htmls = $(".pvtRendererArea").html();

            var ctx = { worksheet : 'Worksheet', table : htmls };

            var link = document.createElement("a");
            link.download = $("#tituloIndicadorGrafica").html();
            link.href = uri + base64(format(template, ctx));
            link.click();
        });
        
    </script>
    
@endsection