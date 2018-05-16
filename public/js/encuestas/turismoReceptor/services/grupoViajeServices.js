var app = angular.module("grupoViajeService", []);

app.factory("grupoViajeServi", ["$http", "$q", function ($http, $q) {

    return {
        informacionCrear: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/grupoviaje/informaciondatoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarGrupo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/grupoviaje/guardargrupo',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        listadoGrupos: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/grupoviaje/grupos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        VerGrupo: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/grupoviaje/detallegrupo/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        InformacionEditar: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/grupoviaje/informacioneditar/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        EditarGrupo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/grupoviaje/editargrupo',data).success(function (data) {
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
    }
}]);