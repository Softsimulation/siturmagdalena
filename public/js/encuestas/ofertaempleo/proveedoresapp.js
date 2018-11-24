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
        
    proveedorServi.CargarListadoRnt().then(function(data){
                                 $("body").attr("class", "cbp-spmenu-push");
                                $scope.proveedores = data.proveedores;
                               
                }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        });   
   

   
}])

.controller('listadoecuestatotal', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
        

        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.getEncuestasTotal().then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.encuestas = data.encuestas;
           
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    
        
      $scope.caracterizacionEmpleo = function(obj){
             
              if(obj.tipo_id == 1){
                     window.location.href = "/ofertaempleo/caracterizacion/"+obj.id;
              }else{
                  
                    if(obj.categoria_id == 15 || obj.categoria_id == 13){
                         window.location.href = "/ofertaempleo/agenciaviajes/"+obj.id;
                    }
                     if(obj.categoria_id == 14){
                         window.location.href = "/ofertaempleo/caracterizacionagenciasoperadoras/"+obj.id;
                    }
                     if(obj.categoria_id == 21){
                         window.location.href = "/ofertaempleo/caracterizaciontransporte/"+obj.id;
                    }
                     if(obj.categoria_id == 22 || obj.categoria_id == 28){
                         window.location.href = "/ofertaempleo/caracterizaciontransporte/"+obj.id;
                    }
                     if(obj.categoria_id == 12){
                         window.location.href = "/ofertaempleo/caracterizacionalimentos/";+obj.id
                    }
                   if(obj.categoria_id == 11 || obj.categoria_id == 16 || obj.categoria_id == 27 ){
                         window.location.href = "/ofertaempleo/caracterizacionalimentos/"+obj.id;
                    }
              }
      }
      
       $scope.ofertaEmpleo = function(obj){
             
              if(obj.tipo_id == 1){
                     window.location.href = "/ofertaempleo/oferta/"+obj.id;
              }else{
                  
                    if(obj.categoria_id == 15 || obj.categoria_id == 13){
                         window.location.href = "/ofertaempleo/ofertaagenciaviajes/"+obj.id;
                    }
                     if(obj.categoria_id == 14){
                         window.location.href = "/ofertaempleo/ocupacionagenciasoperadoras/"+obj.id;
                    }
                     if(obj.categoria_id == 21){
                         window.location.href = "/ofertaempleo/ofertalquilervehiculo/"+obj.id;
                    }
                     if(obj.categoria_id == 22 || obj.categoria_id == 28){
                         window.location.href = "/ofertaempleo/ofertatransporte/"+obj.id;
                    }
                     if(obj.categoria_id == 12){
                         window.location.href = "/ofertaempleo/capacidadalimentos/";+obj.id
                    }
                   if(obj.categoria_id == 11){
                         window.location.href = "/ofertaempleo/capacidadalimentos/"+obj.id;
                    }
              }
      }
   
   
   
   
   
}])