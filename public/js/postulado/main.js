angular.module('postuladoApp', ["postuladoService","ADM-dateTimePicker","ui.select"])

.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            })

        }

    }

}])

.controller('crearPostuladoCtrl', ['$scope', 'postuladoServi',function ($scope, postuladoServi) {
   
   $scope.usuario = {};
   
   $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD/MM/YYYY',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };
    
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day,month,year].join('/');
    }
    
    $("body").attr("class", "charging");
    postuladoServi.CargarCrearPostulado().then(function (data) {
        $scope.departamentos = data.departamentos;
        $("body").attr("class", "cbp-spmenu-push");
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.changemunicipio = function(){
        if($scope.usuario.departamento != undefined){
            $scope.municipios = [];
            $("body").attr("class", "charging");
            postuladoServi.CargarMunicipios($scope.usuario.departamento).then(function (data) {
                $scope.municipios = data;
                $("body").attr("class", "cbp-spmenu-push");
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página.", "error");
            })
        }
    }
    
    $scope.guardarUsuario = function(){
        if(!$scope.crearForm.$valid){
            swal("Error", "Verifique que el formulario este correcto.", "error");
            return;
        }
        
        if($scope.usuario.password1 != $scope.usuario.password2){
            swal("Error", "Verifique que la contraseña coincida.", "error");
            return;
        }
        
        $("body").attr("class", "charging");
        postuladoServi.CrearPostulante($scope.usuario).then(function (data) {
            if(data.success){
                swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                  });
                  setTimeout(function () {
                      if($scope.id != undefined){
                        window.location.href = "/postulado/postular/" + $scope.id;    
                      }else{
                        window.location.href = "/";  
                      }
                      
                    }, 500);
            }else{
                $scope.errores = data.errores;
                
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    }
   
}])