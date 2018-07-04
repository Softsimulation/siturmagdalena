var app = angular.module("usuarioService", []);

app.factory("usuarioServi", ["$http", "$q", function ($http, $q) {

    return {
        
        getUsuarios: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/usuario/usuarios').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInformacionguardar: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/usuario/informacionguardar').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInformacionEditar: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/usuario/informacioneditar/'+id).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        guardar: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/usuario/guardarusuario', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editar: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/usuario/editarusuario', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstado: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/usuario/cambiarestado', {'id':data})
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);