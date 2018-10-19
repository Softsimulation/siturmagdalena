var app = angular.module("noticiaService", []);

app.factory("noticiaServi", ["$http", "$q", function ($http, $q) {

    return {
        
        listadoNoticias: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/noticias').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        cambiarEstadoNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/cambiarestado', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        eliminarNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/eliminarnoticia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        verNoticia: function (dato) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datosver/'+dato).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        datosCrearNoticia: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datoscrearnoticias').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/guardarnoticia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarMultimediaNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/guardarmultimedianoticia', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        datosEditarNoticia: function (idNoticia,idIdioma) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datoseditar/'+idNoticia+'/'+idIdioma).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        modificarNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/modificarnoticia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarTextoAlternativo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/guardartextoalternativo', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        datosNuevoIdioma: function (idNoticia) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/noticias/datosnuevoidioma/'+idNoticia).success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarNuevoIdioma: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/guardarnuevoidioma', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        eliminarMultimedia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/eliminarmultimedia', data)
            .success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        editarMultimediaNoticia: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/noticias/editarmultimedia', data, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);