
var app = angular.module('listadoEncuestasSApp', ['angularUtils.directives.dirPagination','sostenibilidadPstService'])


app.controller('listadoEncuestasSostenibilidadCtrl',['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    
    $scope.encuestas = [];
    
    $("body").attr("class", "charging");
    sostenibilidadPstServi.CargarEncuestas().then(function (data) {
        $("body").attr("class", "");
        $scope.encuestas = data.encuestas;
    }).catch(function () {
        $("body").attr("class", "");
        swal("Error", "No se realizo la solicitud, reinicie la página", "error");
    })
    
}]);
