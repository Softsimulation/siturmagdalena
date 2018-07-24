/* global angular */
/* global swal */
angular.module('atracciones.editar', [])

.controller('atraccionesEditarController', function($scope, atraccionesServi, $location, $http){
    $scope.atraccion = {
        adicional: {}
    };
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.getDatosatraccion($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.atraccion.adicional.perfiles = data.perfiles_turista;
                $scope.atraccion.adicional.tipos = data.tipo_atracciones;
                $scope.atraccion.adicional.categorias = data.categorias_turismo;
                $scope.atraccion.adicional.actividades = data.actividades;
                
                var portada = null;
                $http.get("../.." + data.portadaIMG, {responseType: "blob"}).success((data) => {
                    portada = data;
                    $scope.previewportadaIMG.push(portada);
                });
                
                var imagenes = [];
                for (var i = 0; i < data.imagenes.length; i++){
                    $http.get("../.." + data.imagenes[i], {responseType: "blob"}).success((response) => {
                        imagenes.push(response);
                    });
                    if (i == (data.imagenes.length - 1)){
                        $scope.previewImagenes = imagenes;
                    }
                }
                $scope.video_promocional = data.video_promocional;
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    atraccionesServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.sectores = data.sectores;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.tipos_atracciones = data.tipos_atracciones;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.actividades = data.actividades;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid && $scope.atraccion.id != -1){
            return;
        }
        var fd = new FormData();
        var input = $('#portadaIMG');
        if (input[0] != undefined) {
            // check for browser support (may need to be modified)
            if (input[0].files && input[0].files.length == 1) {
                if (input[0].files[0].size > 2097152) {
                    swal("Error", "Por favor la imagen debe tener un peso menor de " + (2097152 / 1024 / 1024) + " MB", "error");
                    // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                    return;
                }
            }
        }
        
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
            }
        }
        fd.append('id', $scope.id);
        fd.append('video_promocional', $("#video_promocional").val());
        atraccionesServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                swal('¡Éxito!', 'Multimedia agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid || $scope.atraccion.id == -1){
            return;
        }
        $scope.atraccion.adicional.id = $scope.id;
        atraccionesServi.postGuardaradicional($scope.atraccion.adicional).then(function(data){
            if (data.success){
                swal('¡Éxito!', 'Atracción creada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});