(function(){

    angular.module("appIndicadoresSecundarios", [ "angular.filter", "EstadisticasSecuentariasServices" ] )

    
    .controller("EstadisticasSecundariasCtrl", ["$scope","estadisticasSecundariasServi", function($scope,estadisticasSecundariasServi){
        
        estadisticasSecundariasServi.getDataConfiguracion()
            .then(function(data){
                $scope.anios = data.anios;
                $scope.meses = data.meses;
                $scope.data = data.data;
            });
      
       
        $scope.guardarData = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            estadisticasSecundariasServi
                .guardarData($scope.indicador)
                .then(function (data) {
                       
                        if (data.success) {
                           
                            swal("¡Periodo guardado!", "El perido se ha guardado exitosamnete", "success");
                            $("#modalConfiData").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                       
                        $("body").attr("class", "cbp-spmenu-push");
                       
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
       
        $scope.OpenModal = function (isCrear, yearID, indicadorEditar) {
            
            var indicador = angular.copy( indicadorEditar );
            indicador.es_crear = isCrear;
            indicador.yearID = !isCrear ? yearID : null; 
            $scope.indicador = indicador;
            
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalConfiData").modal("show");
        }
        
        $scope.OpenModalIndicador = function (indicador) {
            
            $scope.indicadorCrearEditar =  indicador ? indicador :{ series:[], rotulos:[] };
            $scope.incluirRorulos =  $scope.indicadorCrearEditar.rotulos.length>0 ? 1: 0;
            $scope.formCrear.$setPristine();
            $scope.formCrear.$setUntouched();
            $scope.formCrear.$submitted = false;
            $("#modalIndicador").modal("show");
        }
       
        
        $scope.guardarIndicador = function () {

            if (!$scope.formCrear.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            estadisticasSecundariasServi
                .guardarIndicador($scope.indicadorCrearEditar)
                .then(function (data) {
                       
                        if (data.success) {
                           
                            swal("¡Periodo guardado!", "El perido se ha guardado exitosamnete", "success");
                            $("#modalConfiData").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                       
                        $("body").attr("class", "cbp-spmenu-push");
                       
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
        
        
        $scope.filterData = function(array){
            var x = [];
            for(var i=0; i<array.length; i++){ x.push({ id:array[i].id,  nombre:array[i].nombre }); }
            return x;
        }
        
        $scope.initValorMeses = function(idMes, array){
            for(var i=0; i<array.length; i++){ 
                if(array[i].mes_indicador_id==idMes && array[i].anio_id==$scope.indicador.yearID){ 
                    return {  mes:idMes, anio: array[i].anio_id, valor:array[i].valor };
                }
            }
            return {  mes:idMes, anio:$scope.indicador.yearID };
        }
        
        $scope.initValorRotulos = function(idRotulo, array){
            for(var i=0; i<array.length; i++){ 
                if(array[i].rotulo_estadistica_id==idRotulo && array[i].anio_id==$scope.indicador.yearID){ 
                    return {  rotulo:idRotulo, anio: array[i].anio_id, valor:array[i].valor };
                }
            }
            return {  rotulo:idRotulo, anio:$scope.indicador.yearID };
        }
        
        
        $scope.changeSelectYear = function(){
            for(var i=0; i<$scope.indicador.series.length; i++){ 
                for(var j=0; j<$scope.indicador.series[i].valores.length; j++){ 
                   $scope.indicador.series[i].valores[j].anio = $scope.indicador.yearID;
                }
            }
        }
        
        
    }])
    

    
}());