angular.module('interno.hogares', [])

.controller("crear_Hogar", function ($scope,$http) {
    $scope.encuesta = {}
    $scope.encuesta.integrantes = []
    $scope.integrante = {}

    $http.get('/turismointerno/datoshogar')
        .success(function (data) {

            $scope.municipios = data.municipios
            $scope.niveles = data.niveles
            $scope.motivos = data.motivos
            $scope.estratos=data.estratos

        })
        .error(function () {
            swal("Error", "No se realizo la solicitud, reinicie la pagina")
        })


    $scope.nuevo = function (indice) {
        
        if (indice == null) {
            $scope.aux = -1;
            $scope.integrante = {};
            $scope.IntegranteForm.$setPristine();
            $scope.IntegranteForm.$setUntouched();
            $('#inte').modal();
        } else {
            $scope.aux = indice;
            $scope.integrante = $.extend( {}, $scope.encuesta.integrantes[indice] );
            $scope.IntegranteForm.$setPristine();
            $scope.IntegranteForm.$setUntouched();
            $('#inte').modal();


        }

    }

    $scope.changebarrio = function () {

        $http.post('/turismointerno/barrios', {'id':$scope.municipio})
        .success(function (data) {

            $scope.barrios = data.barrios          

        })
        .error(function () {
            swal("Error", "No se realizo la solicitud, reinicie la pagina")
        })


    }

    $scope.Eliminar = function (indice) {

        $scope.encuesta.integrantes.splice(indice,1)

    }

    

    $scope.SavePersona = function () {

        if ($scope.IntegranteForm.$valid) {
            if ($scope.aux == -1) {
                $scope.integrante.jefe_hogar = 'false';
                $scope.encuesta.integrantes.push($scope.integrante)
                $scope.integrante = {}
                $scope.IntegranteForm.$setPristine();
                $scope.IntegranteForm.$setUntouched();
                $('#inte').modal('hide');
            } else {

                $scope.encuesta.integrantes[$scope.aux] = $.extend({}, $scope.integrante);
                $scope.IntegranteForm.$setPristine();
                $scope.IntegranteForm.$setUntouched();
                $('#inte').modal('hide');


            }

        } else {

            swal("Error","Error en el formulario de creacion de personas corrigelo","error")

        }

    }

    $scope.enviar = function () {
        
        if($scope.encuesta.integrantes.length<1){
            swal("Error","Debe ingresar por lo menos un integrante","error");
            return;
        }

        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            $http.post('/turismointerno/guardarhogar', $scope.encuesta)
                .success(function (data) {
                    $("body").attr("class", "");
                    if (data.success) {                      
                        
                        window.location = "/turismointerno/editarhogar/"+data.id;
                        
                    } else {
                        swal("Error", "Hay errores en el formulario corrigelos", "error")
                        $scope.errores = data.errores;

                    }
                })
                .error(function () {
                    $("body").attr("class", "");
                    swal("Error", "Error en la petición intentalo nuevamente", "error")
                })


        } else {

            swal("Error", "Formulario incompleto corrige los errores", "error")

        }

    }


})

