angular.module('interno.gasto', [])

.controller('gasto', function ($scope, $http, $window) {

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get('/EncuestaInterno/CargarGasto/' + $scope.id)
            .success(function (response) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.opciones = response;
                $scope.encuestaInterno = response.encuestaInterno;
                if ($scope.encuestaInterno == undefined) {
                    $scope.encuestaInterno = {};
                    $scope.encuestaInterno.GastosRubros = [];
                    $scope.encuestaInterno.DivisaPaquete = "39";
                } else {
                    if ($scope.encuestaInterno.DivisaPaquete) {
                        $scope.encuestaInterno.DivisaPaquete = "39";
                    }
                }
                    
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push")
                swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error')
            })
    });

    $scope.guardar = function () {
        
        if (!$scope.GastoForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }
        
        $scope.encuestaInterno.GastosRubros = [];

        if ($scope.encuestaInterno.lista != null) {
            var numLista = Object.keys($scope.encuestaInterno.lista).length;
            for (var i = 0; i < numLista; i++) {
                if (!(($scope.encuestaInterno.lista[i].PersonasCubiertas == null || $scope.encuestaInterno.lista[i].PersonasCubiertas == undefined)
                    && ($scope.encuestaInterno.lista[i].Cantidad == null || $scope.encuestaInterno.lista[i].Cantidad == undefined))) {
                    $scope.encuestaInterno.GastosRubros.push($scope.encuestaInterno.lista[i]);
                } else if ($scope.encuestaInterno.lista[i].OtrosAsumidos == true) {
                    swal("Error", "Debe seleccionar el número de personas cubiertas en el rubro " + $scope.encuestaInterno.lista[i].NombreRubro, "error");
                    return;
                }
            }
        } else {
            swal("Error", "Debe ingresar por lo mínimo un gasto realizado", "error")
        }
        $scope.encuestaInterno.Viaje = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.post('/encuestaInterno/guardarGastos', $scope.encuestaInterno)
         .success(function (data) {
             $("body").attr("class", "cbp-spmenu-push")
             if (data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                 });
                 setTimeout(function () {
                     window.location.href = "/encuestaInterno/FuentesInformacion/" + $scope.id;
                 }, 1000);

             } else {
                 $("body").attr("class", "cbp-spmenu-push")
                 $scope.errores = data.errores;
                 swal("Error", "Error en el formulario, corrijalos", "error")
             }

         }).error(function () {
             $("body").attr("class", "cbp-spmenu-push")
             swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error')
         })

    }
})