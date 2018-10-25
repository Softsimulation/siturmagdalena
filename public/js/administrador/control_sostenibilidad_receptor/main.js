angular.module('controlSosRecpApp', ['ControlSostenibilidadService','ADM-dateTimePicker','angularUtils.directives.dirPagination'])

.controller('controlSostenibilidadCtrl', ['$scope','controlSostenibilidadServi',function ($scope,controlSostenibilidadServi) {
    
    
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

        return [year,month,day].join('/');
    }
    
    $scope.registros = [];
    
    $("body").attr("class", "charging");
    controlSostenibilidadServi.listarRegistros().then(function (data) {
        $("body").attr("class", "");
        $scope.registros = data.registros;
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.abrirModalCrear = function(){
        $scope.registro = {};
        $scope.crearForm.$setPristine();
        $scope.crearForm.$setUntouched();
        $scope.crearForm.$submitted = false;
        $('#modalCrear').modal('show');
   }
   
   $scope.guardar = function(){
       if(!$scope.crearForm.$valid){
           return;
       }
       
       
       $("body").attr("class", "charging");
        controlSostenibilidadServi.guardarRegistro($scope.registro).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                $scope.errores = null;
                $scope.registros.push(data.registro);
                swal({
                    title: "Realizado",
                    text: "Registro ingresado exitosamente",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    
                    $('#modalCrear').modal('hide');
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
   
   $scope.abrirEditar = function(item){
    $scope.registro = angular.copy(item);
    $scope.indexEditar = $scope.registros.indexOf(item);
    $scope.editarForm.$setPristine();
    $scope.editarForm.$setUntouched();
    $scope.editarForm.$submitted = false;
    $('#modalEditar').modal('show');       
   }
    
    $scope.editar = function(){
       if(!$scope.editarForm.$valid){
           return;
       }
       
       
       $("body").attr("class", "charging");
        controlSostenibilidadServi.editarRegistro($scope.registro).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                $scope.errores = null;
                $scope.registros[$scope.indexEditar] = $scope.registro;
                swal({
                    title: "Realizado",
                    text: "Registro editado exitosamente",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    
                    $('#modalEditar').modal('hide');
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
    
}])


