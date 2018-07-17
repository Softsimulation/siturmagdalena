/* global angular */
/* global swal */
angular.module('atracciones.crear', [])

.controller('atraccionesCrearController', function($scope, atraccionesServi, FileUploader){
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
    $("#portadaIMG").fileinput({
        language: "es",
        showUpload: false,
        required: true,
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
    // $("#imagenes").fileinput({
    //     maxFileCount: 5,
    //     showUpload: false,
    //     validateInitialCount: true,
    //     autoFitCaption: true,
    //     autoReplace: true,
    //     overwriteInitial: false,
    //     language: "es",
    //     initialPreview: [
    //         "<img class='kv-preview-data file-preview-image' src='https://placeimg.com/800/460/nature'>",
    //         "<img class='kv-preview-data file-preview-image' src='https://placeimg.com/800/460/nature'>",
    //         "<img class='kv-preview-data file-preview-image' src='https://placeimg.com/800/460/nature'>"
    //     ],
    //     initialPreviewConfig: [
    //         {caption: "Nature-1.jpg", size: 628782, width: "120px", url: "/site/file-delete", key: 1},
    //         {caption: "Nature-2.jpg", size: 982873, width: "120px", url: "/site/file-delete", key: 2}, 
    //         {caption: "Nature-3.jpg", size: 567728, width: "120px", url: "/site/file-delete", key: 3} 
    //     ],
    //     allowedFileExtensions: ["jpg", "png", "gif"]
    // });
    $("#imagenes").fileinput({
        autoReplace: false,
        uploadUrl: "",
        maxFileCount: 5,
        showUpload: false,
        language: "es",
        allowedFileExtensions: ["jpg", "png", "gif"],
        fileActionSettings: {
            showUpload: false
        }
    });
    
    $scope.groupByDestino = function (item) {
        // by returning this, it will attach this as the group by key
        // and automatically group your items by this
        return item.destino.destino_con_idiomas[0].nombre;
    }
    
    $scope.portadaUploader = new FileUploader({
        queueLimit: 1
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
        atraccionesServi.postCrearatraccion($scope.atraccion.datosGenerales).then(function(data){
            if (data.success){
                $scope.atraccion.id = data.id;
                swal('¡Éxito!', 'Atracción creada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarMultimedia = function (){
        if (!$scope.multimediaForm.$valid && $scope.atraccion.id != -1){
            return;
        }
        var portada = $("#portadaIMG");
        var fd = new FormData();
        fd.append("portadaIMG", portada[0].files[0]);
        jQuery.each($("#imagenes")[0].files, function (i, value){
            fd.append("image[]", value);
        });
        fd.append('id', $scope.atraccion.id);
        fd.append('video_promocional', $("#video_promocional").val());
        atraccionesServi.postGuardarmultimedia(fd).then(function (data){
            if (data.success){
                swal('¡Éxito!', 'Multimedia agregada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.guardarAdicional = function (){
        if (!$scope.informacionAdicionalForm.$valid || $scope.atraccion.id != -1){
            return;
        }
        $scope.atraccion.adicional.id = 115;
        atraccionesServi.postGuardaradicional($scope.atraccion.adicional).then(function(data){
            if (data.success){
                swal('¡Éxito!', 'Atracción creada con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
});