var situr = angular.module("proveedoresApp", ['InputFile' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'proveedoresServices', 'proveedores.crear', 'proveedores.index', 'proveedores.editar', 'proveedores.idioma']);

situr.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            });
        }
    }
}]);

situr.directive('finalizacion', function () {
    return function (scope, element, attrs) {
        if (scope.$last) {
            $(".select2 ").select2({

            });
        }
    };
});

situr.filter('idiomaFilter', function() {
    return function( items, condition) {
    var filtered = [];
    
    if(condition === undefined || condition.length == 0){
      return items;
    }
    angular.forEach(items, function(item) {
        angular.forEach(condition, function(traduccion){
            if(traduccion.idioma.id != item.id){
                filtered.push(item);
            }
        });
    });
    
    return filtered;
    };
});