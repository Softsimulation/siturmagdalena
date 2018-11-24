/* global angular */
/* global swal */
angular.module('atracciones.index', [])

.controller('atraccionesIndexController', function($scope, atraccionesServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    atraccionesServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.atracciones = data.atracciones;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (atraccion){
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.postDesactivarActivar(atraccion.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                atraccion.estado = !atraccion.estado;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
     $scope.sugerir = function (atraccion){
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.postSugerir(atraccion.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                atraccion.sugerido = !atraccion.sugerido;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.modalIdioma = function (atraccion){
        $scope.atraccionEdit = atraccion;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradoratracciones/idioma/"+ $scope.atraccionEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
});