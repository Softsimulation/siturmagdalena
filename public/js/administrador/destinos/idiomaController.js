/* global angular */
/* global swal */
angular.module('destinos.idioma', [])

.controller('destinosIdiomaController', function($scope, destinosServi){
    $scope.destino = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.destino.datosGenerales = {
                    'nombre': data.destino.destino_con_idiomas[0].nombre,
                    'descripcion' : data.destino.destino_con_idiomas[0].descripcion
                };
            }
            $scope.idioma = data.idioma;
        }).catch(function (errs){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarDestinoForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.destino.datosGenerales.id = $scope.id;
        $scope.destino.datosGenerales.idIdioma = $scope.idIdioma;
        destinosServi.postEditaridioma($scope.destino.datosGenerales).then(function(data){
            if (data.success){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.destino.datosGenerales = {
                    'nombre': data.destino.destino_con_idiomas[0].nombre,
                    'descripcion' : data.destino.destino_con_idiomas[0].descripcion
                };
                swal('¡Éxito!', 'Destino modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});