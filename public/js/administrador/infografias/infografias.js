var pp=angular.module('admin.infografias', ['infografiasservice'])

.controller('Infografiactrl', ['$scope', 'adminService',function ($scope, adminService) {

    $scope.exportaciones=[];
     $("body").attr("class", "cbp-spmenu-push charging");
    adminService.getDatos()
        .then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            $scope.meses=data.meses;
            $scope.anios=data.anios;
            
        })
        .catch(function(){
             $("body").attr("class", "cbp-spmenu-push");
           swal("Error","No se pudo cargar la informacion, intentalo nuevamente","error"); 
        });
    
  
    
    
    
    
    
    
    $scope.generar=function(){
        
        if(!$scope.addForm.$valid){
            
            swal("Error","Hay errores en el formulario, selecciona los dos campos","error");
            return;
        }
        
        $scope.errores=null
        $("body").attr("class", "cbp-spmenu-push charging");
        adminService.Generar($scope.infografia)
            .then(function(data){
                $("body").attr("class", "cbp-spmenu-push");
                if(data.success){
                    
                   $scope.datoinfografia=data.datos;
                    
                }else{
                    $scope.errores=data.errores;
                    swal("Error","Corrija los errores","success");
                }
                
            })
            .catch(function(){
                 $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
        
    }
    
    
    

}])
