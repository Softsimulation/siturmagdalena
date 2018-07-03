angular.module('sostenibilidadPst.configuracion', [])

.controller('configuracionController', ['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD/MM/YYYY hh:mm',
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
    
    $scope.proveedores = [];
    $scope.encuesta = {};
    sostenibilidadPstServi.getProveedoresRnt().then(function (data) {
        $scope.proveedores = data.proveedores;
    }).catch(function () {
        swal("Error", "No se realizo la solicitud, reinicie la página");
    });
    
    $scope.guardar = function(){
        if(!$scope.datosForm.$valid){
            return;
        }
        
        $("body").attr("class", "charging");
        sostenibilidadPstServi.postCrearEncuesta($scope.encuesta).then(function (data) {
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
                    //window.location = "/turismoreceptor/seccionestancia/"+data.encuesta.id;
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