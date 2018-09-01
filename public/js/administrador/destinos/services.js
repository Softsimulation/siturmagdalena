var app = angular.module('destinosServices', []);

app.factory('destinosServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradordestinos/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postDesactivarActivar: function(id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/desactivar-activar', {'id' : id}).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosdestino: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradordestinos/datosdestino/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatosIdioma: function (id, idIdioma){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradordestinos/datos-idioma/'+id+'/'+idIdioma).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDatoscrear: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradordestinos/datoscrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCreardestino: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/creardestino', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postGuardarmultimedia: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/guardarmultimedia', data, {
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

            $http.post('/administradordestinos/editaridioma', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditardatosgenerales: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/editardatosgenerales', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        getDeletesector: function (id){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administradordestinos/deletesector/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditaridiomasector: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/editaridiomasector', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearsector: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administradordestinos/crearsector', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        }
    }
}])