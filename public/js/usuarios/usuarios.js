var situr = angular.module("admin.usuario", ['ngSanitize','ADM-dateTimePicker','ui.select', 'angularUtils.directives.dirPagination', 'checklist-model', 'angular-repeat-n','usuarioService']);

situr.controller('listadoUsuariosCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    
    $("body").attr("class", "charging");
    usuarioServi.getUsuarios().then(function (data) {
        $scope.usuarios = data.usuarios;
        $scope.roles = data.roles;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    $scope.cambiarEstado = function (usuario) {
        swal({
            title: "Cambiar estado",
            text: "¿Está seguro que desea cambiar el estado?",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            
            $scope.errores = null;
            usuarioServi.cambiarEstado(usuario.id).then(function (data) {
                if(data.success == true){
                    $scope.usuarios[$scope.usuarios.indexOf(usuario)].estado = !$scope.usuarios[$scope.usuarios.indexOf(usuario)].estado;
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                }else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la página.", "error");
            })

        })


    }
}])
situr.controller('guardarUsuarioCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    
    $("body").attr("class", "charging");
    usuarioServi.getInformacionguardar().then(function (data) {
        $scope.roles = data.roles;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.guardarUsuario = function () {
        if (!$scope.crearForm.$valid || $scope.usuario.rol.length == 0) {
            return;
        }
        $("body").attr("class", "charging");
        usuarioServi.guardar($scope.usuario).then(function (data) {
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {

                    window.location.href = "/usuario/listadousuarios"
                }, 1000);
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })

    }
    
}])
situr.controller('editarUsuarioCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    
    $("body").attr("class", "charging");
    usuarioServi.getInformacionguardar().then(function (data) {
        $scope.roles = data.roles;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.editarUsuario = function () {
        if (!$scope.crearForm.$valid || $scope.usuario.rol.length == 0) {
            return;
        }
        $("body").attr("class", "charging");
        usuarioServi.editar($scope.usuario).then(function (data) {
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {

                    window.location.href = "/usuario/listadousuarios"
                }, 1000);
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = data.errores;
            }
            $("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })

    }
    $scope.$watch('usuario.id', function () {
        usuarioServi.getInformacionEditar($scope.usuario.id).then(function (data) {
            $scope.usuario = data.usuario
            $('#processing').removeClass('process-in');
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    });
}])