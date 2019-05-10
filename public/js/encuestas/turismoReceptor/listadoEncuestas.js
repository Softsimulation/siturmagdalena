var app = angular.module('encuestaListado', ['recpetorService','angularUtils.directives.dirPagination','ADM-dateTimePicker'])


app.controller('listadoEncuestas2Ctrl', ['$scope','receptorServi', function ($scope,receptorServi) {
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY-MM-DD',
        zIndex: 1060,
        autoClose: true,
        default: null,
        gregorianDic: {
            title: 'Fecha',
            monthsNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            daysNames: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            todayBtn: "Hoy"
        }
    };
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('/');
    }
    
    $scope.prop = {
        search:''
    }
    $("body").attr("class", "charging");
    receptorServi.getEncuestas().then(function (data) {
        $scope.encuestas = data;
        
        for (var i = 0; i < $scope.encuestas.length; i++) {
            $scope.encuestas[i].fechaaplicacion = formatDate($scope.encuestas[i].fechaaplicacion);
            $scope.encuestas[i].fechallegada = formatDate($scope.encuestas[i].fechallegada);
              if ($scope.encuestas[i].estadoid > 0 && $scope.encuestas[i].estadoid < 7) {
                  $scope.encuestas[i].Filtro = 'sincalcular';
              } else {
                  $scope.encuestas[i].Filtro = 'calculadas';
              }
          }
        $("body").attr("class", "cbp-spmenu-push");
        
    }).catch(function () {
        $('#processing').removeClass('process-in');
        swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.buscarEncuestasPorRango = function(){
        if($scope.fecha_inicial == undefined || $scope.fecha_final == undefined){
            swal("Error", "Debe seleccionar el rango de fechas.", "info");
            return;
        }
        if($scope.fecha_inicial.length > 0 && $scope.fecha_final.length > 0){
            $("body").attr("class", "charging");
            receptorServi.encuestasPorRango($scope.fecha_inicial, $scope.fecha_final).then(function (data) {
                $scope.encuestas = data.encuestas;
                
                for (var i = 0; i < $scope.encuestas.length; i++) {
                    $scope.encuestas[i].fechaaplicacion = formatDate($scope.encuestas[i].fechaaplicacion);
                    $scope.encuestas[i].fechallegada = formatDate($scope.encuestas[i].fechallegada);
                      if ($scope.encuestas[i].estadoid > 0 && $scope.encuestas[i].estadoid < 7) {
                          $scope.encuestas[i].Filtro = 'sincalcular';
                      } else {
                          $scope.encuestas[i].Filtro = 'calculadas';
                      }
                  }
                $("body").attr("class", "cbp-spmenu-push");
                
            }).catch(function () {
                $('#processing').removeClass('process-in');
                swal("Error", "Error en la carga, por favor recarga la página.", "error");
            })
        }else{
            swal("Error", "Debe seleccionar el rango de fechas.", "info");
        }
    }
    
    $scope.refrescar = function(){
        $("body").attr("class", "charging");
        receptorServi.getEncuestas().then(function (data) {
            $scope.encuestas = data;
            
            for (var i = 0; i < $scope.encuestas.length; i++) {
                $scope.encuestas[i].fechaaplicacion = formatDate($scope.encuestas[i].fechaaplicacion);
                $scope.encuestas[i].fechallegada = formatDate($scope.encuestas[i].fechallegada);
                  if ($scope.encuestas[i].estadoid > 0 && $scope.encuestas[i].estadoid < 7) {
                      $scope.encuestas[i].Filtro = 'sincalcular';
                  } else {
                      $scope.encuestas[i].Filtro = 'calculadas';
                  }
              }
            $("body").attr("class", "cbp-spmenu-push");
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    }
    
    $scope.filtrarEncuesta = function (item) {
        return ($scope.filtroEstadoEncuesta != "" && item.Filtro == $scope.filtroEstadoEncuesta) || $scope.filtroEstadoEncuesta == "";
    };
    $scope.campoSelected = "";
    $scope.filtrarCampo = function (item) {
        return ($scope.campoSelected != "" && item[$scope.campoSelected].indexOf($scope.prop.search) > -1) || $scope.campoSelected == "";
    };
    
    $scope.eliminarEncuesta = function(encuesta){
        const data = {'encuesta_id': encuesta.id};
        const indexEncuesta = $scope.encuestas.indexOf(encuesta);
        
        
        swal({
            title: "Eliminar encuesta",
            text: "¿Está seguro? Una vez eliminada la encuesta no podra volver a visualizarla.",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function () {
            setTimeout(function () {
                $("body").attr("class", "charging");
                receptorServi.postEliminarencuesta(data).then(function(data){
                    if(data.success){
                        $scope.encuestas.splice(indexEncuesta,1);
                        swal({
                            title: "Encuesta eliminada",
                            text: "Se ha eliminado la encuesta.",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                        $scope.errores = null;
                    }else{
                        swal("Error", "Verifique la información y vuelva a intentarlo.", "error");
                        $scope.errores = data.errores; 
                    }
                     $("body").attr("class", "cbp-spmenu-push");
                }).catch(function(){
                    $("body").attr("class", "cbp-spmenu-push");
                    swal("Error","Error en la petición, recargue la pagina","error");
                })
            }, 2000);
        });
        
    }
    
    
    $scope.historialEncuesta = function(encuesta){

        $("body").attr("class", "charging");
        receptorServi.getHistorialencuesta(encuesta.id).then(function (data) {
       
            $scope.historial_encuestas = data;
            
            $("body").attr("class", "cbp-spmenu-push");
             $('#modalHistorial').modal('show');
            
        }).catch(function () {
            $('#processing').removeClass('process-in');
            swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
              
    }
    
    
    
    
}])
