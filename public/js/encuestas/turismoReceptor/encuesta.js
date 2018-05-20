
var app = angular.module('encuesta', ['ui.select','checklist-model','angularUtils.directives.dirPagination','encuestas.datos_encuestado','recpetorService','grupoViajeService','receptor.estanciayvisitados','receptor.transporte','receptor.grupo_viaje','receptor.gasto','receptor.percepcion_viaje','receptor.enteran'])


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

app.controller('listadoEncuestasCtrl', ['$scope','receptorServi', function ($scope,receptorServi) {
    $scope.prop = {
        search:''
    }
    $("body").attr("class", "charging");
    receptorServi.getEncuestas().then(function (data) {
        $scope.encuestas = data;
        for (var i = 0; i < $scope.encuestas.length; i++) {
              if ($scope.encuestas[i].estadoid > 0 && $scope.encuestas[i].estadoid < 7) {
                  $scope.encuestas[i].Filtro = 'sincalcular';
              } else {
                  $scope.encuestas[i].Filtro = 'calculadas';
              }
          }
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $('#processing').removeClass('process-in');
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    $scope.filtrarEncuesta = function (item) {
        return ($scope.filtroEstadoEncuesta != "" && item.Filtro == $scope.filtroEstadoEncuesta) || $scope.filtroEstadoEncuesta == "";
    };
    $scope.campoSelected = "";
    $scope.filtrarCampo = function (item) {
        return ($scope.campoSelected != "" && item[$scope.campoSelected].indexOf($scope.prop.search) > -1) || $scope.campoSelected == "";
    };
}])