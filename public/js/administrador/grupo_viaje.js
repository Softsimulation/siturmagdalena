angular.module('receptor.grupo_viaje', ['ADM-dateTimePicker','grupoViajeService','angularUtils.directives.dirPagination'])

.controller('crear_grupo', ['$scope','grupoViajeServi',function ($scope, grupoViajeServi) {
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY/MM/DD',
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

        return [year, month, day].join('/');
    }
    grupoViajeServi.informacionCrear().then(function (data) {
        $scope.lugares_aplicacion = data.lugares_aplicacion;
        $scope.tipos_viajes = data.tipos_viajes;
        $('#processing').removeClass('process-in');
    }).catch(function () {
        $('#processing').removeClass('process-in');
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    });
    
    $scope.grupo = {};
    
    $scope.grupo.Mayores15 = 0;
    $scope.grupo.Mayores15No = 0;
    $scope.grupo.PersonasMag = 0;
    $scope.grupo.Menores15 = 0;
    $scope.grupo.Menores15No = 0;

    $scope.total = $scope.grupo.Mayores15 + $scope.grupo.Mayores15No + $scope.grupo.Menores15 + $scope.grupo.Menores15No;
    
    $scope.guardar = function () {

        if (!$scope.crearForm.$valid || $scope.total == 0 || $scope.grupo.PersonasEncuestadas > $scope.grupo.Mayores15) {
            return;
        }
        $("body").attr("class", "charging");
        grupoViajeServi.GuardarGrupo($scope.grupo).then(function (data) {
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Grupo #" + data.id + " registrado satisfactoriamente",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "rgb(140, 212, 245)",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                }, function (isConfirm) {
                    window.location.href = "/turismoreceptor/datosencuestados";
                });
            } else {
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    }

    $scope.calcular = function () {
        $scope.total = $scope.grupo.Mayores15 + $scope.grupo.Mayores15No + $scope.grupo.Menores15 + $scope.grupo.Menores15No;
    }
}])

.controller('index_grupo', ['$scope', 'grupoViajeServi','$filter',function ($scope, grupoViajeServi, $filter) {
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year ].join('/');
    }
    $scope.grupos = [];
    $scope.prop = {
        search: '',
        pageSize: 10,
        currentPage: 0
    }
    $scope.orderByField = '';
    $scope.reverseSort = false;
    $("body").attr("class", "charging");
    grupoViajeServi.listadoGrupos().then(function (data) {
        $scope.grupos = data;
        for(var i=0;i<$scope.grupos.length;i++){
            $scope.grupos[i].fecha_aplicacion = formatDate($scope.grupos[i].fecha_aplicacion);
            $scope.grupos[i].encuestasDiligenciadas = $scope.grupos[i].visitantes.length+"/"+$scope.grupos[i].personas_encuestadas;
        }
        $("body").attr("class", "cbp-spmenu-push");
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    $scope.numberOfPages = function () {
        return Math.ceil($scope.getData().length / $scope.prop.pageSize);
    }
    $scope.getData = function () {
        return $filter('filter')($scope.grupos, $scope.prop.search);

    }
    $scope.$watch('prop.search', function () {
        $scope.prop.currentPage = 0;
    })
}])

.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
})

.directive('convertToNumber', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function(val) {
                return parseInt(val, 10);
            });
            ngModel.$formatters.push(function(val) {
                return '' + val;
            });
        }
    };
})

.controller('ver_grupo', ['$scope', 'grupoViajeServi',function ($scope, grupoViajeServi) {
    $scope.total = 0;
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        grupoViajeServi.VerGrupo($scope.id).then(function (data) {
            $scope.grupo = data
            if(data != null){
                $scope.total = $scope.grupo.mayores_quince + $scope.grupo.mayores_quince_no_presentes + $scope.grupo.menores_quince + $scope.grupo.menores_quince_no_presentes;
            }
            var cadena = $scope.grupo.fecha_aplicacion.split(" ")
            cadena = $.grep(cadena, function (n) {return (n);});
            var meses = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var m = meses.indexOf(cadena[0]) + 1
            if (m < 10) {
                m = "0" + m;
            }
            $scope.grupo.fecha_aplicacion = cadena[1] + "/" + m + "/" + cadena[2] + " " + cadena[3];
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    })
}])

.controller('editar_grupo', ['$scope', 'grupoViajeServi','$filter',function ($scope, grupoViajeServi,$timeout, $filter) {
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY/MM/DD',
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

        return [year, month, day].join('/');
    }
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        grupoViajeServi.InformacionEditar($scope.id).then(function (data) {
            $scope.grupo = data.grupo;
            $scope.lugares_aplicacion = data.lugares_aplicacion;
            $scope.tipos_viajes = data.tipos_viajes;
            if(data.grupo != null){
                $scope.total = $scope.grupo.Mayores15 + $scope.grupo.Mayores15No + $scope.grupo.Menores15 + $scope.grupo.Menores15No;
            }
            
            /* cadena = $scope.grupo.Fecha.split(" ")
            cadena = $.grep(cadena, function (n) {return (n);});
            var meses = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var m = meses.indexOf(cadena[0]) + 1
            if (m < 10) {
                m = "0" + m;
            }
            $scope.grupo.fecha_aplicacion = cadena[1] + "/" + m + "/" + cadena[2] + " " + cadena[3];*/
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })

    })

    $scope.calcular = function () {
        $scope.total = $scope.grupo.Mayores15 + $scope.grupo.Mayores15No + $scope.grupo.Menores15 + $scope.grupo.Menores15No;
    }

    $scope.editar = function () {
        if (!$scope.ediForm.$valid || $scope.total == 0 || $scope.grupo.PersonasEncuestadas > $scope.grupo.Mayores15) {
            return;
        }

        //$scope.grupo.Fecha = $('#date_apli').val().toString()
        swal({
            title: "¿Esta seguro de editar?",
            text: "El registro sera modificado.",
            type: "warning", showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $("body").attr("class", "charging");
                grupoViajeServi.EditarGrupo($scope.grupo).then(function (data) {
                    if (data.success) {
                        swal({
                            title: "Realizado",
                            text: "Grupo editado satisfactoriamente",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "rgb(140, 212, 245)",
                            confirmButtonText: "OK",
                            closeOnConfirm: true
                        }, function (isConfirm) {
                            window.location.href = "/grupoviaje/listadogrupos";
                        });
                    } else {
                        swal("Error", "Por favor corrija los errores", "error");
                        $scope.errores = data.errores;
                    }
                    $("body").attr("class", "cbp-spmenu-push");
                }).catch(function () {
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error", "Error en la carga, por favor recarga la página.", "error");
                })
            } else {
                swal("Cancelado", "Se ha cancelado la edición", "error");
                window.location.href = "/grupoviaje/listadogrupos";
            }
        });
    }
}])