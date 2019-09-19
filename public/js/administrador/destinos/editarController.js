/* global angular */
/* global swal */
angular.module('destinos.editar', [])

.controller('destinosEditarController', function($scope, destinosServi, $location, $http){
    $scope.destino = {
        adicional: {},
        datosGenerales: {
            pos: {
                lat,
                lng
            }
        }
    };
    
    $scope.orderByField = '';
    $scope.reverseSort = false;
    var marker = null;
    var lat;
    var lng;
    var latlng;
    var map;
    $scope.previewportadaIMG = [];
    $scope.previewImagenes = [];
    $scope.portadaIMGText = [];
    $scope.previewImagenesText = [];
    
    $scope.$watch('id', function(){
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.getDatosdestino($scope.id).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.destinoNombre = data.destino.destino_con_idiomas[0].nombre;
                $scope.destino.datosGenerales.tipo = data.destino.tipo_destino_id;
                $("#video").val(data.video);
                $scope.destino.datosGenerales.pos.lat = data.destino.latitud;
                $scope.destino.datosGenerales.pos.lng = data.destino.longitud;
                $scope.sectores = data.destino.sectores;
                $scope.idiomas = data.idiomas;
                
                var portada = null;
                if (data.portadaIMG != null){
                    $http.get("../.." + data.portadaIMG.ruta, {responseType: "blob"}).success((response) => {
                        portada = response;
                        $scope.previewportadaIMG.push(portada);
                        $scope.portadaIMGText.push(data.portadaIMG.texto_alternativo);
                    });
                }
                var imagenes = [];
                for (var i = 0; i < data.imagenes.length; i++){
                    $http.get("../.." + data.imagenes[i].ruta, {responseType: "blob"}).success((response) => {
                        imagenes.push(response);
                    });
                    $scope.previewImagenesText.push(data.imagenes[i].texto_alternativo);
                    if (i == (data.imagenes.length - 1)){
                        $scope.previewImagenes = imagenes;
                    }
                }
                
                map = new GMaps({
                    el: '#direccion_map',
                    lat: data.destino.latitud,
                    lng: data.destino.longitud,
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
                        $scope.destino.datosGenerales.pos.lat = angular.copy(lat);
                        $scope.destino.datosGenerales.pos.lng = angular.copy(lng);
                    }
                });
                map.addMarker({
                    lat: $scope.destino.datosGenerales.pos.lat,
                    lng: $scope.destino.datosGenerales.pos.lng,
                    infoWindow: {
                        content: '<p><b>Su posición</b></p>'
                    }
                });
            }
        }).catch(function(error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al cargar los datos. Por favor recargue la página.', 'error');
        });
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
    
    destinosServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.tipos_sitio = data.tipos_sitio;
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
        $("body").attr("class", "cbp-spmenu-push charging");
        fd.append('id', $scope.id);
        fd.append('video', $("#video").val());
        destinosServi.postGuardarmultimedia(fd).then(function (data){
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
    
    $scope.modalSector = function (){
        $scope.sector = {};
        $scope.sector.destino_id = $scope.id;
        $scope.sector.es_urbano = true;
        $scope.nuevoSector.$setPristine();
        $scope.nuevoSector.$setUntouched();
        $("#addSector").modal('show');
    }
    
    $scope.crearSector = function (){
        if (!$scope.nuevoSector.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.postCrearsector($scope.sector).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.sectores.push(data.sector);
                swal('¡Éxito!', 'Sector agregado con éxito.', 'success');
                $("#addSector ").modal('hide');
            }else {
                $scope.errores = data.errores;
            }
        }).catch(function (err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    
    $scope.guardarDatosGenerales = function (){
        if (!$scope.editarDestinoForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        $scope.destino.datosGenerales.id = $scope.id;
        destinosServi.postEditardatosgenerales($scope.destino.datosGenerales).then(function(data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                $scope.errores = null;
                swal('¡Éxito!', 'Destino modificado con éxito.', 'success');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function(err){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.idiomaSectorModal = function (sector, idioma){
        $scope.sectorIdioma = {};
        $scope.sectorIdioma.id = sector.id;
        $scope.sectorIdioma.destino_id = $scope.id;
        for (var i = 0; i < sector.sectores_con_idiomas.length; i++){
            if (sector.sectores_con_idiomas[i].idioma.id == idioma){
                $scope.sectorIdioma.nombre = sector.sectores_con_idiomas[i].nombre;
                break;
            }
        }
        $scope.sectorIdioma.sectores_con_idiomas = sector.sectores_con_idiomas;
        $scope.sectorIdioma.idioma_id = idioma;
        $scope.sectorIdioma.swIdioma = idioma == 0;
        $scope.editarIdiomaSectorForm.$setPristine();
        $scope.editarIdiomaSectorForm.$setUntouched();
        $("#editIdiomaSector").modal('show');
    }
    
    $scope.editarIdiomaSectorController = function (){
        if (!$scope.editarIdiomaSectorForm.$valid){
            return;
        }
        $("body").attr("class", "cbp-spmenu-push charging");
        destinosServi.postEditaridiomasector($scope.sectorIdioma).then(function (data){
            $("body").attr("class", "cbp-spmenu-push");
            if (data.success){
                for (var i = 0; $scope.sectores.length; i++){
                    if ($scope.sectores[i].id == data.sector.id){
                        $scope.sectores[i] = data.sector;
                        break;
                    }
                }
                $scope.errores = null;
                swal('¡Éxito!', 'Sector modificado con éxito.', 'success');
                $("#editIdiomaSector").modal('hide');
            }else{
                $scope.errores = data.errores;
            }
        }).catch(function (error){
            $("body").attr("class", "cbp-spmenu-push");
            swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
        });
    }
    
    $scope.deleteSector = function (sector) {
        swal({
            title: "Eliminar",
            text: "¿Desea eliminar el sector de este destino?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function (res) {
            if (res) {
                destinosServi.getDeletesector(sector.id).then(function (data){
                    if (data.success){
                        for (var i = 0; i < $scope.sectores.length; i++){
                            if ($scope.sectores[i].id == sector.id){
                                $scope.sectores.splice(i, 1);
                                break;
                            }
                        }
                        swal('¡Éxito!', 'Sector eliminado con éxito.', 'success');
                    }
                }).catch(function (error){
                    swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
                });
            }

        });
    }
});