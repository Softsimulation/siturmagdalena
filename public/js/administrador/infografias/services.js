var app = angular.module("infografiasservice", []);

app.factory("adminService", ["$http", "$q", function ($http, $q) {

    return {
       
        
        
        getDatos: function () {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/infografias/datos').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        Generar: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/infografias/generar',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        }
        
        
        
    }
}]);