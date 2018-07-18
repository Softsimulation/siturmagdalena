var app = angular.module("ofertaService", []);

app.factory("ofertaServi", ["$http", "$q", function ($http, $q) {

    return {
  
        guardarNumeroEmp: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarnumeroemp',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
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
        guardarEmpCaracterizacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarempcaracterizacion',data).success(function (data) {
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
        guardarEmpleoMensual: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardarempleomensual',data).success(function (data) {
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
         cargarDatosEmplMensual: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/cargardatosdmplmensual/'+id).success(function (data) {
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
       
         cargarDatosEmplCaract: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/cargardatosemplcaract/'+id).success(function (data) {
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
        
         cargarDatosNumEmp: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleo/cargardatosnumemp/'+id).success(function (data) {
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
        
        guardarActvidadComercial: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleo/guardaractividadcomercial',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
        
    }
}]);
