
var app = angular.module("admin.factoresExpansion", ['factorExpansionService','angularUtils.directives.dirPagination','ui.select']);

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

app.controller('listadoFactoresOfertaCtrl', function($scope, factorExpansionServi) {
    
    $("body").attr("class", "charging");
    factorExpansionServi.listadoFactoresOferta().then(function (dato) {
        $scope.factores = dato.factores;
        for(var i=0;i<$scope.factores.length;i++){
            $scope.factores[i]["mes"] = $scope.factores[i].mes_anio.mes.nombre+" "+$scope.factores[i].mes_anio.anio.anio;
            $scope.factores[i]["tipoProveedor"] = $scope.factores[i].tipo_proveedor.tipo_proveedores_con_idiomas[0].nombre;
            $scope.factores[i]["mes_id"] = $scope.factores[i].mes_anio_id;
            $scope.factores[i]["municipio_id"] = $scope.factores[i].d_municipio_interno_id;
            $scope.factores[i]["tamanioEmpresa_id"] = $scope.factores[i].d_tamanio_empresa_id;
            $scope.factores[i]["tipoProveedor_id"] = $scope.factores[i].tipo_proveedor_id;
            $scope.factores[i].cantidad = parseFloat($scope.factores[i].cantidad);
            $scope.factores[i]["es_general"] = $scope.factores[i].proveedor_rnt_id == null ? 0 : 1;
            $scope.factores[i]["es_oferta"] = $scope.factores[i].es_oferta == false ? 0 : 1;
        }
        $scope.meses = dato.meses;
        $scope.proveedoresRnt = dato.proveedores;
        $scope.municipios = dato.municipios;
        $scope.tamaniosEmpresa = dato.tamaniosEmpresa;
        $scope.tiposProveedores = dato.tiposProveedores;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
    
    $scope.editarFactorModal = function(factor){
        $scope.editarFactor = angular.copy(factor);
        
        $scope.editarFactorForm.$setPristine();
        $scope.editarFactorForm.$setUntouched();
        $scope.editarFactorForm.$submitted = false;
        $scope.errores = null;
        $('#modalEditarFactor').modal('show');
        
        
        
        
    }
    $scope.editarFactorMetodo = function(){
        if (!$scope.editarFactorForm.$valid) {
            return;
        }
        $("body").attr("class", "charging");
        factorExpansionServi.editarFactor($scope.editarFactor).then(function (dato) {
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
                    window.location.href = "/factoresExpansion/listado"
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
    
    $scope.crearFactorModal = function(){
        $scope.crearFactor = {};
        $scope.crearFactorForm.$setPristine();
        $scope.crearFactorForm.$setUntouched();
        $scope.crearFactorForm.$submitted = false;
        $scope.errores = null;
        $('#modalCrearFactor').modal('show');
        
    }
    
    $scope.crearFactorMetodo = function(){
        if (!$scope.crearFactorForm.$valid) {
            return;
        }
        $("body").attr("class", "charging");
        factorExpansionServi.crearFactor($scope.crearFactor).then(function (dato) {
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
                    window.location.href = "/factoresExpansion/listado"
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