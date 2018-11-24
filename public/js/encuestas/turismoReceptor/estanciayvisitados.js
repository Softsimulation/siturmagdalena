angular.module('receptor.estanciayvisitados', [])

.controller('estancia', ['$scope', 'receptorServi','$filter',function ($scope, receptorServi,$filter) {
    //$scope.ide = 0;
    $scope.encuesta = {
        ActividadesRelizadas :[]
    };
    $scope.MensajeAlojamiento = false;

    
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        receptorServi.getDatosEstancia($scope.id).then(function (data) {
            $scope.Datos = data.Enlaces;
            //$scope.transformarObjeto($scope.Datos);
            if(data.encuesta != undefined){
                $scope.encuesta = data.encuesta;   
                if (data.encuesta.Estancias == null) {
                    $scope.agregar();
                }
            }
            $scope.encuesta.Id = $scope.id;
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
    
    

    $scope.agregar = function () {
        $scope.estancia = new Object();
        //$scope.estancia.ide = $scope.ide;
        $scope.estancia.Municipio = null;
        $scope.estancia.Noches = null;
        $scope.estancia.Alojamiento = null;
        if ($scope.encuesta.Estancias != null) {
            $scope.encuesta.Estancias.push($scope.estancia);

        } else {
            $scope.encuesta.Estancias = [];
            $scope.encuesta.Principal = -1;
            $scope.encuesta.Estancias.push($scope.estancia);

        }
      
    }

    $scope.cambionoches = function (es) {
    
        if (es.Noches == 0) {
            es.Alojamiento = 15;

        }
    }

    $scope.cambioselectalojamiento = function (es) {

        

        if (es.Noches == 0) {

            es.Alojamiento = 15;

        } else {
            if(es.Alojamiento == 15){
                es.Alojamiento = null;
            }
        }
        
        var retornoBuscar = $scope.buscarSimilarSeleccion(es);
        if(retornoBuscar){
            es.Alojamiento = null;
        }
        
    }

    $scope.cambioselectmunicipio = function (es) {
        var retornoBuscar = $scope.buscarSimilarSeleccion(es);
        if(retornoBuscar){
            es.Municipio = null;
        }
    }
    
    $scope.buscarSimilarSeleccion = function(es){
        var bandera = false;
        
        for (i = 0; i < $scope.encuesta.Estancias.length; i++) {
            if ($scope.encuesta.Estancias[i] != es) {
                if ($scope.encuesta.Estancias[i].Municipio == es.Municipio  ) {
                    bandera = true;
                    break;
                }
            }
        }
        
        return bandera;
    }

    $scope.cambioActividadesRealizadas = function (actividad) {
        actividad.Respuestas = [];
        actividad.otro = undefined;
        var resultado = $filter('filter')($scope.encuesta.ActividadesRelizadas, {'id':23}, true);
        
        if(resultado.length > 0){
            $scope.encuesta.ActividadesRelizadas = [resultado[0]];    
        }
        
    }

    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = null;
        }
     
        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1);

    }

    $scope.validarOtro = function(id,opcion){
        
        if(opcion.otro != undefined && opcion.otro != ''){
            if(opcion.Respuestas.indexOf(id) == -1){
                opcion.Respuestas.push(id);
            }
        }
        
    }
    
    $scope.validarOtroActividad = function(activ){
        if(activ.otroActividad != undefined && activ.otroActividad != '' && $scope.encuesta.ActividadesRelizadas != undefined){
            var resultado = $filter('filter')($scope.encuesta.ActividadesRelizadas, {'id':19}, true);
            if(resultado.length == 0){
                var seleccion = $filter('filter')($scope.Datos.Actividadesrelizadas, {'id':19}, true);
                $scope.encuesta.ActividadesRelizadas.push(seleccion[0]);    
            }
        }
    }
    
    $scope.validarRequeridoOtroActividad = function(){
        if($scope.encuesta.ActividadesRelizadas != undefined){
            var resultado = $filter('filter')($scope.encuesta.ActividadesRelizadas, {'id':19}, true);
            if(resultado.length > 0){
                return true;   
            }    
        }
        return false;
    }
    
    $scope.validarContenido = function(id,opcion){
        if(opcion.Respuestas != undefined){
            if(opcion.Respuestas.indexOf(id) != -1){
                return true;
            }    
        }
        return false;
    }


    $scope.Validar = function () {
        if($scope.encuesta.ActividadesRelizadas.length == 0){
            return true;
        }
        for(var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++){
            if($scope.encuesta.ActividadesRelizadas[i].opciones.length > 0 && ($scope.encuesta.ActividadesRelizadas[i].Respuestas.length == 0||$scope.encuesta.ActividadesRelizadas[i].Respuestas==undefined) ){
                return true;
            }
            
            if($scope.encuesta.ActividadesRelizadas[i].opciones.length > 0){
                if($scope.encuesta.ActividadesRelizadas[i].Respuestas.length > 0){
                    for(var j = 0; j < $scope.encuesta.ActividadesRelizadas[i].Respuestas.length; j++){
                        if($scope.encuesta.ActividadesRelizadas[i].Respuestas[j].sub_opciones.length > 0 && ($scope.encuesta.ActividadesRelizadas[i].Respuestas[j].Respuestas.length == 0 || $scope.encuesta.ActividadesRelizadas[i].Respuestas[j].Respuestas == undefined ) ){
                            return true;    
                        }
                    }        
                }
            }
            
        }
        
        return false;
    }

    $scope.guardar = function () {
        
        
        if (!$scope.EstanciaForm.$valid || $scope.Validar()) {
            swal("Error", "Formulario incompleto corrige los errores.", "error");
            return
        }

        $scope.errores = null
        $("body").attr("class", "cbp-spmenu-push charging");
        
        receptorServi.guardarSeccionEstancia($scope.encuesta).then(function (data) {
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
                    window.location.href = "/turismoreceptor/secciontransporte/" + $scope.id;
                }, 1000);


            } else {
                swal("Error", "Por favor corrija los errores", "error");
                $scope.errores = data.errores;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
        
    }

}])

