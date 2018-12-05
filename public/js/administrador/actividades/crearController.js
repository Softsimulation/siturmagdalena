/* global angular */
/* global swal */
angular.module('actividades.crear', [])

.controller('actividadesCrearController', function($scope, actividadesServi){
    $scope.actividad = {
        id: -1,
        adicional: {}
    };
    
    $scope.groupByDestino = function (item) {
        // by returning this, it will attach this as the group by key
        // and automatically group your items by this
        return item.destino.destino_con_idiomas[0].nombre;
    }
    
    $("body").attr("class", "cbp-spmenu-push charging");
    actividadesServi.getDatoscrear().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.sitios = data.sitios;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.categorias_turismo = data.categorias_turismo;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.crearActividadForm.$valid || $scope.actividad.id != -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        actividadesServi.postCrearactividad($scope.actividad.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.actividad.id = data.id;
                swal('¡Éxito!', 'Actividad creada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid || $scope.actividad.id == -1){
            return;
        }
        var fd = new FormData();
        var input = $('#files-brcc-portadaIMG');
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
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
            fd.append("portadaIMGText", $('#text-brcc-portadaIMG-0').val());
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
                fd.append("imageText[]", $('#text-brcc-imagenes-'+i).val());
            }
        }
        fd.append('id', $scope.actividad.id);
        fd.append('video_promocional', $("#video_promocional").val());
        $("body").attr("class", "cbp-spmenu-push charging");
        actividadesServi.postGuardarmultimedia(fd).then(function (data){
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
        if (!$scope.informacionAdicionalForm.$valid || $scope.actividad.id == -1){
            return;
        }
        $scope.actividad.adicional.id = $scope.actividad.id;
        actividadesServi.postGuardaradicional($scope.actividad.adicional).then(function(data){
            if (data.success){
                swal('¡Éxito!', 'Información adicional agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});