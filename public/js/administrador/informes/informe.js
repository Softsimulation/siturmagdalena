var situr = angular.module("atraccionesApp", ['InputFile','ADM-dateTimePicker','angularFileUpload' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'atracciones.index', 'atraccionesServices', 'atracciones.crear']);
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