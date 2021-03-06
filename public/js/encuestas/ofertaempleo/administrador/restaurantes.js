var situr = angular.module("admin.restaurante", []);

situr.controller('caracterizacionAlimentosCtrl', ['$scope','restauranteServi', function ($scope,restauranteServi) {

    $scope.alimentos = {}
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");    
        restauranteServi.getInfoAlimentosC($scope.id).then(function (dato) {
            $scope.proveedor = dato.proveedor;
            $scope.actividades_servicios = dato.actividades_servicios;
            $scope.especialidades = dato.especialidades;
            if (dato.provision != null) {
                $scope.alimentos = dato.provision;
                $scope.alimentos.Comercial = dato.encuesta.Comercial+"";
                $scope.alimentos.NumeroDias = dato.encuesta.NumeroDias;
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
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: data.oferta == true ? "Oferta" : "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                      if(!data.oferta){
                          window.location.href = '/ofertaempleo/empleomensual/'+$scope.id;
                      }else{
                          window.location.href = '/ofertaempleo/capacidadalimentos/'+$scope.id;
                      }
                    
                  } else {
                    window.location = "/ofertaempleo/encuestas/"+data.sitio;
                  }
                });
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
                $scope.proveedor = data.proveedor;
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
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        })

    }
}])