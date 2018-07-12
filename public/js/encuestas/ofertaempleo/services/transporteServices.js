var app = angular.module("transporteService", []);

app.factory("transporteServi", ["$http", "$q", function ($http, $q) {

    return {
        getCaracterizacionTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/infocaracterizaciontransporte/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarcaracterizaciontransporte',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/infoofertatransporte/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarofertatransporte',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
        
    }
}]);