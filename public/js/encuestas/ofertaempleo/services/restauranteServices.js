var app = angular.module("restauranteService", []);

app.factory("restauranteServi", ["$http", "$q", function ($http, $q) {

    return {
        getInfoAlimentosC: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/infocaracterizacionalimentos/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarCarAlimentos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarcaralimentos', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        getInfoCapAlimentos: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/infocapalimentos/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarOfertaAlimentos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarofertaalimentos', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        getDatosOfertaAgencia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/datosofertaagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/ofertaagencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAgenciaViajes: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarofertaagenciaviajes', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);