

( function(){
    
    angular.module('generadorCampos', [] )
    
        .directive('camposEncuesta',function(){
        'use strict';
        return{
            restrict: 'EAC',
            scope: {
                preguntas:'=',
            },
             transclude : false,
             replace: false,
             template:
                        '<div class="col-md-4" ng-repeat="pregunta in preguntas">'+
                            '<div class="form-group" ng-class="{ \'error\':(form.$submitted || form.item{{pregunta.id}}.$touched) && !form.item{{pregunta.id}}.$valid}">'+
                                '<label class="control-label" for="item{{pregunta.id}}">{{pregunta.idiomas[0].pregunta}}</label>'+
                                '<dynamic-element html="generarCamposDinamicos(pregunta)" ></dynamic-element>'+ 
                            '</div>'+ 
                        '</div>',
            link: function (scope, element, attrs,ngModel) {
               
                scope.generarCamposDinamicos = function(pregunta){
                   
                   var campo = '';
                   var validaciones = '<span ng-show="((form.$submitted || form.item{{pregunta.id}}.$touched) && form.item{{pregunta.id}}.$error.required)">Campo requerido</span>';
                   
                    switch (pregunta.tipo_campos_id) {
                        
                        case 1:
                                campo = '<input type="text" class="form-control" id="item{{pregunta.id}}" name="item{{pregunta.id}}" ng-model="pregunta.respuesta" maxlength="{{pregunta.max_length}}" ng-required="{{pregunta.es_requerido}}" />';
                                validaciones += '<span ng-show="((form.$submitted || form.item@{{pregunta.id}}.$touched) && form.item@{{pregunta.id}}.$error.maxlength)">Supera los '+pregunta.campo.max_length+' caracteres</span>';
                        break;
                        
                        case 2:
                                campo = '<input type="number" class="form-control" id="item{{pregunta.id}}" name="item{{pregunta.id}}" ng-model="pregunta.respuesta" min="@{{pregunta.valor_min}}" max="@{{pregunta.valor_max}}" ng-required="{{pregunta.es_requerido}}" />';
                                validaciones += '<span ng-show="((form.$submitted || form.item@{{pregunta.id}}.$touched) && form.item@{{pregunta.id}}.$error.min)">El número no debe ser menor a '+pregunta.valor_min+' </span>'+
                                                '<span ng-show="((form.$submitted || form.item@{{pregunta.id}}.$touched) && form.item@{{pregunta.id}}.$error.min)">El número no debe ser mayor a '+pregunta.valor_max+' </span>';
                        break;
                        
                        case 3:
                                campo = '<div class="radio" ng-repeat="op in pregunta.campo.opciones" >'+
                                           '<label> <input type="radio" name="item{{op.id}}" ng-model="pregunta.respuesta" ng-value="op.id" ng-required="!pregunta.respuesta"> @{{op.nombre}} </label>'+
                                        '</div>';
                                validaciones += '';
                        break;
                        
                        case 4:
                                campo = '<adm-dtp options="optionFecha" ng-model="pregunta.respuesta" ng-required="pregunta.es_requerido" ></adm-dtp>';
                                validaciones += '<span ng-show="(form.$submitted && pregunta.campo.id==4 && !pregunta.respuesta)">Campo requerido</span>';
                        break;
                        
                        case 5:
                                campo = '<ui-select name="item@{{pregunta.id}}" ng-model="pregunta.respuesta" ng-required="{{pregunta.es_requerido}}" >'+
                                            '<ui-select-match >@{{$select.selected.nombre}}</ui-select-match>'+
                                            '<ui-select-choices repeat="item as item in ( pregunta.campo.opciones | filter: $select.search)">'+
                                                '<small> {{item.nombre}} </small>'+
                                            '</ui-select-choices>'+
                                        '</ui-select>';
                                validaciones += '';
                        break;
                        
                        case 6:
                                campo = '<ui-select name="item{{pregunta.id}}" multiple ng-model="pregunta.respuesta" ng-required="{{pregunta.es_requerido}}">'+
                                                '<ui-select-match > {{$item.nombre}} </ui-select-match>'+
                                                '<ui-select-choices repeat="item in pregunta.campo.opciones | filter:$select.search">'+
                                                    '<small> {{item.nombre}} </small>'+
                                                '</ui-select-choices>'+
                                        '</ui-select>';
                                validaciones += '';
                        break;
                        
                        case 7:
                            
                                for(var i=0; i<pregunta.opciones.length; i++){
                                    
                                    campo += '<div class="checkbox">'+
                                                '<label><input type="checkbox" name="item{{pregunta.id}}" checklist-model="pregunta.respuesta" checklist-value="op.id" ng-required="{{pregunta.es_requerido}}" > {{op.idiomas[0].nombre}} </label>'+
                                             '</div>';
                                }
                                
                                validaciones += '<span ng-show="(form.$submitted && pregunta.campo.id==7 && (!pregunta.respuesta || !pregunta.respuesta.length==0))">Campo requerido</span>';
                        break;
                       
                       default: return null;
                    }
                    
                    return campo + validaciones;
                }
                
            },
        };
    })
    
    .directive('dynamicElement', ['$compile', function ($compile) {
      return { 
        restrict: 'E', 
        scope: {  html: "=" },
        replace: true,
        link: function(scope, element, attrs) {
            var template = $compile(scope.html)(scope);
            element.replaceWith(template);               
        },
      }
   }])
    
    
})();