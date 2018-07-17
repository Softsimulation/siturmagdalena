angular.module('sostenibilidadPst.ambiental', [])

.controller('ambientalController', ['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    
    $scope.proveedor = {};
    $scope.encuesta = {
        actividadesAmbiente : [],
        programasConservacion : [],
        actividadesResiduos : [],
        accionesEnergia : [],
        accionesAgua : [],
        tiposEnergia : [],
        planesMitigacion : []
    };
    
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        sostenibilidadPstServi.CargarAmbiental($scope.id).then(function (data) {
            $scope.proveedor = data.proveedor;
            $scope.criteriosCalificacion = data.criteriosCalificacion;
            $scope.actividadesAmbiente = data.actividadesAmbiente;
            $scope.programasConservacion = data.programasConservacion;
            $scope.tiposRiesgos = data.tiposRiesgos;
            $scope.planesMitigacion = data.planesMitigacion;
            $scope.periodosInformes = data.periodosInformes;
            $scope.actividadesResiduos = data.actividadesResiduos;
            $scope.accionesEnergia = data.accionesEnergia;
            $scope.accionesAgua = data.accionesAgua;
            $scope.tiposEnergia = data.tiposEnergia;
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
            var i = $scope.encuesta.actividadesAmbiente.indexOf(7);
            if ($scope.encuesta.otroActividad != null && $scope.encuesta.otroActividad != '') {
                if (i == -1) {
                    $scope.encuesta.actividadesAmbiente.push(7);
                }
            }
        } else if (sw == 2) {
            var i = $scope.encuesta.programasConservacion.indexOf(8);
            if ($scope.encuesta.otroPrograma != null && $scope.encuesta.otroPrograma != '') {
                if (i == -1) {
                    $scope.encuesta.programasConservacion.push(8);
                }
            }
        } else if (sw == 3) {
            var i = $scope.encuesta.actividadesResiduos.indexOf(8);
            if ($scope.encuesta.otroActividadRes != null && $scope.encuesta.otroActividadRes != '') {
                if (i == -1) {
                    $scope.encuesta.actividadesResiduos.push(8);
                }
            }
        } else if (sw == 4) {
            var i = $scope.encuesta.accionesAgua.indexOf(7);
            if ($scope.encuesta.otroAgua != null && $scope.encuesta.otroAgua != '') {
                if (i == -1) {
                    $scope.encuesta.accionesAgua.push(7);
                }
            }
        } else if (sw == 5) {
            var i = $scope.encuesta.accionesEnergia.indexOf(17);
            if ($scope.encuesta.otroEnergia != null && $scope.encuesta.otroEnergia != '') {
                if (i == -1) {
                    $scope.encuesta.accionesEnergia.push(17);
                }
            }
        } else if (sw == 6) {
            var i = $scope.encuesta.tiposEnergia.indexOf(4);
            if ($scope.encuesta.otroRenovable != null && $scope.encuesta.otroRenovable != '') {
                if (i == -1) {
                    $scope.encuesta.tiposEnergia.push(4);
                }
            }
        } else if (sw == 7) {
            var i = $scope.encuesta.planesMitigacion.indexOf(9);
            if ($scope.encuesta.otroMitigacion != null && $scope.encuesta.otroMitigacion != '') {
                if (i == -1) {
                    $scope.encuesta.planesMitigacion.push(9);
                }
            }
        }
    }
    
    $scope.guardar = function(){
        
        if( !$scope.datosForm.$valid || $scope.actividadesAmbiente.length == 0 || $scope.programasConservacion.length == 0 || $scope.actividadesResiduos.length == 0 || $scope.accionesAgua.length == 0 || $scope.accionesEnergia.length == 0 || ($scope.encuesta.energias_renovables == 1 && $scope.tiposEnergia.length == 0) ){
            return;
        }
        
        $scope.encuesta.tiposRiesgos = $scope.tiposRiesgos;
        $scope.encuesta.pst_id = $scope.id;
        
        $("body").attr("class", "charging");
        sostenibilidadPstServi.guardarAmbiental($scope.encuesta).then(function (data) {
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
                    window.location = "/sostenibilidadpst/economico/"+$scope.id;
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