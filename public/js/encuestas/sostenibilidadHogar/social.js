angular.module('social', [])

.controller('socialController', ['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD/MM/YYYY hh:mm',
        zIndex: 1060,
        autoClose: true,
        default: '',
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };
    
    $scope.bandera = false;
    $scope.id = null;
    $scope.social={};
    $scope.social.culturales = [];
    $scope.social.otroCultura= null;
    $("body").attr("class", "cbp-spmenu-push charging");
    $scope.$watch('id',function(){
        if($scope.id != null){
            sostenibilidadHogarServi.getInfoSocial($scope.id).then(function(data){
                $("body").attr("class", "cbp-spmenu-push");
                $scope.estratos = data.estratos;
                $scope.barrios = data.barrios;
                $scope.criterios = data.criterios;
                $scope.culturales = data.culturales;
                $scope.riesgos = data.riesgos;
                $scope.factores = data.factores;
                $scope.factoresPositivos = data.factoresPositivos;
                $scope.calificacionFactor = data.calificacionFactor;
                $scope.beneficios = data.beneficios;
                if(data.social == null){
                    $scope.social={};
                    $scope.social.culturales = [];
                    $scope.social.otroCultura= null;
                }else{
                    $scope.social = data.social;
                }
            }).catch(function(){
                 $("body").attr("class", "cbp-spmenu-push");
                swal("Error","Error en la peticion","error");
             })
        }else{
             $("body").attr("class", "cbp-spmenu-push");
             swal("Error","Error en la peticion","error");
        }
        
    });
    
    $scope.guardar = function(){
        
        if(!$scope.socialForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $scope.social.id = $scope.id;
        $scope.social.riesgos = [];
        for(var i = 0;i<$scope.riesgos.length;i++){
            if($scope.riesgos[i].calificacion != null){
                $scope.social.riesgos.push($scope.riesgos[i]);
            }
        }
        $scope.social.factores = [];
        for( i = 0;i<$scope.factores.length;i++){
            if($scope.factores[i].calificacion != null){
                $scope.social.factores.push($scope.factores[i]);
            }
        }
        $scope.social.factoresPositivos = [];
        for( i = 0;i<$scope.factoresPositivos.length;i++){
            if($scope.factoresPositivos[i].calificacion != null){
                $scope.social.factoresPositivos.push($scope.factoresPositivos[i]);
            }
        }
        
        $scope.social.beneficios = [];
        for( i = 0;i<$scope.beneficios.length;i++){
            if($scope.beneficios[i].calificacion != null){
                $scope.social.beneficios.push($scope.beneficios[i]);
            }
        }
         $("body").attr("class", "cbp-spmenu-push charging");
        sostenibilidadHogarServi.postGuardarSocial($scope.social).then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            if(data.success){
                //swal("Éxito","Se ha guardado con exito","success");
                swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                  });
                  setTimeout(function () {
                      window.location.href = "/sostenibilidadhogares/componenteambiental/" + $scope.id;
                    }, 1000);
            }else{
                $scope.errores = data.errores;
                swal("Error","Corrija los errores","error")
            }
        }).catch(function(){
             $("body").attr("class", "cbp-spmenu-push");
            swal("Error","Error en la carga","error");
        });
    }
    
    $scope.verificarOtroTabla = function(array,idOtro){
        
        for(var i = 0;i<array.length;i++){
            if(array[i].id == idOtro){
                if(array[i].calificacion != undefined){
                    return true;
                }
            }
        }
        
        return false;
        
    }
    
    $scope.verificarOtro = function (array,idOtro,input) {
        
        var i = array.indexOf(idOtro)
        if (input != null && input != '') {
            if (i == -1) {
                array.push(idOtro);
                $scope.bandera = true;
            }
        } else {
            if (i !== -1) {
               array.splice(i, 1);
                $scope.bandera = false;
            }
        }
    }
    
}]);