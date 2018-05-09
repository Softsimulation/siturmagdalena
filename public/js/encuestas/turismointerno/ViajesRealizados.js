angular.module('interno.viajesrealizados', [])

.controller('viajes', function ($scope, $http) {


    $scope.encuesta = {}
    $scope.PrincipalViaje = {};

    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get("/EncuestaInterno/GetViajesRealizados/"+$scope.id)
           .success(function (data) {
               $("body").attr("class", "cbp-spmenu-push")
               if (data.success) {
                   $scope.Datos = data.Enlaces;
                   $scope.Viajes = data.Viajes;
                   $scope.PrincipalViaje.Id = data.PrincipalViaje;
                 
               } else {
                   swal("Error", "Error en la carga, por favor recarga la pagina", "error")

               }
           }).error(function () {
               $("body").attr("class", "cbp-spmenu-push")
               swal("Error", "Error en la carga, por favor recarga la pagina", "error")

           })

    })

    $scope.editar = function (es) {
        $scope.errores = null;
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$setUntouched();

        $("body").attr("class", "cbp-spmenu-push charging")
        $http.get("/EncuestaInterno/GetViaje/" + es.Id)
           .success(function (data) {
               $("body").attr("class", "cbp-spmenu-push")
               if (data.success) {
                   $scope.edit = es;
                   $scope.encuesta = data.encuesta;
                   $scope.encuesta.Id = $scope.id;
                   $scope.encuesta.Crear = false;
                   if (data.encuesta.Numero != null) {
                       $scope.Total = data.encuesta.Numero - 1
                   }
                   if (data.inicio != null && data.fin != null) {
                       fechal = data.inicio.split('/')
                       fechas = data.fin.split('/')
                       $scope.encuesta.Inicio = new Date(fechal[2], (parseInt(fechal[1]) - 1), fechal[0])
                       $scope.encuesta.Fin = new Date(fechas[2], (parseInt(fechas[1]) - 1), fechas[0])

                   }
                   if (data.encuesta.Estancias == null) {
                       $scope.agregar();
                   }

                   $scope.ver = true;
                  
               } else {
                   swal("Error", "Error en la carga, por favor recarga la pagina", "error")

               }
           }).error(function () {
               $("body").attr("class", "cbp-spmenu-push")
               swal("Error", "Error en la carga, por favor recarga la pagina", "error")

           })


    }

    $scope.agregar = function () {
        $scope.estancia = new Object()
        $scope.estancia.ide = $scope.ide
        $scope.estancia.Municipio = null;
        $scope.estancia.Pais = null;
        $scope.estancia.Departamento = null;
        $scope.estancia.Noches = null;
        $scope.estancia.Alojamiento = null;
       
        if ($scope.encuesta.Estancias != null) {
            $scope.encuesta.Estancias.push($scope.estancia)


        } else {
            $scope.encuesta.Estancias = []
            $scope.encuesta.Principal = -1;
            $scope.encuesta.Estancias.push($scope.estancia)



        }

        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$submitted = false;

    }



    $scope.quitar = function (es) {
        if (es.Municipio == $scope.encuesta.Principal) {

            $scope.encuesta.Principal = 0;
        }

        $scope.encuesta.Estancias.splice($scope.encuesta.Estancias.indexOf(es), 1)
        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$submitted=false;
    }



    $scope.cambioselectpais= function (es) {

        es.Departamento = null;
        es.Municipio = null;



    }


    $scope.cambioselectdepartamento = function (es) {


        es.Municipio = null;
   

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




    $scope.cambionoches = function (es) {

        if (es.Noches == 0) {
            es.Alojamiento = 15;

        }
    }


    $scope.cambioselectalojamiento = function (es) {

        if (es.Noches == 0) {

            es.Alojamiento = 15;

        } else {
            if (es.Alojamiento == 15) {
                es.Alojamiento = null;
            }
        }
    }


    $scope.verifica = function () {
        $scope.Total = $scope.encuesta.Numero - 1
        if ($scope.encuesta.Numero > 1 && $scope.encuesta.Numero != null) {
            $scope.encuesta.Personas = []
           
        } else {
            if ($scope.encuesta.Numero == 1) {
                $scope.encuesta.Personas = [1]
                $scope.encuesta.Numerohogar = null;
                $scope.encuesta.Numerotros = null;
             
            } else {
                

                var i = $scope.encuesta.Personas.indexOf(1)
                if (i != -1) {
                    $scope.encuesta.Personas.splice(i, 1)
                }
            }
        }
    }

    $scope.existe = function (k) {

        if ($scope.encuesta.Personas != null) {

            for (i = 0; i < $scope.encuesta.Personas.length; i++){
            
                if ($scope.encuesta.Personas[i] == k || $scope.encuesta.Personas[i] == (k + 1)) {

                    return true

                }
            
            
            }
            if (k == 2) {

                $scope.encuesta.Numerohogar = 0;
                $scope.TotalD = $scope.Total

            }

            if (k == 4) {
                $scope.encuesta.Numerotros = 0
                $scope.TotalF = $scope.Total
            }


        }

        return false



    }



    $scope.verificaT = function () {
        if ($scope.encuesta.Numerohogar != null) {
            $scope.TotalF = $scope.Total - $scope.encuesta.Numerohogar

        } else {
            $scope.TotalF = $scope.Total
        }
       
        if ($scope.encuesta.Numerotros != null) {
            $scope.TotalD = $scope.Total - $scope.encuesta.Numerotros

        } else {
            $scope.TotalD = $scope.Total
        }


        

    }




    $scope.guardar = function () {


         if (!$scope.EstanciaForm.$valid) {
             swal("Error", "corrija los errores", "error")
             return
         }

         $scope.errores = null
         $("body").attr("class", "cbp-spmenu-push charging");
         if ($scope.encuesta.Id == null){
             $scope.encuesta.Id = $scope.id;
             $scope.encuesta.Crear = true;
         }

        $http.post('/EncuestaInterno/CreateViaje', $scope.encuesta)
                       .success(function (data) {
                           if (data.success == true) {
                               if ($scope.encuesta.Crear == true) {
                                   $scope.Viajes.push(data.Dat);

                               } else {
                                   $scope.edit.FechaInicio = data.Dat.FechaInicio;
                                   $scope.edit.FechaFin = data.Dat.FechaFin;

                               }
                               swal({
                                   title: "Realizado",
                                   text: "Se ha guardado satisfactoriamente la sección.",
                                   type: "success",
                                   timer: 1000,
                                   showConfirmButton: false
                               });
                               setTimeout(function () {
                             




                                   $("body").attr("class", "cbp-spmenu-push")
                               }, 1000);
                               $scope.ver = false;
                               $scope.encuesta = {};
                               $scope.clearForm();


                           } else {
                               $("body").attr("class", "cbp-spmenu-push")
                               swal("Error", "Por favor corrija los errores", "error")
                               $scope.errores = data.errores;
                           }
                       }).error(function () {
                           $("body").attr("class", "cbp-spmenu-push")
                           swal("Error", "Error en la carga, por favor recarga la pagina", "error")
                       })
    }




    $scope.eliminar = function (es) {


        swal({
            title: "¿Estas seguro que desea eliminar el viaje ?",
            text: "No será capaz de recuperar esta información!",
            type: "warning", showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {



                $http.post('/EncuestaInterno/eliminarviaje',{Id : es.Id}).success(function (data) {

                    if (data.success == true) {

                        for (j = 0; j < $scope.Viajes.length; j++) {
                            if ($scope.Viajes[j].Id == es.Id) {

                                $scope.Viajes.splice(j, 1);
                            }

                        }





                        swal("¡Éxito!", "Se elimino satisfactoriamente el viaje", "success")

                    } else {
                        swal("Error", "Error al tratar de eliminar", "error");
                    }
                })


            } else {
                swal("Cancelado", "Ha cancelado la eliminación", "error");
            }
        });

    }





    $scope.cancelar = function () {
            $scope.ver = false;
            $scope.encuesta = {};
            $scope.errores = null;
            $scope.error = null;
            $scope.EstanciaForm.$setPristine();
            $scope.EstanciaForm.$setUntouched();
            $scope.EstanciaForm.$submitted = false;
                                
    }


    $scope.clearForm = function () {
        $scope.errores = null;
        $scope.error = null;
        $scope.EstanciaForm.$setPristine();
        $scope.EstanciaForm.$setUntouched();
        $scope.EstanciaForm.$submitted = false;

    }



    $scope.siguiente = function () {

        $scope.error = null
        if ($scope.PrincipalViaje.Id == null) {
            swal("Error", "corrija los errores", "error")
            $scope.error = "Debe seleccionar un viaje como principal";
            return
        }

       
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.encuesta.Id == null) {
            $scope.encuesta.Id = $scope.id;
            $scope.encuesta.Crear = true;
        }



        $http.post('/EncuestaInterno/guardarviaje', { Id: $scope.id, Principal: $scope.PrincipalViaje.Id })
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

                                   if (data.Sw == 1) {
                                       window.location.href = "/EncuestaInterno/ActividadesRealizadas/" + $scope.PrincipalViaje.Id;
                                   } else {
                                       window.location.href = "/EncuestaInterno/Transporte/" + $scope.PrincipalViaje.Id;

                                   }



                                   $("body").attr("class", "cbp-spmenu-push")
                               }, 1000);
                       

                           } else {
                               $("body").attr("class", "cbp-spmenu-push")
                               swal("Error", "Por favor corrija los errores", "error")
                               $scope.error = data.error;
                           }
                       }).error(function () {
                           $("body").attr("class", "cbp-spmenu-push")
                           swal("Error", "Error en la carga, por favor recarga la pagina", "error")
                       })
    }




})