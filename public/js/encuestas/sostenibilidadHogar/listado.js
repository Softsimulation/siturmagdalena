
var app = angular.module('listadoEncuestasHogarSostenibilidadApp', ['angularUtils.directives.dirPagination','sostenibilidadHogarServices'])


app.controller('listadoEncuestasSostenibilidadHogarCtrl',['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
    
    $scope.encuestas = [];
    
    $("body").attr("class", "charging");
    sostenibilidadHogarServi.CargarEncuestas().then(function (data) {
        $("body").attr("class", "");
        $scope.encuestas = data.encuestas;
    }).catch(function () {
        $("body").attr("class", "");
        swal("Error", "No se realizo la solicitud, reinicie la página", "error");
    })
    
}]);
