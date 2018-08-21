/* global angular */
/* global swal */
angular.module('eventos.idioma', [])

.controller('eventosIdiomaController', function($scope, eventosServi){
    $scope.evento = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.evento.datosGenerales = {
                    'nombre': data.evento.eventos_con_idiomas[0].nombre,
                    'descripcion' : data.evento.eventos_con_idiomas[0].descripcion,
                    'horario' : data.evento.eventos_con_idiomas[0].horario,
                    'edicion' : data.evento.eventos_con_idiomas[0].edicion
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
        $scope.evento.datosGenerales.id = $scope.id;
        $scope.evento.datosGenerales.idIdioma = $scope.idIdioma;
        eventosServi.postEditaridioma($scope.evento.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Evento modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});