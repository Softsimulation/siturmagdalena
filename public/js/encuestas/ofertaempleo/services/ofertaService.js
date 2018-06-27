var app = angular.module("recpetorService", []);

app.factory("receptorServi", ["$http", "$q", function ($http, $q) {
    return {
        informacionCrear: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/informaciondatoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    
    
}]);