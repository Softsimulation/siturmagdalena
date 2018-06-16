/* global angular */
/* global swal */
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
        $scope.errores = null;
        $scope.sw = 3;
        $scope.departamento = angular.copy(departamento);
        $('#myModalLabel').text('Ver departamento');
        $('#departamentosModal').modal('show');
    }
    
    $scope.nuevoDepartamentoModal = function (){
        $scope.errores = null;
        $scope.sw = 1;
        $scope.departamento = null;
        $scope.departamentoForm.$setPristine();
        $scope.departamentoForm.$setUntouched();
        $('#myModalLabel').text('Nuevo departamento');
        $('#departamentosModal').modal('show');
    }
    
    $scope.nombreDelPais = function (pais_id){
        for (var i = 0; i < $scope.paises.length; i++){
            if ($scope.paises[i].id == pais_id){
                return $scope.paises[i].paises_con_idiomas[0].nombre;
            }
        }
    }
    
    $scope.editarDepartamentoModal = function (departamento){
        $scope.errores = null;
        $scope.sw = 2;
        $scope.departamento = angular.copy(departamento);
        $scope.departamentoForm.$setPristine();
        $scope.departamentoForm.$setUntouched();
        $('#myModalLabel').text('Editar departamento');
        $('#departamentosModal').modal('show');
    }
    
    $scope.guardarDepartamento = function (){
        if (!$scope.departamentoForm.$valid){
            return;
        }
        switch($scope.sw){
            case 1:
                departamentosServi.postCreardepartamento($scope.departamento).then(function(data){
                    if (data.success){
                        $scope.departamentos.push(data.departamento);
                        swal('¡Éxito!', 'Departamento agregado con éxito', 'success');
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
                });
                break;
            
            case 2:
                departamentosServi.postEditardepartamento($scope.departamento).then(function(data){
                    if (data.success){
                        for (var i = 0; i < $scope.departamentos.length; i++){
                            if ($scope.departamentos[i].id == data.departamento.id){
                                $scope.departamentos[i] = data.departamento;
                            }
                        }
                        swal('¡Éxito!', 'Departamento editado con éxito', 'success');
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al editar los datos. Por favor, recargue la página.', 'error');
                });
                break;
                
            default:
                swal('Error', 'Error al guardar los datos. Por favor, recargue la página.', 'error');
                break;
        }
    }
    
    $scope.importarCsv = function (){
        var fd = new FormData();
        if ($scope.import_file != null){
            fd.append('import_file', $scope.import_file[0]);
        }else{
            swal('Información', 'No se ha seleccionado ningún archivo.', 'info');
            return;
        }
        console.log($scope.import_file);
        $scope.erroresCSV = null;
        departamentosServi.postImportexcel(fd).then(function (data){
            if (data.success){
                window.location.reload();
            }else{
                $scope.erroresCSV = data.errores;
            }
        })
    }
});