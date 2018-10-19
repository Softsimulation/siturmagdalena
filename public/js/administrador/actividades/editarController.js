/* global angular */
/* global swal */
angular.module('actividades.editar', [])

.controller('actividadesEditarController', function($scope, actividadesServi, $location, $http){
    $scope.actividad = {
        adicional: {},
        datosGenerales: {}
    };
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        actividadesServi.getDatosactividad($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.actividadNombre = data.actividad.actividades_con_idiomas[0].nombre;
                $scope.actividad.adicional.perfiles = data.perfiles_turista;
                $scope.actividad.adicional.sitios = data.sitios;
                $scope.actividad.adicional.categorias = data.categorias_turismo;
                $scope.actividad.datosGenerales.valor_maximo = parseInt(data.actividad.valor_max);
                $scope.actividad.datosGenerales.valor_minimo = parseInt(data.actividad.valor_min);
                
                var portada = null;
                if (data.portadaIMG != null){
                    $http.get("../.." + data.portadaIMG, {responseType: "blob"}).success((data) => {
                        portada = data;
                        $scope.previewportadaIMG.push(portada);
                    });
                }
                
                var imagenes = [];
                for (var i = 0; i < data.imagenes.length; i++){
                    $http.get("../.." + data.imagenes[i], {responseType: "blob"}).success((response) => {
                        imagenes.push(response);
                    });
                    if (i == (data.imagenes.length - 1)){
                        $scope.previewImagenes = imagenes;
                    }
                }
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    actividadesServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.sitios = data.sitios;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.categorias_turismo = data.categorias_turismo;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarMultimedia = function (){
        if (!$scope.editarMultimediaForm.$valid){
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
        if ($scope.portadaIMG != undefined) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
            return;
        }
        if ($scope.imagenes != undefined) {
            for (i in $scope.imagenes){
                if (Number.isInteger(parseInt(i))){
                    fd.append("image[]", $scope.imagenes[i]);
                }
            }
        }
        console.log($scope.imagenes);
        fd.append('id', $scope.id);
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
        if (!$scope.informacionAdicionalForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.actividad.adicional.id = $scope.id;
        actividadesServi.postGuardaradicional($scope.actividad.adicional).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                swal('¡Éxito!', 'Información adicional editada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarActividadForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.actividad.datosGenerales.id = $scope.id;
        actividadesServi.postEditardatosgenerales($scope.actividad.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                swal('¡Éxito!', 'Actividad modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});