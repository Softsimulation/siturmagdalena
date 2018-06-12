(function() {

    angular.module('generadorCampos', [])

        .directive('camposEncuesta', function($compile,$timeout) {
            'use strict';
            return {
                restrict: 'EAC',
                scope: { 
                         pregunta: '=',
                         form: '='
                       },
                transclude: false,
                replace: true,
                template: '',
                
                link: function(scope, element, attrs, ngModel) {

                    scope.$watch('pregunta', function(pregunta) {
                        if (pregunta) {

                            var templates = '<div class="panel panel-success">' +
                                               '<div class="panel-heading">' +
                                                  '<h3 class="panel-title">' +
                                                     '<b>' +
                                                          (pregunta.es_requerido ? '<span class="asterik glyphicon glyphicon-asterisk"></span>' : '') +
                                                           pregunta.idiomas[0].pregunta +
                                                     '</b>' + 
                                                  '</h3>' +
                                               '</div>' +
                                               '<div class="panel-body">' +
                                                   '<div class="row">' +
                                                       '<div class="col-md-12">' +
                                                             generarCamposDinamicos(pregunta) + 
                                                       '</div>' +
                                                   '</div>' +
                                               '</div>' +
                                            '</div>';
                            element.html(templates);
                            $compile(element.contents())(scope);
                            
                            $timeout(function () { $.material.init(); });
                            
                        }
                    });

                    var generarCamposDinamicos = function(pregunta) {                                   

                        var campo = '';
                        
                        switch (pregunta.tipo_campos_id) {

                            case 1: 
                                campo = '<input type="text" class="form-control" id="item{{pregunta.id}}" name="item{{pregunta.id}}" ng-model="pregunta.respuesta" maxlength="{{pregunta.max_length}}" ng-required="{{pregunta.es_requerido}}" />'; 
                                break;

                            case 2:
                                campo = '<input type="number" class="form-control" id="item{{pregunta.id}}" name="item{{pregunta.id}}" ng-model="pregunta.respuesta" min="{{pregunta.valor_min}}" max="{{pregunta.valor_max}}" ng-required="{{pregunta.es_requerido}}" />'; 
                                break;

                            case 3: 
                                   campo = '<div class="radio" ng-repeat="op in pregunta.opciones" >' +
                                                '<label> <input type="radio" name="item{{op.id}}" ng-model="pregunta.respuesta" ng-value="op.id" ng-required="!pregunta.respuesta"> {{op.idiomas[0].nombre}} </label>' +
                                           '</div>';  
                                break;

                            case 4: 
                                   campo = '<adm-dtp options="optionFecha" name="ite'+pregunta.id+'" ng-model="pregunta.respuesta" ng-required="pregunta.es_requerido" ></adm-dtp>';                            
                                break;

                            case 5:
                                   campo = '<ui-select name="item@{{pregunta.id}}" ng-model="pregunta.respuesta" ng-required="{{pregunta.es_requerido}}" >' +
                                                '<ui-select-match >{{$select.selected.idiomas[0].nombre}}</ui-select-match>' +
                                                '<ui-select-choices repeat="item.id as item in ( pregunta.opciones | filter:$select.search)">' +
                                                    '<small> {{item.idiomas[0].nombre}} </small>' +
                                                '</ui-select-choices>' +
                                            '</ui-select>';
                                break;

                            case 6:
                                    campo = '<ui-select name="item{{pregunta.id}}" multiple ng-model="pregunta.respuesta" ng-required="{{pregunta.es_requerido}}">' +
                                                '<ui-select-match > {{$item.idiomas[0].nombre}} </ui-select-match>' +
                                                '<ui-select-choices repeat="item.id as item in pregunta.opciones | filter:$select.search">' +
                                                    '<small> {{item.idiomas[0].nombre}} </small>' +
                                                '</ui-select-choices>' +
                                            '</ui-select>';
                                break;

                            case 7:
                                campo = '<div class="checkbox" ng-repeat="op in pregunta.opciones" >' +
                                            '<label><input type="checkbox" name="item{{pregunta.id}}@{{$index}}" checklist-model="pregunta.respuesta" checklist-value="op.id" > {{op.idiomas[0].nombre}} </label>' +
                                        '</div>';
                                break;
                            
                            case 8:
                                campo = '<table class="table table-striped">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<td></td>'+
                                                    '<td ng-repeat="item in pregunta.opciones_sub_preguntas" > {{item.idiomas[0].nombre}} </td>'+ 
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>'+
                                                '<tr ng-repeat="item in pregunta.sub_preguntas">'+
                                                    '<td> {{item.idiomas[0].nombre}} </td>'+
                                                    '<td ng-repeat="it in item.opciones" >'+
                                                        '<div class="radio">' +
                                                            '<label> <input type="radio" name="item{{item.id}}" ng-model="item.respuesta" ng-value="it.id"></label>' +
                                                        '</div>'+
                                                    '</td>'+
                                                '</tr>'+ 
                                            '</tbody>'+
                                        '</table>';
                                break;
                                
                            case 9:
                                campo = '<table class="table table-striped">'+
                                            '<thead>'+
                                                '<tr>'+
                                                    '<td></td>'+
                                                    '<td ng-repeat="item in pregunta.opciones_sub_preguntas" > {{item.idiomas[0].nombre}} </td>'+ 
                                                '</tr>'+
                                            '</thead>'+
                                            '<tbody>'+
                                                '<tr ng-repeat="item in pregunta.sub_preguntas">'+
                                                    '<td> {{item.idiomas[0].nombre}}</td>'+
                                                    '<td ng-repeat="it in item.opciones" >'+
                                                        '<div class="checkbox">' +
                                                            '<label> <input type="checkbox" name="item{{item.id}}" checklist-model="item.respuesta" checklist-value="it.id" ></label>' +
                                                        '</div>'+
                                                    '</td>'+
                                                '</tr>'+ 
                                            '</tbody>'+
                                        '</table>';
                                break;

                            default: return null;
                        }


                        var validaciones = '<span class="info-error" ng-show="(form.$submitted || form.item{{pregunta.id}}.$touched)" >' +
                                                '<span ng-show="form.item{{pregunta.id}}.$error.required">Campo requerido</span>' +
                                                '<span ng-show="form.item{{pregunta.id}}.$error.min">El valor minimo es {{pregunta.valor_min}}</span>' +
                                                '<span ng-show="form.item{{pregunta.id}}.$error.max">El valor maximo es {{pregunta.valor_max}}</span>' +
                                                '<span ng-show="form.item{{pregunta.id}}.$error.number">Formato de numero invalido</span>' +
                                                '<span ng-show="form.item{{pregunta.id}}.$error.maxlength">El numero maximo de caracteres es @{{pregunta.max_length}}</span>' +
                                                '<span ng-show="(pregunta.es_requerido && (pregunta.respuesta==null || pregunta.respuesta.length==0) && (pregunta.tipo_campos_id==3 || pregunta.tipo_campos_id==4 || pregunta.tipo_campos_id==5 || pregunta.tipo_campos_id==7))">Campo requerido</span>' +
                                            '</span>';

                        return campo + validaciones;
                    };
                    
                },

            };
        })

})();
