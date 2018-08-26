var app = angular.module('eventosServices', []);

app.factory('eventosServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoreventos/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postDesactivarActivar: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoreventos/desactivar-activar', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosevento: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoreventos/datosevento/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosIdioma: function (id, idIdioma){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoreventos/datos-idioma/'+id+'/'+idIdioma).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatoscrear: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradoreventos/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearevento: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoreventos/crearevento', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardarmultimedia: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoreventos/guardarmultimedia', data, {
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

            $http.post('/administradoreventos/guardaradicional', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaridioma: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradoreventos/editaridioma', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditarevento: function (data){
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