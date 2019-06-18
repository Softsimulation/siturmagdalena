<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Formato</title>
</head>

<body>
          <table class="table table-striped">
                        <thead>
                            <tr>   
                      
                            <th>ID</th>
                            <th>Número de RNT</th>
                            <th>Nombre comercial</th>
                            <th>Sub-Categoría</th>
                            <th>Categoría</th>
                            <th>Direccion</th>
                            <th>Encuesta</th>
                       
                             
                            </tr>
           
                        </thead>
                         <tbody>
                         @foreach ($proveedores as $proveedor)    
                            <tr>
                                <td>{{$proveedor->id}}</td>
                                <td>{{$proveedor->rnt}}</td>
                                <td>{{$proveedor->nombre}}</td>
                                <td>{{$proveedor->subcategoria}}</td>
                                <td>{{$proveedor->categoria}}</td>
                                <td>{{$proveedor->direccion}}</td>
                                @if ($proveedor->sitio_para_encuesta_id != null)
                                   <td >Activo</td>
                               
                                @else
                                   <td >Desactivado</td>
                                @endif
                               
                            </tr>
                         @endforeach
                         </tbody>
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