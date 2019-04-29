(function(){
     
    var coloresGraficas = ['#2196f3', '#f44336', '#ffeb3ba6', '#4caf50e6', '#45b7cd', '#ff6384', '#ff8e72', '#800080', '#FF00FF', '#000080', '#0000FF', '#008080', '#00FFFF', '#008000', '#00FF00', '#808000', '#FFFF00', '#800000', '#FF0000', '#000000', '#808080', '#C0C0C0']; 
    
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
                                                    if(!isNaN(tickValue)){ return ""; }
                                                    return tickValue.length<=20 ? tickValue : tickValue.substring(0, 17) +"..." ;
                                                }
                                        }
                              }], 
                              yAxes: [{ display: true, offset:true, scaleLabel: { display:true, fontSize:14, fontColor: "black", labelString:"" } }] 
                    },
                    title: {  display: true, text: '', fontSize:16  }
                };
                
           
    var app = angular.module("appIndicadores", [  "chart.js", "indicadoresServices", 'angular.filter' ] );
   
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
            $scope.indicador = null;
            
            indicadoresServi.getDataSecundarios(id, $scope.filtro.year)
                .then(function(data){
                    $scope.periodos = data.periodos;
                    $scope.indicador = data.indicador;
                    
                    $scope.yearSelect = data.periodos[0];
                    $scope.filtro.year = $scope.yearSelect.id;
                    
                    $scope.label_x = data.indicador.label_x;
                    $scope.label_y = data.indicador.label_y;
                    $scope.formato = ' ';
                    
                    $scope.inicializarDataGrafica(data.data);
                });
        }
        
        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
            
            var validar_tipo_grafica = (item.codigo=="pie" || item.codigo=="doughnut" || item.codigo=="polarArea" || item.codigo=="radar");
            
            $scope.options.scales.xAxes[0].display = !validar_tipo_grafica;
            $scope.options.scales.yAxes[0].display = !validar_tipo_grafica;
            $scope.options.legend.display = validar_tipo_grafica || ($scope.series.length > 1);
            $scope.override = [];
            
            if( validar_tipo_grafica && $scope.data.length>0 ){
                $scope.override.push({ backgroundColor: $scope.colores, borderColor: "white" });
            }
            else{
                $scope.override.push({ borderWidth: (item.id==2 ? 3: 1) });
                Chart.defaults.global.elements.line.fill = !(item.id==2);
            }
            
            if(item.codigo=="horizontalBar"){
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_y;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_x;
            }
            else{
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_x;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_y;
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
                            
                            var validar_tipo_grafica = ($scope.graficaSelect.codigo=="pie" || $scope.graficaSelect.codigo=="doughnut" || $scope.graficaSelect.codigo=="polarArea" || $scope.graficaSelect.codigo=="radar");
                            dataString = element.hidden ? "" : dataString +' '+ ( $scope.graficaSelect.codigo !='pie' ? ($scope.formato?$scope.formato:'') : '%' );
                            
							var padding = 5;
							var position = element.tooltipPosition();
							var y = position.y  +  ( !validar_tipo_grafica ?  12 : 0) - (fontSize / 2) - padding
							ctx.fillText(dataString, position.x , y );
						});
					}
				});
			}
		});
        
        
    }]);
   
    app.controller("IndicadoresCtrl", ["$scope","indicadoresServi", function($scope,indicadoresServi){
        
        $scope.options = optionsGraficas;
        $scope.colores = coloresGraficas;
        
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
            $scope.indicador = undefined;
            
            indicadoresServi.getDataIndicador(id)
                .then(function(data){
                    $scope.periodos = data.periodos;
                    $scope.indicador = data.indicador;
                    
                    if( data.periodos.length>0 ){
                        $scope.yearSelect = data.periodos[0];
                        $scope.mesSelect = data.periodos[0];
                        $scope.SelectTrimestre = data.periodos[0];
                        $scope.filtro.year = $scope.yearSelect.year;
                        $scope.filtro.id = $scope.yearSelect.id;
                        if($scope.yearSelect.mes){ $scope.filtro.mes = $scope.yearSelect.mes; }
                        if($scope.yearSelect.trimestre){ $scope.filtro.trimestre = $scope.yearSelect.trimestre; }
                    }
                    
                    $scope.label_x = data.indicador.idiomas[0].eje_x;
                    $scope.label_y = data.indicador.idiomas[0].eje_y;
                    $scope.formato = data.indicador.formato;
                    
                    $scope.inicializarDataGrafica(data.data);
                    $('#content-main .nav-tabs a:first').tab('show');
                });
                
            indicadoresServi.getDataPivoTable(id);
        }
        
        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
            
            var validar_tipo_grafica = (item.codigo=="pie" || item.codigo=="doughnut" || item.codigo=="polarArea" || item.codigo=="radar");
            
            $scope.options.scales.xAxes[0].display = !validar_tipo_grafica;
            $scope.options.scales.yAxes[0].display = !validar_tipo_grafica;
            $scope.options.legend.display = validar_tipo_grafica || $scope.series;
            $scope.override = [];
            
            if( validar_tipo_grafica && $scope.data.length>0 ){
                $scope.override.push({ backgroundColor: $scope.colores, borderColor: "white" });
            }
            else{
                $scope.override.push({ borderWidth: (item.id==2 ? 3: 1) });
                Chart.defaults.global.elements.line.fill = !(item.id==2);
            }
            
            if(item.codigo=="horizontalBar"){
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_y;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_x;
            }
            else{
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_x;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_y;
            }
            
        }   
        
        $scope.inicializarDataGrafica = function(data){
            $scope.labels = data.labels;
            $scope.data = data.series ? data.data : [data.data];
            $scope.series = data.series;
            $scope.dataExtra = data.dataExtra;
            
            if($scope.filtro.indicador==5){
                $scope.options.title.text = $scope.indicador.idiomas[0].nombre + " ("+ $("#SelectTipoGasto option:selected" ).text() +"/"+$scope.filtro.year+")";
            } 
            else if($scope.yearSelect.temporada){
                for(var i=0; i<$scope.periodos.length; i++){
                    if($scope.periodos[i].id==$scope.yearSelect.id){
                        $scope.options.title.text = $scope.indicador.idiomas[0].nombre + " ("+ $scope.periodos[i].temporada +"/"+$scope.filtro.year+")";
                        break;
                    }
                }
            }
            else if($scope.yearSelect.trimestre){
                for(var i=0; i<$scope.periodos.length; i++){
                    if($scope.periodos[i].id==$scope.yearSelect.id){
                        $scope.options.title.text = $scope.indicador.idiomas[0].nombre + " ("+ $scope.periodos[i].trimestre +"/"+$scope.filtro.year+")";
                        break;
                    }
                }
            }
            else{
                $scope.options.title.text = $scope.indicador.idiomas[0].nombre + " ("+ ( $scope.filtro.mes? $scope.filtro.mes+"/" : "") + $scope.filtro.year+")";
            }
            
            for(var i=0; i<$scope.indicador.graficas.length; i++){
                if($scope.indicador.graficas[i].pivot.es_principal){
                    $scope.changeTipoGrafica($scope.indicador.graficas[i]);
                    break;
                }
            }
            
        }
        
        $scope.changePeriodo = function(){
            $scope.mesSelect = $scope.yearSelect;
            $scope.filtro.year = $scope.yearSelect.year;
            $scope.filtro.id =   $scope.yearSelect.id;
            $scope.filtro.mes = $scope.mesSelect.mes;
            $scope.filtro.trimestre = $scope.mesSelect.trimestre;
            $scope.filtro.temporada = $scope.mesSelect.temporada;
            $scope.filtrarDatos();
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
                            
                            var validar_tipo_grafica = ($scope.graficaSelect.codigo=="pie" || $scope.graficaSelect.codigo=="doughnut" || $scope.graficaSelect.codigo=="polarArea" || $scope.graficaSelect.codigo=="radar");
                            dataString = element.hidden ? "" : dataString +' '+ ( $scope.graficaSelect.codigo !='pie' ? ($scope.formato?$scope.formato:'') : '%' );
                            
							var padding = 5;
							var position = element.tooltipPosition();
							var y = position.y  +  ( !validar_tipo_grafica ?  12 : 0) - (fontSize / 2) - padding
							ctx.fillText(dataString, position.x , y );
						});
					}
				});
			}
		});
        
    }]);
    
}());