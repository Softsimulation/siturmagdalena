var app = angular.module("bolsaEmpleoService", []);

app.factory("bolsaEmpleoServi", ["$http", "$q", function ($http, $q) {

    return {
        getEmpresas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/bolsaEmpleo/empresas').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearVacante: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/bolsaEmpleo/crearvacante',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);