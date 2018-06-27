var app = angular.module("interno.Services", []);

app.factory("serviInterno", ["$http", "$q", function ($http, $q) {

    return {

        getDataGastos: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/datagastos', { id: id }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarGastos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/guardargastos', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosEstancia: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismointerno/actividades/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionEstancia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/crearestancia',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosViajes: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismointerno/viajes/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarviaje: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/createviaje',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        eliminarviaje: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/eliminarviaje',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        siguienteviaje: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/siguienteviaje',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatoViaje: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismointerno/viaje/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },

    }

}]);