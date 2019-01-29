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
          
          
          validarProveedoresFueraZona: function(markersProveedores,sharpesAndPopus){
                
                var defered = $q.defer();
                var promise = defered.promise;
                
                var proveedoresFuera = []; 
                var sw = false;
                
                for(var k=0; k<markersProveedores.length; k++){
                    
                    sw = false;
                    
                    for(var i=0; i<sharpesAndPopus.length; i++){
                       if( google.maps.geometry.poly.containsLocation( markersProveedores[k].position , sharpesAndPopus[i].sharpe ) ){ sw = true; break; }
                    }
                    
                    if(sw==false){
                        proveedoresFuera.push( markersProveedores[k].dataProveedor );
                    }
                    
                }
                
                defered.resolve(proveedoresFuera); 
            
                return promise; 
            }
          
          
        }
        
    }]);
    
    
}())