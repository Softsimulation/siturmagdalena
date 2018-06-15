(function(){

    angular.module("appEncuestaDinamicaPublic", [ 'ngSanitize', 'ui.select', 'checklist-model', "ADM-dateTimePicker", "servicios", "generadorCampos" ] )
    
    .config(["ADMdtpProvider", function(ADMdtpProvider,ChartJsProvider) {
         ADMdtpProvider.setOptions({ calType: "gregorian", format: "YYYY/MM/DD", default: "today" })
    }])
    
    .controller("EncuestaCtrl", ["$scope","ServiEncuesta","$timeout", function($scope,ServiEncuesta,$timeout){
        
        $scope.encuesta = {
            idEncuesta : $("#idEncuesta").val(),
            idSeccion : $("#idSeccion").val(),
            codigo : $("#codigo").val(),
        };
        
        ServiEncuesta.getDataSeccionEncuesta($scope.encuesta)
                .then(function(data){ 
                    $scope.seccion = data;
                    $scope.seccion.idEncuesta = $("#idEncuesta").val();
                    $scope.seccion.codigo = $scope.encuesta.codigo;
                });
                     
        $scope.guardarEncuesta = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            ServiEncuesta.guardarEncuesta($scope.seccion).then(function (data) {
                
                $("body").attr("class", "cbp-spmenu-push");      
                
                if (data.success) {
                    
                    if(data.termino){
                        swal({
                             title: "Encuesta terminada",
                             text: "Gracias por su colaboración.",
                             type: "success",
                             showConfirmButton: true
                         });
                         setTimeout(function () {
                             window.location.href = data.ruta;
                         }, 1000);
                    }
                    else{
                        swal({
                             title: "Realizado",
                             text: "Se ha guardado satisfactoriamente la sección.",
                             type: "success",
                             timer: 1000,
                             showConfirmButton: false
                         });
                         setTimeout(function () {
                             window.location.href = data.ruta;
                         }, 1000);
                    }
                }
                else {
                    $scope.errores = data.errores;
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            });
    
        }
       
        $scope.onEnd = function(){
            $timeout(function(){
                $(".lds-facebook").hide();
                $(".btns").removeClass("hide");
            }, 1);
        };
        
    }])
    
    .controller("RegistroUsuarioEncuestaCtrl", ["$scope","ServiEncuesta", function($scope,ServiEncuesta){
        
        $scope.registroUsuarioEncuesta = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            ServiEncuesta.registroUsuarioEncuesta($scope.usuario).then(function (data) {
                       
                if (data.success) {
                    window.location.href = data.ruta;
                }
                else {
                    $scope.errores = data.errores;
                    sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                }
                
            }).catch(function () {
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            });
            
        }   
        
    }])
    
    .directive("repeatEnd", function(){
        return {
            restrict: "A",
            link: function (scope, element, attrs) {
                if (scope.$last) { scope.$eval(attrs.repeatEnd);  }
            }
        };
    })
    
}());