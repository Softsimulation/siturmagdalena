angular.module('receptor.enteran', [])

.controller('enteran-crear', ['$scope', 'receptorServi',function ($scope,receptorServi) {
    $scope.enteran = {
        'FuentesDurante': [],
        'FuentesAntes': [],
        'Redes':[]
    }
    $scope.control = {};
    $scope.errores = null;
    $scope.err = null;
    
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.getDatosSeccionInformacion($scope.id).then(function (data) {
            if(data.success){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.fuentesAntes = data.fuentesAntes;
                $scope.fuentesDurante = data.fuentesDurante;
                $scope.redes = data.redes;
                $scope.enteran.Id = $scope.id;

                if (data.invitacion_correo != null) {
                    $scope.enteran.FuentesAntes = data.fuentes_antes;
                    $scope.enteran.FuentesDurante = data.fuentes_durante;
                    $scope.enteran.Redes = data.compar_redes;
                    $scope.enteran.OtroFuenteAntes = data.OtroFuenteAntes;
                    $scope.enteran.OtroFuenteDurante = data.OtroFuenteDurante;
                    $scope.enteran.Correo = data.invitacion_correo;
                    $scope.enteran.Invitacion = data.invitacion;
                    $scope.enteran.NombreFacebook = data.facebook;
                    $scope.enteran.NombreTwitter = data.twitter;
                    $scope.enteran.facilidad = data.facilidad;
                    $scope.enteran.conoce_marca = data.conoce_marca;
                    $scope.enteran.acepta_autorizacion = data.acepta_autorizacion;
                    $scope.enteran.acepta_tratamiento = data.acepta_tratamiento;
                    $scope.enteran.otroRed = data.otroRed;
                }
            }else{
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })

    $scope.validar = function (sw, id) {
        if (sw == 0) {
            if (id == 13) {
                var i = $scope.enteran.FuentesDurante.indexOf(13);
                if (i == -1) {
                    $scope.enteran.FuentesDurante = [13];
                    $scope.enteran.OtroFuenteDurante = null;
                }
            } else {
                if (id == 14) {
                    var i = $scope.enteran.FuentesDurante.indexOf(14);
                    if (i != -1) {
                        $scope.enteran.OtroFuenteDurante = null;
                    }
                }
            }
        } else if (sw == 1) {
            if (id == 1) {
                var i = $scope.enteran.Redes.indexOf(1);
                if (i == -1) {
                    $scope.enteran.Redes = [1];
                }
            }
        } else {
            if (id == 14) {
                var i = $scope.enteran.FuentesAntes.indexOf(14);
                if (i != -1) {
                    $scope.enteran.OtroFuenteAntes = null;
                }
            }
        }
    }

    $scope.validarOtro = function (sw) {
        if (sw == 0) {
            var i = $scope.enteran.FuentesAntes.indexOf(14);
            if ($scope.enteran.OtroFuenteAntes != null && $scope.enteran.OtroFuenteAntes != '') {
                if (i == -1) {
                    $scope.enteran.FuentesAntes.push(14);
                }
            } 
        } else if(sw == 1) {
            var i = $scope.enteran.FuentesDurante.indexOf(14);
            if ($scope.enteran.OtroFuenteDurante != null && $scope.enteran.OtroFuenteDurante != '') {
                if (i == -1) {
                    $scope.enteran.FuentesDurante.push(14);
                }
            } 
        } else if(sw == 2) {
            var i = $scope.enteran.Redes.indexOf(12);
            if ($scope.enteran.otroRed != null && $scope.enteran.otroRed != '') {
                if (i == -1) {
                    $scope.enteran.Redes.push(12);
                }
            } 
        }
    }

    $scope.guardar = function () {

        if (!$scope.inForm.$valid) {
            return;
        }

        if ($scope.enteran.FuentesAntes.length == 0 || $scope.enteran.FuentesDurante.length == 0 || $scope.enteran.Redes.length == 0 || $scope.enteran.Correo == null) {
            return;
        }

        if ($scope.enteran.FuentesAntes.indexOf(14) == -1) {
            $scope.enteran.OtroFuenteAntes = null;
        }

        if ($scope.enteran.FuentesDurante.indexOf(14) == -1) {
            $scope.enteran.OtroFuenteDurante = null;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.guardarSeccionInformacion($scope.enteran).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push");
                var msj;
                if (data.sw == 0) {
                    msj = "guardado";
                } else {
                    msj = "editado";
                }
                swal({
                    title: "Realizado",
                    text: "Se ha " + msj + " satisfactoriamente la sección.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    window.location.href = "/turismoreceptor/listadoencuestas";
                }, 1000);
                
                if(data.rol == "Encuestador"){
                    setTimeout(function () {
                        //window.location.href = "/EncuestaReceptor/EncuestasSitur";
                    }, 1000);
    
                }else {
                    setTimeout(function () {
                        //window.location.href = "/EncuestaReceptor/Encuestas";
                    }, 1000);
                }
            } else {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    }

}])

.controller('enteran-crear_visitante', ['$scope', '$http',function ($scope, $http) {
    $scope.enteran = {
        'FuentesDurante': [],
        'FuentesAntes': [],
        'Redes': []
    }
    $scope.control = {};
    $scope.errores = null;
    $scope.err = null;

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptorVisitante/cargarDatosFuentes/' + $scope.id)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.fuentesAntes = data.fuentesAntes;
                $scope.fuentesDurante = data.fuentesDurante;
                $scope.redes = data.redes;
                $scope.enteran.Id = $scope.id;

                if (data.invitacion_correo != null) {
                    $scope.enteran.FuentesAntes = data.fuentes_antes;
                    $scope.enteran.FuentesDurante = data.fuentes_durante;
                    $scope.enteran.Redes = data.compar_redes;
                    $scope.enteran.OtroFuenteAntes = data.OtroFuenteAntes;
                    $scope.enteran.OtroFuenteDurante = data.OtroFuenteDurante;
                    $scope.enteran.Correo = data.invitacion_correo;
                    $scope.enteran.Invitacion = data.invitacion;
                    $scope.enteran.NombreFacebook = data.facebook;
                    $scope.enteran.NombreTwitter = data.twitter;
                    $scope.enteran.facilidad = data.facilidad;
                    $scope.enteran.conoce_marca = data.conoce_marca;
                    $scope.enteran.acepta_autorizacion = data.acepta_autorizacion;
                    $scope.enteran.acepta_tratamiento = data.acepta_tratamiento;
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            })
    })

    $scope.validar = function (sw, id) {
        if (sw == 0) {
            if (id == 13) {
                var i = $scope.enteran.FuentesDurante.indexOf(13);
                if (i == -1) {
                    $scope.enteran.FuentesDurante = [13];
                    $scope.enteran.OtroFuenteDurante = null;
                }
            } else {
                if (id == 14) {
                    var i = $scope.enteran.FuentesDurante.indexOf(14);
                    if (i != -1) {
                        $scope.enteran.OtroFuenteDurante = null;
                    }
                }
            }
        } else if (sw == 1) {
            if (id == 1) {
                var i = $scope.enteran.Redes.indexOf(1);
                if (i == -1) {
                    $scope.enteran.Redes = [1];
                }
            }
        } else {
            if (id == 14) {
                var i = $scope.enteran.FuentesAntes.indexOf(14);
                if (i != -1) {
                    $scope.enteran.OtroFuenteAntes = null;
                }
            }
        }
    }

    $scope.validarOtro = function (sw) {
        if (sw == 0) {
            var i = $scope.enteran.FuentesAntes.indexOf(14);
            if ($scope.enteran.OtroFuenteAntes != null && $scope.enteran.OtroFuenteAntes != '') {
                if (i == -1) {
                    $scope.enteran.FuentesAntes.push(14);
                }
            }
        } else {
            var i = $scope.enteran.FuentesDurante.indexOf(14);
            if ($scope.enteran.OtroFuenteDurante != null && $scope.enteran.OtroFuenteDurante != '') {
                if (i == -1) {
                    $scope.enteran.FuentesDurante.push(14);
                }
            }
        }
    }

    $scope.guardar = function () {

        if (!$scope.inForm.$valid) {
            return;
        }

        if ($scope.enteran.FuentesAntes.length == 0 || $scope.enteran.FuentesDurante.length == 0 || $scope.enteran.Redes.length == 0 || $scope.enteran.Correo == null) {
            return;
        }

        if ($scope.enteran.FuentesAntes.indexOf(14) == -1) {
            $scope.enteran.OtroFuenteAntes = null;
        }

        if ($scope.enteran.FuentesDurante.indexOf(14) == -1) {
            $scope.enteran.OtroFuenteDurante = null;
        }

        $("body").attr("class", "cbp-spmenu-push charging")
        $http.post('/EncuestaReceptorVisitante/guardarSeccionG', $scope.enteran)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success == true) {
                    if (data.success) {
                        var msj;
                        if (data.sw == 0) {
                            msj = "guardado";
                        } else {
                            msj = "editado";
                        }
                        swal({
                            title: "Realizado",
                            text: "Se ha " + msj + " satisfactoriamente la sección.",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            window.location.href = "/Home";
                        }, 1000);
                        //swal({
                        //    title: "Realizado",
                        //    text: "Se ha terminado con éxito toda la encuesta",
                        //    type: "success",
                        //    showCancelButton: false,
                        //    confirmButtonColor: "rgb(140, 212, 245)",
                        //    confirmButtonText: "OK",
                        //    closeOnConfirm: true
                        //}, function (isConfirm) {
                        //    window.location.href = "/Home";
                        //});
                    } else {
                        swal("Error", "Por favor corrija los errores", "error");
                        $scope.errores = data.errores;
                    }
                } else {
                    $("body").attr("class", "cbp-spmenu-push");
                    $scope.errores = data.errores;
                    swal("Error", "Error en la carga, por favor recarga la página", "error");
                }

            })

    }

}])
