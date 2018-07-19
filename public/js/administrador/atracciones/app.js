var situr = angular.module("atraccionesApp", ['InputFile' ,'checklist-model', 'angularUtils.directives.dirPagination', 'ui.select', 'atracciones.index', 'atraccionesServices', 'atracciones.index', 'atracciones.crear', 'atracciones.editar', 'atracciones.idioma']);

situr.directive('finalizacion', function () {
    return function (scope, element, attrs) {
        if (scope.$last) {
            $(".select2 ").select2({

            });
        }
    };
});
