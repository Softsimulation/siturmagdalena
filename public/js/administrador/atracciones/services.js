var app = angular.module('atraccionesServices', []);

app.factory('atraccionesServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoratracciones/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postDesactivarActivar: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/desactivar-activar', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postSugerir: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/sugerir', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosatraccion: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoratracciones/datosatraccion/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosIdioma: function (id, idIdioma){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoratracciones/datos-idioma/'+id+'/'+idIdioma).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatoscrear: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoratracciones/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearatraccion: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/crearatraccion', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardarmultimedia: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/guardarmultimedia', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardaradicional: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/guardaradicional', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaridioma: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/editaridioma', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaratraccion: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoratracciones/editaratraccion', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        }
    }
}])