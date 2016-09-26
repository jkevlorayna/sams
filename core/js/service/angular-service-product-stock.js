app.factory('svcProductStock', function ($rootScope, $http, $q) {
    $this = {
        list: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/productStock/'+id
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data;
                $this.count = data.length;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        },save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/productStock',
                data:postData
            }).success(function (data, status) {
                deferred.resolve(data);
                $this.objects = data.Results;
                $this.count = data.Count;
            }).error(function (data, status) {
                $this.objectes = [];
                $this.count = 0;
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
    return $this;
});