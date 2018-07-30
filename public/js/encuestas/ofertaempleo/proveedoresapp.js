angular.module('proveedoresoferta', ["checklist-model","proveedorServices",'angularUtils.directives.dirPagination'])

.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            })

        }

    }

}])

.controller('listado', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
        
    proveedorServi.CargarListado().then(function(data){
                                $("body").attr("class", "cbp-spmenu-push charging");
                                $scope.proveedores = data.proveedores;
                                $("body").attr("class", "cbp-spmenu-push");
                            });   
   

   
}])

.controller('listadoecuesta', ['$scope', 'proveedorServi',function ($scope, proveedorServi) {
   
        
    $scope.$watch('id', function () {
        $("body").attr("class", "cbp-spmenu-push charging");
        
        proveedorServi.getEncuestas($scope.id).then(function (data) {
            $("body").attr("class", "cbp-spmenu-push");
            $scope.encuestas = data.encuestas;
            $scope.ruta = data.ruta;
        }).catch(function () {
            $("body").attr("class", "cbp-spmenu-push");
            swal("Error", "No se realizo la solicitud, reinicie la página");
        })
    })
   

   
}])