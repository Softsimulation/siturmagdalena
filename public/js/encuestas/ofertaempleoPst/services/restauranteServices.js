var app = angular.module("restauranteServicePst", []);

app.factory("restauranteServiPst", ["$http", "$q", function ($http, $q) {

    return {
        getInfoAlimentosC: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/infocaracterizacionalimentos/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarCarAlimentos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarcaralimentos', data)
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

            $http.get('/ofertaempleopst/infocapalimentos/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarOfertaAlimentos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertaalimentos', data)
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

            $http.get('/ofertaempleopst/datosofertaagencia').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOfertaAgencia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/ofertaagencia/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAgenciaViajes: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertaagenciaviajes', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);