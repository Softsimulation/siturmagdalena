angular.module('interno.Actividades', [])
.controller('estancia', ['$scope', '$filter','serviInterno',function ($scope, $filter,serviInterno,)  {


    $scope.encuesta = {}
    $scope.MensajeAlojamiento = false


  $scope.$watch('id', function () {
        if($scope.id != null){
            
            $("body").attr("class", "cbp-spmenu-push charging");
            serviInterno.getDatosEstancia($scope.id).then(function (data) {
                       $scope.Datos = data.Enlaces;
                       $scope.encuesta = data.encuesta;
                       $scope.encuesta.Id = $scope.id;
                       $("body").attr("class", "cbp-spmenu-push");
                      
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "No se realizo la solicitud, reinicie la página");
            })
        }
        
    })
    

    $scope.cambioActividadesRealizadas = function (obj) {
        
         for (var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++) {
            if($scope.encuesta.ActividadesRelizadas[i].id == 18){
                 obj = $scope.encuesta.ActividadesRelizadas[i];
                 $scope.encuesta.ActividadesRelizadas = [];
                 $scope.encuesta.ActividadesRelizadas.push(obj);
                $scope.encuesta.OpcionesActividades = [];
                $scope.encuesta.SubOpcionesActividades = [];
            }
            
        }
        
          for (var i = 0; i < obj.opciones_actividades_realizadas_internos.length; i++) {
                $scope.LimpiarOpcion(obj.opciones_actividades_realizadas_internos[i].id)
            }
        
    
    }
    
    
    $scope.requeridoOpciones = function(obj){
        
       for (var i = 0; i < obj.length; i++) {
            if($scope.existeOpcion(obj[i].id)){
                
                return false;
            }
        }
        return true;
    }
    
    
    $scope.LimpiarOpcion = function(obj){
        
       for (var i = 0; i < $scope.encuesta.OpcionesActividades.length; i++) {
            if($scope.encuesta.OpcionesActividades[i].id == obj){
                
                $scope.encuesta.OpcionesActividades.splice(i,1)
            }
        }
  
    }
    
    
      $scope.existeOpcion = function(obj){
        
       for (var i = 0; i < $scope.encuesta.OpcionesActividades.length; i++) {
            if($scope.encuesta.OpcionesActividades[i].id == obj){
                
                return true;
            }
        }
        return false;
    }
    
    $scope.existeActividad= function(obj){
        
       for (var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++) {
            if($scope.encuesta.ActividadesRelizadas[i].id == obj){
                
                return true;
            }
        }
        return false;
    }
    
     $scope.Opcion = function(obj){
        
       for (var i = 0; i < $scope.encuesta.OpcionesActividades.length; i++) {
            if($scope.encuesta.OpcionesActividades[i].id == obj){
                
                return $scope.encuesta.OpcionesActividades[i];
            }
        }
        return false;
    }
    
        
    $scope.Actividad= function(obj){
        
       for (var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++) {
            if($scope.encuesta.ActividadesRelizadas[i].id == obj){
                
                return $scope.encuesta.ActividadesRelizadas[i];
            }
        }
        return false;
    }
    
    
     $scope.requeridoSubOpciones = function(obj){
        
       for (var i = 0; i < obj.length; i++) {
            if($scope.encuesta.SubOpcionesActividades.indexOf(obj[i])  > -1){
                
                return false;
            }
        }
        return true;
    }
    
   
    
    
    
       $scope.Validar = function(){
        if($scope.encuesta.ActividadesRelizadas.length == 0){
            return true
        }
       for (var i = 0; i < $scope.encuesta.ActividadesRelizadas.length; i++) {
           var obj = $scope.encuesta.ActividadesRelizadas[i];
            if(obj.opciones_actividades_realizadas_internos.length > 0){
                  if($scope.requeridoOpciones(obj.opciones_actividades_realizadas_internos )){
                    return true
                }
                for (var k = 0; k < obj.opciones_actividades_realizadas_internos.length; k++) {
                    var obj2 = obj.opciones_actividades_realizadas_internos[k];
             
                    if(obj2.sub_opciones_actividades_realizadas_internos.length > 0){
                        
                        if($scope.requeridoSubOpciones(obj2.sub_opciones_actividades_realizadas_internos)){
                            return true
                        }
                    }
            }
                
            }
        }
        return false;
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
