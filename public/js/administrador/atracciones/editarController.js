/* global angular */
/* global swal */
angular.module('atracciones.editar', [])

.controller('atraccionesEditarController', function($scope, atraccionesServi, $location, $http){
    $scope.atraccion = {
        adicional: {},
        datosGenerales: {
            pos: {
                lat,
                lng
            }
        }
    };
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    var marker = null;
    var lat;
    var lng;
    var latlng;
    var map = null;
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.getDatosatraccion($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.atraccionNombre = data.atraccion.sitio.sitios_con_idiomas[0].nombre;
                $scope.atraccion.adicional.perfiles = data.perfiles_turista;
                $scope.atraccion.adicional.tipos = data.tipo_atracciones;
                $scope.atraccion.adicional.categorias = data.categorias_turismo;
                $scope.atraccion.adicional.actividades = data.actividades;
                
                $scope.atraccion.datosGenerales.valor_minimo = parseInt(data.atraccion.valor_min);
                $scope.atraccion.datosGenerales.valor_maximo = parseInt(data.atraccion.valor_max);
                $scope.atraccion.datosGenerales.sector_id = data.atraccion.sitio.sectores_id;
                $scope.atraccion.datosGenerales.direccion = data.atraccion.sitio.direccion;
                $scope.atraccion.datosGenerales.telefono = data.atraccion.telefono;
                $scope.atraccion.datosGenerales.pagina_web = data.atraccion.sitio_web;
                $scope.atraccion.datosGenerales.pos.lat = data.atraccion.sitio.latitud;
                $scope.atraccion.datosGenerales.pos.lng = data.atraccion.sitio.longitud;
                $scope.atraccion.datosGenerales.id = $scope.id;
                
                
                map = new GMaps({
                    el: '#direccion_map',
                    lat: data.atraccion.sitio.latitud,
                    lng: data.atraccion.sitio.longitud,
                    zoom: 16,
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
                
                marker = map.addMarker({
                    lat: $scope.atraccion.datosGenerales.pos.lat,
                    lng: $scope.atraccion.datosGenerales.pos.lng,
                    infoWindow: {
                        content: '<p><b>Su posición</b></p>'
                    }
                });
                
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
    
    atraccionesServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.sectores = data.sectores;
            $scope.perfiles_turista = data.perfiles_turista;
            $scope.tipos_atracciones = data.tipos_atracciones;
            $scope.categorias_turismo = data.categorias_turismo;
            $scope.actividades = data.actividades;
        }
    }).catch(function (errs){
        swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
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
        atraccionesServi.postGuardarmultimedia(fd).then(function (data){
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
        if (!$scope.editarAtraccionForm.$valid){
            return;
        }
        if (marker == null){
            swal('Error', 'No ha colocado un marcador en el mapa.', 'error');
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        atraccionesServi.postEditaratraccion($scope.atraccion.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                $scope.atraccion.id = data.id;
                swal('¡Éxito!', 'Atracción modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid || $scope.atraccion.id == -1){
            return;
        }
        $scope.atraccion.adicional.id = $scope.id;
        atraccionesServi.postGuardaradicional($scope.atraccion.adicional).then(function(data){
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Información adicional modificada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});