var app = angular.module('encuestaInterno', ['checklist-model', 'interno.transporte', 'interno.gastos', 'interno.hogares', 'interno.Actividades', 'interno.viajesrealizados','interno.fuentes','interno.Services'])

app.controller('seccionCtrl', ['$http', '$scope', function ($http, $scope) {
    $scope.seccionMax = 0;
    $scope.secciones = [
        { id: 2, url: 'ActividadesRealizadas', nombre: 'Duración de la estancia y lugares visitados' },
        { id: 3, url: 'Transporte', nombre: 'Transporte utilizado' },
        { id: 4, url: 'Gastos', nombre: 'Gastos de viaje antes y durante el viaje al departamento del Magdalena' },
        { id: 5, url: 'FuentesInformacion', nombre: 'Fuentes de información' }
    ];
    var idSeccion = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    var url = window.location.href.split('/');
    var seccion = url[url.length - 2];
    console.log(seccion);
    if (seccion != "ViajesRealizados" && seccion != "EditarHogar") {
        $http.get('/EncuestaInterno/getSeccion/' + idSeccion)
          .success(function (data) {
              if (data.success) {
                  $scope.seccionMax = data.seccion;
                  console.log($scope.seccionMax);
              }
          })
          .error(function () {

          })
        $scope.$watch('seccionSelected', function () {
            if ($scope.seccionSelected != undefined) {
                if ($scope.seccionSelected.id > $scope.seccionMax) {
                    swal("Acción no permitida", "No puede acceder a la sección seleccionada", "warning");
                } else {
                    window.location.href = "/EncuestaInterno/" + $scope.seccionSelected.url + "/" + idSeccion;
                }
            }

        })
    } else {
        $("#seccion").hide();
    }
    
}])