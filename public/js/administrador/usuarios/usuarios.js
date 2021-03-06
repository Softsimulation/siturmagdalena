var situr = angular.module("admin.usuario", ['ngSanitize','ADM-dateTimePicker','ui.select', 'angularUtils.directives.dirPagination','usuarioService','checklist-model']);

situr.controller('listadoUsuariosCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    
    $scope.usuariosCorreos = { ids:[] };
    $scope.asignarPermiso = { permisos:[] };
    $scope.permisos = [];
    $("body").attr("class", "charging");
    usuarioServi.getUsuarios().then(function (data) {
        $scope.usuarios = data.usuarios;
        for(var i=0; i<$scope.usuarios.length; i++){
            $scope.usuarios[i].nombreEstado = $scope.usuarios[i].estado == true ? "Activo" : "Inactivo";
            $scope.usuarios[i].nombresRoles = "";
            for(var j=0; j<$scope.usuarios[i].roles.length;j++){
               if(j==0){
                   $scope.usuarios[i].nombresRoles = $scope.usuarios[i].roles[j].display_name;
               }else{
                   $scope.usuarios[i].nombresRoles = $scope.usuarios[i].nombresRoles+"," + $scope.usuarios[i].roles[j].display_name;
               } 
            }
        }
        $scope.roles = data.roles;
        $scope.permisos = data.permisos;
        $scope.proveedoresRNT = data.proveedoresRNT;
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
    $scope.asignarPermisosModal = function (usuario) {
        $scope.asignarPermiso = {};
        $scope.asignarPermisosForm.$setPristine();
        $scope.asignarPermisosForm.$setUntouched();
        $scope.asignarPermisosForm.$submitted = false;
        
        $scope.errores = null;
        $scope.usuarioAsignacion = usuario;
        $scope.asignarPermiso.idUsuario=usuario.id;
        $scope.asignarPermiso.permisos=usuario.permisos;
        $('#modalAsignacionPermiso').modal('show');
    }
    $scope.asignacionPermisos = function (usuario) {
        $("body").attr("class", "charging");
        usuarioServi.asignacionPermisos($scope.asignarPermiso).then(function (data) {
            if (data.success) {
                $scope.usuarios[$scope.usuarios.indexOf($scope.usuarioAsignacion)].permisos = data.permisos;
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalAsignacionPermiso').modal('hide');
                    //window.location.href = "/usuario/listadousuarios"
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
    $scope.enviarCorreos = function () {
        $("body").attr("class", "charging");
        usuarioServi.envioCorreos( { usuarios:$scope.usuariosCorreos.ids } ).then(function (data) {
            if (data.success) {
                $scope.usuariosCorreos = {};
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {

                    //window.location.href = "/usuario/listadousuarios"
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
situr.controller('guardarUsuarioCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    
    $("body").attr("class", "charging");
    usuarioServi.getInformacionguardar().then(function (data) {
        $scope.roles = data.roles;
        $scope.proveedoresRNT = data.proveedoresRNT;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    $scope.usuario = {'rol':[],'proveedoresRNT':[]};
    $scope.$watch('usuario.rol', function () {
        $scope.es_pst = false;
        for(var i=0;i<$scope.usuario.rol.length; i++){
            if($scope.usuario.rol[i] == 3){
                $scope.es_pst = true;
            }
        }
        
    });
    
    $scope.guardarUsuario = function () {
        if (!$scope.crearForm.$valid || ($scope.es_pst == true && $scope.usuario.proveedoresRNT.length == 0)) {
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
        $scope.proveedoresRNT = data.proveedoresRNT;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.usuario = {'rol':[],'proveedoresRNT':[]};
    $scope.$watch('usuario.rol', function () {
        $scope.es_pst = false;
        for(var i=0;i<$scope.usuario.rol.length; i++){
            if($scope.usuario.rol[i] == 3){
                $scope.es_pst = true;
            }
        }
        
    });
    
    $scope.editarUsuario = function () {
        if (!$scope.crearForm.$valid || ($scope.es_pst == true && $scope.usuario.proveedoresRNT.length == 0)) {
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

situr.controller('asignacionPermisosCtrl', ['$scope','usuarioServi', function ($scope,usuarioServi) {
    $scope.permisos = [];
    $scope.$watch('id', function () {
        $("body").attr("class", "charging");
        usuarioServi.getPermisosUsuario($scope.id).then(function (data) {
            $scope.permisos = data.permisos;
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    });
    
    $scope.asignacionPermisos = function () {
        $("body").attr("class", "charging");
        usuarioServi.asignacionPermisos($scope.permisos,$scope.id).then(function (data) {
            if (data.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalAsignacionPermiso').modal('hide');
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