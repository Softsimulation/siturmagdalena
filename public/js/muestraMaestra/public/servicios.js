(function(){
 
    angular.module("serviciosMuestraMaestra",[])
    .factory('ServiMuestra', ['$http', '$q', function($http,$q) {
      
      
      var http = {
          
            post: function (url,data) { return this.peticion("POST",url,data); },
             
            get: function(url){ return this.peticion("GET",url,null); },
            
            peticion: function(metodo, url, data){
                var defered = $q.defer();
                var promise = defered.promise;
                $http({  method : metodo,  url : url,  data : data })
                .success(function (data) {  defered.resolve(data); })
                .error(function(err){  });  
                return promise; 
            } ,
            
            getFile: function(url){
                var defered = $q.defer();
                var promise = defered.promise;
                $http({  method : "GET",  url : url, responseType: 'blob'  })
                .success(function (data) {  defered.resolve(data); })
                .error(function(err){  });  
                return promise; 
            } 
      };
     
      return {
          
          
          getData: function(id){ return http.get("/MuestraMaestra/datacongiguracion/"+ (id ? id : -1) ); },
          
          getListadoPeridos: function(){ return http.get("/MuestraMaestra/datalistado");  },
          
          crearPeriodo: function(data){ return http.post("/MuestraMaestra/crearperiodo", data);  },
          
          editarPeriodo: function(data){ return http.post("/MuestraMaestra/editarperiodo", data);  },
          
          agregarZona: function(data){ return http.post("/MuestraMaestra/agregarzona", data);  },
          
          editarZona: function(data){ return http.post("/MuestraMaestra/editarzona", data);  },
          
          editarPosicionZona: function(data){ return http.post("/MuestraMaestra/editarposicionzona", data);  },
          
          eliminarZona: function(data){ return http.post("/MuestraMaestra/eliminarzona", data);  },
          
          
          getGeoJson: function(id){ return http.get("/MuestraMaestra/geojsonzone/"+id );  },
          getExcel: function(id){ return http.getFile("/MuestraMaestra/excel/"+id );  },
          getExcelGeneral: function(id){ return http.getFile("/MuestraMaestra/excelinfoperiodo/"+id );  },
          
          getDataLLenarInfoZona: function(id){ return http.get("/MuestraMaestra/datazonallenarinfo/"+ (id ? id : -1) );  },
          guardarDataInfoZona: function(data){ return http.post("/MuestraMaestra/guardarinfozona", data );  },
          getExcelZona: function(id){ return http.getFile("/MuestraMaestra/excelinfozona/"+id );  },
          
          
          agregarProveedorInformal: function(data){ return http.post("/MuestraMaestra/guardarproveedorinformal", data );  },
          editarPosicionProveedor: function(data){ return http.post("/MuestraMaestra/editarubicacionproveedor", data);  },
          
          
          validarProveedoresFueraZona: function(pro, zn){
                var defered = $q.defer();
                
                var proveedores = angular.copy(pro);
                var zonas = angular.copy(zn);
                
                var promise = defered.promise;
                
                for(var k=0; k<zonas.length; k++){
                    
                    for (var i = 0; i<zonas[k].coordenadas.length; i++ ) {
                        zonas[k].coordenadas[i] = { lat: zonas[k].coordenadas[i][0] , lng: zonas[k].coordenadas[i][1] };    
                    }
                    zonas[k].polygono = new google.maps.Polygon({paths: zonas[k].coordenadas});
                }
                
                var proveedoresFuera = []; 
                
                for(var k=0; k<proveedores.length; k++){
                    
                    var point = new google.maps.LatLng( proveedores[k].latitud , proveedores[k].longitud );
                    var sw = false;
                    
                    for(var i=0; i<zonas.length; i++){
                       if( google.maps.geometry.poly.containsLocation( point , zonas[i].polygono ) ){
                          sw = true; break;
                       }
                        
                    }
                    
                    if(sw==false){
                        proveedoresFuera.push( proveedores[k] );
                    }
                    
                }
                
                defered.resolve(proveedoresFuera); 
            
         
                return promise;      
            }
          
          
        }
        
    }]);
    
    
}())