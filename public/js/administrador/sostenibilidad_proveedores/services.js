var app = angular.module("sostenibilidadPstService", []);

app.factory("sostenibilidadPstServi", ["$http", "$q", function ($http, $q) {
    return {
        CargarEncuestas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/listarencuestas').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        }
    }
}]);