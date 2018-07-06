/* global angular */
/* global swal */
angular.module('atracciones.crear', [])

.controller('atraccionesCrearController', function($scope, atraccionesServi){
    var marker;
    var lat;
    var lng;
    var latlng;
    $scope.atraccion = {
        pos: {
            lat,
            lng
        }
    };
    
    atraccionesServi.getDatoscrear().then(function (data){
        if (data.success){
            $scope.sectores = data.sectores;
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
            $scope.atraccion.pos.lat = angular.copy(lat);
            $scope.atraccion.pos.lng = angular.copy(lng);
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
                    $scope.atraccion.pos.lat = angular.copy(latlng.lat());
                    $scope.atraccion.pos.lng = angular.copy(latlng.lng());
                }
            }
        });
    }
    
    $scope.guardarDepartamento = function (){
        if (!$scope.departamentoForm.$valid){
            return;
        }
        switch($scope.sw){
            case 1:
                departamentosServi.postCreardepartamento($scope.departamento).then(function(data){
                    if (data.success){
                        $scope.departamentos.push(data.departamento);
                        swal('¡Éxito!', 'Departamento agregado con éxito', 'success');
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al ingresar los datos. Por favor, recargue la página.', 'error');
                });
                break;
            
            case 2:
                departamentosServi.postEditardepartamento($scope.departamento).then(function(data){
                    if (data.success){
                        for (var i = 0; i < $scope.departamentos.length; i++){
                            if ($scope.departamentos[i].id == data.departamento.id){
                                $scope.departamentos[i] = data.departamento;
                            }
                        }
                        swal('¡Éxito!', 'Departamento editado con éxito', 'success');
                    }else{
                        $scope.errores = data.errores;
                    }
                }).catch(function(err){
                    swal('Error', 'Error al editar los datos. Por favor, recargue la página.', 'error');
                });
                break;
                
            default:
                swal('Error', 'Error al guardar los datos. Por favor, recargue la página.', 'error');
                break;
        }
    }
    
    $scope.importarCsv = function (){
        var fd = new FormData();
        if ($scope.import_file != null){
            fd.append('import_file', $scope.import_file[0]);
        }else{
            swal('Información', 'No se ha seleccionado ningún archivo.', 'info');
            return;
        }
        console.log($scope.import_file);
        $scope.erroresCSV = null;
        departamentosServi.postImportexcel(fd).then(function (data){
            if (data.success){
                window.location.reload();
            }else{
                $scope.erroresCSV = data.errores;
            }
        })
    }
});