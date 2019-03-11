var app = angular.module("indicadorMedicionService", []);

app.factory("indicadorMedicionServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoIndicadores: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/indicadoresMedicion/indicadoresmedicion').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);