angular.module('AppInformacionDepartamento', [ 'InformacionServices', 'InputFile', 'ng.ckeditor' ])
    
.controller('informacionDepartamentoCtrl', ['$scope', 'InformacionServi', function ($scope, InformacionServi) {
    
    $scope.galeria = [];    
    
    InformacionServi.getData( $("#id").val() )
        .then(function(data){
            $scope.informacion = data ? data : { id:$("#id").val() };
        });
    
    $scope.guardar = function () {
        
        if (!$scope.crearForm.$valid) { return; }
        
        $scope.errores = null;
        $("body").attr("class", "charging");
        
        InformacionServi.guardar($scope.informacion).then(function (data) {
            if(data.success == true){
                swal("Éxito", "Acción realizada satisfactoriamente", "success");
            }else{
               swal("Error", "La acción no se pudo realizar", "error");
               $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }    
    
    $scope.guardarvideo = function () {
        
        if (!$scope.formVideo.$valid) { return; }
        
        $scope.errores = null;
        $("body").attr("class", "charging");
        
        InformacionServi.guardarvideo($scope.informacion).then(function (data) {
            if(data.success == true){
                swal("Éxito", "Acción realizada satisfactoriamente", "success");
            }else{
               swal("Error", "La acción no se pudo realizar", "error");
               $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }
    
    $scope.guardarGaleria = function(){
        
        if( !$scope.galeria ){ return; }
        if( $scope.galeria.length==0 ){ return; }
        
        $scope.errores = null;
        $("body").attr("class", "charging");
        
        var fd = new FormData();
        fd.append( "id" , $scope.informacion.id );
        for(var i=0; i<$scope.galeria.length; i++){  fd.append( "galeria[]" , $scope.galeria[i] ); }
        
        InformacionServi.guardarGaleria(fd).then(function (data) {
            if (data.success) {
                $scope.informacion.imagenes = data.imagenes;
                $scope.galeria = [];
               swal("¡Imagenes guardadas!", "Las imagenes se han guardado exitosamente", "success");
            } else {
                swal("Error", "Por favor corregir los errores", "error");
                $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página", "error");
        })
        
    }
    
    
    $scope.eliminarImagen = function (id, index) {
    
        swal({
            title: "Eliminar imagen",
            text: "¿Esta seguro de eliminar la imagen?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            InformacionServi.eliminarImagen(id)
               .then(function(data){
                    if(data.success){
                       $scope.informacion.imagenes.splice(index,1)
                       swal("¡Eliminado!", "La imagen se ha eliminado exitosamente", "success");
                    }
                    else{
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    }
                }).catch(function () {
                    swal("Error", "Error en la carga, por favor recarga la página", "error");
                    $("body").attr("class", "cbp-spmenu-push"); 
                });
        });

    };
        
}]);


