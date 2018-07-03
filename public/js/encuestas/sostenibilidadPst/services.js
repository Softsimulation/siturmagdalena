var app = angular.module("sostenibilidadPstService", []);

app.factory("sostenibilidadPstServi", ["$http", "$q", function ($http, $q) {
    return {
        getProveedoresRnt: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadpst/cargarproveedoresrnt').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postCrearEncuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadpst/guardarconfiguracion',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);