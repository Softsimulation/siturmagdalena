(function(){

    angular.module("appIndicadoresSecundarios", [ "angular.filter", "EstadisticasSecuentariasServices" ] )

    
    .controller("EstadisticasSecundariasCtrl", ["$scope","estadisticasSecundariasServi", function($scope,estadisticasSecundariasServi){
        
        estadisticasSecundariasServi.getDataConfiguracion()
            .then(function(data){
                $scope.anios = data.anios;
                $scope.meses = data.meses;
                $scope.data = data.data;
                $scope.graficas = data.graficas;
            });
        
       
        $scope.guardarData = function () {

            if (!$scope.form.$valid) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            estadisticasSecundariasServi
                .guardarData($scope.indicador)
                .then(function (data) {
                       
                        if (data.success) {
                            $scope.data = data.data;
                            swal("¡Datos guardado!", "Los datos se han guardado exitosamente", "success");
                            $("#modalConfiData").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                       
                        $("body").attr("class", "cbp-spmenu-push");
                       
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
       
        $scope.OpenModal = function (isCrear, yearID, indicadorEditar, dataValoresTiempo, dataValoresRotulos) {
            
            $scope.indicador = angular.copy( indicadorEditar );
            $scope.indicador.es_crear = isCrear;
            $scope.indicador.yearID = !isCrear ? yearID : null; 
          
            if(isCrear && dataValoresTiempo && dataValoresRotulos){
                var index = null;
                $scope.aniosFiltrados = [];
                if(Object.keys(dataValoresTiempo).length>0){
                    
                    for(var i=0; i<$scope.anios.length; i++){
                        index = -1;
                        for(var x in dataValoresTiempo){
                            if(dataValoresTiempo[x][0].anio_id==$scope.anios[i].id){ index = i; break; }
                        }
                        if(index == -1){ $scope.aniosFiltrados.push($scope.anios[i]); }
                    }
                    
                }
                else if(Object.keys(dataValoresRotulos).length>0){ 
                    
                    for(var i=0; i<$scope.anios.length; i++){
                        index = -1;
                        for(var x in dataValoresRotulos){
                            if(dataValoresRotulos[x][0].anio_id==$scope.anios[i].id){ index = i; break; }
                        }
                        if(index == -1){ $scope.aniosFiltrados.push($scope.anios[i]); }
                    }
                    
                }
                else{
                    $scope.aniosFiltrados = $scope.anios;
                }
                
            }
            else{
                $scope.aniosFiltrados = $scope.anios;
            }
            
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            $scope.form.$submitted = false;
            $("#modalConfiData").modal("show");
        }
        
        $scope.OpenModalIndicador = function (indicador) {
            
            $scope.indicadorCrearEditar =  indicador ? angular.copy(indicador) :{ series:[], rotulos:[], graficas:[] };
            $scope.indicadorCrearEditar.es_crear =  indicador ? false : true;
            $scope.incluirRorulos =  $scope.indicadorCrearEditar.rotulos.length>0 ? 1: 0;
            $scope.formCrear.$setPristine();
            $scope.formCrear.$setUntouched();
            $scope.formCrear.$submitted = false;
            $("#modalIndicador").modal("show");
        }
       
        
        $scope.guardarIndicador = function () {

            if (!$scope.formCrear.$valid || $scope.indicadorCrearEditar.series.length==0 || $scope.indicadorCrearEditar.graficas.length==0 || ( $scope.incluirRorulos==1 && $scope.indicadorCrearEditar.rotulos.length==0) ) {
                swal("Error", "Verifique los errores en el formulario", "error");
                return;
            }
            
            $("body").attr("class", "cbp-spmenu-push charging");
            
            estadisticasSecundariasServi
                .guardarIndicador($scope.indicadorCrearEditar)
                .then(function (data) {
                       
                        if (data.success) {
                            $scope.data = data.data;
                            swal("¡Indicador guardado!", "El indicador se ha guardado exitosamnete", "success");
                            $("#modalIndicador").modal("hide");
                        }
                        else {
                            $scope.errores = data.errores;
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                       
                        $("body").attr("class", "cbp-spmenu-push");
                       
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                        $("body").attr("class", "cbp-spmenu-push"); 
                    });
            
        }
        
        
        $scope.filterData = function(array){
            var x = [];
            for(var i=0; i<array.length; i++){ x.push({ id:array[i].id,  nombre:array[i].nombre }); }
            return x;
        }
        
        $scope.initValorMeses = function(idMes, array){
            for(var i=0; i<array.length; i++){ 
                if(array[i].mes_indicador_id==idMes && array[i].anio_id==$scope.indicador.yearID){ 
                    return {  mes:idMes, anio: array[i].anio_id, valor:array[i].valor };
                }
            }
            return {  mes:idMes, anio:$scope.indicador.yearID };
        }
        
        $scope.initValorRotulos = function(idRotulo, array){
            for(var i=0; i<array.length; i++){ 
                if(array[i].rotulo_estadistica_id==idRotulo && array[i].anio_id==$scope.indicador.yearID){ 
                    return {  rotulo:idRotulo, anio: array[i].anio_id, valor:array[i].valor };
                }
            }
            return {  rotulo:idRotulo, anio:$scope.indicador.yearID };
        }
        
        
        $scope.changeSelectYear = function(){
            for(var i=0; i<$scope.indicador.series.length; i++){ 
                for(var j=0; j<$scope.indicador.series[i].valores.length; j++){ 
                   $scope.indicador.series[i].valores[j].anio = $scope.indicador.yearID;
                }
            }
        }
        
        $scope.agregarTipoGrafica = function(){
            
            var esPrincipal = false;
            
            for(var i=0; i<$scope.indicadorCrearEditar.graficas.length; i++){
                
                if($scope.indicadorCrearEditar.graficas[i].id==$scope.grafica.id){
                    sweetAlert("La gráfica ya existe", "El tipo de gráfica que intentas guardar ya existe.", "error");
                    return;
                }
                
                if( $scope.indicadorCrearEditar.graficas[i].pivot.principal && !esPrincipal ){ esPrincipal = true; }
            }
            
            if(esPrincipal && $scope.grafica.pivot.principal){
                sweetAlert("Gráfica principal ya existe", "Ya se encuentra un tipo de gráfica como principal.", "error");
                return;
            }
            
            $scope.indicadorCrearEditar.graficas.push( angular.copy($scope.grafica) );
            $scope.grafica = { pivot:{ principal:false } };
        }
        
        
        $scope.eliminarIndicador = function (indicador,index) {
            swal({
                title: "Eliminar indicador",
                text: "¿Esta seguro de eliminar el indicador: "+ indicador.nombre +"?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    estadisticasSecundariasServi
                    .eliminarIndicador( { id:indicador.id } )
                    .then(function (data) {
                        if (data.success) {
                            $scope.data.splice(index,1);
                            swal("¡Eliminado!", "El se ha eliminado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
        $scope.activarDesactivarIndicador = function (indicador) {
            swal({
                title: "Cambio de estado",
                text: "¿Está seguro de "+( !indicador.es_visible ? "activar":"desactivar" )+" la pregunta?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#processing').addClass('process-in');
                    estadisticasSecundariasServi
                    .cambiarEstadoIndicador( {id:indicador.id} )
                    .then(function (data) {
                        if (data.success) {
                            indicador.es_visible = data.estado;
                            swal("¡Modificado!", "El estado se ha modificado exitosamente", "success");
                        }
                        else {
                            sweetAlert("Oops...", "Ha ocurrido un error.", "error");
                        }
                    }).catch(function () {
                        swal("Error", "Error en la carga, por favor recarga la página", "error");
                    });
    
                }, 500);
            });
        }
        
     
    }])
    

    
}());