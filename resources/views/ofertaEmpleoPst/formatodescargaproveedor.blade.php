<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Formato</title>
</head>

<body>
          <table class="table table-striped">
                        <thead>
                            <tr>   
                                <th>IdProveedorRNT</th>
                                <th>Número de RNT</th>
                                <th>Nombre comercial</th>
                                <th>Sub-Categoría</th>
                                <th>Categoría</th>
                                <th>Direccion</th>
                                <th>Contacto</th>
                             
                            </tr>
           
                        </thead>
                         <tbody>
                         @foreach ($proveedores as $proveedor)    
                            <tr>
                           
                                <td>{{$proveedor->proveedor_rnt_id}}</td>
                                <td>{{$proveedor->rnt}}</td>
                                <td>{{$proveedor->razon_social}}</td>
                                <td>{{$proveedor->subcategoria}}</td>
                                <td>{{$proveedor->categoria}}</td>
                                <td>{{$proveedor->direccion}}</td>
                                 @if ($proveedor->email != null)
                                   <td >{{$proveedor->email}}</td>
                               
                                @else
                                   <td >N/D</td>
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