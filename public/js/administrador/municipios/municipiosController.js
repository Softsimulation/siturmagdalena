/* global angular */
/* global swal */
angular.module('municipios.municipio', [])

.controller('municipiosController', function($scope, municipiosServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    municipiosServi.getDatos().then(function (data){
        if (data.success){
            $scope.departamentos = data.departamentos;
            $scope.municipios = data.municipios;
            $("body").attr("class", "cbp-spmenu-push");
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.verMunicipioModal = function (municipio){
        $scope.errores = null;
        $scope.sw = 3;
        $scope.municipio = angular.copy(municipio);
        $('#myModalLabel').text('Ver municipio');
        $('#municipiosModal').modal('show');
    }
    
    $scope.nuevoMunicipioModal = function (){
        $scope.errores = null;
        $scope.sw = 1;
        $scope.municipio = null;
        $scope.municipioForm.$setPristine();
        $scope.municipioForm.$setUntouched();
        $('#myModalLabel').text('Nuevo municipio');
        $('#municipiosModal').modal('show');
    }
    
    $scope.imprimirNombre = function (departamento_id){
        for (var i = 0; i < $scope.departamentos.length; i++){
            if ($scope.departamentos[i].id == departamento_id){
                return $scope.departamentos[i].nombre + ', ' + $scope.departamentos[i].paise.paises_con_idiomas[0].nombre;
            }
        }
    }
    
    $scope.editarMunicipioModal = function (municipio){
        $scope.errores = null;
        $scope.sw = 2;
        $scope.municipio = angular.copy(municipio);
        $scope.municipioForm.$setPristine();
        $scope.municipioForm.$setUntouched();
        $('#myModalLabel').text('Editar municipio');
        $('#municipiosModal').modal('show');
    }
    
    $scope.guardarMunicipio = function (){
        if (!$scope.municipioForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        switch($scope.sw){
            case 1:
                municipiosServi.postCrearmunicipio($scope.municipio).then(function (data){
                    $("body").attr("class", "cbp-spmenu-push");
                    if (data.success){ 
                        $scope.municipios.push(data.municipio);
                        $('#municipiosModal').modal('hide');
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function (){
                    $("body").attr("class", "cbp-spmenu-push");
                    swal('Error', 'Error al ingresar el municipio. Intente de nuevo', 'error');
                });
                break;
            
            case 2:
                municipiosServi.postEditarmunicipio($scope.municipio).then(function (data){
                    if (data.success){
                        $("body").attr("class", "cbp-spmenu-push");
                        for (var i = 0; i < $scope.municipios.length; i++){
                            if ($scope.municipios[i].id == data.municipio.id){
                                $scope.municipios[i] = data.municipio;
                                break;
                            }
                        }
                        $('#municipiosModal').modal('hide');
                    }else{
                        $("body").attr("class", "cbp-spmenu-push");
                        $scope.errores = data.errores;
                    }
                })
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
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.erroresCSV = null;
        municipiosServi.postImportexcel(fd).then(function (data){
            if (data.success){
                $("body").attr("class", "cbp-spmenu-push");
                window.location.reload();
            }else{
                $scope.erroresCSV = data.errores;
            }
        })
    }
});