var app = angular.module("adminservice", []);

app.factory("adminService", ["$http", "$q", function ($http, $q) {

    return {
       

        
        Exportar: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/exportacion/exportar',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        }
        
        
        
    }
}]);