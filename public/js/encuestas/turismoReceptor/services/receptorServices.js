var app = angular.module("recpetorService", []);

app.factory("receptorServi", ["$http", "$q", function ($http, $q) {

    return {
        informacionCrear: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/informaciondatoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDepartamento: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/departamento/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getMunicipio: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/municipio/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCrearEncuesta: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardardatos',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosEstancia: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargardatosseccionestancia/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionEstancia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/crearestancia',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getEncuestas: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/encuestas',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);