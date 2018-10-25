var app = angular.module('appEncuestaAlojamiento', ["OfertaEmpleoServices"] );

app.controller("CaracterizacionAlojamientoCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:{}, apartamentos:{}, casas:{}, cabanas:{}, campins:{} };
    
    
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $scope.encuesta = data.encuesta;
            if($scope.encuesta.actividad_comercial==0 || $scope.encuesta.actividad_comercial==1){
                $scope.encuesta.actividad_comercial = $scope.encuesta.actividad_comercial+"";
            }
            
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
        data.encuesta = angular.copy($scope.encuesta);
        data.servicios = angular.copy($scope.servicios);
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        OfertaEmpleoServi.guardarCaracterizacionAlojamiento( data ).then(function(data){
            
            if(data.success){
                   $("body").attr("class", "cbp-spmenu-push")
                
                swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Oferta",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                
                          window.location.href = '/ofertaempleo/oferta/'+$scope.encuesta.id;
                      
                    
                  } else {
                    window.location.href = data.ruta;
                  }
                });
                
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
    $scope.numero_dias = 0;
     
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $scope.numero_dias = data.encuesta.numero_dias;
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
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        OfertaEmpleoServi.guardarOfertaAlojamiento( data ).then(function(data){
            
            if(data.success){
                      swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    window.location.href = '/ofertaempleo/empleomensual/'+$scope.id;
                  } else {
                    window.location.href = data.ruta;
                  }
                });
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

app.controller("AlojamientoMensualCtrl", function($scope, OfertaEmpleoServi){
    
    $scope.alojamiento = { habitaciones:[], apartamentos:[], casas:[], cabanas:[], campins:[] };
    $scope.numero_dias = 0;
     
    $("body").attr("class", "cbp-spmenu-push charging");
    
    OfertaEmpleoServi.getDataAlojamiento( $("#id").val() ).then(function(data){
            
            if(data.alojamiento){
                $scope.alojamiento = data.alojamiento;
            }
            
            $scope.servicios = data.servicios;
            $scope.numero_dias = data.encuesta.numero_dias;
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
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        OfertaEmpleoServi.guardarAlojamientoMensual( data ).then(function(data){
            
            if(data.success){
                          swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    window.location.href = '/ofertaempleo/empleomensual/'+$scope.id;
                  } else {
                    window.location.href = data.ruta;
                  }
                });
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
