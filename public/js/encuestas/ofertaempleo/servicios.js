var app = angular.module("OfertaEmpleoServices", []);

app.factory("OfertaEmpleoServi", ["$http", "$q", function ($http, $q) {

    return {
  
        getDataAlojamiento: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/dataalojamiento/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionAlojamiento: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarcaracterizacionalojamientos', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAlojamiento: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarofertaalojamientos', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);