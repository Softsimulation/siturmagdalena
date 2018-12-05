(function(){
 
    angular.module("InformacionServices",[])
    .factory('InformacionServi', ['$http', '$q', function($http,$q) {
      
      
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
            },
            
            postFile: function (url,data) {
                var defered = $q.defer();
                var promise = defered.promise;
    
                $http.post(url, data, { transformRequest: angular.identity, headers: { 'Content-Type': undefined } }
                ).success(function (data) {
                    defered.resolve(data);
                }).error(function (err) {
                    defered.reject(err);
                })
                return promise;
            },
      };
      
      return {
            
        getData: function(id){ return http.get("/InformacionDepartamento/data/"+id );  },
        guardar: function(data){ return http.post("/InformacionDepartamento/guardar", data);  },
        guardarvideo: function(data){ return http.post("/InformacionDepartamento/guardarvideo", data);  },
        
        guardarGaleria: function(fd){ return http.postFile("/InformacionDepartamento/guardargaleria",fd);  },
        eliminarImagen: function(id){ return http.post("/InformacionDepartamento/eliminarimagen",{ id:id});  },
        
      };
      
      
    }]);
    
    
}())