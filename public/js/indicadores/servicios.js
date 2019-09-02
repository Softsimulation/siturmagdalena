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
            
			
            http.get("/indicadores/datapivotable/"+indicador)
                .then(function(data){
                    
                    if( !data ){
                        $("#content-main .nav-tabs a:last").css("display", 'none');
                    }
                    else if( data.length==0 ){
                        $("#content-main .nav-tabs a:last").css("display", 'none');
                    }
                    else{
                        
                        $("#content-main .nav-tabs a:last").css("display", 'block');
                        
						var aggregators = {};
            
            
						var promedioSitur = $.pivotUtilities.aggregatorTemplates.promedioSitur;
						var promedioDia = $.pivotUtilities.aggregatorTemplates.promedioDia;
						var porcentaje = $.pivotUtilities.aggregatorTemplates.fractionOf;
						var sum = $.pivotUtilities.aggregatorTemplates.sum;				
						var floatFormat = $.pivotUtilities.numberFormat({ digitsAfterDecimal: 2 });
                
						/* var aggregators = {
										"Noches": function () { return promedioSitur()(["cantidad"]) },
										"COP": function () { return promedioSitur()(["cantidad"]); },
										"%": function () { return porcentaje(sum(), "total", null)(["cantidad"]) },
										"COP por día": function () { return promedioDia()(["Cantidad_Dia"]); },
							}; */										
					
						if(indicador==1){
							aggregators = { "%": function () { return porcentaje(sum(), "total", null)(["cantidad"]) } };
						}
						else if(indicador==2){
							aggregators = { "%": function () { return porcentaje(sum(), "total", null)(["cantidad"]) } };
						}
						else if(indicador==3){
							aggregators = { "%": function () { return porcentaje(sum(), "total", null)(["cantidad"]) } };
						}
						else if(indicador==4){
							aggregators = { "COP": function () { return promedioSitur()(["cantidad"]); } };
						}
						else if(indicador==5){
							aggregators = { "COP": function () { return promedioSitur()(["cantidad"]); } };
						}
						else if(indicador==6){
							aggregators = { "Noches": function () { return promedioSitur()(["cantidad"]) } };
						}
												
                        $("#tablaDinamica").pivotUI(data, {
                            onRefresh: function (config) { config.rows = []; config.cols = []; },
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