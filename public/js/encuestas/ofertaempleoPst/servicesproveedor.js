var app = angular.module("proveedorServicesPst", []);

app.factory("proveedorServiPst", ["$http", "$q", function ($http, $q) {

    return {
  
        CargarListado: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/listado').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
         getEncuestasTotal: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/encuestasrealizadastotales').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
           getEncuestas: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/encuestasrealizadas/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
           getProveedor: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/proveedor/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },       

        Activar: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardaractivar',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarListadoRnt: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/listadornt').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
             EditarProveedor: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarproveedorrnt',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        getHistorialencuesta: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/historialencuesta/'+id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);