
var app = angular.module("admin.noticia", ['ngMaterial','ngMessages','ng.ckeditor','noticiaService','angularUtils.directives.dirPagination']);

app.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            })
        }
    }
}]);
app.directive('ngHtml', ['$compile', function($compile) {
       return function(scope, elem, attrs) {
           if(attrs.ngHtml){
               elem.html(scope.$eval(attrs.ngHtml));
               $compile(elem.contents())(scope);
           }
           scope.$watch(attrs.ngHtml, function(newValue, oldValue) {
               if (newValue && newValue !== oldValue) {
                   elem.html(newValue);
                   $compile(elem.contents())(scope);
               }
           });
       };
}]);

app.controller('listadoNoticiasCtrl', function($scope, noticiaServi) {
    $("body").attr("class", "charging");
    noticiaServi.listadoNoticias().then(function (dato) {
        $scope.noticias = dato.noticias;
        for(var i=0; i<$scope.noticias.length;i++){
            $scope.noticias[i].estadoNoticia = $scope.noticias[i].estado == true ? 'Activo' : 'Inactivo';
        }
        $scope.tiposNoticias = dato.tiposNoticias;
        $scope.idiomasNoticia = dato.idiomasNoticia[0].idiomas;
        $scope.cantIdiomas = dato.cantIdiomas;
        $scope.noticias2 = dato.idiomasNoticia;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    $scope.cambiarEstado = function (obj) {
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
            $("body").attr("class", "charging");
            noticiaServi.cambiarEstadoNoticia(obj.idNoticia).then(function (data) {
                if(data.success == true){
                    $scope.noticias[$scope.noticias.indexOf(obj)].estado = !$scope.noticias[$scope.noticias.indexOf(obj)].estado;
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                }else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        })


    }
    
    $scope.eliminarNoticia = function (obj) {
        swal({
            title: "Eliminar",
            text: "¿Está seguro que desea eliminar la noticia?",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            
            $scope.errores = null;
            $("body").attr("class", "charging");
            noticiaServi.eliminarNoticia(obj.idNoticia).then(function (data) {
                if(data.success == true){
                    $scope.noticias.splice($scope.noticias.indexOf(obj), 1);
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                }else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        })


    }
});

app.controller('verNoticiaCtrl', function($scope, noticiaServi) {
   $scope.$watch('idNoticia', function () {
       $("body").attr("class", "charging");
        noticiaServi.verNoticia($scope.idNoticia).then(function (data) {
            $scope.noticia = data.noticia;
            $scope.multimediasNoticias = data.multimedia;
            $scope.portada = data.portada;
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    });
    
});

app.controller('crearNoticiaCtrl', function($scope, noticiaServi) {
    $scope.multimediasNoticias = [];
    $scope.noticia={};
    $scope.noticia.id = -1;
    $("body").attr("class", "charging");
    noticiaServi.datosCrearNoticia().then(function (data) {
        $scope.tiposNoticias = data.tiposNoticias;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    $scope.guardarNoticia= function () {
        if (!$scope.crearForm.$valid) {
            return;
        }
        $scope.errores = null;
        $("body").attr("class", "charging");
        noticiaServi.guardarNoticia($scope.noticia).then(function (data) {
            if(data.success == true){
                $scope.noticia.id = data.idNoticia;
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $scope.crearForm.$setPristine();
                   $scope.crearForm.$setUntouched();
                   $scope.crearForm.$submitted = false;
                   
    
                });
                //window.location.href="/bandeja";
                
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
    
    $scope.guardarMultimedia= function () {
        if (!$scope.crearMultimediaForm.$valid || ($scope.Galeria==null || $scope.Galeria.length==0 || $scope.Galeria == undefined)) {
            return;
        }
        if ($scope.noticia.id == null || $scope.noticia.id == undefined || $scope.noticia.id <= 0) {
            swal("Error", "Debe crear primero la noticia ", "error");
            return;
        }
        var input = $('#GaleriaNoticia');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 2097152) {
                swal("Error", "Por favor la imagen debe tener un peso menor de " + (5242880 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
        $scope.multimedia.idNoticia = $scope.noticia.id;
        var fd = new FormData();
         $scope.errores = null;
        for (nombre in $scope.multimedia) {
            if ($scope.multimedia[nombre] != null && $scope.multimedia[nombre] != "") {
                fd.append(nombre, $scope.multimedia[nombre])
            }
        }
        if ($scope.Galeria != null) {
            fd.append("Galeria", $scope.Galeria[0]);
        }
        $("body").attr("class", "charging");
        noticiaServi.guardarMultimediaNoticia(fd).then(function (data) {
            if(data.success == true){
               $scope.multimediasNoticias = data.multimedia;
                swal({
                  title: "Éxito",
                  text: "Multimedia creada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $('#modalCrearNoticia').modal('hide');
    
                });
                //window.location.href="/bandeja";
                
              }else{
                  swal("Error", "la multimedia no se pudo agregar", "error");
                  $scope.errores = data.errores;
                  
              }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }
    $scope.abrirModalCrearNoticia = function () {
        $scope.crearMultimediaForm.$setPristine();
       $scope.crearMultimediaForm.$setUntouched();
       $scope.crearMultimediaForm.$submitted = false;
       $scope.multimedia = null;
       $scope.Galeria = null;
        $scope.errores = null;
        $('#modalCrearNoticia').modal('show');
    }
    $scope.textoAlternativo = {};
    $scope.abrirModalTextoAlternativo = function (multimedia) {
        $scope.guardarTextoAlternativoForm.$setPristine();
       $scope.guardarTextoAlternativoForm.$setUntouched();
       $scope.guardarTextoAlternativoForm.$submitted = false;
       $scope.textoAlternativo.idMultimedia = multimedia.idMultimedia;
       $scope.textoAlternativo.textoAlternativo = multimedia.texto;
       $scope.textoAlternativo.idIdioma = 1;
       $scope.actualTexto = $scope.multimediasNoticias.indexOf(multimedia);
       //$scope.textoAlternativo.idIdioma = multimedia.idiomas_id;
        $scope.errores = null;
        $('#modalTextoAlternativo').modal('show');
    }
    $scope.guardarAlternativo = function () {
        if (!$scope.guardarTextoAlternativoForm.$valid) {
            return;
        }
        $scope.errores = null;
        $("body").attr("class", "charging");
        noticiaServi.guardarTextoAlternativo($scope.textoAlternativo).then(function (data) {
            if(data.success == true){
                    
                console.log($scope.noticia);
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                    $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    $scope.$apply(function () {
                        $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    });
                    $('#modalTextoAlternativo').modal('hide');
                    
                });
                //window.location.href="/bandeja";
                
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
});

app.controller('editarNoticiaCtrl', function($scope, noticiaServi) {
    $scope.editar = {};
    $scope.editar.idioma = {};
    $scope.noticia = {};
    $scope.multimediaEspaniol = [];
    $scope.$watch('editar2', function () {
        $("body").attr("class", "charging");
        noticiaServi.datosEditarNoticia($scope.editar2.idNoticia,$scope.editar2.idIdioma).then(function (data) {
            $scope.noticia = data.noticia;
            $scope.multimediasNoticias = data.multimediaEspañol;
            $scope.tiposNoticias = data.tiposNoticias;
            var sw=0;
            if(data.multimedia.length > 0){
                for(var i=0; i<$scope.multimediasNoticias.length; i++){
                    sw=0;
                    for(var j=0; j<data.multimedia.length; j++){
                        if(data.multimedia[j].idMultimedia == $scope.multimediasNoticias[i].idMultimedia){
                                $scope.multimediasNoticias[i].texto = data.multimedia[j].texto;
                                sw=1;
                        }
                    }
                    if(sw==0){
                        $scope.multimediasNoticias[i].texto = null;
                    }
                }
            }else{
                for(var i=0; i<$scope.multimediasNoticias.length; i++){
                                $scope.multimediasNoticias[i].texto = null;
                }
            }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    });
    
    $scope.guardarNoticia= function () {
        if (!$scope.crearForm.$valid) {
            return;
        }
        $scope.errores = null;
        $scope.noticia.idIdioma = $scope.editar2.idIdioma;
        $scope.noticia.id = $scope.editar2.idNoticia;
        $("body").attr("class", "charging");
        noticiaServi.modificarNoticia($scope.noticia).then(function (data) {
            if(data.success == true){
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $scope.crearForm.$setPristine();
                   $scope.crearForm.$setUntouched();
                   $scope.crearForm.$submitted = false;
                   
    
                });
                //window.location.href="/bandeja";
                
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
    
    $scope.guardarMultimedia= function () {
        if (!$scope.crearMultimediaForm.$valid || ($scope.Galeria==null || $scope.Galeria.length==0 || $scope.Galeria == undefined)) {
            return;
        }
        if ($scope.noticia.id == null || $scope.noticia.id == undefined || $scope.noticia.id <= 0) {
            swal("Error", "Debe crear primero la noticia ", "error");
            return;
        }
        var input = $('#GaleriaNoticia');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 2097152) {
                swal("Error", "Por favor la imagen debe tener un peso menor de " + (5242880 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
        $scope.multimedia.idNoticia = $scope.editar2.idNoticia;
        $scope.multimedia.idIdioma = $scope.editar.idioma.id;
        var fd = new FormData();
         $scope.errores = null;
        for (nombre in $scope.multimedia) {
            if ($scope.multimedia[nombre] != null && $scope.multimedia[nombre] != "") {
                fd.append(nombre, $scope.multimedia[nombre])
            }
        }
        if ($scope.Galeria != null) {
            fd.append("Galeria", $scope.Galeria[0]);
        }
        $("body").attr("class", "charging");
        noticiaServi.guardarMultimediaNoticia(fd).then(function (data) {
            if(data.success == true){
               $scope.multimediasNoticias = data.multimedia;
                swal({
                  title: "Éxito",
                  text: "Multimedia creada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $('#modalCrearNoticia').modal('hide');
                    //location.reload();
                });
                //window.location.href="/bandeja";
                
              }else{
                  swal("Error", "la multimedia no se pudo agregar", "error");
                  $scope.errores = data.errores;
                  
              }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }
    $scope.abrirModalCrearNoticia = function () {
        $scope.crearMultimediaForm.$setPristine();
       $scope.crearMultimediaForm.$setUntouched();
       $scope.crearMultimediaForm.$submitted = false;
       $scope.multimedia = null;
       $scope.Galeria = null;
        $scope.errores = null;
        $('#modalCrearNoticia').modal('show');
    }
    $scope.textoAlternativo = {};
    $scope.abrirModalTextoAlternativo = function (multimedia) {
        $scope.guardarTextoAlternativoForm.$setPristine();
       $scope.guardarTextoAlternativoForm.$setUntouched();
       $scope.guardarTextoAlternativoForm.$submitted = false;
       $scope.textoAlternativo.idMultimedia = multimedia.idMultimedia;
       $scope.textoAlternativo.textoAlternativo = multimedia.texto;
       $scope.textoAlternativo.idIdioma = $scope.editar2.idIdioma;
       $scope.actualTexto = $scope.multimediasNoticias.indexOf(multimedia);
       //$scope.textoAlternativo.idIdioma = multimedia.idiomas_id;
        $scope.errores = null;
        $('#modalTextoAlternativo').modal('show');
    }
    $scope.guardarAlternativo = function () {
        if (!$scope.guardarTextoAlternativoForm.$valid) {
            return;
        }
        $scope.errores = null;
        $("body").attr("class", "charging");
        noticiaServi.guardarTextoAlternativo($scope.textoAlternativo).then(function (data) {
            if(data.success == true){
                    
                console.log($scope.noticia);
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                    $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    $scope.$apply(function () {
                        $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    });
                    /*for(var i=0;i<$scope.multimediasNoticias.length;i++){
                        if($scope.multimediasNoticias[i].idMultimedia == data.idMultimedia){
                            $scope.multimediasNoticias[i].texto = data.texto;
                        
                            break;
                        }
                    }*/
                    $('#modalTextoAlternativo').modal('hide');
                    
                });
                //window.location.href="/bandeja";
                
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
    $scope.cambiarEstado = function (obj) {
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
            $("body").attr("class", "charging");
            noticiaServi.cambiarEstadoNoticia(obj.idNoticia).then(function (data) {
                if(data.success == true){
                    $scope.noticias[$scope.noticias.indexOf(obj)].estado = !$scope.noticias[$scope.noticias.indexOf(obj)].estado;
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                }else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        })


    }
    
    $scope.eliminarMultimedia = function (obj) {
        swal({
            title: "Eliminar",
            text: "¿Está seguro que desea eliminar la multimedia?. Se eliminará automaticamente en los idiomas donde se encuentre la multimedia seleccionada.",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            
            $scope.errores = null;
            $("body").attr("class", "charging");
            noticiaServi.eliminarMultimedia(obj.idMultimedia).then(function (data) {
                if(data.success == true){
                    $scope.multimediasNoticias.splice($scope.multimediasNoticias.indexOf(obj), 1);
                    swal("Exito", "Se realizó la operación exitosamente", "success");
                }else {
                    swal("Error", "Se ha manipulado la información, intente de nuevo", "error");
                }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
            });

        })


    }
    $scope.abrirModalEditarMultimedia = function (multimedia) {
        $scope.editarMultimediaForm.$setPristine();
       $scope.editarMultimediaForm.$setUntouched();
       $scope.editarMultimediaForm.$submitted = false;
       $scope.multimediaEditar = [];
       $scope.multimediaEditar["idMultimedia"] = multimedia.idMultimedia;
       $scope.multimediaEditar["texto_alternativo"] = multimedia.texto;
       $scope.multimediaEditar["ruta"] = multimedia.ruta;
       $scope.multimediaEditar["portadaNoticia"] = multimedia.portada == true ? 1 : 2;
       $scope.indexMultimediaEditar = $scope.multimediasNoticias.indexOf(multimedia);
        $scope.errores = null;
        $('#modalEditarMultimedia').modal('show');
    }
    $scope.editarMultimedia= function () {
        if (!$scope.editarMultimediaForm.$valid) {
            return;
        }
        var input = $('#GaleriaNoticia');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 2097152) {
                swal("Error", "Por favor la imagen debe tener un peso menor de " + (5242880 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
        var fd = new FormData();
         $scope.errores = null;
        for (nombre in $scope.multimediaEditar) {
            if ($scope.multimediaEditar[nombre] != null && $scope.multimediaEditar[nombre] != "") {
                fd.append(nombre, $scope.multimediaEditar[nombre])
            }
        }
        if ($scope.Galeria != null) {
            fd.append("Galeria", $scope.Galeria[0]);
        }
        $("body").attr("class", "charging");
        noticiaServi.editarMultimediaNoticia(fd).then(function (data) {
            if(data.success == true){
               $scope.multimediasNoticias[$scope.indexMultimediaEditar].texto =  data.multimedia["texto"];
            $scope.multimediasNoticias[$scope.indexMultimediaEditar].portada =  data.multimedia["portada"];
            $scope.multimediasNoticias[$scope.indexMultimediaEditar].ruta =  data.multimedia["ruta"];
                swal({
                  title: "Éxito",
                  text: "Multimedia creada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                    
                  $('#modalEditarMultimedia').modal('hide');
                    //location.reload();
                });
                //window.location.href="/bandeja";
                
              }else{
                  swal("Error", "la multimedia no se pudo agregar", "error");
                  $scope.errores = data.errores;
                  
              }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });

    }
});
app.controller('crearIdiomaCtrl', function($scope, noticiaServi) {
    $scope.multimediasNoticias = [];
    $scope.noticia={};
    $scope.$watch('noticia.idNoticia', function () {
        $("body").attr("class", "charging");
        noticiaServi.datosNuevoIdioma($scope.noticia.idNoticia).then(function (data) {
            $scope.idiomas = data.idiomas;
            $scope.multimediasNoticias = data.multimedia;
            $scope.tiposNoticias = data.tiposNoticias;
                for(var i=0; i<$scope.multimediasNoticias.length; i++){
                                $scope.multimediasNoticias[i].texto = null;
                }
            
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    });
    $scope.guardarNoticia= function () {
        if (!$scope.crearForm.$valid) {
            return;
        }
        $scope.errores = null;
        $("body").attr("class", "charging");
        noticiaServi.guardarNuevoIdioma($scope.noticia).then(function (data) {
            if(data.success == true){
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                  $scope.crearForm.$setPristine();
                   $scope.crearForm.$setUntouched();
                   $scope.crearForm.$submitted = false;
                   window.location.href="/noticias/listadonoticias";
    
                });
                
                
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
    $scope.textoAlternativo = {};
    $scope.abrirModalTextoAlternativo = function (multimedia) {
        $scope.guardarTextoAlternativoForm.$setPristine();
       $scope.guardarTextoAlternativoForm.$setUntouched();
       $scope.guardarTextoAlternativoForm.$submitted = false;
       $scope.textoAlternativo.idMultimedia = multimedia.idMultimedia;
       $scope.textoAlternativo.textoAlternativo = multimedia.texto;
       $scope.textoAlternativo.idIdioma = $scope.noticia.idioma;
       $scope.actualTexto = $scope.multimediasNoticias.indexOf(multimedia);
       //$scope.textoAlternativo.idIdioma = multimedia.idiomas_id;
        $scope.errores = null;
        $('#modalTextoAlternativo').modal('show');
    }
    $scope.guardarAlternativo = function () {
        if (!$scope.guardarTextoAlternativoForm.$valid) {
            return;
        }
        $scope.errores = null;
        $("body").attr("class", "charging");
        $scope.textoAlternativo.idIdioma = $scope.noticia.idioma;
        noticiaServi.guardarTextoAlternativo($scope.textoAlternativo).then(function (data) {
            if(data.success == true){
                    
                console.log($scope.noticia);
                swal({
                  title: "Éxito",
                  text: "Acción realizada satisfactoriamente",
                  type: "success",
                  confirmButtonText: "",
                },
                function(){
                    $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    $scope.$apply(function () {
                        $scope.multimediasNoticias[$scope.actualTexto].texto = data.texto;
                    });
                    /*for(var i=0;i<$scope.multimediasNoticias.length;i++){
                        if($scope.multimediasNoticias[i].idMultimedia == data.idMultimedia){
                            $scope.multimediasNoticias[i].texto = data.texto;
                        
                            break;
                        }
                    }*/
                    $('#modalTextoAlternativo').modal('hide');
                    
                });
                //window.location.href="/bandeja";
                
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
});