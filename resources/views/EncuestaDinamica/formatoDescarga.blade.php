<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Formato</title>
</head>

<body>
  

   <table>
       
          <tr>
                @foreach ($preguntas as $p)
                    @if ( count($p['subPreguntas']) > 0 )
                        <th colspan="{{count($p['subPreguntas'])}}" > {{ $p['idiomas'][0]['pregunta'] }} </th>
                    @else
                        <th rowspan="2" > {{ $p['idiomas'][0]['pregunta'] }} </th>
                    @endif
               @endforeach
          </tr>
          
          <tr>
                @foreach ($preguntas as $pt)
                    
                    @forelse ($pt->subPreguntas as $sp)
                        <th> {{ $sp['idiomas'][0]['nombre'] }} </th>
                    @empty
                       <th>  </th>
                    @endforelse
                @endforeach
          </tr>
          
          
          @foreach ($encuestas as $encuesta)
                <tr>
                   @foreach ($encuesta as $r)
                      <td>{{ $r }}</td>
                   @endforeach
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