var app = angular.module('rutasServices', []);

app.factory('rutasServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradorrutas/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postDesactivarActivar: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradorrutas/desactivar-activar', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosruta: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradorrutas/datosruta/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosIdioma: function (id, idIdioma){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradorrutas/datos-idioma/'+id+'/'+idIdioma).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatoscrear: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradorrutas/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearruta: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradorrutas/crearruta', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardarmultimedia: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradorrutas/guardarmultimedia', data, {
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

            $http.post('/administradorrutas/guardaradicional', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaridioma: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradorrutas/editaridioma', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditarruta: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoreventos/editarevento', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        }
    }
}])