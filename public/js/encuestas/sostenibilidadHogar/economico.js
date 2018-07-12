angular.module('sostenibilidadHogar.economico', [])

.controller('economicoController', ['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
    
    $scope.proveedor = {};
    $scope.encuesta = {
        sectoresTurismo : [],
        sectoresEconomia : []
    };
    
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        sostenibilidadHogarServi.getInfoEconomico($scope.id).then(function (data) {
            $scope.sectoresTurismo = data.sectoresTurismo;
            $scope.sectoresEconomia = data.sectoresEconomia;
            $scope.beneficios = data.beneficios;
            $scope.calificacionesFactor = data.calificacionesFactor;
            $scope.tiposRiesgos = data.tiposRiesgos;
            $scope.criteriosCalificacion = data.criteriosCalificacion;
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
            var i = $scope.encuesta.sectoresTurismo.indexOf(7);
            if ($scope.encuesta.otroSectorTurismo != null && $scope.encuesta.otroSectorTurismo != '') {
                if (i == -1) {
                    $scope.encuesta.sectoresTurismo.push(7);
                }
            }
        } else if (sw == 2) {
            var i = $scope.encuesta.sectoresEconomia.indexOf(12);
            if ($scope.encuesta.otroSectorEconomia != null && $scope.encuesta.otroSectorEconomia != '') {
                if (i == -1) {
                    $scope.encuesta.sectoresEconomia.push(12);
                }
            }
        }
    }
    
    $scope.guardar = function(){
        
        if( !$scope.datosForm.$valid || $scope.encuesta.sectoresTurismo.length == 0 || ($scope.encuesta.sectoresEconomia.length == 0 && $scope.encuesta.sectoresTurismo.indexOf(6) == -1 && $scope.encuesta.sectoresTurismo.length > 0 )  ){
            return;
        }
        
        
        $scope.encuesta.hogar_id = $scope.id;
        $scope.encuesta.beneficios = $scope.beneficios;
        $scope.encuesta.tiposRiesgos = $scope.tiposRiesgos;
        
        $("body").attr("class", "charging");
        sostenibilidadHogarServi.GuardarEconomico($scope.encuesta).then(function (data) {
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
                    window.location = "/sostenibilidadhogares/encuestas";
                }, 1000);
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