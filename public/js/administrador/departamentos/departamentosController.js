/* global angular */
angular.module('departamentos.departamento', [])

.controller('departamentosController', function($scope, departamentosServi){
    departamentosServi.getDatos().then(function (data){
        if (data.success){
            $scope.departamentos = data.departamentos;
            $scope.paises = data.paises;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.');
    });
    
    $scope.verDepartamentoModal = function (departamento){
        $scope.sw = 3;
        $scope.departamento = angular.copy(departamento);
        $('#myModalLabel').text('Ver departamento');
        $('#departamentosModal').modal('show');
    }
});