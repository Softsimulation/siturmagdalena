var app = angular.module('encuestaListado', ['recpetorService','angularUtils.directives.dirPagination'])


app.controller('listadoEncuestas2Ctrl', ['$scope','receptorServi', function ($scope,receptorServi) {
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('/');
    }
    $scope.prop = {
        search:''
    }
    $("body").attr("class", "charging");
    receptorServi.getEncuestas().then(function (data) {
        $scope.encuestas = data;
        
        for (var i = 0; i < $scope.encuestas.length; i++) {
            $scope.encuestas[i].fechaaplicacion = formatDate($scope.encuestas[i].fechaaplicacion);
            $scope.encuestas[i].fechallegada = formatDate($scope.encuestas[i].fechallegada);
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
