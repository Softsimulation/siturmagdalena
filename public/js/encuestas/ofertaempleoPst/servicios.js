var app = angular.module("OfertaEmpleoServicesPst", []);

app.factory("OfertaEmpleoServiPst", ["$http", "$q", function ($http, $q) {

    return {
  
        getDataAlojamiento: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/dataalojamiento/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionAlojamiento: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarcaracterizacionalojamientos', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAlojamiento: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertaalojamientos', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarAlojamientoMensual: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardaralojamientomensual', data ).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
    }
}]);