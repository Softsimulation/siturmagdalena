/* global angular */
/* global swal */
angular.module('proveedores.index', [])

.controller('proveedoresIndexController', function($scope, proveedoresServi){
    $("body").attr("class", "cbp-spmenu-push charging");
    proveedoresServi.getDatos().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.proveedores = data.proveedores;
            $scope.idiomas = data.idiomas;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.desactivarActivar = function (proveedor){
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postDesactivarActivar(proveedor.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                proveedor.estado = !proveedor.estado;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar el proveedor. Por favor, recargue la página.', 'error');
        });
    }
    
     $scope.sugerir = function (proveedor){
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postSugerir(proveedor.id).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                proveedor.sugerido = !proveedor.sugerido;
                swal('¡Éxito!', 'Operación realizada con éxito.', 'success');
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al desactivar el proveedor. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.modalIdioma = function (proveedor){
        $scope.proveedorEdit = proveedor;
        $("#idiomaModal").modal('show');
    }
    
    $scope.nuevoIdioma = function (){
        if ($scope.idiomaEditSelected == ""){
            swal("Información", 'Elija un idioma.', 'info');
            return;
        }
        window.location = "/administradorproveedores/idioma/"+ $scope.proveedorEdit.id +"/" + $scope.idiomaEditSelected;
    }
    
});