.controller("editar_Hogar", function ($scope, $http) {
    $scope.encuesta = {}
    $scope.encuesta.integrantes = []
    $scope.integrante = {}

    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        $http.post('/turismointerno/datoseditar', {'id':$scope.id})
            .success(function (data) {
                
                $scope.municipios = data.datos.municipios
                $scope.niveles = data.datos.niveles
                $scope.motivos = data.datos.motivos
                $scope.estratos = data.datos.estratos
                $scope.barrios = data.barrios
                $scope.municipio = String(data.encuesta.edificacione.barrio.municipio_id)
                var hora_fecha=data.encuesta.fecha_realizacion.split(" ");
                var fecha = hora_fecha[0].split("-")
                var hora = hora_fecha[1].split(":")               
                $scope.encuesta = data.encuesta;
                $scope.encuesta.Fecha_aplicacion = new Date(fecha[0], (fecha[1]-1), fecha[2])
                $scope.encuesta.Hora_aplicacion = new Date(fecha[0], fecha[1], fecha[2], hora[0], hora[1], hora[2])
                $scope.encuesta.Barrio=String(data.encuesta.edificacione.barrio_id)
                $scope.encuesta.Estrato=String(data.encuesta.edificacione.estrato_id)
                $scope.encuesta.Direccion=data.encuesta.edificacione.direccion
                $scope.encuesta.Telefono=data.encuesta.telefono
                $scope.encuesta.Nombre_Entrevistado=data.encuesta.edificacione.nombre_entrevistado
                $scope.encuesta.Celular_Entrevistado=data.encuesta.edificacione.telefono_entrevistado
                $scope.encuesta.Email_Entrevistado=data.encuesta.edificacione.email_entrevistado
               
                $scope.encuesta.integrantes= cambiar($scope.encuesta.personas)
                $("body").attr("class", "");
               
            })
            .error(function () {
                $("body").attr("class", "");
                swal("Error", "No se realizo la solicitud, reinicie la pagina")
            })
    })

    $scope.nuevo = function (indice) {

        if (indice == null) {
            $scope.aux = -1;
            $scope.integrante = {};
            $scope.IntegranteForm.$setPristine();
            $scope.IntegranteForm.$setUntouched();
            $('#inte').modal();
        } else {
            $scope.aux = indice;
            $scope.integrante = $.extend({}, $scope.encuesta.integrantes[indice]);
            $scope.IntegranteForm.$setPristine();
            $scope.IntegranteForm.$setUntouched();
            $('#inte').modal();


        }

    }

    $scope.cambiar = function (index) {

        for (var j = 0; j < $scope.encuesta.integrantes.length; j++) {

            if (j == index) {

                $scope.encuesta.integrantes[j].jefe_hogar = 'true';

            } else {
                $scope.encuesta.integrantes[j].jefe_hogar = 'false';
            }

        }


    }

    $scope.changebarrio = function () {
        $scope.encuesta.Barrio=""
        $http.post('/turismointerno/barrios', { 'id': $scope.municipio })
        .success(function (data) {

            $scope.barrios = data.barrios

        })
        .error(function () {
            swal("Error", "No se realizo la solicitud, reinicie la pagina")
        })


    }

    $scope.Eliminar = function (indice) {
        if ($scope.encuesta.integrantes[indice].id != null) {

            swal({
                  title: "¿Desea eliminar a la persona seleccionada?",
                  text: "¿Esta seguro?",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function () {

                        $http.post('/turismointerno/eliminarpersona', { id: $scope.encuesta.integrantes[indice].id})
                            .success(function (data) {

                                if (data.success) {

                                    $scope.encuesta.integrantes.splice(indice, 1)
                                    swal("Realizado", "Persona eliminada exitosamente","success")

                                } else {
                                    swal("Error",data.error, "error")
                                }

                            })
                            .error(function () {
                                swal("Error", "No se realizo la solicitud, reinicie la pagina","error")
                            })
                    
                      }, 500);
                    });

        } else {
            $scope.encuesta.integrantes.splice(indice, 1)
        }
        

    }



    $scope.SavePersona = function () {

        if ($scope.IntegranteForm.$valid) {
            if ($scope.aux == -1) {
                $scope.encuesta.integrantes.push($scope.integrante)
                $scope.integrante = {}
                $scope.IntegranteForm.$setPristine();
                $scope.IntegranteForm.$setUntouched();
                $('#inte').modal('hide');
            } else {

                $scope.encuesta.integrantes[$scope.aux] = $.extend({}, $scope.integrante);
                $scope.IntegranteForm.$setPristine();
                $scope.IntegranteForm.$setUntouched();
                $('#inte').modal('hide');


            }

        } else {

            swal("Error", "Error en el formulario de creacion de personas corrigelo", "error")

        }

    }

    $scope.enviar = function () {
        $scope.encuesta.id=$scope.id;
        if ($scope.DatosForm.$valid) {
            $("body").attr("class", "charging");
            $http.post('/turismointerno/guardareditarhogar', $scope.encuesta)
                .success(function (data) {
                    $("body").attr("class", "");
                    if (data.success) {

                        window.location = "/turismointerno/editarhogar/" + data.id;

                    } else {
                        swal("Error", "Hay errores en el formulario corrigelos", "error")
                        $scope.errores = data.errores;

                    }
                })
                .error(function () {
                    $("body").attr("class", "");
                    swal("Error", "Error en la petición intentalo nuevamente", "error")
                })


        } else {

            swal("Error", "Formulario incompleto corrige los errores", "error")

        }

    }
    
    function cambiar(array){
        
        for(var i=0;i<array.length;i++){
            
            array[i].Nombre=String(array[i].nombre);
            array[i].Sexo=String(array[i].sexo);
            array[i].Edad=array[i].edad;
            array[i].Celular=String(array[i].celular);
            array[i].Email=String(array[i].email);
            array[i].Viaje=(array[i].es_viajero)?"1":"0";
            array[i].Nivel_Educacion=String(array[i].nivel_educacion);
            array[i].jefe_hogar=String(array[i].jefe_hogar);
            if(array[i].motivo_no_viajes.length>0){
                array[i].Motivo=String(array[i].motivo_no_viajes[0].motivo_no_viaje_id);
             }
                   
               }
        return array;
        
        
    }
    


})


