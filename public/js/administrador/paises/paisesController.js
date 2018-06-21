/* global angular */
/* global swal */
angular.module('paises.pais', [])

.controller('paisesController', function ($scope, paisServi) {
    /*Variables*/
    $scope.sw = 0;
    $scope.pais = {
        nombre: '',
        idioma: '',
        id: ''
    };
    var paisVer;
    
    paisServi.getDatos().then(function(data){
        if (data.success){
            $scope.paises = data.paises;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function(err){
        swal('Error', 'Error al cargar los datos. Recargue la página por favor.', 'error');
    });
    
    $scope.nuevoPaisModal = function (){
        $scope.pais = {
            nombre: '',
            idioma: '',
            id: ''
        };
        $scope.errores = null;
        $scope.sw = 1;
        $scope.paisForm.$setPristine();
        $scope.paisForm.$setUntouched();
        $('#myModalLabel').text('Nuevo país');
        $('#paisesModal').modal('show');
    }
    
    $scope.verNombre = function(idioma){
        if ($scope.sw == 3 || $scope.sw == 2){
            for(var i in paisVer.paises_con_idiomas){
                if (paisVer.paises_con_idiomas[i].idioma_id == idioma){
                    $scope.pais.nombre = paisVer.paises_con_idiomas[i].nombre;
                    return;
                }
            }
        }
    }
    
    $scope.verPaisModal = function (pais, idioma){
        $scope.sw = 3;
        paisVer = angular.copy(pais);
        $scope.verNombre(idioma);
        $scope.pais.idioma = idioma;
        $scope.errores = null;
        $scope.paisForm.$setPristine();
        $scope.paisForm.$setUntouched();
        $('#myModalLabel').text('Ver país');
        $('#paisesModal').modal('show');
    }
    
    $scope.editarPaisModal = function(pais, idioma){
        $scope.sw = 2;
        $scope.errores = null;
        paisVer = angular.copy(pais);
        $scope.verNombre(idioma);
        $scope.pais.id = pais.id;
        $scope.pais.idioma = idioma;
        $scope.paisForm.$setPristine();
        $scope.paisForm.$setUntouched();
        $('#myModalLabel').text('Editar país');
        $('#paisesModal').modal('show');
    }
    
    $scope.agregarNombre = function(pais){
        $scope.sw = 4;
        $scope.errores = null;
        paisVer = angular.copy(pais);
        $scope.pais.id = pais.id;
        $scope.pais.nombre = paisVer.nombre;
        $scope.paisForm.$setPristine();
        $scope.paisForm.$setUntouched();
        $('#myModalLabel').text('Agregar idioma');
        $('#paisesModal').modal('show');
    }
    
    $scope.guardarPais = function(){
        if(!$scope.paisForm.$valid){
            return;
        }
        switch ($scope.sw) {
            case 1:
                // code
                paisServi.postCreatepais($scope.pais).then(function(data){
                    if (data.success){
                        $scope.paises.unshift(data.pais);
                        swal({
                               title: "Éxito",
                               text: "El país se ha ingresado correctamente",
                               type: "success",
                               showCancelButton: false,
                               closeOnConfirm: true,
                               showLoaderOnConfirm: true,
                           }, function (res) {
                    
                               window.location.reload();
                             
                           });
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al crear el país. Recargue la página.', 'error');
                });
                break;
            case 2:
                // code
                paisServi.postEditarpais($scope.pais).then(function(data){
                    if (data.success){
                        $scope.paises.unshift(data.pais);
                        swal({
                               title: "Éxito",
                               text: "Se ha modificado el país satisfactoriamente.",
                               type: "success",
                               showCancelButton: false,
                               closeOnConfirm: true,
                               showLoaderOnConfirm: true,
                           }, function (res) {
                               window.location.reload();
                           });
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al modificar el país. Recargue la página.', 'error');
                });
                break;
            case 4:
                // code
                paisServi.postAgregarnombre($scope.pais).then(function(data){
                    if (data.success){
                        $scope.paises.unshift(data.pais);
                        swal({
                               title: "Éxito",
                               text: "Se ha agregado el nombre del país satisfactoriamente.",
                               type: "success",
                               showCancelButton: false,
                               closeOnConfirm: true,
                               showLoaderOnConfirm: true,
                           }, function (res) {
                               window.location.reload();
                           });
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al crear el nombre del país. Recargue la página.', 'error');
                });
                break;
            default:
                // code
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
        paisServi.postImportexcel(fd).then(function (data){
            if (data.success){
                window.location.reload();
            }else{
                $scope.erroresCSV = data.errores;
            }
        })
    }
});