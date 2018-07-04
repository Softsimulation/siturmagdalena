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

        getEncuestas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/encuestas').success(function (data) {
             defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosTransporte: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargardatostransporte/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionTransporte: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardarsecciontransporte',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosSeccionViajeGrupo: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargardatosseccionviaje/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionViajeGrupo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardarseccionviajegrupo',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosSeccionInformacion: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargardatosseccioninformacion/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionInformacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardarseccioninformacion',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosSeccionPercepcion: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargardatospercepcion/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarSeccionPercepcion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardarseccionpercepcion',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosEditarDatos: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/cargareditardatos/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEditarDatos: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardareditardatos',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoGasto: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/turismoreceptor/infogasto/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postGuardarGasto: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/turismoreceptor/guardargastos',data).success(function (data) {

                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);