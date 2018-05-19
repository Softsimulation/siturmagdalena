angular.module('admin.temporadas', ['objectTable'])

.controller('temporadasCtrl', ['$scope', '$http',function ($scope, $http) {

    $("body").attr("class", "cbp-spmenu-push charging");
    
    $http.get('/temporada/gettemporadas')
        .success(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.temporadas = data.temporadas;
        }).error(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la pagina", "error");
        })

    $scope.pasarC = function () {
        $scope.temporada = {};
        $scope.errores = null;
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $scope.addForm.$submitted = false;
        $('#date_apli').val('');
        $('#date_apli_2').val('');
        $('#crearTemporada').modal('show');
    }

    $scope.pasarE = function (obj) {
        $scope.index = $scope.temporadas.indexOf(obj);
        $scope.temporada = $.extend(true, {}, obj);
        $scope.errores = null;
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $scope.addForm.$submitted = false;
        $('#editarTemporada').modal('show');
    }

    $scope.guardar = function () {
        $scope.temporada.Fecha_ini = $('#date_apli').val().split("/").join("-");
        $scope.temporada.Fecha_fin = $('#date_apli_2').val().split("/").join("-");
        if (!$scope.addForm.$valid) {
            return;
        }

        for (var i in $scope.temporadas) {
            if (!validarFechas($scope.temporada.Fecha_ini, $scope.temporada.Fecha_fin, $scope.temporadas[i].Fecha_ini, $scope.temporadas[i].Fecha_fin)) {
                swal("Error", "Las fechas coinciden con una temporada ya creada.", "error");
                return;
            }
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/temporada/guardartemporada', $scope.temporada)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
                    swal("¡Realizado!", "Se ha creado satisfactoriamente la temporada.", "success");
                    $scope.temporada.Estado = true;
                    $scope.temporada.id = data.temporada.id;
                    $scope.temporadas.unshift($scope.temporada);
                    $('#crearTemporada').modal('hide');
                    
                } else {
                    $scope.errores = data.errores;
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            })

    }

    $scope.editar = function () {
        $scope.temporada.Fecha_ini = $('#date_apli_3').val().split("/").join("-");
        $scope.temporada.Fecha_fin = $('#date_apli_4').val().split("/").join("-");
        if (!$scope.editForm.$valid) {
            return;
        }

        for (var i in $scope.temporadas) {
            if (!validarFechas($scope.temporada.Fecha_ini, $scope.temporada.Fecha_fin, $scope.temporadas[i].Fecha_ini, $scope.temporadas[i].Fecha_fin) && $scope.temporadas[i].Id != $scope.temporada.Id) {
                swal("Error", "Las fechas coinciden con una temporada ya creada.", "error");
                return;
            }
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/temporada/guardartemporada', $scope.temporada)
            .success(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
                    swal("¡Realizado!", "Se ha modificado satisfactoriamente la temporada.", "success");
                    
                    $scope.temporadas[$scope.index] = $scope.temporada;
                    $('#editarTemporada').modal('hide');
                } else {
                    $scope.errores = data.errores;
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
    }

    $scope.cambiarEstado = function (obj) {
        var t1, t2;
        if (obj.Estado) {
            t1 = 'Desactivar';
            t2 = 'desactivado';
        } else {
            t1 = 'Activar';
            t2 = 'activado';
        }

        swal({
            title: t1 + " temporada",
            text: "¿Está seguro?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false
        },
        function () {
            $("body").attr("class", "cbp-spmenu-push charging");
            $http.post('/temporada/cambiarestado', obj)
                .success(function (data) {
                    $("body").attr("class", "cbp-spmenu-push");
                    if (data.success) {
                        obj.Estado = data.estado;
                        swal("¡Realizado!", "Se ha " + t2 + " satisfactoriamente la temporada.", "success");
                    } else {
                        $scope.errores = data.errores;
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                    }
                }).error(function () {
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error");
                })
        });

    }

    function validarFechas(fechaNuevaInicial, fechaNuevaFinal, fechaViejaInicial, fechaViejaFinal) {
        if ((fechaNuevaInicial >= fechaViejaInicial && fechaNuevaInicial <= fechaViejaFinal) || (fechaNuevaFinal >= fechaViejaInicial && fechaNuevaFinal <= fechaViejaFinal) || (fechaNuevaInicial < fechaViejaInicial && fechaNuevaFinal > fechaViejaFinal)) {
            return false;
        }
        return true;
    }

}])

.controller('verTemporadaCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/temporada/cargardatos/' + $scope.id)
            .success(function (data) {
                $scope.temporada = data.temporada;
                $scope.temporada.Personas=data.hogares
                $("body").attr("class", "cbp-spmenu-push");
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
    })

    
}])