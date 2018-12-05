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
                preview: '<',
                text: '<',
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
                    
                        +'<div class="cont-files">'
                            +'<div class="col-sm-4" ng-repeat="item in filesView" style="background-color: rgba(24, 20, 20, 0.9);border-radius: 5px;padding: 5px;width: auto;display: grid;margin: 10px;float:left" >' 
                                   +'<img ng-if="item.img" class="img-responsive" style="height:200px;width:auto;" ng-src="{{item.ruta}}">'
                                   +'<i ng-if="!item.img" class="{{iconClass}}" style="font-size:9em" >{{icon}}</i>'
                                   +'<div ng-if="item.img && item.text" style="width: 100%;background: transparent; text-align: center; cursor: pointer; margin-top: 3px;"><input id="text-brcc-{{idInput}}-{{item.id}}" class="form-control" value="{{text[item.id]}}" placeholder="Texto alternativo"></div>'
                                   +'<div style="width: 100%;background: transparent; text-align: center; cursor: pointer; margin-top: 3px;"><button ng-click="eliminarFile($index)" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
             ,
            link: function (scope, element, attrs, ngModel) {
                
                var variable = 0;
                scope.filesView = [];
                scope.textView = [];
                scope.filesModel = [];
                scope.multiple = attrs.multiple==undefined ? false : true;
                var text = attrs.text==undefined ? false : true;
                scope.$watch('preview', function(preview) {
                    if (preview != undefined){
                        if (preview.length != 0){
                            var reader = new FileReader();
                            reader.onload = function () {
                                if (reader.result.length >6){
                                    var isImagen = reader.result.includes("data:image");
                                    scope.filesView.push({ 'id': variable, 'ruta': reader.result, img:isImagen, text:text });
                                    variable++;
                                }
                            };
                            if(!scope.multiple){ scope.filesModel = [];  }
                            scope.filesModel.push(new File([preview[preview.length-1]], 'file'+getExtension(preview[preview.length-1].type), {type: preview[preview.length-1].type}));
                            reader.readAsDataURL(preview[preview.length-1]);
                            
                            document.getElementById('files-brcc-'+scope.idInput+'').value = "";
                            ngModel.$setViewValue( scope.filesModel );
                        }
                    }
                }, true);
                
                
                element.bind('change', function (file) {
                    
                    var input = document.getElementById('files-brcc-'+scope.idInput+'').files;
                    
                    if( scope.maxFiles ){
                        if( (input.length+scope.filesModel.length) > scope.maxFiles ){
                            document.getElementById('files-brcc-'+scope.idInput+'').value = "";
                            swal('Error al subir el archivo', 'Se superó el límite de archivos.', 'error'); return;
                        }
                    }
                    
                    for (var i = 0; i < input.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            scope.$apply(function () {
                                var isImagen = e.target.result.includes("data:image");
                                if(!scope.multiple){ scope.filesView = [];  }
                                scope.filesView.push({ 'id': variable, 'ruta': e.target.result, img:isImagen, text:text });
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
                };
                
                scope.openBtnFile = function () {
                    document.getElementById('files-brcc-'+scope.idInput+'').click();
                };
               
                function getExtension (contentType){
                    switch(contentType){
                        case 'audio/aac':
                            return '.acc';
                        case 'image/png':
                            return '.acc';
                        case 'application/x-abiword':
                            return '.abw';
                        case 'application/octet-stream':
                            return '.arc';
                        case 'video/x-msvideo':
                            return '.avi';
                        case 'application/vnd.amazon.ebook':
                            return '.azw';
                        case 'application/octet-stream':
                            return '.bin';
                        case 'application/x-bzip':
                            return '.bz';
                        case 'application/x-bzip2':
                            return '.bz2';
                        case 'application/x-csh':
                            return '.csh';
                        case 'text/css':
                            return '.css';
                        case 'text/csv':
                            return '.csv';
                        case 'application/msword':
                            return '.doc';
                        case 'application/epub+zip':
                            return '.epub';
                        case 'image/gif':
                            return '.gif';
                        case 'text/html':
                            return '.html';
                        case 'image/x-icon':
                            return '.ico';
                        case 'text/calendar':
                            return '.ics';
                        case 'application/java-archive':
                            return '.jar';
                        case 'image/jpeg':
                            return '.jpg';
                        case 'application/javascript':
                            return '.js';
                        case 'application/json':
                            return '.json';
                        case 'audio/midi':
                            return '.mid';
                        case 'video/mpeg':
                            return '.mpeg';
                        case 'application/vnd.apple.installer+xml':
                            return '.mpkg';
                        case 'application/vnd.oasis.opendocument.presentation':
                            return '.odp';
                        case 'application/vnd.oasis.opendocument.spreadsheet':
                            return '.ods';
                        case 'application/vnd.oasis.opendocument.text':
                            return '.odt';
                        case 'audio/ogg':
                            return '.oga';
                        case 'video/ogg':
                            return '.ogv';
                        case 'application/ogg':
                            return '.ogx';
                        case 'application/pdf':
                            return '.pdf';
                        case 'application/vnd.ms-powerpoint':
                            return '.ppt';
                        case 'application/x-rar-compressed':
                            return '.rar';
                        case 'application/rtf':
                            return '.rtf';
                        case 'application/x-sh':
                            return '.sh';
                        case 'image/svg+xml':
                            return '.svg';
                        case 'application/x-shockwave-flash':
                            return '.swf';
                        case 'application/x-tar':
                            return '.tar';
                        case 'image/tiff':
                            return '.tiff';
                        case 'font/ttf':
                            return '.ttf';
                        case 'application/vnd.visio':
                            return '.vsd';
                        case 'audio/x-wav':
                            return '.wav';
                        case 'audio/webm':
                            return '.weba';
                        case 'video/webm':
                            return '.webm';
                        case 'image/webp':
                            return '.webp';
                        case 'font/woff':
                            return '.woff';
                        case 'font/woff2':
                            return '.woff2';
                        case 'application/xhtml+xml':
                            return '.xhtml';
                        case 'application/vnd.ms-excel':
                            return '.xls';
                        case 'application/xml':
                            return '.xml';
                        case 'application/vnd.mozilla.xul+xml':
                            return '.xul';
                        case 'application/zip':
                            return '.zip';
                        case 'video/3gpp':
                            return '.3gp';
                        case 'audio/3gpp':
                            return '.3gp';
                        case 'video/3gpp2':
                            return '.3g2';
                        case 'audio/3gpp2':
                            return '.3g2';
                        case 'application/x-7z-compressed':
                            return '.7z';
                    }
                }
            },
        };
    });    
    
})();