var app = angular.module("proveedorService", []);

app.factory("proveedorServi", ["$http", "$q", function ($http, $q) {

    return {
        CargarSoporte: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/importarRnt/cargarsoporte',data, {
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
        EditarProveedor: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/importarRnt/editarproveedor',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CrearProveedor: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/importarRnt/crearproveedor',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CrearHabilitarProveedor: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/importarRnt/crearhabilitarproveedor',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);