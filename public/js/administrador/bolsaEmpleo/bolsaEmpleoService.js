var app = angular.module("bolsaEmpleoService", []);

app.factory("bolsaEmpleoServi", ["$http", "$q", function ($http, $q) {

    return {
        getEmpresas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/bolsaEmpleo/empresas').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        crearVacante: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/bolsaEmpleo/crearvacante',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getVacante: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/bolsaEmpleo/cargareditarvacante/' + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarVacante: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/bolsaEmpleo/editarvacante',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cargarVacantes: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/bolsaEmpleo/cargarvacantes').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/bolsaEmpleo/cambiarestadovacante',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstadoPublicar: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/bolsaEmpleo/cambiarestadopublicovacante',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        PostulacionesVacante: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/bolsaEmpleo/vacantepostulados/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);