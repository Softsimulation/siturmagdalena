
(function(){

    angular.module("appMuestraMaestra", [ 'ngSanitize', 'ui.select', 'checklist-model', "ADM-dateTimePicker",  "serviciosMuestraMaestra", "ngMap" ] )
    
    .config(["ADMdtpProvider", function(ADMdtpProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" });
    }])
    
    
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
        
        ServiMuestra.getData($("#periodo").val())
          .then(function(data){ 
                
                $scope.sectoresZonasIDS = [];
                $scope.sectoresZonas = [];
                for(var i=0; i< data.periodo.zonas.length; i++){
                    data.periodo.zonas[i].coordenadas = $scope.getCoordenadas(data.periodo.zonas[i].coordenadas);
                    
                    if( $scope.sectoresZonasIDS.indexOf( data.periodo.zonas[i].sector_id )==-1 && data.periodo.zonas[i].sector_id ){
                        $scope.sectoresZonasIDS.push( data.periodo.zonas[i].sector_id );
                        $scope.sectoresZonas.push( $scope.buscarAbjetoInArray(data.sectores,data.periodo.zonas[i].sector_id) );
                    }
                }
                
                $scope.TotalFormales = data.proveedores.length;
                $scope.TotalInformales = data.proveedoresInformales.length;
                
                $scope.dataPerido = data.periodo;
                $scope.digitadores = data.digitadores; 
                $scope.proveedores = data.proveedores.concat(data.proveedoresInformales);
                $scope.tiposProveedores = data.tiposProveedores;
                $scope.sectores = data.sectores;
                $scope.estados = data.estados;
                $scope.municipios = data.municipios;
                
                $scope.tiposProveedoresInfo = [];
                for(var i=0; i<data.tiposProveedores.length; i++){
                    $scope.tiposProveedoresInfo.push( { id:data.tiposProveedores[i].id , nombre:data.tiposProveedores[i].tipo_proveedores_con_idiomas[0].nombre, cantidad:[0,0] } );
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            });
       
       
        
        
        $scope.filterProveedores = function(pro){
            
            var sw0 = 0; var sw1 = 0; var sw2 = 0; var sw3 = 0; var sw4 = 0;
            
            if( $scope.filtro.tipoProveedores!=1){
                sw0 = (($scope.filtro.tipoProveedores==2 && pro.rnt) || ($scope.filtro.tipoProveedores==3 && !pro.rnt)) ? 1 : -1;
            }
            
            if($scope.filtro.tipo.length>0){
                sw1 = $scope.filtro.tipo.indexOf(pro.idtipo);
                
                if($scope.filtro.categorias.length>0){
                    sw1 =  $scope.filtro.categorias.indexOf(pro.idcategoria);
                }
            }
            
            if($scope.filtro.estados.length>0){
                sw2 = $scope.filtro.estados.indexOf(pro.idestado);
            }
            
            if($scope.filtro.municipios.length>0){
                sw3 = $scope.filtro.municipios.indexOf(pro.municipio_id);
            }
            
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
            
            
            return (sw0>=0?true:false) && (sw1>=0?true:false) && (sw2>=0?true:false) && (sw3>=0?true:false) && (sw4>=0?true:false);
            
        }
        
        $scope.filterZonas = function(item, index){
            
            var sw1 = 0;
            var sw2 = 0;
            
            if($scope.filtro.encargados.length>0){
                sw1 = -1;
                for(var i=0; i<item.encargados.length; i++){
                    if($scope.filtro.encargados.indexOf(item.encargados[i].id)!=-1){ sw1 = 1; break; }
                }
            }
            
            if($scope.filtro.sectores.length>0){
                sw2 = $scope.filtro.sectores.indexOf(item.sector_id); 
            }
            
            return (sw1>=0?true:false) && (sw2>=0?true:false);
        }
        
        $scope.limpiarFiltros = function(){
            $scope.filtro = { tipo:[], categorias:[], estados:[], municipios:[], sectoresProv:[], verZonas:true, sectores:[], encargados:[], tipoProveedores:1 };
        }
        
        $scope.getIcono = function( p ){
            
            var ruta = "/Content/IconsMap/";
            
            switch ( p.idtipo ) {
                case 1: ruta += "alojamientos/"; break;
                case 2: ruta += "gastronomicos/"; break;
                case 3: ruta += "agencias_viajes/"; break;
                case 4: ruta += "esparcimiento/"; break;
                case 5: ruta += "arrendadores_vehiculos/"; break;
                default: return null;
            }
            
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
            
            return  ruta;
        }
        
        $scope.getCoordenadas = function(coordenadas){
            var array = [];
            for(var j=0; j<coordenadas.length; j++){
                array.push([ coordenadas[j].x, coordenadas[j].y ]);
            }
            return array;
        }
        
        
        $scope.verOcultarZonas = function(){
            for(var i in  $scope.map.shapes){
                $scope.map.shapes[i].setVisible($scope.filtro.verZonas);
                $scope.map.customMarkers[i].setVisible($scope.filtro.verZonas);
            }
        }
        
        $scope.showInfoMapa = function(event, proveedor, index){
            
            if( $scope.proveedor ){
                $scope.cancelarEditarPosicionProveedor();
            }
            $scope.proveedor = proveedor;
            $scope.indexEditarProveedor = index;
            document.getElementById("mySidenav").style.width = "350px";
            $scope.detalleZona = null;
        }  
        
        $scope.showInfoNumeroPS = function(event, zona, proveedores){
            
            var numeroPrestadoresFormales = 0 ;
            var numeroPrestadoresInformales = 0 ;
            
            var tiposProveedores = angular.copy($scope.tiposProveedoresInfo);
            var estadosProveedores =  angular.copy($scope.estados);
            
            for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
            
            for(var i=0; i<proveedores.length; i++){
                
                var point = new google.maps.LatLng( proveedores[i].latitud , proveedores[i].longitud );
                if( google.maps.geometry.poly.containsLocation( point , this) ){
                    
                    for(var j=0; j<tiposProveedores.length; j++){ 
                        
                        if(tiposProveedores[j].id==proveedores[i].idtipo){
                            
                            if(proveedores[i].rnt){ tiposProveedores[j].cantidad[0] += 1; numeroPrestadoresFormales+=1; }
                            else{ tiposProveedores[j].cantidad[1] += 1; numeroPrestadoresInformales+=1; }
                            break;
                        }
                        
                    }  
                    
                    for(var j=0; j< estadosProveedores.length; j++){ 
                        if( estadosProveedores[j].id == $scope.proveedores[i].idestado ){
                            estadosProveedores[j].cantidad += 1; break;
                        }
                    } 
                    
                }
            }
            
            $scope.detalleZona = angular.copy(zona);
            $scope.detalleZona.tiposProveedores = tiposProveedores;
            $scope.detalleZona.estadosProveedores = estadosProveedores;
            $scope.detalleZona.numeroPrestadoresFormales = numeroPrestadoresFormales;
            $scope.detalleZona.numeroPrestadoresInformales = numeroPrestadoresInformales;
            
            document.getElementById("mySidenav").style.width = "350px";
            $scope.proveedor = null;
        }  
        
        $scope.closeInfoMapa = function(){
            $scope.proveedor = null;
            $scope.detalleZona = null;
            document.getElementById("mySidenav").style.width = "0";
        }
        
     
        
        $scope.verTablaZonas = function(){
            
            $scope.detalle = angular.copy($scope.dataPerido.zonas);
            
            
            var zona = null;
            
            for(var i=0; i<$scope.detalle.length; i++){
                
                zona = $scope.map.shapes[i];
                
                var tiposProveedores =  angular.copy($scope.tiposProveedoresInfo);
                var estadosProveedores =  angular.copy($scope.estados);
            
                for(var j=0; j<estadosProveedores.length; j++){ estadosProveedores[j].cantidad = 0;  }
                
                
                for(var k=0; k<$scope.proveedores.length; k++){
                    
                    var point = new google.maps.LatLng( $scope.proveedores[k].latitud , $scope.proveedores[k].longitud );
                    if( google.maps.geometry.poly.containsLocation( point , zona ) ){
                        
                        
                        
                        for(var j=0; j< tiposProveedores.length; j++){ 
                            if(tiposProveedores[j].id==$scope.proveedores[i].idtipo){
                            
                                if($scope.proveedores[k].rnt){ tiposProveedores[j].cantidad[0] += 1; }
                                else{ tiposProveedores[j].cantidad[1] += 1; }
                                break;
                            }
                        }  
                        
                        for(var j=0; j< estadosProveedores.length; j++){ 
                            if( estadosProveedores[j].id == $scope.proveedores[k].idestado ){
                                estadosProveedores[j].cantidad += 1; break;
                            }
                        } 
                        
                    }
                    
                }
                
                
           
                
                $scope.detalle[i].tiposProveedores = tiposProveedores;
                $scope.detalle[i].estadosProveedores = estadosProveedores;
                
            }
            
            
            $("#modalDetallesZonas").modal("show");
        }
        
        $scope.getCantidadPorTipo = function(id){
            
            var sT = 0;
            var sF = 0;
            var sI = 0;
            
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].idtipo==id ){  
                    sT+=1;  
                    if($scope.proveedores[i].rnt){ sF+=1; }
                    else{ sI+=1; }
                }
            }
            
            if( $scope.filtro.tipoProveedores==1 ){
                return "<b>Total: </b>"+sT + ", Formales: "+sF+", Informales: "+sI;
            }
            else if( $scope.filtro.tipoProveedores==2 ){
                return "<b>Formales: </b>"+sF;
            }
            else{
                return "<b>Informales: </b>"+sI;
            }
        }
        
        $scope.getCantidadPorCategoria = function(id){
            
            var sT = 0;
            var sF = 0;
            var sI = 0;
            
            for (var i = 0; i < $scope.proveedores.length; i++) {
                
                if( $scope.proveedores[i].idcategoria==id ){  
                    sT+=1;  
                    if($scope.proveedores[i].rnt){ sF+=1; }
                    else{ sI+=1; }
                }
            }
            
            if( $scope.filtro.tipoProveedores==1 ){
                return "<b>Total: </b>"+sT  + ", Formales: "+sF+", Informales: "+sI+"";
            }
            else if( $scope.filtro.tipoProveedores==2 ){
                return "<b>Formales: </b>"+sF;
            }
            else{
                return "<b>Informales: </b>"+sI;
            }
            
        }
        
        $scope.getCantidadPorEstado = function(id){
            
            var s = 0;
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].idestado==id ){  s+=1;  }
            }
            return s;
        }
        
        $scope.getCantidadPorMunicipio = function(id){
            
            var sT = 0;
            var sF = 0;
            var sI = 0;
            
            for (var i = 0; i < $scope.proveedores.length; i++) {
                if( $scope.proveedores[i].municipio_id==id ){  
                    sT+=1;  
                    if($scope.proveedores[i].rnt){ sF+=1; }
                    else{ sI+=1; }
                }
            }
            
            if( $scope.filtro.tipoProveedores==1 ){
                return "<b>Total: </b>"+sT + ", Formales: "+sF+", Informales: "+sI;
            }
            else if( $scope.filtro.tipoProveedores==2 ){
                return "<b>Formales: </b>"+sF;
            }
            else{
                return "<b>Informales: </b>"+sI;
            }
        }
        
        $scope.getCantidadPorSector = function(id){
            
            var sT = 0;
            var sF = 0;
            var sI = 0;
            
            for (var i = 0; i < $scope.dataPerido.zonas.length; i++) { 
                if($scope.dataPerido.zonas[i].sector_id==id){
                    for (var j = 0; j < $scope.proveedores.length; j++) {
                        var point = new google.maps.LatLng( $scope.proveedores[j].latitud , $scope.proveedores[j].longitud );
                        if( google.maps.geometry.poly.containsLocation( point , $scope.map.shapes[i] ) ){
                            sT+=1;  
                            if($scope.proveedores[i].rnt){ sF+=1; }
                            else{ sI+=1; }
                        }
                    }
                }
            }
            
            if( $scope.filtro.tipoProveedores==1 ){
                return "<b>Total: </b>"+sT + ", Formales: "+sF+", Informales: "+sI;
            }
            else if( $scope.filtro.tipoProveedores==2 ){
                return "<b>Formales: </b>"+sF;
            }
            else{
                return "<b>Informales: </b>"+sI;
            }
        }
        
        
        NgMap.getMap().then(function(map) { 
            $scope.map = map;
           
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({
              strokeColor: 'red',
              strokeWeight: 1,
              fillOpacity:0,
              clickable:false
            });
            
        });
        
        
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
        
    }])
     
  
    .directive('htmldiv', function($compile, $parse) {
        return {
          restrict: 'E',
          link: function(scope, element, attr) {
            scope.$watch(attr.content, function() {
              element.html($parse(attr.content)(scope));
              $compile(element.contents())(scope);
            }, true);
          }
        }
    });
    
}());