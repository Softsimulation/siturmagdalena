(function(){
    
    angular.module( "InputFile", [] )

    .directive('fileInput',function(){
        "use strict";
        return{
            restrict: 'E',
            scope: {
                idInput:'@',
                label:'@',
                maxFiles:'@',
                iconClass:'@',
                icon:'@',
                accept:'@',
                ngModel: '=?',
            },
            require: '?ngModel',
            template:
                    '<div class="row btn-archivos" id="{{idInput}}"  >'
                        +'<div class="col-sm-4">'
                            +'<a href class="btn-file" ng-click="openBtnFile()"  style="color:white;background-color: rgba(24, 20, 20, 0.7);width: 200px;text-align: center;padding: 20px 0px;border-radius: 5px;border: 1px solid rgba(0, 0, 0, 0.1);font-weight: bold;display: grid;text-decoration: none;margin: auto;" >' 
                                +'<i class="{{iconClass}}" style="font-size:3em;" >{{icon}}</i> {{label}} '
                            +'</a>'
                        +'</div>'
                        +'<input ng-if="multiple"  type="file" accept="{{accept}}" id="files-brcc-{{idInput}}" style="display:none"  ng-model="f" ng-change="changeFile()" multiple >'
                        +'<input ng-if="!multiple" type="file" accept="{{accept}}" id="files-brcc-{{idInput}}" style="display:none"  ng-model="f" ng-change="changeFile()" >'
                    
                        +'<div class="cont-files" >'
                            +'<div class="col-sm-4" ng-repeat="item in filesView" style="background-color: rgba(24, 20, 20, 0.9);border-radius: 5px;padding: 5px;width: auto;display: grid;margin: 10px;float:left" >' 
                                   +'<img ng-if="item.img" class="img-responsive" style="height:200px;width:auto;" ng-src="{{item.ruta}}">'
                                   +'<i ng-if="!item.img" class="{{iconClass}}" style="font-size:9em" >{{icon}}</i>'
                                   +'<div style="width: 100%;background: transparent; text-align: center; cursor: pointer; margin-top: 3px;"><button ng-click="eliminarFile($index)" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></div>'
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
                    
                    if( scope.maxFiles ){
                        if( (input.length+scope.filesModel.length) > scope.maxFiles ){
                            document.getElementById('files-brcc-'+scope.idInput+'').value = "";
                            swal('Error al subir el archivo', 'Se superó el límite de archivos.', 'error'); return;
                        }
                    }
                    
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