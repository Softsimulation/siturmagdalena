angular.module('bolsaEmpleoApp', ['bolsaEmpleoService','ADM-dateTimePicker','ui.select'])

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
        $("body").attr("class", "cbp-spmenu-push");
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.guardar = function(){
        
        if(!$scope.datosForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
        $("body").attr("class", "charging");
        bolsaEmpleoServi.crearVacante($scope.vacante).then(function (data) {
            $("body").attr("class", "");
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Vacante creada correctamente",
                    type: "success",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Volver al listado",
                    cancelButtonText: "Crear otra vacante",
                    closeOnConfirm: false,
                    closeOnCancel: false    
                },
                function(isConfirm) {
                  if (isConfirm) {
                    //window.location = "/bolsaEmpleo/vacante";
                  } else {
                    window.location = "/bolsaEmpleo/crear";
                  }
                });
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