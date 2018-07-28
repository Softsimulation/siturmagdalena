var situr = angular.module("destinosApp", ['InputFile' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'destinosServices', 'destinos.crear', 'destinos.index', 'destinos.idioma', 'destinos.editar']);

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
