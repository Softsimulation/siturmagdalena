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
                    $scope.changeTipoGrafica2($scope.indicador.graficas[i]);
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

							ctx.font = Chart.helpers.fontString(12, 'normal', 'Helvetica Neue');

							// Just naively convert to string for now
							var dataString = dataset.data[index] +"";

							// Make sure alignment settings are correct
							ctx.textAlign = 'center';
							ctx.textBaseline = 'middle';
                            
                            dataString = element.hidden ? "" : dataString +' '+ ( $scope.graficaSelect.codigo !='pie' ? ($scope.formato?$scope.formato:'') : '%' );
                            
							var position = element.tooltipPosition();
							var y = position.y  +  ($scope.graficaSelect.codigo=="bar" || $scope.graficaSelect.codigo=="line" ? -5 : 0 );
            				var x = position.x + ($scope.graficaSelect.codigo=="horizontalBar" ? 18 : 0 );
							ctx.fillText(dataString, x , y );
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
            $scope.data2 =  null; 
            $scope.labels2 = null;
            $scope.series2 = null;
            $scope.data3 =  null; 
            $scope.labels3 = null;
            $scope.series3 = null;
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
                    
                    if(data.periodos){
                        if( data.periodos.length>0 ){
                            $scope.yearSelect = data.periodos[0];
                            $scope.mesSelect = data.periodos[0];
                            $scope.SelectTrimestre = data.periodos[0];
                            $scope.filtro.year = $scope.yearSelect.year;
                            $scope.filtro.id = $scope.yearSelect.id;
                            if($scope.yearSelect.mes){ $scope.filtro.mes = $scope.yearSelect.mes; }
                            if($scope.yearSelect.trimestre){ $scope.filtro.trimestre = $scope.yearSelect.trimestre; }
                        }
                    }
                    
                    $scope.label_x = data.indicador.idiomas[0].eje_x;
                    $scope.label_y = data.indicador.idiomas[0].eje_y;
                    $scope.formato = data.indicador.formato;
                    
                    
                    if(data.data2){
                        if(data.data2.data){
                            $scope.data2 =  [data.data2.data]; 
                            $scope.labels2 = data.data2.labels;
                            $scope.series2 = data.data2.series;
                        }
                    }
                    
                    if(data.data3){
                        if(data.data3.data){
                            $scope.data3 =  [data.data3.data]; 
                            $scope.labels3 = data.data3.labels;
                            $scope.series3 = data.data3.series;
                        }
                    }
                    
                    $scope.inicializarDataGrafica(data.data);
                    $('#content-main .nav-tabs a:first').tab('show');
                });
                
            indicadoresServi.getDataPivoTable(id);
        }
        
        $scope.inicializarDataGrafica = function(data){
            $scope.labels = data.labels;
            $scope.data = data.series ? data.data : [data.data];
            $scope.series = data.series;
            $scope.dataExtra = data.dataExtra;
            
            if($scope.filtro.indicador==5){
                $scope.options.title.text = $scope.indicador.idiomas[0].nombre + " ("+ $("#SelectTipoGasto option:selected" ).text() +"/"+$scope.filtro.year+")";
            }
            else if($scope.yearSelect){
            
                if($scope.yearSelect.temporada){
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
            
            }
            else{
                $scope.options.title.text = $scope.indicador.idiomas[0].nombre;
            }
            
            $scope.tituloIndicadorGrafica  = $scope.options.title.text;
            $scope.tituloIndicadorGrafica2 = $scope.indicador.idiomas[0].nombre;
            $scope.tituloIndicadorGrafica3 = $scope.indicador.idiomas[0].nombre;
            
            $scope.options2 = angular.copy($scope.options);
            $scope.options2.title.text = $scope.tituloIndicadorGrafica2;
            
            $scope.options3 = angular.copy($scope.options);
            $scope.options3.title.text = $scope.tituloIndicadorGrafica3;
            
            for(var i=0; i<$scope.indicador.graficas.length; i++){
                if($scope.indicador.graficas[i].pivot.es_principal){
                    $scope.changeTipoGrafica($scope.indicador.graficas[i]);
                    $scope.changeTipoGrafica2($scope.indicador.graficas[i]);
                    $scope.changeTipoGrafica3($scope.indicador.graficas[i]);
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
            }
            
            Chart.defaults.global.elements.line.fill = !(item.id==2);
            
            if(item.codigo=="horizontalBar"){
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_y;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_x;
            }
            else{
                $scope.options.scales.xAxes[0].scaleLabel.labelString = $scope.label_x;
                $scope.options.scales.yAxes[0].scaleLabel.labelString = $scope.label_y;
            }
            
        }   
        
        $scope.changeTipoGrafica2 = function(item){
            $scope.graficaSelect2 = item;
            
            var validar_tipo_grafica = (item.codigo=="pie" || item.codigo=="doughnut" || item.codigo=="polarArea" || item.codigo=="radar");
            
            $scope.options2.scales.xAxes[0].display = !validar_tipo_grafica;
            $scope.options2.scales.yAxes[0].display = !validar_tipo_grafica;
            $scope.options2.legend.display = validar_tipo_grafica || $scope.series2;
            $scope.override2 = [];
            
            if( validar_tipo_grafica ){
                $scope.override2.push({ backgroundColor: $scope.colores, borderColor: "white" });
            }
            else{
                $scope.override2.push({ borderWidth: (item.id==2 ? 3: 1) });
                Chart.defaults.global.elements.line.fill = !(item.id==2);
            }
            
            if(item.codigo=="horizontalBar"){
                $scope.options2.scales.xAxes[0].scaleLabel.labelString = $scope.label_y;
                $scope.options2.scales.yAxes[0].scaleLabel.labelString = $scope.label_x;
            }
            else{
                $scope.options2.scales.xAxes[0].scaleLabel.labelString = $scope.label_x;
                $scope.options2.scales.yAxes[0].scaleLabel.labelString = $scope.label_y;
            }
            
        } 
        
        $scope.changeTipoGrafica3 = function(item){
            $scope.graficaSelect3 = item;
            
            var validar_tipo_grafica = (item.codigo=="pie" || item.codigo=="doughnut" || item.codigo=="polarArea" || item.codigo=="radar");
            
            $scope.options3.scales.xAxes[0].display = !validar_tipo_grafica;
            $scope.options3.scales.yAxes[0].display = !validar_tipo_grafica;
            $scope.options3.legend.display = validar_tipo_grafica || $scope.series3;
            $scope.override3 = [];
            
            if( validar_tipo_grafica ){
                $scope.override3.push({ backgroundColor: $scope.colores, borderColor: "white" });
            }
            else{
                $scope.override3.push({ borderWidth: (item.id==2 ? 3: 1) });
                Chart.defaults.global.elements.line.fill = !(item.id==2);
            }
            
            if(item.codigo=="horizontalBar"){
                $scope.options3.scales.xAxes[0].scaleLabel.labelString = $scope.label_y;
                $scope.options3.scales.yAxes[0].scaleLabel.labelString = $scope.label_x;
            }
            else{
                $scope.options3.scales.xAxes[0].scaleLabel.labelString = $scope.label_x;
                $scope.options3.scales.yAxes[0].scaleLabel.labelString = $scope.label_y;
            }
            
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

							ctx.font = Chart.helpers.fontString(12, 'normal', 'Helvetica Neue');

							// Just naively convert to string for now
							var dataString = dataset.data[index] +"";

							// Make sure alignment settings are correct
							ctx.textAlign = 'center';
							ctx.textBaseline = 'middle';
                            
                            dataString = element.hidden ? "" : dataString +' '+ ( $scope.graficaSelect.codigo !='pie' ? ($scope.formato?$scope.formato:'') : '%' );
                            
							var position = element.tooltipPosition();
							var y = position.y  +  ($scope.graficaSelect.codigo=="bar" || $scope.graficaSelect.codigo=="line" ? -5 : 0 );
            				var x = position.x + ($scope.graficaSelect.codigo=="horizontalBar" ? 18 : 0 );
							ctx.fillText(dataString, x , y );
						});
					}
				});
			}
		});
        
    }]);
    
}());