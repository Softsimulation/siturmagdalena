@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection','Detalles de zonas')
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="DetalleZonasCtrl"')

@section('titulo','Muestra maestra')
@section('subtitulo','Ingresar información de zona')

@section('content')
   
   <input type="hidden" id="periodo" value="{{$periodo}}" />
   
    <h1>@{{zona.nombre}}</h1>
   
    <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>SECTOR</th>
                  <th>BLOQUE</th>
                  <th>ENCARGADOS</th>
                  <th>PRESTADORES (Estado – Categoría)</th>
                  <th>GENERADA</th>
                  <th>PLANILLA</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="z in detalle" >
                  <th>@{{$index+1}}</th>
                  <td>@{{ (sectores|filter:{id:z.sector_id}:true)[0].sectores_con_idiomas[0].nombre }}</td>
                  <td>@{{z.nombre}}</td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.encargados" > @{{it.codigo}} </li> 
                      </ul>
                  </td>
                  <td>
                      <ul>
                         <li ng-repeat="it in z.estadosProveedores" > @{{it.nombre}}: @{{it.cantidad}} </li> 
                      </ul>
                      
                      <br>
                      
                      <ul>
                         <li ng-repeat="it in z.tiposProveedores" > @{{it.nombre}}: @{{it.cantidad[0]+it.cantidad[1]}}
                         <p style="font-size:11px" >Formales:@{{it.cantidad[0]}}, informales:@{{it.cantidad[1]}}</p> </li> 
                      </ul>
                  </td>
                  <td>@{{z.es_generada ? "Si" : "No"}}</td>
                  <td>
                    <a href  ng-click="exportarFileExcelZona(z)" >
                        Descargar
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>

@endsection

@section('javascript')
    <script src="{{asset('/js/dir-pagination.js')}}"></script>
    <script src="{{asset('/js/plugins/angular-sanitize.js')}}"></script>
    <script src="{{asset('/js/plugins/select.min.js')}}"></script>
    <script src="{{asset('/js/plugins/checklist-model.js')}}"></script>
    <script src="{{asset('/js/plugins/ADM-dateTimePicker.min.js')}}"></script>
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
