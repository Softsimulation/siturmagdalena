
var app = angular.module('listadoEncuestasSApp', ['angularUtils.directives.dirPagination','sostenibilidadPstService'])


app.controller('listadoEncuestasSostenibilidadCtrl',['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    
    $scope.encuestas = [];
     $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        sostenibilidadPstServi.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
    
    
    $("body").attr("class", "charging");
    sostenibilidadPstServi.CargarEncuestas().then(function (data) {
        $("body").attr("class", "");
        $scope.encuestas = data.encuestas;
    }).catch(function () {
        $("body").attr("class", "");
        swal("Error", "No se realizo la solicitud, reinicie la página", "error");
    })
    
}]);
