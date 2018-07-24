var app = angular.module("proveedorServices", []);

app.factory("proveedorServi", ["$http", "$q", function ($http, $q) {

    return {
  
        CargarListado: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/listado').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
           getEncuestas: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/encuestasrealizadas/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
       
        
        
    }
}]);