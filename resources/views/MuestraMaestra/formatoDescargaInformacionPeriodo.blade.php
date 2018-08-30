<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Formato</title>
</head>

<body>
   
   
   
   
   <table class="table" >
       
          <tr>
              <th>RNT</th> <th>ActRNT</th>
              <th>Estado</th> <th>ActEstado</th>
              <th>Nombre Comercial</th> <th>ActNombreComercial</th>
              <th>Direccion Comercial</th> <th>ActDirComercial</th>
              <th>CodCategoria</th> <th>ActCodCategoria</th>
              <th>CodSubcategoria</th> <th>ActCodSubcategoria</th>
              <th>Municipio</th> <th>ActMunicipio</th>
              <th>Novedades</th>
              <th>GEOPOSICIÓN - LATITUD Y LONGITUD</th>
          </tr>
          
          @if (count($proveedores) === 0)
             <tr>
                 <td colspan="15" >No se encontraron proveedores dentro de la zona</td>
             </tr>
          @endif
          
          @foreach ($proveedores as $proveedor)
              <tr>
                  <td>{{$proveedor->rnt_proveedor}}</td>        <td>{{$proveedor->rnt_muestra}}</td> 
                  <td>{{$proveedor->estado_proveedor}}</td>     <td>{{$proveedor->estado_muestra}}</td>
                  <td>{{$proveedor->nombre_proveedor}}</td>     <td>{{$proveedor->nombre_proveedor_muestra}}</td>
                  <td>{{$proveedor->direccion_proveedor}}</td>  <td>{{$proveedor->direccion_muestra}}</td>
                  
                  <td>{{$proveedor->categoria_proveedor}}</td>     <td>{{$proveedor->categoria_muestra}}</td>
                  <td>{{$proveedor->subcategoria_proveedor}}</td>     <td>{{$proveedor->subcategoria_muestra}}</td>
                  
                  <td>municipio</td>  <td>municipio</td>
                  <td>{{$proveedor->observaciones_muestra}}</td>
                  
                  <td>{{$proveedor->latitud}} {{$proveedor->longitud}}</td>
              </tr>
          @endforeach
          
          @foreach ($proveedoresInformales as $proveedor)
              <tr>
                  <td>---</td>        <td>---</td> 
                  <td>{{$proveedor->estado_proveedor}}</td>     <td>{{$proveedor->estado_muestra}}</td>
                  <td>{{$proveedor->nombre_proveedor}}</td>     <td>{{$proveedor->nombre_proveedor_muestra}}</td>
                  <td>{{$proveedor->direccion_proveedor}}</td>  <td>{{$proveedor->direccion_muestra}}</td>
                  
                  <td>{{$proveedor->categoria_proveedor}}</td>     <td>{{$proveedor->categoria_muestra}}</td>
                  <td>{{$proveedor->subcategoria_proveedor}}</td>     <td>{{$proveedor->subcategoria_muestra}}</td>
                  
                  <td>municipio</td>  <td>municipio</td>
                  <td>{{$proveedor->observaciones_muestra}}</td>
                  
                  <td>{{$proveedor->latitud}} {{$proveedor->longitud}}</td>
              </tr>
          @endforeach
          
          

          
    </table>

<style>
    table, td, th {
        border: 4px solid #000000;
        padding: 0px 4px;
        text-align:center;
    }
    
    table {
        border-collapse: collapse;
    }
    
</style>

</body>

</html>