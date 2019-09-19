var app = angular.module("indicadorMedicionService", []);

app.factory("indicadorMedicionServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoIndicadores: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/indicadoresMedicion/indicadoresmedicion').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInformacionEditar: function (indicador_id,idioma_id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/indicadoresMedicion/informacioneditar/'+indicador_id+'/'+idioma_id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarIndicador: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/indicadoresMedicion/guardarindicador',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearIndicador: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/indicadoresMedicion/crearindicador',dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);