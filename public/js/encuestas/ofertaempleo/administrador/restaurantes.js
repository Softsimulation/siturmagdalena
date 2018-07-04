var situr = angular.module("admin.restaurante", []);

situr.controller('caracterizacionAlimentosCtrl', ['$scope','restauranteServi', function ($scope,restauranteServi) {

    $scope.alimentos = {}
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");    
        restauranteServi.getInfoAlimentosC($scope.id).then(function (dato) {
            $scope.actividades_servicios = dato.actividades_servicios;
            $scope.especialidades = dato.especialidades;
            if (dato.provision != null) {
                $scope.alimentos = dato.provision;
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    })
    
    $scope.guardar = function () {
        if (!$scope.carAlim.$valid) {
            return
        }

        $scope.alimentos.id = $scope.id
        $("body").attr("class", "charging"); 
        restauranteServi.GuardarCarAlimentos($scope.alimentos).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Se ha guardado satisfactoriamente la sección.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location.href = "/ofertaempleo/capacidadalimentos/" + $scope.id;
                }, 1000);
            } else {
                $scope.errores = data.errores
                swal("Error", "Verifique la información.", "error")
            }
            
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }

}]);

situr.controller('capacidadAlimentosCtrl', ['$scope','restauranteServi', function ($scope,restauranteServi) {

    $scope.alimentos = {}

    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        restauranteServi.getInfoCapAlimentos($scope.id).then(function (data) {
            if (data.capacidad != null) {
                $scope.alimentos = data.capacidad
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    })
    
    $scope.guardar = function () {
        if (!$scope.capacidadForm.$valid) {
            return
        }

        $scope.alimentos.id = $scope.id
        
        $("body").attr("class", "charging");
        restauranteServi.GuardarOfertaAlimentos($scope.alimentos).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Se ha guardado satisfactoriamente la sección.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location.href = "/ofertaempleo/empleomensual/" + $scope.id;
                }, 1000);
            } else {
                $scope.errores = data.errores
                swal("Error", "Verifique la información.", "error")
            }
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        })

    }
}])