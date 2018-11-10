var app = angular.module("sliderService", []);

app.factory("sliderServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoSliders: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sliders/sliders').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        agregarSlider: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/guardarslider', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoEditarSlider: function (datos) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/infoeditar', datos)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarSlider: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/editarslider', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        agregarIdiomaSlider: function (agregarIdiomaSlider) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/agregaridiomaslider', agregarIdiomaSlider)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        desactivarSlider: function (sliderId) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/desactivarslider', { 'id': sliderId }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        activarSlider: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/activarslider', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        subirPrioridadSlider: function (sliderId) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/subirprioridad', { 'id': sliderId }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        bajarPrioridadSlider: function (sliderId) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sliders/bajarprioridad', { 'id': sliderId }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);