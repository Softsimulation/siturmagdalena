/* global angular */
/* global swal */
angular.module('rutas.index', [])

.controller('rutasIndexController', function($scope, rutasServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    rutasServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.rutas = data.rutas;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (ruta){
        $("body").attr("class", "cbp-spmenu-push charging");
        rutasServi.postDesactivarActivar(ruta.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                ruta.estado = !ruta.estado;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar la atracción. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.modalIdioma = function (ruta){
        $scope.rutaEdit = ruta;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradorrutas/idioma/"+ $scope.rutaEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
});