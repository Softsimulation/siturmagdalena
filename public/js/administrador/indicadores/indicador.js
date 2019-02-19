var pp=angular.module('admin.indicadores', ['serviceIndicadores','angularUtils.directives.dirPagination'])

.controller('indicadoresCtrl', ['$scope','serviceIndicador',function ($scope,serviceIndicador) {
    
     $("body").attr("class", "cbp-spmenu-push charging");
    serviceIndicador.getInfo()
        .then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            $scope.anios = data.anios;
            $scope.meses = data.meses;
            $scope.indicadores = data.indicadores;
            $scope.tiposMedicion = data.tiposMedicion;
            $scope.indicadoresMedicion = data.indicadoresMedicion;
        })
        .catch(function(){
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la pagina", "error");
        });

    $scope.abrirModal = function(){
        $scope.indicador={};
        $scope.indicadorForm.$setPristine();
        $scope.indicadorForm.$setUntouched();
        $('#calcularIndicadores').modal();
        
    }
    
    $scope.guardar = function(){
        
        if(!$scope.indicadorForm.$valid){
            swal("Error","Corrija los errores","error");
            return;
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        serviceIndicador.guardar($scope.indicador)
        .then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            if(data.success){
                swal("Exito","Se ha calculado exitosamente","success");
                $scope.indicadoresMedicion = data.indicadoresMedicion;
                $('#calcularIndicadores').modal('hide');
            }else{
                
                swal("Error","Error en el cálculo","error");
                $scope.errores = data.errores;
            }
        })
        .catch(function(){
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la pagina", "error");
        });
    }
    
    $scope.recalcular = function(obj){
           swal({
            title: "¿Desea recalcular este indicador?",
            text: "¿Está seguro?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function () {
            $("body").attr("class", "cbp-spmenu-push charging");
            $scope.enviar = {};
            $scope.enviar.indicador = obj;
            serviceIndicador.recalcular($scope.enviar)
                .then(function (data) {
                    $("body").attr("class", "cbp-spmenu-push");
                    if (data.success) {
                        swal("Exito","Se ha calculado exitosamente","success");
                        $scope.indicadoresMedicion = data.indicadoresMedicion;
                    } else {
                         swal("Error","Error en el cálculo","error");
                        $scope.errores = data.errores;
                    }
                }).catch(function () {
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error");
                })
        });

    }
}])

