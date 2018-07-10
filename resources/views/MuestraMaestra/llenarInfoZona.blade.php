@extends('layout._AdminLayout')

@section('title','Muestra maestra')
@section('TitleSection','Creación de medición de Muestra Maestra')
@section('app','ng-app="appMuestraMaestra"')
@section('controller','ng-controller="LlenatInfoZonaCtrl"')

@section('content')
   
   <input type="hidden" id="id" value="{{$zona}}" />
   
    
   
    <form name="form" novalidate >
        
        <div class="btn-group">
            <a href="/MuestraMaestra/periodo/{{$periodo}}"  class="btn btn-primary" >Volver</a>
            <button type="submit" class="btn btn-success" ng-click="guardar()" >Guardar</button>
            <a href="/MuestraMaestra/excelinfozona/{{$zona}}"  class="btn btn-primary" >Descargar excel</a>
        </div>
        
        <table>
              <tr>
                <th style="width:4%">ID</th>
                <th style="width:8%" >RNT</th>
                <th style="width:13%" >ESTADO</th>
                <th style="width:15%">NOMBRE DEL ESTABLECIMIENTO</th>
                <th style="width:15%">DIRECCIÓN ESTABLECIMIENTO</th>
                <th style="width:15%">CATEGORIA</th>
                <th style="width:15%">SUBCATEGORIA</th>
                <th style="width:15%">NOVEDADES</th>
              </tr>
             
              <tr ng-repeat="item in proveedores" >
                <th>@{{item.id}}</th>
                <td ng-class="{ 'error': ( (form.$submitted || form.rnt@{{$index}}.$touched) && form.rnt@{{$index}}.$invalid  ) }" >  
                    <p title="@{{item.numero_rnt}}" >@{{item.numero_rnt}}</p> 
                    <input type="number" class="form-control" name="rnt@{{$index}}" min="0" placeholder="RNT" ng-model="item.muestra.rnt" required >
                </td>
                <td ng-class="{ 'error': ( (form.$submitted || form.estado@{{$index}}.$touched) && form.estado@{{$index}}.$invalid  ) }" >
                    <p title="@{{item.estadop.nombre}}" >@{{item.estadop.nombre}} </p> 
                    <select class="form-control" name="estado@{{$index}}"  ng-options="it.id as it.nombre for it in estados" ng-model="item.muestra.estado_proveedor_id" required >
                        <option value="" selected disabled >Estado</option>
                    </select>
                </td>
                <td ng-class="{ 'error': ( (form.$submitted || form.rz@{{$index}}.$touched) && form.rz@{{$index}}.$invalid  ) }" >
                    <p class="text-table" title="@{{item.razon_social}}" >@{{item.razon_social}}</p> 
                    <input type="text" class="form-control" name="rz@{{$index}}" placeholder="Nombre" ng-model="item.muestra.nombre_proveedor" required > 
                </td>
                <td ng-class="{ 'error': ( (form.$submitted || form.dir@{{$index}}.$touched) && form.dir@{{$index}}.$invalid  ) }" >
                    <p class="text-table" title="@{{item.direccion}}" >@{{item.direccion}}</p> 
                    <input type="text" class="form-control" name="dir@{{$index}}" placeholder="Dirección" ng-model="item.muestra.direccion" required >
                </td>
                <td ng-init="selectTipo=initSelectTipo(item.muestra.categoria.tipo_proveedores_id)" ng-class="{ 'error': ( (form.$submitted || form.tp@{{$index}}.$touched) && form.tp@{{$index}}.$invalid  ) }" >
                    <p class="text-table" title="@{{item.tipo}}" >@{{item.tipo}}</p>
                    <select class="form-control" name="tp@{{$index}}" ng-options="it as it.tipo_proveedores_con_idiomas[0].nombre for it in tiposProveedores" ng-model="selectTipo" required >
                        <option value="" selected disabled >Tipo proveedor</option>
                    </select>
                </td>
                <td ng-class="{ 'error': ( (form.$submitted || form.ctg@{{$index}}.$touched) && form.ctg@{{$index}}.$invalid  ) }">
                    <p class="text-table" title="@{{item.nombreCategoria}}" >@{{item.nombreCategoria}}</p>
                    <select class="form-control" name="ctg@{{$index}}" ng-options="it.id as it.categoria_proveedores_con_idiomas[0].nombre for it in selectTipo.categoria_proveedores" ng-model="item.muestra.categoria_proveedor_id" required >
                        <option value="" selected disabled >Categoria proveedor</option>
                    </select>
                </td>
                <td ng-class="{ 'error': ( (form.$submitted || form.obs@{{$index}}.$touched) && form.obs@{{$index}}.$invalid  ) }">
                     <textarea class="form-control" name="obs@{{$index}}" style="resize:none" placeholder="Novedades" ng-model="item.muestra.observaciones" ></textarea>
                </td>
              </tr>
              
        </table>
       
    </form>
    
    <style>
        table, td, th {
            border: 1px solid #000000;
            padding: 0px 4px;
            text-align:center;
        }
        
        table {
            border-collapse: collapse;
            margin-top: 30px;
        }
        
        table .form-control{
            padding: 1px 3px !important;
        }
        .text-table{
            width: 210px;
            padding: 1px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .error input, .error select{
                border: 1px solid red !important;
        }
    </style>

@endsection

@section('javascript')
    <script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places"></script>
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="{{asset('/js/muestraMaestra/servicios.js')}}"></script>
    <script src="{{asset('/js/muestraMaestra/app.js')}}"></script>
@endsection
