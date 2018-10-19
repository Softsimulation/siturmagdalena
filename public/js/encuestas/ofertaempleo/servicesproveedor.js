var app = angular.module("proveedorServices", []);

app.factory("proveedorServi", ["$http", "$q", function ($http, $q) {

    return {
  
        CargarListado: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/listado').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
           getEncuestas: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/encuestasrealizadas/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
           getProveedor: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/proveedor/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },       

        Activar: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardaractivar',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarListadoRnt: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/listadornt').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
    }
}]);