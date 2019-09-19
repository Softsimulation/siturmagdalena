var situr = angular.module("actividadesApp", ['InputFile', 'ng.ckeditor' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'actividadesServices', 'actividades.crear', 'actividades.index', 'actividades.idioma', 'actividades.editar']);

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
    console.log(condition);
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