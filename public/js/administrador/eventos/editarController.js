/* global angular */
/* global swal */
angular.module('eventos.editar', [])

.controller('eventosEditarController', function($scope, eventosServi, $location, $http){
    $scope.evento = {
        adicional: {},
        datosGenerales: {}
    };
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    
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
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.getDatosevento($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.eventoNombre = data.evento.eventos_con_idiomas[0].nombre;
                $scope.evento.adicional.perfiles = data.perfiles_turista;
                $scope.evento.adicional.sitios = data.sitios;
                $scope.evento.adicional.categorias = data.categorias_turismo;
                
                $scope.evento.datosGenerales.valor_minimo = parseInt(data.evento.valor_min);
                $scope.evento.datosGenerales.valor_maximo = parseInt(data.evento.valor_max);
                $scope.evento.datosGenerales.tipo_evento = data.evento.tipo_eventos_id;
                $scope.evento.datosGenerales.telefono = data.evento.telefono;
                $scope.evento.datosGenerales.pagina_web = data.evento.web;
                $scope.evento.datosGenerales.fecha_inicio = data.evento.fecha_in;
                $scope.evento.datosGenerales.fecha_final = data.evento.fecha_fin;
                $scope.evento.datosGenerales.id = $scope.id;
                
                var portada = null;
                if (data.portadaIMG != null){
                    $http.get("../.." + data.portadaIMG, {responseType: "blob"}).success((data) => {
                        portada = data;
                        $scope.previewportadaIMG.push(portada);
                    });
                }
                
                var imagenes = [];
                for (var i = 0; i < data.imagenes.length; i++){
                    $http.get("../.." + data.imagenes[i], {responseType: "blob"}).success((response) => {
                        imagenes.push(response);
                    });
                    if (i == (data.imagenes.length - 1)){
                        $scope.previewImagenes = imagenes;
                    }
                }
                $scope.video_promocional = data.video_promocional;
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
    });
    
    eventosServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.sitios = data.sitios;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.tipos_evento = data.tipos_evento;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid){
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
        
        $("body").attr("class", "cbp-spmenu-push charging");
        if ($scope.portadaIMG != null) {
            fd.append("portadaIMG", $scope.portadaIMG[0]);
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (var i in $scope.imagenes){
                if (Number.isInteger(parseInt(i))){
                    fd.append("image[]", $scope.imagenes[i]);
                }
                console.log(i);
            }
        }
        fd.append('id', $scope.id);
        fd.append('video_promocional', $("#video_promocional").val());
        eventosServi.postGuardarmultimedia(fd).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Multimedia modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarEventoForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        eventosServi.postEditarevento($scope.evento.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Evento modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid){
            return;
        }
        $scope.evento.adicional.id = $scope.id;
        $("body").attr("class", "cbp-spmenu-push charging");
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
    }
});