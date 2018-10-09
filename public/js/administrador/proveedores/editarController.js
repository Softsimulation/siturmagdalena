/* global angular */
/* global swal */
angular.module('proveedores.editar', [])

.controller('proveedoresEditarController', function($scope, proveedoresServi, $location, $http){
    $scope.proveedor = {
        adicional: {},
        datosGenerales: {}
    };
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    
    $scope.selectionChanged = function (proveedor){
        $scope.proveedorNombre = proveedor.razon_social;
    }
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.getDatosproveedor($scope.id).then(function(data){
            if (data.success){
                $scope.proveedorNombre = data.proveedor.proveedor_rnt.razon_social;
                $scope.proveedor.adicional.perfiles = data.perfiles_usuarios;
                $scope.proveedor.adicional.actividades = data.actividades;
                $scope.proveedor.adicional.categorias = data.categorias_turismo;
                
                $scope.proveedor.datosGenerales.valor_minimo = parseInt(data.proveedor.valor_min);
                $scope.proveedor.datosGenerales.valor_maximo = parseInt(data.proveedor.valor_max);
                $scope.proveedor.datosGenerales.proveedor_rnt_id = data.proveedor.proveedor_rnt_id;
                $scope.proveedor.datosGenerales.telefono = data.proveedor.telefono;
                $scope.proveedor.datosGenerales.pagina_web = data.proveedor.sitio_web;
                $scope.proveedor.datosGenerales.id = $scope.id;
                
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
                $scope.video_promocional = data.video_promocional;
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    proveedoresServi.getDatoscrear().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.categoria_proveedor = data.categoria_proveedor;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.actividades = data.actividades;
            $scope.proveedores = data.proveedores_rnt;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid){
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
        
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (var i in $scope.imagenes){
                if (Number.isInteger(parseInt(i))){
                    fd.append("image[]", $scope.imagenes[i]);
                }
            }
        }
        fd.append('id', $scope.id);
        fd.append('video_promocional', $("#video_promocional").val());
        proveedoresServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Multimedia modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarProveedorForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postEditarproveedor($scope.proveedor.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Proveedor modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid){
            return;
        }
        $scope.proveedor.adicional.id = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postGuardaradicional($scope.proveedor.adicional).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Información adicional agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});