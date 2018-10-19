var app = angular.module("sostenibilidadHogarServices", []);

app.factory("sostenibilidadHogarServi", ["$http", "$q", function ($http, $q) {
    return {
        
        getInfoCrear: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/infocrear').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postGuardarCrear: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadhogares/guardarencuesta',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoEditar: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/infoeditar/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postEditarCrear: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadhogares/editarencuesta',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoSocial: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/infocomponentesocial/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postGuardarSocial: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadhogares/guardarcomponentesocial',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoAmbiental: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/infocomponenteambiental/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        postGuardarAmbiental: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadhogares/guardarcomponenteambiental',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getInfoEconomico: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/cargardatoseconomico/'+id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        GuardarEconomico: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/sostenibilidadhogares/guardareconomico',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        CargarEncuestas: function () {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/sostenibilidadhogares/listarencuestas').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);