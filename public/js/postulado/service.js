var app = angular.module("postuladoService", []);

app.factory("postuladoServi", ["$http", "$q", function ($http, $q) {

    return {
        CargarCrearPostulado: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/postulado/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarMunicipios: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/postulado/municipios/'+data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CrearPostulante: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/postulado/crearpostulado',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);