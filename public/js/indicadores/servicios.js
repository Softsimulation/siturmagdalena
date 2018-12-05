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
        
        
        getDataPivoTable: function(indicador){
            
            
            if(indicador==1 || indicador==2 || indicador==4 || indicador==4 || indicador==5){
                
                var floatFormat = $.pivotUtilities.numberFormat({ digitsAfterDecimal: 2 });
                
                var aggregators = {
                                    "Noches":   function () { return $.pivotUtilities.aggregatorTemplates.average()(["cantidad"]) },
                                    "COP":      function () { return $.pivotUtilities.aggregatorTemplates.average()(["cantidad"]) },
                                    "%":        function () { return $.pivotUtilities.aggregatorTemplates.sum(floatFormat)(["cantidad"]) },
                                    "Personas": function () { return $.pivotUtilities.aggregatorTemplates.average()(["cantidad"]) },
                                    "Nights":   function () { return $.pivotUtilities.aggregatorTemplates.average()(["cantidad"]) },
                                    "People":   function () { return $.pivotUtilities.aggregatorTemplates.average()(["cantidad"]) }
                                 };
            }
            
            http.get("/indicadores/datapivotable/"+indicador)
                .then(function(data){
                    if(data){
                        
                        $("#tablaDinamica").pivotUI(data, {
                            onRefresh: function (config) {
                                config.rows = [];
                                config.cols = [];
                            },
                            aggregators: aggregators,
                            hiddenAttributes: ["cantidad"],
                            renderers: $.extend( $.pivotUtilities.renderers, $.pivotUtilities.c3_renderers, $.pivotUtilities.d3_renderers ),
                            rendererName: "Tabla"
                        });
                    }    
                });
            
        }
        
      };
      
      
    }]);
    
    
}())