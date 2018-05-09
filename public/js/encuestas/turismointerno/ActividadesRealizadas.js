angular.module('interno.Actividades', [])
.controller('estancia', function ($scope, $http) {


    $scope.encuesta = {}
    $scope.MensajeAlojamiento = false



    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get("/EncuestaInterno/GetActividadesRealizadas/" + $scope.id)
           .success(function (data) {
               $("body").attr("class", "cbp-spmenu-push")
               if (data.success) {
                   $scope.Datos = data.Enlaces;
                   $scope.encuesta = data.encuesta;
                   $scope.encuesta.Id = $scope.id;
                  


               } else {
                   swal("Error", "Error en la carga, por favor recarga la pagina", "error")

               }
           }).error(function () {
               $("body").attr("class", "cbp-spmenu-push")
               swal("Error", "Error en la carga, por favor recarga la pagina", "error")

           })
    })





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

        $http.post('/EncuestaInterno/CreateActividades', $scope.encuesta)
                       .success(function (data) {
                           if (data.success == true) {
                               swal({
                                   title: "Realizado",
                                   text: "Se ha guardado satisfactoriamente la sección.",
                                   type: "success",
                                   timer: 1000,
                                   showConfirmButton: false
                               });
                               setTimeout(function () {
                                   window.location.href = "/EncuestaInterno/Transporte/" + $scope.id;
                                   
                             




                               }, 1000);


                           } else {
                               swal("Error", "Por favor corrija los errores", "error")
                               $scope.errores = data.errores;
                           }
                       }).error(function () {
                           $("body").attr("class", "cbp-spmenu-push")
                           swal("Error", "Error en la carga, por favor recarga la pagina", "error")
                       })
    }



})

