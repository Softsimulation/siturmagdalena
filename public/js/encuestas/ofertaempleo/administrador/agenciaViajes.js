var situr = angular.module("admin.agenciaViaje", []);

situr.controller('caracterizacionAgenciaViajesCtrl', ['$scope','agenciaViajeServi', function ($scope,agenciaViajeServi) {
    $scope.encuesta = {};
    $scope.encuesta.TipoServicios = [];
    
    $scope.$watch('encuesta.id', function () {
        
        if ($scope.encuesta.id != null) {
            $("body").attr("class", "charging");
            agenciaViajeServi.getAgencia($scope.encuesta.id).then(function (data) {
                $scope.proveedor = data.proveedor;
                if (data.agencia.Id > 0) {
                    var arrayAux = [];
                    if(data.agencia.TipoServicios != null){
                        if(data.agencia.TipoServicios.servicios_agencias.length > 0){
                            for(var i=0; i<data.agencia.TipoServicios.servicios_agencias.length;i++){
                                arrayAux.push(data.agencia.TipoServicios.servicios_agencias[i].id);
                            }
                        }
                    }
                    $scope.encuesta.TipoServicios = arrayAux;
                    
                    $scope.encuesta.Planes = data.agencia.Planes + ""
                    $scope.encuesta.Otro = data.agencia.Otro;
                    $scope.encuesta.Comercial = data.agencia.Comercial+"";
                    $scope.encuesta.NumeroDias = data.agencia.numeroDias;
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }  
    })
    $("body").attr("class", "charging");
    agenciaViajeServi.getDatosAgencia().then(function (data) {
        $scope.servicios = data;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    })
    
    $scope.guardar = function () {

       if ($scope.DatosForm.$valid && $scope.encuesta.TipoServicios.length>0) {
           
            $("body").attr("class", "charging");
            agenciaViajeServi.guardarCaracterizacion($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
    
                        if(data.redireccion == true){
    
                            swal({
                              title: "Realizado",
                              text: "Se ha guardado satisfactoriamente la sección.",
                              type: "success",
                              showCancelButton: true,
                              confirmButtonClass: "btn-info",
                              cancelButtonClass: "btn-info",
                              confirmButtonText: data.oferta == true ? "Oferta" : "Empleo",
                              cancelButtonText: "Listado de encuestas",
                              closeOnConfirm: false,
                              closeOnCancel: false
                            },
                            function(isConfirm) {
                              if (isConfirm) {
                                  if(!data.oferta){
                                      window.location.href = '/ofertaempleo/empleomensual/'+$scope.encuesta.id;
                                  }else{
                                      window.location.href = '/ofertaempleo/ofertaagenciaviajes/'+$scope.encuesta.id;
                                  }
                                
                              } else {
                                window.location = "/ofertaempleo/encuestas/"+data.sitio;
                              }
                            });
                        }else{
                            window.location = "/ofertaempleo/encuestas/"+data.sitio;
                        }
    
    
    
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error")
                    $scope.errores = data.errores;
    
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            })

        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }



    }
}])

situr.controller('ofertaAgenciaViajesCtrl', ['$scope','agenciaViajeServi', function ($scope,agenciaViajeServi) {
    $scope.encuesta = {};
    $scope.encuesta.personas = {};
    $scope.encuesta.ventaPlanes = false;
    $scope.$watch('encuesta.id', function () {
        
        if ($scope.encuesta.id != null) {
            $("body").attr("class", "charging");
            agenciaViajeServi.getOfertaAgencia($scope.encuesta.id).then(function (data) {
                $scope.proveedor = data.proveedor;
                if (data.agencia.id > 0) {
                    $scope.encuesta.ofrecePlanesConDestino = data.agencia.ofreceplanes;
                    if(data.agencia.personas_destino_con_viajes_turismos.length > 0){
                        $scope.encuesta.personas = data.agencia.personas_destino_con_viajes_turismos;
                        for(var i=0; i<$scope.encuesta.personas.length; i++){
                            $scope.encuesta.personas[i].internacional = parseInt($scope.encuesta.personas[i].internacional);
                            $scope.encuesta.personas[i].nacional = parseInt($scope.encuesta.personas[i].nacional);
                            $scope.encuesta.personas[i].numerototal = parseInt($scope.encuesta.personas[i].numerototal);
                        }
                    }
                    
                    if(data.agencia.planes_santamarta != null){
                        $scope.encuesta.numero=parseInt(data.agencia.planes_santamarta.numero)
                        $scope.encuesta.magdalena=parseInt(data.agencia.planes_santamarta.residentes)
                        $scope.encuesta.nacional=parseInt(data.agencia.planes_santamarta.noresidentes)
                        $scope.encuesta.internacional=parseInt(data.agencia.planes_santamarta.extrajeros)
                    }
                    
                    for(var i=0; i<data.agencia.servicios_agencias.length; i++){
                        if(data.agencia.servicios_agencias[i].id == 1){
                            $scope.encuesta.ventaPlanes = true;
                            break;
                        }
                    }
                    
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        }  
    })
    $("body").attr("class", "charging");
    agenciaViajeServi.getDatosOfertaAgencia().then(function (data) {
        $scope.destinos = data;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    })
    
    $scope.guardar = function () {

       if ($scope.DatosForm.$valid) {
           
            $("body").attr("class", "charging");
            
            agenciaViajeServi.guardarOfertaAgenciaViajes($scope.encuesta).then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
    
                    swal({
                  title: "Realizado",
                  text: "Se ha guardado satisfactoriamente la sección.",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  cancelButtonClass: "btn-info",
                  confirmButtonText: "Empleo",
                  cancelButtonText: "Listado de encuestas",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    window.location.href = '/ofertaempleo/empleomensual/'+$scope.id;
                  } else {
                    window.location.href = data.ruta;
                  }
                });
    
    
    
                } else {
                    swal("Error", "Hay errores en el formulario corrigelos", "error")
                    $scope.errores = data.errores;
    
                }
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            })

        } else {
            swal("Error", "Formulario incompleto corrige los errores", "error")
        }



    }
}])