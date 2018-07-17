var app = angular.module('appEncuestaAlojamiento', ["OfertaEmpleoServices"] );

app.controller("CaracterizacionAlojamientoCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:{}, apartamentos:{}, casas:{}, cabanas:{}, campins:{} };
    
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
    
    
    $scope.guardar = function(){
        
        if(!$scope.carForm.$valid){
            swal("Error","Corrija los errores","error");  return;
        }
        
        
        $scope.ErrorServicio = false;
        var sw = true;
        for ( var name in $scope.servicios ) {
          if($scope.servicios[name]==true){ sw = false; }
        }
        if(sw){
            $scope.ErrorServicio = true;
            swal("Error","Corrija los errores","error");  return;
        }
      
        var data = angular.copy($scope.alojamiento);
        data.encuesta = $("#id").val();
        data.servicios = angular.copy($scope.servicios);
        
        OfertaEmpleoServi.guardarCaracterizacionAlojamiento( data ).then(function(data){
            
            if(data.success){
                window.location.href = "/ofertaempleo/oferta/" + $("#id").val();
            }
            else{
                $scope.errores = data.errores;
                swal("Error","Corrija los errores","error");
            }
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
        
    }
    
});

app.controller("OfertaAlojamientoCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:[], apartamentos:[], casas:[], cabanas:[], campins:[] };
    
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
    
    
    $scope.guardar = function(){
        
        if(!$scope.AlojamientoForm.$valid){
            swal("Error","Corrija los errores","error");  return;
        }
        
        var data = angular.copy($scope.alojamiento);
        data.encuesta = $("#id").val();
        data.servicios = angular.copy($scope.servicios);
        
        OfertaEmpleoServi.guardarOfertaAlojamiento( data ).then(function(data){
            
            if(data.success){
                window.location.href = "/ofertaempleo/empleomensual/" + $("#id").val();
            }
            else{
                $scope.errores = data.errores;
                swal("Error","Corrija los errores","error");
            }
            
            $scope.servicios = data.servicios;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(){
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error","Error en la carga de pagina","error"); 
        });
        
    }
    
});
