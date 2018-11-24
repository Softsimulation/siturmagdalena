angular.module('interno.gastos', [] )

.controller('gastos', function ($scope, $http, $window, serviInterno) {
  
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        serviInterno.getDataGastos($scope.id).then(function (data) {
            $scope.encuesta = data.encuesta;
            $scope.divisas = data.divisas;
            $scope.financiadores = data.financiadores;
            $scope.opcionesLugares = data.opcionesLugares;
            $scope.serviciosPaquetes = data.serviciosPaquetes;
            
            for(var i=0; i< $scope.encuesta.gastosServicosPaquetes.length ;i++){
               
               for (var j = 0; j < $scope.serviciosPaquetes.length; j++){
                    if ($scope.encuesta.gastosServicosPaquetes[i].servicio_paquete_id == $scope.serviciosPaquetes[j].id) { 
                        $scope.encuesta.gastosServicosPaquetes[i].nombre = $scope.serviciosPaquetes[j].nombre;
                        break;
                    }
                }
                
            }
            
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        });
    });

    $scope.guardar = function () {
        
        if (!$scope.GastoForm.$valid || $scope.encuesta.financiadores.length==0) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }
        
        for (var i = 0; i < $scope.encuesta.gastosServicosPaquetes.length; i++){
            if( ($scope.encuesta.gastosServicosPaquetes[i].dentro+$scope.encuesta.gastosServicosPaquetes[i].fuera) != 100 ){
                swal("Error", "La suma de los porcentajes gastados debe ser igual a 100%.", 'info'); return;
            }
        }
        
        var data = angular.copy($scope.encuesta);
        data.id = $scope.id;
        data.rubros = [];

        if ($scope.encuesta.gastosAparte == 1) {
           
            for (var i = 0; i < $scope.encuesta.rubros.length; i++) {
                if($scope.encuesta.rubros[i].viajes_gastos_internos.length>0){
                    var rubro = $scope.encuesta.rubros[i];
                    if( (rubro.viajes_gastos_internos[0].valor_fuera || rubro.viajes_gastos_internos[0].valor) && rubro.viajes_gastos_internos[0].personas_cubrio ){
                        data.rubros.push({
                            rubros_id : rubro.id,
                            valor_fuera : rubro.viajes_gastos_internos[0].valor_fuera,
                            valor : rubro.viajes_gastos_internos[0].valor,
                            personas_cubrio : rubro.viajes_gastos_internos[0].personas_cubrio,
                            gastos_realizados_otros : rubro.viajes_gastos_internos[0].gastos_realizados_otros
                        });  
                    }
                    else{
                        swal("Error", "por favor corrija los errores y vuelva a intentarlo", 'error');
                        return;
                    }
                }
            }
            
        } 
        
        $("body").attr("class", "cbp-spmenu-push charging");
        
        serviInterno.guardarGastos(data).then(function (data) {
            
            if(data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                 });
                 setTimeout(function () {
                     window.location.href = "/turismointerno/fuentesinformacion/" + $scope.id;
                 }, 1000);
                 

            } else {
                 $("body").attr("class", "cbp-spmenu-push")
                 $scope.errores = data.errores;
                 swal("Error", "Error en el formulario, corrijalos", "error")
            }
             
             $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        })
        
        

    }
    
    
    
    $scope.changeServiciosPaquetes = function(s){
        if(s.id==7 || s.id==8 ){
            if( $scope.encuesta.serviciosPaquetes.indexOf(s.id)!=-1 ){
               $scope.encuesta.gastosServicosPaquetes.push( { servicio_paquete_id:s.id, nombre: s.nombre} );
            }
            else{ 
                for(var i=0; i<$scope.encuesta.gastosServicosPaquetes.length;i++){
                    if( $scope.encuesta.gastosServicosPaquetes[i].servicio_paquete_id==s.id ){ 
                        $scope.encuesta.gastosServicosPaquetes.splice(i,1); break; 
                    }
                }
            }
        }
    }
    
    
})