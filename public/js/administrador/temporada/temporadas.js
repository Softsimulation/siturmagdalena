var pp=angular.module('admin.temporadas', ['adminservice','angularUtils.directives.dirPagination','ADM-dateTimePicker'])

.controller('temporadasCtrl', ['$scope','adminService',function ($scope,adminService) {

    $("body").attr("class", "cbp-spmenu-push charging");
    
     $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };
    
    adminService.GetTemporadas()
        .then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            $scope.temporadas = data.temporadas;
            
        })
        .catch(function(){
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la pagina", "error");
        });
    

    $scope.pasarC = function () {
        $scope.temporada = {};
        $scope.errores = null;
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $scope.addForm.$submitted = false;
        $('#crearTemporada').modal('show');
    }

    $scope.pasarE = function (obj) {
        $scope.index = $scope.temporadas.indexOf(obj);
        $scope.temporada = $.extend(true, {}, obj);
        $scope.errores = null;
        $scope.addForm.$setPristine();
        $scope.addForm.$setUntouched();
        $scope.addForm.$submitted = false;
        $('#editarTemporada').modal('show');
    }

    $scope.guardar = function () {
        
        if (!$scope.addForm.$valid) {
            return;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
        adminService.Guardartemporada($scope.temporada)
            .then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
                    swal("¡Realizado!", "Se ha creado satisfactoriamente la temporada.", "success");
                    $scope.temporada.Estado = true;
                    $scope.temporada.id = data.temporada.id;
                    $scope.temporadas.unshift($scope.temporada);
                    $('#crearTemporada').modal('hide');
                    
                } else {
                    $scope.errores = data.errores;
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página", "error");
            })

    }

    $scope.editar = function () {
      
        if (!$scope.editForm.$valid) {
            return;
        }

        $("body").attr("class", "cbp-spmenu-push charging");
       adminService.Guardartemporada($scope.temporada)
            .then(function (data) {
                $("body").attr("class", "cbp-spmenu-push");
                if (data.success) {
                    swal("¡Realizado!", "Se ha modificado satisfactoriamente la temporada.", "success");
                    
                    $scope.temporadas[$scope.index] = $scope.temporada;
                    $('#editarTemporada').modal('hide');
                } else {
                    $scope.errores = data.errores;
                    swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
    }

    $scope.cambiarEstado = function (obj) {
        var t1, t2;
        if (obj.Estado) {
            t1 = 'Desactivar';
            t2 = 'desactivado';
        } else {
            t1 = 'Activar';
            t2 = 'activado';
        }

        swal({
            title: t1 + " temporada",
            text: "¿Está seguro?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false
        },
        function () {
            $("body").attr("class", "cbp-spmenu-push charging");
            adminService.CambiarEstado(obj)
                .then(function (data) {
                    $("body").attr("class", "cbp-spmenu-push");
                    if (data.success) {
                        obj.Estado = data.estado;
                        swal("¡Realizado!", "Se ha " + t2 + " satisfactoriamente la temporada.", "success");
                    } else {
                        $scope.errores = data.errores;
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                    }
                }).catch(function () {
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error");
                })
        });

    }
}])

.controller('verTemporadaCtrl', ['$scope','adminService', function ($scope,adminService) {
    
    $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        adminService.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }

     $scope.Eliminar = function (id) {
        

            swal({
                  title: "¿Desea eliminar la encuesta seleccionada?",
                  text: "¿Esta seguro?",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function () {
                        var indice=buscar($scope.temporada.Personas,id);
                        adminService.Eliminarviaje({ id: $scope.temporada.Personas[indice].persona.id})
                            .then(function (data) {

                                if (data.success) {

                                    $scope.temporada.Personas.splice(indice, 1);
                                    swal("Realizado", "Encuesta eliminada exitosamente","success");

                                } else {
                                    swal("Error",data.error, "error")
                                }

                            })
                            .catch(function () {
                                swal("Error", "No se realizo la solicitud, reinicie la pagina","error")
                            })
                    
                      }, 500);
                    });       

    }

    $scope.Eliminarhogar = function (id) {
        

            swal({
                  title: "¿Desea eliminar el hogar seleccionada?",
                  text: "¿Esta seguro?",
                  type: "warning",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function () {
                        var indice=buscar2($scope.temporada.Hogares,id);
                        adminService.Eliminarhogar({ id: id})
                            .then(function (data) {

                                if (data.success) {

                                    $scope.temporada.Hogares.splice(indice, 1);
                                    swal("Realizado", "Encuesta eliminada exitosamente","success");

                                } else {
                                    swal("Error",data.error, "error")
                                }

                            })
                            .catch(function () {
                                swal("Error", "No se realizo la solicitud, reinicie la pagina","error")
                            })
                    
                      }, 500);
                    });       

    }


    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        adminService.DatosTemporada($scope.id)
            .then(function (data) {
                $scope.temporada = data.temporada;
                $scope.temporada.Personas=data.encuestas
                $("body").attr("class", "cbp-spmenu-push");
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            });
    });

    function buscar(array,id){

        for(let i=0;i<array.length;i++){
            if(array[i].persona.id==id){
                return i;
            }
        }

        return -1;
    }

    function buscar2(array,id){

        for(let i=0;i<array.length;i++){
            if(array[i].id==id){
                return i;
            }
        }

        return -1;
    }

    
}])