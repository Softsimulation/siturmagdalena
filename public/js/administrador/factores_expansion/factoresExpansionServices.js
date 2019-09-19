var app = angular.module("factorExpansionService", []);

app.factory("factorExpansionServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoFactoresOferta: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/factoresExpansion/factoresoferta').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearFactor: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/factoresExpansion/crearfactor',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarFactor: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/factoresExpansion/editarfactor',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);