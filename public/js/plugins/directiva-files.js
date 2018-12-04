
(function(){
    
    angular.module( "InputFile", [] )

    .directive('fileInput',function(){
        "use strict";
        return{
            restrict: 'E',
            scope: {
                idInput:'@',
                label:'@',
                iconClass:'@',
                icon:'@',
                accept:'@',
                ngModel: '=?',
            },
            require: '?ngModel',
            template:
                    '<div class="row btn-archivos" id="{{idInput}}"  >'
                        +'<a href class="btn-file" ng-click="openBtnFile()"  style="background: #f5f5f5;width: 200px;text-align: center;padding: 20px 0px;border-radius: 5px;border: 1px solid rgba(0, 0, 0, 0.1);font-weight: bold;display: grid;text-decoration: none;margin: auto;" >' 
                            +'<i class="{{iconClass}}" style="font-size:3em" >{{icon}}</i> {{label}} '
                        +'</a>'
                        
                        +'<input ng-if="multiple"  type="file" accept="{{accept}}" id="files-brcc-{{idInput}}" style="display:none"  ng-model="f" ng-change="changeFile()" multiple >'
                        +'<input ng-if="!multiple" type="file" accept="{{accept}}" id="files-brcc-{{idInput}}" style="display:none"  ng-model="f" ng-change="changeFile()" >'
                        
                        +'<div class="cont-files" style="width: 100%;" >'
                            +'<div ng-repeat="item in filesView" style="background: rgba(0, 0, 0, 0.2);border-radius: 5px;padding: 5px;width: fit-content;display: grid;margin: 10px;float:left" >' 
                                   +'<img ng-if="item.img" style="height:200px;width:auto;" ng-src="{{item.ruta}}" height="200" >'
                                   +'<i ng-if="!item.img" class="{{iconClass}}" style="font-size:9em" >{{icon}}</i>'
                                   +'<span style="width: 100%;background: rgba(0, 0, 0, 0); text-align: center; cursor: pointer; color: blue; margin-top: 3px;" ng-click="eliminarFile($index)" >Eliminar</span>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
             ,
            link: function (scope, element, attrs, ngModel) {
                
                scope.filesView = [];
                scope.filesModel = [];
                scope.multiple = attrs.multiple==undefined ? false : true;
                
                element.bind('change', function (file) {
                    var input = document.getElementById('files-brcc-'+scope.idInput+'').files;
                    var variable = 0;
                    for (var i = 0; i < input.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            scope.$apply(function () {
                                var isImagen = e.target.result.includes("data:image");
                                if(!scope.multiple){ scope.filesView = [];  }
                                scope.filesView.push({ 'id': variable, 'ruta': e.target.result, img:isImagen });
                                variable++;
                            });
                        }
                        if(!scope.multiple){ scope.filesModel = [];  }
                        scope.filesModel.push(input[i]);
                        reader.readAsDataURL(input[i]);
                    }
                    document.getElementById('files-brcc-'+scope.idInput+'').value = "";
                    ngModel.$setViewValue( scope.filesModel );
                });
                
                scope.$watch('ngModel', function(newVal, oldVal) {
                    if(scope.ngModel){
                        if(scope.ngModel.length==0){
                            scope.filesView = [];
                            scope.filesModel = [];
                        }
                    }
                });
                
                scope.eliminarFile = function(pos){
                    scope.filesView.splice(pos,1);
                    scope.filesModel.splice(pos,1);
                    ngModel.$setViewValue( scope.filesModel);
                }
                
                scope.openBtnFile = function () {
                    document.getElementById('files-brcc-'+scope.idInput+'').click();
                }
               
            },
        };
    });    
    
})();