/* global angular */
/* global swal */
angular.module('eventos.crear', [])

.controller('eventosCrearController', function($scope, eventosServi){
    $scope.evento = {
        datosGenerales: {
            pos: {
                lat: null,
                lng: null
            }
        },
        id: -1
    };
    
    $scope.fechaActual = "'" + formatDate(new Date()) + "'";
    $scope.optionFecha = {
        calType: 'gregorian',
        format: 'YYYY/MM/DD',
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
    
    $("body").attr("class", "cbp-spmenu-push charging");
    eventosServi.getDatoscrear().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.sitios = data.sitios;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.tipos_evento = data.tipos_evento;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
  
   
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.crearEventoForm.$valid || $scope.evento.id != -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.postCrearevento($scope.evento.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                $scope.evento.id = data.id;
                swal('¡Éxito!', 'Evento creado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid || $scope.evento.id == -1){
            return;
        }
        var fd = new FormData();
        var input = $('#files-brcc-portadaIMG');
        if (input[0] != undefined) {
            // check for browser support (may need to be modified)
            if (input[0].files && input[0].files.length == 1) {
                if (input[0].files[0].size > 2097152) {
                    swal("Error", "Por favor la imagen debe tener un peso menor de " + (2097152 / 1024 / 1024) + " MB", "error");
                    // alert("The file must be less than " + (1572864/ 1024 / 1024) + "MB");
                    return;
                }
            }
        }
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
            fd.append("portadaIMGText", $('#text-brcc-portadaIMG-0').val());
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
                fd.append("imageText[]", $($('.cont-files-imagenes').find('input')[i]).val());
            }
        }
        fd.append('id', $scope.evento.id);
        fd.append('video_promocional', $("#video_promocional").val());
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Multimedia agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid || $scope.evento.id == -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.evento.adicional.id = $scope.evento.id;
        eventosServi.postGuardaradicional($scope.evento.adicional).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Información adicional agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    };
});