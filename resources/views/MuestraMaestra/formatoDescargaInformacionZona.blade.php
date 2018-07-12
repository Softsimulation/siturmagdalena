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
          </tr>
          
          @if (count($proveedores) === 0)
             <tr>
                 <td colspan="15" >No se encontraron proveedores dentro de la zona</td>
             </tr>
          @endif
          
          @foreach ($proveedores as $proveedor)
              <tr>
                  <td>{{$proveedor["proveedor"]['numero_rnt']}}</td>  <td>{{$proveedor['rnt']}}</td>
                  <td>{{$proveedor["proveedor"]['estadop']['nombre']}}</td> <td>{{$proveedor['estadop']['nombre']}}</td>
                  <td>{{$proveedor["proveedor"]['razon_social']}}</td> <td>{{$proveedor['nombre_proveedor']}}</td>
                  <td>{{$proveedor["proveedor"]['direccion']}}</td>  <td>{{$proveedor['direccion']}}</td>
                  
                  <td>{{$proveedor["proveedor"]["tipoCategoria"]['tipo']}}</td>  <td>{{$proveedor["tipoCategoria"]['tipo']}}</td>
                  <td>{{$proveedor["proveedor"]["tipoCategoria"]['categoria']}}</td>  <td>{{$proveedor["tipoCategoria"]['categoria']}}</td>
                  
                  
                  <td>municipio</td>  <td>municipio</td>
                  <td>{{$proveedor["observaciones"]}}</td>
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