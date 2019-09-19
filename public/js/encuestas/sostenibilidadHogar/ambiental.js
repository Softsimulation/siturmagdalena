angular.module('ambiental', [])

.controller('ambientalController', ['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY/MM/DD hh:mm',
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
    $scope.bandera1 = false;
    $scope.bandera2 = false;
    $scope.id = null;
    $scope.ambiental={};
    $scope.ambiental.actividades = [];
    $scope.ambiental.residuos = [];
    $scope.ambiental.aguas = [];
    $scope.ambiental.otroActividad = null;
    $scope.ambiental.otroAccion1 = null;
    $scope.ambiental.otroAccion2 = null;
    
    $("body").attr("class", "cbp-spmenu-push charging");
    $scope.$watch('id',function(){
        if($scope.id != null){
            sostenibilidadHogarServi.getInfoAmbiental($scope.id).then(function(data){
                $("body").attr("class", "cbp-spmenu-push");

                $scope.criterios = data.criterios;
                $scope.actividades = data.actividades;
                $scope.acciones = data.acciones;
                $scope.riesgos = data.riesgos;
                if(data.ambiental == null){
                    $scope.ambiental={};
                    $scope.ambiental.actividades = [];
                    $scope.ambiental.residuos = [];
                    $scope.ambiental.aguas = [];
                    $scope.ambiental.otroActividad = null;
                    $scope.ambiental.otroAccion1 = null;
                    $scope.ambiental.otroAccion2 = null;
                }else{
                    $scope.ambiental = data.ambiental;
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
        
        if(!$scope.ambientalForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $scope.ambiental.id = $scope.id;
        $scope.ambiental.riesgos = [];
        for(var i = 0;i<$scope.riesgos.length;i++){
            if($scope.riesgos[i].calificacion != null){
                $scope.ambiental.riesgos.push($scope.riesgos[i]);
            }
        }
         $("body").attr("class", "cbp-spmenu-push charging");
        sostenibilidadHogarServi.postGuardarAmbiental($scope.ambiental).then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            if(data.success){
                
                swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                  });
                  setTimeout(function () {
                      window.location.href = "/sostenibilidadhogares/economico/" + $scope.id;
                    }, 500);
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
    
    $scope.verificarOtro = function (array,idOtro,input,bandera) {
        
        var i = array.indexOf(idOtro)
        if (input != null && input != '') {
            if (i == -1) {
                array.push(idOtro);
                bandera = true;
            }
        } else {
            if (i !== -1) {
               array.splice(i, 1);
                bandera = false;
            }
        }
    }
    
}]);