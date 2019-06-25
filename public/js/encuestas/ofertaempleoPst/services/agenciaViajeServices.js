var app = angular.module("agenciaViajeServicePst", []);

app.factory("agenciaViajeServipst", ["$http", "$q", function ($http, $q) {

    return {
        getDatosAgencia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/datosagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/agencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarcaracterizacion', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        getDatosOfertaAgencia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/datosofertaagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/ofertaagencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAgenciaViajes: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertaagenciaviajes', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);