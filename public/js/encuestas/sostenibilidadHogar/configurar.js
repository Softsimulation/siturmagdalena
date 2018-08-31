angular.module('crear', [])

.controller('crearController', ['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD hh:mm',
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
    
    $scope.minfecha = '2018-01-01';
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('/');
    }
    
  
    $("body").attr("class", "cbp-spmenu-push charging");
 
    sostenibilidadHogarServi.getInfoCrear().then(function(data){
       
        $scope.estratos = data.estratos;
        $scope.barrios = data.barrios;
        $scope.encuestadores = data.encuestadores;
         $("body").attr("class", "cbp-spmenu-push");
    }).catch(function(){
         $("body").attr("class", "cbp-spmenu-push");
        swal("Error","Error en la peticion","error");
     });
        
        
 
    
    $scope.guardar = function(){
        
        if(!$scope.crearForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
         $("body").attr("class", "cbp-spmenu-push charging");
        sostenibilidadHogarServi.postGuardarCrear($scope.social).then(function(data){
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
                      window.location.href = "/sostenibilidadhogares/componentesocial/" + data.id;
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

    
}])

.controller('editarController', ['$scope', 'sostenibilidadHogarServi',function ($scope,sostenibilidadHogarServi) {
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
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('/');
    }
    
    

        
    $("body").attr("class", "cbp-spmenu-push charging");
    $scope.$watch('id',function(){
        if($scope.id != null){
            sostenibilidadHogarServi.getInfoEditar($scope.id).then(function(data){
       
                $scope.estratos = data.estratos;
                $scope.barrios = data.barrios;
                $scope.encuestadores = data.encuestadores;
                $scope.social = data.casa;
                $scope.social.fecha_aplicacion = $scope.social.fecha_aplicacion.substring(0,$scope.social.fecha_aplicacion.length-3);
                 $("body").attr("class", "cbp-spmenu-push");
            }).catch(function(){
                 $("body").attr("class", "cbp-spmenu-push");
                swal("Error","Error en la peticion","error");
             });
        }else{
             $("body").attr("class", "cbp-spmenu-push");
             swal("Error","Error en la peticion","error");
        }
        
    });
 
    
    $scope.guardar = function(){
        
        if(!$scope.crearForm.$valid){
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return;
        }
        
         $("body").attr("class", "cbp-spmenu-push charging");
        sostenibilidadHogarServi.postEditarCrear($scope.social).then(function(data){
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
                      window.location.href = "/sostenibilidadhogares/componentesocial/" + $scope.social.id;
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

    
}]);