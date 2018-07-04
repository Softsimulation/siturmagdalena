angular.module('receptor.estanciayvisitados', [])

.controller('estancia', ['$scope', 'receptorServi','$filter',function ($scope, receptorServi,$filter) {
    //$scope.ide = 0;
    $scope.encuesta = {
        ActividadesRelizadas :[]
    };
    $scope.MensajeAlojamiento = false;

    
    $scope.$watch('id', function () {
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
        }).catch(function () {
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
    
    
    
    // $scope.transformarObjeto = function(Datos){
    //     //atracciones
    //     var atracciones = [];
    //     for(var i = 0; i < Datos.Atracciones.length; i++){
    //         var objeto = {
    //             Nombre : Datos.Atracciones[i].atraccione.sitio.sitios_con_idiomas[0].nombre,
    //             Id : Datos.Atracciones[i].atraccion_id,
    //             IdT : Datos.Atracciones[i].tipo_atraccion_id,
    //         }
    //         atracciones.push(objeto);
    //     }
    //     $scope.Datos.Atracciones = atracciones;
        
    //     //tipoAtracciones
    //     var arreglo = [];
    //     for(var i = 0; i < Datos.TipoAtracciones.length; i++){
    //         var objeto = {
    //             Nombre : Datos.TipoAtracciones[i].tipo_atracciones_con_idiomas[0].nombre,
    //             Id : Datos.TipoAtracciones[i].id,
    //             IdA : Datos.TipoAtracciones[i].actividades_realizadas[0].id,
    //         }
    //         arreglo.push(objeto);
    //     }
    //     $scope.Datos.TipoAtracciones = arreglo;
        
    //     //actividades
    //     var arreglo = [];
    //     for(var i = 0; i < Datos.Actividades.length; i++){
    //         var objeto = {
    //             Nombre : Datos.Actividades[i].actividade.actividades_con_idiomas[0].nombre,
    //             Id : Datos.Actividades[i].actividad_id,
    //             IdA : Datos.Actividades[i].actividades_realizadas_id,
    //         }
    //         arreglo.push(objeto);
    //     }
    //     $scope.Datos.Actividades = arreglo;
        
    //     //atraccionesportal
    //     var arreglo = [];
    //     for(var i = 0; i < Datos.AtraccionesPortal.length; i++){
    //         var objeto = {
    //             Nombre : Datos.AtraccionesPortal[i].sitio.sitios_con_idiomas[0].nombre,
    //             Id : Datos.AtraccionesPortal[i].id,
    //         }
    //         arreglo.push(objeto);
    //     }
    //     $scope.Datos.AtraccionesPortal = arreglo;
        
    // }

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
    }

    $scope.cambioselectmunicipio = function (es) {

        for (i = 0; i < $scope.encuesta.Estancias.length; i++) {
            if ($scope.encuesta.Estancias[i] != es) {
                if ($scope.encuesta.Estancias[i].Municipio == es.Municipio) {
                    es.Municipio = null;
                }
            }


        }
    }

    $scope.cambioActividadesRealizadas = function (actividad) {
        actividad.Respuestas = [];
        actividad.otro = undefined;
        var resultado = $filter('filter')($scope.encuesta.ActividadesRelizadas, {'id':18}, true);
        
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
        
        for(var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++){
            if($scope.encuesta.ActividadesRelizadas[i].opciones.length > 0 && ($scope.encuesta.ActividadesRelizadas[i].Respuestas.length == 0||$scope.encuesta.ActividadesRelizadas[i].Respuestas==undefined) ){
                return true;
            }
        }
        
        return false;
    }

    $scope.guardar = function () {
        
        
        if (!$scope.EstanciaForm.$valid || $scope.Validar()) {
            swal("Error", "corrija los errores", "error");
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

.controller('estancia_visitante', ['$scope', '$http',function ($scope, $http) {

    $scope.ide = 0;
    $scope.encuesta = {};
    
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        $http.get("/EncuestaReceptorVisitante/GetSeccionEstanciayvisitados/" + $scope.id)
           .success(function (data) {
               $("body").attr("class", "cbp-spmenu-push");
               if (data.success) {
                   $scope.Datos = data.Enlaces;
                   $scope.encuesta = data.encuesta;
                   $scope.encuesta.Id = $scope.id
                   if (data.encuesta.Estancias == null) {
                       $scope.agregar();
                   }

               } else {
                   
                   swal("Error", "Error en la carga, por favor recarga la página", "error");

               }
           }).error(function () {
               $("body").attr("class", "cbp-spmenu-push");
               swal("Error", "Error en la carga, por favor recarga la página", "error");

           })
    })

    $scope.agregar = function () {
        $scope.estancia = new Object();
        $scope.ide = $scope.ide + 1;
        $scope.estancia.ide = $scope.ide;
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
    }

    $scope.cambioselectmunicipio = function (es) {

        for (i = 0; i < $scope.encuesta.Estancias.length; i++) {
            if ($scope.encuesta.Estancias[i] != es) {
                if ($scope.encuesta.Estancias[i].Municipio == es.Municipio) {
                    es.Municipio = null;
                }
            }


        }
    }

    $scope.cambioActividadesRealizadas = function () {
        $scope.sw = $scope.encuesta.ActividadesRelizadas.indexOf(23);
        
        if ($scope.sw >= 0) {
            $scope.encuesta.ActividadesRelizadas = [23];
        }
    }

    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = 0;
        }
     
        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1);

    }

    $scope.existe = function (num) {
        
        if ($scope.encuesta.ActividadesRelizadas != null) {
            $scope.sw = $scope.encuesta.ActividadesRelizadas.indexOf(num)
            if ($scope.sw >= 0) {
                return true;
            } else {

                if(num == 1){
                    $scope.encuesta.AtraccionesP = [];
                }

                if (num == 2) {
                    $scope.encuesta.TipoAtraccionesN = [];
                    $scope.encuesta.AtraccionesN = [];

                }

                if (num == 3) {
                    $scope.encuesta.TipoAtraccionesM = [];
                    $scope.encuesta.AtraccionesM = [];
                }

                if (num == 8) {
                    $scope.encuesta.ActividadesH = [];

                }

                if (num == 10) {
                    $scope.encuesta.ActividadesD = [];

                }

                return false;
            }
        } else {
            return false;
        }

    }

    $scope.existetipon = function (num) {

        if ($scope.encuesta.TipoAtraccionesN != null) {
            $scope.sw = $scope.encuesta.TipoAtraccionesN.indexOf(num)
            if ($scope.sw >= 0) {
                return true;
            } else {
                if (num == 94) {
                    $scope.encuesta.AtraccionesN = []
                }

                return false;
            }
        } else {
            return false;
        }

    }

    $scope.existetipom = function (num) {

        if ($scope.encuesta.TipoAtraccionesM != null) {
            $scope.sw = $scope.encuesta.TipoAtraccionesM.indexOf(num);
            if ($scope.sw >= 0) {
                return true;
            } else {
                if (num == 117) {
                    $scope.encuesta.AtraccionesM = [];
                }

                return false;
            }
        } else {
            return false;
        }

    }

    $scope.existeAtraccion = function (num) {
        if ($scope.encuesta.AtraccionesM != null) {
            if ($scope.encuesta.AtraccionesM.length > 0) {

                if (($scope.encuesta.AtraccionesM.indexOf(num) >= 0)) {
                    return true;
                }

            }

        }

        if ($scope.encuesta.AtraccionesP != null) {
            if ($scope.encuesta.AtraccionesP.length > 0) {
                if (($scope.encuesta.AtraccionesP.indexOf(num) >= 0)) {
                    return true;
                }
            }

        }

        if ($scope.encuesta.AtraccionesN != null) {
            if ($scope.encuesta.AtraccionesN.length > 0) {
                if (($scope.encuesta.AtraccionesN.indexOf(num) >= 0)) {
                    return true;
                }
            }

        }

        return false;
        
    }

    $scope.existeAtracciones = function () {

        if ($scope.encuesta.AtraccionesM != null) {
            if ($scope.encuesta.AtraccionesM.length > 0) {
                return true;
            }

        }

        if ($scope.encuesta.AtraccionesP != null) {
            if ($scope.encuesta.AtraccionesP.length > 0) {
                return true;
            }

        }

        if ($scope.encuesta.AtraccionesN!= null) {
            if ($scope.encuesta.AtraccionesN.length > 0) {
                return true;
            }

        }

        return false;

    }

    $scope.Validar = function () {
        if ($scope.encuesta.ActividadesRelizadas == null) {
            return true;
        }else{

            if ($scope.encuesta.ActividadesRelizadas.length == 0) {
                return true;
            } else {

                if ($scope.encuesta.ActividadesRelizadas.indexOf(1) >= 0) {
                    if ($scope.encuesta.AtraccionesP.length == 0) {
                        return true;

                    }
                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(2) >= 0) {
  
                    if ($scope.encuesta.TipoAtraccionesN.length == 0) {
                        return true;

                    } else {

                        if ($scope.encuesta.TipoAtraccionesN.indexOf(94) >= 0) {

                            if ($scope.encuesta.AtraccionesN.length == 0) {
                                return true;

                            }

                        }

                    }

                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(3) >= 0) {


                    if ($scope.encuesta.TipoAtraccionesM.length == 0) {
                        return true;

                    } else {

                        if ($scope.encuesta.TipoAtraccionesM.indexOf(117) >= 0) {

                            if ($scope.encuesta.AtraccionesM.length == 0) {
                                return true;

                            }

                        }

                    }


                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(8) >= 0) {
                    if ($scope.encuesta.ActividadesH.length == 0) {
                        return true;

                    }
                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(10) >= 0) {
                    if ($scope.encuesta.ActividadesD.length == 0) {
                        return true;

                    }
                }

            }

        }
        return false;

    }

    $scope.guardar = function () {

        $scope.sw2 =  $scope.Validar()
        if (!$scope.EstanciaForm.$valid || $scope.sw2) {
            swal("Error", "corrija los errores", "error");
            return;
        }


        $scope.errores = null;
        $("body").attr("class", "cbp-spmenu-push charging");

        $http.post('/EncuestaReceptorVisitante/CreateEstancia', $scope.encuesta)
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
                        window.location.href = "/EncuestaReceptorVisitante/SeccionTransporte/" + $scope.id;
                    }, 1000);

               
                } else {
                    swal("Error", "Por favor corrija los errores", "error");
                    $scope.errores = data.errores;
                }
            }).error(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            })
    }

}])