angular.module('ofertaPst.alquilarTransporte', ["checklist-model","ofertaService"])


.controller('seccionAlquiler', function ($scope, ofertaServiPst) {

    
    $scope.alquiler = {};
    $scope.estadoEncuesta = null;
    $scope.$watch('id', function () {
        if($scope.id != undefined){
            $("body").attr("class", "cbp-spmenu-push charging");
            ofertaServiPst.getDatosAlquilerVehiculo($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.alquiler = data.alquiler;
                if($scope.alquiler != null){
                $scope.alquiler.Comercial = data.alquiler.Comercial+'';
                }
                $scope.proveedor = data.proveedor;
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
        ofertaServiPst.guardarCaracterizacionAlquilerVehiculo($scope.alquiler).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push")
            if (data.success) {
           $("body").attr("class", "cbp-spmenu-push")
                
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
                          window.location.href = '/ofertaempleo/ofertalquilervehiculo/'+$scope.id;
                      }
                    
                  } else {
                    window.location = "ruta";
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

.controller('ofertaAlquiler', function ($scope, ofertaServiPst) {

    
    $scope.alquiler = {};
    $scope.estadoEncuesta = null;
    $scope.$watch('id', function () {
        if($scope.id != undefined){
            $("body").attr("class", "cbp-spmenu-push charging");
            ofertaServiPst.getDatosAlquilerVehiculoOferta($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.alquiler = data.alquiler;
               $scope.proveedor = data.proveedor;
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
        ofertaServiPst.guardarOfertaAlquilerVehiculo($scope.alquiler).then(function (data) {
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