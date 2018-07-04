var app = angular.module("paisesServices", []);

app.factory("paisServi", ["$http", "$q", function ($http, $q) {

    return {
        getDatos: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administrarpaises/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postCreatepais: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarpaises/crearpais', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postAgregarnombre: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarpaises/agregarnombre', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postEditarpais: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarpaises/editarpais', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postImportexcel: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarpaises/importexcel', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        }
    }
}]);