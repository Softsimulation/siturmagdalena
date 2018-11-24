angular.module('visitanteApp', ["visitanteService","ADM-dateTimePicker","ui.select",'angularUtils.directives.dirPagination','ngDraggable'])

.directive('fileInput', ['$parse', function ($parse) {

    return {
        restrict: 'A',
        link: function (scope, elm, attrs) {
            elm.bind('change', function () {
                $parse(attrs.fileInput).assign(scope, elm[0].files);
                scope.$apply();
            })

        }

    }

}])

.controller('misFavoritosCtrl', ['$scope', 'visitanteServi',function ($scope, visitanteServi) {
   
    $scope.planificadores = [];
    $scope.listaPlanificadores = [];
    $scope.favoritos = [];
    $scope.intrucciones = { ver: true };
    var hoy = new Date();
    var dia = hoy.getDate() > 10 ? hoy.getDate() : '0' + hoy.getDate();
    var mes = (hoy.getMonth() + 1) > 10 ? hoy.getMonth() + 1 : '0' + (hoy.getMonth() + 1);
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'DD-MM-YYYY',
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

        return [day,month,year].join('/');
    }
   
    $("body").attr("class", "charging");
    visitanteServi.CargarFavoritos().then(function(data) {
       $scope.favoritos = data.favoritos;
       $scope.listaPlanificadores = data.listaPlanificadores;
       $("body").attr("class", "cbp-spmenu-push");
    }).catch(function() {
       $("body").attr("class", "cbp-spmenu-push");
       swal("Error", "Error en la carga, por favor recarga la página.", "error");
    })
    
    $scope.abrirAgregarPlanificador = function(){
        $scope.nuevoPlanificador = {
            Id: $scope.planificadores.length + 1,
            Dias: []
        };
        $scope.crearForm.$setPristine();
        $scope.crearForm.$setUntouched();
        $scope.crearForm.$submitted = false;
        $('#modalCrearPlanificador').modal('show');
    }
    
    $scope.abrirEditarPlanificador = function(){
        $scope.nuevoPlanificador = angular.copy($scope.planificadores[0]);
        $scope.editarForm.$setPristine();
        $scope.editarForm.$setUntouched();
        $scope.editarForm.$submitted = false;
        $('#modalEditarPlanificador').modal('show');
    }
    
    $scope.crearPlanificador = function(){
        if(!$scope.crearForm.$valid){
            swal("Error", "Verifique el formulario.", "error");
            return;
        }
        
        var dateOutRange = false;
        for (var i = 0; i < $scope.listaPlanificadores.length; i++) {
            if (!validarFechas( stringToDate($scope.nuevoPlanificador.Fecha_inicio) , stringToDate($scope.nuevoPlanificador.Fecha_fin) , Date.parse(($scope.listaPlanificadores[i].Fecha_inicio)) , Date.parse($scope.listaPlanificadores[i].Fecha_fin) ) ) {
                dateOutRange = true;
                break;
            }
        }
        
        if(dateOutRange){
            swal("Error", "Verifique que las fechas del planificador no coincidan con las de otro planificador.", "error");
            return;
        }
        
        $scope.planificadores.push($scope.nuevoPlanificador);
        $('#modalCrearPlanificador').modal('hide');
        
    }
    
    $scope.editarPlanificador = function(){
        if(!$scope.editarForm.$valid){
            swal("Error", "Verifique el formulario.", "error");
            return;
        }
        
        var dateOutRange = false;
        for (var i = 0; i < $scope.listaPlanificadores.length; i++) {
            if (! validarFechas( stringToDate($scope.nuevoPlanificador.Fecha_inicio) , stringToDate($scope.nuevoPlanificador.Fecha_fin) , Date.parse(($scope.listaPlanificadores[i].Fecha_inicio)) , Date.parse($scope.listaPlanificadores[i].Fecha_fin) ) ) {
                dateOutRange = true;
                break;
            }
        }
        
        if(dateOutRange){
            swal("Error", "Verifique que las fechas del planificador no coincidan con las de otro planificador.", "error");
            return;
        }
        
        $scope.planificadores[0].Nombre = $scope.nuevoPlanificador.Nombre;
        $scope.planificadores[0].Fecha_inicio = $scope.nuevoPlanificador.Fecha_inicio;
        $scope.planificadores[0].Fecha_fin = $scope.nuevoPlanificador.Fecha_fin;
        $('#modalEditarPlanificador').modal('hide');
    }
    
    $scope.guardar = function(){
        
        if($scope.planificadores[0].Dias.length == 0){
            swal("Error", "Para guardar un planificador debe verificar que este tenga por lo menos un día.", "error");
            return;
        }
        
        $("body").attr("class", "charging");
        visitanteServi.GuardarPlanificador($scope.planificadores[0]).then(function(data) {
            if(data.success) {
                swal("Realizado", "Se ha guardado satisfactoriamente el planificador.", "success");
                window.location = '/visitante/misfavoritos';
            } else {
                $scope.errores = data.errores;
                swal("Error", "Por favor verifique la información", "error");
            }
           $("body").attr("class", "cbp-spmenu-push");
        }).catch(function() {
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
    }
    
    $scope.onDragComplete = function (data, evt, id) {
        $('#fav-' + id).addClass('list-group-item-drop');
        //console.log("drag success, data:", data);
    }
    $scope.onDropItem = function (data, evt) {
        //console.log("drag success, data:", data);
        $('#fav-' + id).removeClass('list-group-item-drop');
    }
    var toType = function (obj) {
        return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase()
    }
    $scope.onDropComplete = function (index, dia, planificador, data, evt) {
        var copyData = $.extend(true, {}, data);
        var found = -1;
        for (var i = 0; i < dia.Items.length; i++) {
            if (dia.Items[i].Id == copyData.Id && dia.Items[i].Tipo == copyData.Tipo) {
                found = i;
                break;
            }
        }
        if (found == -1) {
            copyData['Orden'] = dia.Items.length + 1;
            if (copyData.Tipo == 4) {
                
                // var fInicioData, fFinData;
                // if (copyData.FechaInicial.indexOf('/') != -1 && copyData.FechaFin.indexOf('/') !=  -1) {
                //     fInicioData = copyData.FechaInicial.split(' ')[0].split('/');
                //     fFinData = copyData.FechaFin.split(' ')[0].split('/');
                // } else {
                //     fInicioData = copyData.FechaInicial.split(' ')[0].split('-');
                //     fFinData = copyData.FechaFin.split(' ')[0].split('-');
                // }
                
                if (validarFechas( convertDate(copyData.FechaInicial) , convertDate(copyData.FechaFin) , planificador.Fecha_inicio, planificador.Fecha_fin)) {
                    swal("Error en fecha del evento", "El evento no puede ser agregado a este planificador porque su fecha no corresponde al rango de fecha del planificador.", "error");
                } else {
                    // copyData.FechaInicial = new Date(fInicioData[1] + '/' + fInicioData[0] + '/' + fInicioData[2]);
                    // copyData.FechaFin = new Date(fFinData[1] + '/' + fFinData[0] + '/' + fFinData[2]);
                    dia.Items.push(copyData);
                }
            } else {
                dia.Items.push(copyData);
            }
            //$scope.planificador.Dias.push(dia);
        } else {
            swal("Ítem duplicado", "El ítem ya se encuentra en el día" + ' ' + (index + 1), "error");
        }
    }
    $scope.deleteItem = function (index, items) {
        items.splice(index, 1);
    }
    $scope.ordenarItem = function (index, items) {
        var temp = items[index];
        items[index].Orden -= 1;
        items[index] = items[index - 1];
        items[index - 1].Orden += 1;
        items[index - 1] = temp;

    }
    $scope.addDay = function (planificador) {
        if ((restaFechas(stringToDate(planificador.Fecha_inicio), stringToDate(planificador.Fecha_fin)) + 1) <= planificador.Dias.length) {
            swal("Error", "El número de días ingresado supera los días de duración del viaje ingresados en la configuración del planificador.", "error");
        } else {
            var dia = { Items: [] };
            planificador.Dias.push(dia);
            $scope.planificador = planificador;
        }

    }
    $scope.removeDay = function (planificador,dia) {
        planificador.Dias.splice(dia, 1);
    }
    
    
    $scope.quitarFavoritos = function (fav) {
        var ruta;
        var data = {};
        switch (fav.Tipo) {
            case 1:
                data.atraccion_id = fav.Id;
                ruta = '/atracciones/favoritoclient';
                break;
            case 2:
                data.actividad_id = fav.Id;
                ruta = '/actividades/favoritoclient';
                break;
            case 3:
                data.proveedor_id = fav.Id;
                ruta = '/proveedor/favoritoclient';
                break;
            case 4:
                data.evento_id = fav.Id;
                ruta = '/eventos/favoritoclient';
                break;
        }
        
        $("body").attr("class", "charging");
        visitanteServi.QuitarFavorito(ruta, data).then(function(data) {
            if(data.success) {
                swal("Exito!", "Se ha quitado satisfactoriamente de favoritos.", "success");
                $scope.favoritos.splice($scope.favoritos.indexOf(fav), 1);
            } else {
                $scope.errores = data.errores;
                swal("Error", "Se ha presentado un error en la petición.", "error");
            }
           $("body").attr("class", "cbp-spmenu-push");
        }).catch(function() {
           $("body").attr("class", "cbp-spmenu-push");
           swal("Error", "Error en la carga, por favor recarga la página.", "error");
        })
        
    }
    
    
    function validarFechas(fechaNuevaInicial, fechaNuevaFinal, fechaViejaInicial, fechaViejaFinal) {
        if ((fechaNuevaInicial >= fechaViejaInicial && fechaNuevaInicial <= fechaViejaFinal) || (fechaNuevaFinal >= fechaViejaInicial && fechaNuevaFinal <= fechaViejaFinal) || (fechaNuevaInicial < fechaViejaInicial && fechaNuevaFinal > fechaViejaFinal)) {
            return false;
        }
        return true;
    }
    
    // Función para calcular los días transcurridos entre dos fechas
    function restaFechas(a, b) {
        var _MS_PER_DAY = 1000 * 60 * 60 * 24;
        // Discard the time and time-zone information.
        var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

        return Math.floor((utc2 - utc1) / _MS_PER_DAY);
    }
    
    function stringToDate(date) {
        var cad;
        if (date.indexOf('/') != -1) {
            cad = date.split(' ')[0].split('/');
        } else {
            cad = date.split(' ')[0].split('-');
        }
        return new Date(cad[1] + '/' + cad[0] + '/' + cad[2]);
        
           
    }
    
    function convertDate(dateString){
        var p = dateString.split(/\D/g)
        return [p[2],p[1],p[0] ].join("-")
    } 
   
}])

.controller('planificador', ['$scope', 'visitanteServi',function ($scope, visitanteServi) {
   
   $scope.$watch('Id', function () {

        if ($scope.Id != null) {
            $("body").attr("class", "charging");
            visitanteServi.MiPlanificador($scope.Id).then(function(data) {
               $scope.planificador = data.planificador;
               $("body").attr("class", "cbp-spmenu-push");
            }).catch(function() {
               $("body").attr("class", "cbp-spmenu-push");
               swal("Error", "Error en la carga, por favor recarga la página.", "error");
            })
        }

    })
    
}])