var app = angular.module("sostenibilidadPstService", []);

app.factory("sostenibilidadPstServi", ["$http", "$q", function ($http, $q) {
    return {
        getProveedoresRnt: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargarproveedoresrnt').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postCrearEncuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardarconfiguracion',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getCargarSocioCultural: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargardatossociocultural/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSocioCultural: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardarseccioncultural',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarAmbiental: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargardatosambiental/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarAmbiental: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardarambiental',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarEconomico: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargardatoseconomico/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEconomico: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardareconomico',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarEditarEncuesta: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargareditarencuesta/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEditarEncuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardareditarencuesta',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        }
    }
}]);