(function(){
 
    angular.module("EstadisticasSecuentariasServices",[])
    .factory('estadisticasSecundariasServi', ['$http', '$q', function($http,$q) {
      
      
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
            } 
      };
      
      return {
            
        getDataConfiguracion: function(){ return http.get("/Estadisticassecundarias/dataconfiguracion");  },
        
        guardarData: function(data){ return http.post("/Estadisticassecundarias/guardardata", data);  },
        guardarIndicador: function(data){ return http.post("/Estadisticassecundarias/guardarindicador", data);  },
        
        eliminarIndicador: function(data){ return http.post("/Estadisticassecundarias/eliminarindicador", data);  },
        cambiarEstadoIndicador: function(data){ return http.post("/Estadisticassecundarias/cambiarestadoindicador", data);  },
        
      };
      
      
    }]);
    
    
}())