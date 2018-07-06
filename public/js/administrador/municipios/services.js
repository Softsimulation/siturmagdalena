var app = angular.module('municipiosServices', []);

app.factory('municipiosServi', ['$http', '$q', function ($http, $q){
    return {
        getDatos: function (){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.get('/administrarmunicipios/datos').success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postCrearmunicipio: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarmunicipios/crearmunicipio', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postEditarmunicipio: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarmunicipios/editarmunicipio', data).success(function (data) {
                defered.resolve(data);
            }).error(function (err) {
                defered.reject(err);
            });
            return promise;
        },
        postImportexcel: function (data){
            var defered = $q.defer();
            var promise = defered.promise;

            $http.post('/administrarmunicipios/importexcel', data, {
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