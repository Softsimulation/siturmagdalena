var app = angular.module('departamentosServices', []);

app.factory('departamentosServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administrardepartamentos/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCreardepartamento: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrardepartamentos/creardepartamento', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditardepartamento: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrardepartamentos/editardepartamento', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postImportexcel: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrardepartamentos/importexcel', data, {
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
        }
    }
}])