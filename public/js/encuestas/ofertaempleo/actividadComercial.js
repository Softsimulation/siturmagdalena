angular.module('oferta.Actividad', [])

.controller('seccionActividadComercialAdmin', ['$scope', 'ofertaServi',function ($scope, ofertaServi) {

    $scope.Id = null;
    $scope.actividad = {}
    $scope.Sitio = null;
    $scope.Anio = null;
    $scope.$watch('Id', function () {
        if ($scope.Id == null) {
            swal("Error", "Error en la carga, por favor recarga la pagina", "error")
        }
    });

    $scope.guardar = function () {
        if (!$scope.ActividadForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return
        }
        $scope.actividad.Mes = $scope.Id;
        $scope.actividad.Anio = $scope.Anio;
        $scope.actividad.Sitio = $scope.Sitio;
        $("body").attr("class", "cbp-spmenu-push charging")
        ofertaServi.guardarActvidadComercial($scope.actividad).then(function (data) {
        $("body").attr("class", "cbp-spmenu-push");
           if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha completado satisfactoriamente la sección.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        window.location.href = data.ruta;
                    }, 1000);
                } else {
                   
                    $scope.errores = data.errores;
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error")

                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        
        



    }
}])