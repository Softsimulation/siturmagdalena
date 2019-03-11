
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
    $scope.sliders = [];
    $("body").attr("class", "charging");
    indicadorMedicionServi.listadoIndicadores().then(function (dato) {
        $scope.indicadores = dato.indicadores;
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $("body").attr("class", "cbp-spmenu-push");
        swal("Error", "Hubo un error en la petición intentalo nuevamente", "error");
    });
});