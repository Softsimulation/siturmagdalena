/* global angular */
/* global swal */
angular.module('rutas.idioma', [])

.controller('rutasIdiomaController', function($scope, rutasServi){
    $scope.ruta = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        rutasServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.ruta.datosGenerales = {
                    'nombre': data.ruta.rutas_con_idiomas[0].nombre,
                    'descripcion' : data.ruta.rutas_con_idiomas[0].descripcion,
                    'recomendacion' : data.ruta.rutas_con_idiomas[0].recomendacion
                };
            }
            $scope.idioma = data.idioma;
        }).catch(function (errs){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarIdiomaForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.ruta.datosGenerales.id = $scope.id;
        $scope.ruta.datosGenerales.idIdioma = $scope.idIdioma;
        rutasServi.postEditaridioma($scope.ruta.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Ruta modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});