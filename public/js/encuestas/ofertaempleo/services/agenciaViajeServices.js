var app = angular.module("agenciaViajeService", []);

app.factory("agenciaViajeServi", ["$http", "$q", function ($http, $q) {

    return {
        getDatosAgencia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/datosagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/agencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarcaracterizacion', data)
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

            $http.get('/ofertaempleo/datosofertaagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/ofertaagencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAgenciaViajes: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarofertaagenciaviajes', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);