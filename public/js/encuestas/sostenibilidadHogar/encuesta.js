var app = angular.module('sostenibilidadHogar', ['ADM-dateTimePicker','ui.select','checklist-model','angularUtils.directives.dirPagination','ambiental','sostenibilidadHogarServices','social','crear','sostenibilidadHogar.economico'])

app.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);

    for (var i=1; i<=total; i++) {
      input.push(i);
    }

    return input;
  };
});