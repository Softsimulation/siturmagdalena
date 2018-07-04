(function(){

    angular.module("appIndicadores", [  "chart.js", "indicadoresServices" ] )
    
    .config(["ChartJsProvider", function(ChartJsProvider) {
         ChartJsProvider.setOptions({ colors : [ '#803690', '#00ADF9', '#DCDCDC', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360'] });
    }])
    
    .controller("receptorCtrl", ["$scope","indicadoresServi", function($scope,indicadoresServi){
        
        $scope.filtro = {};
        
        $scope.options = {
                        legend: { display: true, position: 'bottom', labels: { fontColor: 'rgb(255, 99, 132)' }, },
                        scales: { xAxes: [{ display: true, stacked: true  }], yAxes: [{ display: true, stacked: true }] },
                        title: {  display: true, text: '', fontSize:16  }
                    };
       
      
        indicadoresServi.getDataReceptor()
            .then(function(data){
                $scope.periodos = data.periodos;
                $scope.graficas = data.graficas;
                $scope.filtro.year = data.periodos[0];
            });
      
        $scope.labels = ['2006', '2007', '2008', '2009', '2010', '2011', '2012'];
        $scope.series = ['Series A', 'Series B'];
        
        $scope.data = [
            [65, 59, 80, 81, 56, 55, 40],
            [28, 48, 40, 19, 86, 27, 90]
        ];
        

        $scope.changeTipoGrafica = function(item){
            $scope.graficaSelect = item;
        }   
        
        $scope.descargarGrafica = function(){
             var link = document.createElement("a");
              link.download = "Grafica_turismo_receptor";
              link.href = document.getElementById('base').toDataURL(); //'image/jpeg', 1.0
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);
        }    
        
    }])
    

    
}());