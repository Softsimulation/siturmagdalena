var app = angular.module("adminservice", []);

app.factory("adminService", ["$http", "$q", function ($http, $q) {

    return {

        getDatos: function ()
        {
            var defered = $q.defer();
            var promise = defered.promise;
            $http.get('/modelospredictivos/data').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });

            return promise;
        },

        predecir: function (data)
        {
            var defered = $q.defer();
            var promise = defered.promise;
            $http.post('/modelospredictivos/predecir',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });

            return promise;
        },
    }
}]);