var pp=angular.module('admin.exportaciones', ['adminservice','angularUtils.directives.dirPagination','ADM-dateTimePicker'])

.controller('ExportacionCtrl', ['$scope', 'adminService',function ($scope, adminService) {

    $scope.exportaciones=[];
    
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };
    
    $scope.exportar=function(){
        
        $scope.exportacion={};
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $('#exportacion').modal();
        
    }
    
    $scope.guardar=function(){
        
        if(!$scope.addForm.$valid){
            
            swal("Error","Hay errores en el formulario","error");
            return;
        }
        
        $scope.errores=null
        $("body").attr("class", "cbp-spmenu-push charging");
        adminService.Exportar($scope.exportacion)
            .then(function(data){
                $("body").attr("class", "cbp-spmenu-push");
                if(data.success){
                    
                    swal({
                          title: "Realizado",
                          text: "Exportación realizada exitosamente",
                          type: "success",
                          showCancelButton: true,
                          confirmButtonColor: "#8CD4F5",
                          confirmButtonText: "Descargar",
                          closeOnConfirm: true,
                          html: false
                        }, function(){
                            
                            var link = document.createElement("a");
                             //link.download = 'Exportacion.xlsx';
                             link.href = data.url;
                             document.body.appendChild(link);
                             link.click();
                             document.body.removeChild(link);
                            
                          
                        });
                    
                    
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
