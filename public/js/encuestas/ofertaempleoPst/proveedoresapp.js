angular.module('proveedoresofertaPst', ["checklist-model","proveedorServicesPst",'angularUtils.directives.dirPagination'])

.controller('listado', ['$scope', 'proveedorServiPst',function ($scope, proveedorServiPst) {
   
     $("body").attr("class", "cbp-spmenu-push charging");
        
    proveedorServiPst.CargarListado().then(function(data){
                                 $("body").attr("class", "cbp-spmenu-push");
                                $scope.proveedores = data.proveedores;
                               
                }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });   
   

   
}])

.controller('listadoecuesta', ['$scope', 'proveedorServiPst',function ($scope, proveedorServiPst) {
   
      $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        proveedorServiPst.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
   
   
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServiPst.getEncuestas($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.encuestas = data.encuestas;
            $scope.ruta = data.ruta;
            $scope.ruta2 = data.ruta2;
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
   

   
}])

