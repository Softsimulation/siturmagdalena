(function(){
 
    angular.module("serviciosAdmin",[])
    .factory('ServiEncuesta', ['$http', '$q', function($http,$q) {
      
      
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
          
          
        ///// listado de encuestas dinamicas
        getListadoEncuestas: function(){ return http.get("/encuesta/listadoencuestasdinamicas");  },
        guardarIdiomaEncuesta: function(data){ return http.post("/encuesta/guardaridiomaencuesta", data );  },
        cambiarEstadoEncuesta: function(data){ return http.post("/encuesta/cambiarestadoencuesta", data );  },
        agregarEncuesta: function(data){ return http.post("/encuesta/agregarencuesta", data );  },
        //activarDesactivarEncuesta: function(data){ return http.post("/encuesta/activarDesactivarEncuesta", data );  },
        //eliminarEncuesta: function(data){ return http.post("/encuesta/eliminarEncuesta", data );  },
        
        
        
        
        getData: function(id){ return http.get("/encuesta/dataconfiguracion/"+id);  },
        agregarSeccion: function(data){ return http.post("/encuesta/agregarseccion", data );  },
        agregarPregunta: function(data){ return http.post("/encuesta/agregarpregunta", data );  },
        activarDesactivarPregunta: function(data){ return http.post("/encuesta/activardesactivarpregunta", data );  },
        eliminarPregunta: function(data){ return http.post("/encuesta/eliminarpregunta", data );  },
        
        guardarOrdenPreguntas: function(data){ return http.post("/encuesta/guardarordenpreguntas", data );  },
        guardarIdiomaPregunta: function(data){ return http.post("/encuesta/guardaridiomapregunta", data );  },
        guardarOpcionPregunta: function(data){ return http.post("/encuesta/agregaropcionpregunta", data );  },
        eliminarOpcionPregunta: function(data){ return http.post("/encuesta/eliminaropcionpregunta", data );  },
        
        
        
        getDataSeccionEncuesta: function(data){ return http.post("/encuesta/dataseccionencuestausuarios", data );  },
        guardarEncuesta: function(data){ return http.post("/encuesta/guardarencuestausuarios", data );  },
        
        
        getListadoEncuestasRealidadas: function(id){ return http.get("/encuesta/listadoencuestas/"+id);  },
        agregarencuestausuario: function(data){ return http.post("/encuesta/agregarencuestausuario", data);  },
        
        
        registroUsuarioEncuesta: function(data){ return http.post("/encuesta/registrousuarioencuesta", data );  },
        
        
        estadisticasencuesta: function(id){ return http.get("/encuesta/estadisticasencuesta/"+id);  },
        
      };
      
      
    }]);
    
    
}())