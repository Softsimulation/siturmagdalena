var situr = angular.module("situr_admin", ['checklist-model', 'angularUtils.directives.dirPagination', 'admin.temporadas','grupoViajeService','receptor.grupo_viaje','admin.noticia','noticiaService','ADM-dateTimePicker']);
situr.config(['ADMdtpProvider', function (ADMdtp) {
    ADMdtp.setOptions({
        calType: 'gregorian',
        format: 'YYYY-MM-DD hh:mm',
        zIndex: 1060,
        default: 'today'
    });
}]);

situr.controller('listadoEncuestasCtrl', ['$scope','grupoViajeServi', function ($scope,receptorServi) {
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('/');
    }
    $scope.prop = {
        search:''
    }
    $("body").attr("class", "charging");
    receptorServi.getEncuestas().then(function (data) {
        $scope.encuestas = data;
        for (var i = 0; i < $scope.encuestas.length; i++) {
            $scope.encuestas[i].fechaaplicacion = "'"+formatDate($scope.encuestas[i].fechaaplicacion+"'");
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


