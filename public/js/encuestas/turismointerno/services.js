var app = angular.module("internoService", []);

app.factory("internoServi", ["$http", "$q", function ($http, $q) {

    return {
  
        getDatosEstancia: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismointerno/actividades/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionEstancia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismointerno/crearestancia',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
         getDatosViajes: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismointerno/viajes/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);