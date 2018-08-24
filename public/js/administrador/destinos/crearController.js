/* global angular */
/* global swal */
angular.module('destinos.crear', [])

.controller('destinosCrearController', function($scope, destinosServi){
    var marker = null;
    var lat;
    var lng;
    var latlng;
    $scope.destino = {
        datosGenerales: {
            pos: {
                lat: null,
                lng: null
            }
        },
        id: -1,
        adicional: {}
    };
    
    $scope.groupByDestino = function (item) {
        // by returning this, it will attach this as the group by key
        // and automatically group your items by this
        return item.destino.destino_con_idiomas[0].nombre;
    }
    
    $("body").attr("class", "cbp-spmenu-push charging");
    destinosServi.getDatoscrear().then(function (data){
        $("body").attr("class", "cbp-spmenu-push");
        if (data.success){
            $scope.tipos_sitio = data.tipos_sitio;
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
            $scope.destino.datosGenerales.pos.lat = angular.copy(lat);
            $scope.destino.datosGenerales.pos.lng = angular.copy(lng);
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
                    $scope.destino.datosGenerales.pos.lat = angular.copy(latlng.lat());
                    $scope.destino.datosGenerales.pos.lng = angular.copy(latlng.lng());
                }
            }
        });
    }
    
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.crearDestinoForm.$valid || $scope.destino.id != -1){
            return;
        }
        if (marker == null){
            swal('Error', 'No ha colocado un marcador en el mapa.', 'error');
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.postCreardestino($scope.destino.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.destino.id = data.id;
                swal('¡Éxito!', 'Destino creado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid || $scope.destino.id == -1){
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
        }else{
            swal('Error', 'No ha adjuntado imagen de portada..', 'error');
        }
        if ($scope.imagenes != null && $scope.imagenes.length != 0) {
            for (i in $scope.imagenes){
                fd.append("image[]", $scope.imagenes[i]);
            }
        }
        fd.append('id', $scope.destino.id);
        fd.append('video', $("#video").val());
        destinosServi.postGuardarmultimedia(fd).then(function (data){
            if (data.success){
                swal('¡Éxito!', 'Multimedia agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});