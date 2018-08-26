/* global angular */
/* global swal */
angular.module('atracciones.crear', [])

.controller('atraccionesCrearController', function($scope, atraccionesServi){
    var marker = null;
    var lat;
    var lng;
    var latlng;
    $scope.atraccion = {
        datosGenerales: {
            pos: {
                lat: null,
                lng: null
            }
        },
        id: -1
    };
    
    $scope.groupByDestino = function (item) {
        // by returning this, it will attach this as the group by key
        // and automatically group your items by this
        return item.destino.destino_con_idiomas[0].nombre;
    }
    $("body").attr("class", "cbp-spmenu-push charging");
    atraccionesServi.getDatoscrear().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.sectores = data.sectores;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.tipos_atracciones = data.tipos_atracciones;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.actividades = data.actividades;
        }
    }).catch(function (errs){
        $("body").attr("class", "cbp-spmenu-push");
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
    });
    
    var map = new GMaps({
        el: '#direccion_map',
        lat: 11.2315042,
        lng: -74.193007,
        zoom: 12,
        click: function (e){
            lat = e.latLng.lat();
            lng = e.latLng.lng();
            map.removeMarkers();
            marker = map.addMarker({
                lat: lat,
                lng: lng,
                infoWindow: {
                    content: '<p><b>Su posición</b></p>'
                }
            });
            $scope.atraccion.datosGenerales.pos.lat = angular.copy(lat);
            $scope.atraccion.datosGenerales.pos.lng = angular.copy(lng);
        }
    });
    
    $scope.searchAdress = function(){
        GMaps.geocode({
            address: $('#address').val(),
            callback: function(results, status) {
                if (status == 'OK') {
                    latlng = results[0].geometry.location;
                    map.setCenter(latlng.lat(), latlng.lng());
                    map.removeMarkers();
                    map.setZoom(16);
                    marker = map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng(),
                        infoWindow: {
                            content: '<p><b>'+ $('#address').val() +'</b></p>'
                        }
                    });
                    $scope.atraccion.datosGenerales.pos.lat = angular.copy(latlng.lat());
                    $scope.atraccion.datosGenerales.pos.lng = angular.copy(latlng.lng());
                }
            }
        });
    }
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.crearAtraccionForm.$valid || $scope.atraccion.id != -1){
            return;
        }
        if (marker == null){
            swal('Error', 'No ha colocado un marcador en el mapa.', 'error');
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.postCrearatraccion($scope.atraccion.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.atraccion.id = data.id;
                swal('¡Éxito!', 'Atracción creada con éxito.', 'success');
                $scope.errores = null;
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid && $scope.atraccion.id != -1){
            return;
        }
        var fd = new FormData();
        var input = $('#portadaIMG');
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
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
            return;
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
            }
        }
        fd.append('id', $scope.atraccion.id);
        fd.append('video_promocional', $("#video_promocional").val());
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.postGuardarmultimedia(fd).then(function (data){
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
        if (!$scope.informacionAdicionalForm.$valid || $scope.atraccion.id == -1){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.atraccion.adicional.id = $scope.atraccion.id;
        atraccionesServi.postGuardaradicional($scope.atraccion.adicional).then(function(data){
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