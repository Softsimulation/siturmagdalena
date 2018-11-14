/* global angular */
/* global swal */
angular.module('destinos.index', [])

.controller('destinosIndexController', function($scope, destinosServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    destinosServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.destinos = data.destinos;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (destino){
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.postDesactivarActivar(destino.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                destino.estado = !destino.estado;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.sugerir = function (destino){
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.postSugerir(destino.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                destino.sugerido = !destino.sugerido;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.modalIdioma = function (destino){
        $scope.destinoEdit = destino;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradordestinos/idioma/"+ $scope.destinoEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
});