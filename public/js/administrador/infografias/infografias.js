var pp=angular.module('admin.infografias', ['infografiasservice'])

.controller('Infografiactrl', ['$scope', 'adminService', '$timeout',function ($scope, adminService, $timeout) {
    
    $scope.datoinfografia=null;
    $scope.exportaciones=[];
    $scope.enabledDownloadBtn = false;
     $("body").attr("class", "cbp-spmenu-push charging");
    adminService.getDatos()
        .then(function(data){
             $("body").attr("class", "cbp-spmenu-push");
            $scope.meses=data.meses;
            $scope.anios=data.anios;
            
        })
        .catch(function(){
             $("body").attr("class", "cbp-spmenu-push");
           swal("Error","No se pudo cargar la informacion, intentalo nuevamente","error"); 
        });
    
  
    
    $scope.getImg = function(url, id){
        return (id != null && id != undefined) ? url + id + ".png" : '';
    }
    
    $scope.generar=function(){
        
        if(!$scope.addForm.$valid){
            
            swal("Error","Hay errores en el formulario, selecciona los dos campos","error");
            return;
        }
        
        $scope.errores=null
        $("body").attr("class", "cbp-spmenu-push charging");
        adminService.Generar($scope.infografia)
            .then(function(data){
                $("body").attr("class", "cbp-spmenu-push");
                if(data.success){
                    
                   $scope.datoinfografia=data.datos;
                   
                   console.log($scope.getItemByName('sexo','Femenino'));
                   
                   //console.log($scope.getBase64Img("http://situr-magdalena-pitrineca.c9users.io/infografia/origen_internacional/9.png"));
                   //d3.selectAll(".wrap").call($scope.wrap, 60);
                   $timeout(function(){
                       //d3.selectAll(".wrap").call($scope.wrap, 60);
                       d3.selectAll(".wrap").call($scope.wrap, 70);
                       var images = document.querySelectorAll('image');
                       var countImg = 0;
                       
                       for(var i = 0; i < images.length; i++){
                           var newImg = new Image();
                           newImg.id = i;
                           newImg.src = images[i].getAttribute('xlink:href');
                           newImg.addEventListener( 'load', function(e){
                               //console.log(images[parseInt(e.target.id)]);
                               images[parseInt(e.target.id)].setAttribute('xlink:href', $scope.getDataUrl(e.target));
                               if(countImg == images.length){
                                $scope.enabledDownloadBtn = true;   
                               }
                               countImg++;
                               //console.log(newImg);
                           } );
                          
                       }
                       //$scope.wrap("#tipo-transporte-1-name", 70);
                   },1000);
                   
                }else{
                    $scope.errores=data.errores;
                    swal("Error","Corrija los errores","success");
                }
                
            })
            .catch(function(){
                 $("body").attr("class", "cbp-spmenu-push");
                swal("Error", "Error en la carga, por favor recarga la pagina", "error");
            })
        
    }
    
    $scope.getItemByName = function(indicator, name){
        
        var copyList = Object.assign([],$scope.datoinfografia);
        var indicatorArr = copyList[indicator];
        var result = null;
        if(indicatorArr != undefined){
            result = indicatorArr.filter(function(item) {
            	return item.nombre == name;
            });
        }
        return (result != null && result.length > 0) ? result.shift() : {nombre: name, numero: 0};
    }
    
    $scope.calcBar = function(percentage){
        return (percentage * 70.8661)/100;
    }
    
    $scope.download = function(){
        
        html2canvas(document.getElementById("svgInfografia"), {
				onrendered: function(canvas) {
					var dataURL = canvas.toDataURL();
        	    	console.log(dataURL);
				},
			});
        // html2canvas(document.getElementById("svgInfografia")).then(function(canvas) {
        //     //document.body.appendChild(canvas)
        //     console.log(canvas);
        // });
    }
    
    $scope.wrap = function(text, width) {
      text.each(function() {
        var text = d3.select(this),
            textTemp = text.text().indexOf("(") > -1 ? text.text().split('(')[0] : text.text(),
            words = textTemp.split(/\s+/).reverse(),
            word,
            line = [],
            lineNumber = 0,
            lineHeight = 1.1, // ems
            x = text.attr("x"),
            y = parseFloat(text.attr("y")),
            //dy = parseFloat(text.attr("dy")),
            dy = parseFloat(y),
            tspan = text.text(null).append("tspan").attr("x", x).attr("y", y);
            lineNumber+=10;
        while (word = words.pop()) {
          line.push(word);
          tspan.text(line.join(" "));
          if (tspan.node().getComputedTextLength() > width) {
            line.pop();
            tspan.text(line.join(" "));
            line = [word];
            tspan = text.append("tspan").attr("x", x).attr("y", y + lineNumber).text(word);
            lineNumber+=10;
            //tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
          }
        }
      });
    }
    
    $scope.getDataUrl = function (img) {
      var canvas = document.createElement('canvas')
      var ctx = canvas.getContext('2d')
    
      canvas.width = img.width
      canvas.height = img.height
      ctx.drawImage(img, 0, 0)
    
      // If the image is not png, the format
      // must be specified here
      return canvas.toDataURL()
    }
    $scope.getBase64Img = function(url){
        
        
        return $scope.loadImage(url).then((img) => {
          //console.log($scope.getDataUrl(img));
          return $scope.getDataUrl(img);
        })
        
        //return url;
        
        // var img = new Image();
        // img.src=url;
        // img.onload = function(){
        //     console.log("cargó");
        //     //console.log($scope.getDataUrl(img));
        //     return $scope.getDataUrl(img);
        // }
    }
    $scope.loadImage = function(src) {
        return new Promise((resolve, reject)=> {
          console.log(src);
      
          var img = new Image();
          img.onload = ()=> resolve(img);
          img.src = src;
        });
    }
    
    

}])
