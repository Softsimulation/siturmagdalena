    angular.module('AppMapa', [ 'ngMap', 'MapaServices', 'checklist-model' ])
    
    .controller('mapa', ['$scope', '$timeout', 'NgMap', 'mapaServi', function ($scope, $timeout, NgMap, mapaServi) {
        
        $scope.filtro = { tipoProveedor:[], tipoAtraciones:[] };
        
        var numTipo = 0;
        var numZoom = 8;
        //limites items a visualizar
        $scope.limiteAtr = 8;
        $scope.limiteDest = 0;
        $scope.limiteProv = 0;

        
        mapaServi.getData()
                .then(function(data){
                    $scope.tipoProveedores = data.tipoProveedores;
                    $scope.tipoAtracciones = data.tipoAtracciones;
                    $scope.destinos = data.destinos;
                    $scope.atracciones = data.atracciones;
                    $scope.proveedoresData = data.proveedores;
                    
                    $scope.limiteDest = $scope.destinos.length;
                    $scope.changeIcons();
                });
    
        $scope.dynMarkers = []
        NgMap.getMap().then(function (map) {
            $scope.map = map;
            $scope.map.data.loadGeoJson('/js/muestraMaestra/depto.json');
            $scope.map.data.setStyle({ strokeColor: 'red', strokeWeight: 1, fillOpacity:0, clickable:false });
            
            $scope.zoomChanged = function (event) {
                numZoom = map.getZoom();
                $scope.changeIcons();
            }
            
        });
        
        
        $scope.changeIcons = function (event) {
            var limiteCerca, limiteLejos;
            $scope.proveedores = [];
            $scope.limiteProv = 0;

            if (numZoom <= 8) {
                limiteCerca = 3;
                limiteLejos = 8;
                $scope.limiteAtr = 8;
            } else if (numZoom > 8 && numZoom <= 10) {
                limiteCerca = 5;
                limiteLejos = 13;
                $scope.limiteAtr = 13;
            } else if (numZoom > 10 && numZoom <= 12) {
                limiteCerca = 8;
                limiteLejos = 18;
                $scope.limiteAtr = 18;
            } else if (numZoom > 12 && numZoom <= 15) {
                limiteCerca = 10;
                limiteLejos = 25;
                $scope.limiteAtr = 25;
                $scope.limiteDest = $scope.destinos.length;
            }

            if (numZoom <= 15) {
                
                for (var i = 0; i < $scope.atracciones.length; i++) {
                    if (i < limiteCerca) {
                        $scope.atracciones[i]['icono'] = "/Content/icons/maps/historico-cerca.png";
                    } 
                    else if (i < limiteLejos) {
                        $scope.atracciones[i]['icono'] = "/Content/icons/maps/historico-lejos.png";
                    } else {  break; }
                }

                for (var i = 0; i < $scope.tipoProveedores.length; i++) {
                    if ( $scope.filtro.tipoProveedor.indexOf( $scope.tipoProveedores[i].id)!=-1) {
                        var cont = 0;
                        for (var j = 0; j < $scope.proveedoresData.length; j++) {
                            if ($scope.proveedoresData[j].categoria.tipo_proveedores_id == $scope.tipoProveedores[i].id) {
                                if (cont < limiteCerca) {
                                    $scope.proveedoresData[j]['icono'] = $scope.tipoProveedores[i].icono_cerca;
                                } 
                                else if (cont < limiteLejos) {
                                    $scope.proveedoresData[j]['icono'] = $scope.tipoProveedores[i].icono_lejos;
                                } else { break; }
                                
                                $scope.proveedores.push($scope.proveedoresData[j]);
                                cont++;
                            }
                        }
                        $scope.limiteProv += cont;
                    }
                }
            }else {
                $scope.limiteDest = 0;
                $scope.limiteAtr = $scope.atracciones.length;
                $scope.limiteProv = 0;

                for (var i = 0; i < $scope.atracciones.length; i++) {
                    $scope.atracciones[i]['icono'] = "/Content/icons/maps/historico-cerca.png";
                }
                
                
                for (var i = 0; i < $scope.tipoProveedores.length; i++) {
                    if ( $scope.filtro.tipoProveedor.indexOf( $scope.tipoProveedores[i].id)!=-1) {
                        var cont = 0;
                        for (var j = 0; j < $scope.proveedoresData.length; j++) {
                            if ($scope.proveedoresData[j].categoria.tipo_proveedores_id == $scope.tipoProveedores[i].id) {
                                $scope.proveedoresData[j]['icono'] = $scope.tipoProveedores[i].icono_cerca;
                                $scope.proveedores.push($scope.proveedoresData[j]);
                                cont++;
                            }
                        }
                        $scope.limiteProv += cont;
                    }
                }
                
            }
        }
        
        
        $scope.getIconoProveedor = function(id){
            for(var i=0; i<$scope.tipoProveedores.length; i++){
                if(id == $scope.tipoProveedores[i].id ){  return $scope.tipoProveedores[i].icono_cerca;   }
            }
            return null;
        }
    

        //muestra la información de la entidad
        $scope.showInfo = function (event, id, nombre, portada, url) {
            
            $scope.detalle = {
                id: id,
                nombre: nombre,
                portada: portada,
                url: url
            };
            
            $scope.showInfoEntidad = true;
            if (numZoom < 15) {
                $scope.map.setZoom(15);
                $scope.map.setCenter(this.getPosition());
            }
          
        };

        
        $scope.filterAtracciones = function(atr){
            
            if($scope.filtro.tipoAtraciones.length==0){ return true; }
            
            for(var i=0; i<atr.atracciones_con_tipos.length; i++){
                if( $scope.filtro.tipoAtraciones.indexOf( atr.atracciones_con_tipos[i].id )!=-1 ){
                    return true;
                }
            }
            
            return false;
        }
        
        $scope.filterProveedores = function(prov){
            return $scope.filtro.tipoProveedor.indexOf(prov.categoria.tipo_proveedores_id)!=-1;
        }
        
    }
]);


