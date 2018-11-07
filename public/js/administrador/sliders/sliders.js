
var app = angular.module("admin.slider", ['ngMaterial','ngMessages','ng.ckeditor','sliderService','angularUtils.directives.dirPagination','ui.select','ngSanitize']);

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

app.controller('listadoSlidersCtrl', function($scope, sliderServi) {
    $scope.sliders = [];
    $("body").attr("class", "charging");
    sliderServi.listadoSliders().then(function (dato) {
        $scope.sliders = dato.sliders;
        $scope.actividades = dato.actividades;
        $scope.atracciones = dato.atracciones;
        $scope.destinos = dato.destinos;
        $scope.eventos = dato.eventos;
        $scope.proveedores = dato.proveedores;
        $scope.rutas = dato.rutas;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    
    $scope.abrirModalCrearSlider = function () {
        $scope.slider = { };
        $scope.errores = null;
        $scope.crearSliderForm.$setPristine();
        $scope.crearSliderForm.$setUntouched();
        $scope.crearSliderForm.$submitted = false;
        $scope.slider.enlaceInterno = 2;
        $('#nombreImagenSlider').val('');
        $scope.imagenSlider = null;
        $('#modalAgregarSlider').modal('show');

    }
    
    $scope.guardarSlider = function () {
        if (!$scope.crearSliderForm.$valid || $scope.imagenSlider == null) {
            swal("Error", "Error en el formulario, favor revisar.", "error");
            return;
        }
        var input = $('#imagenSlider');
        // check for browser support (may need to be modified)
        if (input[0].files && input[0].files.length == 1) {
            if (input[0].files[0].size > 2097152) {
                swal("Error", "Por favor la imagen debe tener un peso menor de " + (2097152 / 1024 / 1024) + " MB", "error");
                // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                return;
            }
        }
        var fd = new FormData();
        for (nombre in $scope.slider) {
            if ($scope.slider[nombre] != null && $scope.slider[nombre] != "") {
                fd.append(nombre, $scope.slider[nombre]);
            }
        }
        if ($scope.imagenSlider != null) {
            fd.append("imagenSlider", $scope.imagenSlider[0]);
        }
        $("body").attr("class", "charging");
        sliderServi.agregarSlider(fd).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders = data.sliders;
                swal({
                    title: "Agregado",
                    text: "Se ha agregado satisfactoriamente la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {

                    $('#modalAgregarSlider').modal('hide');
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
    $scope.abirModalEditarSlider = function (idiomaId, slider) {
        $scope.indexSliderEditar = $scope.sliders.indexOf(slider);
        $scope.idiomaSliderEditar = idiomaId;
        $scope.errores = null;
        $scope.editarSliderForm.$setPristine();
        $scope.editarSliderForm.$setUntouched();
        $scope.editarSliderForm.$submitted = false;
        $('#nombreImagenSliderEditar').val('');
        $scope.imagenSliderEditar = null;
        $scope.sliderEditar = {};
        var objetoEnviar = {idiomaId:idiomaId,slider:slider.id}
        //$("body").attr("class", "charging");
        sliderServi.getInfoEditarSlider(objetoEnviar).then(function (data) {
            
            $scope.sliderEditar = data.slider;
            $('#modalEditarSlider').modal('show');
            //$("body").attr("class", "cbp-spmenu-push");
        }).catch(function () {
            //$("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    }

    $scope.editarSlider = function () {
        if (!$scope.editarSliderForm.$valid) {
            swal("Error", "Error en el formulario, favor revisar.", "error");
            return;
        }
        if ($scope.imagenSliderEditar != null) {
            var input = $('#imagenSliderEditar');
            // check for browser support (may need to be modified)
            if (input[0].files && input[0].files.length == 1) {
                if (input[0].files[0].size > 2097152) {
                    swal("Error", "Por favor la imagen debe tener un peso menor de " + (2097152 / 1024 / 1024) + " MB", "error");
                    // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                    return;
                }
            }
        }
        $scope.sliderEditar.idiomaId = $scope.idiomaSliderEditar;
        var fd = new FormData();
        for (nombre in $scope.sliderEditar) {
            if ($scope.sliderEditar[nombre] != null && $scope.sliderEditar[nombre] != "") {
                fd.append(nombre, $scope.sliderEditar[nombre]);
            }
        }
        if ($scope.imagenSliderEditar != null) {
            fd.append("imagenSliderEditar", $scope.imagenSliderEditar[0]);
        }
        $("body").attr("class", "charging");
        sliderServi.editarSlider(fd).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders[$scope.indexSliderEditar] = data.slider;
                swal({
                    title: "Editado",
                    text: "Se ha editado satisfactoriamente la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {

                    $('#modalEditarSlider').modal('hide');
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

    $scope.abrirModalAgregarIdiomaSlider = function (slider) {
        $scope.indexSliderAgregarIdioma = $scope.sliders.indexOf(slider);
        $scope.errores = null;
        $scope.agregarIdiomaSliderForm.$setPristine();
        $scope.agregarIdiomaSliderForm.$setUntouched();
        $scope.agregarIdiomaSliderForm.$submitted = false;
        $scope.agregarIdiomaSlider = {};
        $scope.agregarIdiomaSlider.imagenActual = slider.rutaSlider;
        $scope.agregarIdiomaSlider.noIdiomas = slider.noIdiomas;
        $scope.agregarIdiomaSlider.id = slider.id;
        $('#modalAgregarIdiomaSlider').modal('show');
    }

    $scope.agregarIdioma = function () {
        if (!$scope.agregarIdiomaSliderForm.$valid) {
            return;
        }
        $("body").attr("class", "charging");
        sliderServi.agregarIdiomaSlider($scope.agregarIdiomaSlider).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders[$scope.indexSliderAgregarIdioma] = data.slider;
                swal({
                    title: "Agregado",
                    text: "Se ha agregado satisfactoriamente el nuevo idioma.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalAgregarIdiomaSlider').modal('hide');
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
    $scope.desactivarSlider = function (slider) {
        
        $scope.indexSliderDesactivar= $scope.sliders.indexOf(slider);
        swal({
            title: "Desactivar",
            text: "¿Está seguro?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            setTimeout(function () {
                $("body").attr("class", "charging");
                sliderServi.desactivarSlider(slider.id).then(function (data) {
                    if (data.success) {
                        $scope.errores = null;
                        slider.estadoSlider = slider.estadoSlider == 1 ? 0 : 1;
                        slider.prioridadSlider = 0;
                        swal({
                            title: "Realizado",
                            text: "Se ha desactivado la imagen.",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                        }, 2000);
                    } else {
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                        $scope.errores = data.errores;
                    }
                    $("body").attr("class", "cbp-spmenu-push");
                }).catch(function () {
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error", "Error en la carga, por favor recarga la página.", "error");
                })
            }, 2000);
        });
    }

    $scope.activarSlider = function (slider) {
        var contActivos = 0;
        $scope.sliderActivar = {};
        $scope.sliderActivar.id = slider.id;
        for (var i = 0; i < $scope.sliders.length; i++) {
            if ($scope.sliders[i].estadoSlider == 1) {
                contActivos = contActivos + 1;
            }
        }
        if (contActivos == 8) {
            $scope.errores = null;
            $scope.activarSliderForm.$setPristine();
            $scope.activarSliderForm.$setUntouched();
            $scope.activarSliderForm.$submitted = false;
            $('#prioridadSliderActivar').val('');
            $scope.activarSliderForm.prioridadSliderActivar.$error.min = false;
            $scope.activarSliderForm.prioridadSliderActivar.$error.max = false;
            
            $('#modalActivarSlider').modal('show');
            return;
        }
        $("body").attr("class", "charging");
        sliderServi.activarSlider($scope.sliderActivar).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders = data.sliders;
                $('#modalActivarSlider').modal('hide');
                swal({
                    title: "Activado",
                    text: "Se ha activado satisfactoriamente la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
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

    $scope.activarSlider2 = function (slider) {
        if (!$scope.activarSliderForm.$valid) {
            return;
        }
        if ($scope.sliderActivar == null) {
            $scope.sliderActivar.prioridadSliderActivar = 0;
        }
        $scope.sliderActivar.bandera = 1;
        $("body").attr("class", "charging");
        sliderServi.activarSlider($scope.sliderActivar).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders = data.sliders;
                $('#modalActivarSlider').modal('hide');
                swal({
                    title: "Activado",
                    text: "Se ha activado satisfactoriamente la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
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

    $scope.subirPrioridadSlider = function (slider) {
        $("body").attr("class", "charging");
        sliderServi.subirPrioridadSlider(slider.id).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders = data.sliders;
                swal({
                    title: "Realizado",
                    text: "Se ha modificado satisfactoriamente la prioridad de la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
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

    $scope.bajarPrioridadSlider = function (slider) {
        $("body").attr("class", "charging");
        sliderServi.bajarPrioridadSlider(slider.id).then(function (data) {
            if (data.success) {
                $scope.errores = null;
                $scope.sliders = data.sliders;
                swal({
                    title: "Realizado",
                    text: "Se ha modificado satisfactoriamente la prioridad de la imagen.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
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
});