var app = angular.module("ofertaServicePst", []);

app.factory("ofertaServiPst", ["$http", "$q", function ($http, $q) {

    return {
  
        guardarNumeroEmp: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarnumeroemp',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getinfoCaracterizacionOperadora: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/infocaracterizacionoperadora/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
          guardarEmpleo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarempleo',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
         cargarDatosEmplomensual: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargardatosempleo/'+id).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEmpCaracterizacion: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarempcaracterizacion',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionOperadora: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/crearcaracterizacionoperadora',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarEmpleoMensual: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarempleomensual',data).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getOcuacionOperadora: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargardatosocupacionoperadoras/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
         cargarDatosEmplMensual: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargardatosdmplmensual/'+id).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOcupacionOperadora: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarocupacionoperadora',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
       
         cargarDatosEmplCaract: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargardatosemplcaract/'+id).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        getDatosAlquilerVehiculo: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargarcaracterizacionalquilervehiculos/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
       getDatosAlquilerVehiculoOferta: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargarofertaalquilervehiculos/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
         cargarDatosNumEmp: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/cargardatosnumemp/'+id).success(function (data) {
                  defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarCaracterizacionAlquilerVehiculo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarcaracterizacionalquilervehiculo',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        guardarOfertaAlquilerVehiculo: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardarofertaalquilervehiculo',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },        
        guardarActvidadComercial: function (data) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/ofertaempleopst/guardaractividadcomercial',data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
        
          getDatoActivar: function (id) {
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/ofertaempleopst/encuestaspendientes/'  + id).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            })
            return promise;
        },
    }
}]);
