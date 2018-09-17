@extends('layout._AdminLayout')

@section('title','Encuesta dinamica')
@section('TitleSection', $encuesta->idiomas[0]->nombre)
@section('app','ng-app="appEncuestaDinamica"')
@section('controller','ng-controller="EstadisticasrEncuestasCtrl"')

@section('titulo','Encuestas ADHOC')
@section('subtitulo','Estadísticas de resultados de una pregunta')

@section('content')
<div class="flex-list">
    <a class="btn btn-link" href="/encuesta/listado">Volver al listado</a>
</div>

<div class="flex-list">
        <div class="form-group" >
            <select class="form-control" ng-model="selectPregunta" ng-change="changePregunta()"  >
                <option value="" selected disabled >Selecione una pregunta para cargar los resultados</option>
                {{$index = 1}}
                @foreach ($encuesta->secciones as $secccion)
                    <option value=""  disabled >Seccion {{$index++}}</option>
                    @foreach ($secccion->preguntas as $pregunta)
                        <option value="{{$pregunta->id}}">{{$pregunta->idiomas[0]->pregunta}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="form-group" >
            <select class="form-control" ng-model="tipoGrafica" >
                <option value="bar">Barras</option>
                <option value="line">Área</option>
            </select>
        </div>
        <div class="form-group" >
            <button class="btn btn-success" ng-click="descargarGrafica()" ng-disabled="!(data && data.length>0)" >
                Descargar
            </button>
        </div>
</div>

<div>
   
    
    <div class="row" >
       <div class="col-xs-12 col-md-9">
            <div class="well" ng-if="!data || data.length==0">
                <p><strong>Para generar los resultados:</strong></p>
                <ol>
                    <li>Seleccione la pregunta de la cual desea conocer los resultados.</li>
                    <li>Seleccione el tipo de grafico con el cual desea visualizar los resultados.</li>
                    <li>Si desea, presione el botón Descargar para descargar los resultados.</li>
                </ol>
                <img src="/Content/icons/estadisticas/estadisticas.png" alt="" role="presentation" class="img-responsive" style="height: 200px; margin: 0 auto;" >
            </div>
            <canvas id="base" class="chart-base" chart-type="tipoGrafica"
              chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colores">
            </canvas>    
            
             <div class="row" style="margin-bottom:15px"  >
                <div class="col-md-12" >
                    <table class="table table-striped" ng-show="data.length>0" >
                        <thead>
                          <tr>
                            <th></th>
                            <th ng-if="!isTablaContingencia" >Total</th>
                            <th ng-if="isTablaContingencia" ng-repeat="item in labels" class="text-center" >@{{item}}</th>
                          </tr>
                        </thead>
                        <tbody ng-if="!isTablaContingencia" >
                          <tr ng-repeat="label in labels">
                            <td>@{{label}}</td>
                            <td class="text-center" >@{{data[$index]}}</td>
                          </tr>
                        </tbody>
                        <tbody  ng-if="isTablaContingencia">
                          <tr ng-repeat="datos in data track by $index" >
                            <td>@{{series[$index]}}</td>
                            <td ng-repeat="d in datos track by $index" class="text-center" >@{{d}}</td>
                          </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
    
       </div>
       <div class="col-xs-12 col-md-3">
           
            <p class="text-center">{{$encuesta->idiomas[0]->descripcion}}</p>
            
            <canvas id="polar-area" class="chart chart-polar-area" width="400" height="400"
              chart-data="[{{$terminadas}},{{$noTerminadas}}]" chart-labels="['Terminadas','No terminadas']" 
              chart-options="{ legend: { display: true, position: 'bottom' }, title: { display: true, text: 'Encuestas' } }" >
            </canvas> 
            
            <ul class="list-group"> 
              <li class="list-group-item d-flex justify-content-between align-items-center" >
               Terminadas <span class="badge badge-pill">{{$terminadas}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center" >
                No terminadas <span class="badge badge-pill">{{$noTerminadas}}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Total <span class="badge badge-pill">{{$terminadas+$noTerminadas}}</span>
              </li>
            </ul>
            
        </div>
    </div>
    
</div>
   
<style type="text/css">
       .list-group-item { cursor: default; }
       #openModalOrdenPreguntas .list-group-item { cursor: move; }
       .btn-agregar{
            margin-left: 10px;
            font-size: 1.1em;
            padding: 5px 11px;
            background: #5bb85b;
            border: none;
            border-radius: 35px;
            color: white;
            font-weight: bold;
       }
       .btn-agregar:focus { outline: none; }
       .list-group-item>.badge { background: red; }
       #openModalOrdenPreguntas .list-group-item>.badge { background: black; }
       .center{ text-align:center; }
    </style>

@endsection

@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="{{asset('/js/plugins/Chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-chart.min.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-dragdrop.min.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/serviAdmin.js')}}"></script>
    <script src="{{asset('/js/encuestas/dinamica/appAdmin.js')}}"></script>
@endsection