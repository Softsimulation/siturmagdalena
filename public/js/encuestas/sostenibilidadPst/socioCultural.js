angular.module('sostenibilidadPst.socioCultural', [])

.controller('socioCulturalController', ['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    
    $scope.proveedor = {};
    $scope.encuesta = {
        accionesCulturales : [],
        motivosResponsabilidad : [],
        esquemasAccesibles : [],
        beneficiosEsquema : []
    };
    
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        sostenibilidadPstServi.getCargarSocioCultural($scope.id).then(function (data) {
            $scope.proveedor = data.proveedor;
            $scope.criteriosCalificacion = data.criteriosCalificacion;
            $scope.accionesCulturales = data.accionesCulturales;
            $scope.motivosResponsabilidad = data.motivosResponsabilidad;
            $scope.tiposDiscapacidad = data.tiposDiscapacidad;
            $scope.esquemasAccesibles = data.esquemasAccesibles;
            $scope.beneficiosEsquema = data.beneficiosEsquema;
            $scope.tiposRiesgos = data.tiposRiesgos;
            $scope.tipoProveedor = data.tipoProveedor;
            if(data.objeto != undefined){
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
            var i = $scope.encuesta.accionesCulturales.indexOf(8);
            if ($scope.encuesta.otroCultural != null && $scope.encuesta.otroCultural != '') {
                if (i == -1) {
                    $scope.encuesta.accionesCulturales.push(8);
                }
            }
        } else if (sw == 2){
            var i = $scope.encuesta.motivosResponsabilidad.indexOf(9);
            if ($scope.encuesta.otroMotivoResp != null && $scope.encuesta.otroMotivoResp != '') {
                if (i == -1) {
                    $scope.encuesta.motivosResponsabilidad.push(9);
                }
            }
        } else if (sw == 3){
            var i = $scope.encuesta.esquemasAccesibles.indexOf(8);
            if ($scope.encuesta.otroEsquemaAcc != null && $scope.encuesta.otroEsquemaAcc != '') {
                if (i == -1) {
                    $scope.encuesta.esquemasAccesibles.push(8);
                }
            }
        } else if (sw == 4){
            var i = $scope.encuesta.beneficiosEsquema.indexOf(7);
            if ($scope.encuesta.otroBeneficio != null && $scope.encuesta.otroBeneficio != '') {
                if (i == -1) {
                    $scope.encuesta.beneficiosEsquema.push(7);
                }
            }
        }
    }
    
    $scope.guardar = function(){
        
        if(!$scope.datosForm.$valid || $scope.encuesta.accionesCulturales.length == 0 || ($scope.encuesta.motivosResponsabilidad.length == 0 && $scope.encuesta.responsabilidad_social == 1) || $scope.encuesta.esquemasAccesibles.length == 0 || ($scope.encuesta.beneficiosEsquema.length == 0 && $scope.encuesta.esquemasAccesibles.indexOf(7) == -1 ) ){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $scope.encuesta.tiposDiscapacidad = $scope.tiposDiscapacidad;
        $scope.encuesta.tiposRiesgos = $scope.tiposRiesgos;
        $scope.encuesta.pst_id = $scope.id;
        $scope.encuesta.tipoProveedor = $scope.tipoProveedor;
        
        
        $("body").attr("class", "charging");
        sostenibilidadPstServi.guardarSocioCultural($scope.encuesta).then(function (data) {
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
                    window.location = "/sostenibilidadpst/ambiental/"+$scope.id;
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