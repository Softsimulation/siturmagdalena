
var app = angular.module('encuestaSostenibilidadPst', ['ADM-dateTimePicker','ui.select','checklist-model','angularUtils.directives.dirPagination','sostenibilidadPstService','sostenibilidadPst.configuracion','sostenibilidadPst.socioCultural','sostenibilidadPst.ambiental','sostenibilidadPst.economico'])


app.filter('range', function() {
  return function(input, total) {
    total = parseInt(total);

    for (var i=1; i<=total; i++) {
      input.push(i);
    }

    return input;
  };
});