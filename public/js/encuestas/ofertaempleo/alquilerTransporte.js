angular.module('oferta.alquilarTransporte', ["checklist-model","ofertaService"])


.controller('seccionAlquiler', function ($scope, ofertaServi) {

    
    $scope.alquiler = {};
    $scope.estadoEncuesta = null;
    $scope.$watch('id', function () {
        if($scope.id != undefined){
            $("body").attr("class", "cbp-spmenu-push charging");
            ofertaServi.getDatosAlquilerVehiculo($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.alquiler = data.alquiler;
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });    
        }
    });

    $scope.guardar = function () {
        $scope.solicitud = null;
        if (!$scope.AlquilerForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return
        }
        if ($scope.alquiler.VehiculosAlquiler < $scope.alquiler.PromedioDia) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return
        }
        $("body").attr("class", "cbp-spmenu-push charging")
        $scope.alquiler.id = $scope.id;
       
        

        $("body").attr("class", "cbp-spmenu-push charging");
        ofertaServi.guardarCaracterizacionAlquilerVehiculo($scope.alquiler).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push")
            if (data.success) {
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
            } else {
                $scope.errores = data.errores
                swal("Error", "Verifique la información.", "error")
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });

    }

})
