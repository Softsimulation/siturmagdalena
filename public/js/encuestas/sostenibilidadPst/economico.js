angular.module('sostenibilidadPst.economico', [])

.controller('economicoController', ['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    
    $scope.proveedor = {};
    $scope.encuesta = {
        clasificacionesProveedor : [],
        aspectosSeleccion : [],
        beneficiosEconomicos : []
    };
    
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        sostenibilidadPstServi.CargarEconomico($scope.id).then(function (data) {
            $scope.proveedor = data.proveedor;
            $scope.clasificacionesProveedor = data.clasificacionesProveedor;
            $scope.aspectosSeleccion = data.aspectosSeleccion;
            $scope.beneficios = data.beneficios;
            $scope.calificacionesFactor = data.calificacionesFactor;
            $scope.beneficiosEconomicos = data.beneficiosEconomicos;
            if(data.objeto){
                $scope.encuesta = data.objeto;
            }
            $("body").attr("class", "");
        }).catch(function () {
            $("body").attr("class", "");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    });
    
    $scope.validarOtro = function (sw) {
        if (sw == 1) {
            var i = $scope.encuesta.clasificacionesProveedor.indexOf(14);
            if ($scope.encuesta.otroClasificacion != null && $scope.encuesta.otroClasificacion != '') {
                if (i == -1) {
                    $scope.encuesta.clasificacionesProveedor.push(14);
                }
            }
        } else if (sw == 2) {
            var i = $scope.encuesta.aspectosSeleccion.indexOf(9);
            if ($scope.encuesta.otroSeleccion != null && $scope.encuesta.otroSeleccion != '') {
                if (i == -1) {
                    $scope.encuesta.aspectosSeleccion.push(9);
                }
            }
        } else if (sw == 3) {
            var i = $scope.encuesta.beneficiosEconomicos.indexOf(12);
            if ($scope.encuesta.otroEconomico != null && $scope.encuesta.otroEconomico != '') {
                if (i == -1) {
                    $scope.encuesta.beneficiosEconomicos.push(12);
                }
            }
        }
    }
    
    $scope.guardar = function(){
        
        if( !$scope.datosForm.$valid || $scope.encuesta.clasificacionesProveedor.length == 0 || $scope.encuesta.aspectosSeleccion.length != 2 || $scope.encuesta.beneficiosEconomicos.length != 3 ){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        
        $scope.encuesta.pst_id = $scope.id;
        $scope.encuesta.beneficios = $scope.beneficios;
        
        $("body").attr("class", "charging");
        sostenibilidadPstServi.guardarEconomico($scope.encuesta).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Sección guardada exitosamente",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location = "/sostenibilidadpst/encuestas";
                }, 500);
            } else {
                swal("Error", "Hay errores en el formulario corrigelos", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "");
            swal("Error", "No se realizo la solicitud, reinicie la página", "error");
        })
        
    }
    
}])