(function(){
     
    var coloresGraficas = [ '#2196f3', '#f44336', '#ffeb3ba6', '#4caf50e6', '#45b7cd', '#ff6384', '#ff8e72']; 
    
    var optionsGraficas = {
                    backgroundColor:'rgb(10,10,10)',
                    legend: { display: true, position: 'bottom', labels: { fontColor: 'black' }, usePointStyle:true },
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
                    title: {  display: true, text: '', fontSize:16  }
                };
                
           
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
                    $scope.formato = ' ';
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
        
        $scope.options = optionsGraficas;
        $scope.colores = coloresGraficas;
        
        
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
                    $scope.filtro.year = $scope.yearSelect.id;
                    
                    $scope.inicializarDataGrafica(data.data);
                    
                    $scope.options.scales.xAxes[0].scaleLabel.labelString = data.indicador.label_x;
                    $scope.options.scales.yAxes[0].scaleLabel.labelString = data.indicador.label_y;
                    $scope.formato = ' ';
                });
        }
        
        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
            $scope.options.scales.xAxes[0].display = !(item.codigo=="pie");
            $scope.options.scales.yAxes[0].display = !(item.codigo=="pie");
            $scope.options.legend.display = ($scope.series.length>1 || item.codigo=="pie") ? true : false;
            $scope.override = [];
            
            if(item.codigo=="pie"){
                $scope.override.push({ backgroundColor: [], borderColor: "white" });
                for(var i=0;i<$scope.data[0].length>0;i++){
                   $scope.override[0].backgroundColor.push( $scope.getColor() );
                }
            }else{
                for(var i=0;i<$scope.series.length>0;i++){
                    $scope.override.push({ borderWidth: ( item.codigo!="line" ? 2 : 3) , fill:false, pointBorderColor: $scope.colores[i]  });
                }
            }
            
        }   
        
        $scope.inicializarDataGrafica = function(data){
            $scope.labels = data.labels;
            $scope.data = data.data;
            $scope.series = data.series;
            $scope.dataExtra = data.dataExtra;
            
            $scope.tituloIndicadorGrafica =   $scope.indicador.nombre +" / "+  $scope.getYear($scope.filtro.year) +"";
            $scope.options.title.text = $scope.tituloIndicadorGrafica;
            
            for(var i=0; i<$scope.indicador.graficas.length; i++){
                if($scope.indicador.graficas[i].pivot.principal){
                    $scope.changeTipoGrafica($scope.indicador.graficas[i]);
                    break;
                }
            }
            
        }
        
        
        $scope.getYear = function(id){
            for(var i=0; i<$scope.periodos.length; i++){
                if($scope.periodos[i].id==id){ return $scope.periodos[i].anio; }
            }
            return null;
        }
        
        $scope.getColor = function(){
        
            var r1 = Math.floor(Math.random()*256) ;
            var r2 = Math.floor(Math.random()*256) ;
            var r3 = Math.floor(Math.random()*256) ;
        
            return  "rgba("+r1+","+r2+","+r3+", 0.5)";
        }
        
        Chart.plugins.register({
			afterDatasetsDraw: function(chart) {
				var ctx = chart.ctx;

				chart.data.datasets.forEach(function(dataset, i) {
					var meta = chart.getDatasetMeta(i);
					if (!meta.hidden) {
						meta.data.forEach(function(element, index) {
							// Draw the text in black, with the specified font
							ctx.fillStyle = 'rgb(0, 0, 0)';

							var fontSize = 12;
							var fontStyle = 'normal';
							var fontFamily = 'Helvetica Neue';
							ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

							// Just naively convert to string for now
							var dataString = dataset.data[index].toString();

							// Make sure alignment settings are correct
							ctx.textAlign = 'center';
							ctx.textBaseline = 'middle';
                            
                            
                            dataString = element.hidden ? "" : dataString +' '+ ( $scope.graficaSelect.codigo !='pie' ? ($scope.formato?$scope.formato:'') : '%' );
                            
                            
                            
							var padding = 5;
							var position = element.tooltipPosition();
							var y = position.y  +  ($scope.graficaSelect.codigo !='pie' ?  25 : 0) - (fontSize / 2) - padding
							ctx.fillText(dataString, position.x , y );
						});
					}
				});
			}
		});
        
        
    }]);
    

    
}());