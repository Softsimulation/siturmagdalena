angular.module('ofertaPst.agenciasOperadoras', ["checklist-model","ofertaServicePst"])


.controller('ocupacioncAgencias', function ($scope, ofertaServiPst) {
    $scope.agencia = {
        actividades: [],
        toures: []
    }

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        ofertaServiPst.getOcuacionOperadora($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push")
            $scope.agencia = data.prestamo;
            $scope.proveedor = data.proveedor;
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });
    })

    $scope.guardar = function () {
        if (!$scope.ocupacionForm.$valid || ($scope.agencia.porcentajeC + $scope.agencia.porcentajeE + $scope.agencia.porcentajeM) != 100) {
            return
        }

        $scope.agencia.id = $scope.id;
        
        $("body").attr("class", "cbp-spmenu-push charging");
        ofertaServiPst.guardarOcupacionOperadora($scope.agencia).then(function (data) {
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

.controller('caracterizacionAgencia', function ($scope, ofertaServiPst) {

    $scope.agencia = {
        actividades: [],
        toures: []
    }

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        ofertaServiPst.getinfoCaracterizacionOperadora($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.actividades = data.actividades;
            $scope.toures = data.toures;
            if (data.retornado != null) {
                $scope.agencia = data.retornado;
                $scope.agencia.Comercial = data.retornado.Comercial+'';
                $scope.proveedor = data.proveedor;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })

    $scope.validarOtro = function (sw) {
        if (sw == 0) {
            if ($scope.agencia.otraD != '' && $scope.agencia.otraD != null) {
                if ($scope.agencia.actividades.indexOf(15) == -1) {
                    $scope.agencia.actividades.push(15)
                }
            }
        } else {
            if (sw == 1) {
                if ($scope.agencia.otroT != '' && $scope.agencia.otroT != null) {
                    if ($scope.agencia.toures.indexOf(14) == -1) {
                        $scope.agencia.toures.push(14)
                    }
                }
            }
        }
    }

    $scope.guardar = function () {
        if (!$scope.carForm.$valid || $scope.agencia.actividades.length == 0 || $scope.agencia.toures.length == 0) {
            return
        }

        $scope.agencia.id = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        ofertaServiPst.guardarCaracterizacionOperadora($scope.agencia).then(function (data) {
            if(data.success){
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
                          window.location.href = '/ofertaempleo/ocupacionagenciasoperadoras/'+$scope.id;
                      }
                    
                  } else {
                    window.location = data.ruta;
                  }
                });
            }else{
                $("body").attr("class", "cbp-spmenu-push");
                $scope.errores = data.errores; 
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });

    }

})

