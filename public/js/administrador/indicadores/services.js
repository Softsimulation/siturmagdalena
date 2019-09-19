var app = angular.module("serviceIndicadores", []);

app.factory("serviceIndicador", ["$http", "$q", function ($http, $q) {

    return {
        
        getInfo: function () {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/calcularindicadores/cargarinfo').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            
            return promise;
        },
        
        guardar: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/calcularindicadores/calcularindicador',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            
            return promise;
        },
        recalcular: function (data) {
            
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/calcularindicadores/recalcularindicador',data).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            
            return promise;
        },
        
        
    }
}]);