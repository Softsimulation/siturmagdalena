
var app = angular.module("admin.indicadoresMedicion", ['indicadorMedicionService','angularUtils.directives.dirPagination','ui.select']);

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

app.controller('listadoIndicadoresMedicionCtrl', function($scope, indicadorMedicionServi) {
    
    $("body").attr("class", "charging");
    indicadorMedicionServi.listadoIndicadores().then(function (dato) {
        $scope.indicadores = [];
        $scope.indicadores = dato.indicadores;
        $scope.idiomas = dato.idiomas;
        $scope.tiposMediciones = dato.tiposMediciones;
        for(var i=0;i<$scope.indicadores.length;i++){
            $scope.indicadores[i].idsGraficas = [];
            $scope.indicadores[i].graficaPrincipal = null;
            $scope.indicadores[i].categoria = $scope.indicadores[i].tipo_indicador.nombre;
            $scope.indicadores[i].nombre = $scope.indicadores[i].idiomas[0].nombre;
            $scope.indicadores[i].descripcion = $scope.indicadores[i].idiomas[0].descripcion;
            $scope.indicadores[i].eje_x = $scope.indicadores[i].idiomas[0].eje_x;
            $scope.indicadores[i].eje_y = $scope.indicadores[i].idiomas[0].eje_y;
            $scope.indicadores[i].estadoIndicador = $scope.indicadores[i].estado == true ? "Activo" : "Inactivo";
            for(var j=0;j<$scope.indicadores[i].graficas.length;j++){
                $scope.indicadores[i].idsGraficas.push($scope.indicadores[i].graficas[j].id);
                if($scope.indicadores[i].graficas[j].pivot.es_principal){
                    $scope.indicadores[i].graficaPrincipal = $scope.indicadores[i].graficas[j].id;
                }
            }
        }
        $scope.tiposGraficas = dato.tiposGraficas;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    
    $scope.editarIndicadorModal = function(indicador,idioma_id){
        $scope.editarIndicador = {};
        $scope.editarIndicadorForm.$setPristine();
        $scope.editarIndicadorForm.$setUntouched();
        $scope.editarIndicadorForm.$submitted = false;
        $scope.errores = null;
        $("body").attr("class", "charging");
        indicadorMedicionServi.getInformacionEditar(indicador.id,idioma_id).then(function (dato) {
            $scope.editarIndicador.nombre = dato.indicador.idiomas[0].nombre;
            $scope.editarIndicador.formato = dato.indicador.formato;
            $scope.editarIndicador.descripcion = dato.indicador.idiomas[0].descripcion;
            $scope.editarIndicador.eje_x = dato.indicador.idiomas[0].eje_x;
            $scope.editarIndicador.eje_y = dato.indicador.idiomas[0].eje_y;
            $scope.editarIndicador.idsGraficas = indicador.idsGraficas;
            $scope.editarIndicador.graficaPrincipal = indicador.graficaPrincipal;
            $scope.editarIndicador.id = dato.indicador.id;
            $scope.editarIndicador.idioma_id = dato.indicador.idiomas[0].idioma_id;
            $("body").attr("class", "cbp-spmenu-push");
            $('#modalEditarIndicador').modal('show');
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
        
        
        
        
    }
    $scope.guardarIndicador = function(){
        if (!$scope.editarIndicadorForm.$valid || ($scope.editarIndicador.idsGraficas.length == 0 && $scope.editarIndicador.idioma_id == 1)) {
            return;
        }
        $("body").attr("class", "charging");
        indicadorMedicionServi.guardarIndicador($scope.editarIndicador).then(function (dato) {
            $("body").attr("class", "cbp-spmenu-push");
            if (dato.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalEditarIndicador').modal('hide');
                    window.location.href = "/indicadoresMedicion/listado"
                }, 1000);
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = dato.errores;
            }
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
    $scope.modalIdioma = function(indicador){
        $scope.idiomaIndicador = {};
        $scope.idiomaIndicadorForm.$setPristine();
        $scope.idiomaIndicadorForm.$setUntouched();
        $scope.idiomaIndicadorForm.$submitted = false;
        $scope.errores = null;
        $scope.idiomaIndicador.noIdiomas = [];
        $scope.idiomaIndicador.noIdiomas = indicador.noIdiomas;
        $scope.idiomaIndicador.id = indicador.id;
        $('#modalIdiomaIndicador').modal('show');
        
    }
    $scope.guardarIndicadorIdioma = function(){
        if (!$scope.idiomaIndicadorForm.$valid) {
            return;
        }
        $("body").attr("class", "charging");
        indicadorMedicionServi.guardarIndicador($scope.idiomaIndicador).then(function (dato) {
            $("body").attr("class", "cbp-spmenu-push");
            if (dato.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalIdiomaIndicador').modal('hide');
                    window.location.href = "/indicadoresMedicion/listado"
                }, 1000);
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = dato.errores;
            }
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
    
    $scope.crearIndicadorModal = function(indicador,idioma_id){
        $scope.crearIndicador = {};
        $scope.crearIndicadorForm.$setPristine();
        $scope.crearIndicadorForm.$setUntouched();
        $scope.crearIndicadorForm.$submitted = false;
        $scope.errores = null;
        $('#modalCrearIndicador').modal('show');
        
    }
    
    $scope.crearIndicadorMetodo = function(){
        if (!$scope.crearIndicadorForm.$valid || $scope.crearIndicador.idsGraficas.length == 0 ) {
            return;
        }
        $("body").attr("class", "charging");
        indicadorMedicionServi.crearIndicador($scope.crearIndicador).then(function (dato) {
            $("body").attr("class", "cbp-spmenu-push");
            if (dato.success) {
                swal({
                    title: "Realizado",
                    text: "Acción realizada satisfactoriamente.",
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                setTimeout(function () {
                    $('#modalCrearIndicador').modal('hide');
                    window.location.href = "/indicadoresMedicion/listado"
                }, 1000);
            } else {
                swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                $scope.errores = dato.errores;
            }
            
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
        });
    }
});