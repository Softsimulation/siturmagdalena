(function(){
 
    angular.module("InformesServices",[])
    .factory('informesServi', ['$http', '$q', function($http,$q) {
      
      
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
            
        getData: function(){ return http.get("/informes/dataconfiguracion");  },
        guardarIdioama: function(data){ return http.post("/informes/guardaridioama", data);  },
        cambiarEstado: function(id){ return http.post("/informes/cambiarestado", {id:id} );  },
        eliminarIdioma: function(data){ return http.post("/informes/eliminaridioma", data );  },
        
      
      };
      
      
    }]);
    
    
}())