(function(){
     
    var app = angular.module("appIndicadores", [  "chart.js", "indicadoresServices" ] );
   
    app.controller("receptorCtrl", ["$scope","indicadoresServi", function($scope,indicadoresServi){
        
        $scope.options = {
                            backgroundColor:'rgb(10,10,10)',
                            legend: { display: true, position: 'bottom', labels: { fontColor: 'black' }, },
                            scales: { 
                                      xAxes: [{ 
                                                display: true, 
                                                offset:true,
                                                scaleLabel: { display:true, fontSize:14, fontColor: "black", labelString:"" },
                                                ticks: {
                                                        callback: function(tickValue, index, ticks) {
                                                            return tickValue.length<=20 ? tickValue : tickValue.substring(0, 17) +"..." ;
                                                        }
                                                }
                                      }], 
                                      yAxes: [{ display: true, offset:true, scaleLabel: { display:true, fontSize:14, fontColor: "black", labelString:"" } }] 
                            },
                            title: {  display: true, text: '', fontSize:16  },
                            tooltips: {
                                enabled: true,
                                mode: 'label',
                                callbacks: {
                                    title: function(tooltipItems, data) {
                                        var idx = tooltipItems[0].index;
                                        return data.labels[idx];
                                    }
                                }
                            },
                            plugins: {
                                datalabels: {
                                    display: true,
                                    color: 'black',
                                    align: 'bottom',
                                    anchor: 'end',
                                    formatter: function(value,context) {
                                        return value +' '+ ($scope.graficaSelect.codigo !='pie' ? $scope.formato : '%' );
                                    }
                                }
                            }
                            
                            
                        };
        
        
        $scope.filtrarDatos = function(){
            
            if (!$scope.form.$valid) { return; }
            
            indicadoresServi.filtrarDataIndicador($scope.filtro)
                .then(function(data){
                    $scope.inicializarDataGrafica(data);
                });
        }

        $scope.changeIndicador = function(id){
            $scope.indicadorSelect = id;
            $scope.buscarData(id);
            $scope.yearSelect = null;
        }
        
        $scope.buscarData = function(id){
            
            $scope.filtro = { indicador:id, tipoGasto:'1' };
            $scope.labels = [];
            $scope.data = [];
            $scope.series = null;
            
            indicadoresServi.getDataIndicador(id)
                .then(function(data){
                    $scope.periodos = data.periodos;
                    $scope.indicador = data.indicador;
                    
                    $scope.yearSelect = data.periodos[0];
                    $scope.filtro.year = $scope.yearSelect.year;
                    $scope.filtro.mes = $scope.yearSelect.mes;
                    
                    $scope.inicializarDataGrafica(data.data);
                    
                    $scope.options.scales.xAxes[0].scaleLabel.labelString = data.indicador.idiomas[0].eje_x;
                    $scope.options.scales.yAxes[0].scaleLabel.labelString = data.indicador.idiomas[0].eje_y;
                    $scope.formato = '$';
                });
        }
        
        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
            $scope.options.scales.xAxes[0].display = !(item.codigo=="pie");
            $scope.options.scales.yAxes[0].display = !(item.codigo=="pie");
            $scope.options.legend.display = ($scope.series || item.codigo=="pie") ? true : false;
            
            $scope.override = item.codigo=="line" ? { borderWidth: 3, fill:false } : null;
            if( item.codigo=="line" && $scope.series ){
                $scope.override = [];
                for(var i=0;i<$scope.series.length>0;i++){
                    $scope.override.push({ borderWidth: 3, fill:false });
                }
            }
            
        }   
        
        $scope.inicializarDataGrafica = function(data){
            $scope.labels = data.labels;
            $scope.data = data.data;
            $scope.series = data.series;
            $scope.dataExtra = data.dataExtra;
            
            if($scope.filtro.indicador==5){
                $scope.tituloIndicadorGrafica = $scope.indicador.idiomas[0].nombre + " ("+ $("#SelectTipoGasto option:selected" ).text() +"/"+$scope.filtro.year+")";
            }   
            else{
                $scope.tituloIndicadorGrafica = $scope.indicador.idiomas[0].nombre + " ("+ ( $scope.filtro.mes? $scope.filtro.mes+"/" : "") + $scope.filtro.year+")";
            }
            $scope.options.title.text = $scope.tituloIndicadorGrafica;
            
            $scope.colores = [ ];
            for(var i=1; i<$scope.data.length; i++){ $scope.colores.push($scope.getColor()); }
            
            for(var i=0; i<$scope.indicador.graficas.length; i++){
                if($scope.indicador.graficas[i].pivot.es_principal){
                    $scope.changeTipoGrafica($scope.indicador.graficas[i]);
                    break;
                }
            }
        }
        
        $scope.getColor = function(){
        
            var r1 = Math.floor(Math.random()*256) ;
            var r2 = Math.floor(Math.random()*256) ;
            var r3 = Math.floor(Math.random()*256) ;
        
            return  {
                      backgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointBackgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointHoverBackgroundColor: "rgb("+r1+","+r2+","+r3+")",
                      borderColor: "rgb("+r1+","+r2+","+r3+")",
                      pointBorderColor: '#fff',
                      pointHoverBorderColor: "rgb("+r1+","+r2+","+r3+")"
                    };
        }
        
    }]);
    
    app.controller("secundariasCtrl", ["$scope","indicadoresServi", function($scope,indicadoresServi){
        
        $scope.options = {
                            backgroundColor:'rgb(10,10,10)',
                            legend: { display: true, position: 'bottom', labels: { fontColor: 'black' }, },
                            scales: { 
                                      xAxes: [{ 
                                                display: true, 
                                                offset:true,
                                                scaleLabel: { display:true, fontSize:14, fontColor: "black", labelString:"" },
                                                ticks: {
                                                        callback: function(tickValue, index, ticks) {
                                                            return tickValue.length<=20 ? tickValue : tickValue.substring(0, 17) +"..." ;
                                                        }
                                                }
                                      }], 
                                      yAxes: [{ display: true, offset:true, scaleLabel: { display:true, fontSize:14, fontColor: "black", labelString:"" } }] 
                            },
                            title: {  display: true, text: '', fontSize:16  },
                            tooltips: {
                                enabled: true,
                                mode: 'label',
                                callbacks: {
                                    title: function(tooltipItems, data) {
                                        var idx = tooltipItems[0].index;
                                        return data.labels[idx];
                                    }
                                }
                            },
                            plugins: {
                                datalabels: {
                                    display: true,
                                    color: 'black',
                                    align: 'bottom',
                                    anchor: 'end',
                                    formatter: function(value,context) {
                                        return value +' '+ ($scope.graficaSelect.codigo !='pie' ? $scope.formato : '%' );
                                    }
                                }
                            }
                            
                            
                        };
        
        
        $scope.filtrarDatos = function(){
            
            if (!$scope.form.$valid) { return; }
            
            indicadoresServi.filtrarDataSecundarias($scope.filtro)
                .then(function(data){
                    $scope.inicializarDataGrafica(data);
                });
        }

        $scope.changeIndicador = function(id){
            $scope.indicadorSelect = id;
            $scope.buscarData(id);
            $scope.yearSelect = null;
        }
        
        $scope.buscarData = function(id){
            
            $scope.filtro = { indicador:id  };
            $scope.labels = [];
            $scope.data = [];
            $scope.series = null;
            
            indicadoresServi.getDataSecundarios(id, $scope.filtro.year)
                .then(function(data){
                    $scope.periodos = data.periodos;
                    $scope.indicador = data.indicador;
                    
                    $scope.yearSelect = data.periodos[0];
                    $scope.filtro.year = $scope.yearSelect.year;
                    $scope.filtro.mes = $scope.yearSelect.mes;
                    
                    $scope.inicializarDataGrafica(data.indicador);
                    
                    //$scope.options.scales.xAxes[0].scaleLabel.labelString = data.indicador.idiomas[0].eje_x;
                    //$scope.options.scales.yAxes[0].scaleLabel.labelString = data.indicador.idiomas[0].eje_y;
                    //$scope.formato = '$';
                });
        }
        
        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
            $scope.options.scales.xAxes[0].display = !(item.codigo=="pie");
            $scope.options.scales.yAxes[0].display = !(item.codigo=="pie");
            $scope.options.legend.display = ($scope.series || item.codigo=="pie") ? true : false;
            
            $scope.override = item.codigo=="line" ? { borderWidth: 3, fill:false } : null;
            if( item.codigo=="line" && $scope.series ){
                $scope.override = [];
                for(var i=0;i<$scope.series.length>0;i++){
                    $scope.override.push({ borderWidth: 3, fill:false });
                }
            }
            
        }   
        
        $scope.inicializarDataGrafica = function(data){
            $scope.labels = data.labels;
            $scope.data = data.data;
            $scope.series = data.series;
            $scope.dataExtra = data.dataExtra;
            
            $scope.tituloIndicadorGrafica =   $("#SelectTipoGasto option:selected" ).text() +"/"+$scope.filtro.year+")";
          
            $scope.options.title.text = $scope.tituloIndicadorGrafica;
            
            $scope.colores = [];
            for(var i=1; i<$scope.data.length; i++){ $scope.colores.push($scope.getColor()); }
            /*
            for(var i=0; i<$scope.indicador.graficas.length; i++){
                if($scope.indicador.graficas[i].pivot.es_principal){
                    $scope.changeTipoGrafica($scope.indicador.graficas[i]);
                    break;
                }
            }
            */
        }
        
        $scope.getColor = function(){
        
            var r1 = Math.floor(Math.random()*256) ;
            var r2 = Math.floor(Math.random()*256) ;
            var r3 = Math.floor(Math.random()*256) ;
        
            return  {
                      backgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointBackgroundColor: "rgba("+r1+","+r2+","+r3+", 0.5)",
                      pointHoverBackgroundColor: "rgb("+r1+","+r2+","+r3+")",
                      borderColor: "rgb("+r1+","+r2+","+r3+")",
                      pointBorderColor: '#fff',
                      pointHoverBorderColor: "rgb("+r1+","+r2+","+r3+")"
                    };
        }
        
    }]);
    

    
}());