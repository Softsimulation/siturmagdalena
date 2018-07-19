var situr = angular.module("admin.transporte", []);

situr.controller('caracterizacionTransporteCtrl', ['$scope','transporteServi', function ($scope,transporteServi) {

    $scope.transporte = {};
    $scope.estadoEncuesta = null;
    $scope.id = null;
    
    $scope.$watch('id', function () {
        
        if ($scope.id != null) {
            $("body").attr("class", "charging");
            transporteServi.getCaracterizacionTransporte($scope.id).then(function (data) {
                if (data.transporte != null) {

                    for (i = 0; i < data.transporte.length;i++){
                        if (data.transporte[i].tipos_transporte_oferta_id == 1) {
                            $scope.transporte.Terrestre = data.transporte[i].tipos_transporte_oferta_id;
                            $scope.transporte.VehiculosTerrestre = data.transporte[i].numero_vehiculos;
                            $scope.transporte.PersonasVehiculosTerrestre = data.transporte[i].personas;
                        }
                        if (data.transporte[i].tipos_transporte_oferta_id == 2) {
                            $scope.transporte.Aereo = data.transporte[i].tipos_transporte_oferta_id;
                            $scope.transporte.VehiculosAereo = data.transporte[i].numero_vehiculos;
                            $scope.transporte.PersonasVehiculosAereo = data.transporte[i].personas;
                        }
                        if (data.transporte[i].tipos_transporte_oferta_id == 3) {
                            $scope.transporte.Maritimo = data.transporte[i].tipos_transporte_oferta_id;
                            $scope.transporte.VehiculosMaritimo = data.transporte[i].numero_vehiculos;
                            $scope.transporte.PersonasVehiculosMaritimo = data.transporte[i].personas;
                        }
                    }
                    if (data.success == 1) {
                        $scope.estadoEncuesta = 1;
                    } else {
                        $scope.estadoEncuesta = 0;
                    }
                    
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }  
    })

    $scope.guardar = function () {
        if (!$scope.caracterizacionForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error");
            return;
        }
        $scope.transporte.id = $scope.id;
        if ($scope.estadoEncuesta == 0) {
            $scope.solicitud = 'guardarCaracterizacionTransporte';
        } else {
            $scope.solicitud = 'editarCaracterizacionTransporte';
        }
        
        $("body").attr("class", "charging");
        transporteServi.guardarCaracterizacionTransporte($scope.transporte).then(function (data) {
            if (data.success == true) {
                $("body").attr("class", "cbp-spmenu-push")
                swal({
                    title: "Realizado",
                    text: "Se ha guardado satisfactoriamente la sección.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location.href = "/ofertaempleo/ofertatransporte/" + $scope.id;
                }, 1000);
            } else {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.errores = data.errores;
                swal("Error", "Error en la carga, por favor recarga la pagina", "error")
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
     
}])

situr.controller('ofertaTransporteCtrl', ['$scope','transporteServi', function ($scope,transporteServi) {

    $scope.transporte = {};
    $scope.tipos = [];
    $scope.id = null;
    $scope.estadoEncuesta =null
    
    $scope.$watch('id', function () {
        
        if ($scope.id != null) {
            $("body").attr("class", "charging");
            transporteServi.getOfertaTransporte($scope.id).then(function (data) {
                for (var i = 0; i < data.oferta.length; i++) {
                    if(data.oferta[i].transporte != null){
                        if (data.oferta[i].transporte.tipos_transporte_oferta_id == 1) {
                            $scope.transporte.TotalTerrestre = parseInt(data.oferta[i].personas_total);
                            $scope.transporte.TarifaTerrestre = parseInt(data.oferta[i].tarifa_promedio);
                        }
                        if (data.oferta[i].transporte.tipos_transporte_oferta_id == 2) {
                            $scope.transporte.TotalAereo = parseInt(data.oferta[i].personas_total);
                            $scope.transporte.TarifaAereo = parseInt(data.oferta[i].tarifa_promedio);
                        }
                        if (data.oferta[i].transporte.tipos_transporte_oferta_id == 3) {
                            $scope.transporte.TotalMaritimo = parseInt(data.oferta[i].personas_total);
                            $scope.transporte.TarifaMaritimo = parseInt(data.oferta[i].tarifa_promedio);
                        }
                    }
                    
                }
                    $scope.tipos = data.ides;
                    $("body").attr("class", "cbp-spmenu-push charging")
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }else {
            $("body").attr("class", "cbp-spmenu-push")
            swal("Error", "Error en la carga, por favor recarga la pagina", "error")
        }  
    })

    $scope.guardar = function () {
        if (!$scope.ofertaForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error");
            return;
        }
        $scope.transporte.id = $scope.id;
        var i =$scope.llamar(1) 
        if ( i!= null) {
            $scope.transporte.Terrestre = $scope.tipos[i];
        }
        var i = $scope.llamar(2)
        if (i != null) {
            $scope.transporte.Aereo = $scope.tipos[i];
        }
        var i = $scope.llamar(3)
        if (i != null) {
            $scope.transporte.Maritimo = $scope.tipos[i];
        }
        $scope.transporte.id = $scope.id;
        $("body").attr("class", "charging");
        transporteServi.guardarOfertaTransporte($scope.transporte).then(function (data) {
            if (data.success == true) {
                $("body").attr("class", "cbp-spmenu-push")
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
                $("body").attr("class", "cbp-spmenu-push")
                $scope.errores = data.errores;
                swal("Error", "Error en la carga, por favor recarga la pagina", "error")
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
        
        
    }

    $scope.llamar = function (indice) {
        var i = $scope.tipos.indexOf(indice);
        if (i == -1) {
            return null;
        } else {
            return i;
        }
        
    }

}])