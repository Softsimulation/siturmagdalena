var situr = angular.module("admin.agenciaViaje", []);

situr.controller('caracterizacionAgenciaViajesCtrl', ['$scope','agenciaViajeServi', function ($scope,agenciaViajeServi) {
    $scope.encuesta = {};
    $scope.encuesta.TipoServicios = [];
    
    $scope.$watch('encuesta.id', function () {
        
        if ($scope.encuesta.id != null) {
            $("body").attr("class", "charging");
            agenciaViajeServi.getAgencia($scope.encuesta.id).then(function (data) {
                if (data.Id > 0) {
                    var arrayAux = [];
                    if(data.TipoServicios.length > 0){
                        if(data.TipoServicios.servicios_agencias.length > 0){
                            for(var i=0; i<data.TipoServicios.servicios_agencias.length;i++){
                                arrayAux.push(data.TipoServicios.servicios_agencias[i].id);
                            }
                        }
                    }
                    $scope.encuesta.TipoServicios = arrayAux;
                    
                    $scope.encuesta.Planes = data.Planes + ""
                    $scope.encuesta.Otro = data.Otro
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }  
    })
    $("body").attr("class", "charging");
    agenciaViajeServi.getDatosAgencia().then(function (data) {
        $scope.servicios = data;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    })
    
    $scope.guardar = function () {

       if ($scope.DatosForm.$valid && $scope.encuesta.TipoServicios.length>0) {
           
            $("body").attr("class", "charging");
            agenciaViajeServi.guardarCaracterizacion($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
    
                    swal({
                        title: "Realizado",
                        text: "Sección guardada exitosamente",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
    
    
                        window.location = "/ofertaempleo/ofertaagenciaviajes/"+$scope.encuesta.id;
    
    
                    }, 1000);
    
    
    
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error")
                    $scope.errores = data.errores;
    
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            })

        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }



    }
}])

situr.controller('ofertaAgenciaViajesCtrl', ['$scope','agenciaViajeServi', function ($scope,agenciaViajeServi) {
    $scope.encuesta = {};
    $scope.encuesta.personas = {};
    
    $scope.$watch('encuesta.id', function () {
        
        if ($scope.encuesta.id != null) {
            $("body").attr("class", "charging");
            agenciaViajeServi.getOfertaAgencia($scope.encuesta.id).then(function (data) {
                if (data.id > 0) {
                    if(data.personas_destino_con_viajes_turismos.length > 0){
                        $scope.encuesta.personas = data.personas_destino_con_viajes_turismos;
                        for(var i=0; i<$scope.encuesta.personas.length; i++){
                            $scope.encuesta.personas[i].internacional = parseInt($scope.encuesta.personas[i].internacional);
                            $scope.encuesta.personas[i].nacional = parseInt($scope.encuesta.personas[i].nacional);
                            $scope.encuesta.personas[i].numerototal = parseInt($scope.encuesta.personas[i].numerototal);
                        }
                    }
                    
                    if(data.planes_santamarta != null){
                        $scope.encuesta.numero=parseInt(data.planes_santamarta.numero)
                        $scope.encuesta.magdalena=parseInt(data.planes_santamarta.residentes)
                        $scope.encuesta.nacional=parseInt(data.planes_santamarta.noresidentes)
                        $scope.encuesta.internacional=parseInt(data.planes_santamarta.extrajeros)
                    }
                    
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }  
    })
    $("body").attr("class", "charging");
    agenciaViajeServi.getDatosOfertaAgencia().then(function (data) {
        $scope.destinos = data;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    })
    
    $scope.guardar = function () {

       if ($scope.DatosForm.$valid) {
           
            $("body").attr("class", "charging");
            
            agenciaViajeServi.guardarOfertaAgenciaViajes($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
    
                    swal({
                        title: "Realizado",
                        text: "Sección guardada exitosamente",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
    
    
                        window.location = "/ofertaempleo/empleomensual/"+$scope.encuesta.id;
    
    
                    }, 1000);
    
    
    
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error")
                    $scope.errores = data.errores;
    
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            })

        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }



    }
}])