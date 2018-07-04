angular.module('interno.fuentes', ["checklist-model"])

.controller('fuentesInterno', function ($scope, $http) {

    $scope.enteran = {
        FuentesAntes: [],
        FuentesDurante: [],
        Redes: []
    }

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get('/turismointerno/cargardatosfuentes/'+$scope.id)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                
                $scope.fuentesAntes = data.fuentesAntes
                $scope.fuentesDurante = data.fuentesDurante
                $scope.redes = data.redes
                $scope.enteran.id = $scope.id
                $scope.experiencias = data.experiencias
                $scope.calificaciones = data.calificaciones

                if (data.invitacion_correo != null) {
                    
                    $scope.enteran.FuentesAntes = data.fuentes_antes
                    $scope.enteran.FuentesDurante = data.fuentes_durante
                    $scope.enteran.Redes = data.compar_redes
                    $scope.enteran.OtroFuenteAntes = data.OtroFuenteAntes
                    $scope.enteran.OtroFuenteDurante = data.OtroFuenteDurante
                    $scope.enteran.Correo = data.invitacion_correo
                    $scope.enteran.Invitacion = data.invitacion
                    $scope.enteran.NombreFacebook = data.facebook
                    $scope.enteran.NombreTwitter = data.twitter
                }

            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push")
                swal("Error", "Error en la carga, por favor recarga la pagina", "error")
            })
    })

    


    $scope.validar = function (sw, id) {
        if (sw == 0) {
            if (id == 13) {
                var i = $scope.enteran.FuentesDurante.indexOf(13)
                if (i == -1) {
                    $scope.enteran.FuentesDurante = [13]
                    $scope.enteran.OtroFuenteDurante = null
                }
            } else {
                if (id == 14) {
                    var i = $scope.enteran.FuentesDurante.indexOf(14)
                    if (i != -1) {
                        $scope.enteran.OtroFuenteDurante = null
                    }
                }
            }
        } else if (sw == 1) {
            if (id == 1) {
                var i = $scope.enteran.Redes.indexOf(1)
                if (i == -1) {
                    $scope.enteran.Redes = [1]
                }
            }
        } else {
            if (id == 14) {
                var i = $scope.enteran.FuentesAntes.indexOf(14)
                if (i != -1) {
                    $scope.enteran.OtroFuenteAntes = null
                }
            }
        }
    }

    $scope.validarOtro = function (sw) {
        if (sw == 0) {
            var i = $scope.enteran.FuentesAntes.indexOf(14)
            if ($scope.enteran.OtroFuenteAntes != null && $scope.enteran.OtroFuenteAntes != '') {
                if (i == -1) {
                    $scope.enteran.FuentesAntes.push(14)
                }
            }
        } else {
            var i = $scope.enteran.FuentesDurante.indexOf(14)
            if ($scope.enteran.OtroFuenteDurante != null && $scope.enteran.OtroFuenteDurante != '') {
                if (i == -1) {
                    $scope.enteran.FuentesDurante.push(14)
                }
            }
        }
    }

    $scope.guardar = function() {
        if (!$scope.inForm.$valid || $scope.enteran.FuentesAntes.length == 0 || $scope.enteran.FuentesDurante.length == 0 || $scope.enteran.Redes.length == 0) {
            return
        }

        if ($scope.enteran.FuentesAntes.indexOf(14) == -1) {$scope.enteran.OtroFuenteAntes = null}

        if ($scope.enteran.FuentesDurante.indexOf(14) == -1) {$scope.enteran.OtroFuenteDurante = null}

        $scope.enteran.Experiencias = $scope.experiencias
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.post('/turismointerno/guardarfuentesinformacion', $scope.enteran)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                if (data.success) {
                    var msj
                    if (data.sw == 0) {
                        msj = "guardado"
                    } else {
                        msj = "editado"
                    }
                    swal({
                        title: "Realizado",
                        text: "Se ha " + msj + " satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        window.location.href = "/temporada";
                    }, 1000);
                } else {
                    $scope.errores = data.errores
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error")
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push")
                swal("Error", "Error en la carga, por favor recarga la página.", "error")
            })
    }
})