angular.module('proveedoresoferta', ["checklist-model","proveedorServices",'angularUtils.directives.dirPagination'])

.controller('listado', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
     $("body").attr("class", "cbp-spmenu-push charging");
        
    proveedorServi.CargarListado().then(function(data){
                                 $("body").attr("class", "cbp-spmenu-push");
                                $scope.proveedores = data.proveedores;
                               
                }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });   
   

   
}])

.controller('listadoecuesta', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
      $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        proveedorServi.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
   
   
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.getEncuestas($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.encuestas = data.encuestas;
            $scope.ruta = data.ruta;
            $scope.ruta2 = data.ruta2;
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
   

   
}])

.controller('activarController', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
        
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.getProveedor($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            if(data.establecimiento != null){
                $scope.establecimiento = data.establecimiento;
                if($scope.establecimiento.extension != null){
                $scope.establecimiento.extension = +$scope.establecimiento.extension;
                }
                $scope.municipios = data.municipios;
                $scope.categorias = data.categorias;
            }else{
                $scope.establecimiento = {};
                $scope.establecimiento.proveedor_rnt_id = $scope.id;
                $scope.municipios = data.municipios;
                $scope.categorias = data.categorias;
            }
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
   
    $scope.guardar = function(){
              if (!$scope.indentificacionForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return
        }

        $("body").attr("class", "cbp-spmenu-push charging")
        proveedorServi.Activar($scope.establecimiento).then(function (data) {
        $("body").attr("class", "cbp-spmenu-push");
           if (data.success == true) {
                    swal({
                        title: "Realizado",
                        text: "Se ha completado satisfactoriamente la sección.",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: "btn-info",
                        cancelButtonClass: "btn-info",
                        confirmButtonText: "Encuesta",
                        cancelButtonText: "Listado de proveedores rnt",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                      if (isConfirm) {
                         window.location.href = "/ofertaempleo/encuesta/"+data.id;
                      } else {
                        window.location.href = "/ofertaempleo/listadoproveedoresrnt";
                      }
                    });
        
                } else {
                   
                    $scope.errores = data.errores;
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error")

                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        
    }

   
}])

.controller('listadoRnt', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
     $("body").attr("class", "cbp-spmenu-push charging");
    $scope.proveedores = [];
    proveedorServi.CargarListadoRnt().then(function(data){
                                 $("body").attr("class", "cbp-spmenu-push");
                                $scope.proveedores = data.proveedores;
                                for(var i=0;i<$scope.proveedores.length;i++){
                                    if($scope.proveedores[i].sitio_para_encuesta_id != null){
                                        $scope.proveedores[i].estado = "Activo";
                                    }else{
                                        $scope.proveedores[i].estado = "Desactivado";
                                    }
                                }
                                $scope.categorias = data.categorias;
                               
                }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });   
   

   $scope.abrirEditar = function (proveedor) {
        $scope.item = proveedor;
        $scope.proveedorEdit = angular.copy(proveedor);
        $scope.proveedorEditForm.$setPristine();
        $scope.proveedorEditForm.$setUntouched();
        $scope.proveedorEditForm.$submitted = false;
        $scope.errores = null;
        $('#modalEditarProveedor').modal('show');
    }
   
   
   $scope.guardar = function(){
              if (!$scope.proveedorEditForm.$valid) {
            swal("Error", "Formulario incompleto corrige los errores", "error")
            return
        }

        $("body").attr("class", "cbp-spmenu-push charging")
        proveedorServi.EditarProveedor($scope.proveedorEdit).then(function (data) {
        $("body").attr("class", "cbp-spmenu-push");
           if (data.success == true) {
                  swal("Realizado", "Se realizo correctamente la operacion", "success")
                     $scope.item.nombre = data.proveedor[0].nombre;
                     $scope.item.direccion = data.proveedor[0].direccion;
                     $scope.item.idcategoria = data.proveedor[0].idcategoria;
                     $scope.item.subcategoria = data.proveedor[0].subcategoria;
                     $scope.item.categoria = data.proveedor[0].categoria;
                     $scope.item.idtipo = data.proveedor[0].idtipo;
                     $scope.item.rnt = data.proveedor[0].rnt;
                     $scope.item.nit = data.proveedor[0].nit;
                     $scope.item.email = data.proveedor[0].email;

                     $('#modalEditarProveedor').modal('hide');
                } else {
                   
                    $scope.errores = data.errores;
                    swal("Error", "Error en la carga, por favor recarga la pagina", "error")

                }
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        
    }
   

   
}])

.controller('listadoecuestatotal', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
        
        //$scope.search = {'caracterizacionFiltro':"",'ofertaFiltro':"",'capacitacionFiltro':"",'empleoFiltro':""};   
        $scope.search = {};
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.getEncuestasTotal().then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.encuestas = data.encuestas;
            for(var i=0;i<$scope.encuestas.length;i++){
                $scope.encuestas[i].caracterizacionFiltro = $scope.encuestas[i].caracterizacion != true ? 2 : 1;
                $scope.encuestas[i].ofertaFiltro = $scope.encuestas[i].oferta != true ? 2 : 1; 
                $scope.encuestas[i].capacitacionFiltro = $scope.encuestas[i].capacitacion != true ? 2 : 1; 
                $scope.encuestas[i].empleoFiltro = $scope.encuestas[i].empleo != true ? 2 : 1; 
            }
           
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    
        
    $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        proveedorServi.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
        
        
      $scope.caracterizacionEmpleo = function(obj){
             
              if(obj.tipo_id == 1){
                     window.location.href = "/ofertaempleo/caracterizacion/"+obj.id;
              }else{
                   if(obj.categoria_id == 35 || obj.categoria_id == 36 || obj.categoria_id == 37 || obj.categoria_id == 38){
                     window.location.href = "/ofertaempleo/caracterizacion/"+obj.id;
                    }
                  
                    if(obj.categoria_id == 15 || obj.categoria_id == 13){
                         window.location.href = "/ofertaempleo/agenciaviajes/"+obj.id;
                    }
                     if(obj.categoria_id == 14){
                         window.location.href = "/ofertaempleo/caracterizacionagenciasoperadoras/"+obj.id;
                    }
                     if(obj.categoria_id == 21){
                         window.location.href = "/ofertaempleo/caracterizacionalquilervehiculo/"+obj.id;
                    }
                     if(obj.categoria_id == 22 || obj.categoria_id == 27){
                         window.location.href = "/ofertaempleo/caracterizaciontransporte/"+obj.id;
                    }
                     if(obj.categoria_id == 12 || obj.categoria_id == 11 || obj.categoria_id == 29){
                         window.location.href = "/ofertaempleo/caracterizacionalimentos/"+obj.id;
                    }
              
              }
      }
      
       $scope.ofertaEmpleo = function(obj){
             
              if(obj.tipo_id == 1){
                     window.location.href = "/ofertaempleo/oferta/"+obj.id;
              }else{
                   if(obj.categoria_id == 35 || obj.categoria_id == 36 || obj.categoria_id == 37 || obj.categoria_id == 38){
                     window.location.href = "/ofertaempleo/caracterizacion/"+obj.id;
                    }
                  
                    if(obj.categoria_id == 15 || obj.categoria_id == 13){
                         window.location.href = "/ofertaempleo/ofertaagenciaviajes/"+obj.id;
                    }
                     if(obj.categoria_id == 14){
                         window.location.href = "/ofertaempleo/ocupacionagenciasoperadoras/"+obj.id;
                    }
                     if(obj.categoria_id == 21){
                         window.location.href = "/ofertaempleo/ofertalquilervehiculo/"+obj.id;
                    }
                     if(obj.categoria_id == 22 || obj.categoria_id == 27){
                         window.location.href = "/ofertaempleo/ofertatransporte/"+obj.id;
                    }
                     if(obj.categoria_id == 12 || obj.categoria_id == 11 || obj.categoria_id == 29){
                         window.location.href = "/ofertaempleo/capacidadalimentos/"+obj.id;
                    }
                 
              }
      }
   
   
   
   
   
}])