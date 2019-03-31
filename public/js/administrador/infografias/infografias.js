var pp=angular.module('admin.infografias', ['infografiasservice'])

.controller('Infografiactrl', ['$scope', 'adminService', '$timeout',function ($scope, adminService, $timeout) {

    $scope.exportaciones=[];
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
                   //d3.selectAll(".wrap").call($scope.wrap, 60);
                   $timeout(function(){
                       //d3.selectAll(".wrap").call($scope.wrap, 60);
                       console.log(d3.select('svg').select("#tipo-transporte-1-name").text().split(/\s+/).reverse());
                       d3.selectAll(".wrap").call($scope.wrap, 70);
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
        console.log(percentage);
        return (percentage * 70.8661)/100;
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
    

}])
