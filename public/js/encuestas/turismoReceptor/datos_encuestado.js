angular.module('encuestas.datos_encuestado', [])

.controller("crear", ['$scope', 'receptorServi', function ($scope, receptorServi) {
    $scope.encuesta = {};
    $scope.departamentod = {};
    
    $scope.$watch('id', function () {
        receptorServi.informacionCrear().then(function (data) {
            $scope.grupos = data.grupos;
            $scope.encuestadores = data.encuestadores;
            $scope.lugares = data.lugar_nacimiento;
            $scope.paises = data.paises;
            $scope.motivos = data.motivos;
            $scope.medicos = data.medicos;
            $scope.departamentos_colombia = data.departamentos;
        }).catch(function () {
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });
    })

    $scope.otro = function () {
        if ($scope.encuesta.Otro == "") {
            $scope.encuesta.Motivo = null;
        } else {
            $scope.encuesta.Motivo = 18;
        }
    }

    $scope.cambiomotivo = function () {
        if ($scope.encuesta.Motivo != 18) {
            $scope.encuesta.Otro = "";
        }
    }

    $scope.changedepartamento = function () {
        $scope.departamento = "";
        $scope.departamentos = [];
        if ($scope.pais_residencia != null) {
            
            receptorServi.getDepartamento($scope.pais_residencia).then(function (data) {
                $scope.departamentos = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.changemunicipio = function () {
        $scope.encuesta.Municipio = "";
        $scope.municipios = [];
        if ($scope.departamento != null) {
            
            receptorServi.getMunicipio($scope.departamento).then(function (data) {
                $scope.municipios = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
            
        }
    }

    $scope.changemunicipiocolombia = function () {
        $scope.encuesta.Destino = "";
        $scope.municipios_colombia = [];
        if ($scope.departamentod.id != null) {
            
            receptorServi.getMunicipio($scope.departamentod.id).then(function (data) {
                $scope.municipios_colombia = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.guardar = function () {
       
        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            
            receptorServi.guardarCrearEncuesta($scope.encuesta).then(function (data) {
                $("body").attr("class", "");
                
                if (data.success) {

                    swal({
                        title: "Realizado",
                        text: "Sección guardada exitosamente",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        window.location = "/turismoreceptor/seccionestancia/"+data.id;
                        if (JSON.parse(data.actor)) {
                            //window.location = "/EncuestaReceptor/Encuestas";
                        } else {
                            //window.location = "/EncuestaReceptor/SeccionEstanciayvisitados/"+data.id;
                        }
                    }, 1000);
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error");
                    $scope.errores = data.errores;
                }
            }).catch(function () {
                $("body").attr("class", "");
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error");
        }

    }

}])

.controller("editar", ['$scope', 'receptorServi',function ($scope, receptorServi) {

    $scope.encuesta = {};
    $scope.departamentod = {};
    $scope.$watch("id", function () {

        if ($scope.id != null) {

            $("body").attr("class", "charging");
            
            receptorServi.getDatosEditarDatos($scope.id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                data.datos = data.datos;
                $scope.departamentos = data.departamentosr;
                $scope.municipios = data.municipiosr;
                $scope.municipios_colombia = data.municipiosd;
                $scope.grupos = data.datos.grupos;
                $scope.encuestadores = data.datos.encuestadores;
                $scope.lugares = data.datos.lugar_nacimiento;
                $scope.paises = data.datos.paises;
                $scope.motivos = data.datos.motivos;
                $scope.medicos = data.datos.medicos;
                $scope.departamentos_colombia = data.datos.departamentos;
                $scope.encuesta = data.visitante;
                $scope.pais_residencia = data.visitante.Pais;
                $scope.departamento = data.visitante.Departamento;
                $scope.departamentod.id = data.visitante.DepartamentoDestino;
                fechal = data.visitante.Llegada.split('-');
                fechas = data.visitante.Salida.split('-');
                $scope.encuesta.Llegada = new Date(fechal[0], (parseInt(fechal[1]) - 1), fechal[2]);
                $scope.encuesta.Salida = new Date(fechas[0], (parseInt(fechas[1]) - 1), fechas[2]);
                
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });
        }
    })

    $scope.otro = function () {
        if ($scope.encuesta.Otro == "") {
            $scope.encuesta.Motivo = null;
        } else {
            $scope.encuesta.Motivo = 18;
        }
    }

    $scope.cambiomotivo = function () {
        if ($scope.encuesta.Motivo != 18) {
            $scope.encuesta.Otro = "";
        }
    }

    $scope.changedepartamento = function () {
        $scope.departamento = "";
        $scope.departamentos = [];
        if ($scope.pais_residencia != null) {
            
            receptorServi.getDepartamento($scope.pais_residencia).then(function (data) {
                $scope.departamentos = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.changemunicipio = function () {
        $scope.encuesta.Municipio = "";
        $scope.municipios = [];
        if ($scope.departamento != null) {
            
            receptorServi.getMunicipio($scope.departamento).then(function (data) {
                $scope.municipios = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
            
        }
    }

    $scope.changemunicipiocolombia = function () {
        $scope.encuesta.Destino = "";
        $scope.municipios_colombia = [];
        if ($scope.departamentod.id != null) {
            
            receptorServi.getMunicipio($scope.departamentod.id).then(function (data) {
                $scope.municipios_colombia = data;
            }).catch(function () {
                swal("Error", "No se realizo la solicitud, reinicie la página", "error");
            })
        }
    }

    $scope.guardar = function () {

        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            
            $("body").attr("class", "charging");
            
            receptorServi.guardarEditarDatos($scope.encuesta).then(function (data) {
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
                        window.location = "/turismoreceptor/seccionestancia/"+ $scope.encuesta.Id;
                        //window.location = "/EncuestaReceptor/SeccionEstanciayvisitados/" + $scope.encuesta.Id;
                    }, 1000);
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error");
                    $scope.errores = data.errores;
                }  
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });
        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error");
        }

    }

}])