
(function(){

    angular.module("appMuestraMaestra", [ 'ngSanitize', 'ui.select', 'checklist-model',  "serviciosMuestraMaestra", "ngMap" ] )
    
    .controller("MuestraMaestraCtrl", ["$scope","ServiMuestra", "NgMap", "$timeout", "$interval", function($scope,ServiMuestra,NgMap,$timeout,$interval){
        
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.pantallaCompleta = false;
        $scope.TipoProveedorInformal = {};
        $scope.selectTipoProveedores = { select:[] };
        $scope.filtro = { tipo:[], categorias:[], estados:[], sectoresProv:[], municipios:[], verZonas:true, sectores:[], encargados:[], tipoProveedores:1 };
        $scope.dataPerido = { zonas:[] };
        $scope.zona = {};
        $scope.styloMapa = [{featureType:'poi.school',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.business',elementType:'labels',stylers:[{visibility:'off'}]} , {featureType:'poi.attraction',elementType:'labels',stylers:[{visibility:'off'}]} ];
        $scope.centro = [10.4113014,-74.4056612];
        $scope.filterTabla = {};
        $scope.sharpesAndPopus =[];
        $scope.markersProveedores =[];
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                $scope.sectoresZonasIDS = [];
                $scope.sectoresZonas = [];
                $scope.proveedores = data.proveedores.concat(data.proveedoresInformales);
                
                for(var i=0; i< data.periodo.zonas.length; i++){
                    
                    if( $scope.sectoresZonasIDS.indexOf( data.periodo.zonas[i].sector_id )==-1 && data.periodo.zonas[i].sector_id ){
                        $scope.sectoresZonasIDS.push( data.periodo.zonas[i].sector_id );
                        $scope.sectoresZonas.push( $scope.buscarAbjetoInArray(data.sectores,data.periodo.zonas[i].sector_id) );
                    }
                    
                    $scope.crearPolygono( data.periodo.zonas[i] );
                    
                }
                
                $scope.TotalFormales = data.proveedores.length;
                $scope.TotalInformales = data.proveedoresInformales.length;
                
                $scope.tiposProveedoresInfo = [];
                
                for(var i=0; i<data.tiposProveedores.length; i++){
                    $scope.tiposProveedoresInfo.push( { id:data.tiposProveedores[i].id , nombre:data.tiposProveedores[i].tipo_proveedores_con_idiomas[0].nombre, cantidad:[0,0] } );
                    
                    data.tiposProveedores[i].cantidad = $scope.getCantidadProveedores( data.tiposProveedores[i].id, "idtipo" );
                    
                    for(var j=0; j<data.tiposProveedores[i].categoria_proveedores.length; j++){
                        data.tiposProveedores[i].categoria_proveedores[j].cantidad = $scope.getCantidadProveedores( data.tiposProveedores[i].categoria_proveedores[j].id, "idcategoria" );
                    }
                    
                }
                
                for(var i=0; i<data.estados.length; i++){
                    data.estados[i].cantidad = $scope.getCantidadPorEstado(data.estados[i].id);
                }
                
                for(var i=0; i<data.municipios.length; i++){
                    data.municipios[i].cantidad = $scope.getCantidadProveedores(data.municipios[i].id, "municipio_id");
                }
                
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.sectores = data.sectores;
                $scope.estados = data.estados;
                $scope.municipios = data.municipios;
                
                for (var i=0; i<$scope.proveedores.length; i++) {  
                    $scope.markersProveedores.push( $scope.crearMarker($scope.proveedores[i]) );
                };
                
                
                for(var i=0; i<$scope.sectoresZonas.length; i++){
                    $scope.sectoresZonas[i].cantidad = $scope.getCantidadPorSector($scope.sectoresZonas[i].id);
                }
                
                /*
                $scope.heatmapFormales   = new google.maps.visualization.HeatmapLayer({ data: $scope.getLatLngProveedores(data.proveedores), map: $scope.map, radius:getNewRadius() });
                $scope.heatmapInformales = new google.maps.visualization.HeatmapLayer({ data: $scope.getLatLngProveedores(data.proveedoresInformales), map: $scope.map, radius:getNewRadius()  });
                
                var gradient = [ 'rgba(0, 255, 255, 0)', 'rgba(0, 255, 255, 1)', 'rgba(0, 191, 255, 1)', 'rgba(0, 127, 255, 1)', 'rgba(0, 63, 255, 1)', 'rgba(0, 0, 255, 1)', 'rgba(0, 0, 223, 1)', 'rgba(0, 0, 191, 1)', 'rgba(0, 0, 159, 1)', 'rgba(0, 0, 127, 1)', 'rgba(63, 0, 91, 1)', 'rgba(127, 0, 63, 1)', 'rgba(191, 0, 31, 1)', 'rgba(255, 0, 0, 1)' ];
                $scope.heatmapInformales.set('gradient', gradient);
                */
                
                $("body").attr("class", "cbp-spmenu-push");
                
            });
        
        $scope.getLatLngProveedores = function(array){
            
            var Lista = [];
            
            for(var i=0; i<array.length; i++){
                Lista.push( new google.maps.LatLng(array[i].latitud, array[i].longitud ) );
            }
             
            return Lista;
        }
        
        
        $scope.crearMarker = function(pro){
            
            var marker = new google.maps.Marker(
                            {
                                position: new google.maps.LatLng(pro.latitud, pro.longitud),
                                dataProveedor: pro,
                                icon: { url: "/Content/IconsMap/"+(pro.rnt ? "green.png" : "red.png"), scaledSize: new google.maps.Size(20, 20), labelOrigin: new google.maps.Point(12, -10) }
                            });
            marker.setMap($scope.map);
            //marker.addListener('click',  $scope.showInfoMapa );
            
            return marker;
        }
        
        $scope.crearPolygono = function(zona){
            var polygon = new google.maps.Polygon({ map: $scope.map, paths: $scope.getCoordenadasZona( zona.coordenadas ), dataZona : zona, visible: false });
            $scope.sharpesAndPopus.push( { sharpe: polygon } );
        }
        
      
        $scope.getCoordenadasZona = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push({ lat: coordenadas[j].x, lng: coordenadas[j].y });
            }
            return array;
        }
        
        $scope.filterProveedores = function(){
            return;
            var dynMarkers = [];
            
            for( var i=0; i<$scope.markersProveedores.length; i++ ){
                var pro = $scope.markersProveedores[i].dataProveedor;
                
                var sw0 = 0; var sw1 = 0; var sw2 = 0; var sw3 = 0; var sw4 = 0;
            
                if( $scope.filtro.tipoProveedores!=1){
                    sw0 = (($scope.filtro.tipoProveedores==2 && pro.rnt) || ($scope.filtro.tipoProveedores==3 && !pro.rnt)) ? 1 : -1;
                }
                
                if($scope.filtro.tipo.length>0){
                    sw1 = $scope.filtro.tipo.indexOf(pro.idtipo);
                    
                    if($scope.filtro.categorias.length>0){ sw1 =  $scope.filtro.categorias.indexOf(pro.idcategoria); }
                }
                
                if($scope.filtro.estados.length>0){ sw2 = $scope.filtro.estados.indexOf(pro.idestado); }
                
                if($scope.filtro.municipios.length>0){ sw3 = $scope.filtro.municipios.indexOf(pro.municipio_id); }
                
                if( $scope.filtro.sectoresProv.length > 0){ 
                    
                    var point = new google.maps.LatLng( pro.latitud , pro.longitud );
                    sw4 = -1;
                    for (var i = 0; i < $scope.dataPerido.zonas.length; i++) { 
                        if( $scope.filtro.sectoresProv.indexOf( $scope.dataPerido.zonas[i].sector_id )!=-1 ){
                            if( google.maps.geometry.poly.containsLocation( point , $scope.map.shapes[i] ) ){
                                sw4 = 1; break;
                            }
                            
                        }
                    }
                }
                
                if( ( (sw0>=0?true:false) && (sw1>=0?true:false) && (sw2>=0?true:false) && (sw3>=0?true:false) && (sw4>=0?true:false) ) ){
                    dynMarkers.push( $scope.markersProveedores[i] );
                }
                
            }
            
            $scope.clusterProveedores.clearMarkers();
            $scope.clusterProveedores.addMarkers(dynMarkers);
            $scope.clusterProveedores.redraw();
            
        }
        
        $scope.limpiarFiltros = function(){
            $scope.filtro = { tipo:[], categorias:[], estados:[], municipios:[], sectoresProv:[], verZonas:true, sectores:[], encargados:[], tipoProveedores:1 };
        }
        
        /*
        $scope.getIcono = function( p ){
            
            var ruta = "";
            
            switch ( p.idtipo ) {
                case 1: ruta  += "/Content/IconsMap/alojamientos/"; break;
                case 2: ruta  += "/Content/IconsMap/establecimiento_gastronomia/"; break;
                case 3: ruta  += "/Content/IconsMap/agencias_viajes/"; break;
                //case 4: ruta  += "esparcimiento/"; break;
                case 5: ruta  += "/Content/IconsMap/empresa_transporte/"; break;
                case 6: ruta  += "/Content/IconsMap/arrendadores_vehiculos/"; break;
                case 7: ruta  += "/Content/IconsMap/concesionarios_servicios/"; break;
                case 8: ruta  += "/Content/IconsMap/empresa_tiempo/"; break;
                case 9: ruta  += "/Content/IconsMap/empresas_captadoras/"; break;
                case 10: ruta += "/Content/IconsMap/guia_turismo/"; break;
                case 11: ruta += "/Content/IconsMap/oficina_turistica/"; break;
                case 12: ruta += "/Content/IconsMap/operadores_profesionales/"; break;
                case 13: ruta += "/Content/IconsMap/parques_tematicos/"; break;
                case 14: ruta += "/Content/IconsMap/usuarios_operadores/"; break;
                default: break;
            }
            
            if(ruta != ""){
                if(p.rnt){
                    switch ( p.idestado ) {
                        case 1: ruta += "activo.png";     break;  // Activo
                        case 2: ruta += "cancelado.png";  break;  // Nnulado
                        case 3: ruta += "cancelado.png";  break;  // Cancelado
                        case 4: ruta += "cancelado.png";  break;  // Cancelado por traslado
                        case 5: ruta += "pendiente.png";  break;  // Pendiente actualización
                        case 6: ruta += "cancelado.png";  break;  // Suspendido
                        default: return null;
                    }
                }
                else{ ruta += "informal.png";  }
            }
            
            return  ruta;
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        
        
        $scope.showInfoMapa = function(){ 
            
            if( $scope.proveedor ){
                $scope.cancelarEditarPosicionProveedor();
            }
            $scope.proveedor = this.dataProveedor;
            $scope.proveedorEditarPos = this;
            document.getElementById("mySidenav").style.width = "350px";
            $scope.detalleZona = null;
            $scope.$apply();
        }  
        
        
        $scope.closeInfoMapa = function(){
            $scope.proveedor = null;
            $scope.detalleZona = null;
            document.getElementById("mySidenav").style.width = "0";
        }
        
        
        */
        
        $scope.getCantidadProveedores = function(id, idCompara){
            
            var sF = 0; var sI = 0;
            
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i][idCompara]==id ){  
                    if($scope.proveedores[i].rnt){ sF+=1; }
                    else{ sI+=1; }
                }
            }
            
            return {  formales: sF,  informales: sI };
        }
        
        $scope.getCantidadPorEstado = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].idestado==id ){  s+=1;  }
            }
            return s;
        }
        
        $scope.getCantidadPorSector = function(id){
            
            var sF = 0;
            var sI = 0;
            
            for(var i=0; i<$scope.sharpesAndPopus.length; i++){
                if($scope.sharpesAndPopus[i].sharpe.dataZona.sector_id==id){
                    for(var k=0; k<$scope.markersProveedores.length; k++){
                        
                        if( google.maps.geometry.poly.containsLocation( $scope.markersProveedores[k].position , $scope.sharpesAndPopus[i].sharpe ) ){
                            
                            if($scope.markersProveedores[k].dataProveedor.rnt){ sF+=1; }
                            else{ sI+=1; }
                            
                        }
                            
                    }
                }
            }
            
            return {  formales: sF,  informales: sI };
        }
        
        $scope.centerMapa = function(){
            
            if($scope.proveedoresFiltrados.length>0){
                $timeout(function() {
                    if($scope.proveedoresFiltrados.length>0){
                        $scope.map.setZoom(15);
                        $scope.map.setCenter( new google.maps.LatLng($scope.proveedoresFiltrados[0].latitud, $scope.proveedoresFiltrados[0].longitud) );
                    }
                },1000);
                
            }
            
        }
        
        $scope.centrarMapaAlProveedor = function(pro){
            $scope.map.setZoom(21);
            $scope.map.setCenter( new google.maps.LatLng(pro.latitud, pro.longitud) );
        }
        
        $scope.buscarAbjetoInArray = function(array, id){
            for(var j=0; j<array.length; j++){
                if( array[j].id==id ){ return array[j]; }
            }
            return null;
         } 
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
            /*
            google.maps.event.addListener($scope.map, 'zoom_changed', function (){
              $scope.heatmapFormales.setOptions({ radius: getNewRadius() });
              $scope.heatmapInformales.setOptions({ radius: getNewRadius() });
            });
            */
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({ strokeColor: 'red', strokeWeight: 1, fillOpacity:0, clickable:false });
        });
        
        
    var TILE_SIZE = 256;

      //Mercator --BEGIN--
    function bound(value, opt_min, opt_max) {
          if (opt_min !== null) value = Math.max(value, opt_min);
          if (opt_max !== null) value = Math.min(value, opt_max);
          return value;
    }

    function degreesToRadians(deg) { return deg * (Math.PI / 180); }

    function radiansToDegrees(rad) { return rad / (Math.PI / 180); }

    function MercatorProjection() {
          this.pixelOrigin_ = new google.maps.Point(TILE_SIZE / 2, TILE_SIZE / 2);
          this.pixelsPerLonDegree_ = TILE_SIZE / 360;
          this.pixelsPerLonRadian_ = TILE_SIZE / (2 * Math.PI);
    }

    MercatorProjection.prototype.fromLatLngToPoint = function (latLng, opt_point) {
          var me = this;
          var point = opt_point || new google.maps.Point(0, 0);
          var origin = me.pixelOrigin_;

          point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;
          var siny = bound(Math.sin(degreesToRadians(latLng.lat())), - 0.9999, 0.9999);
          point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) * -me.pixelsPerLonRadian_;
          return point;
    };

    MercatorProjection.prototype.fromPointToLatLng = function (point) {
          var me = this;
          var origin = me.pixelOrigin_;
          var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
          var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
          var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);
          return new google.maps.LatLng(lat, lng);
    };

      //Mercator --END--

        
        
    var desiredRadiusPerPointInMeters = 1000;
    function getNewRadius() {
          
          var numTiles = 1 << $scope.map.getZoom();
          var center = $scope.map.getCenter();
          var moved = google.maps.geometry.spherical.computeOffset(center, 10000, 90); /*1000 meters to the right*/
          var projection = new MercatorProjection();
          var initCoord = projection.fromLatLngToPoint(center);
          var endCoord = projection.fromLatLngToPoint(moved);
          var initPoint = new google.maps.Point( initCoord.x * numTiles, initCoord.y * numTiles);
          var endPoint = new google.maps.Point( endCoord.x * numTiles, endCoord.y * numTiles);
          var pixelsPerMeter = (Math.abs(initPoint.x-endPoint.x))/10000.0;
          var totalPixelSize = Math.floor(desiredRadiusPerPointInMeters*pixelsPerMeter);
          console.log(totalPixelSize);
          return totalPixelSize;
    }
        
        
    }])
    
}());

