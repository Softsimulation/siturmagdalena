(function(){
 
    angular.module("indicadoresServices",[])
    .factory('indicadoresServi', ['$http', '$q', function($http,$q) {
      
      
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
            
        getDataIndicador: function(id){ return http.get("/indicadores/dataindicador/"+id);  },
        filtrarDataIndicador: function(data){ return http.post("/indicadores/filtrardataindicador", data);  },
        
        getDataSecundarios: function(id){ return http.get("/indicadores/datasencundarios/"+id);  },
        filtrarDataSecundarias: function(data){ return http.get("/indicadores/filtrardatasecundaria/"+ data.indicador+ "/"+ data.year );  },
      
      };
      
      
    }]);
    
    
}())