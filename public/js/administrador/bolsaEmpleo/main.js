angular.module('bolsaEmpleoApp', ['bolsaEmpleoService','ADM-dateTimePicker','ui.select','angularUtils.directives.dirPagination'])

.controller('crearVacanteController', ['$scope', 'bolsaEmpleoServi',function ($scope, bolsaEmpleoServi) {
    
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
    
    $scope.vacante = {};
  
    $("body").attr("class", "charging");
    bolsaEmpleoServi.getEmpresas().then(function (data) {
        $scope.proveedores = data.proveedores;
        $scope.nivelesEducacion = data.nivelesEducacion;
        $scope.municipios = data.municipios;
        $scope.tiposCargos = data.tiposCargos;
        $("body").attr("class", "cbp-spmenu-push");
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.guardar = function(banderPublicar){
        
        if(!$scope.datosForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $scope.vacante.banderPublicar = banderPublicar;
        
        $("body").attr("class", "charging");
        bolsaEmpleoServi.crearVacante($scope.vacante).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                
                swal({
                    title: "Realizado",
                    text: "Vacante creada correctamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                
                setTimeout(function () {
                    window.location = "/bolsaEmpleo/vacantes";
                }, 2000);
                
            } else {
                swal("Error", "Hay errores en el formulario corrigelos", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    }
   
}])


.controller('editarVacanteController', ['$scope', 'bolsaEmpleoServi',function ($scope, bolsaEmpleoServi) {
    
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
    
    $scope.vacante = {};
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        bolsaEmpleoServi.getVacante($scope.id).then(function (data) {
            $scope.proveedores = data.proveedores;
            $scope.nivelesEducacion = data.nivelesEducacion;
            $scope.municipios = data.municipios;
            $scope.vacante = data.vacante;
            $scope.tiposCargos = data.tiposCargos;
            
            if($scope.vacante.fecha_vencimiento != undefined){
                $scope.vacante.fecha_vencimiento = $scope.parsearFecha($scope.vacante.fecha_vencimiento);    
            }
            
            $scope.vacante.salario_minimo = $scope.vacante.salario_minimo ? parseFloat($scope.vacante.salario_minimo) : null; 
            $scope.vacante.salario_maximo = $scope.vacante.salario_maximo ? parseFloat($scope.vacante.salario_maximo) : null; 
            
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    });
    
    
    $scope.guardar = function(){
        
        if(!$scope.datosForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $("body").attr("class", "charging");
        bolsaEmpleoServi.editarVacante($scope.vacante).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Vacante editada exitosamente",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    window.location = "/bolsaEmpleo/vacantes";
                }, 1000);
            } else {
                swal("Error", "Hay errores en el formulario corrigelos", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    }
    
    $scope.parsearFecha = function(fecha){
        
        split = fecha.split("-");
        var fechaAp = new Date(split[0], split[1] - 1, split[2]);
        return formatDate(fechaAp);
    }
    
}])


.controller('listarVacantesController', ['$scope', 'bolsaEmpleoServi',function ($scope, bolsaEmpleoServi) {
    
    $("body").attr("class", "charging");
    bolsaEmpleoServi.cargarVacantes().then(function (data) {
        $scope.vacantes = data.vacantes;
        $("body").attr("class", "cbp-spmenu-push");
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.cambiarEstado = function(item){
        var indexCambiar = $scope.vacantes.indexOf(item);
        
        swal({
            title: "Cambiar estado",
            text: "¿Está seguro?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            setTimeout(function () {
                $("body").attr("class", "charging");
                bolsaEmpleoServi.cambiarEstado(item).then(function(data){
                    if(data.success){
                        item.estado = !item.estado;
                        swal({
                            title: "Estado cambiado",
                            text: "Se ha cambiado el estado satisfactoriamente.",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $scope.errores = null;
                    }else{
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                        $scope.errores = data.errores; 
                    }
                     $("body").attr("class", "cbp-spmenu-push");
                }).catch(function(){
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error","Error en la petición, recargue la pagina","error");
                })
            }, 2000);
        });
    }
    
    $scope.cambiarEstadoPublicar = function(item){
        var indexCambiar = $scope.vacantes.indexOf(item);
        
        swal({
            title: "Cambiar estado de publicación",
            text: "¿Está seguro?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            setTimeout(function () {
                $("body").attr("class", "charging");
                bolsaEmpleoServi.cambiarEstadoPublicar(item).then(function(data){
                    if(data.success){
                        item.es_publico = !item.es_publico;
                        swal({
                            title: "Estado cambiado",
                            text: "Se ha cambiado el estado de publicación satisfactoriamente.",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $scope.errores = null;
                    }else{
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                        $scope.errores = data.errores; 
                    }
                     $("body").attr("class", "cbp-spmenu-push");
                }).catch(function(){
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error","Error en la petición, recargue la pagina","error");
                })
            }, 2000);
        });
    }
    
    
}])



.controller('postuladosVacanteController', ['$scope', 'bolsaEmpleoServi',function ($scope, bolsaEmpleoServi) {
    
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
    
    $scope.vacante = {};
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        bolsaEmpleoServi.PostulacionesVacante($scope.id).then(function (data) {
            
            $scope.vacante = data.vacante;
            
            if($scope.vacante.fecha_vencimiento != undefined){
                $scope.vacante.fecha_vencimiento = $scope.parsearFecha($scope.vacante.fecha_vencimiento);    
            }
            
            
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    });
    
    
    
    $scope.parsearFecha = function(fecha){
        
        split = fecha.split("-");
        var fechaAp = new Date(split[0], split[1] - 1, split[2]);
        return formatDate(fechaAp);
    }
    
}])

