var app = angular.module('actividadesServices', []);

app.factory('actividadesServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoractividades/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postDesactivarActivar: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/desactivar-activar', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postSugerir: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/sugerir', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosactividad: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoractividades/datosactividad/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosIdioma: function (id, idIdioma){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoractividades/datos-idioma/'+id+'/'+idIdioma).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatoscrear: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoractividades/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearactividad: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/crearactividad', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardarmultimedia: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/guardarmultimedia', data, {
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

            $http.post('/administradoractividades/guardaradicional', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaridioma: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/editaridioma', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditardatosgenerales: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoractividades/editardatosgenerales', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        }
    }
}])