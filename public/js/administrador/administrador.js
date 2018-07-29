var situr = angular.module("situr_admin", ['checklist-model', 'angularUtils.directives.dirPagination','grupoViajeService','receptor.grupo_viaje']);

situr.controller('listadoEncuestasCtrl', ['$scope','grupoViajeServi', function ($scope,receptorServi) {
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


