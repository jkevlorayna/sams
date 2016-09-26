app.factory('svcProduct', function ($rootScope, $http, $q) {
    $this = {
        listByCategory: function (CategoryId,searchText,pageNo,pageSize) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/productByCategory?CategoryId='+CategoryId+'&searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize
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
        },
        list: function (searchText,pageNo,pageSize) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/product?searchText='+searchText+'&pageNo='+pageNo+'&pageSize='+pageSize
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
        },
		  getById: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'GET',
                url: BasePath+'/class/product/'+id
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
        },
		deleteData: function (id) {
            var deferred = $q.defer();
            $http({
                method: 'DELETE',
                url: BasePath+'/class/product/'+id
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
        }
		,save: function (postData) {
            var deferred = $q.defer();
            $http({
                method: 'POST',
                url: BasePath+'/class/product',
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