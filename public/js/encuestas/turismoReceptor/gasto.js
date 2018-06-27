angular.module('receptor.gasto', ['ui.select'])

.controller('gasto', ['$scope', 'receptorServi', '$window',function ($scope, receptorServi, $window) {

    $scope.encuestaReceptor = {};
    $scope.abrirAlquiler = false;
    $scope.abrirTerrestre = false;
    $scope.abrirRopa = false;
    $scope.$watch('id',function(){
        if($scope.id != null){
             $("body").attr("class", "cbp-spmenu-push charging");
            receptorServi.getInfoGasto($scope.id).then(function(data){
                $scope.divisas = data.divisas;
                $scope.financiadores = data.financiadores;
                $scope.municipios = data.municipios;
                $scope.opciones = data.opciones;
                $scope.servicios = data.servicios;
                $scope.tipos = data.tipos;
                $scope.rubros = data.rubros;
                $scope.encuestaReceptor = data.encuesta;
                
                for(var i = 0; i<$scope.rubros.length;i++){
                    $scope.cambiarAlquiler($scope.rubros[i]);
                }
                
              $("body").attr("class", "cbp-spmenu-push");
            }).catch(function(){
                
              $("body").attr("class", "cbp-spmenu-push");
               swal("Error","Error en la carga de pagina","error"); 
            });
        }
    })
     $scope.limpiarGasto = function(){
        if($scope.encuestaReceptor.RealizoGasto == 0){
            var aux = [];
            aux = $scope.encuestaReceptor.Financiadores;
            $scope.encuestaReceptor = {}
            $scope.encuestaReceptor.Financiadores = aux;
            $scope.encuestaReceptor.RealizoGasto = 0;
            for(var i= 0; i<$scope.rubros.length;i++){
                $scope.rubros[i].gastos_visitantes = [];
            }
        }
    }
    
    $scope.limpiarPaquete = function(){
        if($scope.encuestaReceptor.ViajoDepartamento == 0){
            var aux = [];
            aux = $scope.encuestaReceptor.Financiadores;
            $scope.encuestaReceptor = {}
            $scope.encuestaReceptor.Financiadores = aux;
            $scope.encuestaReceptor.RealizoGasto = 1;
            $scope.encuestaReceptor.ViajoDepartamento = 0
        }
    }
    
    $scope.limpiarRubros = function(){
        if($scope.encuestaReceptor.GastosAparte == 0){
            for(var i= 0; i<$scope.rubros.length;i++){
                $scope.rubros[i].gastos_visitantes = [];
            }
        }
    }
    
    $scope.limpiarLocalizacion = function(){
        if($scope.encuestaReceptor.Proveedor != 1 && $scope.encuestaReceptor.LugarAgencia != undefined ){
            $scope.encuestaReceptor.LugarAgencia = undefined;
        }
    }
    
    $scope.limpiarMunicipios = function(){
        if($scope.encuestaReceptor.IncluyoOtros == 0 ){
            $scope.encuestaReceptor.Municipios = [];
        }
    }
    
    $scope.cambiarAlquiler = function(rub){
        
        if(rub.gastos_visitantes.length==0){
            return;
        }
        
        if( rub.gastos_visitantes[0].personas_cubiertas != null && rub.gastos_visitantes[0].divisas_magdalena!= null && rub.gastos_visitantes[0].cantidad_pagada_magdalena != null){
               switch (rub.id) {
                   case 3:
                        $scope.abrirTerrestre = true;
                       break;
                   case 5:
                        $scope.abrirAlquiler = true;
                       break;
                   case 12:
                        $scope.abrirRopa = true;
                       break;
                   default:
                      break;
               }
        }
        
        if($scope.abrirTerrestre){
            if( rub.id ==3 && rub.gastos_visitantes[0].personas_cubiertas == null && rub.gastos_visitantes[0].divisas_magdalena == null && rub.gastos_visitantes[0].cantidad_pagada_magdalena==null){
                $scope.abrirTerrestre = false;
            }
        }
        if($scope.abrirAlquiler){
            if( rub.id == 5 && rub.gastos_visitantes[0].personas_cubiertas == null && rub.gastos_visitantes[0].divisas_magdalena == null && rub.gastos_visitantes[0].cantidad_pagada_magdalena==null){
                $scope.abrirAlquiler = false;
            }
        }
        if($scope.abrirRopa){
            if( rub.id == 12 && rub.gastos_visitantes[0].personas_cubiertas == null && rub.gastos_visitantes[0].divisas_magdalena == null && rub.gastos_visitantes[0].cantidad_pagada_magdalena==null){
                $scope.abrirRopa = false;
            }
        }
        
    }
    
    $scope.guardar = function(){
        
        if(!$scope.GastoForm.$valid){
            swal("Error","Corrija los errores","error");
            return ;
        }
        if($scope.encuestaReceptor.ViajoDepartamento ==1){
            
            if($scope.encuestaReceptor.ServiciosIncluidos.length==0){
                return;   
            }
        }
        if($scope.encuestaReceptor.RealizoGasto == 1 && ($scope.encuestaReceptor.ViajoDepartamento == 0 && $scope.encuestaReceptor.GastosAparte ==0)){
            return;
        }
        
        $scope.encuestaReceptor.Rubros = [];
        for(var i = 0 ;i<$scope.rubros.length;i++){
            if($scope.rubros[i].gastos_visitantes.length>0){
                if(($scope.rubros[i].gastos_visitantes[0].cantidad_pagada_fuera != null && $scope.rubros[i].gastos_visitantes[0].divisas_fuera != null) || ($scope.rubros[i].gastos_visitantes[0].cantidad_pagada_magdalena != null && $scope.rubros[i].gastos_visitantes[0].divisas_magdalena != null) && $scope.rubros[i].gastos_visitantes[0].personas_cubiertas != null ){
                        $scope.encuestaReceptor.Rubros.push($scope.rubros[i]);
                }
            }
        }
        $scope.encuestaReceptor.id = $scope.id;
         $("body").attr("class", "cbp-spmenu-push charging");
         receptorServi.postGuardarGasto($scope.encuestaReceptor).then(function(data){
              $("body").attr("class", "cbp-spmenu-push");
             if(data.success){
                   swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                   });
                  setTimeout(function () {
                      window.location.href = "/turismoreceptor/seccionpercepcionviaje/" + $scope.id;
                    }, 1000);
             }else{
                 $scope.errores = data.errores;
                 swal("Error","Corrija los errores","error");
             }
             
         }).catch(function(){
              $("body").attr("class", "cbp-spmenu-push");
             swal("Error","Error en la petición","error");
         })
        
    }
}])
.controller('gasto_visitante', ['$scope', '$http', '$window',function ($scope, $http, $window) {

    $scope.encuestaReceptor = {};
    $scope.encuestaReceptor.GastosRubros = [];
    $scope.municipiosSeleccionados = [];

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get('/EncuestaReceptorVisitante/CargarGasto/' + $scope.id)
            .success(function (response) {
                $("body").attr("class", "cbp-spmenu-push");
                $scope.opciones = response;
                $scope.encuestaReceptor = response.encuestaReceptor;
                if (response.encuestaReceptor.Municipios != null) {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, $scope.encuestaReceptor.Municipios);
                } else {
                    putfalse($scope.opciones.municipios);
                    inicializar($scope.opciones.municipios, null);
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
            })
    });
    
    $scope.quitarCiudad = function (ciudad) {
        $scope.opciones.municipios[$scope.opciones.municipios.indexOf(ciudad)].selected = false;
        $scope.encuestaReceptor.Municipios.splice($scope.encuestaReceptor.Municipios.indexOf(ciudad.Id), 1);
    }

    $scope.showParent = function (items, numFilter) {

        if (numFilter != 0) {
            for (var i = 0; i < items.length; i++) {
                if (!items[i].selected) {
                    return true;
                }
            }
        }

        return false;
    }
    
    
   
    
    $scope.guardar = function () {

        if (!$scope.GastoForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return;
        }

        $scope.encuestaReceptor.GastosRubros = [];

        if ($scope.encuestaReceptor.lista != null) {
            var numLista = Object.keys($scope.encuestaReceptor.lista).length;
            for (var i = 0; i < numLista; i++) {
                if (!(($scope.encuestaReceptor.lista[i].PersonasCubiertas == null || $scope.encuestaReceptor.lista[i].PersonasCubiertas == undefined)
                    && ($scope.encuestaReceptor.lista[i].CantidadFuera == null || $scope.encuestaReceptor.lista[i].CantidadFuera == undefined) &&
                    ($scope.encuestaReceptor.lista[i].CantidadDentro == null || $scope.encuestaReceptor.lista[i].CantidadDentro == undefined) &&
                    ($scope.encuestaReceptor.lista[i].DivisaDentro == "" || $scope.encuestaReceptor.lista[i].DivisaDentro == undefined)
                     && ($scope.encuestaReceptor.lista[i].DivisaFuera == "" || $scope.encuestaReceptor.lista[i].DivisaFuera == undefined))) {
                    var aux = $scope.encuestaReceptor.lista[i];
                    if ((aux.DivisaDentro == "39" && aux.CantidadDentro < 1000) || (aux.DivisaFuera == "39" && aux.CantidadFuera < 1000)) {
                        swal("Error", "El valor de las divisas colombianas debe ser mayor a $1,000", "error");
                        return;
                    }
                    $scope.encuestaReceptor.GastosRubros.push(aux);
                } else if ($scope.encuestaReceptor.lista[i].OtrosAsumidos == true) {
                    swal("Error", "Debe seleccionar el número de personas cubiertas en el rubro " + $scope.encuestaReceptor.lista[i].NombreRubro, "error");
                    return;
                }

            }
        }
        $scope.encuestaReceptor.visitante = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.post('/EncuestaReceptorVisitante/guardarGastos', $scope.encuestaReceptor)
         .success(function (data) {
             $("body").attr("class", "cbp-spmenu-push");
             if (data.success == true) {

                 swal({
                     title: "Realizado",
                     text: "Se ha guardado satisfactoriamente la sección.",
                     type: "success",
                     timer: 1000,
                     showConfirmButton: false
                   });
                  setTimeout(function () {
                      window.location.href = "/turismoreceptor/seccionpercepcionviaje/" + $scope.id;
                    }, 1000);
             } else {
                 $("body").attr("class", "cbp-spmenu-push");
                 $scope.errores = data.errores;
                 swal("Error", "Error en la carga, por favor recarga la página", "error");
             }

         }).error(function () {
             $("body").attr("class", "cbp-spmenu-push");
             swal("Error", "No se pudo realizar la petición intentalo nuevamente", 'error');
         })

    }
}]);