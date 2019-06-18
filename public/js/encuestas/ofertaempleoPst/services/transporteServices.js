var app = angular.module("transporteServicePst", []);

app.factory("transporteServiPst", ["$http", "$q", function ($http, $q) {

    return {
        getCaracterizacionTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/infocaracterizaciontransporte/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarcaracterizaciontransporte',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/infoofertatransporte/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaTransporte: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertatransporte',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
        
    }
}]);