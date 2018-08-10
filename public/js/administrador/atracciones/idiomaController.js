/* global angular */
/* global swal */
angular.module('atracciones.idioma', [])

.controller('atraccionesIdiomaController', function($scope, atraccionesServi){
    $scope.atraccion = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.atraccion.datosGenerales = {
                    'nombre': data.atraccion.sitio.sitios_con_idiomas[0].nombre,
                    'descripcion' : data.atraccion.sitio.sitios_con_idiomas[0].descripcion,
                    'horario' : data.atraccion.atracciones_con_idiomas[0].horario,
                    'actividad' : data.atraccion.atracciones_con_idiomas[0].periodo,
                    'recomendaciones' : data.atraccion.atracciones_con_idiomas[0].recomendaciones,
                    'reglas' : data.atraccion.atracciones_con_idiomas[0].reglas,
                    'como_llegar' : data.atraccion.atracciones_con_idiomas[0].como_llegar,
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
        $scope.atraccion.datosGenerales.id = $scope.id;
        $scope.atraccion.datosGenerales.idIdioma = $scope.idIdioma;
        atraccionesServi.postEditaridioma($scope.atraccion.datosGenerales).then(function(data){
            if (data.success){
                $scope.errores = null;
                $("body").attr("class", "cbp-spmenu-push");
                $scope.atraccion.datosGenerales = {
                    'nombre': data.atraccion.sitio.sitios_con_idiomas[0].nombre,
                    'descripcion' : data.atraccion.sitio.sitios_con_idiomas[0].descripcion,
                    'horario' : data.atraccion.atracciones_con_idiomas[0].horario,
                    'actividad' : data.atraccion.atracciones_con_idiomas[0].periodo,
                    'recomendaciones' : data.atraccion.atracciones_con_idiomas[0].recomendaciones,
                    'reglas' : data.atraccion.atracciones_con_idiomas[0].reglas,
                    'como_llegar' : data.atraccion.atracciones_con_idiomas[0].como_llegar,
                };
                swal('¡Éxito!', 'Atracción modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});