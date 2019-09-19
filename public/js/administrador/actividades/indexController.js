/* global angular */
/* global swal */
angular.module('actividades.index', [])

.controller('actividadesIndexController', function($scope, actividadesServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    actividadesServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.actividades = data.actividades;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (atraccion){
        $("body").attr("class", "cbp-spmenu-push charging");
        actividadesServi.postDesactivarActivar(atraccion.id).then(function (data){
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
        actividadesServi.postSugerir(atraccion.id).then(function (data){
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
    
    $scope.modalIdioma = function (actividad){
        $scope.actividadEdit = actividad;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradoractividades/idioma/"+ $scope.actividadEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
});