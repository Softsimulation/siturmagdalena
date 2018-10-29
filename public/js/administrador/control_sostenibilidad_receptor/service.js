var app = angular.module("ControlSostenibilidadService", []);

app.factory("controlSostenibilidadServi", ["$http", "$q", function ($http, $q) {

    return {
        guardarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/controlSostenibilidadReceptor/guardarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        listarRegistros: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/controlSostenibilidadReceptor/listado').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/controlSostenibilidadReceptor/editarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/controlSostenibilidadReceptor/cambiarestado', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);