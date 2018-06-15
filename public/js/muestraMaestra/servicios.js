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
            } 
      };
      
      return {
          
          
          getData: function(id){ return http.get("/MuestraMaestra/datacongiguracion/"+id);  },
          
          getListadoPeridos: function(){ return http.get("/MuestraMaestra/datalistado");  },
          
          guardarPeriodo: function(data){ return http.post("/MuestraMaestra/guardarperiodo", data);  },
          
          guardarZona: function(data){ return http.post("/MuestraMaestra/guardarzona", data);  },
        }
        
    }]);
    
    
}())