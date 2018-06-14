var app = angular.module("ofertaService", []);

app.factory("ofertaServi",["$http", "$q", function ($http, $q) {
    return {
        getinfoCaracterizacionOperadora: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/infocaracterizacionoperadora/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionOperadora: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/crearcaracterizacionoperadora',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOcuacionOperadora: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/cargardatosocupacionoperadoras/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOcupacionOperadora: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarocupacionoperadora',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosAlquilerVehiculo: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/cargarcaracterizacionalquilervehiculos/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionAlquilerVehiculo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarcaracterizacionalquilervehiculo',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    };
}])