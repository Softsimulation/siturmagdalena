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
    $("body").attr("class", "charging");
    sostenibilidadPstServi.getProveedoresRnt().then(function (data) {
        $scope.proveedores = data.proveedores;
        $scope.encuestadores = data.encuestadores;
        $scope.periodos = data.periodos;
        $("body").attr("class", "");
    }).catch(function () {
        $("body").attr("class", "");
        swal("Error", "No se realizo la solicitud, reinicie la página");
    });
    
    $scope.$watch('id', function () {
        if($scope.id != undefined && $scope.id > 0){
            $scope.encuesta.periodo = $scope.id;
        }
    });
    
    $scope.guardar = function(){
        if(!$scope.datosForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
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
                    window.location = "/sostenibilidadpst/sociocultural/"+data.encuesta.id;
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


.controller('editarEncuestaController', ['$scope', 'sostenibilidadPstServi',function ($scope,sostenibilidadPstServi) {
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
    
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        sostenibilidadPstServi.CargarEditarEncuesta($scope.id).then(function (data) {
            $scope.proveedores = data.proveedores;
            $scope.encuestadores = data.encuestadores;
            $scope.encuesta = data.encuesta;
            $scope.periodos = data.periodos;
            
            var split1 = data.encuesta.fecha_aplicacion.split(" ");
            var split2 = split1[1].split(":");
            split1 = split1[0].split("-");
            var fechaAp = new Date(split1[0], split1[1] - 1, split1[2],split2[0],split2[1]);
            $scope.encuesta.fechaAplicacion = formatDate(fechaAp) + " " + split2[0] + ":" + split2[1];
            $("body").attr("class", "");
        }).catch(function () {
            $("body").attr("class", "");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    });
    
    $scope.guardar = function(){
        if(!$scope.datosForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $("body").attr("class", "charging");
        
        sostenibilidadPstServi.guardarEditarEncuesta($scope.encuesta).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Sección editada exitosamente",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location = "/sostenibilidadpst/sociocultural/"+$scope.encuesta.id;
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



