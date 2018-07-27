/* global angular */
/* global swal */
angular.module('actividades.idioma', [])

.controller('actividadesIdiomaController', function($scope, actividadesServi){
    $scope.actividad = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        actividadesServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.actividad.datosGenerales = {
                    'nombre': data.actividad.actividades_con_idiomas[0].nombre,
                    'descripcion' : data.actividad.actividades_con_idiomas[0].descripcion
                };
            }
            $scope.idioma = data.idioma;
        }).catch(function (errs){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarActividadForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.actividad.datosGenerales.id = $scope.id;
        $scope.actividad.datosGenerales.idIdioma = $scope.idIdioma;
        actividadesServi.postEditaridioma($scope.actividad.datosGenerales).then(function(data){
            if (data.success){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.actividad.datosGenerales = {
                    'nombre': data.actividad.actividades_con_idiomas[0].nombre,
                    'descripcion' : data.actividad.actividades_con_idiomas[0].descripcion
                };
                swal('¡Éxito!', 'Actividad modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});