/* global angular */
/* global swal */
angular.module('proveedores.crear', [])

.controller('proveedoresCrearController', function($scope, proveedoresServi){
    
    $scope.proveedor = {
        datosGenerales: {},
        id: -1
    };
    
    $("body").attr("class", "cbp-spmenu-push charging");
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
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.selectionChanged = function (proveedor){
        $scope.nombreProveedor = proveedor.razon_social;
    }
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.crearProveedorForm.$valid || $scope.proveedor.id != -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postCrearproveedor($scope.proveedor.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                $scope.proveedor.id = data.id;
                swal('¡Éxito!', 'Proveedor creado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid || $scope.proveedor.id == -1){
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
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
            }
        }
        fd.append('id', $scope.proveedor.id);
        fd.append('video_promocional', $("#video_promocional").val());
        $("body").attr("class", "cbp-spmenu-push charging");
        proveedoresServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
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
        if (!$scope.informacionAdicionalForm.$valid || $scope.proveedor.id == -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.proveedor.adicional.id = $scope.proveedor.id;
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