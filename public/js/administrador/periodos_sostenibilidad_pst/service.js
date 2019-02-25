var app = angular.module("periodoSostenibilidadPstService", []);

app.factory("periodoSostenibilidadPstServi", ["$http", "$q", function ($http, $q) {

    return {
        guardarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadPst/guardarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        listarRegistros: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/periodoSostenibilidadPst/listarperiodos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarRegistro: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadPst/editarregistro', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/periodoSostenibilidadPst/cambiarestado', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        detalle: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/periodoSostenibilidadPst/cargardetalle/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);