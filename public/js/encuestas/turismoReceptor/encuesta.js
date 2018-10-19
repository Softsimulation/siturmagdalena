
var app = angular.module('encuesta', ['ui.select','checklist-model','angularUtils.directives.dirPagination','encuestas.datos_encuestado','recpetorService','receptor.estanciayvisitados','receptor.transporte','receptor.gasto','receptor.percepcion_viaje','receptor.enteran'])


app.controller('seccionCtrl', ['$http', '$scope', function ($http, $scope) {
    $scope.seccionMax = 0;
    $scope.secciones = [
        { id: 1, url: 'EditarDatos', nombre: 'Información general' },
        { id: 2, url: 'SeccionEstanciayvisitados', nombre: 'Duración de la estancia y lugares visitados' },
        { id: 3, url: 'SeccionTransporte', nombre: 'Transporte utilizado' },
        { id: 4, url: 'SeccionViajeGrupo', nombre: 'Viaje en grupo' },
        { id: 5, url: 'Gastos', nombre: 'Gastos de viaje antes y durante el viaje al departamento del Atlántico' },
        { id: 6, url: 'percepcionviaje', nombre: 'Percepción del viaje al departamento del Atlántico' },
        { id: 7, url: 'FuentesInformacionVisitante', nombre: 'Como se enteran los visitantes sobre el departamento del Atlántico' }
    ];
    var idSeccion = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    if (idSeccion != "DatosEncuestados") {
        $http.get('/encuestaReceptor/getSeccion/' + idSeccion)
          .success(function (data) {
              if (data.success) {
                  $scope.seccionMax = data.seccion;
              }
          })
          .error(function () {

          })
    }
    
    $scope.$watch('seccionSelected', function () {
        if ($scope.seccionSelected != undefined) {
            if ($scope.seccionSelected.id > $scope.seccionMax) {
                swal("Acción no permitida","No puede acceder a la sección seleccionada","warning");
            } else {
                window.location.href = "/EncuestaReceptor/" + $scope.seccionSelected.url + "/" + idSeccion;
            }
        }
        
    })
}])

