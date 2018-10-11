/* global angular */
/* global swal */
angular.module('proveedores.idioma', [])

.controller('proveedoresIdiomaController', function($scope, proveedoresServi){
    $scope.proveedor = {};

    $scope.$watchGroup(['id', 'idIdioma'], function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.getDatosIdioma($scope.id, $scope.idIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.proveedor.datosGenerales = {
                    'nombre': data.proveedor.proveedor_rnt.idiomas[0].nombre,
                    'descripcion' : data.proveedor.proveedor_rnt.idiomas[0].descripcion,
                    'horario' : data.proveedor.proveedores_con_idiomas[0].horario
                };
            }
            $scope.idioma = data.idioma;
        }).catch(function (errs){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarProveedorForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.proveedor.datosGenerales.id = $scope.id;
        $scope.proveedor.datosGenerales.idIdioma = $scope.idIdioma;
        proveedoresServi.postEditaridioma($scope.proveedor.datosGenerales).then(function(data){
            if (data.success){
                $scope.proveedor.datosGenerales = {
                    'nombre': data.proveedor.proveedor_rnt.idiomas[0].nombre,
                    'descripcion' : data.proveedor.proveedor_rnt.idiomas[0].descripcion,
                    'horario' : data.proveedor.proveedores_con_idiomas[0].horario
                };
                swal('¡Éxito!', 'Proveedor modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
});