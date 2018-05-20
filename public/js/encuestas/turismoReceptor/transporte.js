angular.module('receptor.transporte', ["checklist-model"])

.controller('transporte', ['$scope', 'receptorServi',function ($scope, receptorServi) {
    $scope.transporte = {};
    
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        receptorServi.getDatosTransporte($scope.id).then(function (data) {
            if(data.success){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.transportes = data.transporte_llegar;
                $scope.lugares = data.lugares;
                $scope.transporte.Id = $scope.id;
                
                if (data.mover != null && data.llegar != null) {
                    $scope.transporte.Llegar = data.llegar;
                    $scope.transporte.Mover = data.mover;
                    $scope.transporte.Alquiler = data.opcion_lugar;
                    $scope.transporte.Empresa = data.empresa;
                    $scope.transporte.Calificacion = data.calificacion;
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

    $scope.guardar = function () {

        if (!$scope.transForm.$valid) {
            return;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.guardarSeccionTransporte($scope.transporte).then(function (data) {
            if (data.success) {
                $("body").attr("class", "cbp-spmenu-push");
                var msj;
                if (data.sw == 0) {
                    msj = "guardado";
                }else{
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
                    window.location.href = "/turismoreceptor/secciongrupoviaje/" + $scope.id;
                }, 1000);
                
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

.controller('viaje_grupo', ['$scope', 'receptorServi',function ($scope, receptorServi) {
    $scope.grupo = {
        Personas: []
    }

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.getDatosSeccionViajeGrupo($scope.id).then(function (data) {
            if(data.success){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.viaje_grupos = data.viaje_grupos;
                $scope.grupo.Id = $scope.id;

                if (data.tam_grupo != null && data.personas != null) {
                    $scope.grupo.Numero = data.tam_grupo;
                    $scope.grupo.Personas = data.personas;
                    $scope.grupo.Otro = data.otro;
                    $scope.grupo.Numero_otros = data.acompaniantes;
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

    $scope.buscar = function (list, data) {
        if (list.indexOf(data) !== -1) {
            return true;
        } else {
            return false;
        }
    }

    $scope.verifica = function () {
        if($scope.grupo.Numero < 1 && $scope.grupo.Numero != null){
            $scope.grupo.Personas = [];
            $scope.grupo.Otro = null;
        } else {
            if ($scope.grupo.Numero == 1) {
                $scope.grupo.Personas = [1];
                $scope.grupo.Otro = null;
            } else {
                var i = $scope.grupo.Personas.indexOf(1);
                if (i != -1) {
                    $scope.grupo.Personas.splice(i, 1);
                }
            }
        }
    }

    $scope.verificarOtro = function () {
        var i = $scope.grupo.Personas.indexOf(12);
        if ($scope.grupo.Otro != null && $scope.grupo.Otro != '') {
            if (i == -1) {
                $scope.grupo.Personas.push(12);
            }
        }
    }

    $scope.vchek = function (id) {
        if (id == 12) {
            var i = $scope.grupo.Personas.indexOf(12);
            if (i !== -1) {
                $scope.grupo.Otro = null;
            }
        }
    }

    $scope.guardar = function () {

        if (!$scope.grupoForm.$valid || $scope.grupo.Personas.length == 0) {
            return;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.guardarSeccionViajeGrupo($scope.grupo).then(function (data) {
            if(data.success){
                $("body").attr("class", "cbp-spmenu-push");
                var msj;
                if (data.sw == 0) {
                    msj = "guardado";
                } else {
                    msj = "editado";
                }
                swal({
                    title: "Realizado",
                    type: "success",
                    text: "Se ha " + msj + " satisfactoriamente la sección.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location.href = "/turismoreceptor/secciongastos/" + $scope.id;
                }, 1000);
            }else{
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Por favor corrija los errores", "error");
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    }
}])

.controller('transporte_visitante', ['$scope', '$http',function ($scope, $http) {
    $scope.transporte = {};

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptorVisitante/CargarTransporte/' + $scope.id)
        .success(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success) {
                $scope.transportes = data.transporte_llegar;
                $scope.lugares = data.lugares;
                $scope.transporte.Id = $scope.id;

                if (data.mover != null && data.llegar != null) {
                    $scope.transporte.Llegar = data.llegar;
                    $scope.transporte.Mover = data.mover;
                    $scope.transporte.Alquiler = data.opcion_lugar;
                    $scope.transporte.Empresa = data.empresa;
                }
            } else {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            }
        }).error(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        })
    })

    $scope.guardar = function () {

        if (!$scope.transForm.$valid) {
            return;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/EncuestaReceptorVisitante/GuardarTransporte', $scope.transporte)
            .success(function (data) {
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
                        window.location.href = "/EncuestaReceptorVisitante/SeccionViajeGrupo/" + $scope.id;
                    }, 
                   1000);

                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
    }
}])

.controller('viaje_grupo_visitante', ['$scope', '$http',function ($scope, $http) {
    $scope.grupo = {
        Personas: []
    }

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptorVisitante/CargarViajeGrupo/' + $scope.id)
        .success(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success) {
                $scope.viaje_grupos = data.viaje_grupos;
                $scope.grupo.Id = $scope.id;

                if (data.tam_grupo != null && data.personas != null) {
                    $scope.grupo.Numero = data.tam_grupo;
                    $scope.grupo.Personas = data.personas;
                    $scope.grupo.Otro = data.otro;
                    $scope.grupo.Numero_otros = data.acompañantes;
                }
            } else {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            }
        }).error(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        })
    })

    $scope.buscar = function (list, data) {
        if (list.indexOf(data) !== -1) {
            return true;
        } else {
            return false;
        }
    }

    $scope.verifica = function () {
        if ($scope.grupo.Numero < 1 && $scope.grupo.Numero != null) {
            $scope.grupo.Personas = [];
            $scope.grupo.Otro = null;
        } else {
            if ($scope.grupo.Numero == 1) {
                $scope.grupo.Personas = [1]
                $scope.grupo.Otro = null;
            } else {
                var i = $scope.grupo.Personas.indexOf(1);
                if (i != -1) {
                    $scope.grupo.Personas.splice(i, 1);
                }
            }
        }
    }

    $scope.verificarOtro = function () {
        var i = $scope.grupo.Personas.indexOf(12);
        if ($scope.grupo.Otro != null && $scope.grupo.Otro != '') {
            if (i == -1) {
                $scope.grupo.Personas.push(12);
            }
        }
    }

    $scope.vchek = function (id) {
        if (id == 12) {
            var i = $scope.grupo.Personas.indexOf(12);
            if (i !== -1) {
                $scope.grupo.Otro = null;
            }
        }
    }

    $scope.guardar = function () {

        if (!$scope.grupoForm.$valid) {
            return;
        }

        if ($scope.grupo.Personas.length == 0) {
            return;
        }

        if ($scope.grupo.Personas.indexOf(9) == -1) {
            $scope.grupo.Numero_otros = null;
        }

        if ($scope.grupo.Personas.indexOf(12) == -1) {
            $scope.grupo.Otro = null;
        }


        $("body").attr("class", "cbp-spmenu-push charging");

        $http.post('/EncuestaReceptorVisitante/GuardarViajeGrupo', $scope.grupo)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
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
                        window.location.href = "/EncuestaReceptorVisitante/Gastos/" + $scope.id;
                    }, 1000);

                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
    }
}])