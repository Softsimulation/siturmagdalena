angular.module('interno.Actividades', [])
.controller('estancia', ['$scope', 'serviInterno',function ($scope, serviInterno)  {


    $scope.encuesta = {}
    $scope.MensajeAlojamiento = false


  $scope.$watch('id', function () {
        if($scope.id != null){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            serviInterno.getDatosEstancia($scope.id).then(function (data) {
                       $scope.Datos = data.Enlaces;
                       $scope.transformarObjeto($scope.Datos);
                       $scope.encuesta = data.encuesta;
                       $scope.encuesta.Id = $scope.id;
                       $("body").attr("class", "cbp-spmenu-push");
                      
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        }
        
    })
    
      $scope.transformarObjeto = function(Datos){
        //atracciones
        var atracciones = [];
        for(var i = 0; i < Datos.Atracciones.length; i++){
            var objeto = {
                Nombre : Datos.Atracciones[i].atraccione.sitio.sitios_con_idiomas[0].nombre,
                Id : Datos.Atracciones[i].atraccion_id,
                IdT : Datos.Atracciones[i].tipo_atraccion_id,
            }
            atracciones.push(objeto);
        }
        $scope.Datos.Atracciones = atracciones;
        
        //tipoAtracciones
        var arreglo = [];
        for(var i = 0; i < Datos.TipoAtracciones.length; i++){
            var objeto = {
                Nombre : Datos.TipoAtracciones[i].tipo_atracciones_con_idiomas[0].nombre,
                Id : Datos.TipoAtracciones[i].id,
                IdA : Datos.TipoAtracciones[i].actividades_realizadas[0].id,
            }
            arreglo.push(objeto);
        }
        $scope.Datos.TipoAtracciones = arreglo;
        
        //actividades
        var arreglo = [];
        for(var i = 0; i < Datos.Actividades.length; i++){
            var objeto = {
                Nombre : Datos.Actividades[i].actividade.actividades_con_idiomas[0].nombre,
                Id : Datos.Actividades[i].actividad_id,
                IdA : Datos.Actividades[i].actividades_realizadas_id,
            }
            arreglo.push(objeto);
        }
        $scope.Datos.Actividades = arreglo;
        
        //atraccionesportal
        var arreglo = [];
        for(var i = 0; i < Datos.AtraccionesPortal.length; i++){
            var objeto = {
                Nombre : Datos.AtraccionesPortal[i].sitio.sitios_con_idiomas[0].nombre,
                Id : Datos.AtraccionesPortal[i].id,
            }
            arreglo.push(objeto);
        }
        $scope.Datos.AtraccionesPortal = arreglo;
        
    }

    $scope.cambioActividadesRealizadas = function () {
        $scope.sw = $scope.encuesta.ActividadesRelizadas.indexOf(23)

        if ($scope.sw >= 0) {
            $scope.encuesta.ActividadesRelizadas = [23];
        }
    }




    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = 0;
        }

        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1)

    }


    $scope.existe = function (num) {

        if ($scope.encuesta.ActividadesRelizadas != null) {
            $scope.sw = $scope.encuesta.ActividadesRelizadas.indexOf(num)
            if ($scope.sw >= 0) {
                return true;
            } else {

                if (num == 1) {
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

                if (num == 67) {
                    $scope.encuesta.AtraccionesR = []
                }



                return false;
            }
        } else {
            return false;
        }

    }



    $scope.existetipom = function (num) {

        if ($scope.encuesta.TipoAtraccionesM != null) {
            $scope.sw = $scope.encuesta.TipoAtraccionesM.indexOf(num)
            if ($scope.sw >= 0) {
                return true;
            } else {
                if (num == 117) {
                    $scope.encuesta.AtraccionesM = []
                }

              

                return false;
            }
        } else {
            return false;
        }

    }



    $scope.Validar = function () {

        if ($scope.encuesta.ActividadesRelizadas == null) {
            return true
        } else {


            if ($scope.encuesta.ActividadesRelizadas.length == 0) {
                return true
            } else {

                if ($scope.encuesta.ActividadesRelizadas.indexOf(1) >= 0) {
                    if ($scope.encuesta.AtraccionesP.length == 0) {
                        return true

                    }
                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(2) >= 0) {


                    if ($scope.encuesta.TipoAtraccionesN.length == 0) {
                        return true

                    } else {


                        if ($scope.encuesta.TipoAtraccionesN.indexOf(94) >= 0) {

                            if ($scope.encuesta.AtraccionesN.length == 0) {
                                return true

                            }

                        }



                        if ($scope.encuesta.TipoAtraccionesN.indexOf(67) >= 0) {

                            if ($scope.encuesta.AtraccionesR.length == 0) {
                                return true

                            }

                        }



                    }


                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(3) >= 0) {


                    if ($scope.encuesta.TipoAtraccionesM.length == 0) {
                        return true

                    } else {


                        if ($scope.encuesta.TipoAtraccionesM.indexOf(117) >= 0) {

                            if ($scope.encuesta.AtraccionesM.length == 0) {
                                return true

                            }

                        }

                    }


                }






                if ($scope.encuesta.ActividadesRelizadas.indexOf(8) >= 0) {
                    if ($scope.encuesta.ActividadesH.length == 0) {
                        return true

                    }
                }

                if ($scope.encuesta.ActividadesRelizadas.indexOf(10) >= 0) {
                    if ($scope.encuesta.ActividadesD.length == 0) {
                        return true

                    }
                }

            }
        }

        return false

    }






    $scope.guardar = function () {


        $scope.sw2 = $scope.Validar()
        if (!$scope.EstanciaForm.$valid || $scope.sw2) {
            swal("Error", "corrija los errores", "error")
            return
        }

        $scope.errores = null
        $("body").attr("class", "cbp-spmenu-push charging");


       serviInterno.guardarSeccionEstancia($scope.encuesta).then(function (data) {
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
                        window.location.href = "/turismointerno/transporte/" + $scope.id;
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
