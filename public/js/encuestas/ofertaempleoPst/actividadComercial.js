angular.module('ofertaPst.Actividad', [])

.controller('seccionActividadComercialAdmin', ['$scope', 'ofertaServiPst',function ($scope, ofertaServiPst) {
  
    $scope.encuestas = [];
    $scope.$watch('Id', function () {
        if ($scope.Id != null) {
             $("body").attr("class", "cbp-spmenu-push charging");
            ofertaServiPst.getDatoActivar($scope.Id).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push")
                $scope.encuestas = data.encuestas;
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            });   
        }
    });

    $scope.guardar = function (mes) {
     
        $scope.actividad = {};
        $scope.actividad.Mes = mes.mesId;
        $scope.actividad.Anio = mes.anio;
        $scope.actividad.Sitio = $scope.Id;
        $("body").attr("class", "cbp-spmenu-push charging")
        ofertaServiPst.guardarActvidadComercial($scope.actividad).then(function (data) {
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