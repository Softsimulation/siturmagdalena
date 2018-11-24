var app = angular.module("visitanteService", []);

app.factory("visitanteServi", ["$http", "$q", function ($http, $q) {

    return {
        CargarFavoritos: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/visitante/favoritos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarPlanificador: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/visitante/guardarplanificador', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        MiPlanificador: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/visitante/planificador/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        QuitarFavorito: function(ruta, data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post(ruta, data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        }
    }
}]);