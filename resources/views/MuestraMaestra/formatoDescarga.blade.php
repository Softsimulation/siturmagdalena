<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Formato</title>
</head>

<body>
   
   
   
   <table style="width:60%" style="text-align:left" >
       <tr>
           <td colspan="8" >
               <img src="img/brand/others/logos.png" />
           </td>
       </tr>
       <tr>
           <td colspan="4" >DEPARTAMENTO:</td>
           <td colspan="4" >Magdalena</td>
       </tr>
       <tr>
           <td colspan="4" >MUNICIPIO:</td>
           <td colspan="4" >Santa Marta</td>
       </tr>
       <tr>
           <td colspan="4" >IDENTIFICACION DE PLANILLA:</td>
           <td colspan="4" ></td>
       </tr>
       <tr>
           <td colspan="4" style="text-align:center;" >BLOQUE:</td>
           <td colspan="4" style="text-align:center;" >FECHA DE VERIFICACIÓN BLOQUE</td>
       </tr>
       <tr>
           <td colspan="4" style="text-align:center;" > {{$zona->nombre}} </td>
           <td colspan="4" style="text-align:center;" ></td>
       </tr>
       <tr>
           <td colspan="4" >NOMBRE DEL VERIFICADOR/CODIGO:</td>
           <td colspan="4" >
                @foreach ($zona['encargados'] as $encargado)
                    {{$encargado->user['nombre'] . ","}} 
                @endforeach        
           </td>
       </tr>
   </table>
 
   
   <table class="table" >
       
          <tr>
            <th style="width:10%;" >ID</th>
            <th>RNT</th>
            <th colspan="2" >ESTADO</th>
            <th colspan="2" >NOMBRE DEL ESTABLECIMIENTO</th>
            <th colspan="2" >DIRECCIÓN ESTABLECIMIENTO</th>
            <th colspan="2" >CATEGORIA</th>
            <th colspan="2" >SUBCATEGORIA</th>
            <th>NOVEDADES</th>
            <th>ENCUESTA SOSTENIBILIDAD</th>
            <th>ESTADO</th>
          </tr>
          
          @if (count($proveedores) === 0)
          
            @for ($i = 0; $i < 10; $i++)
                <tr>
                    <td rowspan="2" style="width:10%;" ></td>
                    <td rowspan="2" ></td>
                    <td rowspan="2" style="width:20%;" ></td>    <td style="width:5%; background: #85f185;" >SI</td>
                    <td style="width:25%;" ></td>                <td style="width:5%; background: #85f185;" >SI</td>
                    <td style="width:25%;" ></td>                <td style="width:5%; background: #85f185;" >SI</td>
                    <td style="width:25%;" ></td>                <td style="width:5%; background: #85f185;" >SI</td>
                    <td style="width:25%;" ></td>                <td style="width:5%; background: #85f185;" >SI</td>
                    <td style="width:25%;" rowspan="2" ></td>
                    <td style="width:15%;" ></td>
                    <td style="width:10%;" ></td>
                </tr>
                  
                <tr>
                    <td style="width: 20%;" ></td> <td style=";width: 5%;" >NO</td>
                    <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>       
                    <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                    <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                    <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                    <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                    <td style="width: 25%;" ></td> <td style=";width: 25%;">NOMBRE</td>
                    <td style="width:10%;" >RECO</td>
                </tr>
                
                
            @endfor
            
          @endif
          
          @foreach ($proveedores as $proveedor)
              <tr>
                <td rowspan="2" style="width:10%;" > {{$proveedor->codigo}} </td>
                <td rowspan="2" > {{$proveedor->rnt ? $proveedor->rnt : 'No tiene' }} </td>
                <td rowspan="2" style="width:20%;" > {{$proveedor->estado_rnt}} </td>      <td style="width:5%; background: #85f185;" >SI</td>
                <td style="width:25%;" > {{$proveedor->nombre_rnt}} </td>                  <td style="width:5%; background: #85f185;" >SI</td>
                <td style="width:25%;" > {{$proveedor->direccion_rnt}} </td>               <td style="width:5%; background: #85f185;" >SI</td>
                <td style="width:25%;" > {{$proveedor->categoria_rnt}} </td>               <td style="width:5%; background: #85f185;" >SI</td>
                <td style="width:25%;" > {{$proveedor->subcategoria_rnt}} </td>            <td style="width:5%; background: #85f185;" >SI</td>
                <td style="width:25%;" rowspan="2" ></td>
                <td style="width:15%;" >FECHA   HORA</td>
                <td style="width:10%;" >ENTR</td>
              </tr>
              
              <tr>
                <td style="width: 20%;" ></td> <td style=";width: 5%;" >NO</td>
                <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>       
                <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                <td style="width: 25%;" ></td> <td style=";width: 5%;" >NO</td>
                <td style="width: 25%;" ></td> <td style=";width: 25%;">NOMBRE</td>
                <td style="width:10%;" >RECO</td>
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
    
    .table td {
        height: 30px;
    }
</style>

</body>

</html>