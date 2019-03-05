<?xml version='1.0' encoding='utf-8' ?>
<kml xmlns='http://www.opengis.net/kml/2.2'>
  <Document>    
         
    <name>{!! html_entity_decode($periodo['nombre']) !!}</name>
    
    <description> {{$periodo['fecha_inicio']}} al {{$periodo['fecha_fin']}} </description>
      
    
    @foreach ($zonas as $zona)
          <?php 
           $color = '4D' . substr($zona['color'], 5, 2) . substr($zona['color'], 3, 2) . substr($zona['color'], 1, 2);
          ?>
          
          <Style id='poly-{{$zona['id']}}-normal'>
            <PolyStyle>
              <color>{{$color}}</color>
              <width>2</width>
              <fill>1</fill>
              <outline>0.2</outline>
            </PolyStyle>
            <BalloonStyle>
              <text><![CDATA[<h3>$[name]</h3>]]></text>
            </BalloonStyle>
          </Style>
          <Style id='poly-{{$zona['id']}}-highlight'>
            <PolyStyle>
              <color>{{$color}}</color>
              <fill>1</fill>
              <outline>0.2</outline>
            </PolyStyle>
            <BalloonStyle>
              <text><![CDATA[<h3>$[name]</h3>]]></text>
            </BalloonStyle>
          </Style>
          <StyleMap id='poly-{{$zona['id']}}-nodesc'>
            <Pair>
              <key>normal</key>
              <styleUrl>#poly-{{$zona['id']}}-normal</styleUrl>
            </Pair>
            <Pair>
              <key>highlight</key>
              <styleUrl>#poly-{{$zona['id']}}-highlight</styleUrl>
            </Pair>
          </StyleMap>
    @endforeach 
      
    <Folder>  
        <name>Bloques</name>
        @foreach ($zonas as $zona)
          <Placemark>
             <name>{!! html_entity_decode($zona['nombre']) !!}</name>
             <styleUrl>#poly-{{$zona['id']}}-nodesc</styleUrl>
             <ExtendedData>
               <Data name='name'><value>{!! html_entity_decode($zona['nombre']) !!}</value></Data>
             </ExtendedData>        
             <Polygon>
              <outerBoundaryIs>
                <LinearRing>
                  <coordinates>
                    @foreach ($zona['coordenadas'] as $coordenada)
                        {{$coordenada['y']}},{{$coordenada['x']}},0
                    @endforeach
                        {{$zona['coordenadas'][0]['y']}},{{$zona['coordenadas'][0]['x']}},0
                  </coordinates>
                </LinearRing>
              </outerBoundaryIs>
             </Polygon>        
          </Placemark>
        @endforeach
    </Folder>
    
    <Folder>
      <name>Prestadores formales</name>
      @foreach ($proveedores as $proveedor)
        @if( $proveedor->rnt )
          <Placemark>
            <name>{!! html_entity_decode($proveedor->nombre_rnt) !!}</name>
            <ExtendedData>
              <Data name='RNT'><value>{{$proveedor->rnt}}</value></Data>
              <Data name='ESTADO'><value>{!! html_entity_decode($proveedor->estado_rnt) !!}</value></Data>
              <Data name='NOMBRE DEL ESTABLECIMIENTO'><value>{!! html_entity_decode($proveedor->nombre_rnt) !!}</value></Data>
              <Data name='DIRECCIÓN ESTABLECIMIENTO'><value>{!! html_entity_decode($proveedor->direccion_rnt) !!}</value></Data>
              <Data name='CATEGORIA'><value>{!! html_entity_decode($proveedor->categoria_rnt) !!}</value></Data>
              <Data name='SUBCATEGORIA'><value>{!! html_entity_decode($proveedor->subcategoria_rnt) !!}</value></Data>
            </ExtendedData>
            <Point>
              <coordinates>
                {{$proveedor->longitud}},{{$proveedor->latitud}},0
              </coordinates>
            </Point>
          </Placemark>
        @endif
      @endforeach
    </Folder>
    
    <Folder>
      <name>Prestadores informales</name>
      @foreach ($proveedores as $proveedor)
        @if( !$proveedor->rnt )
          <Placemark>
            <name>{!! html_entity_decode($proveedor->nombre_rnt) !!}</name>
            <ExtendedData>
              <Data name='RNT'><value>No tiene</value></Data>
              <Data name='ESTADO'><value>{!! html_entity_decode($proveedor->estado_rnt) !!}</value></Data>
              <Data name='NOMBRE DEL ESTABLECIMIENTO'><value>{!! html_entity_decode($proveedor->nombre_rnt) !!}</value></Data>
              <Data name='DIRECCIÓN ESTABLECIMIENTO'><value>{!! html_entity_decode($proveedor->direccion_rnt) !!}</value></Data>
              <Data name='CATEGORIA'><value>{!! html_entity_decode($proveedor->categoria_rnt) !!}</value></Data>
              <Data name='SUBCATEGORIA'><value>{!! html_entity_decode($proveedor->subcategoria_rnt) !!}</value></Data>
            </ExtendedData>
            <Point>
              <coordinates>
                {{$proveedor->longitud}},{{$proveedor->latitud}},0
              </coordinates>
            </Point>
          </Placemark>
        @endif
      @endforeach
    </Folder>
    
 </Document>
</kml>