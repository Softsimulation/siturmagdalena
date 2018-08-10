/* global angular */
/* global swal */
angular.module('rutas.editar', [])

.controller('rutasEditarController', function($scope, rutasServi, $location, $http){
    $scope.ruta = {
        adicional: {}
    };
    $scope.previewportadaIMG = [];
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        rutasServi.getDatosruta($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.rutaNombre = data.ruta.rutas_con_idiomas[0].nombre;
                $scope.ruta.adicional.atracciones = data.rutas_con_atracciones;
                
                var portada = null;
                if (data.ruta.portada != null){
                    $http.get("../.." + data.ruta.portada, {responseType: "blob"}).success((data) => {
                        portada = data;
                        $scope.previewportadaIMG.push(portada);
                    });
                }
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    rutasServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.atracciones = data.atracciones;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid){
            return;
        }
        var fd = new FormData();
        var input = $('#files-brcc-portadaIMG');
        if (input[0] != undefined) {
            // check for browser support (may need to be modified)
            if (input[0].files && input[0].files.length == 1) {
                if (input[0].files[0].size > 2097152) {
                    swal("Error", "Por favor la imagen debe tener un peso menor de " + (2097152 / 1024 / 1024) + " MB", "error");
                    // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                    return;
                }
            }
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        fd.append('id', $scope.id);
        rutasServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Multimedia modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid){
            return;
        }
        $scope.ruta.adicional.id = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        rutasServi.postGuardaradicional($scope.ruta.adicional).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Información adicional modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});