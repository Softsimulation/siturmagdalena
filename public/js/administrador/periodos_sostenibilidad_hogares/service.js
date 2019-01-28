var app = angular.module("periodoSostenibilidadHogaresService", []);

app.factory("periodoSostenibilidadHogaresServi", ["$http", "$q", function ($http, $q) {

    return {
        guardarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadHogares/guardarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        listarRegistros: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/periodoSostenibilidadHogares/listarperiodos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadHogares/editarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadHogares/cambiarestado', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        detalle: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/periodoSostenibilidadHogares/cargardetalle/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);