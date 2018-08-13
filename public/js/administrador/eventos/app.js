var situr = angular.module("eventosApp", ['ADM-dateTimePicker',  'InputFile' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'eventosServices', 'eventos.crear', 'eventos.index', 'eventos.idioma', 'eventos.editar']);

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