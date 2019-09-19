
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
    
    
    $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        sostenibilidadHogarServi.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
    
}]);
