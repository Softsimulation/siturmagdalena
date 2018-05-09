angular.module('receptor.gasto', [])

.controller('gasto', ['$scope', '$http', '$window',function ($scope, $http, $window) {

    $scope.encuestaReceptor = {};
    $scope.encuestaReceptor.GastosRubros = [];
    $scope.municipiosSeleccionados = [];

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptor/CargarGasto/' + $scope.id)
            .success(function (response) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.opciones = response;
                $scope.encuestaReceptor = response.encuestaReceptor;
                if (response.encuestaReceptor.Municipios != null) {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, $scope.encuestaReceptor.Municipios);
                } else {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, null);
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
            })
    });
    
    $scope.quitarCiudad = function (ciudad) {
        $scope.opciones.municipios[$scope.opciones.municipios.indexOf(ciudad)].selected = false;
        $scope.encuestaReceptor.Municipios.splice($scope.encuestaReceptor.Municipios.indexOf(ciudad.Id), 1);
    }

    $scope.showParent = function (items, numFilter) {

        if (numFilter != 0) {
            for (var i = 0; i < items.length; i++) {
                if (!items[i].selected) {
                    return true;
                }
            }
        }

        return false;
    }

    $scope.guardar = function () {

        if (!$scope.GastoForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }

        $scope.encuestaReceptor.GastosRubros = [];

        if ($scope.encuestaReceptor.lista != null) {
            var numLista = Object.keys($scope.encuestaReceptor.lista).length;
            for (var i = 0; i < numLista; i++) {
                if (!(($scope.encuestaReceptor.lista[i].PersonasCubiertas == null || $scope.encuestaReceptor.lista[i].PersonasCubiertas == undefined)
                    && ($scope.encuestaReceptor.lista[i].CantidadFuera == null || $scope.encuestaReceptor.lista[i].CantidadFuera == undefined) &&
                    ($scope.encuestaReceptor.lista[i].CantidadDentro == null || $scope.encuestaReceptor.lista[i].CantidadDentro == undefined) &&
                    ($scope.encuestaReceptor.lista[i].DivisaDentro == "" || $scope.encuestaReceptor.lista[i].DivisaDentro == undefined)
                     && ($scope.encuestaReceptor.lista[i].DivisaFuera == "" || $scope.encuestaReceptor.lista[i].DivisaFuera == undefined))) {
                    var aux = $scope.encuestaReceptor.lista[i];
                    if ((aux.DivisaDentro == "39" && aux.CantidadDentro < 1000) || (aux.DivisaFuera == "39" && aux.CantidadFuera < 1000)) {
                        swal("Error", "El valor de las divisas colombianas debe ser mayor a $1,000", "error");
                        return;
                    }
                    $scope.encuestaReceptor.GastosRubros.push(aux);
                } else if ($scope.encuestaReceptor.lista[i].OtrosAsumidos == true) {
                    swal("Error", "Debe seleccionar el número de personas cubiertas en el rubro " + $scope.encuestaReceptor.lista[i].NombreRubro, "error");
                    return;
                }

            }
        }
        $scope.encuestaReceptor.visitante = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/EncuestaReceptor/guardarGastos', $scope.encuestaReceptor)
         .success(function (data) {
             $("body").attr("class", "cbp-spmenu-push");
             if (data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                   });
                 setTimeout(function () {
                     window.location.href = "/EncuestaReceptor/percepcionviaje/" + $scope.id;
                 }, 1000);

             } else {
                 $("body").attr("class", "cbp-spmenu-push");
                 $scope.errores = data.errores;
                 swal("Error", "Error en la carga, por favor recarga la página", "error");
             }

         }).error(function () {
             $("body").attr("class", "cbp-spmenu-push");
             swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
         })

    }
}])
.controller('gasto_visitante', ['$scope', '$http', '$window',function ($scope, $http, $window) {

    $scope.encuestaReceptor = {};
    $scope.encuestaReceptor.GastosRubros = [];
    $scope.municipiosSeleccionados = [];

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptorVisitante/CargarGasto/' + $scope.id)
            .success(function (response) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.opciones = response;
                $scope.encuestaReceptor = response.encuestaReceptor;
                if (response.encuestaReceptor.Municipios != null) {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, $scope.encuestaReceptor.Municipios);
                } else {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, null);
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
            })
    });
    
    $scope.quitarCiudad = function (ciudad) {
        $scope.opciones.municipios[$scope.opciones.municipios.indexOf(ciudad)].selected = false;
        $scope.encuestaReceptor.Municipios.splice($scope.encuestaReceptor.Municipios.indexOf(ciudad.Id), 1);
    }

    $scope.showParent = function (items, numFilter) {

        if (numFilter != 0) {
            for (var i = 0; i < items.length; i++) {
                if (!items[i].selected) {
                    return true;
                }
            }
        }

        return false;
    }

    $scope.guardar = function () {

        if (!$scope.GastoForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }

        $scope.encuestaReceptor.GastosRubros = [];

        if ($scope.encuestaReceptor.lista != null) {
            var numLista = Object.keys($scope.encuestaReceptor.lista).length;
            for (var i = 0; i < numLista; i++) {
                if (!(($scope.encuestaReceptor.lista[i].PersonasCubiertas == null || $scope.encuestaReceptor.lista[i].PersonasCubiertas == undefined)
                    && ($scope.encuestaReceptor.lista[i].CantidadFuera == null || $scope.encuestaReceptor.lista[i].CantidadFuera == undefined) &&
                    ($scope.encuestaReceptor.lista[i].CantidadDentro == null || $scope.encuestaReceptor.lista[i].CantidadDentro == undefined) &&
                    ($scope.encuestaReceptor.lista[i].DivisaDentro == "" || $scope.encuestaReceptor.lista[i].DivisaDentro == undefined)
                     && ($scope.encuestaReceptor.lista[i].DivisaFuera == "" || $scope.encuestaReceptor.lista[i].DivisaFuera == undefined))) {
                    var aux = $scope.encuestaReceptor.lista[i];
                    if ((aux.DivisaDentro == "39" && aux.CantidadDentro < 1000) || (aux.DivisaFuera == "39" && aux.CantidadFuera < 1000)) {
                        swal("Error", "El valor de las divisas colombianas debe ser mayor a $1,000", "error");
                        return;
                    }
                    $scope.encuestaReceptor.GastosRubros.push(aux);
                } else if ($scope.encuestaReceptor.lista[i].OtrosAsumidos == true) {
                    swal("Error", "Debe seleccionar el número de personas cubiertas en el rubro " + $scope.encuestaReceptor.lista[i].NombreRubro, "error");
                    return;
                }

            }
        }
        $scope.encuestaReceptor.visitante = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/EncuestaReceptorVisitante/guardarGastos', $scope.encuestaReceptor)
         .success(function (data) {
             $("body").attr("class", "cbp-spmenu-push");
             if (data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                   });
                  setTimeout(function () {
                      window.location.href = "/EncuestaReceptorVisitante/percepcionviaje/" + $scope.id;
                    }, 1000);
             } else {
                 $("body").attr("class", "cbp-spmenu-push");
                 $scope.errores = data.errores;
                 swal("Error", "Error en la carga, por favor recarga la página", "error");
             }

         }).error(function () {
             $("body").attr("class", "cbp-spmenu-push");
             swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
         })

    }
}]);